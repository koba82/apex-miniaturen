<?php
/********************
 *
 * Default Woo:
 *   woocommerce_single_product_summary
 * @hooked woocommerce_template_single_title - 5
 * @hooked woocommerce_template_single_rating - 10
 * @hooked woocommerce_template_single_price - 10
 * @hooked woocommerce_template_single_excerpt - 20
 * @hooked woocommerce_template_single_add_to_cart - 30
 * @hooked woocommerce_template_single_meta - 40
 * @hooked woocommerce_template_single_sharing - 50
 */

/**
 * PDP woocommerce_single_product_summary change order and actions
 */

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_in_stock_text', 29);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 39);

/**
 * @descr Add options page for WooCommerce
 */
acf_add_options_page(array(
            'page_title' => 'Apex & Woo',
            'menu_title' => 'Apex & Woo',
            'menu_slug' => 'wc-apex-admin',
            'capability' => 'edit_posts',
            'redirect' => false
));

//Add class to admin body if WooCommerce is active
function woo_body_class($classes) {

    $classes .= ' woo-com-active';
    return $classes;
};
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

if(!function_exists('custom_woo_wrapper_close_tag')) :
    function custom_woo_wrapper_close_tag() {
        echo '</main>';
    }
    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
    add_action('woocommerce_after_main_content', 'custom_woo_wrapper_close_tag', 20);
endif;

function add_class_to_pdp($classes)
{

    if (is_product()) {

        $classes[] = 'pdp';
    }
    return $classes;
}

add_filter('body_class', 'add_class_to_pdp');


/**
 * PDP Wrappers
 */
if(!function_exists('custom_before_single_product_summary_wrap_open_tag')) :
    function custom_before_single_product_summary_wrap_open_tag() {
        echo '<section class="row gallery-and-summary-wrap"><div class="block woo-product-image-gallery-wrap colspan-8"><div class="content">';
    }
    add_action('woocommerce_before_single_product_summary', 'custom_before_single_product_summary_wrap_open_tag', 3);
endif;

if(!function_exists('custom_after_single_product_summary_wrap_close_tag')) :
    function custom_after_single_product_summary_wrap_close_tag() {
        echo '</div></div></section>';
    }
    add_action('woocommerce_after_single_product_summary', 'custom_after_single_product_summary_wrap_close_tag', 3);
endif;

if(!function_exists('custom_before_single_product_summary_open_tag')) :
    function custom_before_single_product_summary_open_tag() {
        echo '</div></div><div class="block summary entry-summary colspan-4">';
    }
    add_action('woocommerce_single_product_summary', 'custom_before_single_product_summary_open_tag', 3);
endif;

/**
* Cart Wrappers
*/
if(!function_exists('custom_before_woocommerce_before_cart_tag')) :
    function custom_before_woocommerce_before_cart_tag() {
        echo '<section class="row car-row"><div class="block cart-table"><div class="content">';
    }
    add_action('woocommerce_before_cart', 'custom_before_woocommerce_before_cart_tag', 4);
endif;

if(!function_exists('custom_before_woocommerce_before_cart_collaterals_tag')) :
    function custom_before_woocommerce_before_cart_collaterals_tag() {
        echo '</div></div><div class="block cart-collaterals colspan-3"><div class="content">';
    }
    add_action('woocommerce_before_cart_collaterals', 'custom_before_woocommerce_before_cart_collaterals_tag', 4);
endif;

if(!function_exists('custom_after_woocmmerce_after_cart_tag')) :
    function custom_after_woocmmerce_after_cart_tag() {
        echo '</section>';
    }
    add_action('woocommerce_after_cart', 'custom_after_woocmmerce_after_cart_tag', 4);
endif;


/**
 * Add the Custom fields for Products in WooCommerce backend (COP)
 */
function woocommerce_render_meta_field()
{
    $savePrice = array(
        'id' => '_price_save',
        'label' => 'Bespaar',
        'value' => get_post_meta(get_the_ID(), '_price_save', true)
    );

    $original_sku = array(
        'id' => '_original_sku',
        'label' => 'Oorspronkelijke SKU',
        'value' => get_post_meta(get_the_ID(), '_original_sku', true)
    );

    $inputGDJ = array(
        'id' => '_cop_gdj',
        'label' => 'Inkoopprijs Geerligs & De Jong',
        'value' => get_post_meta(get_the_ID(), '_cop_gdj', true)
    );

    $inputMCW = array(
        'id' => '_cop_mcw',
        'label' => 'Inkoopprijs Model Car Wholesale',
        'value' => get_post_meta(get_the_ID(), '_cop_mcw', true)
    );

    $inputDCC = array(
        'id' => '_cop_dcc',
        'label' => 'Inkoopprijs The Diecast Company',
        'value' => get_post_meta(get_the_ID(), '_cop_dcc', true)
    );

    $inputBevro = array(
        'id' => '_cop_bev',
        'label' => 'Inkoopprijs Bevro',
        'value' => get_post_meta(get_the_ID(), '_cop_bev', true)
    );
    $inputGDJstock = array(
        'id' => '_stock_gdj',
        'label' => 'Voorraad Geerligs & De Jong',
        'value' => get_post_meta(get_the_ID(), '_stock_gdj', true)
    );
    $inputMCWstock = array(
        'id' => '_stock_mcw',
        'label' => 'Voorraad Model Car Wholesale',
        'value' => get_post_meta(get_the_ID(), '_stock_mcw', true)
    );
    $inputBevroStock = array(
        'id' => '_stock_bev',
        'label' => 'Voorraad Bevro',
        'value' => get_post_meta(get_the_ID(), '_stock_bev', true)
    );
    $inputDCCstock = array(
        'id' => '_stock_dcc',
        'label' => 'Voorraad Diecast Company',
        'value' => get_post_meta(get_the_ID(), '_stock_dcc', true)
    );
    $inputGDJ_URL = array(
        'id' => '_url_gdj',
        'label' => 'URL Geerligs & De Jong',
        'value' => get_post_meta(get_the_ID(), '_url_gdj', true)
    );
    $inputMCW_URL = array(
        'id' => '_url_mcw',
        'label' => 'URL Model Car Wholesale',
        'value' => get_post_meta(get_the_ID(), '_url_mcw', true)
    );
    $inputBevro_URL = array(
        'id' => '_url_bev',
        'label' => 'URL Bevro',
        'value' => get_post_meta(get_the_ID(), '_url_bev', true)
    );
    $inputDCC_URL = array(
        'id' => '_url_dcc',
        'label' => 'URL Diecast Company',
        'value' => get_post_meta(get_the_ID(), '_url_dcc', true)
    );

    ?>

    <div id="save_price" class="options_group">
        <?php woocommerce_wp_text_input($savePrice); ?>
    </div>
    <div id="original_sku" class="options_group">
        <?php woocommerce_wp_text_input($original_sku); ?>
    </div>
    <div id="cop_attr" style="background: rgb(225,225,255)" class="options_group">
        <?php woocommerce_wp_text_input($inputGDJ); ?>
    </div>
    <div id="cop_attr" style="background: rgb(225,225,255)" class="options_group">
        <?php woocommerce_wp_text_input($inputGDJstock); ?>
    </div>
    <div id="cop_attr" style="background: rgb(225,225,255)" class="options_group">
        <?php woocommerce_wp_text_input($inputGDJ_URL); ?>
    </div>
    <div id="cop_attr" style="background: rgb(255,225,225)" class="options_group">
        <?php woocommerce_wp_text_input($inputMCW); ?>
    </div>
    <div id="cop_attr" style="background: rgb(255,225,225)" class="options_group">
        <?php woocommerce_wp_text_input($inputMCWstock); ?>
    </div>
    <div id="cop_attr" style="background: rgb(255,225,225)" class="options_group">
        <?php woocommerce_wp_text_input($inputMCW_URL); ?>
    </div>
    <div id="cop_attr" style="background: rgb(225,255,255)" class="options_group">
        <?php woocommerce_wp_text_input($inputBevro); ?>
    </div>
    <div id="cop_attr" style="background: rgb(225,255,255)" class="options_group">
        <?php woocommerce_wp_text_input($inputBevroStock); ?>
    </div>
    <div id="cop_attr" style="background: rgb(225,255,255)" class="options_group">
        <?php woocommerce_wp_text_input($inputBevro_URL); ?>
    </div>
    <div id="cop_attr" style="background: rgb(225,255,225)" class="options_group">
        <?php woocommerce_wp_text_input($inputDCC); ?>
    </div>
    <div id="cop_attr" style="background: rgb(225,255,225)" class="options_group">
        <?php woocommerce_wp_text_input($inputDCCstock); ?>
    </div>
    <div id="cop_attr" style="background: rgb(225,255,225)" class="options_group">
        <?php woocommerce_wp_text_input($inputDCC_URL); ?>
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

add_action('woocommerce_single_product_summary', 'woocommerce_add_attributes_to_summary', 30);

/**
 * Add links to lister pages based on product attributes (SEO)
 */
function seo_links_on_pdp()
{
    global $product;

    echo '<div class="block"><div class="content"><div class="tagcloud">';


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

    echo '</div></div></div>';


}

add_action('woocommerce_after_single_product_summary', 'seo_links_on_pdp', 50);

/***
 * PDP custom product attributes
 */

add_filter( 'wc_product_enable_dimensions_display', '__return_false' );


///**
// * @desc PDP Remove in all product type
// */
//function wc_remove_all_quantity_fields( $return, $product ) {
//    return true;
//}
//add_filter( 'woocommerce_is_sold_individually', 'wc_remove_all_quantity_fields', 10, 2 );
//

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
    $name = str_replace("\"", ' ', $product->name);
    $description = str_replace("\"", ' ', $product->description);
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' );
    $averageRating = $product->average_rating;
    $ratingCount = $product->review_count;
    $price = ($product->sale_price) ? $product->sale_price : $product->regular_price;

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
            $stock_html = '<p><span class="icon-wrap small">' . display_icon('fnd-success-alt') . '</span>' . wp_kses_post($availability) . '</p><p><span class="icon-wrap small">' . display_icon('truck-delivery') . '</span>Op voorrraad</p>';
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
    if (get_field('woo-set-pdp-content', 'option')) :
        $staticID = get_field('woo-set-pdp-content', 'option');
        if (have_rows('flex', $staticID)) :
            $args = ['page-id' => $staticID];
            get_template_part('/acf-flex-content-loop', NULL, $staticID);
        endif;
    endif;

}
//    if ($staticID) :
//
//        if (have_rows('flex', $staticID)):
//            while (have_rows('flex', $staticID)) : the_row();
//
//                $row_layout = get_row_layout();
//
//                if (validateFlexItem(get_sub_field('flex-options'))) :
//
//                    get_template_part('/blocks/' . $row_layout);
//
//                endif;
//
//            endwhile;
//        endif;
//
//    endif;

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
        $availability['availability'] = 'In stock';
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

function woocommerce_in_stock_text()
{

    global $product;

    if ($product->is_type('variable') && $product->get_attribute('pa_manufactured') == 'In-House') :

        echo '<div class="woocommerce-availability"><div class="stock in-stock"><p><span class="icon-wrap small">';
        echo display_icon("fnd-success-alt");
        echo '</span>In stock</p><p><span class="icon-wrap small">';
        echo display_icon("truck-delivery");
        echo '</span>Shipping 6 days a week</p><p><span class="icon-wrap small">';
        echo display_icon("flag-us");
        echo '</span>Made In-House</p></div></div>';

    elseif ($product->is_type('variable')) :

        echo '<div class="woocommerce-availability"><div class="stock in-stock"><p><span class="icon-wrap small">';
        echo display_icon("fnd-success-alt");
        echo '</span>In stock</p><p><span class="icon-wrap small">';
        echo display_icon("truck-delivery");
        echo '</span>Shipping 6 days a week</p></div></div>';

    endif;
}

/**
 * Wrap listerpage in div
 */


function lister_page_open_div()
{
    echo '<div class="block lister-page">';
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

add_action('woocommerce_after_main_content', 'show_filter_on_listerpage', 4);

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
    $defaults['home'] = 'Apex Miniaturen';
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


function show_single_price_on_lister_page() {

    global $product;

    if($product->is_type( 'variable')) :
        echo '<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="starting-at">starting at </span><span class="woocommerce-Price-currencySymbol">$</span>' . $product->get_variation_price() . '</bdi></span>';
    else:

        wc_get_template( 'loop/price.php' );

    endif;

}
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
add_action('woocommerce_after_shop_loop_item_title', 'show_single_price_on_lister_page', 10);

/* PDP Summary */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
add_action('woocommerce_single_product_summary', function () {
    woocommerce_template_custom_loop_rating(true);
}, 5);


//Remove price from variable products

function chooseSizeToSeePrice() {
    echo '<p class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="price-holder"><span style="font-size: 0.9rem; padding: 0 0.4rem 0.2rem 0.4rem; font-weight: normal; display:block;">Choose variation to see price</span></span></bdi></span></p>';

    ?>

        <script>
            jQuery(document).ready(function() {
                let newPrice = '';
                let newPriceVal = '';

                setInterval(function() {
                    newPrice = jQuery('.woocommerce-variation-price bdi').html();
                    if (newPriceVal == '$') {
                        jQuery('choose-size').css('display', 'block');

                    } else {
                        jQuery('choose-size').css('display', 'none');
                    }

                    jQuery('.price-holder').html(newPrice);
                }, 500);

                jQuery('.variations_form select').on('change', function() {
                    if (newPrice == '<span class="woocommerce-Price-currencySymbol">$</span>') {
                        jQuery('choose-size').css('display', 'block');
                    } else {
                        jQuery('choose-size').css('display', 'none');
                    }
                    newPrice = jQuery('.woocommerce-variation-price bdi').html();
                    jQuery('.price-holder').html(newPrice);
                })
            });
        </script>

    <?php

}
function priceVariableProducts() {
    global $product;

    if( $product->is_type( 'variable') && $product->get_variation_price( 'min' ) !== $max_price = $product->get_variation_price( 'max' ) ) :
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
        add_action('woocommerce_single_product_summary', 'chooseSizeToSeePrice', 20);
    endif;

}

add_action('woocommerce_single_product_summary', 'priceVariableProducts', 5);


/**
 * PDP Flex field
 */
function displayFlexLoopOnPdp()
{

    get_template_part('acf-flex-content-loop');

}

add_action('woocommerce_after_single_product_summary', 'displayFlexLoopOnPdp', 3);

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

        $ids[(string)$sku]['id'] = $id;
        $ids[(string)$sku]['stock'] = $wooProduct->get_stock_quantity();
        $ids[(string)$sku]['year'] = $wooProduct->get_attribute( 'pa_jaar' );
        $ids[(string)$sku]['event'] = $wooProduct->get_attribute( 'pa_evenement' );
        $ids[(string)$sku]['driver'] = $wooProduct->get_attribute( 'pa_coureur' );
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

function lister_page_seo_text() {
    $curUrl = $_SERVER['REQUEST_URI'];
    $base_slug = returnCategorySlug($page->ID);
    $wc_options = get_option('woocommerce_permalinks');
    $att_base = '/' . $wc_options['attribute_base'];
    if( (strpos($curUrl, $att_base) !== false )) :

        $attr = substr($curUrl, strlen($att_base) + 1, strlen($curUrl));
        $attri = substr($attr, 0, strpos($attr, '/'));

        //var_dump(get_terms('pa_' . $attri));

    endif;

}
add_action('woocommerce_before_shop_loop', 'lister_page_seo_text', 5 );

function yourOrderHeadingCheckout() {

    echo '<h3>Your order</h3>';
}

add_action('woocommerce_checkout_order_review', 'yourOrderHeadingCheckout', 1);


/*****************************
 * Size chart
 */

function the_size_chart() {

    global $product;
    global $post;
    $output = '';

    $scale = ($product->get_attribute('schaal')) ? $product->get_attribute('schaal') : false;
    $terms = get_the_terms( $post->ID, 'product_cat' );
    $category = $terms[0]->slug;

    $sizechart = [
        '1:43' => [
            'formule-1' => '<td>~ 10-13cm</td><td>~ 5cm</td><td>~ 2-3cm</td>',
            'le-mans-endurance' => '<td>~ 8-11cm</td><td>~ 5cm</td><td>~ 3cm</td>'
        ],
        '1:18' => [
            'formule-1' => '<td>~ 30cm</td><td>~ 10cm</td><td>~ 6cm</td>'
        ]
    ];

    if(array_key_exists($scale, $sizechart) && array_key_exists($category, $sizechart[$scale]) ) :

        $output = '<div class="product-size-chart"><h4>Afmetingen</h4><table class="content-table"><tr><th>Lengte</th><th>Breedte</th><th>Hoogte</th></tr><tr>';
        $output.= $sizechart[$scale][$category];
        $output.= '</tr></table><i>Afmetingen zijn bij benadering.</i></div>';

    endif;

    return $output;

}