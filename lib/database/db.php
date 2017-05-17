<?php
include_once('lib/logic/sqlFunctions.php');
/**
 * Created by PhpStorm.
 * User: Jaycin
 * Date: 2016/10/23
 * Time: 3:14 AM
 */
class Database extends sqlFunctions
{
    private $root;
    private $admin;
    private $site;
    public $level;

    public function connectRoot()
    {
        $this->root = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

        $this->checkAdminDb();
    }
    public function connectSite($sitename,$level)
    {
        $this->connectDb($sitename,DBUSER,DBPASS,ADMINDB,$level);
    }
    public function checkAdminDb()
    {
        $sql = "SHOW DATABASES LIKE '".mysqli_real_escape_string($this->root,ADMINDB)."'";
        $result = $this->query($sql,"0");
       // print_r($result);

        if(empty($result))
        {
            //Create admin db
            echo($this->getAdminDbCreateSql());
            $result = $this->query($this->getAdminDbCreateSql(),0);
        }
        else
        {
            //Switch to site dB
            $this->connectDb(DBHOST,DBUSER,DBPASS,ADMINDB,"0");
        }
    }

    public function escapeStr($str,$level = "0")
    {
        switch ($level)
        {
            case"0":return "'".mysqli_real_escape_string($this->admin,$str)."'";
            break;
            case"1":return "'".mysqli_real_escape_string($this->admin,$str)."'";
            break;
            default: return "'".$str."'";
        }
    }


    /**
     * @param $host
     * @param $user
     * @param $pass
     * @param $db
     * @param string $level 0 for admin 1 for site
     */
    public function connectDb($host,$user,$pass,$db,$level = "0")
    {

        switch ($level)
        {
            case "0":$this->admin = new mysqli($host,$user,$pass,$db);
                break;
            case "1":$this->site = new mysqli($host,$user,$pass,$db);
                break;
        }
    }

    public function query($sql,$level = "2",$multi = false)
    {

        return $this->runQuery($sql,$level,$multi);
    }

    /**
     * @param $sql
     * @param string $level
     * @return array|string
     */
    private function runQuery($sql,$level = "2",$multi = false)
    {

        $result = "";
        $return = "";
        $insertId = 0;
        //Switch data layer level
        //print_r($level);
        switch($level)
        {
            case "0":
                $result = $this->root->query($sql);
                $insertId = $this->root->insert_id;
                if(!empty(mysqli_error($this->root))){
                    echo(mysqli_error($this->root));
                }
                break;
            case "1":
                if(!$multi) {
                    $result = $this->admin->query($sql);
                    $insertId = $this->admin->insert_id;
                    if(!empty(mysqli_error($this->admin))){
                        echo(mysqli_error($this->admin));
                    }
                }
                else
                {
                    $this->admin->multi_query($sql);
                    $insertId = $this->admin->error;
                    do { $this->admin->use_result(); } while( $this->admin->next_result() );
                }
                break;
            case "2":
                $result = $this->site->query($sql);
                $insertId = $this->site->insert_id;
                break;
        }
        //SELECT OR SHOW STATEMENTS
        if(!empty($result)&& strpos(strtolower($sql),"select") !== FALSE || strpos(strtolower($sql),"show")!==FALSE)
        {

            while($row = $result->fetch_object())
            {
                $return[] = $row;
            }
            return $return;
        }

        if(!empty($result)&& strpos(strtolower($sql),"insert") !== FALSE || strpos(strtolower($sql),"insert")!==FALSE)
        {
           return $insertId;

        }

    }
}



?>