<?php 
    session_start();
$server = "localhost";
$username = "root";
$password = "";
$database = "db_ibnusina_innodb";

// Koneksi dan memilih database di server
mysql_connect($server,$username,$password) or die("Koneksi gagal");
mysql_select_db($database) or die("Database tidak bisa dibuka");


    include 'WebClientPrint.php';
    use Neodynamic\SDK\Web\WebClientPrint;
    use Neodynamic\SDK\Web\Utils;
    use Neodynamic\SDK\Web\DefaultPrinter;
    use Neodynamic\SDK\Web\InstalledPrinter;
    use Neodynamic\SDK\Web\ClientPrintJob;

    // Process request
    // Generate ClientPrintJob? only if clientPrint param is in the query string
    $urlParts = parse_url($_SERVER['REQUEST_URI']);
    
    if (isset($urlParts['query'])){
        $rawQuery = $urlParts['query'];
        if($rawQuery[WebClientPrint::CLIENT_PRINT_JOB]){
            parse_str($rawQuery, $qs);

            $useDefaultPrinter = ($qs['useDefaultPrinter'] === 'checked');
            $printerName = urldecode($qs['printerName']);

            $kd_user=$qs['kd_user'];
            $no_penjualan=$qs['no_penjualan'];

            $queryuser=mysql_query("select pegawai.nama_pegawai from user,pegawai where user.id_pegawai=pegawai.id_pegawai and user.id_user='$kd_user'");
            $rowuser=mysql_fetch_array($queryuser);
            $user=$rowuser['nama_pegawai'];

            $querypenjualan=mysql_query("select no_penjualan, date_format(tgl_penjualan,'%Y-%m-%d') as tgl_penjualan,
                                    date_format(tgl_penjualan,'%H:%i:%s') as jampenjualan,kd_unit_apt,cust_code,resep,shiftapt,
                                    no_resep,kd_dokter,dokter,kd_pasien,nama_pasien,discount,total_transaksi,total_bayar,adm_racik,adm_resep,adm_tuslah,
                                    jum_item_obat,is_lunas,tutup,returapt,no_pendaftaran,jasa_medis,biaya_adm,biaya_kartu from apt_penjualan where no_penjualan='$no_penjualan'");
            $item=mysql_fetch_array($querypenjualan);

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

            //Create ESC/POS commands for sample receipt
            /*$esc = '0x1B'; //ESC byte in hex notation
            $newLine = '0x0A'; //LF byte in hex notation

            $cmds = $esc . "@"; //Initializes the printer (ESC @)
            $cmds .= $esc . '!' . '0x38'; //Emphasized + Double-height + Double-width mode selected (ESC ! (8 + 16 + 32)) 56 dec => 38 hex
            $cmds .= 'BEST DEAL STORES'; //text to print
            $cmds .= $newLine . $newLine;
            $cmds .= $esc . '!' . '0x00'; //Character font A selected (ESC ! 0)
            $cmds .= 'COOKIES                   5.00'; 
            $cmds .= $newLine;
            $cmds .= 'MILK 65 Fl oz             3.78';
            $cmds .= $newLine + $newLine;
            $cmds .= 'SUBTOTAL                  8.78';
            $cmds .= $newLine;
            $cmds .= 'TAX 5%                    0.44';
            $cmds .= $newLine;
            $cmds .= 'TOTAL                     9.22';
            $cmds .= $newLine;
            $cmds .= 'CASH TEND                10.00';
            $cmds .= $newLine;
            $cmds .= 'CASH DUE                  0.78';
            $cmds .= $newLine + $newLine;
            $cmds .= $esc . '!' . '0x18'; //Emphasized + Double-height mode selected (ESC ! (16 + 8)) 24 dec => 18 hex
            $cmds .= '# ITEMS SOLD 2';
            $cmds .= $esc . '!' . '0x00'; //Character font A selected (ESC ! 0)
            $cmds .= $newLine . $newLine;
            $cmds .= '11/03/13  19:53:17';
            */
        $kd_pasien='';
        if($item['kd_pasien']==''){$kd_pasien="-";}
        else{$kd_pasien=$item['kd_pasien'];}
        
        $Data = $initialized; 
        $Data .= $condensed1; 
        //$Data .= $pagelength; 
        $Data .= "POLIKLINIK IBNUSINA (MUARA RAPAK BALIKPAPAN)\n"; 
        $Data .= "Jl Jend A Yani 252 BALIKPAPAN 76123 Mekar Sari\n"; 
        //$Data .= "Kota Balikpapan\n"; 
        $Data .= "Faktur Standard Penjualan                                 Tunai\n"; 
        $Data .= "Print Date : ".date('d-m-Y h:i:s')."".str_pad($no_penjualan,30," ",STR_PAD_LEFT)."\n"; 
        $Data .= "Kasir      : ".$user."         \n"; 
        $Data .= "Pasien     : ".$kd_pasien." / ".$item['nama_pasien']."         \n"; 
        $Data .= "---------------------------------------------------------------\n"; 
        //$Data .= "No| ".$bold1."COBA CETAK".$bold0." |\n"; 
        $Data .= "No.| Nama Item                          | Qty|      Jml Harga\n"; 
        $Data .= "---------------------------------------------------------------\n"; 
        $subtotal=0;
        $no=1;
        $jasamedis=$item['jasa_medis']+$item['biaya_adm']+$item['biaya_kartu'];
        $items=array();
        $queryitems=mysql_query("select apt_obat.nama_obat,apt_penjualan_detail.harga_jual,apt_penjualan_detail.qty,((apt_penjualan_detail.qty*apt_penjualan_detail.harga_jual)+apt_penjualan_detail.adm_resep) as total
                                from apt_penjualan,apt_penjualan_detail,apt_obat where apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and 
                                apt_penjualan_detail.kd_obat=apt_obat.kd_obat and apt_penjualan.no_penjualan='$no_penjualan'");      
        while ($isi=mysql_fetch_array($queryitems)) {
            # code...
            # code...
            $Data .= "".str_pad($no,3," ",STR_PAD_RIGHT)."| ".str_pad(substr($isi['nama_obat'],0,34),35," ",STR_PAD_RIGHT)."| ".str_pad($isi['qty'], 3," ",STR_PAD_LEFT)."| ".str_pad(number_format($isi['total'],2,'.',''), 16," ",STR_PAD_LEFT)."\n"; 
            $subtotal=$subtotal+$isi['total'];
            $no++;
        }
        //foreach ($items as $isi){
        //}
        //$Data .= "02 | Sanmag Tab                    | 832    | 10   |       8316\n"; 
        $Data .= "---------------------------------------------------------------\n"; 
        $Data .= "Sub Total                          | Rp. ".str_pad($subtotal, 22," ",STR_PAD_LEFT)."\n"; 
        $Data .= "Jasa Medis                         | Rp. ".str_pad($jasamedis, 22," ",STR_PAD_LEFT)."\n"; 
        $Data .= "Grand Total                        | Rp. ".str_pad($subtotal+$jasamedis, 22," ",STR_PAD_LEFT)."\n"; 
        $Data .= "                                   ".str_pad('', 28,"-",STR_PAD_LEFT)."\n"; 
        //$Data .= "Jumlah Bayar                       | Rp. ".str_pad($subtotal, 22," ",STR_PAD_LEFT)."\n\n"; 
        $Data .= "----------------------Terima Kasih ----------------------------\n\n\n\n"; 

            //Create a ClientPrintJob obj that will be processed at the client side by the WCPP
            $cpj = new ClientPrintJob();
            //set ESC/POS commands to print...
            //$cpj->printerCommands = $cmds;
            $cpj->printerCommands = $Data;
            $cpj->formatHexValues = true;
            //set client printer
            if ($useDefaultPrinter || $printerName === 'null'){
                $cpj->clientPrinter = new DefaultPrinter();
            }else{
                $cpj->clientPrinter = new InstalledPrinter($printerName);
            }

            //Send ClientPrintJob back to the client
            ob_clean();
            echo $cpj->sendToClient();
            ob_end_flush(); 
            exit();
        }
    }
?>

    <script type="text/javascript">
        var wcppGetPrintersDelay_ms = 5000; //5 sec

        function wcpGetPrintersOnSuccess(){
            // Display client installed printers
            if(arguments[0].length > 0){
                var p=arguments[0].split("|");
                var options = '';
                for (var i = 0; i < p.length; i++) {
                    options += '<option>' + p[i] + '</option>';
                }
                $('#installedPrinters').css('visibility','visible');
                $('#installedPrinterName').html(options);
                $('#installedPrinterName').focus();
                $('#loadPrinters').hide();                                                        
            }else{
                alert("No printers are installed in your system.");
            }
        }

        function wcpGetPrintersOnFailure() {
            // Do something if printers cannot be got from the client
            alert("No printers are installed in your system.");
        }
    </script>