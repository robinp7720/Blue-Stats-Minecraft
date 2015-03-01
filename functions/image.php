<?php
function get_main_colour($source_file){

        $im = ImageCreateFrompng($source_file);

        $imgw = imagesx($im);
        $imgh = imagesy($im);

        // n = total number or pixels

        $n = $imgw*$imgh;
        $colors = array();

        for ($i=0; $i<$imgw; $i++)
        {
                for ($j=0; $j<$imgh; $j++)
                {

                        // get the rgb value for current pixel

                        $rgb = ImageColorAt($im, $i, $j);
                        $color = imagecolorsforindex($im, $rgb);
                        $colors[]=$color;
                }
        }
        $red = 0;
        $green = 0;
        $blue = 0;
        /* Calculate colors red */
        foreach ($colors as $value){
                $red+=$value["red"];
                $green+=$value["green"];
                $blue+=$value["blue"];
        }

        /* Get average of all the colours */
        $red = round($red / $n);
        $green = round($green / $n);
        $blue = round($blue / $n);

        return array("red"=>$red,"green"=>$green,"blue"=>$blue);

}

function HexfromRGB($R, $G, $B){
 
 $R=dechex($R);
 If (strlen($R)<2)
 $R='0'.$R;
 
  $G=dechex($G);
 If (strlen($G)<2)
 $G='0'.$G;
 
 $B=dechex($B);
 If (strlen($B)<2)
 $B='0'.$B;
 
 return '#' . $R . $G . $B;
 

}