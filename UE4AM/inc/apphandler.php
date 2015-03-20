<?php

/*! \brief The App Handler is for managing multiple apps and autorisations on the same server
*/
class UE4AM_AppHandler
{

	function AddApp($token)
	{
	global $database;
	global $prefix;
	$database->InsertData($prefix."mytable","col1,col2,col3","var1,var2,var3");
	
	}
	
	function Auth($appid, $token)
	{
	
	}
	
	function RemoveApp($appid,$token)
	{
	
	}
}

// important pointers as global vars
$apps = new UE4AM_AppHandler();
$log->AddLog("UE4AM AppHandler loaded");

?>