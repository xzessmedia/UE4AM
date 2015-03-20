<?php
require("../inc/ui.php");
$page = NewPage("UE4AM Login");




$page->AddContent('

<div class="container">
  
  <div class="row" id="pwd-container">
    <div class="col-md-4"></div>
    
    <div class="col-md-4">
      <section class="login-form">
        <form class="loginform" method="post" role="login">
          <img src="http://i.imgur.com/RcmcLv4.png" class="img-responsive" alt="" />
          <input type="text" name="username" placeholder="Username" required class="form-control input-lg" value="YourUsername" />
          
          <input type="password" class="form-control input-lg" id="password" placeholder="Password" required="" />
          
          
          <div class="pwstrength_viewport_progress"></div>
          
          
          <button type="submit" name="go" id="submitbutton" class="btn btn-lg btn-primary btn-block">Sign in</button>
          
          <div>
            <a href="#">Create account</a> or <a href="#">reset password</a>
          </div>
          
        </form>
        
      </section>  
      </div>
      
      ');
      

$page->AddFormProcessorScript("loginform","submitbutton","actionhandler.php?action=login","Sorry, something went wrong");
$page->Add->Jumbotron("<h1>Jo Test!</h1>",true);
$page->Render();

?>