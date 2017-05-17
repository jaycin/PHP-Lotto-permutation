<?php
include_once('BaseClass.php');
/**
 * Created by PhpStorm.
 * User: Jayci
 * Date: 2016/10/23
 * Time: 4:26 PM
 */
class Module extends BaseClass
{
        public $css;
        public $js;
        public $html;
        public $id;
        public $moduleData;

        public function Module($context,$id)
        {
            $data = $context->query("SELECT * FROM module WHERE id = $id");
            $this->css = $data[0]->css;
            $this->html = $data[0]->html;
            $this->id = $data[0]->id;
            $this->js = $data[0]->js;
            $this->moduleData = $data[0]->moduleData;
        }

        public function GetModuleData()
        {
            return json_decode($this->moduleData);
        }

        public function SetModuleData($moduleData)
        {
            $this->moduleData = json_encode($moduleData);
        }

        public function Update($db)
        {
            $sql = "Update module SET css ='$this->css'
                    ,js = '$this->js' html = '$this->html'
                    ,moduleData = '$this->moduleData'
                    WHERE id = $this->moduleId";
            return $db->query($sql);
        }


}