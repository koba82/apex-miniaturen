<?php

    if($args['context'] == 'static-content') :
        $args = array_merge($args, get_sub_field('flex-options'));
    endif;
    $div_start = '<div class="';
    $bgc_value = ($args['flex-bgc-select']) ?: 'no-bgc';
    $column = ($args['column']) ?: 'colspan-12';
    $classlist = ($args['classlist']) ?: array();
    $datalist = ($args['datalist'])?: array();
    $content_align = ($args['content-align']) ?: 'align-left';
    $data_string = '';
    $classlist[] = get_sub_field('flex-text-spotlight');


    $default_classes = [];

    if($args['bgc-extend']) :
        $classlist[] = 'extended-bgc';
        $default_classes = [$content_align, 'block-uid-' . $args['uid'],$column,get_row_layout(),'block'];
    else :
        $default_classes = [$content_align, 'block-uid-' . $args['uid'],$column,$bgc_value,get_row_layout(),'block'];
    endif;

    foreach( $args['margins'] as $margin ) :
        $default_classes[] = $margin;
    endforeach;

    foreach( $default_classes as $class ) :
        array_unshift($classlist, $class);
    endforeach;

    foreach( $datalist as $attr => $value ) :
        $data_string.= $attr . '="' . $value . '" ';
    endforeach;

    if($args['context'] == 'main-content' && get_row_layout() !== 'flex-static-content') :

        echo $div_start . implode(' ', $classlist) . '" ' . $data_string . '>';
        echo $div_start . 'content">';

    elseif($args['context'] == 'static-content' && get_row_layout() !== 'flex-static-content' ) :

        unset($args['classlist'][0]);

        echo $div_start . implode(' ', $classlist) . '" ' .  $data_string . '>';
        echo $div_start . 'content">';

    endif; ?>