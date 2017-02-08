<?php	//set_time_limit(900);

require_once(__DIR__."\\IdmlFunctions.php");
require_once(__DIR__."\\EquTables.php");

$maxHistory = 5;

$file["Prototype"] = "_Prototype.idml";
$idml = new ZipArchive;
$idml->open($file["Prototype"]);
$file_DesignMap = $idml->getFromName('designmap.xml');
$file_Spread = $idml->getFromName('Spreads/Spread_1.xml');
$file_Story["Code"] = $idml->getFromName('Stories/Story_1_Code.xml');
$file_Story["Header"] = $idml->getFromName('Stories/Story_1_Header.xml');
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


unset($totalCounts, $RaceIndexes);
foreach($Xmls as $RaceIndexes) $totalCounts += count($RaceIndexes);
//print("<pre>"); var_dump($totalCounts); print("</pre>"); exit();


unset($Xml, $RaceIndexes);
foreach($Xmls as $Xml => $RaceIndexes) {
	
	$XmlData = Xml2Xpath($Xml);
	
	unset($RaceIndex, $iRace);
	foreach($RaceIndexes as $RaceIndex => $iRace) {
		//if($iRace != 2 - 1) continue;
		
		
		CalcProgress($totalCounts, ++$currCount, "", "", "");
		
		
		unset($RaceScrap);
		$RaceScrap = $XmlData->evaluate(".//RACE[".++$RaceIndex."]")->item(0);
		
		unset($RaceNumber);
		$RaceNumber = $iRace + 1;
		//print("<pre>"); var_dump($RaceNumber); print("</pre>"); exit;
		
		unset($RaceTitle, $scrap);
		foreach($XmlData->evaluate(".//RACE_HEADER_1_VENUE", $RaceScrap) as $scrap) {
			$TrackName = FixSpaces($scrap->nodeValue);
			$TrackName = preg_replace("'\s+.*'uis", "", $TrackName);
			$RaceTitle =
				$TrackName
				."   -   ".
				str_replace(
					array(1, 2, 3, 4, 5, 6, 7),
					array("ΔΕΥΤΕΡΑ", "ΤΡΙΤΗ", "ΤΕΤΑΡΤΗ", "ΠΕΜΠΤΗ", "ΠΑΡΑΣΚΕΥΗ", "ΣΑΒΒΑΤΟ", "ΚΥΡΙΑΚΗ"),
					date("N", strtotime($_REQUEST["Date"]))
				)
				." ".
				date("j/n", strtotime($_REQUEST["Date"]))
			;
			$RaceTitle = strtoupper($RaceTitle);
		}
		//print("<pre>"); var_dump($TrackName); print("</pre>"); exit;
		//print("<pre>"); var_dump($RaceTitle); print("</pre>"); exit;
		
		unset($RaceTime, $scrap);
		foreach($XmlData->evaluate(".//RACE_HEADER_1_RACE_TIME", $RaceScrap) as $scrap) {
			$RaceTime = FixSpaces($scrap->nodeValue);
			$RaceTime = date('H:i', strtotime("+1 hour", strtotime($RaceTime)));
		}
		//print("<pre>"); var_dump($RaceTime); print("</pre>"); exit;
		
/*		unset($RaceType, $scrap);
		foreach($XmlData->evaluate(".//RACE_HEADER_1_RACE_GROUP", $RaceScrap) as $scrap) {
			$RaceType = FixSpaces($scrap->nodeValue);
			$RaceType = EquSearch($RaceType, $Equ["Type"]);
		}
		//print("<pre>"); var_dump($RaceType); print("</pre>"); exit;
		
		unset($RaceClass, $scrap);
		foreach($XmlData->evaluate(".//RACE_HEADER_1_RACE_GROUP", $RaceScrap) as $scrap) {
			$RaceClass = FixSpaces($scrap->nodeValue);
			$RaceClass = EquSearch($RaceClass, $Equ["Group"], true);
			if(!$RaceClass) $RaceClass = FixSpaces($XmlData->evaluate(".//RACE_HEADER_1_RACE_CLASS", $RaceScrap)->item(0)->nodeValue);
		}
		//print("<pre>"); var_dump($RaceClass); print("</pre>"); exit;
		
		unset($RaceAge, $RaceAgeMax, $scrap);
		foreach($XmlData->evaluate(".//RACE_HEADER_1_MINIMUM_AGE", $RaceScrap) as $scrap) {
			$RaceAge = FixSpaces($scrap->nodeValue);
			$RaceAgeMax = FixSpaces($XmlData->evaluate(".//RACE_HEADER_1_MAXIMUM_AGE", $RaceScrap)->item(0)->nodeValue);
			if($RaceAgeMax != $RaceAge) $RaceAge .= $RaceAgeMax == 98 ? "+" : "-".$RaceAgeMax;
		}
		//print("<pre>"); var_dump($RaceAge); print("</pre>"); exit;
*/		
		unset($RacePrizeParity);
		$RacePrizeParity = 0.06;
		//print("<pre>"); var_dump($RacePrizeParity); print("</pre>"); exit();
		
		unset($RaceMoneySymbol);
		$RaceMoneySymbol = "R";
		//print("<pre>"); var_dump($RaceMoneySymbol); print("</pre>"); exit();
		
		unset($RacePrize, $scrap);
		foreach($XmlData->evaluate(".//RACE_HEADER_1_GR_STAKE", $RaceScrap) as $scrap) {
			$RacePrize = FixSpaces($scrap->nodeValue);
			$RacePrize = EquSearch($RacePrize, $EquPreg["OnlyDigits"]);
			//$RacePrize *= $RacePrizeParity;
			$RacePrize = number_format($RacePrize, 0, ',', '.');
		}
		//print("<pre>"); var_dump($RacePrize); print("</pre>"); exit;
		
		unset($RaceName, $scrap);
		foreach($XmlData->evaluate(".//RACE_HEADER_2_RACE_TITLE", $RaceScrap) as $scrap) {
			$RaceName = FixSpaces($scrap->nodeValue);
		}
		//print("<pre>"); var_dump($RaceName); print("</pre>"); exit;
		
		unset($RaceRange, $scrap);
		foreach($XmlData->evaluate(".//RACE_HEADER_2_DISTANCE", $RaceScrap) as $scrap) {
			$RaceRange = FixSpaces($scrap->nodeValue);
			$RaceRange = EquSearch($RaceRange, $Equ["Range"]);
		}
		//print("<pre>"); var_dump($RaceRange); print("</pre>"); exit;
		
		unset($RaceCouplings, $scrap);
		foreach($XmlData->evaluate(".//RACE_HEADER_2_COUPLINGS", $RaceScrap) as $scrap) {
			$RaceCouplings = FixSpaces($scrap->nodeValue);
			$RaceCouplings = preg_replace("'.*?([(].*[)]).*'uis", "$01", $RaceCouplings);
			$RaceCouplings = EquSearch($RaceCouplings, $Equ["Couplings"]);
		}
		//print("<pre>"); var_dump($RaceCouplings); print("</pre>"); exit;
		
		
		unset($HorseNumber, $scrap, $i);
		foreach($XmlData->evaluate(".//HORSE_HEADER_1_SADDLE_NO", $RaceScrap) as $i => $scrap) {
			$HorseNumber[$i] = FixSpaces($scrap->nodeValue);
		}
		//print("<pre>"); var_dump($HorseNumber); print("</pre>"); exit;
		
		unset($HorseName, $scrap, $i);
		foreach($XmlData->evaluate(".//HORSE_HEADER_1_NAME", $RaceScrap) as $i => $scrap) {
			$HorseName[$i] = FixSpaces($scrap->nodeValue);
		}
		//print("<pre>"); var_dump($HorseName); print("</pre>"); exit;
		
		unset($HorseStart, $scrap, $i);
		foreach($XmlData->evaluate(".//HORSE_HEADER_1_DRAW", $RaceScrap) as $i => $scrap) {
			$HorseStart[$i] = FixSpaces($scrap->nodeValue);
		}
		//print("<pre>"); var_dump($HorseStart); print("</pre>"); exit;
		
		unset($HorseWeight, $scrap, $i);
		foreach($XmlData->evaluate(".//HORSE_HEADER_1_WEIGHT", $RaceScrap) as $i => $scrap) {
			$HorseWeight[$i] = FixSpaces($scrap->nodeValue);
		}
		//print("<pre>"); var_dump($HorseWeight); print("</pre>"); exit;
		
		unset($HorseAge, $scrap, $i);
		foreach($XmlData->evaluate(".//HORSE_HEADER_2_AGE", $RaceScrap) as $i => $scrap) {
			$HorseAge[$i] = FixSpaces($scrap->nodeValue);
		}
		//print("<pre>"); var_dump($HorseAge); print("</pre>"); exit;
		
		unset($HorseColor, $scrap, $i);
		foreach($XmlData->evaluate(".//HORSE_HEADER_2_COLOUR", $RaceScrap) as $i => $scrap) {
			$HorseColor[$i] = FixSpaces($scrap->nodeValue);
			$HorseColor[$i] = EquSearch($HorseColor[$i], $Equ["Color"]);
		}
		//print("<pre>"); var_dump($HorseColor); print("</pre>"); exit;
		
		unset($HorseSex, $scrap, $i);
		foreach($XmlData->evaluate(".//HORSE_HEADER_2_SEX", $RaceScrap) as $i => $scrap) {
			$HorseSex[$i] = FixSpaces($scrap->nodeValue);
			$HorseSex[$i] = EquSearch($HorseSex[$i], $Equ["Sex"]);
		}
		//print("<pre>"); var_dump($HorseSex); print("</pre>"); exit;
		
		unset($HorseFather, $scrap, $i);
		foreach($XmlData->evaluate(".//HORSE_HEADER_2_SIRE", $RaceScrap) as $i => $scrap) {
			$HorseFather[$i] = FixSpaces($scrap->nodeValue);
			$HorseFather[$i] = EquSearch($HorseFather[$i], $EquPreg["Brackets"]);
		}
		//print("<pre>"); var_dump($HorseFather); print("</pre>"); exit;
		
		unset($HorseMother, $scrap, $i);
		foreach($XmlData->evaluate(".//HORSE_HEADER_2_DAM", $RaceScrap) as $i => $scrap) {
			$HorseMother[$i] = FixSpaces($scrap->nodeValue);
			$HorseMother[$i] = EquSearch($HorseMother[$i], $EquPreg["Brackets"]);
		}
		//print("<pre>"); var_dump($HorseMother); print("</pre>"); exit;
		
		unset($HorseTrainer, $HorseTrainerSearch, $scrap, $i);
		foreach($XmlData->evaluate(".//HORSE_HEADER_2_TRAINER", $RaceScrap) as $i => $scrap) {
			$HorseTrainer[$i] = FixSpaces($scrap->nodeValue);
			$HorseTrainerSearch = EquSearch($HorseTrainer[$i], $Equ["Trainer"], true);
			if($HorseTrainerSearch !== null) $HorseTrainer[$i] = $HorseTrainerSearch ?: $HorseTrainer[$i];
			else {
				$Equ["Trainer"][$HorseTrainer[$i]] = "";
				file_put_contents($file["Trainer"], iconv("UTF-8", "UCS-2LE", addslashes($HorseTrainer[$i])."\r\n"), FILE_APPEND | LOCK_EX);
			}
		}
		//print("<pre>"); var_dump($HorseTrainer); print("</pre>"); exit;
		
		unset($HorseOwner, $HorseOwnerColors, $scrap, $i);
		foreach($XmlData->evaluate(".//HORSE_HEADER_2_OWNER", $RaceScrap) as $i => $scrap) {
			$HorseOwner[$i] = FixSpaces($scrap->nodeValue);
			$HorseOwnerColors[$i] = EquSearch($HorseOwner[$i], $Equ["OwnerColors"], true);
			$HorseOwner[$i] = EquSearch($HorseOwner[$i], array($Equ["Empty"], $EquPreg["Brackets"]));
		}
		//print("<pre>"); var_dump($HorseOwner); print("</pre>"); exit;
		//print("<pre>"); var_dump($HorseOwnerColors); print("</pre>"); exit;
		
		unset($HorseJockey, $scrap, $i);
		foreach($XmlData->evaluate(".//HORSE_HEADER_2_JOCKEY", $RaceScrap) as $i => $scrap) {
			$HorseJockey[$i] = FixSpaces($scrap->nodeValue);
			$HorseJockey[$i] = EquSearch($HorseJockey[$i], $Equ["Empty"]);
			$HorseJockey[$i] = EquSearch($HorseJockey[$i], $Equ["Jockey"]);
		}
		//print("<pre>"); var_dump($HorseJockey); print("</pre>"); exit;
		
		unset($HorseRaces, $HorseWins, $HorsePlaces);
		unset($scrap, $i);
		foreach($XmlData->evaluate(".//HORSE_HEADER_2_RUNS", $RaceScrap) as $i => $scrap) {
			$HorseRaces[$i]["All"] = FixSpaces($scrap->nodeValue);
			$HorseWins[$i]["All"] = FixSpaces($XmlData->evaluate("(.//HORSE_HEADER_2_WINS)[".($i + 1)."]", $RaceScrap)->item(0)->nodeValue);
			$HorsePlaces[$i]["All"] = FixSpaces($XmlData->evaluate("(.//HORSE_HEADER_2_PLACES)[".($i + 1)."]", $RaceScrap)->item(0)->nodeValue);
		}
		//print("<pre>"); var_dump(array_map(function($value) {return $value["All"];}, $HorseRaces)); print("</pre>"); exit;
		//print("<pre>"); var_dump(array_map(function($value) {return $value["All"];}, $HorseWins)); print("</pre>"); exit;
		//print("<pre>"); var_dump(array_map(function($value) {return $value["All"];}, $HorsePlaces)); print("</pre>"); exit;
		
		unset($scrap, $i);
		foreach($XmlData->evaluate(".//HORSE_HEADER_2_DIST_RUNS", $RaceScrap) as $i => $scrap) {
			$HorseRaces[$i]["Range"] = FixSpaces($scrap->nodeValue);
			$HorseWins[$i]["Range"] = FixSpaces($XmlData->evaluate("(.//HORSE_HEADER_2_DIST_WINS)[".($i + 1)."]", $RaceScrap)->item(0)->nodeValue);
			$HorsePlaces[$i]["Range"] = FixSpaces($XmlData->evaluate("(.//HORSE_HEADER_2_DIST_PLACE)[".($i + 1)."]", $RaceScrap)->item(0)->nodeValue);
		}
		//print("<pre>"); var_dump(array_map(function($value) {return $value["Range"];}, $HorseRaces)); print("</pre>"); exit;
		//print("<pre>"); var_dump(array_map(function($value) {return $value["Range"];}, $HorseWins)); print("</pre>"); exit;
		//print("<pre>"); var_dump(array_map(function($value) {return $value["Range"];}, $HorsePlaces)); print("</pre>"); exit;
		
		unset($scrap, $i);
		foreach($XmlData->evaluate(".//HORSE_HEADER_2_CRSE_RUNS", $RaceScrap) as $i => $scrap) {
			$HorseRaces[$i]["Track"] = FixSpaces($scrap->nodeValue);
			$HorseWins[$i]["Track"] = FixSpaces($XmlData->evaluate("(.//HORSE_HEADER_2_CRSE_WINS)[".($i + 1)."]", $RaceScrap)->item(0)->nodeValue);
			$HorsePlaces[$i]["Track"] = FixSpaces($XmlData->evaluate("(.//HORSE_HEADER_2_CRSE_PLACE)[".($i + 1)."]", $RaceScrap)->item(0)->nodeValue);
		}
		//print("<pre>"); var_dump(array_map(function($value) {return $value["Track"];}, $HorseRaces)); print("</pre>"); exit;
		//print("<pre>"); var_dump(array_map(function($value) {return $value["Track"];}, $HorseWins)); print("</pre>"); exit;
		//print("<pre>"); var_dump(array_map(function($value) {return $value["Track"];}, $HorsePlaces)); print("</pre>"); exit;
		
		unset($scrap, $i);
		foreach($XmlData->evaluate(".//HORSE_HEADER_2_CRDIST_RUNS", $RaceScrap) as $i => $scrap) {
			$HorseRaces[$i]["Track_Range"] = FixSpaces($scrap->nodeValue);
			$HorseWins[$i]["Track_Range"] = FixSpaces($XmlData->evaluate("(.//HORSE_HEADER_2_CRDIST_WINS)[".($i + 1)."]", $RaceScrap)->item(0)->nodeValue);
			$HorsePlaces[$i]["Track_Range"] = FixSpaces($XmlData->evaluate("(.//HORSE_HEADER_2_CRDIST_PLACE)[".($i + 1)."]", $RaceScrap)->item(0)->nodeValue);
		}
		//print("<pre>"); var_dump(array_map(function($value) {return $value["Track_Range"];}, $HorseRaces)); print("</pre>"); exit;
		//print("<pre>"); var_dump(array_map(function($value) {return $value["Track_Range"];}, $HorseWins)); print("</pre>"); exit;
		//print("<pre>"); var_dump(array_map(function($value) {return $value["Track_Range"];}, $HorsePlaces)); print("</pre>"); exit;
		
		unset($HorsePrizes, $scrap, $i);
		foreach($XmlData->evaluate(".//HORSE_HEADER_2_STAKES", $RaceScrap) as $i => $scrap) {
			$HorsePrizes[$i] = FixSpaces($scrap->nodeValue);
			$HorsePrizes[$i] = EquSearch($HorsePrizes[$i], $EquPreg["OnlyDigits"]);
			//$HorsePrizes[$i] *= $RacePrizeParity;
			$HorsePrizes[$i] = number_format($HorsePrizes[$i], 0, ',', '.');
		}
		//print("<pre>"); var_dump($HorsePrizes); print("</pre>"); exit;
		
		
		unset($HorseScrap, $iHorse);
		foreach($XmlData->evaluate(".//HORSE",  $RaceScrap) as $iHorse => $HorseScrap) {
			//if($iHorse != 2 - 1) continue;
			
			unset($HistoryTrack[$iHorse], $scrap, $i);
			foreach($XmlData->evaluate(".//HORSE_RUN_VENUE", $HorseScrap) as $i => $scrap) {
				$HistoryTrack[$iHorse][$i] = FixSpaces($scrap->nodeValue);
				$HistoryTrack[$iHorse][$i] = EquSearch($HistoryTrack[$iHorse][$i], $Equ["Track"]);
			}
			//print("<pre>"); var_dump($HistoryTrack[$iHorse]); print("</pre>"); exit;
			
			unset($HistoryDate[$iHorse], $HistoryYear, $HistoryMonth, $HistoryDay, $scrap, $i);
			foreach($XmlData->evaluate(".//HORSE_RUN_DATE_YEAR", $HorseScrap) as $i => $scrap) {
				$HistoryYear = FixSpaces($scrap->nodeValue);
				$HistoryYear = substr($HistoryYear, 2);
				$HistoryMonth = FixSpaces($XmlData->evaluate("(.//HORSE_RUN_DATE_MONTH)[".($i + 1)."]", $HorseScrap)->item(0)->nodeValue);
				$HistoryDay = FixSpaces($XmlData->evaluate("(.//HORSE_RUN_DATE_DAY)[".($i + 1)."]", $HorseScrap)->item(0)->nodeValue);
				$HistoryDate[$iHorse][$i] = $HistoryDay."/".$HistoryMonth."/".$HistoryYear;
			}
			//print("<pre>"); var_dump($HistoryDate[$iHorse]); print("</pre>"); exit;
			
			unset($HistoryType[$iHorse], $scrap, $i);
			foreach($XmlData->evaluate(".//HORSE_RUN_RACE_TYPE", $HorseScrap) as $i => $scrap) {
				$HistoryType[$iHorse][$i] = FixSpaces($scrap->nodeValue);
				$HistoryType[$iHorse][$i] = EquSearch($HistoryType[$iHorse][$i], $Equ["HistoryType"]);
			}
			//print("<pre>"); var_dump($HistoryType[$iHorse]); print("</pre>"); exit;
			
			unset($HistoryClass[$iHorse], $scrap, $i);
			foreach($XmlData->evaluate(".//HORSE_RUN_RACE_GROUP", $HorseScrap) as $i => $scrap) {
				$HistoryClass[$iHorse][$i] = FixSpaces($scrap->nodeValue);
				$HistoryClass[$iHorse][$i] = EquSearch($HistoryClass[$iHorse][$i], $Equ["Group"], true);
				if(!$HistoryClass[$iHorse][$i]) $HistoryClass[$iHorse][$i] = FixSpaces($XmlData->evaluate("(.//HORSE_RUN_RACE_CLASS)[".($i + 1)."]", $HorseScrap)->item(0)->nodeValue);
			}
			//print("<pre>"); var_dump($HistoryClass[$iHorse]); print("</pre>"); exit;
			
			unset($HistoryTerrain[$iHorse], $scrap, $i);
			foreach($XmlData->evaluate(".//HORSE_RUN_GOING", $HorseScrap) as $i => $scrap) {
				$HistoryTerrain[$iHorse][$i] = FixSpaces($scrap->nodeValue);
				$HistoryTerrain[$iHorse][$i] = EquSearch($HistoryTerrain[$iHorse][$i], $Equ["Terrain"]);
			}
			//print("<pre>"); var_dump($HistoryTerrain[$iHorse]); print("</pre>"); exit;
			
			unset($HistoryPrize[$iHorse], $scrap, $i);
			foreach($XmlData->evaluate(".//HORSE_RUN_STAKE", $HorseScrap) as $i => $scrap) {
				$HistoryPrize[$iHorse][$i] = FixSpaces($scrap->nodeValue);
				$HistoryPrize[$iHorse][$i] = EquSearch($HistoryPrize[$iHorse][$i], $EquPreg["OnlyDigits"]);
				//$HistoryPrize[$iHorse][$i] *= $RacePrizeParity;
				$HistoryPrize[$iHorse][$i] = round($HistoryPrize[$iHorse][$i] / 1000)."K";
			}
			//print("<pre>"); var_dump($HistoryPrize[$iHorse]); print("</pre>"); exit;
			
			unset($HistoryRange[$iHorse], $scrap, $i);
			foreach($XmlData->evaluate(".//HORSE_RUN_DISTANCE", $HorseScrap) as $i => $scrap) {
				$HistoryRange[$iHorse][$i] = FixSpaces($scrap->nodeValue);
				$HistoryRange[$iHorse][$i] = EquSearch($HistoryRange[$iHorse][$i], $Equ["Range"]);
			}
			//print("<pre>"); var_dump($HistoryRange[$iHorse]); print("</pre>"); exit;
			
			unset($HistoryJockey[$iHorse], $scrap, $i);
			foreach($XmlData->evaluate(".//HORSE_RUN_JOCKEY", $HorseScrap) as $i => $scrap) {
				$HistoryJockey[$iHorse][$i] = FixSpaces($scrap->nodeValue);
				$HistoryJockey[$iHorse][$i] = EquSearch($HistoryJockey[$iHorse][$i], $Equ["Jockey"]);
			}
			//print("<pre>"); var_dump($HistoryJockey[$iHorse]); print("</pre>"); exit;
			
			unset($HistoryWeight[$iHorse], $scrap, $i);
			foreach($XmlData->evaluate(".//HORSE_RUN_WEIGHT", $HorseScrap) as $i => $scrap) {
				$HistoryWeight[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			}
			//print("<pre>"); var_dump($HistoryWeight[$iHorse]); print("</pre>"); exit;
			
			unset($HistoryRank[$iHorse], $scrap, $i);
			foreach($XmlData->evaluate(".//HORSE_RUN_POS_FIN", $HorseScrap) as $i => $scrap) {
				$HistoryRank[$iHorse][$i] = FixSpaces($scrap->nodeValue);
				$HistoryRank[$iHorse][$i] = EquSearch($HistoryRank[$iHorse][$i], $EquPreg["DigitPad"]);
			}
			//print("<pre>"); var_dump($HistoryRank[$iHorse]); print("</pre>"); exit;
			
			unset($HorseQue[$iHorse], $HorseQueRank, $HorseQueYear, $HorseQuePrevYear, $i);
			foreach((array)$HistoryRank[$iHorse] as $i => $HorseQueRank) {
				$HorseQueRank = EquSearch($HorseQueRank, $EquPreg["DigitUnpad"]);
				$HorseQueYear = preg_replace("'.+?(\d+)$'uis", "$01", $HistoryDate[$iHorse][$i]);
				if(!isset($HorseQue[$iHorse])) $HorseQue[$iHorse] = $HorseQueRank;
				else $HorseQue[$iHorse] .= ($HorseQueYear > $HorseQuePrevYear && isset($HorseQuePrevYear) ? "-" : ",").$HorseQueRank;
				$HorseQuePrevYear = $HorseQueYear;
			}
			//print("<pre>"); var_dump($HorseQue[$iHorse]); print("</pre>"); exit;
			
			unset($HistoryLengths[$iHorse], $scrap, $i);
			foreach($XmlData->evaluate(".//HORSE_RUN_POS_FIN_LB", $HorseScrap) as $i => $scrap) {
				$HistoryLengths[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			}
			//print("<pre>"); var_dump($HistoryLengths[$iHorse]); print("</pre>"); exit;
			
			unset($HistoryStart[$iHorse], $scrap, $i);
			foreach($XmlData->evaluate(".//HORSE_RUN_DRAW", $HorseScrap) as $i => $scrap) {
				$HistoryStart[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			}
			//print("<pre>"); var_dump($HistoryStart[$iHorse]); print("</pre>"); exit;
			
			unset($HistoryRunners[$iHorse], $scrap, $i);
			foreach($XmlData->evaluate(".//HORSE_RUN_DRAW_OF", $HorseScrap) as $i => $scrap) {
				$HistoryRunners[$iHorse][$i] = FixSpaces($scrap->nodeValue);
				$HistoryRunners[$iHorse][$i] = EquSearch($HistoryRunners[$iHorse][$i], $EquPreg["DigitPad"]);
			}
			//print("<pre>"); var_dump($HistoryRunners[$iHorse]); print("</pre>"); exit;
			
			unset($HistoryWinner[$iHorse], $HistoryIsFirst[$iHorse], $scrap, $i);
			foreach($XmlData->evaluate(".//HORSE_RUN_WINNER", $HorseScrap) as $i => $scrap) {
				$HistoryWinner[$iHorse][$i] = FixSpaces($scrap->nodeValue);
				$HistoryIsFirst[$iHorse][$i] = stristr($HistoryWinner[$iHorse][$i], $HorseName[$iHorse]) ? true : false;
				if($HistoryIsFirst[$iHorse][$i]) $HistoryWinner[$iHorse][$i] = FixSpaces($XmlData->evaluate("(.//HORSE_RUN_SECOND)[".($i + 1)."]", $HorseScrap)->item(0)->nodeValue);
			}
			//print("<pre>"); var_dump($HistoryWinner[$iHorse]); print("</pre>"); exit;
			//print("<pre>"); var_dump($HistoryIsFirst[$iHorse]); print("</pre>"); exit;
			
			unset($HistoryTime[$iHorse], $HistoryTimeSecs[$iHorse], $scrap, $i);
			foreach($XmlData->evaluate(".//HORSE_RUN_WINNING_TIME", $HorseScrap) as $i => $scrap) {
				$HistoryTimeSecs[$iHorse][$i] = FixSpaces($scrap->nodeValue);
				$HistoryTime[$iHorse][$i] = Secs2Mins($HistoryTimeSecs[$iHorse][$i]);
				$HistoryTime[$iHorse][$i] = EquSearch($HistoryTime[$iHorse][$i], $Equ["Empty"]);
				
				if(!$HistoryLengths[$iHorse][$i] || $HistoryTime[$iHorse][$i] == EmptyChar())
					$HistoryLengths[$iHorse][$i] = $HistoryTime[$iHorse][$i];
				else if($HistoryLengths[$iHorse][$i] >= 90)
					$HistoryLengths[$iHorse][$i] = "μακράν";
				else
					$HistoryLengths[$iHorse][$i] = Secs2Mins($HistoryTimeSecs[$iHorse][$i] + $HistoryLengths[$iHorse][$i] * 20 / 100);
				
				if($HistoryIsFirst[$iHorse][$i]) list($HistoryTime[$iHorse][$i], $HistoryLengths[$iHorse][$i]) = array($HistoryLengths[$iHorse][$i], $HistoryTime[$iHorse][$i]);
			}
			//print("<pre>"); var_dump($HistoryTime[$iHorse]); print("</pre>"); exit;
			//print("<pre>"); var_dump($HistoryLengths[$iHorse]); print("</pre>"); exit;
			
			unset($HistoryPerform[$iHorse], $scrap, $i);
			foreach($XmlData->evaluate(".//HORSE_RUN_START_ODDS", $HorseScrap) as $i => $scrap) {
				$HistoryPerform[$iHorse][$i] = FixSpaces($scrap->nodeValue);
				$HistoryPerform[$iHorse][$i] = preg_replace_callback("'(\d+)-(\d+)'uis", function($m) {return round($m[1] / $m[2] + 1, 1);}, $HistoryPerform[$iHorse][$i]);
			}
			//print("<pre>"); var_dump($HistoryPerform[$iHorse]); print("</pre>"); exit;
		}
		
		unset($HorseIsDebut, $iHorse);
		foreach(array_keys($HorseName) as $iHorse) $HorseIsDebut[$iHorse] = ($HistoryDate[$iHorse][0] == false);
		//print("<pre>"); var_dump($HorseIsDebut); print("</pre>"); exit;
		
		
		unset($RacePrint[$iRace]);
		$RacePrint[$iRace] .= "
			<hr/>
			<br/>
			<div class='row'>
				<h1 id='Title' class='col-lg-8 col-lg-offset-2' title='Τίτλος (Ιπποδρόμιο - Ημερομηνία)' data-toggle='tooltip'>".$RaceNumber.". ".$RaceTitle."</h1>
				<h1 id='Range' class='col-lg-2' title='Απόσταση' data-toggle='tooltip'>".$RaceRange." μ.</h1>
			</div>
			<div class='row'>
				<h2 id='Subtitle' class='col-lg-8 col-lg-offset-2' title='Όνομα κούρσας' data-toggle='tooltip'>".$RaceName."</h2>
			</div>
			<div class='row'>
				<h4 id='Prize' class='col-lg-8 col-lg-offset-2' title='Έπαθλο' data-toggle='tooltip'>".$RaceMoneySymbol." ".$RacePrize/*." - Ίπποι ".$RaceAge." ετών".(!$RaceClass ? "" : ", Κλάση ".$RaceClass).", ".$RaceType*/."</h4>
				<h4 id='Time' class='col-lg-2' title='Ώρα διεξαγωγής' data-toggle='tooltip'>".$RaceTime."</h4>
			</div>
			<div class='row'>
				<h6 id='Couplings' class='col-lg-8 col-lg-offset-2' title='Ίπποι με τον ίδιο προπονητή' data-toggle='tooltip'>".$RaceCouplings."</h6>
			</div>
			<br/>
		";
	
		storyTitle($file_Story["Title"], $RaceTitle);
		storySubtitle($file_Story["Subtitle"],
			$RaceName,
			$RaceMoneySymbol,
			$RacePrize/*,
			$CourseAge,
			$CourseClass,
			$CourseType*/
		);
		storyRange($file_Story["Range"], $RaceRange);
		storyTime($file_Story["Time"], $RaceTime);
		storyHeader($file_Story["Main"], "Main");
		storyHeader($file_Story["History"], "History");
		
		unset($iHorse);
		foreach(array_keys((array)$HorseNumber) as $iHorse) {
			
			unset($IsLastHorse);
			$IsLastHorse = $iHorse == count((array)$HorseNumber) - 1;
			//print("<pre>"); var_dump($IsLastHorse); print("</pre>"); exit;
			
			$RacePrint[$iRace] .= "
				<table id='Main' class='table table-bordered' style='margin:auto;'>
					<tr>
						<th rowspan='4'><h1 title='Αύξων ίππου' data-toggle='tooltip'>".$HorseNumber[$iHorse]."</h1></th>
						<th>
							<span title='Όνομα ίππου' data-toggle='tooltip'><h3 style='display:inline;'> ".strtoupper($HorseName[$iHorse])."</h3></span>
						</th>
						<th><span title='Κιλά ίππου' data-toggle='tooltip'>".$HorseWeight[$iHorse]."</span></th>
						<th><span title='Αναβάτης' data-toggle='tooltip'>".$HorseJockey[$iHorse]."</span></th>
						<th><span title='Ιδιοκτήτης' data-toggle='tooltip'>".$HorseOwner[$iHorse]."</span></th>
						<th rowspan='4'><span title='Σταρτ (Θέση εκκίνησης)' data-toggle='tooltip'>".$HorseStart[$iHorse]."</span></th>
					</tr>
					<tr>
						<th colspan='2'><span title='Χρώμα, φύλλο & ηλικία' data-toggle='tooltip'>".$HorseColor[$iHorse].$HorseSex[$iHorse].$HorseAge[$iHorse]."</span><span> &nbsp;</span><span title='Τελευταίες συμμετοχές' data-toggle='tooltip'>(".($HorseQue[$iHorse] ?: "Ντεμπούτο").")</span></th>
						<th><span title='Προπονητής' data-toggle='tooltip'>".$HorseTrainer[$iHorse]."</span></th>
						<th><span title='Χρώματα ιδιοκτήτη' data-toggle='tooltip'>".$HorseOwnerColors[$iHorse]."</span></th>
					</tr>
					<tr>
						<th colspan='2'>
							<span title='Πατέρας' data-toggle='tooltip'>".$HorseFather[$iHorse]."</span>
							<span> - </span>
							<span title='Μητέρα' data-toggle='tooltip'>".$HorseMother[$iHorse]."</span>
						</th>
						<th></th>
						<th><span title='Συνολικά έπαθλα' data-toggle='tooltip'>".$RaceMoneySymbol." ".($HorsePrizes[$iHorse] ?: 0)."</span></th>
					</tr>
					<tr>
						<th colspan='4'>
							<span title='Συμμετοχές, νίκες &&nbsp;πλασέ&nbsp;(2ος&nbsp;&&nbsp;3ος)' data-toggle='tooltip'>Συμμ.-νίκ.-πλ.: ".($HorseIsDebut[$iHorse] ? "-" : "[".$HorseRaces[$iHorse]["All"]."-".$HorseWins[$iHorse]["All"]."-".$HorsePlaces[$iHorse]["All"]."]")."</span>
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
				$HorseIsDebut[$iHorse],
				strtoupper($HorseName[$iHorse]),
				$HorseWeight[$iHorse],
				$HorseJockey[$iHorse],
				$HorseOwner[$iHorse],
				$HorseNumber[$iHorse],
				$HorseColor[$iHorse],
				$HorseSex[$iHorse],
				$HorseAge[$iHorse],
				$HorseQue[$iHorse] ?: "Ντεμπούτο",
				$HorseTrainer[$iHorse],
				$HorseOwnerColors[$iHorse],
				$HorseStart[$iHorse],
				$HorseFather[$iHorse],
				$HorseMother[$iHorse],
				"NO", //$HorseTopRate[$iHorse],
				"", //$HorseTopDate[$iHorse],
				$RaceMoneySymbol,
				$HorsePrizes[$iHorse] ?: 0,
				$HorseRaces[$iHorse],
				$HorseWins[$iHorse],
				$HorsePlaces[$iHorse],
				!$IsLastHorse ? "" : $RaceCouplings
			);
			
			
			$RacePrint[$iRace].= "
				<div class='table-responsive'>
					<table id='History' class='table table-striped'>
						<tr>
							<th><span title='Ημερομηνία' data-toggle='tooltip'>ΗΜ/ΝΙΑ</span></th>
							<th><span title='Άφιξη / Συμμετέχοντες' data-toggle='tooltip'>Αφ.</span></th>
							<th><span title='(Κιλά ίππου) Αναβάτης (Σταρτ)' data-toggle='tooltip'>Κιλά/Αναβάτης <br/>& σειρά εκκίνησης</span></th>
							<th><span title='Ιπποδρόμιο' data-toggle='tooltip'>Ιππόδρ.</span></th>
							<th><span title='Απόσταση & τύπος κούρσας' data-toggle='tooltip'>Απόστ.</span></th>
							<th><span title='Κλάση (κατηγορία) κούρσας' data-toggle='tooltip'>Κλάση</span></th>
							<th><span title='Στοίβος' data-toggle='tooltip'>Στ.</span></th>
							<th><span title='Έπαθλο' data-toggle='tooltip'>Έπαθ.</span></th>
							<th><span title='Όνομα νικητή ή δεύτερου αν νικήσει ο τρέχων ίππος' data-toggle='tooltip'>Νικητής ή 2ος</span></th>
							<th><span title='Χρόνος νικητή' data-toggle='tooltip'>Χρόνος 1ου</span></th>
							<th><span title='Χρόνος 2ου ή χρόνος 1ου αν νικήσει ο τρέχων ίππος' data-toggle='tooltip'>Χρόν. ή Χρ.<br/>2ου ή διαφ.</span></th>
							<th><span title='Απόδοση' data-toggle='tooltip'>Απόδ.</span></th>
						</tr>
			";
			
			unset($iHistory);
			if($HorseIsDebut[$iHorse]) {
				$RacePrint[$iRace] .= "
					<tr>
						<td></td>
						<td colspan='2'><span>Κάνει ντεμπούτο</span></td>
						<td colspan='10'></td>
					</tr>
				";
				
				storyHistoryDebut($file_Story["History"]);
				
				$iHistory += 1;
			}
			else {
				$HistoryDate[$iHorse] = array_reverse((array)$HistoryDate[$iHorse]);
				$HistoryRank[$iHorse] = array_reverse((array)$HistoryRank[$iHorse]);
				$HistoryRunners[$iHorse] = array_reverse((array)$HistoryRunners[$iHorse]);
				$HistoryWeight[$iHorse] = array_reverse((array)$HistoryWeight[$iHorse]);
				$HistoryJockey[$iHorse] = array_reverse((array)$HistoryJockey[$iHorse]);
				$HistoryStart[$iHorse] = array_reverse((array)$HistoryStart[$iHorse]);
				$HistoryTrack[$iHorse] = array_reverse((array)$HistoryTrack[$iHorse]);
				$HistoryRange[$iHorse] = array_reverse((array)$HistoryRange[$iHorse]);
				$HistoryType[$iHorse] = array_reverse((array)$HistoryType[$iHorse]);
				$HistoryClass[$iHorse] = array_reverse((array)$HistoryClass[$iHorse]);
				$HistoryTerrain[$iHorse] = array_reverse((array)$HistoryTerrain[$iHorse]);
				$HistoryPrize[$iHorse] = array_reverse((array)$HistoryPrize[$iHorse]);
				$HistoryWinner[$iHorse] = array_reverse((array)$HistoryWinner[$iHorse]);
				$HistoryLengths[$iHorse] = array_reverse((array)$HistoryLengths[$iHorse]);
				$HistoryTime[$iHorse] = array_reverse((array)$HistoryTime[$iHorse]);
				$HistoryPerform[$iHorse] = array_reverse((array)$HistoryPerform[$iHorse]);
					
				foreach(array_keys((array)$HistoryDate[$iHorse]) as $iHistory) {
					if($iHistory > $maxHistory - 1) break;
				
					$RacePrint[$iRace] .= "
						<tr>
							<td><span>".$HistoryDate[$iHorse][$iHistory]."</span></td>
							<td><span><strong>".$HistoryRank[$iHorse][$iHistory]."</strong>/".$HistoryRunners[$iHorse][$iHistory]."</span></td>
							<td>
								".(!$HistoryWeight[$iHorse][$iHistory] ? "" : "<span>(".$HistoryWeight[$iHorse][$iHistory].")</span>")."
								<span>".$HistoryJockey[$iHorse][$iHistory]."</span>
								".(!$HistoryStart[$iHorse][$iHistory] ? "" : "<span>(".$HistoryStart[$iHorse][$iHistory].")</span>")."
							</td>
							<td><strong>".$HistoryTrack[$iHorse][$iHistory]."</strong></td>
							<td><span>".$HistoryRange[$iHorse][$iHistory]." ".$HistoryType[$iHorse][$iHistory]."</span></td>
							<td><span>".($HistoryClass[$iHorse][$iHistory] ?: EmptyChar())."</span></th>
							<td><span>".($HistoryTerrain[$iHorse][$iHistory] ?: EmptyChar())."</span></th>
							<td><span>".$HistoryPrize[$iHorse][$iHistory]."</span></td>
							<td><span>".$HistoryWinner[$iHorse][$iHistory]."</span></td>
							<td><span>".$HistoryTime[$iHorse][$iHistory]."</span></td>
							<td><span>".$HistoryLengths[$iHorse][$iHistory]."</span></td>
							<td><span>".$HistoryPerform[$iHorse][$iHistory]."</span></td>
						</tr>
					";
					
					$EchoRaces[$iRace] .= ""
						."<tr>"
						."	<td>".$HistoryDate[$iHorse][$iHistory]."</td>"
						."	<td><b>".$HistoryRank[$iHorse][$iHistory]."</b>/".$HistoryRunners[$iHorse][$iHistory]."</td>"
						."	<td>"
						."		".(!$HistoryWeight[$iHorse][$iHistory] ? "" : "(".$HistoryWeight[$iHorse][$iHistory].")")
						."		".$HistoryJockey[$iHorse][$iHistory]
						."		".(!$HistoryStart[$iHorse][$iHistory] ? "" : "(".$HistoryStart[$iHorse][$iHistory].")")
						."	</td>"
						."	<td><b>".$HistoryTrack[$iHorse][$iHistory]."</b></td>"
						."	<td><b>".$HistoryRange[$iHorse][$iHistory]."</b></td>"
						."	<td>".$HistoryType[$iHorse][$iHistory]."</td>"
						."	<td>".($HistoryClass[$iHorse][$iHistory] ?: EmptyChar())."</th>"
						."	<td>".($HistoryTerrain[$iHorse][$iHistory] ?: EmptyChar())."</th>"
						."	<td>".$HistoryPrize[$iHorse][$iHistory]."</td>"
						."	<td>".$HistoryWinner[$iHorse][$iHistory]."</td>"
						."	<td>".$HistoryLengths[$iHorse][$iHistory]."</td>"
						."	<td>".$HistoryTime[$iHorse][$iHistory]."</td>"
						."	<td>".$HistoryPerform[$iHorse][$iHistory]."</td>"
						."</tr>"
					;
					
					storyHistoryBody($file_Story["History"],
						$iHistory + 1,
						$HistoryDate[$iHorse][$iHistory],
						$HistoryRank[$iHorse][$iHistory],
						$HistoryRunners[$iHorse][$iHistory],
						$HistoryWeight[$iHorse][$iHistory],
						$HistoryJockey[$iHorse][$iHistory],
						$HistoryStart[$iHorse][$iHistory],
						$HistoryTrack[$iHorse][$iHistory],
						$HistoryRange[$iHorse][$iHistory],
						$HistoryType[$iHorse][$iHistory],
						$HistoryClass[$iHorse][$iHistory],
						$HistoryTerrain[$iHorse][$iHistory],
						$HistoryPrize[$iHorse][$iHistory],
						$HistoryWinner[$iHorse][$iHistory],
						$HistoryLengths[$iHorse][$iHistory],
						$HistoryTime[$iHorse][$iHistory],
						"NO", //$HistoryRate[$iHorse][$iHistory] ?: EmptyChar(),
						$HistoryPerform[$iHorse][$iHistory]
					);
				}
			}
			
			unset($currHistory);
			$currHistory = $iHistory + 1;
			
			unset($iHistory);
			for($iHistory = $currHistory; $iHistory < $maxHistory; $iHistory++) storyHistoryLine($file_Story["History"]);
			
			$RacePrint[$iRace].= "
					</table>
				</div>
				<br/>
			";
			
			storyHistoryNewLine($file_Story["History"]);
		}
		
		
		storyFooter($file_Story["Main"]);
		storyFooter($file_Story["History"]);
		
		$DesignSpreads[$iRace] = '<idPkg:Spread src="Spreads/Spread_'.$RaceNumber.'.xml"/>';
		$DesignStories[$iRace] = str_replace("1", $RaceNumber, implode($Stories[0]));
		
		$idml->addFromString('Spreads/Spread_'.$RaceNumber.'.xml', str_ireplace('ParentStory="Story_1', 'ParentStory="Story_'.$RaceNumber, $file_Spread));
		unset($story, $i);
		foreach(str_replace("1", $RaceNumber, $Stories[1]) as $i => $story)
			$idml->addFromString($story, str_ireplace('Self="Story_1', 'Self="Story_'.$RaceNumber, $file_Story[$Stories[2][$i]]));
	}
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