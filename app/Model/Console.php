<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Utility\TStringUtility;

//URL: https://laravel.com/docs/5.3/eloquent
class Console extends Model
{
    const TABLE = 'consoles';
    //columns
    const SERIAL_NO = 'serial_no';
    const ADDRESS = 'address';
    const MODEL = 'model';
    
    //for column of model 
    protected $primaryKey = self::SERIAL_NO;
    protected $keyType = 'string';
    public $incrementing = false;
    
    //relation
    public function users()
    {
        return $this->belongsToMany(User::class, 
            UserHasConsole::TABLE, 
            UserHasConsole::SERIAL_NO, UserHasConsole::USER_ID)->withTimestamps();;
    }
    
    //column getter and setter
    public function getSerialNoAttribute()
    {
        return $this->attributes[self::SERIAL_NO];
    }
    public function setSerialNoAttribute($serialNo)
    {
        $this->attributes[self::SERIAL_NO] = $serialNo;
    }
    
    public function getAddressAttribute()
    {
        return $this->attributes[self::ADDRESS];
    }
    public function setAddressAttribute($address)
    {
        $this->attributes[self::ADDRESS] = $address;
    }
    
    public function getModelAttribute()
    {
        if( array_key_exists(self::MODEL, $this->attributes) )
        {
            return $this->attributes[self::MODEL];
        }
        if( TStringUtility::isEmpty($this->serialNo) )
        {
            return '';
        }
        return substr($this->serialNo, 0, 3);
    }
    public function setModelAttribute($model)
    {
        $this->attributes[self::MODEL] = $model;
    }
}
