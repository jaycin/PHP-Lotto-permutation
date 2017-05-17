<?php

require_once('lib/config.php');
require_once('lib/database/db.php');
require_once('lib/logic/siteFunctions.php');
require_once('lib/classes/Objects/Page.php');
$db = new Database();
$db->connectRoot();
$functions = new siteFunctions();
//$functions->generateLottoNumbersRecursive($db);
$functions->generateLottoNumbers($db);
