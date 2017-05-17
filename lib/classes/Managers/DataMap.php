<?php

/**
 * Created by PhpStorm.
 * User: Jaycin
 * Date: 2016/10/23
 * Time: 4:21 PM
 */
include_once ('lib/classes/Objects/BaseClass.php');
include_once ('lib/classes/Objects/Page.php');
include_once ('lib/classes/Objects/Site.php');
class DataMap
{
    private $tables;

    public function getTables()
    {
        $this->tables["Site"] =
            array("fields"=>
                array("id"=>array("INT(11)","PRIMARY KEY","AUTO_INCREMENT"),
                    "name"=>array("VARCHAR(255)"),
                    "domain"=>array("VARCHAR(255)"),
                    "header"=>array("LONGTEXT"),
                    "footer"=>array("LONGTEXT")),
                    "Relationships"=>array("Page"=>"RELATIONSHIP FK"));
        $this->tables["Page"] =
            array("fields"=>
                array("id"=>array("INT(11)","PRIMARY KEY","AUTO_INCREMENT"),
                    "siteId"=>array("INT(11)","KEY"),
                    "url"=>array("VARCHAR(255)"),
                    "hits"=>array("INT"),
                    "metaTag"=>array("VARCHAR(255)"),
                    "body"=>array("LONGTEXT"),
                    "name"=>array("VARCHAR(255)")),
                    "Relationships"=>array("Module"=>"RELATIONSHIP FK"));
        $this->tables["Module"] =
            array("fields"=>
                array("id"=>array("INT(11)","PRIMARY KEY" , "AUTO_INCREMENT"),
                    "js"=>array("LONGTEXT"),
                    "html"=>array("LONGTEXT"),
                    "css"=>array("LONGTEXT"),
                    "moduleData"=>array("LONGTEXT"),
                    "name"=>array("VARCHAR(255)")));


        return $this->tables;
    }

}