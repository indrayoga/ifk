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
        var bulan=$('#bulan').val();
        var tahun=$('#tahun').val();
        var kd_unit_apt=$('#kd_unit_apt').val();
        window.location.href='<?php echo base_url() ?>index.php/transapotek/laporanapt/indikatorobatxls/'+bulan+'/'+tahun+'/'+kd_unit_apt;
    })
});
</script>
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
                                            <h5>LAPORAN INDIKATOR OBAT</h5>
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
                                            <form id="form" class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/laporanapt/indikatorobat">                                                
												
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="span7">
                                                            <div class="control-group">
                                                                <label for="bulan" class="control-label">Periode</label>
                                                                <div class="controls with-tooltip">
                                                                    <select name="bulan" id="bulan" class="input-medium">
                                                                        <option value="01" <?php if($bulan=='01') echo "selected=selected"; ?>>Januari</option>
                                                                        <option value="02" <?php if($bulan=='02') echo "selected=selected"; ?>>Februari</option>
                                                                        <option value="03" <?php if($bulan=='03') echo "selected=selected"; ?>>Maret</option>
                                                                        <option value="04" <?php if($bulan=='04') echo "selected=selected"; ?>>April</option>
                                                                        <option value="05" <?php if($bulan=='05') echo "selected=selected"; ?>>Mei</option>
                                                                        <option value="06" <?php if($bulan=='06') echo "selected=selected"; ?>>Juni</option>
                                                                        <option value="07" <?php if($bulan=='07') echo "selected=selected"; ?>>Juli</option>
                                                                        <option value="08" <?php if($bulan=='08') echo "selected=selected"; ?>>Agustus</option>
                                                                        <option value="09" <?php if($bulan=='09') echo "selected=selected"; ?>>September</option>
                                                                        <option value="10" <?php if($bulan=='10') echo "selected=selected"; ?>>Oktober</option>
                                                                        <option value="11" <?php if($bulan=='11') echo "selected=selected"; ?>>November</option>
                                                                        <option value="12" <?php if($bulan=='12') echo "selected=selected"; ?>>Desember</option>
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
                                                                <th style="text-align:center;vertical-align:middle;"  style="width:5px;">NO</th>
                                                                <th style="text-align:center;vertical-align:middle;"  class="span5">NAMA OBAT</th>
                                                                <?php
                                                                foreach ($puskesmas as $pkm) {
                                                                    # code...
                                                                ?>
                                                                <th style="text-align:center;vertical-align:middle;"  class="span5"><?=$pkm['nama']?></th>                                                                
                                                                <?php
                                                                }
                                                                ?>
                                                            </tr>
                                                                                                                     
                                                        </thead>
                                                        <tbody id="listmutasi">
                                                            <?php
                                                            $no=1;
                                                            foreach ($items as $item) {
                                                            ?>
                                                                <tr style="font-size:80% !important;">
                                                                    <td style="text-align:center;width:5px !important;"><?php echo number_format($no)?></td>
                                                                    <td style="width:25px !important;"><?php echo $item['nama_obat']?></td>
                                                                    <?php
                                                                    foreach ($puskesmas as $pkm) {
                                                                        # code...
                                                                        $indikator = $this->db->query('select sum(qty) as jumlah from apt_penjualan_detail a join apt_penjualan b on a.no_penjualan=b.no_penjualan where b.customer_id="'.$pkm['id'].'" and a.kd_obat="'.$item['kd_obat'].'" and month(b.tgl_penjualan)="'.$bulan.'" and year(b.tgl_penjualan)="'.$tahun.'" ')->row_array();
                                                                        
                                                                    ?>
                                                                    <td style="width:25px !important;"><?php echo number_format($indikator['jumlah'],2,'.',',')?></td> 
                                                                    <?php
                                                                    }
                                                                    ?>                                                                    
                                                                </tr>                                                    
                                                            <?php
                                                            $no++;
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