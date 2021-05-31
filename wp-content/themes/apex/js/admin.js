	jQuery(document).ready(function() {
		jQuery(".more-publishing-options").click(function() { 
			jQuery(".misc-pub-section").toggleClass("misc-pub-section-open"); 
		});

		//translate_labels(en_EN);



	});
	
	jQuery(document).ready(function() {
		console.log('collapsed');
		jQuery('#wpcontent').addClass('done');

	//	jQuery(".layout").not("-collapsed").addClass("-collapsed");
	//	
	//	jQuery(".layout").click(function() {
	//		jQuery(".layout").not("-collapsed").not(this).addClass("-collapsed");
	//	});
	});

	function translate_labels(targetlanguage) {
		jQuery("label, .acf-tab-button, .description").each(function() {

			let innerText = jQuery(this).text();

			if(en_EN.hasOwnProperty(innerText)) {
				let text = en_EN[innerText];
				jQuery(this).text(text);
			}
		});

	}

	let en_EN = {
		'Beschrijving' : 'Description',
		'H1 Kop' : 'H1 Header',
		'Paginatitel' : 'Pagetitle',
		'Kop' : 'Header (H2)',
		'Tekst' : 'Text',
		'Icoon toevoegen' : 'Add icon',
		'Uitgelichte tekst' : 'Spotlight text',
		'1 kolom' : '1 column',
		'2 kolommen' : '2 columns',
		'Blok inhoud' : 'Content',
		'Opties' : 'Options',
		'Achtergrondkleur' : 'Background color',
		'Gepubliceerd' : 'Published',
		'Begindatum' : 'Start date',
		'Einddatum' : 'End date',
		'Toon dit blok vanaf een bepaalde datum' : 'Display this block starting from selected date',
		'Toon dit blok tot een bepaalde datum' : 'Display this block until selected date'

	}