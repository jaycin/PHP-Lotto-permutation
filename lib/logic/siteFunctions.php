<?php

/**
 * Created by PhpStorm.
 * User: Jayci
 * Date: 2016/10/23
 * Time: 4:12 PM
 */
class siteFunctions
{
    /**
     * @param $path path to dir
     * @return returns array of classes
     */
    public function getClassesInDir($path)
    {

    }

    public function generateLottoSQL($db)
    {
        $sql = "CREATE TABLE entries (id INT(17) KEY ,Number1 INT(11),Number2 INT(11),Number3 INT(11),Number4 INT(11),Number5 INT(11),Number6 INT(11) )";
        return $db->query($sql);
    }

    public function getPageData($db,$siteData)
    {
        $sql = "SELECT site.name AS siteName,site.id,site.`domain`,site.header,site.footer,page.name AS pageName,
                page.id AS pageId,module.id AS moduleId,page.body,page.hits,page.metaTag,page.url,module.name as moduleName, module.html,module.css,module.js
                FROM site
        INNER JOIN page ON page.siteId = site.id
        INNER JOIN modulepage ON modulepage.pageId = page.id
        INNER JOIN module ON module.id = modulepage.moduleId
        WHERE site.id = ".$siteData[0]->id;
        return $db->query($sql);
    }

    public function getSiteData($db)
    {
        $sql = "SELECT * FROM site WHERE `domain` =".$db->escapeStr($this->getDomainName());
        //echo($sql."<br>");
        return($db->query($sql,"1"));
    }
    public function getDomainName()
    {
        if(!empty($_SERVER['HTTP_HOST']))
        {
            return $_SERVER['HTTP_HOST'];
        }
        else
        {
            return $_SERVER['SERVER_NAME'];
        }
    }

    public function getPageId()
    {
        //print_r($_REQUEST);die();
    }
    public function getLastEntry($db)
    {
        $sql = "SELECT * FROM entries ORDER BY id DESC LIMIT 1";
        return $db->query($sql,1);
    }

    public function deleteEnries($db)
    {
        $sql = "DELETE FROM entries";
        return $db->query($sql,1);
    }

    public  function getEntryCount($db)
    {

        $sql = "SELECT COUNT(id) FROM entries";
        return $db->query($sql,1);
    }
    public  function generateEntriesTable($db)
    {
        $sql = "CREATE TABLE `entries` (
                 `id` int(17) NOT NULL AUTO_INCREMENT,
                 `Number1` int(11) DEFAULT NULL,
                 `Number2` int(11) DEFAULT NULL,
                 `Number3` int(11) DEFAULT NULL,
                 `Number4` int(11) DEFAULT NULL,
                 `Number5` int(11) DEFAULT NULL,
                 `Number6` int(11) DEFAULT NULL,
                 `Processed` tinyint(1) DEFAULT NULL,
                 PRIMARY KEY (`id`),
                 KEY `Number1` (`Number1`),
                 KEY `Number2` (`Number2`),
                 KEY `Number3` (`Number3`),
                 KEY `Number4` (`Number4`),
                 KEY `Number5` (`Number5`),
                 KEY `Number6` (`Number6`)
                )";
        $db->query($sql,1);
    }

    public function getDistinctEntries($db,$index = 0)
    {
        ini_set('memory_limit', -1);
        $sql = "SELECT * FROM entries ORDER BY id DESC LIMIT $index,1000";
        $numbers = "";
        foreach($db->query($sql,1)as $entry)
        {
            $sql = "SELECT id FROM entries
            WHERE (Number1 = $entry->Number1 OR Number1 = $entry->Number2 OR Number1 = $entry->Number3 OR
             Number1 = $entry->Number4 OR Number1 = $entry->Number5 OR Number1 = $entry->Number6) AND
             (Number2 = $entry->Number1 OR Number2 = $entry->Number2 OR Number2 = $entry->Number3 OR
             Number2 = $entry->Number4 OR Number2 = $entry->Number5 OR Number2 = $entry->Number6) AND
             (Number3 = $entry->Number1 OR Number3 = $entry->Number2 OR Number3 = $entry->Number3 OR
             Number3 = $entry->Number4 OR Number3 = $entry->Number6 OR Number3 = $entry->Number6) AND
             (Number4 = $entry->Number1 OR Number4 = $entry->Number2 OR Number4 = $entry->Number3 OR
             Number4 = $entry->Number4 OR Number4 = $entry->Number5 OR Number4 = $entry->Number6) AND
             (Number5 = $entry->Number1 OR Number5 = $entry->Number2 OR Number5 = $entry->Number3 OR
             Number5 = $entry->Number4 OR Number5 = $entry->Number5 OR Number5 = $entry->Number6) AND
             (Number6 = $entry->Number1 OR Number6 = $entry->Number2 OR Number6 = $entry->Number3 OR
             Number6 = $entry->Number4 OR Number6 = $entry->Number5 OR Number6 = $entry->Number6) AND id <> $entry->id";
            $result = $db->query($sql,1);
            if(!empty($result))
            {
                echo("<pre>");
                print_r($result);
                echo("</pre>");
                echo("<pre>");
                print_r($entry);
                echo("</pre>");
                die();
            }
        }
        echo("Total Entries:".count(array_unique($numbers)));
    }
    function array_unique_by_key (&$array, $key) {
        $tmp = array();
        $result = array();
        foreach ($array as $value) {
            if (!in_array($value[$key], $tmp)) {
                array_push($tmp, $value[$key]);
                array_push($result, $value);
            }
        }
        return $array = $result;
    }
    public function generateLottoNumbersRecursive($db,$size = 6,$numbers = 49)
    {
        $this->getLottoNumbers(array(),0,$size,$numbers,$db);
    }
    public function getLottoNumbers($data,$index,$size,$numbers,$db)
    {

            for($i = 1+$index;$i <=$numbers-$index;$i++)
            {
                if($index != $size-1)
                {

                    $data[] = $i;
                    $this->getLottoNumbers($data,$index,$size,$numbers,$db);
                }
                else
                {
                    $index++;
                    $args = $data;
                    $args[] = $i;
                    $args2 = array_unique($args);
                    if(count($args2)== count($args)) {

                        $sql[] = " INSERT INTO entries (Number1,Number2,Number3,Number4,Number5,Number6)VALUES(".implode(',',$args).")";
                        if(count($sql)> 10000)
                        {
                            echo(implode(',',$args)."\n");
                            $sql =[];
                        }
                    }
                }
            }
    }
    public function generateLottoNumbers($db)
    {
        $index = [];
        $entry = $this->getLastEntry($db);
        if(!$entry)
        {
            $index = [1,2,3,4,5,6];
        }
        else
        {
            $entry = $entry[0];
            if($entry->Number6 != 49-5)
            {
                $entry->Number6++;
            }
            else if($entry->Number5 != 49-4)
            {
                $entry->Number5++;
            }
            else if($entry->Number4 != 49-3)
            {
                $entry->Number4++;
            }
            else if($entry->Number3 != 49-2)
            {
                $entry->Number3++;
            }
            else if($entry->Number2 != 49-1)
            {
                $entry->Number2++;
            }
            else if($entry->Number1 != 49)
            {
                $entry->Number1++;
            }

            $index[] = $entry->Number1;
            $index[] = $entry->Number2;
            $index[] = $entry->Number3;
            $index[] = $entry->Number4;
            $index[] = $entry->Number5;
            $index[] = $entry->Number6;
        }
        error_reporting(0);
        ini_set('max_execution_time', -1);
        $c = 0;
        for($i = $index[0]; $i<=49;$i++)
        {
            for($ii = $index[1]; $ii<=49-1;$ii++)
            {
                for($iii = $index[2]; $iii<=49-2;$iii++)
                {
                    for($iiii = $index[3]; $iiii<=49-3;$iiii++)
                    {
                        for($iiiii = $index[4]; $iiiii<=49-4;$iiiii++)
                        {
                            for($iiiiii = $index[5]; $iiiiii<=49-5;$iiiiii++)
                            {

                                $args = [$i,$ii,$iii,$iiii,$iiiii,$iiiiii];
                                $args2 = array_unique($args);
                                if(count($args2)== count($args)) {

                                    $sql[] = " INSERT INTO entries (Number1,Number2,Number3,Number4,Number5,Number6)VALUES($i,$ii,$iii,$iiii,$iiiii,$iiiiii)";
                                    if(count($sql)> 5000)
                                    {
                                        echo("$i,$ii,$iii,$iiii,$iiiii,$iiiiii \n");
                                        echo('Result:'.$db->query(implode(';',$sql),1,true)."\n");
                                        $sql =[];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $db->query(implode(';',$sql),1,true);
        echo($c." Done<br>");
    }
}