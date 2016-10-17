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
	foreach ($events['events'] as $event) 
	{
		$userId=$event['source']['userId'];
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
				switch(strtoupper($textArr[1]))
				{
					case "Z7" :
				
						$content_scada = file_get_contents('http://118.175.86.109/line/q.php?z=z7');
						$scada_data = json_decode($content_scada);
						$replytext="ขอรายงานข้อมูลของแรงสูง 2 (z7) สถานีฟ้าแสง ณ ".$scada_data->{'DateTimeZ7'}." ดังนี้\n";
						$replytext.="1. อัตราการจ่ายชุมชน ถ.กาญจนวนิช หาดใหญ่-น้ำน้อย ".$scada_data->{'Z7HY_FE1_PV'}." ลบ.ม./ชม. แรงดัน ".$scada_data->{'Z7HY_PE1_PV'}." บาร์ เลขมาตรขึ้น ".$scada_data->{'Z7HY_FE1_TOT1'}."\n";
						$replytext.="2. อัตราการจ่าย สพ.โคกสูงเส้นเก่า ".$scada_data->{'Z7HY_FE2_PV'}." ลบ.ม./ชม. แรงดัน ".$scada_data->{'Z7HY_PE2_PV'}." บาร์ เลขมาตรขึ้น ".$scada_data->{'Z7HY_FE2_TOT2'}."\n";
						$replytext.="3. ระดับน้ำถังน้ำใสขนาด 6,000 ลบ.ม. คือ ".$scada_data->{'Z7HY_LE1_VOLUME'}." ลบ.ม. หรือ ".$scada_data->{'Z7HY_LE1_PV'}." เมตร";
						break;
					case "Z8" :
						$content_scada = file_get_contents('http://118.175.86.109/line/q.php?z=z8');
						$scada_data = json_decode($content_scada);
						$replytext="ขอรายงานข้อมูลของแรงสูง 3 (z8) สถานีฟ้าแสง ณ ".$scada_data->{'DateTimeZ8'}." ดังนี้\n";
						$replytext.="1. อัตราการจ่ายหาดใหญ่โซนสูง ".$scada_data->{'Z8HY_FE1_PV'}." ลบ.ม./ชม. แรงดัน ".$scada_data->{'Z8HY_PE1_PV'}." บาร์ เลขมาตรขึ้น ".$scada_data->{'Z8HY_FE1_TOT1'}."\n";
						$replytext.="2. อัตราการจ่ายหาดใหญ่โซนต่ำ ".$scada_data->{'Z8HY_FE2_PV'}." ลบ.ม./ชม. แรงดัน ".$scada_data->{'Z8HY_PE2_PV'}." บาร์ เลขมาตรขึ้น ".$scada_data->{'Z8HY_FE2_TOT2'}."\n";
						$replytext.="3. อัตราการจ่ายสพ.โคกสูงเส้นใหม่ ".$scada_data->{'Z8HY_FE3_PV'}." ลบ.ม./ชม. แรงดัน ".$scada_data->{'Z8HY_PE3_PV'}." บาร์ เลขมาตรขึ้น ".$scada_data->{'Z8HY_FE3_TOT3'}."\n";
						$replytext.="4. ระดับน้ำถังน้ำใสขนาด 3,500 ลบ.ม. คือ ".$scada_data->{'Z8HY_LE1_VOLUME'}." ลบ.ม. หรือ ".$scada_data->{'Z8HY_LE1_PV'}." เมตร";
						
						break;
					default :
				
						$replytext="สวัสดีครับ ผมชื่อ Robot\n";
						$replytext.="ในขณะนี้ผมสามารถให้ข้อมูลได้ดังนี้\n";
						$replytext.="1. แรงสูง 2 สถานีฟ้าแสง(z7) ให้กรอก robot z7\n";
						$replytext.="2. แรงสูง 3 สถานีฟ้าแสง(z8) ให้กรอก robot z8";
				}	


				
				// Build message to reply back
				$messages = [
					'type' => 'text',
					'text' =>  $sourceInfo['DisplayName']
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
}
echo "OK";
