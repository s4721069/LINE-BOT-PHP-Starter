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
				switch(strtoupper($textArr[1]))
				{
					case "Z3" :
						$content_scada = file_get_contents('http://118.175.86.109/line/q.php?z=z3');
						$scada_data = json_decode($content_scada, true);
						$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
						$replytext.="ขอรายงานข้อมูลของโรงกรอง 1500 ลบ.ม./ชม.(z3) สถานีฟ้าแสง ณ ".$scada_data['DateTimeZ3']." ดังนี้\n";
						$replytext.="1. ระดับน้ำถังน้ำใสขนาด 3,000 ลบ.ม. คือ ".$scada_data['Z3HY_LE1_VOLUME']." ลบ.ม. หรือ ".$scada_data['Z3HY_LE1_PV']." เมตร\n";
						$replytext.="2. คุณภาพน้ำ pH ".$scada_data['Z3HY_PH']." ความขุ่น ".$scada_data['Z3HY_TB']." NTU คลอรีนคงเหลือ ".$scada_data['Z3HY_CL']." mg/l";
											
						break;
					case "Z4" :
						$content_scada = file_get_contents('http://118.175.86.109/line/q.php?z=z4');
						$scada_data = json_decode($content_scada, true);
						$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
						$replytext.="ขอรายงานข้อมูลของโรงกรอง 2000 ลบ.ม./ชม. (z4) สถานีฟ้าแสง ณ ".$scada_data['DateTimeZ4']." ดังนี้\n";
						$replytext.="1. คุณภาพน้ำ pH ".$scada_data['Z4HY_PH']." ความขุ่น ".$scada_data['Z4HY_TB']." NTU คลอรีนคงเหลือ ".$scada_data['Z4HY_CL']." mg/l";
											
						break;
					case "Z6" :
						$content_scada = file_get_contents('http://118.175.86.109/line/q.php?z=z6');
						$scada_data = json_decode($content_scada, true);
						$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
						$replytext.="ขอรายงานข้อมูลของแรงสูง 1 (z6) สถานีฟ้าแสง ณ ".$scada_data['DateTimeZ6']." ดังนี้\n";
						$replytext.="1. อัตราการจ่าย สจ.ควนลัง ".$scada_data['Z6HY_FE2_PV']." ลบ.ม./ชม. แรงดัน ".$scada_data['Z6HY_PE2_PV']." บาร์ เลขมาตรขึ้น ".$scada_data['Z6HY_FE2_TOT2']."\n";
						$replytext.="2. อัตราการจ่าย สจ.บ้านพรุ ".$scada_data['Z6HY_FE1_PV']." ลบ.ม./ชม. แรงดัน ".$scada_data['Z6HY_PE1_PV']." บาร์ เลขมาตรขึ้น ".$scada_data['Z6HY_FE1_TOT1']."\n";
						$replytext.="3. ระดับน้ำถังน้ำใสขนาด 3,000 ลบ.ม. คือ ".$scada_data['Z6HY_LE1_VOLUME']." ลบ.ม. หรือ ".$scada_data['Z6HY_LE1_PV']." เมตร\n";
						$replytext.="4. ระดับน้ำถังสูงขนาด 250 ลบ.ม. คือ ".$scada_data['Z6HY_LE2_VOLUME']." ลบ.ม. หรือ ".$scada_data['Z6HY_LE2_PV']." เมตร";
						break;
					case "Z7" :
						$content_scada = file_get_contents('http://118.175.86.109/line/q.php?z=z7');
						$scada_data = json_decode($content_scada, true);
						$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
						$replytext.="ขอรายงานข้อมูลของแรงสูง 2 (z7) สถานีฟ้าแสง ณ ".$scada_data['DateTimeZ7']." ดังนี้\n";
						$replytext.="1. อัตราการจ่ายชุมชน ถ.กาญจนวนิช หาดใหญ่-น้ำน้อย ".$scada_data['Z7HY_FE1_PV']." ลบ.ม./ชม. แรงดัน ".$scada_data['Z7HY_PE1_PV']." บาร์ เลขมาตรขึ้น ".$scada_data['Z7HY_FE1_TOT1']."\n";
						$replytext.="2. อัตราการจ่าย สพ.โคกสูงเส้นเก่า ".$scada_data['Z7HY_FE2_PV']." ลบ.ม./ชม. แรงดัน ".$scada_data['Z7HY_PE2_PV']." บาร์ เลขมาตรขึ้น ".$scada_data['Z7HY_FE2_TOT2']."\n";
						$replytext.="3. ระดับน้ำถังน้ำใสขนาด 6,000 ลบ.ม. คือ ".$scada_data['Z7HY_LE1_VOLUME']." ลบ.ม. หรือ ".$scada_data['Z7HY_LE1_PV']." เมตร";
						break;
					case "Z8" :
						$content_scada = file_get_contents('http://118.175.86.109/line/q.php?z=z8');
						$scada_data = json_decode($content_scada, true);
						$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
						$replytext.="ขอรายงานข้อมูลของแรงสูง 3 (z8) สถานีฟ้าแสง ณ ".$scada_data['DateTimeZ8']." ดังนี้\n";
						$replytext.="1. อัตราการจ่ายหาดใหญ่โซนสูง ".$scada_data['Z8HY_FE1_PV']." ลบ.ม./ชม. แรงดัน ".$scada_data['Z8HY_PE1_PV']." บาร์ เลขมาตรขึ้น ".$scada_data['Z8HY_FE1_TOT1']."\n";
						$replytext.="2. อัตราการจ่ายหาดใหญ่โซนต่ำ ".$scada_data['Z8HY_FE2_PV']." ลบ.ม./ชม. แรงดัน ".$scada_data['Z8HY_PE2_PV']." บาร์ เลขมาตรขึ้น ".$scada_data['Z8HY_FE2_TOT2']."\n";
						$replytext.="3. อัตราการจ่ายสพ.โคกสูงเส้นใหม่ ".$scada_data['Z8HY_FE3_PV']." ลบ.ม./ชม. แรงดัน ".$scada_data['Z8HY_PE3_PV']." บาร์ เลขมาตรขึ้น ".$scada_data['Z8HY_FE3_TOT3']."\n";
						$replytext.="4. ระดับน้ำถังน้ำใสขนาด 3,500 ลบ.ม. คือ ".$scada_data['Z8HY_LE1_VOLUME']." ลบ.ม. หรือ ".$scada_data['Z8HY_LE1_PV']." เมตร";
						
						break;
					case "Z9" :
						$content_scada = file_get_contents('http://118.175.86.109/line/q.php?z=z9');
						$scada_data = json_decode($content_scada, true);
						$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
						$replytext.="ขอรายงานข้อมูลของแรงสูง 4 (z9) สถานีฟ้าแสง ณ ".$scada_data['DateTimeZ9']." ดังนี้\n";
						$replytext.="1. อัตราการจ่าย กปภ.สงขลาผ่านท่อ GRPø800 ตาม ถ.ลพบุรีราเมศร์ ".$scada_data['Z9HY_FE1_PV']." ลบ.ม./ชม. แรงดัน ".$scada_data['Z9HY_PE1_PV']." บาร์ เลขมาตรขึ้น ".$scada_data['Z9HY_FE1_TOT1']."\n";
						$replytext.="2. ระดับน้ำถังน้ำใสขนาด 3,500 ลบ.ม. คือ ".$scada_data['Z9HY_LE1_VOLUME']." ลบ.ม. หรือ ".$scada_data['Z9HY_LE1_PV']." เมตร\n";
						$replytext.="3. คุณภาพน้ำ pH ".$scada_data['Z9HY_PH']." ความขุ่น ".$scada_data['Z9HY_TB']." NTU คลอรีนคงเหลือ ".$scada_data['Z9HY_CL']." mg/l";
											
						break;
					case "Z11" :
						$content_scada = file_get_contents('http://118.175.86.109/line/q.php?z=z11');
						$scada_data = json_decode($content_scada, true);
						$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
						$replytext.="ขอรายงานข้อมูลของสถานีจ่ายน้ำบ้านพรุ (z11) ณ ".$scada_data['DateTimeZ11']." ดังนี้\n";
						$replytext.="1. อัตราการจ่าย ท่อรับ ".$scada_data['Z0HY_DC_BP_FE1_PV']." ลบ.ม./ชม. แรงดัน ".$scada_data['Z0HY_DC_BP_PE1_PV']." บาร์ เลขมาตรขึ้น ".$scada_data['Z0HY_DC_BP_TOT1']."\n";
						$replytext.="2. อัตราการจ่าย ท่อจ่าย ".$scada_data['Z0HY_DC_BP_FE2_PV']." ลบ.ม./ชม. แรงดัน ".$scada_data['Z0HY_DC_BP_PE2_PV']." บาร์ เลขมาตรขึ้น ".$scada_data['Z0HY_DC_BP_TOT2']."\n";
						$replytext.="3. ระดับน้ำถังน้ำใสขนาด 1,000 ลบ.ม. คือ ".$scada_data['Z0HY_DC_BP_LE1_VOLUME']." ลบ.ม. หรือ ".$scada_data['Z0HY_DC_BP_LE1_PV']." เมตร\n";
						$replytext.="4. ระดับน้ำถังสูงขนาด 250 ลบ.ม. คือ ".$scada_data['Z0HY_DC_BP_LE2_VOLUME']." ลบ.ม. หรือ ".$scada_data['Z0HY_DC_BP_LE2_PV']." เมตร\n";
						$replytext.="5. คุณภาพน้ำ คลอรีนคงเหลือ ".$scada_data['Z0HY_DC_BP_CL']." mg/l";
											
						break;
					case "Z12" :
						$content_scada = file_get_contents('http://118.175.86.109/line/q.php?z=z12');
						$scada_data = json_decode($content_scada, true);
						$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
						$replytext.="ขอรายงานข้อมูลของสถานีจ่ายน้ำนาหม่อม (z12) ณ ".$scada_data['DateTimeZ12']." ดังนี้\n";
						$replytext.="1. อัตราการจ่าย ท่อรับ ".$scada_data['Z0HY_DC_NM_FE2_PV']." ลบ.ม./ชม. แรงดัน ".$scada_data['Z0HY_DC_NM_PE1_PV']." บาร์ เลขมาตรขึ้น ".$scada_data['Z0HY_DC_NM_TOT2']."\n";
						$replytext.="2. อัตราการจ่าย ท่อจ่าย ".$scada_data['Z0HY_DC_NM_FE1_PV']." ลบ.ม./ชม. แรงดัน ".$scada_data['Z0HY_DC_NM_PE2_PV']." บาร์ เลขมาตรขึ้น ".$scada_data['Z0HY_DC_NM_TOT1']."\n";
						$replytext.="3. ระดับน้ำถังน้ำใสขนาด 200 ลบ.ม. คือ ".$scada_data['Z0HY_DC_NM_LE1_VOLUME']." ลบ.ม. หรือ ".$scada_data['Z0HY_DC_NM_LE1_PV']." เมตร\n";
						$replytext.="4. ระดับน้ำถังสูงขนาด 100 ลบ.ม. คือ ".$scada_data['Z0HY_DC_NM_LE2_VOLUME']." ลบ.ม. หรือ ".$scada_data['Z0HY_DC_NM_LE2_PV']." เมตร\n";
						$replytext.="5. คุณภาพน้ำ คลอรีนคงเหลือ ".$scada_data['Z0HY_DC_NM_CL']." mg/l";
											
						break;
					default :
				
						$replytext="สวัสดีครับคุณ ".$sourceInfo['displayName']." ผมชื่อ Robot นะครับ\n";
						$replytext.="ในขณะนี้ผมสามารถให้ข้อมูลได้ดังนี้\n";
						$replytext.="1. โรงกรอง 1500 ลบ.ม./ชม. สถานีฟ้าแสง(z3) ให้กรอก robot z3\n";
						$replytext.="2. โรงกรอง 2000 ลบ.ม./ชม. สถานีฟ้าแสง(z4) ให้กรอก robot z4\n";
						$replytext.="3. แรงสูง 1 สถานีฟ้าแสง(z6) ให้กรอก robot z6\n";
						$replytext.="4. แรงสูง 2 สถานีฟ้าแสง(z7) ให้กรอก robot z7\n";
						$replytext.="5. แรงสูง 3 สถานีฟ้าแสง(z8) ให้กรอก robot z8\n";
						$replytext.="6. แรงสูง 4 สถานีฟ้าแสง(z9) ให้กรอก robot z9\n";
						$replytext.="7. สถานีจ่ายน้ำบ้านพรุ(z11) ให้กรอก robot z11\n";
						$replytext.="8. สถานีจ่ายน้ำนาหม่อม(z12) ให้กรอก robot z12";
				}	


				
				// Build message to reply back
				$messages = [
					'type' => 'text',
					'text' =>  $replytext
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

