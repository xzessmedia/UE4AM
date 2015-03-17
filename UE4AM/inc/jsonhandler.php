<?php

/*! \brief The Json Handler is decoding and encoding data between clients and the database
*/
class UE4_JsonHandler
{
private $last_received_jsonarray;
private $last_data; 

	/*! Receives the Json Data, decodes and returns to an array containing all data */
	function Receive()
	{
		$input = file_get_contents('php://input');
		$received_jsonarray = json_decode( $input, TRUE);
		$this->last_received_jsonarray = $received_jsonarray;
		return $received_jsonarray;
	}
	
	/*! This Function outputs the data to the client */
	/*! $data is an array containing the data */
	
	function Output($data)
	{
		$json_data = json_encode($data);
		return $json_data;
	}
	
	/*! This function sends the data to a specified url */
	/*! This function is not ready yet */
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