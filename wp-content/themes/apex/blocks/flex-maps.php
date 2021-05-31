<?php 
$marker_address = get_sub_field('flex-maps-address');
$maps_width = get_sub_field('flex-maps-width');
$maps_height = get_sub_field('flex-maps-height');
$background_color =  get_sub_field('flex-bgc');
?>

<section class="content-wrap block-maps <?php the_sub_Field('flex-bgc'); ?> <?php if($maps_width == 'full') : echo 'full-width bgc'; endif;?>"  style="height:<?=$maps_height; ?>px">

    <?php include 'components/header-and-text.php'; ?>

    <div class="google-maps-wrap">


<div id="map"></div>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?php the_field('google_maps_api_key', 'option'); ?>&callback=initMap&language=nl">
</script>

<script>
    function initMap() {

        let lat = "";
        let lng = "";
        let x = new XMLHttpRequest();
        
        //Get address from user and convert it to url friendly format, then construct the URL
        let addressString = "<?php echo $marker_address; ?>";
        addressString = encodeURIComponent(addressString.trim());
        let geocodeUrl = "https://maps.googleapis.com/maps/api/geocode/xml?address=" + addressString;
        
        x.open("GET", geocodeUrl, true);
        x.onreadystatechange = function () {
            if (x.readyState == 4 && x.status == 200) {
                //Get the latitude and longitude from the XML file
                var doc = x.responseXML;
                lat = doc.getElementsByTagName("lat")[0].textContent;
                lng = doc.getElementsByTagName("lng")[0].textContent;
                        
                //Put the map otions in an array
                let mapOptions = {
                    center: new google.maps.LatLng(lat,lng),
                    zoom: <?php the_sub_field('flex-maps-zoom'); ?>,
                    scrollWheel: false,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                }	
                //Create the map 
                let map = new google.maps.Map(document.getElementById("map"), mapOptions);   
                let image = {
                    url : '<?php echo get_template_directory_uri(); ?>/img/maps-marker.svg',
                    size: new google.maps.Size(42, 54),
                };
                map.setOptions({'scrollwheel': false});
                let myLatLng = new google.maps.LatLng(lat,lng);
                let mapsMarker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    icon: image
                });
            };
        };
        x.send(null);
    }   
    initMap();
    
</script>


    </div>
</section>
