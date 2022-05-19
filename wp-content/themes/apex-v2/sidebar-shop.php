<?php
/**
 * The sidebar containing the secondary widget area
 *
 * Displays on posts and pages.
 *
 * If no active widgets are in this sidebar, hide it completely.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
 ?>

<?php if(woocommerce_product_loop()) : ?>
    <div class="sidebar">
        <div class="sidebar-filter-button">Filter</div>
        <div class="sidebar-inner">
            <?php dynamic_sidebar('filterbox'); ?>
        </div>
    </div>

        <script>
            jQuery('.sidebar-filter-button').on('click', function() {
                if(jQuery('.sidebar').hasClass('active')) {
                    console.log('has-class');
                    jQuery('.sidebar').removeClass('active');
                } else {
                    jQuery('.sidebar').addClass('active');
                }
            })

            jQuery('.sidebar:not(.active) .sidebar-inner').on('click', function() {
                if(jQuery('.sidebar').hasClass('active')) {
                    jQuery('.sidebar').removeClass('active');
                } else {
                    jQuery('.sidebar').addClass('active');
                    console.log('class added-class');
                }
            })
        </script>

<?php endif; ?>