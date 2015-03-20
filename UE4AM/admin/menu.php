<?

require("../inc/ui.php");

$menu = new UE4AM_WebMenu();
$menu->AddItem("fa fa-dashboard","Dashboard","index.php",true);
                    $menu->AddItem("fa fa-glass","Apps","index.php?page=apps",false);
                     $menu->AddItem("fa fa-glass","Gameservers","index.php?page=gameservers",false);
                    $menu->AddItem("fa fa-gavel","Accounts","index.php?page=accounts",false);
                    $menu->AddItem("fa fa-gavel","Characters","index.php?page=characters",false);
                    $menu->AddItem("fa fa-globe","Database","index.php?page=database",false);
                    $menu->AddItem("fa fa-globe","Tools","index.php?page=tools",false);
                    $menu->AddItem("fa fa-globe","Logout","index.php?page=logout",false);
                    
// Must be set before init of this class
switch ($activemenu) {
	case "Dashboard":
		$menu->SetItemActive("Dashboard", true);
	break;
	
	case "Apps":
		$menu->SetItemActive("Apps", true);
	break;

	case "Gameservers":
	 	 $menu->SetItemActive("Gameservers", true);
             break;
             	
	case "Accounts":
	 	 $menu->SetItemActive("Accounts", true);
             break;
             
             case "Characters":
     		 $menu->SetItemActive("Characters", true);
             break;
             
             case "Database":
		 $menu->SetItemActive("Database", true);
             break;
             
	 case "Tools":
		 $menu->SetItemActive("Tools", true);
             break;
             
             case "Logout":
		 $menu->SetItemActive("Logout", true);
             break;
}

                   
                    $menu->Render();
                    
?>
                   