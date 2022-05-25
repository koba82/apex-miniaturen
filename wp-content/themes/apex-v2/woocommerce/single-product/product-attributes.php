<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-attributes.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.3
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$has_row    = false;
$alt        = 1;
$attributes = $product->get_attributes();

ob_start();

?>
    <table class="shop_attributes">

            <?php if ( $product->has_weight() ) : $has_row = true; ?>
                <tr class="<?php if ( ( $alt = $alt * -1 ) === 1 ) echo 'alt'; ?>">
                    <th><?php _e( 'Weight', 'woocommerce' ) ?></th>
                    <td class="product_weight"><?php echo wc_format_localized_decimal( $product->get_weight() ) . ' ' . esc_attr( get_option( 'woocommerce_weight_unit' ) ); ?></td>
                </tr>
            <?php endif; ?>

            <?php if ( $product->has_dimensions() ) : $has_row = true; ?>
                <tr class="<?php if ( ( $alt = $alt * -1 ) === 1 ) echo 'alt'; ?>">
                    <th><?php _e( 'Dimensions', 'woocommerce' ) ?></th>
                    <td class="product_dimensions"><?php echo $product->get_dimensions(); ?></td>
                </tr>
            <?php endif; ?>

        <?php

        $base_slug = returnCategorySlug($page->ID);
        $wc_options = get_option('woocommerce_permalinks');
        $attribute_base = $wc_options['attribute_base'];

        foreach ( $attributes as $attribute ) :

            $values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
            $value_count = count($values);
            $plural = ($value_count > 1 && wc_attribute_label( $attribute['name']) !== 'Features' && wc_attribute_label( $attribute['name']) !== 'Material' && wc_attribute_label( $attribute['name']) !== 'Washing instructions') ;

            if ( empty( $attribute['is_visible'] ) || $attribute['name'] == 'Original category' || !$attribute['options'] || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) {
                continue;
            } else {
                $has_row = true;
            }
            ?>
            <tr class="<?php if ( ( $alt = $alt * -1 ) == 1 ) echo 'alt'; ?>">
                <th><?php echo ($plural) ? 'Available <span class="plural-attr-names">' : ''; ?><?php echo wc_attribute_label( $attribute['name'] ); ?><?php echo ($plural) ? 's</span>' : ''; ?></th>
                <td><?php
                    if ( $attribute['is_taxonomy'] ) {

                        $values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
                        //echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );

                        $attr_filter_name = str_replace('pa_', '', $attribute['name']);

                        foreach($values as $value) :

                            $value_slug = str_replace(' ', '-', $value);
                            $value_slug = str_replace(':', '-', $value_slug);

                            if($value_slug !== 'Machine-wash' && $value_slug !== 'Machine-dry') :

                                echo '<span class="attr-value-list-item ' . strtolower($value_slug) . '">' . $value . '</span> ';

                            else :

                                echo '<span class="attr-value-list-item ' . strtolower($value_slug) . '"><span class="icon-wrap small">' . display_icon('fnd-water') . '</span>' . $value . '</span> ';

                            endif;

                        endforeach;

                    } else {
                        // Convert pipes to commas and display values
                        $values = array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) );

                        $value_count = count($values);
                        $counter = 1;
                        foreach($values as $value) :

                            $suffix = '';
                            if($counter !== $value_count) :
                                $suffix = ' / ';
                            endif;

                            $value_slug = str_replace(' ', '-', $value);
                            $value_slug = str_replace(':', '-', $value_slug);

                            if($value_slug !== 'machine-wash' && $value_slug !== 'machine-dry') :

                                echo '<span class="attr-value-list-item ' . strtolower($value_slug) . '">' . $value . '</span> ';

                            else :

                                echo '<span class="icon-wrap small">' . display_icon('fnd-water') . '</span><span class="attr-value-list-item ' . strtolower($value_slug) . '">' . $value . '</span> ';

                            endif;

                            $counter++;
                        endforeach;

                        //echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
                    }
                    ?></td>
            </tr>
        <?php endforeach; ?>

    </table>
<?php
if ( $has_row ) {
    echo ob_get_clean();
} else {
    ob_end_clean();
}
