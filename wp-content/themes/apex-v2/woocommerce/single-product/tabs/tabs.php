<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>
    <section class="row content-tabs-row bgc bgc-extend additional-color-4 border-top border-bottom">

         <?php
         if(array_key_exists('description', $product_tabs)) : ?>
            <div class="block flex-table no-bgc colspan-6 align-left" data-cols-per-row="6" data-col-width="6">
                <div class="content">
                    <div class="woocommerce-tab-wrap tab-description-wrap">
                        <?php if ( isset( $product_tabs['description']['callback'] ) ) :
                            call_user_func( $product_tabs['description']['callback'], 'description', $product_tabs['description'] );
                        endif; ?>
                    </div>
                </div>
            </div>
        <?php endif;
         if(array_key_exists('additional_information', $product_tabs)) : ?>
            <div class="block flex-table no-bgc colspan-6 align-left" data-cols-per-row="6" data-col-width="6">
                <div class="content">
                    <div class="woocommerce-tab-wrap tab-additional_information-wrap">
                        <?php if ( isset( $product_tabs['additional_information']['callback'] ) ) :
                            call_user_func( $product_tabs['additional_information']['callback'], 'additional_information', $product_tabs['additional_information'] );
                        endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>

    <section class="row content-tabs-row">
        <?php foreach ( $product_tabs as $key => $product_tab ) :
            if($key !== 'additional_information' && $key !== 'description'): ?>
                <section class="content-wrap content-<?=$key;?>-wrap">
                    <div class="content">
                        <div class="woocommerce-tab-wrap tab-<?php echo esc_attr( $key ); ?>-wrap">
                            <?php if ( isset( $product_tab['callback'] ) ) :
                                call_user_func( $product_tab['callback'], $key, $product_tab );
                            endif; ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php do_action( 'woocommerce_product_after_tabs' ); ?>
    </section>
<?php endif; ?>