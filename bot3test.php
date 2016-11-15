<?php
$access_token = 'zMD2WPXSIgTgNnJjHKExkS3oJiEjm3B++iwh1Sy0xOZUn0IKapWhTqnkEa8h3b9oTWbYvyghxYroDKb/W7gxbleMPa5aSQXUicBMz3mI04LgDZMXFcdK5dFs32mcPfrNoXhsBRAcyo655MlG/614uQdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');

//$myfile = fopen("testfile.txt", "w");
//fwrite($myfile, $content);
//fclose($myfile);

// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) 
{
	// Loop through each event
	foreach ($events['events'] as $event) 
	{
		

		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') 
		{

			

			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			$textArr=explode(" ",$text);
			if(strtoupper($textArr[0])=="ROBOT")
			{
				
				$userId='Uc5ef5c19165db14d618eec456075f674';
				$url = 'https://api.line.me/v2/bot/profile/'.$userId;
				$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				$result = curl_exec($ch);
				curl_close($ch);
				$sourceInfo = json_decode($result, true);

				$replytext=$sourceInfo["pictureUrl"];
				
				// Build message to reply back

				$messages = [
					'type' => 'text',
					'text' =>  $replytext
				];

				// Make a POST Request to Messaging API to reply to sender
				$url = 'https://api.line.me/v2/bot/message/reply';
				$data = [
					'replyToken' => $replyToken,
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
		}
	}
}
else
{
	$userId='5210463542905';
				//$url = 'https://api.line.me/v2/bot/profile/'.$userId;
				$url = 'https://api.line.me/v2/bot/message/'.$userId.'/content';
				$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				$result = curl_exec($ch);
				curl_close($ch);
				$sourceInfo = json_decode($result, true);

				$replytext=$sourceInfo["displayName"];
				print "\$replytext=$replytext";
}
echo "<br>OK";

