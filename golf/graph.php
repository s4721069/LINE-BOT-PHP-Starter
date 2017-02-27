<?php
$deviceid=$_GET["deviceid"];
$content = file_get_contents('http://110.77.148.66/golf/g1.php?deviceid='.$deviceid);
$data = json_decode($content, true);
$currentDT=thaitime($data["CurrentTime"]);




include( dirname(__file__).'/chartlogix.inc.php' );
$graph = new BarChart();
$graph->setDefaultFont ( 'fonts/PSL100.ttf' );
$graph->setTitle( 'กราฟแสดงอุณหภูมิและความชื้นเฉลี่ยในแต่ละชั่วโมง ของ device ID : '. $deviceid.' ณ '.$currentDT);
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


$graph->drawJPEG( 1024, 720 );


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

?>