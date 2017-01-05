<?php
$access_token = 'zMD2WPXSIgTgNnJjHKExkS3oJiEjm3B++iwh1Sy0xOZUn0IKapWhTqnkEa8h3b9oTWbYvyghxYroDKb/W7gxbleMPa5aSQXUicBMz3mI04LgDZMXFcdK5dFs32mcPfrNoXhsBRAcyo655MlG/614uQdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');

$myfile = fopen("testfile.txt", "a");
fwrite($myfile, $content);
fclose($myfile);

// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) 
{
	
}
else
{
	$job=$_GET["job"];
	$pushtext=$_GET["pushtext"];
	switch ($job) 
	{
		
		case 'job01' : 
			$to='U13fcec855c7157a2b7c9c0c1d8c0d19b'; // Somchai
			
			$messages = [[
					'type' => 'text',
					'text' =>  $pushtext
				]];

			break;
		
		default:
			exit();
			break;
	}

	


	// Make a POST Request to Messaging API to reply to sender
	$url = 'https://api.line.me/v2/bot/message/push';
	$data = [
		'to' => $to,
		'messages' => $messages,
	];
	$post = json_encode($data);
	$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$result = curl_exec($ch);
	curl_close($ch);

	echo $result . "\r\n";
}
echo "OK";
