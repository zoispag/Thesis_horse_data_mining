<?php

$file["Hippo"] = $equDir."GallikesIppodromia.txt";
$fileContent["Hippo"] = iconv( "UCS-2", "UTF-8", file_get_contents($file["Hippo"]) );
//print "<textarea rows='25' cols='125'>".$fileContent["Hippo"]."</textarea>";
preg_match_all( "'([^\t]*?)(?:\t([^\t\r\n]*))?[\r\n]{1,2}'uis", $fileContent["Hippo"], $Equ["Hippo"] );
foreach( $Equ["Hippo"][1] as $tCount=>$tValue ){
	$Equ["Hippo"][CleanSpecialChars($tValue)] = str_ireplace( "*", "", $Equ["Hippo"][2][$tCount] );
}
unset( $fileContent["Hippo"], $Equ["Hippo"][0], $Equ["Hippo"][1], $Equ["Hippo"][2], $tCount, $tValue );
$Equ["Hippo"][""] = "PREG_STRi_WHOLE";
//print("<pre>"); var_dump( $Equ["Hippo"] ); print("</pre>"); exit();


$file["Terrain"] = $equDir."GallikesStoivoi.txt";
$fileContent["Terrain"] = iconv( "UCS-2", "UTF-8", file_get_contents($file["Terrain"]) );
//print "<textarea rows='25' cols='125'>".$fileContent["Terrain"]."</textarea>";
preg_match_all( "'([^\t]*?)(?:\t([^\t\r\n]*))?[\r\n]{1,2}'uis", $fileContent["Terrain"], $Equ["Terrain"] );
foreach( $Equ["Terrain"][1] as $tCount=>$tValue ){
	$Equ["Terrain"][CleanSpecialChars($tValue)] = $Equ["Terrain"][2][$tCount];
}
unset( $fileContent["Terrain"], $Equ["Terrain"][0], $Equ["Terrain"][1], $Equ["Terrain"][2], $tCount, $tValue );
$Equ["Terrain"][""] = "PREG_STRi_WHOLE";
//print("<pre>"); var_dump( $Equ["Terrain"] ); print("</pre>"); exit();


$file["Rank"] = $equDir."GallikesAfikseis.txt";
$fileContent["Rank"] = iconv( "UCS-2", "UTF-8", file_get_contents($file["Rank"]) );
//print "<textarea rows='25' cols='125'>".$fileContent["Rank"]."</textarea>";
preg_match_all( "'([^\t]*?)(?:\t([^\t\r\n]*))?[\r\n]{1,2}'uis", $fileContent["Rank"], $Equ["Rank"] );
foreach( $Equ["Rank"][1] as $tCount=>$tValue ){
	$Equ["Rank"][CleanSpecialChars($tValue)] = $Equ["Rank"][2][$tCount];
}
unset( $fileContent["Rank"], $Equ["Rank"][0], $Equ["Rank"][1], $Equ["Rank"][2], $tCount, $tValue );
$Equ["Rank"][""] = "PREG_STRi_WHOLE";
//print("<pre>"); var_dump( $Equ["Rank"] ); print("</pre>"); exit();


$file["Time2First"] = $equDir."GallikesApostaseis.txt";
$fileContent["Time2First"] = iconv( "UCS-2", "UTF-8", file_get_contents($file["Time2First"]) );
//print "<textarea rows='25' cols='125'>".$fileContent["Time2First"]."</textarea>";
preg_match_all( "'([^\t]*?)(?:\t([^\t\r\n]*))?(?:\t([^\t\r\n]*))?[\r\n]{1,2}'uis", $fileContent["Time2First"], $Equ["Time2First"] );
foreach( $Equ["Time2First"][1] as $tCount=>$tValue ){
	$Equ["Time2First"]["Number"][CleanSpecialChars($tValue)] = $Equ["Time2First"][2][$tCount];
	$Equ["Time2First"]["String"][CleanSpecialChars($tValue)] = $Equ["Time2First"][3][$tCount];
}
unset( $fileContent["Time2First"], $Equ["Time2First"][0], $Equ["Time2First"][1], $Equ["Time2First"][2], $Equ["Time2First"][3], $tCount, $tValue );
$Equ["Time2First"]["Number"][""] = "PREG_STRi_WHOLE";
$Equ["Time2First"]["String"][""] = "PREG_STRi_WHOLE";
//print("<pre>"); var_dump( $Equ["Time2First"] ); print("</pre>"); exit();


$file["OwnerColors"] = $equDir."GallikesFaneles.txt";
$fileContent["OwnerColors"] = iconv( "UCS-2", "UTF-8", file_get_contents($file["OwnerColors"]) );
//print "<textarea rows='25' cols='125'>".$fileContent["OwnerColors"]."</textarea>";
preg_match_all( "'\"?([^\t]*?)\"?(?:\t\"?([^\t\r\n]*?)\"?)?[\r\n]{1,2}'uis", $fileContent["OwnerColors"], $Equ["OwnerColors"] );
foreach( $Equ["OwnerColors"][1] as $tCount=>$tValue ){
	$Equ["OwnerColors"][CleanSpecialChars($tValue)] = $Equ["OwnerColors"][2][$tCount];
}
unset( $fileContent["OwnerColors"], $Equ["OwnerColors"][0], $Equ["OwnerColors"][1], $Equ["OwnerColors"][2], $tCount, $tValue );
$Equ["OwnerColors"][""] = "PREG_STRi_WHOLE";
//print("<pre>"); var_dump( $Equ["OwnerColors"] ); print("</pre>"); exit();


$file["Jockey"] = $equDir."GallikesAnabates.txt";
$fileContent["Jockey"] = iconv( "UCS-2", "UTF-8", file_get_contents($file["Jockey"]) );
//print "<textarea rows='25' cols='125'>".$fileContent["Jockey"]."</textarea>";
preg_match_all( "'\"?([^\t]*?)\"?(?:\t\"?([^\t\r\n]*?)\"?)?[\r\n]{1,2}'uis", $fileContent["Jockey"], $Equ["Jockey"] );
foreach( $Equ["Jockey"][1] as $tCount=>$tValue ){
	$Equ["Jockey"][CleanSpecialChars($tValue)] = $Equ["Jockey"][2][$tCount];
}
unset( $fileContent["Jockey"], $Equ["Jockey"][0], $Equ["Jockey"][1], $Equ["Jockey"][2], $tCount, $tValue );
$Equ["Jockey"][""] = "PREG_STRi_WHOLE";
//print("<pre>"); var_dump( $Equ["Jockey"] ); print("</pre>"); exit();


$file["Trainer"] = $equDir."GallikesProponites.txt";
$fileContent["Trainer"] = iconv( "UCS-2", "UTF-8", file_get_contents($file["Trainer"]) );
//print "<textarea rows='25' cols='125'>".$fileContent["Trainer"]."</textarea>";
preg_match_all( "'\"?([^\t]*?)\"?(?:\t\"?([^\t\r\n]*?)\"?)?[\r\n]{1,2}'uis", $fileContent["Trainer"], $Equ["Trainer"] );
foreach( $Equ["Trainer"][1] as $tCount=>$tValue ){
	$Equ["Trainer"][CleanSpecialChars($tValue)] = $Equ["Trainer"][2][$tCount];
}
unset( $fileContent["Trainer"], $Equ["Trainer"][0], $Equ["Trainer"][1], $Equ["Trainer"][2], $tCount, $tValue );
$Equ["Trainer"][""] = "PREG_STRi_WHOLE";
//print("<pre>"); var_dump( $Equ["Trainer"] ); print("</pre>"); exit();




$Equ["Age"] = array(
	"zéro" => "0", // Μηδέν
	"un" => "1", // Ένα
	"deux" => "2", // Δύο
	"trois" => "3", // Τρία
	"quatre" => "4", // Τέσσερα
	"cinq" => "5", // Πέντε
	"six" => "6", // Έξι
	"sept" => "7", // Επτά
	"huit" => "8", // Οκτώ
	"neuf" => "9", // Εννιά
	"dix" => "10", // Δέκα
	"onze" => "11", // Έντεκα
	"douze" => "12", // Δώδεκα
	"treize" => "13", // Δεκατρία
	"quatorze" => "14", // Δεκατέσσερα
	"quinze" => "15", // Δεκαπέντε
	" et au-dessus" => "+", // Συν
	" et plus" => "+",
	" à " => "-", // Παύλα
	" et " => " & ", // Και
);
$Equ["Age"][""] = "STRi";
//print("<pre>"); var_dump($Equ["Age"]); print("</pre>"); exit();

$EquPreg["Age"] = array(
	".+?\s+(\d+,\s)?(\d+[-& ]{1,3})?(\d+)\s+ans([+])?.*" => "$01$02$03$04", // Καθάρισμα
);
$EquPreg["Age"][""] = "PREG_REGEXi_REPLACE";
//print("<pre>"); var_dump( $EquPreg["Age"] ); print("</pre>"); exit();


$Equ["Type"] = array(
	"Plat" => "Επίπεδη", // Επίπεδη
	"Haies" => "Εμποδίων", // Εμποδίων
	"Steeple-chase" => "Φυσικών εμποδίων", // Φυσικών εμποδίων
	"Steeple" => "Φυσικών εμποδίων",
	"Attelé" => "Άμαξίδια", // Άμαξίδια
	"Monté" => "Έφιπποι", // Έφιπποι
	"Cross-country" => "Ανώμαλου δρόμου", // Ανώμαλου δρόμου
	"Crosscountry" => "Ανώμαλου δρόμου",
);
$Equ["Type"][""] = "PREG_STRi_REPLACE";
//print("<pre>"); var_dump($Equ["Type"]); print("</pre>"); exit();


$Equ["Class"] = array(
	"Listed Race" => "L", // Listed
	"Groupe III" => "GR 3", // Group
	"Groupe II" => "GR 2",
	"Groupe I" => "GR 1",
	"A réclamer" => "Αξ", // Αξίωσης ;
	"Handicap" => "Ηd", // Handicap
);
$Equ["Class"][""] = "PREG_STRi_REPLACE";
//print("<pre>"); var_dump($Equ["Class"]); print("</pre>"); exit();

$EquPreg["Class"] = array(
	"Course\s+(.)\s+" => "$01", // Class
);
$EquPreg["Class"][""] = "PREG_REGEXi_REPLACE";
//print("<pre>"); var_dump( $EquPreg["Class"] ); print("</pre>"); exit();


$Equ["Petal"] = array(
	"D4" => "4", // Τέσσερα Πέταλα (Μπρος-Πίσω)
	"DA" => "2ε", // Δύο Πέταλα Μπροστά
	"DP" => "2π", // Δύο Πέταλα Πίσω
);
$Equ["Petal"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["Petal"] ); print("</pre>"); exit();


$EquPreg["NonDigit"] = array(
	"\D*" => "", // Μη-Αριθμοί
);
$EquPreg["NonDigit"][""] = "PREG_REGEXi";
//print("<pre>"); var_dump( $EquPreg["NonDigit"] ); print("</pre>"); exit();


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


$Equ["DecimalComma"] = array(
	"." => ",", // Τελεία σε Κόμμα
);
$Equ["DecimalComma"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["DecimalComma"] ); print("</pre>"); exit();


$Equ["Parenthesis"] = array(
	"(" => "", // Παρενθέσεις
	")" => "",
);
$Equ["Parenthesis"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["Parenthesis"] ); print("</pre>"); exit();


$Equ["Time"] = array(
	"''" => ".", // Μονό-Αυτάκι σε Τελεία
	"'" => ".",
);
$Equ["Time"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["Time"] ); print("</pre>"); exit();


$Equ["Money"] = array(
	" €" => "", // Σύμβολο Νομίσματος
	"€" => "",
	" GBP" => "",
	"GBP" => "",
	" KR" => "",
	"KR" => "",
	" " => "", // Κενά
);
$Equ["Money"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["Money"] ); print("</pre>"); exit();




$Equ["hPetal"] = $Equ["Petal"];
//print("<pre>"); var_dump( $Equ["hPetal"] ); print("</pre>"); exit();


$Equ["hSex"] = array(
	"F" => "φ", // Θηλυκό
	"M" => "κ", // Αρσενικό
	"H" => "εκτ.", // Ευνουχισμένο (Άουτς..)
);
$Equ["hSex"] = array_merge( $Equ["hSex"], $Equ["Digit"] );
//print("<pre>"); var_dump( $Equ["hSex"] ); print("</pre>"); exit();


$EquPreg["hAge"] = $EquPreg["NonDigit"];
//print("<pre>"); var_dump( $EquPreg["hAge"] ); print("</pre>"); exit();


$Equ["hJockey"] = array(
	"Non-partant" => "ΔΙΕΓΡΑΦΗ", // Διαγράφηκε
);
$Equ["hJockey"][""] = "PREG_STRi_REPLACE";
//print("<pre>"); var_dump( $Equ["hJockey"] ); print("</pre>"); exit();


$Equ["hQue"] = array(
	"D" => "Ακ", // Ακυρώθηκε
	"A" => "Στ", // Σταμάτησε
	"T" => "Αν", // Ανατράπηκε
	"R" => "R", // ;
);
$Equ["hQue"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["hQue"] ); print("</pre>"); exit();

$EquPreg["hQue"] = array(
	"[(].*?[)]" => "-", // Παρενθέσεις σε Παύλες
	"^-" => "", // Τελευταία Παύλα
	"[a-z]" => "", // Πεζά γράμματα
	"(.)(?=.)" => "$01,", // Κόμμα σε όλα τα γράμματα (εκτώς τελευταίου)
);
$EquPreg["hQue"][""] = "PREG_REGEX";
//print("<pre>"); var_dump( $EquPreg["hQue"] ); print("</pre>"); exit();


$Equ["hMoney"] = $Equ["Money"];
//print("<pre>"); var_dump( $Equ["hMoney"] ); print("</pre>"); exit();


$Equ["cHippo"] = $Equ["Hippo"];
//print("<pre>"); var_dump( $Equ["cHippo"] ); print("</pre>"); exit();


$Equ["cType"] = array(
	"Plat" => "f", // Απλή
	"Haies" => "h", // Εμπόδια
	"Steeple-chase" => "s", // Κυνήγι
	"Steeple" => "s",
	"Attelé" => "Αμ.", // Άμμος ;
	"Monté" => "Εφ.", // Αμαξίδια
	"Cross-country" => "c", // ;
	"Crosscountry" => "c",
);
$Equ["cType"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["cType"] ); print("</pre>"); exit();


$Equ["cTerrain"] = $Equ["Terrain"];
//print("<pre>"); var_dump( $Equ["cTerrain"] ); print("</pre>"); exit();


$Equ["cPrize"] = $Equ["Money"];
//print("<pre>"); var_dump( $Equ["cPrize"] ); print("</pre>"); exit();


$Equ["cRank"] = array(
	"0" => "ΕΑ", // Ελεεινός & Άσχετος :P ;
);
$Equ["cRank"] = array_merge( $Equ["cRank"], $Equ["Rank"] );
//print("<pre>"); var_dump( $Equ["cRank"] ); print("</pre>"); exit();

$Equ["_cRankIsDigit"] = array_combine(
	array_keys( $Equ["Digit"] ),
	array_fill( 0, count($Equ["Digit"]), "1" )
);
$Equ["_cRankIsDigit"][""] = "PREG_STRi_REPLACE";
//print("<pre>"); var_dump( $Equ["_cRankIsDigit"] ); print("</pre>"); exit();


$Equ["cPetal"] = $Equ["Petal"];
//print("<pre>"); var_dump( $Equ["cPetal"] ); print("</pre>"); exit();


$Equ["cClass"] = $Equ["Class"];
//print("<pre>"); var_dump( $Equ["cClass"] ); print("</pre>"); exit();

$EquPreg["cClass"] = $EquPreg["Class"];
//print("<pre>"); var_dump( $EquPreg["cClass"] ); print("</pre>"); exit();


$Equ["cTime"] = $Equ["Time"];
//print("<pre>"); var_dump( $Equ["cTime"] ); print("</pre>"); exit();


$Equ["cStart"] = $Equ["Parenthesis"];
//print("<pre>"); var_dump( $Equ["cStart"] ); print("</pre>"); exit();


$Equ["cPerform"] = $Equ["DecimalComma"];
//print("<pre>"); var_dump( $Equ["cPerform"] ); print("</pre>"); exit();


$Equ["cTime2First"] = $Equ["Time"];
//print("<pre>"); var_dump( $Equ["cTime2First"] ); print("</pre>"); exit();

$Equ["cTime2First_Zero"] = array_filter( $Equ["Time2First"]["Number"], function($var){return !$var;} );
$Equ["cTime2First_Zero"][""] = "PREG_STRi_WHOLE";
//print("<pre>"); var_dump( $Equ["cTime2First_Zero"] ); print("</pre>"); exit();

$Equ["cTime2First_Number"] = $Equ["Time2First"]["Number"];
//print("<pre>"); var_dump( $Equ["cTime2First_Number"] ); print("</pre>"); exit();

$Equ["cTime2First_String"] = $Equ["Time2First"]["String"];
//print("<pre>"); var_dump( $Equ["cTime2First_String"] ); print("</pre>"); exit();


$Equ["_cTime2First"] = array(
	"Τ. α" => "0.00", // D/H
	"Τ. Α" => "0.00", // TNC
	"β.κεφ." => "0.01", // CNEZ
	"Β.κεφ." => "0.02", // NEZ
	"Β.Κεφ." => "0.03", // CTETE
	"Κεφ." => "0.04", // TETE
	"τραχ." => "0.05", // CENC
	"Τραχ." => "0.06", // ENC
	"Μακρ." => "4.00", // LOIN
	"1/4" => "0.07", // 1/4
	"1/2" => "0.10", // 1/2
	"3/4" => "0.15", // 3/4
);
$Equ["_cTime2First"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["_cTime2First"] ); print("</pre>"); exit();

?>