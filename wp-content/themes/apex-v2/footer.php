<footer itemscope itemtype="http://schema.org/WPFooter">
    <div class="footer-container bgc pri-color">

        <div class="footer-wrapper">

                <div class="footer-content footer-logo">
                    <a href="<?php echo site_url(); ?>" class="logo-link">
                        <?php
                        $logos = get_field('config-logo', 'option');
                        $sec_logo_url = $logos['secondary-logo'] ? $logos['secondary-logo'] : $logos['primary-logo']; ?>
                        <img src="<?=$sec_logo_url;?>" alt="<?php the_field('config-name', 'option'); ?>" />
                    </a>
                </div>

            <section class="row">
                <div class="footer-content block no-bgc colspan-3 footer-nav-col footer-nav-col-1">
                    <span class="footer-menu-title"><?=wp_get_nav_menu_name('footer-nav-col-1')?></span>
                    <?php wp_nav_menu( array(
                        'theme_location' => 'footer-nav-col-1',
                        'container_class' => 'nav-wrap' ) );
                    ?>
                </div>

                <div class="footer-content block no-bgc colspan-3 footer-nav-col footer-nav-col-2">
                    <span class="footer-menu-title"><?=wp_get_nav_menu_name('footer-nav-col-2')?></span>
                    <?php wp_nav_menu( array(
                        'theme_location' => 'footer-nav-col-2',
                        'container_class' => 'nav-wrap' ) );
                    ?>
                </div>

                <div class="footer-content block no-bgc colspan-3 footer-nav-col footer-nav-col-3">
                    <span class="footer-menu-title"><?=wp_get_nav_menu_name('footer-nav-col-3')?></span>
                    <?php wp_nav_menu( array(
                        'theme_location' => 'footer-nav-col-3',
                        'container_class' => 'nav-wrap' ) );
                    ?>
                </div>

                <div class="footer-content block no-bgc colspan-3 footer-nav-col footer-nav-col-4">
                    <span class="footer-menu-title"><?=wp_get_nav_menu_name('footer-nav-col-4')?></span>
                    <?php wp_nav_menu( array(
                        'theme_location' => 'footer-nav-col-4',
                        'container_class' => 'nav-wrap' ) );
                    ?>
                </div>

            </section>

            <div class="envisic"></div>
        </div>
    </div>

    <div class="footer-container">

        <div class="footer-wrapper bottom-footer">
            <span>©<?php echo date('Y')?> Apex Miniaturen</span><span><a href="/algemene-voorwaarden" rel="nofollow">Algemene Voorwaarden zijn van toepassing</a></span><span><a href="/privacyverklaring" rel="nofollow">Lees onze privacyverklaring.</a></span><span>Alle prijzen zijn exclusief BTW en verzendkosten, tenzij anders aangegeven</span><span>Realisatie: <a href="http://www.envisic.nl">Envisic.</a></span>
        </div>

    </div>
	
</footer>

<?php wp_footer(); ?>

<?php  get_template_part('scripts'); ?>
	
	
<div class="support-warning"><div class="support-inner"><img src="<?php echo get_template_directory_uri(); ?>/img/support-error-icon.png" class="support-error-image" alt="Browser niet ondersteund"/><span class="h1">Uw browser is verouderd</span>Hierdoor kan de website die u wilt bezoeken niet (goed) worden weergegeven. Ook is werkt uw huidige browser niet meer volgens de laatste veiligheidseisen. 
Update uw browser. Heeft u al een andere browser zoals Chrome of Firefox geïnstalleerd? Gebruik dan uw andere browser om deze website te bezoeken.</div>
</div></div>

<?php
    if(get_field('use-cookiealert', 'option')) :

        $tracking_cookies_settings = get_field('trackingcookies', 'option');

        if(!isset($_COOKIE['gdpr-appliance'])) :

            $tracking_cookie_json = '{"gdpr-all" : false, ';
            $tracking_settings = "";

            if($tracking_cookies_settings) :
                foreach($tracking_cookies_settings as $cookie ) :
                    $tracking_cookie_json.= '"' . $cookie['tracking-name'] . '" : false,';
                    $tracking_settings.= "<div class='tracking-option' data-service='" . $cookie['tracking-name'] . "'><span class='name'>" . $cookie['name'] . "</span><span class='description'>" . $cookie['description'] . "</span><span class='switch'></span></div>";
                endforeach;
            endif;

            $tracking_cookie_json.="}";

            ?>

            <div class="cookie-wrap on bgc pri-color">
                <div class="main-cookie-setting on">
                <div class="cookie-text">
                    <?php the_field('cookiealert-text', 'option'); ?>
                </div>

                <div class="button-container">
                    <div class="button open accept-all-cookies"><span class="cta-icon" data-icon="&#xf17b;"></span> Accepteren</div>
                    <?php if($tracking_cookies_settings) : ?>
                        <div class="button open set-cookie-settings"><span class="cta-icon" data-icon="&#xf19b;"></span>Instellingen wijzigen</div>
                    <?php endif; ?>
                </div>
                </div>
                <div class="tracking">
                    <?=$tracking_settings ;?>
                    <div class="button-container">
                        <div class="button open save-cookie-settings"><span class="cta-icon" data-icon="&#xf19b;"></span>Instellingen opslaan en accepteren</div>
                    </div>
                </div>

                <script>
                    let trackingJSON = <?php echo $tracking_cookie_json; ?>;

                    window.addEventListener('load', function () {

                        jQuery('.accept-all-cookies').click(function () {
                            trackingJSON['gdpr-all'] = true;
                            document.cookie = "gdpr-appliance=" + JSON.stringify(trackingJSON) + "; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
                            jQuery('.cookie-wrap').removeClass('on');
                        });

                        jQuery('.tracking .switch').click(function () {
                            let service = jQuery(this).parent('.tracking-option').attr('data-service');
                            if(trackingJSON[service]) {
                                trackingJSON[service] = false
                            } else {
                                trackingJSON[service] = true
                            }
                            document.cookie = "gdpr-appliance=" + JSON.stringify(trackingJSON) + "; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
                        });

                        jQuery('.set-cookie-settings, .save-cookie-settings').click(function () {
                            jQuery('.tracking').toggleClass('on');
                            jQuery('.main-cookie-setting').toggleClass('on');
                        });

                        jQuery('.save-cookie-settings').click(function () {
                            jQuery('.on').removeClass('on');
                        });

                        jQuery('.switch').click(function () {
                            jQuery(this).toggleClass('on');
                        });
                    })

                </script>
            </div>
        <?php
        else :

            $cookie_data = json_decode(stripslashes($_COOKIE['gdpr-appliance']));
            $cookie_array = (array) $cookie_data;

            if($tracking_cookies_settings) :
                if($cookie_array['gdpr-all']) :
                    foreach($tracking_cookies_settings as $cookie ) :
                        echo $cookie['script'];
                    endforeach;
                else:
                    foreach($tracking_cookies_settings as $cookie ) :
                        if( $cookie_array[$cookie['tracking-name']] ) :
                            echo $cookie['script'];
                        endif;
                    endforeach;
                endif;
            endif;
        endif;
    endif;
    ?>

</body>
</html>