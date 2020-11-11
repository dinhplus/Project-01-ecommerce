<?php
define('WEBROOT', str_replace("server.php", "", $_SERVER["SCRIPT_NAME"]));
define('ROOT', str_replace("WEBROOT".WEBROOT, "", $_SERVER["SCRIPT_FILENAME"]));


require_once(ROOT."/request.php");
require_once(ROOT."Config/Core.php");


?>