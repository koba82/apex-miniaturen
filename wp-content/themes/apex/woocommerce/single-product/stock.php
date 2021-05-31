<?php
/**
 * Single Product stock.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/stock.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="stock <?php echo esc_attr( $class ); ?>">

    <?php switch($class) {
        case "in-stock" :
            echo '<p><span class="icon-wrap small">' . display_icon('fnd-success-alt') . '</span>' . wp_kses_post( $availability ) . '</p>';
            echo '<p><span class="icon-wrap small">' . display_icon('truck-delivery') . '</span>Binnen 24 uur verzonden</p>';
            break;
        case "available-on-backorder" :

            $mcwStock = get_post_meta( get_the_ID(), '_stock_mcw', true );
            $gdjStock = get_post_meta( get_the_ID(), '_stock_gdj', true );
            $bevStock = get_post_meta( get_the_ID(), '_stock_bev', true );

            if(strpos($gdjStock, 'Yes') !== false ) :
                echo '<p><span class="icon-wrap small">' . display_icon('fnd-info') . '</span>Op voorraad bij leverancier</p>';
                echo '<p><span class="icon-wrap small">' . display_icon('calendar') . '</span>Levertijd: ca. 5 werkdagen</p>';
            elseif($bevStock !== '' && $bevStock !== NULL && $bevStock !== false ) :
                echo '<p><span class="icon-wrap small">' . display_icon('fnd-info') . '</span>Op voorraad bij leverancier</p>';
                echo '<p><span class="icon-wrap small">' . display_icon('calendar') . '</span>Levertijd: ca. 5 werkdagen</p>';
            elseif(strpos($mcwStock, 'available') !== false ) :
                echo '<p><span class="icon-wrap small">' . display_icon('fnd-info') . '</span>Op voorraad bij leverancier</p>';
                echo '<p><span class="icon-wrap small">' . display_icon('calendar') . '</span>Levertijd: ca. 10 werkdagen</p>';
            else:
                echo '<p><span class="icon-wrap small">' . display_icon('fnd-close-circle') . '</span>' . wp_kses_post( $availability ) . '</p>';
                echo '<p><span class="icon-wrap small">' . display_icon('calendar') . '</span>Helaas is de levertijd op dit moment niet bekend.</p>';
            endif;

            break;
        case "out-of-stock" :
            echo '<p><span class="icon-wrap small">' . display_icon('fnd-close-circle') . '</span>' . wp_kses_post( $availability ) . '</p>';
            echo '<p><span class="icon-wrap small">' . display_icon('calendar') . '</span>Helaas is de levertijd op dit moment niet bekend.</p>';
            break;
        default :

    }; ?>
</div>
