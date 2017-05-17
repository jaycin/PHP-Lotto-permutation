<?php
/**
 * Created by PhpStorm.
 * User: Jayci
 * Date: 2016/10/23
 * Time: 4:44 AM
 */
class Output
{
    static function pre($val)
    {
        echo"<pre>";
        print_r($val);
        echo"</pre>";
    }
}