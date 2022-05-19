<?php

    if(!isset($component)) :
        $component = $args;
    endif;

    $image = $component['image'];
    $display_caption = $component['caption'];
    $card = ($component['context'] == 'card');
    $lightbox_id = $component['lightbox-id'];
    $size = $component['image-size'];
    $lightbox = $component['lightbox'];
    $orientation = ($image['width'] > $image['height']) ? 'landscape' : 'portrait';
    
?>
<div class="content-image-wrap <?=$orientation?>">
    <?php if($card) : ?>

        <div class="content-image">
            <img src="<?=$image['sizes']['image-1066']?>"
                 srcset="<?=$image['sizes']['image-320']?> 320w,
                        <?=$image['sizes']['image-400']?> 400w,
                        <?=$image['sizes']['image-560']?> 560w" />
        </div>

    <?php elseif($size && $lightbox ) : ?>

        <a href="<?=$image['sizes']['main-image-size']?>" <?php if($lightbox_id) : ?> data-lightbox-id="<?=$lightbox_id?>" <?php endif;?> class="content-image" <?=($image['alt']) ? 'title="' . $image['alt'] . '"' : '';?>>
        <img src="<?=$image['sizes'][$size]?>" />
        <div class="content-image-overlay">
            <div class="icon-wrap medium">
                <?=display_icon('zoom-in')?>
            </div>
        </div>
        </a>

    <?php elseif($lightbox) : ?>
        <a href="<?=$image['sizes']['main-image-size']?>" <?php if($lightbox_id) : ?> data-lightbox-id="<?=$lightbox_id?>" <?php endif;?> class="content-image" <?=($image['alt']) ? 'title="' . $image['alt'] . '"' : '';?>>
            <img src="<?=$image['sizes']['image-1066']?>"
                 srcset="<?=$image['sizes']['image-320']?> 320w,
                        <?=$image['sizes']['image-400']?> 400w,
                        <?=$image['sizes']['image-560']?> 560w,
                        <?=$image['sizes']['image-800']?> 800w,
                        <?=$image['sizes']['image-1066']?> 1066w,
                        <?=$image['sizes']['main-image-size']?> 1300w" />
            <div class="content-image-overlay">
                <div class="icon-wrap medium">
                    <?=display_icon('zoom-in')?>
                </div>
            </div>
        </a>
    <?php elseif(!$lightbox) : ?>
        <div class="content-image" <?=($image['alt']) ? 'title="' . $image['alt'] . '"' : '';?>>
            <img src="<?=$image['sizes']['image-1066']?>"
                 srcset="<?=$image['sizes']['image-320']?> 320w,
                        <?=$image['sizes']['image-400']?> 400w,
                        <?=$image['sizes']['image-560']?> 560w,
                        <?=$image['sizes']['image-800']?> 800w,
                        <?=$image['sizes']['image-1066']?> 1066w,
                        <?=$image['sizes']['main-image-size']?> 1300w" />
        </div>
    <?php endif; ?>

    <?php
    if($image['caption'] && $display_caption ): ?>
        <div class="content-image-text">
            <span class="icon-wrap small"><?= display_icon('notes')?></span><span><?=$image['caption']?></span>
        </div>
    <?php endif;?>
</div>