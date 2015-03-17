<?

class UE4AM_WebMenu
{
private $html;

	function __construct() 
	{
	       $html = '<ul class="sidebar-menu">';
	 }

	
	public function AddItem($icon,$name,$link,$active)
	{
	$html = $this->html;
		if($active == true)
		{
		$html = $html.'<li class="active">';
		} else
		{
		$html = $html.'<li>';
		}
		$html = $html.'
                            <a href="'.$link.'">
                                <i class="'.$icon.'"></i> <span>'.$name.'</span>
                            </a>
                        </li>';
	}
	
	public function Finish()
	{
		$html = $this->html;
		$html = $html.'</ul>';
	}
	public function Render()
	{
	 echo($this->html);
	}
	
}

                    $menu = new UE4AM_WebMenu();
                    $menu->AddItem("fa fa-dashboard","Dashboard","index.html",false);
                    $menu->AddItem("fa fa-glass","Apps","apps.html",true);
                    $menu->AddItem("fa fa-gavel","Accounts","accounts.html",false);
                    $menu->AddItem("fa fa-gavel","Characters","characters.html",false);
                    $menu->AddItem("fa fa-globe","Database","database.html",false);
                    $menu->Finish();
                    $menu->Render();
                    
?>
                   