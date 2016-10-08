<?php
class Output
{
	//Prepare a JSON formatted response error response
	public function Response($status, $msg, $response, $logger=null)
	{
			if (!is_null($logger))
			{
				$logger->info(date("Y-m-d H:i:s") . ": Status ". $status ."/" . $msg);
			}
			$data = array('Status' => $status , 'Message' => $msg);
			$outresponse = $response->withJson($data);
			return $outresponse;
		
	}
	
	
	
}
?>