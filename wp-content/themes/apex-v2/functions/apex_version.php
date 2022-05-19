<?php

function apex_version( $arg ) {

    $apex_main_version = "1";
    $apex_sub_version = ".1";
    $apex_version_date = "4-12-2021";

    if( $arg == 'main') :
        return $apex_main_version;
    elseif( $arg == 'sub' ) :
        return $apex_sub_version;
    elseif( $arg == 'date' ) :
        return $apex_version_date;
    endif;
}
