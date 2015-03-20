<?php

// Written by Tim Koepsel (c) 2013

/*! \brief UE4_UI Base UI Class
*	This is a php based boostrap page renderer
*	
*	
*	
*	
*/    
abstract class UE4_UI
{
	abstract public function GetHTML();
	abstract public function Render();
}

class UE4AM_WebMenuItem extends UE4_UI
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

class UE4AM_WebMenu extends UE4_UI
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

class UE4_UIModal extends UE4_UI
{
	private $title;
	private $header;
	private $body;
	private $footer;
	private $id;
	
	public function SetTitle($title)
	{
	$this->title = $title;
	}
	
	public function AddContent($content)
	{
	$this->body .= $content;
	}
	public function AddFooter($content)
	{
	$this->footer .= $content;
	}
	public function AddHeader($content)
	{
	$this->header .= $content;
	}
	
		
	public function AddFormProcessorScript($modalid,$formclass,$buttonid,$phpscript)
	{
	$this->body .= '
	<script>
	$(function() {
	$("button#'.$buttonid.'").click(function() {
	$.ajax({
	type: "POST",
	url: "'.$phpscript.'",     '."
	data: $('form.".$formclass."').serialize(),
	success:function(msg) {
	$(".'#'.$modalid.'").modal('."'hide');
	},
	error: function() {
	alert(".'"failure");
	}
			});
		});
	});
	</script>';
	}
	
	public function GetHTML()
	{
	
	$html = '
	<!-- Modal HTML -->
	<div id="'.$id.'" class="modal fade">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 class="modal-title">'.$this->title.'</h4>
	            </div>
	            <div class="modal-body">'.$this->body.'
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	                <button type="button" class="btn btn-primary">Save changes</button>
	                '.$this->footer.'
	            </div>
	        </div>
	    </div>
	</div>';
	
	$html .= $this->AddModalOpenScript($this->id);
	return $html;
	}
	
	public function Render()
	{
	echo $this->GetHTML();
	}
	
	function AddModalOpenScript($modalid)
	{
	$str = '
	<script type="text/javascript">
	$(document).ready(function(){
	    $(".btn").click(function(){
	        $("#'.$modalid.'").modal('."'show');
	    });
	});
	</script>";
	return $str;
	}
}


class UE4_UITool
{
	private $page;
	private $tools;
	
	function __construct() {
	 // init array
	        $this->tools = array();
	 }
	 
	 public function SetPage($page)
	 {
	 $this->page = $page;
	 }
	 
	// type (bool) (true = Add to Page, false = Get
	public function Jumbotron($content,$bAdd)
	{
	$div = MakeDiv("jumbotron",$content);
	$this->Add($div); // Add the tool on stack array
	
	if($bAdd == true)
	{
	$this->AddToolToPage($div);
	} else {
	return $tool;
	}
	}
	
	// type (bool) (true = Add to Page, false = Get
	public function Div($content,$bAdd)
	{
	$div = MakeDiv("",$content);
	$this->Add($div); // Add the tool on stack array
	
	if($bAdd == true)
	{
	$this->AddToolToPage($div);
	} else {
	return $tool;
	}
	}
	
	// type (bool) (true = Add to Page, false = Get
	public function Container($content,$bAdd)
	{
	$div = MakeDiv("container",$content);
	$this->Add($div); // Add the tool on stack array
	
	if($bAdd == true)
	{
	$this->AddToolToPage($div);
	} else {
	return $tool;
	}
	}
	
	// type (bool) (true = Add to Page, false = Get
	public function AlertDanger($content,$bAdd)
	{
	$div = MakeSpecialDiv("alert alert-danger",$content,'role="alert"');
	$this->Add($div); // Add the tool on stack array
	
	if($bAdd == true)
	{
	$this->AddToolToPage($div);
	} else {
	return $tool;
	}
	}
	
	// type (bool) (true = Add to Page, false = Get
	public function AlertInfo($content,$bAdd)
	{
	$div = MakeSpecialDiv("alert alert-info",$content,'role="alert"');
	$this->Add($div); // Add the tool on stack array
	
	if($bAdd == true)
	{
	$this->AddToolToPage($div);
	} else {
	return $tool;
	}
	}
	
	
	private function Add($tool)
	{
	array_push($this->tools, $tool);
	}
	
	private function AddToolToPage($tool)
	{
		$this->page->AddContent($tool->GetHTML());
	}
}

class UE4_UITool_Div extends UE4_UI
{
	private $class;
	private $content;
	private $additional;
	
	public function SetClass($class)
	{
	$this->class = $class;
	}
	
	public function AddAdditional($addcode)
	{
	$this->additional .= ' '.$addcode;
	}
	
	public function AddContent($content)
	{
	$this->content .= $content;
	}
	
	public function ClearContent()
	{
	$this->content = "";
	}
	
	public function GetHTML()
	{
	$html = '
	<div class="'.$this->class.' '.$this->additional.">"."\r\n";
	$html .= "\t".$this->content."\r\n";
	$html .= "\t".'</div>'."\r\n";
	return $html;
	}
	
	public function Render()
	{
	$this->GetHTML();
	}
}

class UE4_PageHeader extends UE4_UI
{
	private $content;
	private $title;
	
	function __construct() {
	 // Set default Title
	        $this->SetTitle("UE4AM");
	 }
	 
	public function AddHeader($code)
	{
	$this->content .= $code."\r\n";
	}
	
	public function SetTitle($title)
	{
	$this->title = $title;
	}
	
	public function GetHTML()
	{
	$html =
	'
	    <head>
	        <meta charset="UTF-8">
	        <title>'.$this->title.'</title>
	        <meta content='."'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	        <meta name=".'"description" content="Developed By Tim Koepsel">
	        <meta name="keywords" content="Admin, Bootstrap 3,  Responsive">
	        <!-- bootstrap 3.0.2 -->
	        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	        <!-- font Awesome -->
	        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	        <!-- Ionicons -->
	        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
	
	        <link href='."'http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
	        <!-- Theme style -->
	        <link href=".'"css/style.css" rel="stylesheet" type="text/css" />
	
	        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	        <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
	        <!--[if lt IE 9]>
	          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	        <![endif]-->';
	        
	        // Insert Header Content
	        $html .= $this->content."\r\n";
	
	        // Close
	        $html .= '    </head>'."\r\n";
	        return $html;
	}
	
	public function Render()
	{
	echo $this->GetHTML();
	}
}

class UE4_PageBody extends UE4_UI
{
	private $content;
	private $theme;
	
	 function __construct() {
	 // Set default Theme
	        $this->SetTheme("skin-black");
	 }
	
	public function AddContent($content)
	{
	$this->content .= $content."\r\n";
	}
	
	public function ClearContent()
	{
	$this->content = "";
	}
	
	public function SetTheme($theme)
	{
	$this->theme = $theme;
	}
	public function GetTheme()
	{
	return $this->theme;
	}
	
	public function GetHTML()
	{
	$html = '
	 <body class="skin-black">
	 '."\r\n";
	 $html .= $this->content;
	 $html .= '</body>'."\r\n";
	 return $html;
	}
	
	public function Render()
	{
	echo $this->GetHTML();
	}
}
class UE4_UIPage extends UE4_UI
{
	private $header;
	private $body;
	public $Add;
	
	 function __construct() {
	        $this->header 	= new UE4_PageHeader();
	        $this->body	= new UE4_PageBody();
	        $this->Add 	= new UE4_UITool();
	        $this->Add->SetPage($this);
	 }
	 
	public function AddHeader($code)
	{
	$this->header->AddHeader($code);
	}
	
	public function SetTitle($title)
	{
	$this->header->SetTitle($title);
	}
	
	public function AddContent($content)
	{
	$this->body->AddContent($content);
	}
	
	public function AddFormProcessorScript($formclass,$buttonid,$phpscript,$failuremsg)
	{
	$this->body->AddContent('
	<script>
	$(function() {
	$("button#'.$buttonid.'").click(function() {
	$.ajax({
	type: "POST",
	url: "'.$phpscript.'",     '."
	data: $('form.".$formclass."').serialize(),
	success:function(msg) {

	},
	error: function() {
	alert('".$failuremsg."');
	}
			});
		});
	});
	</script>");
	}
	
	

	public function GetHTML()
	{
	$html = '
	<!DOCTYPE html>
	<html>';
	$html .= $this->header->GetHTML();
	$html .= $this->body->GetHTML()."\r\n";
	$html .= '</html>'."\r\n";
	
	return $html;
	}
	public function Render()
	{
	echo $this->GetHTML();
	}
}


// static Helper function
function NewPage($title)
{
$page = new UE4_UIPage();
$page->SetTitle($title);

return $page;
}

/*! \brief UE4_UI MakeDiv Helper Function
*	
*	
*	
*	
*	
*/    
function MakeDiv($class,$content)
{
	$div = new UE4_UITool_Div();
	
		if(isset($class))
		{
		$div->SetClass($class);
		}
		
		if(isset($content))
		{
		$div->AddContent($content);
		}
	return $div;
}

function MakeSpecialDiv($class,$content,$additional)
{
	$div = new UE4_UITool_Div();
	
		if(isset($class))
		{
		$div->SetClass($class);
		}
		
		if(isset($content))
		{
		$div->AddContent($content);
		}
		
		if(isset($additional))
		{
		$div->AddAdditional($additional);
		}
	return $div;
}

function MakeModal($title)
{
$modal = new UE4_UIModal();
$modal->SetTitle($title);
return $modal;
}



?>