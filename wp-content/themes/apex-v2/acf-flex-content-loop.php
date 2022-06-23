
<?php

    $cols_per_row = [
        'full-width' => 12,
        'colspan-12' => 12,
        'colspan-9' => 9,
        'colspan-8' => 8,
        'colspan-6' => 6,
        'colspan-4' => 4,
        'colspan-3' => 3
    ];

    $col_width_array = array();

    $flex = array();

    $page_id = ($args) ?: get_the_ID();

    $flex = get_field('flex', $page_id);

    $blocks = [];

    if($flex) :

        $block_index = 0;
        $col_counter = 0;

        foreach($flex as $row) :

            if(validateFlexItem($row['flex-options'])) :

                $current_col = $cols_per_row[$row['flex-options']['column']];
                $extend_background_color = $row['flex-options']['bgc-extend'];
                $break_row = in_array('break-row', $row['flex-options']['margins'], true);

                $col_width_array[] = $current_col;
                $col_start = $col_counter;
                $col_counter+= $current_col;

                if(!array_key_exists($block_index,$blocks)) {
                    $blocks[$block_index] = [];
                }

                if(!array_key_exists('colspan', $blocks[$block_index])) {
                    $blocks[$block_index]['colspan'] = $current_col;
                    $blocks[$block_index]['col-start-pos'] = $col_start;
                }

                if(!array_key_exists('first-in-row',$blocks[$block_index])) {
                    $blocks[$block_index]['first-in-row'] = false;
                }

                if($block_index === 0) {
                    $blocks[$block_index]['first-in-row'] = true;
                    $blocks[$block_index]['classlist'][] = 'row';
                }

                if( $break_row || $col_counter === 12 ) :
                    $blocks[$block_index + 1]['first-in-row'] = true;
                    $blocks[$block_index + 1]['classlist'][] = 'row';
                    $blocks[$block_index]['row'] = $row_index;
                    $col_counter = 0;
                elseif($col_counter > 12) :
                    $blocks[$block_index]['row'] = $row_index + 1;
                    $blocks[$block_index]['first-in-row'] = true;
                    $blocks[$block_index]['classlist'][] = 'row';
                    $col_counter = $current_col;
                else :
                    $blocks[$block_index]['row'] = $row_index;
                endif;

                if($extend_background_color) :
                    for($i = $block_index; $i > -1; $i--) :
                        if($blocks[$i]['first-in-row'] && !in_array('bgc-extend', $blocks[$i]['classlist'])) :
                            $blocks[$i]['classlist'][] = 'bgc-extend';
                            $bg_array = explode(' ', $row['flex-options']['flex-bgc-select']);
                            $blocks[$i]['classlist'] = array_unique(array_merge($blocks[$i]['classlist'], $bg_array));
                            break;

                        endif;
                    endfor;
                endif;

                for($i = $block_index; $i > -1; $i--) :
                    if($blocks[$i]['first-in-row']) :
                        $blocks[$i]['classlist'][] = 'contains-' . $row['acf_fc_layout'];
                        $blocks[$i]['classlist'] = array_unique($blocks[$i]['classlist']);
                        break;
                    endif;
                endfor;

                $blocks[$block_index]['type'] = $row['acf_fc_layout'];
                $blocks[$block_index]['bgc'] = ($row['flex-options']['flex-bgc-select']) ?: 'no-bgc';
                $block_index++;

            endif;
        endforeach;
    endif;

    $type_counter = -1;
    $same_block_type_siblings = [];

    foreach($blocks as $key => $block) :

        if($block['first-in-row'] === true) :
            $type_counter++;
        endif;
        $same_block_type_siblings[$type_counter][$block['type']]+= 1 ;

    endforeach;

    $current_row = $block_counter = $cols_per_row_counter = 0;
	if( have_rows('flex', $page_id) ): while ( have_rows('flex', $page_id) ) : $row_data = the_row();

        $flex_options = get_sub_field('flex-options');

        if( validateFlexItem($flex_options) ) :

            $column = ($flex_options['column']) ?: 'colspan-12';
            $bgc_value = ($flex_options['flex-bgc-select']) ?: 'no-bgc';
            $flex_options['uid'] = rand (99999, 999999);
            $flex_options['context'] = 'main-content';
            $flex_options['datalist'] = [
                "data-parent-row-id"                => $current_row,
                "data-block-id"                     => $block_counter,
                "data-cols-per-row"                 => $cols_per_row_counter,
                "data-col-width"                    => $col_width_array[$block_counter],
                "data-same-block-type-siblings"     => $same_block_type_siblings[$current_row][$blocks[$block_counter]['type']]
            ];

            if($blocks[$block_counter]['first-in-row'] === true) :
                echo '<section class="' . implode(' ', $blocks[$block_counter]['classlist']) . '" data-row-id="' . $current_row . '">';
                $cols_per_row_counter = $col_width_array[$block_counter];
                $flex_options['datalist']['data-cols-per-row'] = $cols_per_row_counter;
            endif;

            if($blocks[$block_counter + 1]['first-in-row'] === false && $blocks[$block_counter + 1]['bgc'] !== 'no-bgc') {
                $flex_options['classlist'][] = 'next-sib-has-bgc';
            }

            get_template_part('/blocks/components/block-header', NULL, $flex_options);

            get_template_part('/blocks/' . get_row_layout(), NULL, $flex_options);

            get_template_part('/blocks/components/block-footer', NULL, $flex_options);

            $cols_per_row_counter+= $col_width_array[$block_counter + 1];

            if($blocks[$block_counter + 1]['first-in-row']) :
                echo '</section>';
                $current_row++;
            endif;
            $block_counter++;

        endif;

    endwhile; endif;