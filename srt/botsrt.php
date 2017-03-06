<?php

$access_token = 'GetTMp7MUnHI0c5JhOidQ8Vhp2sa96hGnfMjGq89KUT6luiflYZKTwTCrkXuES1DI4kg9Y5/dkDa5hZF/OfJ+MhzUsnnamUfcctnguRE3uYiPmhKA9ZiLRfIsiHShTGSdqVynUdOx7AC+u/36YBn4gdB04t89/1O/w1cDnyilFU=';


$content = file_get_contents('php://input');

//$myfile = fopen("esp.txt", "w");
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
			if(strtoupper($textArr[0])=="ROBOT")
			{

				if(strtoupper($textArr[1])=="CL")
				{
					$content_scada = file_get_contents('http://180.183.250.116/line/srt/q.php?z=cl');
					$arrSCADA = json_decode($content_scada, true);
					$replytext="ข้อมูลของสถานีจ่ายน้ำโฉลกรัฐ ณ ".$arrSCADA["DateTime"]."\n";
					$replytext.="-อัตราการจ่าย ".number_format($arrSCADA["SUICL_FT1_AINPUT_PV"],2)." ลบ.ม./ชม.\n";
					$replytext.="-เลขมาตรขึ้น ".$arrSCADA["SUICL_FT1_TOT"]." ลบ.ม.\n";
					$replytext.="-ระดับน้ำถังสูง ".number_format($arrSCADA["SUICL_LE1_AINPUT_PV"],2)." ม.";
					showgraph_cl();
					$messages = [[
								'type' => 'text',
								'text' =>  $replytext
								],[
								'type' => 'image',
								'originalContentUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/chart_cl_ft.jpg',
								'previewImageUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/thumb_chart_cl_ft.jpg'
								],[
								'type' => 'image',
								'originalContentUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/chart_cl_le.jpg',
								'previewImageUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/thumb_chart_cl_le.jpg'
								]];
	
				}
				elseif(strtoupper($textArr[1])=="KM5")
				{
					$content_scada = file_get_contents('http://180.183.250.116/line/srt/q.php?z=km5');
					$arrSCADA = json_decode($content_scada, true);
					$LE1_volume=$arrSCADA["KM5CW_LE1_AINPUT_PV"]*6000/4;
					$replytext1="ข้อมูลของสถานีจ่ายน้ำ กม.5 ณ ".$arrSCADA["DateTime"]."\n";
					$replytext1.="ระดับน้ำ\n";
					$replytext1.="-ถังน้ำใส คือ ".number_format($arrSCADA["KM5CW_LE1_AINPUT_PV"],2)." ม. หรือ ".number_format($LE1_volume,0)." ลบ.ม.\n";
					$replytext1.="-โรงกรอง 1600 (LE1) คือ ".number_format($arrSCADA["KM5WFT_LE1_AINPUT_PV"],2)." ม.\n";
					$replytext1.="-โรงกรอง 1600 (LE2) คือ ".number_format($arrSCADA["KM5WFT_LE2_AINPUT_PV"],2)." ม.\n";
					$replytext1.="-โรงกรอง 500 (LE3) คือ ".number_format($arrSCADA["KM5WFT_LE3_AINPUT_PV"],2)." ม.\n";
					$replytext1.="-โรงกรอง 500 (LE4) คือ ".number_format($arrSCADA["KM5WFT_LE4_AINPUT_PV"],2)." ม.";
					$replytext2="อัตราการจ่าย\n";
					$replytext2.="-น้ำดิบโรงกรอง 1600 คือ ".number_format($arrSCADA["KM5CHE_FT1_AINPUT_PV"],0)." ลบ.ม./ชม. เลขมาตรขึ้น ".$arrSCADA["KM5CHE_FE1_OUT_TOT"]."\n";
					$replytext2.="-น้ำดิบโรงกรอง 500 คือ ".number_format($arrSCADA["KM5WFT_FT1_AINPUT_PV"],0)." ลบ.ม./ชม.";
					$replytext3="แรงดัน\n";
					$replytext3.="-น้ำใสขึ้นท่ากูบ คือ ".number_format($arrSCADA["KM5CW_PT1_AINPUT_PV"],2)." บาร์\n";
					$replytext3.="-BOOSTER PUMP โรงจ่ายสารเคมี คือ ".number_format($arrSCADA["KM5CHE_PT1_AINPUT_PV"],2)." บาร์";
					$replytext4="คุณภาพน้ำ\n";
					$replytext4.="น้ำดิบ\n";
					$replytext4.="-TB ".number_format($arrSCADA["SUI_WFT2_TB_PV"],2)." NTU\n";
					$replytext4.="-CO ".number_format($arrSCADA["SUI_WFT2_COND_PV"],2)." µs/cm\n";
					$replytext4.="-pH ".number_format($arrSCADA["SUI_WFT2_PH_PV"],2)."\n";
					$replytext4.="น้ำประปา\n";
					$replytext4.="-TB ".number_format($arrSCADA["SUI_WFT1_TB_PV"],2)." NTU\n";
					$replytext4.="-CL ".number_format($arrSCADA["SUI_WFT1_CL_PV"],2)." mg/L";
					$tmp=file_get_contents('http://180.183.250.116/line/srt/pumprun.php?z=km5');
					file_put_contents("pictures/srt_km5.jpg", fopen("http://180.183.250.116/line/srt/srt_km5.jpg", 'r'));
					resize("pictures/srt_km5.jpg","pictures/thumb_srt_km5.jpg",240);
					$messages = [[
								'type' => 'text',
								'text' =>  $replytext1
								],[
								'type' => 'text',
								'text' =>  $replytext2
								],[
								'type' => 'text',
								'text' =>  $replytext3
								],[
								'type' => 'text',
								'text' =>  $replytext4
								],[
								'type' => 'image',
								'originalContentUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/pictures/srt_km5.jpg',
								'previewImageUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/pictures/thumb_srt_km5.jpg'
								]];
	
				}
				elseif(strtoupper($textArr[1])=="TK")
				{
					$content_scada = file_get_contents('http://180.183.250.116/line/srt/q.php?z=tk');
					$arrSCADA = json_decode($content_scada, true);
					$LE1_volume=$arrSCADA["SUITK_LE1_AINPUT_PV"]*11000/4.5;
					$replytext1="ข้อมูลของสถานีจ่ายน้ำท่ากูบ ณ ".$arrSCADA["DateTime"]."\n";
					$replytext1.="ระดับน้ำ\n";
					$replytext1.="-ถังน้ำใส คือ ".number_format($arrSCADA["SUITK_LE1_AINPUT_PV"],2)." ม. หรือ ".number_format($LE1_volume,0)." ลบ.ม.";
					showgraph_tk();
					$messages = [[
								'type' => 'text',
								'text' =>  $replytext1
								],[
								'type' => 'image',
								'originalContentUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/chart_tk_le.jpg',
								'previewImageUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/thumb_chart_tk_le.jpg'
								]];
	
				}
				elseif(strtoupper($textArr[1])=="TT")
				{
					$content_scada = file_get_contents('http://180.183.250.116/line/srt/q.php?z=tt');
					$arrSCADA = json_decode($content_scada, true);
					$LE1_volume=$arrSCADA["SUITT_LE1_AINPUT_PV"]*2000/4;
					$replytext1="ข้อมูลของสถานีจ่ายน้ำท่าทองใหม่ ณ ".$arrSCADA["DateTime"]."\n";
					$replytext1.="ระดับน้ำ\n";
					$replytext1.="-ถังน้ำใส คือ ".number_format($arrSCADA["SUITT_LE1_AINPUT_PV"],2)." ม. หรือ ".number_format($LE1_volume,0)." ลบ.ม.";
					showgraph_tt();
					$messages = [[
								'type' => 'text',
								'text' =>  $replytext1
								],[
								'type' => 'image',
								'originalContentUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/chart_tt_le.jpg',
								'previewImageUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/thumb_chart_tt_le.jpg'
								]];
	
				}
				elseif(strtoupper($textArr[1])=="TL")
				{
					$content_scada = file_get_contents('http://180.183.250.116/line/srt/q.php?z=tl');
					$arrSCADA = json_decode($content_scada, true);
					$replytext1="ข้อมูลของสถานีสูบน้ำดิบตลิ่งชัน ณ ".$arrSCADA["DateTime"]."\n";
					$replytext1.="-ระดับน้ำดิบ คือ ".number_format($arrSCADA["SUITL_LE1_AINPUT_PV"],2)." ม.\n";
					$replytext1.="-TB คือ ".number_format($arrSCADA["SUITL_TB_AINPUT_PV"],2)." NTU\n";
					$replytext1.="-DO คือ ".number_format($arrSCADA["SUITL_DO_AINPUT_PV"],2)." mg/L\n";
					$replytext1.="-CO คือ ".number_format($arrSCADA["SUITL_CO_AINPUT_PV"],2)." µs/cm";
					showgraph_tl();
					$tmp=file_get_contents('http://180.183.250.116/line/srt/pumprun.php?z=tl');
					file_put_contents("pictures/srt_tl.jpg", fopen("http://180.183.250.116/line/srt/srt_tl.jpg", 'r'));
					resize("pictures/srt_tl.jpg","pictures/thumb_srt_tl.jpg",240);
					$messages = [[
								'type' => 'text',
								'text' =>  $replytext1
								],[
								'type' => 'image',
								'originalContentUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/chart_tl_tb.jpg',
								'previewImageUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/thumb_chart_tl_tb.jpg'
								],[
								'type' => 'image',
								'originalContentUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/chart_tl_le.jpg',
								'previewImageUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/thumb_chart_tl_le.jpg'
								],[
								'type' => 'image',
								'originalContentUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/pictures/srt_tl.jpg',
								'previewImageUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/pictures/thumb_srt_tl.jpg'
								]];
	
				}
				elseif(strtoupper($textArr[1])=="MB")
				{
					$content_scada = file_get_contents('http://180.183.250.116/line/srt/q.php?z=mb');
					$arrSCADA = json_decode($content_scada, true);
					$LE1_volume=$arrSCADA["SUIMB_PRESSURE01"]*1000/3.5;
					$replytext1="ข้อมูลของ Mobile Plant ณ ".$arrSCADA["DateTime"]."\n";
					$replytext1.="-อัตราการสูบน้ำดิบ คือ ".number_format($arrSCADA["SUIMB_FLOW01_IN"],0)." ลบ.ม./ชม.\n";
					$replytext1.="-เลขมาตรรวมน้ำดิบ คือ ".number_format($arrSCADA["SUIMB_FLOW01_TOTAL"],0)." ลบ.ม.\n";
					$replytext1.="-อัตราการจ่ายน้ำประปา คือ ".number_format($arrSCADA["SUIMB_FLOW02_OUT"],0)." ลบ.ม./ชม.\n";
					$replytext1.="-เลขมาตรรวมน้ำประปา คือ ".number_format($arrSCADA["SUIMB_FLOW02_TOTAL"],0)." ลบ.ม.\n";
					$replytext1.="-ถังน้ำใส คือ ".number_format($arrSCADA["SUIMB_PRESSURE01"],2)." เมตร หรือ ".number_format($LE1_volume,0)." ลบ.ม.";
					showgraph_mb();
					$messages = [[
								'type' => 'text',
								'text' =>  $replytext1
								],[
								'type' => 'image',
								'originalContentUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/chart_mb_ft1.jpg',
								'previewImageUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/thumb_chart_mb_ft1.jpg'
								],[
								'type' => 'image',
								'originalContentUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/chart_mb_ft2.jpg',
								'previewImageUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/thumb_chart_mb_ft2.jpg'
								],[
								'type' => 'image',
								'originalContentUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/chart_mb_le.jpg',
								'previewImageUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/thumb_chart_mb_le.jpg'
								]];
	
				}
				elseif(strtoupper($textArr[1])=="PP")
				{
					$content_scada = file_get_contents('http://180.183.250.116/line/srt/q.php?z=pp');
					$arrSCADA = json_decode($content_scada, true);
					$PPCW1_LE1_volume=$arrSCADA["PPCW1_LE1_AINPUT_PV"]*3000/5;
					$PPCW2_LE1_volume=$arrSCADA["PPCW2_LE1_AINPUT_PV"]*1500/3.5;
					$PPCW2_LE2_volume=$arrSCADA["PPCW2_LE2_AINPUT_PV"]*120/3.4;
					$replytext1="ข้อมูลของสถานีจ่ายน้ำพุนพิน ณ ".$arrSCADA["DateTime"]."\n";
					$replytext1="ปริมาณน้ำ\n";
					$replytext1.="-ถังน้ำใส 3000 ลบ.ม. คือ ".number_format($arrSCADA["PPCW1_LE1_AINPUT_PV"],2)." เมตร หรือ ".number_format($PPCW1_LE1_volume,0)." ลบ.ม.\n";
					$replytext1.="-ถังน้ำใส 1500 ลบ.ม. คือ ".number_format($arrSCADA["PPCW2_LE1_AINPUT_PV"],2)." เมตร หรือ ".number_format($PPCW2_LE1_volume,0)." ลบ.ม.\n";
					$replytext1.="-ถังสูง คือ ".number_format($arrSCADA["PPCW2_LE2_AINPUT_PV"],2)." เมตร หรือ ".number_format($PPCW2_LE2_volume,0)." ลบ.ม.\n";
					$replytext1.="-ระดับน้ำโรงกรอง 600 ลบ.ม. (Level 1) คือ ".number_format($arrSCADA["SUIPP_WFT_LE1_AINPUT_PV"],2)." ม.\n";
					$replytext1.="-ระดับน้ำโรงกรอง 600 ลบ.ม. (Level 2) คือ ".number_format($arrSCADA["SUIPP_WFT_LE2_AINPUT_PV"],2)." ม.\n";
					$replytext1.="-ระดับน้ำโรงกรอง 250 ลบ.ม. (Level 3) คือ ".number_format($arrSCADA["SUIPP_WFT_LE3_AINPUT_PV"],2)." ม.\n";
					$replytext1.="-ระดับน้ำโรงกรอง 250 ลบ.ม. (Level 4) คือ ".number_format($arrSCADA["SUIPP_WFT_LE4_AINPUT_PV"],2)." ม.";
					$replytext2="อัตราการจ่าย\n";
					$replytext2.="-อัตราการสูบน้ำดิบโรงกรอง 600 ลบ.ม. คือ ".number_format($arrSCADA["PPCW1_FT1_AINPUT_PV"],0)." ลบ.ม./ชม.\n";
					$replytext2.="-เลขมาตรรวมน้ำดิบโรงกรอง 600 ลบ.ม. คือ ".number_format($arrSCADA["PPCW1_FT1_SUM_TOT"],0)." ลบ.ม.\n";
					$replytext2.="-อัตราการสูบน้ำดิบโรงกรอง 250 ลบ.ม. คือ ".number_format($arrSCADA["PPCW1_FT2_AINPUT_PV"],0)." ลบ.ม./ชม.\n";
					$replytext2.="-เลขมาตรรวมน้ำดิบโรงกรอง 250 ลบ.ม. คือ ".number_format($arrSCADA["PPCW1_FT2_SUM_TOT"],0)." ลบ.ม.";
					$replytext3="คุณภาพน้ำดิบ\n";
					$replytext3.="-TB ".number_format($arrSCADA["PPCW1_TB_AINPUT_PV"],2)." NTU\n";
					$replytext3.="-DO ".number_format($arrSCADA["PPCW1_DO_AINPUT_PV"],2)."  mg/L\n";
					$replytext3.="-pH ".number_format($arrSCADA["PPCW1_PH_AINPUT_PV"],2);
					
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
	
				}
				elseif(strtoupper($textArr[1])=="TC")
				{
					$content_scada = file_get_contents('http://180.183.250.116/line/srt/q.php?z=tc');
					$arrSCADA = json_decode($content_scada, true);
					$LE1_volume=$arrSCADA["SUITC_LE1_AINPUT_PV"]*500/4;
					$replytext1="ข้อมูลของสถานีจ่ายน้ำท่าฉาง ณ ".$arrSCADA["DateTime"]."\n";
					$replytext1.="-ถังน้ำใส คือ ".number_format($arrSCADA["SUITC_LE1_AINPUT_PV"],2)." เมตร หรือ ".number_format($LE1_volume,0)." ลบ.ม.\n";
					$replytext1.="-อัตราการไหลมาตรรับน้ำจาก Mobile Plant คือ ".number_format($arrSCADA["SUITC_FT1_AINPUT_PV"],0)." ลบ.ม./ชม.\n";
					$replytext1.="-เลขมาตรรวมมาตรรับน้ำจาก Mobile Plant คือ ".number_format($arrSCADA["SUITC_FT1_TOT"],0)." ลบ.ม.";
					showgraph_tc();
					$messages = [[
								'type' => 'text',
								'text' =>  $replytext1
								],[
								'type' => 'image',
								'originalContentUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/chart_tc_ft.jpg',
								'previewImageUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/thumb_chart_tc_ft.jpg'
								],[
								'type' => 'image',
								'originalContentUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/chart_tc_le.jpg',
								'previewImageUrl' =>  'https://immense-lake-22116.herokuapp.com/srt/images/thumb_chart_tc_le.jpg'
								]];
	
				}
				elseif(strtoupper($textArr[1])=="SP")
				{
					$content_scada = file_get_contents('http://180.183.250.116/line/srt/q.php?z=sp');
					$arrSCADA = json_decode($content_scada, true);
					$LE1_volume=$arrSCADA["SUISP_LE1_AINPUT_PV"]*2000/4.5;
					$replytext1="ข้อมูลของสถานีจ่ายน้ำแสงเพชร ณ ".$arrSCADA["DateTime"]."\n";
					$replytext1.="-ถังน้ำใส คือ ".number_format($arrSCADA["SUISP_LE1_AINPUT_PV"],2)." เมตร หรือ ".number_format($LE1_volume,0)." ลบ.ม.\n";
					$replytext1.="-อัตราการไหลมาตรรับน้ำจากท่ากูบ คือ ".number_format($arrSCADA["SUISP_FT4_AINPUT_PV"],0)." ลบ.ม./ชม.\n";
					$replytext1.="-เลขมาตรรวมมาตรรับน้ำจากท่ากูบ คือ ".number_format($arrSCADA["SUISP_FT4_TOT"],0)." ลบ.ม.";
					//showgraph_sp();
					$messages = [[
								'type' => 'text',
								'text' =>  $replytext1
								]];
	
				}
				else
				{
					$replytext="ในขณะนี้ผมสามารถให้ข้อมูล ได้ดังนี้\n";
					$replytext.="1.สถานีจ่ายน้ำโฉลกรัฐ ให้ป้อน robot cl\n";
					$replytext.="2.สถานีจ่ายน้ำ กม.5 ให้ป้อน robot km5\n";
					$replytext.="3.สถานีจ่ายน้ำท่ากูบ ให้ป้อน robot tk\n";
					$replytext.="4.สถานีจ่ายน้ำท่าทองใหม่ ให้ป้อน robot tt\n";
					$replytext.="5.สถานีสูบน้ำดิบตลิ่งชัน ให้ป้อน robot tl\n";
					$replytext.="6.Mobile Plant ให้ป้อน robot mb\n";
					$replytext.="7.สถานีจ่ายน้ำพุนพิน ให้ป้อน robot pp\n";
					$replytext.="7.สถานีจ่ายน้ำท่าฉาง ให้ป้อน robot tc\n";
					$replytext.="8.สถานีจ่ายน้ำแสงเพชร ให้ป้อน robot sp";
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

}
function showgraph_cl()
{

	global $messages;
	$content = file_get_contents('http://180.183.250.116/line/srt/g1.php');
	$data = json_decode($content, true);
	$currentDT=thaitime($data["CurrentTime"]);




	include( dirname(__file__).'/chartlogix.inc.php' );
	$graph_FT1 = new BarChart();
	$graph_FT1->setDefaultFont ( 'fonts/PSL100.ttf' );
	$graph_FT1->setTitle( 'กราฟแสดงอัตราการจ่ายเฉลี่ยในแต่ละชั่วโมง ของ สถานีจ่ายน้ำโฉลกรัฐ ณ '.$currentDT);
	$graph_FT1->setTitleStyle( 'fonts/PSL102.ttf', 22, 0x000000 );



	//echo $data["Cols"][5];
								


	//$graph->addColumns( $data["Cols"] );

	for( $i = 0; $i < count($data["Cols"]); $i++ )
	{
		$graph_FT1->addColumns( $data["Cols"][$i] );
	}

	$graph_FT1->setBackground( 0xFFFFFF, 0xE0E0EE );


	$graph_FT1->setStackedBarOverlap( 0 );


	$graph_FT1->setXAxisTextStyle( 'fonts/PSL100.ttf', 14, 0x000000,90 );
	$graph_FT1->setYAxisTextStyle( 'fonts/PSL100.ttf', 18, 0x000000 );

	$graph_FT1->setXAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );
	$graph_FT1->setYAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );




	$graph_FT1->clearAxes();

	$graph_FT1->setLeftAxis( 'y', 'up', 'อัตราการจ่าย' );
	$graph_FT1->setLeftAxisTitle( 'อัตราการจ่าย (ลบ.ม./ชม.)' ); 


	$graph_FT1->setBottomAxis( 'x', 'left' );
	$graph_FT1->setBottomAxisTitle( 'ช่วงเวลาแต่ละชั่วโมง' ); 
	$graph_FT1->setValueStyle ( 'fonts/PSL100.ttf', 13, 0x000000, 1, 0 );

	//  อัตราการจ่าย
	$graph_FT1->doLineSeries( 'อัตราการจ่าย' );
	$graph_FT1->setLineColour( 0x009900, 0x009900 );

	$graph_FT1->setLineStyle( 2, 8 );

	for( $i = 0; $i < count($data["FT1"]); $i++ )
	{
		$graph_FT1->addData( $data["Cols"][$i], $data["FT1"][$i] );
	}



	$graph_FT1->setColumnSpacing( 0 );
	$graph_FT1->setLegendPosition( 1, 1 );
	$graph_FT1->setLegendWidth( 15 );


	//$graph->drawJPEG( 1024, 720 );
	$graph_FT1->saveJPEG( 'images/chart_cl_ft.jpg', 1024, 720 );
	resize("images/chart_cl_ft.jpg","images/thumb_chart_cl_ft.jpg",240);



	$graph_LE1 = new BarChart();
	$graph_LE1->setDefaultFont ( 'fonts/PSL100.ttf' );
	$graph_LE1->setTitle( 'กราฟแสดงระดับน้ำถังสูงเฉลี่ยในแต่ละชั่วโมง ของ สถานีจ่ายน้ำโฉลกรัฐ ณ '.$currentDT);
	$graph_LE1->setTitleStyle( 'fonts/PSL102.ttf', 22, 0x000000 );



	//echo $data["Cols"][5];
								


	//$graph->addColumns( $data["Cols"] );

	for( $i = 0; $i < count($data["Cols"]); $i++ )
	{
		$graph_LE1->addColumns( $data["Cols"][$i] );
	}

	$graph_LE1->setBackground( 0xFFFFFF, 0xE0E0EE );


	$graph_LE1->setStackedBarOverlap( 0 );


	$graph_LE1->setXAxisTextStyle( 'fonts/PSL100.ttf', 14, 0x000000,90 );
	$graph_LE1->setYAxisTextStyle( 'fonts/PSL100.ttf', 18, 0x000000 );

	$graph_LE1->setXAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );
	$graph_LE1->setYAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );




	$graph_LE1->clearAxes();

	$graph_LE1->setLeftAxis( 'y', 'up', 'ระดับน้ำถังสูง' );
	$graph_LE1->setLeftAxisTitle( 'ระดับน้ำถังสูง (เมตร)' ); 

	$graph_LE1->setBottomAxis( 'x', 'left' );
	$graph_LE1->setBottomAxisTitle( 'ช่วงเวลาแต่ละชั่วโมง' ); 
	$graph_LE1->setValueStyle ( 'fonts/PSL100.ttf', 13, 0x000000, 1, 0 );



	//  ระดับน้ำถังสูง
	$graph_LE1->doLineSeries( 'ระดับน้ำถังสูง' );
	$graph_LE1->setLineColour( 0x0066FF, 0x0033CC );

	for( $i = 0; $i < count($data["LE1"]); $i++ )
	{
		$graph_LE1->addData( $data["Cols"][$i], $data["LE1"][$i] );
	}

	$graph_LE1->setColumnSpacing( 0 );
	$graph_LE1->setLegendPosition( 1, 1 );
	$graph_LE1->setLegendWidth( 15 );


	//$graph->drawJPEG( 1024, 720 );
	$graph_LE1->saveJPEG( 'images/chart_cl_le.jpg', 1024, 720 );
	resize("images/chart_cl_le.jpg","images/thumb_chart_cl_le.jpg",240);
	

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
	$arrMonth["12"] = "ตุลาคม";

	$arrTime=explode(":", $arrCurrentDT[1]);



	return($arrDate[2]." ".$arrMonth[$arrDate[1]]." ".$arrDate[0]." เวลา ".$arrTime[0].".".$arrTime[1]." น.");
}
function showgraph_tk()
{

	global $messages;
	$content = file_get_contents('http://180.183.250.116/line/srt/g2.php');
	$data = json_decode($content, true);
	$currentDT=thaitime($data["CurrentTime"]);




	include( dirname(__file__).'/chartlogix.inc.php' );
	




	$graph_LE1 = new BarChart();
	$graph_LE1->setDefaultFont ( 'fonts/PSL100.ttf' );
	$graph_LE1->setTitle( 'กราฟแสดงปริมาณน้ำถังน้ำใสเฉลี่ยในแต่ละชั่วโมง ของ สถานีจ่ายน้ำท่ากูบ ณ '.$currentDT);
	$graph_LE1->setTitleStyle( 'fonts/PSL102.ttf', 22, 0x000000 );



	//echo $data["Cols"][5];
								


	//$graph->addColumns( $data["Cols"] );

	for( $i = 0; $i < count($data["Cols"]); $i++ )
	{
		$graph_LE1->addColumns( $data["Cols"][$i] );
	}

	$graph_LE1->setBackground( 0xFFFFFF, 0xE0E0EE );


	$graph_LE1->setStackedBarOverlap( 0 );


	$graph_LE1->setXAxisTextStyle( 'fonts/PSL100.ttf', 14, 0x000000,90 );
	$graph_LE1->setYAxisTextStyle( 'fonts/PSL100.ttf', 18, 0x000000 );

	$graph_LE1->setXAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );
	$graph_LE1->setYAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );




	$graph_LE1->clearAxes();

	$graph_LE1->setLeftAxis( 'y', 'up', 'ปริมาณน้ำในถังน้ำใส' );
	$graph_LE1->setLeftAxisTitle( 'ปริมาณน้ำในถังน้ำใส (ลบ.ม.)' ); 

	$graph_LE1->setBottomAxis( 'x', 'left' );
	$graph_LE1->setBottomAxisTitle( 'ช่วงเวลาแต่ละชั่วโมง' ); 
	$graph_LE1->setValueStyle ( 'fonts/PSL100.ttf', 13, 0x000000, 1, 0 );



	//  ระดับน้ำถังสูง
	$graph_LE1->doLineSeries( 'ปริมาณน้ำในถังน้ำใส' );
	$graph_LE1->setLineColour( 0x0066FF, 0x0033CC );

	for( $i = 0; $i < count($data["LE1"]); $i++ )
	{
		$graph_LE1->addData( $data["Cols"][$i], $data["LE1"][$i] );
	}

	$graph_LE1->setColumnSpacing( 0 );
	$graph_LE1->setLegendPosition( 1, 1 );
	$graph_LE1->setLegendWidth( 15 );


	//$graph->drawJPEG( 1024, 720 );
	$graph_LE1->saveJPEG( 'images/chart_tk_le.jpg', 1024, 720 );
	resize("images/chart_tk_le.jpg","images/thumb_chart_tk_le.jpg",240);
	

}

function showgraph_tt()
{

	global $messages;
	$content = file_get_contents('http://180.183.250.116/line/srt/g3.php');
	$data = json_decode($content, true);
	$currentDT=thaitime($data["CurrentTime"]);




	include( dirname(__file__).'/chartlogix.inc.php' );
	




	$graph_LE1 = new BarChart();
	$graph_LE1->setDefaultFont ( 'fonts/PSL100.ttf' );
	$graph_LE1->setTitle( 'กราฟแสดงปริมาณน้ำถังน้ำใสเฉลี่ยในแต่ละชั่วโมง ของ สถานีจ่ายน้ำท่าทองใหม่ ณ '.$currentDT);
	$graph_LE1->setTitleStyle( 'fonts/PSL102.ttf', 22, 0x000000 );



	//echo $data["Cols"][5];
								


	//$graph->addColumns( $data["Cols"] );

	for( $i = 0; $i < count($data["Cols"]); $i++ )
	{
		$graph_LE1->addColumns( $data["Cols"][$i] );
	}

	$graph_LE1->setBackground( 0xFFFFFF, 0xE0E0EE );


	$graph_LE1->setStackedBarOverlap( 0 );


	$graph_LE1->setXAxisTextStyle( 'fonts/PSL100.ttf', 14, 0x000000,90 );
	$graph_LE1->setYAxisTextStyle( 'fonts/PSL100.ttf', 18, 0x000000 );

	$graph_LE1->setXAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );
	$graph_LE1->setYAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );




	$graph_LE1->clearAxes();

	$graph_LE1->setLeftAxis( 'y', 'up', 'ปริมาณน้ำในถังน้ำใส' );
	$graph_LE1->setLeftAxisTitle( 'ปริมาณน้ำในถังน้ำใส (ลบ.ม.)' ); 

	$graph_LE1->setBottomAxis( 'x', 'left' );
	$graph_LE1->setBottomAxisTitle( 'ช่วงเวลาแต่ละชั่วโมง' ); 
	$graph_LE1->setValueStyle ( 'fonts/PSL100.ttf', 13, 0x000000, 1, 0 );



	//  ระดับน้ำถังสูง
	$graph_LE1->doLineSeries( 'ปริมาณน้ำในถังน้ำใส' );
	$graph_LE1->setLineColour( 0x0066FF, 0x0033CC );

	for( $i = 0; $i < count($data["LE1"]); $i++ )
	{
		$graph_LE1->addData( $data["Cols"][$i], $data["LE1"][$i] );
	}

	$graph_LE1->setColumnSpacing( 0 );
	$graph_LE1->setLegendPosition( 1, 1 );
	$graph_LE1->setLegendWidth( 15 );


	//$graph->drawJPEG( 1024, 720 );
	$graph_LE1->saveJPEG( 'images/chart_tt_le.jpg', 1024, 720 );
	resize("images/chart_tt_le.jpg","images/thumb_chart_tt_le.jpg",240);
	

}

function showgraph_tl()
{

	global $messages;
	$content = file_get_contents('http://180.183.250.116/line/srt/g4.php');
	$data = json_decode($content, true);
	$currentDT=thaitime($data["CurrentTime"]);




	include( dirname(__file__).'/chartlogix.inc.php' );
	$graph_TB1 = new BarChart();
	$graph_TB1->setDefaultFont ( 'fonts/PSL100.ttf' );
	$graph_TB1->setTitle( 'กราฟแสดงความขุ่นเฉลี่ยในแต่ละชั่วโมง ของ สถานีสูบน้ำดิบตลิ่งชัน ณ '.$currentDT);
	$graph_TB1->setTitleStyle( 'fonts/PSL102.ttf', 22, 0x000000 );



	//echo $data["Cols"][5];
								


	//$graph->addColumns( $data["Cols"] );

	for( $i = 0; $i < count($data["Cols"]); $i++ )
	{
		$graph_TB1->addColumns( $data["Cols"][$i] );
	}

	$graph_TB1->setBackground( 0xFFFFFF, 0xE0E0EE );


	$graph_TB1->setStackedBarOverlap( 0 );


	$graph_TB1->setXAxisTextStyle( 'fonts/PSL100.ttf', 14, 0x000000,90 );
	$graph_TB1->setYAxisTextStyle( 'fonts/PSL100.ttf', 18, 0x000000 );

	$graph_TB1->setXAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );
	$graph_TB1->setYAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );




	$graph_TB1->clearAxes();

	$graph_TB1->setLeftAxis( 'y', 'up', 'ความขุ่น' );
	$graph_TB1->setLeftAxisTitle( 'ความขุ่น (NTU)' ); 


	$graph_TB1->setBottomAxis( 'x', 'left' );
	$graph_TB1->setBottomAxisTitle( 'ช่วงเวลาแต่ละชั่วโมง' ); 
	$graph_TB1->setValueStyle ( 'fonts/PSL100.ttf', 13, 0x000000, 1, 0 );

	//  อัตราการจ่าย
	$graph_TB1->doLineSeries( 'ความขุ่น' );
	$graph_TB1->setLineColour( 0x009900, 0x009900 );

	$graph_TB1->setLineStyle( 2, 8 );

	for( $i = 0; $i < count($data["TB1"]); $i++ )
	{
		$graph_TB1->addData( $data["Cols"][$i], $data["TB1"][$i] );
	}



	$graph_TB1->setColumnSpacing( 0 );
	$graph_TB1->setLegendPosition( 1, 1 );
	$graph_TB1->setLegendWidth( 15 );


	//$graph->drawJPEG( 1024, 720 );
	$graph_TB1->saveJPEG( 'images/chart_tl_tb.jpg', 1024, 720 );
	resize("images/chart_tl_tb.jpg","images/thumb_chart_tl_tb.jpg",240);



	$graph_LE1 = new BarChart();
	$graph_LE1->setDefaultFont ( 'fonts/PSL100.ttf' );
	$graph_LE1->setTitle( 'กราฟแสดงระดับน้ำดิบเฉลี่ยในแต่ละชั่วโมง ของ สถานีสูบน้ำดิบตลิ่งชัน ณ '.$currentDT);
	$graph_LE1->setTitleStyle( 'fonts/PSL102.ttf', 22, 0x000000 );



	//echo $data["Cols"][5];
								


	//$graph->addColumns( $data["Cols"] );

	for( $i = 0; $i < count($data["Cols"]); $i++ )
	{
		$graph_LE1->addColumns( $data["Cols"][$i] );
	}

	$graph_LE1->setBackground( 0xFFFFFF, 0xE0E0EE );


	$graph_LE1->setStackedBarOverlap( 0 );


	$graph_LE1->setXAxisTextStyle( 'fonts/PSL100.ttf', 14, 0x000000,90 );
	$graph_LE1->setYAxisTextStyle( 'fonts/PSL100.ttf', 18, 0x000000 );

	$graph_LE1->setXAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );
	$graph_LE1->setYAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );




	$graph_LE1->clearAxes();

	$graph_LE1->setLeftAxis( 'y', 'up', 'ระดับน้ำดิบ' );
	$graph_LE1->setLeftAxisTitle( 'ระดับน้ำดิบ (เมตร)' ); 

	$graph_LE1->setBottomAxis( 'x', 'left' );
	$graph_LE1->setBottomAxisTitle( 'ช่วงเวลาแต่ละชั่วโมง' ); 
	$graph_LE1->setValueStyle ( 'fonts/PSL100.ttf', 13, 0x000000, 1, 0 );



	//  ระดับน้ำถังสูง
	$graph_LE1->doLineSeries( 'ระดับน้ำดิบ' );
	$graph_LE1->setLineColour( 0x0066FF, 0x0033CC );

	for( $i = 0; $i < count($data["LE1"]); $i++ )
	{
		$graph_LE1->addData( $data["Cols"][$i], $data["LE1"][$i] );
	}

	$graph_LE1->setColumnSpacing( 0 );
	$graph_LE1->setLegendPosition( 1, 1 );
	$graph_LE1->setLegendWidth( 15 );


	//$graph->drawJPEG( 1024, 720 );
	$graph_LE1->saveJPEG( 'images/chart_tl_le.jpg', 1024, 720 );
	resize("images/chart_tl_le.jpg","images/thumb_chart_tl_le.jpg",240);
	

}

function showgraph_mb()
{

	global $messages;
	$content = file_get_contents('http://180.183.250.116/line/srt/g5.php');
	$data = json_decode($content, true);
	$currentDT=thaitime($data["CurrentTime"]);




	include( dirname(__file__).'/chartlogix.inc.php' );
	$graph_FT1 = new BarChart();
	$graph_FT1->setDefaultFont ( 'fonts/PSL100.ttf' );
	$graph_FT1->setTitle( 'กราฟแสดงอัตราการสูบน้ำดิบเฉลี่ยในแต่ละชั่วโมง ของ Mobile Plant ณ '.$currentDT);
	$graph_FT1->setTitleStyle( 'fonts/PSL102.ttf', 22, 0x000000 );



	//echo $data["Cols"][5];
								


	//$graph->addColumns( $data["Cols"] );

	for( $i = 0; $i < count($data["Cols"]); $i++ )
	{
		$graph_FT1->addColumns( $data["Cols"][$i] );
	}

	$graph_FT1->setBackground( 0xFFFFFF, 0xE0E0EE );


	$graph_FT1->setStackedBarOverlap( 0 );


	$graph_FT1->setXAxisTextStyle( 'fonts/PSL100.ttf', 14, 0x000000,90 );
	$graph_FT1->setYAxisTextStyle( 'fonts/PSL100.ttf', 18, 0x000000 );

	$graph_FT1->setXAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );
	$graph_FT1->setYAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );




	$graph_FT1->clearAxes();

	$graph_FT1->setLeftAxis( 'y', 'up', 'อัตราการสูบน้ำดิบ' );
	$graph_FT1->setLeftAxisTitle( 'อัตราการสูบน้ำดิบ (ลบ.ม./ชม.)' ); 


	$graph_FT1->setBottomAxis( 'x', 'left' );
	$graph_FT1->setBottomAxisTitle( 'ช่วงเวลาแต่ละชั่วโมง' ); 
	$graph_FT1->setValueStyle ( 'fonts/PSL100.ttf', 13, 0x000000, 1, 0 );

	//  อัตราการจ่าย
	$graph_FT1->doLineSeries( 'อัตราการสูบน้ำดิบ' );
	$graph_FT1->setLineColour( 0x009900, 0x009900 );

	$graph_FT1->setLineStyle( 2, 8 );

	for( $i = 0; $i < count($data["FT1"]); $i++ )
	{
		$graph_FT1->addData( $data["Cols"][$i], $data["FT1"][$i] );
	}



	$graph_FT1->setColumnSpacing( 0 );
	$graph_FT1->setLegendPosition( 1, 1 );
	$graph_FT1->setLegendWidth( 15 );


	//$graph->drawJPEG( 1024, 720 );
	$graph_FT1->saveJPEG( 'images/chart_mb_ft1.jpg', 1024, 720 );
	resize("images/chart_mb_ft1.jpg","images/thumb_chart_mb_ft1.jpg",240);

	$graph_FT2 = new BarChart();
	$graph_FT2->setDefaultFont ( 'fonts/PSL100.ttf' );
	$graph_FT2->setTitle( 'กราฟแสดงอัตราการจ่ายน้ำประปาเฉลี่ยในแต่ละชั่วโมง ของ Mobile Plant ณ '.$currentDT);
	$graph_FT2->setTitleStyle( 'fonts/PSL102.ttf', 22, 0x000000 );



	//echo $data["Cols"][5];
								


	//$graph->addColumns( $data["Cols"] );

	for( $i = 0; $i < count($data["Cols"]); $i++ )
	{
		$graph_FT2->addColumns( $data["Cols"][$i] );
	}

	$graph_FT2->setBackground( 0xFFFFFF, 0xE0E0EE );


	$graph_FT2->setStackedBarOverlap( 0 );


	$graph_FT2->setXAxisTextStyle( 'fonts/PSL100.ttf', 14, 0x000000,90 );
	$graph_FT2->setYAxisTextStyle( 'fonts/PSL100.ttf', 18, 0x000000 );

	$graph_FT2->setXAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );
	$graph_FT2->setYAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );




	$graph_FT2->clearAxes();

	$graph_FT2->setLeftAxis( 'y', 'up', 'อัตราการจ่ายน้ำประปา' );
	$graph_FT2->setLeftAxisTitle( 'อัตราการจ่ายน้ำประปา (ลบ.ม./ชม.)' ); 


	$graph_FT2->setBottomAxis( 'x', 'left' );
	$graph_FT2->setBottomAxisTitle( 'ช่วงเวลาแต่ละชั่วโมง' ); 
	$graph_FT2->setValueStyle ( 'fonts/PSL100.ttf', 13, 0x000000, 1, 0 );

	//  อัตราการจ่าย
	$graph_FT2->doLineSeries( 'อัตราการจ่ายน้ำประปา' );
	$graph_FT2->setLineColour( 0x009900, 0x009900 );

	$graph_FT2->setLineStyle( 2, 8 );

	for( $i = 0; $i < count($data["FT2"]); $i++ )
	{
		$graph_FT2->addData( $data["Cols"][$i], $data["FT2"][$i] );
	}



	$graph_FT2->setColumnSpacing( 0 );
	$graph_FT2->setLegendPosition( 1, 1 );
	$graph_FT2->setLegendWidth( 15 );


	//$graph->drawJPEG( 1024, 720 );
	$graph_FT2->saveJPEG( 'images/chart_mb_ft2.jpg', 1024, 720 );
	resize("images/chart_mb_ft2.jpg","images/thumb_chart_mb_ft2.jpg",240);



	$graph_LE1 = new BarChart();
	$graph_LE1->setDefaultFont ( 'fonts/PSL100.ttf' );
	$graph_LE1->setTitle( 'กราฟแสดงปริมาณน้ำถังน้ำใสเฉลี่ยในแต่ละชั่วโมง ของ Mobile Plant ณ '.$currentDT);
	$graph_LE1->setTitleStyle( 'fonts/PSL102.ttf', 22, 0x000000 );



	//echo $data["Cols"][5];
								


	//$graph->addColumns( $data["Cols"] );

	for( $i = 0; $i < count($data["Cols"]); $i++ )
	{
		$graph_LE1->addColumns( $data["Cols"][$i] );
	}

	$graph_LE1->setBackground( 0xFFFFFF, 0xE0E0EE );


	$graph_LE1->setStackedBarOverlap( 0 );


	$graph_LE1->setXAxisTextStyle( 'fonts/PSL100.ttf', 14, 0x000000,90 );
	$graph_LE1->setYAxisTextStyle( 'fonts/PSL100.ttf', 18, 0x000000 );

	$graph_LE1->setXAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );
	$graph_LE1->setYAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );




	$graph_LE1->clearAxes();

	$graph_LE1->setLeftAxis( 'y', 'up', 'ปริมาณน้ำถังน้ำใส' );
	$graph_LE1->setLeftAxisTitle( 'ปริมาณน้ำถังน้ำใส (ลบ.ม.)' ); 

	$graph_LE1->setBottomAxis( 'x', 'left' );
	$graph_LE1->setBottomAxisTitle( 'ช่วงเวลาแต่ละชั่วโมง' ); 
	$graph_LE1->setValueStyle ( 'fonts/PSL100.ttf', 13, 0x000000, 1, 0 );



	//  ระดับน้ำถังสูง
	$graph_LE1->doLineSeries( 'ปริมาณน้ำถังน้ำใส' );
	$graph_LE1->setLineColour( 0x0066FF, 0x0033CC );

	for( $i = 0; $i < count($data["LE1"]); $i++ )
	{
		$graph_LE1->addData( $data["Cols"][$i], $data["LE1"][$i] );
	}

	$graph_LE1->setColumnSpacing( 0 );
	$graph_LE1->setLegendPosition( 1, 1 );
	$graph_LE1->setLegendWidth( 15 );


	//$graph->drawJPEG( 1024, 720 );
	$graph_LE1->saveJPEG( 'images/chart_mb_le.jpg', 1024, 720 );
	resize("images/chart_mb_le.jpg","images/thumb_chart_mb_le.jpg",240);
	

}

function showgraph_tc()
{

	global $messages;
	$content = file_get_contents('http://180.183.250.116/line/srt/g6.php');
	$data = json_decode($content, true);
	$currentDT=thaitime($data["CurrentTime"]);




	include( dirname(__file__).'/chartlogix.inc.php' );
	$graph_FT1 = new BarChart();
	$graph_FT1->setDefaultFont ( 'fonts/PSL100.ttf' );
	$graph_FT1->setTitle( 'กราฟแสดงอัตราการไหลมาตรรับน้ำจาก Mobile Plant เฉลี่ยในแต่ละชั่วโมง ของ สถานีจ่ายน้ำท่าฉาง ณ '.$currentDT);
	$graph_FT1->setTitleStyle( 'fonts/PSL102.ttf', 18, 0x000000 );



	//echo $data["Cols"][5];
								


	//$graph->addColumns( $data["Cols"] );

	for( $i = 0; $i < count($data["Cols"]); $i++ )
	{
		$graph_FT1->addColumns( $data["Cols"][$i] );
	}

	$graph_FT1->setBackground( 0xFFFFFF, 0xE0E0EE );


	$graph_FT1->setStackedBarOverlap( 0 );


	$graph_FT1->setXAxisTextStyle( 'fonts/PSL100.ttf', 14, 0x000000,90 );
	$graph_FT1->setYAxisTextStyle( 'fonts/PSL100.ttf', 18, 0x000000 );

	$graph_FT1->setXAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );
	$graph_FT1->setYAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );




	$graph_FT1->clearAxes();

	$graph_FT1->setLeftAxis( 'y', 'up', 'อัตราการไหล' );
	$graph_FT1->setLeftAxisTitle( 'อัตราการไหล (ลบ.ม./ชม.)' ); 


	$graph_FT1->setBottomAxis( 'x', 'left' );
	$graph_FT1->setBottomAxisTitle( 'ช่วงเวลาแต่ละชั่วโมง' ); 
	$graph_FT1->setValueStyle ( 'fonts/PSL100.ttf', 13, 0x000000, 1, 0 );

	//  อัตราการจ่าย
	$graph_FT1->doLineSeries( 'อัตราการไหล' );
	$graph_FT1->setLineColour( 0x009900, 0x009900 );

	$graph_FT1->setLineStyle( 2, 8 );

	for( $i = 0; $i < count($data["FT1"]); $i++ )
	{
		$graph_FT1->addData( $data["Cols"][$i], $data["FT1"][$i] );
	}



	$graph_FT1->setColumnSpacing( 0 );
	$graph_FT1->setLegendPosition( 1, 1 );
	$graph_FT1->setLegendWidth( 15 );


	//$graph->drawJPEG( 1024, 720 );
	$graph_FT1->saveJPEG( 'images/chart_tc_ft.jpg', 1024, 720 );
	resize("images/chart_tc_ft.jpg","images/thumb_chart_tc_ft.jpg",240);



	$graph_LE1 = new BarChart();
	$graph_LE1->setDefaultFont ( 'fonts/PSL100.ttf' );
	$graph_LE1->setTitle( 'กราฟแสดงปริมาณน้ำถังน้ำใสเฉลี่ยในแต่ละชั่วโมง ของ สถานีจ่ายน้ำท่าฉาง ณ '.$currentDT);
	$graph_LE1->setTitleStyle( 'fonts/PSL102.ttf', 22, 0x000000 );



	//echo $data["Cols"][5];
								


	//$graph->addColumns( $data["Cols"] );

	for( $i = 0; $i < count($data["Cols"]); $i++ )
	{
		$graph_LE1->addColumns( $data["Cols"][$i] );
	}

	$graph_LE1->setBackground( 0xFFFFFF, 0xE0E0EE );


	$graph_LE1->setStackedBarOverlap( 0 );


	$graph_LE1->setXAxisTextStyle( 'fonts/PSL100.ttf', 14, 0x000000,90 );
	$graph_LE1->setYAxisTextStyle( 'fonts/PSL100.ttf', 18, 0x000000 );

	$graph_LE1->setXAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );
	$graph_LE1->setYAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );




	$graph_LE1->clearAxes();

	$graph_LE1->setLeftAxis( 'y', 'up', 'ปริมาณน้ำถังน้ำใส' );
	$graph_LE1->setLeftAxisTitle( 'ปริมาณน้ำถังน้ำใส (ลบ.ม.)' ); 

	$graph_LE1->setBottomAxis( 'x', 'left' );
	$graph_LE1->setBottomAxisTitle( 'ช่วงเวลาแต่ละชั่วโมง' ); 
	$graph_LE1->setValueStyle ( 'fonts/PSL100.ttf', 13, 0x000000, 1, 0 );



	//  ระดับน้ำถังสูง
	$graph_LE1->doLineSeries( 'ปริมาณน้ำถังน้ำใส' );
	$graph_LE1->setLineColour( 0x0066FF, 0x0033CC );

	for( $i = 0; $i < count($data["LE1"]); $i++ )
	{
		$graph_LE1->addData( $data["Cols"][$i], $data["LE1"][$i] );
	}

	$graph_LE1->setColumnSpacing( 0 );
	$graph_LE1->setLegendPosition( 1, 1 );
	$graph_LE1->setLegendWidth( 15 );


	//$graph->drawJPEG( 1024, 720 );
	$graph_LE1->saveJPEG( 'images/chart_tc_le.jpg', 1024, 720 );
	resize("images/chart_tc_le.jpg","images/thumb_chart_tc_le.jpg",240);
	

}

function showgraph_sp()
{

	global $messages;
	$content = file_get_contents('http://180.183.250.116/line/srt/g7.php');
	$data = json_decode($content, true);
	$currentDT=thaitime($data["CurrentTime"]);




	include( dirname(__file__).'/chartlogix.inc.php' );
	$graph_FT1 = new BarChart();
	$graph_FT1->setDefaultFont ( 'fonts/PSL100.ttf' );
	$graph_FT1->setTitle( 'กราฟแสดงอัตราการไหลมาตรรับน้ำจากท่ากูบ เฉลี่ยในแต่ละชั่วโมง ของ สถานีจ่ายน้ำแสงเพชร ณ '.$currentDT);
	$graph_FT1->setTitleStyle( 'fonts/PSL102.ttf', 18, 0x000000 );



	//echo $data["Cols"][5];
								


	//$graph->addColumns( $data["Cols"] );

	for( $i = 0; $i < count($data["Cols"]); $i++ )
	{
		$graph_FT1->addColumns( $data["Cols"][$i] );
	}

	$graph_FT1->setBackground( 0xFFFFFF, 0xE0E0EE );


	$graph_FT1->setStackedBarOverlap( 0 );


	$graph_FT1->setXAxisTextStyle( 'fonts/PSL100.ttf', 14, 0x000000,90 );
	$graph_FT1->setYAxisTextStyle( 'fonts/PSL100.ttf', 18, 0x000000 );

	$graph_FT1->setXAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );
	$graph_FT1->setYAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );




	$graph_FT1->clearAxes();

	$graph_FT1->setLeftAxis( 'y', 'up', 'อัตราการไหล' );
	$graph_FT1->setLeftAxisTitle( 'อัตราการไหล (ลบ.ม./ชม.)' ); 


	$graph_FT1->setBottomAxis( 'x', 'left' );
	$graph_FT1->setBottomAxisTitle( 'ช่วงเวลาแต่ละชั่วโมง' ); 
	$graph_FT1->setValueStyle ( 'fonts/PSL100.ttf', 13, 0x000000, 1, 0 );

	//  อัตราการจ่าย
	$graph_FT1->doLineSeries( 'อัตราการไหล' );
	$graph_FT1->setLineColour( 0x009900, 0x009900 );

	$graph_FT1->setLineStyle( 2, 8 );

	for( $i = 0; $i < count($data["FT1"]); $i++ )
	{
		$graph_FT1->addData( $data["Cols"][$i], $data["FT1"][$i] );
	}



	$graph_FT1->setColumnSpacing( 0 );
	$graph_FT1->setLegendPosition( 1, 1 );
	$graph_FT1->setLegendWidth( 15 );


	//$graph->drawJPEG( 1024, 720 );
	$graph_FT1->saveJPEG( 'images/chart_sp_ft.jpg', 1024, 720 );
	resize("images/chart_sp_ft.jpg","images/thumb_chart_sp_ft.jpg",240);



	$graph_LE1 = new BarChart();
	$graph_LE1->setDefaultFont ( 'fonts/PSL100.ttf' );
	$graph_LE1->setTitle( 'กราฟแสดงปริมาณน้ำถังน้ำใสเฉลี่ยในแต่ละชั่วโมง ของ สถานีจ่ายน้ำแสงเพชร ณ '.$currentDT);
	$graph_LE1->setTitleStyle( 'fonts/PSL102.ttf', 22, 0x000000 );



	//echo $data["Cols"][5];
								


	//$graph->addColumns( $data["Cols"] );

	for( $i = 0; $i < count($data["Cols"]); $i++ )
	{
		$graph_LE1->addColumns( $data["Cols"][$i] );
	}

	$graph_LE1->setBackground( 0xFFFFFF, 0xE0E0EE );


	$graph_LE1->setStackedBarOverlap( 0 );


	$graph_LE1->setXAxisTextStyle( 'fonts/PSL100.ttf', 14, 0x000000,90 );
	$graph_LE1->setYAxisTextStyle( 'fonts/PSL100.ttf', 18, 0x000000 );

	$graph_LE1->setXAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );
	$graph_LE1->setYAxisTitleStyle( 'fonts/PSL100.ttf', 20, '000000' );




	$graph_LE1->clearAxes();

	$graph_LE1->setLeftAxis( 'y', 'up', 'ปริมาณน้ำถังน้ำใส' );
	$graph_LE1->setLeftAxisTitle( 'ปริมาณน้ำถังน้ำใส (ลบ.ม.)' ); 

	$graph_LE1->setBottomAxis( 'x', 'left' );
	$graph_LE1->setBottomAxisTitle( 'ช่วงเวลาแต่ละชั่วโมง' ); 
	$graph_LE1->setValueStyle ( 'fonts/PSL100.ttf', 13, 0x000000, 1, 0 );



	//  ระดับน้ำถังสูง
	$graph_LE1->doLineSeries( 'ปริมาณน้ำถังน้ำใส' );
	$graph_LE1->setLineColour( 0x0066FF, 0x0033CC );

	for( $i = 0; $i < count($data["LE1"]); $i++ )
	{
		$graph_LE1->addData( $data["Cols"][$i], $data["LE1"][$i] );
	}

	$graph_LE1->setColumnSpacing( 0 );
	$graph_LE1->setLegendPosition( 1, 1 );
	$graph_LE1->setLegendWidth( 15 );


	//$graph->drawJPEG( 1024, 720 );
	$graph_LE1->saveJPEG( 'images/chart_sp_le.jpg', 1024, 720 );
	resize("images/chart_sp_le.jpg","images/thumb_chart_sp_le.jpg",240);
	

}

echo "OK";

