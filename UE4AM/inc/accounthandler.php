<?php
require "settings.php";
//written by Tim Koepsel (c) 2012






class UE4AM_Account
{
    public $userid;
    public $isLoggedIn;
    public $username;
    public $email;
    public $password;
    public $type;
    public $lastpingtimestamp;
    public $regtimestamp;
    public $lastlogintimestamp;
    public $lastlogouttimestamp;
    
    
        public function SaveToSession()
    {
              ini_set('php_value output_buffering', '1');
	  ini_set('session.use_trans_sid', '0');
	  ini_set('session.use_cookies' , '1' );
	  ini_set('session.use_only_cookies' , '1');
	  
                session_start();  
   	    session_unset();
   	    session_regenerate_id(true);
   	    
                $_SESSION['userid'] = $this->userid;
                $_SESSION['email'] = $this->email;
                $_SESSION['username'] = $this->username;
                $_SESSION['password'] = $this->password;
            
                $_SESSION['regtimestamp'] = $this->regtimestamp;
                $_SESSION['lastlogintimestamp'] = $this->lastlogintimestamp;
                $_SESSION['lastlogouttimestamp'] = $this->lastlogouttimestamp;
                $_SESSION['type'] = $this->type;
                $_SESSION['lastpingtimestamp'] = $this->lastpingtimestamp;
            
                
                setcookie("email", $this->email, time()+3600);  /* verfällt in 1 Stunde */
                setcookie("password", $this->password, time()+3600);  /* verfällt in 1 Stunde */
    }	
    
     public function SyncFromDB()
     {
         global $database;
         global $prefix;
        
            $data = $database->FetchData($prefix."_users","*","WHERE userid='".$this->userid."'");
            
            foreach ($data as $key) {
            $this->username = $key['username'];
            $this->password = $key['password'];
            $this->email = $key['email'];
            $this->regtimestamp = $key['regtimestamp'];
            $this->lastlogintimestamp = $key['lastlogintimestamp'];
            $this->lastlogouttimestamp = $key['lastlogouttimestamp'];
            $this->type = $key['type'];
            $this->lastpingtimestamp = $key['lastpingtimestamp'];
     	}
     }
     
     public function SyncAndSave()
     {
     $this->SyncFromDB();
     $this->SaveToSession();
     }
     
     public function SyncToDB()
     {
         global $database;
         global $prefix;
        
        $params = "username='".$this->username."', password='".$this->password."', email='".$this->email."', regtimestamp='".$this->regtimestamp."', lastlogintimestamp='".$this->lastlogintimestamp."', lastlogouttimestamp='".$this->lastlogouttimestamp."', type='".$this->type."', lastpingtimestamp='".$this->lastpingtimestamp."' ";
        
        if( $database->UpdateData($prefix."_users",$params,"WHERE userid='".$this->userid."'")){
        return TRUE;
        }      else {
            return FALSE;
        }
    
     }
    
    
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
    	

}

#######################################################
/*! \brief The Account Handler is for registering, updating, authorising player accounts
*/
class UE4AM_AccountHandler {
private $CurrentUser;
    
    
    
    public function GetCurrentUser()
    {
    return $CurrentUser;
    }
     public function GetAccountFromID($userid)
     {
     $account = new UE4AM_Account();
     $account->userid = $userid;
     $account->SyncFromDB();
     return $account;
     }
     
     public function GetAccountFromUsername($username)
     {
    global $database;
    global $prefix;
    $account = new UE4AM_Account();
    $result = $database->FetchData($prefix."_users","userid","WHERE username=".$username);

        foreach ($result as $row) {
        $account->userid = $row['userid'];
   	 }
    
     
      $account->SyncFromDB();
     return $account;
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
        
        // Protect Strings to avoid SQL injections
        $username = $database->ProtectString($username);
        $password = $database->ProtectString($password);
        
        $rows = $database->FetchData($prefix."_users","*","WHERE username='".$username."'");
        
        if (count($rows)==0) {
            return 0;
        }
        
                    // Verify Password with Hash
            $verifyresult = password_verify($password, $key['password']);
            
            
            if ($verifyresult == TRUE) {
        	$this->CurrentUser = $this->GetAccountFromUsername($username);
             $this->CurrentUser->SyncAndSave();
                return 1;
              
            
            } else {
                return 2;
                
            }
        }
        
        
        
    
    /*! \brief Retrieves the Username by int $id
	*	Usage:
	*	$username = $accounts->GetUsername(1);
	*/
    public function GetUsername($id) {
    global $database;
    global $prefix;
    $result = $database->FetchData($prefix."_users","username","WHERE userid=".$id);
    foreach ($result as $row) {
        return $username = $row['username'];
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
        $res = $database->FetchData($prefix."_users","*","WHERE username='".$username."'");
        
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
 
        
        if( $database->RemoveData($prefix."_users","WHERE userid=".$userid)){
        return TRUE;
        }      else {
            return FALSE;
        }
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
            $lastpingtimestamp = $row['lastpingtimestamp'];
        $total++;
                if ((time()-1200)<$lastpingtimestamp) {
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
    
    
	/*! \brief Send a Ping, required for checking for online users
	*	Usage:
	*	$accounts->SendPing(1);
	*/      
    public function SendPing($userid) {
        global $database;
        global $prefix;
        
        if( $database->UpdateData($prefix."_users","lastpingtimestamp=".time(),"WHERE userid='".$userid."'")){
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
            if($database->InsertData("clients","userid,ip,timestamp,lastpingtimestamp","'".$_SESSION['userid']."','".$client_ip."','".time()."','".time()."'")){
			   return TRUE;
            }
        } else {
            if ($database->UpdateData("clients","userid='".$_SESSION['userid']."',lastpingtimestamp=".time(),"WHERE ip='".$client_ip."'")) {
                if(isset($_SESSION['userid']))
				{
					if($database->UpdateData($prefix."_users","lastpingtimestamp=".time(),"WHERE userid='".$_SESSION['userid']."'")) {
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

    
    
    
    /*! \brief Returns the Logoff timestamp
	*/  
    public function GetLogoffTime($userid) {
        global $database;
        global $prefix;
        
        $data = $this->GetUserDataFromDB($userid);
        foreach ($data as $row) {
            $logofftime = $row['lastlogouttimestamp'];
            
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
            $logintime = $row['lastlogintimestamp'];
            
        }
        
    }
    /*! \brief This function is used to register new users
	*	returns TRUE if successful or FALSE if not
	*/  
    public function Register($email,$username,$password,$redirecturl) {
        global $database;
        global $prefix;
        
        // Protect Strings to avoid SQL injections
        $username = $database->ProtectString($username);
        $password = $database->ProtectString($password);
        $email = $database->ProtectString($email);
        
        // Crypt Password
        $password = password_hash($password, PASSWORD_DEFAULT);
        
        if (($this->CheckIfUsernameIsFree($username) == TRUE) && $this->CheckIfEmailIsFree($email) == TRUE) {
            
        
        if($database->InsertData($prefix."_users","username,email,password,regtimestamp,lastlogintimestamp,lastlogouttimestamp,type,lastpingtimestamp","'".$username."','".$email."','".$password."','".time()."','".time()."','".time()."','0','".time()."'")) {
                header("Location: ".$redirecturl);
    	exit;
        return TRUE; 

        } } else {
            return FALSE;
        }
        
    }
}




// important pointers as global vars
$accounts = new UE4AM_AccountHandler();
$log->AddLog("UE4AM Account Handler loaded");

?>