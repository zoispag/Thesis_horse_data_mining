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

$file["Trot_Prototype"] = "_Prototype_Trot.idml";
$idml = new ZipArchive;
$idml->open($file["Trot_Prototype"]);
$file_Story["Trot_Header"] = $idml->getFromName('Stories/Story_1_Header.xml');
$idml->close();


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
	$totalCounts += $RaceDatum->evaluate("count(.//table[@id='tableau_partants']//tr/td[2]/span/a[@class='lienFiche']/@href)");

unset($RaceDatum, $iRace);
foreach((array)$RaceData as $iRace => $RaceDatum) {
	//if($iRace != 2 - 1) continue;
	
	unset($RaceNumber);
	$RaceNumber = $iRace + 1;
	//print("<pre>"); var_dump($RaceNumber); print("</pre>"); exit();
	
	unset($RaceTitle, $scrap);
	foreach($RaceDatum->evaluate(".//div[@class='yui-u first nomReunion']") as $scrap) {
		$TrackName = FixSpaces($scrap->nodeValue);
		$TrackName = preg_replace("'.+:\s+(.+)\s+[(]R.+'uis", "$01", $RaceTitle);
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
		$RaceTitle = strtoupper($RaceTitle);
	}
	//print("<pre>"); var_dump($TrackName); print("</pre>"); exit();
	//print("<pre>"); var_dump($RaceTitle); print("</pre>"); exit();
	
	unset($RaceName, $scrap);
	foreach($RaceDatum->evaluate(".//*[@class='yui-u first nomCourse']//strong/text()[2]") as $scrap) {
		$RaceName = FixSpaces($scrap->nodeValue);
		$RaceName = preg_replace("'.+-\s+(.+)'uis", "$01", $RaceName);
	}
	//print("<pre>"); var_dump($RaceName); print("</pre>"); exit();
	
	unset($RaceTime, $scrap);
	foreach($RaceDatum->evaluate(".//*[@class='infoCourse']/strong[1]") as $scrap) {
		$RaceTime = FixSpaces($scrap->nodeValue);
		$RaceTime = str_replace("h", ":", $RaceTime);
		$RaceTime = date('H.i', strtotime("+1 hour", strtotime($RaceTime)));
	}
	//print("<pre>"); var_dump($RaceTime); print("</pre>"); exit();
	
	unset($RaceMoneyParity);
	$RaceMoneyParity = 1;
	//print("<pre>"); var_dump($RaceMoneyParity); print("</pre>"); exit();
	
	unset($RaceMoneySymbol);
	$RaceMoneySymbol = "€";
	//print("<pre>"); var_dump($RaceMoneySymbol); print("</pre>"); exit();
	
	unset($RaceType, $RaceClass, $RacePrize, $RaceRange, $RaceInfo, $scrap);
	foreach($RaceDatum->evaluate(".//*[@class='infoCourse']/text()[./following-sibling::span[1]][last()]") as $scrap) {
		$RaceInfo = FixSpaces($scrap->nodeValue);
		
/*		$RaceType = EquSearch($RaceInfo, $Equ["Type"]);
		
		$RaceClass = EquSearch($RaceInfo, $Equ["Class"], true);
*/		
		$RacePrize = str_replace(" ", "", preg_replace("'.+-\s+(.+)€.*'uis", "$01", $RaceInfo));
		//$RacePrize *= $RaceMoneyParity;
		$RacePrize = number_format($RacePrize, 0, ",", ".");
		
		$RaceRange = preg_replace("'.+-\s+(\d+)m.*'uis", "$01", $RaceInfo);
		
/*		$RaceInfo = EquSearch($RaceInfo, $EquPreg["Class"], true);
		If($RaceInfo && !strstr($RaceClass, "G") && !strstr($RaceClass, "L")) {
			if($RaceClass) $RaceClass .= "/";
			$RaceClass .= $RaceInfo;
		}
*/		
	}
	//print("<pre>"); var_dump($RaceType); print("</pre>"); exit();
	//print("<pre>"); var_dump($RaceClass); print("</pre>"); exit();
	//print("<pre>"); var_dump($RacePrize); print("</pre>"); exit();
	//print("<pre>"); var_dump($RaceRange); print("</pre>"); exit();
	
/*	unset($RaceAge, $scrap);
	foreach($RaceDatum->evaluate(".//*[@class='infoCourse']/span") as $scrap) {
		$RaceAge = FixSpaces($scrap->nodeValue);
		$RaceAge = EquSearch($RaceAge, array($Equ["Age"], $EquPreg["Age"]));
	}
	//print("<pre>"); var_dump($RaceAge); print("</pre>"); exit();
*/	
	
	unset($HorseNumber, $scrap, $i);
	foreach($RaceDatum->evaluate(".//table[@id='tableau_partants']//td[1]") as $i => $scrap) {
		$HorseNumber[$i] = FixSpaces($scrap->nodeValue);
	}
	//print("<pre>"); var_dump($HorseNumber); print("</pre>"); exit();
	
	unset($HorseName, $scrap, $i);
	foreach($RaceDatum->evaluate(".//table[@id='tableau_partants']//td[2]/span/a[@class='lienFiche']") as $i => $scrap) {
		$HorseName[$i] = FixSpaces($scrap->nodeValue);
		$HorseName[$i] = CleanSpecialChars($HorseName[$i]);
	}
	//print("<pre>"); var_dump($HorseName); print("</pre>"); exit();
	
	unset($HorseLink, $scrap, $i);
	foreach($RaceDatum->evaluate(".//table[@id='tableau_partants']//td[2]/span/a[@class='lienFiche']") as $i => $scrap) {
		$HorseLink[$i] = $scrap->getAttribute("href");
		$HorseLink[$i] = "http://www.geny.com".$HorseLink[$i];
	}
	//print("<pre>"); var_dump($HorseLink); print("</pre>"); exit();
	
/*	unset($HorseBlinkers, $HorseBlinkersValue, $scrap, $i);
	foreach($RaceDatum->evaluate(".//table[@id='tableau_partants']//td[2]/span/a[@class='lienFiche']") as $i => $scrap) {
		$HorseBlinkersValue[$i] = FixSpaces($RaceDatum->evaluate("..//img/@src",$scrap)->item(0)->nodeValue);
		$HorseBlinkers[$i] = !$HorseBlinkersValue[$i] ? "" : "Παρωπίδες";
		$HorseBlinkers[$i] .= !stristr(end(explode("/", $HorseBlinkersValue[$i])), "oeilleres_australiennes.gif") ? "" : " Αυστραλίας";
	}
*/	//print("<pre>"); var_dump($HorseBlinkers); print("</pre>"); exit();
	
	unset($HorsePetals, $scrap, $i);
	foreach($RaceDatum->evaluate(".//table[@id='tableau_partants']//td[2]/span/text()[2]") as $i => $scrap) {
		$HorsePetals[$i] = FixSpaces($scrap->nodeValue);
		$HorsePetals[$i] = EquSearch($HorsePetals[$i], $Equ["hPetal"]);
	}
	//print("<pre>"); var_dump($HorsePetals); print("</pre>"); exit();
	
	unset($HorseStart, $scrap, $i);
	foreach($RaceDatum->evaluate(".//table[@id='tableau_partants']//td[count(../../..//th[.='C']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]") as $i => $scrap) {
		$HorseStart[$i] = FixSpaces($scrap->nodeValue);
	}
	//print("<pre>"); var_dump($HorseStart); print("</pre>"); exit();
	
	unset($HorseSex, $scrap, $i);
	foreach($RaceDatum->evaluate(".//table[@id='tableau_partants']//td[count(../../..//th[.='SA']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]") as $i => $scrap) {
		$HorseSex[$i] = FixSpaces($scrap->nodeValue);
		$HorseSex[$i] = EquSearch($HorseSex[$i], $Equ["hSex"]);
	}
	//print("<pre>"); var_dump($HorseSex); print("</pre>"); exit();
	
	unset($HorseAge, $scrap, $i);
	foreach($RaceDatum->evaluate(".//table[@id='tableau_partants']//td[count(../../..//th[.='SA']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]") as $i => $scrap) {
		$HorseAge[$i] = FixSpaces($scrap->nodeValue);
		$HorseAge[$i] = EquSearch($HorseAge[$i], $EquPreg["hAge"]);
	}
	//print("<pre>"); var_dump($HorseAge); print("</pre>"); exit();
	
	unset($HorseRange, $scrap, $i);
	foreach($RaceDatum->evaluate(".//table[@id='tableau_partants']//td[count(../../..//th[.='Dist.']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]") as $i => $scrap) {
		$HorseRange[$i] = FixSpaces($scrap->nodeValue);
		$HorseRange[$i] = round($HorseRange[$i]);
	}
	//print("<pre>"); var_dump($HorseRange); print("</pre>"); exit();
	
	unset($RaceIsTrot[$iRace]);
	$RaceIsTrot[$iRace] = $HorseRange[$i] ? true : false;
	//print("<pre>"); var_dump($RaceIsTrot); print("</pre>"); exit();
	
	unset($HorseWeight, $scrap, $i);
	foreach($RaceDatum->evaluate(".//table[@id='tableau_partants']//tr[td]") as $i => $scrap) {
		$HorseWeight[$i]["poid"] = FixSpaces($RaceDatum->evaluate(".//td[count(../../..//th[.='Poids']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]",$scrap)->item(0)->nodeValue);
		$HorseWeight[$i]["dech"] = FixSpaces($RaceDatum->evaluate(".//td[count(../../..//th[.='Déch.']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]",$scrap)->item(0)->nodeValue);
		$HorseWeight[$i] = stristr($HorseWeight[$i]["dech"], "-") ? $HorseWeight[$i]["poid"] : $HorseWeight[$i]["dech"];
	}
	//print("<pre>"); var_dump($HorseWeight); print("</pre>"); exit();
	
	unset($HorseJockey, $HorseJockeyLink, $scrap, $i);
	foreach($RaceDatum->evaluate(".//table[@id='tableau_partants']//td[count(../../..//th[.='Driver' or .='Jockey']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]") as $i => $scrap) {
		$HorseJockey[$i] = FixSpaces($scrap->nodeValue);
		$HorseJockey[$i] = EquSearch($HorseJockey[$i], $Equ["hJockey"]);
		$HorseJockey[$i] = CleanSpecialChars($HorseJockey[$i]);
		$HorseJockey[$i] = EquSearch($HorseJockey[$i], $Equ["Jockey"]);
		
		$HorseJockeyLink[$i] = $RaceDatum->evaluate("./a/@href", $scrap)->item(0)->nodeValue;
		if($HorseJockeyLink[$i]) $HorseJockeyLink[$i] = "http://www.geny.com".$HorseJockeyLink[$i];
	}
	//print("<pre>"); var_dump($HorseJockey); print("</pre>"); exit();
	//print("<pre>"); var_dump($HorseJockeyLink); print("</pre>"); exit();
	
	unset($HorseTrainer, $scrap, $i);
	foreach($RaceDatum->evaluate(".//table[@id='tableau_partants']//td[count(../../..//th[.='Entraîneur']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]/a") as $i => $scrap) {
		$HorseTrainer[$i] = FixSpaces($scrap->nodeValue);
		$HorseTrainer[$i] = CleanSpecialChars($HorseTrainer[$i]);
		$HorseTrainer[$i] = EquSearch($HorseTrainer[$i], $Equ["Trainer"]);
	}
	//print("<pre>"); var_dump($HorseTrainer); print("</pre>"); exit();
	
	unset($HorseTrainerLink, $scrap, $i);
	foreach($RaceDatum->evaluate(".//table[@id='tableau_partants']//td[count(../../..//th[.='Entraîneur']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]/a") as $i => $scrap) {
		$HorseTrainerLink[$i] = $scrap->getAttribute("href");
		$HorseTrainerLink[$i] = "http://www.geny.com".$HorseTrainerLink[$i];
	}
	//print("<pre>"); var_dump($HorseTrainerLink); print("</pre>"); exit();
	
	
	unset($HorseData);
	$HorseData = MultiLinkData($HorseLink);
	
	unset($HorseDatum, $iHorse);
	foreach((array)$HorseData as $iHorse => $HorseDatum) {
		//if($iHorse != 6 - 1) continue;
		
		
		CalcProgress($totalCounts, ++$currCount, "", "", $transferSpeed[$iHorse]);
		
		
		unset($HorseIcon[$iHorse], $scrap);
		foreach($HorseDatum->evaluate(".//div[@class='yui-u first']/img/@src") as $scrap) {
			$HorseIcon[$iHorse] = $scrap->nodeValue;
		}
		//print("<pre>"); var_dump($HorseIcon); print("</pre>"); exit();
		
		unset($HorseQue[$iHorse], $scrap);
		foreach($HorseDatum->evaluate(".//div[@id='fc']/h3") as $scrap) {
			$HorseQue[$iHorse] = FixSpaces($scrap->nodeValue);
			if(stristr($HorseQue[$iHorse], "Inédit")/* || stristr($HorseQue[$iHorse], "Inédite")*/) {
				$HorseQue[$iHorse] = null;
			}
			else {
				$HorseQue[$iHorse] = EquSearch($HorseQue[$iHorse], array($EquPreg["hQue"], $Equ["hQue"]));
				$HorseQue[$iHorse] = implode(",", array_reverse(explode(",", $HorseQue[$iHorse])));
				$HorseQue[$iHorse] = str_ireplace(array(",-,","-,"), "-", $HorseQue[$iHorse]);
			}
		}
		//print("<pre>"); var_dump($HorseQue); print("</pre>"); exit();
		
		unset($HorseFather[$iHorse], $scrap);
		foreach($HorseDatum->evaluate(".//div[@id='fc']/div[3]") as $scrap) {
			$HorseFather[$iHorse] = FixSpaces($scrap->nodeValue);
			$HorseFather[$iHorse] = preg_replace("'.*\s+par\s+(.*)\s+et\s+(.*)'uis", "$01", $HorseFather[$iHorse]);
			$HorseFather[$iHorse] = CleanSpecialChars($HorseFather[$iHorse]);
		}
		//print("<pre>"); var_dump($HorseFather); print("</pre>"); exit();
		
		unset($HorseMother[$iHorse], $scrap);
		foreach($HorseDatum->evaluate(".//div[@id='fc']/div[3]") as $scrap) {
			$HorseMother[$iHorse] = FixSpaces($scrap->nodeValue);
			$HorseMother[$iHorse] = preg_replace("'.*\s+par\s+(.*)\s+et\s+(.*)'uis", "$02", $HorseMother[$iHorse]);
			$HorseMother[$iHorse] = CleanSpecialChars($HorseMother[$iHorse]);
		}
		//print("<pre>"); var_dump($HorseMother); print("</pre>"); exit();
		
		unset($HorseOwner[$iHorse], $HorseOwnerColors[$iHorse], $scrap);
		foreach($HorseDatum->evaluate(".//div[@class='yui-gd']//div[@class='yui-gd'][3]/div[@class='yui-u']") as $scrap) {
			$HorseOwner[$iHorse] = FixSpaces($scrap->nodeValue);
			$HorseOwner[$iHorse] = CleanSpecialChars($HorseOwner[$iHorse]);
			$HorseOwnerColors[$iHorse] = EquSearch($HorseOwner[$iHorse], $Equ["OwnerColors"], true);
		}
		//print("<pre>"); var_dump($HorseOwner); print("</pre>"); exit();
		//print("<pre>"); var_dump($HorseOwnerColors); print("</pre>"); exit();
		
		unset($HorsePrizes[$iHorse], $scrap);
		foreach($HorseDatum->evaluate(".//div[@class='yui-gd']//div[@class='yui-gd'][4]/div[@class='yui-u']") as $scrap) {
			$HorsePrizes[$iHorse] = FixSpaces($scrap->nodeValue);
			$HorsePrizes[$iHorse] = EquSearch($HorsePrizes[$iHorse], $Equ["hMoney"]);
			//$HorsePrizes[$iHorse] *= $RaceMoneyParity;
			$HorsePrizes[$iHorse] = number_format($HorsePrizes[$iHorse], 0, ",", ".");
		}
		if(!$HorsePrizes[$iHorse]) $HorsePrizes[$iHorse] = 0;
		//print("<pre>"); var_dump($HorsePrizes); print("</pre>"); exit();
		
		if($RaceIsTrot[$iRace]) {
			unset($HorseRaces[$iHorse]["All"], $scrap);
			foreach($HorseDatum->evaluate(".//table[@class='tableau_technique']/tr[2]/td[@class='numerique'][1]") as $scrap) {
				$HorseRaces[$iHorse]["All"] = FixSpaces($scrap->nodeValue);
			}
			//print("<pre>"); var_dump($HorseRaces); print("</pre>"); exit();
			
			unset($HorseWins[$iHorse]["All"], $scrap);
			foreach($HorseDatum->evaluate(".//table[@class='tableau_technique']/tr[2]/td[@class='numerique'][2]") as $scrap) {
				$HorseWins[$iHorse]["All"] = FixSpaces($scrap->nodeValue);
			}
			//print("<pre>"); var_dump($HorseWins); print("</pre>"); exit();
			
			unset($HorsePlaces[$iHorse]["All"], $scrap);
			foreach($HorseDatum->evaluate(".//table[@class='tableau_technique']/tr[2]/td[@class='numerique'][3]") as $scrap) {
				$HorsePlaces[$iHorse]["All"] = FixSpaces($scrap->nodeValue);
			}
			//print("<pre>"); var_dump($HorsePlaces); print("</pre>"); exit();
		}
		
		
		unset($HistoryDate[$iHorse], $scrap, $i);
		foreach($HorseDatum->evaluate(".//table[@id='tableau_fichecheval']//td[1]/a") as $i => $scrap) {
			$HistoryDate[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			if($i >= $maxHistory - 1) break;
		}
		//print("<pre>"); var_dump($HistoryDate[$iHorse]); print("</pre>"); exit();
		
		unset($HistoryLink[$iHorse], $scrap, $i);
		foreach($HorseDatum->evaluate(".//table[@id='tableau_fichecheval']//td[1]/a") as $i => $scrap) {
			$HistoryLink[$iHorse][$i] = $scrap->getAttribute("href");
			$HistoryLink[$iHorse][$i] = "http://www.geny.com".$HistoryLink[$iHorse][$i];
			if($i >= $maxHistory - 1) break;
		}
		//print("<pre>"); var_dump($HistoryLink[$iHorse]); print("</pre>"); exit();
		
		unset($HistoryTrack[$iHorse], $scrap, $i);
		foreach($HorseDatum->evaluate(".//table[@id='tableau_fichecheval']//td[2]") as $i => $scrap) {
			$HistoryTrack[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			$HistoryTrack[$iHorse][$i] = CleanSpecialChars($HistoryTrack[$iHorse][$i]);
			$HistoryTrack[$iHorse][$i] = EquSearch($HistoryTrack[$iHorse][$i], $Equ["cHippo"]);
			if($i >= $maxHistory - 1) break;
		}
		//print("<pre>"); var_dump($HistoryTrack[$iHorse]); print("</pre>"); exit();
		
		unset($HistoryRange[$iHorse], $scrap, $i);
		foreach($HorseDatum->evaluate(".//table[@id='tableau_fichecheval']//td[3]") as $i => $scrap) {
			$HistoryRange[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			$HistoryRange[$iHorse][$i] = round($HistoryRange[$iHorse][$i]);
			if($i >= $maxHistory - 1) break;
		}
		//print("<pre>"); var_dump($HistoryRange[$iHorse]); print("</pre>"); exit();
		
		unset($HistoryType[$iHorse], $scrap, $i);
		foreach($HorseDatum->evaluate(".//table[@id='tableau_fichecheval']//td[count(../../..//th[.='Spé.']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]") as $i => $scrap) {
			$HistoryType[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			$HistoryType[$iHorse][$i] = EquSearch($HistoryType[$iHorse][$i], $Equ["cType"]);
			if($i >= $maxHistory - 1) break;
		}
		//print("<pre>"); var_dump($HistoryType[$iHorse]); print("</pre>"); exit();
		
		unset($HistoryTerrain[$iHorse], $scrap, $i);
		foreach($HorseDatum->evaluate(".//table[@id='tableau_fichecheval']//td[count(../../..//th[.='Terrain']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]") as $i => $scrap) {
			$HistoryTerrain[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			$HistoryTerrain[$iHorse][$i] = CleanSpecialChars($HistoryTerrain[$iHorse][$i]);
			$HistoryTerrain[$iHorse][$i] = EquSearch($HistoryTerrain[$iHorse][$i], $Equ["cTerrain"]);
			if($i >= $maxHistory - 1) break;
		}
		//print("<pre>"); var_dump($HistoryTerrain[$iHorse]); print("</pre>"); exit();
		
		unset($HistoryPrize[$iHorse], $HistoryPrizeSymbol[$iHorse], $scrap, $i);
		foreach($HorseDatum->evaluate(".//table[@id='tableau_fichecheval']//td[count(../../..//th[.='Alloc.']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]") as $i => $scrap) {
			$HistoryPrize[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			$HistoryPrizeSymbol[$iHorse][$i] = preg_replace("'.*?\s*(\D+)$'uis", "$01", $HistoryPrize[$iHorse][$i]);
			$HistoryPrize[$iHorse][$i] = EquSearch($HistoryPrize[$iHorse][$i], $Equ["cPrize"]);
			//$HistoryPrize[$iHorse][$i] *= $RaceMoneyParity;
			$HistoryPrize[$iHorse][$i] *= stristr($HistoryPrizeSymbol[$iHorse][$i], "GBP") ? 1.2 : 1;
			$HistoryPrize[$iHorse][$i] *= stristr($HistoryPrizeSymbol[$iHorse][$i], "KR") ? 0.1 : 1;
			$HistoryPrize[$iHorse][$i] = round($HistoryPrize[$iHorse][$i] / 1000)."K";
			if($i >= $maxHistory - 1) break;
		}
		//print("<pre>"); var_dump($HistoryPrize[$iHorse]); print("</pre>"); exit();
		
		unset($HistoryRank[$iHorse], $HistoryRankIsDigit[$iHorse], $scrap, $i);
		foreach($HorseDatum->evaluate(".//table[@id='tableau_fichecheval']//td[count(../../..//th[.='Rang']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]") as $i => $scrap) {
			$HistoryRank[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			$HistoryRankIsDigit[$iHorse][$i] = EquSearch($HistoryRank[$iHorse][$i], $Equ["_cRankIsDigit"], true);
			$HistoryRank[$iHorse][$i] = EquSearch($HistoryRank[$iHorse][$i], $Equ["cRank"]);
			$HistoryRank[$iHorse][$i] = str_pad($HistoryRank[$iHorse][$i], 2, "0", STR_PAD_LEFT);
			if($i >= $maxHistory - 1) break;
		}
		//print("<pre>"); var_dump($HistoryRank[$iHorse]); print("</pre>"); exit();
		//print("<pre>"); var_dump($HistoryRankIsDigit[$iHorse]); print("</pre>"); exit();
		
		unset($HistoryRate[$iHorse], $scrap, $i);
		foreach($HorseDatum->evaluate(".//table[@id='tableau_fichecheval']//td[count(../../..//th[.='Valeur']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]") as $i => $scrap) {
			$HistoryRate[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			if($i >= $maxHistory - 1) break;
		}
		//print("<pre>"); var_dump($HistoryRate[$iHorse]); print("</pre>"); exit();
		
		unset($HistoryPetals[$iHorse], $scrap, $i);
		foreach($HorseDatum->evaluate(".//table[@id='tableau_fichecheval']//td[count(../../..//th[.='Déferré']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]") as $i => $scrap) {
			$HistoryPetals[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			$HistoryPetals[$iHorse][$i] = EquSearch($HistoryPetals[$iHorse][$i], $Equ["cPetal"]);
			if($i >= $maxHistory - 1) break;
		}
		//print("<pre>"); var_dump($HistoryPetals[$iHorse]); print("</pre>"); exit();
		
		
		unset($HistoryData[$iHorse]);
		$HistoryData[$iHorse] = MultiLinkData($HistoryLink[$iHorse]);
		
		unset($HistoryDatum, $iHistory);
		foreach((array)$HistoryData[$iHorse] as $iHistory => $HistoryDatum) {
			//if($iHistory != 3 - 1) continue;
			
			unset($HistoryClass[$iHorse][$iHistory], $HistoryClassValue[$iHorse][$iHistory], $scrap);
			foreach($HistoryDatum->evaluate(".//div[@id='fc']/div[6]/text()[count(../strong)+2]") as $scrap) {
				$HistoryClassValue[$iHorse][$iHistory] = FixSpaces($scrap->nodeValue);
				$HistoryClass[$iHorse][$iHistory] = EquSearch($HistoryClassValue[$iHorse][$iHistory], $Equ["cClass"], true);
				if(!$HistoryClass[$iHorse][$iHistory] || $HistoryClass[$iHorse][$iHistory] == "Αξ" || $HistoryClass[$iHorse][$iHistory] == "Ηd") {
					$HistoryClassValue[$iHorse][$iHistory] = EquSearch($HistoryClassValue[$iHorse][$iHistory], $EquPreg["cClass"], true);
					if($HistoryClassValue[$iHorse][$iHistory]) {
						$HistoryClass[$iHorse][$iHistory] .= ($HistoryClass[$iHorse][$iHistory] ? "/" : "").$HistoryClassValue[$iHorse][$iHistory];
					}
				}
			}
			//print("<pre>"); var_dump($HistoryClass[$iHorse]); print("</pre>"); exit();
			
			unset($HistoryRunners[$iHorse][$iHistory], $scrap);
			foreach($HistoryDatum->evaluate(".//div[@id='fc']/div[6]/text()[count(../strong)+3]") as $scrap) {
				$HistoryRunners[$iHorse][$iHistory] = FixSpaces($scrap->nodeValue);
				$HistoryRunners[$iHorse][$iHistory] = preg_replace("'.*?(\d+)\s+Partants.*'uis", "$01", $HistoryRunners[$iHorse][$iHistory]);
				$HistoryRunners[$iHorse][$iHistory] = str_pad($HistoryRunners[$iHorse][$iHistory], 2, "0", STR_PAD_LEFT);
			}
			//print("<pre>"); var_dump($HistoryRunners[$iHorse]); print("</pre>"); exit();
			
			unset($HistoryTime[$iHorse][$iHistory], $scrap);
			foreach($HistoryDatum->evaluate(".//table[@class='tableau_technique']//tr[1]/td[count(../../..//th[.='Dist.' or .='Réd. km']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]") as $scrap) {
				$HistoryTime[$iHorse][$iHistory] = FixSpaces($scrap->nodeValue);
				$HistoryTime[$iHorse][$iHistory] = EquSearch($HistoryTime[$iHorse][$iHistory], $Equ["cTime"], true);
				if(!$HistoryTime[$iHorse][$iHistory]) $HistoryTime[$iHorse][$iHistory] = EmptyChar();
			}
			//print("<pre>"); var_dump($HistoryTime[$iHorse]); print("</pre>"); exit();
			
			unset($HistoryHorseIndex[$iHorse][$iHistory]);
			$HistoryHorseIndex[$iHorse][$iHistory] = $HistoryDatum->evaluate("count(.//table[@class='tableau_technique']//tr[./td[contains(@style,'color:red;')]]/preceding-sibling::*)+1");
			//print("<pre>"); var_dump($HistoryHorseIndex[$iHorse]); print("</pre>"); exit();
			
			unset($HistoryWinner[$iHorse][$iHistory], $scrap);
			foreach($HistoryDatum->evaluate(".//table[@class='tableau_technique']//tr[".($HistoryHorseIndex[$iHorse][$iHistory] > 1 ? 1 : 2)."]/td[count(../../..//th[.='Cheval']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]/a") as $scrap) {
				$HistoryWinner[$iHorse][$iHistory] = FixSpaces($scrap->nodeValue);
				$HistoryWinner[$iHorse][$iHistory] = CleanSpecialChars($HistoryWinner[$iHorse][$iHistory]);
			}
			//print("<pre>"); var_dump($HistoryWinner[$iHorse]); print("</pre>"); exit();
			
			unset($HistoryWinnerLink[$iHorse][$iHistory], $scrap);
			foreach($HistoryDatum->evaluate(".//table[@class='tableau_technique']//tr[".($HistoryHorseIndex[$iHorse][$iHistory] > 1 ? 1 : 2)."]/td[count(../../..//th[.='Cheval']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]/a") as $scrap) {
				$HistoryWinnerLink[$iHorse][$iHistory] = $scrap->getAttribute("href");
				$HistoryWinnerLink[$iHorse][$iHistory] = "http://www.geny.com".$HistoryWinnerLink[$iHorse][$iHistory];
			}
			//print("<pre>"); var_dump($HistoryWinnerLink[$iHorse]); print("</pre>"); exit();
			
//	XPath: th > Pos. ;
			unset($HistoryStart[$iHorse][$iHistory], $scrap);
			foreach($HistoryDatum->evaluate(".//table[@class='tableau_technique']//tr[./td[contains(@style,'color:red;')]]/td[count(../../..//th[.='Corde']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]") as $scrap) {
				$HistoryStart[$iHorse][$iHistory] = FixSpaces($scrap->nodeValue);
				$HistoryStart[$iHorse][$iHistory] = EquSearch($HistoryStart[$iHorse][$iHistory], $Equ["cStart"]);
			}
			//print("<pre>"); var_dump($HistoryStart[$iHorse]); print("</pre>"); exit();
			
			unset($HistoryWeight[$iHorse][$iHistory], $scrap);
			foreach($HistoryDatum->evaluate(".//table[@class='tableau_technique']//tr[./td[contains(@style,'color:red;')]]/td[count(../../..//th[.='Poids']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]") as $scrap) {
				$HistoryWeight[$iHorse][$iHistory] = FixSpaces($scrap->nodeValue);
			}
			//print("<pre>"); var_dump($HistoryWeight[$iHorse]); print("</pre>"); exit();
			
			unset($HistoryJockey[$iHorse][$iHistory], $scrap);
			foreach($HistoryDatum->evaluate(".//table[@class='tableau_technique']//tr[./td[contains(@style,'color:red;')]]/td[count(../../..//th[.='Driver' or .='Jockey']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]/a") as $scrap) {
				$HistoryJockey[$iHorse][$iHistory] = FixSpaces($scrap->nodeValue);
				$HistoryJockey[$iHorse][$iHistory] = CleanSpecialChars($HistoryJockey[$iHorse][$iHistory]);
				$HistoryJockey[$iHorse][$iHistory] = EquSearch($HistoryJockey[$iHorse][$iHistory], $Equ["Jockey"]);
			}
			//print("<pre>"); var_dump($HistoryJockey[$iHorse]); print("</pre>"); exit();
			
			unset($HistoryJockeyLink[$iHorse][$iHistory], $scrap);
			foreach($HistoryDatum->evaluate(".//table[@class='tableau_technique']//tr[./td[contains(@style,'color:red;')]]/td[count(../../..//th[.='Driver' or .='Jockey']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]/a") as $scrap) {
				$HistoryJockeyLink[$iHorse][$iHistory] = $scrap->getAttribute("href");
				$HistoryJockeyLink[$iHorse][$iHistory] = "http://www.geny.com".$HistoryJockeyLink[$iHorse][$iHistory];
			}
			//print("<pre>"); var_dump($HistoryJockeyLink[$iHorse]); print("</pre>"); exit();
			
			unset($HistoryPerform[$iHorse][$iHistory], $scrap);
			foreach($HistoryDatum->evaluate(".//table[@class='tableau_technique']//tr[./td[contains(@style,'color:red;')]]/td[count(../../..//th[.='Cote']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]") as $scrap) {
				$HistoryPerform[$iHorse][$iHistory] = FixSpaces($scrap->nodeValue);
				$HistoryPerform[$iHorse][$iHistory] = preg_replace_callback("'([0-9.]+)/(\d+)'uis", function($m) {return round($m[1] / $m[2] , 1);}, str_ireplace(',','.',$HistoryPerform[$iHorse][$iHistory]));
				$HistoryPerform[$iHorse][$iHistory] = EquSearch($HistoryPerform[$iHorse][$iHistory], $Equ["cPerform"]);
			}
			//print("<pre>"); var_dump($HistoryPerform[$iHorse]); print("</pre>"); exit();
			
			unset($HistoryLengths[$iHorse][$iHistory], $HistoryLengthsValue[$iHorse][$iHistory], $scrap);
			if(!$HistoryRankIsDigit[$iHorse][$iHistory]) {
				$HistoryLengths[$iHorse][$iHistory] = EmptyChar();
				//print("<pre>"); var_dump($HistoryLengths[$iHorse]); print("</pre>"); exit();
			}
			else {
				foreach($HistoryDatum->evaluate(".//table[@class='tableau_technique']//tr[".($HistoryHorseIndex[$iHorse][$iHistory]>1 ? $HistoryHorseIndex[$iHorse][$iHistory] : 2)."]/td[count(../../..//th[.='Réd. km']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]") as $scrap) {
					$HistoryLengths[$iHorse][$iHistory] = FixSpaces($scrap->nodeValue);
					$HistoryLengths[$iHorse][$iHistory] = EquSearch($HistoryLengths[$iHorse][$iHistory], $Equ["cTime2First"], true);
				}
				
				unset($HistoryLengthsValue[$iHorse][$iHistory], $HistoryLengthsDecimals[$iHorse][$iHistory], $HistoryLengthsZeros[$iHorse][$iHistory], $HistoryLengthsHasPlus[$iHorse][$iHistory]);
				if(!$HistoryLengths[$iHorse][$iHistory]) {
					foreach($HistoryDatum->evaluate(".//table[@class='tableau_technique']//tr[count(./preceding-sibling::*)<".($HistoryHorseIndex[$iHorse][$iHistory]>1 ? $HistoryHorseIndex[$iHorse][$iHistory] : 2)."][count(./preceding-sibling::*)>0]/td[count(../../..//th[.='Dist.']/preceding-sibling::*)+1][count(./preceding-sibling::*)>0]") as $scrap) {
						$HistoryLengthsValue[$iHorse][$iHistory] = FixSpaces($scrap->nodeValue);
						if($HistoryHorseIndex[$iHorse][$iHistory] <= 2) {
							$HistoryLengths[$iHorse][$iHistory] = EquSearch($HistoryLengthsValue[$iHorse][$iHistory], $Equ["cTime2First_String"]);
						} else {
							$HistoryLengths[$iHorse][$iHistory] += preg_replace_callback("'(?:(\d+)\s+)?(\d+)/(\d+)'uis", function($m) {return ($m[1] ?: 0) + $m[2]/$m[3];}, EquSearch($HistoryLengthsValue[$iHorse][$iHistory],$Equ["cTime2First_Number"]));
							$HistoryLengthsDecimals[$iHorse][$iHistory] += EquSearch(EquSearch(str_ireplace("LOIN", "", $HistoryLengthsValue[$iHorse][$iHistory]), $Equ["cTime2First_String"], true), $Equ["_cTime2First"]);
							if(!$HistoryLengthsValue[$iHorse][$iHistory]) $HistoryLengthsHasPlus[$iHorse][$iHistory] = true;
							if(EquSearch($HistoryLengthsValue[$iHorse][$iHistory], $Equ["cTime2First_Zero"]) == "0") ++$HistoryLengthsZeros[$iHorse][$iHistory];
						}
					}
					if($HistoryHorseIndex[$iHorse][$iHistory] > 2) {
						if($HistoryLengthsZeros[$iHorse][$iHistory] >= 2) $HistoryLengths[$iHorse][$iHistory] += 0.25;
						if($HistoryLengths[$iHorse][$iHistory] != round($HistoryLengths[$iHorse][$iHistory])) {
							$HistoryLengths[$iHorse][$iHistory] = preg_replace_callback("'(\d+)([.]\d+)'uis", function($m) {$m[1] = $m[1] ? $m[1]." " : ""; return $m[1].($m[2] * 4)."/4";}, $HistoryLengths[$iHorse][$iHistory]);
							$HistoryLengths[$iHorse][$iHistory] = str_ireplace("2/4", "1/2", $HistoryLengths[$iHorse][$iHistory]);
						}
						if($HistoryLengthsHasPlus[$iHorse][$iHistory]) $HistoryLengths[$iHorse][$iHistory] .= "+";
					}
				}
				//print("<pre>"); var_dump($HistoryLengthsDecimals[$iHorse][$iHistory]); print("</pre>"); exit();
				//print("<pre>"); var_dump($HistoryLengths[$iHorse][$iHistory]); print("</pre>"); exit();
				
				if(!$HistoryLengths[$iHorse][$iHistory] || $HistoryTime[$iHorse][$iHistory] == EmptyChar()) $HistoryLengths[$iHorse][$iHistory] = EmptyChar();
				
				if($HistoryLengthsHasPlus[$iHorse][$iHistory]) $HistoryLengths[$iHorse][$iHistory] = EmptyChar();
				if($HistoryLengths[$iHorse][$iHistory] != EmptyChar() && $HistoryType[$iHorse][$iHistory] == "f") {
					$_cTime[$iHorse][$iHistory] = explode(".", $HistoryTime[$iHorse][$iHistory]);
					$HistoryLengthsValue[$iHorse][$iHistory] = EquSearch($HistoryLengths[$iHorse][$iHistory], $Equ["_cTime2First"]);
					$HistoryLengthsValue[$iHorse][$iHistory] = preg_replace_callback("'^(\d+)\s*(0\..+)?$'uis", function($m) {return $m[1] * 0.2 + $m[2];}, $HistoryLengthsValue[$iHorse][$iHistory]);
					if($HistoryLengthsZeros[$iHorse][$iHistory] >= 2) $HistoryLengthsValue[$iHorse][$iHistory] -= strstr($HistoryLengths[$iHorse][$iHistory], "1/4") ? 0.07 : 0.05;
					$HistoryLengthsValue[$iHorse][$iHistory] += $HistoryLengthsDecimals[$iHorse][$iHistory];
					//print("<pre>"); var_dump($HistoryLengthsValue[$iHorse][$iHistory]); print("</pre>"); exit();
					$HistoryLengths[$iHorse][$iHistory] = Secs2Mins($HistoryLengthsValue[$iHorse][$iHistory] + $_cTime[$iHorse][$iHistory][0] * 60 + $_cTime[$iHorse][$iHistory][1] + $_cTime[$iHorse][$iHistory][2] / 100);
					unset($_cTime[$iHorse][$iHistory], $HistoryLengthsValue[$iHorse][$iHistory]);
				}
				//print("<pre>"); var_dump($HistoryLengths[$iHorse]); print("</pre>"); exit();
			}
			
			unset($HistoryRankIsDigit[$iHorse][$iHistory], $HistoryHorseIndex[$iHorse][$iHistory]);
		}
	}
	
	unset($HorseIsDebut, $iHorse);
	foreach(array_keys($HorseName) as $iHorse) $HorseIsDebut[$iHorse] = ($HistoryDate[$iHorse][0] == false);
	//print("<pre>"); var_dump($HorseIsDebut); print("</pre>"); exit;
	
	
	if($RaceIsTrot[$iRace]) $file_Story["Header"] = $file_Story["Trot_Header"];
	
	
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
		<div class='row'>
			<h4 id='Prize' class='col-lg-8 col-lg-offset-2' title='Έπαθλο' data-toggle='tooltip'>".$RaceMoneySymbol." ".$RacePrize/*." - Ίπποι ".$RaceAge." ετών".(!$RaceClass ? "" : ", Κλάση ".$RaceClass).", ".$RaceType*/."</h4>
			<h4 id='Time' class='col-lg-2' title='Ώρα διεξαγωγής' data-toggle='tooltip'>".$RaceTime."</h4>
		</div>
		<br/>
	";
	
	storyTitle($file_Story["Title"], $RaceTitle);
	storySubtitle($file_Story["Subtitle"],
		$RaceName,
		$RaceMoneySymbol,
		$RacePrize/*,
		$RaceAge,
		$RaceClass,
		$RaceType*/
	);
	storyRange($file_Story["Range"], $RaceRange);
	storyTime($file_Story["Time"], $RaceTime);
	storyHeader($file_Story["Main"], "Main");
	storyHeader($file_Story["History"], "History");
	
	foreach(array_keys((array)$HorseNumber) as $iHorse) {
		$RacePrint[$iRace] .= "
			<table id='Main' class='table table-bordered' style='margin:auto;'>
				<tr>
					<th rowspan='4'><h1 title='Αύξων ίππου' data-toggle='tooltip'>".$HorseNumber[$iHorse]."</h1></th>
					<th>
						<a href='".$HorseLink[$iHorse]."' title='Φανέλα ιδιοκτήτη' data-toggle='tooltip'><img src='".$HorseIcon[$iHorse]."' /></a>
						<a href='".$HorseHistoryLink[$iHorse]."' title='Όνομα ίππου' data-toggle='tooltip'><h3 style='display:inline;'> ".strtoupper($HorseName[$iHorse])."</h3></a>
					</th>
					<th><span title='Κιλά ίππου ή&nbsp;απόσταση' data-toggle='tooltip'>".($HorseWeight[$iHorse] ?: $HorseRange[$iHorse])."</span></th>
					<th><a ".(!$HorseJockeyLink[$iHorse] ?: "href='".$HorseJockeyLink[$iHorse]."'")." title='Αναβάτης' data-toggle='tooltip'>".$HorseJockey[$iHorse]."</a></th>
					<th><a ".(!$HorseOwnerLink[$iHorse] ?: "href='".$HorseOwnerLink[$iHorse]."'")." title='Ιδιοκτήτης' data-toggle='tooltip'>".$HorseOwner[$iHorse]."</a></th>
					<th rowspan='4'><span title='Σταρτ (Θέση εκκίνησης) ή&nbsp;Πέταλα' data-toggle='tooltip'>".($HorseStart[$iHorse] ?: $HorsePetals[$iHorse])."</span></th>
				</tr>
				<tr>
					<th colspan='2'><span title='Χρώμα, φύλλο & ηλικία' data-toggle='tooltip'>".$HorseColour[$iHorse].$HorseSex[$iHorse].$HorseAge[$iHorse]."</span><span> &nbsp;</span><span title='Τελευταίες συμμετοχές' data-toggle='tooltip'>(".($HorseQue[$iHorse] ?: "Ντεμπούτο").")</span></th>
					<th><a ".(!$HorseTrainerLink[$iHorse] ?: "href='".$HorseTrainerLink[$iHorse]."'")." title='Προπονητής' data-toggle='tooltip'>".$HorseTrainer[$iHorse]."</a></th>
					<th><span title='Χρώματα ιδιοκτήτη' data-toggle='tooltip'>".$HorseOwnerColors[$iHorse]."</span></th>
				</tr>
				<tr>
					<th colspan='2'>
						<a ".(!$HorseFatherLink[$iHorse] ?: "href='".$HorseFatherLink[$iHorse]."'")." title='Πατέρας' data-toggle='tooltip'>".$HorseFather[$iHorse]."</a>
						<span> - </span>
						<a ".(!$HorseMotherLink[$iHorse] ?: "href='".$HorseMotherLink[$iHorse]."'")." title='Μητέρα' data-toggle='tooltip'>".$HorseMother[$iHorse]."</a>
					</th>
					<th>"/*.($hIsDebut[$iHorse] ? "" : "<span title='Καλύτερη απόδοση (ημερομηνία)' data-toggle='tooltip'>Top rate: ".(!$HorseTopRate[$iHorse] ? "-" : $HorseTopRate[$iHorse]." (".$HorseTopDate[$iHorse].")")."</span>")*/."</th>
					<th><span title='Συνολικά έπαθλα' data-toggle='tooltip'>".$RaceMoneySymbol." ".($HorsePrizes[$iHorse] ?: 0)."</span></th>
				</tr>
				<tr>
					<th colspan='4'>
		".(!$RaceIsTrot[$iRace] ? "" : "
						<span title='Συμμετοχές, νίκες &&nbsp;πλασέ&nbsp;(2ος&nbsp;&&nbsp;3ος)' data-toggle='tooltip'>Συμμ.-νίκ.-πλ.: ".($hIsDebut[$iHorse] ? "-" : "[".$HorseRaces[$iHorse]["All"]."-".$HorseWins[$iHorse]["All"]."-".$HorsePlaces[$iHorse]["All"]."]")."</span>
			"/*.(!$HorseRaces[$iHorse]["Track"] && !$HorseRaces[$iHorse]["Range"] ? "" : "
						<span title='Σε ιππόδρομο' data-toggle='tooltip'>&nbsp; &nbsp;Σε Ιππόδρ. (".$HorseRaces[$iHorse]["Track"]."-".$HorseWins[$iHorse]["Track"]."-".$HorsePlaces[$iHorse]["Track"].")</span>
						<span title='Σε απόσταση' data-toggle='tooltip'>, Απόστ. (".$HorseRaces[$iHorse]["Range"]."-".$HorseWins[$iHorse]["Range"]."-".$HorsePlaces[$iHorse]["Range"].")</span>
						<span title='Σε ιππόδρομο & απόσταση μαζί' data-toggle='tooltip'>, Ιππόδρ.-Απόστ. (".$HorseRaces[$iHorse]["Track_Range"]."-".$HorseWins[$iHorse]["Track_Range"]."-".$HorsePlaces[$iHorse]["Track_Range"].")</span>
			")*/."
		")."
					</th>
				</tr>
			</table>
			"/*.($HorseBlinkers[$iHorse] ? " (".$HorseBlinkers[$iHorse].")" : "")*/."
		";
		
		storyMainBody($file_Story["Main"],
			$HorseIsDebut[$iHorse],
			strtoupper($HorseName[$iHorse]),
			$HorseWeight[$iHorse] ?: $HorseRange[$iHorse],
			$HorseJockey[$iHorse],
			$HorseOwner[$iHorse],
			$HorseNumber[$iHorse],
			"", //$HorseColor[$iHorse],
			$HorseSex[$iHorse],
			$HorseAge[$iHorse],
			$HorseQue[$iHorse] ?: "Ντεμπούτο",
			$HorseTrainer[$iHorse],
			$HorseOwnerColors[$iHorse],
			$HorseStart[$iHorse] ?: $HorsePetals[$iHorse],
			$HorseFather[$iHorse],
			$HorseMother[$iHorse],
			"NO", //$HorseTopRate[$iHorse],
			"", //$HorseTopDate[$iHorse],
			$RaceMoneySymbol,
			$HorsePrizes[$iHorse],
			$HorseRaces[$iHorse],
			$HorseWins[$iHorse],
			$HorsePlaces[$iHorse],
			$RaceIsTrot[$iRace]
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
					".($RaceIsTrot[$iRace] ? "
						<th><span title='Κλάση (κατηγορία) κούρσας' data-toggle='tooltip'>Κλάση</span></th>
						<th><span title='Στοίβος' data-toggle='tooltip'>Στ.</span></th>
					" : "
						<th><span title='Πέταλα ίππου' data-toggle='tooltip'>Π.</span></th>
					")."
						<th><span title='Έπαθλο' data-toggle='tooltip'>Έπαθ.</span></th>
						<th><span title='Όνομα νικητή ή δεύτερου αν νικήσει ο τρέχων ίππος' data-toggle='tooltip'>Νικητής ή 2ος</span></th>
						<th><span title='Χρόνος νικητή' data-toggle='tooltip'>Χρόνος 1ου</span></th>
						<th><span title='Χρόνος 2ου ή χρόνος 1ου αν νικήσει ο τρέχων ίππος' data-toggle='tooltip'>Χρόν. ή Χρ.<br/>2ου ή διαφ.</span></th>
					".($RaceIsTrot[$iRace] ? "" : "
						<th><span title='Επίσημη αξιολόγηση (Official&nbsp;Rating)' data-toggle='tooltip'>R</span></th>
					")."
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
			foreach(array_keys((array)$HistoryDate[$iHorse]) as $iHistory) {
				if($iHistory > $maxHistory - 1) break;
			
				$RacePrint[$iRace] .= "
					<tr>
						<td><a href='".$HistoryLink[$iHorse][$iHistory]."'>".$HistoryDate[$iHorse][$iHistory]."</a></td>
						<td><a ".(!$HistoryResultsLink[$iHorse][$iHistory] ?: "href='".$HistoryResultsLink[$iHorse][$iHistory]."'")."><strong>".$HistoryRank[$iHorse][$iHistory]."</strong>/".$HistoryRunners[$iHorse][$iHistory]."</a></td>
						<td>
							".(!$HistoryWeight[$iHorse][$iHistory] ? "" : "<span>(".$HistoryWeight[$iHorse][$iHistory].")</span>")."
							<a ".(!$HistoryJockeyLink[$iHorse][$iHistory] ?: "href='".$HistoryJockeyLink[$iHorse][$iHistory]."'").">".$HistoryJockey[$iHorse][$iHistory]."</a>
							".(!$HistoryStart[$iHorse][$iHistory] ? "" : "<span>(".$HistoryStart[$iHorse][$iHistory].")</span>")."
						</td>
						<td><strong>".$HistoryTrack[$iHorse][$iHistory]."</strong></td>
						<td><span>".$HistoryRange[$iHorse][$iHistory]." ".$HistoryType[$iHorse][$iHistory]."</span></td>
					".(!$RaceIsTrot[$iRace] ? "
						<td><span>".($HistoryClass[$iHorse][$iHistory] ?: EmptyChar())."</span></th>
						<td><span>".($HistoryTerrain[$iHorse][$iHistory] ?: EmptyChar())."</span></th>
					" : "
						<td><span>".$HistoryPetals[$iHorse][$iHistory]."</span></td>
					")."
						<td><span>".$HistoryPrize[$iHorse][$iHistory]."</span></td>
						<td><a ".(!$HistoryWinnerLink[$iHorse][$iHistory] ?: "href='".$HistoryWinnerLink[$iHorse][$iHistory]."'").">".$HistoryWinner[$iHorse][$iHistory]."</a></td>
						<td><span>".$HistoryTime[$iHorse][$iHistory]."</span></td>
						<td><span>".$HistoryLengths[$iHorse][$iHistory]."</span></td>
					".($RaceIsTrot[$iRace] ? "" : "
						<td>".($HistoryRate[$iHorse][$iHistory] ?: EmptyChar())."</th>
					")."
						<td><span>".$HistoryPerform[$iHorse][$iHistory]."</span></td>
					</tr>
				";
				
				if(!$RaceIsTrot[$iRace]) {
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
						$HistoryTime[$iHorse][$iHistory],
						$HistoryLengths[$iHorse][$iHistory],
						$HistoryRate[$iHorse][$iHistory] ?: EmptyChar(),
						$HistoryPerform[$iHorse][$iHistory]
					);
				}
				else {
					storyHistoryBody_Trot($file_Story["History"],
						$iHistory + 1,
						$HistoryDate[$iHorse][$iHistory],
						$HistoryRank[$iHorse][$iHistory],
						$HistoryRunners[$iHorse][$iHistory],
						$HistoryJockey[$iHorse][$iHistory],
						$HistoryTrack[$iHorse][$iHistory],
						$HistoryRange[$iHorse][$iHistory],
						$HistoryType[$iHorse][$iHistory],
						$HistoryPetals[$iHorse][$iHistory],
						$HistoryPrize[$iHorse][$iHistory],
						$HistoryWinner[$iHorse][$iHistory],
						$HistoryTime[$iHorse][$iHistory],
						$HistoryLengths[$iHorse][$iHistory],
						$HistoryPerform[$iHorse][$iHistory]
					);
				}
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