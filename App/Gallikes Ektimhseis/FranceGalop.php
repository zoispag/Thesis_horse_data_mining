<?php	//set_time_limit(900);

require_once(__DIR__."\\IdmlFunctions.php");


$file["Prototype"] = "_Prototype.idml";
$idml = new ZipArchive;
$idml->open($file["Prototype"]);
$file_DesignMap = $idml->getFromName('designmap.xml');
$file_Spread = $idml->getFromName('Spreads/Spread_1.xml');
$idml->close();

preg_match_all("'<idPkg:Story src=\"(Stories/Story_1_(.*?)[.]xml)\" />'uis", $file_DesignMap, $Stories);


$Day = str_replace(
	array("1", "2", "3", "4", "5", "6", "7"),
	array("Δευτέρας", "Τρίτης", "Τετάρτης", "Πέμπτης", "Παρασκευής", "Σαββάτου", "Κυριακής"),
	date("N", strtotime($Date))
);
$file["Main"] = $fileDir.Title()."_".$Day." (1).idml";
while(file_exists(iconv("UTF-8", "Greek", $file["Main"]))) {$file["Main"] = preg_replace_callback("'\s\((\d+)\)\.(.*)$'uis", function($m) {return " (".($m[1]+1).").".$m[2];}, $file["Main"]);}
copy($file["Prototype"], iconv("UTF-8", "Greek", $file["Main"]));
$idml = new ZipArchive;
$idml->open($file["Main"]);


unset($RaceData);
$RaceData = MultiLinkData($Links);

unset($totalCounts, $RaceDatum);
foreach((array)$RaceData as $RaceDatum)
	$totalCounts += $RaceDatum->evaluate("count(.//*[@class='table']//td[2]/a)");


unset($RaceDatum, $iRace);
foreach((array)$RaceData as $iRace => $RaceDatum) {
	//if($iRace != 2 - 1) continue;
	
	unset($RaceNumber);
	$RaceNumber = $iRace + 1;
	//print("<pre>"); var_dump($RaceNumber); print("</pre>"); exit();
	
	unset($TrackName, $RaceTitle, $scrap);
	foreach($RaceDatum->evaluate("(.//*[@class='content']//p)[2]") as $scrap) {
		$TrackName = FixSpaces($scrap->nodeValue);
		$TrackName = preg_replace("'.+,\s+(.+)$'uis", "$01", $TrackName);
		$RaceTitle =
			$TrackName
			."   -   ".
			str_replace(
				array("1", "2", "3", "4", "5", "6", "7"),
				array("ΔΕΥΤΕΡΑ", "ΤΡΙΤΗ", "ΤΕΤΑΡΤΗ", "ΠΕΜΠΤΗ", "ΠΑΡΑΣΚΕΥΗ", "ΣΑΒΒΑΤΟ", "ΚΥΡΙΑΚΗ"),
				date("N", strtotime($_REQUEST["Date"]))
			)
			." ".
			date("j/n", strtotime($_REQUEST["Date"]))
		;
	}
	//print("<pre>"); var_dump($TrackName); print("</pre>"); exit();
	//print("<pre>"); var_dump($RaceTitle); print("</pre>"); exit();
	
	
	unset($RaceName, $scrap);
	foreach($RaceDatum->evaluate(".//h1") as $scrap) {
		$RaceName = FixSpaces($scrap->nodeValue);
	}
	//print("<pre>"); var_dump($RaceName); print("</pre>"); exit();
	
	unset($RaceRange, $scrap);
	foreach($RaceDatum->evaluate("(//*[@class='content']//strong)[1]") as $scrap) {
		$RaceRange = FixSpaces($scrap->nodeValue);
		$RaceRange = preg_replace("'.+?[,]\s+(\d+)[.]?(\d+)?\s+meters.*'uis", "$01$02", $RaceRange);
	}
	//print("<pre>"); var_dump($RaceRange); print("</pre>"); exit();
	
	unset($HorseLink, $HorseDataLink, $scrap, $i);
	foreach($RaceDatum->evaluate(".//*[@class='table']//td[2]/a/@href") as $i => $scrap) {
		$HorseLink[$i] = FixSpaces($scrap->nodeValue);
		$HorseLink[$i] = "http://www.france-galop.com".$HorseLink[$i];
	}
	//print("<pre>"); var_dump($HorseLink); print("</pre>"); exit();
	
	unset($HorseRacesLink);
	$HorseRacesLink = str_ireplace("/horse/", "/frglp_global/ajax?module=cheval_performances&id=", $HorseLink);
	//print("<pre>"); var_dump($HorseRacesLink); print("</pre>"); exit();
	
	
	unset($HorseRacesData);
	$HorseRacesData = MultiLinkData($HorseRacesLink, false, true);
	
	unset($HorseRacesDatum, $iHorse);
	foreach((array)$HorseRacesData as $iHorse => $HorseRacesDatum) {
		//if($iHorse != 6 - 1) continue;
		
		
		CalcProgress($totalCounts, ++$currCount, "", "", $transferSpeed[$iHorse]);
		
		
		unset($HorseRacesDatumSwap, $HorseRacesDatumKeyName);
		$HorseRacesDatum = json_decode($HorseRacesDatum, true);
		foreach(array_keys((array)current($HorseRacesDatum)) as $HorseRacesDatumKeyName) {
			$HorseRacesDatumSwap[$HorseRacesDatumKeyName] = array_column($HorseRacesDatum, $HorseRacesDatumKeyName);
		}
		$HorseRacesDatum = $HorseRacesDatumSwap;
		//print("<pre>"); var_dump($HorseRacesDatum); print("</pre>"); exit();
		
		
		unset($HorseTopRate[$iHorse], $HorseTopDate[$iHorse], $HorseTopRateIndex);
		$HorseTopRateIndex = array_search(max($HorseRacesDatum["Valeur"] ?: array(0)), (array)$HorseRacesDatum["Valeur"]);
		$HorseTopRate[$iHorse] = $HorseRacesDatum["Valeur"][$HorseTopRateIndex];
		if($HorseTopRate[$iHorse] == "-") $HorseTopRate[$iHorse] = 0;
		if($HorseTopRate[$iHorse]) {
			$HorseTopRate[$iHorse] = number_format($HorseTopRate[$iHorse]/10, 1, ",", "");
			$HorseTopDate[$iHorse] = $HorseRacesDatum["DateReunion"][$HorseTopRateIndex];
			$HorseTopDate[$iHorse] = date("d/m/Y", strtotime($HorseTopDate[$iHorse]));
		}
		//print("<pre>"); var_dump($HorseTopRate[$iHorse]); print("</pre>"); exit();
		//print("<pre>"); var_dump($HorseTopDate[$iHorse]); print("</pre>"); exit();
		
		unset($HorseRaces[$iHorse]["All"], $HorseWins[$iHorse]["All"], $HorsePlaces[$iHorse]["All"], $HorseFinishCount);
		$HorseFinishCount = array_count_values((array)$HorseRacesDatum["NbPlace"]);
		$HorseRaces[$iHorse]["All"] = array_sum((array)$HorseFinishCount);
		$HorseWins[$iHorse]["All"] = $HorseFinishCount["01"] ?: 0;
		$HorsePlaces[$iHorse]["All"] = $HorseFinishCount["02"] + $HorseFinishCount["03"];
		//print("<pre>"); var_dump($HorseRaces[$iHorse]["All"]); print("</pre>"); exit();
		//print("<pre>"); var_dump($HorseWins[$iHorse]["All"]); print("</pre>"); exit();
		//print("<pre>"); var_dump($HorsePlaces[$iHorse]["All"]); print("</pre>"); exit();
		
		unset($HorseRaces[$iHorse]["Track"], $HorseWins[$iHorse]["Track"], $HorsePlaces[$iHorse]["Track"], $HorseFinishCount);
		$HorseFinishCount = array_count_values(array_intersect_key((array)$HorseRacesDatum["NbPlace"], array_intersect((array)$HorseRacesDatum["Hippodrome"], array($TrackName))));
		//print("<pre>"); var_dump($HorseFinishCount); print("</pre>"); exit();
		$HorseRaces[$iHorse]["Track"] = array_sum((array)$HorseFinishCount);
		$HorseWins[$iHorse]["Track"] = $HorseFinishCount["01"] ?: 0;
		$HorsePlaces[$iHorse]["Track"] = $HorseFinishCount["02"] + $HorseFinishCount["03"];
		//print("<pre>"); var_dump($HorseRaces[$iHorse]["Track"]); print("</pre>"); exit();
		//print("<pre>"); var_dump($HorseWins[$iHorse]["Track"]); print("</pre>"); exit();
		//print("<pre>"); var_dump($HorsePlaces[$iHorse]["Track"]); print("</pre>"); exit();
		
		unset($HorseRaces[$iHorse]["Range"], $HorseWins[$iHorse]["Range"], $HorsePlaces[$iHorse]["Range"], $HorseFinishCount);
		$HorseFinishCount = array_count_values(array_intersect_key((array)$HorseRacesDatum["NbPlace"], array_intersect((array)$HorseRacesDatum["DistanceParcouru"], array($RaceRange))));
		//print("<pre>"); var_dump($HorseFinishCount); print("</pre>"); exit();
		$HorseRaces[$iHorse]["Range"] = array_sum((array)$HorseFinishCount);
		$HorseWins[$iHorse]["Range"] = $HorseFinishCount["01"] ?: 0;
		$HorsePlaces[$iHorse]["Range"] = $HorseFinishCount["02"] + $HorseFinishCount["03"];
		//print("<pre>"); var_dump($HorseRaces[$iHorse]["Range"]); print("</pre>"); exit();
		//print("<pre>"); var_dump($HorseWins[$iHorse]["Range"]); print("</pre>"); exit();
		//print("<pre>"); var_dump($HorsePlaces[$iHorse]["Range"]); print("</pre>"); exit();
		
		unset($HorseRaces[$iHorse]["Track_Range"], $HorseWins[$iHorse]["Track_Range"], $HorsePlaces[$iHorse]["Track_Range"], $HorseFinishCount);
		$HorseFinishCount = array_count_values(array_intersect_key((array)$HorseRacesDatum["NbPlace"], array_intersect((array)$HorseRacesDatum["Hippodrome"], array($TrackName)), array_intersect((array)$HorseRacesDatum["DistanceParcouru"], array($RaceRange))));
		//print("<pre>"); var_dump($HorseFinishCount); print("</pre>"); exit();
		$HorseRaces[$iHorse]["Track_Range"] = array_sum((array)$HorseFinishCount);
		$HorseWins[$iHorse]["Track_Range"] = $HorseFinishCount["01"] ?: 0;
		$HorsePlaces[$iHorse]["Track_Range"] = $HorseFinishCount["02"] + $HorseFinishCount["03"];
		//print("<pre>"); var_dump($HorseRaces[$iHorse]["Track_Range"]); print("</pre>"); exit();
		//print("<pre>"); var_dump($HorseWins[$iHorse]["Track_Range"]); print("</pre>"); exit();
		//print("<pre>"); var_dump($HorsePlaces[$iHorse]["Track_Range"]); print("</pre>"); exit();
	}
	
	unset($HorseIsDebut, $HorseRace, $iHorse);
	foreach($HorseRaces as $iHorse => $HorseRace) $HorseIsDebut[$iHorse] = ($HorseRace["All"] == false);
	//print("<pre>"); var_dump($HorseIsDebut); print("</pre>"); exit;
	
	
	unset($RacePrint[$iRace]);
	$RacePrint[$iRace] .= "
		<hr/>
		<br/>
		<div class='row'>
			<h1 id='Title' class='col-lg-8 col-lg-offset-2' title='Τίτλος (Ιπποδρόμιο - Ημερομηνία)' data-toggle='tooltip'><a href='".$Links[$iRace]."'>".$RaceNumber.". ".$RaceTitle."</a></h1>
			<h1 id='Range' class='col-lg-2' title='Απόσταση' data-toggle='tooltip'>".$RaceRange." μ.</h1>
		</div>
		<div class='row'>
			<h2 id='Subtitle' class='col-lg-8 col-lg-offset-2' title='Όνομα κούρσας' data-toggle='tooltip'>".$RaceName."</h2>
		</div>
		<!--
			<div class='row'>
				<h4 id='Prize' class='col-lg-8 col-lg-offset-2' title='Έπαθλο' data-toggle='tooltip'>".$RaceMoneySymbol." ".$RacePrize/*." - Ίπποι ".$RaceAge." ετών".(!$RaceClass ? "" : ", Κλάση ".$RaceClass).", ".$RaceType*/."</h4>
				<h4 id='Time' class='col-lg-2' title='Ώρα διεξαγωγής' data-toggle='tooltip'>".$RaceTime."</h4>
			</div>
		//-->
		<br/>
	";
	
	storyTitle($file_Story["Title"], $RaceTitle);
	storySubtitle($file_Story["Subtitle"], $RaceName);
	storyRange($file_Story["Range"], $RaceRange);
	storyHeader($file_Story["Main"], "Main");
	
	unset($iHorse);
	foreach(array_keys((array)$HorseTopRate) as $iHorse) {
		$RacePrint[$iRace] .= "
			<table id='Main' class='table table-bordered' style='margin:auto;'>
				<tr>
					<th>".($HorseIsDebut[$iHorse] ? "" : "<span title='Καλύτερη απόδοση (ημερομηνία)' data-toggle='tooltip'><a href='".$HorseRacesLink[$iHorse]."'>Top rate:</a> ".(!$HorseTopRate[$iHorse] ? "-" : $HorseTopRate[$iHorse]." (".$HorseTopDate[$iHorse].")")."</span>")."</th>
				</tr>
				<tr>
					<th>
						<span title='Συμμετοχές, νίκες &&nbsp;πλασέ&nbsp;(2ος&nbsp;&&nbsp;3ος)' data-toggle='tooltip'><a href='".$HorseLink[$iHorse]."'>Συμμ.-νίκ.-πλ.:</a> ".($HorseIsDebut[$iHorse] ? "-" : "[".$HorseRaces[$iHorse]["All"]."-".$HorseWins[$iHorse]["All"]."-".$HorsePlaces[$iHorse]["All"]."]")."</span>
		".(!$HorseRaces[$iHorse]["Track"] && !$HorseRaces[$iHorse]["Range"] ? "" : "
						<span title='Σε ιππόδρομο' data-toggle='tooltip'>&nbsp; &nbsp;Σε Ιππόδρ. (".$HorseRaces[$iHorse]["Track"]."-".$HorseWins[$iHorse]["Track"]."-".$HorsePlaces[$iHorse]["Track"].")</span>
						<span title='Σε απόσταση' data-toggle='tooltip'>, Απόστ. (".$HorseRaces[$iHorse]["Range"]."-".$HorseWins[$iHorse]["Range"]."-".$HorsePlaces[$iHorse]["Range"].")</span>
						<span title='Σε ιππόδρομο & απόσταση μαζί' data-toggle='tooltip'>, Ιππόδρ.-Απόστ. (".$HorseRaces[$iHorse]["Track_Range"]."-".$HorseWins[$iHorse]["Track_Range"]."-".$HorsePlaces[$iHorse]["Track_Range"].")</span>
		")."
					</th>
				</tr>
			</table>
		";
		
		storyMainBody($file_Story["Main"],
			$HorseTopRate[$iHorse],
			$HorseTopDate[$iHorse],
			$HorseRaces[$iHorse],
			$HorseWins[$iHorse],
			$HorsePlaces[$iHorse]
		);
	}
	
	
	storyFooter($file_Story["Main"]);
	
	$DesignSpreads[$iRace] = '<idPkg:Spread src="Spreads/Spread_'.$RaceNumber.'.xml"/>';
	$DesignStories[$iRace] = str_replace("1", $RaceNumber, implode($Stories[0]));
	
	$idml->addFromString('Spreads/Spread_'.$RaceNumber.'.xml', str_ireplace('ParentStory="Story_1', 'ParentStory="Story_'.$RaceNumber, $file_Spread));	
	unset($story, $i);
	foreach(str_replace("1", $RaceNumber, $Stories[1]) as $i => $story)
		$idml->addFromString($story, str_ireplace('Self="Story_1', 'Self="Story_'.$RaceNumber, $file_Story[$Stories[2][$i]]));
}

ksort($DesignSpreads);
$DesignSpreads = implode($DesignSpreads);
ksort($DesignStories);
$DesignStories = implode($DesignStories);

$idml->addFromString(
	'designmap.xml',
	str_ireplace(
		array('<idPkg:Spread src="Spreads/Spread_1.xml" />', implode($Stories[0])),
		array($DesignSpreads, $DesignStories),
		$file_DesignMap
	)
);
$idml->close();

ksort($RacePrint);
$EchoBottom = implode($RacePrint);

$EchoTop .= DownloadButton("//".LinkBase()."/App/~tmp/".basename($file["Main"]));

?>