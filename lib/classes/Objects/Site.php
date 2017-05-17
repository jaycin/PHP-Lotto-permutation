<?php

/**
 * Created by PhpStorm.
 * User: Jaycin
 * Date: 2016/10/23
 * Time: 3:14 AM
 */
include_once('Page.php');
class Site extends BaseClass
{
    public $header;
    public $footer;
    public $pageIds;
    public $domain;
    public $cookie;
    public $session;
    public $name;
    public $page;


    public function LoadSite($domain)
    {
        $sql = "SELECT * FROM sites WHERE `domain` = '".$domain."'";
    }


}