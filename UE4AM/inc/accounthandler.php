<?php
require "settings.php";

#######################################################
/*! \brief The Account Handler is for registering, updating, authorising player accounts
*/
class UE4_AccountHandler {
    public $userid;
    public $isLoggedIn;
    public $username;
    public $email;
    public $password;
    public $type;
    public $lastping;
    public $regtimestamp;
    public $logintimestamp;
    public $logofftimestamp;
    
    public function isLogged() {
        if ($_SESSION['userid']) {
            $this->isLoggedIn = TRUE;
        } else {
            $this->isLoggedIn = FALSE;
        }
        return $this->isLoggedIn;
    }
	
/*! \brief Logouts the current User - returns a bool if successful
*	Usage:
*	$accounts->Logout();
*/
    public function Logout() {
        if ($this->isLogged()==TRUE) {
            session_destroy();
           
            return $this->isLogged();
        }
    }
	/*! \brief Login a user
	*	Returns an int
	*	0 = Login failed
	*	1 = Login succeeded
	*	2 = Password is wrong
	*
	*	Usage:
	*	$accounts->Login("itsme","test");
	*/
    public function Login($username,$password) {
        global $database;
        global $prefix;
        
        
        $rows = $database->FetchData($prefix."_users","*","WHERE username='".$username."'");
        
        if (count($rows)==0) {
            return 0;
        }
        
        foreach ($rows as $key) {
            $this->username = $key['name'];
            $this->password = $key['password'];
            $this->email = $key['email'];
            $this->regtimestamp = $key['regtimestamp'];
            $this->logintimestamp = $key['logintimestamp'];
            $this->logofftimestamp = $key['logofftimestamp'];
            $this->type = $key['type'];
            $this->lastping = $key['lastping'];
            
            
            
            if ($password == $key['password']) {
                $_SESSION['userid'] = $key['userid'];
                $_SESSION['email'] = $key['email'];
                $_SESSION['username'] = $key['name'];
                $_SESSION['password'] = $key['password'];
            
                $_SESSION['regtimestamp'] = $key['regtimestamp'];
                $_SESSION['logintimestamp'] = $key['logintimestamp'];
                $_SESSION['logofftimestamp'] = $key['logofftimestamp'];
                $_SESSION['type'] = $key['type'];
                $_SESSION['lastping'] = $key['lastping'];
            
                
                setcookie("email", $email, time()+3600);  /* verfällt in 1 Stunde */
                setcookie("password", $password, time()+3600);  /* verfällt in 1 Stunde */
                
                return 1;
              
            
            } elseif ($password != $opassword) {
                return 2;
                
            }
        }
        
        
        
    }
    /*! \brief Retrieves the Username by int $id
	*	Usage:
	*	$username = $accounts->GetUsername(1);
	*/
    public function GetUsername($id) {
    global $database;
    global $prefix;
    $result = $database->FetchData($prefix."_users","name","WHERE userid=".$id);
    foreach ($result as $row) {
        return $username = $row['name'];
    }
    if (count($result)==0) {
        return "noname";
    }
}
	/*! \brief Check if Username is free for registration
	*	Usage:
	*	If($accounts->CheckifUsernameIsFree("Hans") == TRUE)
	*	{
	*	$accounts->Register(..);
	*	}
	*/    
    public function CheckIfUsernameIsFree($username) {
        global $database;
        global $prefix;
        $res = $database->FetchData($prefix."_users","*","WHERE name='".$username."'");
        
        if (count($res) == 0) {
            return TRUE;
        } else {
            return FALSE;
            }
    }
	/*! \brief Check if E-Mail is free for registration
	*	Usage:
	*	If($accounts->CheckifEmailIsFree("Hans@me.com") == TRUE)
	*	{
	*	$accounts->Register(..);
	*	}
	*/        
    public function CheckIfEmailIsFree($email) {
        global $database;
        global $prefix;
        $res = $database->CountData($prefix."_users","*","WHERE email='".$email."'");
        
        if ($res == 0) {
            return TRUE;
        } else {
            return FALSE;
            }
    }
	/*! \brief This removes an account from DB
	*	Usage:
	*	$accounts->RemoveAccount(1);
	*/        
    public function RemoveAccount($userid) 
    {
        global $database;
        global $prefix;
        
        $this->Logout();
        
        if( $database->RemoveData($prefix."_users","WHERE userid=".$userid)){
        return TRUE;
        }      else {
            return FALSE;
        }
    }
	
  public function GenerateLiveUserList($page)
	{
	global $database;
	global $prefix;
	
	$table = new xUIListview;
	$table->InitWithID("c","liveuserlist");	
	$table->AddDivider ("Players online:");
	
	

	$data = $database->FetchData($prefix."_users","*","ORDER BY lastping asc");
	foreach ($data as $row) {
		$userid = $row['userid'];
		$username = $row['name'];
		$lastping = $row['lastping'];
		$logintime = $row['logintimestamp'];
		$now = time();
		$timeleft = $now-$logintime;
		
		$pingstr = SekundenFormatieren($now-$lastping);
		if ((time()-1200)<$lastping) {
		$timestr = '
		 p';
			$table->AddItemWithDesc ($username,"<p>Ping: ".$pingstr." | online <span id='clock".$userid."'></span></p>", "message.php?v=newmsg&uid=".$userid);  
			
			$table->AddJavascript("
	function updateClock ( )
    {
    var currentTime = ".$timeleft.";
    var currentHours = currentTime.getHours ( );
    var currentMinutes = currentTime.getMinutes ( );
    var currentSeconds = currentTime.getSeconds ( ); ".'

    // Pad the minutes and seconds with leading zeros, if required
    currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
    currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

    

    // Compose the string for display
    var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
    
    
    $("#clock'.$userid.'").html(currentTimeString);
    $("#liveuserlist").listview("refresh");
        
 }
'."
$(document).ready(function()
{
   setInterval('updateClock()', 1000);
});

");  
		}
	}	
	$counttotal = $database->CountData($prefix."_users","*","");
	$table->AddDivider ($counttotal." Players Total");
	
	
$str .= $table->GetHtml();


	return $str;
}
	


	/*! \brief This renders a list of all Users online
	*	Usage:
	*	$accounts->RenderOnlineUserlist();
	*/     
	public function RenderOnlineUserlist() {
	global $database;
	global $prefix;
	
	$page = new xUIPage;
	$page->Init("livePlayers","Players Online","page");
	$page->StartContent();
	$page->AddTitle("Players online","1");
	$page->AddContent('<div data-role="popup">');

	$table = new xUIListview;
	$table->InitWithID("c","liveuserlist");	
	$table->AddDivider ("Players online:");
	
	

	$data = $database->FetchData($prefix."_users","*","ORDER BY lastping asc");
	foreach ($data as $row) {
		$userid = $row['userid'];
		$username = $row['name'];
		$lastping = $row['lastping'];
		$logintime = $row['logintimestamp'];
		$now = time();
		$timeleft = $now-$logintime;
		
		$pingstr = SekundenFormatieren($now-$lastping);
		if ((time()-1200)<$lastping) {
		$timestr = '
		 p';
			$table->AddItemWithDesc ($username,"<p>Ping: ".$pingstr." | online <span id='clock".$userid."'></span></p>", "message.php?v=newmsg&uid=".$userid);  
			
			 $table->AddJavascript("
	function updateClock ( )
    {
    var currentTime = ".$timeleft.";
    var currentHours = currentTime.getHours ( );
    var currentMinutes = currentTime.getMinutes ( );
    var currentSeconds = currentTime.getSeconds ( ); ".'

    // Pad the minutes and seconds with leading zeros, if required
    currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
    currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

    

    // Compose the string for display
    var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
    
    
    $("#clock'.$userid.'").html(currentTimeString);
    $("#liveuserlist").listview("refresh");
        
 }
'."
$(document).ready(function()
{
   setInterval('updateClock()', 1000);
});

");
 
		}
	}	
	$counttotal = $database->CountData($prefix."_users","*","");
	$table->AddDivider ($counttotal." Players Total");
	
	

	
	$page->AddContent('</div>');
	$page->AddContent($table->GetHtml());
	$page->StopContent();
	$page->RenderPage();


}
	/*! \brief This returns an int $count of all Users online
	*	Usage:
	*	$count = $accounts->GetOnlineUsers();
	*/      
    public function GetOnlineUsers($page) {
        global $database;
        global $prefix;
        
        $Playerscount = 0;
        $guestscount = 0;
        $total = $database->CountData($prefix."_users","*","");
        $rows = $database->FetchData("clients","*","");
        foreach ($rows as $row) {
            $userid = $row['userid'];
            $lastping = $row['lastping'];
        $total++;
                if ((time()-1200)<$lastping) {
                    if (!$userid) {
                        $guestscount++;
                    } else {
                        $Playerscount++;
                    }
                }
                
            }
        

		if($Playerscount == 1)
		{
		$mglied = "<a href='#liveusers' data-rel='popup'>Mitglied</a>";
		} else {
		$mglied = "<a href='#liveusers' data-rel='popup'>Mitglieder</a>";
		}
		
		$p = '<div data-role="popup" id="liveusers">'.$this->GenerateLiveUserList($page).'</div>';
        return $Playerscount." ".$mglied." und ".$guestscount." Besucher online".$p;
    
	}
    
    
    public function SetTime($userid,$params) {
        global $database;
        global $prefix;
        
        if( $database->UpdateData($prefix."_users",$params,"WHERE userid='".$userid."'")){
        return TRUE;
        }      else {
            return FALSE;
        }
    }
	/*! \brief Send a Ping, required for checking for online users
	*	Usage:
	*	$accounts->SendPing(1);
	*/      
    public function SendPing($userid) {
        global $database;
        global $prefix;
        
        if( $database->UpdateData($prefix."_users","lastping=".time(),"WHERE userid='".$userid."'")){
        return TRUE;
        }      else {
            return FALSE;
        }
    }
	/*! \brief Sends IP Ping used to detect all clients browsing the pages
	*	Will be handled automatically by xLib
	*	Usage:
	*	$accounts->SendIPPing();
	*/  
    public function SendIPPing() {
        global $database;
        global $prefix;
        
        if (! isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $client_ip = $_SERVER['REMOTE_ADDR'];
        }
        else {
        $client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
		
		

        if ($database->CountData("clients","*","WHERE ip='".$client_ip."'")== 0) {
            if($database->InsertData("clients","userid,ip,timestamp,lastping","'".$_SESSION['userid']."','".$client_ip."','".time()."','".time()."'")){
			   return TRUE;
            }
        } else {
            if ($database->UpdateData("clients","userid='".$_SESSION['userid']."',lastping=".time(),"WHERE ip='".$client_ip."'")) {
                if(isset($_SESSION['userid']))
				{
					if($database->UpdateData($prefix."_users","lastping=".time(),"WHERE userid='".$_SESSION['userid']."'")) {
						return TRUE;
					}
				}

            }
        }
		

    }
    /*! \brief Get and returns an array of User Data
	*	Usage:
	*	$userdata = $accounts->GetUserDataFromDB(1);
	*
	*	foreach..
	*/  
    public function GetUserDataFromDB($userid) {
        global $database;
        global $prefix;
        
        $data = $database->FetchData($prefix."_users","*","WHERE userid='".$userid."'");
        return $data;
    }
    
	/*! \brief Sync DB Data to current session
	*/  
    public function SyncFromDB($userid) {
        global $database;
        global $prefix;
        
        $data = $database->FetchData($prefix."_users","*","WHERE userid='".$userid."'");
        foreach ($data as $key) {
            $this->username = $key['name'];
            $this->password = $key['password'];
            $this->email = $key['email'];
            $this->regtimestamp = $key['regtimestamp'];
            $this->logintimestamp = $key['logintimestamp'];
            $this->logofftimestamp = $key['logofftimestamp'];
            $this->type = $key['type'];
            $this->lastping = $key['lastping'];
        }
    }
    /*! \brief Sync DB Data and save in current session
	*/  
    public function SyncAndSave($userid) {
        if ($this->isLogged()==TRUE) {
            
            $this->SyncFromDB($userid);
            $this->SaveInSession();
        }
        
    }
    
    
    
    /*! \brief Returns the Logoff timestamp
	*/  
    public function GetLogoffTime($userid) {
        global $database;
        global $prefix;
        
        $data = $this->GetUserDataFromDB($userid);
        foreach ($data as $row) {
            $logofftime = $row['logofftimestamp'];
            
        }
        return $logofftime;
    }
    /*! \brief Returns the Register timestamp
	*/  
    public function GetRegisterTime($userid) {
        global $database;
        global $prefix;
        
        $data = $this->GetUserDataFromDB($userid);
        foreach ($data as $row) {
            $regtime = $row['regtimestamp'];
            
        }
        return $regtime;
    }
    /*! \brief Returns last Login timestamp
	*/  
    public function GetLoginTime($userid) {
        global $database;
        global $prefix;
        
        $data = $this->GetUserDataFromDB($userid);
        foreach ($data as $row) {
            $logintime = $row['logintimestamp'];
            
        }
        
    }
    /*! \brief This function is used to register new users
	*	returns TRUE if successful or FALSE if not
	*/  
    public function Register($email,$username,$password) {
        global $database;
        global $prefix;
        if (($this->CheckIfUsernameIsFree($username) == TRUE) && $this->CheckIfEmailIsFree($email) == TRUE) {
            
        
        if($database->InsertData($prefix."_users","name,email,password,regtimestamp,logintimestamp,logofftimestamp,type,lastping","'".$username."','".$email."','".$password."','".time()."','".time()."','".time()."','0','".time()."'")) {
        return TRUE; } } else {
            return FALSE;
        }
        
    }
}

?>