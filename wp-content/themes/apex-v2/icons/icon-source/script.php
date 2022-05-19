<?php

    function delete_all_between($beginning, $end, $string) {
        $beginningPos = strpos($string, $beginning);
        $endPos = strpos($string, $end, $beginningPos + 1 );
        if ($beginningPos === false || $endPos === false) {
            return $string;
        }

        $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

        return delete_all_between($beginning, $end, str_replace($textToDelete, '', $string)); // recursion to ensure all occurrences are replaced
    }


    $icon_dir = __DIR__ . '/tilda/';
    $files = scandir($icon_dir);

    $cats = [
         "1" => "Education",
		 "2" => "Webinar",
		 "3" => "Store",
		 "4" => "Wedding_agency",
		 "5" => "Event agency",
		 "6" => "Beauty_salon",
		 "7" => "Cafe",
		 "8" => "Yoga_class",
		 "9" => "Travel_agency",
		 "10" => "Coworking",
		 "11" => "Music",
		 "12" => "Fitness_centre",
		 "13" => "Photo_studio",
		 "14" => "Hostel",
		 "15" => "Real_estate",
		 "16" => "Сonference",
		 "17" => "Kids_education",
		 "18" => "Video_production",
		 "19" => "Advertising",
		 "20" => "Medicine",
		 "21" => "Renovation",
		 "22" => "Sport",
		 "23" => "Barbershop",
		 "24" => "Finances",
		 "25" => "Car_service",
		 "26" => "Social_networks",
        "27" => "Bullets",
        "28" => "Law",
        "29" => "Tattoo_studio",
        "30" => "System_icons",
        "31" => "Formats",
        "32" => "Professions",
        "33" => "Interior_design",
        "34" => "Veterinary_clinic",
        "35" => "Valentines_day",
        "36" => "Armed_Forces_Day",
        "37" => "FinTech",
        "38" => "Cleaning_services",
        "39" => "Printing_Service",
        "40" => "IT_company",
        "41" => "Hotel",
        "42" => "Restaurant",
        "43" => "Logistics",
        "44" => "Travel",
        "45" => "Quest",
        "46" => "Christmas_New_Year",
        "47" => "Delivery"
    ];

    $counter = 0;

    $svg_collection = [];
    foreach($files as $file) :

        if($file !== '.' && $file !== '..') :


            if($counter < 10000 ) :

                $cat_id = filter_var($file, FILTER_SANITIZE_NUMBER_INT);

                $cat_name = (array_key_exists($cat_id, $cats)) ? $cats[$cat_id] : 'Other';

                $name = substr($file, strrpos($file, '_') + 1);
                $name = str_replace('.svg', '', 'tilda-' . $name);

                $new_icon = file_get_contents($icon_dir . $file);

                $new_icon = delete_all_between('id="', '" ', $new_icon);
                $new_icon = delete_all_between('version=', '" ', $new_icon);
                $new_icon = delete_all_between('xmlns=', '" ', $new_icon);
                $new_icon = delete_all_between('xmlns', '" ', $new_icon);
                $new_icon = delete_all_between('xml:space', 'e"', $new_icon);
                //$new_icon = delete_all_between('style="enable', '" ', $new_icon);
                $new_icon = delete_all_between('<?xml', '?>', $new_icon);
                $new_icon = delete_all_between('<!--', '-->', $new_icon);
                $new_icon = delete_all_between('<!--?xml', '?-->', $new_icon);
                $new_icon = delete_all_between('<style>', '</style>', $new_icon);
                $new_icon = delete_all_between('<title>', '</title>', $new_icon);
                $new_icon = delete_all_between('<defs>', '</defs>', $new_icon);
                $new_icon = delete_all_between('data-name="', '" ', $new_icon);
                $new_icon = str_replace('<!--?xml version="1.0" encoding="iso-8859-1"?-->', "", $new_icon);
                $new_icon = str_replace('#000000', "currentColor", $new_icon);
                $new_icon = str_replace('fill:#FFFFFF', "fill: currentColor", $new_icon);
                $new_icon = delete_all_between('background:new ', ';', $new_icon);
                $new_icon = str_replace('enable-', "fill: currentColor;", $new_icon);
                $new_icon = str_replace('#231F20;', "currentColor;", $new_icon);
                $class_string = strtolower('icon fill-icon tilda-icon ' . $cat_name . ' ' . $name );

                $svg_start_tag = '<svg xmlns="http://www.w3.org/2000/svg" id="tilda-' . $name . '" class="' . $class_string . '" width="100%" height="100%" ';

                if(!strpos($new_icon, 'fill:')) :
                    $svg_start_tag.= 'fill="currentColor" ';
                endif;

                $svg_start = strpos('<svg', $new_icon);
                $new_icon = substr($new_icon, $svg_start, strlen($new_icon));



                $new_icon = str_replace('<svg', $svg_start_tag, $new_icon);

                $svg_collection[strtolower($cat_name)][$name] = $new_icon;

                $counter++;
            endif;

        endif;

    endforeach;

    echo '<pre>';

    $icon_code = '';
    $names_list = '';

    foreach($svg_collection as $key => $categories ) :
        foreach($categories as $name => $icon ) :
            $icon_code.= "'" . $name . "' => '" . "\n";

            $iconmin = str_replace("\n", '', $icon);
            $iconmin = str_replace("\t", '', $iconmin);
            $iconmin = str_replace("  ", '', $iconmin);

            $icon_code.= $iconmin . "',\n";

        endforeach;
    endforeach;

foreach($svg_collection as $key => $categories ) :
    foreach($categories as $name => $icon ) :
        $names_list.= "'" . $name . "',\n";
    endforeach;
endforeach;

echo '<div style="display:flex; color: red; flex-wrap: wrap">';
$icon_counter = 0;
foreach($svg_collection as $key => $categories ) :
    foreach($categories as $name => $icon ) :
        echo '<div style="flex:0 0 7%; padding: 15px">';
        echo $icon . '</div>';
        $icon_counter++;
    endforeach;
endforeach;
echo '</div>';

var_dump($icon_counter);

    file_put_contents(__DIR__ . '/icons.txt', $icon_code );
    file_put_contents(__DIR__ . '/names.txt', $names_list );

