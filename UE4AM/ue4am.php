<?php
require "inc/settings.php";
require "inc/log.php";
require "inc/dbhandler.php";
require "inc/accounthandler.php";
require "inc/jsonhandler.php";
require "inc/apphandler.php";
require "inc/ue4am.php";

 /*! \brief UE4AM Entry Point of the Script
 * This is the main entry point where we create UE4AM, and start the whole progress
 * 
 * On Script launch UE4AM inits and processes the command which has been received */  
//$ue4am->InstallCheck();
$ue4am->AuthCMD();

?>