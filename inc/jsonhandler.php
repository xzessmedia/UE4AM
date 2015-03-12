<?php
/*! \brief The Json Handler is decoding and encoding data between clients and the database
*/
class UE4_JsonHandler
{
private $last_received_jsonarray;
private $last_data; 

	function Receive()
	{
		$input = file_get_contents('php://input');
		$received_jsonarray = json_decode( $input, TRUE);
		$this->last_received_jsonarray = $received_jsonarray;
		return $received_jsonarray;
	}
	
	function Send($url, $data)
	{
	$this->last_data = $data;
	
	$options = array(
	    'http' => array(
	        'method'  => 'POST',
	        'content' => json_encode( $data ),
	        'header'=>  "Content-Type: application/json\r\n" .
	                    "Accept: application/json\r\n"
	      )
	);
	 
	$context     = stream_context_create($options);
	$result      = file_get_contents($url, false, $context);
	$response    = json_decode($result);
	var_dump($response);
	}
}

?>