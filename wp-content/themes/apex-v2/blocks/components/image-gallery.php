<?php
if(!isset($component)) :
    $component = $args;
endif;

$slider_id = rand (9999, 99999);
$id = rand (9999, 99999);
$images = $component['images'];
$display_caption = $component['caption'];

?>

<div class="image-gallery">
    <div class="main-image">
        <div class="content-image-wrap">
            <a href="<?=$images[0]['sizes']['main-image-size']; ?>"
               data-image='{"imageMain" : "<?=$images[0]['sizes']['main-image-size']; ?>",
                            "imageLarge" : "<?=$images[0]['sizes']['image-800']; ?>",
                            "imageThumb" : "<?=$images[0]['sizes']['image-400']; ?>",
                            "imagePosition" : "0",
                            "fancybox" : "<?=$id; ?>"}'
               data-fancybox-start="<?=$id; ?>" class="content-image fancy-box-main-image" <?=($image[0]['alt']) ? 'title="' . $image[0]['alt'] . '"' : '';?>>
                <img src="<?=$images[0]['sizes']['image-800']; ?>"/>
                <div class="content-image-overlay">
                    <div class="icon-wrap medium">
                        <?=display_icon('zoom-in'); ?>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <?php if(count($images) > 1 )  : ?>
        <div class="image-reel flex-slider-<?=$slider_id; ?>">

            <?php $counter = 1;
            foreach($images as $key => $image) : ?>

                <div class="content-image" data-href="<?=$image['sizes']['main-image-size']; ?>">

                    <?php if($counter !== 1) : ?>
                        <a href="<?=$image['sizes']['main-image-size']; ?>" data-fancybox-start="<?=$id; ?>"></a>
                    <?php endif; ?>

                    <img src="<?=$image['sizes']['image-400']; ?>"
                         data-image='{"imageMain" : "<?=$image['sizes']['main-image-size']; ?>",
                                "imageLarge" : "<?=$image['sizes']['image-800']; ?>",
                                "imageThumb" : "<?=$image['sizes']['image-400']; ?>",
                                "imageOriginal" : "<?=$image['url']; ?>",
                                "imagePosition" : "<?php echo $key;?>",
                                "fancybox" : "<?=$id; ?>"}'
                         data-img-main="<?=$image['sizes']['image-800']; ?>" data-img-lg="<?=$image['sizes']['main-image-size']; ?>"/>
                    <div class="content-image-overlay">
                        <div class="icon-wrap medium">
                            <?=display_icon('chevron-up'); ?>
                        </div>
                    </div>
                </div>
            <?php
            $counter++;
            endforeach; ?>
        </div>
    <?php endif; ?>

    <script>
        window.addEventListener('load', function () {

           <?php
            $fancyBoxObject = '';
            foreach($images as $image) :
                $fancyBoxObject.= "{ src : '" . $image['sizes']['main-image-size'] . "', opts : { caption : 'First caption'}},\n";
            endforeach
            ?>

            let fancyBoxData = [<?=$fancyBoxObject?>]
            let thisFancyBoxInstance
            let fancyBoxOffset = false

            function initFancyBox(e) {
                    e.preventDefault();
                    thisFancyBoxInstance = $.fancybox.open(fancyBoxData,
                        {
                            loop : false,
                        }
                    );
                    console.log(fancyBoxOffset);
                    if(fancyBoxOffset && fancyBoxOffset !== "0") {
                        thisFancyBoxInstance.jumpTo(fancyBoxOffset, 0);
                    }
            }

            function setLargeImage(imageData) {
                let mainImage = document.querySelector('.image-gallery .main-image')
                mainImage.setAttribute('data-image', JSON.stringify(imageData));
                mainImage.setAttribute('data-href', imageData['imageMain']);
                mainImage.querySelector('img').setAttribute('src', imageData['imageLarge']);
            }

            let imageReel = document.querySelectorAll('.image-reel .content-image');
            for (let i = 0; i < imageReel.length; i++) {
                imageReel[i].addEventListener("click", function () {
                    let imgData = JSON.parse(this.querySelector('img').getAttribute('data-image'));
                    setLargeImage(imgData);
                    fancyBoxOffset = imgData['imagePosition'];
                });
            }

            document.querySelector('[data-fancybox-start="<?=$id?>"]').addEventListener('click', function(e) {
                initFancyBox(e)
            });

            let variationsFrom = document.querySelector('.variations_form');
            if (variationsFrom) {
                let formVariationsJSON = JSON.parse(document.querySelector('.variations_form').getAttribute('data-product_variations'));
                let options = variationsFrom.querySelectorAll('select');
                options.forEach(function (option) {
                    option.addEventListener("change", function () {
                        let selectedVariation = [];
                        variationsFrom.querySelectorAll('select').forEach(function (e) {
                            let attributeName = e.dataset.attribute_name;
                            Array.from(e.selectedOptions).forEach((el) => {
                                let value = el.getAttribute('value');
                                if (!selectedVariation.includes(attributeName)) {
                                    selectedVariation[attributeName] = value;
                                }
                            })
                        });

                        formVariationsJSON.forEach((formVariation) => {
                            let counter = 0;
                            for (let pa in selectedVariation) {
                                if (formVariation.attributes[pa] == selectedVariation[pa]) {
                                    counter++;
                                    if (counter == Object.keys(selectedVariation).length) {
                                        matchVariationImage(formVariation.image.url)
                                        return;
                                    }
                                }
                            }
                        });

                        function matchVariationImage(needleImage, callback) {
                            let imageReel = document.querySelectorAll('.image-reel .content-image img');
                            imageReel.forEach((img) => {
                                let imgData = JSON.parse(img.getAttribute('data-image'));
                                if (imgData['imageOriginal'] === needleImage) {
                                    setLargeImage(imgData);
                                }
                            });
                        }
                    });
                });
            };




            let elem<?=$id; ?> = document.querySelector('.flex-slider-<?=$slider_id; ?>');
            let flkty<?=$id; ?> = new Flickity( elem<?=$id; ?>, {
                cellAlign: 'left',
                contain: false,
                percentPosition: false,
                freeScroll: true,
                wrapAround: false,
                autoPlay: false,
                pageDots: false,
                prevNextButtons: true,
                groupCells: 3,
                arrowShape: {
                    x0: 10,
                    x1: 60, y1: 50,
                    x2: 60, y2: 50,
                    x3: 60
                }
            });

            jQuery('[data-lightbox-id="<?php echo $id; ?>"]').simpleLightbox({sourceAttr: 'data-href'});

        });
    </script>




</div>


