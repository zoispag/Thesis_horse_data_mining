<?php	set_time_limit(1800);
require_once(__DIR__."\\..\\..\\Vars.php");


$AllowedFileNames = array(
	"AfrikisFaneles.txt",
	"AfrikisAnabates.txt",
	"AfrikisProponites.txt",
	"Z........X.D.xml"
);

$FilePath = __DIR__."\\..\\EquFiles\\";
$FileProgress = true;
$FileBackUp = true;
$FileMatch = "'^(".implode("|", $AllowedFileNames).")$'uis";
//print("<pre>"); var_dump($FileMatch); print("</pre>"); exit();
$MatchError = "<strong>Λάθος ονοματοδοσία αρχείου!</strong>";


if($_FILES["FileUpload"]["name"][0] != "") {
	unset($fName, $fCount);
	foreach($_FILES["FileUpload"]["name"] as $fCount => $fName) {
		unset($XmlPath);
		if(preg_match("'[.]xml$'uis", $fName)) $XmlPath = __DIR__."\\..\\XMLs\\";
		FileCopy($EchoError, "move_uploaded_file", $_FILES["FileUpload"]["tmp_name"][$fCount], ($XmlPath ?: $FilePath).$fName, $FileProgress, $FileBackUp, $FileMatch, $MatchError);
		$EchoTop .= $EchoError ? "" : UploadSuccess($fName);
	}
	
	if(!$EchoError) $EchoError = "N0N";
}


Start:
session_id(SessionId());
session_start();
$_SESSION["InitialTime"] = $_SESSION["Progress"] = $_SESSION["Speed"] = $_SESSION["Time"] = 0;
session_commit();

$EchoMiddle .= UploadBody($AllowedFileNames);

End:
print(Output($EchoError, $EchoTop, $EchoMiddle, $EchoBottom, $EchoScript));
unset($EchoError, $EchoTop, $EchoMiddle, $EchoBottom, $EchoScript);

?>