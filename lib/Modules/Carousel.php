<?php
/**
 * Created by PhpStorm.
 * User: Jaycin
 * Date: 2017/02/11
 * Time: 11:14 PM
 * Carousel module
 */
include_once('lib/classes/Objects/Module.php');

class Carousel extends Module{
    public $jsFiles;
    public $cssFiles;
    public $images;
    public $content;
    public $settings;


    public function Carousel($context,$moduleId)
    {
        parent::Module($context,$moduleId);
        $ModuleData = parent::GetModuleData();
        $this->jsFiles = $ModuleData['jsFiles'];
        $this->cssFiles = $ModuleData['cssFiles'];
        $this->images = $ModuleData['images'];
        $this->content = $ModuleData['content'];
        $this->settings = $ModuleData['settings'];
    }

    public function GenerateModuleData()
    {
        $ModuleData['jsFiles'] = $this->jsFiles;
        $ModuleData['cssFiles'] = $this->cssFiles;
        $ModuleData['images'] = $this->images;
        $ModuleData['content'] = $this->content;
        $ModuleData['settings'] = $this->settings;
        return $ModuleData;
    }

    public function style($loadedScripts)
    {
        $returnString = '';
        foreach ($this->cssFiles as $v) {
            if (!in_array($v, $loadedScripts)) {
                $returnString .='<link href="'.$v.'" rel="stylesheet">';
            }
        }
        return $returnString;
    }

    public function scripts($loadedScripts)
    {
        $returnString = '';
        foreach ($this->jsFiles as $v) {
            if (!in_array($v, $loadedScripts)) {
                $returnString .='<script src="'.$v.'" ></script>';
            }
        }
        return $returnString;
    }

    public function layOut()
    {
        $returnSting = '
                    <!-- Main jumbotron for a primary marketing message or call to action -->
                        <div class="jumbotron">
                            <div id="myCarousel" class="carousel slide" data-ride="carousel">';
        $returnSting .= '<ol class="carousel-indicators">';
        for($i = 0 ;$i <count($this->images);$i++)
        {
            if($i == 0) {
                $returnSting .= '<li data-target="#myCarousel" data-slide-to="'.$i.'" class="active"></li>';
            }
            else {
                $returnSting .= '<li data-target="#myCarousel" data-slide-to="' . $i . '"></li>';
            }
        }
        $returnSting .= '</ol>';
        $returnSting .= '
                        <!-- Indicators -->
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">';
        foreach($this->images as $k=>$img) {
            if($k == 0) {
                $returnSting .= '<div class="item active">';
            }
            else
            {
                $returnSting .= '<div class="item">';
            }
            $returnSting .= '<img src="'.$img.'" alt="'.$this->content[$k]->heading.'"/>
                                  <div class="carousel-caption">
                                    <h3>'.$this->content[$k]->heading.'</h3>
                                    <p>'.$this->content[$k]->body.'</p>
                                  </div>
                                </div>';
        }
        $returnSting .= '<!-- Left and right controls -->
                              <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                              </a>
                              <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                              </a>';
        $returnSting .= '</div>
                            </div>';
        return $returnSting;
    }

    public function Async($post,$db)
    {
        if(!empty($post['content']))
        {
            $this->content = $post['content'];
        }
        if(!empty($post['images']))
        {
            $this->images = $post['images'];
        }
        if(!empty($post['css']))
        {
            $this->settings = $post['settings'];
        }
        $moduleData = $this->GenerateModuleData();
        parent::SetModuleData($moduleData);
        parent::Update($db);
    }

}