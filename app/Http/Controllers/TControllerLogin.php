<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Requests\TRequestLogin;
use App\Model\User;
use App\Utility\TUrlUtility;

class TControllerLogin extends Controller
{
    const URL_ROOT = '/';
    const URL_HOME = '/home';
    const URL_LOGIN = '/login';
    const ACTION_LOGIN = 'TControllerLogin@login';
    const FORM_LOGIN = 'login_form';
    const URL_LOGOUT = '/logout';
    const ACTION_LOGOUT = 'TControllerLogin@logout';
    
    use RedirectsUsers, ThrottlesLogins;
    
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public static function getUser($userId)
    {
        if( $userId == 0 )
        {
            return Auth::user();
        }
        else
        {
            return User::find($userId);
        }
    }
    
    public static function isMe(User $user)
    {
        if( Auth::user()->id == $user->id )
        {
            return true;
        }
        return false;
    }

    public function index()
    {
        return view(TControllerLogin::FORM_LOGIN);
    }
    
    /**
     * Handle a login request to the application.
     *
     * @param  App\Http\Requests\TRequestLogin  $request
     * @return \Illuminate\Http\Response
     */
    public function login(TRequestLogin $request)
    {
        //$this->validateLogin($request);  //has validate by TRequestLogin::rules()

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if( $this->hasTooManyLoginAttempts($request) ) 
        {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if( $this->attemptLogin($request) ) 
        {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
        //return 'Email: ' . $request->email . ', Password: ' . $request->password;
    }
    
    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $message = Lang::get('auth.throttle', ['seconds' => $seconds]);

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([$this->username() => $message]);
    }
    
    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->has('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }
    
    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }
    
    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => Lang::get('auth.failed'),
            ]);
    }
    
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }
    
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return User::EMAIL;  //'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/');
    }
    
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
