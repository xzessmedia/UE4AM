<?php
require_once("../ue4am.php");
require("../inc/ui.php");

if(isset($_GET['action']))
{
	if($_GET['action'] == "login")
	{
		if(isset($_POST['username']) && isset($_POST['password']))
		{
			// If we are able to login
			if($accounts->Login($_POST['username'],$_POST['password']) == 1)
			{
			$log->AddLog('Login successful (admin/login.php)');
			header("location: index.php");
			exit();
			} else {
				$log->AddLog('Wrong userdata received (admin/login.php)');
				$page = NewPage("UE4AM Login");
				$page->Add->AlertDanger("Sorry wrong Login Data! <a href=login.php>Go Back</a>",true);
				$page->Render();
			}
		} else {
			$log->AddLog('No Post Data received (admin/login.php)');
			$page = NewPage("UE4AM Login");
				$page->Add->AlertDanger("Sorry no Post Data received, dont call this script directly <a href=login.php>Go Back</a>",true);
				$page->Render();
		}
	}
}

?>