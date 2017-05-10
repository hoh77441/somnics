<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Utility\TArrayUtility;
use App\Utility\TStringUtility;

class UserProfile extends Model
{
    const TABLE = 'user_profiles';
    //columns
    const USER_ID = 'user_id';
    const KEY = '_key';
    const VALUE = '_value';
    
    //for key value
    const QUESTIONNAIRE_COUNT_IN_PAGE = 'questionnaire_count_in_page';
    const LANGUAGE = 'language';
    const THEME = 'theme';
    const PRIVILEGE = 'privilege';
    //for default value
    const DEFAULT_QUESTIONNAIRE_COUNT = '30';
    const DEFAULT_LANGUAGE = 'EN';
    const DEFAULT_THEME = 'DEFAULT';
    //for language
    const LANGUAGE_EN = 'EN';
    const LANGUAGE_DE = 'DE';
    
    //for column of model 
    protected $primaryKey = self::USER_ID;
    protected $keyType = 'int';
    public $incrementing = false;
    
    //relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    //utility
    public static function profile($user, $key, $default)
    {
        $profiles = UserProfile::where([
            [self::USER_ID, '=', $user->id],
            [self::KEY, '=', $key]
        ])->get();
        
        if( $profiles->count() == 0 )
        {
            return $default;
        }
        return $profiles->first();
    }
    
    public function setProfile($key, $value)
    {
        $this->attributes[self::KEY] = $key;
        $this->attributes[self::VALUE] = $value;
    }
    
    //column getter and setter
    public function getUserIdAttribute()
    {
        return $this->attributes[self::USER_ID];
    }
    public function setUserIdAttribute($id)
    {
        $this->attributes[self::USER_ID] = $id;
    }
    
    public function getKeyAttribute()
    {
        return $this->attributes[self::KEY];
    }
    public function setKeyAttribute($key)
    {
        $this->attributes[self::KEY] = $key;
    }
    
    public function getValueAttribute()
    {
        return $this->attributes[self::VALUE];
    }
    public function setValueAttribute($value)
    {
        $this->attributes[self::VALUE] = $value;
    }
    
    //helper function for column
    public function getQuestionnaireCountInPageAttribute()
    {
        $value = $this->getKeyValue(self::QUESTIONNAIRE_COUNT_IN_PAGE, self::DEFAULT_QUESTIONNAIRE_COUNT);
        return intval($value);
    }
    public function setQuestionnaireCountInPageAttribute($count)
    {
        $this->key = self::QUESTIONNAIRE_COUNT_IN_PAGE;
        $this->value = $count;
    }
    
    public function getLanguageAttribute()
    {
        return $this->getKeyValue(self::LANGUAGE, self::DEFAULT_LANGUAGE);
    }
    public function setLanguageAttribute($language)
    {
        $this->key = self::LANGUAGE;
        $this->value = $language;
    }
    
    public function getThemeAttribute()
    {
        return $this->getKeyValue(self::THEME, self::DEFAULT_THEME);
    }
    public function setThemeAttribute($theme)
    {
        $this->key = self::THEME;
        $this->value = $theme;
    }
    
    public function getKeyValue($key, $default=null)
    {
        $pros = UserProfile::where([[self::USER_ID, $this->userId], [self::KEY, $key]])->get();
        if( $pros->count() != 0 )
        {
            $value = $pros->first()->value;
            if( !TStringUtility::isEmpty($value) )
            {
                return $value;
            }
        }
        return $default;
    }
}
