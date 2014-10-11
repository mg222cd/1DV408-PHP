<?php
namespace Helper;

class ServiceHelper{

    /**
    * Returns  the User-Agent: header from the current request
    *
    * @return string
    */
    public function getUserAgent(){
        return $_SERVER['HTTP_USER_AGENT'];
    }
}