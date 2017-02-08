<?php	set_time_limit(0);
require_once(__DIR__."\\..\\Vars.php");


$fileDir = __DIR__."\\..\\~tmp\\";
$equDir = __DIR__."\\EquFiles\\";
$xmlDir = __DIR__."\\Xmls\\";


if(isset($_REQUEST["Run"])) {
	if(implode((array)$_REQUEST["Xmls"])) {
		foreach($_REQUEST["Order"] as $OrdersCount => $Orders)
			foreach($Orders as $OrderCount => $Order)
				if($Order && preg_match("'\d+'uis", $Order))
					$Xmls[$_REQUEST["Xmls"][$OrdersCount]][$OrderCount] = $Order - 1;
		//print("<pre>"); var_dump($Xmls); print("</pre>"); exit();
		if($Xmls) include("TabGoldXML.php");
	}
	$EchoError = $EchoError ?: "N0N";
}


Start:
session_id(SessionId());
session_start();
$_SESSION["InitialTime"] = $_SESSION["Progress"] = $_SESSION["Speed"] = $_SESSION["Time"] = 0;
session_commit();

$_REQUEST["Date"] = $_REQUEST["Date"] ? date("Y-m-d", strtotime($_REQUEST["Date"])) : date("Y-m-d");


unset($PageLink, $Xmls);
$PageLink = "http://www.tabgold.co.za/fixtures/".date("Ymd", strtotime($_REQUEST["Date"]));
$Xmls = XmlFiles($xmlDir, $_REQUEST["Date"]);
//print("<pre>"); var_dump($Xmls); print("</pre>"); exit();

$EchoMiddle .= RacingHead($_REQUEST["Date"]);

unset($XmlData, $Track, $iTrack);
foreach((array)$Xmls as $iTrack => $Xml) {
	$XmlData[$iTrack] = Xml2Xpath($Xml);
	
	unset($scrap, $i);
	foreach($XmlData[$iTrack]->evaluate("/TEMPLATE") as $i => $scrap) {
		if($XmlData[$iTrack]->evaluate(".//PARAMS/@VENUE", $scrap)->length) $Track[$iTrack] = $scrap;
	}
}
//print("<pre>"); var_dump($Track); print("</pre>"); exit();

if(!$Track) {
	$EchoError .= "
		<a href='#' class='close' data-dismiss='alert' aria-label='close' target='_self'>&times;</a>
		Δεν υπάρχουν κούρσες για αυτή την ημερομηνία.
	";
	goto End;
}


unset($TrackScrap, $iTrack);
unset($TrackName, $RaceTime, $RaceName);
foreach($Track as $iTrack => $TrackScrap) {
	unset($scrap);
	foreach($XmlData[$iTrack]->evaluate(".//PARAMS/@VENUE", $TrackScrap) as $scrap) {
		$TrackName[$iTrack] = FixSpaces($scrap->nodeValue);
		$TrackName[$iTrack] = preg_replace("'\s+.*'uis", "", $TrackName[$iTrack]);
	}
	//print("<pre>"); var_dump($TrackName[$iTrack]); print("</pre>"); exit;
	
	unset($scrap, $i);
	foreach($XmlData[$iTrack]->evaluate(".//RACE_HEADER_1_RACE_TIME", $TrackScrap) as $i => $scrap) {
		$RaceTime[$iTrack][$i] = FixSpaces($scrap->nodeValue);
		$RaceTime[$iTrack][$i] = date('H:i', strtotime("+1 hour", strtotime($RaceTime[$iTrack][$i])));
	}
	//print("<pre>"); var_dump($RaceTime[$iTrack]); print("</pre>"); exit;
	
	unset($scrap, $i);
	foreach($XmlData[$iTrack]->evaluate(".//RACE_HEADER_2_RACE_TITLE", $TrackScrap) as $i => $scrap) {
		$RaceName[$iTrack][$i] = FixSpaces($scrap->nodeValue);
		$RaceName[$iTrack][$i] = ($i + 1).". ".$RaceName[$iTrack][$i];
	}
	//print("<pre>"); var_dump($TrackRaces[$iTrack]); print("</pre>"); exit;
}


$EchoMiddle .= RacingBodyXmls($_REQUEST["Date"], $TrackName, $RaceName, $RaceTime, $Xmls);

End:
$EchoMiddle .= "<a class='btn btn-info' href='".$PageLink."'>Μετάβαση στην ιστοσελίδα της διοργανώτριας αρχής</a>";

print(Output($EchoError, $EchoTop, $EchoMiddle, $EchoBottom, $EchoScript));
unset($EchoError, $EchoTop, $EchoMiddle, $EchoBottom, $EchoScript);

?>