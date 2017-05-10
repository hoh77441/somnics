<?php
namespace App\Helper;

use App\Utility\TDateUtility;
use App\Utility\TStringUtility;
use App\Utility\TErrorCode;

use App\Model\User;
use App\Model\Console;
use App\Model\UserHasConsole;

class TConsoleAssignHelper extends THelper
{
    public function __construct(TAppHelper $helper) 
    {
        parent::__construct();
        
        $this->helper = $helper;
        if( $helper == null )
        {
            $this->helper = new TAppHelper();
        }
    }
    
    /**
     * 
     * @param User $user
     * @param Console $console
     * @param string $time null will use current time
     * @param bool $addRelationIfNotExist 
     * @return error code
     */
    public function assign(User $user, Console $console, $time=null, $addRelationIfNotExist=false)
    {
        $this->initHelper();
        $this->doAssign = false;
        
        if( $user->consoles->contains($console) )
        {
            return TErrorCode::SUCCESS;
        }
        
        if( !$addRelationIfNotExist )
        {
            $this->lastError = TErrorCode::NOT_FOUND;
            $this->why = sprintf('user: \'%s\' and console: \'%s\' was not been assigned', $user->email, $console->serialNo);
            return null;
        }
        
        if( TStringUtility::isEmpty($time) )
        {
            $time = TStringUtility::now();
        }
        if( !$user->consoles()->save($console, [UserHasConsole::APP_TIME => $time]) )
        {
            $this->lastError = TErrorCode::ERROR_DB_SAVE;
            $this->why = sprintf('user: \'%s\' and console: \'%s\' could not been assigned', $user->email, $console->serialNo);
            return TErrorCode::ERROR_DB_SAVE;
        }
        $this->doAssign = true;
        return TErrorCode::SUCCESS;
    }
    
    public function isDoAssign()
    {
        return $this->doAssign;
    }

    protected $helper;
    protected $doAssign;
}
