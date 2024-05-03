<?php
require '../database_connection.php';

$display_query = "SELECT event_id, event_name, event_start_datetime, event_end_datetime,description FROM calendar_event_master";
$results = mysqli_query($con, $display_query);
$count = mysqli_num_rows($results);

if ($count > 0) {
	$data_arr = array();
	$i = 1;
	while ($data_row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
		$data_arr[$i]['event_id'] = $data_row['event_id'];
		$data_arr[$i]['title'] = $data_row['event_name'];
		$data_arr[$i]['start'] = $data_row['event_start_datetime'];
		$data_arr[$i]['end'] = $data_row['event_end_datetime'];
        $data_arr[$i]['description'] = $data_row['description'];
		$data_arr[$i]['color'] = generateLightColor(); // Generate a light color
		$i++;
	}

	$data = array(
		'status' => true,
		'msg' => 'Successfully fetched events!',
		'data' => $data_arr
	);
} else {
	$data = array(
		'status' => false,
		'msg' => 'No events found.'
	);
}
echo json_encode($data);

function generateLightColor() {
    $hue = mt_rand(0, 360); // Random hue value (0-360)
    $saturation = mt_rand(75, 100); // Saturation (75-100 for relatively saturated colors)
    $lightness = mt_rand(75, 85); // Lightness (75-85 for light colors)

    // Convert HSL values to RGB
    $rgb = hslToRgb($hue, $saturation, $lightness);

    // Convert RGB to hex color code
    $color = rgbToHex($rgb);

    return $color;
}

function hslToRgb($h, $s, $l) {
    $h /= 360;
    $s /= 100;
    $l /= 100;

    if ($s == 0) {
        $r = $g = $b = $l;
    } else {
        $var2 = ($l < 0.5) ? ($l * (1 + $s)) : (($l + $s) - ($s * $l));
        $var1 = 2 * $l - $var2;

        $r = hueToRgb($var1, $var2, $h + (1 / 3));
        $g = hueToRgb($var1, $var2, $h);
        $b = hueToRgb($var1, $var2, $h - (1 / 3));
    }

    return array('r' => $r * 255, 'g' => $g * 255, 'b' => $b * 255);
}

function hueToRgb($v1, $v2, $vh) {
    if ($vh < 0) $vh += 1;
    if ($vh > 1) $vh -= 1;
    if ((6 * $vh) < 1) return ($v1 + ($v2 - $v1) * 6 * $vh);
    if ((2 * $vh) < 1) return ($v2);
    if ((3 * $vh) < 2) return ($v1 + ($v2 - $v1) * ((2 / 3) - $vh) * 6);
    return ($v1);
}

function rgbToHex($rgb) {
    return sprintf("#%02x%02x%02x", $rgb['r'], $rgb['g'], $rgb['b']);
}
