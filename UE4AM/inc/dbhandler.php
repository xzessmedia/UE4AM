<?php

/*! \brief UE4AM DB Handler
 * This class will be instanced by UE4_AccountManager class.
 * It always provides fast and easy database access
 * it can be called by using $database->FetchData(..); i.e.
 */
class UE4_DBHandler
{
    /// Public bool if database is connected to MYSQLDB
    public $isConnected = false;
    
/*! \brief The constructor will automatically call Connect()
 *
 */
 function __construct() {
        $this->Connect();
 }


//! The connect function connects manually to a DB,
/*! UE4AM automatically handles this!
 */
public function Connect()
{
global $dbuser,$dbpassword,$dbname,$dbhost;
$conn_id = mysql_connect($dbhost,$dbuser,$dbpassword);
mysql_select_db($dbname,$conn_id);
//mysql_query("SET NAMES 'utf8'");

if (!$conn_id) {
    $this->isConnected = FALSE;
} else {
  $this->isConnected = TRUE;  
}
return $this->isConnected;
}

//! Execute SQL String
/*! Usage example: $database->ExecSql("SELECT * from table"); 
 */
public function ExecSql($sql) {
    $query = mysql_query($sql) or die (mysql_error());
    return $query;
}
//! Insert Data into a table
/*! Usage example: $database->InsertData("mytable","col1,col2,col3","var1,var2,var3");
 */
public function InsertData($table,$sqlcolumns,$vars) {
  $res =   mysql_query("INSERT INTO ".$table." (".$sqlcolumns.") VALUES (".$vars.")")or die (mysql_error());	
  return $res;
}
//! Count all data in a table
/*! Usage example: $result = $database->CountData("mytable","users","WHERE userid=1");
 */
public function CountData($table,$sqlcolumns,$selector) {
		$result = mysql_query("SELECT ".$sqlcolumns." FROM ".$table." ".$selector) or die (mysql_error()); 
		return mysql_num_rows($result);
}
/*! \brief Fetch Data into an array.
 *         Usage example: $data = $database->FetchData("mytable","*","ORDER BY id asc");
 *
 *  foreach ($data as $row) {
 *     $username = $row['username'];
 *  }
 */
public function FetchData($table,$sqlcolumns,$selector)
{
		$query = mysql_query("SELECT ".$sqlcolumns." FROM ".$table." ".$selector) or die (mysql_error());
			
			
    $result = array();
    while ($record = mysql_fetch_array($query)) {
         $result[] = $record;
    }
    return $result;

}
//! Updates a Data value in a table
/*! Usage example: $result = $database->UpdateData("mytable","username='Hans'","WHERE userid=1");
 */
public function UpdateData($table,$params,$selector) {
        $res =   mysql_query("UPDATE ".$table." SET ".$params." ".$selector) or die (mysql_error());	
        return $res;
}


//! Removes a Data value in a table.
/*! Usage example: $result = $database->RemoveData("mytable","WHERE userid=1");
 */
public function RemoveData($table,$selector) {
		$result = mysql_query("DELETE FROM ".$table." ".$selector) or die (mysql_error()); 
		return($result);
}
//! Clears all data in a table.
/*! Usage example: $result = $database->ClearTable("mytable");
 */
public function ClearTable($table) {
        $result = mysql_query('TRUNCATE TABLE '.$table) or die (mysql_error()); 
		return($result);
}

private function getSCArray() { return array( 'Ã¼'=>'ü', 'Ã¤'=>'ä', 'Ã¶'=>'ö', 'Ã–'=>'Ö', 'ÃŸ'=>'ß', 'Ã '=>'à', 'Ã¡'=>'á', 'Ã¢'=>'â', 'Ã£'=>'ã', 'Ã¹'=>'ù', 'Ãº'=>'ú', 'Ã»'=>'û', 'Ã™'=>'Ù', 'Ãš'=>'Ú', 'Ã›'=>'Û', 'Ãœ'=>'Ü', 'Ã²'=>'ò', 'Ã³'=>'ó', 'Ã´'=>'ô', 'Ã¨'=>'è', 'Ã©'=>'é', 'Ãª'=>'ê', 'Ã«'=>'ë', 'Ã€'=>'À', 'Ã'=>'Á', 'Ã‚'=>'Â', 'Ãƒ'=>'Ã', 'Ã„'=>'Ä', 'Ã…'=>'Å', 'Ã‡'=>'Ç', 'Ãˆ'=>'È', 'Ã‰'=>'É', 'ÃŠ'=>'Ê', 'Ã‹'=>'Ë', 'ÃŒ'=>'Ì', 'Ã'=>'Í', 'ÃŽ'=>'Î', 'Ã'=>'Ï', 'Ã‘'=>'Ñ', 'Ã’'=>'Ò', 'Ã“'=>'Ó', 'Ã”'=>'Ô', 'Ã•'=>'Õ', 'Ã˜'=>'Ø', 'Ã¥'=>'å', 'Ã¦'=>'æ', 'Ã§'=>'ç', 'Ã¬'=>'ì', 'Ã­'=>'í', 'Ã®'=>'î', 'Ã¯'=>'ï', 'Ã°'=>'ð', 'Ã±'=>'ñ', 'Ãµ'=>'õ', 'Ã¸'=>'ø', 'Ã½'=>'ý', 'Ã¿'=>'ÿ', 'â‚¬'=>'€' );
}
/*! Fix all Special Chars in localized strings: $result = $database->FixSC("mytable","mycolumn");
 */
public function FixSC($table,$column) {                  
	$umlaute = $this->getSCArray();                  
	foreach ($umlaute as $key => $value){                                         
	$sql = "UPDATE ".$table." SET ".$column." = REPLACE(row, '{$key}', '{$value}') WHERE row LIKE '%{$key}%'"; 
	}
}

}

?>