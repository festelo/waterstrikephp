<?php
$ship_path = __DIR__ . "/resources/ship.png";
$cross_path = __DIR__ . "/resources/cross.png";
$font = __DIR__ . "/roboto-regular.ttf";
$font_size = '12';

header('Content-Type: image/jpeg');

function set_images($src_image, $dst_image, $xy_str_array, $width, $height) {
    foreach ($xy_str_array as $xy) {
        $column = intval($xy[0]);
        $row = intval($xy[1]);
        imagecopyresampled($src_image, $dst_image,
            $width * ($column + 1), $height * ($row+1),
            0,0, $width, $height, $width, $height);
    }
}
$ship_image = imagecreatefrompng($ship_path);
$cross_image = imagecreatefrompng($cross_path);
$width = imagesx($ship_image);
$height = imagesy($ship_image);

$image = imagecreatetruecolor($width * 11, $height * 11);
imagealphablending( $image, true );
imagesavealpha( $image, true );
$white = imagecolorallocate($image, 255, 255, 255);
imagefill($image, 0, 0, $white);

set_images($image, $ship_image, str_split($_GET["ships"], 2), $width, $height);
set_images($image, $cross_image, str_split($_GET["crosses"], 2), $width, $height);

$black = imagecolorallocate($image, 233, 14, 91);

foreach (array("А", "Б", "В", "Г", "Д", "Е", "Ж", "З", "И", "К") as $key => $item)
{
    imagettftext($image, $font_size, 0, $width * ($key+1) + 8, 20, $black, $font, $item);
}
for ($i = 1; $i < 11; $i++)
{
    imagettftext($image, $font_size, 0, 4, $height * $i + 20, $black, $font, $i);
}

imagepng($image);
imagedestroy($image);
imagedestroy($ship_image);
imagedestroy($cross_image);