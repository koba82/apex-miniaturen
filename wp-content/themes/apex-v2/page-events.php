<?php
/**
 * Template Name: Events

 */

get_header(); ?>



<?php
//Determine what H1 text we will use. First comes custom H1 field called 'H1 Kop', then 'Paginatitel', then Wordpress page title.
if (get_field('h1-text')) {
    $args[0] = get_field('h1-text');
} elseif (get_field('seo-title')) {
    $args[0] = get_field('seo-title');
} else {
    $args[0] = get_the_title();
};
?>

<?php get_template_part('/blocks/block-h1', 'h1-headline', $args) ?>

<main>
    <section class="content">

        <?php
        $events = get_field('events');

        $ordered_events = array();


        foreach( $events as $i => $row ) {
            $ordered_events[ $i ] = $row['event-start-date'];
            $ordered_events[ $i ] = $row['event-end-date'];
            $ordered_events[ $i ] = $row['event-title'];
            $ordered_events[ $i ] = $row['event-description'];
        }

        if(is_array($ordered_events['event-start-date'])) :
            array_multisort( $ordered_events['event-start-date'], SORT_DESC, $events );
        endif;


        if( $events ):
            $past;
            $future = false;

            $today = strtotime(date('j F Y'));?>

            <?php foreach( $events as $i => $row ):
                    if($today <= strtotime($row['event-end-date'])) :
                        $future = true;
                        break;
                    endif;
            endforeach;

            if($future) : ?>
                <div class="future-events-wrap">
                    <h2>Upcoming events</h2>


                    <?php foreach( $events as $i => $row ): ?>

                        <?php
                        $start_date = $row['event-start-date'];
                        $start_date = strtotime($start_date);
                        $end_date = $row['event-end-date'];
                        $end_date = strtotime($end_date);

                        if($today <= $end_date) : ?>

                            <div class="event-wrap">
                                <h4 class="event-title"><?=$row['event-title']; ?></h4>
                                <div class="event-date">
                                    <?php if($start_date == $end_date): ?>
                                        <span class="icon-wrap small"><?php echo display_icon('calendar-event'); ?></span><span class="event-date-text"><?php echo date_i18n("F j Y", $start_date); ?></span>
                                    <?php elseif( date_i18n("F", $start_date) != date_i18n("F", $end_date) ): ?>
                                        <span class="icon-wrap small"><?php echo display_icon('calendar-event'); ?></span><span class="event-date-text"><?php echo date_i18n("F j", $start_date); ?> - <?php echo date_i18n("F j Y", $end_date); ?></span>
                                    <?php else : ?>
                                        <span class="icon-wrap small"><?php echo display_icon('calendar-event'); ?></span><span class="event-date-text"><?php echo date_i18n("F j", $start_date); ?>-<?php echo date_i18n("j Y", $end_date); ?></span>
                                    <?php endif; ?>
                                </div>

                                <p class="event-description"><?=$row['event-description']; ?></p>
                            </div>


                        <?php endif; ?>

                    <?php endforeach;
                else : ?>

                    <div class="future-events-wrap">
                        <strong>There are no future events planned at this moment.</strong><br /><br />

                    </div>

                <?php endif; ?>


            <?php
            $anyPastEvents = false;
            foreach( $events as $i => $row ):
                $start_date = $row['event-start-date'];
                $start_date = strtotime($start_date);
                $end_date = $row['event-end-date'];
                $end_date = strtotime($end_date);

                if($today > $end_date) :
                    $anyPastEvents = true;
                endif;

            endforeach;


            if($anyPastEvents):

                ?>

                <div class="past-events-wrap">
                    <h2>Past events</h2>


                    <?php foreach( $events as $i => $row ): ?>

                        <?php
                        $start_date = $row['event-start-date'];
                        $start_date = strtotime($start_date);
                        $end_date = $row['event-end-date'];
                        $end_date = strtotime($end_date);

                        if($today > $end_date) : ?>

                            <div class="event-wrap">
                                <h3 class="event-title"><?=$row['event-title']; ?></h3>
                                <?php if($start_date == $end_date): ?>
                                    <span class="event-date"><?php echo date_i18n("F j Y", $start_date); ?></span>
                                <?php elseif( date_i18n("F", $start_date) != date_i18n("F", $end_date) ): ?>
                                    <span class="event-date"><?php echo date_i18n("F j", $start_date); ?> - <?php echo date_i18n("F j Y", $end_date); ?></span>
                                <?php else : ?>
                                    <span class="event-date"><?php echo date_i18n("F j", $start_date); ?>-<?php echo date_i18n("j Y", $end_date); ?></span>
                                <?php endif; ?>


                                <p class="event-description"><?=$row['event-description']; ?></p>
                            </div>


                        <?php endif; ?>

                    <?php endforeach; ?>

                </div>
            <?php endif; ?>

        <?php endif; ?>


        </div>
    </section>

    <?php get_template_part('acf-flex-content-loop'); ?>





</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
