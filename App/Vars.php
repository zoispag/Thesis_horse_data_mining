<?php	SessionId(); DisplayProgress();

function SessionId() {
	global $_SessionId;
	
	return($_SessionId = $_SessionId ?: uniqid());
}

function FixSpaces($theString) {
	return preg_replace(array("'(?:^\s+|\s+$)'uis", "'\s+'uis"), array("", " "), $theString);
}

function CleanSpecialChars($theString) {
	return preg_replace("'\p{M}'uis", "", Normalizer::normalize($theString, Normalizer::FORM_KD));
}

function Secs2Mins($theNumber) {
	$mins = floor($theNumber / 60);
	$secs = floor($theNumber) % 60;
	$secs = str_pad($secs, 2, "0", STR_PAD_LEFT);
	$msecs = stristr($theNumber, ".") * 100;
	$msecs = str_pad($msecs, 2, "0", STR_PAD_LEFT);
	return($mins.".".$secs.".".$msecs);
}

function EquSearch($theValue, $theEqu, $theFilter = false, $theStop = false) {
	
	if(is_array(current($theEqu))) {
		$EquArray = $theEqu;
	}
	else {
		$EquArray = array($theEqu);
	}
	
	foreach($EquArray as $equCount => $theEqu) {
		
		if(!$_Search["Value"]) $_Search["Value"] = $theValue;
		
		$_Search["Type"] = $theEqu[""];
		unset($theEqu[""]);
		
		$_Search["Find"] = array_keys($theEqu);
		$_Search["Replace"] = $theEqu;
		
		if($_Search["Type"] == "STR") {
			$replaceValue = str_replace($_Search["Find"], $_Search["Replace"], $_Search["Value"], $replaceCount);
			$_Search["Value"] = ($theFilter && !$replaceCount) ? null : $replaceValue;
			if($theStop && $replaceCount) return $_Search["Value"];
			continue;
		}
		else if($_Search["Type"] == "STRi") {
			$replaceValue = str_ireplace($_Search["Find"], $_Search["Replace"], $_Search["Value"], $replaceCount);
			$_Search["Value"] = ($theFilter && !$replaceCount) ? null : $replaceValue;
			if($theStop && $replaceCount) return $_Search["Value"];
			continue;
		}
		else if($_Search["Type"] == "PREG_REGEX") {
			$_Search["Param"] = function($val) {return "'".$val."'us";};
		}
		else if($_Search["Type"] == "PREG_REGEXi") {
			$_Search["Param"] = function($val) {return "'".$val."'uis";};
		}
		else if($_Search["Type"] == "PREG_REGEX_REPLACE") {
			$_Search["Param"] = function($val) {return "'.*?".$val.".*'us";};
		}
		else if($_Search["Type"] == "PREG_REGEXi_REPLACE") {
			$_Search["Param"] = function($val) {return "'.*?".$val.".*'uis";};
		}
		else if($_Search["Type"] == "PREG_STR_CHUNK") {
			$_Search["Param"] = function($val) {return "'".preg_quote($val,"'")."'us";};
		}
		else if($_Search["Type"] == "PREG_STRi_CHUNK") {
			$_Search["Param"] = function($val) {return "'".preg_quote($val,"'")."'uis";};
		}
		else if($_Search["Type"] == "PREG_STR_WHOLE") {
			$_Search["Param"] = function($val) {return "'^".preg_quote($val,"'")."$'us";};
		}
		else if($_Search["Type"] == "PREG_STRi_WHOLE") {
			$_Search["Param"] = function($val) {return "'^".preg_quote($val,"'")."$'uis";};
		}
		else if($_Search["Type"] == "PREG_STR_REPLACE") {
			$_Search["Param"] = function($val) {return "'.*?".preg_quote($val,"'").".*'us";};
		}
		else if($_Search["Type"] == "PREG_STRi_REPLACE") {
			$_Search["Param"] = function($val) {return "'.*?".preg_quote($val,"'").".*'uis";};
		}
		
		$_Search["Find"] = array_map($_Search["Param"], $_Search["Find"]);
		//print("<pre>"); var_dump(array_combine($_Search["Find"], $_Search["Replace"])); print("</pre>"); exit();
		
		if($theStop) {
			unset($tisFound);
			$tisFound = preg_filter($_Search["Find"], $_Search["Replace"], $_Search["Value"]);
		}
		
		if($theFilter) {
			$_Search["Value"] = preg_filter($_Search["Find"], $_Search["Replace"], $_Search["Value"]);
		}
		else {
			$_Search["Value"] = preg_replace($_Search["Find"], $_Search["Replace"], $_Search["Value"]);
		}
		//print("<pre>"); var_dump($_Search["Value"]); print("</pre>"); exit();
		
		if($theStop && $tisFound) return $_Search["Value"];
	}
	
	return $_Search["Value"];
}

function Greeklish2Greek($greeklish) {
	$greek = $greeklish;
	
	$greek = str_replace(
		array(
			"TH", "Th", "th",
			"KS", "Ks", "ks",
			"CH", "Ch", "ch",
			"PS", "Ps", "ps",
		),
		array(
			"Θ", "Θ", "θ",
			"Ξ", "Ξ", "ξ",
			"Χ", "Χ", "χ",
			"Ψ", "Ψ", "ψ",
		),
		$greek
	);
	$greek = str_replace(
		array(
			"A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",
			"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"
		),
		array(
			"Α", "Β", "", "Δ", "Ε", "Φ", "Γ", "Η", "Ι", "", "Κ", "Λ", "Μ", "Ν", "Ο", "Π", "", "Ρ", "Σ", "Τ", "Υ", "Β", "Ω", "Χ", "Υ", "Ζ",
			"α", "β", "", "δ", "ε", "φ", "γ", "η", "ι", "", "κ", "λ", "μ", "ν", "ο", "π", "", "ρ", "σ", "τ", "υ", "β", "ω", "χ", "υ", "ζ"
		),
		$greek
	);
	$greek = preg_replace("'σ([^Α-ω])|σ$'uis", "ς$1", $greek);
	
	return($greek);
}

function EmptyChar() {
	return("-");
}

function LinkBase() {
	return(dirname("//".$_SERVER['SERVER_NAME'].str_replace($_SERVER['DOCUMENT_ROOT'], "", str_replace("\\", "/", __DIR__))));
}

function Title() {
	return(Greeklish2Greek(basename(preg_replace("'".addslashes(basename($_SERVER["SCRIPT_NAME"]))."'uis", "", $_SERVER["SCRIPT_FILENAME"]))));
}

function PathDownload() {
	return("//".preg_replace("'^.*?[.](\bcrazyrabbit|crbb\b)'is", "$1", $_SERVER["SERVER_NAME"])."/Download/"/*?file=*/);
}

function ImageDownload() {
	return("//".preg_replace("'^.*?[.](\bcrazyrabbit|crbb\b)'is", "$1", $_SERVER["SERVER_NAME"])."/!/dl.png");
}

function ImageDelete() {
	return("//".preg_replace("'^.*?[.](\bcrazyrabbit|crbb\b)'is", "$1", $_SERVER["SERVER_NAME"])."/!/del.png");
}

function ImagePattern() {
	return("//".preg_replace("'^.*?[.](\bcrazyrabbit|crbb\b)'is", "$1", $_SERVER["SERVER_NAME"])."/!/ptrn.png");
}

function IconFavorite() {
	return("//".preg_replace("'^.*?[.](\bcrazyrabbit|crbb\b)'is", "$1", $_SERVER["SERVER_NAME"])."/!/favicon.ico");
}

function PathFix($filePath) {
	$filePath = dirname($filePath)."\\".preg_replace("'([.][^.]*)$'uis", " (1)$1",basename($filePath));
	
	while(file_exists(iconv("UTF-8", "Greek", $filePath))) {
		$filePath = preg_replace_callback("'\s[(](\d+)[)][.]([^.]*)$'uis", create_function('$match', 'return " (".($match[1]+1).").".$match[2];'), $filePath);
	}
	
	return(iconv("UTF-8", "Greek", $filePath));
}

function makeBackUp($filePath) {
	if(file_exists($filePath)) {
		$fBackUpPath = dirname($filePath)."\\BackUps";
		if(!is_dir($fBackUpPath)) {mkdir($fBackUpPath);}
		$fBackUpPath = PathFix($fBackUpPath."\\Old_".basename($filePath));
		rename($filePath, $fBackUpPath);
	}
}

function FileCopy(&$Error, $copyFunc, $tmpFile, $finalFilePath, $Progress = false, $backUp = false, $fileMatch = "'.*'uis", $matchError = "<h3>File MUST be of Type: Anything</h3><br/>") {
	if($copyFunc != "move_uploaded_file") {
		$urlFile = $tmpFile;
		$tmpFile = tempnam($_SERVER["TMP"], "ul");
		$Error = Url2FileError($urlFile, $tmpFile, $Progress);
		if($Error) {return;}
	}
	
	$finalName = basename($finalFilePath);
	
	if(!preg_match($fileMatch, $finalName)) {
		$Error .= $matchError;
		return;
	}
	
	ob_start();
	if(is_file($tmpFile)) {
		$finalFile = $backUp ? $finalFilePath : PathFix($finalFilePath);
		if($backUp) {makeBackUp($finalFile);}
		if(!$copyFunc($tmpFile, $finalFile)) {$ErrorFlag = true;}
	}
	else {$ErrorFlag = true;}
	
	if($ErrorFlag) {
		$Error .= "<p>Error Occured on file <span style='color:red;'>".$finalName."</span></p>";
		$Error .= !ob_get_contents() ? "" : "<pre>".ob_get_contents()."</pre>";
	}
	ob_end_clean();
	
	return($finalFile);
}

function Url2FileError($PageUrl, $File, $Progress = false) {
	global $Curl;

	$tmpFilePointer = fopen($File, "w");
	
	unset($PageData, $Curl);
	$Curl = curl_init($PageUrl);
	curl_setopt_array($Curl,
		array(
			CURLOPT_RETURNTRANSFER	=> true,
			CURLOPT_FAILONERROR		=> true,
			CURLOPT_AUTOREFERER		=> true,
			CURLOPT_FOLLOWLOCATION	=> true,
			CURLOPT_MAXREDIRS		=> 5,
			//CURLOPT_COOKIEFILE		=> $cookies,
			//CURLOPT_COOKIEJAR		=> $cookies,
			CURLOPT_ENCODING		=> "",
			CURLOPT_USERAGENT		=> "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)",
			CURLOPT_MAXCONNECTS		=> 50,
			CURLOPT_CONNECTTIMEOUT	=> 120,
			CURLOPT_TIMEOUT			=> 120,
			CURLOPT_VERBOSE			=> true,
			//CURLOPT_HEADER			=> true,
			//CURLOPT_SSL_VERIFYHOST	=> 0,
			//CURLOPT_SSL_VERIFYPEER	=> false,
			CURLOPT_FILE			=> $tmpFilePointer,
		)
	);
	if($Progress) {
		curl_setopt_array($Curl,
			array(
				CURLOPT_NOPROGRESS			=> false,
				CURLOPT_PROGRESSFUNCTION	=> "CalcProgress"
			)
		);
	}
	$PageData = curl_exec($Curl);
	$Error .= curl_error($Curl);
	curl_close($Curl);
	
	fclose($tmpFilePointer);
	
	return($Error);
}

function CalcProgress($downloadSize, $downloadNow, $uploadSize, $uploadNow, $transferSpeed = "") {
	global $curl;
	
	if(!$transferSpeed) $transferSpeed = @curl_getinfo($curl, CURLINFO_SPEED_DOWNLOAD);
	
	session_id($_GET["SessionId"] ?: $_REQUEST["PHP_SESSION_UPLOAD_PROGRESS"]);
	session_start();
	$_SESSION["Speed"] = $transferSpeed ? number_format($transferSpeed/pow(10,3),0,", ",".")." kbps" : $_SESSION["Speed"];
	$_SESSION["Progress"] = $downloadSize ? number_format($downloadNow/$downloadSize*pow(10,2),0,", ",".")."%" : 0 ;
	session_commit();
}

function CalcElapsedTime() {
	session_id($_GET["SessionId"]);
	session_start();
	
	if(!$_SESSION["InitialTime"]) $_SESSION["InitialTime"] = time();
	
	$elapsedTime = time() - $_SESSION["InitialTime"];
	$elapsedMin = floor($elapsedTime/60);
	$elapsedSec = $elapsedTime%60;
	
	if($elapsedMin > 0 && $elapsedSec == 0) {
		$_SESSION["Time"] = $elapsedMin." min";
	}
	elseif($elapsedMin > 0 && $elapsedSec > 0) {
		$_SESSION["Time"] = $elapsedMin." min ".$elapsedSec." s";
	}
	else {
		$_SESSION["Time"] = $elapsedSec." s";
	}
	
	session_commit();
}

function DisplayProgress() {
	if(isset($_GET["Progress"])) {
		CalcElapsedTime();
		session_id($_GET["SessionId"]);
		session_start();
		switch($_GET["Progress"]) {
			case "File":
				if($uploadInfo = $_SESSION["upload_progress_".$_GET["SessionId"]]) {
					//var_export($uploadInfo);
					CalcProgress($uploadInfo['content_length'], $uploadInfo['bytes_processed'], $uploadInfo['content_length'], $uploadInfo['bytes_processed']);
				}
			case "Link":
				$_GET["Progress"] .= " Upload ";
			default:
				$_Echo = "
					<h3>Σε εξέλιξη, παρακαλώ περιμένετε...</h3>
					<div class='progress' style='width:370px; height:50px; background:rgba(51,122,183,0.5);'>
						<div class='progress-bar' role='progressbar' aria-valuenow='".str_replace("%", "" , $_SESSION["Progress"])."' aria-valuemin='0' aria-valuemax='100' style='width:".$_SESSION["Progress"].";'></div>
						<span class='".($_SESSION["Progress"] ? "fa-lg" : "fa fa-spinner fa-2x")."' style='position:absolute; left:0; width:100%; color:white; line-height:50px;'>".($_SESSION["Progress"] ?: "")."</span>
					</div>
					<p>".$_SESSION["Time"]."</p>
					<!--<p>".($_SESSION["Speed"] ? "Speed: ".$_SESSION["Speed"] : "")."</p>//-->
					".(!$_SESSION["Progress"] ? "" : "
						<script type='text/javascript'>
							document.title = '[".$_SESSION["Progress"]."] ".Title()."';
						</script>
					")."
				";
			break;
		}
		session_commit();
		print($_Echo);
		exit();
	}
}

function LinkData($PageLink, $Cookies = "", $ReturnRawData = false) {
	$CurlOptions = CurlOptions($Cookies);
	
	$Curl = curl_init($PageLink);
	curl_setopt_array($Curl, $CurlOptions);
	$LinkData = curl_exec($Curl);
	if(curl_error($Curl)) $LinkData = false;
	curl_close($Curl);
	
	if(!$ReturnRawData) $LinkData = Html2Xpath($LinkData);
	
	return($LinkData);
}

function MultiLinkData($PageLinks, $Cookies = "", $ReturnRawData = false) {
	$CurlOptions = CurlOptions($Cookies);
	
	$CurlMulti = curl_multi_init();
	curl_multi_setopt($CurlMulti, CURLMOPT_PIPELINING, 3);
	foreach((array)$PageLinks as $Count => $PageLink) {
		$Curls[$Count] = curl_init($PageLink);
		curl_setopt_array($Curls[$Count], $CurlOptions);
		curl_multi_add_handle($CurlMulti, $Curls[$Count]);
	}
	//reset($Curls);
	do {
		curl_multi_exec($CurlMulti, $CurlRunning);
		curl_multi_select($CurlMulti);
	} while($CurlRunning > 0);
	foreach((array)$Curls as $Count => $Curl) {
		$LinkData[$Count] = curl_error($Curl) ? false : curl_multi_getcontent($Curl);
		curl_multi_remove_handle($CurlMulti, $Curl);
		
		if(!$ReturnRawData) $LinkData[$Count] = Html2Xpath($LinkData[$Count]);
	}
	curl_multi_close($CurlMulti);
	
	return($LinkData);
}

function CurlOptions($Cookies = "") {
	$CurlOptions = array(
		CURLOPT_RETURNTRANSFER	=> true,
		CURLOPT_FAILONERROR		=> true,
		CURLOPT_AUTOREFERER		=> true,
		CURLOPT_FOLLOWLOCATION	=> true,
		CURLOPT_MAXREDIRS		=> 5,
		CURLOPT_ENCODING		=> "",
		CURLOPT_USERAGENT		=> "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)",
		CURLOPT_MAXCONNECTS		=> 50,
		CURLOPT_CONNECTTIMEOUT	=> 120,
		CURLOPT_TIMEOUT			=> 120,
		//CURLOPT_VERBOSE			=> true,
		CURLOPT_HEADER			=> false,
		CURLOPT_SSL_VERIFYHOST	=> 0,
		CURLOPT_SSL_VERIFYPEER	=> false
	);
	if($Cookies)
		$CurlOptions += array(
			CURLOPT_COOKIEFILE		=> $Cookies,
			CURLOPT_COOKIEJAR		=> $Cookies
		);
	//print("<pre>"); var_dump($CurlOptions); print("</pre>"); exit();
	
	return($CurlOptions);
}

function Html2Xpath($LinkData) {
	$Dom = new DOMDocument();
	@$Dom->loadHTML($LinkData);
	//print $Dom->saveHTML(); exit();
	$Html2Xpath = new DOMXPath($Dom);
	
	return($Html2Xpath);
}


function XmlFiles($XmlDir, $Date) {
	$iTrack = 0;
	foreach(scandir($XmlDir, SCANDIR_SORT_DESCENDING) as $FileName) {
		$FilePath = $XmlDir.$FileName;
		if(is_file($FilePath) && preg_match("'^Z".date("Ymd", strtotime($Date))."X[A-Z]D[.]xml$'uis", $FileName)) {
			$Xmls[$iTrack] = $FilePath;
			++$iTrack;
		}
	}
	
	return($Xmls);
}

function Xml2Xpath($FilePath) {
	$Dom = new DOMDocument();
	@$Dom->load($FilePath);
	//print $Dom->saveXML(); exit();
	$Xml2Xpath = new DOMXPath($Dom);
	
	return($Xml2Xpath);
}


function ButtonDelete($Name, $Path) {
	return("
		<form id='fileAction' action='' method='post' target='_self'>
			<input type='hidden' name='name' value='".rawurlencode($Name)."' />
			<input type='hidden' name='file' value='".rawurlencode($Path)."' />
			<input type='submit' name='delete' value='DEL' style='background-image:url(".ImageDelete().");' />
		</form>
	");
}

function ProgressContainer() {
	return("<div id='Progress' class='panel panel-primary text-center' style='width:500px; display:none;'></div>");
}

function DownloadButton($Link, $Name = "", $Text = "") {
	$Link2Name = basename($Link);
	$Link2Name = preg_replace("'\s[(].+([.].+)$'uis", "$1", $Link2Name);
	$Link2Name = str_replace("_", " ", $Link2Name);
	
	return("
		<a class='btn btn-lg btn-success' title='Κατέβασμα αρχείου' data-toggle='tooltip' href='".$Link."' download='".($Name ?: $Link2Name)."'>
			<i class='fa fa-cloud-download fa-2x'></i>
			<h3 style='display:inline;'>&nbsp;".($Text ?: $Link2Name)."</h3>
		</a>
	");
}

function UploadButton($Text = "&nbsp;Μεταφόρτωση") {
	return("
		<form enctype='multipart/form-data' method='post' target='_self' onsubmit='Progress(\"on\", \"File\");'>
			<label class='btn btn-lg btn-primary' title='Μεταφόρτωση αρχείων' data-toggle='tooltip'>
				<i class='fa fa-cloud-upload fa-2x'></i>
				<h3 style='display:inline;'>".$Text."</h3>
				<input type='file' name='FileUpload[]' accept='.txt, .xml' style='display:none;' required multiple onchange='$(this).parents(\"form:first\").submit();'>
			</label>
			<input type='hidden' name='PHP_SESSION_UPLOAD_PROGRESS' value='".SessionId()."' />
		</form>
	");
}

function UploadSuccess($FileName = "") {
	return("
		<div class='alert alert-success'>
			<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			Το αρχείο <strong>".$FileName."</strong> μεταφορτώθηκε επιτυχώς!
		</div>
	");
}

function UploadBody($AllowedFileNames = "", $UploadText = "&nbsp;Μεταφόρτωση") {
	foreach((array)$AllowedFileNames as $FileName) {
		$EchoNames .= "<div class='list-group-item'>".$FileName."</div>";
	}
	
	return("
		<br/>
		".UploadButton($UploadText)."
		<br/>
		
		".ProgressContainer()."
		
		".(!$EchoNames ? "" : "
			<hr/>
			<div class='panel panel-primary' title='Κανόνες ονοματοδοσίας &&nbsp;αποθήκευσης' data-toggle='tooltip' style='display:inline-block;'>
				<div class='panel-heading'>
					<h3 class='panel-title'>Τα αρχεία πρέπει να είναι αποθηκευμένα ως \"Κείμενο Unicode\" και ονομασμένα ως εξής:</h3>
				</div>
				<div class='panel-body'>
					".$EchoNames."
				</div>
			</div>
		")."
	");
}

function RacingHead($Date) {
	return("
		<h1 class='fa-3x text-uppercase'><img src='".LinkBase()."/dist/images/horse.png' width='80px;' style='position:relative; bottom: 15px;'> ".Title()." ΙΠΠΟΔΡΟΜΙΕΣ</h1>
		<hr/>
		<br/>
		
		".ProgressContainer()."
		
		<form id='Date' name='form' method='get' action='' target='_self'>
			<div class='input-group' title='Ημερομηνία' data-toggle='tooltip' style='max-width:200px;'>
				<span class='input-group-addon'><label for='datesel' style='margin:auto;'><i class='fa fa-calendar'></i></label></span>
				<input id='datesel' class='form-control' type='date' name='Date' value='".$Date."' style='min-width:150px;'>
				<span class='input-group-btn'><button type='submit' class='btn btn-primary' title='Ανανέωση' data-toggle='tooltip'><i class='fa fa-repeat'></i>&#8203;</button></span>
			</div>
		</form>
		<br/>
	");
}

function RacingBody($Date, $TrackName, $RaceName, $RaceLink, $RaceTime) {
	$Day = str_replace(
		array("1", "2", "3", "4", "5", "6", "7"),
		array("Δευτέρα", "Τρίτη", "Τετάρτη", "Πέμπτη", "Παρασκευή", "Σάββατο", "Κυριακή"),
		date("N", strtotime($Date))
	);
	
	
	$PdfSource = "https://www.pamestoixima.gr/EL/1/totehome#action=coupon";
	$PdfData = LinkData("https://www.pamestoixima.gr/static/content/horse/Coupon_EL.html?forcenew=1");
	
	foreach($PdfData->evaluate(".//a/@href[contains(., '_".date("dmY", strtotime($Date))."')]") as $iData => $scrapData) {
		$PdfLink = FixSpaces($scrapData->nodeValue);
		$PdfType = stristr($PdfLink, "HR_") ? "Πλήρες" : "Συνοπτικό";
	}
	//print("<pre>"); var_dump($PdfLink); print("</pre>"); exit();
	//print("<pre>"); var_dump($PdfType); print("</pre>"); exit();
	
	
	foreach(array_keys($TrackName) as $iTrack) {
		foreach(array_keys((array)$RaceName[$iTrack]) as $iRace) {
			$EchoRaces .= "
				<tr>
			".($iRace ? "" : "
					<th rowspan='".(count($RaceName[$iTrack]))."'><span title='Ιπποδρόμιο' data-toggle='tooltip'>".$TrackName[$iTrack]."</span></th>
			")."
					<td style='width:70px;'><input type='number' min='1' max='99' class='form-control' placeholder='#' name='Order[".$TrackName[$iTrack]."][".$iRace."]' value='".$_REQUEST["Order"][$TrackName[$iTrack]][$iRace]."' title='Αρίθμιση κούρσας' data-toggle='tooltip' data-placement='left' />
					<td style='text-align:left !important;'><a href='".$RaceLink[$iTrack][$iRace]."' title='Κούρσα' data-toggle='tooltip'>".$RaceName[$iTrack][$iRace]."</a></td>
					<td><span title='Ώρα διεξαγωγής' data-toggle='tooltip'>".$RaceTime[$iTrack][$iRace]."</span></td>
					<input type='hidden' name='Links[".$TrackName[$iTrack]."][".$iRace."]' value='".$RaceLink[$iTrack][$iRace]."' />
				</tr>
			";
		}
	}
	
	return("
		<form id='Main' name='form' action='' method='post' target='_self' onsubmit='Progress(\"on\");'>
			<table id='Form' class='table table-bordered table-condensed'>
				<tr>
					<th style='width:200px;'><a class='btn btn-block btn-".($PdfLink ? ($PdfType == "Πλήρες" ? "primary" : "info") : "warning")."' href='".($PdfLink ?: $PdfSource)."' title='Πρόγραμμα ιπποδρομιών (".($PdfType ?: "Μη&nbsp;διαθέσιμο").")' data-toggle='tooltip'><i class='fa fa-file-text fa-2x'></i></a></th>
					<th colspan='2'><h4 title='Ημέρα ιπποδρομιακής' data-toggle='tooltip'>".$Day."</h4></th>
					<th style='width:130px;'><button type='reset' class='btn btn-block btn-warning' title='Επαναφορά αρίθμισης' data-toggle='tooltip'><i class='fa fa-history fa-2x'></i></button></th>
				</tr>
				<tbody id='typeRaces'>
					".$EchoRaces."
				</tbody>
				<tr>
					<th colspan='4'><button type='submit' name='Run' class='btn btn-block btn-primary' title='Εκτέλεση' data-toggle='tooltip'><i class='fa fa-bolt fa-2x'></i></button></th>
				</tr>
			</table>
			<input type='hidden' name='Date' value='".$Date."' />
			<input type='hidden' name='PHP_SESSION_UPLOAD_PROGRESS' value='".SessionId()."' />
		</form>
		<br/>
	");
}

function RacingBodyLinks($Date, $Quantity = 20) {
	$Day = str_replace(
		array("1", "2", "3", "4", "5", "6", "7"),
		array("Δευτέρα", "Τρίτη", "Τετάρτη", "Πέμπτη", "Παρασκευή", "Σάββατο", "Κυριακή"),
		date("N", strtotime($Date))
	);
	
	
	$PdfSource = "https://www.pamestoixima.gr/EL/1/totehome#action=coupon";
	$PdfData = LinkData("https://www.pamestoixima.gr/static/content/horse/Coupon_EL.html?forcenew=1");
	
	foreach($PdfData->evaluate(".//a/@href[contains(., '_".date("dmY", strtotime($Date))."')]") as $iData => $scrapData) {
		$PdfLink = FixSpaces($scrapData->nodeValue);
		$PdfType = stristr($PdfLink, "HR_") ? "Πλήρες" : "Συνοπτικό";
	}
	//print("<pre>"); var_dump($PdfLink); print("</pre>"); exit();
	//print("<pre>"); var_dump($PdfType); print("</pre>"); exit();
	
	
	for($iLink = 0; $iLink < $Quantity; ++$iLink) {
		$EchoLinks .= "
			<tr>
				<td><input type='number' min='1' max='99' class='form-control' placeholder='#' name='Order[FranceGallop ".$iLink."][0]' value='".$_REQUEST["Order"]["FranceGallop ".$iLink][0]."' title='Αρίθμιση κούρσας' data-toggle='tooltip' data-placement='right' />
				<td colspan='3'><input type='text' class='form-control' placeholder='http://' style='text-align:left !important;' name='Links[FranceGallop ".$iLink."][0]' title='Σύνδεσμος Κούρσας' data-toggle='tooltip' value=\"".$_REQUEST["Links"]["FranceGallop ".$iLink][0]."\" /></td>
			</tr>
		";
	}
	
	return("
		<form id='Main' name='form' action='' method='post' target='_self' onsubmit='Progress(\"on\");'>
			<table id='Form' class='table table-bordered table-condensed'>
				<tr>
					<th style='width:70px;'><a class='btn btn-block btn-".($PdfLink ? ($PdfType == "Πλήρες" ? "primary" : "info") : "warning")."' href='".($PdfLink ?: $PdfSource)."' title='Πρόγραμμα ιπποδρομιών (".($PdfType ?: "Μη&nbsp;διαθέσιμο").")' data-toggle='tooltip'><i class='fa fa-file-text fa-2x'></i></a></th>
					<th colspan='2'><h4 title='Ημέρα ιπποδρομιακής' data-toggle='tooltip'>".$Day."</h4></th>
					<th style='width:130px;'><button type='reset' class='btn btn-block btn-warning' title='Επαναφορά αρίθμισης' data-toggle='tooltip'><i class='fa fa-history fa-2x'></i></button></th>
				</tr>
				<tbody id='typeLinks'>
					".$EchoLinks."
				</tbody>
				<tr>
					<th colspan='4'><button type='submit' name='Run' class='btn btn-block btn-primary' title='Εκτέλεση' data-toggle='tooltip'><i class='fa fa-bolt fa-2x'></i></button></th>
				</tr>
			</table>
			<input type='hidden' name='Date' value='".$Date."' />
			<input type='hidden' name='PHP_SESSION_UPLOAD_PROGRESS' value='".SessionId()."' />
		</form>
		<br/>
	");
}

function RacingBodyXmls($Date, $TrackName, $RaceName, $RaceTime, $Xmls) {
	$Day = str_replace(
		array("1", "2", "3", "4", "5", "6", "7"),
		array("Δευτέρα", "Τρίτη", "Τετάρτη", "Πέμπτη", "Παρασκευή", "Σάββατο", "Κυριακή"),
		date("N", strtotime($Date))
	);
	
	
	$PdfSource = "https://www.pamestoixima.gr/EL/1/totehome#action=coupon";
	$PdfData = LinkData("https://www.pamestoixima.gr/static/content/horse/Coupon_EL.html?forcenew=1");
	
	foreach($PdfData->evaluate(".//a/@href[contains(., '_".date("dmY", strtotime($Date))."')]") as $iData => $scrapData) {
		$PdfLink = FixSpaces($scrapData->nodeValue);
		$PdfType = stristr($PdfLink, "HR_") ? "Πλήρες" : "Συνοπτικό";
	}
	//print("<pre>"); var_dump($PdfLink); print("</pre>"); exit();
	//print("<pre>"); var_dump($PdfType); print("</pre>"); exit();
	
	
	foreach(array_keys($TrackName) as $iTrack) {
		foreach(array_keys((array)$RaceName[$iTrack]) as $iRace) {
			$EchoRaces .= "
				<tr>
			".($iRace ? "" : "
					<th rowspan='".(count($RaceName[$iTrack]))."'><span title='Ιπποδρόμιο' data-toggle='tooltip'>".$TrackName[$iTrack]."</span></th>
			")."
					<td style='width:70px;'><input type='number' min='1' max='99' class='form-control' placeholder='#' name='Order[".$TrackName[$iTrack]."][".$iRace."]' value='".$_REQUEST["Order"][$TrackName[$iTrack]][$iRace]."' title='Αρίθμιση κούρσας' data-toggle='tooltip' data-placement='left' />
					<td style='text-align:left !important;'><span title='Κούρσα' data-toggle='tooltip'>".$RaceName[$iTrack][$iRace]."</span></td>
					<td><span title='Ώρα διεξαγωγής' data-toggle='tooltip'>".$RaceTime[$iTrack][$iRace]."</span></td>
				</tr>
			";
		}
		$EchoRaces.= "<input type='hidden' name='Xmls[".$TrackName[$iTrack]."]' value='".$Xmls[$iTrack]."' />";
	}
	
	return("
		<form id='Main' name='form' action='' method='post' target='_self' onsubmit='Progress(\"on\");'>
			<table id='Form' class='table table-bordered table-condensed'>
				<tr>
					<th style='width:200px;'><a class='btn btn-block btn-".($PdfLink ? ($PdfType == "Πλήρες" ? "primary" : "info") : "warning")."' href='".($PdfLink ?: $PdfSource)."' title='Πρόγραμμα ιπποδρομιών (".($PdfType ?: "Μη&nbsp;διαθέσιμο").")' data-toggle='tooltip'><i class='fa fa-file-text fa-2x'></i></a></th>
					<th colspan='2'><h4 title='Ημέρα ιπποδρομιακής' data-toggle='tooltip'>".$Day."</h4></th>
					<th style='width:130px;'><button type='reset' class='btn btn-block btn-warning' title='Επαναφορά αρίθμισης' data-toggle='tooltip'><i class='fa fa-history fa-2x'></i></button></th>
				</tr>
				<tbody id='typeXmls'>
					".$EchoRaces."
				</tbody>
				<tr>
					<th colspan='4'><button type='submit' name='Run' class='btn btn-block btn-primary' title='Εκτέλεση' data-toggle='tooltip'><i class='fa fa-bolt fa-2x'></i></button></th>
				</tr>
			</table>
			<input type='hidden' name='Date' value='".$Date."' />
			<input type='hidden' name='PHP_SESSION_UPLOAD_PROGRESS' value='".SessionId()."' />
		</form>
		<br/>
	");
}

function NavBar() {
	$Link = dirname(str_replace(LinkBase(), "", "//".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]));
	//print("<pre>"); var_dump($Link); print("</pre>"); exit();
	if($Link != "\\") {
		for($LinkSplit = dirname($Link); $LinkSplit != "\\"; $LinkSplit = dirname($LinkSplit)) {
			if($LinkSplit != "/App")
				$Breadcrumb[] = "<li class='breadcrumb-item'><a href='".LinkBase().$LinkSplit."' target='_self'>".Greeklish2Greek(basename($LinkSplit))."</a></li>";
		}
		$EchoBreadcrumbs = "
			<ol class='breadcrumb'>
				<li class='breadcrumb-item'><a href='".LinkBase()."' target='_self'>Αρχικη</a></li>
				".implode("", array_reverse((array)$Breadcrumb))."
				<li class='breadcrumb-item active'><span>".Greeklish2Greek(basename($Link))."</span></li>
			</ol>
		";
	}
	
	return("
		<!-- Navigation -->
		<nav class='navbar yamm navbar-inverse navbar-fixed-top' role='navigation'>
			<div class='container'>
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class='navbar-header'>
					<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#bs-example-navbar-collapse-1'>
						<span class='sr-only'>Toggle navigation</span>
						<span class='icon-bar'></span>
						<span class='icon-bar'></span>
						<span class='icon-bar'></span>
					</button>
					<a class='navbar-brand' href='".LinkBase()."' target='_self'><span><img src='".LinkBase()."/dist/images/horse.png' width='30px;' style='position:relative; bottom:5px; -webkit-filter:invert(60%);'> Horse Racing</span></a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class='collapse navbar-collapse' id='bs-example-navbar-collapse-1'>
					<ul class='nav navbar-nav pull-right'>
						<li class='dropdown'>
							<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Διοργανώσεις <b class='caret'></b></a>
							<ul class='dropdown-menu'>
								<li>
									<a href='".LinkBase()."/App/Agglikes' target='_self'><span class='icons icon-flag-uk'></span> &nbsp;Αγγλίας</a>
								</li>
								<li>
									<a href='".LinkBase()."/App/Gallikes' target='_self'><span class='icons icon-flag-fr'></span> &nbsp;Γαλλίας</a>
								</li>
								<li>
									<a href='".LinkBase()."/App/N. Afrikhs' target='_self'><span class='icons icon-flag-za'></span> &nbsp;Ν. Αφρικής</a>
								</li>
							</ul>
						</li>
						<li class='dropdown'>
							<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Μεταφορτώσεις <b class='caret'></b></a>
							<ul class='dropdown-menu'>
								<li>
									<a href='".LinkBase()."/App/Agglikes/Metafortwsh' target='_self'><span class='icons icon-flag-uk'></span> &nbsp;Αγγλίας</a>
								</li>
								<li>
									<a href='".LinkBase()."/App/Gallikes/Metafortwsh' target='_self'><span class='icons icon-flag-fr'></span> &nbsp;Γαλλίας</a>
								</li>
								<li>
									<a href='".LinkBase()."/App/N. Afrikhs/Metafortwsh' target='_self'><span class='icons icon-flag-za'></span> &nbsp;Ν. Αφρικής</a>
								</li>
							</ul>
						</li>
						<li class='dropdown'>
							<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Εργαλεία <b class='caret'></b></a>
							<ul class='dropdown-menu'>
								<li>
									<a href='".LinkBase()."/App/Gallikes Ektimhseis' target='_self'><span class='icons icon-flag-fr'></span> &nbsp;Εκτιμήσεις Γαλλίας</a>
								</li>
							</ul>
						</li>
						<li>
							<a href='".LinkBase()."/about.php' target='_self'>Περί</a>
						</li>
						<li class='dropdown yamm-fw'>
							<a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='fa fa-question-circle fa-lg'></i></a>
							<ul class='dropdown-menu'>
								<li>
									<div class='yamm-content'>
										<div class='row'>
											<div class='col-md-12'>
												<h2 class='page-header'>Οδηγίες χρήσης</h2>
											</div>
											<div class='col-md-12'>
												<div class='well'>
													".@file_get_contents('help.html')."
													<!--
													<br />
													<button type='button' class='btn btn-primary btn-lg' data-toggle='modal' data-target='#myModal'>
														<i class='fa fa-info-circle' style='position:relative; bottom:1px;'></i> Αναλυτικές οδηγίες
													</button>
													-->
												</div>
											</div>
										</div>
									</div>
							   </li>
							</ul>
						</li>
					</ul>
				</div>
				<!-- /.navbar-collapse -->
			</div>
			<!-- /.container -->
		</nav>
		
		".$EchoBreadcrumbs."
		
		<!-- Modal -->
		<div class='modal fade' id='myModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
			<div class='modal-dialog modal-xl' role='document'>
				<div class='modal-content'>
					<div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<h4 class='modal-title' id='myModalLabel'>Αναλυτικές οδηγίες</h4>
					</div>
					<div class='modal-body'>
						".file_get_contents(__DIR__."\\help_details.html")."
					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-default pull-right' data-dismiss='modal'>Close</button>
					</div>
				</div>
			</div>
		</div>
		
		<style>
			.dropdown-menu a {
				text-align: left !important;
			}
			
			.navbar-brand:hover img {
				-webkit-filter:invert(100%) !important;
			}
		
			.icons {
				display: inline-block;
				background-size: cover;
				width: 18px;
				height: 18px;
			}
			.icon-flag-uk {
				background-image: url('".LinkBase()."/dist/images/flag-uk.png');
			}
			.icon-flag-fr {
				background-image: url('".LinkBase()."/dist/images/flag-fr.png');
			}
			.icon-flag-za {
				background-image: url('".LinkBase()."/dist/images/flag-za.png');
			}
			
			ul.nav li.dropdown:hover > ul.dropdown-menu {
				display: block;  
			}
			
			@media (min-width: 1280px) {
				.modal-xl {
					width: 1020px;
				}
			}
			
		</style>
	");
}

function ScriptMain() {
	global $_SessionId;
	
	return("
		$(window).unload(function() {});
		
		var progressInterval;
		
		function ScrollToTop(speed) {
			$('html, body').animate({scrollTop: 0}, speed);
		}
		
		function Progress(Display, Type) {
			Display = typeof(Display) != 'undefined' ? Display : '';
			Type = typeof(Type) != 'undefined' ? Type : '';
			
			if(Display == 'on') {
				ScrollToTop(100);
				$('#Progress').fadeIn();
				progressInterval = setInterval(function() {Progress('', Type);}, 10);
			}
			else if(Display == 'off') {
				clearInterval(progressInterval);
				$('#Progress').fadeOut();
			}
			else {
				$('#Progress').load('?Progress=' + Type + '&SessionId=".$_SessionId."');
			}
		}
	");
}

function StyleMain() {
	return("
		<style type='text/css'>
			* {
				margin: auto;
				text-align: center !important;
				vertical-align: middle !important;
			}
			
			b, strong {
				vertical-align: initial !important;
			}
			
			body {
				height: 100%;
				//background: url(".ImagePattern().");
			}
			
			form#fileAction {
				display: inline;
			}
			form#fileAction input {
				width: 35px;
				height: 35px;
				text-indent: -1000%;
				cursor: pointer;
				border-style: none;
				background-color: transparent;
				background-position: center;
				background-size: contain;
				background-repeat: no-repeat;
			}
			
			table#FileList input {
				font-weight: bold;
				cursor: pointer;
				border-style: none;
				background-color: transparent;
			}
			table#FileList td, table#FileList th {
				border-width: 1px;
				text-align: center;
			}
			table#FileList th {
				padding: 10px 2px;
				border-style: dashed;
			}
			table#FileList td {
				padding: 2px;
				border-style: dotted;
			}
			
		</style>
	");
}

function HeaderMain() {
	return("
		<title>".Title()."</title>
		<link rel='shortcut icon' href='".LinkBase()."/dist/images/horse.png'>
		
		<base target='_blank' />
		
		<meta charset='utf-8'>
		<meta http-equiv='X-UA-Compatible' content='IE=edge'>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<meta name='description' content=''>
		<meta name='author' content=''>
		
		<!-- Bootstrap Core CSS -->
		<link rel='stylesheet' href='".LinkBase()."/dist/css/bootstrap.min.css'>
		<!--<link rel='stylesheet' href='https://bootswatch.com/spacelab/bootstrap.min.css'>-->

		<!-- Custom CSS -->
		<link rel='stylesheet' href='".LinkBase()."/dist/css/modern-business.css'>

		<!-- Yamm3 CSS -->
		<link rel='stylesheet' href='".LinkBase()."/dist/yamm/yamm.css'>

		<!-- Custom Fonts -->
		<link rel='stylesheet' type='text/css' href='".LinkBase()."/dist/font-awesome/css/font-awesome.min.css'>
		
		<!-- jQuery JS -->
		<script src='".LinkBase()."/dist/js/jquery.js'></script>
		
		<!-- NiceScroll JS -->
		<script src='".LinkBase()."/dist/js/nicescroll.min.js'></script>
		
		<!-- NiceScroll Startup -->
		<script>
			$(document).ready(function() {
				$('html').niceScroll({cursorcolor:'lightgrey', cursorwidth: '8px', mousescrollstep: 60});
			});
		</script>
		
		<!-- Bootstrap JS -->
		<script src='".LinkBase()."/dist/js/bootstrap.min.js'></script>
		
		<!-- Bootstrap Tooltips -->
		<script>
			$(document).ready(function() {
				$(\"[data-toggle='tooltip']\").tooltip(); 
			});
		</script>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'></script>
			<script src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js'></script>
		<![endif]-->
	");
}

function FooterMain() {
	return("
		<!-- Footer -->
		<hr/>
		<footer>
			<div class='row'>
				<p>
					Copyright &copy; 2016 | Πτυχιακή Εργασία
					<br/>
					<small>
						Ζαχαρίου Βασίλειος - Παγουλάτος Ζώης
						<br/>
						<small><strong>ΤΕΙ Αθήνας » Τμήμα Μηχανηκών Πληροφορικής ΤΕ</strong></small>
					</small>
				</p>
			</div>
		</footer>
	");
}

function Output($Error, $Top, $Middle, $Bottom, $Script="", $NoBr=false) {
	return("
		<!DOCTYPE html>
		<html lang='en'>
			<head>
				".(!$Error ? "" : "<title>".Title().($Error == "N0N" ? "" : " [Error]")."</title>")."
				".HeaderMain().StyleMain()."
			</head>
			<body>
				
				".NavBar()."
				
				<!-- Page Content -->
				<div class='container'>
					<div class='row'>
						".(!$Error || $Error == "N0N" ? "" : "<br/><div id='Error' class='alert alert-danger'>".$Error."</div>")."
						".(!$Top ? "" : "<br/><div id='Top'>".$Top."</div>")."
						".(!$Middle ? "" : ($NoBr ? "" : "<br/>")."<div id='Middle'>".$Middle."</div>")."
						".(!$Bottom ? "" : "<br/><div id='Bottom'>".$Bottom."</div>")."
						".($NoBr ? "" : "<br/>")."
					</div>
					
					".FooterMain()."
				
				</div>
				<!-- /.container -->
			</body>
		</html>
		
		<script type='text/javascript'>".ScriptMain().$Script."</script>
	");
}

?>