<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Utility\TConstant;

class FileWaitForParse extends Model
{
    const TABLE = 'file_wait_for_parses';
    //columns
    const ID = 'id';
    const FILE_NAME = 'filename';
    const SERIAL_NO = 'serial_no';
    const USER_NAME = 'username';
    const DONE = 'done';
    
    protected $connection = TConstant::FILE_CONNECTION;
    
    public function getIdAttribute()
    {
        return $this->attributes[self::ID];
    }
    public function setIdAttribute($id)
    {
        $this->attributes[self::ID] = $id;
    }
    
    public function getFilenameAttribute()
    {
        return $this->attributes[self::FILE_NAME];
    }
    public function setFilenameAttribute($filename)
    {
        $this->attributes[self::FILE_NAME] = $filename;
    }
    
    public function getSerialNoAttribute()
    {
        return $this->attributes[self::SERIAL_NO];
    }
    public function setSerialNoAttribute($serialNo)
    {
        $this->attributes[self::SERIAL_NO] = $serialNo;
    }
    
    public function getUsernameAttribute()
    {
        return $this->attributes[self::USER_NAME];
    }
    public function setUsernameAttribute($username)
    {
        $this->attributes[self::USER_NAME] = $username;
    }
    
    public function getDoneAttribute()
    {
        return $this->attributes[self::DONE];
    }
    public function setDoneAttribute($done)
    {
        $this->attributes[self::DONE] = $done;
    }
}
