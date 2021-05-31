<section class="content-wrap block-table <?php getBackgroundColor(); ?>" >
    <div class="content">

        <?php include 'components/header-and-text.php'; ?>

        <div class="flex-table-wrap">
            <?php
            $table = get_sub_field( 'flex-table-content' );
            if ( $table ) {
                echo '<table border="0">';
                if ( $table['header'] ) {
                    echo '<thead>';
                    echo '<tr>';

                    foreach ( $table['header'] as $th ) {
                        echo '<th>';
                        echo $th['c'];
                        echo '</th>';
                    }

                    echo '</tr>';
                    echo '</thead>';
                }

                echo '<tbody>';
                foreach ( $table['body'] as $tr ) {
                    echo '<tr>';
                    foreach ( $tr as $td ) {
                        echo '<td>';
                        echo $td['c'];
                        echo '</td>';
                    }
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } ?>
        </div>
    </div>
</section>