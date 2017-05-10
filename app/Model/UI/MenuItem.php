<?php
namespace App\Model\UI;

use Illuminate\Database\Eloquent\Model;

use App\Utility\TMenuUtility;
use App\Utility\TUrlUtility;

use App\Model\User;
use App\Model\Role;

use App\Http\Controllers\TControllerQuestionnaire;
use App\Http\Controllers\TControllerDashboard;

class MenuItem extends Model
{
    const TITLE = 'title';
    const URL = 'url';
    const ICON = 'icon';
    const SUB_MENU = 'sub_menu';
    
    //for index of menu item
    const INDEX_DASHBOARD_USER = 0;
    const INDEX_QUESTIONNAIRE_CALENDAR = 0;
    const INDEX_QUESTIONNAIRE_DETAIL = 1;
    
    public function __construct($title='', $url='', $icon='') 
    {
        parent::__construct();
        
        $this->title = $title;
        $this->url = $url;
        $this->icon = $icon;
    }
    
    public static function getMenuItemsByUser(User $user)
    {
        $menuItems = array();
        
        /*$dashboard = new MenuItem('Dashboard', TControllerDashboard::SHOW_DASHBOARD,  TMenuUtility::getIcon('dashboard', 3));
        $dashboard->subMenu = null;
        $menuItems[self::INDEX_DASHBOARD_USER] = $dashboard;//*/
        
        $calendar = new MenuItem('Calendar', TControllerQuestionnaire::ACTION_SHOW_IN_CALENDAR,  TMenuUtility::getIcon('calendar', 3));
        $calendar->subMenu = self::getCareItemsByUser($user, TControllerQuestionnaire::ACTION_SHOW_IN_CALENDAR);
        $menuItems[self::INDEX_QUESTIONNAIRE_CALENDAR] = $calendar;
        
        $detail = new MenuItem('Usage Report', TControllerQuestionnaire::ACTION_SHOW_IN_DETAIL, TMenuUtility::getIcon('clock', 3));
        $detail->subMenu = self::getCareItemsByUser($user, TControllerQuestionnaire::ACTION_SHOW_IN_DETAIL);
        $menuItems[self::INDEX_QUESTIONNAIRE_DETAIL] = $detail;
        
        return $menuItems;
    }
    
    public static function getCareItemsByUser(User $user, $url)
    {
        $cares = $user->cares;
        if( $cares->count() == 0 )
        {
            return null;
        }
        
        $menuItems = array();
        /*if( Role::isPatient($user) )
        {
            $item = new MenuItem();
            $item->title = $user->name . '(self)';
            $item->url = action($url, [TControllerQuestionnaire::PARAMETER_USER => $user->id]);
            $item->icon = TMenuUtility::getIcon('home', 1);
            array_push($menuItems, $item);
        }//*/
        
        /*foreach( $cares as $care )
        {
            $item = new MenuItem();
            $userId = $care->watcher->id;
            $item->title = $care->watcher->name;
            $item->url = action($url, [TControllerQuestionnaire::PARAMETER_USER => $userId]);
            $item->icon = TMenuUtility::getIcon('user', 1);
            array_push($menuItems, $item);
        }//*/
        foreach( $cares as $care )
        {
            $item = new MenuItem();
            $userId = $care->id;
            $item->title = $care->email;  //$care->name;
            $item->url = action($url, [TControllerQuestionnaire::PARAMETER_USER => $userId]);
            $item->icon = TMenuUtility::getIcon('user', 1);
            if( $care->isMe )
            {
                $item->icon = TMenuUtility::getIcon('bookmark', 1);
            }
            
            array_push($menuItems, $item);
        }
        return $menuItems;
    }

    public function getTitleAttribute()
    {
        return $this->attributes[self::TITLE];
    }
    public function setTitleAttribute($title)
    {
        $this->attributes[self::TITLE] = $title;
    }
    
    public function getUrlAttribute()
    {
        return $this->attributes[self::URL];
    }
    public function setUrlAttribute($url)
    {
        $this->attributes[self::URL] = $url;
    }
    
    public function getIconAttribute()
    {
        return $this->attributes[self::ICON];
    }
    public function setIconAttribute($icon)
    {
        $this->attributes[self::ICON] = $icon;
    }
    
    public function getSubMenuAttribute()
    {
        return $this->attributes[self::SUB_MENU];
    }
    public function setSubMenuAttribute($subMenu)
    {
        $this->attributes[self::SUB_MENU] = $subMenu;
    }
}
