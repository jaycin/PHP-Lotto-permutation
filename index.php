<?php

require_once('lib/config.php');
require_once('lib/database/db.php');
require_once('lib/logic/siteFunctions.php');
require_once('lib/classes/Objects/Page.php');
$db = new Database();
$db->connectRoot();
$functions = new siteFunctions();

$siteData =$functions->getSiteData($db);

//new site
if(empty($siteData))
{
    $sql = "INSERT INTO site (`name`,`domain`) VALUES (".$db->escapeStr($functions->getDomainName()).",".$db->escapeStr($functions->getDomainName()).")";
    $siteInsertId = $db->query($sql,'1');
    $siteData =$functions->getSiteData($db);
}

$db->connectSite($siteData[0]->name,"1");
$pageData="";
if(!empty($_REQUEST) || !empty($_POST))
{
    if(!empty($_REQUEST['page']))
    {
        $pageData = $functions->getPageData($db,$siteData);
        if(empty($pageData) && $_REQUEST['level'] == "Admin")
        {
            $sql = "INSERT INTO page (name,siteId) VALUES ('".$_REQUEST['page']."',".$siteData[0]->id.")";
            $pageInsertId = $db->query($sql,'1');
            $sql = "INSERT INTO module (name) VALUES ('jumbotron')";
            $ModuleInsertId = $db->query($sql,'1');
            $sql = "INSERT INTO modulepage (pageId,moduleId) VALUES (".$pageInsertId.",".$ModuleInsertId.")";
            $ModuleInsertId = $db->query($sql,'1');
            $sql = "INSERT INTO module (name) VALUES ('productlist')";
            $ModuleInsertId = $db->query($sql,'1');
            $sql = "INSERT INTO modulepage (pageId,moduleId) VALUES (".$pageInsertId.",".$ModuleInsertId.")";
            $ModuleInsertId = $db->query($sql,'1');
            $pageData = $functions->getPageData($db,$siteData);
        }

        if(!empty($pageData[0]->hits) || !empty($pageData[0]->pageId))
        {
            if(empty($pageData[0]->hits)) { $pageData[0]->hits = 1;}
            $sql = "UPDATE page SET hits = ".($pageData[0]->hits + 1)." WHERE id =".$pageData[0]->pageId;
            $db->query($sql,'1');
        }
    }
}
$page = new Page();
?>
<!DOCTYPE html>
<html lang="en">
<?php

$page->loadHeader();
$page->writeBody();

?>
</html>

