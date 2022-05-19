<?php

const APEX_MAIN_VERSION = "2";
const APEX_SUB_VERSION = ".BETA";
const APEX_VERSION_DATE = "4-2-2022";

//Add the acf_form_head the the admin header. Needed to make acf_form work.
//function add_acf_form_head_to_header() {
//	acf_form_head();
//}
//add_action( 'admin_head', 'add_acf_form_head_to_header' );

//**********************************************************************************************************************
//	Use classic editor instead of Gutenberg
//**********************************************************************************************************************

		add_filter('use_block_editor_for_post', '__return_false');

//**********************************************************************************************************************
//	Include ACF plugin
//**********************************************************************************************************************

	add_filter('acf/settings/path', 'my_acf_settings_path');

	function my_acf_settings_path( $path ) {
	    $path = get_template_directory_uri() . '/plugin/advanced-custom-fields-pro/';
	    return $path;
	}
	add_filter('acf/settings/dir', 'my_acf_settings_dir');

	function my_acf_settings_dir( $dir ) {
	    $dir = get_template_directory_uri() . '/plugin/advanced-custom-fields-pro/';
	    return $dir;
	}

	include_once( get_template_directory() . '/plugin/advanced-custom-fields-pro/acf.php' );


//**********************************************************************************************************************
//	Include other plugins
//**********************************************************************************************************************

	include_once( get_template_directory() . '/plugin/envisic-custom-dashboard/envisic-custom-dashboard.php' );
	include_once( get_template_directory() . '/plugin/advanced-custom-fields-table-field/acf-table.php' );



//**********************************************************************************************************************
//	Remove Emojicons
//**********************************************************************************************************************

	function disable_wp_emojicons() {

		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );


		add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
	}

	add_action( 'init', 'disable_wp_emojicons' );

	function disable_emojicons_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}


//**********************************************************************************************************************
//	Load stylesheets
//**********************************************************************************************************************

	// Load module stylesheets
	if ( ! function_exists( 'theme_enqueue_module_styles' ) ) {
		function theme_enqueue_module_styles() {
			if(get_sub_field('module-real-estate', 'option') == "true" ) :
				wp_enqueue_style( 'module-real-estate', get_template_directory_uri() .'/modules/module-real-estate/module-real-estate.css', array(), false, 'all');
			endif;
		}
		add_action( 'wp_enqueue_scripts', 'theme_enqueue_module_styles' );
	};

	// Load Google Fonts for backend display
	if ( ! function_exists( 'enqueue_goolge_fonts_backend' ) ) {
		function enqueue_goolge_fonts_backend() {

			wp_enqueue_style( 'google-fonts-Open-sans', 'https://fonts.googleapis.com/css?family=Open+Sans:400' , array(), false, 'all');
			wp_enqueue_style( 'google-fonts-Merriweather', 'https://fonts.googleapis.com/css?family=Merriweather:400' , array(), false, 'all');
			wp_enqueue_style( 'google-fonts-Roboto', 'https://fonts.googleapis.com/css?family=Roboto:400' , array(), false, 'all');
			wp_enqueue_style( 'google-fonts-Playfair', 'https://fonts.googleapis.com/css?family=Playfair+Display:400' , array(), false, 'all');
			wp_enqueue_style( 'google-fonts-Montserrat', 'https://fonts.googleapis.com/css?family=Montserrat+Alternates:400' , array(), false, 'all');
			wp_enqueue_style( 'google-fonts-Playfair', 'https://fonts.googleapis.com/css?family=Playfair+Display:400' , array(), false, 'all');
			wp_enqueue_style( 'google-fonts-Spectral', 'https://fonts.googleapis.com/css?family=Spectral:400' , array(), false, 'all');
			wp_enqueue_style( 'google-fonts-Josefin', 'https://fonts.googleapis.com/css?family=Josefin+Slab:400' , array(), false, 'all');
			wp_enqueue_style( 'google-fonts-Arima', 'https://fonts.googleapis.com/css?family=Arima+Madurai:400' , array(), false, 'all');
			wp_enqueue_style( 'google-fonts-Dancing+Script', 'https://fonts.googleapis.com/css?family=Dancing+Script:400' , array(), false, 'all');
			wp_enqueue_style( 'google-fonts-Trirong', 'https://fonts.googleapis.com/css?family=Trirong:400' , array(), false, 'all');
			wp_enqueue_style( 'google-fonts-Zilla+Slab', 'https://fonts.googleapis.com/css?family=Zilla+Slab:400' , array(), false, 'all');
			wp_enqueue_style( 'google-fonts-Arima', 'https://fonts.googleapis.com/css?family=Arima+Madurai:400' , array(), false, 'all');
			wp_enqueue_style( 'google-fonts-Zilla+Slab', 'https://fonts.googleapis.com/css?family=Zilla+Slab:400' , array(), false, 'all');
			wp_enqueue_style( 'google-fonts-Nunito', 'https://fonts.googleapis.com/css?family=Nunito:400' , array(), false, 'all');
			wp_enqueue_style( 'google-fonts-Montserrat', 'https://fonts.googleapis.com/css?family=Montserrat:400' , array(), false, 'all');
			wp_enqueue_style( 'google-fonts-Raleway', 'https://fonts.googleapis.com/css?family=Raleway:400' , array(), false, 'all');
			wp_enqueue_style( 'google-fonts-Permanent-marker', 'https://fonts.googleapis.com/css?family=Permanent+Marker' , array(), false, 'all');
			wp_enqueue_style( 'google-fonts-Pacifico', 'https://fonts.googleapis.com/css?family=Pacifico' , array(), false, 'all');

		}
	  add_action( 'admin_enqueue_scripts', 'enqueue_goolge_fonts_backend' );
	};

	//Remove Gutenberg block styles
	add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );
	function wps_deregister_styles() {
		wp_dequeue_style( 'wp-block-library' );
	}

//**********************************************************************************************************************
//	Load stylesheets (bundled or developer mode)
//**********************************************************************************************************************

	if ( !function_exists( 'theme_enqueue_styles' )) :

		function theme_enqueue_styles() {

			$developer_mode = get_field('dev-mode', 'option');

			if($developer_mode) :

				$theme_sub_style_sheet = get_field('config-theme', 'option');
				wp_enqueue_style( 'pre-base', get_template_directory_uri() .'/css/includes/pre-base.css', array(), false, 'all');
				wp_enqueue_style( 'flickity', get_template_directory_uri() .'/css/includes/vendor/flickity.css', array(), false, 'all');
				wp_enqueue_style( 'simple-lightbox', get_template_directory_uri() .'/css/includes/vendor/simplelightbox.css', array(), false, 'all');
				wp_enqueue_style( 'fancybox', get_template_directory_uri() .'/css/includes/vendor/fancybox.css', array(), false, 'all');
				wp_enqueue_style( 'style', get_template_directory_uri() .'/css/style.css', array(), false, 'all');
				if($theme_sub_style_sheet !== 'base') :
				    wp_enqueue_style( 'sub-theme-style', get_template_directory_uri() .'/css/themes/' . $theme_sub_style_sheet, array(), false, 'all');
				endif;
                wp_enqueue_style( 'config', get_template_directory_uri() .'/css/config.css', array(), false, 'all');
				wp_enqueue_style( 'override', get_template_directory_uri() .'/css/override.css', array(), false, 'all');

			else :

				wp_enqueue_style( 'bundled-css', get_template_directory_uri() .'/bundled-min.css', array(), false, 'all');

			endif;
		};

		add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

	endif;


//**********************************************************************************************************************
//	Load admin style & javascript
//**********************************************************************************************************************

	function apex_theme_style() {
		wp_enqueue_style('apex-admin-theme', get_template_directory_uri() . '/admin-style.css', __FILE__);
	}
	add_action('admin_enqueue_scripts', 'apex_theme_style');
	add_action('login_enqueue_scripts', 'apex_theme_style');

	if ( ! function_exists( 'enqueue_admin_javascript' ) ) {
		function enqueue_admin_javascript() {
			wp_enqueue_script( 'admin-js', get_template_directory_uri() . '/js/admin.js', array(), false, false );
		}
	  add_action( 'admin_enqueue_scripts', 'enqueue_admin_javascript' );
	};


//**********************************************************************************************************************
//	Custom image sizes
//**********************************************************************************************************************

	if ( ! function_exists( 'add_custom_image_sizes' ) ) {
	    function add_custom_image_sizes() {
			add_image_size( 'image-gallery-thumbnail-size', 250, 250, true );
			add_image_size( 'main-image-size', 1300, 975 );
            add_image_size( 'image-1066', 1066, 800 );
            add_image_size( 'image-800', 800, 600 );
            add_image_size( 'image-560', 560, 420 );
            add_image_size( 'image-400', 400, 300 );
            add_image_size( 'image-320', 320, 240 );
			add_image_size( 'front-end-thumb', 550, 550, true );
			add_image_size( 'back-end-thumb', 30, 30, true );

			// Header/Hero image sizes
			add_image_size( 'hero-2500', 2500, 1260, true );
			add_image_size( 'hero-1980', 1980, 1080, true );
			add_image_size( 'hero-1280', 1280, 1000, true );
			add_image_size( 'hero-770', 770, 500, true );
			add_image_size( 'hero-640', 640, 300, true );
			add_image_size( 'hero-480', 480, 300, true );
	    }
		add_custom_image_sizes();
	}

//**********************************************************************************************************************
//	Front-end image customisation
//**********************************************************************************************************************

	//Remove image links by default
	function wpb_imagelink_setup() {
		$image_set = get_option( 'image_default_link_type' );
			if ($image_set !== 'none') {
				update_option('image_default_link_type', 'none');
			}
	}
	add_action('admin_init', 'wpb_imagelink_setup', 10);

    //Allow SVG
    add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {

        global $wp_version;
        if ( $wp_version !== '4.7.1' ) {
            return $data;
        }

        $filetype = wp_check_filetype( $filename, $mimes );

        return [
            'ext'             => $filetype['ext'],
            'type'            => $filetype['type'],
            'proper_filename' => $data['proper_filename']
        ];

    }, 10, 4 );

    function cc_mime_types( $mimes ){
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }
    add_filter( 'upload_mimes', 'cc_mime_types' );

    function fix_svg() {
        echo '<style type="text/css">
            .attachment-266x266, .thumbnail img {
                 width: 100% !important;
                 height: auto !important;
            }
            </style>';
    }
    add_action( 'admin_head', 'fix_svg' );



//**********************************************************************************************************************
//	ACF options page
//**********************************************************************************************************************

	if( function_exists('acf_add_options_page') ) {

		acf_add_options_page(array(
			'page_title' 	=> 'Configuratie',
			'menu_title'	=> 'Configuratie',
			'menu_slug' 	=> 'theme-general-settings',
			'capability'	=> 'edit_posts',
			'redirect'		=> false
		));

	}


//**********************************************************************************************************************
//	Remove menu's, widgets, links etc from admin
//**********************************************************************************************************************

	//Remove menu's
	if( ! function_exists( 'remove_menus' ) ) {
        if( ! current_user_can('administrator') ) {
            function remove_menus()
            {
                //remove_menu_page( 'index.php' );
                remove_submenu_page('index.php', 'update-core.php');    //Update
                remove_submenu_page('index.php', 'index.php');          //index submenu
                remove_menu_page('edit.php');                           //Posts
                remove_menu_page('edit-comments.php');                  //Comments
            }

            add_action('admin_menu', 'remove_menus');
        }
	};

	//Remove tools menu only if current user is not administrator
	if( ! current_user_can('administrator') ) {
		function remove_tools_menu() {
			remove_menu_page( 'tools.php' );                               //Tools
		};
		add_action( 'admin_menu', 'remove_tools_menu' );
	}


	//Remove dashboard widgets
	if( ! function_exists( 'remove_dashboard_meta' ) ) {
	  function remove_dashboard_meta() {
			  $user = wp_get_current_user();
			  if (!$user -> has_cap ('manage_options'))
			  remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
			  remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
			  remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
			  remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
			  remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
			  remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
			  remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
			  remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
			  remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
		  }
	  add_action( 'admin_init', 'remove_dashboard_meta' );
	};

	//Remove columns from posts/pages overview page (Page table)
	if( ! function_exists( 'custom_column_init' ) ) {
        if( ! current_user_can('administrator') ) {
            function my_manage_columns($columns)
            {
                unset($columns['comments']);    //Comments
                unset($columns['author']);    //Author
                unset($columns['cb']);        //Checkbox
                return $columns;
            }

            function custom_column_init()
            {
                add_filter('manage_posts_columns', 'my_manage_columns');
                add_filter('manage_pages_columns', 'my_manage_columns');
            }

            add_action('admin_init', 'custom_column_init');
        }
	};

	// Remove personal options from profile page, removes the `profile.php` admin color scheme options
	remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
	if ( ! function_exists( 'rdm_remove_personal_options' ) ) {
		// removes the leftover 'Visual Editor', 'Keyboard Shortcuts' and 'Toolbar' options.
		function rdm_remove_personal_options( $subject ) {
			$subject = preg_replace( '#<h3>Personal Options</h3>.+?/table>#s', '', $subject, 1 );
			return $subject;
		}
		function rdm_profile_subject_start() {
			ob_start( 'rdm_remove_personal_options' );
		}
		function rdm_profile_subject_end() {
			ob_end_flush();
		}
	}
	add_action( 'admin_head-profile.php', 'rdm_profile_subject_start' );
	add_action( 'admin_footer-profile.php', 'rdm_profile_subject_end' );
	class RDM_User_Caps {
	// add some filters
	function RDM_User_Caps(){
		add_filter( 'editable_roles', array(&$this, 'editable_roles'));
		add_filter( 'map_meta_cap', array(&$this, 'map_meta_cap'),10,4);
	}

	// remove 'Administrator' from the list of roles if the current user is not an admin
	function editable_roles( $roles ){
		if( isset( $roles['administrator'] ) && !current_user_can('administrator') ){
		unset( $roles['administrator']);
	}
	return $roles;
	}

	// don't allow users to edit or delete unless they are an admin
	function map_meta_cap( $caps, $cap, $user_id, $args ){
		switch( $cap ){
			case 'edit_user':
			case 'remove_user':
			case 'promote_user':
				if( isset($args[0]) && $args[0] == $user_id )
				break;
				elseif( !isset($args[0]) )
					$caps[] = 'do_not_allow';
					$other = new WP_User( absint($args[0]) );
					if( $other->has_cap( 'administrator' ) ){
						if(!current_user_can('administrator')){
							$caps[] = 'do_not_allow';
						}
					}
				break;
			case 'delete_user':
			case 'delete_users':
				if( !isset($args[0]) )
				break;
				$other = new WP_User( absint($args[0]) );
				if( $other->has_cap( 'administrator' ) ){
				if(!current_user_can('administrator')){
				$caps[] = 'do_not_allow';
				}
				}
			break;
			default:
			break;
			}
			return $caps;
		}
	}
	$rdm_user_caps = new RDM_User_Caps();

	// Customize admin menu bar items
	function mytheme_admin_bar_render() {
		global $wp_admin_bar;

		// Remove an existing link using its $id
		$wp_admin_bar->remove_menu('updates');
		$wp_admin_bar->remove_menu('comments');
		$wp_admin_bar->remove_menu('new-content');
		$wp_admin_bar->remove_node( 'wp-logo');

		// Add a new top level menu link
		// Here we add a customer support URL link

		//$customerSupportURL = 'http://help.eenvoudigonline.nl/';
		//$wp_admin_bar->add_menu( array(
		//'parent' => false,
		//'id' => 'customer_support',
		//'title' => __('Hulp nodig? Klik hier'),
		//'href' => $customerSupportURL
		//));

		// Add a new sub-menu to the link above
		$contactUsURL = 'http://www.envisic.nl/';
		$wp_admin_bar->add_menu(array(
			'parent' => 'customer_support',
			'id' => 'contact_us',
			'title' => __('Neem contact op met Envisic'),
			'href' => $contactUsURL
		));
	}
       // Finally we add our hook function
       add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );


//**********************************************************************************************************************
//	Create sitemap
//**********************************************************************************************************************

	add_action( "save_post", "eg_create_sitemap" );
	function eg_create_sitemap() {
	    if ( str_replace( '-', '', get_option( 'gmt_offset' ) ) < 10 ) {
		$tempo = '-0' . str_replace( '-', '', get_option( 'gmt_offset' ) );
	    } else {
		$tempo = get_option( 'gmt_offset' );
	    }
	    if( strlen( $tempo ) == 3 ) { $tempo = $tempo . ':00'; }
	    $postsForSitemap = get_posts( array(
		'numberposts' => -1,
		'orderby'     => 'modified',
		'post_type'   => array( 'post', 'page', 'product' ),
		'order'       => 'DESC'
	    ) );
	    $sitemap .= '<?xml version="1.0" encoding="UTF-8"?>' . '<?xml-stylesheet type="text/xsl" href="' .
		esc_url( home_url( '/' ) ) . 'sitemap.xsl"?>';
	    $sitemap .= "\n" . '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
	    $sitemap .= "\t" . '<url>' . "\n" .
		"\t\t" . '<loc>' . esc_url( home_url( '/' ) ) . '</loc>' .
		"\n\t\t" . '<lastmod>' . date( "Y-m-d\TH:i:s", current_time( 'timestamp', 0 ) ) . $tempo . '</lastmod>' .
		"\n\t\t" . '<changefreq>daily</changefreq>' .
		"\n\t\t" . '<priority>1.0</priority>' .
		"\n\t" . '</url>' . "\n";
	    foreach( $postsForSitemap as $post ) {
		setup_postdata( $post);
		$postdate = explode( " ", $post->post_modified );
		$sitemap .= "\t" . '<url>' . "\n" .
		    "\t\t" . '<loc>' . get_permalink( $post->ID ) . '</loc>' .
		    "\n\t\t" . '<lastmod>' . $postdate[0] . 'T' . $postdate[1] . $tempo . '</lastmod>' .
		    "\n\t\t" . '<changefreq>Weekly</changefreq>' .
		    "\n\t\t" . '<priority>0.5</priority>' .
		    "\n\t" . '</url>' . "\n";
	    }
	    $sitemap .= '</urlset>';
	    $fp = fopen( ABSPATH . "sitemap.xml", 'w' );
	    fwrite( $fp, $sitemap );
	    fclose( $fp );
	}

//**********************************************************************************************************************
//	Custom WYSIWYG toolbar
//**********************************************************************************************************************

	if( ! function_exists( 'custom_toolbars' ) ) {
		add_filter( 'acf/fields/wysiwyg/toolbars' , 'custom_toolbars'  );
		function custom_toolbars( $toolbars ) {
			// Uncomment to view format of $toolbars
			// echo '< pre >'; print_r($toolbars); echo '< /pre >'; die;

			// Add a new toolbar called "Very Simple"
			// - this toolbar has only 1 row of buttons
			$toolbars['Very Simple' ] = array();
			$toolbars['Very Simple' ][1] = array('bold' , 'italic' , 'link', 'unlink', 'bullist', 'numlist', 'charmap', 'undo' );
			$toolbars['Table' ] = array();
			$toolbars['Table' ][1] = array('bold' , 'italic' , 'link', 'unlink', 'wp_more' );

			// Edit the "Full" toolbar and remove 'code'
			// - delet from array code from http://stackoverflow.com/questions/7225070/php-array-delete-by-value-not-key
			if( ($key = array_search('code' , $toolbars['Full' ][2])) !== false ) {
				unset( $toolbars['Full' ][2][$key] );
			}

			// remove the 'Basic' toolbar completely
			unset( $toolbars['Basic' ] );

			// return $toolbars - IMPORTANT!
			return $toolbars;
		}
	};


//**********************************************************************************************************************
//	Remove toolbar from top of page when logged in
//**********************************************************************************************************************

	function remove_admin_login_header() {
		remove_action('wp_head', '_admin_bar_bump_cb');
	}
	add_action('get_header', 'remove_admin_login_header');

//**********************************************************************************************************************
//	Admin page customisation
//**********************************************************************************************************************

	//Rename 'Default Template', or 'Standaard template' in Dutch, to custom title
	function filter_function_name( $label, $context ) {
	  return __( 'Selecteer paginatype', 'meta-box' );
	}
	//add_filter( 'default_page_template_title', 'filter_function_name', 10, 2 );

	//Custom login logo
	function my_login_logo() { ?>
		<style type="text/css">
			.login h1 a {
				background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/login-logo.svg);
				width: 310px;
				height: 104px;
				background-size: contain !important;
				-webkit-background-size: contain !important;
				margin: 0 !important;
			}
		</style>
	<?php }
	add_action( 'login_enqueue_scripts', 'my_login_logo' );

	//Custom login link
	function my_login_logo_url() {
		return home_url();
	}
	add_filter( 'login_headerurl', 'my_login_logo_url' );

	function my_login_logo_url_title() {
	    return 'Envisic Print + Web';
	}
	add_filter( 'login_headertitle', 'my_login_logo_url_title' );

	// Customizing meta box names
    if( ! current_user_can('administrator') ) {
        function my_remove_meta_boxes()
        {
            remove_meta_box('pageparentdiv', 'post', 'side');
            remove_meta_box('postimagediv', 'post', 'side');
            add_meta_box('pageparentdiv', __('Pagina eigenschappen'), 'page_attributes_meta_box', 'post', 'normal', 'high');
        }

        add_action('admin_menu', 'my_remove_meta_boxes');
        //add_filter('upload_mimes', 'custom_upload_mimes');
    }
	// Add role class to body
	function add_role_to_body($classes) {

		global $current_user;
		$user_role = array_shift($current_user->roles);

		$classes .= 'role-'. $user_role;
		return $classes;
	}
	add_filter('body_class','add_role_to_body');
	add_filter('admin_body_class', 'add_role_to_body');

	//Add button to publish metabox
	add_action( 'post_submitbox_misc_actions', 'custom_button' );

        function custom_button()
        {
            $html = '<div id="major-publishing-actions" style="overflow:hidden">';
            $html .= '<div id="publishing-action">';
            $html .= '<div class="button-grey more-publishing-options" >Meer opties</div>';
            $html .= '</div>';
            $html .= '</div>';
            echo $html;
        }


//**********************************************************************************************************************
//	Duplicate post/page
//**********************************************************************************************************************

	function rd_duplicate_post_as_draft(){
		global $wpdb;
		if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
			wp_die('No post to duplicate has been supplied!');
		}

		// Nonce verification
		if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) )
			return;

		//get the original post id
		$post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );

		//and all the original post data then
		$post = get_post( $post_id );

		//if you don't want current user to be the new post author, then change next couple of lines to this: $new_post_author = $post->post_author;
		$current_user = wp_get_current_user();
		$new_post_author = $current_user->ID;

		//if post data exists, create the post duplicate
		if (isset( $post ) && $post != null) {

		//new post data array
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);

		//insert the post by wp_insert_post() function
		$new_post_id = wp_insert_post( $args );

		//get all current post terms ad set them to the new post draft
		$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
			wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}

		//duplicate all post meta just in two SQL queries
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				if( $meta_key == '_wp_old_slug' ) continue;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}


			//finally, redirect to the edit post screen for the new draft
			wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
			exit;
		} else {
			wp_die('Post creation failed, could not find original post: ' . $post_id);
		}
	}
	add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );

	//Add the duplicate link to action list for post_row_actions
	function rd_duplicate_post_link( $actions, $post ) {
		if (current_user_can('edit_posts')) {
			$actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=rd_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '" title="Duplicate this item" rel="permalink">Dupliceren</a>';
		}
		return $actions;
	}

	add_filter( 'post_row_actions', 'rd_duplicate_post_link', 10, 2 );
	add_filter( 'page_row_actions', 'rd_duplicate_post_link', 10, 2 );


//**********************************************************************************************************************
//	Custom names in ACF flexible content layout handle
//**********************************************************************************************************************

    function display_header_for_handle($header_text_field) {
        $header = '';
        if($header_text_field['content-header']) :
            $header = '<span class="name-span"><i>"' . $header_text_field['content-header'] . '"</i></span>';
        elseif($header_text_field['content-text']) :
            $text = str_replace('<p>', '', $header_text_field['content-text']);
            $text = str_replace('</p>', '', $text);
            $text = str_replace('<a href="', '', $text);
            $text = str_replace('</a>', ' ', $text);
            $text = str_replace('>', ' ', $text);
            $text = substr($text, 0, 35);
            $header = '<span class="name-span"><i>"' . $text . '..."</i></span>';
        endif;

        return $header;
    }


function custom_flex_content_handle( $title, $field, $layout, $i ) {

        $options = get_sub_field('flex-options');
        $show = validateFlexItem(get_sub_field('flex-options'));
        $column = '';
        switch($options['column']) :
            case 'full-width' :
                $column = "F";
                break;
            case 'colspan-12' :
                $column = "12";
                break;
            case 'colspan-8' :
                $column = "8";
                break;
            case 'colspan-6' :
                $column = "6";
                break;
            case 'colspan-4' :
                $column = "4";
                break;
            case 'colspan-3' :
                $column = "3";
                break;
            default :
                $column = false;
        endswitch;

        $col_label = ($column) ? ' <span class="column-label col-width">' . $column . '</span>' : '';

        //Wrap default ACF in span class
        $title = $col_label . '<span class="flex-layout-type column-label">' . $title . '</span>';

		//Flex text
		if($text = display_header_for_handle(get_sub_field('content-header-text'))) {
			$title .= ' <span><i>' . $text . '</i></span>';
		}

		//Flex form
		if($text = get_sub_field('flex-form-title')) {
			$title .= ' <span><i>"' . $text . '"</i></span>';
		};

		//Flex Google maps
		if($text = get_sub_field('flex-maps-address')) {
			$title .= ' <span>' . $text . '</span>';
		};

		//Flex table
		if( get_row_layout() == 'flex-table' ) {
            $title.= display_header_for_handle(get_sub_field('content-header-text'));
		};

		if( get_row_layout() == 'flex-usp') {
		    $list = get_sub_field("list-group");
		    $title .= display_header_for_handle(get_sub_field('content-header-text')) . '<span class="column-label">' . count($list['list-repeater']) . ' punt(en)</span>';
		}

		//Flex image
		if( get_row_layout() == 'flex-image' ) {
			$image_object = get_sub_field('flex-image-array');
			$text = (count($image_object) == 1 ) ? '<span class="column-label">1 afbeelding</span>' : '<span class="column-label">' . count($image_object) . ' afbeeldingen</span>';
			$title .= display_header_for_handle(get_sub_field('content-header-text')) . '<span>' . $text . '</span>';
		}

		//Flex gallery
		if( get_row_layout() == 'flex-gallery' ) {
			$gallery_images = get_sub_field('flex-gallery-images');
			$title .= ' <span>Bevat ' . count($gallery_images) . ' afbeeldingen.</span>';
		}

        //Flex algemene inhoud
        if( get_row_layout() == 'flex-static-content' ) {
            $static = get_sub_field('content');
            $title .= ' <span>Toont de inhoud van <a class="handle-button" href="post.php?post=' . $static . '&action=edit"> ' . get_the_title($static) . '</a>.</span>';
        }

		//Flex CTA
		if( get_row_layout() == 'flex-card' ) {

			$n_o_b = count(get_sub_field('card-flex'));

				if($n_o_b > 1 ) {
                    $title.= '<span>Bevat ' . $n_o_b . ' cards.</span>';
				} elseif ($n_o_b == 1 ) {
                    $title.= '<span>Bevat ' . $n_o_b . ' card.</span>';
				} else {
                    $title.= '<span>Bevat geen cards.</span>';
				};

		};

		if(get_row_layout() == 'flex-button' ) {
            $title.= display_header_for_handle(get_sub_field('content-header-text'));
            $title.= '<span>Bevat ' . count(get_sub_field('button-repeater')) . ' knop(pen)</span>';
        }



        $colors = get_field('config-colors', 'option');
        $selected_color = str_replace('bgc ', '', $options['flex-bgc-select']);
        $expand_color = ($options['bgc-extend']) ? 'xpnad-bgc' : '';

		$title.= '<div class="block-background ' . $expand_color . '" style="background: ' . $colors[$selected_color] . ';"></div>';
		if(!$show && get_sub_field('flex-options')) :
		    $title= '<span class="hidden-block">' . $title . '</span>';
		endif;


		return $title;
	}

	add_filter('acf/fields/flexible_content/layout_title', 'custom_flex_content_handle', 10, 4);


//**********************************************************************************************************************
//	Add custom post types from options page based on radio button on options page
//**********************************************************************************************************************

	//Add the custom post types from the options page
	function add_cpt_from_option_page() {
		function codex_custom_init() {

			//First get the true or false values from the options page
			$mod_occ = get_field('module-occasions', 'option' );
			$mod_new = get_field('module-news', 'option' );
			$mod_res = get_field('module-real-estate', 'option');
			$mod_boo = get_field('module-booking', 'option');

			//Occasions CPT
			$mod_occ_args = array(
				'labels' => array('name' => __( 'Occasions' ),
						'singular_name' => __( 'Occasion' ),
						'add_new' => __( 'Occasion toevoegen' ),
						'add_new_item' => __( 'Occasion toevoegen' ),
						'edit_item' => __( 'Occasion bewerken' ),
						'new_item' => __( 'Occasion toevoegen' ),
						),
				'public' => true,
				'has_archive' => true,
				'supports' => array('title', 'editor', 'thumbnail'),
				'menu_icon' => __('dashicons-exerpt-view')
			);

			//News CPT
			$mod_new_args = array(
				'labels' => array('name' => __( 'Nieuws' ),
						'singular_name' => __( 'Nieuwsitem' ),
						'add_new' => __( 'Nieuwsitem toevoegen' ),
						'add_new_item' => __( 'Nieuwsitem toevoegen' ),
						'edit_item' => __( 'Nieuwsitem bewerken' ),
						'new_item' => __( 'Nieuwsitem toevoegen' ),
						),
				'public' => true,
				'has_archive' => true,
				'supports' => array('title', 'editor', 'thumbnail'),
				'menu_icon' => __('dashicons-media-document')
			);

			//Real estate CPT
			$mod_res_args = array(
				'labels' => array('name' => __( 'Vastgoed' ),
						'singular_name' => __( 'Vastgoedobject' ),
						'add_new' => __( 'Vastgoedobject toevoegen' ),
						'add_new_item' => __( 'Vastgoedobject toevoegen' ),
						'edit_item' => __( 'Vastgoedobject bewerken' ),
						'new_item' => __( 'Vastgoedobject toevoegen' ),
						),
				'public' => true,
				'has_archive' => true,
				'supports' => array('title', 'editor', 'thumbnail'),
				'menu_icon' => __('dashicons-admin-home'),
				'rewrite' => array('slug' => __( 'aanbod'))
			);

			//Afspraken module CPT
			$mod_boo_args = array(
				'labels' => array('name' => __( 'Afspraken' ),
						'singular_name' => __( 'Afspraak' ),
						'add_new' => __( 'Afspraak toevoegen' ),
						'add_new_item' => __( 'Afspraak toevoegen' ),
						'edit_item' => __( 'Afspraak bewerken' ),
						'new_item' => __( 'Afspraak toevoegen' ),
						),
				'public' => true,
				'has_archive' => true,
				'supports' => array('title', 'editor', 'thumbnail'),
				'menu_icon' => __('dashicons-admin-home'),
				'rewrite' => array('slug' => __( 'aanbod'))
			);

			//Register the CPT's if option page values == true
			if($mod_occ == 'true' ) : register_post_type('occasions', $mod_occ_args); endif;
			if($mod_new == 'true' ) : register_post_type('news', $mod_new_args); endif;
			if($mod_res == 'true' ) : register_post_type('real-estate', $mod_res_args); endif;
			if($mod_boo == 'true' ) : register_post_type('booking', $mod_boo_args); endif;
		};

		codex_custom_init();
	};

	//Register options CPT on init
	add_action('init', 'add_cpt_from_option_page');


	//Add class to body if module is active
	function module_body_classes( $classes ) {
		$mod_occ = get_field('module-occasions', 'option' );
		$mod_new = get_field('module-news', 'option' );
		$mod_res = get_field('module-real-estate', 'option');
		$mod_boo = get_field('module-booking', 'option');

		if($mod_occ == 'true') { $classes .= ' occ-active'; };
		if($mod_new == 'true') { $classes .= ' new-active'; };
		if($mod_res == 'true') { $classes .= ' res-active'; };
		if($mod_boo == 'true') { $classes .= ' boo-active'; };

	    return $classes;
	};

	add_filter( 'admin_body_class', 'module_body_classes' );


// ************************
//
// Custom page attributes
//
// ************************

//First remove the default page attributes meta box
function lets_remove_pageparentdiv() {
		remove_meta_box( 'pageparentdiv', 'page', 'normal' );
}
add_action( 'admin_menu', 'lets_remove_pageparentdiv' );

//Then copy the page attributes meta box from wp-admin/includes/meta-boxes.php and alter the name of the function from page_attributes_meta_box to page_attributes_custom_meta_box
//and edit as requiered

function page_attributes_custom_meta_box($post) {
	$post_type_object = get_post_type_object($post->post_type);
	if ( $post_type_object->hierarchical ) {
		$dropdown_args = array(
			'post_type'        => $post->post_type,
			'exclude_tree'     => $post->ID,
			'selected'         => $post->post_parent,
			'name'             => 'parent_id',
			'show_option_none' => __('(no parent)'),
			'sort_column'      => 'menu_order, post_title',
			'echo'             => 0,
		);

		$dropdown_args = apply_filters( 'page_attributes_dropdown_pages_args', $dropdown_args, $post );
		$pages = wp_dropdown_pages( $dropdown_args );
		if ( ! empty($pages) ) {
?>
<p><strong>Deze pagina is een subpagina van:</strong></p>
<label class="screen-reader-text" for="parent_id">Bovenliggende pagina</label>
<?php echo $pages; ?>
<?php
		} // end empty pages check
	} // end hierarchical check.
	if ( 'page' == $post->post_type && 0 != count( get_page_templates( $post ) ) && get_option( 'page_for_posts' ) != $post->ID ) {
		$template = !empty($post->page_template) ? $post->page_template : false;
		?>

<p><strong>Pagina type:</strong><?php
	do_action( 'page_attributes_meta_box_template', $template, $post );
?></p>
<label class="screen-reader-text" for="page_template">Pagina type</label><select name="page_template" id="page_template">
<?php

$default_title = apply_filters( 'default_page_template_title',  __( 'Default Template' ), 'meta-box' );
?>
<?php page_template_dropdown($template); ?>
</select>
<?php
	} ?>
<p><strong>Volgorde</strong></p>
<p><label class="screen-reader-text" for="menu_order"><?php _e('Order') ?></label><input name="menu_order" type="text" size="4" id="menu_order" value="<?php echo esc_attr($post->menu_order) ?>" /></p>

<?php

}

add_action('add_meta_boxes','add_post_template_metabox');
function add_post_template_metabox() {
    add_meta_box('postparentdiv', __('Pagina eigenschappen'), 'page_attributes_custom_meta_box', 'page', 'side', 'core');
}


//Function to quickly display NAW
function naw($item) {
	$data = get_field("config-naw", "options");
	if($data[$item]) { echo $data[$item]; };
}

function get_naw($item) {
	$data = get_field("config-naw", "options");
	return $data[$item];
}

function check_contrast($pri, $txt) {
		$min_contrast = 35;

		list($pr, $pg, $pb) = sscanf($pri, "#%02x%02x%02x");
		list($tr, $tg, $tb) = sscanf($txt, "#%02x%02x%02x");
		$rgb = [$pr, $pg, $pb, $tr, $tg, $tb];
		foreach ($rgb as $value) :
			$lum[] = ($value / 255) * 100 ;
		endforeach;
		$col1 = 0.3 * $lum['0'] + 0.59 * $lum['1'] + 0.11 * $lum['2'];
		$col2 = 0.3 * $lum['3'] + 0.59 * $lum['4'] + 0.11 * $lum['5'];
		$contrast = ($col1 > $col2) ? $col1 - $col2 : $col2 - $col1;

		if($contrast >= $min_contrast ) :
			//echo "<div style='margin: 20px; z-index: 10000; width: 100%;'><div style='width: 100px; height: 30px; display: inline-block; border: 1px solid black; background: " . $pri . ";'>" . $pri . "</div> ->
		//Contrast: " . ceil($lval) . " -> <div style='width: 100px; height: 30px; display: inline-block; border: 1px solid black; background: " . $txt . ";'>" . $txt . "</div></div>";
			return true;
		else :
				//echo "<div style='margin: 20px; z-index: 10000; width: 100%;'><div style='width: 100px; height: 30px; display: inline-block; border: 1px solid black; background: " . $pri . ";'>" . $pri . "</div> ->
			//Contrast: " . ceil($lval) . " -> <div style='width: 100px; height: 30px; display: inline-block; border: 1px solid black; background: " . $txt . ";'>" . $txt . "</div></div>";
			return false;
		endif;
}

function check_high_luminance($pri) {

    list($pr, $pg, $pb) = sscanf($pri, "#%02x%02x%02x");

    if($pr > 190 && $pg > 190 && $pb > 190) :
        return true;
    else :
        return false;
    endif;
}

function hex_to_seperate_rgb($pri) {

    list($pr, $pg, $pb) = sscanf($pri, "#%02x%02x%02x");

    return [$pr, $pg, $pb];
}

function add_color_tint($base, $tint) {

		list($r, $g, $b) = sscanf($base, "#%02x%02x%02x");
		$tint = 1 - ($tint / 100);

		$r = ($r * $tint <= 255) ? $r * $tint : 255;
		$g = $g * $tint;
		$b = $b * $tint;

		$r = dechex($r);
		$g = dechex($g);
		$b = dechex($b);

		return "#" . $r . $g . $b;
}

//function set_colors($pri, $sec, $h, $t) {
//		if(check_contrast($pri, $h)) :
//			$h_bgc = $h;
//			$t_bgc = $h;
//		elseif(check_contrast($pri, $t)) :
//			$h_bgc = $t;
//			$t_bgc = $t;
//		elseif(check_contrast($sec, $h)) :
//			$h_bgc = $h;
//			$c_bgc = $sec;
//		elseif(check_contrast($pri, "#FFFFFF")) :
//			$h_bgc = '#FFFFFF';
//			$t_bgc = '#FFFFFF';
//		elseif(check_contrast($pri, "#333333")) :
//			$h_bgc = '#333333';
//			$t_bgc = '#333333';
//		elseif(check_contrast($sec, "#FFFFFF")) :
//			$h_bgc = '#FFFFFF';
//			$t_bgc = '#FFFFFF';
//			$c_bgc = $colors['sec-color'];
//		elseif(check_contrast($sec, "#333333")) :
//			$h_bgc = '#333333';
//			$t_bgc = '#333333';
//			$c_bgc = $sec;
//		else :
//			$h_bgc = '#333333';
//			$t_bgc = '#333333';
//			$c_bgc = '#eeeeee';
//		endif;
//}

//**********************************************************************************************************************
//	Get global colors and load them in flex-fields
//**********************************************************************************************************************

function acf_load_color_field_choices( $color_select ) {
    // reset choices
    $color_select['choices'] = array();
	$colors = get_field('config-colors', 'option');

	$color_select['choices'][ 'no-bgc' ] = '<span class="color-selector" style="background: #fffff"> Geen </span>';
    $color_select['choices'][ 'bgc pri-color' ] = '<span class="color-selector" style="background: ' . $colors['pri-color'] . ';"> </span>';
	$color_select['choices'][ 'bgc sec-color' ] = '<span class="color-selector" style="background: ' . $colors['sec-color'] . ';"> </span>';
	$color_select['choices'][ 'bgc ter-color' ] = '<span class="color-selector" style="background: ' . $colors['ter-color'] . ';"> </span>';


    //Add additional colors from config menu to stylesheet
    if($colors['additional-colors']) :
        $add_col_count = 1;
        foreach($colors['additional-colors'] as $value) :
            $hex = $value['add-color'];
            $name = 'bgc additional-color-' . $add_col_count;
            $color_select['choices'][ $name ] = '<span class="color-selector" style="background: ' . $hex . ';"> </span>';
            $add_col_count++;
        endforeach;
    endif;


    // return the field
    return $color_select;

}

add_filter('acf/load_field/name=flex-bgc-select', 'acf_load_color_field_choices');
add_filter('acf/load_field/name=flex-card-bgc-select', 'acf_load_color_field_choices');

//**********************************************************************************************************************
//	Function to check if a flex item should be shown based on 'Publiceren' option, 'Startdatum' option and 'Einddatum'option
//**********************************************************************************************************************

	function validateFlexItem($flex_options) {

		$flex_show = true;
		$flex_publish = $flex_options['flex-publish'];
		$flex_expire = $flex_options['flex-end-date-option'];
		$flex_valid = $flex_options['flex-start-date-option'];

		//Before checking dates, see if post is published at all
		if($flex_publish) {

			//If either of dates are set
			if($flex_expire or $flex_valid) {

				//Get current date
				$current_date = date('Ymd');

				//If both start and end date are set
				if($flex_expire && $flex_valid) {
					$flex_expire_date = $flex_options['flex-end-date'];
					$flex_valid_date = $flex_options['flex-start-date'];

					if( ( $current_date > $flex_expire_date) or ( $current_date < $flex_valid_date ) ) {
						$flex_show = false;
					}
				}

				//If start date is set
				if($flex_valid && !$flex_expire) {
					$flex_valid_date = $flex_options['flex-start-date'];

					if($current_date < $flex_valid_date) {
						$flex_show = false;
					}
				}

				//If end date is set
				if($flex_expire && !$flex_valid) {
					$flex_expire_date = $flex_options['flex-end-date'];

					if($current_date >= $flex_expire_date) {
						$flex_show = false;
					}
				}
			}
		} else {
			$flex_show = false;
		}

		return $flex_show;
	};

//**********************************************************************************************************************
//	Enable GZIP
//**********************************************************************************************************************

	//ob_start("ob_gzhandler");


//**********************************************************************************************************************
//	WooSupport
//**********************************************************************************************************************

	/**
	 * Add new constant that returns true if WooCommerce is active
     *
     * In mixed templates (Woo and non-Woo content), test for WPEX_WOOCOMMERCE_ACTIVE
     *
	 */
	define( 'WPEX_WOOCOMMERCE_ACTIVE', class_exists( 'WooCommerce' ) );

	// Checking if WooCommerce is active
	if ( WPEX_WOOCOMMERCE_ACTIVE ) {

        get_template_part('/woocommerce/functions/woo-functions');

    }

//**********************************************************************************************************************
//	Adding Menus & adding menu option in backend top level menu
//**********************************************************************************************************************

	//Register menu locations
	function apex_custom_menus() {
		register_nav_menus(
		  array(
			'main-nav' => __( 'Hoofdnavigatie' ),
			'top-nav' => __( 'Topnavigatie' ),
			'footer-nav' => __( 'Footernavigatie')
		  )
		);
	}
	add_action( 'init', 'apex_custom_menus' );

	//Add custom link to Menu's in backend
	add_action( 'admin_menu', 'linked_url' );
    function linked_url() {
  		add_menu_page( 'linked_url', 'Menustructuur', 'read', 'nav-menus.php', '', 'dashicons-menu', 12 );
    }

    // add_action( 'admin_menu' , 'linkedurl_function' );
	// 	function linkedurl_function() {
	// 	global $menu;
	// 	$menu[11][1] = get_admin_url() . "nav-menus.php";
	// }

	//Allow editors to edit menu
	$role_object = get_role( 'editor' );
	$role_object->add_cap( 'edit_theme_options' );


//**********************************************************************************************************************
//	SMTP Mail option
//**********************************************************************************************************************

	function send_smtp_email( $phpmailer ) {

		$smtpHost = get_field('smtp-server', 'option');
		$smtpPort = get_field('smtp-port', 'option');
		$smtpUser = get_field('smtp-user', 'option');
		$smtpPass = get_field('smtp-pass', 'option');

		$fromName = 'Bericht van ' . get_bloginfo('name');
		$replyToEmail = 'mailer@envisichosting.nl';
		$replyToName = get_bloginfo('name');

		$phpmailer->isSMTP();
		$phpmailer->Host       	= $smtpHost;
		$phpmailer->Port       	= $smtpPort;
		//$phpmailer->SMTPSecure 	= 'tls';
		$phpmailer->SMTPAuth   	= true;
		$phpmailer->Username   	= $smtpUser;
		$phpmailer->Password  	= $smtpPass;
		$phpmailer->From       	= 'mailer@envisichosting.nl';
		$phpmailer->FromName   	= $fromName;
		$phpmailer->addReplyTo($replyToEmail, $replyToName);

	}

	function set_my_mail_content_type() {
		return "text/html";
	}

//**********************************************************************************************************************
//	Static content CPT
//**********************************************************************************************************************

	$static_content_cpt = array(
		'labels' => array('name' => __( 'Algemene inhoud' ),
				'singular_name' => __( 'Algemene inhoud' ),
				'add_new' => __( 'Algemene inhoud toevoegen' ),
				'add_new_item' => __( 'Algemene inhoud toevoegen' ),
				'edit_item' => __( 'Algemene inhoud bewerken' ),
				'new_item' => __( 'Algemene inhoud toevoegen' ),
				),
		'public' => true,
		'has_archive' => false,
		'show_in_nav_menus' => false,
		'supports' => array('title', 'editor'),
		'menu_icon' => __('dashicons-format-aside'),
		'rewrite' => array('slug' => __( 'static-content'))
	);

	register_post_type('static-content', $static_content_cpt);


//**********************************************************************************************************************
//	Generate config CSS on backend 'Configuratie' update
//**********************************************************************************************************************

    function generate_config_css() {
        $screen = get_current_screen();
        if (strpos($screen->id, "theme-general-settings") == true) {

            if(get_field('dev-mode', 'option') == true ) :
                //---------------------------------------------------------------------------------------------------------------------------------------
                //Add inline custom styling
                $custom_style = '';
                $colors = get_field('config-colors', 'option');
                $header_font = get_field('config-header-font', 'option');
                $text_font = get_field('config-text-font', 'option');
                $alt_header_font = get_field('config-header-font-css', 'option');
                $alt_text_font = get_field('config-text-font-css', 'option');

                $alt_header_font = str_replace(' ', '+', $alt_header_font);
                $alt_text_font = str_replace(' ', '+', $alt_text_font);

                $custom_style.= " :root {\n";

                //Generate separate RGB values for each color
                foreach($colors as $key => $value) :
                    if($value && $key !== 'additional-colors') :
                        $rgb = hex_to_seperate_rgb($value);
                        $custom_style.= "--" . $key . "-r: " . $rgb[0] . ";\n";
                        $custom_style.= "--" . $key . "-g: " . $rgb[1] . ";\n";
                        $custom_style.= "--" . $key . "-b: " . $rgb[2] . ";\n";
                    endif;
                endforeach;

                //Add additional colors from config menu to stylesheet
                if($colors['additional-colors']) :
                    $i = 1;
                    foreach($colors['additional-colors'] as $value) :
                        $hex = $value['add-color'];
                        $rgb = hex_to_seperate_rgb($hex);
                        $custom_style.= "--additional-color-" . $i . "-r: " . $rgb[0] . ";\n";
                        $custom_style.= "--additional-color-" . $i . "-g: " . $rgb[1] . ";\n";
                        $custom_style.= "--additional-color-" . $i . "-b: " . $rgb[2] . ";\n";
                        $custom_style.= "--additional-rgb-" . $i . ": var(--additional-color-" . $i . "-r), var(--additional-color-" . $i . "-g), var(--additional-color-" . $i . "-b);\n";
                        $custom_style.= "--additional-" . $i . ": rgb(var(--additional-rgb-" . $i . ")); \n";

                        if(check_high_luminance($hex)) :
                            $custom_style.= "--additional-" . $i . "-con: var(--pri-color) ;\n";
                        else :
                            $con = check_contrast($hex, '#FFFFFF') ? '#FFF' : '#444';
                            $custom_style.= "--additional-" . $i . "-con: " . $con . ";\n";
                        endif;

                        $i++;
                    endforeach;
                endif;

                //Set and add the contrast colors
                foreach($colors as $key => $value) :
                    if($key == ( 'pri-color' || 'sec-color' || 'ter-color' || 'icon-color' ) && $value) :

                        if(check_high_luminance($value)) :
                            $custom_style.= "--" . $key . "-con: var(--pri-color) ;\n";
                        else :
                            $con = check_contrast($value, '#FFFFFF') ? '#FFF' : '#444';
                            $custom_style.= "--" . $key . "-con: " . $con . ";\n";
                        endif;
                    endif;
                endforeach;

                //Check for header fonts and alternative header fonts and add them to inline style
                if($alt_header_font) :
                    $custom_style.= "--header-font: '" . str_replace("+", " ", $alt_header_font) . "', Helvetica, Arial, sans-serif; \n";
                elseif($header_font['value']) :
                    $custom_style.= "--header-font: '" .  str_replace("+"," ",$header_font['value']) . "', Helvetica, Arial, sans-serif; \n";
                endif;
                if($alt_text_font) :
                    $custom_style.= "--text-font: '" . str_replace("+", " ", $alt_text_font) . "', Helvetica, Arial, sans-serif; \n";
                elseif($text_font['value']) :
                    $custom_style.= "--text-font: '" .  str_replace("+"," ",$text_font['value']) . "', Helvetica, Arial, sans-serif \n";
                endif;
                $custom_style.= "}\n";

                $custom_style.= "h1,h2,h3,h4,h5,h6 { font-weight: " . get_field('header-weight', 'option') . "; } \n";
                $custom_style.= "body { font-weight: " . get_field('text-weight', 'option') . "; } \n";

                if($colors["additional-colors"]) :
                    $i = 1;
                    foreach($colors['additional-colors'] as $value) :

                        $custom_style.= ".bgc.additional-color-" . $i . " { \n ";
                        $custom_style.= "--bgc: var(--additional-". $i . "); \n ";
                        $custom_style.= "--con-color: var(--additional-" . $i . "-con); \n ";
                        $custom_style.= "color: var(--additional-" . $i . "-con); \n ";
                        $custom_style.= "background: var(--bgc); \n";
                        $custom_style.= "}\n";
                    $i++;
                    endforeach;
                endif;

                //Set header height option
                if( get_field( 'override-header-height', 'option' ) ) :
                    $custom_style.= "@media screen and (min-width: 950px) { :root { --header-height:" . get_field('dev-header-height', 'option') . "}} \n";
                endif;

                //Override desktop -> mobile navigation breakpoint
                $mobNavBreakpoint = ( get_field('override-mob-navi-breakpoint', 'option') ) ? get_field('mob-navi-breakpoint', 'option') : 950;
                if( get_Field('override-mob-navi-breakpoint', 'option') ) :
                    $custom_style.= "@media screen and (max-width:" . get_field('mob-navi-breakpoint', 'option') . "px) {.nav-main, .nav-top { display:none; } .nav-mobile, .nav-trigger { display: block;}} \n";
                endif;

                if( get_field('theme-setting-use-hamburger') ) :
                    $custom_style.= '.nav-trigger, .nav-mobile { display:block }' ;
                endif;

                // Add the font CSS:
                $selected_header_font = get_field('config-header-font', 'option' );
                $selected_text_font = get_field('config-text-font', 'option' );

                $selected_alternative_header_font = get_field('config-header-font-css', 'option');
                $selected_alternative_text_font = get_field('config-text-font-css', 'option');

                if(!$selected_alternative_header_font) :
                    $header_font = 'https://fonts.googleapis.com/css?family=' . $selected_header_font['value'] . ':300,300i,400,400i,700i,700,900,900i';

                    if($selected_header_font !== $selected_text_font && !$selected_alternative_text_font) :
                        $body_font = 'https://fonts.googleapis.com/css?family=' . $selected_text_font['value'] . ':300,300i,400,400i,700i,700,900,900i';
                    elseif($selected_alternative_text_font) :
                        $body_font = 'https://fonts.googleapis.com/css?family=' . $selected_alternative_text_font . ':300,300i,400,400i,700i,700,900,900i';
                    endif;
                else :
                    $header_font = 'https://fonts.googleapis.com/css?family=' . $selected_alternative_header_font . ':300,300i,400,400i,700i,700,900,900i';

                    if($selected_alternative_text_font) :
                        $body_font = 'https://fonts.googleapis.com/css?family=' . $selected_alternative_text_font . ':300,300i,400,400i,700i,700,900,900i';
                    else :
                        $body_font = 'https://fonts.googleapis.com/css?family=' . $selected_text_font['value'] . ':300,300i,400,400i,700i,700,900,900i';
                    endif;
                endif;

                $custom_style.= file_get_contents($header_font);
                $custom_style.= file_get_contents($body_font);


                //Download Google fonts

                function getContents($str, $startDelimiter, $endDelimiter) {
                    $contents = array();
                    $startDelimiterLength = strlen($startDelimiter);
                    $endDelimiterLength = strlen($endDelimiter);
                    $startFrom = $contentStart = $contentEnd = 0;
                    while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
                        $contentStart += $startDelimiterLength;
                        $contentEnd = strpos($str, $endDelimiter, $contentStart);
                        if (false === $contentEnd) {
                            break;
                        }
                        $contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
                        $startFrom = $contentEnd + $endDelimiterLength;
                    }

                    return $contents;
                }

                //Download Google Fonts and replace the original font file URLs with local ones
                    $headerFontFilesContent = getContents(file_get_contents($header_font), 'url(', ') format');
                    $bodyFontFilesContent = getContents(file_get_contents($body_font), 'url(', ') format');

                    $newFiles = array();
                    $oldFiles = $headerFontFilesContent;

                    foreach($bodyFontFilesContent as $i) {
                        $oldFiles[] = $i;
                    }

                    foreach($headerFontFilesContent as $fontUrl) {
                        $file_name = basename($fontUrl);
                        file_put_contents(get_template_directory() . '/fonts/google/' . $file_name, file_get_contents($fontUrl));
                        $newFiles[] = get_template_directory_uri() . '/fonts/google/' . $file_name;
                    }

                    foreach($bodyFontFilesContent as $fontUrl) {
                        $file_name = basename($fontUrl);
                        file_put_contents(get_template_directory() . '/fonts/google/' . $file_name, file_get_contents($fontUrl));
                        $newFiles[] = get_template_directory_uri() . '/fonts/google/' . $file_name;
                    }

                    foreach($oldFiles as $i => $oldFile) {
                        $newCustomStyle = str_replace($oldFile, $newFiles[$i], $custom_style);
                        $custom_style = $newCustomStyle;
                    }
                //End download Google fonts

                $file = get_template_directory() . '/css/config.css';
                file_put_contents($file, $custom_style ) or print_r(error_get_last());



            endif;
        }
    }
    add_action('acf/save_post', 'generate_config_css', 20);

//**********************************************************************************************************************
//	Hide usernames in
//**********************************************************************************************************************

    function redirect_to_home_if_author_parameter() {

        $is_author_set = get_query_var( 'author', '' );
        if ( $is_author_set != '' && !is_admin()) {
            wp_redirect( home_url(), 301 );
            exit;
        }
    }
    add_action( 'template_redirect', 'redirect_to_home_if_author_parameter' );

//**********************************************************************************************************************
//	Icons
//**********************************************************************************************************************

    function display_icon($icon_name) {

        include locate_template('icons/icons.php');

        $iconHTML = '';

        if($icon_name && array_key_exists($icon_name, $icons)) :

            $iconHTML = $icons[$icon_name];

        endif;

        return $iconHTML;
    };

    //Load icons in fields

    function acf_load_icon_field_choices( $icon_select ) {
        // reset choices
        $icon_select['choices'] = array();
        include locate_template('icons/icon-names.php');

        foreach($icon_names as $name) :
            $icon_select['choices'][$name] = $name;
        endforeach;

        // return the field
        return $icon_select;

    }

    add_filter('acf/load_field/name=icon-select', 'acf_load_icon_field_choices');
    add_filter('acf/load_field/name=icon-select-2', 'acf_load_icon_field_choices');

//**********************************************************************************************************************
//	Nav Menu Walker
//**********************************************************************************************************************


    class Walker_Nav_Menu_Apex extends Walker_Nav_Menu {

        public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
            if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
                $t = '';
                $n = '';
            } else {
                $t = "\t";
                $n = "\n";
            }
            // Check for icon
            $icon = (display_icon(get_field('icon-select', $item->object_id ))) ? '<span class="icon-wrap nav-icon">' . display_icon(get_field('icon-select', $item->object_id )) . '</span>' : false;
            $icon_name = ($icon) ? get_field('icon-select', $item->object_id) : '';

            $thumb = '';
            if (WPEX_WOOCOMMERCE_ACTIVE) :
                //Check for WooCommerce category image
                $thumbnail_id = get_woocommerce_term_meta( $item->object_id, 'thumbnail_id', true );
                $thumb = wp_get_attachment_url( $thumbnail_id );
            endif;

            $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';
            $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
            //$classes[] = 'menu-item-' . $item->ID;
            $classes[] = 'post-id-' . $item->object_id;

            $classes[] = ($icon) ? 'has-icon has-icon-' . $icon_name : 'has-no-icon';

            /**
             * Filters the arguments for a single nav menu item.
             *
             * @since 4.4.0
             *
             * @param stdClass $args  An object of wp_nav_menu() arguments.
             * @param WP_Post  $item  Menu item data object.
             * @param int      $depth Depth of menu item. Used for padding.
             */
            $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

            /**
             * Filters the CSS classes applied to a menu item's list item element.
             *
             * @since 3.0.0
             * @since 4.1.0 The `$depth` parameter was added.
             *
             * @param string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
             * @param WP_Post  $item    The current menu item.
             * @param stdClass $args    An object of wp_nav_menu() arguments.
             * @param int      $depth   Depth of menu item. Used for padding.
             */
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

            /**
             * Filters the ID applied to a menu item's list item element.
             *
             * @since 3.0.1
             * @since 4.1.0 The `$depth` parameter was added.
             *
             * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
             * @param WP_Post  $item    The current menu item.
             * @param stdClass $args    An object of wp_nav_menu() arguments.
             * @param int      $depth   Depth of menu item. Used for padding.
             */
            //$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
            //$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

            //$output .= $indent . '<li' . $id . $class_names . '>';
            $output .= $indent . '<li' . $class_names . '>';

            $atts           = array();
            $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
            $atts['target'] = ! empty( $item->target ) ? $item->target : '';
            if ( '_blank' === $item->target && empty( $item->xfn ) ) {
                $atts['rel'] = 'noopener noreferrer';
            } else {
                $atts['rel'] = $item->xfn;
            }
            $atts['href']         = ! empty( $item->url ) ? $item->url : '';
            $atts['aria-current'] = $item->current ? 'page' : '';

            /**
             * Filters the HTML attributes applied to a menu item's anchor element.
             *
             * @since 3.6.0
             * @since 4.1.0 The `$depth` parameter was added.
             *
             * @param array $atts {
             *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
             *
             *     @type string $title        Title attribute.
             *     @type string $target       Target attribute.
             *     @type string $rel          The rel attribute.
             *     @type string $href         The href attribute.
             *     @type string $aria_current The aria-current attribute.
             * }
             * @param WP_Post  $item  The current menu item.
             * @param stdClass $args  An object of wp_nav_menu() arguments.
             * @param int      $depth Depth of menu item. Used for padding.
             */
            $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                    $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            /** This filter is documented in wp-includes/post-template.php */
            $title = apply_filters( 'the_title', $item->title, $item->ID );

            /**
             * Filters a menu item's title.
             *
             * @since 4.4.0
             *
             * @param string   $title The menu item's title.
             * @param WP_Post  $item  The current menu item.
             * @param stdClass $args  An object of wp_nav_menu() arguments.
             * @param int      $depth Depth of menu item. Used for padding.
             */
            $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

            $item_output  = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= ($icon) ?? '';
            $item_output .= ($thumb) ? '<img class="nav-thumb" src="'.$thumb.'" />' : '';
            $item_output .= '<span class="menu-item-text">';
            $item_output .= $args->link_before . $title . $args->link_after;
            $item_output .= '</span>';
            $item_output .= '</a>';
            $item_output .= $args->after;

            /**
             * Filters a menu item's starting output.
             *
             * The menu item's starting output only includes `$args->before`, the opening `<a>`,
             * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
             * no filter for modifying the opening and closing `<li>` for a menu item.
             *
             * @since 3.0.0
             *
             * @param string   $item_output The menu item's starting HTML output.
             * @param WP_Post  $item        Menu item data object.
             * @param int      $depth       Depth of menu item. Used for padding.
             * @param stdClass $args        An object of wp_nav_menu() arguments.
             */

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }


    }

//**********************************************************************************************************************
//	Work around get_template_part(): this function lets you include a php file with parameters.
//**********************************************************************************************************************


    function includeWithVariables($filePath, $variables = array(), $print = true)
    {
        $output = NULL;
        if(file_exists($filePath)){
            // Extract the variables to a local namespace
            extract($variables);

            // Start output buffering
            ob_start();

            // Include the template file
            include $filePath;

            // End buffering and return its contents
            $output = ob_get_clean();
        } else {
            $output = "Error, no such file";
        }
        if ($print) {
            print $output;
        }
        return $output;

    }

?>