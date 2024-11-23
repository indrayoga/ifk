<?php

class Mqrcode extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}

	function getQRCode($kd_unit_apt,$tgl_expire,$batch){
		if($kd_unit_apt=='D03'){$kode=1;} 
		else if($kd_unit_apt=='D02'){$kode=2;} 
		else if($kd_unit_apt=='D05'){$kode=3;} 
		else if($kd_unit_apt=='U02'){$kode=4;} 
		else if($kd_unit_apt=='D06'){$kode=5;} 
		else if($kd_unit_apt=='apb'){$kode=6;} 
		else if($kd_unit_apt=='D08'){$kode=7;} 
		else if($kd_unit_apt=='D07'){$kode=8;} 
		else if($kd_unit_apt=='D09'){$kode=9;} 
		else if($kd_unit_apt=='D10'){$kode=9;} 
		$tgl=explode('-', $tgl_expire);$new_batch=str_replace(" ", "", $batch);
		$new_batch=str_replace("/", "sls", $new_batch);
		$qrcode=$kode.$tgl[1].substr($tgl[0], -2).$new_batch;

		return $qrcode;
	}

	function GenerateQRCode($data){

		//header('Content-type: image/png');

		$tempdir = "temp/"; //Nama folder tempat menyimpan file qrcode
        //if (!file_exists($tempdir)) //Buat folder bername temp
        //mkdir($tempdir);

        //isi qrcode jika di scan
        $codeContents = $data;
        //nama file qrcode yang akan disimpan
        $namaFile=$data.".png";
        //ECC Level
        $level=QR_ECLEVEL_H;
        //Ukuran pixel
        $UkuranPixel=10;
        //Ukuran frame
        $UkuranFrame=4;

        QRcode::png($codeContents, $tempdir.$namaFile, $level, $UkuranPixel, $UkuranFrame); 
		
		//imagepng($QR);
		//imagedestroy($QR);
	}
}
?>