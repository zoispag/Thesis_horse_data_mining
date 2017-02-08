<?php

$file["OwnerColors"] = $equDir."AfrikisFaneles.txt";
$fileContent["OwnerColors"] = iconv( "UCS-2", "UTF-8", file_get_contents($file["OwnerColors"]) );
//print "<textarea rows='25' cols='125'>".$fileContent["OwnerColors"]."</textarea>";
preg_match_all( "'\"?([^\t]*?)\"?(?:\t\"?([^\t\r\n]*?)\"?)?[\r\n]{1,2}'uis", $fileContent["OwnerColors"], $Equ["OwnerColors"] );
foreach( $Equ["OwnerColors"][1] as $tCount=>$tValue ){
	$Equ["OwnerColors"][CleanSpecialChars($tValue)] = $Equ["OwnerColors"][2][$tCount];
}
unset( $fileContent["OwnerColors"], $Equ["OwnerColors"][0], $Equ["OwnerColors"][1], $Equ["OwnerColors"][2], $tCount, $tValue );
$Equ["OwnerColors"][""] = "PREG_STRi_WHOLE";
//print("<pre>"); var_dump( $Equ["OwnerColors"] ); print("</pre>"); exit();


$file["Jockey"] = $equDir."AfrikisAnabates.txt";
$fileContent["Jockey"] = iconv( "UCS-2", "UTF-8", file_get_contents($file["Jockey"]) );
//print "<textarea rows='25' cols='125'>".$fileContent["Jockey"]."</textarea>";
preg_match_all( "'\"?([^\t]*?)\"?(?:\t\"?([^\t\r\n]*?)\"?)?[\r\n]{1,2}'uis", $fileContent["Jockey"], $Equ["Jockey"] );
foreach( $Equ["Jockey"][1] as $tCount=>$tValue ){
	$Equ["Jockey"][CleanSpecialChars($tValue)] = $Equ["Jockey"][2][$tCount];
}
unset( $fileContent["Jockey"], $Equ["Jockey"][0], $Equ["Jockey"][1], $Equ["Jockey"][2], $tCount, $tValue );
$Equ["Jockey"][""] = "PREG_STRi_WHOLE";
//print("<pre>"); var_dump( $Equ["Jockey"] ); print("</pre>"); exit();


$file["Trainer"] = $equDir."AfrikisProponites.txt";
$fileContent["Trainer"] = iconv( "UCS-2", "UTF-8", file_get_contents($file["Trainer"]) );
//print "<textarea rows='25' cols='125'>".$fileContent["Trainer"]."</textarea>";
preg_match_all( "'\"?([^\t]*?)\"?(?:\t\"?([^\t\r\n]*?)\"?)?[\r\n]{1,2}'uis", $fileContent["Trainer"], $Equ["Trainer"] );
foreach( $Equ["Trainer"][1] as $tCount=>$tValue ){
	$Equ["Trainer"][CleanSpecialChars($tValue)] = $Equ["Trainer"][2][$tCount];
}
unset( $fileContent["Trainer"], $Equ["Trainer"][0], $Equ["Trainer"][1], $Equ["Trainer"][2], $tCount, $tValue );
$Equ["Trainer"][""] = "PREG_STRi_WHOLE";
//print("<pre>"); var_dump( $Equ["Trainer"] ); print("</pre>"); exit();




$EquPreg["OnlyDigits"] = array(
	"\D*" => "", // Μη-Αριθμοί
);
$EquPreg["OnlyDigits"][""] = "PREG_REGEXi";
//print("<pre>"); var_dump($EquPreg["OnlyDigits"]); print("</pre>"); exit;


$EquPreg["DigitPad"] = array(
	"^\d$" => "0$00", // Μηδέν μπροστά σε Μονοψήφιο Αριθμό
);
$EquPreg["DigitPad"][""] = "PREG_REGEXi";
//print("<pre>"); var_dump($EquPreg["DigitPad"]); print("</pre>"); exit;


$EquPreg["DigitUnpad"] = array(
	"^0" => "", // Αφαίρεση Μηδέν μπροστά σε Μονοψήφιο Αριθμό
);
$EquPreg["DigitUnpad"][""] = "PREG_REGEXi";
//print("<pre>"); var_dump($EquPreg["DigitUnpad"]); print("</pre>"); exit;


$EquPreg["Brackets"] = array(
	"\s+[(].*[)]" => "", // Παρενθέσεις
);
$EquPreg["Brackets"][""] = "PREG_REGEXi";
//print("<pre>"); var_dump($EquPreg["Brackets"]); print("</pre>"); exit;


$Equ["Empty"] = array(
	"..............." => EmptyChar(), // Κένο
	"N.T.T." => EmptyChar(),
	"00.00" => EmptyChar(),
);
$Equ["Empty"][""] = "STRi";
//print("<pre>"); var_dump($Equ["Empty"]); print("</pre>"); exit;




$Equ["Type"] = array(
	"0" => "Επίπεδη", // Επίπεδη
);
$Equ["Type"][""] = "STRi";
//print("<pre>"); var_dump($Equ["Type"]); print("</pre>"); exit;


$Equ["Group"] = array(
	"1" => "G1", // Group
	"2" => "G2",
	"3" => "G3",
	"4" => "L", // Listed
);
$Equ["Group"][""] = "STRi";
//print("<pre>"); var_dump($Equ["Group"]); print("</pre>"); exit;


$Equ["Range"] = array(
	"m" => "", // m σε κενό
);
$Equ["Range"][""] = "STRi";
//print("<pre>"); var_dump($Equ["Range"]); print("</pre>"); exit;


$Equ["Couplings"] = array(
	"(none)" => "", // Κενό
	" & " => ",", // Σύνδεσμος (&) σε Κόμμα
);
$Equ["Couplings"][""] = "STRi";
//print("<pre>"); var_dump( $Equ["Couplings"] ); print("</pre>"); exit();


$EquPreg["Money"] = array(
	"\s+" => ".", // Κενά σε Τελείες
);
$EquPreg["Money"][""] = "PREG_REGEXi";
//print("<pre>"); var_dump($EquPreg["Money"]); print("</pre>"); exit;


$Equ["Color"] = array(
	"b" => "ο", // Bay - Καφέ (Ορφνό)
	"B" => "ο",
	"br" => "ο", // Brown - Καφέ (Ορφνό)
	"Br" => "ο",
	"blk" => "μ", // Black - Μαύρο
	"Blk" => "μ",
	"ch" => "ξ", // Chestnut - Κίτρινο (Ξανθό)
	"Ch" => "ξ",
	"gr" => "ψ", // Grey - Γκρί (Ψαρί/Φαιό)
	"Gr" => "ψ",
	"Rn" => "ψ", // Roan - Γκρί (Ψαρί/Φαιό)
	"rn" => "ψ",
);
$Equ["Color"][""] = "PREG_STRi_WHOLE";
//print("<pre>"); var_dump($Equ["HorseColor"]); print("</pre>"); exit;


$Equ["Sex"] = array(
	"g" => "εκτ.", // Gelding
	"h" => "κ", // Horse
	"c" => "κ", // Colt
	"f" => "φ", // Filly
	"m" => "φ", // Mare
);
$Equ["Sex"][""] = "STRi";
//print("<pre>"); var_dump($Equ["HorseSex"]); print("</pre>"); exit;


$Equ["Track"] = array(
	"??" => EmptyChar(), // Κενό
	"X" => EmptyChar(),
	"Ovs" => EmptyChar(),
	"AN" => "Arlington", // Arlington
	"A" => "Arlington",
	"Arl" => "Arlington",
	"BF" => "Bloemfontein", // Bloemfontein
	"CD" => "Clairwood", // Clairwood
	"C" => "Clairwood",
	"Clw" => "Clairwood",
	"DE" => "Durbanville", // Durbanville
	"D" => "Durbanville",
	"Dbv" => "Durbanville",
	"FW" => "Fairview", // Fairview
	"F" => "Fairview",
	"Frv" => "Fairview",
	"GE" => "Greyville", // Greyville
	"G" => "Greyville",
	"Gry" => "Greyville",
	"KW" => "Kenilworth", // Kenilworth
	"K" => "Kenilworth",
	"Ken" => "Kenilworth",
	"W" => "Kenilworth",
	"Keno" => "Kenilworth",
	"KY" => "Kimberley", // Kimberley
	"Y" => "Kimberley",
	"Flp" => "Kimberley",
	"MN" => "Mauritius", // Mauritius
	"NT" => "Newmarket", // Newmarket
	"RJ" => "Randjesfontein", // Randjesfontein
	"SV" => "Scottsville", // Scottsville
	"S" => "Scottsville",
	"SCT" => "Scottsville",
	"P" => "Scottsville",
	"SCI" => "Scottsville",
	"TN" => "Turffontein", // Turffontein
	"T" => "Turffontein",
	"Tur" => "Turffontein",
	"J" => "Turffontein",
	"Tfi" => "Turffontein",
	"VR" => "Vaal", // Vaal
	"V" => "Vaal",
	"Val" => "Vaal",
	"L" => "Vaal",
	"Vsn" => "Vaal",
	"ZE" => "Zimbabwe", // Zimbabwe
	"H" => "Zimbabwe",
	"Mash" => "Zimbabwe",
);
$Equ["Track"][""] = "PREG_STRi_WHOLE";
//print("<pre>"); var_dump($Equ["Track"]); print("</pre>"); exit;


$Equ["Terrain"] = array(
	"G" => "Gd", // Good
	"N" => "Gd",
	"Y" => "Gd",
	"F" => "Fm", // Firm
	"S" => "Sft", // Soft
	"s" => "GS", // Slightly Soft
	"V" => "VS", // Very Soft
	"H" => "Hy", // Heavy
);
$Equ["Terrain"][""] = "PREG_STR_WHOLE";
//print("<pre>"); var_dump($Equ["Terrain"]); print("</pre>"); exit;




$Equ["HistoryType"] = array(
	"0" => "f", // Επίπεδη
);
$Equ["HistoryType"][""] = "STRi";
//print("<pre>"); var_dump($Equ["HistoryType"]); print("</pre>"); exit;
?>