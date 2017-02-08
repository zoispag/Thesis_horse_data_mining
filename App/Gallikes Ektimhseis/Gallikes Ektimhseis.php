<?php	set_time_limit(0);
require_once(__DIR__."\\..\\Vars.php");


$fileDir = __DIR__."\\..\\~tmp\\";


if(isset($_REQUEST["Run"])) {
	if(implode((array)$_REQUEST["Links"])) {
		foreach($_REQUEST["Order"] as $OrdersCount => $Orders)
			foreach($Orders as $OrderCount => $Order)
				if($Order && preg_match("'\d+'uis", $Order))
					$Links[$_REQUEST["Links"][$OrdersCount][$OrderCount]] = $Order - 1;
		$Links = array_flip((array)$Links);
		//print("<pre>"); var_dump($Links); print("</pre>"); exit();
		if(stristr(current($Links), "france-galop.com"))
			include("FranceGalop.php");
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
$PageLink = "http://www.france-galop.com/en/racing/other-dates";
$PageData = LinkData($PageLink);
//print("<pre>"); var_dump($PageData); print("</pre>"); exit();
if(!$PageData) {
	$EchoError .= "<strong>Παρουσιάστηκε σφάλμα!</strong> Επισκευτείτε την ιστοσελίδα για να βεβαιωθείτε πως μπορείτε να συνδεθείτε.";
	goto End;
}

$EchoMiddle .= RacingHead($_REQUEST["Date"]);

unset($Track, $scrap, $i);
foreach($PageData->evaluate(".//div[@class='table']//tr[normalize-space(td)='".date("d/m/Y", strtotime($_REQUEST["Date"]))."' or preceding-sibling::*[normalize-space(td)='".date("d/m/Y", strtotime($_REQUEST["Date"]))."'] and following-sibling::*[normalize-space(td)='".date("d/m/Y", strtotime($_REQUEST["Date"]." +1 day"))."']]") as $i => $scrap) {
	$Track[$i] = $scrap;
}
//print("<pre>"); var_dump($Track); print("</pre>"); exit();

if(!$Track) {
	$EchoError .= "
		<a href='#' class='close' data-dismiss='alert' aria-label='close' target='_self'>&times;</a>
		Δεν υπάρχουν κούρσες για αυτή την ημερομηνία.
	";
	goto End;
}


unset($TrackName, $TrackLink, $TrackScrap, $iTrack);
foreach($Track as $iTrack => $TrackScrap) {
	unset($PageLinkInfo, $scrap);
	$PageLinkInfo = parse_url($PageLink);
	foreach($PageData->evaluate("./td[2]/a", $TrackScrap) as $scrap) {
		$TrackName[$iTrack] = FixSpaces($scrap->nodeValue);
		$TrackLink[$iTrack] = $scrap->getAttribute("href");
		$TrackLink[$iTrack] = $PageLinkInfo["scheme"]."://".$PageLinkInfo["host"].$TrackLink[$iTrack];
	}
	//print("<pre>"); var_dump($TrackName); print("</pre>"); exit();
	//print("<pre>"); var_dump($TrackLink); print("</pre>"); exit();
}


unset($TrackData);
$TrackData = MultiLinkData($TrackLink);

unset($TrackScrap, $iTrack);
unset($RaceLink, $RaceName, $RaceTime);
foreach($TrackData as $iTrack => $TrackDatum) {
	unset($PageLinkInfo, $scrap, $i);
	$PageLinkInfo = parse_url($PageLink);
	foreach($TrackDatum->evaluate(".//*[@class='table course']//td[3]/a") as $i => $scrap) {
		$RaceName[$iTrack][$i] = FixSpaces($scrap->nodeValue);
		$RaceName[$iTrack][$i] = ($i + 1).". ".$RaceName[$iTrack][$i];
		$RaceLink[$iTrack][$i] = $scrap->getAttribute("href");
		$RaceLink[$iTrack][$i] = $PageLinkInfo["scheme"]."://".$PageLinkInfo["host"].$RaceLink[$iTrack][$i];
	}
	//print("<pre>"); var_dump($RaceName[$iTrack]); print("</pre>"); exit();
	//print("<pre>"); var_dump($RaceLink[$iTrack]); print("</pre>"); exit();
	
	unset($scrap, $i);
	foreach($TrackDatum->evaluate(".//*[@class='table course']//td[1]") as $i => $scrap) {
		$RaceTime[$iTrack][$i] = FixSpaces($scrap->nodeValue);
		$RaceTime[$iTrack][$i] = preg_replace_callback("'(\d+)h(\d+)'uis", function($m) { return ($m[1] + 1).":".$m[2]; }, $RaceTime[$iTrack][$i]);
	}
	//print("<pre>"); var_dump($RaceTime[$iTrack]); print("</pre>"); exit();
}


$EchoMiddle .= RacingBody($_REQUEST["Date"], $TrackName, $RaceName, $RaceLink, $RaceTime);

End:
$EchoMiddle .= "<a class='btn btn-info' href='".$PageLink."'>Μετάβαση στην ιστοσελίδα της διοργανώτριας αρχής</a>";

print(Output($EchoError, $EchoTop, $EchoMiddle, $EchoBottom, $EchoScript));
unset($EchoError, $EchoTop, $EchoMiddle, $EchoBottom, $EchoScript);

?>