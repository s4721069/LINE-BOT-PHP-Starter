<?php
$access_token = '6AHZeq++0ib7lwzyTgJJdOJON151Ugy/L3EXVepD5tBAj/MhR5iwoQxufCbcEyGXjVP7YP7xLAOeNDCKeoLmtpaIt1dxiuz+Hs5oYxOMTPQ4I61ttgUzX10Dc3ofzQ8BEYxql2nC1c23Wy9TRpIL+QdB04t89/1O/w1cDnyilFU=';

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
				if(strtoupper($textArr[1])=="HD")
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
						    $replytext1.="- การนำไฟฟ้า ".$scada_data['tele_ec']." µS/cm\n";
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
						    $replytext2.="- การนำไฟฟ้า ".$scada_data['tele_ec']." µS/cm\n";
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
						    $replytext3.="- การนำไฟฟ้า ".$scada_data['tele_ec']." µS/cm\n";
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
							    resize($scada_data['flood_image'],"pictures/utp10.jpg",1024);
							    resize("pictures/utp10.jpg","pictures/thumb_utp10.jpg",240);
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
										'originalContentUrl' =>  'https://scada.pwa.co.th/LINE/pictures/utp10.jpg',
										'previewImageUrl' =>  'https://scada.pwa.co.th/LINE/pictures/thumb_utp10.jpg'
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
							    resize($scada_data['flood_image'],"pictures/utp20.jpg",1024);
							    resize("pictures/utp20.jpg","pictures/thumb_utp20.jpg",240);
							    
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
										'originalContentUrl' =>  'https://scada.pwa.co.th/LINE/pictures/utp20.jpg',
										'previewImageUrl' =>  'https://scada.pwa.co.th/LINE/pictures/thumb_utp20.jpg'
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
							    resize($scada_data['flood_image'],"pictures/utp30.jpg",1024);
							    resize("pictures/utp30.jpg","pictures/thumb_utp30.jpg",240);
							    
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
										'originalContentUrl' =>  'https://scada.pwa.co.th/LINE/pictures/utp30.jpg',
										'previewImageUrl' =>  'https://scada.pwa.co.th/LINE/pictures/thumb_utp30.jpg'
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
						case "DMA" :
							$dmazone=strtoupper($textArr[3]);
							f_dma("5552012","hd",$dmazone);	
							break;
						case "METER" :
							$custcode=$textArr[3];
							f_meter("5552012","hd",$custcode);
							break;			
						default :
					
							//$replytext="สวัสดีครับ ".$sourceInfo['displayName']." ผมชื่อ Robot นะครับ\n";
							$replytext="ในขณะนี้ผมสามารถให้ข้อมูลของสาขาหาดใหญ่ได้ดังนี้\n";
							$replytext.="1. โรงกรอง 1500 ลบ.ม./ชม. สถานีฟ้าแสง(z3) ให้กรอก robot hd z3\n";
							$replytext.="2. โรงกรอง 2000 ลบ.ม./ชม. สถานีฟ้าแสง(z4) ให้กรอก robot hd z4\n";
							$replytext.="3. แรงสูง 1 สถานีฟ้าแสง(z6) ให้กรอก robot hd z6\n";
							$replytext.="4. แรงสูง 2 สถานีฟ้าแสง(z7) ให้กรอก robot hd z7\n";
							$replytext.="5. แรงสูง 3 สถานีฟ้าแสง(z8) ให้กรอก robot hd z8\n";
							$replytext.="6. แรงสูง 4 สถานีฟ้าแสง(z9) ให้กรอก robot hd z9\n";
							$replytext.="7. สถานีจ่ายน้ำบ้านพรุ(z11) ให้กรอก robot hd z11\n";
							$replytext.="8. สถานีจ่ายน้ำนาหม่อม(z12) ให้กรอก robot hd z12\n";
							$replytext.="9. Booster Pump นาหม่อม(z13) ให้กรอก robot hd z13\n";
							$replytext.="10. สถานีจ่ายน้ำควนลัง(z14) ให้กรอก robot hd z14\n";
							$replytext.="11. คุณภาพน้ำ ให้กรอก robot hd wq\n";
							$replytext.="12. ปริมาณน้ำ ให้กรอก robot hd volume\n";
							$replytext.="13. สถานีตรวจวัดน้ำดิบ ให้กรอก robot hd tele\n";
							$replytext.="14. ระบบประเมินสถานการณ์เพื่อการเตือนภัยน้ำท่วม ให้กรอก robot hd flood\n";
							$replytext.="15. ข้อมูล DMA ให้กรอก robot hd dma\n";
							$replytext.="16. ค้นหามาตรผู้ใช้น้ำ ให้กรอก robot hd meter";
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
							file_put_contents("pictures/z1sk.jpg", fopen("http://118.175.86.109/line/z1sk.jpg", 'r'));
							resize("pictures/z1sk.jpg","pictures/thumb_z1sk.jpg",240);
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
									'originalContentUrl' =>  'https://scada.pwa.co.th/LINE/pictures/z1sk.jpg',
									'previewImageUrl' =>  'https://scada.pwa.co.th/LINE/pictures/thumb_z1sk.jpg'
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
							file_put_contents("pictures/z3nn.jpg", fopen("http://118.175.86.109/line/z3nn.jpg", 'r'));
							resize("pictures/z3nn.jpg","pictures/thumb_z3nn.jpg",240);
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
									'originalContentUrl' =>  'https://scada.pwa.co.th/LINE/pictures/z3nn.jpg',
									'previewImageUrl' =>  'https://scada.pwa.co.th/LINE/pictures/thumb_z3nn.jpg'
								]];
							break;
						case "Z4" :$content_scada = file_get_contents('http://118.175.86.109/line/q_sk.php?z=z4');
							$tmp=file_get_contents('http://118.175.86.109/line/pumprun.php?z=z4th');
							file_put_contents("pictures/z4th.jpg", fopen("http://118.175.86.109/line/z4th.jpg", 'r'));
							resize("pictures/z4th.jpg","pictures/thumb_z4th.jpg",240);
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
									'originalContentUrl' =>  'https://scada.pwa.co.th/LINE/pictures/z4th.jpg',
									'previewImageUrl' =>  'https://scada.pwa.co.th/LINE/pictures/thumb_z4th.jpg'
								]];
							break;
						case "VOLUME" : 
							$content_scada = file_get_contents('http://118.175.86.109/line/volume_sk.php');
							$scada_data = json_decode($content_scada, true);
							$percentZ1SK_LE1_VOLUME=number_format($scada_data['Z1SK_LE1_VOLUME']/12000*100,2);
							$percentZ2SK_LE1_VOLUME=number_format($scada_data['Z2SK_LE1_VOLUME']/12600*100,2);
							$percentZ3NN_LE1_VOLUME=number_format($scada_data['Z3NN_LE1_VOLUME']/7000*100,2);
							$percentZ3NN_LE2_VOLUME=number_format($scada_data['Z3NN_LE2_VOLUME']/250*100,2);
							$percentZ4TH_LE1_VOLUME=number_format($scada_data['Z4TH_LE1_VOLUME']/4000*100,2);


							$replytext1="ปริมาณน้ำ ณ ".$scada_data['DateTime']."\n";

							$replytext1.="-ถังน้ำใสสงขลาขนาด 12,000 ลบ.ม. (Z1)  คือ ".number_format($scada_data['Z1SK_LE1_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ1SK_LE1_VOLUME." %\n";
							$replytext1.="-ถังน้ำใสเขาสำโรงขนาด 12,600 ลบ.ม. (Z2)  คือ ".number_format($scada_data['Z2SK_LE1_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ2SK_LE1_VOLUME." %\n";
							$replytext1.="-ถังน้ำใสโคกสูงขนาด 7,000 ลบ.ม. (Z3)  คือ ".number_format($scada_data['Z3NN_LE1_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ3NN_LE1_VOLUME." %\n";
							$replytext1.="-ถังสูงโคกสูงขนาด 250 ลบ.ม. (Z3)  คือ ".number_format($scada_data['Z3NN_LE2_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ3NN_LE2_VOLUME." %\n";
							$replytext1.="-ถังน้ำใสท่านางหอมขนาด 4,000 ลบ.ม. (Z4)  คือ ".number_format($scada_data['Z4TH_LE1_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ4TH_LE1_VOLUME." %";


							$messages = [[
									'type' => 'text',
									'text' =>  $replytext1
								]];
							break;
						case "DMA" :
							$dmazone=strtoupper($textArr[3]);
							f_dma("5552011","sk",$dmazone);
							break;
						case "METER" :
							$custcode=$textArr[3];
							f_meter("5552011","sk",$custcode);
							break;
						default :
							$replytext="ในขณะนี้ผมสามารถให้ข้อมูลของสาขาสงขลาได้ดังนี้\n";
							$replytext.="1. โรงสูบน้ำสำนักงาน ให้กรอก robot sk z1\n";
							$replytext.="2. ถังน้ำใสเขาสำโรง ให้กรอก robot sk z2\n";
							$replytext.="3. สถานีเพิ่มแรงดันโคกสูง ให้กรอก robot sk z3\n";
							$replytext.="4. สถานีเพิ่มแรงดันท่านางหอม ให้กรอก robot sk z4\n";
							$replytext.="5. ปริมาณน้ำ robot sk volume\n";
							$replytext.="6. ข้อมูล DMA ให้กรอก robot sk dma\n";
							$replytext.="7. ค้นหามาตรผู้ใช้น้ำ ให้กรอก robot sk meter";
							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
					}
				}
				elseif(strtoupper($textArr[1])=="SD")
				{
					switch(strtoupper($textArr[2]))
					{
						case "DMA" :
							$dmazone=strtoupper($textArr[3]);
							f_dma("5552013","sd",$dmazone);
							break;
						default :
							$replytext="ในขณะนี้ผมสามารถให้ข้อมูลของสาขาสะเดาได้ดังนี้\n";
							$replytext.="1. ข้อมูล DMA ให้กรอก robot sd dma";

							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
					}
				}
				elseif(strtoupper($textArr[1])=="KS")
				{
					switch(strtoupper($textArr[2]))
					{
						case "DMA" :
							$dmazone=strtoupper($textArr[3]);
							f_dma("5552017","ks",$dmazone);
							break;
						case "METER" :
							$custcode=$textArr[3];
							f_meter("5552017","ks",$custcode);
							break;
						default :
							$replytext="ในขณะนี้ผมสามารถให้ข้อมูลของสาขาเขาชัยสนได้ดังนี้\n";
							$replytext.="1. ข้อมูล DMA ให้กรอก robot ks dma\n";
							$replytext.="2. ค้นหามาตรผู้ใช้น้ำ ให้กรอก robot ks meter";

							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
					}
				}
				elseif(strtoupper($textArr[1])=="RN")
				{
					switch(strtoupper($textArr[2]))
					{
						case "METER" :
							$custcode=$textArr[3];
							f_meter("5552015","rn",$custcode);
							break;
						default :
							$replytext="ในขณะนี้ผมสามารถให้ข้อมูลของสาขาระโนด ได้ดังนี้\n";
							$replytext.="1. ค้นหามาตรผู้ใช้น้ำ ให้กรอก robot rn meter";

							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
					}
				}
				elseif(strtoupper($textArr[1])=="TR")
				{
					switch(strtoupper($textArr[2]))
					{
						case "DMA" :
							$dmazone=strtoupper($textArr[3]);
							f_dma("5552018","tr",$dmazone);
							break;
						default :
							$replytext="ในขณะนี้ผมสามารถให้ข้อมูลของสาขาตรังได้ดังนี้\n";
							$replytext.="1. ข้อมูล DMA ให้กรอก robot tr dma";

							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
					}
				}
				elseif(strtoupper($textArr[1])=="HY")
				{
					switch(strtoupper($textArr[2]))
					{
						case "DMA" :
							$dmazone=strtoupper($textArr[3]);
							f_dma("5552019","hy",$dmazone);
							break;
						default :
							$replytext="ในขณะนี้ผมสามารถให้ข้อมูลของสาขาห้วยยอดได้ดังนี้\n";
							$replytext.="1. ข้อมูล DMA ให้กรอก robot hy dma";

							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
					}
				}
				elseif(strtoupper($textArr[1])=="YK")
				{
					switch(strtoupper($textArr[2]))
					{
						case "DMA" :
							$dmazone=strtoupper($textArr[3]);
							f_dma("5552020","yk",$dmazone);
							break;
						default :
							$replytext="ในขณะนี้ผมสามารถให้ข้อมูลของสาขาย่านตาขาวได้ดังนี้\n";
							$replytext.="1. ข้อมูล DMA ให้กรอก robot yk dma";

							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
					}
				}
				elseif(strtoupper($textArr[1])=="KT")
				{
					switch(strtoupper($textArr[2]))
					{
						case "DMA" :
							$dmazone=strtoupper($textArr[3]);
							f_dma("5552021","kt",$dmazone);
							break;
						default :
							$replytext="ในขณะนี้ผมสามารถให้ข้อมูลของสาขากันตังได้ดังนี้\n";
							$replytext.="1. ข้อมูล DMA ให้กรอก robot kt dma";

							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
					}
				}
				elseif(strtoupper($textArr[1])=="LA")
				{
					switch(strtoupper($textArr[2]))
					{
						case "DMA" :
							$dmazone=strtoupper($textArr[3]);
							f_dma("5552023","la",$dmazone);
							break;
						default :
							$replytext="ในขณะนี้ผมสามารถให้ข้อมูลของสาขาละงูได้ดังนี้\n";
							$replytext.="1. ข้อมูล DMA ให้กรอก robot la dma";

							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
					}
				}
				elseif(strtoupper($textArr[1])=="BT")
				{
					switch(strtoupper($textArr[2]))
					{
						case "DMA" :
							$dmazone=strtoupper($textArr[3]);
							f_dma("5552025","bt",$dmazone);
							break;
						default :
							$replytext="ในขณะนี้ผมสามารถให้ข้อมูลของสาขาเบตงได้ดังนี้\n";
							$replytext.="1. ข้อมูล DMA ให้กรอก robot bt dma";

							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
					}
				}
				elseif(strtoupper($textArr[1])=="PL")
				{
					switch(strtoupper($textArr[2]))
					{
						case "DMA" :
							$dmazone=strtoupper($textArr[3]);
							f_dma("5552030","pl",$dmazone);
							break;
						default :
							$replytext="ในขณะนี้ผมสามารถให้ข้อมูลของสาขาพังลาได้ดังนี้\n";
							$replytext.="1. ข้อมูล DMA ให้กรอก robot pl dma";

							$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								]];
					}
				}
				elseif(strtoupper($textArr[1])=="PT")
				{
					switch(strtoupper($textArr[2]))
					{
						case "METER" :
							$custcode=$textArr[3];
							f_meter("5552016","pt",$custcode);
							break;
						default :
							$replytext="ในขณะนี้ผมสามารถให้ข้อมูลของสาขาพัทลุงได้ดังนี้\n";
							$replytext.="1. ค้นหามาตรผู้ใช้น้ำ ให้กรอก robot pt meter";

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
					$replytext.="1. สาขาหาดใหญ่ ให้กรอก robot hd\n";
					$replytext.="2. สาขาสงขลา ให้กรอก robot sk\n";
					$replytext.="3. สาขาสะเดา ให้กรอก robot sd\n";
					$replytext.="4. สาขาระโนด ให้กรอก robot rn\n";
					$replytext.="5. สาขาพัทลุง ให้กรอก robot pt\n";
					$replytext.="6. สาขาเขาชัยสน ให้กรอก robot ks\n";
					$replytext.="7. สาขาตรัง ให้กรอก robot tr\n";
					$replytext.="8. สาขาห้วยยอด ให้กรอก robot hy\n";
					$replytext.="9. สาขาย่านตาขาว ให้กรอก robot yk\n";
					$replytext.="10. สาขากันตัง ให้กรอก robot kt\n";
					$replytext.="11. สาขาละงู ให้กรอก robot la\n";
					$replytext.="12. สาขาเบตง ให้กรอก robot bt\n";
					$replytext.="13. สาขาพังลา ให้กรอก robot pl";
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
else
{
	$job=$_GET["job"];
	switch ($job) 
	{
		case 'job01': //รายงาน กลุ่มการจ่ายน้ำสงขลา ทุกๆ 6.00 น.
			$to='C6868f540d449376a8334981297ec9c01'; // การจ่ายน้ำสงขลา
			$content_scada = file_get_contents('http://118.175.86.109/line/q_sk.php?z=Jorm');
			$scada_data = json_decode($content_scada, true);
			$pushtext="ปริมาณน้ำวันที่ ".$scada_data['DateTime']."\n";
			$pushtext.="- ปริมาณน้ำถังน้ำใสสงขลาขนาด 12,000 ลบ.ม. คือ ".number_format($scada_data['Z1SK_LE1_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z1SK_LE1_AINPUT_PV'],2)." เมตร อัตราการจ่ายเข้าเมือง ".number_format($scada_data['Z1SK_FE2_AINPUT_PV'],0)." ลบ.ม./ชม. แรงดัน ".number_format($scada_data['Z1SK_PE2_AINPUT_PV'],2)." บาร์\n";
			$pushtext.="- ปริมาณน้ำถังน้ำใสเขาสำโรงขนาด 12,600 ลบ.ม. คือ ".number_format($scada_data['Z2SK_LE1_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z2SK_LE1_AINPUT_PV'],2)." เมตร\n";
			$pushtext.="- ปริมาณน้ำถังน้ำใสโคกสูงขนาด 7,000 ลบ.ม. คือ ".number_format($scada_data['Z3NN_LE1_VOLUME'],0)." ลบ.ม. หรือ ".number_format($scada_data['Z3NN_LE1_AINPUT_PV'],2)." เมตร";
			$messages = [[
					'type' => 'text',
					'text' =>  $pushtext
				]];
			break;
		case 'job02': //รายงานคุณภาพน้ำ กลุ่มนวัตกรรม 59
			$to='C901af91ed9d961d5eedc5ac872fc7f50'; // นวัตกรรม 59
			$content_scada = file_get_contents('http://118.175.86.109/line/wq.php');
			$scada_data = json_decode($content_scada, true);
			$pushtext1="คุณภาพน้ำของโรงกรอง 1500 ลบ.ม./ชม. (Z3) ณ ".$scada_data['DateTimeZ3']." ดังนี้\n";
			$pushtext1.="ความขุ่น ".number_format($scada_data['Z3HY_TB'],2)." NTU\n";
			$pushtext1.="pH ".number_format($scada_data['Z3HY_PH'],2)."\n";
			$pushtext1.="Residual Chlorine ".number_format($scada_data['Z3HY_CL'],2)." mg/l\n\n";
			$pushtext1.="คุณภาพน้ำของโรงกรอง 2000 ลบ.ม./ชม. (Z4) ณ ".$scada_data['DateTimeZ4']." ดังนี้\n";
			$pushtext1.="ความขุ่น ".number_format($scada_data['Z4HY_TB'],2)." NTU\n";
			$pushtext1.="pH ".number_format($scada_data['Z4HY_PH'],2)."\n";
			$pushtext1.="Residual Chlorine ".number_format($scada_data['Z4HY_CL'],2)." mg/l\n\n";
			$pushtext1.="คุณภาพน้ำของแรงสูง 4 (Z9) ณ ".$scada_data['DateTimeZ9']." ดังนี้\n";
			$pushtext1.="ความขุ่น ".number_format($scada_data['Z9HY_TB'],2)." NTU\n";
			$pushtext1.="pH ".number_format($scada_data['Z9HY_PH'],2)."\n";
			$pushtext1.="Residual Chlorine ".number_format($scada_data['Z9HY_CL'],2)." mg/l\n\n";
			$pushtext1.="คุณภาพน้ำของสถานีจ่ายน้ำบ้านพรุ (Z11) ณ ".$scada_data['DateTimeZ11']." ดังนี้\n";
			$pushtext1.="Residual Chlorine ".number_format($scada_data['Z0HY_DC_BP_CL'],2)." mg/l\n\n";
			$pushtext1.="คุณภาพน้ำของสถานีจ่ายน้ำนาหม่อม (Z12) ณ ".$scada_data['DateTimeZ12']." ดังนี้\n";
			$pushtext1.="Residual Chlorine ".number_format($scada_data['Z0HY_DC_NM_CL'],2)." mg/l";

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
			$pushtext2="ปริมาณน้ำ ณ ".$scada_data['DateTimeZ3']."\n";
			$pushtext2.="-ถังน้ำใสขนาด 3,000 ลบ.ม. (Z3)  คือ ".number_format($scada_data['Z3HY_LE1_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ3HY_LE1_VOLUME." %\n";
			$pushtext2.="-ถังน้ำใสขนาด 3,000 ลบ.ม. (Z6) คือ ".number_format($scada_data['Z6HY_LE1_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ6HY_LE1_VOLUME." %\n";
			$pushtext2.="-ถังสูงขนาด 250 ลบ.ม. (Z6) คือ ".number_format($scada_data['Z6HY_LE2_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ6HY_LE2_VOLUME." %\n";
			$pushtext2.="-ถังน้ำใสขนาด 6,000 ลบ.ม. (Z7) คือ ".number_format($scada_data['Z7HY_LE1_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ7HY_LE1_VOLUME." %\n";
			$pushtext2.="-ถังน้ำใสขนาด 3,500 ลบ.ม. (Z8) คือ ".number_format($scada_data['Z8HY_LE1_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ8HY_LE1_VOLUME." %\n";
			$pushtext2.="-ถังน้ำใสขนาด 3,500 ลบ.ม. (Z9) คือ ".number_format($scada_data['Z9HY_LE1_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ9HY_LE1_VOLUME." %\n";
			$pushtext2.="-ถังน้ำใสขนาด 1,000 ลบ.ม. สถานีจ่ายน้ำบ้านพรุ (Z11) คือ ".number_format($scada_data['Z0HY_DC_BP_LE1_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ0HY_DC_BP_LE1_VOLUME." %\n";
			$pushtext2.="-ถังสูงขนาด 250 ลบ.ม. สถานีจ่ายน้ำบ้านพรุ (Z11) คือ ".number_format($scada_data['Z0HY_DC_BP_LE2_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ0HY_DC_BP_LE2_VOLUME." %\n";
			$pushtext2.="-ถังน้ำใสขนาด 200 ลบ.ม. สถานีจ่ายน้ำนาหม่อม (Z12) คือ ".number_format($scada_data['Z0HY_DC_NM_LE1_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ0HY_DC_NM_LE1_VOLUME." %\n";
			$pushtext2.="-ถังสูงขนาด 100 ลบ.ม. สถานีจ่ายน้ำนาหม่อม (Z12) คือ ".number_format($scada_data['Z0HY_DC_NM_LE2_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ0HY_DC_NM_LE2_VOLUME." %\n";
			$pushtext2.="-ถังน้ำใสขนาด 1500 ลบ.ม. สถานีจ่ายน้ำควนลัง คือ ".number_format($scada_data['Z14KL_LE2_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ14KL_LE2_VOLUME." %\n";
			$pushtext2.="-ถังสูงขนาด 300 ลบ.ม. สถานีจ่ายน้ำควนลัง คือ ".number_format($scada_data['Z14KL_LE1_VOLUME'],0)." ลบ.ม. คิดเป็น ".$percentZ14KL_LE1_VOLUME." %";
			
			$content_scada = file_get_contents('http://118.175.86.109/line/wrd.php');
			$scada_data = json_decode($content_scada, true);
		    $pushtext3="ข้อมูลสถานีตรวจวัดน้ำดิบ อัพเดทล่าสุด ".$scada_data['tele_lastdatatime']."\n";
		    $pushtext3.="- pH ".$scada_data['tele_ph']."\n";
		    $pushtext3.="- DO ".$scada_data['tele_do']." mg/L\n";
		    $pushtext3.="- Turbidity ".$scada_data['tele_tb']." NTU\n";
		    $pushtext3.="- การนำไฟฟ้า ".$scada_data['tele_ec']." µS/cm\n";
		    $pushtext3.="- ความเค็ม ".$scada_data['tele_salinity']." g/L\n";
		    $pushtext3.="- รีดอกซ์ ".$scada_data['tele_orp']." mV\n";
		    $pushtext3.="- อุณหภูมิ ".$scada_data['tele_temp']." °C\n";
		    $pushtext3.="- ระดับน้ำ ".$scada_data['tele_level']." ม.รทก.";
			$messages = [[
					'type' => 'text',
					'text' =>  $pushtext1
				],
				[
					'type' => 'text',
					'text' =>  $pushtext2
				],
				[
					'type' => 'text',
					'text' =>  $pushtext3
				]];


			break;
		case 'upt10': //flood กลุ่มนวัตกรรม 59
			$to='C901af91ed9d961d5eedc5ac872fc7f50'; // นวัตกรรม 59
			$content_scada = file_get_contents('http://118.175.86.109/line/flood.php?basin=UPT&s=UPT10');
			$scada_data = json_decode($content_scada, true);
			$pushtext1="ข้อมูลสถานี".$scada_data['flood_name']."\n";
			$pushtext1.="เมื่อ ".$scada_data['flood_lastdatatime']."\n";
			$pushtext1.="-ระดับน้ำ ".$scada_data['flood_level']." ม.รทก. (".$scada_data['flood_status'].")\n";
			$pushtext1.="-ระดับน้ำต่ำกว่าตลิ่งซ้าย ".$scada_data['flood_left']." ม.\n";
			$pushtext1.="-ระดับน้ำต่ำกว่าตลิ่งขวา ".$scada_data['flood_right']." ม.";
			resize($scada_data['flood_image'],"pictures/upt10.jpg",1024);
			resize("pictures/upt10.jpg","pictures/thumb_upt10.jpg",240);
					    
			$messages = [[
					'type' => 'text',
					'text' =>  $pushtext1
				],[
					'type' => 'location',
					'title' =>  'ที่ตั้งสถานี'.$scada_data['flood_name'],
					'address' =>  $scada_data['flood_address'],
					'latitude' =>  $scada_data['flood_lat'],
					'longitude' =>  $scada_data['flood_long']
				],[
					'type' => 'image',
					'originalContentUrl' =>  'https://scada.pwa.co.th/LINE/pictures/upt10.jpg',
					'previewImageUrl' =>  'https://scada.pwa.co.th/LINE/pictures/thumb_upt10.jpg'
				]];

			break;
		case 'upt20': //flood กลุ่มนวัตกรรม 59
			$to='C901af91ed9d961d5eedc5ac872fc7f50'; // นวัตกรรม 59
			$content_scada = file_get_contents('http://118.175.86.109/line/flood.php?basin=UPT&s=UPT20');
			$scada_data = json_decode($content_scada, true);
			$pushtext1="ข้อมูลสถานี".$scada_data['flood_name']."\n";
			$pushtext1.="เมื่อ ".$scada_data['flood_lastdatatime']."\n";
			$pushtext1.="-ระดับน้ำ ".$scada_data['flood_level']." ม.รทก. (".$scada_data['flood_status'].")\n";
			$pushtext1.="-ระดับน้ำต่ำกว่าตลิ่งซ้าย ".$scada_data['flood_left']." ม.\n";
			$pushtext1.="-ระดับน้ำต่ำกว่าตลิ่งขวา ".$scada_data['flood_right']." ม.";
			resize($scada_data['flood_image'],"pictures/upt20.jpg",1024);
			resize("pictures/upt20.jpg","pictures/thumb_upt20.jpg",240);
					    
			$messages = [[
					'type' => 'text',
					'text' =>  $pushtext1
				],[
					'type' => 'location',
					'title' =>  'ที่ตั้งสถานี'.$scada_data['flood_name'],
					'address' =>  $scada_data['flood_address'],
					'latitude' =>  $scada_data['flood_lat'],
					'longitude' =>  $scada_data['flood_long']
				],[
					'type' => 'image',
					'originalContentUrl' =>  'https://scada.pwa.co.th/LINE/pictures/upt20.jpg',
					'previewImageUrl' =>  'https://scada.pwa.co.th/LINE/pictures/thumb_upt20.jpg'
				]];

			break;
		case 'upt30': //flood กลุ่มนวัตกรรม 59
			$to='C901af91ed9d961d5eedc5ac872fc7f50'; // นวัตกรรม 59
			$content_scada = file_get_contents('http://118.175.86.109/line/flood.php?basin=UPT&s=UPT30');
			$scada_data = json_decode($content_scada, true);
			$pushtext1="ข้อมูลสถานี".$scada_data['flood_name']."\n";
			$pushtext1.="เมื่อ ".$scada_data['flood_lastdatatime']."\n";
			$pushtext1.="-ระดับน้ำ ".$scada_data['flood_level']." ม.รทก. (".$scada_data['flood_status'].")\n";
			$pushtext1.="-ระดับน้ำต่ำกว่าตลิ่งซ้าย ".$scada_data['flood_left']." ม.\n";
			$pushtext1.="-ระดับน้ำต่ำกว่าตลิ่งขวา ".$scada_data['flood_right']." ม.";
			resize($scada_data['flood_image'],"pictures/upt30.jpg",1024);
			resize("pictures/upt30.jpg","pictures/thumb_upt30.jpg",240);
				    
			$messages = [[
					'type' => 'text',
					'text' =>  $pushtext1
				],[
					'type' => 'location',
					'title' =>  'ที่ตั้งสถานี'.$scada_data['flood_name'],
					'address' =>  $scada_data['flood_address'],
					'latitude' =>  $scada_data['flood_lat'],
					'longitude' =>  $scada_data['flood_long']
				],[
					'type' => 'image',
					'originalContentUrl' =>  'https://scada.pwa.co.th/LINE/pictures/upt30.jpg',
					'previewImageUrl' =>  'https://scada.pwa.co.th/LINE/pictures/thumb_upt30.jpg'
				]];

			break;

		case 'pumprun_sk': 
			//$to='C6868f540d449376a8334981297ec9c01'; // การจ่ายน้ำสงขลา
			$to='C2cfe9bdd6ccdc48c6eb02a919156d874'; // การเดินเครื่องสงขลา
			$pushtext1="";
			if(strlen($_GET["cvm01sk"])>0)
			{
				if(strlen($pushtext1)>0)
					$pushtext1.="\n";
				if($_GET["cvm01sk"]=="on")
					$pushtext1.="เครื่องสูบน้ำ CVM01SK ได้เดินเครื่องแล้ว";
				if($_GET["cvm01sk"]=="off")
					$pushtext1.="เครื่องสูบน้ำ CVM01SK ได้หยุดเครื่องแล้ว";
			}
			if(strlen($_GET["cvm02sk"])>0)
			{
				if(strlen($pushtext1)>0)
					$pushtext1.="\n";
				if($_GET["cvm02sk"]=="on")
					$pushtext1.="เครื่องสูบน้ำ CVM02SK ได้เดินเครื่องแล้ว";
				if($_GET["cvm02sk"]=="off")
					$pushtext1.="เครื่องสูบน้ำ CVM02SK ได้หยุดเครื่องแล้ว";
			}
			if(strlen($_GET["cvm03sk"])>0)
			{
				if(strlen($pushtext1)>0)
					$pushtext1.="\n";
				if($_GET["cvm03sk"]=="on")
					$pushtext1.="เครื่องสูบน้ำ CVM03SK ได้เดินเครื่องแล้ว";
				if($_GET["cvm03sk"]=="off")
					$pushtext1.="เครื่องสูบน้ำ CVM03SK ได้หยุดเครื่องแล้ว";
			}
			if(strlen($_GET["cvm04sk"])>0)
			{
				if(strlen($pushtext1)>0)
					$pushtext1.="\n";
				if($_GET["cvm04sk"]=="on")
					$pushtext1.="เครื่องสูบน้ำ CVM04SK ได้เดินเครื่องแล้ว";
				if($_GET["cvm04sk"]=="off")
					$pushtext1.="เครื่องสูบน้ำ CVM04SK ได้หยุดเครื่องแล้ว";
			}
			if(strlen($_GET["cvm05sk"])>0)
			{
				if(strlen($pushtext1)>0)
					$pushtext1.="\n";
				if($_GET["cvm05sk"]=="on")
					$pushtext1.="เครื่องสูบน้ำ CVM05SK ได้เดินเครื่องแล้ว";
				if($_GET["cvm05sk"]=="off")
					$pushtext1.="เครื่องสูบน้ำ CVM05SK ได้หยุดเครื่องแล้ว";
			}

			if(strlen($_GET["cvm01nn"])>0)
			{
				if(strlen($pushtext1)>0)
					$pushtext1.="\n";
				if($_GET["cvm01nn"]=="on")
					$pushtext1.="เครื่องสูบน้ำ CVM01NN ได้เดินเครื่องแล้ว";
				if($_GET["cvm01nn"]=="off")
					$pushtext1.="เครื่องสูบน้ำ CVM01NN ได้หยุดเครื่องแล้ว";
			}
			if(strlen($_GET["cvm02nn"])>0)
			{
				if(strlen($pushtext1)>0)
					$pushtext1.="\n";
				if($_GET["cvm02nn"]=="on")
					$pushtext1.="เครื่องสูบน้ำ CVM02NN ได้เดินเครื่องแล้ว";
				if($_GET["cvm02nn"]=="off")
					$pushtext1.="เครื่องสูบน้ำ CVM02NN ได้หยุดเครื่องแล้ว";
			}
			if(strlen($_GET["cvm03nn"])>0)
			{
				if(strlen($pushtext1)>0)
					$pushtext1.="\n";
				if($_GET["cvm03nn"]=="on")
					$pushtext1.="เครื่องสูบน้ำ CVM03NN ได้เดินเครื่องแล้ว";
				if($_GET["cvm03nn"]=="off")
					$pushtext1.="เครื่องสูบน้ำ CVM03NN ได้หยุดเครื่องแล้ว";
			}
			if(strlen($_GET["cvm04nn"])>0)
			{
				if(strlen($pushtext1)>0)
					$pushtext1.="\n";
				if($_GET["cvm04nn"]=="on")
					$pushtext1.="เครื่องสูบน้ำ CVM04NN ได้เดินเครื่องแล้ว";
				if($_GET["cvm04nn"]=="off")
					$pushtext1.="เครื่องสูบน้ำ CVM04NN ได้หยุดเครื่องแล้ว";
			}
			if(strlen($_GET["cvm05nn"])>0)
			{
				if(strlen($pushtext1)>0)
					$pushtext1.="\n";
				if($_GET["cvm05nn"]=="on")
					$pushtext1.="เครื่องสูบน้ำ CVM05NN ได้เดินเครื่องแล้ว";
				if($_GET["cvm05nn"]=="off")
					$pushtext1.="เครื่องสูบน้ำ CVM05NN ได้หยุดเครื่องแล้ว";
			}
			if(strlen($_GET["cvm06nn"])>0)
			{
				if(strlen($pushtext1)>0)
					$pushtext1.="\n";
				if($_GET["cvm06nn"]=="on")
					$pushtext1.="เครื่องสูบน้ำ CVM06NN ได้เดินเครื่องแล้ว";
				if($_GET["cvm06nn"]=="off")
					$pushtext1.="เครื่องสูบน้ำ CVM06NN ได้หยุดเครื่องแล้ว";
			}
			if(strlen($_GET["cvm07nn"])>0)
			{
				if(strlen($pushtext1)>0)
					$pushtext1.="\n";
				if($_GET["cvm07nn"]=="on")
					$pushtext1.="เครื่องสูบน้ำ CVM07NN ได้เดินเครื่องแล้ว";
				if($_GET["cvm07nn"]=="off")
					$pushtext1.="เครื่องสูบน้ำ CVM07NN ได้หยุดเครื่องแล้ว";
			}

			if(strlen($_GET["cvm01th"])>0)
			{
				if(strlen($pushtext1)>0)
					$pushtext1.="\n";
				if($_GET["cvm01th"]=="on")
					$pushtext1.="เครื่องสูบน้ำ CVM01TH ได้เดินเครื่องแล้ว";
				if($_GET["cvm01th"]=="off")
					$pushtext1.="เครื่องสูบน้ำ CVM01TH ได้หยุดเครื่องแล้ว";
			}
			if(strlen($_GET["cvm02th"])>0)
			{
				if(strlen($pushtext1)>0)
					$pushtext1.="\n";
				if($_GET["cvm02th"]=="on")
					$pushtext1.="เครื่องสูบน้ำ CVM02TH ได้เดินเครื่องแล้ว";
				if($_GET["cvm02th"]=="off")
					$pushtext1.="เครื่องสูบน้ำ CVM02TH ได้หยุดเครื่องแล้ว";
			}
			if(strlen($_GET["cvm03th"])>0)
			{
				if(strlen($pushtext1)>0)
					$pushtext1.="\n";
				if($_GET["cvm03th"]=="on")
					$pushtext1.="เครื่องสูบน้ำ CVM03TH ได้เดินเครื่องแล้ว";
				if($_GET["cvm01th"]=="off")
					$pushtext1.="เครื่องสูบน้ำ CVM03TH ได้หยุดเครื่องแล้ว";
			}
			if(strlen($_GET["cvm04th"])>0)
			{
				if(strlen($pushtext1)>0)
					$pushtext1.="\n";
				if($_GET["cvm04th"]=="on")
					$pushtext1.="เครื่องสูบน้ำ CVM04TH ได้เดินเครื่องแล้ว";
				if($_GET["cvm04th"]=="off")
					$pushtext1.="เครื่องสูบน้ำ CVM04TH ได้หยุดเครื่องแล้ว";
			}
		    
			$messages = [[
					'type' => 'text',
					'text' =>  $pushtext1
				]];

			break;
		
		case 'rostip' : 
			//$to='U13fcec855c7157a2b7c9c0c1d8c0d19b'; // Somchai
			//$to='C348cc0d50104291f777b2564e691021b'; // _เพื่อนรัก
			$to='Uc5ef5c19165db14d618eec456075f674'; // Rostip
			$pushtext1=f_dma_rostip("5552020","MM-01");
			$pushtext1.=f_dma_rostip("5552020","MM-02");
			$pushtext1.=f_dma_rostip("5552020","MM-03");
			$pushtext1.=f_dma_rostip("5552020","MM-04");
			$pushtext1.=f_dma_rostip("5552020","MM-05");
			$pushtext1.=f_dma_rostip("5552020","MM-06");
			$pushtext2=f_dma_rostip("5552020","DMA-01");
			$pushtext2.=f_dma_rostip("5552020","DMA-02");
			$pushtext2.=f_dma_rostip("5552020","DMA-03");
			$pushtext2.=f_dma_rostip("5552020","DMA-04");
			$messages = [[
					'type' => 'text',
					'text' =>  $pushtext1
				],[
					'type' => 'text',
					'text' =>  $pushtext2
				]];

			break;
		case 'job03' : //U13fcec855c7157a2b7c9c0c1d8c0d19b
			//$to='U13fcec855c7157a2b7c9c0c1d8c0d19b'; // Somchai
			$to='C901af91ed9d961d5eedc5ac872fc7f50'; // นวัตกรรม 59
			$pushtext1=f_dma_rostip("5552012","DMA-03-11");
			$pushtext1.=f_dma_rostip("5552012","DMA-04-06");
			$messages = [[
					'type' => 'text',
					'text' =>  $pushtext1
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

function f_dma($wwcode,$shortcode,$dmazone)
{
	global $messages;

	$upperdamzone=strtoupper($dmazone);
	if(strlen($dmazone)>0)
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
		$content_dma = file_get_contents('http://dmamonitor.pwa.co.th/dashboard/services.php?method=device_detail&device_id='.$wwcode.'-SL-'.$upperdamzone);
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
			

			$replytext1=$device_name;
			if(strlen($sensor_Battery_LatestValue)>0)
			{
				$replytext1.="\n\nBattery Status ".$sensor_Battery_LatestValue." V.\n";
				$replytext1.="ข้อมูล ณ ".$sensor_Battery_LastUpdated_date;
			}
			if(strlen($sensor_Flow_LatestValue)>0)
			{
				$replytext1.="\n\nอัตราการไหล ".$sensor_Flow_LatestValue." ลบ.ม./ชม.\n";
				$replytext1.="ข้อมูล ณ ".$sensor_Flow_LastUpdated_date;
			}
			if(strlen($sensor_P2_LatestValue)>0)
			{
				$replytext1.="\n\nแรงดัน ".$sensor_P2_LatestValue." บาร์\n";
				$replytext1.="ข้อมูล ณ ".$sensor_P2_LastUpdated_date;
			}
			if(strlen($sensor_Volume_LatestValue)>0)
			{
				$replytext1.="\n\nเลขมาตรขึ้น ".$sensor_Volume_LatestValue." ลบ.ม.\n";
				$replytext1.="ข้อมูล ณ ".$sensor_Volume_LastUpdated_date;
			}
			if($Latitude!="")
			{
				$messages = [[
					'type' => 'text',
					'text' =>  $replytext1
				],[
					'type' => 'location',
					'title' =>  'ที่ตั้ง '.$device_name,
					'address' =>  'latitude:'.$Latitude.' longitude:'.$Longitude,
					'latitude' =>  $Latitude,
					'longitude' =>  $Longitude
				]];
			}
			else
			{
				$messages = [[
				'type' => 'text',
				'text' =>  $replytext1
				]];
			}
			
			
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
		$replytext="มีข้อมูล DMA ดังนี้";
		$arrDmaCode=array();
		foreach($dma_data as $k => $v) 
		{
				//$replytext.=$k." *** ".$v."\n";
				if(strlen($replytext)>0)
					$replytext.="\n";
			$arrDmaCode=explode($wwcode.'-SL-', $k);
			$replytext.="-".$v." ให้กรอก robot ".$shortcode." dma ".strtolower($arrDmaCode[1]);
		}

		$messages = [[
			'type' => 'text',
			'text' =>  $replytext
		]];

	}


}
function f_meter($wwcode,$shortcode,$custcode)
{
	//1132296
	global $messages;
	$obj = file_get_contents('http://scada.pwa.co.th/gpsmeter/apiv2.php?service=getdata&custcode='.$custcode.'&branch='.$wwcode.'&fx=custcode');
	$arrObj=explode("mycallback(",$obj);
	$meter_data=json_decode(substr($arrObj[1],0,strlen($arrObj[1])-1), true);
	if(strlen($custcode)>0)
	{
		if($meter_data['status']=="success")
		{
			$replytext="หมายเลขผู้ใช้น้ำ : ".$custcode."\n";
			$replytext="ชื่อผู้ใช้น้ำ : ".$meter_data['custname']."\n";
			$replytext.="หมายเลขมาตร : ".$meter_data['meterno'];
			$messages = [[
				'type' => 'text',
				'text' =>  $replytext
			],[
					'type' => 'location',
					'title' =>  'ที่อยู่ของ '.$meter_data['custname'],
					'address' =>  $meter_data['custaddr'],
					'latitude' =>  $meter_data['custlat'],
					'longitude' =>  $meter_data['custlng']
				]];
		}
		else
		{
			$replytext="ไม่พบข้อมูลหมายเลขผู้ใช้น้ำ ที่กรอก";
			$messages = [[
				'type' => 'text',
				'text' =>  $replytext
			]];
		}
	}
	else
	{
		$replytext="ค้นหามาตรผู้ใช้น้ำ ให้กรอก robot ".$shortcode." meter หมายเลขผู้ใช้น้ำ\n";
		$replytext.="เช่น robot ".$shortcode." meter 1234567";
			$messages = [[
				'type' => 'text',
				'text' =>  $replytext
			]];
	}
}

function f_dma_rostip($wwcode,$dmazone)
{
	$upperdamzone=strtoupper($dmazone);
	if(strlen($dmazone)>0)
	{
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
		$content_dma = file_get_contents('http://dmamonitor.pwa.co.th/dashboard/services.php?method=device_detail&device_id='.$wwcode.'-SL-'.$upperdamzone);
		$dma_data = json_decode($content_dma, true);

		if(count($dma_data)>0)
		{
			foreach($dma_data as $k => $v) 
			{
				if(!is_array($v))
				{
						//$replytext.=$k." *** ".$v."\n";
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
			

			$replytext1=$device_name;
			$replytext1.="\nข้อมูล ณ ".$sensor_Battery_LastUpdated_date;
			if(strlen($sensor_Battery_LatestValue)>0)
			{
				$replytext1.="\nBattery Status ".$sensor_Battery_LatestValue." V.";
			}
			if(strlen($sensor_Flow_LatestValue)>0)
			{
				$replytext1.="\nอัตราการไหล ".$sensor_Flow_LatestValue." ลบ.ม./ชม.";
			}
			if(strlen($sensor_P2_LatestValue)>0)
			{
				$replytext1.="\nแรงดัน ".$sensor_P2_LatestValue." บาร์";
			}
			if(strlen($sensor_Volume_LatestValue)>0)
			{
				$replytext1.="\nเลขมาตรขึ้น ".$sensor_Volume_LatestValue." ลบ.ม.";
			}
		
		}
	}
	$replytext1.="\n______________\n";
	return $replytext1;
}