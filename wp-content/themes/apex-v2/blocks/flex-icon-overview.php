<?php ?>

        <?php

            include locate_template('./icons/icons.php');


            foreach($icons as $key => $value) :

        ?>

                <div class="icon-overview-wrap">
                    <span class="icon-wrap large"><?php echo $value; ?></span>

                    <span class="icon-code"><?php echo $key; ?></span>

                </div>

             <?php
                endforeach;
             ?>

