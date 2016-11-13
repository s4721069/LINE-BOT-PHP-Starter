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
				/*
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
				*/
				if(strtoupper($textArr[1])=="HY")
				{
					switch(strtoupper($textArr[2]))
					{
						case "Z3" :
							$content_scada = file_get_contents('http://118.175.86.109/line/q.php?z=z3');
							$scada_data = json_decode($content_scada, true);
							//$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
							$replytext="ขอรายงานข้อมูลของโรงกรอง 1500 ลบ.ม./ชม.(z3) สถานีฟ้าแสง ณ ".$scada_data['DateTimeZ3']." ดังนี้\n";
							$replytext.="1. ระดับน้ำถังน้ำใสขนาด 3,000 ลบ.ม. คือ ".number_format($scada_data['Z3HY_LE1_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z3HY_LE1_PV'],2)." เมตร\n";
							$replytext.="2. คุณภาพน้ำ pH ".$scada_data['Z3HY_PH']." ความขุ่น ".number_format($scada_data['Z3HY_TB'],2)." NTU คลอรีนคงเหลือ ".number_format($scada_data['Z3HY_CL'],2)." mg/l";
							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
												
							break;
						case "Z4" :
							$content_scada = file_get_contents('http://118.175.86.109/line/q.php?z=z4');
							$scada_data = json_decode($content_scada, true);
							//$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
							$replytext="ขอรายงานข้อมูลของโรงกรอง 2000 ลบ.ม./ชม. (z4) สถานีฟ้าแสง ณ ".$scada_data['DateTimeZ4']." ดังนี้\n";
							$replytext.="1. คุณภาพน้ำ pH ".number_format($scada_data['Z4HY_PH'],2)." ความขุ่น ".number_format($scada_data['Z4HY_TB'],2)." NTU คลอรีนคงเหลือ ".number_format($scada_data['Z4HY_CL'],2)." mg/l";
							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
												
							break;
						case "Z6" :
							$content_scada = file_get_contents('http://118.175.86.109/line/q.php?z=z6');
							$scada_data = json_decode($content_scada, true);
							//$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
							$replytext="ขอรายงานข้อมูลของแรงสูง 1 (z6) สถานีฟ้าแสง ณ ".$scada_data['DateTimeZ6']." ดังนี้\n";
							$replytext.="1. อัตราการจ่าย สจ.ควนลัง ".number_format($scada_data['Z6HY_FE2_PV'],0)." ลบ.ม./ชม. แรงดัน ".number_format($scada_data['Z6HY_PE2_PV'],2)." บาร์ เลขมาตรขึ้น ".$scada_data['Z6HY_FE2_TOT2']."\n";
							$replytext.="2. อัตราการจ่าย สจ.บ้านพรุ ".number_format($scada_data['Z6HY_FE1_PV'],0)." ลบ.ม./ชม. แรงดัน ".number_format($scada_data['Z6HY_PE1_PV'],2)." บาร์ เลขมาตรขึ้น ".$scada_data['Z6HY_FE1_TOT1']."\n";
							$replytext.="3. ระดับน้ำถังน้ำใสขนาด 3,000 ลบ.ม. คือ ".number_format($scada_data['Z6HY_LE1_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z6HY_LE1_PV'],2)." เมตร\n";
							$replytext.="4. ระดับน้ำถังสูงขนาด 250 ลบ.ม. คือ ".number_format($scada_data['Z6HY_LE2_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z6HY_LE2_PV'],2)." เมตร";
							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
							break;
						case "Z7" :
							$content_scada = file_get_contents('http://118.175.86.109/line/q.php?z=z7');
							$scada_data = json_decode($content_scada, true);
							//$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
							$replytext="ขอรายงานข้อมูลของแรงสูง 2 (z7) สถานีฟ้าแสง ณ ".$scada_data['DateTimeZ7']." ดังนี้\n";
							$replytext.="1. อัตราการจ่ายชุมชน ถ.กาญจนวนิช หาดใหญ่-น้ำน้อย ".number_format($scada_data['Z7HY_FE1_PV'],0)." ลบ.ม./ชม. แรงดัน ".number_format($scada_data['Z7HY_PE1_PV'],2)." บาร์ เลขมาตรขึ้น ".$scada_data['Z7HY_FE1_TOT1']."\n";
							$replytext.="2. อัตราการจ่าย สพ.โคกสูงเส้นเก่า ".number_format($scada_data['Z7HY_FE2_PV'],0)." ลบ.ม./ชม. แรงดัน ".number_format($scada_data['Z7HY_PE2_PV'],2)." บาร์ เลขมาตรขึ้น ".$scada_data['Z7HY_FE2_TOT2']."\n";
							$replytext.="3. ระดับน้ำถังน้ำใสขนาด 6,000 ลบ.ม. คือ ".number_format($scada_data['Z7HY_LE1_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z7HY_LE1_PV'],2)." เมตร";
							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
							break;
						case "Z8" :
							$content_scada = file_get_contents('http://118.175.86.109/line/q.php?z=z8');
							$scada_data = json_decode($content_scada, true);
							//$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
							$replytext="ขอรายงานข้อมูลของแรงสูง 3 (z8) สถานีฟ้าแสง ณ ".$scada_data['DateTimeZ8']." ดังนี้\n";
							$replytext.="1. อัตราการจ่ายหาดใหญ่โซนสูง ".number_format($scada_data['Z8HY_FE1_PV'],0)." ลบ.ม./ชม. แรงดัน ".number_format($scada_data['Z8HY_PE1_PV'],2)." บาร์ เลขมาตรขึ้น ".$scada_data['Z8HY_FE1_TOT1']."\n";
							$replytext.="2. อัตราการจ่ายหาดใหญ่โซนต่ำ ".number_format($scada_data['Z8HY_FE2_PV'],0)." ลบ.ม./ชม. แรงดัน ".number_format($scada_data['Z8HY_PE2_PV'],2)." บาร์ เลขมาตรขึ้น ".$scada_data['Z8HY_FE2_TOT2']."\n";
							$replytext.="3. อัตราการจ่ายสพ.โคกสูงเส้นใหม่ ".number_format($scada_data['Z8HY_FE3_PV'],0)." ลบ.ม./ชม. แรงดัน ".number_format($scada_data['Z8HY_PE3_PV'],2)." บาร์ เลขมาตรขึ้น ".$scada_data['Z8HY_FE3_TOT3']."\n";
							$replytext.="4. ระดับน้ำถังน้ำใสขนาด 3,500 ลบ.ม. คือ ".number_format($scada_data['Z8HY_LE1_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z8HY_LE1_PV'],2)." เมตร";
							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
							
							break;
						case "Z9" :
							$content_scada = file_get_contents('http://118.175.86.109/line/q.php?z=z9');
							$scada_data = json_decode($content_scada, true);
							//$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
							$replytext="ขอรายงานข้อมูลของแรงสูง 4 (z9) สถานีฟ้าแสง ณ ".$scada_data['DateTimeZ9']." ดังนี้\n";
							$replytext.="1. อัตราการจ่าย กปภ.สงขลาผ่านท่อ GRPø800 ตาม ถ.ลพบุรีราเมศร์ ".number_format($scada_data['Z9HY_FE1_PV'],0)." ลบ.ม./ชม. แรงดัน ".number_format($scada_data['Z9HY_PE1_PV'],2)." บาร์ เลขมาตรขึ้น ".$scada_data['Z9HY_FE1_TOT1']."\n";
							$replytext.="2. ระดับน้ำถังน้ำใสขนาด 3,500 ลบ.ม. คือ ".number_format($scada_data['Z9HY_LE1_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z9HY_LE1_PV'],2)." เมตร\n";
							$replytext.="3. คุณภาพน้ำ pH ".number_format($scada_data['Z9HY_PH'],2)." ความขุ่น ".number_format($scada_data['Z9HY_TB'],2)." NTU คลอรีนคงเหลือ ".number_format($scada_data['Z9HY_CL'],2)." mg/l";
							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
												
							break;
						case "Z11" :
							$content_scada = file_get_contents('http://118.175.86.109/line/q.php?z=z11');
							$scada_data = json_decode($content_scada, true);
							//$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
							$replytext="ขอรายงานข้อมูลของสถานีจ่ายน้ำบ้านพรุ (z11) ณ ".$scada_data['DateTimeZ11']." ดังนี้\n";
							$replytext.="1. อัตราการจ่าย ท่อรับ ".number_format($scada_data['Z0HY_DC_BP_FE1_PV'],0)." ลบ.ม./ชม. แรงดัน ".number_format($scada_data['Z0HY_DC_BP_PE1_PV'],2)." บาร์ เลขมาตรขึ้น ".$scada_data['Z0HY_DC_BP_TOT1']."\n";
							$replytext.="2. อัตราการจ่าย ท่อจ่าย ".number_format($scada_data['Z0HY_DC_BP_FE2_PV'],0)." ลบ.ม./ชม. แรงดัน ".number_format($scada_data['Z0HY_DC_BP_PE2_PV'],2)." บาร์ เลขมาตรขึ้น ".$scada_data['Z0HY_DC_BP_TOT2']."\n";
							$replytext.="3. ระดับน้ำถังน้ำใสขนาด 1,000 ลบ.ม. คือ ".number_format($scada_data['Z0HY_DC_BP_LE1_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z0HY_DC_BP_LE1_PV'],2)." เมตร\n";
							$replytext.="4. ระดับน้ำถังสูงขนาด 250 ลบ.ม. คือ ".number_format($scada_data['Z0HY_DC_BP_LE2_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z0HY_DC_BP_LE2_PV'],2)." เมตร\n";
							$replytext.="5. คุณภาพน้ำ คลอรีนคงเหลือ ".number_format($scada_data['Z0HY_DC_BP_CL'],2)." mg/l";
							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
												
							break;
						case "Z12" :
							$content_scada = file_get_contents('http://118.175.86.109/line/q.php?z=z12');
							$scada_data = json_decode($content_scada, true);
							//$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
							$replytext="ขอรายงานข้อมูลของสถานีจ่ายน้ำนาหม่อม (z12) ณ ".$scada_data['DateTimeZ12']." ดังนี้\n";
							$replytext.="1. อัตราการจ่าย ท่อรับ ".number_format($scada_data['Z0HY_DC_NM_FE2_PV'],0)." ลบ.ม./ชม. แรงดัน ".number_format($scada_data['Z0HY_DC_NM_PE1_PV'],2)." บาร์ เลขมาตรขึ้น ".$scada_data['Z0HY_DC_NM_TOT2']."\n";
							$replytext.="2. อัตราการจ่าย ท่อจ่าย ".number_format($scada_data['Z0HY_DC_NM_FE1_PV'],0)." ลบ.ม./ชม. แรงดัน ".number_format($scada_data['Z0HY_DC_NM_PE2_PV'],2)." บาร์ เลขมาตรขึ้น ".$scada_data['Z0HY_DC_NM_TOT1']."\n";
							$replytext.="3. ระดับน้ำถังน้ำใสขนาด 200 ลบ.ม. คือ ".number_format($scada_data['Z0HY_DC_NM_LE1_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z0HY_DC_NM_LE1_PV'],2)." เมตร\n";
							$replytext.="4. ระดับน้ำถังสูงขนาด 100 ลบ.ม. คือ ".number_format($scada_data['Z0HY_DC_NM_LE2_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z0HY_DC_NM_LE2_PV'],2)." เมตร\n";
							$replytext.="5. คุณภาพน้ำ คลอรีนคงเหลือ ".number_format($scada_data['Z0HY_DC_NM_CL'],2)." mg/l";
							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
												
							break;
						case "Z13" :
							$content_scada = file_get_contents('http://118.175.86.109/line/q.php?z=z13');
							$scada_data = json_decode($content_scada, true);
							//$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
							$replytext="ขอรายงานข้อมูลของสถานีเพิ่มแรงดันนาหม่อม (z13) ณ ".$scada_data['DateTimeZ13']." ดังนี้\n";
							$replytext.="1. แรงดันขาเข้า ".number_format($scada_data['Z0HY_DC_BT_PE1_PV'],2)." บาร์ แรงดันขาออก ".number_format($scada_data['Z0HY_DC_BT_PE2_PV'],2)." บาร์";
							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
												
							break;
						case "Z14" :
							$content_scada = file_get_contents('http://118.175.86.109/line/q.php?z=z14');
							$scada_data = json_decode($content_scada, true);
							//$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
							$replytext="ขอรายงานข้อมูลของสถานีจ่ายน้ำควนลัง (z14) ณ ".$scada_data['DateTimeZ14']." ดังนี้\n";
							$replytext.="1. อัตราการจ่าย ท่อจ่าย ".number_format($scada_data['Z14KL_FE1_PV'],0)." ลบ.ม./ชม. แรงดัน ".number_format($scada_data['Z14KL_PE1_PV'],2)." บาร์ เลขมาตรขึ้น ".$scada_data['Z14KL_FE1_TOT']."\n";
							$replytext.="2. ระดับน้ำถังน้ำใสขนาด 1500 ลบ.ม. คือ ".number_format($scada_data['Z14KL_LE2_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z14KL_LE2_PV'],2)." เมตร\n";
							$replytext.="3. ระดับน้ำถังสูงขนาด 300 ลบ.ม. คือ ".number_format($scada_data['Z14KL_LE1_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z14KL_LE1_PV'],2)." เมตร";
							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
												
							break;
						case "WQ" :
							$content_scada = file_get_contents('http://118.175.86.109/line/wq.php');
							$scada_data = json_decode($content_scada, true);
							$replytext1="คุณภาพน้ำของโรงกรอง 1500 ลบ.ม./ชม. (Z3) ณ ".$scada_data['DateTimeZ3']." ดังนี้\n";
							$replytext1.="ความขุ่น ".number_format($scada_data['Z3HY_TB'],2)." NTU\n";
							$replytext1.="pH ".number_format($scada_data['Z3HY_PH'],2)."\n";
							$replytext1.="Residual Chlorine ".number_format($scada_data['Z3HY_CL'],2)." mg/l";
							$replytext2="คุณภาพน้ำของโรงกรอง 2000 ลบ.ม./ชม. (Z4) ณ ".$scada_data['DateTimeZ4']." ดังนี้\n";
							$replytext2.="ความขุ่น ".number_format($scada_data['Z4HY_TB'],2)." NTU\n";
							$replytext2.="pH ".number_format($scada_data['Z4HY_PH'],2)."\n";
							$replytext2.="Residual Chlorine ".number_format($scada_data['Z4HY_CL'],2)." mg/l";
							$replytext3="คุณภาพน้ำของแรงสูง 4 (Z9) ณ ".$scada_data['DateTimeZ9']." ดังนี้\n";
							$replytext3.="ความขุ่น ".number_format($scada_data['Z9HY_TB'],2)." NTU\n";
							$replytext3.="pH ".number_format($scada_data['Z9HY_PH'],2)."\n";
							$replytext3.="Residual Chlorine ".number_format($scada_data['Z9HY_CL'],2)." mg/l";
							$replytext4="คุณภาพน้ำของสถานีจ่ายน้ำบ้านพรุ (Z11) ณ ".$scada_data['DateTimeZ11']." ดังนี้\n";
							$replytext4.="Residual Chlorine ".number_format($scada_data['Z0HY_DC_BP_CL'],2)." mg/l";
							$replytext5="คุณภาพน้ำของสถานีจ่ายน้ำนาหม่อม (Z12) ณ ".$scada_data['DateTimeZ12']." ดังนี้\n";
							$replytext5.="Residual Chlorine ".number_format($scada_data['Z0HY_DC_NM_CL'],2)." mg/l";
							$messages = [[
									'type' => 'text',
									'text' =>  $replytext1
								],
								[
									'type' => 'text',
									'text' =>  $replytext2
								],
								[
									'type' => 'text',
									'text' =>  $replytext3
								],
								[
									'type' => 'text',
									'text' =>  $replytext4
								],
								[
									'type' => 'text',
									'text' =>  $replytext5
								]];
												
							break;
						case "VOLUME" :
							$content_scada = file_get_contents('http://118.175.86.109/line/volume.php');
							$scada_data = json_decode($content_scada, true);
							$percentZ3HY_LE1_VOLUME=number_format($scada_data['Z3HY_LE1_VOLUME']/3000*100,2);
							$percentZ6HY_LE1_VOLUME=number_format($scada_data['Z6HY_LE1_VOLUME']/3000*100,2);
							$percentZ6HY_LE2_VOLUME=number_format($scada_data['Z6HY_LE2_VOLUME']/250*100,2);
							$percentZ7HY_LE1_VOLUME=number_format($scada_data['Z7HY_LE1_VOLUME']/6000*100,2);
							$percentZ8HY_LE1_VOLUME=number_format($scada_data['Z8HY_LE1_VOLUME']/3500*100,2);
							$percentZ9HY_LE1_VOLUME=number_format($scada_data['Z9HY_LE1_VOLUME']/3500*100,2);
							$percentZ0HY_DC_BP_LE1_VOLUME=number_format($scada_data['Z0HY_DC_BP_LE1_VOLUME']/1000*100,2);
							$percentZ0HY_DC_BP_LE2_VOLUME=number_format($scada_data['Z0HY_DC_BP_LE2_VOLUME']/250*100,2);
							$percentZ0HY_DC_NM_LE1_VOLUME=number_format($scada_data['Z0HY_DC_NM_LE1_VOLUME']/200*100,2);
							$percentZ0HY_DC_NM_LE2_VOLUME=number_format($scada_data['Z0HY_DC_NM_LE2_VOLUME']/100*100,2);
							$percentZ14KL_LE2_VOLUME=number_format($scada_data['Z14KL_LE2_VOLUME']/1500*100,2);
							$percentZ14KL_LE1_VOLUME=number_format($scada_data['Z14KL_LE1_VOLUME']/300*100,2);
							$replytext1="ปริมาณน้ำ ณ ".$scada_data['DateTimeZ3']."\n";
							$replytext1.="-ถังน้ำใสขนาด 3,000 ลบ.ม. (Z3)  คือ ".number_format($scada_data['Z3HY_LE1_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ3HY_LE1_VOLUME." %\n";
							$replytext1.="-ถังน้ำใสขนาด 3,000 ลบ.ม. (Z6) คือ ".number_format($scada_data['Z6HY_LE1_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ6HY_LE1_VOLUME." %\n";
							$replytext1.="-ถังสูงขนาด 250 ลบ.ม. (Z6) คือ ".number_format($scada_data['Z6HY_LE2_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ6HY_LE2_VOLUME." %\n";
							$replytext1.="-ถังน้ำใสขนาด 6,000 ลบ.ม. (Z7) คือ ".number_format($scada_data['Z7HY_LE1_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ7HY_LE1_VOLUME." %\n";
							$replytext1.="-ถังน้ำใสขนาด 3,500 ลบ.ม. (Z8) คือ ".number_format($scada_data['Z8HY_LE1_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ8HY_LE1_VOLUME." %\n";
							$replytext1.="-ถังน้ำใสขนาด 3,500 ลบ.ม. (Z9) คือ ".number_format($scada_data['Z9HY_LE1_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ9HY_LE1_VOLUME." %\n";
							$replytext1.="-ถังน้ำใสขนาด 1,000 ลบ.ม. สถานีจ่ายน้ำบ้านพรุ (Z11) คือ ".number_format($scada_data['Z0HY_DC_BP_LE1_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ0HY_DC_BP_LE1_VOLUME." %\n";
							$replytext1.="-ถังสูงขนาด 250 ลบ.ม. สถานีจ่ายน้ำบ้านพรุ (Z11) คือ ".number_format($scada_data['Z0HY_DC_BP_LE2_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ0HY_DC_BP_LE2_VOLUME." %\n";
							$replytext1.="-ถังน้ำใสขนาด 200 ลบ.ม. สถานีจ่ายน้ำนาหม่อม (Z12) คือ ".number_format($scada_data['Z0HY_DC_NM_LE1_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ0HY_DC_NM_LE1_VOLUME." %\n";
							$replytext1.="-ถังสูงขนาด 100 ลบ.ม. สถานีจ่ายน้ำนาหม่อม (Z12) คือ ".number_format($scada_data['Z0HY_DC_NM_LE2_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ0HY_DC_NM_LE2_VOLUME." %\n";
							$replytext1.="-ถังน้ำใสขนาด 1500 ลบ.ม. สถานีจ่ายน้ำควนลัง คือ ".number_format($scada_data['Z14KL_LE2_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ14KL_LE2_VOLUME." %\n";
							$replytext1.="-ถังสูงขนาด 300 ลบ.ม. สถานีจ่ายน้ำควนลัง คือ ".number_format($scada_data['Z14KL_LE1_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ14KL_LE1_VOLUME." %";
							$messages = [[
									'type' => 'text',
									'text' =>  $replytext1
								]];
												
							break;
						case "TELE" :
							$content_scada = file_get_contents('http://118.175.86.109/line/tele.php?id=HY_01');
							$scada_data = json_decode($content_scada, true);
						    $replytext1="ข้อมูลสถานีตรวจวัดน้ำดิบ สถานีหาดใหญ่ อัพเดทล่าสุด ".$scada_data['tele_lastdatatime']."\n";
						    $replytext1.="- pH ".$scada_data['tele_ph']."\n";
						    $replytext1.="- DO ".$scada_data['tele_do']." mg/L\n";
						    $replytext1.="- Turbidity ".$scada_data['tele_tb']." NTU\n";
						    $replytext1.="- การนำไฟฟ้า ".$scada_data['tele_ec']." uS/cm\n";
						    $replytext1.="- ความเค็ม ".$scada_data['tele_salinity']." g/L\n";
						    $replytext1.="- รีดอกซ์ ".$scada_data['tele_orp']." mV\n";
						    $replytext1.="- อุณหภูมิ ".$scada_data['tele_temp']." °C\n";
						    $replytext1.="- ระดับน้ำ ".$scada_data['tele_level']." ม.รทก.";
						    $content_scada = file_get_contents('http://118.175.86.109/line/tele.php?id=Q08');
							$scada_data = json_decode($content_scada, true);
						    $replytext2="ข้อมูลสถานีตรวจวัดน้ำดิบ สถานีบางศาลา อัพเดทล่าสุด ".$scada_data['tele_lastdatatime']."\n";
						    $replytext2.="- pH ".$scada_data['tele_ph']."\n";
						    $replytext2.="- DO ".$scada_data['tele_do']." mg/L\n";
						    $replytext2.="- Turbidity ".$scada_data['tele_tb']." NTU\n";
						    $replytext2.="- การนำไฟฟ้า ".$scada_data['tele_ec']." uS/cm\n";
						    $replytext2.="- ความเค็ม ".$scada_data['tele_salinity']." g/L\n";
						    $replytext2.="- รีดอกซ์ ".$scada_data['tele_orp']." mV\n";
						    $replytext2.="- อุณหภูมิ ".$scada_data['tele_temp']." °C\n";
						    $replytext2.="- ระดับน้ำ ".$scada_data['tele_level']." ม.รทก.";
						    $content_scada = file_get_contents('http://118.175.86.109/line/tele.php?id=2Q06');
							$scada_data = json_decode($content_scada, true);
						    $replytext3="ข้อมูลสถานีตรวจวัดน้ำดิบ สถานีพังลา อัพเดทล่าสุด ".$scada_data['tele_lastdatatime']."\n";
						    $replytext3.="- pH ".$scada_data['tele_ph']."\n";
						    $replytext3.="- DO ".$scada_data['tele_do']." mg/L\n";
						    $replytext3.="- Turbidity ".$scada_data['tele_tb']." NTU\n";
						    $replytext3.="- การนำไฟฟ้า ".$scada_data['tele_ec']." uS/cm\n";
						    $replytext3.="- ความเค็ม ".$scada_data['tele_salinity']." g/L\n";
						    $replytext3.="- รีดอกซ์ ".$scada_data['tele_orp']." mV\n";
						    $replytext3.="- อุณหภูมิ ".$scada_data['tele_temp']." °C\n";
						    $replytext3.="- ระดับน้ำ ".$scada_data['tele_level']." ม.รทก.";
						    $messages = [[
									'type' => 'text',
									'text' =>  $replytext1
								],[
									'type' => 'text',
									'text' =>  $replytext2
								],[
									'type' => 'text',
									'text' =>  $replytext3
								]];

							break;
						case "FLOOD" :
							if(strtoupper($textArr[3])=="UPT10")
							{
								$content_scada = file_get_contents('http://118.175.86.109/line/flood.php?basin=UPT&s=UPT10');
								$scada_data = json_decode($content_scada, true);
							    $replytext1="ข้อมูลสถานี".$scada_data['flood_name']."\n";
							    $replytext1.="เมื่อ ".$scada_data['flood_lastdatatime']."\n";
							    $replytext1.="-ระดับน้ำ ".$scada_data['flood_level']." ม.รทก. (".$scada_data['flood_status'].")\n";
							    $replytext1.="-ระดับน้ำต่ำกว่าตลิ่งซ้าย ".$scada_data['flood_left']." ม.\n";
							    $replytext1.="-ระดับน้ำต่ำกว่าตลิ่งขวา ".$scada_data['flood_right']." ม.";
							    resize($scada_data['flood_image'],"thumb_utp10.jpg",240);
							    resize($scada_data['flood_image'],"utp10.jpg",1024);
							    $replytext2="ที่มา : http://www.southwarning.com/flood/monitor/main?basin=UPT&s=UPT10";
							    
							    $messages = [[
										'type' => 'text',
										'text' =>  $replytext1
									],[
										'type' => 'location',
										'title' =>  'ที่ตั้งสถานี'.$scada_data['flood_name'],
										'address' =>  $scada_data['flood_address'],
										'latitude' =>  $scada_data['flood_lat'],
										'longitude' =>  $scada_data['flood_long']
									],[
										'type' => 'image',
										'originalContentUrl' =>  'https://immense-lake-22116.herokuapp.com/utp10.jpg',
										'previewImageUrl' =>  'https://immense-lake-22116.herokuapp.com/thumb_utp10.jpg'
									],[
										'type' => 'text',
										'text' =>  $replytext2
									]];
							}
							elseif (strtoupper($textArr[3])=="UPT20") 
							{
								$content_scada = file_get_contents('http://118.175.86.109/line/flood.php?basin=UPT&s=UPT20');
								$scada_data = json_decode($content_scada, true);
							    $replytext1="ข้อมูลสถานี".$scada_data['flood_name']."\n";
							    $replytext1.="เมื่อ ".$scada_data['flood_lastdatatime']."\n";
							    $replytext1.="-ระดับน้ำ ".$scada_data['flood_level']." ม.รทก. (".$scada_data['flood_status'].")\n";
							    $replytext1.="-ระดับน้ำต่ำกว่าตลิ่งซ้าย ".$scada_data['flood_left']." ม.\n";
							    $replytext1.="-ระดับน้ำต่ำกว่าตลิ่งขวา ".$scada_data['flood_right']." ม.";
							    resize($scada_data['flood_image'],"thumb_utp20.jpg",240);
							    resize($scada_data['flood_image'],"utp20.jpg",1024);
							    $replytext2="ที่มา : http://www.southwarning.com/flood/monitor/main?basin=UPT&s=UPT20";
							    
							    $messages = [[
										'type' => 'text',
										'text' =>  $replytext1
									],[
										'type' => 'location',
										'title' =>  'ที่ตั้งสถานี'.$scada_data['flood_name'],
										'address' =>  $scada_data['flood_address'],
										'latitude' =>  $scada_data['flood_lat'],
										'longitude' =>  $scada_data['flood_long']
									],[
										'type' => 'image',
										'originalContentUrl' =>  'https://immense-lake-22116.herokuapp.com/utp20.jpg',
										'previewImageUrl' =>  'https://immense-lake-22116.herokuapp.com/thumb_utp20.jpg'
									],[
										'type' => 'text',
										'text' =>  $replytext2
									]];
							}
							elseif (strtoupper($textArr[3])=="UPT30") 
							{
								$content_scada = file_get_contents('http://118.175.86.109/line/flood.php?basin=UPT&s=UPT30');
								$scada_data = json_decode($content_scada, true);
							    $replytext1="ข้อมูลสถานี".$scada_data['flood_name']."\n";
							    $replytext1.="เมื่อ ".$scada_data['flood_lastdatatime']."\n";
							    $replytext1.="-ระดับน้ำ ".$scada_data['flood_level']." ม.รทก. (".$scada_data['flood_status'].")\n";
							    $replytext1.="-ระดับน้ำต่ำกว่าตลิ่งซ้าย ".$scada_data['flood_left']." ม.\n";
							    $replytext1.="-ระดับน้ำต่ำกว่าตลิ่งขวา ".$scada_data['flood_right']." ม.";
							    resize($scada_data['flood_image'],"thumb_utp30.jpg",240);
							    resize($scada_data['flood_image'],"utp30.jpg",1024);
							    $replytext2="ที่มา : http://www.southwarning.com/flood/monitor/main?basin=UPT&s=UPT30";
							    
							    $messages = [[
										'type' => 'text',
										'text' =>  $replytext1
									],[
										'type' => 'location',
										'title' =>  'ที่ตั้งสถานี'.$scada_data['flood_name'],
										'address' =>  $scada_data['flood_address'],
										'latitude' =>  $scada_data['flood_lat'],
										'longitude' =>  $scada_data['flood_long']
									],[
										'type' => 'image',
										'originalContentUrl' =>  'https://immense-lake-22116.herokuapp.com/utp30.jpg',
										'previewImageUrl' =>  'https://immense-lake-22116.herokuapp.com/thumb_utp30.jpg'
									],[
										'type' => 'text',
										'text' =>  $replytext2
									]];
							}
							else
							{
								$replytext="ในขณะนี้ผมสามารถให้ข้อมูลระบบประเมินสถานการณ์เพื่อการเตือนภัยน้ำท่วม จังหวัดสงขลา ได้ดังนี้\n";
								$replytext.="1. สถานีบ้านหาดใหญ่ใน ให้กรอก robot hy flood upt10\n";
								$replytext.="2. สถานีสะพานบ้านบางศาลา ให้กรอก robot hy flood upt20\n";
								$replytext.="3. สถานีสะพานวัดม่วงก็อง ให้กรอก robot hy flood upt30";
								$messages = [[
									'type' => 'text',
									'text' =>  $replytext
									]];
							}
							break; 
						
						default :
					
							//$replytext="สวัสดีครับ ".$sourceInfo['displayName']." ผมชื่อ Robot นะครับ\n";
							$replytext="ในขณะนี้ผมสามารถให้ข้อมูลของสาขาหาดใหญ่ได้ดังนี้\n";
							$replytext.="1. โรงกรอง 1500 ลบ.ม./ชม. สถานีฟ้าแสง(z3) ให้กรอก robot hy z3\n";
							$replytext.="2. โรงกรอง 2000 ลบ.ม./ชม. สถานีฟ้าแสง(z4) ให้กรอก robot hy z4\n";
							$replytext.="3. แรงสูง 1 สถานีฟ้าแสง(z6) ให้กรอก robot hy z6\n";
							$replytext.="4. แรงสูง 2 สถานีฟ้าแสง(z7) ให้กรอก robot hy z7\n";
							$replytext.="5. แรงสูง 3 สถานีฟ้าแสง(z8) ให้กรอก robot hy z8\n";
							$replytext.="6. แรงสูง 4 สถานีฟ้าแสง(z9) ให้กรอก robot hy z9\n";
							$replytext.="7. สถานีจ่ายน้ำบ้านพรุ(z11) ให้กรอก robot hy z11\n";
							$replytext.="8. สถานีจ่ายน้ำนาหม่อม(z12) ให้กรอก robot hy z12\n";
							$replytext.="9. Booster Pump นาหม่อม(z13) ให้กรอก robot hy z13\n";
							$replytext.="10. สถานีจ่ายน้ำควนลัง(z14) ให้กรอก robot hy z14\n";
							$replytext.="11. คุณภาพน้ำ ให้กรอก robot hy wq\n";
							$replytext.="12. ปริมาณน้ำ ให้กรอก robot hy volume\n";
							$replytext.="13. สถานีตรวจวัดน้ำดิบ ให้กรอก robot hy tele\n";
							$replytext.="14. ระบบประเมินสถานการณ์เพื่อการเตือนภัยน้ำท่วม ให้กรอก robot hy flood";
							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
					}	
				}

				elseif(strtoupper($textArr[1])=="SK")
				{
					switch(strtoupper($textArr[2]))
					{
						case "JORM" :
							$content_scada = file_get_contents('http://118.175.86.109/line/q_sk.php?z=Jorm');
							$scada_data = json_decode($content_scada, true);
							$percentLe1=number_format($scada_data['Z1SK_LE1_VOLUME']/12000*100,2);
							//$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
							$replytext="ปริมาณน้ำวันที่ ".$scada_data['DateTime']."\n";
							$replytext.="- ปริมาณน้ำถังน้ำใสสงขลาขนาด 12,000 ลบ.ม. ".$percentLe1."% คือ ".number_format($scada_data['Z1SK_LE1_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z1SK_LE1_AINPUT_PV'],2)." เมตร อัตราการจ่ายเข้าเมือง ".number_format($scada_data['Z1SK_FE2_AINPUT_PV'],0)." ลบ.ม./ชม. แรงดัน ".number_format($scada_data['Z1SK_PE2_AINPUT_PV'],2)." บาร์\n";
							$replytext.="- ปริมาณน้ำถังน้ำใสเขาสำโรงขนาด 12,600 ลบ.ม. คือ ".number_format($scada_data['Z2SK_LE1_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z2SK_LE1_AINPUT_PV'],2)." เมตร\n";
							$replytext.="- ปริมาณน้ำถังน้ำใสโคกสูงขนาด 7,000 ลบ.ม. คือ ".number_format($scada_data['Z3NN_LE1_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z3NN_LE1_AINPUT_PV'],2)." เมตร";
							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];					
							break;
						case "Z1" : $content_scada = file_get_contents('http://118.175.86.109/line/q_sk.php?z=z1');

							$tmp=file_get_contents('http://118.175.86.109/line/pumprun.php?z=z1sk');
							file_put_contents("z1sk.jpg", fopen("http://118.175.86.109/line/z1sk.jpg", 'r'));
							resize("z1sk.jpg","thumb_z1sk.jpg",240);
							$scada_data = json_decode($content_scada, true);
							$percentLe1=number_format($scada_data['Z1SK_LE1_VOLUME']/12000*100,2);
							//$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
							$replytext1="ข้อมูลโรงสูบน้ำสำนักงาน สงขลา ณ ".$scada_data['DateTime'];
							$replytext2="ระดับน้ำในถังเก็บ\n";
							$replytext2.="-ปริมาณน้ำถังน้ำใสสงขลาขนาด 12,000 ลบ.ม. คือ ".number_format($scada_data['Z1SK_LE1_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z1SK_LE1_AINPUT_PV'],2)." เมตร คิดเป็น ".$percentLe1."%";
							$replytext3="อัตราการจ่าย\n";
							$replytext3.="-จ่ายเข้าเมือง ".number_format($scada_data['Z1SK_FE2_AINPUT_PV'],0)." ลบ.ม./ชม.\n";
							$replytext3.="-จ่ายขึ้นเขาสำโรง ".number_format($scada_data['Z1SK_FE1_AINPUT_PV'],0)." ลบ.ม./ชม.\n";
							$replytext3.="-รับน้ำลงถังน้ำใส ".number_format($scada_data['Z1SK_FE3_AINPUT_PV'],0)." ลบ.ม./ชม.";
							$replytext4="แรงดันในเส้นท่อ\n";
							$replytext4.="-แรงดันจ่ายเข้าเมือง ".number_format($scada_data['Z1SK_PE2_AINPUT_PV'],2)." บาร์\n";
							$replytext4.="-แรงดันจ่ายขึ้นเขาสำโรง ".number_format($scada_data['Z1SK_PE1_AINPUT_PV'],2)." บาร์";
							$messages = [[
									'type' => 'text',
									'text' =>  $replytext1
								],
								[
									'type' => 'text',
									'text' =>  $replytext2
								],
								[
									'type' => 'text',
									'text' =>  $replytext3
								],
								[
									'type' => 'text',
									'text' =>  $replytext4
								],
								[
									'type' => 'image',
									'originalContentUrl' =>  'https://immense-lake-22116.herokuapp.com/z1sk.jpg',
									'previewImageUrl' =>  'https://immense-lake-22116.herokuapp.com/thumb_z1sk.jpg'
								]];
							break;
						case "Z2" :$content_scada = file_get_contents('http://118.175.86.109/line/q_sk.php?z=z2');
							$scada_data = json_decode($content_scada, true);
							$percentLe1=number_format($scada_data['Z2SK_LE1_VOLUME']/12600*100,2);
							//$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
							$replytext1="ข้อมูลถังน้ำใสเขาสำโรง ณ ".$scada_data['DateTime'];
							$replytext2="ระดับน้ำในถังเก็บ\n";
							$replytext2.="-ปริมาณน้ำถังน้ำใสเขาสำโรงขนาด 12,600 ลบ.ม. คือ ".number_format($scada_data['Z2SK_LE1_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z2SK_LE1_AINPUT_PV'],2)." เมตร คิดเป็น ".$percentLe1."%";
							$messages = [[
									'type' => 'text',
									'text' =>  $replytext1
								],
								[
									'type' => 'text',
									'text' =>  $replytext2
								]];
							break;
						case "Z3" :$content_scada = file_get_contents('http://118.175.86.109/line/q_sk.php?z=z3');
							$tmp=file_get_contents('http://118.175.86.109/line/pumprun.php?z=z3nn');
							file_put_contents("z3nn.jpg", fopen("http://118.175.86.109/line/z3nn.jpg", 'r'));
							resize("z3nn.jpg","thumb_z3nn.jpg",240);
							$scada_data = json_decode($content_scada, true);
							$percentLe1=number_format($scada_data['Z3NN_LE1_VOLUME']/7000*100,2);
							$percentLe2=number_format($scada_data['Z3NN_LE2_VOLUME']/250*100,2);
							//$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
							$replytext1="ข้อมูลสถานีเพิ่มแรงดันโคกสูง ณ ".$scada_data['DateTime'];
							$replytext2="ระดับน้ำในถังเก็บ\n";
							$replytext2.="-ปริมาณน้ำถังน้ำใสโคกสูงขนาด 7,000 ลบ.ม. คือ ".number_format($scada_data['Z3NN_LE1_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z3NN_LE1_AINPUT_PV'],2)." เมตร คิดเป็น ".$percentLe1."%\n";
							$replytext2.="-ปริมาณน้ำถังสูงโคกสูงขนาด 250 ลบ.ม. คือ ".number_format($scada_data['Z3NN_LE2_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z3NN_LE2_AINPUT_PV'],2)." เมตร คิดเป็น ".$percentLe2."%";
							$replytext3="อัตราการจ่าย\n";
							$replytext3.="-จ่ายลงถังน้ำใสสงขลา ".number_format($scada_data['Z3NN_FE1_AINPUT_PV'],0)." ลบ.ม./ชม.\n";
							$replytext3.="-จ่ายพื้นที่โซนสูง ".number_format($scada_data['Z3NN_FE2_AINPUT_PV'],0)." ลบ.ม./ชม.\n";
							$replytext3.="-รับน้ำลงถังน้ำใส ".number_format($scada_data['Z3NN_FE4_AINPUT_PV'],0)." ลบ.ม./ชม.";
							$replytext4="แรงดันในเส้นท่อ\n";
							$replytext4.="-แรงดันจ่ายลงถังน้ำใสสงขลา ".number_format($scada_data['Z3NN_PE1_AINPUT_PV'],2)." บาร์\n";
							$replytext4.="-แรงดันจ่ายจ่ายพื้นที่โซนสูง ".number_format($scada_data['Z3NN_PE2_AINPUT_PV'],2)." บาร์\n";
							$replytext4.="-แรงดันจ่ายสิงหนคร ".number_format($scada_data['Z3NN_PE3_AINPUT_PV'],2)." บาร์";
							$messages = [[
									'type' => 'text',
									'text' =>  $replytext1
								],
								[
									'type' => 'text',
									'text' =>  $replytext2
								],
								[
									'type' => 'text',
									'text' =>  $replytext3
								],
								[
									'type' => 'text',
									'text' =>  $replytext4
								],
								[
									'type' => 'image',
									'originalContentUrl' =>  'https://immense-lake-22116.herokuapp.com/z3nn.jpg',
									'previewImageUrl' =>  'https://immense-lake-22116.herokuapp.com/thumb_z3nn.jpg'
								]];
							break;
						case "Z4" :$content_scada = file_get_contents('http://118.175.86.109/line/q_sk.php?z=z4');
							$tmp=file_get_contents('http://118.175.86.109/line/pumprun.php?z=z4th');
							file_put_contents("z4th.jpg", fopen("http://118.175.86.109/line/z4th.jpg", 'r'));
							resize("z4th.jpg","thumb_z4th.jpg",240);
							$scada_data = json_decode($content_scada, true);
							$percentLe1=number_format($scada_data['Z4TH_LE1_VOLUME']/4000*100,2);
							//$replytext="ตอบคุณ ".$sourceInfo['displayName']."\n";
							$replytext1="ข้อมูลสถานีเพิ่มแรงดันท่านางหอม ณ ".$scada_data['DateTime'];
							$replytext2="ระดับน้ำในถังเก็บ\n";
							$replytext2.="-ปริมาณน้ำถังน้ำใสท่านางหอมขนาด 4,000 ลบ.ม. คือ ".number_format($scada_data['Z4TH_LE1_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z4TH_LE1_AINPUT_PV'],2)." เมตร คิดเป็น ".$percentLe1."%";
							$replytext3="อัตราการจ่าย\n";
							$replytext3.="-จ่ายสิงหนคร ".number_format($scada_data['Z4TH_FE3_AINPUT_PV'],0)." ลบ.ม./ชม.\n";
							$replytext3.="-รับน้ำท่อ GRPø800 ".number_format($scada_data['Z4TH_FE1_AINPUT_PV'],0)." ลบ.ม./ชม.\n";
							$replytext3.="-ับน้ำท่อ PEø630 ".number_format($scada_data['Z4TH_FE2_AINPUT_PV'],0)." ลบ.ม./ชม.";
							$replytext4="แรงดันในเส้นท่อ\n";
							$replytext4.="-แรงดันจ่ายสิงหนคร ".number_format($scada_data['Z4TH_PE2_AINPUT_PV'],2)." บาร์";
							$messages = [[
									'type' => 'text',
									'text' =>  $replytext1
								],
								[
									'type' => 'text',
									'text' =>  $replytext2
								],
								[
									'type' => 'text',
									'text' =>  $replytext3
								],
								[
									'type' => 'text',
									'text' =>  $replytext4
								],
								[
									'type' => 'image',
									'originalContentUrl' =>  'https://immense-lake-22116.herokuapp.com/z4th.jpg',
									'previewImageUrl' =>  'https://immense-lake-22116.herokuapp.com/thumb_z4th.jpg'
								]];
							break;
						case "DMA" :
							$wwcode='5552011';
							if(strlen($textArr[3])>0)
							{
								$Latitude="";
								$Longitude="";
								$device_name="";
								$sensor_Flow_LatestValue="";
								$sensor_Flow_LastUpdated_date="";
								$sensor_P2_LatestValue="";
								$sensor_P2_LastUpdated_date="";
								$sensor_Volume_LatestValue="";
								$sensor_Volume_LastUpdated_date="";
								$sensor_Battery_LatestValue="";
								$sensor_Battery_LastUpdated_date="";
								//http://dmamonitor.pwa.co.th/dashboard/services.php?method=device_detail&device_id=5542023-SL-MM-01
								$content_dma = file_get_contents('http://dmamonitor.pwa.co.th/dashboard/services.php?method=device_detail&device_id='.$wwcode.'-SL-'.strtoupper($textArr[3]));
								$dma_data = json_decode($content_dma, true);
								if(count($dma_data)>0)
								{
									foreach($dma_data as $k => $v) 
									{
										if(!is_array($v))
										{
		  									//$replytext.=$k." *** ".$v."\n";
		  									if($k=="Latitude")
		  										$Latitude=$v;
		  									if($k=="Longitude")
		  										$Longitude=$v;
		  									if($k=="device_name")
		  										$device_name=$v;
										}
		  								else
		  								{
		  									//$replytext.=$k."\n";
		  									foreach($v as $k1 => $v1) 
		  									{
		  										if(!is_array($v1))
		  										{
		  											//$replytext.=$k1." *** ".$v1."\n";
		  										}
		  										else
		  										{
		  											//$replytext.=$k1."\n";
		  											foreach($v1 as $k2 => $v2) 
		  											{
		  												if(!is_array($v2))
		  												{
		  													//$replytext.=$k2." *** ".$v2."\n";
		  													if(($k=="sensor") && ($k1=="Flow") && ($k2=="LatestValue"))
		  														$sensor_Flow_LatestValue=$v2;
		  													if(($k=="sensor") && ($k1=="P 2 (Out)") && ($k2=="LatestValue"))
		  														$sensor_P2_LatestValue=$v2;
		  													if(($k=="sensor") && ($k1=="Volume") && ($k2=="LatestValue"))
		  														$sensor_Volume_LatestValue=$v2;
		  													if(($k=="sensor") && ($k1=="Battery Status") && ($k2=="LatestValue"))
		  														$sensor_Battery_LatestValue=$v2;

		  												}
		  												else
		  												{
		  													//$replytext.=$k2."\n";
		  													foreach($v2 as $k3 => $v3) 
		  													{
		  														if(!is_array($v3))
				  												{
				  													//$replytext.=$k3." *** ".$v3."\n";
				  													if(($k=="sensor") && ($k1=="Flow") && ($k2=="LastUpdated") && ($k3=="date"))
		  																$sensor_Flow_LastUpdated_date=$v3;
		  															if(($k=="sensor") && ($k1=="P 2 (Out)") && ($k2=="LastUpdated") && ($k3=="date"))
		  																$sensor_P2_LastUpdated_date=$v3;
		  															if(($k=="sensor") && ($k1=="Volume") && ($k2=="LastUpdated") && ($k3=="date"))
		  																$sensor_Volume_LastUpdated_date=$v3;
		  															if(($k=="sensor") && ($k1=="Battery Status") && ($k2=="LastUpdated") && ($k3=="date"))
		  																$sensor_Battery_LastUpdated_date=$v3;
				  												}
		  													}
		  												}
		  											}
		  										}
		  									}
		  								}
									}
									

									$replytext1=$device_name."\n";
									if(strlen($sensor_Battery_LatestValue)>0)
									{
										$replytext1.="\nBattery Status ".$sensor_Battery_LatestValue." V.\n";
										$replytext1.="ข้อมูล ณ ".$sensor_Battery_LastUpdated_date."\n";
									}
									if(strlen($sensor_Flow_LatestValue)>0)
									{
										$replytext1.="\nอัตราการไหล ".$sensor_Flow_LatestValue." ลบ.ม./ชม.\n";
										$replytext1.="ข้อมูล ณ ".$sensor_Flow_LastUpdated_date."\n";
									}
									if(strlen($sensor_P2_LatestValue)>0)
									{
										$replytext1.="\nแรงดัน ".$sensor_P2_LatestValue." บาร์\n";
										$replytext1.="ข้อมูล ณ ".$sensor_P2_LastUpdated_date."\n";
									}
									if(strlen($sensor_Volume_LatestValue)>0)
									{
										$replytext1.="\nเลขมาตรขึ้น ".$sensor_Volume_LatestValue." ลบ.ม.\n";
										$replytext1.="ข้อมูล ณ ".$sensor_Volume_LastUpdated_date."\n";
									}
									
									$messages = [[
										'type' => 'text',
										'text' =>  $replytext1
									],[
										'type' => 'location',
										'title' =>  'ที่ตั้งสถานี '.$device_name,
										'address' =>  '123',
										'latitude' =>  $Latitude,
										'longitude' =>  $Longitude
									]];
								}
								else
								{
									$replytext="ไม่พบข้อมูล DMA ที่กรอก";
									$messages = [[
										'type' => 'text',
										'text' =>  $replytext
									]];
								}
							}
							else
							{
								$content_dma = file_get_contents('http://dmamonitor.pwa.co.th/dashboard/services.php?method=dmaName&wwcode='.$wwcode);
								$dma_data = json_decode($content_dma, true);
								$replytext="";
								$arrDmaCode=array();
								foreach($dma_data as $k => $v) 
								{
	  								//$replytext.=$k." *** ".$v."\n";
	  								if(strlen($replytext)>0)
	  									$replytext.="\n";
									$arrDmaCode=explode($wwcode.'-SL-', $k);
									$replytext.="-".$v." ให้กรอก robot sk dma ".strtolower($arrDmaCode[1]);
								}
								$messages = [[
									'type' => 'text',
									'text' =>  $replytext
								]];
							}
							
							break;
						default :
							$replytext="ในขณะนี้ผมสามารถให้ข้อมูลของสาขาสงขลาได้ดังนี้\n";
							$replytext.="1. โรงสูบน้ำสำนักงาน ให้กรอก robot sk z1\n";
							$replytext.="2. ถังน้ำใสเขาสำโรง ให้กรอก robot sk z2\n";
							$replytext.="3. สถานีเพิ่มแรงดันโคกสูง ให้กรอก robot sk z3\n";
							$replytext.="4. สถานีเพิ่มแรงดันท่านางหอม ให้กรอก robot sk z4";
							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
					}
				}
				else
				{
					$replytext="สวัสดีครับ ผมชื่อ Robot นะครับ\n";
					$replytext.="ในขณะนี้ผมสามารถให้ข้อมูลได้ดังนี้\n";
					$replytext.="1. สาขาหาดใหญ่ ให้กรอก robot hy\n";
					$replytext.="2. สาขาสงขลา ให้กรอก robot sk";
					$messages = [[
						'type' => 'text',
						'text' =>  $replytext
						]];
				}

				
				// Build message to reply back
				/*
				$messages = [
					'type' => 'text',
					'text' =>  $replytext
				];
				*/
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
echo "OK";
function resize($images,$new_images,$width)
{
	$size=GetimageSize($images);
	$height=round($width*$size[1]/$size[0]);
	$images_orig = ImageCreateFromJPEG($images);
	$photoX = ImagesX($images_orig);
	$photoY = ImagesY($images_orig);
	$images_fin = ImageCreateTrueColor($width, $height);
	ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
	ImageJPEG($images_fin,$new_images);
	//ImageJPEG($images_fin,$new_images);
	ImageDestroy($images_orig);
	ImageDestroy($images_fin);
}