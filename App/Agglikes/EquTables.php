<?php

$file["Hippo"] = $equDir."AgglikesIppodromia.txt";
$fileContent["Hippo"] = iconv( "UCS-2", "UTF-8", file_get_contents($file["Hippo"]) );
//print "<textarea rows='25' cols='125'>".$fileContent["Hippo"]."</textarea>";
preg_match_all( "'([^\t]*?)(?:\t([^\t\r\n]*))?[\r\n]{1,2}'uis", $fileContent["Hippo"], $Equ["Hippo"] );
foreach( $Equ["Hippo"][1] as $tCount=>$tValue ){
	$Equ["Hippo"][CleanSpecialChars($tValue)] = preg_replace( "'[*]'uis", "", $Equ["Hippo"][2][$tCount] );
}
unset( $fileContent["Hippo"], $Equ["Hippo"][0], $Equ["Hippo"][1], $Equ["Hippo"][2], $tCount, $tValue );
$Equ["Hippo"][""] = "PREG_STRi_WHOLE";
//print("<pre>"); var_dump( $Equ["Hippo"] ); print("</pre>"); exit();


$file["Time2First"] = $equDir."AgglikesAfikseis.txt";
$fileContent["Time2First"] = iconv( "UCS-2", "UTF-8", file_get_contents($file["Time2First"]) );
//print "<textarea rows='25' cols='125'>".$fileContent["Time2First"]."</textarea>";
preg_match_all( "'([^\t]*?)(?:\t([^\t\r\n]*))?[\r\n]{1,2}'uis", $fileContent["Time2First"], $Equ["Time2First"] );
foreach( $Equ["Time2First"][1] as $tCount=>$tValue ){
	$Equ["Time2First"][$tValue] = $Equ["Time2First"][2][$tCount];
}
unset( $fileContent["Time2First"], $Equ["Time2First"][0], $Equ["Time2First"][1], $Equ["Time2First"][2], $tCount, $tValue );
$Equ["Time2First"][""] = "PREG_STRi_WHOLE";
//print("<pre>"); var_dump( $Equ["Time2First"] ); print("</pre>"); exit();


$file["OwnerColors"] = $equDir."AgglikesFaneles.txt";
$fileContent["OwnerColors"] = iconv( "UCS-2", "UTF-8", file_get_contents($file["OwnerColors"]) );
//print "<textarea rows='25' cols='125'>".$fileContent["OwnerColors"]."</textarea>";
preg_match_all( "'\"?([^\t]*?)\"?(?:\t\"?([^\t\r\n]*?)\"?)?[\r\n]{1,2}'uis", $fileContent["OwnerColors"], $Equ["OwnerColors"] );
foreach( $Equ["OwnerColors"][1] as $tCount=>$tValue ){
	$Equ["OwnerColors"][CleanSpecialChars($tValue)] = $Equ["OwnerColors"][2][$tCount];
}
unset( $fileContent["OwnerColors"], $Equ["OwnerColors"][0], $Equ["OwnerColors"][1], $Equ["OwnerColors"][2], $tCount, $tValue );
$Equ["OwnerColors"][""] = "PREG_STRi_WHOLE";
//print("<pre>"); var_dump( $Equ["OwnerColors"] ); print("</pre>"); exit();


$file["Jockey"] = $equDir."AgglikesAnabates.txt";
$fileContent["Jockey"] = iconv( "UCS-2", "UTF-8", file_get_contents($file["Jockey"]) );
//print "<textarea rows='25' cols='125'>".$fileContent["Jockey"]."</textarea>";
preg_match_all( "'\"?([^\t]*?)\"?(?:\t\"?([^\t\r\n]*?)\"?)?[\r\n]{1,2}'uis", $fileContent["Jockey"], $Equ["Jockey"] );
foreach( $Equ["Jockey"][1] as $tCount=>$tValue ){
	$Equ["Jockey"][CleanSpecialChars($tValue)] = $Equ["Jockey"][2][$tCount];
}
unset( $fileContent["Jockey"], $Equ["Jockey"][0], $Equ["Jockey"][1], $Equ["Jockey"][2], $tCount, $tValue );
$Equ["Jockey"][""] = "PREG_STRi_WHOLE";
//print("<pre>"); var_dump( $Equ["Jockey"] ); print("</pre>"); exit();


$file["Trainer"] = $equDir."AgglikesProponites.txt";
$fileContent["Trainer"] = iconv( "UCS-2", "UTF-8", file_get_contents($file["Trainer"]) );
//print "<textarea rows='25' cols='125'>".$fileContent["Trainer"]."</textarea>";
preg_match_all( "'\"?([^\t]*?)\"?(?:\t\"?([^\t\r\n]*?)\"?)?[\r\n]{1,2}'uis", $fileContent["Trainer"], $Equ["Trainer"] );
foreach( $Equ["Trainer"][1] as $tCount=>$tValue ){
	$Equ["Trainer"][CleanSpecialChars($tValue)] = $Equ["Trainer"][2][$tCount];
}
unset( $fileContent["Trainer"], $Equ["Trainer"][0], $Equ["Trainer"][1], $Equ["Trainer"][2], $tCount, $tValue );
$Equ["Trainer"][""] = "PREG_STRi_WHOLE";
//print("<pre>"); var_dump( $Equ["Trainer"] ); print("</pre>"); exit();




$Equ["Fractions"] = array(
	"½" => "1/2", // 1/2
	"¼" => "1/4", // 1/4
	"¾" => "3/4", // 3/4
);
$Equ["Fractions"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["Fractions"] ); print("</pre>"); exit();

$EquPreg["Fractions"] = array(
	"(\d+)½" => "$01 1/2", // Αριθμός & 1/2
	"(\d+)¼" => "$01 1/4", // Αριθμός & 1/4
	"(\d+)¾" => "$01 3/4", // Αριθμός & 3/4
);
$EquPreg["Fractions"][""] = "PREG_REGEXi";
//print("<pre>"); var_dump( $EquPreg["Fractions"] ); print("</pre>"); exit();


$Equ["Parenthesis"] = array(
	"(" => "", // Παρενθέσεις
	")" => "",
);
$Equ["Parenthesis"][""] = "STRi";
//print("<pre>"); var_dump( $EquPreg["Parenthesis"] ); print("</pre>"); exit();

$EquPreg["Parenthesis"] = array(
	"\s+[(].*[)]" => "", // Παρενθέσεις
);
$EquPreg["Parenthesis"][""] = "PREG_REGEXi";
//print("<pre>"); var_dump( $EquPreg["Parenthesis"] ); print("</pre>"); exit();


$Equ["Digit"] = array(
	"0" => "", // Αριθμοί
	"1" => "",
	"2" => "",
	"3" => "",
	"4" => "",
	"5" => "",
	"6" => "",
	"7" => "",
	"8" => "",
	"9" => "",
);
$Equ["Digit"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["Digit"] ); print("</pre>"); exit();


$Equ["Name"] = array(
	"´" => "'", // Απόστροφος
);
$Equ["Name"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["Name"] ); print("</pre>"); exit();


$Equ["Money"] = array(
	"£" => "", // Σύμβολο Νομίσματος
	"," => "", // Κόμμα
);
$Equ["Money"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["Money"] ); print("</pre>"); exit();


$Equ["Empty"] = array(
	"—" => EmptyChar(), // Κενό
	"0.00.00" => EmptyChar(),
);
$Equ["Empty"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["Empty"] ); print("</pre>"); exit();




$Equ["Type"] = array(
	"Hurdle" => "Εμποδίων", // Εμποδίων
	"Chase" => "Φυσικών εμποδίων", // Φυσικών εμποδίων
	//"H Flat Race" => "Επίπεδη κυνήγι", // Επίπεδη κυνήγι ;
	//"Hunt Flat Race" => "Επίπεδη κυνήγι",
);
$Equ["Type"][""] = "PREG_STRi_REPLACE";
//print("<pre>"); var_dump($Equ["Type"]); print("</pre>"); exit();


$Equ["Class"] = array(
	"(Listed Race)" => "L", // Listed
	//"Handicap" => "H", // Handicap
	"Maiden" => "Μδ", // Μαίδεν
	"Claiming" => "Αξ", // Αξίωσης
	"Selling" => "Αξ",
);
$Equ["Class"][""] = "PREG_STRi_REPLACE";
//print("<pre>"); var_dump( $Equ["Class"] ); print("</pre>"); exit();

$EquPreg["Class"] = array(
	"[(](?:Grade|Group)\s+(\d+)[)]" => "G$01", // Group
);
$EquPreg["Class"][""] = "PREG_REGEXi_REPLACE";
//print("<pre>"); var_dump( $EquPreg["Class"] ); print("</pre>"); exit();


$Equ["TopRateType"] = array(
	".*H$" => "μποδίων", // Hurdle
	".*Ch$" => "μποδίων", // Chase
	//".*HF$" => "Επίπεδη κυνήγι", // Hunt Flat
);
$Equ["TopRateType"][""] = "PREG_REGEX";
//print("<pre>"); var_dump($Equ["TopRateType"]); print("</pre>"); exit();

$EquPreg["TopRateType"] = array(
	"(.+?)\s+.+" => "$01", // Αφαίρεση επάθλου
);
$EquPreg["TopRateType"][""] = "PREG_REGEX";
//print("<pre>"); var_dump($EquPreg["TopRateType"]); print("</pre>"); exit();



$Equ["hName"] = $Equ["Name"];
//print("<pre>"); var_dump( $Equ["hName"] ); print("</pre>"); exit();


$EquPreg["hStatsUrls"] = array(
	"(horse_id=\d+)" => "http://www.racingpost.com/horses/horse_key_stats.sd?$01", // hUrls σε hStatsUrls
);
$EquPreg["hStatsUrls"][""] = "PREG_REGEXi_REPLACE";
//print("<pre>"); var_dump( $EquPreg["hStatsUrls"] ); print("</pre>"); exit();


$EquPreg["hHistoryUrls"] = array(
	"(horse_id=\d+)" => "http://www.racingpost.com/horses/horse_form.sd?$01", // hUrls σε hHistoryUrls
);
$EquPreg["hHistoryUrls"][""] = "PREG_REGEXi_REPLACE";
//print("<pre>"); var_dump( $EquPreg["hHistoryUrls"] ); print("</pre>"); exit();


$Equ["hDistRank"] = array(
	"http://ui.racingpost.com/ico/distance-c.gif" => "[Στίβ.]", // Στίβος
	"http://ui.racingpost.com/ico/distance-d.gif" => "[Απόστ.]", // Απόσταση
	"http://ui.racingpost.com/ico/distance-cd.gif" => "[Στίβ./Απόστ.]", // Στίβος & Απόσταση
);
$Equ["hDistRank"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["hDistRank"] ); print("</pre>"); exit();


$Equ["hORating"] = $Equ["Empty"];
//print("<pre>"); var_dump( $Equ["hORating"] ); print("</pre>"); exit();


$Equ["hJockey"] = array(
	"DOUBTFUL" => "ΔΙΕΓΡΑΦH", // Διαγράφηκε
);
$Equ["hJockey"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["hJockey"] ); print("</pre>"); exit();


$Equ["hColour"] = array(
	"bay" => "ο", // Καφέ (Ορφνό)
	"brown" => "ο", // Καφέ (Ορφνό)
	"bay or brown" => "ο", // Καφέ (Ορφνό)
	"grey" => "ψ", // Γκρί (Ψαρί/Φαιό)
	"roan" => "ψ", // Γκρί (Ψαρί/Φαιό)
	"grey or roan" => "ψ", // Γκρί (Ψαρί/Φαιό)
	"chestnut" => "ξ", // Κίτρινο (Ξανθό)
	"black" => "μ", // Μαύρο
);
$Equ["hColour"][""] = "PREG_STRi_WHOLE";
//print("<pre>"); var_dump( $Equ["hColour"] ); print("</pre>"); exit();


$Equ["hSex"] = array(
	"colt" => "κ", // Αρσενικό
	"horse" => "κ",
	"filly" => "φ", // Θηλυκό
	"mare" => "φ",
	"gelding" => "εκτ.", // Ευνούχισμένο ( Κλάψ :P )
);
$Equ["hSex"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["hSex"] ); print("</pre>"); exit();


$Equ["hFather"] = $Equ["Name"];
//print("<pre>"); var_dump( $Equ["hFather"] ); print("</pre>"); exit();

$EquPreg["hFather"] = $EquPreg["Parenthesis"];
//print("<pre>"); var_dump( $EquPreg["hFather"] ); print("</pre>"); exit();


$Equ["hMother"] = $Equ["Name"];
//print("<pre>"); var_dump( $Equ["hMother"] ); print("</pre>"); exit();

$EquPreg["hMother"] = $EquPreg["Parenthesis"];
//print("<pre>"); var_dump( $EquPreg["hMother"] ); print("</pre>"); exit();


$Equ["hGrandFather"] = array_merge( $Equ["Name"], $Equ["Parenthesis"] );
//print("<pre>"); var_dump( $Equ["hGrandFather"] ); print("</pre>"); exit();

$EquPreg["hGrandFather"] = $EquPreg["Parenthesis"];
//print("<pre>"); var_dump( $EquPreg["hGrandFather"] ); print("</pre>"); exit();


$Equ["cRank"] = array(
	"DNF" => "Στ", // Σταμάτησε
	"CO" => "Στ",
	"PU" => "Στ",
	"RO" => "Στ",
	"U" => "Αν", // Ανατράπηκε
	"UR" => "Αν",
	"SU" => "Αν",
	"F" => "Αν",
	"BD" => "Αν",
	"R" => "Δ", // Διαγράφηκε ;
	"RR" => "Δ",
	"RTR" => "Δ",
	"REF" => "Δ",
	"LFT" => "Δ",
);
$Equ["cRank"][""] = "PREG_STRi_WHOLE";
//print("<pre>"); var_dump( $Equ["cRank"] ); print("</pre>"); exit();

$EquPreg["cRank"] = array(
	"(\d+)d" => "Ακ$01", // Αρκυρώθηκε ;
);
$EquPreg["cRank"][""] = "PREG_REGEXi";
//print("<pre>"); var_dump( $EquPreg["cRank"] ); print("</pre>"); exit();


$EquPreg["cResultsUrls"] = array(
	"(race_id=\d+)" => "http://www.racingpost.com/horses/result_race.sd?$01", // cUrls σε cResultsUrls
);
$EquPreg["cResultsUrls"][""] = "PREG_REGEXi_REPLACE";
//print("<pre>"); var_dump( $EquPreg["cResultsUrls"] ); print("</pre>"); exit();


$Equ["cTerrain"] = $Equ["Digit"];
$Equ["cTerrain"] += array(
	"." => "", // Τελεία
	"St/Slw" => "AW", // Standard σε All Weather
	"St" => "AW",
);
//print("<pre>"); var_dump( $Equ["cTerrain"] ); print("</pre>"); exit();


$Equ["cParts"] = array(
	"/" => "", // Κάθετως
);
$Equ["cParts"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["cParts"] ); print("</pre>"); exit();


$Equ["cPerform"] = $Equ["Empty"];
//print("<pre>"); var_dump( $Equ["cPerform"] ); print("</pre>"); exit();

$EquPreg["cPerform"] = array(
	"Even" => "2", // Even (2/1)
);
$EquPreg["cPerform"][""] = "PREG_REGEXi_REPLACE";
//print("<pre>"); var_dump( $EquPreg["cPerform"] ); print("</pre>"); exit();


$Equ["cORating"] = $Equ["Empty"];
//print("<pre>"); var_dump( $Equ["cORating"] ); print("</pre>"); exit();


/*$Equ["hQue"] = array(
	"C" => "Στ", // Σταμάτησε
	"P" => "Στ",
	"O" => "Στ",
	"U" => "Αν", // Ανατράπηκε
	"F" => "Αν",
	"B" => "Αν",
	"S" => "Αν",
	"L" => "Δ", // Διαγράφηκε ;
	"R" => "Δ",
);
$Equ["hQue"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["hQue"] ); print("</pre>"); exit();

$EquPreg["hQue"] = array(
	"(\d),d" => "Ακ$01", // Ακυρώθηκε ;
);
$EquPreg["hQue"][""] = "PREG_REGEXi";
*///print("<pre>"); var_dump( $EquPreg["hQue"] ); print("</pre>"); exit();


$Equ["hMoney"] = $Equ["Money"];
//print("<pre>"); var_dump( $Equ["hMoney"] ); print("</pre>"); exit();


$Equ["cHippo"] = $Equ["Hippo"];
//print("<pre>"); var_dump( $Equ["cHippo"] ); print("</pre>"); exit();


$Equ["cType"] = array(
	"Hurdle" => "h", // Εμποδίων
	"Chase" => "s", // Φυσικών εμποδίων
	"H Flat Race" => "hf", // Επίπεδη Κυνήγι
	"Hunt Flat Race" => "hf",
);
$Equ["cType"][""] = "PREG_STRi_REPLACE";
//print("<pre>"); var_dump( $Equ["cType"] ); print("</pre>"); exit();


$Equ["cClass"] = $Equ["Class"];
//print("<pre>"); var_dump( $Equ["cClass"] ); print("</pre>"); exit();

$EquPreg["cClass"] = $EquPreg["Class"];
//print("<pre>"); var_dump( $EquPreg["cClass"] ); print("</pre>"); exit();


$Equ["cDist"] = array_combine(
	array_keys( $Equ["Fractions"] ),
	array( ".5", ".25", ".75", "" )
);
$Equ["cDist"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["cDist"] ); print("</pre>"); exit();


$Equ["cPrize"] = $Equ["Money"];
//print("<pre>"); var_dump( $Equ["cPrize"] ); print("</pre>"); exit();


$Equ["_cTime2First"] = array(
	"β.κεφ." => "0.01", // nse
	"Β.κεφ." => "0.02", // shd
	"κεφ." => "0.03", // hd
	"Κεφ." => "0.04", // snk
	"τραχ." => "0.05", // nk
	"1/4" => "0.07", // 1/4
	"1/2" => "0.10", // 1/2
	"3/4" => "0.15", // 3/4
);
$Equ["_cTime2First"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["_cTime2First"] ); print("</pre>"); exit();

?>