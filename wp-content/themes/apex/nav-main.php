<?php

wp_nav_menu( array(
    'theme_location' => 'main-nav',
    'container_class' => 'nav-wrap',
    'walker' => new Walker_Nav_Menu_Apex()
) );

