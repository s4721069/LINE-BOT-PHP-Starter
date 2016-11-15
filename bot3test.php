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

function f_meter($wwcode,$custcode)
{
	//1132296
	global $messages;
	$obj = file_get_contents('http://scada.pwa.co.th/gpsmeter/apiv2.php?service=getdata&custcode='.$custcode.'&branch='.$wwcode.'&fx=custcode');
	$arrObj=explode("mycallback(",$obj);
	$meter_data=json_decode(substr($arrObj[1],0,strlen($arrObj[1])-1), true);
	if($meter_data['status']=="success")
	{
		$replytext="ชื่อผู้ใช้น้ำ :".$meter_data['custname'];
		$messages = [[
			'type' => 'text',
			'text' =>  $replytext
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
