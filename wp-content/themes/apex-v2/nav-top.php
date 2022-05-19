<?php
    wp_nav_menu( array(
        'theme_location' => 'top-nav',
        'container_class' => 'nav-top',
        'walker' => new Walker_Nav_Menu_Apex()
    ));


