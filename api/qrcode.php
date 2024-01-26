<?php
	require_once('phpqrcode/qrlib.php');

    $content = "http://144.22.137.165/copinha/";
    QRcode::png($content, $outfile = false, $level = QR_ECLEVEL_L, $size = 15,  $margin = 1,  $saveandprint = false);

    
    /*$qrCode = 'qr_img0.50j/php/qr_img.php?';
	$qrCode .= 'd=http://144.22.137.165/copinha/';
	//#QRCODE#
	echo $QRCODE = '<img height="400" width="400" src="' . $qrCode . '" />';*/
    
?>
