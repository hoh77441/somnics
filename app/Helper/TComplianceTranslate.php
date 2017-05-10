<?php
namespace App\Helper;

use Illuminate\Support\Facades\DB;

use App\Utility\TErrorCode;
use App\Utility\TDateUtility;
use App\Helper\THelper;
use App\Helper\TAppHelper;
use App\Helper\TComplianceChecker;
use App\Helper\TConsoleAssignHelper;

use App\Model\User;
use App\Model\Console;
use App\Model\ComplianceApp;
use App\Model\Questionnaire;
use App\Model\ComplianceConsole;

class TComplianceTranslate extends THelper
{
    public function __construct(TComplianceChecker $checker, TAppHelper $helper)
    {
        parent::__construct();
        
        $this->checker = $checker;
        $this->helper = $helper;
    }
    
    public function translate()
    {
        $this->initHelper();
        
        $checker = TErrorCode::SUCCESS;
        DB::beginTransaction();
        do
        {
            if( ($checker=$this->translateUser()) != TErrorCode::SUCCESS )
            {
                break;
            }
            if( ($checker=$this->translateConsole()) != TErrorCode::SUCCESS )
            {
                break;
            }
            if( ($checker=$this->translateComplianceApp()) != TErrorCode::SUCCESS )
            {
                break;
            }
            if( ($checker=$this->translateQuestionnaire()) != TErrorCode::SUCCESS )
            {
                break;
            }
            if( ($checker=$this->translateRecords()) != TErrorCode::SUCCESS )
            {
                break;
            }                
        } while( false );
        if( $checker != TErrorCode::SUCCESS )
        {
            DB::rollback();
            return $checker;
        }
        
        DB::commit();
        return TErrorCode::SUCCESS;
    }
    
    protected function translateUser()
    {
        $userId = $this->helper->getUserId($this->checker->getJsonUser());
        $email = $this->helper->getEmail($this->checker->getJsonUser());
        $this->user = User::getUserByUserIdAndEmail($userId, $email);
        if( $this->user != null )
        {
            return TErrorCode::SUCCESS;
        }
        
        $password = $this->helper->getPassword($this->checker->getJsonUser());
        $this->user = User::getUserByEmailAndPassword($email, $password);  //for exist user
        if( $this->user != null )
        {
            return TErrorCode::SUCCESS;
        }
        
        $users = User::getUsersByEmail($email);  //for exist user and non signon
        if( $users->count() == 0 )
        {
            $this->lastError = TErrorCode::ERROR_NULL_POINTER;
            $this->why = 'email and id/password not matched';
            return $this->lastError;
        }
        
        $this->user = $users->first();
        return TErrorCode::SUCCESS;
    }
    
    protected function translateConsole()
    {
        $serialNo = $this->helper->getSerialNo($this->checker->getJsonConsole());
        $console = Console::find($serialNo);
        if( $console == null )
        {
            $console = new Console();
            $console->serialNo = $serialNo;
            $console->address = $this->helper->getAddress($this->checker->getJsonConsole());
            $console->model = $this->helper->getModel($this->checker->getJsonConsole());
            if( !$console->save() )
            {
                $this->lastError = TErrorCode::ERROR_DB_SAVE;
                $this->why = 'could not save console';
                return $this->lastError;
            }
        }
        
        $this->isNewAssign = false;
        $this->console = $console;
        $assigner = new TConsoleAssignHelper($this->helper);
        $this->lastError = $assigner->assign($this->user, $this->console, null, true);
        $this->isNewAssign = $assigner->isDoAssign();
        $this->why = $assigner->getWhy(true);  //self::class . ': ';
        return $this->lastError;
    }
    
    protected function translateComplianceApp()
    {
        if( TErrorCode::isWarning($this->findLatestComplianceApp()) )
        {
            $this->currentComplianceApp = $this->latestComplianceApp;
        }
        else 
        {
            return $this->saveCurrentComplianceApp();
        }
    }

    protected function translateQuestionnaire()
    {
        if( $this->duplocate )  //duplication data
        {
            return TErrorCode::SUCCESS;
        }
        
        $question = new Questionnaire();
        //$question->appId = $this->currentComplianceApp->id;
        $question->evening1 = $this->helper->getEvening1($this->checker->getJsonQuestionnaire());
        $question->evening2 = $this->helper->getEvening2($this->checker->getJsonQuestionnaire());
        $question->eveningTime = $this->helper->getEveningTime($this->checker->getJsonQuestionnaire());
        $question->morning1 = $this->helper->getMorning1($this->checker->getJsonQuestionnaire());
        $question->morning2 = $this->helper->getMorning2($this->checker->getJsonQuestionnaire());
        $question->morningTime = $this->helper->getMorningTime($this->checker->getJsonQuestionnaire());
        $question->isReFill = $this->helper->getIsRefill($this->checker->getJsonQuestionnaire());
        //if( !$question->save() )
        if( !$this->currentComplianceApp->questionnaire()->save($question) )
        {
            $this->lastError = TErrorCode::ERROR_DB_SAVE;
            $this->why = 'questionaire save fail';
            return $this->lastError;
        }
        
        $this->questionnaire = $question;
        return TErrorCode::SUCCESS;
    }
    
    protected function translateRecords()
    {
        if( $this->duplocate )  //duplication data
        {
            return TErrorCode::SUCCESS;
        }
        
        if( !TErrorCode::isSuccess($this->processPreviousRecordsInDb()) )
        {
            return $this->lastError;
        }
        if( !TErrorCode::isSuccess($this->processCurrentRecords()) )
        {
            return $this->lastError;
        }
        return TErrorCode::SUCCESS;
    }
    
    protected function findLatestComplianceApp()
    {
        $userId = $this->user->id;
        $serialNo = $this->console->serialNo;
        $record = ComplianceApp::getLatestCompliance($userId);//, $serialNo);
        if( $record != null )
        {
            $startTime = $this->helper->getStartTime($this->checker->getJsonMaster());
            if( $record->start == $startTime )  //the latest record is app's input master information
            {
                $this->lastError = TErrorCode::WARNING_DUPLICATE_DATA;
                $this->why = 'latest compliance app is the same user\'s input';
                return $this->lastError;
            }
        }
        
        $this->latestComplianceApp = $record;
        return TErrorCode::SUCCESS;
    }
    
    protected function saveCurrentComplianceApp()
    {
        $this->duplocate = false;
        
        $record = new ComplianceApp();
        //$record->userId = $this->user->id;
        $record->serialNo = $this->console->serialNo;
        $record->appVersion = $this->helper->getVersion($this->checker->getJsonMaster());
        $record->start = $this->helper->getStartTime($this->checker->getJsonMaster());
        if( ComplianceApp::getCompliance($this->user->id, $record->serialNo, $record->start) != null )  //user maybe sent twice the same data
        {
            $this->duplocate = true;
            return TErrorCode::SUCCESS;
        }
        $record->end = $this->helper->getEndTime($this->checker->getJsonMaster());
        $record->treatment = $this->helper->getTreatment($this->checker->getJsonMaster());
        $record->leakage = $this->helper->getLeakage($this->checker->getJsonMaster());
        $record->timeZone = $this->helper->getTimeZone($this->checker->getJsonMaster());
        $record->latitude = $this->helper->getLatitude($this->checker->getJsonMaster());
        $record->longitude = $this->helper->getLongitude($this->checker->getJsonMaster());
        $record->consoleStart = $this->helper->getConsoleStart($this->checker->getJsonMaster());
        $record->isNewAssign = $this->isNewAssign;
        //$record->archiveDate = TDateUtility::appTimeToArchive($record->start);  //has assigned by set start time
        if( !$this->user->complianceApps()->save($record) )
        {
            $this->lastError = TErrorCode::ERROR_DB_SAVE;
            $this->why = 'compliance app save fail';
            return $this->lastError;
        }
        
        $this->currentComplianceApp = $record;
        return TErrorCode::SUCCESS;
    }
    
    protected function processPreviousRecordsInDb()
    {
        if( $this->latestComplianceApp == null )  //first record
        {
            $this->firstRecord = true;
            return TErrorCode::SUCCESS;
        }
        
        $this->firstRecord = false;
        if( $this->currentComplianceApp == null )  //error handling
        {
            return TErrorCode::SUCCESS;
        }
        
        $serialNo = $this->console->serialNo;
        $lastSerialNo = $this->latestComplianceApp->serialNo;
        if( $serialNo != $lastSerialNo )  //user change the console
        {
            $this->firstRecord = true;
            return TErrorCode::SUCCESS;
        }
        
        $userId = $this->user->id;
        $appId = $this->latestComplianceApp->id;
        do
        {
            $records = ComplianceConsole::getRecords($userId, $serialNo, $appId);  //find out latest non assign compliance records
            if( $records != null )
            {
                break;
            }
            
            $records = ComplianceConsole::getRecords($userId, $serialNo, 0);  //find out the latest is first record
            if( $records != null )
            {
                break;
            }
            
            $records = ComplianceConsole::getNonMatches($userId, $serialNo);
        } while( false );
        if( $records == null )  //no any previous record(s) have to update (match/assign)
        {
            return TErrorCode::SUCCESS;
        }
        
        $c1 = $this->currentComplianceApp->start;
        $c2 = $this->currentComplianceApp->end;
        $l1 = $this->latestComplianceApp->start;
        $l2 = $this->latestComplianceApp->end;
        $start = $l1;
        $end = $l2;
        foreach( $records as $record )
        {
            $record->appId = $appId;  //assign appId
            $r1 = $record->start;
            $r2 = $record->end;
            $record->matchAppTime = TDateUtility::overlapping($record->start, $record->end, $start, $end);
            if( !$record->save() )
            {
                $this->lastError = TErrorCode::ERROR_DB_SAVE;
                $this->why = 'save compliance console fail';
                return $this->lastError;
            }
        }
        
        return TErrorCode::SUCCESS;
    }

    protected function processCurrentRecords()
    {
        $appId = 0;
        $start = null;
        $end = null;
        if( $this->latestComplianceApp != null )
        {
            $appId = $this->latestComplianceApp->id;
            $start = $this->latestComplianceApp->start;
            $end = $this->latestComplianceApp->end;
        }
        if( $this->firstRecord )
        {
            $appId = null;
        }
        
        $treatment = 0;
        $leakage = 0;
        $timeZone = 0;
        $jsonArray = $this->checker->getJsonRecords();
        foreach( $jsonArray as $json )
        {
            if( $start == null || $end == null )
            {
                $overlapping = false;
            }
            else
            {
                $overlapping = TDateUtility::overlapping($this->helper->getStartTime($json), $this->helper->getEndTime($json), $start, $end);
            }
            
            if( !TErrorCode::isSuccess($this->saveJsonToComplianceConsole($appId, $overlapping, $json)) )
            {
                return $this->lastError;
            }
            if( !$overlapping )
            {
                continue;
            }
            
            $treatment += $this->helper->getTreatment($json);
            $leakage += $this->helper->getLeakage($json);
            $timeZone = $this->helper->getTimeZone($json);
        }
        
        return $this->updateLastComplianceRecord($treatment, $leakage, $timeZone);
    }
    
    protected function updateCurrentComplianceApp($treatment, $leakage, $timeZone)
    {
        if( $this->currentComplianceApp->treatment == 0 && 
            $this->currentComplianceApp->leakage == 0 && 
            $this->currentComplianceApp->timeZone == 0 )
        {
            //for legacy bug
            if( $treatment == 0 )
            {
                $start = $this->currentComplianceApp->start;
                $end = $this->currentComplianceApp->end;
                $treatment = TDateUtility::diffInSeconds($start, $end);
            }
            
            $this->currentComplianceApp->treatment = $treatment;
            $this->currentComplianceApp->leakage = $leakage;
            $this->currentComplianceApp->timeZone = $timeZone;
            
            if( !$this->user->complianceApps()->save($this->currentComplianceApp) )
            {
                $this->lastError = TErrorCode::ERROR_DB_SAVE;
                $this->why = 'update compliance app fail';
                return $this->lastError;
            }
        }
        return TErrorCode::SUCCESS;
    }
    
    protected function updateLastComplianceRecord($treatment, $leakage, $timeZone)
    {
        if( $this->latestComplianceApp == null )
        {
            return TErrorCode::SUCCESS;
        }
        
        if( $this->latestComplianceApp->treatment == 0 && 
            $this->latestComplianceApp->leakage == 0 )
        {
            $diff = $treatment;
            if( $treatment == 0 )  //for legacy bug
            {
                $start = $this->latestComplianceApp->start;
                $end = $this->latestComplianceApp->end;
                $diff = TDateUtility::diffInSeconds($start, $end);
            }
            
            $this->latestComplianceApp->treatment = $diff;
            $this->latestComplianceApp->leakage = $leakage;
        }
        
        $this->latestComplianceApp->consoleTreatment = $treatment;
        $this->latestComplianceApp->consoleLeakage = $leakage;
        $this->latestComplianceApp->timeZone = $timeZone;
        if( !$this->user->complianceApps()->save($this->latestComplianceApp) )
        {
            $this->lastError = TErrorCode::ERROR_DB_SAVE;
            $this->why = 'update compliance app fail';
            return $this->lastError;
        }
        return TErrorCode::SUCCESS;
    }

    protected function saveJsonToComplianceConsole($appId, $overlapping, $json)
    {
        $record = new ComplianceConsole();
        $record->userId = $this->user->id;
        $record->serialNo = $this->console->serialNo;
        $record->appId = $appId;  //make current 
        $record->start = $this->helper->getStartTime($json);
        $record->end = $this->helper->getEndTime($json);
        $record->treatment = $this->helper->getTreatment($json);
        $record->leakage = $this->helper->getLeakage($json);
        $record->timeZone = $this->helper->getTimeZone($json);
        $record->matchAppTime = $overlapping;
        $record->appOrConsole = ($record->start == $record->end);  //0: app created, 1: console created
        if( !$record->save() )
        {
            $this->why = 'save compliance console fail';
            $this->lastError = TErrorCode::ERROR_DB_SAVE;
            return $this->lastError;
        }
        return TErrorCode::SUCCESS;
    }
    
    public function getModelUser()
    {
        return $this->user;
    }
    
    public function getModelConsole()
    {
        return $this->console;
    }
    
    public function getModelComplianceApp()
    {
        return $this->currentComplianceApp;
    }
    
    public function getModelQuestionnaire()
    {
        return $this->questionnaire;
    }
    
    public function getModelRecords()
    {
        return $this->records;
    }

    protected $checker;
    protected $helper;
    protected $isNewAssign;

    //model object
    protected $user;
    protected $console;
    protected $latestComplianceApp;
    protected $currentComplianceApp;
    protected $questionnaire;
    
    //utility
    protected $firstRecord;
    protected $duplocate;
}
