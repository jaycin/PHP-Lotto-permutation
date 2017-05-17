<?php
include_once('siteFunctions.php');
include_once ('lib/classes/Managers/DataMap.php');
/**
 * Created by PhpStorm.
 * User: Jayci
 * Date: 2016/10/23
 * Time: 4:49 AM
 */
class sqlFunctions extends siteFunctions
{
    public static function getAdminDbCreateSql()
    {

        $sql = array();
        $data =  new DataMap();
        $data =  $data->getTables();
        $db = ADMINDB;
        $sql[] = "CREATE DATABASE $db; ";/*"USE $db";
        foreach ($data as $tableName => $tableData) {
            $baseSql = "CREATE TABLE " . $tableName . " (";
            $colSql = array();
            foreach ($tableData['fields'] as $name => $properties) {
                $tempSql = " " . $name . " ";
                foreach ($properties as $type) {
                    $tempSql .= " " . $type;
                }
                $colSql[] = $tempSql;
            }
            $baseSql .= implode(',',$colSql).")";
            $sql[] = $baseSql;
        }
        */

        return implode(';',$sql);
    }

    public function generateObjectsSql()
    {

    }
}