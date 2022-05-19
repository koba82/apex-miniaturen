<?php
 // needed to load some jquery/css for ACF
/**
 * Our custom dashboard page
 */

/** WordPress Administration Bootstrap */
acf_form_head();
require_once( ABSPATH . 'wp-load.php' );
require_once( ABSPATH . 'wp-admin/admin.php' );
require_once( ABSPATH . 'wp-admin/admin-header.php' );
?>
<div class="custom-dashboard">
	<div class="apex-version">
		Apex Versie: <?php echo APEX_MAIN_VERSION . APEX_SUB_VERSION . ' | ' . APEX_VERSION_DATE; ?>
	</div>
<div class="wrap envisic-dashboard-wrap">


	
	<hr>
	
	<div class="column-wrap">
	
		<div class="column">
            <h1>Hallo <?php global $current_user; wp_get_current_user(); echo $current_user->user_nicename; ?></h1>
		</div>


		<div class="column">
			<h2>Wil je een vraag stellen?</h2>
			Dat kan natuurlijk. Stel je vraag in onderstaand formulier, klik op 'Versturen' en je krijgt zo snel mogelijk antwoord!
			<form id="support-form" method="post" action="admin.php?page=custom-dashboard">
				<textarea id="support-text-field" name="support-text-field" rows="4" placeholder="Stel je vraag"></textarea>
				<input type="hidden" value="<?php the_field('client-number', 'option'); ?>" name="client-number" id="client-number" />
				<input type="submit" name="submit" id="submit" value="Versturen" >
			</form>
			
			<?php	
				
				if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['bundle-css']) ) :
					//Get mailto from the flex item, if not set we get the mailto from options page
					$email_to = 'info@envisic.nl';	
					
					$subject = 'Supportvraag van' . get_field('config-name', 'option');

					//Convert body array to text and add the permalink of the current page
					$replyEmail = get_field('config-naw', 'option');		
					$body = $_POST['support-text-field'] . '<br /><br />';
					$body .= 'Klantnummer: ' . $_POST['client-number'] . '<br />';
					$body .= 'E-mail adres: ' . $replyEmail['email'];
				
					function send_my_mail($email_to, $subject, $body) {

						//Send the mail
						add_filter( 'wp_mail_content_type','set_my_mail_content_type' );
						add_action( 'phpmailer_init', 'send_smtp_email' );
					
						wp_mail( $email_to, $subject, $body);

						remove_filter( 'wp_mail_content_type','set_my_mail_content_type' );
						remove_action( 'phpmailer_init', 'send_smtp_email' );
					
					}
					send_my_mail($email_to, $subject, $body);

					//Send the mail
					$emailSent = true;
					
					echo '<bold>Je bericht is verstuurd.</bold>';
				endif;
					
				 ?>
		</div>
	
	</div>
	
	<hr>
	
		<div class="about-text">
			<h3>Laatste nieuws</h3>
			<?php
				$xml=simplexml_load_file("http://xml.app.envisic.nl/news.xml") or die("Error: Cannot create object");
				
				if($xml->important->message) :?>
					<div class="important-message">
						<?php echo $xml->important->message; ?><br>
						<?php if($xml->important->link): ?>
							<a href="<?=$xml->important->link; ?>" class="custom-button-link important-link" target="_new"><?=$xml->important->linktext; ?></a>
						<?php endif; ?>
					</div>
				<?php
				endif;
			
				if($xml->newsitem[0]->message) :?>
					<div class="news-message">
						<i><?=$xml->newsitem[0]->date; ?></i><br>
						<?=$xml->newsitem[0]->message; ?>
					</div>
				<?php endif; 
				
				if($xml->newsitem[1]->message) :?>
					<div class="news-message">
						<i><?=$xml->newsitem[1]->date; ?></i><br>
						<?=$xml->newsitem[1]->message; ?>
					</div>
				<?php endif; ?>
		</div>
		
		<?php if( current_user_can('administrator') ) {  ?>

			<hr>

			<div class="about-text">
				<h3>Developer</h3>
				<form method="post">
					<input name="bundle-css" id="bundle-css" type="hidden" value="true" />
					<input type="submit" id="submit-bundle" value="Bundle CSS" />
				</form>
				<?php 

				if(isset($_POST['bundle-css'] ) ){

					$theme_sub_style_sheet = get_field('config-theme', 'option');
					$template_uri = get_template_directory_uri();

					//Bundle CSS files
                    $cssFiles = [];

                    if($theme_sub_style_sheet !== 'base') :
                        $cssFiles = array(
                            '/css/includes/pre-base.css',
                            '/css/includes/vendor/flickity.css',
                            '/css/includes/vendor/simplelightbox.css',
                            '/css/includes/vendor/fancybox.css',
                            '/css/style.css',
                            '/css/themes/' . $theme_sub_style_sheet,
                            '/css/config.css',
                            '/css/override.css'
                        );
                    else :
                        $cssFiles = array(
                            '/css/includes/pre-base.css',
                            '/css/includes/vendor/flickity.css',
                            '/css/includes/vendor/simplelightbox.css',
                            '/css/includes/vendor/fancybox.css',
                            '/css/style.css',
                            '/css/config.css',
                            '/css/override.css'
                        );
                    endif;

					$buffer = "";

					foreach ($cssFiles as $cssFile) {

					    $cssFileContents = file_get_contents($template_uri . $cssFile);

					    if(strpos($cssFileContents, '@import') !== false ) :

                            $cssArray = explode('@im', $cssFileContents);

					        foreach($cssArray as $cssPart) :

                                if(strpos($cssPart, 'port url(') !== false ) :

                                    $startpos = 13;
                                    $length = strpos($cssPart, '")', $startpos) - $startpos;
                                    $importFile = substr($cssPart, $startpos, $length);
                                    $importFileFull = '/css/' . $importFile;
                                    $buffer .= ' ' . file_get_contents($template_uri . $importFileFull);
                                    $cssPartStripped = str_replace('port url("../' . $importFile . '");', '', $cssPart);

                                    $buffer .= ' ' . $cssPartStripped;

                                else :

                                    $buffer.= ' ' . $cssPart;

                                endif;

                            endforeach;

                        else :

                            $buffer .= ' ' . $cssFileContents;

                        endif;

					}
					//Remove comments
					$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
					//Remove space after colons
					$buffer = str_replace(': ', ':', $buffer);
					//Remove whitespace
					$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
					//rewrite the URL to icons font
					$buffer = str_replace("url('../../fonts/Icon", "url('fonts/Icon", $buffer);
					$file = get_template_directory() . '/bundled-min.css';
					file_put_contents($file, $buffer ) or print_r(error_get_last());
				};

				?>
			</div>
		
			<?php }; ?>

</div>

</div>

<style>
	
	.apex-version {
		max-width: 1120px;
		padding: 5px;
		text-align: right;
	}
	
	.envisic-dashboard-wrap {
		max-width: 1050px;
		padding: 40px;
		background: white;
		font-size: 16px;
		line-height: 28px;
	}
	
	hr {
		background: rgb(225,225,225);
		height: 1px;
		border: 0px;
		margin: 20px 0;
	}
	
	.column-wrap {
		display:flex;
		justify-content: space-between;
	}
	
	.column {
		flex: 1 1;
		max-width: 46%;
	}
	
	.column-wrap > div:nth-of-type(odd) {
		padding-right: 4%;
		width: 48%;
		border-right: 1px solid rgb(225,225,225);
	}
	
	a.custom-button-link {
		text-decoration: none;
		border: 1px solid rgb(225,225,225);
		border-radius: 3px;
		padding: 1px 3px;
		margin: 0 3px;
	}
	
	.custom-button-link:hover {
		background: rgba(0,0,0,0.05);
	}
	
	.hide-tab {
		display: none;
	}
	.custom-dashboard .about-wrap {
		background: white;
		padding: 50px;
	}
	
	.nav-tab-active {
		background: white;
		border-bottom: 1px solid white;
	}
	
	.icon {
		font-family: IconsFont;
	}
	
	textarea {
		min-width: 100%;
		border-radius: 3px;
		font-size: 16px;
		line-height: 22px;
		margin: 20px 0;
		display: block;
		resize: none;
	}
	
	.important-message {
		margin: 20px auto;
		padding: 15px;
		border: 1px solid rgb(225,225,225);
		border-top: 3px solid rgb(225, 10, 10);
	}
	
	a.important-link {
		display: inline-block;
		padding: 3px 10px;
		margin: 10px 0px;
	}
	
	.news-message {
		margin: 20px auto;
		padding: 15px;
		border: 1px solid rgb(225,225,225);
	}
	
	.news-message i {
		font-size: 0.9em;
	}
	
</style>

<script>
	
	jQuery(document).ready(function() {
		jQuery(".nav-tab").click(function() {
			jQuery(".nav-tab-active").removeClass("nav-tab-active");
			jQuery(this).addClass("nav-tab-active");
		});
		
		jQuery(".nav-tab-1").click(function() {
			jQuery(".tab").addClass("hide-tab");
			jQuery(".tab-1").removeClass("hide-tab");
			jQuery("nav-tab-active").removeClass("nav-tab-active");
			jQuery(this).addClass("nav-tab-active");
		});
		
		jQuery(".nav-tab-2").click(function() {
			jQuery(".tab").addClass("hide-tab");
			jQuery(".tab-2").removeClass("hide-tab");
		});
		
		jQuery(".nav-tab-3").click(function() {
			jQuery(".tab").addClass("hide-tab");
			jQuery(".tab-3").removeClass("hide-tab");
		});
		
		jQuery(".nav-tab-4").click(function() {
			jQuery(".tab").addClass("hide-tab");
			jQuery(".tab-4").removeClass("hide-tab");
		})
		
	});

</script>

