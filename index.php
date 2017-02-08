<?php	set_time_limit(0);
require_once(__DIR__."\\App\\Vars.php");

$EchoMiddle .= "
	<div class='row'>
		<div class='col-lg-12'>
			<h2 class='page-header'>
				<span><img src='".LinkBase()."/dist/images/horse.png' width='45px;' style='position:relative; bottom:5px;'> Horse Racing</span>
			</h2>
		</div>
		<div class='col-md-offset-1 col-md-10'>
			<div class='panel panel-info'>
				<div class='panel-heading'>
					<h2 class='panel-title'>
						<a style='text-decoration: none;' role='button' data-toggle='collapse' href='#collapse'>
							<i class='pull-left fa fa-angle-double-down'></i>
							<strong>Δημιουργία διαδικτυακής εφαρμογής για την εξόρυξη ιπποδρομιακών δεδομένων από Ανοιχτά Δεδομένα</strong>
							<i class='pull-right fa fa-angle-double-down'></i>
						</a>
					</h2>
				</div>
				<div id='collapse' class='panel-collapse collapse'>
					<div class='panel-body'>
						<div style='text-align:left !important;'>
							Τα <strong>Ανοιχτά Δεδομένα</strong> (Open Data) αποτελούν αντικείμενο εκτεταμένης μελέτης τα τελευταία χρόνια, με στόχο την εξαγωγή χρήσιμης πληροφορίας. Ανοιχτά είναι τα δεδομένα που μπορούν ελεύθερα να χρησιμοποιηθούν, να επαναχρησιμοποιηθούν και να αναδιανεμηθούν από οποιονδήποτε – υπό τον όρο να γίνεται αναφορά στους δημιουργούς και να διατίθενται, με τη σειρά τους, υπό τους ίδιους όρους.
							<br /><br />
							Στόχος της συγκεκριμένης πτυχιακής αποτελεί η συλλογή, ανάλυση και εξόρυξη γνώσης και χρήσιμης πληροφορίας που αφορούν τον ιππόδρομο και την μετατροπή αυτών σε θεματική ενότητα ενός περιοδικού. Η εργασία αυτή αφορά την υλοποίηση μιας διεπαφής για την ανάκτηση ιπποδρομιακών δεδομένων και τη χρήση τους για την εξαγωγή αποτελεσμάτων και στοιχείων στην κατάλληλη μορφή. Η πληροφορία αυτή θα προέρχεται από ιστοσελίδες ιπποδρομιακών αγώνων όπως Racing Post (<a>http://www.racingpost.com/</a>), Geny (<a>http://www.geny.com/</a>) ή και άλλες ιστοσελίδες που περιέχουν στατιστικά στοιχεία για κούρσες αλόγων.
							<br /><br />
							Το τελικό αποτέλεσμα θα είναι μια σειρά από σελίδες, έτοιμες προς εκτύπωση, στις οποίες θα συνοψίζεται η συνολική εικόνα των αγώνων που έχουν διεξαχθεί σε μια συγκεκριμένη ημερομηνία.
							<br /><br />
							Για την υλοποίηση της εφαρμογής έχει χρησιμοποιηθεί συνδυασμός τεχνολογιών προγραμματισμού εφαρμογών για το web όπως:
							<ul>
								<li style='text-align:left !important;'><span class='label label-primary' style='position:relative; bottom:1px;'>PHP 7</span> <span class='label label-primary' style='position:relative; bottom:1px;'>Javascript</span> <span class='label label-primary' style='position:relative; bottom:1px;'>JQuery 1.11.1</span></li>
								<li style='text-align:left !important;'>το CSS Framework <span class='label label-primary' style='position:relative; bottom:1px;'>Bootstrap 3</span></li>
								<li style='text-align:left !important;'><span class='label label-primary' style='position:relative; bottom:1px;'>NiceScroll</span> <span class='label label-primary' style='position:relative; bottom:1px;'>Font Awesome 4</span> <span class='label label-primary' style='position:relative; bottom:1px;'>Yamm3</span></li>
								<li style='text-align:left !important;'>οι εξειδικευμένες βιβλιοθήκες <span class='label label-primary' style='position:relative; bottom:1px;'>XML</span> και <span class='label label-primary' style='position:relative; bottom:1px;'>ZIP</span></li>
							</ul>
						</div>
					</div>
				</div>
				<div class='panel-footer'>
					<div class='pull-right' style='text-align:right !important;'>
						<strong>Φοιτητές:</strong> Ζαχαρίου Βασίλης & Παγουλάτος Ζώης<br/>
						<strong>Υπεύθυνη Καθηγήτρια:</strong> Ελένη Γαλιώτου
					</div>
					<div class='clearfix'></div>
				</div>
			</div>
		</div>
	</div>

	<div class='row'>
		<div class='col-lg-12'>
			<h3 class='page-header'>
				Διοργανώσεις
			</h3>
		</div>
		<div class='col-md-4 col-sm-6'>
			<div class='panel panel-default text-center'>
				<div class='panel-heading'>
					<span class='fa-stack fa-5x'>
						  <img src='".LinkBase()."/dist/images/map-uk.png' width='100%'>
					</span>
				</div>
				<div class='panel-body'>
					<h4>Αγγλίας</h4>
					<p>Συλλογές κουρσών από RacingPost</p>
					<a href='".LinkBase()."/App/Agglikes/' class='btn btn-primary btn-block' target='_self'>Εκτέλεση</a>
					<a href='".LinkBase()."/App/Agglikes/Metafortwsh/' class='btn btn-default btn-block' target='_self'>Μεταφόρτωση</a>
				</div>
			</div>
		</div>
		<div class='col-md-4 col-sm-6'>
			<div class='panel panel-default text-center'>
				<div class='panel-heading'>
					<span class='fa-stack fa-5x'>
						<img src='".LinkBase()."/dist/images/map-fr.png' width='100%'>
					</span>
				</div>
				<div class='panel-body'>
					<h4>Γαλλίας</h4>
					<p>Συλλογές κουρσών από Geny & FranceGallop</p>
					<a href='".LinkBase()."/App/Gallikes/' class='btn btn-primary btn-block' target='_self'>Εκτέλεση</a>
					<div class='col-md-6 col-sm-6' style='padding-left: 0; padding-right: 3px; margin-top:5px;'>
						<a href='".LinkBase()."/App/Gallikes Ektimhseis/' class='btn btn-primary btn-block' target='_self'>Εκτιμήσεις</a>
					</div>
					<div class='col-md-6 col-sm-6' style='padding-right: 0; padding-left: 3px; margin-top:5px;'>
						<a href='".LinkBase()."/App/Gallikes/Metafortwsh/' class='btn btn-default btn-block' target='_self'>Μεταφόρτωση</a>
					</div>
				</div>
			</div>
		</div>
		<div class='col-md-4 col-sm-6'>
			<div class='panel panel-default text-center'>
				<div class='panel-heading'>
					<span class='fa-stack fa-5x'>
						  <img src='".LinkBase()."/dist/images/map-za.png' width='100%'>
					</span>
				</div>
				<div class='panel-body'>
					<h4>Ν. Αφρικής</h4>
					<p>Συλλογές κουρσών από XML της TabGold</p>
					<a href='".LinkBase()."/App/N. Afrikhs/' class='btn btn-primary btn-block' target='_self'>Εκτέλεση</a>
					<a href='".LinkBase()."/App/N. Afrikhs/Metafortwsh/' class='btn btn-default btn-block' target='_self'>Μεταφόρτωση</a>
				</div>
			</div>
		</div>
	</div>
";

$EchoScript .= "
	document.title = 'Πτυχιακή Εργασία';
	
	$('.collapse').on('shown.bs.collapse', function(){
		$(this).parent().find('.fa-angle-double-down').removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
	}).on('hidden.bs.collapse', function(){
		$(this).parent().find('.fa-angle-double-up').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
	});
	
";

print(Output($EchoError, $EchoTop, $EchoMiddle, $EchoBottom, $EchoScript));
unset($EchoError, $EchoTop, $EchoMiddle, $EchoBottom, $EchoScript);

?>