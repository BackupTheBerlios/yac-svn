<?php

// GD Graph - Example 31-6
//-------------------------------


function graph($name,$w,$h,$bgc,$fgc,$title,$xtitle,$ytitle,$numX,$xTitles,$xValues,$bc) {
	$top=15;
	$right=5;
	$left=35;
	$bottom=25;
	$image = ImageCreate($w,$h);
	$cols = colours($image);
	ImageFill($image,0,0,$cols[$bgc]);
	drawAxis($image,$w,$h,$cols[$fgc],$top,$right,$left,$bottom);
	drawLines($image,$w,$h,$cols[$fgc],$top,$right,$left,$bottom);	
	drawTitles($image,$w,$h,$cols[$fgc],$title,$xtitle,$ytitle);
	drawXLables($image,$w,$h,$right,$left,$cols[$fgc],$numX,$xTitles);
	$max = calcMaxDataItem($xValues,$numX);
	drawYLables($image,$w,$h,$cols[$fgc],$top,$right,$left,$bottom,$max);	
	drawData($image,$w,$h,$cols[$bc],$top,$right,$left,$bottom,$numX,$xValues,$max);	
	ImageJPEG($image, $name);
	ImageDestroy($image);
}

function colours($image) {
	$white = ImageColorAllocate($image,255,255,255);
	$black = ImageColorAllocate($image,0,0,0);
	$lightblue =  ImageColorAllocate($image,64,64,255);
	$blue = ImageColorAllocate($image,0,0,255);
	$darkblue = ImageColorAllocate($image,0,0,192);
	$red = ImageColorAllocate($image,255,0,0);
	$lightred = ImageColorAllocate($image,255,64,64);
	$darkred = ImageColorAllocate($image,192,0,0);
	$green = ImageColorAllocate($image,0,255,0);
	$lightgreen = ImageColorAllocate($image,64,255,64);
	$darkgreen = ImageColorAllocate($image,0,192,0);
	$yellow = ImageColorAllocate($image,255,255,0);	
	$grey = ImageColorAllocate($image,192,192,192);	
	$darkgrey = ImageColorAllocate($image,128,128,128);	
	$lightgrey = ImageColorAllocate($image,192,192,255);	
	$cols = array($white,$black,$lightblue,$blue,$darkblue,$red,$lightred,$darkred,$green,$lightgreen,$darkgreen,$yellow,$grey,$darkgrey,$lightgrey);
	return $cols;
}


function drawAxis($image, $w, $h, $col, $top,$right,$left,$bottom) {
	ImageRectangle($image,$left,$top,$w-$right,$h-$bottom,$col); 
}


function drawLines($image, $w, $h, $col, $top,$right,$left,$bottom) {
	$gHeight = $h - ($top + $bottom);
	$space = $gHeight / 4; 
	$y = $top;
	for($a=1;$a<5;$a++) {
		ImageLine($image,$left,$y,$w-$right,$y,$col);
		$y=$y+$space;
	}
}

function drawTitles($image,$w,$h,$col,$title,$xtitle,$ytitle) {
	$width = ImageFontWidth(1) * strlen($title);
	$x = ($w - $width)/2;
	ImageString($image,1,$x,3,$title,$col);
	$width = ImageFontWidth(1) * strlen($ytitle);
	$x = ($w - $width)/2;
	ImageString($image,1,$x,$h-10,$ytitle,$col);	
	$height = ImageFontWidth(1) * strlen($xtitle);
	$y = ($h - $height)/2;
	ImageStringUp($image,1,1,$y+$height,$xtitle,$col);	
}

function drawXLables($image,$w,$h,$right,$left,$col,$numX,$xTitles) {
	$graphWidth = $w - ($right+$left);
	$spacing = $graphWidth/$numX;
	$x = $left + ($spacing/4);
	for($a=0;$a<$numX;$a++) {
		ImageString($image,1,$x,$h-20,$xTitles[$a],$col);
		$x=$x+$spacing;
	}
}

function calcMaxDataItem($xValues, $numX) {
	$temp=0;
	for($a=0;$a<$numX;$a++) {
		if($xValues[$a] > $temp)
			$temp = $xValues[$a];
	}
	return $temp;
}

function drawYLables($image,$w,$h,$col,$top,$right,$left,$bottom,$max) {
	$gHeight = $h - ($top + $bottom);
	$space = $gHeight / 4; 
	$y = $top;
	$quater = round($max/4,0);
	for($a=1;$a<5;$a++) {
		$len = strlen($max);
		$width = ImageFontWidth(1) * $len;
		ImageString($image,0,32-$width,$y-2,$max,$col);
		$y=$y+$space;
		$max=$max-$quater;
	}
}


function drawData($image,$w,$h,$col,$top,$right,$left,$bottom,$numX,$xValues,$max) {
	$graphHeight = $h - ($top+$bottom);
	$pixelValue = $graphHeight / $max;
	$graphWidth = $w - ($right+$left);
	$spacing = $graphWidth/$numX;
	$gap = $spacing/4;
	$x = $left + ($spacing/6);
	for($a=0;$a<$numX;$a++) {
		$rectSize = ($graphHeight + $top) - $xValues[$a]*$pixelValue;
		ImageFilledRectangle($image,$x,$rectSize,$x+($spacing-$gap),$h-$bottom,$col);
		$x=$x+$spacing;
	}
}


$xTitles = array("Mon","Tue","Wed","Thu","Fri");
$xValues = array(50,55,78,87,32);
graph("graphics/graph.jpeg", 200, 150, 14,2,"Total Number of Sales","Sales £","Weekdays",5,$xTitles,$xValues,5);

?>
<img src='graphics/graph.jpeg'>










