<?php
namespace App\Model\UI;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

use App\Utility\TColorUtility;
use App\Utility\TDateUtility;
use App\Utility\TStringUtility;

use App\Model\User;
use App\Model\UserProfile;
use App\Model\Questionnaire;
use App\Model\Console;

class QuestionnaireItem extends Model
{
    const DATE = 'start';  //reference fullcalendar
    const TITLE = 'title';
    const COLOR = 'color';
    const COUNT = 'count';
    
    //for questionnaire level
    const EN_LEVEL = array(
        'Strongly disagree', 'Disagree', 'Neutral', 'Agree', 'Strongly agree'
    );
    const DE_LEVEL = array(
        'Stimme eher nicht zu', 'Stimme nicht zu', 'Neutral', 'Stimme zu', 'Stimme eher zu'
    );
    const LEVEL_0 = 0;  //Strongly disagree
    const LEVEL_1 = 1;  //Disagree
    const LEVEL_2 = 2;  //Neutral
    const LEVEL_3 = 3;  //Agree
    const LEVEL_4 = 4;  //Strongly agree
    
    /**
     * get the user's questionnaire(s)
     * @param User $user
     * @param bool $aggregation true: merge the same archive date, false: return all questionnaires
     * @return array: key is archive date, value is questionnaire with tag(count)
     */
    public static function getQuestionnaires(User $user, $aggregation=true)
    {
        if( $aggregation )
        {
            return self::aggregationQuestionnaires($user);
        }
        else 
        {
            return self::allQuestionnaires($user);
        }
    }
    
    /**
     * get user's questionnaire at the specific date
     * @param User $user
     * @param type $date
     */
    public static function getQuestionnairesByDate(User $user, $date)
    {
        $dateTime = TDateUtility::from($date);
        if( $dateTime == null )
        {
            return null;
        }
        
        $apps = $user->complianceAppsByData(TStringUtility::toMySql($dateTime));
        if( $apps->count() == 0 )
        {
            return null;
        }
        
        $questionnaires = array();
        $index = 0 ;
        foreach( $apps as $app )
        {
            $questionnaires[$index++] = $app->questionnaire;
        }
        return $questionnaires;
    }

    /**
     * create events for calendar view by questionnaire
     * @param string $date
     * @param string $language
     * @param Questionnaire $questionnaire
     * @param Console $console
     * @return array QuestionnaireItem
     */
    public static function makeCalendarEvent($date, $language, Questionnaire $questionnaire)
    {
        $items = array();
        //process answers of questionnaire
        array_push($items, self::createCalendarEventByAnswerLevel($date, $language, 1, $questionnaire->evening1));
        array_push($items, self::createCalendarEventByAnswerLevel($date, $language, 2, $questionnaire->evening2));
        array_push($items, self::createCalendarEventByAnswerLevel($date, $language, 3, $questionnaire->morning1));
        array_push($items, self::createCalendarEventByAnswerLevel($date, $language, 4, $questionnaire->morning2));
        
        //process console info of questionnaire
        array_push($items, self::createCalendarEventByConsoleInfo($date, $language, $questionnaire));
        
        return $items;
    }
    
    public static function makeReportDetail($nighNo, $language, Questionnaire $questionnaire, $changeConsole=false)
    {
        $treatment = $questionnaire->complianceApp->consoleTreatment;
        $sealing = $treatment - $questionnaire->complianceApp->consoleLeakage;
        if( $treatment == 0 )
        {
            $strSeal = self::transferTime($sealing);
        }
        else
        {
            $strSeal = TStringUtility::toTime($sealing);
        }
        
        return array(
            'night_no' => sprintf('Night %04d', $nighNo+1), 
            'serial_no' => $questionnaire->complianceApp->serialNo,
            'change_console' => $changeConsole,
            'app_start' => $questionnaire->complianceApp->start,
            'app_end' => $questionnaire->complianceApp->end,
            'evening1' => self::getArrayByLanguage($language)[$questionnaire->evening1],
            'evening2' => self::getArrayByLanguage($language)[$questionnaire->evening2],
            'morning1' => self::getArrayByLanguage($language)[$questionnaire->morning1],
            'morning2' => self::getArrayByLanguage($language)[$questionnaire->morning2],
            'treatment' => self::transferTime($treatment),
            'sealing' => $strSeal);
    }

    private static function aggregationQuestionnaires(User $user)
    {
        $items = array();
        $archiveDate = Carbon::create(2000, 1, 1, 0, 0, 0);
        $key = '';
        foreach($user->complianceApps as $app)
        {
            $dateTime = TDateUtility::from($app->archiveDate);
            if( $archiveDate->ne($dateTime) )  //different archive date
            {
                $key = $app->archiveDate;
                $archiveDate = $dateTime;
                $questionnaire = $app->questionnaire;
                if( $questionnaire == null )
                {
                    continue;
                }
                //for ui display
                $questionnaire->count = 1;
                $questionnaire->serialNo = $app->console->serialNo;
                $items[$key] = $questionnaire;
                continue;
            }
            
            $items[$key]->count = $items[$key]->count + 1;  //the same archive date
        }
        
        return $items;
    }
    
    private static function allQuestionnaires(User $user)
    {
        $items = array();
        $index = 0;
        foreach($user->complianceApps as $app)
        {
            $items[$index++] = $app->questionnaire;
        }
        return $items;
    }
    
    public static function createCalendarEventByAnswerLevel($date, $language, $index, $level)
    {
        $item = new QuestionnaireItem();
        $item->date = $date;
        $item->title = sprintf('%d. %s', $index, self::getArrayByLanguage($language)[$level]); //. self::getArrayByLanguage($language)[$questionnaire->evening1];
        $item->color = self::getColorByLevel($level);
        
        return $item;
    }
    
    private static function createCalendarEventByConsoleInfo($date, $language, $questionnaire)
    {
        $sn = new QuestionnaireItem();
        $sn->date = $date;
        $sn->title = 'SN: ' .   $questionnaire->complianceApp->serialNo;
        $sn->color = TColorUtility::GREEN;
        if( $questionnaire->count > 1 )
        {
            $sn->title .= sprintf('(%02d)', $questionnaire->count);
            $sn->color = TColorUtility::RED;
        }
        return $sn;
    }

    public static function getArrayByLanguage($language)
    {
        if( strtoupper($language) == UserProfile::LANGUAGE_DE )
        {
            return self::DE_LEVEL;
        }
        return self::EN_LEVEL;
    }
    
    private static function getColorByLevel($level)
    {
        switch($level)
        {
            case self::LEVEL_0:
            case self::LEVEL_1:
            case self::LEVEL_2:
            case self::LEVEL_3:
            case self::LEVEL_4:
            return TColorUtility::DEEP_SKY_BLUE;
        }
        return TColorUtility::DEEP_SKY_BLUE;
    }
    
    private static function transferTime($seconds)
    {
        if( $seconds == 0 )
        {
            return "no data";
        }
        return TStringUtility::toTime($seconds);
    }

    public function getDateAttribute()
    {
        return $this->attributes[self::DATE];
    }
    public function setDateAttribute($date)
    {
        $this->attributes[self::DATE] = $date;
    }
    
    public function getTitleAttribute()
    {
        return $this->attributes[self::TITLE];
    }
    public function setTitleAttribute($title)
    {
        $this->attributes[self::TITLE] = $title;
    }
    
    public function getColorAttribute()
    {
        return $this->attributes[self::COLOR];
    }
    public function setColorAttribute($color)
    {
        $this->attributes[self::COLOR] = $color;
    }
    
    public function getCountAttribute()
    {
        return $this->attributes[self::COUNT];
    }
    public function setCountAttribute($count)
    {
        $this->attributes[self::COUNT] = $count;
    }
}