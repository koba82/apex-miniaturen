<?php 
$form_source = get_sub_field('form-source');

//Create some variables
$field_counter = 1; $field_type = array(); $field_label = array(); $body = array(); $id = $args['uid']; ?>

            <div class="flex-form-wrap" id="form-id-<?=$id;?>">

                <?php get_template_part('/blocks/components/header-and-text'); ?>

                <form method="post" action="<?php echo the_permalink(); ?>#form-id-<?=$id;?>">

                    <?php
                    if ( have_rows( 'flex-form-fields' ) ) :

                        while ( have_rows( 'flex-form-fields' ) ) : the_row();

                            $req_field = (get_sub_field('flex-form-field-required')) ? "required" : ""; ?>

                            <?php
                            if(get_sub_field('flex-form-field-type') == "select") : ?>

                                <div class="flex-field-wrap">
                                    <label for="field-<?=$field_counter;?>" class="field-<?=$field_counter;?> <?php the_sub_field('flex-form-field-type'); ?>-field<?php if($req_field) : ?> required-field <?php endif; ?>"><?php the_sub_field('flex-form-field-label'); ?></label>
                                    <select id="field-<?=$field_counter;?>" name="field-<?=$field_counter;?>" <?=$req_field;?>>
                                        <?php
                                        if(get_sub_field('select-options')):
                                            $options = get_sub_field('select-options');
                                            foreach($options as $single_option): ?>
                                                <option>
                                                    <?=$single_option['select-option']; ?>
                                                </option>
                                            <?php
                                            endforeach;
                                        endif; ?>
                                    </select>
                                </div>
                                <?php
                                //Add current field type to field_type array
                                $field_type[$field_counter] = get_sub_field('flex-form-field-type');

                                //Add current label to field_label array
                                $field_label[$field_counter] = get_sub_field('flex-form-field-label');

                                $field_counter++ ;

                            elseif(get_sub_field('flex-form-field-type') == "textarea") : ?>
                                <div class="flex-field-wrap">
                                    <label for="field-<?=$field_counter;?>" class="field-<?=$field_counter;?> <?php the_sub_field('flex-form-field-type'); ?>-field<?php if($req_field) { ?> required-field <?php }; ?>"><?php the_sub_field('flex-form-field-label'); ?></label>
                                    <textarea id="field-<?=$field_counter;?>" name="field-<?=$field_counter;?>" <?=$req_field;?> rows="4"></textarea>
                                </div>
                                <?php

                                //Add current field type to field_type array
                                $field_type[$field_counter] = get_sub_field('flex-form-field-type');

                                //Add current label to field_label array
                                $field_label[$field_counter] = get_sub_field('flex-form-field-label');

                                $field_counter++ ;

                            else : ?>
                                <div class="flex-field-wrap">
                                    <label for="field-<?=$field_counter;?>" class="field-<?=$field_counter;?> <?php the_sub_field('flex-form-field-type'); ?>-field<?php if($req_field) { ?> required-field <?php }; ?>"><?php the_sub_field('flex-form-field-label'); ?></label>
                                    <input id="field-<?=$field_counter;?>" name="field-<?=$field_counter;?>" type="<?php the_sub_field('flex-form-field-type'); ?>" <?=$req_field;?>>

                                </div>
                                <?php
                                //Add current field type to field_type array
                                $field_type[$field_counter] = get_sub_field('flex-form-field-type');

                                //Add current label to field_label array
                                $field_label[$field_counter] = get_sub_field('flex-form-field-label');

                                $field_counter++ ;
                            endif;

                        endwhile;
                    endif; ?>

                    <?php
                    //Custom send button text
                    if(get_sub_field('flex-form-alt-send')) {
                        $send_text = get_sub_field('flex-form-alt-send');
                    } else {
                        $send_text = 'Verzenden';
                    } ?>

                    <div class="g-recaptcha" data-sitekey="<?php the_field("recaptcha_site_key", "options"); ?>"></div>
                    <div class="button-container">
                        <input type="submit" name="submit" id="recaptcha-submit" value="<?=$send_text;?>" class="button" />
                    </div>

                </form>
            </div>

<?php	

	if ($_SERVER['REQUEST_METHOD'] == 'POST') :
		
		// your secret key
		$secret_key = get_field("recaptcha_secret_key", "options");
		$remote_ip = $_SERVER['REMOTE_ADDR'];
		$captcha;
		
		// get captcha response
		if(isset($_POST['g-recaptcha-response'])){
			$captcha=$_POST['g-recaptcha-response'];
		};
		
		// Error message: if captcha response is empty
		if(!$captcha){
			echo '<div class="flex-form-success-wrap flex-form-success-show">
				<div class="flex-form-success">
					<div class="flex-form-error-icon" data-icon="&#xf1cf;"></div>
					<p>Vink het reCaptcha vinkje aan</p>
					<div class="button flex-form-close-button">Sluiten</div>
				</div>
			</div>';
		};
			
		$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret_key."&response=".$captcha."&remoteip=".$ip);
		$responseKeys = json_decode($response,true);
		
		//Error message: if captcha response is not success
		if(intval($responseKeys["success"]) !== 1) :
			echo '<div class="flex-form-success-wrap flex-form-success-show">
				<div class="flex-form-success">
					<div class="flex-form-error-icon" data-icon="&#xf1cf;"></div>
					<p>Vink het reCaptcha vinkje aan.</p>
					<div class="button flex-form-close-button">Sluiten</div>
				</div>
			</div>';
		
		//If captach response is success, we construct the mail
		else :
			
			//Get mailto from the flex item, if not set we get the mailto from options page
			$email_to = (get_sub_field('flex-form-alt-email')) ? get_sub_field('flex-form-alt-email') : get_field('config-email', 'option');

			$reply_to = $email_to;
			$body;
			$body_item = array();
			
			//Loop through all fields and store the label + user input in body array
			for ($i = 1; $i <= $field_counter; $i++) {
				
				$body_item[$i] = $_POST['field-' . $i];
				$body[$i] = $field_label[$i] . ' :' . $body_item[$i];
				
					$reply_to = ($field_type[$i] == 'email') ? $body_item[$i] : $email_to;
			}	
			
			$subject = 'E-mail van website:' . get_field('config-name', 'option');
			
			//Convert body array to text and add the permalink of the current page		
			$body = implode("<br />",$body) . "<br /><br /> Verzonden vanaf:" . get_permalink();

			function send_my_mail($email_to, $subject, $body) {

				//Send the mail
				add_filter( 'wp_mail_content_type','set_my_mail_content_type' );
				add_action( 'phpmailer_init', 'send_smtp_email' );
			
				    return wp_mail( $email_to, $subject, $body);

				remove_filter( 'wp_mail_content_type','set_my_mail_content_type' );
				remove_action( 'phpmailer_init', 'send_smtp_email' );
			
			}

			$emailSent = false;
            $emailSent = send_my_mail($email_to, $subject, $body);
			
			//Show success message
            if($emailSent) :
			    echo '<div class="flex-form-success-wrap flex-form-success-show"><div class="flex-form-success"><div class="flex-form-success-icon" data-icon="&#xf1a1;"></div><p>' . get_sub_field('flex-form-success-message') . '</p><div class="button flex-form-close-button">Sluiten</div></div></div>';
            else :
                echo '<div class="flex-form-success-wrap flex-form-success-show"><div class="flex-form-success"><div class="flex-form-success-icon" data-icon="&#xf1a1;"></div><p>Er is iets fout gegaan bij het versturen van de mail. Neem contact op met de site beheerder.</p><div class="button flex-form-close-button">Sluiten</div></div></div>';
            endif;
                // Recaptcha if/else
		endif;
	endif;
	
	?>

<script>
    window.addEventListener('load', function () {
        $(".flex-form-close-button").click(function() {
            $(".flex-form-success-wrap").removeClass('flex-form-success-show');
        });

        jQuery(document).ready(function() {
            loadRecaptcha('#form-id-<?=$id;?>', 0)
        });

        jQuery(document).scroll(function() {
            loadRecaptcha('#form-id-<?=$id;?>', 0)
        });
    });
</script>