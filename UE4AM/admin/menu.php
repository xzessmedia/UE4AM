<?

class UE4AM_WebMenuItem
{
	private $isActive;
	private $icon;
	private $link;
	private $caption;
	
	function Render()
	{
		echo $this->GetHTML();
	}

	function Setup($icon, $link, $caption, $isActive)
	{
		$this->icon 	= $icon;
		$this->link 	= $link;
		$this->caption 	= $caption;
		$this->isActive = $isActive;
	}
	
	function GetName()
	{
		return $this->caption;
	}
	
	function GetHTML()
	{
		if($this->isActive == true)
			{
				echo("<li class='active'>");
			} else {
				echo('<li>');
			}
			
		echo("
		<a href=".$this->link.">
	                                <i class='".$this->icon."'></i> <span>".$this->caption."</span>
	                            </a>
	                        </li>");
	}
	
	function IsActive()
	{
		return $this->isActive;
	}
	
	function SetActive($value)
	{
		$this->isActive = $value;
	}
}

class UE4AM_WebMenu
{
private $items;

	function __construct() 
	{
	       $this->items = array();
	 }


	// Push Item on the Array Stack
	public function AddItem($icon,$name,$link,$active)
	{
		$newitem = new UE4AM_WebMenuItem();
		$newitem->Setup($icon, $link, $name, $active);
		array_push($this->items, $newitem);
	}
	
	public function SetItemActive($itemname, $active)
	{
	$return = false;
	
	$this->ResetActive();
	
	foreach ($this->items as $key => $value) {
		if($value->GetName() == $itemname)
		{
		$value->SetActive($active);
		$return = true;
		}
	}
	return $return;
	}
	
	// Resets all Items active Status to inactive
	public function ResetActive()
	{
	foreach ($this->items as $key => $value) {
		$value->SetActive(false);
	}
	}
	
	public function GetHTML()
	{
	$html = '<ul class="sidebar-menu">';
	foreach ($this->items as $key => $value) {
		$html .= $value->GetHTML();
	}
	$html .= '</ul>';
		return $html;
	}

	public function Render()
	{
	 print($this->GetHTML());
	}
	
}

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
                   