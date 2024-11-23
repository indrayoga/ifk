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
		$('#form').ajaxForm({
            beforeSubmit: function(a,f,o) {
                o.dataType = "json";
                $('div.error').removeClass('error');
                $('span.help-inline').html('');
                $('#progress').show();
                $('body').append('<div id="overlay1" style="position: fixed;height: 100%;width: 100%;z-index: 1000000;"></div>');
                $('body').addClass('body1');
                z=true;

                if(z==0)return false;
            },
            dataType:  'json',
            success: function(data) {
            //alert(data);
            if (typeof data == 'object' && data.nodeType)
            data = elementToString(data.documentElement, true);
            else if (typeof data == 'object')
            //data = objToString(data);
                if(parseInt(data.status)==1) //jika berhasil
                {
                    //apa yang terjadi jika berhasil
                    $('#progress').hide();
                    $('#overlay1').remove();
                    $('body').removeClass('body1');
                    $('#error').html('<div class="alert alert-success fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>Tutup Bulan Selesai</div>');

                    /*if(parseInt(data.cetak)>0){
                        //window.location.href='<?php echo base_url() ?>third-party/fpdf/penerimaanpenyetoran.php?tahun='+data.tahun+'&bulan='+data.bulan+'&status='+data.statuslap+'';
                        window.open('<?php echo base_url() ?>third-party/fpdf/mutasiobat.php?kd_unit_apt='+data.kd_unit_apt+'&bulan='+data.bulan+'&tahun='+data.tahun+'','_newtab');
                    } */                   
                }
                else if(parseInt(data.status)==0) //jika gagal
                {
                    //apa yang terjadi jika gagal
                    $('#progress').hide();
                    $('#overlay1').remove();
                    $('body').removeClass('body1');
                    $('#error').show();
                    $('#error').html('<div class="alert alert-success fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>'+data.pesan+'</div>');
                }

            }
        });
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
                                            <h5>TUTUP BULAN / PROSES MUTASI OBAT PUSKESMAS</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <!--
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>third-party/fpdf/bukukasumumpenerimaan.php?kd_unit_apt=<?php echo $kd_unit_apt ?>&bulan=<?php echo $bulan; ?>&tahun=<?php echo $tahun; ?>"> <i class="icon-print"></i> PDF</a></li>
                                                    -->
													<!--li><a target="" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/laporanapt/exceltutupbuku/<?php echo $kd_unit_apt=$this->session->userdata('kd_unit_apt'); ?>/<?php echo $bulan; ?>/<?php echo $tahun; ?>"> <i class="icon-print"></i> Export to Excel</a></li-->
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
                                            <form id="form" class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/laporanapt/carimutasiobatpkm">                                                
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
                                                            <div class="control-group">
			                                                    <label for="id_puskesmas" class="control-label">Puskesmas</label>
			                                                    <div class="controls with-tooltip">
																	<select  class="input-xlarge cleared" name="id_puskesmas" id="id_puskesmas">
																			<option value="">Pilih Puskesmas</option>
																			<?php
																			foreach ($datapuskesmas as $puskesmas) {
																				$select="";
																				if(isset($id_puskesmas)){
																					if($id_puskesmas==$puskesmas['id'])$select="selected=selected";else $select="";
																				}
																		
																			?>
																				<option value="<?php if(!empty($puskesmas)) echo $puskesmas['id'] ?>" <?php echo $select; ?>><?php echo $puskesmas['nama'] ?></option>
																			<?php
																			}
																			?>
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
                                                        <button class="btn btn-primary" type="submit" name="submit" value="cari"><i class="icon-search"></i> Mutasi Obat</button>
                                                        <!--button class="btn" type="reset"><i class="icon-undo"></i> Reset</button-->
                                                        <!--button class="btn " type="submit" name="submit1" value="cetak"><i class="icon-print"></i> PDF</button-->
														
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
                                        <div aria-hidden="true" aria-labelledby="approveModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="detilmutasi" style="display: none;width:92%;margin-left:30;left:10px;top:25px;">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                               <!--
                                                <div class="toolbar pull-right" style="height:auto;">
                                                    <ul class="nav nav-tabs">
                                                        <li><button class="btn" href="<?php echo base_url() ?>index.php/penerimaan/tambahpenerimaan"> <i class="icon-plus"></i> Tambah</button></li>
                                                    </ul>
                                                </div>   
                                                -->                 
                                                <h3 id="helpModalLabel"><i class="icon-external-link"></i> Mutasi Obat</h3>
                                            </div>
                                            <div class="modal-body" style="">
                                                <div id="" class="">
                                                    <table id="dataTable" class="table table-bordered responsive" style="position:relative;width:1200;">
                                                        <thead>
                                                            <tr style="font-size:90% !important;">
                                                                <th style="text-align:center;vertical-align:middle;" rowspan="2" style="width:5px;">NO</th>
																<th style="text-align:center;vertical-align:middle;" rowspan="2" class="span5">Nama Obat</th>
																<th style="text-align:center;vertical-align:middle;" rowspan="2" class="span2">SALDO AWAL</th>
																<!--th style="text-align:center;vertical-align:middle;" rowspan="2" class="span2">Harga</th-->
																<!--th style="text-align:center;vertical-align:middle;" rowspan="2" class="span2">TOTAL AWAL</th-->
																<th style="text-align:center;vertical-align:middle;" colspan="4">MASUK</th>
																<!--th style="text-align:center;vertical-align:middle;" rowspan="2" class="span2">TOTAL MASUK</th-->
																<th style="text-align:center;vertical-align:middle;" colspan="4">KELUAR</th>
                                                                <!--th style="text-align:center;vertical-align:middle;" rowspan="2" class="span2">TOTAL KELUAR</th-->
																<th style="text-align:center;vertical-align:middle;" rowspan="2" class="span2">STOK OPNAME</th>
																<th style="text-align:center;vertical-align:middle;" rowspan="2" class="span2">SALDO AKHIR</th>
                                                                <!--th style="text-align:center;vertical-align:middle;" rowspan="2" class="span2">TOTAL AKHIR</th-->
                                                            </tr>
                                                            <tr style="font-size:90% !important;">
                                                                <th style="text-align:center;vertical-align:middle;" rowspan="1" class="span1">PBF</th>
                                                                <th style="text-align:center;vertical-align:middle;" rowspan="1" class="span1">Unit</th>
                                                                <th style="text-align:center;vertical-align:middle;" rowspan="1" class="span1">Retur</th>
                                                                <th style="text-align:center;vertical-align:middle;" rowspan="1" class="span1">Jml</th>
                                                                <th style="text-align:center;vertical-align:middle;" rowspan="1" class="span1">Resep</th>
                                                                <th style="text-align:center;vertical-align:middle;" rowspan="1" class="span1">Unit</th>
                                                                <th style="text-align:center;vertical-align:middle;" rowspan="1" class="span1">Retur</th>
																<th style="text-align:center;vertical-align:middle;" rowspan="1" class="span1">Jml.</th>
                                                            </tr>                                                            
                                                            <!--tr style="font-size:80% !important;">
                                                                <th style="text-align:center;vertical-align:middle;">1</th>
                                                                <th style="text-align:center;vertical-align:middle;">2</th>
                                                                <th style="text-align:center;vertical-align:middle;">3</th>
                                                                <th style="text-align:center;vertical-align:middle;">4</th>
                                                                <th style="text-align:center;vertical-align:middle;">5</th>
                                                                <th style="text-align:center;vertical-align:middle;">6</th>
                                                                <th style="text-align:center;vertical-align:middle;">7</th>
                                                                <th style="text-align:center;vertical-align:middle;">8</th>
                                                                <th style="text-align:center;vertical-align:middle;">9</th>
                                                                <th style="text-align:center;vertical-align:middle;">10</th>
                                                                <th style="text-align:center;vertical-align:middle;">11</th>
                                                                <th style="text-align:center;vertical-align:middle;">12</th>
																<th style="text-align:center;vertical-align:middle;">13</th>
																<th style="text-align:center;vertical-align:middle;">14</th>
																<th style="text-align:center;vertical-align:middle;">15</th>
																<th style="text-align:center;vertical-align:middle;">16</th>
																<th style="text-align:center;vertical-align:middle;">17</th>																
                                                            </tr-->
                                                        </thead>
                                                        <tbody id="listmutasi">
                                                            <?php
                                                            $no=1;
                                                            foreach ($items as $item) {
                                                            ?>
                                                                <tr style="font-size:80% !important;">
                                                                    <td style="text-align:center;width:5px !important;"><?php echo number_format($no)?></td>
																	<td style="width:25px !important;"><?php echo $item['nama_obat']?></td> 
																	<td style="text-align:right;width:15px !important;"><?php echo number_format($item['saldo_awal'],2,'.',',')?></td>
																	<!--?php if($item['harga_beli']=='' or $item['harga_beli']==0 or $item['harga_beli']=='null'){ ?>
																		<td style="text-align:right;width:25px !important;"><-?php echo "-"; ?></td>																		
																	<-?php } else { ?>
																		<td style="text-align:right;width:25px !important;"><-?php echo number_format($item['harga_beli'])?></td>
																	<-?php }?-->
                                                                    
                                                                    <!--td style="text-align:right;width:25px !important;"><?php echo number_format($item['total_awal'],2,'.',',')?></td-->                                                                    
                                                                    <td style="text-align:right;width:15px !important;"><?php echo number_format($item['in_pbf'],2,'.',',')?></td>
                                                                    <td style="text-align:right;width:15px !important;"><?php echo number_format($item['in_unit'],2,'.',',')?></td>
																	<td style="text-align:right;width:15px !important;"><?php echo number_format($item['retur_jual'],2,'.',',')?></td>                                                                   
																	<td style="text-align:right;width:15px !important;"><?php echo number_format($item['jum_masuk'],2,'.',',')?></td>
																	<!--td style="text-align:right;width:25px !important;"><-?php echo number_format($item['total_masuk'])?></td-->
                                                                    <td style="text-align:right;width:15px !important;"><?php echo number_format($item['out_jual'],2,'.',',') ?></td>
																	<td style="text-align:right;width:15px !important;"><?php echo number_format($item['out_unit'],2,'.',',')?></td>
																	<td style="text-align:right;width:15px !important;"><?php echo number_format($item['retur_pbf'],2,'.',',')?></td>
																	<td style="text-align:right;width:15px !important;"><?php echo number_format($item['jum_keluar'],2,'.',',')?></td>
                                                                    <!--td style="text-align:right;width:25px !important;"><-?php echo number_format($item['total_keluar'])?></td-->
																	<td style="text-align:right;width:25px !important;"><?php echo number_format($item['stok_opname'],2,'.',',')?></td>
                                                                    <td style="text-align:right;width:25px !important;"><?php echo number_format($item['saldo_akhir'],2,'.',',')?></td>
																	<!--td style="text-align:right;width:25px !important;"><-?php echo number_format($item['total_akhir'])?></td-->
                                                                </tr>                                                    
                                                            <?php
                                                            $no++;
                                                            }															
                                                            ?>
                                                        </tbody>
														<!--tfoot>
															 <tr>
																<th class="header">&nbsp;</th>
																<th class="header" style="text-align:center;">T O T A L</th>
																<th class="header">&nbsp;</th>
																<th class="header">&nbsp;</th>
																<th class="header">&nbsp;</th>
																<th class="header">&nbsp;</th>
																<th class="header">&nbsp;</th>
																<th class="header">&nbsp;</th>
																<th class="header">&nbsp;</th>
																<th class="header">&nbsp;</th>
																<th class="header">&nbsp;</th>
																<th class="header">&nbsp;</th>
																<th class="header">&nbsp;</th>
															</tr>
													   </tfoot-->
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <!--a target="_blank" class="btn btn-success" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="#" id="detilcetak"> <i class="icon-print"></i> Cetak</a-->
                                                <a class="btn btn-success" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="#" id="detilcetak"> <i class="icon-print"></i> Cetak</a>
												<button aria-hidden="true" data-dismiss="modal" class="btn btn-warning">Close</button>
                                            </div>
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