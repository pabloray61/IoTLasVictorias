<?
header('Content-type: image/jpeg');
$size = $_REQUEST['size'];
$foto_url = $_REQUEST['url'];

list ($w, $h) = getImageSize ($foto_url);

if ($size=='c'){
	$width = 87;
	$height = 75;
	if($width / $height < $w / $h){
		$hf = $height;
		$wf = $w * $hf / $h;
	}
	else{
		$wf = $width;
		$hf = $h * $wf / $w;
	}
}
else{
	$width = 608;
	$height = 407;
	
	if($width / $height >= $w / $h){
		$hf = $height;
		$wf = $w * $hf / $h;
	}
	else{
		$wf = $width;
		$hf = $h * $wf / $w;
	}
	
}

//echo "final: " . $wf . " x " . $hf . "<br>"; 
//echo "inicial: " . $w . " x " . $h; 

$thumb = imagecreatetruecolor($wf, $hf);
$source = imagecreatefromjpeg($foto_url);

// Resize
imagecopyresized($thumb, $source, 0, 0, 0, 0, $wf, $hf, $w, $h);

//Output (la grabo en la carpeta de thumbs)
if($size == 'c'){
	imagejpeg($thumb,"",60);
}
else{
	imagejpeg($thumb,"",100);
}
?>