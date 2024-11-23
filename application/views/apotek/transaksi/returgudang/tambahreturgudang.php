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
body.modal-open {
    overflow: hidden;
}

</style>
<style>
#feedback { font-size: 1.4em; }
#listobat .ui-selecting, #listobat .ui-selecting { background: #FECA40; }
#listobat .ui-selected, #listobat .ui-selected { background: #F39814; color: white; }
#listobat, #listobat { list-style-type: none; margin: 0; padding: 0; width: 60%; }
#listobat li, #listobat li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px; }
</style>
<script>
$(function() {
    $( "#listobat" ).selectable({});
});

function SelectSelectableElement (selectableContainer, elementsToSelect)
{
    // add unselecting class to all elements in the styleboard canvas except the ones to select
    $(".ui-selected", selectableContainer).not(elementsToSelect).removeClass("ui-selected").addClass("ui-unselecting");
    
    // add ui-selecting class to the elements to select
    $(elementsToSelect).not(".ui-selected").addClass("ui-selected");

    // trigger the mouse stop event (this will select all .ui-selecting elements, and deselect all .ui-unselecting elements)
    selectableContainer.selectable('refresh');
    //selectableContainer.data("selectable")._mouseStop(null);
    //return false;
}
</script>
<script src="<?php echo base_url(); ?>assets/js/mousetrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/mousetrap-global-bind.min.js"></script> 
<script type="text/javascript">
	Mousetrap.bindGlobal('ctrl+r', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptreturgudang/tambahreturgudang'; return false;});
	Mousetrap.bindGlobal('f10', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptreturgudang'; return false;});
	
	Mousetrap.bindGlobal('ctrl+l', function() { 
		$('#pencarian').modal("show");
		return false;
	});
	
	Mousetrap.bindGlobal('ctrl+b', function() { 
		$('#tambahbaris').trigger('click');
		return false;
	});
	
	Mousetrap.bindGlobal('ctrl+s', function() { 
		$('#simpan').trigger('click');
		return false;
	});
	
	Mousetrap.bind(['down','right'], function() {

        if($('#daftarobat').is(':visible')){    
            if($("#listobat .ui-selected").next().is('tr')){
				$('#modal-body-daftarobat').scrollTop($('#modal-body-daftarobat').scrollTop()+45);
				SelectSelectableElement($("#listobat"), $(".ui-selected").next('tr'));
            }else{
                return false;
            }
        }
    });
	
	Mousetrap.bind(['up','left'], function() {
        //$('#selectable').next('tr').trigger('click');

        if($('#daftarobat').is(':visible')){ 
            if($("#listobat .ui-selected").prev().is('tr')){
				$('#modal-body-daftarobat').scrollTop($('#modal-body-daftarobat').scrollTop()-45);
				SelectSelectableElement($("#listobat"), $(".ui-selected").prev('tr'));
            }else{
                return false;
            }
        }
    });
	
    Mousetrap.bind('enter', function(e) { 

        if($('#daftarobat').is(':visible')){
            $('.ui-selected').find('.btn').trigger('click');
            return false;
        }
        return false;
    });
	
</script>
<script type="text/javascript">

    $(document).ready(function() {
		$('#kd_unit_tujuan').focus();
        $('#form').ajaxForm({
            beforeSubmit: function(a,f,o) {
                o.dataType = "json";
                $('div.error').removeClass('error');
                $('span.help-inline').html('');
                $('#progress').show();
                $('body').append('<div id="overlay1" style="position: fixed;height: 100%;width: 100%;z-index: 1000000;"></div>');
                $('body').addClass('body1');
                var urlnya="<?php echo base_url(); ?>index.php/transapotek/aptreturgudang/periksareturgudang"; //buat validasi inputan
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
                    $('#no_retur').val(data.no_retur);
                    $('#btn-cetak').removeAttr('disabled');
                    $('#btn-cetak').attr('href','<?php echo base_url() ?>third-party/fpdf/buktidistribusi.php?no_retur='+data.no_retur+'');
                    $('#btn-tutuptrans').removeAttr('disabled');
                    if(parseInt(data.keluar)>0){
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/transapotek/aptreturgudang';
                    }

                    if(parseInt(data.posting)==1){
                        $('#btn-tutuptrans').attr('value','bukatrans');
                        $('#btn-tutuptrans').text('Buka Trans');
                        //$('#btn-bayar').removeAttr('disabled');
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptreturgudang/ubahreturgudang/'+data.no_retur;
                    }
                    if(parseInt(data.posting)==2){
                        //$('#btn-bayar').attr('disabled');                        
                        $('#btn-tutuptrans').attr('value','tutuptrans');
                        $('#btn-tutuptrans').text('Tutup Trans');
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptreturgudang/ubahreturgudang/'+data.no_retur;
                    }
					if(parseInt(data.posting)==3){
						 window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptreturgudang/ubahreturgudang/'+data.no_retur;
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
						<form class="form-horizontal"  id="form" method="POST" action="<?php echo base_url() ?>index.php/transapotek/aptreturgudang/simpanreturgudang">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header class="top" style="">
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>RETUR OBAT / ALKES KE UNIT GUDANG FARMASI</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/aptreturgudang/"> <i class="icon-list"></i> Daftar / (F10)</a></li>
                                                    <li><a target="_blank" class="btn" id="btn-cetak" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php if(!empty($no_retur)){ echo base_url() ?>third-party/fpdf/buktireturgudang.php?no_retur=<?php echo $no_retur;} else echo '#'; ?>" <?php if(empty($no_retur)){ ?>disabled<?php } ?>> <i class="icon-print"></i> Cetak</a></li>
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/aptreturgudang/tambahreturgudang"> <i class="icon-plus"></i> Tambah / (Ctrl+R)</a></li>
                                                    <li><button <?php if($this->mreturgudang->isPosted($no_retur))echo "disabled"; ?> class="btn" id="simpan" type="submit"  name="submit" value="simpan"> <i class="icon-save"></i> Simpan / (Ctrl+S)</button></li>
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" data-toggle="modal" data-original-title="Pencarian" data-placement="bottom" rel="tooltip" href="#pencarian"> <i class="icon-search"></i> Pencarian / (Ctrl+L)</a></li>
                                                    <?php
                                                    if($this->mreturgudang->isPosted($no_retur)){
                                                    ?>
                                                    <li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="bukatrans" <?php if(empty($no_retur)){ ?>disabled<?php } ?>> <i class="icon-key"></i> Buka Trans.</a></li>
                                                    <?php
                                                    }else{
                                                    ?>
                                                    <li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="tutuptrans" <?php if(empty($no_retur)){ ?>disabled<?php } ?>> <i class="icon-key"></i> Tutup Trans.</button></li>
                                                    <?php
                                                    }
                                                    ?>
													<!--?php
                                                    if($this->mreturgudang->isPosted($no_retur)){
														if($kd_applogin==0){ ?>
															<li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="bukatrans" <-?php echo "disabled"; ?>> <i class="icon-key"></i> Buka Trans.</button></li>
														<-?php } else { ?>
															<li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="bukatrans" <-?php echo "enabled"; ?> data-toggle="modal" data-original-title="Log Retur ke Gudang" data-placement="bottom" rel="tooltip" href="#bukatutupform"> <i class="icon-key"></i> Buka Trans.</button></li-->
														<!--?php } ?>
                                                    <!?php
                                                    }else{
                                                    ?-->
														<!--li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="tutuptrans" <-?php if(empty($no_retur)){ ?>disabled<-?php } ?>> <i class="icon-key"></i> Tutup Trans.</button></li-->
                                                    <!--?php
                                                    }
                                                    ?-->
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
																<!--input type="text" id="kd_applogin" name="kd_applogin" value="<-?php echo $kd_applogin; ?>" class="span2 input-tooltip" data-original-title="kd_applogin" data-placement="bottom"/-->
															</div>
														</div>
													</div>
													<div class="span7">
														<div class="control-group">
															<label for="kd_unit_asal" class="control-label">Unit Asal </label>
															<div class="controls with-tooltip">
																<input type="text" name="nama_unit_asal" id="nama_unit_asal" value="<?php if($unit=$this->mreturgudang->ambilNamaUnit($this->session->userdata('kd_unit_apt'))) echo $unit; ?>" readonly class="span5 input-tooltip" data-original-title="unit asal" data-placement="bottom"/>
																<input type="hidden" name="kd_unit_asal" id="kd_unit_asal" value="<?php echo $this->session->userdata('kd_unit_apt'); ?>" readonly class="span2 input-tooltip" data-original-title="kd unit asal" data-placement="bottom"/>
															</div>
														</div>
													</div>
												</div>
											</div>                                                
                                            <div class="row-fluid">
												<div class="span12">
													<div class="span5">
														<div class="control-group">
															<label for="tgl_retur" class="control-label">Tgl. Retur </label>
															<div class="controls with-tooltip">
																<input <?php if($this->mreturgudang->isPosted($no_retur))echo "readonly"; ?> type="text" name="tgl_retur" id="tgl_retur" class="input-small input-tooltip cleared" data-original-title="tgl distribusi" data-mask="99-99-9999" value="<?php if(empty($itemtransaksi['tgl_retur']))echo date('d-m-Y'); else echo convertDate($itemtransaksi['tgl_retur']); ?>" data-placement="bottom"/>
																<span class="help-inline"></span>
																Shift  <input type="text" id="shift" name="shift" value="<?php if(isset($itemtransaksi['shift']))echo $itemtransaksi['shift'] ?>" class="span3 input-tooltip" data-original-title="shift" data-placement="bottom" readonly />
															</div>
														</div>
													</div>
													<div class="span7">
														<div class="control-group">
															<label for="kd_unit_tujuan" class="control-label">Unit Tujuan </label>
															<div class="controls with-tooltip">
																<input type="text" name="nama_unit_tujuan" id="nama_unit_tujuan" value="<?php if($unit=$this->mreturgudang->ambilNamaUnit($this->session->userdata('kd_unit_apt_gudang'))) echo $unit; ?>" readonly class="span5 input-tooltip" data-original-title="unit tujuan" data-placement="bottom"/>
																<input type="hidden" name="kd_unit_tujuan" id="kd_unit_tujuan" value="<?php echo $this->session->userdata('kd_unit_apt_gudang'); ?>" readonly class="span2 input-tooltip" data-original-title="kd unit tujuan" data-placement="bottom"/>
																<span class="help-inline"></span>
																<input type="hidden" name="jam_retur" id="jam_retur" value="<?php echo date('h:i:s'); ?>" data-mask="99:99:99" class="input-small"/>
																<input type="hidden" id="jam_retur1" name="jam_retur1" value="<?php if(isset($itemtransaksi['jam_retur']))echo $itemtransaksi['jam_retur'] ?>" class="input-small" data-original-title="jam distribusi" data-placement="bottom"/>
															</div>
														</div>
													</div>
												</div>
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
															<li><button <?php if($this->mreturgudang->isPosted($no_retur))echo "disabled"; ?> class="btn" type="button" id="tambahbaris"> <i class="icon-plus"></i> Tambah Obat (Ctrl+B)</button></li>
															<li><button <?php if($this->mreturgudang->isPosted($no_retur))echo "disabled"; ?> class="btn" type="button" id="hapusbaris"> <i class="icon-remove"></i> Hapus Obat</button></li>
														</ul>
													</div>
												<!-- /.toolbar -->
												</header>
												<div class="body collapse in" id="defaultTable">
													<table class="table responsive">
														<thead>
															<tr>
																<th class="header">&nbsp;</th>
                                                                <!--
																<th class="header" style="width:150px;">Kode</th>
                                                                -->
																<th class="header">Kode Obat</th>
																<th class="header">Nama Obat</th>
																<th class="header">Satuan</th>
																<th class="header">Tgl. Expire</th>
																<th class="header">Jml.Dist.</th>
															</tr>
														</thead>
														<tbody id="bodyinput">
															<?php
																if(isset($itemsdetiltransaksi)){
																	//$no=1;
																	foreach ($itemsdetiltransaksi as $itemdetil){																			
																	?>
																		<tr>
																			<td style="text-align:center;"><input <?php if($this->mreturgudang->isPosted($no_retur))echo "disabled"; ?> type="checkbox" class="barisinput" /></td>
																			<td><input <?php if($this->mreturgudang->isPosted($no_retur))echo "readonly"; ?> type="text" name="kd_obat[]" value="<?php echo $itemdetil['kdobat'] ?>" style="width:150px !important;" class="input-large bariskodeobat cleared"></td>
																			<td><input <?php if($this->mreturgudang->isPosted($no_retur))echo "readonly"; ?> type="text" name="nama_obat[]" value="<?php echo $itemdetil['nama_obat'] ?>" style="width:650px !important;" class="input-xxlarge barisnamaobat cleared"></td>
																			<td><input <?php if($this->mreturgudang->isPosted($no_retur))echo "readonly"; ?> type="text" name="satuan_kecil[]" value="<?php echo $itemdetil['satuan_kecil'] ?>" style="width:130px;" class="input-medium barissatuan cleared" readonly></td>																			
																			<td><input <?php if($this->mreturgudang->isPosted($no_retur))echo "readonly"; ?> type="text" name="tgl_expire[]" value="<?php echo convertDate($itemdetil['tglexpire']) ?>" class="input-small baristanggal cleared" readonly></td>																			
																			<td><input <?php if($this->mreturgudang->isPosted($no_retur))echo "readonly"; ?> type="text" name="qty[]" value="<?php echo $itemdetil['qty'] ?>" class="input-small barisqty cleared"></td>								
																			<td><input type="hidden" name="jml_stok[]" value="<?php echo $itemdetil['jml_stok'] ?>" class="input-medium barisstok cleared"></td>
																			<td><input type="hidden" name="min_stok[]" value="<?php echo $itemdetil['min_stok'] ?>" class="input-mini barisminstok cleared"></td>
																		</tr>
																	<?php
																		//$no++;
																	}
																}
															?>
														</tbody>														
													</table>
												</div>
											</div>
										</div>
									</div>
									
									<!--div aria-hidden="true" aria-labelledby="approveModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="bukatutupform" style="display: none;">
										<div class="modal-header">
											<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
											<h3 id="helpModalLabel"><i class="icon-external-link"></i> Log Retur ke Gudang</h3>
										</div>
										<div class="modal-body" style="">
											<div class="body" id="collapse4">
												<div class="row-fluid">
													<div class="span12">
														<div class="control-group">
															<label for="no_retur1" class="control-label">No. Retur</label>
															<div class="controls with-tooltip">
																<input type="text" name="no_retur1" id="no_retur1" value="<-?php echo $no_retur; ?>" readonly class="span7 input-tooltip" data-original-title="no retur" data-placement="bottom"/>
																<span class="help-inline"></span>
																<input type="text" name="tgl_log" id="tgl_log" class="input-small input-tooltip cleared" data-original-title="tgl log" data-mask="9999-99-99" value="<-?php echo date('Y-m-d'); ?>" data-placement="bottom"/>
																<input type="text" name="jam_log" id="jam_log" value="<-?php echo date('h:i:s'); ?>" data-mask="99:99:99" class="input-small"/>
																<input type="text" name="jenis" id="jenis" value="<-?php if($this->mreturgudang->isPosted($no_retur)) {echo 1;} else {echo 0;} ?>" class="input-mini input-tooltip cleared" data-original-title="jenis" data-placement="bottom"/>
															</div>
														</div>
													</div>
												</div>
												<div class="control-group">
													<label for="alasan" class="control-label">Alasan</label>
													<div class="controls with-tooltip">
														<textarea id="alasan" name="alasan" cols="90" rows="3" class="input-large" style="width:270px" style="text-align:left;"></textarea>
														<span class="help-inline"></span>
													</div>
												</div>
												<div class="control-group">
													<label for="catatan" class="control-label">&nbsp;</label>
													<div class="controls with-tooltip">
														<-?php if($this->mreturgudang->isPosted($no_retur)) { ?>
															<button class="btn btn-primary" type="submit" name="submit" value="simpanbuka" id="simpanlog">Simpan Log Buka Trans.</button>
														<-?php } //else { ?>
															<!--button class="btn btn-primary" type="submit" name="submit" value="simpantutup" id="simpanlog">Simpan Log Tutup Trans.</button>
														<!--?php } ?-->														
														<!--button aria-hidden="true" data-dismiss="modal" class="btn">Cancel</button>
														<span class="help-inline"></span>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button aria-hidden="true" data-dismiss="modal" class="btn">Close</button>
										</div>
									</div-->
									
									<div aria-hidden="true" aria-labelledby="approveModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="pencarian" style="display: none;width:50%;left:45% !important;">
										<div class="modal-header">
											<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
											<h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Retur ke Gudang</h3>
										</div>
										<div class="modal-body" style="">
											<div class="body" id="collapse4">
												<table id="dataTable1" class="table table-bordered table-condensed table-hover table-striped">
													<thead>
														<tr>
															<th style="text-align:center;">No. Retur</th>
															<th style="text-align:center;">Tanggal</th>
															<th style="text-align:center;">Pilihan</th>
														</tr>
													</thead>
													<tbody>
														<?php
															foreach ($items as $item) {
															# code...																
														?>
																<tr>
																	<td style="text-align:center;"><?php echo $item['no_retur'] ?></td>
																	<td style="text-align:center;"><?php echo $item['tgl_retur'] ?></td>
																	<td style="text-align:center;">
																		<a href="<?php echo base_url() ?>index.php/transapotek/aptreturgudang/ubahreturgudang/<?php echo $item['no_retur'] ?>" class="btn"><i class="icon-edit"></i> PILIH</a>
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

<div aria-hidden="true" aria-labelledby="helpModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="daftarobat" style="display: none;width:70%;margin-left:-400px !important;"> 
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Obat</h3>
    </div>
    <div class="modal-body" id="modal-body-daftarobat" style="height:340px;">
        <div class="body" id="collapse4">
            <table id="dataTable" class="table table-bordered ">
                <thead>
                    <tr>						
                        <th>Kode Obat</th>
                        <th>Nama Obat</th>
						<th>Satuan</th>
						<th>Tgl. Expire</th>
						<th>Stok</th>
                        <th style="width:50px !important;">Pilihan</th>
                    </tr>
                </thead>
                <tbody id="listobat">

                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <input type="text" id="nama_obat1" class="pull-left" autocomplete="off">
        <button aria-hidden="true" data-dismiss="modal" class="btn">Close</button>
    </div>
</div>
			
<script type="text/javascript">
    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });
	
	/*$('#simpanlog').click(function(){
		var batal=0;
		var alasan=$('#alasan').val();
		if(alasan==''){
			alert('Alasan tidak boleh kosong !');
			$('#alasan').focus();
			batal=1;
			return false;
		}
		if(batal)return false;
        $('#bukatutupform').modal("hide");
		location.reload();
    });*/
	
    $('#tgl_retur').datepicker({
        format: 'dd-mm-yyyy'
    });
	
	$('#jam_retur').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
    });
	
	/*$('#jam_log').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
    });*/
	
	function pilihobat(kd_obat1,nama_obat,satuan_kecil,tgl_expire,jml_stok,min_stok) {
		var batal=0;
		$('.bariskodeobat').each(function(){
                var val=$(this).val();
                if(val==kd_obat1){
					alert('Obat sudah di input');
					batal=1;
					return false;
				}
        });
		if(batal)return false;
		
		$('.focused').find('.bariskodeobat').val(kd_obat1);
        $('.focused').find('.barisnamaobat').val(nama_obat);
        $('.focused').find('.barissatuan').val(satuan_kecil);
		$('.focused').find('.baristanggal').val(tgl_expire);
		$('.focused').find('.barisstok').val(jml_stok);
		$('.focused').find('.barisminstok').val(min_stok);
		$('#daftarobat').modal("hide");
        $('.focused').find('input[name="tgl_expire[]"]').focus();
		return false;
    }
	
	$('#tambahbaris').click(function(){	
		if($('.bariskodeobat').length>0){
            $('.barisstok').each(function(){
				var val=$(this).val(); //ambil stok
				var minstok=$('.focused').find('.barisminstok').val();
				var nama_obat=$('.focused').find('.barisnamaobat').val();
				if(parseFloat(minstok)==parseFloat(val)){
                    alert('Obat '+nama_obat+' telah mencapai batas minimum stok !');
                }				
            });

        }
		
		$('#bodyinput').append('<tr><td style="text-align:center;"><input type="checkbox" class="barisinput cleared" /></td>'+
								'<td><input type="text" name="kd_obat[]" value="" style="width:150px !important;" class="input-large bariskodeobat cleared"></td>'+
								'<td><input type="text" name="nama_obat[]" value="" style="width:650px !important;" class="input-xxlarge barisnamaobat cleared"></td>'+
								'<td><input type="text" name="satuan_kecil[]" value="" style="width:130px;" class="input-medium barissatuan cleared" readonly ></td>'+
								'<td><input type="text" name="tgl_expire[]" value="" style="width:100px;" class="input-small baristanggal cleared" readonly ></td>'+									
								'<td><input type="text" name="qty[]" value="" class="input-small barisqty cleared"></td>'+
								'<td><input type="hidden" name="jml_stok[]" value="" class="input-medium barisstok cleared"></td>'+
								'<td><input type="hidden" name="min_stok[]" value="" class="input-mini barisminstok cleared"></td>'+
							'</tr>');
	
		
		$("#bodyinput tr:last input[name='kd_obat[]']").focus();
		$('#bodyinput tr').removeClass('focused'); 
		$("#bodyinput tr:last input[name='kd_obat[]']").parent().parent('tr').addClass('focused');
		
		$('.barisnamaobat, .bariskodeobat, .barissatuan, .baristanggal, .barisqty, .barisstok, .barisminstok').click(function(){  
			$('#bodyinput tr').removeClass('focused');
			$(this).parent().parent('tr').addClass('focused');
		})
		
		$('.barisqty').keyup(function(e){  
            if(e.keyCode == 13){ 
				$('#tambahbaris').trigger('click');
				return false;
            }
        });
		
		$('.bariskodeobat').keyup(function(e){ //di dlm function tambah baris
            if(e.keyCode == 13){
                //alert('xx')
                $('.bariskodeobat').parent().parent('tr').removeClass('focused');
                $(this).parent().parent('tr').addClass('focused');

                $("#dataTable").dataTable().fnDestroy();
                $('#dataTable').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptreturgudang/ambildaftarobatbykode/",
					"sServerMethod": "POST",
                    "fnServerParams": function ( aoData ) {
                      aoData.push( { "name": "kd_obat", "value":""+$('.focused').find('.bariskodeobat').val()+""} );
                    }
                    
                } );
				$('#dataTable').css('width','100%');
                $('#daftarobat').modal("show");
                    var check = function(){
                        if($('#listobat tr').length >0 && !$('#listobat tr').hasClass('ui-selected')){
                            // run when condition is met
                            $('#listobat tr:first').addClass('ui-selected');
                        }
                        else {
                            setTimeout(check, 1000); // check again in a second
                        }
                    }
                    check();     
            }
        }); 
		
		$('.barisnamaobat').keyup(function(e){ //di dlm function tambah baris
            if(e.keyCode == 13){
                //alert('xx')
                $('.barisnamaobat').parent().parent('tr').removeClass('focused');
                $(this).parent().parent('tr').addClass('focused');

                $("#dataTable").dataTable().fnDestroy();
                $('#dataTable').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptreturgudang/ambildaftarobatbynama/",
					"sServerMethod": "POST",
                    "fnServerParams": function ( aoData ) {
                      aoData.push( { "name": "nama_obat", "value":""+$('.focused').find('.barisnamaobat').val()+""} );
                    }
                    
                } );
				$('#dataTable').css('width','100%');
                $('#daftarobat').modal("show");
                    var check = function(){
                        if($('#listobat tr').length >0 && !$('#listobat tr').hasClass('ui-selected')){
                            // run when condition is met
                            $('#listobat tr:first').addClass('ui-selected');
                        }
                        else {
                            setTimeout(check, 1000); // check again in a second
                        }
                    }
                    check();     
            }
        });		
	}); //akhir function tambah baris
	
	$('.barisnamaobat, .bariskodeobat, .barissatuan, .baristanggal, .barisqty, .barisstok, .barisminstok').click(function(){  
		$('#bodyinput tr').removeClass('focused');
		$(this).parent().parent('tr').addClass('focused');
	})
	
	$('.barisqty').keyup(function(e){  
            if(e.keyCode == 13){ 
				$('#tambahbaris').trigger('click');
				return false;
            }
        });
	
	$('#hapusbaris').click(function(){
         $('.barisinput:checked').parents('tr').remove();			
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
	
	$('.bariskodeobat').keyup(function(e){ 
		if(e.keyCode == 13){
			//alert('xx')
			$('.bariskodeobat').parent().parent('tr').removeClass('focused');
			$(this).parent().parent('tr').addClass('focused');

			$("#dataTable").dataTable().fnDestroy();
			$('#dataTable').dataTable( {
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptreturgudang/ambildaftarobatbykode/",
				"sServerMethod": "POST",
				"fnServerParams": function ( aoData ) {
				  aoData.push( { "name": "kd_obat", "value":""+$('.focused').find('.bariskodeobat').val()+""} );
				}				
			} );
			$('#dataTable').css('width','100%');
			$('#daftarobat').modal("show");
				var check = function(){
					if($('#listobat tr').length >0 && !$('#listobat tr').hasClass('ui-selected')){
						// run when condition is met
						$('#listobat tr:first').addClass('ui-selected');
					}
					else {
						setTimeout(check, 1000); // check again in a second
					}
				}
				check();     
		}
	}); 
	
	$('.barisnamaobat').keyup(function(e){ 
		if(e.keyCode == 13){
			//alert('xx')
			$('.barisnamaobat').parent().parent('tr').removeClass('focused');
			$(this).parent().parent('tr').addClass('focused');

			$("#dataTable").dataTable().fnDestroy();
			$('#dataTable').dataTable( {
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptreturgudang/ambildaftarobatbynama/",
				"sServerMethod": "POST",
				"fnServerParams": function ( aoData ) {
				  aoData.push( { "name": "nama_obat", "value":""+$('.focused').find('.barisnamaobat').val()+""} );
				}
				
			} );
			$('#dataTable').css('width','100%');
			$('#daftarobat').modal("show");
				var check = function(){
					if($('#listobat tr').length >0 && !$('#listobat tr').hasClass('ui-selected')){
						// run when condition is met
						$('#listobat tr:first').addClass('ui-selected');
					}
					else {
						setTimeout(check, 1000); // check again in a second
					}
				}
				check();     
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

	$(document).ready(function() {
		$("#daftarobat").on("show", function () {
		  $("body").addClass("modal-open");

		}).on("hidden", function () {
			if($('#daftarobat').is(':visible')){
				$("body").addClass("modal-open");
			}else{
				$("body").removeClass("modal-open");
			}
		});

	}); 	

</script>