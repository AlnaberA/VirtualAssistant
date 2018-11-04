<?php 
error_reporting(0);
$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
	fwrite($myfile, $requestBody);
	fclose($myfile);
	
	$json = json_decode($requestBody);

	$text = $json->queryResult->queryText;

	switch ($text) {
		case 'hi':
			$speech = "Hi, Nice to meet you";
			break;

		case 'bye':
			$speech = "Bye, good night";
			break;

		case 'anything':
			$speech = "Yes, you can type anything here.";
			break;
		
		default:
			$speech = "Sorry, I didnt get that. Please ask me something else.";
			break;
	}
    $object = array("text"=>$speech, "image" => "test.png");
	
	$response = new \stdClass();
	$response->fulfillmentText = $speech;    
    $response->fulfillmentMessages->object;
	$response->source = "webhook";
	echo json_encode($response);
}
else
{
	echo "Method not allowed";
}

?>