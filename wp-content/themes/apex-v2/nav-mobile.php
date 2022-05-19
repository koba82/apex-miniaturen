<?php


wp_nav_menu(array(
    'theme_location' => 'main-nav',
    'walker' => new Walker_Nav_Menu_Apex()
));


wp_nav_menu(array(
    'theme_location' => 'top-nav',
    'walker' => new Walker_Nav_Menu_Apex()
));



