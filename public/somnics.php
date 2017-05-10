<?php
function initFramework($callback=null)
{
    if( strncasecmp($_SERVER['REQUEST_METHOD'], 'Post', 4) != 0x00 )
    {
        header("Location: index.php");
        return;
    }

    //initial laravel framework
    require __DIR__.'/../bootstrap/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle($request = Illuminate\Http\Request::capture());  //use Symfony\Component\HttpFoundation\Response;

    if( $callback != null )
    {
        call_user_func($callback);
        $kernel->terminate($request, $response);
        return;
    }
    //change default exception handler
    new App\SomnicsApi\Exception\TExceptionHandler($app);
    $json = transferRequestToJson($request);
    echo (string)executeSomnicsApi($json);
    
    $kernel->terminate($request, $response);
}

/**
 * transfer request to json object by user's input type
 * @param \Illuminate\Http\Request $request
 * @return JSONObject json object
 */
function transferRequestToJson($request)
{
    if( $request->getContent() )  //if is resource(eg. json, mysql connection, ...)
    {
        return new App\Utility\JSONObject($request->json());
    }
    else
    {
        $jsonArray = json_decode($request->request->get('param'), true);
        return new App\Utility\JSONObject($jsonArray);
    }
}

/**
 * execute the request for somnics protocol
 * @param JSONObject $json
 * @return JSONObject
 */
function executeSomnicsApi($json)
{
    \Log::info((string)$json);
    $task = $json->get(App\SomnicsApi\ITask::TASK);
    if( isset($task) )
    {
        $class = sprintf('App\\SomnicsApi\\%s', $task);
        $filename = sprintf('../app/SomnicsApi/%s.php', $task);
        if( file_exists($filename) )
        {
            $result = generateReport(new $class(), $json);
        }
        else
        {
            $result = App\Utility\JSONObject::makeReport(App\Utility\TErrorCode::ERROR_FILE_NOT_EXIST, $filename);
        }
    }
    else 
    {
        $result = App\Utility\JSONObject::makeReport(App\Utility\TErrorCode::ERROR_NULL_POINTER, 'no task');
    }
    
    logToDb($task, $json, $result);
    return $result;
}

/**
 * generate report to client
 * @param App\SomnicsApi\ITask $somnics
 * @param JSONObject $json
 * @return JSONObject result of execution
 */
function generateReport($somnics, $json)
{
    if( $somnics instanceof App\SomnicsApi\ITask )
    {
        return $somnics->report($json);
    }
    else
    {
        $task = $json->get(App\SomnicsApi\ITask::TASK);
        return App\Utility\JSONObject::makeReport(App\Utility\TErrorCode::ERROR_NOT_TASK, $task);
    }
}

function logToDb($task, $json, $result)
{
    if( App\Utility\TConstant::isLogRequest() )
    {
        $log = new App\Model\RequestLog();
        $log->from = request()->ip();
        $log->task = $task;
        $log->subTask = $json->get(App\SomnicsApi\ITask::SUB_TASK);
        $log->message = (string)$json;
        $log->result = (string)$result;
        $log->save();

        \Log::info('Receive: '.$task.', Response: '.(string)$result);
    }
}

initFramework();
