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

<script src="<?php echo base_url(); ?>assets/js/mousetrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/mousetrap-global-bind.min.js"></script> 
<script type="text/javascript">
	Mousetrap.bindGlobal('ctrl+r', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/returpenjualanobat/tambahretur'; return false;});
	Mousetrap.bindGlobal('f9', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/returpenjualanobat'; return false;});
	
	Mousetrap.bindGlobal('ctrl+l', function() { 
		$('#pencarian').modal("show");
		return false;
	});
	
	Mousetrap.bindGlobal('ctrl+s', function() { 
		$('#simpan').trigger('click');
		return false;
	});
</script>

<script type="text/javascript">

    $(document).ready(function() {
		$('#no_penjualan').focus();
        var totalretur=0;
        $('.barisjumlah').each(function(){
                var val=$(this).val();
                if(val=='')val=0;
                totalretur=totalretur+parseFloat(val);
        });
        $('#jumlahapprove').val(totalretur);
        //$('#totalpenerimaan').val(addCommas(totalpenerimaan));
		$('#totalretur').val(totalretur.toFixed(2));
		
        $('#form').ajaxForm({
            beforeSubmit: function(a,f,o) {
                o.dataType = "json";
                $('div.error').removeClass('error');
                $('span.help-inline').html('');
                $('#progress').show();
                $('body').append('<div id="overlay1" style="position: fixed;height: 100%;width: 100%;z-index: 1000000;"></div>');
                $('body').addClass('body1');
                var urlnya="<?php echo base_url(); ?>index.php/transapotek/returpenjualanobat/periksaretur"; //buat validasi inputan
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
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptreturobat';
                    }
                    $('#no_retur_penjualan').val(data.no_retur_penjualan);
                    $('#btn-cetak').attr('href','<?php echo base_url() ?>third-party/fpdf/buktireturpenjualan.php?no_retur_penjualan='+data.no_retur_penjualan+'');
                    $('#btn-tutuptrans').removeAttr('disabled');

                    if(parseInt(data.posting)==1){
                        $('#btn-tutuptrans').attr('value','bukatrans');
                        $('#btn-tutuptrans').text('Buka Trans');
                        $('#btn-cetak').removeAttr('disabled');
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/returpenjualanobat/ubahretur/'+data.no_retur_penjualan;
                    }
                    if(parseInt(data.posting)==2){
                        //$('#btn-bayar').attr('disabled');                        
                        $('#btn-tutuptrans').attr('value','tutuptrans');
                        $('#btn-tutuptrans').text('Tutup Trans');
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/returpenjualanobat/ubahretur/'+data.no_retur_penjualan;
                    }
					if(parseInt(data.posting)==3){
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/returpenjualanobat/ubahretur/'+data.no_retur_penjualan;
                    }
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
						<form class="form-horizontal"  id="form" method="POST" action="<?php echo base_url() ?>index.php/transapotek/returpenjualanobat/simpanretur">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header class="top" style="">
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>RETUR PENJUALAN OBAT / ALKES </h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/returpenjualanobat/"> <i class="icon-list"></i> Daftar / (F9)</a></li>													
                                                    <li><a target="_blank" class="btn" id="btn-cetak" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php if(!empty($no_retur_penjualan)){ echo base_url() ?>third-party/fpdf/buktireturpenjualan.php?no_retur_penjualan=<?php echo $no_retur_penjualan;} else echo '#'; ?>" <?php if(empty($no_retur_penjualan)){ ?>disabled<?php } ?>> <i class="icon-print"></i> Cetak</a></li>
													<li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/returpenjualanobat/tambahretur"> <i class="icon-plus"></i> Tambah / (Ctrl+R)</a></li>
													<li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" data-toggle="modal" data-original-title="Pencarian" data-placement="bottom" rel="tooltip" href="#pencarian"> <i class="icon-search"></i> Pencarian / (Ctrl+L)</a></li>
                                                    <li><button <?php if($this->mreturpenjualan->isPosted($no_retur_penjualan))echo "disabled"; ?> class="btn" id="simpan" type="submit"  name="submit" value="simpan"> <i class="icon-save"></i> Simpan / (Ctrl+S)</button></li>
                                                    <?php
                                                    if($this->mreturpenjualan->isPosted($no_retur_penjualan)){
                                                    ?>
                                                    <li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="bukatrans" <?php if(empty($no_retur_penjualan)){ ?>disabled<?php } ?>> <i class="icon-key"></i> Buka Trans.</a></li>
                                                    <?php
                                                    }else{
                                                    ?>
                                                    <li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="tutuptrans" <?php if(empty($no_retur_penjualan)){ ?>disabled<?php } ?>> <i class="icon-key"></i> Tutup Trans.</button></li>
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
													<div class="span6">
														<div class="control-group">
															<label for="no_retur_penjualan" class="control-label">No. Retur </label>
															<div class="controls with-tooltip">
																<input type="text" name="no_retur_penjualan" id="no_retur_penjualan" value="<?php echo $no_retur_penjualan; ?>" readonly class="span5 input-tooltip" data-original-title="no retur penjualan" data-placement="bottom"/>
																<span class="help-inline"></span>
																<input type="hidden" name="jam_retur" id="jam_retur" value="<?php echo date('h:i:s'); ?>" data-mask="99:99:99" class="input-small"/>
																<input type="hidden" id="jam_retur1" name="jam_retur1" value="<?php if(isset($itemtransaksi['jam_retur']))echo $itemtransaksi['jam_retur'] ?>" class="input-small" data-original-title="jam retur" data-placement="bottom"/>
															</div>
														</div>
													</div>
													<div class="span6">
														<div class="control-group">
															<label for="tgl_returpenjualan" class="control-label">Tgl. Retur</label>
															<div class="controls with-tooltip">
																<input <?php if($this->mreturpenjualan->isPosted($no_retur_penjualan))echo "readonly"; ?> type="text" name="tgl_returpenjualan" id="tgl_returpenjualan" class="input-small input-tooltip cleared" data-original-title="tgl retur" data-mask="99-99-9999" value="<?php if(empty($itemtransaksi['tgl_returpenjualan']))echo date('d-m-Y'); else echo convertDate($itemtransaksi['tgl_returpenjualan']); ?>" data-placement="bottom"/>
																<span class="help-inline"></span>
																Shift &nbsp&nbsp<input type="text" id="shiftapt" name="shiftapt" value="<?php if(isset($itemtransaksi['shiftapt']))echo $itemtransaksi['shiftapt'] ?>" class="span2 input-tooltip" data-original-title="shift" data-placement="bottom" readonly />
																&nbsp&nbsp&nbspTutup Retur <input type="checkbox" id="tutup" name="tutup" value="1" <?php echo set_checkbox('tutup','1',isset($itemtransaksi['tutup'])&& $itemtransaksi['tutup']=='1' ? true:false); ?> disabled />
																<input type="hidden" id="cust_code" name="cust_code" value="<?php if(isset($itemtransaksi['cust_code']))echo $itemtransaksi['cust_code'] ?>" class="span1 input-tooltip" data-original-title="jenis pasien" data-placement="bottom" readonly />
															</div>
														</div>
													</div>
												</div>
											</div>                                                
                                            <div class="row-fluid">
												<div class="span12">
													<div class="span6">
														<div class="control-group">
															<label for="no_penjualan" class="control-label">No. Penjualan </label>
															<div class="controls with-tooltip">
																<input <?php if($this->mreturpenjualan->isPosted($no_retur_penjualan))echo "readonly"; ?> type="text" id="no_penjualan" name="no_penjualan" value="<?php if(isset($itemtransaksi['no_penjualan']))echo $itemtransaksi['no_penjualan'] ?>" class="span5 input-tooltip" data-original-title="no penjualan" data-placement="bottom" href="#caripenjualan" />
																<span class="help-inline"></span>																
															</div>
														</div>
													</div>
													<div class="span6">
														<div class="control-group">
															<label for="customer" class="control-label">Jenis Pasien </label>
															<div class="controls with-tooltip">
																<input type="text" id="customer" name="customer" value="<?php if(isset($itemtransaksi['customer']))echo $itemtransaksi['customer'] ?>" class="span4 input-tooltip" data-original-title="jenis pasien" data-placement="bottom" readonly />
																<span class="help-inline"></span>	
																<input type="hidden" id="resep" name="resep" value="<?php if(isset($itemtransaksi['resep']))echo $itemtransaksi['resep'] ?>" class="span1 input-tooltip" data-original-title="resep" data-placement="bottom"/>
																&nbsp&nbsp&nbspTgl. Penjualan &nbsp&nbsp<input type="text" id="tgl_penjualan" name="tgl_penjualan" value="<?php if(isset($itemtransaksi['tgl_penjualan'])) echo $itemtransaksi['tgl_penjualan'] ?>" class="input-small input-tooltip" data-original-title="tgl penjualan" data-placement="bottom" readonly />
															</div>															
														</div>
													</div>
												</div>
											</div>
											<div class="row-fluid">
												<div class="span12">
													<div class="span6">
														<div class="control-group">
															<label for="dokter" class="control-label">Dokter </label>
															<div class="controls with-tooltip">
																<input type="text" id="dokter" name="dokter" value="<?php if(isset($itemtransaksi['dokter']))echo $itemtransaksi['dokter'] ?>" class="span9 input-tooltip" data-original-title="dokter" data-placement="bottom" readonly />
																<input type="hidden" id="kd_dokter" name="kd_dokter" value="<?php if(isset($itemtransaksi['kd_dokter']))echo $itemtransaksi['kd_dokter'] ?>" class="span3 input-tooltip" data-original-title="dokter" data-placement="bottom" readonly />
																<span class="help-inline"></span>
															</div>
														</div>
													</div>
													<div class="span6">
														<div class="control-group">
															<label for="kd_pasien" class="control-label">Pasien </label>
															<div class="controls with-tooltip">
																<input type="text" id="kd_pasien" name="kd_pasien" value="<?php if(isset($itemtransaksi['kd_pasien']))echo $itemtransaksi['kd_pasien'] ?>" class="span3 input-tooltip" data-original-title="kode pasien" data-placement="bottom" readonly />
																<span class="help-inline"></span>																	
																<input type="text" id="nama_pasien" name="nama_pasien" value="<?php if(isset($itemtransaksi['nama_pasien']))echo $itemtransaksi['nama_pasien'] ?>" class="span8 input-tooltip" data-original-title="nama pasien" data-placement="bottom" readonly />
															</div>															
														</div>
													</div>
												</div>
											</div>
											<div class="row-fluid">
												<div class="span12">													
													<div class="span6">
														<div class="control-group">
															<label for="alasan" class="control-label">Alasan</label>
															<div class="controls with-tooltip">
																<textarea <?php if($this->mreturpenjualan->isPosted($no_retur_penjualan))echo "readonly"; ?> id="alasan" name="alasan" cols="90" rows="2" class="input-xlarge" style="width:310px"><?php if(isset($itemtransaksi['alasan']))echo $itemtransaksi['alasan'] ?></textarea>
																<span class="help-inline"></span>
															</div>
														</div>														
													</div>
													<div class="span6">
														<div class="control-group">
															<label for="jum_item_obat" class="control-label">Jum. Item Obat</label>
															<div class="controls with-tooltip">
																<input align="right" type="text" id="jum_item_obat" name="jum_item_obat" value="<?php if(isset($itemtransaksi['jum_item_obat']))echo $itemtransaksi['jum_item_obat'] ?>" class="span2 input-tooltip" data-original-title="jumlah item obat" data-placement="bottom" readonly />
																<span class="help-inline"></span>																	
																&nbsp&nbsp&nbsp Total Retur &nbsp&nbsp<input align="right" type="text" id="total" name="total" value="<?php if(isset($itemtransaksi['total'])) echo number_format($itemtransaksi['total'],2,'.','') ?>" class="span4 input-tooltip" data-original-title="total retur" data-placement="bottom" readonly />
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
															<li><button class="btn" type="button" id="hapusbaris"> <i class="icon-remove"></i> Hapus Obat</button></li>
														</ul>
													</div>
												<!-- /.toolbar -->
												</header>
												<div class="body collapse in" id="defaultTable">
													<table id="dataTable5" class="table responsive">
														<thead>
															<tr style="font-size:90% !important;">
																<th class="header">&nbsp;</th>
																<!--<th class="header" style="width:85px;padding:0 !important;">Kode</th>-->
																<th class="header" style="text-align:center;">Nama Obat</th>
																<th class="header" style="text-align:center;">Satuan</th>
																<th class="header" style="text-align:center;">Tgl. Expire</th>																															
																<th class="header" style="text-align:center;">Harga Jual</th>
																<th class="header" style="text-align:center;">Qty</th>
																<th class="header" style="text-align:right;">Total </th>
															</tr>
														</thead>
														<tbody id="bodyinput">
															<?php
																if(isset($itemsdetiltransaksi)){
																	//$no=1;
																	foreach ($itemsdetiltransaksi as $itemdetil){																			
																	?>
																		<tr style="font-size:90% !important;">
																			<td><input type="checkbox" class="barisinput" /></td>
																			<input type="hidden" name="kd_obat[]" value="<?php echo $itemdetil['kd_obat'] ?>" style="width:85px;" class="input-small bariskodeobat cleared">
																			<td><input <?php if($this->mreturpenjualan->isPosted($no_retur_penjualan))echo "readonly"; ?> type="text" name="nama_obat[]" value="<?php echo $itemdetil['nama_obat'] ?>" style="width:700px;" class="input-xlarge barisnamaobat cleared" readonly></td>
																			<td><input <?php if($this->mreturpenjualan->isPosted($no_retur_penjualan))echo "readonly"; ?> style="text-align:center;" type="text" name="satuan_kecil[]" value="<?php echo $itemdetil['satuan_kecil'] ?>" style="width100px;" class="input-small barissatuan cleared" readonly></td>
																			<td><input <?php if($this->mreturpenjualan->isPosted($no_retur_penjualan))echo "readonly"; ?> type="text" name="tgl_expire[]" value="<?php echo $itemdetil['tgl_expire'] ?>" style="width80px;" class="input-small baristanggal cleared" readonly></td>																			
																			<td><input <?php if($this->mreturpenjualan->isPosted($no_retur_penjualan))echo "readonly"; ?> style="text-align:right;" type="text" name="harga_jual[]" value="<?php echo number_format($itemdetil['harga_jual'],2,'.','') ?>" style="width:90px;" class="input-small barishargajual cleared"></td>
																			<td><input <?php if($this->mreturpenjualan->isPosted($no_retur_penjualan))echo "readonly"; ?> style="text-align:right;" type="text" name="qty[]" value="<?php echo $itemdetil['qty'] ?>" style="width:80px;" class="input-small barisqty cleared"></td>																			
																			<input type="hidden" name="qty1[]" value="<?php echo $itemdetil['qty'] ?>" style="width:60px;font-size:90% !important;" class="input-small barisqtyhidden cleared">
																			<td><input <?php if($this->mreturpenjualan->isPosted($no_retur_penjualan))echo "readonly"; ?> style="text-align:right;" type="text" name="totalgrid[]" value="<?php echo number_format($itemdetil['totalgrid'],2,'.','') ?>" style="width:50px;" class="input-medium barisjumlah cleared" readonly></td>																			
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
									
									<div aria-hidden="true" aria-labelledby="approveModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="pencarian" style="display: none;width:77%;left:34% !important;">
										<div class="modal-header">
											<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
											<h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Retur Penjualan Obat</h3>
										</div>
										<div class="modal-body" style="">
											<div class="body" id="collapse4">
												<table id="dataTable1" class="table table-bordered table-condensed table-hover table-striped">
													<thead>
														<tr>
															<th style="text-align:center;">No Retur</th>
															<th style="text-align:center;">Tgl. Retur</th>
															<th style="text-align:center;">No. Penjualan</th>
															<th style="text-align:center;">Nama Pasien</th>
															<th style="text-align:center;">Jumlah</th>
															<th style="text-align:center;">Pilihan</th>
														</tr>
													</thead>
													<tbody>
														<?php
															foreach ($items as $item) {
															# code...															
														?>
																<tr>
																	<td style="text-align:center;"><?php echo $item['no_retur_penjualan'] ?></td>
																	<td style="text-align:center;"><?php echo convertDate($item['tgl_returpenjualan']) ?></td>																	
																	<td style="text-align:center;"><?php echo $item['no_penjualan'] ?></td>
																	<td><?php echo $item['nama_pasien'] ?></td>
																	<td style="text-align:right;"><?php echo number_format($item['total'],2,',','.') ?></td>																																	
															<!--
															<td style="text-align:center;"></td>
															-->	
																	<td style="text-align:center;">
																		<a href="<?php echo base_url() ?>index.php/transapotek/returpenjualanobat/ubahretur/<?php echo $item['no_retur_penjualan'] ?>" class="btn"><i class="icon-edit"></i> PILIH</a>
																	</td>
																</tr>                                                    
														<?php
															}
														?>
													</tbody>
												</table>
											</div>
										</div>
										<div class="modal-footer">
											<button aria-hidden="true" data-dismiss="modal" class="btn">Close</button>
										</div>
									</div>
										
									<div aria-hidden="true" aria-labelledby="helpModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="daftarpenjualan" style="display: none;width:80%;margin-left:-520px !important;"> 
										<div class="modal-header">
											<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
											<h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Penjualan</h3>
										</div>
										<div class="modal-body" style="height:300px;">
											<div class="body" id="collapse4">
												<table id="dataTable1" class="table table-bordered table-condensed table-hover table-striped">
													<thead>
														<tr>						
															<th style="text-align:center;">No. Penjualan</th>
															<th style="text-align:center;">Tgl. Penjualan</th>
															<th style="text-align:center;">Unit</th>
															<th style="text-align:center;">Nama Pasien</th>
															<th style="text-align:center;">Total</th>
															<th style="width:50px !important;">Pilihan</th>
														</tr>
													</thead>
													<tbody id="listpenjualan">														
													</tbody>
													<tbody id="listdetil">														
													</tbody>
												</table>
											</div>
										</div>
										<div class="modal-footer">
											<input type="text" id="no_penjualan1" class="pull-left" autocomplete="off">
											<button aria-hidden="true" data-dismiss="modal" class="btn">Close</button>
										</div>
									</div>									
									
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
	
	$('#tgl_returpenjualan').datepicker({
        format: 'dd-mm-yyyy'
    });
	
	$('#jam_retur').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
    });
	
	function pilihpenjualan(no_penjualan1,tgl_penjualan,customer,resep,dokter,kd_pasien,nama_pasien,jum_item_obat,total,cust_code) {
		$('#no_penjualan').val(no_penjualan1);
		$('#tgl_penjualan').val(tgl_penjualan);
		$('#customer').val(customer);
		$('#resep').val(resep);
		$('#dokter').val(dokter);
		$('#kd_pasien').val(kd_pasien);
		$('#nama_pasien').val(nama_pasien);
		$('#jum_item_obat').val(jum_item_obat);
		$('#total').val(parseFloat(total).toFixed(2));
		//$('#shiftapt').val(shiftapt);
		$('#cust_code').val(cust_code);
        $('#daftarpenjualan').modal("hide");
        $('#alasan').focus();
		
		    $.ajax({
                url: '<?php echo base_url() ?>index.php/transapotek/returpenjualanobat/ambildetilpenjualan/',
                async:false,
                type:'get',
                data:{query:no_penjualan1},
                success:function(data){
                //typeahead.process(data)
					$('#bodyinput').empty();
					var jum=0;
					$.each(data,function(i,l){
						//alert(l);
						jum=jum+parseFloat(l.totalgrid);																			
						$('#bodyinput').append('<tr style="font-size:90% !important;"><td><input type="checkbox" class="barisinput cleared" /></td>'+
												'<input type="hidden" name="kd_obat[]" value="'+l.kd_obat+'" style="width:85px;" class="input-small bariskodeobat cleared">'+
												'<td><input type="text" name="nama_obat[]" value="'+l.nama_obat+'" style="width:700px;font-size:90% !important;" class="input-xlarge barisnamaobat cleared" readonly></td>'+
												'<td><input type="text" name="satuan_kecil[]" value="'+l.satuan_kecil+'" style="font-size:90% !important;" style="width:100px;" class="input-small barissatuan cleared" readonly></td>'+
												'<td><input type="text" name="tgl_expire[]" style="width:80px !important;font-size:90% !important;" data-mask="99-99-9999" value="'+l.tgl_expire+'" class="input-small baristanggal cleared" readonly></td>'+
												'<td><input style="text-align:right;" type="text" name="harga_jual[]" value="'+parseFloat(l.harga_jual).toFixed(2)+'" style="width:90px !important;font-size:90% !important;" class="input-small barishargajual cleared" readonly></td>'+
												'<td><input style="text-align:right;" type="text" name="qty[]" value="'+l.qty+'" style="width:80px;font-size:90% !important;" class="input-small barisqty cleared"></td>'+
												'<input type="hidden" name="qty1[]" value="'+l.qty+'" style="width:60px;font-size:90% !important;" class="input-small barisqtyhidden cleared">'+
												'<td style="text-align:right;"><input style="text-align:right;" style="width:50px;font-size:90% !important;" type="text" name="totalgrid[]" value="'+parseFloat(l.totalgrid).toFixed(2)+'" class="input-medium barisjumlah cleared" readonly></td>'+
											'</tr>');
					});	
					$('#totalretur').val(jum.toFixed(2));
					
					$('.barisqty, .barisnamaobat, .barissatuan, .baristanggal, .barishargajual, .barisjumlah').click(function(){  
						$('#bodyinput tr').removeClass('focused'); 
						$(this).parent().parent('tr').addClass('focused'); 
					})
					
					$('.barisqty').change(function(){ 						
						var kiteye=$(this).val(); 						
						var hargajual=$('.focused').find('.barishargajual').val();
						if(kiteye=='')kiteye=0; 
						if(hargajual=='')hargajual=0; 
						var total=parseFloat(kiteye)*parseFloat(hargajual);
						$('.focused').find('.barisjumlah').val(total.toFixed(2));
						$('.barisjumlah').trigger('change');
					});
					
					$('.barisjumlah').change(function(){ 
						var totalretur=0;  
						$('.barisjumlah').each(function(){
							var val=$(this).val(); //ngambil jumlah
							if(val=='')val=0;
								totalretur=totalretur+parseFloat(val); //buat totalin perbarisnya	
						});
					   $('#totalretur').val(totalretur.toFixed(2));
					   $('#total').val(totalretur.toFixed(2));
					});
					
                },
                dataType:'json'                         
            }); 
    }
	
	$('#no_penjualan').keyup(function(e){
		if(e.keyCode == 13){
			$.ajax({
				url: '<?php echo base_url() ?>index.php/transapotek/returpenjualanobat/ambilpenjualanbykode/',
				async:false,
                type:'get',
                data:{query:$(this).val()},
				success:function(data){
                //typeahead.process(data)
					$('#listpenjualan').empty();
					$.each(data,function(i,l){
						//alert(l);																																																																						
						//$('#listpenjualan').append('<tr><td style="text-align:center;">'+l.no_penjualan+'</td><td style="text-align:center;">'+l.tgl_penjualan+'</td><td>'+l.nama_unit_apt+'</td><td>'+l.nama_pasien+'</td><td style="text-align:right;">'+l.total+'</td><td><a class="btn" onclick=\'pilihpenjualan("'+l.no_penjualan+'","'+l.customer+'","'+l.resep+'","'+l.tgl_penjualan+'","'+l.dokter+'","'+l.kd_pasien+'","'+l.nama_pasien+'","'+jum_item_obat+'","'+l.total+'")\'>Pilih</a></td></tr>');
						$('#listpenjualan').append('<tr><td style="text-align:center;">'+l.no_penjualan1+'</td><td style="text-align:center;">'+l.tgl_penjualan+'</td><td style="text-align:center;">'+l.nama_unit_apt+'</td><td>'+l.nama_pasien+'</td><td style="text-align:right;">'+l.total+'</td><td><a class="btn" onclick=\'pilihpenjualan("'+l.no_penjualan1+'","'+l.tgl_penjualan+'","'+l.customer+'","'+l.resep+'","'+l.dokter+'","'+l.kd_pasien+'","'+l.nama_pasien+'","'+l.jum_item_obat+'","'+l.total+'","'+l.cust_code+'")\'>Pilih</a></td></tr>');
						
					});    
                },
                dataType:'json'                         
            }); 
            $('#daftarpenjualan').modal("show");
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
            $('#no_penjualan1').keyup(function(e){
				oTable.fnFilter( $(this).val() );
                if(e.keyCode == 13){
                    //alert('xx')
                    return false;
                }
            });
        }
	});
	
	$('#hapusbaris').click(function(){
        $('.barisinput:checked').parents('tr').remove();
		$('.barisjumlah').trigger('change');
		 
		var rowCount = $('#bodyinput tr').length; //ngitung jumlah row di grid....kalo di java getRowCount
		$('#jum_item_obat').val(rowCount);
    });
	
	$('.barisqty').change(function(){ 
		var kiteye=$(this).val(); 						
		var hargajual=$('.focused').find('.barishargajual').val();
		if(kiteye=='')kiteye=0; 
		if(hargajual=='')hargajual=0; 
		var total=parseFloat(kiteye)*parseFloat(hargajual);
		$('.focused').find('.barisjumlah').val(total.toFixed(2));
		$('.barisjumlah').trigger('change');
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
	
	$('.barisjumlah').change(function(){ 
        var totalretur=0;  
		$('.barisjumlah').each(function(){
			var val=$(this).val(); //ngambil jumlah
			if(val=='')val=0;
				totalretur=totalretur+parseFloat(val); //buat totalin perbarisnya	
		});
	   $('#totalretur').val(totalretur.toFixed(2));
	   $('#total').val(totalretur.toFixed(2));
    });
		
	$('.barisqty').change(function(){  
		var val=$(this).val(); var total=0;
		var harga=$('.focused').find('.barishargabeli').val();
		if(val=='')val=0;
		if(harga=='')harga=0;
		total=parseFloat(val)*parseFloat(harga);
		$('.focused').find('.barisjumlah').val(total.toFixed(2));	
		$('.barisjumlah').trigger('change');
	});
		
	$('.barisqty, .barisnamaobat, .barissatuan, .baristanggal, .barishargajual, .barisjumlah').click(function(){  
		$('#bodyinput tr').removeClass('focused'); 
		$(this).parent().parent('tr').addClass('focused'); 
	})	
		
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