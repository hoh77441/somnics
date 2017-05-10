<?php
namespace App\Model\UI;

use Illuminate\Database\Eloquent\Model;

use App\Model\ComplianceApp;
use App\Model\Questionnaire;
use App\Model\User;

use App\Http\Controllers\TControllerQuestionnaire;

use App\Utility\TMenuUtility;
use App\Utility\TColorUtility;

class IconItem extends Model
{
    const ICON = 'icon';
    const ICON_BACKGROUND = 'icon_background';
    const TITLE = 'title';
    const SUB_TITLE = 'sub_title';
    const SHAPE = 'shape';
    const URL = 'url';
    
    const CIRCLE = 0;
    const TRIANGLE = 1;
    
    public function __construct($icon='', $title='', $subTitle='', $shape=self::CIRCLE, $url='') 
    {
        parent::__construct();
        
        $this->icon = $icon;
        $this->title = $title;
        $this->subTitle = $subTitle;
        $this->shape = $shape;
        $this->url = $url;
    }
    
    public static function getAppStatistics(User $user)
    {
        $statistic = array();
        $statistic[0] = self::getUsageDays($user);  //usage days
        $statistic[1] = self::getUsageTimes($user);
        
        //questionnaire level
        /*for( $level=0; $level < 5; $level++ )  //5: Strongly agree(0) to Strongly disagree(4)
        {
            $statistic[$level+1] = self::getCountOfQuestionnaireLevel($user, $level);
        }//*/
        return $statistic;
    }
    
    public static function getUsageDays(User $user)
    {
        $item = new IconItem();
        $item->icon = TMenuUtility::getIcon('calendar_o');
        $item->iconBackground = TColorUtility::RED;
        $count = ComplianceApp::getUsageDays($user);
        $item->title = sprintf('%d day%s', $count, ($count > 1) ?'s' :'');
        $item->subTitle = 'Total used';
        $item->url = action(TControllerQuestionnaire::ACTION_SHOW_IN_CALENDAR, [TControllerQuestionnaire::PARAMETER_USER => $user->id]);
        
        return $item;
    }
    
    public static function getUsageTimes(User $user)
    {
        $item = new IconItem();
        $item->icon = TMenuUtility::getIcon('clock');
        $item->iconBackground = TColorUtility::BLUE;
        $count = ComplianceApp::getUsageTimes($user);
        $item->title = sprintf('%d piece%s', $count, ($count > 1) ?'s' :'');
        $item->subTitle = 'Questionnaires';
        $item->url = action(TControllerQuestionnaire::ACTION_SHOW_IN_DETAIL, [TControllerQuestionnaire::PARAMETER_USER => $user->id]);
        
        return $item;
    }
    
    public static function getCountOfQuestionnaireLevel(User $user, $level)
    {
        $lang = $user->language;
        
        $item = new IconItem();
        $item->icon = TMenuUtility::getIcon('calendar_o');
        $item->iconBackground = TColorUtility::RED;
        $count = Questionnaire::getCountOfQuestionnaireLevel($user, $level);
        $item->title = sprintf('%d time%s', $count, ($count > 1) ?'s' :'');
        $item->subTitle = QuestionnaireItem::getArrayByLanguage($lang)[$level];
        
        return $item;
    }
    
    public function getIconAttribute()
    {
        return $this->attributes[self::ICON];
        $bg = strtolower($this->iconBackground);
        return sprintf('icon-box bg-color-%s %s', $bg, ($this->shape == self::CIRCLE) ?'set-icon' :'');
    }
    public function setIconAttribute($icon)
    {
        $this->attributes[self::ICON] = $icon;
    }
    
    public function getIconBackgroundAttribute()
    {
        return $this->attributes[self::ICON_BACKGROUND];
    }
    public function setIconBackgroundAttribute($iconBack)
    {
        $this->attributes[self::ICON_BACKGROUND] = $iconBack;
    }
    
    public function getTitleAttribute()
    {
        return $this->attributes[self::TITLE];
    }
    public function setTitleAttribute($title)
    {
        $this->attributes[self::TITLE] = $title;
    }
    
    public function getSubTitleAttribute()
    {
        return $this->attributes[self::SUB_TITLE];
    }
    public function setSubTitleAttribute($subTitle)
    {
        $this->attributes[self::SUB_TITLE] = $subTitle;
    }
    
    public function getShapeAttribute()
    {
        //return $this->attributes[self::SHAPE];
        $bg = strtolower($this->iconBackground);
        return sprintf('icon-box bg-color-%s %s', $bg, ($this->attributes[self::SHAPE] == self::CIRCLE) ?'set-icon' :'');
    }
    public function setShapeAttribute($shape)
    {
        $this->attributes[self::SHAPE] = $shape;
    }
    
    public function getUrlAttribute()
    {
        return $this->attributes[self::URL];
    }
    public function setUrlAttribute($url)
    {
        $this->attributes[self::URL] = $url;
    }
}
