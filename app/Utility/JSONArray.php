<?php
namespace App\Utility;

use App\Utility\JSONObject;

//URL: http://php.net/manual/en/function.usort.php
//URL: http://stackoverflow.com/questions/4282413/sort-array-of-objects-by-object-fields
function build_sorter($key) {
    return function ($a, $b) use ($key) {
        if( !array_key_exists($key, $a) || !array_key_exists($key, $b) )
        {
            return 0;
        }
        return strnatcmp($a[$key], $b[$key]);
    };
}

class JSONArray implements \Iterator, \Countable
{
    public function __construct($jsons=array())
    {
        $this->jsons = $jsons;
        $this->position = 0;
    }

    public function current() 
    {
        return new JSONObject($this->jsons[$this->position]);
    }

    public function key()
    {
        return $this->position;
    }

    public function next() 
    {
        ++$this->position;
    }

    public function rewind() 
    {
        $this->position = 0;
    }

    public function valid() 
    {
        return isset($this->jsons[$this->position]);
    }
    
    public function count()
    {
        return count($this->jsons);
    }
    
    public function sort($columnName=null)
    {
        if( count($this->jsons) <= 1 )  //too less record to sort
        {
            return;
        }
        
        usort($this->jsons, build_sorter($columnName));
    }
    
    public function __toString() 
    {
        return json_encode($this->jsons);
    }
    
    protected $jsons;
    protected $position;
}
