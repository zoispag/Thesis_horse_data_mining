<?php	set_time_limit(0);
require_once(__DIR__."\\App\\Vars.php");

$EchoMiddle .= "
	<div class='row'>
		<div class='col-lg-12'>
			<h1 class='page-header'>Περί<br /></h1>
			<div class='panel panel-default'>
				<div class='panel-heading'>
					<h2 class='panel-title'>
						<strong>Δημιουργία διαδικτυακής εφαρμογής για την εξόρυξη ιπποδρομιακών δεδομένων από Ανοιχτά Δεδομένα</strong>
					</h2>
				</div>
				<div class='panel-body'>
					<div style='text-align:left !important;'>
						Τα <strong>Ανοιχτά Δεδομένα</strong> (Open Data) αποτελούν αντικείμενο εκτεταμένης μελέτης τα τελευταία χρόνια, με στόχο την εξαγωγή χρήσιμης πληροφορίας. Ανοιχτά είναι τα δεδομένα που μπορούν ελεύθερα να χρησιμοποιηθούν, να επαναχρησιμοποιηθούν και να αναδιανεμηθούν από οποιονδήποτε – υπό τον όρο να γίνεται αναφορά στους δημιουργούς και να διατίθενται, με τη σειρά τους, υπό τους ίδιους όρους.
						<br /><br />
						Στόχος της συγκεκριμένης πτυχιακής αποτελεί η συλλογή, ανάλυση και εξόρυξη γνώσης και χρήσιμης πληροφορίας που αφορούν τον ιππόδρομο και την μετατροπή αυτών σε θεματική ενότητα ενός περιοδικού. Η εργασία αυτή αφορά την υλοποίηση μιας διεπαφής για την ανάκτηση ιπποδρομιακών δεδομένων και τη χρήση τους για την εξαγωγή αποτελεσμάτων και στοιχείων στην κατάλληλη μορφή. Η πληροφορία αυτή θα προέρχεται από ιστοσελίδες ιπποδρομιακών αγώνων όπως Racing Post (<a>http://www.racingpost.com/</a>), Geny (<a>http://www.geny.com/</a>) ή και άλλες ιστοσελίδες που περιέχουν στατιστικά στοιχεία για κούρσες αλόγων.
						<br /><br />
						Το τελικό αποτέλεσμα θα είναι μια σειρά από σελίδες, έτοιμες προς εκτύπωση, στις οποίες θα συνοψίζεται η συνολική εικόνα των αγώνων που έχουν διεξαχθεί σε μια συγκεκριμένη ημερομηνία.
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Team Members Row -->
	<div class='row'>
		<div class='col-lg-12'>
			<h2 class='page-header'>Ποιοι είμαστε</h2>
		</div>
		<div class='col-lg-6 col-sm-6 text-center'>
			<img class='img-circle img-responsive img-center' src='".LinkBase()."/dist/images/zois.jpg' alt='zois' width='160px'>
			<h3>
				Ζώης Παγουλάτος
				<br/>
				<small>Φοιτητής</small>
			</h3>
			<a href='mailto:cs081014@teiath.gr'>cs081014@teiath.gr</a>
			<p>
				<i>Αγαπάει το Web Developement <i class='fa fa-code fa-lg' style='position:relative; bottom:1px;'></i>, τα ταξίδια <i class='fa fa-plane fa-lg' style='position:relative; bottom:1px;'></i> και τα σουβλάκια!!<br/>Θα πει πάντα «ναι» σε ένα gin tonic με λίγο στυμμένο lime.</i>
			</p>
		</div>
		<div class='col-lg-6 col-sm-6 text-center'>
			<img class='img-circle img-responsive img-center' src='".LinkBase()."/dist/images/vasilis.jpg' alt='vasilis' width='160px'>
			<h3>
				Βασίλης Ζαχαρίου
				<br/>
				<small>Φοιτητής</small>
			</h3>
			<a href='mailto:cs081016@teiath.gr'>cs081016@teiath.gr</a>
			<p>
				<i>Αγαπάει τον προγραμματισμό <strong class='text-danger'>NOT <i class='fa fa-exclamation-circle' style='position:relative; bottom:1px;'></i></strong>, τη διασκέδαση και τις πίτσες (!!!)<br/>Θα πει «ναι» σε οτιδήποτε περιέχει αιθυλική αλκοόλη!</i>
			</p>
		</div>
	</div>
	<div class='row'>
		<div class='col-lg-12'>
			<h2 class='page-header'>Επίβλεψη</h2>
		</div>
		<div class='col-lg-12 col-sm-12 text-center'>
		<img class='img-circle img-responsive img-center' src='".LinkBase()."/dist/images/galiotou.jpg' alt='galiotou' width='160px'>
			<h3>
				Γαλιώτου Ελένη
				<br/>
				<small>Υπεύθυνη Καθηγήτρια</small>
			</h3>
			<a href='mailto:egali@teiath.gr'>egali@teiath.gr</a>
			<p>
				Καθηγήτρια του τμήματος Πληροφοριακών Συστημάτων και Εφαρμογών του ΤΕΙ Αθήνας
			</p>
		</div>
	</div>
";

$EchoScript .= "
	document.title = 'Πτυχιακή Εργασία';
	
	$('.yamm-fw').fadeOut(1000);
";

print(Output($EchoError, $EchoTop, $EchoMiddle, $EchoBottom, $EchoScript));
unset($EchoError, $EchoTop, $EchoMiddle, $EchoBottom, $EchoScript);

?>