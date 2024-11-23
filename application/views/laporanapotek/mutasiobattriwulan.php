<style type="text/css">
.fixed {
    position:fixed;
    top:0px !important;
    z-index:100;
    width: 1024px;    
}
.body1{
    opacity: 0.4;
    background-color: #000000;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $('#cetak').click(function(){
        var triwulan=$('#triwulan').val();
        var tahun=$('#tahun').val();
        var kd_unit_apt=$('#kd_unit_apt').val();
        window.location.href='<?php echo base_url() ?>index.php/transapotek/laporanapt/rl1excelmutasitriwulan/'+triwulan+'/'+tahun;
    })
});
</script>
<?php
// echo "<pre>";
//     print_r($items);
//     exit();
if ($triwulan=='1') {
    $per = "PER, 30 MARET ".$tahun;
    $per_saldo_awal_text = '(Per 01 JANUARI '.$tahun.')';
    $per_saldo_akhir_text = '(Per 30 MARET '.$tahun.')';
}else if($triwulan=='2'){
    $per = "PER, 30 JUNI ".$tahun;
    $per_saldo_awal_text = '(Per 01 APRIL '.$tahun.')';
    $per_saldo_akhir_text = '(Per 30 JUNI '.$tahun.')';
}
else if($triwulan=='3'){
    $per = "PER, 30 SEPTEMBER ".$tahun;
    $per_saldo_awal_text = '(Per 01 JULI '.$tahun.')';      
    $per_saldo_akhir_text = '(Per 30 SEPTEMBER '.$tahun.')';
}
else if($triwulan=='4'){
    $per = "PER, 30 DESEMBER ".$tahun;
    $per_saldo_awal_text = '(Per 01 OKTOBER '.$tahun.')';
    $per_saldo_akhir_text = '(Per 30 DESEMBER '.$tahun.')';
}else{
    $per="";
    $per_saldo_awal_text = '';
    $per_saldo_akhir_text = '';
}
?>
			<div id="error"></div>
            <div id="overlay"></div>
            <!-- #content -->
            <div id="content">
                <!-- .outer -->
                <div class="container-fluid outer">
                    <div class="row-fluid">
                        <!-- .inner -->
                        <div class="span12 inner">
                      <!--BEGIN INPUT TEXT FIELDS-->
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header>
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>LAPORAN MUTASI OBAT TRIWULAN</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li>
                                                        <a class="accordion-toggle minimize-box" data-toggle="collapse" href="#div-1">
                                                            <i class="icon-chevron-up"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- /.toolbar value="<-?php echo $periodeawal; ?>"-->
                                        </header>
                                        <div id="div-1" class="accordion-body collapse in body">
                                            <form id="form" class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/laporanapt/mutasiobattriwulan">                                                
												
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="span7">
                                                            <div class="control-group">
                                                                <label for="triwulan" class="control-label">Triwulan</label>
                                                                <div class="controls with-tooltip">
                                                                    <select name="triwulan" id="triwulan" class="input-medium">
                                                                        <option value="1" <?php if($triwulan=='1') echo "selected=selected"; ?>>Triwulan 1</option>
                                                                        <option value="2" <?php if($triwulan=='2') echo "selected=selected"; ?>>Triwulan 2</option>
                                                                        <option value="3" <?php if($triwulan=='3') echo "selected=selected"; ?>>Triwulan 3</option>
                                                                        <option value="4" <?php if($triwulan=='4') echo "selected=selected"; ?>>Triwulan 4</option>
                                                                    </select>
                                                                    <select name="tahun" id="tahun" class="input-small">
                                                                        <option value="<?php echo date('Y'); ?>" <?php if($tahun==date('Y')) echo "selected=selected"; ?>><?php echo date('Y'); ?></option>
                                                                        <option value="<?php echo date('Y')-1; ?>" <?php if($tahun==date('Y')-1) echo "selected=selected"; ?>><?php echo date('Y')-1; ?></option>
                                                                        <option value="<?php echo date('Y')-1; ?>" <?php if($tahun==date('Y')-2) echo "selected=selected"; ?>><?php echo date('Y')-2; ?></option>
                                                                        <option value="<?php echo date('Y')-1; ?>" <?php if($tahun==date('Y')-3) echo "selected=selected"; ?>><?php echo date('Y')-3; ?></option>
                                                                        <option value="<?php echo date('Y')-1; ?>" <?php if($tahun==date('Y')-4) echo "selected=selected"; ?>><?php echo date('Y')-4; ?></option>
                                                                        <option value="<?php echo date('Y')-1; ?>" <?php if($tahun==date('Y')-5) echo "selected=selected"; ?>><?php echo date('Y')-5; ?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>														
                                                    </div>	
														<div id="progress" style="display:none;"></div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">&nbsp;</label>
                                                    <div class="controls with-tooltip">
                                                        <button class="btn btn-primary" type="submit" name="submit" value="cari"><i class="icon-search"></i> Submit</button>
                                                        <button class="btn " type="button" name="submit1" id="cetak" value="cetak"><i class="icon-print"></i> CETAK EXCEL</button>
														
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
								<div id="progress" style="display:none;"></div>
                            </div>
                            <!--END TEXT INPUT FIELD-->                            
                            <!--Begin Datatables-->
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header>
                                            <div class="icons"><i class="icon-move"></i></div>
                                            <h5></h5>
                                        </header>
                                        <div id="collapse4" class="body">
                                                    <table id="dataTable" class="table table-bordered responsive" style="position:relative;width:1200;">
                                                        <thead>
                                                            <tr style="font-size:90% !important;">
                                                                <th rowspan="2" style="text-align:center;vertical-align:middle;"  style="width:5px;">NO</th>
                                                                <th rowspan="2" style="text-align:center;vertical-align:middle;" >URAIAN BARANG</th>
                                                                <th rowspan="2" style="text-align:center;vertical-align:middle;" >SATUAN</th>
                                                                <th colspan="3" style="text-align:center;vertical-align:middle;"  >SALDO AWAL<br><?php echo $per_saldo_awal_text; ?></th>
                                                                <th colspan="3"  style="text-align:center;vertical-align:middle;" >MUTASI BARANG MASUK</th>
                                                                <th colspan="3" style="text-align:center;vertical-align:middle;" >MUTASI BARANG KELUAR</th>
                                                                <th colspan="3" style="text-align:center;vertical-align:middle;" >MUTASI KARANTINA</th>
                                                                <th colspan="3" style="text-align:center;vertical-align:middle;" >SALDO AKHIR<br><?php echo $per_saldo_akhir_text; ?></th>
                                                            </tr>
                                                            <tr style="font-size:90% !important;">
                                                                <th style="text-align:center;vertical-align:middle;"  >Jumlah Satuan</th>
                                                                <th style="text-align:center;vertical-align:middle;"  >Harga Satuan (Rp)</th>
                                                                <th style="text-align:center;vertical-align:middle;" >Jumlah (Rp)</th>
                                                                <th style="text-align:center;vertical-align:middle;" >Jumlah Satuan</th>
                                                                <th style="text-align:center;vertical-align:middle;" >Harga Satuan (Rp)</th>
                                                                <th style="text-align:center;vertical-align:middle;" >Jumlah (Rp)</th>
                                                                <th style="text-align:center;vertical-align:middle;" >Jumlah Satuan</th>
                                                                <th style="text-align:center;vertical-align:middle;">Harga Satuan (Rp)</th>
                                                                <th style="text-align:center;vertical-align:middle;" >Jumlah (Rp)</th>
                                                                <th style="text-align:center;vertical-align:middle;">Jumlah Satuan</th>
                                                                <th style="text-align:center;vertical-align:middle;">Harga Satuan (Rp)</th>
                                                                <th style="text-align:center;vertical-align:middle;" >Jumlah (Rp)</th>
                                                                <th style="text-align:center;vertical-align:middle;">Jumlah Satuan</th>
                                                                <th style="text-align:center;vertical-align:middle;">Harga Satuan (Rp)</th>
                                                                <th style="text-align:center;vertical-align:middle;" >Jumlah (Rp)</th>
                                                            </tr>
                                                                                                                     
                                                        </thead>
                                                        <tbody id="listmutasi">
                                                            <?php
                                                                foreach ($sumberdana as $sd) { 
                                                                    $no=1;
                                                                    ?>

                                                                    <tr style="">
                                                                        <td colspan="3" style="text-align:left; font-weight: bold"><?php echo $sd['nama_unit_apt']?></td>
                                                                        <td colspan="15" style="text-align:center;"></td>
                                                                    </tr>   
                                                            <?php    
                                                                 $hitung_saldo_awal = 0;
                                                                 $hitung_harga_saldo_awal = 0;
                                                                 $hitung_jumlah_saldo_awal = 0;

                                                                 $hitung_mutasi_masuk = 0;
                                                                 $hitung_harga_mutasi_masuk = 0;
                                                                 $hitung_jumlah_mutasi_masuk = 0;

                                                                 $hitung_mutasi_keluar = 0;
                                                                 $hitung_harga_mutasi_keluar = 0;
                                                                 $hitung_jumlah_mutasi_keluar = 0;

                                                                 $hitung_mutasi_karantina = 0;
                                                                 $hitung_harga_mutasi_karantina = 0;
                                                                 $hitung_jumlah_mutasi_karantina = 0;

                                                                 $hitung_saldo_akhir = 0;
                                                                 $hitung_harga_saldo_akhir = 0;
                                                                 $hitung_jumlah_saldo_akhir = 0;
                                                                foreach ($items as $item) {
                                                                    $persediaan=0;
                                                                    $persediaan=$item['saldo_awal'] + $item['in_pbf'];
                                                                    $opt=0;
                                                                    $opt=$item['out_jual']/1;
                                                                    $total=0;
                                                                    $total=$item['saldo_akhir']*$item['harga_beli'];
                                                                   
                                                                    if ($item ['kd_unit_apt']==$sd['kd_unit_apt']) {
                                                                        # code...
                                                                        // $hitung_saldo_awal = $hitung_saldo_awal + $item['saldo_awal'];
                                                                        // $hitung_harga_saldo_awal = $hitung_harga_saldo_awal + $item['harga_beli'];
                                                                        $hitung_jumlah_saldo_awal = $hitung_jumlah_saldo_awal + ($item['saldo_awal']*$item['harga_beli']);

                                                                        // $hitung_mutasi_masuk = $hitung_mutasi_masuk + $item['in_pbf'];
                                                                        // $hitung_harga_mutasi_masuk = $hitung_harga_mutasi_masuk + $item['harga_beli'];
                                                                        $hitung_jumlah_mutasi_masuk = $hitung_jumlah_mutasi_masuk + ($item['in_pbf']*$item['harga_beli']);

                                                                        // $hitung_mutasi_keluar = $hitung_mutasi_keluar + $item['out_jual'];
                                                                        // $hitung_harga_mutasi_keluar = $hitung_harga_mutasi_keluar + $item['harga_beli'];
                                                                        $hitung_jumlah_mutasi_keluar = $hitung_jumlah_mutasi_keluar + ($item['out_jual']*$item['harga_beli']);

                                                                        // $hitung_mutasi_karantina = $hitung_mutasi_karantina + $item['out_disposal'];
                                                                        // $hitung_harga_mutasi_karantina = $hitung_harga_mutasi_karantina + $item['harga_beli'];
                                                                        $hitung_jumlah_mutasi_karantina = $hitung_jumlah_mutasi_karantina + ($item['out_disposal']*$item['harga_beli']);

                                                                        // $hitung_saldo_akhir = $hitung_saldo_akhir + $item['saldo_akhir'];
                                                                        // $hitung_harga_saldo_akhir = $hitung_harga_saldo_akhir + $item['harga_beli'];
                                                                        $hitung_jumlah_saldo_akhir = $hitung_jumlah_saldo_akhir + ($item['saldo_akhir']*$item['harga_beli']);
                                                                ?>
                                                                    <tr style="font-size:80% !important;">
                                                                        <td style="text-align:center;width:5px !important;"><?php echo number_format($no)?></td>
                                                                        <td style="width:25px !important;"><?php echo $item['nama_obat']?></td>
                                                                        <td style="width:25px !important;"><?php echo $item['satuan_kecil']?></td>

                                                                        <td style="text-align:right;width:15px !important;"><?php echo number_format($item['saldo_awal'],2,'.',',')?></td>
                                                                        <td style="text-align:right;width:15px !important;"><?php echo number_format($item['harga_beli'],2,'.',',')?></td>
                                                                        <td style="text-align:right;width:15px !important;"><?php echo number_format($item['saldo_awal']*$item['harga_beli'],2,'.',',')?></td>

                                                                        <td style="text-align:right;width:15px !important;"><?php echo number_format($item['in_pbf'],2,'.',',')?></td>
                                                                        <td style="text-align:right;width:15px !important;"><?php echo number_format($item['harga_beli'],2,'.',',')?></td>
                                                                        <td style="text-align:right;width:15px !important;"><?php echo number_format($item['in_pbf']*$item['harga_beli'],2,'.',',')?></td>

                                                                        <td style="text-align:right;width:15px !important;"><?php echo number_format($item['out_jual'],2,'.',',')?></td>
                                                                        <td style="text-align:right;width:15px !important;"><?php echo number_format($item['harga_beli'],2,'.',',')?></td>
                                                                        <td style="text-align:right;width:15px !important;"><?php echo number_format($item['out_jual']*$item['harga_beli'],2,'.',',')?></td>

                                                                        <td style="text-align:right;width:15px !important;"><?php echo number_format($item['out_disposal'],2,'.',',')?></td>
                                                                        <td style="text-align:right;width:15px !important;"><?php echo number_format($item['harga_beli'],2,'.',',')?></td>
                                                                        <td style="text-align:right;width:15px !important;"><?php echo number_format($item['out_disposal']*$item['harga_beli'],2,'.',',')?></td>

                                                                        <td style="text-align:right;width:15px !important;"><?php echo number_format($item['saldo_akhir'],2,'.',',')?></td>
                                                                        <td style="text-align:right;width:15px !important;"><?php echo number_format($item['harga_beli'],2,'.',',')?></td>
                                                                        <td style="text-align:right;width:15px !important;"><?php echo number_format($item['saldo_akhir']*$item['harga_beli'],2,'.',',')?></td>
                                                                    </tr>
                                                            <?php  $no++;  
                                                                    }
                                                                
                                                                }

                                                            ?>
                                                                <tr>
                                                                    <td colspan="3" style="text-align:center;">Sub Total</td>
                                                                    <td style="text-align:right;"><?php //echo number_format($hitung_saldo_awal,2,'.',',')?></td>
                                                                    <td style="text-align:right;"><?php //echo number_format($hitung_harga_saldo_awal,2,'.',',')?></td>
                                                                    <td style="text-align:right;"><?php echo number_format($hitung_jumlah_saldo_awal,2,'.',',')?></td>

                                                                    <td style="text-align:right;"><?php //echo number_format($hitung_mutasi_masuk,2,'.',',')?></td>
                                                                    <td style="text-align:right;"><?php //echo number_format($hitung_harga_mutasi_masuk,2,'.',',')?></td>
                                                                    <td style="text-align:right;"><?php echo number_format($hitung_jumlah_mutasi_masuk,2,'.',',')?></td>

                                                                    <td style="text-align:right;"><?php //echo number_format($hitung_mutasi_keluar,2,'.',',')?></td>
                                                                    <td style="text-align:right;"><?php //echo number_format($hitung_harga_mutasi_keluar,2,'.',',')?></td>
                                                                    <td style="text-align:right;"><?php echo number_format($hitung_jumlah_mutasi_keluar,2,'.',',')?></td>

                                                                    <td style="text-align:right;"><?php //echo number_format($hitung_mutasi_karantina,2,'.',',')?></td>
                                                                    <td style="text-align:right;"><?php //echo number_format($hitung_harga_mutasi_karantina,2,'.',',')?></td>
                                                                    <td style="text-align:right;"><?php echo number_format($hitung_jumlah_mutasi_karantina,2,'.',',')?></td>

                                                                    <td style="text-align:right;"><?php //echo number_format($hitung_saldo_akhir,2,'.',',')?></td>
                                                                    <td style="text-align:right;"><?php //echo number_format($hitung_harga_saldo_akhir,2,'.',',')?></td>
                                                                    <td style="text-align:right;"><?php echo number_format($hitung_jumlah_saldo_akhir,2,'.',',')?></td>
                                                                </tr>
                                                                                                                    
                                                            <?php
                                                            
                                                            }                                                           
                                                            ?>
                                                        </tbody>
                                                    </table>
                                          </div>
                                    </div>
                                </div>
                            </div>
                            <!--End Datatables-->

                            <hr>
                        </div>
                        <!-- /.inner -->
                    </div>
                    <!-- /.row-fluid -->
                </div>
                <!-- /.outer -->
            </div>
            <!-- /#content -->

			
<script type="text/javascript">
	$('.with-tooltip').tooltip({
		selector: ".input-tooltip"
	});
	
	
	
	var opts = {
      lines: 9, // The number of lines to draw
      length: 40, // The length of each line
      width: 9, // The line thickness
      radius: 0, // The radius of the inner circle
      corners: 1, // Corner roundness (0..1)
      rotate: 0, // The rotation offset
      direction: 1, // 1: clockwise, -1: counterclockwise
      color: '#000', // #rgb or #rrggbb
      speed: 1.4, // Rounds per second
      trail: 54, // Afterglow percentage
      shadow: false, // Whether to render a shadow
      hwaccel: false, // Whether to use hardware acceleration
      className: 'spinner', // The CSS class to assign to the spinner
      zIndex: 2e9, // The z-index (defaults to 2000000000)
      top: 'auto', // Top position relative to parent in px
      left: '470px' // Left position relative to parent in px
    };
    var target = document.getElementById('progress');
    var spinner = new Spinner(opts).spin(target); 
	
</script>