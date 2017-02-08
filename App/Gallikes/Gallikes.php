<?php	set_time_limit(0);
require_once(__DIR__."\\..\\Vars.php");


$fileDir = __DIR__."\\..\\~tmp\\";
$equDir = __DIR__."\\EquFiles\\";


if(isset($_REQUEST["Run"])) {
	if(implode((array)$_REQUEST["Links"])) {
		foreach($_REQUEST["Order"] as $OrdersCount => $Orders)
			foreach((array)$Orders as $OrderCount => $Order)
				if($Order && preg_match("'\d+'uis", $Order))
					$Links[$_REQUEST["Links"][$OrdersCount][$OrderCount]] = $Order - 1;
		$Links = array_flip((array)$Links);
		//print("<pre>"); var_dump($Links); print("</pre>"); exit();
		if(stristr(current($Links), "geny.com"))
			include("Geny.php");
	}
	$EchoError = $EchoError ?: "N0N";
}


Start:
session_id(SessionId());
session_start();
$_SESSION["InitialTime"] = $_SESSION["Progress"] = $_SESSION["Speed"] = $_SESSION["Time"] = 0;
session_commit();

$_REQUEST["Date"] = $_REQUEST["Date"] ? date("Y-m-d", strtotime($_REQUEST["Date"])) : date("Y-m-d");


unset($PageLink, $PageData);
$PageLink = "http://www.geny.com/reunions-courses-pmu?date=".$_REQUEST["Date"];
$PageData = LinkData($PageLink);
//print("<pre>"); var_dump($PageData); print("</pre>"); exit();
if(!$PageData) {
	$EchoError .= "<strong>Παρουσιάστηκε σφάλμα!</strong> Επισκευτείτε την ιστοσελίδα για να βεβαιωθείτε πως μπορείτε να συνδεθείτε.";
	goto End;
}

$EchoMiddle .= RacingHead($_REQUEST["Date"]);

unset($Track, $scrap, $i);
foreach($PageData->evaluate(".//div[@class='yui-gc cartoucheReunion']") as $i => $scrap) {
	$Track[$i] = FixSpaces($scrap->nodeValue);
}
//print("<pre>"); var_dump($Track); print("</pre>"); exit();

if(!$Track) {
	$EchoError .= "
		<a href='#' class='close' data-dismiss='alert' aria-label='close' target='_self'>&times;</a>
		Δεν υπάρχουν κούρσες για αυτή την ημερομηνία.
	";
	goto End;
}


unset($TrackIndex, $iTrack);
unset($TrackName, $RaceLink, $RaceName, $RaceTime);
foreach(array_keys($Track) as $iTrack => $TrackIndex) {
	unset($scrap);
	foreach($PageData->evaluate(".//div[@class='yui-gc cartoucheReunion'][".($TrackIndex + 1)."]/div[@class='yui-u first nomReunion']/text()[1]") as $scrap) {
		$TrackName[$iTrack] = FixSpaces($scrap->nodeValue);
		$TrackName[$iTrack] = preg_replace("'.*\s+:\s+'uis", "", $TrackName[$iTrack]);
		$TrackName[$iTrack] = str_ireplace("[Matinée]", "(Midi)", $TrackName[$iTrack]);
		$TrackName[$iTrack] = preg_replace("'\s+\[.*?\]'uis", "", $TrackName[$iTrack]);
	}
	//print("<pre>"); var_dump($TrackName[$iTrack]); print("</pre>"); exit();
	
	unset($scrap, $i);
	foreach($PageData->evaluate(".//li[@class!='btnPariez']/a/@href[starts-with(.,'/partants')][preceding::div[@class='yui-gc cartoucheReunion'][".($TrackIndex + 1)."] and not(preceding::div[@class='yui-gc cartoucheReunion'][".($TrackIndex + 2)."])]") as $i => $scrap) {
		$RaceLink[$iTrack][$i] = $scrap->nodeValue;
		$RaceLink[$iTrack][$i] = "http://".current(array_slice(explode("/", $PageLink), 2)).$RaceLink[$iTrack][$i];
	}
	//print("<pre>"); var_dump($RaceLink[$iTrack]); print("</pre>"); exit();
	
	unset($scrap, $i);
	foreach($PageData->evaluate(".//div[@class='yui-u first nomCourse'][preceding::div[@class='yui-gc cartoucheReunion'][".($TrackIndex + 1)."] and not(preceding::div[@class='yui-gc cartoucheReunion'][".($TrackIndex + 2)."])]") as $i => $scrap) {
		$RaceName[$iTrack][$i] = FixSpaces($scrap->nodeValue);
		$RaceName[$iTrack][$i] = preg_replace("'^\d+\s+[-]\s+'uis", "", $RaceName[$iTrack][$i]);
		$RaceName[$iTrack][$i] = ($i + 1).". ".$RaceName[$iTrack][$i];
	}
	//print("<pre>"); var_dump($RaceName[$iTrack]); print("</pre>"); exit();
	
	unset($scrap, $i);
	foreach($PageData->evaluate(".//div[contains(@class,'btnArrivee')][preceding::div[@class='yui-gc cartoucheReunion'][".($TrackIndex + 1)."] and not(preceding::div[@class='yui-gc cartoucheReunion'][".($TrackIndex + 2)."])]") as $i => $scrap) {
		$RaceTime[$iTrack][$i] = FixSpaces($scrap->nodeValue);
		if($RaceTime[$iTrack][$i] == "annulée") $RaceTime[$iTrack][$i] = "ΑΚΥΡΩΘΗΚΕ!";
		else if(preg_match("'^[0-9- /]+$'uis", $RaceTime[$iTrack][$i])) $RaceTime[$iTrack][$i] = "Τελείωσε";
		else $RaceTime[$iTrack][$i] = preg_replace_callback("'(\d+).*?(\d+)h(\d+)'uis", function($m) {return ($m[2] + 1).":".$m[3]." (".$m[1]." Ίπποι)";}, $RaceTime[$iTrack][$i]);
	}
	//print("<pre>"); var_dump($RaceTime[$iTrack]); print("</pre>"); exit();
}


$EchoMiddle .= RacingBody($_REQUEST["Date"], $TrackName, $RaceName, $RaceLink, $RaceTime);

End:
$EchoMiddle .= "<a class='btn btn-info' href='".$PageLink."'>Μετάβαση στην ιστοσελίδα της διοργανώτριας αρχής</a>";

print(Output($EchoError, $EchoTop, $EchoMiddle, $EchoBottom, $EchoScript));
unset($EchoError, $EchoTop, $EchoMiddle, $EchoBottom, $EchoScript);

?>