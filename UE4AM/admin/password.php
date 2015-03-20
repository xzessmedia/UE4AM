<?php
require("../ue4am.php");

if(isset($_GET['password']))
{
echo password_hash($_GET['password'], PASSWORD_DEFAULT);
echo "<br>";
echo "<br>";

echo "Account Registration Result: ";
echo $accounts->Register("test","test",$_GET['password']);
}
?>