<?php
//die($content);
/*
$fileimage=fopen('images/logo.png', 'r'); 
$x=fread($fileimage, filesize('images/logo.png'));
$hex=bin2hex($x);
die($hex);
*/
$tmpdir = sys_get_temp_dir(); # ambil direktori temporary untuk simpan file. 
$file = tempnam($tmpdir, 'ctk.doc'); # nama file temporary yang akan dicetak 
$handle = fopen($file, 'w'); 
$condensed = Chr(27) . Chr(33) . Chr(4); 
$pagelength = Chr(27) . Chr(67) . Chr(48). Chr(6); 
$bold1 = Chr(27) . Chr(69); 
$bold0 = Chr(27) . Chr(70); 
$initialized = chr(27).chr(64); 
$condensed1 = chr(15); 
$condensed0 = chr(18); 
$right = chr(27).chr(97).chr(2); 
$left = chr(27).chr(97).chr(0); 
$center = chr(27).chr(97).chr(1); 
$font = chr(27).chr(83).chr(0); 
$margin = chr(27).chr(79); 
$arrdata=array();
$arrdata[0]['no']='01';
$arrdata[1]['no']='02';
$arrdata[0]['nama']='Sanmag Tab';
$arrdata[1]['nama']='Neurosanbe Plus';
$arrdata[0]['harga']='832';
$arrdata[1]['harga']='5717';
$arrdata[0]['qty']='10';
$arrdata[1]['qty']='10';
$Data = $initialized; 
$Data .= $font; 
$Data .= $condensed1; 
//$Data .= $pagelength; 
$Data .= "\n"; 
$data .="                   	1110000000000000111                              
                          111111                 111111                         
                     11111       11111    01111       111111                    
                  1111    1111   00111   101 11   10       1111                 
               1011     101  11   1 110  00  11   00   01     1101              
             101   10    0011    101110  001111  01 1101     1   101            
           101  11 10     01 111                 1   00   11100    101          
         101    101011001  1    11111111111111111    1 10001 0    1  101        
        00        101   1   11111               11111      100    101  00       
      101          10   1111                         1111   01   10110  101     
     10   1111        101                               101    001        01    
    10      10001   101         11000000000000000011      101  1           01   
   10   00001 111 101       100000000001111       1111      101  00001100   01  
   0       111   10      100000000011                         01    0101     0  
  01         1  10     10000010001                             00   01       10 
 10  00111001  10     100011000                                 01  1    111  0 
 0   110110    0     001111001   1 11 1  11  1  101 1 1 1  1     0   1111001   0
 0      1001  01    001111101    1111110 111 0  011 110 1 10     10    111  1  0
01         1  0    101111101     1110  01111 0  101 1 011 111     0  10011111  1
01  01110001 10    00111100      11  11 0111 0    1111101 000     01           1
0     1111   10    00111110      111111 11 001  010 11  011 0     01           1
01  0000111   0    00111100                                       0    111     1
01  1     11  0    100111101    1011 11 11111 111 11 11  1 111    0  00111100  1
 0       101  01    001111101    111 11111111 01111110111111 1   10  01        0
 01   11110    0     000011001                                   0    110000   0
  0  00011011  10     1000110001                                01  1         0 
  01            10      0000010001                             01  111111    10 
   0         10  10       10000000001                         01  100111001  0  
   10  1111001     01       1100000000001111    111111      10   111111     01  
    10    00    0   101         11100000000000000111      101  11  11000   01   
     10  10    001    101                               101    10         01    
       01     01 00001   111                         111   11101 01     10      
        00   00111    111  111111               111111  1   1111100    00       
         101            00      11111111111111111       101          101        
           101         00                                 01  1    101          
             101     101                                  1001   101            
                101                                       1   101               
                  1111                                     1111                 
                      11111                           11111                     
                           1111111             1111111                          ";

$Data .= "\nPOLIKLINIK IBNUSINA (MUARA RAPAK BALIKPAPAN)\n"; 
$Data .= "Faktur Standard Penjualan                                 Tunai\n"; 
$Data .= "Print Date : ".date('d-m-Y h:i:s')."".str_pad("P.2014.01.00009",30," ",STR_PAD_LEFT)."\n"; 
$Data .= "Kasir      : YULI         \n"; 
$Data .= "Pasien     : 00001         \n"; 
$Data .= "---------------------------------------------------------------\n"; 
//$Data .= "No| ".$bold1."COBA CETAK".$bold0." |\n"; 
$Data .= "No.| Nama Item                     | @Harga | Qty  |  Jml Harga\n"; 
$Data .= "---------------------------------------------------------------\n"; 
$subtotal=0;
foreach ($arrdata as $arr) {
	# code...
	$Data .= "".$arr['no']." | ".str_pad($arr['nama'],30," ",STR_PAD_RIGHT)."| ".str_pad($arr['harga'], 7," ",STR_PAD_LEFT)."| ".str_pad($arr['qty'], 5," ",STR_PAD_LEFT)."| ".str_pad($arr['qty']*$arr['harga'], 10," ",STR_PAD_LEFT)."\n"; 
	$subtotal=$subtotal+$arr['qty']*$arr['harga'];
}
//$Data .= "02 | Sanmag Tab                    | 832    | 10   |       8316\n"; 
/*
$Data .= "---------------------------------------------------------------\n"; 
$Data .= "Sub Total                          | Rp. ".str_pad($subtotal, 22," ",STR_PAD_LEFT)."\n"; 
$Data .= "Grand Total                        | Rp. ".str_pad($subtotal, 22," ",STR_PAD_LEFT)."\n"; 
$Data .= "                                   ".str_pad('', 28,"-",STR_PAD_LEFT)."\n"; 
$Data .= "Jumlah Bayar                       | Rp. ".str_pad($subtotal, 22," ",STR_PAD_LEFT)."\n\n"; 
$Data .= "----------------------Terima Kasih ----------------------------\n\n\n\n"; 
*/
fwrite($handle, $Data); 
fclose($handle); 
//die($data);
//copy($file.'images/logo.png', "//192.168.1.3/EPSONLX"); # Lakukan cetak 
//copy($file, "//PLANET-IT/EPSONLX"); # Lakukan cetak 
copy("images/logo.bmp", "//PLANET-IT/EPSONLX"); # Lakukan cetak 
unlink($file);
?>