<?php
$access_token = 'HnZVItpXuMSHTUoUFlITtJupoc2qpFOcLbHUMx03m6JX+tPfP/ex+xO3UJdItxFpbmgFItgF06r2XZ6Vd0f/BZ2wVyR5k0uBTwgYT6UaVJLW+iylRtVjRM1IWU0LI5ktuFL/SG8CdDqdL/S5qeez/QdB04t89/1O/w1cDnyilFU=';

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
				$replytext="Your id is " .$event['source']['userId'];
				$messages = [[
					'type' => 'text',
					'text' =>  $replytext
					]];
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
	$pushtext=$_GET["text"];
	$to=$_GET["to"];
	//$to='U13fcec855c7157a2b7c9c0c1d8c0d19b'; // Somchai
	$messages = [[
			'type' => 'text',
			'text' =>  $pushtext
		]];



	


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
