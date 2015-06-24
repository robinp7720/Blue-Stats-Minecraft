<?php if (@$_GET["page"]=="player"&&isset($_GET["player"])):?>
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
$config->setDefault("image-src","http://cravatar.eu/avatar/{NAME}/1");
$image_url = str_replace("{NAME}", $_GET["id"], $config->get("image-src"));

$theme["nav"]["color"] = get_main_colour($image_url);
$theme["headers"]["color"] = $theme["nav"]["color"];
$theme["pager"]["color"] = $theme["nav"]["color"];
?>
<style>
	.navbar, .nav-bar-colour{
		background:rgb(<?=$theme["nav"]["color"]["red"]?>,<?=$theme["nav"]["color"]["green"]?>,<?=$theme["nav"]["color"]["blue"]?>);
	}
	.nav>li.active,.nav>li.active>a{
		background:rgb(<?=$theme["nav"]["color"]["red"]+10?>,<?=$theme["nav"]["color"]["green"]+10?>,<?=$theme["nav"]["color"]["blue"]+10?>) !important;
	}
	.pagination>.disabled>span, .pagination>.disabled>span:hover, .pagination>.disabled>span:focus, .pagination>.disabled>a, .pagination>.disabled>a:hover, .pagination>.disabled>a:focus{
		background:rgb(
			<?=$theme["pager"]["color"]["red"]+10?>,
			<?=$theme["pager"]["color"]["green"]+10?>,
			<?=$theme["pager"]["color"]["blue"]+10?>
		);
	}
	.pagination>li>a, .pagination>li>span{
		background:rgb(
			<?=$theme["pager"]["color"]["red"]-5?>,
			<?=$theme["pager"]["color"]["green"]-5?>,
			<?=$theme["pager"]["color"]["blue"]-5?>
		);
	}
	.pagination>.active>a, .pagination>.active>span, .pagination>.active>a:hover, .pagination>.active>span:hover, .pagination>.active>a:focus, .pagination>.active>span:focus{
		background:rgb(
			<?=$theme["pager"]["color"]["red"]-20?>,
			<?=$theme["pager"]["color"]["green"]-20?>,
			<?=$theme["pager"]["color"]["blue"]-20?>
		);
	}
	.pagination>li>a:hover, .pagination>li>span:hover, .pagination>li>a:focus, .pagination>li>span:focus{
		background:rgb(
			<?=$theme["pager"]["color"]["red"]-20?>,
			<?=$theme["pager"]["color"]["green"]-20?>,
			<?=$theme["pager"]["color"]["blue"]-20?>
		);
	}
</style>
<?php endif; ?>