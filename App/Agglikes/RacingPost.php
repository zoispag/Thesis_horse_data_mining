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


unset($RaceData);
$RaceData = MultiLinkData($Links);

unset($totalCounts, $RaceDatum);
foreach((array)$RaceData as $RaceDatum)
	$totalCounts += $RaceDatum->evaluate("count(//div/table[@id='sc_horseCard']//tr/td[3]/a/@href)");

unset($RaceDatum, $iRace);
foreach((array)$RaceData as $iRace => $RaceDatum) {
	//if($iRace != 2 - 1) continue;
	
	unset($RaceNumber);
	$RaceNumber = $iRace + 1;
	//print("<pre>"); var_dump($RaceNumber); print("</pre>"); exit();
	
	unset($RaceLink, $scrap);
	foreach($RaceDatum->evaluate(".//a[@class='print']") as $scrap) {
		$RaceLink = FixSpaces($scrap->getAttributeNode("href")->value);
		$RaceLink = preg_replace("'.*?course_id=(\d+).*'uis", "http://www.racingpost.com/horses/course_home.sd?crs_id=$01", $RaceLink);
	}
	//print("<pre>"); var_dump($RaceLink); print("</pre>"); exit();
	
	unset($RaceTime, $scrap);
	foreach($RaceDatum->evaluate(".//h1[@class='cardHeadline']") as $scrap) {
		$RaceTime = FixSpaces($RaceDatum->evaluate("./span[@class='navRace']/span",$scrap)->item(0)->nodeValue);
		$RaceTime = date('H.i', strtotime("+12 hours", strtotime($RaceTime)));
		
		$TrackName = FixSpaces($RaceDatum->evaluate("./span[@class='placeRace']/node()[1]",$scrap)->item(0)->nodeValue);
		$TrackName = preg_replace("'[(].+[)]'uis", "", $TrackName);
		$RaceTitle =
			$TrackName
			."   -   ".
			str_replace(
				array("1","2","3","4","5","6","7"),
				array("ΔΕΥΤΕΡΑ","ΤΡΙΤΗ","ΤΕΤΑΡΤΗ","ΠΕΜΠΤΗ","ΠΑΡΑΣΚΕΥΗ","ΣΑΒΒΑΤΟ","ΚΥΡΙΑΚΗ"),
				date("N",strtotime($_REQUEST["Date"]))
			)
			." ".
			date("j/n",strtotime($_REQUEST["Date"]))
		;
		$RaceTitle = strtoupper($RaceTitle);
	}
	//print("<pre>"); var_dump($RaceTime); print("</pre>"); exit();
	//print("<pre>"); var_dump($TrackName); print("</pre>"); exit();
	//print("<pre>"); var_dump($RaceTitle); print("</pre>"); exit();
	
	unset($RaceName, $scrap);
	foreach($RaceDatum->evaluate("(.//*[@class = 'raceInfo clearfix']//strong)[2]") as $scrap) {
		$RaceName = FixSpaces($scrap->nodeValue);
	}
	//print("<pre>"); var_dump($RaceName); print("</pre>"); exit();
	
	unset($RaceInfo, $RaceType, $RaceClass, $scrap);
	foreach($RaceDatum->evaluate(".//*[@class='raceInfo clearfix']/div/p/strong") as $scrap) {
		$RaceInfo = FixSpaces($scrap->nodeValue);
		
		$RaceType = EquSearch($RaceInfo, $Equ["Type"], true);
		if(!$RaceType) $RaceType = "Επίπεδη";
		
//		$RaceClass = EquSearch($RaceInfo, array($EquPreg["Class"], $Equ["Class"]), true, true);
		
		unset($RaceInfo);
	}
	//print("<pre>"); var_dump($RaceType); print("</pre>"); exit();
	//print("<pre>"); var_dump($RaceClass); print("</pre>"); exit();
/*	
	if(!strstr($RaceClass, "G") && !strstr($RaceClass, "L")) {
		foreach($RaceDatum->evaluate(".//*[@class='raceInfo clearfix']/div/p/text()[contains(.,'CLASS')]") as $scrap) {
			$RaceInfo = FixSpaces($scrap->nodeValue);
			if($RaceClass) $RaceClass.= "/";
			$RaceClass .= preg_replace("'[(]CLASS\s+(\d+).+'uis", "$01", $RaceInfo);
			unset($RaceInfo);
		}
	}
	//print("<pre>"); var_dump($RaceClass); print("</pre>"); exit();
	
	unset($RaceAge, $scrap);
	foreach($RaceDatum->evaluate(".//*[@class='raceInfo clearfix']/div/p/text()[contains(.,'yo')]") as $scrap) {
		$RaceAge = FixSpaces($scrap->nodeValue);
		$RaceAge = preg_replace("'.+?(\d+-)?(\d+)yo([+])?.+'uis", "$01$02$03", $RaceAge);
	}
	//print("<pre>"); var_dump($RaceAge); print("</pre>"); exit();
*/	
	unset($RaceMoneyParity);
	$RaceMoneyParity = 1.25;
	//print("<pre>"); var_dump($RaceMoneyParity); print("</pre>"); exit();
	
	unset($RaceMoneySymbol, $scrap);
	foreach($RaceDatum->evaluate(".//strong[preceding-sibling::text() = 'Winner: ']") as $scrap) {
		$RaceMoneySymbol = FixSpaces($scrap->nodeValue);
		$RaceMoneySymbol = preg_replace("'([€£]).+'uis", "$01", $RaceMoneySymbol);
	}
	//print("<pre>"); var_dump($RaceMoneySymbol); print("</pre>"); exit();
	
	unset($RacePrize, $scrap);
	foreach($RaceDatum->evaluate(".//*[@id='raceConditionsText']/text()[1]") as $scrap) {
		$RacePrize = FixSpaces($scrap->nodeValue);
		$RacePrize = preg_replace("'[^0-9.]'uis", "", $RacePrize);
		//if($RaceMoneySymbol == "£") $RacePrize *= $RaceMoneyParity;
		$RacePrize = number_format($RacePrize, 0, ',', '.');
	}
	//print("<pre>"); var_dump($RacePrize); print("</pre>"); exit();
	
	unset($RaceRange, $scrap);
	foreach($RaceDatum->evaluate(".//strong[preceding-sibling::text()='Distance: ']") as $scrap) {
		$RaceRange = FixSpaces($scrap->nodeValue);
		$RaceRange = preg_replace_callback("'(?:(\d+)m)?(?:(\d+)f)?(?:(\d+)y)?'uis", function($m) { return (($m[1] ?: 0)*8 + ($m[2] ?: 0) + (int)(($m[3] ?: 0)/100) ?: NULL); }, $RaceRange);
		$RaceRange *= 200;
	}
	//print("<pre>"); var_dump($RaceRange); print("</pre>"); exit();
	
	
	unset($HorseNumber, $scrap, $i);
	foreach($RaceDatum->evaluate(".//tr[@class='cr']/td[@class='t']/strong") as $i => $scrap) {
		$HorseNumber[$i] = FixSpaces($scrap->nodeValue);
	}
	//print("<pre>"); var_dump($HorseNumber); print("</pre>"); exit();
	
	unset($HorseStart, $scrap, $i);
	foreach($RaceDatum->evaluate(".//tr[@class='cr']/td[@class='t']/sup") as $i => $scrap) {
		$HorseStart[$i] = FixSpaces($scrap->nodeValue);
	}
	//print("<pre>"); var_dump($HorseStart); print("</pre>"); exit();
	
	unset($HorseIcon, $scrap, $i);
	foreach($RaceDatum->evaluate(".//tr[@class='cr']//img[@class='iepng']/@src") as $i => $scrap) {
		$HorseIcon[$i] = $scrap->nodeValue;
	}
	//print("<pre>"); var_dump($HorseIcon); print("</pre>"); exit();
	
	unset($HorseName, $scrap, $i);
	foreach($RaceDatum->evaluate(".//tr[@class='cr']/td[3]/a/b") as $i => $scrap) {
		$HorseName[$i] = FixSpaces($scrap->nodeValue);
		$HorseName[$i] = ucwords(strtolower($HorseName[$i]));
		$HorseName[$i] = EquSearch($HorseName[$i], $Equ["hName"]);
	}
	//print("<pre>"); var_dump($HorseName); print("</pre>"); exit();
	
	unset($HorseLink, $scrap, $i);
	foreach($RaceDatum->evaluate(".//tr[@class='cr']/td[3]/a/@href") as $i => $scrap) {
		$HorseLink[$i] = $scrap->nodeValue;
	}
	//print("<pre>"); var_dump($HorseLink); print("</pre>"); exit();
	
	unset($HorseStatsLink);
	$HorseStatsLink = EquSearch($HorseLink, $EquPreg["hStatsUrls"]);
	//print("<pre>"); var_dump($HorseStatsLink); print("</pre>"); exit();
	
	unset($HorseHistoryLink);
	$HorseHistoryLink = EquSearch($HorseLink, $EquPreg["hHistoryUrls"]);
	//print("<pre>"); var_dump($HorseHistoryLink); print("</pre>"); exit();
	
	unset($HorseAge, $scrap, $i);
	foreach($RaceDatum->evaluate(".//tr[@class='cr']/td[@class='c']") as $i => $scrap) {
		$HorseAge[$i] = FixSpaces($scrap->nodeValue);
	}
	//print("<pre>"); var_dump($HorseAge); print("</pre>"); exit();
	
	unset($HorseWeight, $scrap, $i);
	foreach($RaceDatum->evaluate(".//tr[@class='cr']/td[@class='two'][1]/div[1]") as $i => $scrap) {
		$HorseWeight[$i] = FixSpaces($scrap->nodeValue);
		$HorseWeight[$i] = preg_replace_callback("'(\d+)-(\d+)'uis", function($m) {return round(($m[1]*6.35 + $m[2]*0.45)*2)/2;}, $HorseWeight[$i]);
	}
	//print("<pre>"); var_dump($HorseWeight); print("</pre>"); exit();
	
	unset($HorseJockey, $scrap, $i);
	foreach($RaceDatum->evaluate(".//tr[@class='cr']/td[@class='two'][2]/div[1]/node()[name()='a' or name()='span']") as $i => $scrap) {
		$HorseJockey[$i] = FixSpaces($scrap->nodeValue);
		$HorseJockey[$i] = EquSearch($HorseJockey[$i], $Equ["hJockey"]);
		$HorseJockey[$i] = EquSearch($HorseJockey[$i], $Equ["Jockey"]);
	}
	//print("<pre>"); var_dump($HorseJockey); print("</pre>"); exit();
	
	unset($HorseJockeyLink, $scrap, $i);
	foreach($RaceDatum->evaluate(".//tr[@class='cr']/td[@class='two'][2]/div[1]/node()[name()='a' or name()='span']") as $i => $scrap) {
		$HorseJockeyLink[$i] = $scrap->getAttribute("href");
	}
	//print("<pre>"); var_dump($HorseJockeyLink); print("</pre>"); exit();
	
	unset($HorseTrainer, $scrap, $i);
	foreach($RaceDatum->evaluate(".//tr[@class='cr']/td[@class='two'][2]/div[2]/node()[name()='a' or name()='span']") as $i => $scrap) {
		$HorseTrainer[$i] = FixSpaces($scrap->nodeValue);
		$HorseTrainer[$i] = EquSearch($HorseTrainer[$i], $Equ["Trainer"]);
	}
	//print("<pre>"); var_dump($HorseTrainer); print("</pre>"); exit();

	unset($HorseTrainerLink, $scrap, $i);
	foreach($RaceDatum->evaluate(".//tr[@class='cr']/td[@class='two'][2]/div[2]/node()[name()='a' or name()='span']") as $i => $scrap) {
		$HorseTrainerLink[$i] = $scrap->getAttribute("href");
	}
	//print("<pre>"); var_dump($HorseTrainerLink); print("</pre>"); exit();
	
	unset($HorseColor, $scrap, $i);
	foreach($RaceDatum->evaluate(".//p[@class='pedigrees']/text()[1]") as $i => $scrap) {
		$HorseColor[$i] = FixSpaces($scrap->nodeValue);
		$HorseColor[$i] = preg_replace("'(.*)\s+(.*)'uis", "$01", $HorseColor[$i]);
		$HorseColor[$i] = EquSearch($HorseColor[$i], $Equ["hColour"]);
	}
	//print("<pre>"); var_dump($HorseColor); print("</pre>"); exit();
	
	unset($HorseSex, $scrap, $i);
	foreach($RaceDatum->evaluate(".//p[@class='pedigrees']/text()[1]") as $i => $scrap) {
		$HorseSex[$i] = FixSpaces($scrap->nodeValue);
		$HorseSex[$i] = preg_replace("'(.*)\s+(.*)'uis", "$02", $HorseSex[$i]);
		$HorseSex[$i] = EquSearch($HorseSex[$i], $Equ["hSex"]);
	}
	//print("<pre>"); var_dump($HorseSex); print("</pre>"); exit();
	
	unset($HorseFather, $scrap, $i);
	foreach($RaceDatum->evaluate(".//p[@class='pedigrees']/a[1]") as $i => $scrap) {
		$HorseFather[$i] = FixSpaces($scrap->nodeValue);
		$HorseFather[$i] = EquSearch($HorseFather[$i], array($EquPreg["hFather"],$Equ["hFather"]));
	}
	//print("<pre>"); var_dump($HorseFather); print("</pre>"); exit();
	
	unset($HorseFatherLink, $scrap, $i);
	foreach($RaceDatum->evaluate(".//p[@class='pedigrees']/a[1]") as $i => $scrap) {
		$HorseFatherLink[$i] = $scrap->getAttribute("href");
	}
	//print("<pre>"); var_dump($HorseFatherLink); print("</pre>"); exit();
	
	unset($HorseMother, $scrap, $i);
	foreach($RaceDatum->evaluate(".//p[@class='pedigrees']/a[2]") as $i => $scrap) {
		$HorseMother[$i] = FixSpaces($scrap->nodeValue);
		$HorseMother[$i] = EquSearch($HorseMother[$i], array($EquPreg["hMother"],$Equ["hMother"]));
	}
	//print("<pre>"); var_dump($HorseMother); print("</pre>"); exit();
	
	unset($HorseMotherLink, $scrap, $i);
	foreach($RaceDatum->evaluate(".//p[@class='pedigrees']/a[2]") as $i => $scrap) {
		$HorseMotherLink[$i] = $scrap->getAttribute("href");
	}
	//print("<pre>"); var_dump($HorseMotherLink); print("</pre>"); exit();
	
	unset($HorseOwner, $HorseOwnerColors, $scrap, $i);
	foreach($RaceDatum->evaluate(".//p[@class='owners']/a") as $i => $scrap) {
		$HorseOwner[$i] = FixSpaces($scrap->nodeValue);
		$HorseOwnerColors[$i] = EquSearch($HorseOwner[$i], $Equ["OwnerColors"], true);
	}
	//print("<pre>"); var_dump($HorseOwner); print("</pre>"); exit();
	//print("<pre>"); var_dump($HorseOwnerColors); print("</pre>"); exit();
	
	unset($HorseOwnerLink, $scrap, $i);
	foreach($RaceDatum->evaluate(".//p[@class='owners']/a") as $i => $scrap) {
		$HorseOwnerLink[$i] = $scrap->getAttribute("href");
	}
	//print("<pre>"); var_dump($HorseOwnerLink); print("</pre>"); exit();
	
	unset($scrapHorse, $iHorse);
	foreach($RaceDatum->evaluate(".//td[@class='cardItemInfo']/div[@class='forms']") as $iHorse => $scrapHorse) {
		//if($iHorse != 2) continue;
		
		unset($HistoryDate[$iHorse], $scrap, $i);
		foreach($RaceDatum->evaluate(".//table[@class='grid smallSpaceGrid']//td[1]/a", $scrapHorse) as $i => $scrap) {
			$HistoryDate[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			$HistoryDate[$iHorse][$i] = date('d/m/y', strtotime($HistoryDate[$iHorse][$i]));
		}
		//print("<pre>"); var_dump($HistoryDate[$iHorse]); print("</pre>"); exit();
		
		unset($HistoryLink[$iHorse], $scrap, $i);
		foreach($RaceDatum->evaluate(".//table[@class='grid smallSpaceGrid']//td[1]/a/@href", $scrapHorse) as $i => $scrap) {
			$HistoryLink[$iHorse][$i] = "http://www.racingpost.com".$scrap->nodeValue;
		}
		//print("<pre>"); var_dump($HistoryLink[$iHorse]); print("</pre>"); exit();
		
		unset($HistoryResultsLink[$iHorse]);
		$HistoryResultsLink[$iHorse] = EquSearch($HistoryLink[$iHorse], $EquPreg["cResultsUrls"]);
		//print("<pre>"); var_dump($HistoryResultsLink[$iHorse]); print("</pre>"); exit();
		
		unset($HistoryTerrain[$iHorse], $scrap, $i);
		foreach($RaceDatum->evaluate(".//table[@class='grid smallSpaceGrid']//td[2]/b/text()[2]", $scrapHorse) as $i => $scrap) {
			$HistoryTerrain[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			$HistoryTerrain[$iHorse][$i] = EquSearch($HistoryTerrain[$iHorse][$i], $Equ["cTerrain"]);
		}
		//print("<pre>"); var_dump($HistoryTerrain[$iHorse]); print("</pre>"); exit();
		
		unset($HistoryWeight[$iHorse], $scrap, $i);
		foreach($RaceDatum->evaluate(".//table[@class='grid smallSpaceGrid']//td[3]", $scrapHorse) as $i => $scrap) {
			$HistoryWeight[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			$HistoryWeight[$iHorse][$i] = preg_replace_callback("'(\d+)-(\d+)'uis", function($m) {return round(($m[1]*6.35 + $m[2]*0.45)*2)/2;}, $HistoryWeight[$iHorse][$i]);
		}
		//print("<pre>"); var_dump($HistoryWeight[$iHorse]); print("</pre>"); exit();
		
		unset($HistoryRank[$iHorse], $HistoryIsFirst[$iHorse], $scrap, $i);
		foreach($RaceDatum->evaluate(".//table[@class='grid smallSpaceGrid']//td[4]/b", $scrapHorse) as $i => $scrap) {
			$HistoryRank[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			$HistoryRank[$iHorse][$i] = EquSearch($HistoryRank[$iHorse][$i], array($EquPreg["cRank"],$Equ["cRank"]));
			$HistoryRank[$iHorse][$i] = str_pad($HistoryRank[$iHorse][$i], 2, "0", STR_PAD_LEFT);
			$HistoryIsFirst[$iHorse][$i] = $HistoryRank[$iHorse][$i] == 1 ? true : false;
		}
		//print("<pre>"); var_dump($HistoryRank[$iHorse]); print("</pre>"); exit();
		//print("<pre>"); var_dump($HistoryIsFirst[$iHorse]); print("</pre>"); exit();
		
		unset($HistoryRunners[$iHorse], $scrap, $i);
		foreach($RaceDatum->evaluate(".//table[@class='grid smallSpaceGrid']//td[4]/text()[2]", $scrapHorse) as $i => $scrap) {
			$HistoryRunners[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			$HistoryRunners[$iHorse][$i] = EquSearch($HistoryRunners[$iHorse][$i], $Equ["cParts"]);
			$HistoryRunners[$iHorse][$i] = str_pad($HistoryRunners[$iHorse][$i], 2, "0", STR_PAD_LEFT);
		}
		//print("<pre>"); var_dump($HistoryRunners[$iHorse]); print("</pre>"); exit();
		
		/*unset($HistoryLengths[$iHorse], $scrap, $i);
		foreach($RaceDatum->evaluate(".//table[@class='grid smallSpaceGrid']//td[4]/a", $scrapHorse) as $i => $scrap) {
			$HistoryLengths[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			$HistoryLengths[$iHorse][$i] = preg_filter("'[(](.*?)[+]?L?\s*([A-Z].*?)\s+\d+-\d+[)]'us", "$01", $HistoryLengths[$iHorse][$i]);
			$HistoryLengths[$iHorse][$i] = EquSearch($HistoryLengths[$iHorse][$i], array($EquPreg["cTime2First"], $Equ["cTime2First"]));
		}*/
		//print("<pre>"); var_dump($HistoryLengths[$iHorse]); print("</pre>"); exit();
		
		unset($HistoryWinner[$iHorse], $scrap, $i);
		foreach($RaceDatum->evaluate(".//table[@class='grid smallSpaceGrid']//td[4]/a", $scrapHorse) as $i => $scrap) {
			$HistoryWinner[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			$HistoryWinner[$iHorse][$i] = preg_filter("'[(](.*?)[+]?L?\s*([A-Z].*?)\s+\d+-\d+[)]'us", "$02", $HistoryWinner[$iHorse][$i]);
		}
		//print("<pre>"); var_dump($HistoryWinner[$iHorse]); print("</pre>"); exit();
		
		unset($HistoryPerform[$iHorse], $scrap, $i);
		foreach($RaceDatum->evaluate(".//table[@class='grid smallSpaceGrid']//td[4]/text()[3]", $scrapHorse) as $i => $scrap) {
			$HistoryPerform[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			$HistoryPerform[$iHorse][$i] = EquSearch($HistoryPerform[$iHorse][$i], array($Equ["cPerform"],$EquPreg["cPerform"]));
			$HistoryPerform[$iHorse][$i] = preg_replace_callback("'\D*(\d+)/(\d+)\D*'uis", function($m) {return round($m[1]/$m[2]+1, 1);}, $HistoryPerform[$iHorse][$i]);
		}
		//print("<pre>"); var_dump($HistoryPerform[$iHorse]); print("</pre>"); exit();
		
		unset($HistoryJockey[$iHorse], $scrap, $i);
		foreach($RaceDatum->evaluate(".//table[@class='grid smallSpaceGrid']//td[5]/a", $scrapHorse) as $i => $scrap) {
			$HistoryJockey[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			$HistoryJockey[$iHorse][$i] = EquSearch($HistoryJockey[$iHorse][$i], $Equ["Jockey"]);
		}
		//print("<pre>"); var_dump($HistoryJockey[$iHorse]); print("</pre>"); exit();
		
		unset($HistoryJockeyLink[$iHorse], $scrap, $i);
		foreach($RaceDatum->evaluate(".//table[@class='grid smallSpaceGrid']//td[5]/a", $scrapHorse) as $i => $scrap) {
			$HistoryJockeyLink[$iHorse][$i] = $scrap->getAttribute("href");
		}
		//print("<pre>"); var_dump($HistoryJockeyLink[$iHorse]); print("</pre>"); exit();
		
		unset($HistoryRate[$iHorse], $scrap, $i);
		foreach($RaceDatum->evaluate(".//table[@class='grid smallSpaceGrid']//td[@class='num'][1]", $scrapHorse) as $i => $scrap) {
			$HistoryRate[$iHorse][$i] = FixSpaces($scrap->nodeValue);
			$HistoryRate[$iHorse][$i] = EquSearch($HistoryRate[$iHorse][$i], $Equ["cORating"]);
		}
		//print("<pre>"); var_dump($HistoryRate[$iHorse]); print("</pre>"); exit();
	}
	
	
	unset($HorseData);
	$HorseData = MultiLinkData($HorseLink);
	
	unset($HorseDatum, $iHorse);
	foreach((array)$HorseData as $iHorse => $HorseDatum) {
		//if($iHorse != 6 - 1) continue;
		
		unset($HorseQue[$iHorse], $HorseQueValue, $HorseQueYear, $HorseQuePrevYear, $scrap, $i);
		foreach($HorseDatum->evaluate("(.//table[@class='grid']//td[4]/b)[position()<=10]") as $i => $scrap) {
			$HorseQueValue = FixSpaces($scrap->nodeValue);
			$HorseQueValue = EquSearch($HorseQueValue, array($Equ["cRank"], $EquPreg["cRank"]));
			$HorseQueYear = FixSpaces($HorseDatum->evaluate("(.//table[@class='grid']//td[1]/a)[".($i + 1)."]")->item(0)->nodeValue);
			$HorseQueYear = date('y', strtotime($HorseQueYear));
			if(!$HorseQue[$iHorse])
				$HorseQue[$iHorse] = $HorseQueValue;
			else
				$HorseQue[$iHorse] = $HorseQueValue.($HorseQuePrevYear > $HorseQueYear ? "-" : ",").$HorseQue[$iHorse];
			$HorseQuePrevYear = $HorseQueYear;
		}
		//print("<pre>"); var_dump($HorseQue[$iHorse]); print("</pre>"); exit();
		
		unset($HorseTopRate[$iHorse], $HorseTopDate[$iHorse], $HorseTopRateValue, $HorseTopRateDate, $HorseTopRateType, $scrap, $i);
		foreach($HorseDatum->evaluate(".//table[@class='grid']//td[@class='right'][1]") as $i => $scrap) {
			$HorseTopRateValue = FixSpaces($scrap->nodeValue);
			$HorseTopRateDate = FixSpaces($HorseDatum->evaluate("(.//table[@class='grid']//td[1]/a)[".($i + 1)."]")->item(0)->nodeValue);
			$HorseTopRateDate = date('d/m/y', strtotime($HorseTopRateDate));
			$HorseTopRateType = FixSpaces($HorseDatum->evaluate("(.//table[@class='grid']//td[2]/text()[2])[".($i + 1)."]")->item(0)->nodeValue);
			$HorseTopRateType = EquSearch($HorseTopRateType, array($EquPreg["TopRateType"], $Equ["TopRateType"]), true) ?: "Επίπεδη";
			if(!strstr($RaceType, $HorseTopRateType)) continue;
			if($HorseTopRateValue != "—" && $HorseTopRateValue > $HorseTopRate[$iHorse]) {
				$HorseTopRate[$iHorse] = $HorseTopRateValue;
				$HorseTopDate[$iHorse] = $HorseTopRateDate;
			}
		}
		//print("<pre>"); var_dump($HorseTopRate[$iHorse]); print("</pre>"); exit();
		//print("<pre>"); var_dump($HorseTopDate[$iHorse]); print("</pre>"); exit();
		
		unset($HorseRaces[$iHorse], $HorseWins[$iHorse], $HorsePlaces[$iHorse]);
		unset($scrap);
		foreach($HorseDatum->evaluate(".//b[ancestor::tr[1][@class!='fl_P']][preceding::a[1]/@href='".$RaceLink."']") as $scrap) {
			$HorseRaces[$iHorse]["Track"]++;
			
			unset($scrap2);
			foreach($HorseDatum->evaluate("./self::*[.='1']", $scrap) as $scrap2) {
				$HorseWins[$iHorse]["Track"]++;
			}
			
			unset($scrap2);
			foreach($HorseDatum->evaluate("./self::*[.='2' or .='3']", $scrap) as $scrap2) {
				$HorsePlaces[$iHorse]["Track"]++;
			}
		}
		if(!$HorseRaces[$iHorse]["Track"]) $HorseRaces[$iHorse]["Track"] = 0;
		if(!$HorseWins[$iHorse]["Track"]) $HorseWins[$iHorse]["Track"] = 0;
		if(!$HorsePlaces[$iHorse]["Track"]) $HorsePlaces[$iHorse]["Track"] = 0;
		//print("<pre>"); var_dump(array_map(function($val) {return $val["Track"];},(array)$HorseRaces)); print("</pre>"); exit();
		//print("<pre>"); var_dump(array_map(function($val) {return $val["Track"];},(array)$HorseWins)); print("</pre>"); exit();
		//print("<pre>"); var_dump(array_map(function($val) {return $val["Track"];},(array)$HorsePlaces)); print("</pre>"); exit();
		
		unset($scrap);
		foreach($HorseDatum->evaluate(".//tr[@class!='fl_P'][(.//b)[1][translate(.,translate(.,'1234567890',''),'')='".$RaceRange."']]//*[.=(../..//b)[2]]") as $scrap) {
			$HorseRaces[$iHorse]["Range"]++;
			
			unset($scrap2);
			foreach($HorseDatum->evaluate("./self::*[.='1']", $scrap) as $scrap2) {
				$HorseWins[$iHorse]["Range"]++;
			}
			
			unset($scrap2);
			foreach($HorseDatum->evaluate("./self::*[.='2' or .='3']", $scrap) as $scrap2) {
				$HorsePlaces[$iHorse]["Range"]++;
			}
			
			unset($scrap2);
			foreach($HorseDatum->evaluate("./self::*[preceding::a[1]/@href='".$RaceLink."']", $scrap) as $scrap2) {
				$HorseRaces[$iHorse]["Track_Range"]++;
				
				unset($scrap3);
				foreach($HorseDatum->evaluate("./self::*[.='1']", $scrap2) as $scrap3) {
					$HorseWins[$iHorse]["Track_Range"]++;
				}
				
				unset($scrap3);
				foreach($HorseDatum->evaluate("./self::*[.='2' or .='3']", $scrap2) as $scrap3) {
					$HorsePlaces[$iHorse]["Track_Range"]++;
				}
			}
		}
		if(!$HorseRaces[$iHorse]["Range"]) $HorseRaces[$iHorse]["Range"] = 0;
		if(!$HorseWins[$iHorse]["Range"]) $HorseWins[$iHorse]["Range"] = 0;
		if(!$HorsePlaces[$iHorse]["Range"]) $HorsePlaces[$iHorse]["Range"] = 0;
		//print("<pre>"); var_dump(array_map(function($val) {return $val["Range"];},(array)$HorseRaces)); print("</pre>"); exit();
		//print("<pre>"); var_dump(array_map(function($val) {return $val["Range"];},(array)$HorseWins)); print("</pre>"); exit();
		//print("<pre>"); var_dump(array_map(function($val) {return $val["Range"];},(array)$HorsePlaces)); print("</pre>"); exit();
		
		if(!$HorseRaces[$iHorse]["Track_Range"]) $HorseRaces[$iHorse]["Track_Range"] = 0;
		if(!$HorseWins[$iHorse]["Track_Range"]) $HorseWins[$iHorse]["Track_Range"] = 0;
		if(!$HorsePlaces[$iHorse]["Track_Range"]) $HorsePlaces[$iHorse]["Track_Range"] = 0;
		//print("<pre>"); var_dump(array_map(function($val) {return $val["Track_Range"];},(array)$HorseRaces)); print("</pre>"); exit();
		//print("<pre>"); var_dump(array_map(function($val) {return $val["Track_Range"];},(array)$HorseWins)); print("</pre>"); exit();
		//print("<pre>"); var_dump(array_map(function($val) {return $val["Track_Range"];},(array)$HorsePlaces)); print("</pre>"); exit();
	}
	
	
	unset($HorseStatsData);
	$HorseStatsData = MultiLinkData($HorseStatsLink);
	
	unset($HorseStatsDatum, $iHorse);
	foreach((array)$HorseStatsData as $iHorse => $HorseStatsDatum) {
		//if($iHorse != 6 - 1) continue;
		
		
		CalcProgress($totalCounts, ++$currCount, "", "", $transferSpeed[$iHorse]);
		
		
		unset($HorsePrizes[$iHorse], $scrap);
		foreach($HorseStatsDatum->evaluate(".//table[@class='grid right']//tr[td[@class='first left']/a/.='Rules Races']/td[7]") as $scrap) {
			$HorsePrizes[$iHorse] = FixSpaces($scrap->nodeValue);
			$HorsePrizes[$iHorse] = EquSearch($HorsePrizes[$iHorse], $Equ["hMoney"]);
			//$HorsePrizes[$iHorse] *= $RaceMoneyParity;
			$HorsePrizes[$iHorse] = number_format($HorsePrizes[$iHorse], 0, ",", ".");
		}
		//print("<pre>"); var_dump($HorsePrizes); print("</pre>"); exit();
		
		unset($HorseRaces[$iHorse]["All"], $scrap);
		foreach($HorseStatsDatum->evaluate(".//table[@class='grid right']//tr[td[@class='first left']/a/.='Rules Races']/td[2]") as $scrap) {
			$HorseRaces[$iHorse]["All"] = FixSpaces($scrap->nodeValue);
		}
		//print("<pre>"); var_dump(array_map(function($val) {return $val["All"];},(array)$HorseRaces)); print("</pre>"); exit();
		
		unset($HorseWins[$iHorse]["All"], $scrap);
		foreach($HorseStatsDatum->evaluate(".//table[@class='grid right']//tr[td[@class='first left']/a/.='Rules Races']/td[3]") as $scrap) {
			$HorseWins[$iHorse]["All"] = FixSpaces($scrap->nodeValue);
		}
		//print("<pre>"); var_dump(array_map(function($val) {return $val["All"];},(array)$HorseWins)); print("</pre>"); exit();
		
		unset($HorsePlaces[$iHorse]["All"], $scrap);
		foreach($HorseStatsDatum->evaluate(".//table[@class='grid right']//tr[td[@class='first left']/a/.='Rules Races']/td[position()=4 or position()=5]") as $scrap) {
			$HorsePlaces[$iHorse]["All"] += FixSpaces($scrap->nodeValue);
		}
		//print("<pre>"); var_dump(array_map(function($val) {return $val["All"];},(array)$HorsePlaces)); print("</pre>"); exit();
		
		
		unset($HistoryData[$iHorse]);
		$HistoryData[$iHorse] = MultiLinkData($HistoryLink[$iHorse]);
		
		unset($HistoryDatum, $iHistory);
		foreach((array)$HistoryData[$iHorse] as $iHistory => $HistoryDatum) {
			//if($iHistory != 3 - 1) continue;
			
			unset($HistoryTrack[$iHorse][$iHistory], $scrap);
			foreach($HistoryDatum->evaluate(".//div[@class='leftColBig']/h1/text()[1]") as $scrap) {
				$HistoryTrack[$iHorse][$iHistory] = FixSpaces($scrap->nodeValue);
				$HistoryTrack[$iHorse][$iHistory] = preg_replace("'(.*?)(?:\s*[(].*?[)])?\s+Result'uis", "$01", $HistoryTrack[$iHorse][$iHistory]);
				$HistoryTrack[$iHorse][$iHistory] = EquSearch($HistoryTrack[$iHorse][$iHistory], $Equ["cHippo"]);
			}
			//print("<pre>"); var_dump($HistoryTrack[$iHorse]); print("</pre>"); exit();
			
			unset($HistoryType[$iHorse][$iHistory], $scrap);
			foreach($HistoryDatum->evaluate(".//div[@class='leftColBig']/h3[@class='clearfix']/text()[2]") as $scrap) {
				$HistoryType[$iHorse][$iHistory] = FixSpaces($scrap->nodeValue);
				$HistoryType[$iHorse][$iHistory] = EquSearch($HistoryType[$iHorse][$iHistory], $Equ["cType"], true);
				if(!$HistoryType[$iHorse][$iHistory]) $HistoryType[$iHorse][$iHistory] = "f";
			}
			//print("<pre>"); var_dump($HistoryType[$iHorse]); print("</pre>"); exit();
			
			unset($HistoryClass[$iHorse][$iHistory], $scrap);
			foreach($HistoryDatum->evaluate(".//div[@class='leftColBig']/h3[@class='clearfix']/text()[2]") as $scrap) {
				$HistoryClass[$iHorse][$iHistory] = FixSpaces($scrap->nodeValue);
				$HistoryClass[$iHorse][$iHistory] = EquSearch($HistoryClass[$iHorse][$iHistory], array($EquPreg["cClass"],$Equ["cClass"]), true);
			}
			if(!$HistoryClass[$iHorse][$iHistory] || $HistoryClass[$iHorse][$iHistory] == "Αξ" || $HistoryClass[$iHorse][$iHistory] == "Μδ") {
				unset($HistoryClassSecondary[$iHorse][$iHistory], $scrap);
				foreach($HistoryDatum->evaluate(".//div[@class='leftColBig']/ul/li[1]") as $scrap) {
					$HistoryClassSecondary[$iHorse][$iHistory] = FixSpaces($scrap->nodeValue);
					$HistoryClassSecondary[$iHorse][$iHistory] = preg_filter("'.*?[(]Class\s+(\d+)[)].*'uis", "$01", $HistoryClassSecondary[$iHorse][$iHistory]);
					if($HistoryClassSecondary[$iHorse][$iHistory]) {
						$HistoryClass[$iHorse][$iHistory] .= ($HistoryClass[$iHorse][$iHistory] ? "/" : "").$HistoryClassSecondary[$iHorse][$iHistory];
					}
				}
			}
			//print("<pre>"); var_dump($HistoryClass[$iHorse]); print("</pre>"); exit();
			
			unset($HistoryRange[$iHorse][$iHistory], $HistoryRangeHasParenthesis[$iHorse][$iHistory], $HistoryRangeValue[$iHorse][$iHistory], $scrap);
			foreach($HistoryDatum->evaluate(".//div[@class='leftColBig']/ul/li[1]") as $scrap) {
				$HistoryRange[$iHorse][$iHistory] = FixSpaces($scrap->nodeValue);
				$HistoryRange[$iHorse][$iHistory] = EquSearch($HistoryRange[$iHorse][$iHistory], $Equ["cDist"]);
				$HistoryRange[$iHorse][$iHistory] = preg_replace("'[0-9.]+yo[+]?'uis", "", $HistoryRange[$iHorse][$iHistory]);
				$HistoryRangeHasParenthesis[$iHorse][$iHistory] = preg_match("'.*?[(].*?([0-9.]+)[mfy].*?[)].*'uis", $HistoryRange[$iHorse][$iHistory]);
				if($HistoryRangeHasParenthesis[$iHorse][$iHistory]) {
					$HistoryRangeValue[$iHorse][$iHistory]["m"] = preg_filter("'.*?[(].*?([0-9.]+)m.*?[)].*'uis", "$01", $HistoryRange[$iHorse][$iHistory]);
					$HistoryRangeValue[$iHorse][$iHistory]["f"] = preg_filter("'.*?[(].*?([0-9.]+)f.*?[)].*'uis", "$01", $HistoryRange[$iHorse][$iHistory]);
					$HistoryRangeValue[$iHorse][$iHistory]["y"] = preg_filter("'.*?[(].*?([0-9.]+)y.*?[)].*'uis", "$01", $HistoryRange[$iHorse][$iHistory]);
				}
				else {
					$HistoryRangeValue[$iHorse][$iHistory]["m"] = preg_filter("'.*?([0-9.]+)m.*'uis", "$01", $HistoryRange[$iHorse][$iHistory]);
					$HistoryRangeValue[$iHorse][$iHistory]["f"] = preg_filter("'.*?([0-9.]+)f.*'uis", "$01", $HistoryRange[$iHorse][$iHistory]);
					$HistoryRangeValue[$iHorse][$iHistory]["y"] = preg_filter("'.*?([0-9.]+)y.*'uis", "$01", $HistoryRange[$iHorse][$iHistory]);
				}
				$HistoryRange[$iHorse][$iHistory] = ($HistoryRangeValue[$iHorse][$iHistory]["m"] ?: 0) * 1600 + ($HistoryRangeValue[$iHorse][$iHistory]["f"] ?: 0) * 200 + ($HistoryRangeValue[$iHorse][$iHistory]["y"] ?: 0);
				$HistoryRange[$iHorse][$iHistory] = round($HistoryRange[$iHorse][$iHistory] / 10) * 10;
				$HistoryRange[$iHorse][$iHistory] = $HistoryRange[$iHorse][$iHistory] < 2400 ? $HistoryRange[$iHorse][$iHistory] : round($HistoryRange[$iHorse][$iHistory] / 50) * 50;
			}
			//print("<pre>"); var_dump($HistoryRange[$iHorse]); print("</pre>"); exit();
			
			unset($HistoryPrize[$iHorse][$iHistory], $scrap);
			foreach($HistoryDatum->evaluate(".//div[@class='leftColBig']/ul/li[2]") as $scrap) {
				$HistoryPrize[$iHorse][$iHistory] = FixSpaces($scrap->nodeValue);
				$HistoryPrize[$iHorse][$iHistory] = EquSearch($HistoryPrize[$iHorse][$iHistory], $Equ["cPrize"]);
				$HistoryPrize[$iHorse][$iHistory] = array_sum(explode(" ", $HistoryPrize[$iHorse][$iHistory]));
				$HistoryPrize[$iHorse][$iHistory] *= $RaceMoneyParity;
				$HistoryPrize[$iHorse][$iHistory] = round($HistoryPrize[$iHorse][$iHistory] / 1000);
				$HistoryPrize[$iHorse][$iHistory] = $HistoryPrize[$iHorse][$iHistory] ? $HistoryPrize[$iHorse][$iHistory]."K" : EmptyChar();
			}
			//print("<pre>"); var_dump($HistoryPrize[$iHorse]); print("</pre>"); exit();
		}
		
		
		unset($HistoryResultsData[$iHorse]);
		$HistoryResultsData[$iHorse] = MultiLinkData($HistoryResultsLink[$iHorse]);
		
		unset($HistoryResultsDatum, $iHistory);
		foreach((array)$HistoryResultsData[$iHorse] as $iHistory => $HistoryResultsDatum) {
			//if($iHistory != 5 - 1) continue;
			
			unset($HistoryLengths[$iHorse][$iHistory], $HistoryLengthsValue[$iHorse][$iHistory], $HistoryLengthsDecimals[$iHorse][$iHistory], $scrap);
			if($HistoryIsFirst[$iHorse][$iHistory] || $HistoryRank[$iHorse][$iHistory] == 2)
				foreach($HistoryResultsDatum->evaluate("(.//*[@class='dstDesc'])[2]") as $scrap) {
					$HistoryLengths[$iHorse][$iHistory] = FixSpaces($scrap->nodeValue);
					$HistoryLengths[$iHorse][$iHistory] = EquSearch($HistoryLengths[$iHorse][$iHistory], array($Equ["Time2First"], $EquPreg["Fractions"], $Equ["Fractions"]));
				}
			else {
				foreach($HistoryResultsDatum->evaluate("(.//*[@class='dstDesc'])[position() <= count(//tbody[.//b/a=\"".$HorseName[$iHorse]."\"]/preceding-sibling::tbody) + 1]") as $scrap) {
					$HistoryLengthsValue[$iHorse][$iHistory] = FixSpaces($scrap->nodeValue);
					$HistoryLengths[$iHorse][$iHistory] += preg_replace_callback("'(?:(\d+)\s+)?(\d+)/(\d+)'uis", function($m) {return ($m[1] ?: 0) + $m[2] / $m[3];}, EquSearch($HistoryLengthsValue[$iHorse][$iHistory], array($EquPreg["Fractions"], $Equ["Fractions"])));
					$HistoryLengthsDecimals[$iHorse][$iHistory] += EquSearch(EquSearch($HistoryLengthsValue[$iHorse][$iHistory], $Equ["Time2First"], true), $Equ["_cTime2First"]);
				}
				if($HistoryLengths[$iHorse][$iHistory] != round($HistoryLengths[$iHorse][$iHistory])) {
					$HistoryLengths[$iHorse][$iHistory] = preg_replace_callback("'(\d+)([.]\d+)'uis", function($m) {$m[1] = $m[1] ? $m[1]." " : ""; return $m[1].($m[2] * 4)."/4";}, $HistoryLengths[$iHorse][$iHistory]);
					$HistoryLengths[$iHorse][$iHistory] = str_ireplace("2/4", "1/2", $HistoryLengths[$iHorse][$iHistory]);
				}
			}
			//print("<pre>"); var_dump($HistoryLengthsDecimals[$iHorse][$iHistory]); print("</pre>"); exit();
			//print("<pre>"); var_dump($HistoryLengths[$iHorse][$iHistory]); print("</pre>"); exit();
			
			unset($HistoryTime[$iHorse][$iHistory], $HistoryTimeSplit[$iHorse][$iHistory], $scrap);
			foreach($HistoryResultsDatum->evaluate(".//div[@class='raceInfo']/text()[3]") as $scrap) {
				$HistoryTime[$iHorse][$iHistory] = FixSpaces($scrap->nodeValue);
				$HistoryTime[$iHorse][$iHistory] = EquSearch($HistoryTime[$iHorse][$iHistory], $EquPreg["Parenthesis"]);
				$HistoryTimeSplit[$iHorse][$iHistory][1] = preg_filter("'(\d+)m.*'uis", "$01", $HistoryTime[$iHorse][$iHistory]);
				$HistoryTimeSplit[$iHorse][$iHistory][2] = preg_filter("'.*?\s*(\d+)[.].*'uis", "$01", $HistoryTime[$iHorse][$iHistory]);
				$HistoryTimeSplit[$iHorse][$iHistory][3] = preg_filter("'.*?[.](\d+)s'uis", "$01", $HistoryTime[$iHorse][$iHistory]);
				$HistoryTime[$iHorse][$iHistory] = ($HistoryTimeSplit[$iHorse][$iHistory][1] ?: "0").".".(str_pad($HistoryTimeSplit[$iHorse][$iHistory][2], 2, "0", STR_PAD_LEFT) ?: "00").".".(str_pad($HistoryTimeSplit[$iHorse][$iHistory][3], 2, "0", STR_PAD_LEFT) ?: "00");				
				$HistoryTime[$iHorse][$iHistory] = EquSearch($HistoryTime[$iHorse][$iHistory], $Equ["Empty"]);
				
				if(!$HistoryLengths[$iHorse][$iHistory] || $HistoryTime[$iHorse][$iHistory] == EmptyChar()) $HistoryLengths[$iHorse][$iHistory] = EmptyChar();
				if($HistoryLengths[$iHorse][$iHistory] != EmptyChar() && $HistoryType[$iHorse][$iHistory] == "f") {
					$HistoryLengthsValue[$iHorse][$iHistory] = EquSearch($HistoryLengths[$iHorse][$iHistory], $Equ["_cTime2First"]);
					$HistoryLengthsValue[$iHorse][$iHistory] = preg_replace_callback("'^(\d+)\s*(0\..+)?$'uis", function($m) {return $m[1] * 0.2 + $m[2];}, $HistoryLengthsValue[$iHorse][$iHistory]);
					$HistoryLengthsValue[$iHorse][$iHistory] += $HistoryLengthsDecimals[$iHorse][$iHistory];
					//print("<pre>"); var_dump($HistoryLengthsValue[$iHorse][$iHistory]); print("</pre>"); exit();
					$HistoryLengths[$iHorse][$iHistory] = Secs2Mins($HistoryLengthsValue[$iHorse][$iHistory] + $HistoryTimeSplit[$iHorse][$iHistory][1] * 60 + $HistoryTimeSplit[$iHorse][$iHistory][2] + $HistoryTimeSplit[$iHorse][$iHistory][3] / 100);
				}
			}
			//print("<pre>"); var_dump($HistoryTime[$iHorse][$iHistory]); print("</pre>"); exit();
			//print("<pre>"); var_dump($HistoryLengths[$iHorse][$iHistory]); print("</pre>"); exit();
			
			unset($HistoryStart[$iHorse][$iHistory], $scrap);
			foreach($HistoryResultsDatum->evaluate(".//span[@class='draw'][../..//span[@class='black']/b/a/.=\"".$HorseName[$iHorse]."\"]") as $scrap) {
				$HistoryStart[$iHorse][$iHistory] = FixSpaces($scrap->nodeValue);
			}
			//print("<pre>"); var_dump($HistoryStart[$iHorse]); print("</pre>"); exit();
		}
	}
	
	unset($HorseIsDebut, $iHorse);
	foreach(array_keys($HorseName) as $iHorse) $HorseIsDebut[$iHorse] = ($HistoryDate[$iHorse][0] == false);
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
	
	unset($iHorse);
	foreach(array_keys((array)$HorseNumber) as $iHorse) {
		$RacePrint[$iRace] .= "
			<table id='Main' class='table table-bordered' style='margin:auto;'>
				<tr>
					<th rowspan='4'><h1 title='Αύξων ίππου' data-toggle='tooltip'>".$HorseNumber[$iHorse]."</h1></th>
					<th>
						<a href='".$HorseLink[$iHorse]."' title='Φανέλα ιδιοκτήτη' data-toggle='tooltip'><img src='".$HorseIcon[$iHorse]."' /></a>
						<a href='".$HorseHistoryLink[$iHorse]."' title='Όνομα ίππου' data-toggle='tooltip'><h3 style='display:inline;'> ".strtoupper($HorseName[$iHorse])."</h3></a>
					</th>
					<th><span title='Κιλά ίππου' data-toggle='tooltip'>".$HorseWeight[$iHorse]."</span></th>
					<th><a ".(!$HorseJockeyLink[$iHorse] ?: "href='".$HorseJockeyLink[$iHorse]."'")." title='Αναβάτης' data-toggle='tooltip'>".$HorseJockey[$iHorse]."</a></th>
					<th><a ".(!$HorseOwnerLink[$iHorse] ?: "href='".$HorseOwnerLink[$iHorse]."'")." title='Ιδιοκτήτης' data-toggle='tooltip'>".$HorseOwner[$iHorse]."</a></th>
					<th rowspan='4'><span title='Σταρτ (Θέση εκκίνησης)' data-toggle='tooltip'>".$HorseStart[$iHorse]."</span></th>
				</tr>
				<tr>
					<th colspan='2'><span title='Χρώμα, φύλλο & ηλικία' data-toggle='tooltip'>".$HorseColor[$iHorse].$HorseSex[$iHorse].$HorseAge[$iHorse]."</span><span> &nbsp;</span><span title='Τελευταίες συμμετοχές' data-toggle='tooltip'>(".($HorseQue[$iHorse] ?: "Ντεμπούτο").")</span></th>
					<th><a ".(!$HorseTrainerLink[$iHorse] ?: "href='".$HorseTrainerLink[$iHorse]."'")." title='Προπονητής' data-toggle='tooltip'>".$HorseTrainer[$iHorse]."</a></th>
					<th><span title='Χρώματα ιδιοκτήτη' data-toggle='tooltip'>".$HorseOwnerColors[$iHorse]."</span></th>
				</tr>
				<tr>
					<th colspan='2'>
						<a ".(!$HorseFatherLink[$iHorse] ?: "href='".$HorseFatherLink[$iHorse]."'")." title='Πατέρας' data-toggle='tooltip'>".$HorseFather[$iHorse]."</a>
						<span> - </span>
						<a ".(!$HorseMotherLink[$iHorse] ?: "href='".$HorseMotherLink[$iHorse]."'")." title='Μητέρα' data-toggle='tooltip'>".$HorseMother[$iHorse]."</a>
					</th>
					<th>".($HorseIsDebut[$iHorse] ? "" : "<span title='Καλύτερη απόδοση (ημερομηνία)' data-toggle='tooltip'>Top rate: ".(!$HorseTopRate[$iHorse] ? "-" : $HorseTopRate[$iHorse]." (".$HorseTopDate[$iHorse].")")."</span>")."</th>
					<th><span title='Συνολικά έπαθλα' data-toggle='tooltip'>"./*$RaceMoneySymbol.*/"£"." ".($HorsePrizes[$iHorse] ?: 0)."</span></th>
				</tr>
				<tr>
					<th colspan='4'>
						<span title='Συμμετοχές, νίκες &&nbsp;πλασέ&nbsp;(2ος&nbsp;&&nbsp;3ος)' data-toggle='tooltip'><a href='".$HorseStatsLink[$iHorse]."'>Συμμ.-νίκ.-πλ.:</a> ".($HorseIsDebut[$iHorse] ? "-" : "[".$HorseRaces[$iHorse]["All"]."-".$HorseWins[$iHorse]["All"]."-".$HorsePlaces[$iHorse]["All"]."]")."</span>
		".(!$HorseRaces[$iHorse]["Track"] && !$HorseRaces[$iHorse]["Range"] ? "" : "
						<span title='Σε ιππόδρομο' data-toggle='tooltip'>&nbsp; &nbsp;Σε <a href='".$RaceLink."'>Ιππόδρ.</a> (".$HorseRaces[$iHorse]["Track"]."-".$HorseWins[$iHorse]["Track"]."-".$HorsePlaces[$iHorse]["Track"].")</span>
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
			$HorseTopRate[$iHorse],
			$HorseTopDate[$iHorse],
			"£", //$RaceMoneySymbol,
			$HorsePrizes[$iHorse] ?: 0,
			$HorseRaces[$iHorse],
			$HorseWins[$iHorse],
			$HorsePlaces[$iHorse]
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
						<th><span title='Επίσημη αξιολόγηση (Official&nbsp;Rating)' data-toggle='tooltip'>R</span></th>
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
						<td><span>".($HistoryClass[$iHorse][$iHistory] ?: EmptyChar())."</span></th>
						<td><span>".($HistoryTerrain[$iHorse][$iHistory] ?: EmptyChar())."</span></th>
						<td><span>".$HistoryPrize[$iHorse][$iHistory]."</span></td>
						<td><a ".(!$HistoryWinnerLink[$iHorse][$iHistory] ?: "href='".$HistoryWinnerLink[$iHorse][$iHistory]."'").">".$HistoryWinner[$iHorse][$iHistory]."</a></td>
						<td><span>".$HistoryTime[$iHorse][$iHistory]."</span></td>
						<td><span>".$HistoryLengths[$iHorse][$iHistory]."</span></td>
						<td><span>".($HistoryRate[$iHorse][$iHistory] ?: EmptyChar())."</span></td>
						<td><span>".$HistoryPerform[$iHorse][$iHistory]."</span></td>
					</tr>
				";
				
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