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
	
        var totalretur=0; //var sisa=0;
		/*var transaksi=$('#total_transaksi').val();
		var sumtotal=$('#sumtotal').val();
		if(transaksi=='')transaksi=0;
		if(sumtotal=='')sumtotal=0;*/
        $('.barisjumlah').each(function(){
                var val=$(this).val();
                if(val=='')val=0;
                totalretur=totalretur+parseInt(val);
        });
        $('#jumlahapprove').val(totalretur);
        //$('#totalpenjualan').val(addCommas(totalpenjualan));
		$('#totalretur').val(totalretur);
		
		/*var bayar=parseInt(transaksi)-parseInt(sumtotal);
		$('#sumtotal').val(sumtotal);
		$('#bayar').val(bayar);
		$('#bayar1').val(bayar);
		$('#sisa').val(sisa);*/
		

        $('#form').ajaxForm({
            beforeSubmit: function(a,f,o) {
                o.dataType = "json";
                $('div.error').removeClass('error');
                $('span.help-inline').html('');
                $('#progress').show();
                $('body').append('<div id="overlay1" style="position: fixed;height: 100%;width: 100%;z-index: 1000000;"></div>');
                $('body').addClass('body1');
                var urlnya="<?php echo base_url(); ?>index.php/aptreturobat/periksaretur"; //buat validasi inputan
                //console.log($.param(a));
                //console.log($('#form').serialize());
                z=true;
                $.ajax({
                url: urlnya,
                type:"POST",
                async: false,
                data: $.param(a),
                success: function(data){
                    //alert(data.status);
                    if(parseInt(data.status)==1){
                        z=data.status;
                        //alert('aa');
                        //alert($('input[name="harga"]').val());
                    }else if(parseInt(data.status)==0){
                        //alert('xxx');
                        $('#progress').hide();
                        z=data.status;
                        for(yangerror=0;yangerror<=data.error;yangerror++){
                            $('#'+data.id[yangerror]).siblings('.help-inline').html('<p class="text-error">'+data.pesan[yangerror]+'</p>');
                            $('#'+data.id[yangerror]).parents('row-fluid').focus();
                            //$('#error').html('<div class="alert alert-error fade in"><button data-dismiss="alert" class="close" type="button"><i class="iconic-x"></i></button>Terdapat beberapa kesalahan input silahkan cek inputan anda</div>');                                 
                        }
                        $('#error').html('<div class="alert alert-error fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>'+data.pesanatas+'<br/>'+data.pesanlain+'</div>');

                        if(parseInt(data.clearform)==1){
                            //$('#form').resetForm();
                            $('input').live('keydown', function(e) {
                                if(e.keyCode == 13){
                                    return false;                                    
                                }
                            });

                            $('#form .cleared').clearFields();
                        }
                        $('#overlay1').remove();
                        $('body').removeClass('body1');
                    }
                },
                dataType: 'json'
                });

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
                    $('#error').show();
                    $('#error').html('<div class="alert alert-success fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>'+data.pesan+'</div>');
                    if(parseInt(data.keluar)>0){
                        window.location.href='<?php echo base_url(); ?>index.php/aptreturobat';
                    }
                    /*if(parseInt(data.simpanbayar)>0){
                        window.location.href='<?php echo base_url(); ?>index.php/aptreturobat/ubahreturobat/'+data.no_retur;
                    }*/

                    $('#no_retur').val(data.no_retur);
                    //$('#btn-cetak').removeAttr('disabled');
                   // $('#btn-cetak').attr('href','<?php echo base_url() ?>third-party/fpdf/cetakbill.php?no_penjualan='+data.no_penjualan+'');
                  //  $('#btn-cetakkwitansi').removeAttr('disabled');
                    $('#btn-tutuptrans').removeAttr('disabled');

                    if(parseInt(data.posting)==1){
                        $('#btn-tutuptrans').attr('value','bukatrans');
                        $('#btn-tutuptrans').text('Buka Trans');
                        $('#btn-cetak').removeAttr('disabled');
                        //$('#btn-cetak').attr('href','<?php echo base_url() ?>third-party/fpdf/cetakbill.php?no_penjualan='+data.no_penjualan+'');
                        //$('#btn-cetakkwitansi').removeAttr('disabled');
                        //$('#btn-bayar').removeAttr('disabled');
                        window.location.href='<?php echo base_url(); ?>index.php/aptreturobat/ubahreturobat/'+data.no_retur;
                    }
                    if(parseInt(data.posting)==2){
                        //$('#btn-bayar').attr('disabled');                        
                        $('#btn-tutuptrans').attr('value','tutuptrans');
                        $('#btn-tutuptrans').text('Tutup Trans');
                        window.location.href='<?php echo base_url(); ?>index.php/aptreturobat/ubahreturobat/'+data.no_retur;
                    }
                    //if(parseInt(data.cetak)>0){
                        //window.location.href='<?php echo base_url(); ?>index.php/loket/cetakregisterpasienxls/'+data.kd_pendaftaran;  
                        //window.open('<?php echo base_url(); ?>index.php/loket/cetakregisterpasienxls/'+data.kd_pendaftaran,'_newtab');                  
                        //window.location.href='<?php echo base_url(); ?>index.php/loket/';                       
                   // }else{
                       // window.location.href='<?php echo base_url(); ?>index.php/loket/';                       
                   // }
                    
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
<style type="text/css">.datepicker{z-index:1151;}</style>
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
						<form class="form-horizontal"  id="form" method="POST" action="<?php echo base_url() ?>index.php/aptreturobat/simpanreturobat">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header class="top" style="">
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>Retur Obat / Alkes </h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/aptreturobat/"> <i class="icon-list"></i> Daftar</a></li>
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/aptreturobat/tambahreturobat"> <i class="icon-plus"></i> Tambah</a></li>
                                                    <li><button <?php if($this->mreturapt->isPosted($no_retur))echo "disabled"; ?> class="btn" id="simpan" type="submit"  name="submit" value="simpan"> <i class="icon-save"></i> Simpan</button></li>
                                                    <li><button <?php if($this->mreturapt->isPosted($no_retur))echo "disabled"; ?> class="btn" type="submit" name="submit" value="simpankeluar"> <i class="icon-save icon-share-alt"></i> Simpan &amp; Keluar</button></li>
                                                    <!--
                                                    <li><button class="btn" type="submit" name="submit" value="hapus"> <i class="icon-remove"></i> Hapus</button></li>
                                                    
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="#" onclick="xar_confirm('<?php echo base_url() ?>index.php/penerimaan/hapus','Apa anda yakin akan menghapus data ini?')"> <i class="icon-remove"></i> Hapus</a></li>
                                                    -->
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" data-toggle="modal" data-original-title="Pencarian" data-placement="bottom" rel="tooltip" href="#pencarian"> <i class="icon-search"></i> Pencarian</a></li>
                                                    <!--li><a <-?php if(!$this->mpenjualan->isPosted($no_penjualan))echo "disabled"; ?> class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" data-toggle="modal" data-original-title="Pembayaran" data-placement="bottom" rel="tooltip" href="<-?php if(empty($disable)){ ?>#pembayaranform<-?php } ?>"> <i class="icon-ok"></i> Bayar</a></li-->
                                                    <?php
                                                    if($this->mreturapt->isPosted($no_retur)){
                                                    ?>
                                                    <li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="bukatrans" <?php if(empty($no_retur)){ ?>disabled<?php } ?>> <i class="icon-key"></i> Buka Trans.</a></li>
                                                    <?php
                                                    }else{
                                                    ?>
                                                    <li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="tutuptrans" <?php if(empty($no_retur)){ ?>disabled<?php } ?>> <i class="icon-key"></i> Tutup Trans.</button></li>
                                                    <?php
                                                    }
                                                    ?>
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
											<div class="row-fluid">
												<div class="span12">
													<div class="span5">
														<div class="control-group">
															<label for="no_retur" class="control-label">No. Retur </label>
															<div class="controls with-tooltip">
																<input type="text" name="no_retur" id="no_retur" value="<?php echo $no_retur; ?>" readonly class="span7 input-tooltip" data-original-title="no retur" data-placement="bottom"/>
																<span class="help-inline"></span>																
															</div>
														</div>
													</div>
													<div class="span7">
														<div class="control-group">
															<label for="tgl_retur" class="control-label">Tgl. Retur</label>
															<div class="controls with-tooltip">
																<input type="text" name="tgl_retur" id="tgl_retur" class="input-small input-tooltip cleared" data-original-title="tgl retur" data-mask="99-99-9999" value="<?php if(empty($itemtransaksi['tgl_retur']))echo date('d-m-Y'); else echo convertDate($itemtransaksi['tgl_retur']); ?>" data-placement="bottom"/>
																<span class="help-inline"></span>
																Shift  <input type="text" id="shiftapt" name="shiftapt" value="<?php if(isset($itemtransaksi['shiftapt']))echo $itemtransaksi['shiftapt'] ?>" class="span2 input-tooltip" data-original-title="shift" data-placement="bottom" readonly />
																Tutup Faktur <input type="checkbox" id="posting" name="posting" value="1" <?php echo set_checkbox('posting','1',isset($itemtransaksi['posting'])&& $itemtransaksi['posting']=='1' ? true:false); ?> readonly />
															</div>
														</div>
													</div>
												</div>
											</div>                                                
                                            <div class="row-fluid">
												<div class="span12">
													<div class="span5">
														<div class="control-group">
															<label for="no_penerimaan" class="control-label">No. Penerimaan </label>
															<div class="controls with-tooltip">
																<input type="text" id="no_penerimaan" name="no_penerimaan" value="<?php if(isset($itemtransaksi['no_penerimaan']))echo $itemtransaksi['no_penerimaan'] ?>" class="span7 input-tooltip" data-original-title="no penerimaan" data-placement="bottom" />
																<span class="help-inline"></span>																
															</div>
														</div>
													</div>
													<div class="span7">
														<div class="control-group">
															<label for="kd_supplier" class="control-label">Supplier </label>
															<div class="controls with-tooltip">
																<input <?php if($this->mreturapt->isPosted($no_retur))echo "readonly"; ?> type="text" id="kd_supplier" name="kd_supplier" value="<?php if(isset($itemtransaksi['kd_supplier']))echo $itemtransaksi['kd_supplier'] ?>" class="span2 input-tooltip" data-original-title="kd supplier" data-placement="bottom"/>																
																<input <?php if($this->mreturapt->isPosted($no_retur))echo "readonly"; ?> type="text" id="nama" name="nama" value="<?php if(isset($itemtransaksi['nama']))echo $itemtransaksi['nama'] ?>" class="span9 input-tooltip" data-original-title="nama supplier" data-placement="bottom"/>
																<span class="help-inline"></span>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row-fluid">
												<div class="span12">
													<div class="span5">
														<div class="control-group">
															<label for="tgl_penerimaan" class="control-label">Tgl. Penerimaan </label>
															<div class="controls with-tooltip">
																<input type="text" name="tgl_penerimaan" id="tgl_penerimaan" class="input-small input-tooltip cleared" data-original-title="tgl penerimaan" data-mask="99-99-9999" value="<?php if(empty($itemtransaksi['tgl_penerimaan']))echo date('d-m-Y'); else echo convertDate($itemtransaksi['tgl_penerimaan']); ?>" data-placement="bottom"/>
																<span class="help-inline"></span>	
																Lunas <input type="checkbox" id="lunas" name="lunas" value="1" <?php echo set_checkbox('lunas','1',isset($itemtransaksi['lunas'])&& $itemtransaksi['lunas']=='1' ? true:false); ?> readonly />
															</div>
														</div>
													</div>
													<div class="span7">
														<div class="control-group">
															<label for="keterangan" class="control-label">Keterangan </label>
															<div class="controls with-tooltip">
																<input type="text" id="keterangan" name="keterangan" value="<?php if(isset($itemtransaksi['keterangan']))echo $itemtransaksi['keterangan'] ?>" class="span11 input-tooltip" data-original-title="keterangan" data-placement="bottom"/>
																<span class="help-inline"></span>																	
															</div>															
														</div>
													</div>
												</div>
											</div>
											<div class="row-fluid">
												<div class="span12">													
													<div class="span5">
														<div class="control-group">
															<label for="total_transaksi" class="control-label">Jumlah Transaksi </label>
															<div class="controls with-tooltip">
																<input type="text" id="total_transaksi" name="total_transaksi" value="<?php if(isset($itemtransaksi['jumlah']))echo $itemtransaksi['jumlah'] ?>" class="span7 input-tooltip totaltransaksi cleared" data-original-title="jumlah transaksi" data-placement="bottom" readonly />
																<span class="help-inline"></span>																	
															</div>
														</div>														
													</div>
													<div class="span7">
														<div class="control-group">
															<label for="total_bayar" class="control-label">Jumlah Bayar </label>
															<div class="controls with-tooltip">
																<input type="text" id="total_bayar" name="total_bayar" value="<?php if(isset($itemtransaksi['jumlah']))echo $itemtransaksi['jumlah'] ?>" class="span4 input-tooltip" data-original-title="total bayar" data-placement="bottom" readonly />
																<span class="help-inline"></span>																
															</div>
														</div>
													</div>
												</div>
												<div id="progress" style="display:none;"></div>
											</div>																																
                                        </div>
                                    </div>
									
									<div class="row-fluid">
										<div class="span12">
											<div class="box error">
												<header>
												<!-- .toolbar -->
													<div class="toolbar" style="height:auto;float:left;">
														<ul class="nav nav-tabs">
															<!--li><button class="btn" type="button" id="tambahbaris"> <i class="icon-plus"></i> Tambah Baris</button></li-->
															<li><button class="btn" type="button" id="hapusbaris"> <i class="icon-remove"></i> Hapus Baris</button></li>
														</ul>
													</div>
												<!-- /.toolbar -->
												</header>
												<div class="body collapse in" id="defaultTable">
													<table class="table responsive">
														<thead>
															<tr style="font-size:80% !important;">
																<th class="header" style="width:10px;padding:0 !important;">&nbsp;</th>
																<!--<th class="header" style="width:85px;padding:0 !important;">Kode</th>-->
																<th class="header" style="width:160px;padding:0 !important;">Nama Obat</th>
																<th class="header" style="width:60px;padding:0 !important;text-align:center;">Satuan</th>
																<th class="header" style="width:50px;padding:0 !important;text-align:center;">Tgl.Exp.</th>
																<th class="header" style="width:50px;padding:0 !important;text-align:center;">Qty B</th>
																<th class="header" style="width:50px;padding:0 !important;text-align:center;">Qty K</th>																																
																<th class="header" style="width:60px;padding:0 !important;text-align:center;">Harga</th>
																<th class="header" style="width:60px;padding:0 !important;text-align:center;">Jumlah</th>
																<th class="header" style="width:50px;padding:0 !important;text-align:center;">PPN %</th>
																<th class="header" style="text-align:right;width:60px;padding:0 !important;">Total </th>
															</tr>
														</thead>
														<tbody id="bodyinput">
															<?php
																if(isset($itemsdetiltransaksi)){
																	//$no=1;
																	foreach ($itemsdetiltransaksi as $itemdetil){																			
																	?>
																		<tr style="font-size:80% !important;">
																			<td style="text-align:center;padding:0 !important;"><input type="checkbox" class="barisinput" /></td>
																			<input type="hidden" name="kd_obat[]" value="<?php echo $itemdetil['kd_obat'] ?>" style="width:85px;" class="input-small bariskodeobat cleared">
																			<td style="padding:0 !important;"><input <?php if($this->mreturapt->isPosted($no_retur))echo "readonly"; ?> type="text" name="nama_obat[]" value="<?php echo $itemdetil['nama_obat'] ?>" style="width:250px;" class="input-xlarge barisnamaobat cleared"></td>
																			<td style="padding:0 !important;"><input <?php if($this->mreturapt->isPosted($no_retur))echo "readonly"; ?> type="text" name="satuan_kecil[]" value="<?php echo $itemdetil['satuan_kecil'] ?>" style="width:60px;" class="input-small barissatuan cleared" readonly></td>
																			<td style="padding:0 !important;"><input <?php if($this->mreturapt->isPosted($no_retur))echo "readonly"; ?> type="text" name="tgl_expire[]" value="<?php echo $itemdetil['tgl_expire'] ?>" class="input-small baristanggal cleared"></td>
																			<input <?php if($this->mreturapt->isPosted($no_retur))echo "readonly"; ?> type="hidden" name="pembanding[]" value="<?php echo $itemdetil['pembanding'] ?>" class="input-small barispembanding cleared">
																			<td style="padding:0 !important;"><input <?php if($this->mreturapt->isPosted($no_retur))echo "readonly"; ?> type="text" name="qty_box[]" value="<?php echo $itemdetil['qty_box'] ?>" style="width:50px;" class="input-small barisqtyb cleared"></td>
																			<td style="padding:0 !important;"><input <?php if($this->mreturapt->isPosted($no_retur))echo "readonly"; ?> type="text" name="qty_kcl[]" value="<?php echo $itemdetil['qty_kcl'] ?>" style="width:50px;" class="input-small barisqtyk cleared"></td>																			
																			<td style="padding:0 !important;"><input <?php if($this->mreturapt->isPosted($no_retur))echo "readonly"; ?> type="text" name="harga_beli[]" value="<?php echo $itemdetil['harga_beli'] ?>" class="input-small barishargabeli cleared"></td>																								
																			<td style="padding:0 !important;"><input <?php if($this->mreturapt->isPosted($no_retur))echo "readonly"; ?> type="text" name="jumlah1[]" value="<?php echo $itemdetil['jum'] ?>" class="input-small barisjumlah1 cleared" readonly></td>
																			<td style="padding:0 !important;"><input <?php if($this->mreturapt->isPosted($no_retur))echo "readonly"; ?> type="text" name="ppn_item[]" value="<?php echo $itemdetil['ppn_item'] ?>" style="width:50px;" class="input-small barisppn cleared"></td>
																			<td style="text-align:right;"><input <?php if($this->mreturapt->isPosted($no_retur))echo "readonly"; ?> style="text-align:right;" type="text" name="total[]" value="<?php echo $itemdetil['total1'] ?>" class="input-small barisjumlah cleared" readonly></td>																			
																		</tr>
																	<?php
																		//$no++;
																	}
																}
															?>
														</tbody>
														<tfoot>
															<tr>
																<th colspan="12" style="text-align:right;" class="header">Total (Rp) : <input type="text" class="input-medium cleared" id="totalretur" style="text-align:right" disabled></th>
															</tr>
														</tfoot>
													</table>																									
												</div>
											</div>
										</div>
									</div>	
										
									<div aria-hidden="true" aria-labelledby="helpModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="daftarpenerimaan" style="display: none;width:80%;margin-left:-520px !important;"> 
										<div class="modal-header">
											<button aria-hidden="true" data-dismiss="modal" class="close" type="button">�</button>
											<h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Penerimaan</h3>
										</div>
										<div class="modal-body" style="height:340px;">
											<div class="body" id="collapse4">
												<table id="dataTable1" class="table table-bordered table-condensed table-hover table-striped">
													<thead>
														<tr>						
															<th style="text-align:right;">No. Penerimaan</th>
															<th style="text-align:right;">Tgl. Penerimaan</th>
															<th style="text-align:right;">Supplier</th>
															<th style="text-align:right;">Jumlah Transaksi</th>
															<th style="text-align:right;">Jumlah Bayar</th>
															<th style="width:50px !important;">Pilihan</th>
														</tr>
													</thead>
													<tbody id="listpenerimaan">														
													</tbody>
													<tbody id="listdetil">														
													</tbody>
												</table>
											</div>
										</div>
										<div class="modal-footer">
											<input type="text" id="nama" class="pull-left" autocomplete="off">
											<button aria-hidden="true" data-dismiss="modal" class="btn">Close</button>
										</div>
									</div>
									<!--/div-->
									
                                </div>
                            </div>
                            <!--END TEXT INPUT FIELD-->                            
                                            </form>

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
	
    /*$('#tgl_penerimaan').datepicker({
        format: 'dd-mm-yyyy'
    });*/
	
	$('#tgl_retur').datepicker({
        format: 'dd-mm-yyyy'
    });
	
	function pilihpenerimaan(no_penerimaan,tgl_penerimaan,kd_supplier,nama,total_transaksi,total_bayar) {
		$('#no_penerimaan').val(no_penerimaan);
		$('#tgl_penerimaan').val(tgl_penerimaan);
		$('#kd_supplier').val(kd_supplier);
        $('#nama').val(nama);
		$('#total_transaksi').val(total_transaksi);
		$('#total_bayar').val(total_bayar);
        $('#daftarpenerimaan').modal("hide");
        $('#keterangan').focus();
    }
	
	$('#hapusbaris').click(function(){
         $('.barisinput:checked').parents('tr').remove();
		 
            var totalretur=0; var total1=0;
           $('.barisjumlah').each(function(){
                var val=$(this).val();
                if(val=='')val=0;
                totalretur=totalretur+parseInt(val);				
            });
           $('#jumlahapprove').val(totalretur);
           //$('#totalpenjualan').val(addCommas(totalpenjualan));
		   $('#totalretur').val(totalretur);
		   $('#total_transaksi').val(total1);
    });
	
	$('input').live('keydown', function(e) {
            if(e.keyCode == 13){
                return false;                                    
            }
        });
	
	$(window).bind('scroll', function() {
        var p = $(window).scrollTop();
        var offset = $(window).offset();
        if(parseInt(p)>1){            
            $('.top').addClass('fixed');
        }else{
            $('.top').removeClass('fixed');
        }
        //if ($(window).scrollTop() + $(window).height() >= $('.top').height()) {
        //  $('.top').addClass('fixed');
        //}
    });
	
	$('.barisjumlah').change(function(){ //di dlm function tambah baris
        var totalpenjualan=0;  var total1=0;
		var racik=$('#adm_racik').val();
		//var tuslah=$('#adm_tuslah').val();
		var resep=$('#adm_resep').val();
		if(resep=='') resep=0;
		if(racik=='') racik=0;
		//if(tuslah=='') tuslah=0;
		$('.barisjumlah').each(function(){
			var val=$(this).val(); //ngambil jumlah
			if(val=='')val=0;
				totalpenjualan=totalpenjualan+parseInt(val); //buat totalin perbarisnya
				//total1=parseInt(racik)+parseInt(tuslah)+parseInt(resep)+parseInt(totalpenjualan);
				total1=parseInt(racik)+parseInt(resep)+parseInt(totalpenjualan);
		});
	   $('#jumlahapprove').val(totalpenjualan);
	   //$('#totalpenjualan').val(addCommas(totalpenjualan));
	   $('#totalpenjualan').val(totalpenjualan);
	   $('#total_transaksi').val(total1);
    });
	
	$('.barisjumlah').keyup(function(e){ 
		if(e.keyCode == 13){ //klo enter di baris jumlah
			//alert('xx')
			$('#tambahbaris').trigger('click');
			return false;
		}
	});
		
	$('.barisqty').change(function(){  
		var val=$(this).val(); var total=0;
		var harga=$('.focused').find('.barisharga').val();
		if(val=='')val=0;
		if(harga=='')harga=0;
		total=parseInt(val)*parseInt(harga);
		$('.focused').find('.barisjumlah').val(total);	
		$('.barisjumlah').trigger('change');
	});
		
	$('.barisqty').click(function(){  
			$('#bodyinput tr').removeClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty
			$(this).parent().parent('tr').addClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty
	});		
	
	$('#no_penerimaan').keyup(function(e){
		if(e.keyCode == 13){
            $.ajax({
                url: '<?php echo base_url() ?>index.php/aptreturobat/ambilpenerimaanbykode/',
                async:false,
                type:'get',
                data:{query:$(this).val()},
                success:function(data){
                //typeahead.process(data)
					$('#listpenerimaan').empty();
					$.each(data,function(i,l){
						//alert(l);
						$('#listpenerimaan').append('<tr><td>'+l.no_penerimaan+'</td><td style="text-align:center;">'+l.tgl_penerimaan+'</td><td>'+l.nama+'</td><td style="text-align:right;">'+l.total_transaksi+'</td><td style="text-align:right;">'+l.total_bayar+'</td><td><a class="btn" onclick=\'pilihpenerimaan("'+l.no_penerimaan+'","'+l.tgl_penerimaan+'","'+l.kd_supplier+'","'+l.nama+'","'+l.total_transaksi+'","'+l.total_bayar+'")\'>Pilih</a></td></tr>');
						
					});    
                },
                dataType:'json'                         
            }); 
            $('#daftarpenerimaan').modal("show");
		}
		var ex = document.getElementById('dataTable1');
        if ( ! $.fn.DataTable.fnIsDataTable( ex ) ) {
            $('#dataTable1').dataTable({
                "sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
				"sPaginationType": "bootstrap",
                "oLanguage": {
					"sLengthMenu": "Show _MENU_ entries"
                }
            });
            var oTable = $('#dataTable1').dataTable();
            $('#no_penerimaan').keyup(function(e){
				oTable.fnFilter( $(this).val() );
                if(e.keyCode == 13){
                    //alert('xx')
                    return false;
                }
            });
        }
	});
		
	$('input[type="text"]').keydown(function(e){
        //get the next index of text input element
        var next_idx = $('input[type="text"]').index(this) + 1;
         
        //get number of text input element in a html document
        var tot_idx = $('body').find('input[type="text"]').length;
     
        //enter button in ASCII code
        if(e.keyCode == 13){
            //go to the next text input element
            if($(this).parent()[0]['nodeName']=='TD'){
                return false;
            }
            //$('input[type=text]:eq(' + next_idx + ')').focus();
            //$(this).next().focus();
            return false;


        }

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