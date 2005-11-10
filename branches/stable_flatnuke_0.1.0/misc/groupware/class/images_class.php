<?php
echo $_SESSION['project_confirm_ID'];

class images{


	function print_image($text){
	
		$w = 50;
	
		$image = imagecreate($w, 25);
		$light = ImageColorAllocate($image, 255, 255, 0);
		$dark = ImageColorAllocate($image, 0, 0, 0);
		$gray = ImageColorAllocate($image, 0, 0, 0);
		
		ImageFill($image, 0, 0, $light);
		
		$width_two = ImageFontWidth(5) * strlen($text);
		
		$height = ImageFontHeight(100);
		$width = ($w - $width_two)/2;
		
		# vertical lines
		for($x=0; $x<=100; $x+=10){
			ImageLine($image, $x, 0, $x, 100, $dark);
		}
		
		# horizontal lines
		for($x=0; $x<=100; $x+=10){
			ImageLine($image, 0, $x, 100, $x, $dark);
		}
		
		
		ImageString($image, 5, $width, 4, $text, $dark);
		ImagePNG($image, '', 80);
		ImageDestroy($image);
	}	
	
}

/*
// THIS CODE MAKES RANDOM BUBBLES AND NOT LINES

echo $_SESSION['project_confirm_ID'];

class images{


	function print_image($text){
	
		$w = 50;
	
		$image = imagecreate($w, 25);
		$light = ImageColorAllocate($image, 255, 255, 0);
		$dark = ImageColorAllocate($image, 0, 0, 0);
		$gray = ImageColorAllocate($image, 53, 53, 53);
		
		ImageFill($image, 0, 0, $light);
		
		$width_two = ImageFontWidth(5) * strlen($text);
		
		$height = ImageFontHeight(100);
		$width = ($w - $width_two)/2;
		ImageString($image, 5, $width, 4, $text, $dark);
		
		# randomize arcs
		srand((double)microtime() * 1000000);
		
		for ($dots = 1; $dots<200; $dots++){
			$posx = rand(0, 300);
			$posy = rand(0, 300);
			$size = rand(10, 30);
			$col = rand(0, 2);
			
			ImageArc($image, $posx, $posy, $size, $size, 0, 360, $gray);
		}
		
		ImagePNG($image, '', 80);
		ImageDestroy($image);
	}	
	
}

*/

?>