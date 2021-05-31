<?php


/**
 * Add options page for WooCommerce
 */
acf_add_options_page(array(
    'page_title' => 'Apex & Woo',
    'menu_title' => 'Apex & Woo',
    'menu_slug' => 'wc-apex-admin',
    'capability' => 'edit_posts',
    'redirect' => false
));

//Add class to admin body if WooCommerce is active
function woo_body_class($classes)
{
    $classes .= ' woo-com-active';
    return $classes;
}

;

add_filter('admin_body_class', 'woo_body_class');

add_action('after_setup_theme', function () {
    add_theme_support('woocommerce');
});

add_theme_support('wc-product-gallery-slider');
add_theme_support('wc-product-gallery-zoom');
add_theme_support('wc-product-gallery-lightbox');

/**
 * Wrap Woo content in <main> tag
 */
function custom_woo_wrapper_open_tag()
{
    echo '<main>';
}

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
add_action('woocommerce_before_main_content', 'custom_woo_wrapper_open_tag', 10);

function custom_woo_wrapper_close_tag()
{
    echo '</main>';
}

remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_after_main_content', 'custom_woo_wrapper_close_tag', 10);


function add_class_to_pdp($classes)
{

    if (is_product()) {

        $classes[] = 'pdp';
    }
    return $classes;
}

add_filter('body_class', 'add_class_to_pdp');


/**
 * Add the Custom fields for Products in WooCommerce backend (COP)
 */
function woocommerce_render_meta_field()
{
    $savePrice = array(
        'id' => '_save_price',
        'label' => 'Bespaar',
        'value' => get_post_meta(get_the_ID(), '_save_price', true)
    );

    $inputGDJ = array(
        'id' => '_cop_gdj',
        'label' => 'Inkoopprijs GDJ',
        'value' => get_post_meta(get_the_ID(), '_cop_gdj', true)
    );

    $inputMCW = array(
        'id' => '_cop_mcw',
        'label' => 'Inkoopprijs MCW',
        'value' => get_post_meta(get_the_ID(), '_cop_mcw', true)
    );
    $inputBevro = array(
        'id' => '_cop_bev',
        'label' => 'Inkoopprijs Bevro',
        'value' => get_post_meta(get_the_ID(), '_cop_bev', true)
    );
    $inputGDJstock = array(
        'id' => '_stock_gdj',
        'label' => 'Voorraad GDJ',
        'value' => get_post_meta(get_the_ID(), '_stock_gdj', true)
    );
    $inputMCWstock = array(
        'id' => '_stock_mcw',
        'label' => 'Voorraad MCW',
        'value' => get_post_meta(get_the_ID(), '_stock_mcw', true)
    );
    $inputBevroStock = array(
        'id' => '_stock_bev',
        'label' => 'Voorraad Bevro',
        'value' => get_post_meta(get_the_ID(), '_stock_bev', true)
    );

    ?>

    <div id="save_price" class="options_group">
        <?php woocommerce_wp_text_input($savePrice); ?>
    </div>
    <div id="cop_attr" style="background: rgb(225,225,255)" class="options_group">
        <?php woocommerce_wp_text_input($inputGDJ); ?>
    </div>
    <div id="cop_attr" style="background: rgb(225,225,255)" class="options_group">
        <?php woocommerce_wp_text_input($inputGDJstock); ?>
    </div>
    <div id="cop_attr" style="background: rgb(255,225,225)" class="options_group">
        <?php woocommerce_wp_text_input($inputMCW); ?>
    </div>
    <div id="cop_attr" style="background: rgb(255,225,225)" class="options_group">
        <?php woocommerce_wp_text_input($inputMCWstock); ?>
    </div>
    <div id="cop_attr" style="background: rgb(225,255,255)" class="options_group">
        <?php woocommerce_wp_text_input($inputBevro); ?>
    </div>
    <div id="cop_attr" style="background: rgb(225,255,255)" class="options_group">
        <?php woocommerce_wp_text_input($inputBevroStock); ?>
    </div>

    <?php
}

add_action('woocommerce_product_options_general_product_data', 'woocommerce_render_meta_field');

/**
 * Save the product's COP number, if provided.
 *
 * @param int $product_id The ID of the product being saved.
 */
function woocommerce_save_save_price_field($product_id)
{
    if (
        !isset($_POST['_save_price'], $_POST['woocommerce_meta_nonce'])
        || (defined('DOING_AJAX') && DOING_AJAX)
        || !current_user_can('edit_products')
        || !wp_verify_nonce($_POST['woocommerce_meta_nonce'], 'woocommerce_save_data')
    ) {
        return;
    }

    $savePrice = sanitize_text_field($_POST['_save_price']);

    update_post_meta($product_id, '_save_price', $savePrice);
}

add_action('woocommerce_process_product_meta', 'woocommerce_save_save_price_field');


/**
 * Change number of products that are displayed per page (shop page)
 */
function new_loop_shop_per_page($cols)
{
    // $cols contains the current number of products per page based on the value stored on Options –> Reading
    // Return the number of products you wanna show per page.
    $cols = 12;
    return $cols;
}

add_filter('loop_shop_per_page', 'new_loop_shop_per_page', 20);

/**
 *  Lister page product title
 */

function custom_lister_page_product_title()
{

    global $product;

    $year = ($product->get_attribute('jaar')) ? $product->get_attribute('jaar') : '';
    $driver = ($product->get_attribute('coureur')) ? $product->get_attribute('coureur') : '';
    $manufacturer = ($product->get_attribute('fabrikant')) ? $product->get_attribute('fabrikant') : false;
    $scale = ($product->get_attribute('schaal')) ? $product->get_attribute('schaal') : false;

    echo '<h3><span class="lister-title">' . $product->get_attribute('merk') . ' ' . $product->get_attribute('typeaanduiding') . '</span><span class="lister-scale">' . $scale . '</span></h3>';

    echo '<div class="lister-subtitle">';

    if ($driver) :
        echo '<span class="lister-driver">' . $driver . '</span>';
    endif;

    if ($year) :
        echo '<span class="lister-year">' . $year . '</span>';
    endif;

    if ($manufacturer) :
        echo '<span class="lister-manufacturer">' . $manufacturer . '</span>';
    endif;

    echo '</div>';
}

remove_filter('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
add_filter('woocommerce_shop_loop_item_title', 'custom_lister_page_product_title', 10);


/**
 * Add specific product attributes to PDP summary based on backend list
 */
function woocommerce_add_attributes_to_summary()
{
    global $product;

    $attr = get_field('summary-attribute', 'option');

    if ($attr) :

        echo '<div class="summary-attributes">';

        foreach ($attr as $at) :

//                if($product->get_attribute($at['attribute-id'])) :
//                   echo '<div class="attr-row"><span class="attr-key">' . $at['attribute-label'] . '</span><span class="attr-value"><a href="/miniaturen/raceklassen/?filter_' . $at['attribute-id'] . '=' . $product->get_attribute($at['attribute-id']) . '">' . $product->get_attribute($at['attribute-id']) . '</a></<span></div>';
//                endif;

            if ($product->get_attribute($at['attribute-id'])) :
                echo '<div class="attr-row"><span class="attr-key">' . $at['attribute-label'] . '</span><span class="attr-value">' . $product->get_attribute($at['attribute-id']) . '<span></div>';
            endif;

        endforeach;

        echo '</div>';

    endif;
}

add_action('woocommerce_single_product_summary', 'woocommerce_add_attributes_to_summary', 45);


/**
 * Add links to lister pages based on product attributes (SEO)
 */
function seo_links_on_pdp()
{
    global $product;

    echo '<section class="content-wrap"><div class="content"><div class="tagcloud">';


    $attributes = $product->get_attributes();

    $base_slug = returnCategorySlug($page->ID);
    $wc_options = get_option('woocommerce_permalinks');
    $attribute_base = $wc_options['attribute_base'];

    foreach ( $attributes as $attribute ) :

        if ( empty( $attribute['is_visible'] ) || $attribute['name'] == 'Original category' || !$attribute['options'] || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) :
            continue;
        else :
            $has_row = true;
        endif;

        $attr_name =  wc_attribute_label( $attribute['name'] );
        $prefix = '';

        switch ($attr_name) :
            case 'Schaal':
                $prefix = 'Meer miniaturen van schaal ';
                break;
            case 'Jaar':
                $prefix = 'Meer miniaturen uit ';
                break;
            default:
                $prefix = 'Meer miniaturen van ';
        endswitch;

        if ( $attribute['is_taxonomy'] ) :

            $values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
            //echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );

            $attr_filter_name = str_replace('pa_', '', $attribute['name']);

            foreach($values as $value) :

                $value_slug = str_replace(' ', '-', $value);
                $value_slug = str_replace(':', '-', $value_slug);

                echo '<a class="tagcloud-item" title="'.$prefix . $value.'" href="' . get_site_url() . '/' . $attribute_base . '/' . str_replace(' ', '-', $attr_filter_name) . '/' . $value_slug . '">' . $prefix . $value . '</a>';

            endforeach;

        else :
            // Convert pipes to commas and display values
            $values = array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) );

            foreach($values as $value) :
                $value_slug = str_replace(' ', '-', $value);
                $value_slug = str_replace(':', '-', $value_slug);

                echo '<a class="tagcloud-item" title="'.$prefix . $value.'" href="' . get_site_url() . '/' . $attribute_base . '/' . str_replace(' ', '-', $attribute['name']) . '/' . $value_slug . '">' . $prefix . $value . '</a>';

            endforeach;

        endif;

    endforeach;

    echo '</div></div></section>';


}

add_action('woocommerce_after_single_product_summary', 'seo_links_on_pdp', 50);

/***
 * Lister page pagination arrows
 */
function apex_woo_pagination( $args ) {

    $args['prev_text'] = 'Vorige';
    $args['next_text'] = 'Volgende';

    return $args;
}
add_filter( 'woocommerce_pagination_args', 	'apex_woo_pagination' );

function generateRichDataPDP() {
    global $product;



    echo '<pre>';
    $name = str_replace("\"", ' ', $product->name);
    $description = str_replace("\"", ' ', $product->description);
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' );
    $averageRating = $product->average_rating;
    $ratingCount = $product->review_count;
    $price = ($product->sale_price) ? $product->sale_price : $product->regular_price;
    //var_dump($product);
    echo '</pre>';

    ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org/",
      "@type": "Product",
      "name": "<?=$name; ?>",
      "image": "<?= $image[0]; ?>",
      "description": "<?=$description;?>",
      "sku": "<?=$product->sku;?>",
      "brand": {
        "@type": "Brand",
        "name": "<?=$product->get_attribute('pa_fabrikant');?>"
      },
      <?php if($ratingCount !== 0) : ?>
          "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "<?=$averageRating;?>",
            "reviewCount": "<?=$ratingCount;?>"
          },
    <?php endif; ?>
      "offers": {
        "@type": "Offer",
        "url": "<?php the_permalink(); ?>",
        "priceCurrency": "EUR",
        "price": "<?=$price;?>",
        "priceValidUntil": "2029-12-21",
        "itemCondition": "https://schema.org/New",
        "availability": "https://schema.org/InStock"
      }
    }
    </script>

    <?php
}


add_action('woocommerce_after_single_product_summary', 'generateRichDataPDP', 60);

/**
 *  PDP product title based on attributes
 */

function woocommerce_pdp_title()
{
    global $product;

    if ($product->get_attribute('merk') && $product->get_attribute('typeaanduiding')) : ?>

        <h1 class="product_title entry-title"><?= $product->get_attribute('merk'); ?>  <?= $product->get_attribute('typeaanduiding'); ?></h1>

        <?php the_title('<p class="product-sub-title">', '</p>'); ?>

    <?php else :

        the_title('<h1 class="product_title entry-title">', '</h1>');

    endif;

}

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
add_action('woocommerce_single_product_summary', 'woocommerce_pdp_title', 5);

/**
 *  PDP Custom availability
 */
// Add new stock status options
function filter_woocommerce_product_stock_status_options($status)
{
    // Add new statuses
    $status['pre_order'] = 'Voorbestellen';

    return $status;
}

add_filter('woocommerce_product_stock_status_options', 'filter_woocommerce_product_stock_status_options', 10, 1);

// Availability text
function filter_woocommerce_get_availability_text($availability, $product)
{
    switch ($product->stock_status) {
        case 'pre_order':
            $availability = 'Voorbestellen';
            break;
    }
    return $availability;
}

add_filter('woocommerce_get_availability_text', 'filter_woocommerce_get_availability_text', 10, 2);

// Availability class
function filter_woocommerce_get_availability_class($class, $product)
{
    switch ($product->stock_status) {
        case 'pre_order':
            $class = 'pre-order';
            break;
    }

    return $class;
}

add_filter('woocommerce_get_availability_class', 'filter_woocommerce_get_availability_class', 10, 2);

function filter_woocommerce_admin_stock_html($stock_html, $product)
{

    switch ($product->stock_status) {
        case "in_stock" :
            $stock_html = '<p><span class="icon-wrap small">' . display_icon('fnd-success-alt') . '</span>' . wp_kses_post($availability) . '</p><p><span class="icon-wrap small">' . display_icon('truck-delivery') . '</span>Binnen 24 uur verzonden</p>';
            break;
        case "on_backorder" :
            $stock_html = '<p><span class="icon-wrap small">' . display_icon('fnd-info') . '</span>' . wp_kses_post($availability) . '</p><p><span class="icon-wrap small">' . display_icon('calendar') . '</span>Levertijd: enkele werkdagen</p>';
            break;
        case "out_of_stock" :
            $stock_html = '<p><span class="icon-wrap small">' . display_icon('fnd-close-circle') . '</span>' . wp_kses_post($availability) . '</p><p><span class="icon-wrap small">' . display_icon('calendar') . '</span>Helaas is de levertijd op dit moment niet bekend.</p>';
            break;
        default :

    }

    return $stock_html;
}

add_filter('woocommerce_admin_stock_html', 'filter_woocommerce_admin_stock_html', 10, 2);


/**
 * Add static content to PDP
 */
function woocommerce_add_flex_content_to_pdp()
{

    $staticID = get_field('woo-set-pdp-content', 'option');

    if ($staticID) :

        if (have_rows('flex', $staticID)):
            while (have_rows('flex', $staticID)) : the_row();

                $row_layout = get_row_layout();

                if (validateFlexItem(get_sub_field('flex-options'))) :

                    get_template_part('/blocks/' . $row_layout);

                endif;

            endwhile;
        endif;

    endif;

}

add_action('woocommerce_after_single_product_summary', 'woocommerce_add_flex_content_to_pdp', 35);


/**
 * Show cart contents / total Ajax
 */
add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

function woocommerce_header_add_to_cart_fragment($fragments)
{
    global $woocommerce;

    ob_start();

    ?>
    <a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>"
       title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count); ?>
        - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
    <?php
    $fragments['a.cart-customlocation'] = ob_get_clean();
    return $fragments;
}

/**
 * Change the test for "In Stock / Quantity Left / Out of Stock".
 */

add_filter('woocommerce_get_availability', 'wcs_custom_get_availability', 1, 2);
function wcs_custom_get_availability($availability, $_product)
{
    global $product;

    // Change In Stock Text
    if ($_product->is_in_stock()) {
        //$availability['availability'] = __('Plenty available in our store!', 'woocommerce');
        $availability['availability'] = 'Op voorraad';
    }

    // Change in Stock Text to only 1 or 2 left
    if ($_product->is_in_stock() && $product->get_stock_quantity() <= 0) {
        //$availability['availability'] = sprintf( __('Only %s left in store!', 'woocommerce'), $product->get_stock_quantity());
        $availability['availability'] = 'Op nabestelling';
    }

    // Change Out of Stock Text
    if (!$_product->is_in_stock()) {
        $availability['availability'] = 'Op nabestelling';
    }

    return $availability;
}

/**
 * Wrap listerpage in div
 */


function lister_page_open_div()
{
    echo '<div class="content lister-page">';
}

function lister_page_close_div()
{
    echo '</div>';
}

add_action('woocommerce_before_shop_loop', 'lister_page_open_div', 5);
add_action('woocommerce_no_products_found', 'lister_page_open_div', 5);
//add_action( 'woocommerce_after_main_content', 'lister_page_close_div', 5 );

//Filter op LP

function show_filter_on_listerpage()
{

    get_sidebar('shop');

}

add_action('woocommerce_after_shop_loop', 'show_filter_on_listerpage');

/**
 * Hide H1 titles on listerpage
 */
//add_filter( 'woocommerce_show_page_title', '__return_false' );


/**
 * Rename "home" in breadcrumb
 */
function wcc_change_breadcrumb_home_text($defaults)
{
    // Change the breadcrumb home text from 'Home' to 'Apartment'
    $defaults['home'] = 'Miniaturen';
    return $defaults;
}

add_filter('woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_home_text');


/**
 * Change the breadcrumb separator
 */
function wcc_change_breadcrumb_delimiter($defaults)
{
    // Change the breadcrumb delimeter from '/' to '>'
    $defaults['delimiter'] = '';
    return $defaults;
}

add_filter('woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_delimiter');


/**
 * Register Woo specific widgets
 */
function apex_widgets_init()
{

    /**
     * Layered navigation for Woo lister page
     *
     * Called in show_filter_on_listerpage(), hooked on woocommerce_after_shop_loop
     */
    register_sidebar(array(
        'name' => __('Filterbox', 'apex'),
        'id' => 'filterbox',
        'description' => 'Filter opties voor WooCommerce',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    /**
     * Additional nav items
     *
     * Called in header.php
     */
    register_sidebar(array(
        'name' => __('Navbalk', 'apex'),
        'id' => 'navbar',
        'description' => 'Navbar opties',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '',
        'after_title' => '',
    ));

    /**
     * Serachbar in header
     *
     * Called in header.php
     */
    register_sidebar(array(
        'name' => __('Searchbar', 'apex'),
        'id' => 'searchbar',
        'description' => 'Searchbar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '',
        'after_title' => '',
    ));

}

add_action('widgets_init', 'apex_widgets_init');


/**
 * Remove add to cart button on lister page
 */
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');


/**
 * Custom product rating on PDP and LP
 */

function woocommerce_template_custom_loop_rating($arg)
{

    global $product;

    if (!wc_review_ratings_enabled()) {
        return;
    }

    $rating_count = $product->get_rating_count();
    $review_count = $product->get_review_count();
    $average = $product->get_average_rating();

    if ($rating_count > 0) :

        $star_width = $average * 20;
        $plural = ($review_count == 1) ? 'beoordeling' : 'beoordelingen';

        ?>

        <div class="woocommerce-product-rating">
            <div class="star-container">
                <div class="star-wrap open">
                    <div class="star star-open"><?php echo display_icon('fnd-star'); ?></div>
                    <div class="star star-open"><?php echo display_icon('fnd-star'); ?></div>
                    <div class="star star-open"><?php echo display_icon('fnd-star'); ?></div>
                    <div class="star star-open"><?php echo display_icon('fnd-star'); ?></div>
                    <div class="star star-open"><?php echo display_icon('fnd-star'); ?></div>
                </div>
                <div class="star-wrap closed" style="width: <?= $star_width; ?>%;">
                    <div class="star star-closed"><?php echo display_icon('fnd-star-filled'); ?></div>
                    <div class="star star-closed"><?php echo display_icon('fnd-star-filled'); ?></div>
                    <div class="star star-closed"><?php echo display_icon('fnd-star-filled'); ?></div>
                    <div class="star star-closed"><?php echo display_icon('fnd-star-filled'); ?></div>
                    <div class="star star-closed"><?php echo display_icon('fnd-star-filled'); ?></div>
                </div>
            </div>

            <?php if ($arg) : ?>
                <div class="no-of-ratings"><?php echo $review_count . ' ' . $plural; ?></div>
            <?php endif; ?>

        </div>

    <?php endif;

    return;

}

/* LP */
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
add_action('woocommerce_after_shop_loop_item_title', function () {
    woocommerce_template_custom_loop_rating(false);
}, 5);

/* PDP Summary */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
add_action('woocommerce_single_product_summary', function () {
    woocommerce_template_custom_loop_rating(true);
}, 5);


/**
 * PDP Flex field
 */
function displayFlexLoopOnPdp()
{

    get_template_part('acf-flex-content-loop');

}

add_action('woocommerce_after_single_product_summary', 'displayFlexLoopOnPdp', 10);

/**
 * PDP Flex field
 */
add_filter('woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text');
function woocommerce_custom_single_add_to_cart_text()
{
    return 'In winkelwagen';
}

/**
 * Return category slugs of current product, for creating filter URL's
 */
function returnCategorySlug($postID)
{

    $slug = '';

    //First get the base slug
    $wc_options = get_option('woocommerce_permalinks');
    $product_category_base = $wc_options['category_base'];

    //Then get the category slug
    $cat_slug = '';

    $terms = get_the_terms($postID, 'product_cat');

    $has_parent = false;

    //Check if category has parent category
    foreach ($terms as $term) :
        if ($term->parent) :
            $has_parent = true;
        endif;
    endforeach;

    if ($has_parent) :

        foreach ($terms as $term) :

            if ($term->parent) :

                $parentID = $term->parent;
                $parent = get_term($parentID);
                $parent_slug = $parent->slug;

                $cat_slug = $parent_slug;

                break;

            endif;

        endforeach;

    else :

        foreach ($terms as $term) :

            $data = get_term($term);
            $slug = $data->slug;

            $cat_slug = $slug;

            break;

        endforeach;

    endif;

    $slug .= '/' . $product_category_base . '/' . $cat_slug . '/';

    return $slug;
}


/**
 * All product ID's
 */

function getAllProductIds()
{
    $ids = [];
    $all_ids = get_posts(array(
        'post_type' => 'product',
        'numberposts' => -1,
        'post_status' => 'publish',
        'fields' => 'ids',
    ));
    foreach ($all_ids as $id) {
        $ids[] = $id;
    }

    return $ids;
}

/**
 * SKU, ID, Stock
 */

function getProductInfo()
{

    $ids = [];
    $all_ids = get_posts(array(
        'post_type' => 'product',
        'numberposts' => -1,
        'post_status' => 'publish',
        'fields' => 'ids',
    ));

    foreach ($all_ids as $id) {

        $wooProduct = wc_get_product($id);
        $sku = $wooProduct->get_sku();

        $ids[strval($sku)]['id'] = $id;
        $ids[strval($sku)]['stock'] = $wooProduct->get_stock_quantity();
        $ids[strval($sku)]['year'] = $wooProduct->get_attribute( 'pa_jaar' );
        $ids[strval($sku)]['event'] = $wooProduct->get_attribute( 'pa_evenement' );
        $ids[strval($sku)]['driver'] = $wooProduct->get_attribute( 'pa_coureur' );
    }

    return $ids;

}

/**
 * Export all getProductInfo data every ** through WP-cron
 */

function storeProductInfo()
{
    $currHour = intval(date('H'));
    $currMinute = intval(date('i'));
    $message = '';
    $subject = '';
    if ($currHour == 15 && $currMinute > 15 && $currMinute < 25) :
        $info = getProductInfo();

        if (file_put_contents(ABSPATH . '/ports/current_products/products.json', json_encode($info))) :

            $subject .= count($info) . "prod. geëxporteerd. Datum/tijd: " . date('d m H:i');
            $message .= "Product export voltooid op " . date('d m') . " om " . date('H:i') . ". \n";
            $message .= "In totaal " . count($info) . " producten geëxporteerd.";

        else :

            $subject .= "Product export mislukt.";
            $message .= "Product export mislukt. \n";

        endif;

        //Send notification mail
        add_filter('wp_mail_content_type', 'set_my_mail_content_type');
        add_action('phpmailer_init', 'send_smtp_email');

        wp_mail('info@envisic.nl', $subject, $message);

        remove_filter('wp_mail_content_type', 'set_my_mail_content_type');
        remove_action('phpmailer_init', 'send_smtp_email');

    endif;

}

if (!wp_next_scheduled('storeProductInfo')) {
    wp_schedule_event(time(), 'hourly', 'storeProductInfo');
}

add_action('storeProductInfo', 'storeProductInfo');


/**
 * Class extending WC_Widget_Layered_Nav
 *
 * Adds option to select the order in which the attributes appear in on the frontend.
 *
 */

class WC_Widget_Layered_Nav_Apex extends WC_Widget_Layered_Nav {

    /**
     * Init settings after post types are registered.
     */
    public function init_settings() {
        $attribute_array      = array();
        $attribute_taxonomies = wc_get_attribute_taxonomies();

        if ( ! empty( $attribute_taxonomies ) ) {
            foreach ( $attribute_taxonomies as $tax ) {
                if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
                    $attribute_array[ $tax->attribute_name ] = $tax->attribute_name;
                }
            }
        }

        $this->settings = array(
            'title' => array(
                'type'  => 'text',
                'std'   => __( 'Filter by', 'woocommerce' ),
                'label' => __( 'Title', 'woocommerce' )
            ),
            'attribute' => array(
                'type'    => 'select',
                'std'     => '',
                'label'   => __( 'Attributes', 'woocommerce' ),
                'options' => $attribute_array
            ),
            'display_type' => array(
                'type'    => 'select',
                'std'     => 'list',
                //'label'   => __( 'Display type', 'woocommerce' ),
                'label'   => 'Soort',
                'options' => array(
                    'list'     => __( 'List', 'woocommerce' ),
                    'dropdown' => __( 'Dropdown', 'woocommerce' )
                )
            ),
            'query_type' => array(
                'type'    => 'select',
                'std'     => 'and',
                'label'   => __( 'Query type', 'woocommerce' ),
                'options' => array(
                    'and' => __( 'AND', 'woocommerce' ),
                    'or'  => __( 'OR', 'woocommerce' )
                )
            ),
            'query_order' => array(
                'type'    => 'select',
                'std'     => 'DESC',
                'label'   => 'Volgorde',
                'options' => array(
                    'ASC' => 'Oplopend',
                    'DESC'  => 'Aflopend'
                )
            )
        );
    }

    /**
     * Output widget.
     *
     * @see WP_Widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) ) {
            return;
        }

        $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
        $taxonomy           = isset( $instance['attribute'] ) ? wc_attribute_taxonomy_name( $instance['attribute'] ) : $this->settings['attribute']['std'];
        $query_type         = isset( $instance['query_type'] ) ? $instance['query_type'] : $this->settings['query_type']['std'];
        $display_type       = isset( $instance['display_type'] ) ? $instance['display_type'] : $this->settings['display_type']['std'];
        $query_order        = isset( $instance['query_order'] ) ? $instance['query_order'] : $this->settings['query_order']['std'];

        if ( ! taxonomy_exists( $taxonomy ) ) {
            return;
        }

        $get_terms_args = array( 'hide_empty' => '1' );

        $orderby = wc_attribute_orderby( $taxonomy );

        switch ( $orderby ) {
            case 'name' :
                $get_terms_args['orderby']    = 'name';
                $get_terms_args['menu_order'] = false;
                break;
            case 'id' :
                $get_terms_args['orderby']    = 'id';
                $get_terms_args['order']      = $query_order;
                $get_terms_args['menu_order'] = false;
                break;
            case 'menu_order' :
                $get_terms_args['menu_order'] = $query_order;
                break;
        }

        $terms = get_terms( $taxonomy, $get_terms_args );

        if ( 0 === sizeof( $terms ) ) {
            return;
        }

        switch ( $orderby ) {
            case 'name_num' :
                usort( $terms, '_wc_get_product_terms_name_num_usort_callback' );
                break;
            case 'parent' :
                usort( $terms, '_wc_get_product_terms_parent_usort_callback' );
                break;
        }

        ob_start();

        $this->widget_start( $args, $instance );

        if ( 'dropdown' === $display_type ) {
            $found = $this->layered_nav_dropdown( $terms, $taxonomy, $query_type );
        } else {
            $found = $this->layered_nav_list( $terms, $taxonomy, $query_type );
        }

        $this->widget_end( $args );

        // Force found when option is selected - do not force found on taxonomy attributes
        if ( ! is_tax() && is_array( $_chosen_attributes ) && array_key_exists( $taxonomy, $_chosen_attributes ) ) {
            $found = true;
        }

        if ( ! $found ) {
            ob_end_clean();
        } else {
            echo ob_get_clean();
        }
    }




}

add_action( 'widgets_init', 'replace_layered_nav_widget', 11 );

function replace_layered_nav_widget() {
    unregister_widget( 'WC_Widget_Layered_Nav' );
    register_widget( 'WC_Widget_Layered_Nav_Apex' );
}
