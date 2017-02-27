<?php

$access_token = 'RXhevaDMYFmImxZ2D7OlAY9OrrOmAL2yyIags1kFtCth/p8R2gtXZF8HAAz4NuIQN4JJO0BRStBrrvyXGFgoRXxTvIX0FRXtRvNXpaKnjtBhJT70n1gRMoVBsDD+qBrJudvuDn+ERXE1EzXZ1aNqMAdB04t89/1O/w1cDnyilFU=';

//$pushtext1="test";

//$pushtext="Temp=".$_GET["temp"]."\n";
//$pushtext.="Humi=".$_GET["humi"];

$content = file_get_contents('php://input');

//$myfile = fopen("esp.txt", "a");
//fwrite($myfile, $content);
//fclose($myfile);
$events = json_decode($content, true);
if (!is_null($events['events'])) 
{
	foreach ($events['events'] as $event) 
	{
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') 
		{
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			$textArr=explode(" ",$text);
			if(strtoupper($textArr[0])=="ALARM")
			{
				if(strtoupper($textArr[1])=="STATUS")
				{
					if(strlen($textArr[2])>0)
					{
						$content_alarm = file_get_contents('http://110.77.148.66/golf/setalarm.php?setalarm=status&apikey='.$textArr[2]);
						$arrAlarm = json_decode($content_alarm, true);
						$replytext="Device ID: ".strtoupper($arrAlarm["apikey"])."\n";
						if($arrAlarm["setalarm"]=="0")
							$replytext.="Alarm is OFF\n";
						elseif($arrAlarm["setalarm"]=="1")
							$replytext.="Alarm is ON\n";
						$replytext.="Temp set point is ".$arrAlarm["maxtemp"]." C\n";
						$replytext.="Humi set point is ".$arrAlarm["maxhumi"]." %";
					}
					else
					{
						$replytext="Device ID can not blank";
					}
	
				}
				elseif(strtoupper($textArr[1])=="ON")
				{
					if(strlen($textArr[2])>0)
					{
						$content_alarm = file_get_contents('http://110.77.148.66/golf/setalarm.php?setalarm=1&apikey='.$textArr[2]);
						$arrAlarm = json_decode($content_alarm, true);
						$replytext="Device ID: ".strtoupper($arrAlarm["apikey"])."\n";
						if($arrAlarm["status"]=="0")
							$replytext.="Alarm is OFF";
						elseif($arrAlarm["status"]=="1")
							$replytext.="Alarm is ON";
					}
					else
					{
						$replytext="Device ID can not blank";
					}
	
				}
				elseif(strtoupper($textArr[1])=="OFF")
				{
					if(strlen($textArr[2])>0)
					{
						$content_alarm = file_get_contents('http://110.77.148.66/golf/setalarm.php?setalarm=0&apikey='.$textArr[2]);
						$arrAlarm = json_decode($content_alarm, true);
						$replytext="Device ID: ".strtoupper($arrAlarm["apikey"])."\n";
						if($arrAlarm["status"]=="0")
							$replytext.="Alarm is OFF";
						elseif($arrAlarm["status"]=="1")
							$replytext.="Alarm is ON";
					}
					else
					{
						$replytext="Device ID can not blank";
					}
				}
				else
				{
					$replytext.="การปิด-เปิดการแจ้งเตือน\n";
					$replytext.="1. เปิดการแจ้งเตือน ให้ใช้คำสั่ง\n";
					$replytext.="alarm on\n";
					$replytext.="2. ปิดการแจ้งเตือน ให้ใช้คำสั่ง\n";
					$replytext.="alarm off\n";
					$replytext.="\n";
					$replytext.="การแสดงค่า config ที่ตั้งไว้ ให้ใช้คำสั่ง\n";
					$replytext.="alarm status";
				}
				$messages = [[
							'type' => 'text',
							'text' =>  $replytext
							]];
				
				
			}
			elseif(strtoupper($textArr[0])=="SET")
			{
				if(strtoupper($textArr[1])=="TEMP")
				{
					if(strlen($textArr[3])>0)
					{
						$content_alarm = file_get_contents('http://110.77.148.66/golf/settemp.php?settemp='.$textArr[2].'&apikey='.$textArr[3]);
						$arrAlarm = json_decode($content_alarm, true);
						$replytext="Device ID: ".strtoupper($arrAlarm["apikey"])."\n";
						$replytext.="Temp set point is ".$arrAlarm["maxtemp"]." C";
					}
					else
					{
						$replytext="Device ID can not blank";
					}
				}
				elseif(strtoupper($textArr[1])=="HUMI")
				{
					if(strlen($textArr[3])>0)
					{
						$content_alarm = file_get_contents('http://110.77.148.66/golf/sethumi.php?sethumi='.$textArr[2].'&apikey='.$textArr[3]);
						$arrAlarm = json_decode($content_alarm, true);
						$replytext="Device ID: ".strtoupper($arrAlarm["apikey"])."\n";
						$replytext.="Humi set point is ".$arrAlarm["maxhumi"]." %";
					}
					else
					{
						$replytext="Device ID can not blank";
					}
				}
				else
				{
					$replytext="การตั้งค่า\n";
					$replytext.="1. ตั้งจุดแจ้งเตือนสำหรับอุณหภูมิ ให้ใช้คำสั่ง\n";
					$replytext.="set temp {ค่าอุณหภูมิที่ต้องการตั้ง}\n";
					$replytext.="2. ตั้งจุดแจ้งเตือนสำหรับความชื้น ให้ใช้คำสั่ง\n";
					$replytext.="set humi {ค่าความชื้นที่ต้องการตั้ง}";
				}
				$messages = [[
							'type' => 'text',
							'text' =>  $replytext
							]];

			}
			elseif(strtoupper($textArr[0])=="SHOW")
			{
				if(strtoupper($textArr[1])=="NOW")
				{
					if(strlen($textArr[2])>0)
					{
						$content_alarm = file_get_contents('http://110.77.148.66/golf/shownow.php?apikey='.$textArr[2]);
						$arrAlarm = json_decode($content_alarm, true);
						$replytext="Device ID: ".strtoupper($arrAlarm["apikey"])."\n";
						$replytext.="Now ".$arrAlarm["dt"]."\n";
						$replytext.="Temp ".$arrAlarm["temp"]." C\n";
						$replytext.="Humi ".$arrAlarm["humi"]." %";
					}
					else
					{
						$replytext="Device ID can not blank";
					}
					$messages = [[
							'type' => 'text',
							'text' =>  $replytext
							]];
				}
				elseif(strtoupper($textArr[1])=="GP")
				{
					if(strlen($textArr[2])>0)
					{
						showgraph($textArr[2]);
					}
					else
					{
						$replytext="Device ID can not blank";
						$messages = [[
							'type' => 'text',
							'text' =>  $replytext
							]];
					}
				}
				else
				{
					$replytext="1. การแสดงค่าปัจจุบันให้ใช้คำสั่ง";
					$replytext.="show now {ID}\n";
					$replytext.="2. การแสดงกราฟให้ใช้คำสั่ง";
					$replytext.="show gp {ID}";
					$messages = [[
							'type' => 'text',
							'text' =>  $replytext
							]];
				}
				

			}
			elseif(strtoupper($textArr[0])=="HELP")
			{
				$replytext="การตั้งค่า\n";
				$replytext.="1. ตั้งจุดแจ้งเตือนสำหรับอุณหภูมิ ให้ใช้คำสั่ง\n";
				$replytext.="set temp {ค่าอุณหภูมิที่ต้องการตั้ง} {ID}\n";
				$replytext.="2. ตั้งจุดแจ้งเตือนสำหรับความชื้น ให้ใช้คำสั่ง\n";
				$replytext.="set humi {ค่าความชื้นที่ต้องการตั้ง} {ID}\n";
				$replytext.="\n";
				$replytext.="การแสดงค่าปัจจุบัน\n";
				$replytext.="1. แสดงค่า ให้ใช้คำสั่ง show now {ID}\n";
				$replytext.="1. แสดงกราฟ ให้ใช้คำสั่ง show gp {ID}\n";
				$replytext.="\n";
				$replytext.="การปิด-เปิดการแจ้งเตือน\n";
				$replytext.="1. เปิดการแจ้งเตือน ให้ใช้คำสั่ง\n";
				$replytext.="alarm on {ID}\n";
				$replytext.="2. ปิดการแจ้งเตือน ให้ใช้คำสั่ง\n";
				$replytext.="alarm off {ID}\n";
				$replytext.="\n";
				$replytext.="การแสดงค่า config ที่ตั้งไว้ ให้ใช้คำสั่ง\n";
				$replytext.="alarm status {ID}\n";
				$messages = [[
							'type' => 'text',
							'text' =>  $replytext
							]];
			}
			

			
			
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
else
{
	$content_alarm = file_get_contents('http://110.77.148.66/golf/shownow.php?apikey=a');
	print "\$content_alarm=$content_alarm";
	//$arrAlarm = json_decode($content_alarm, true);
						//$replytext="Device ID: ".strtoupper($arrAlarm["apikey"])."\n";
						//$replytext.="Now ".$arrAlarm["dt"]."\n";
						//$replytext.="Temp ".$arrAlarm["temp"]." C\n";
						//$replytext.="Humi ".$arrAlarm["humi"]." %";
						//print "\$replytext=$replytext";
	$pushtext="!!! ALARM !!!\n";
	$pushtext.="Device ID: ".strtoupper($_GET["apikey"])."\n";
	$pushtext.="Temp ".strtoupper($_GET["temp"])." C\n";
	$pushtext.="Humi ".strtoupper($_GET["humi"])." %";

	$messages = [[
						'type' => 'text',
						'text' =>  $pushtext
					]];

	// Make a POST Request to Messaging API to reply to sender
	$url = 'https://api.line.me/v2/bot/message/push';
	$to = 'U465eeabadd7be5ee0e4639da9c304d77'; //Golf
	$to = 'Cf844cf066da73bb9a8dc306d3af3eabf'; //กลุ่มการแจ้งเตือน
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
function thaitime($dt)
{
	$arrCurrentDT=explode(" ", $dt);
	$arrDate=explode("-", $arrCurrentDT[0]);
	$arrMonth=array();
	$arrMonth["01"] = "มกราคม";
	$arrMonth["02"] = "กุมภาพันธ์";
	$arrMonth["03"] = "มีนาคม";
	$arrMonth["04"] = "เมษายน";
	$arrMonth["05"] = "พฤษภาคม";
	$arrMonth["06"] = "มิถุนายน";
	$arrMonth["07"] = "กรกฎาคม";
	$arrMonth["08"] = "สิงหาคม";
	$arrMonth["09"] = "กันยายน";
	$arrMonth["10"] = "ตุลาคม";
	$arrMonth["11"] = "พฤศจิกายน";
	$arrMonth["12"] = "ธันวาคม";

	$arrTime=explode(":", $arrCurrentDT[1]);



	return($arrDate[2]." ".$arrMonth[$arrDate[1]]." ".$arrDate[0]." เวลา ".$arrTime[0].".".$arrTime[1]." น.");
}
function showgraph($deviceid)
{

	global $messages;
	$content = file_get_contents('http://110.77.148.66/golf/g1.php?deviceid='.$deviceid);
	$data = json_decode($content, true);
	$currentDT=thaitime($data["CurrentTime"]);




	include( dirname(__file__).'/chartlogix.inc.php' );
	$graph = new BarChart();
	$graph->setDefaultFont ( 'fonts/PSL100.ttf' );
	$graph->setTitle( 'กราฟแสดงอุณหภูมิและความชื้นเฉลี่ยในแต่ละชั่วโมง ของ device ID : '. strtoupper($deviceid).' ณ '.$currentDT);
	$graph->setTitleStyle( 'fonts/PSL102.ttf', 22, 0x000000 );



	//echo $data["Cols"][5];
								


	//$graph->addColumns( $data["Cols"] );

	for( $i = 0; $i < count($data["Cols"]); $i++ )
	{
		$graph->addColumns( $data["Cols"][$i] );
	}

	$graph->setBackground( 0xFFFFFF, 0xE0E0EE );


	$graph->setStackedBarOverlap( 0 );

	$graph->setLegendWidth( 25 );

	$graph->setXAxisTextStyle( 'fonts/PSL100.ttf', 14, 0x000000,90 );
	$graph->setYAxisTextStyle( 'fonts/PSL100.ttf', 18, 0x000000 );

	$graph->setXAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );
	$graph->setYAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );




	$graph->clearAxes();

	$graph->setLeftAxis( 'y', 'up', 'อุณหภูมิ' );
	$graph->setRightAxis( 'y', 'up', 'ความชื้น' );
	$graph->setLeftAxisTitle( 'อุณหภูมิ' ); 
	$graph->setRightAxisTitle( 'ความชื้น' );
		//$graph->setTopAxis( 'x', 'left', 'Month in 2006' );
	$graph->setBottomAxis( 'x', 'left' );
	$graph->setBottomAxisTitle( 'ช่วงเวลาแต่ละชั่วโมง' ); 
	$graph->setValueStyle ( 'fonts/PSL100.ttf', 13, 0x000000, 1, 0 );

	//  อุณหภูมิ
	$graph->doLineSeries( 'อุณหภูมิ' );
	$graph->setLineColour( 0x009900, 0x009900 );

	$graph->setLineStyle( 2, 8 );

	for( $i = 0; $i < count($data["Temp"]); $i++ )
	{
		$graph->addData( $data["Cols"][$i], $data["Temp"][$i] );
	}


	//  ความชื้น
	$graph->doLineSeries( 'ความชื้น' );
	$graph->setLineColour( 0x0066FF, 0x0033CC );

	for( $i = 0; $i < count($data["Humi"]); $i++ )
	{
		$graph->addData( $data["Cols"][$i], $data["Humi"][$i] );
	}

	$graph->setColumnSpacing( 0 );
	$graph->setLegendPosition( 1, 1 );
	$graph->setLegendWidth( 10 );


	//$graph->drawJPEG( 1024, 720 );
	$graph->saveJPEG( 'images/chart'.$deviceid.'.jpg', 1024, 720 );
	resize("images/chart".$deviceid.".jpg","images/thumb_chart".$deviceid.".jpg",240);
	$messages = [[
					'type' => 'image',
					'originalContentUrl' =>  'https://scada.pwa.co.th/golf/images/chart'.$deviceid.'.jpg',
					'previewImageUrl' =>  'https://scada.pwa.co.th/golf/images/thumb_chart'.$deviceid.'.jpg'
				]];

}
echo "OK";

