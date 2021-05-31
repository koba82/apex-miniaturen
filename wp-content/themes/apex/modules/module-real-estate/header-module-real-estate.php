<?php

//////////////////////////////////////////
//Module:     Real estate
//Part:       Header
//Version:    1.0
///////////////////////////////////////////

    $mod_res_header_img_array = get_field('mod-res-img');
    $mod_res_header_img = $mod_res_header_img_array[0];

?>


    <div class="res-header">
		<div class="header-slider-slide">
			<img src="<?php echo $mod_res_header_img['sizes']['full-screen-size']; ?>" alt="<?php echo $mod_res_header_img['alt']; ?>" />
            <div class="mod-res-header-overlay"></div>
        </div>		

    </div>
    
