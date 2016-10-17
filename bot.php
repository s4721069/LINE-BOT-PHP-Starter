<?php
$access_token = '6AHZeq++0ib7lwzyTgJJdOJON151Ugy/L3EXVepD5tBAj/MhR5iwoQxufCbcEyGXjVP7YP7xLAOeNDCKeoLmtpaIt1dxiuz+Hs5oYxOMTPQ4I61ttgUzX10Dc3ofzQ8BEYxql2nC1c23Wy9TRpIL+QdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) 
{
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') 
		{

			$content_scada = file_get_contents('http://118.175.86.109/line/q.php');
			$scada_data = json_decode($content_scada);

			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			$replytext="ขอรายงานข้อมูลของแรงสูง 2 สถานีฟ้าแสง ณ ".$scada_data->{'DateTimeZ7'}." ดังนี้\n";
			$replytext.="อัตราการจ่ายชุมชนถ.กาญจนวนิช หาดใหญ่-น้ำน้อย ".$scada_data->{'Z7HY_FE1_PV'}." ลบ.ม./ชม. แรงดัน ".$scada_data->{'Z7HY_PE1_PV'}." บาร์\n";
			$replytext.="อัตราการจ่ายสพ.โคกสูงเส้นเก่า ".$scada_data->{'Z7HY_FE2_PV'}." ลบ.ม./ชม. แรงดัน ".$scada_data->{'Z7HY_PE2_PV'}." บาร์\n";

			
			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $replytext
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
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
echo "OK";
