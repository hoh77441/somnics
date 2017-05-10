<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RequestLog extends Model
{
    const TABLE = 'request_logs';
    //columns
    const ID = 'id';
    const FROM = 'from';
    const TASK = 'task';
    const SUB_TASK = 'sub_task';
    const MESSAGE = 'message';
    const RESULT = 'result';
    
    public function getIdAttribute()
    {
        return $this->attributes[self::ID];
    }
    public function setIdAttribute($id)
    {
        $this->attributes[self::ID] = $id;
    }
    
    public function getFromAttribute()
    {
        return $this->attributes[self::FROM];
    }
    public function setFromAttribute($from)
    {
        $this->attributes[self::FROM] = $from;
    }

    public function getTaskAttribute()
    {
        return $this->attributes[self::TASK];
    }
    public function setTaskAttribute($task)
    {
        $this->attributes[self::TASK] = $task;
    }
    
    public function getSubTaskAttribute()
    {
        return $this->attributes[self::SUB_TASK];
    }
    public function setSubTaskAttribute($subTask)
    {
        $this->attributes[self::SUB_TASK] = $subTask;
    }
    
    public function getMessageAttribute()
    {
        return $this->attributes[self::MESSAGE];
    }
    public function setMessageAttribute($message)
    {
        $this->attributes[self::MESSAGE] = $message;
    }
    
    public function getResultAttribute()
    {
        return $this->attributes[self::RESULT];
    }
    public function setResultAttribute($message)
    {
        $this->attributes[self::RESULT] = $message;
    }
}
