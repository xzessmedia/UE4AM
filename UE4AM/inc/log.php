<?php
/*! \brief very simple but helpful log class, which outputs a log.txt on script launch
*/

class UE4AM_Log {
	private $logcontent;
	
	function __construct() {
	file_put_contents("log.txt", 'xLog 0.1 init\n');
	    }
    
	public function WriteLog()
	{
	
	file_put_contents('log.txt', $this->logcontent,FILE_APPEND);
	}
	public function AddMessage($var)
	{
	$str2add = "[".time()."] >> MESSAGE ".$var;
	$ldata = $this->logcontent;
	$this->logcontent = $ldata.'\n'.$str2add;
	$this->WriteLog();
	}
	public function AddLog($var)
	{
	global $debug;
	
	if($debug == true)
	{
	echo($var);
	}
	$str2add = "[".time()."] >> ".$var;
	$ldata = $this->logcontent;
	$this->logcontent = $ldata.'\n'.$str2add;
	$this->WriteLog();
	}
	public function AddLogArray($array)
	{
	$text = print_r($array,true);
	$ldata = $this->logcontent;
	$this->logcontent = $ldata.'\n'.$text;
	$this->WriteLog();
	}
}

?>