<?php
/*! \brief very simple but helpful log class, which outputs a u4am.log on script launch
*/

class UE4AM_Log {
	private $logcontent;
	private $entries;	// How much entries the class has been made in this session
	

	function __construct() {
	$entries = 0;
	file_put_contents("ue4am.log", '*****************************************************'."\r\n".'*****************************************************'."\r\n".'UE4AM new logging init'."\r\n"."Recording Time: ".date("d.m.Y H:i:s")."\r\n",FILE_APPEND);
	$this->AddPlaceholderLine();
	    }
    
    	private function AddPlaceholderLine()
    	{
    	 $lineplaceholder = '____________________________________'."\r\n";
	
	$olddata = $this->logcontent;
	$this->logcontent = $olddata."\r\n".$lineplaceholder;
    	}
    	
	public function WriteLog()
	{
	global $debug;
	if($debug == true)
	{
	echo($this->logcontent);
	}
	file_put_contents('ue4am.log', $this->logcontent,FILE_APPEND);
	}
	public function AddMessage($var)
	{
	$this->entries += 1;
	$str2add = "[".$this->entries."] >> MESSAGE ".$var;

	$this->logcontent = $str2add."\r\n";
	$this->WriteLog();
	}
	public function AddLog($var)
	{
	$this->entries += 1;
	$str2add = "[".$this->entries."] >> ".$var;

	$this->logcontent = $str2add."\r\n";
	$this->WriteLog();
	}
	public function AddLogArray($array)
	{
	$this->entries += 1;
	$text = print_r($array,true);
	
	$this->logcontent = $text."\r\n";
	$this->WriteLog();
	}
}

// important pointers as global vars
$log = new UE4AM_Log();
?>