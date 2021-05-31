<?php
$usp_header = get_sub_field('flex-usp-header');
$usp_cta_link = get_sub_field('flex-usp-cta-link'); ?>

<section class="content-wrap block-usp <?php getBackgroundColor(); ?>" >
    <div class="content">

        <?php include 'components/header-and-text.php'; ?>

        <div class="usp-content-wrap">

            <?php include 'components/list.php'; ?>

        </div>

        <?php include 'components/button-group.php'; ?>


    </div>
</section>