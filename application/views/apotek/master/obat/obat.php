<script>
$(document).ready(function() {

    $datapoli=$('#dataTable').dataTable( {
        "sPaginationType": "bootstrap",
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "<?php echo base_url() ?>index.php/masterapotek/obat/dataobat/<?php echo $nama_obat.'/'.$kd_satuan_kecil; ?>",
        //"sAjaxSource": "<?php echo base_url() ?>index.php/poli/ajaxdatapendaftaran/"+$('#kd_pasien').val()+"/"+$('#nama_pasien').val()+"/"+$('#periodeawal').val()+"/"+$('#periodeakhir').val()+"/"+$('#jns_kelamin').val(),
        "sServerMethod": "POST"
        
    } );
    
    $('#btncari').click(function(){
        $("#dataTable").dataTable().fnDestroy();
        if($('#nama_obat').val()=="")nama_obat="NULL";else nama_obat=$('#nama_obat').val();
        if($('#kd_satuan_kecil').val()=="")kd_satuan_kecil="NULL";else kd_satuan_kecil=$('#kd_satuan_kecil').val();
        $datapoli=$('#dataTable').dataTable( {
            "sPaginationType": "bootstrap",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo base_url() ?>index.php/masterapotek/obat/dataobat/"+nama_obat+"/"+kd_satuan_kecil,
            "sServerMethod": "POST"
            
        } );
        $("#dataTable").css('width','100%');
        return false;
    });
} );
</script>
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
                                            <h5>PENCARIAN DATA</h5>							
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
													
																<li><a href="<?php echo base_url() ?>index.php/masterapotek/obat/tambah"> <i class="icon-plus"></i> Tambah Obat</a></li>
													
                                                    <li>
                                                        <a class="accordion-toggle minimize-box" data-toggle="collapse" href="#div-1">
                                                            <i class="icon-chevron-up"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- /.toolbar -->											
                                        </header>
                                        <div id="div-1" class="accordion-body collapse in body">
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/masterapotek/obat">
                                                <div class="control-group">
													<label for="nama_obat" class="control-label">Nama Obat</label>
													<div class="controls with-tooltip">
                                                        <input type="text" id="nama_obat" name="nama_obat" value="<?php if($nama_obat!='NULL') echo $nama_obat ?>" class="span3 input-tooltip" data-original-title="masukkan nama obat yang ingin dicari" data-placement="bottom"/>												
                                                    </div>
												</div>
												<div class="control-group">
													<label for="kd_satuan_kecil" class="control-label">Satuan Obat</label>
													<div class="controls with-tooltip">
														<select id="kd_satuan_kecil" name="kd_satuan_kecil" class="input-large">
															<option value="">--pilih satuan--</option>
															<?php
															foreach ($satuanobat as $sat) {
																# code...
																if ($sat['kd_satuan_kecil']== $kd_satuan_kecil){
																	$cek = "selected=selected";
																}
																else {
																	$cek = "";
																}
															?>
															<option value="<?php echo $sat['kd_satuan_kecil'] ?>" <?php echo $cek; ?>><?php echo $sat['satuan_kecil'] ?></option>
															<?php
															}
															?>
														</select>																	
													</div>
												</div>
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">&nbsp;</label>
                                                    <div class="controls with-tooltip">
                                                        <button id="btncari" class="btn btn-primary" type="submit" name="cari" value="cari"><i class="icon-search"></i> Cari</button>
                                                        <button class="btn " type="submit" name="reset" value="reset"><i class="icon-undo"></i> Reset</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--END TEXT INPUT FIELD-->                            
                            <!--Begin Datatables-->
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header>
                                            <div class="icons"><i class="icon-move"></i></div>
                                            <h5>DAFTAR OBAT</h5>
                                        </header>
                                        <div id="collapse4" class="body">
                                            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th align="center">Kode Obat</th>                                                        
                                                        <th align="center">Kd Produk</th>                                                        
														<th align="center">Nama Obat</th>
														<th>Satuan Obat</th>
														<th>Harga <br> Beli RFS</th>
														<th>Harga <br>Jual RFS</th>
														<th>Harga <br>APBD 1</th>
														<th>Harga <br>APBD 2</th>
														<th>Harga <br>LAIN LAIN</th>
														<th>Harga <br>Program</th>
														<th>Harga <br>APBN</th>
                                                        <th>Isi Satuan</th>
                                                        <th>Satuan Kecil</th>
                                                        <th>Status</th>
														<th>Pilihan</th>
                                                        <th>Barcode</th>
                                                        <th>Indikator Obat</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
												<!--	<?php
														//$no=1;
													//	foreach($items as $item){
														//debugvar($items);
													?>
													<tr>
														<td></TD>
														<td></td>
														<td></td>
														<td align="right"></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td style="text-align:center;width:160px;">
															<!--?php
                                                            //if($this->mobat->isParent('apt_penjualan_detail','kd_obat',$item['kd_obat'])){
                                                            ?-->
                                                            
                                                            <!--?php
                                                           // }else{
                                                            ?-->
                                                          <!--  <a href="<?php // echo base_url() ?>index.php/masterapotek/obat/edit/<?php // echo $item['kd_obat'] ?>" class="btn"><i class="icon-edit"></i> Edit</a>
															<?php //if($this->session->userdata('kd_unit_apt')==$this->session->userdata('kd_unit_apt_gudang')){ ?>
																		<a href="#" onClick="xar_confirm('<?php // echo base_url() ?>index.php/masterapotek/obat/hapus/<?php // echo $item['kd_obat'] ?>','Apakah Anda ingin menghapus data ini?')" class="btn btn-danger"><i class="icon-remove"></i> Hapus</a>
															<?php // } ?>                                                            
															<!--?php
                                                            }
                                                            ?-->			
                                                      <!--  </td>
													</tr>-->
													<?php
															//$no++;
													//	} //tutup foreach
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

<?php //debugvar('d'); ?>


<script type="text/javascript">
	$('#dataTable1').dataTable({
		"aaSorting": [[ 0, "asc" ]],
		"sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "Show _MENU_ entries"
		}
	});
	
    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });
</script>
