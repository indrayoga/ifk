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
	Mousetrap.bindGlobal('ctrl+r', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptdistribusi/tambahdistribusiapt'; return false;});
	Mousetrap.bindGlobal('f10', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptdistribusi'; return false;});
	
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
                var urlnya="<?php echo base_url(); ?>index.php/transapotek/aptdistribusi/periksadistribusi"; //buat validasi inputan
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
                    $('#no_distribusi').val(data.no_distribusi);
                    $('#btn-cetak').removeAttr('disabled');
                    $('#btn-cetak').attr('href','<?php echo base_url() ?>third-party/fpdf/buktidistribusi.php?no_distribusi='+data.no_distribusi+'');
                    $('#btn-tutuptrans').removeAttr('disabled');
                    if(parseInt(data.keluar)>0){
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/transapotek/aptdistribusi';
                    }

                    if(parseInt(data.posting)==1){
                        $('#btn-tutuptrans').attr('value','bukatrans');
                        $('#btn-tutuptrans').text('Buka Trans');
                        //$('#btn-bayar').removeAttr('disabled');
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptdistribusi/ubahdistribusi/'+data.no_distribusi;
                    }
                    if(parseInt(data.posting)==2){
                        //$('#btn-bayar').attr('disabled');                        
                        $('#btn-tutuptrans').attr('value','tutuptrans');
                        $('#btn-tutuptrans').text('Tutup Trans');
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptdistribusi/ubahdistribusi/'+data.no_distribusi;
                    }
					if(parseInt(data.posting)==3){
						 window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptdistribusi/ubahdistribusi/'+data.no_distribusi;
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
						<form class="form-horizontal"  id="form" method="POST" action="<?php echo base_url() ?>index.php/transapotek/aptdistribusi/simpandistribusi">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header class="top" style="">
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>DISTRIBUSI OBAT / ALKES</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/aptdistribusi/"> <i class="icon-list"></i> Daftar / (F10)</a></li>
                                                    <li><a target="_blank" class="btn" id="btn-cetak" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php if(!empty($no_distribusi)){ echo base_url() ?>third-party/fpdf/buktidistribusi.php?no_distribusi=<?php echo $no_distribusi;} else echo '#'; ?>" <?php if(empty($no_distribusi)){ ?>disabled<?php } ?>> <i class="icon-print"></i> Cetak</a></li>
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/aptdistribusi/tambahdistribusiapt"> <i class="icon-plus"></i> Tambah / (Ctrl+R)</a></li>
                                                    <li><button <?php if($this->mdistribusiapt->isPosted($no_distribusi))echo "disabled"; ?> class="btn" id="simpan" type="submit"  name="submit" value="simpan"> <i class="icon-save"></i> Simpan / (Ctrl+S)</button></li>
                                                    <!--li><button <-?php if($this->mdistribusiapt->isPosted($no_distribusi))echo "disabled"; ?> class="btn" type="submit" name="submit" value="simpankeluar"> <i class="icon-save icon-share-alt"></i> Simpan &amp; Keluar</button></li-->
                                                    <!--
                                                    <li><button class="btn" type="submit" name="submit" value="hapus"> <i class="icon-remove"></i> Hapus</button></li>
                                                    
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="#" onclick="xar_confirm('<?php echo base_url() ?>index.php/penerimaan/hapus','Apa anda yakin akan menghapus data ini?')"> <i class="icon-remove"></i> Hapus</a></li>
                                                    -->
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" data-toggle="modal" data-original-title="Pencarian" data-placement="bottom" rel="tooltip" href="#pencarian"> <i class="icon-search"></i> Pencarian / (Ctrl+L)</a></li>
                                                    <!--?php
                                                    if($this->mdistribusiapt->isPosted($no_distribusi)){
                                                    ?>
                                                    <li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="bukatrans" <-?php if(empty($no_distribusi)){ ?>disabled<-?php } ?>> <i class="icon-key"></i> Buka Trans.</a></li>
                                                    <!?php
                                                    }else{
                                                    ?>
                                                    <li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="tutuptrans" <-?php if(empty($no_distribusi)){ ?>disabled<-?php } ?>> <i class="icon-key"></i> Tutup Trans.</button></li>
                                                    <!?php
                                                    }
                                                    ?-->
													<?php
                                                    if($this->mdistribusiapt->isPosted($no_distribusi)){
														if($kd_applogin==0){ ?>
															<li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="bukatrans" <?php echo "disabled"; ?>> <i class="icon-key"></i> Buka Trans.</button></li>
														<?php } else { ?>
															<li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="bukatrans" <?php echo "enabled"; ?> data-toggle="modal" data-original-title="Log Distribusi" data-placement="bottom" rel="tooltip" href="#bukatutupform"> <i class="icon-key"></i> Buka Trans.</button></li>
														<?php } ?>
                                                    <?php
                                                    }else{
                                                    ?>
														<li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="tutuptrans" <?php if(empty($no_distribusi)){ ?>disabled<?php } ?>> <i class="icon-key"></i> Tutup Trans.</button></li>
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
															<label for="no_distribusi" class="control-label">No. Distribusi </label>
															<div class="controls with-tooltip">
																<input type="text" name="no_distribusi" id="no_distribusi" value="<?php echo $no_distribusi; ?>" readonly class="span9 input-tooltip" data-original-title="no distribusi" data-placement="bottom"/>
																<span class="help-inline"></span>
																<input type="text" id="kd_applogin" name="kd_applogin" value="<?php echo $kd_applogin; ?>" class="span2 input-tooltip" data-original-title="kd_applogin" data-placement="bottom"/>
															</div>
														</div>
													</div>
													<div class="span7">
														<div class="control-group">
															<label for="kd_unit_asal" class="control-label">Unit Asal </label>
															<div class="controls with-tooltip">
																<!--select class="input-medium" name="kd_unit_asal" id="kd_unit_asal" readonly>
																<-?php
																	foreach ($dataunitasal as $unitasal) {
																		$select="";
																		
																		if(isset($itemtransaksi['kd_unit_apt'])){    
                                                                            if($itemtransaksi['kd_unit_apt']==$unitasal['kd_unit_apt'])$select="selected=selected";else $select="";																			
                                                                        }
																		else {
																			if($unitasal['kd_unit_apt']==$this->session->userdata('kd_unit_apt'))$select="selected=selected";else $select=""; 
																		}
																?>
																<option value="<-?php if(!empty($unitasal)) echo $unitasal['kd_unit_apt'] ?>" <-?php echo $select; ?>><-?php echo $unitasal['nama_unit_apt'] ?></option>
																<-?php
																	}
																?>
																</select-->
																<input type="text" name="nama_unit_asal" id="nama_unit_asal" value="<?php if($unit=$this->mdistribusiapt->ambilNamaUnit($this->session->userdata('kd_unit_apt'))) echo $unit; ?>" readonly class="span7 input-tooltip" data-original-title="unit asal" data-placement="bottom"/>
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
															<label for="tgl_distribusi" class="control-label">Tgl. Distribusi </label>
															<div class="controls with-tooltip">
																<input <?php if($this->mdistribusiapt->isPosted($no_distribusi))echo "readonly"; ?> type="text" name="tgl_distribusi" id="tgl_distribusi" class="input-small input-tooltip cleared" data-original-title="tgl distribusi" data-mask="99-99-9999" value="<?php if(empty($itemtransaksi['tgl_distribusi']))echo date('d-m-Y'); else echo convertDate($itemtransaksi['tgl_distribusi']); ?>" data-placement="bottom"/>
																<span class="help-inline"></span>
																Shift  <input type="text" id="shift" name="shift" value="<?php if(isset($itemtransaksi['shift']))echo $itemtransaksi['shift'] ?>" class="span3 input-tooltip" data-original-title="shift" data-placement="bottom" readonly />
															</div>
														</div>
													</div>
													<div class="span7">
														<div class="control-group">
															<label for="kd_unit_tujuan" class="control-label">Unit Tujuan </label>
															<div class="controls with-tooltip">
																<select <?php if($this->mdistribusiapt->isPosted($no_distribusi))echo "readonly"; ?> class="input-xlarge cleared" name="kd_unit_tujuan" id="kd_unit_tujuan">
																<option value="">Pilih Unit Tujuan</option>
																<?php
																	foreach ($dataunittujuan as $unittujuan) {
																		$select="";
																		if(isset($itemtransaksi['kd_unit_tujuan'])){    
                                                                            if($itemtransaksi['kd_unit_tujuan']==$unittujuan['kd_unit_apt'])$select="selected=selected";else $select="";
                                                                        }
																?>
																<option value="<?php if(!empty($unittujuan)) echo $unittujuan['kd_unit_apt'] ?>" <?php echo $select; ?>><?php echo $unittujuan['nama_unit_apt'] ?></option>
																<?php
																	}
																?>
																</select>
																<input type="hidden" name="tgl_entry" id="tgl_entry" class="input-small input-tooltip cleared" data-original-title="tgl entry" data-mask="9999-99-99" value="<?php if(empty($tgl_entry))echo date('Y-m-d'); else echo convertDate($tgl_entry); ?>" data-placement="bottom"/>
																<input type="hidden" name="jam_distribusi" id="jam_distribusi" value="<?php echo date('h:i:s'); ?>" data-mask="99:99:99" class="input-small"/>
																<input type="hidden" id="jam_distribusi1" name="jam_distribusi1" value="<?php if(isset($itemtransaksi['jam_distribusi']))echo $itemtransaksi['jam_distribusi'] ?>" class="input-small" data-original-title="jam distribusi" data-placement="bottom"/>
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
															<li><button <?php if($this->mdistribusiapt->isPosted($no_distribusi))echo "disabled"; ?> class="btn" type="button" id="tambahbaris"> <i class="icon-plus"></i> Tambah Obat (Ctrl+B)</button></li>
															<li><button <?php if($this->mdistribusiapt->isPosted($no_distribusi))echo "disabled"; ?> class="btn" type="button" id="hapusbaris"> <i class="icon-remove"></i> Hapus Obat</button></li>
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
																<th class="header">No. Permintaan</th>
																<th class="header">Kode Obat</th>
																<th class="header">Nama Obat</th>
																<th class="header" style="width:230px;">Satuan</th>
																<th class="header" style="width:130px;">Tgl. Expire</th>
																<th class="header" style="width:70px;">Jml.Req</th>
																<th class="header" style="width:70px;">Jml.Dist.</th>
															</tr>
														</thead>
														<tbody id="bodyinput">
															<?php
																if(isset($itemsdetiltransaksi)){
																	//$no=1;
																	foreach ($itemsdetiltransaksi as $itemdetil){																			
																	?>
																		<tr>
																			<td style="text-align:center;"><input <?php if($this->mdistribusiapt->isPosted($no_distribusi))echo "disabled"; ?> type="checkbox" class="barisinput" /></td>
																			<td><input <?php if($this->mdistribusiapt->isPosted($no_distribusi))echo "readonly"; ?> type="text" name="no_permintaan[]" value="<?php echo $itemdetil['no_permintaan'] ?>" style="width:150px !important;" class="input-medium barisnomor cleared"></td>
                                                                            <td><input <?php if($this->mdistribusiapt->isPosted($no_distribusi))echo "readonly"; ?> type="text" name="kd_obat[]" value="<?php echo $itemdetil['kdobat'] ?>" style="width:100px !important;" class="input-medium bariskodeobat cleared"></td>
																			<td><input <?php if($this->mdistribusiapt->isPosted($no_distribusi))echo "readonly"; ?> type="text" name="nama_obat[]" value="<?php echo $itemdetil['nama_obat'] ?>" style="width:540px !important;" class="input-xlarge barisnamaobat cleared"></td>
																			<td><input <?php if($this->mdistribusiapt->isPosted($no_distribusi))echo "readonly"; ?> type="text" name="satuan_kecil[]" value="<?php echo $itemdetil['satuan_kecil'] ?>" style="width:130px;" class="input-medium barissatuan cleared" readonly></td>																			
																			<td><input <?php if($this->mdistribusiapt->isPosted($no_distribusi))echo "readonly"; ?> type="text" name="tgl_expire[]" value="<?php echo convertDate($itemdetil['tglexpire']) ?>" class="input-small baristanggal cleared" readonly></td>																			
																			<?php if($itemdetil['no_permintaan']=='') { ?>
																					<td><input <?php if($this->mdistribusiapt->isPosted($no_distribusi))echo "readonly"; ?> type="text" name="jml_req[]" value="0" class="input-small barisrequest cleared" readonly></td>	
																			<?php } else { ?>
																					<td><input <?php if($this->mdistribusiapt->isPosted($no_distribusi))echo "readonly"; ?> type="text" name="jml_req[]" value="<?php echo $itemdetil['qty'] ?>" class="input-small barisrequest cleared" readonly></td>	
																			<?php } ?>																			
																			<td><input <?php if($this->mdistribusiapt->isPosted($no_distribusi))echo "readonly"; ?> type="text" name="qty[]" value="<?php echo $itemdetil['qty'] ?>" class="input-small barisqty cleared"></td>								
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
									
									<div aria-hidden="true" aria-labelledby="approveModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="bukatutupform" style="display: none;">
										<div class="modal-header">
											<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
											<h3 id="helpModalLabel"><i class="icon-external-link"></i> Log Distribusi</h3>
										</div>
										<div class="modal-body" style="">
											<div class="body" id="collapse4">
												<div class="row-fluid">
													<div class="span12">
														<div class="control-group">
															<label for="no_distribusi1" class="control-label">No. Distribusi</label>
															<div class="controls with-tooltip">
																<input type="text" name="no_distribusi1" id="no_distribusi1" value="<?php echo $no_distribusi; ?>" readonly class="span7 input-tooltip" data-original-title="no distribusi" data-placement="bottom"/>
																<span class="help-inline"></span>
																<input type="hidden" name="tgl_log" id="tgl_log" class="input-small input-tooltip cleared" data-original-title="tgl log" data-mask="9999-99-99" value="<?php echo date('Y-m-d'); ?>" data-placement="bottom"/>
																<input type="hidden" name="jam_log" id="jam_log" value="<?php echo date('h:i:s'); ?>" data-mask="99:99:99" class="input-small"/>
																<input type="hidden" name="jenis" id="jenis" value="<?php if($this->mdistribusiapt->isPosted($no_distribusi)) {echo 1;} else {echo 0;} ?>" class="input-mini input-tooltip cleared" data-original-title="jenis" data-placement="bottom"/>
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
														<?php if($this->mdistribusiapt->isPosted($no_distribusi)) { ?>
															<button class="btn btn-primary" type="submit" name="submit" value="simpanbuka" id="simpanlog">Simpan Log Buka Trans.</button>
														<?php } //else { ?>
															<!--button class="btn btn-primary" type="submit" name="submit" value="simpantutup" id="simpanlog">Simpan Log Tutup Trans.</button>
														<!--?php } ?-->														
														<button aria-hidden="true" data-dismiss="modal" class="btn">Cancel</button>
														<span class="help-inline"></span>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button aria-hidden="true" data-dismiss="modal" class="btn">Close</button>
										</div>
									</div>
									
									<div aria-hidden="true" aria-labelledby="approveModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="pencarian" style="display: none;width:77%;left:34% !important;">
										<div class="modal-header">
											<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
											<h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Distribusi</h3>
										</div>
										<div class="modal-body" style="">
											<div class="body" id="collapse4">
												<table id="dataTable1" class="table table-bordered table-condensed table-hover table-striped">
													<thead>
														<tr>
															<th>No Distribusi</th>
															<th>Tanggal</th>
															<th>Unit Tujuan</th>
															<!--<th>Approve</th>-->
															<th>Pilihan</th>
														</tr>
													</thead>
													<tbody>
														<?php
															foreach ($items as $item) {
															# code...																
														?>
																<tr>
																	<td><?php echo $item['no_distribusi'] ?></td>
																	<td><?php echo $item['tgl_distribusi'] ?></td>
																	<td><?php echo $item['unit_tujuan'] ?></td>																																	
															<!--
															<td style="text-align:center;"></td>
															-->	
																	<td>
																		<a href="<?php echo base_url() ?>index.php/transapotek/aptdistribusi/ubahdistribusi/<?php echo $item['no_distribusi'] ?>" class="btn"><i class="icon-edit"></i> PILIH</a>
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

<div aria-hidden="true" aria-labelledby="helpModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="daftarrequest" style="display: none;width:50%;margin-left:-400px !important;"> 
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Permintaan Obat</h3>
    </div>
    <div class="modal-body" style="height:260px;">
        <div class="body" id="collapse4">
            <table id="dataTable2" class="table table-bordered table-condensed table-hover table-striped">
                <thead>
					<tr>	
						<th>&nbsp;</th>
                        <th style="text-align:center;">No. Permintaan</th>
                        <th style="text-align:center;">Tgl. Permintaan</th>
						<th style="text-align:center;">Unit Apotek</th>
						<!--th style="text-align:center;" style="width:50px !important;">Pilihan</th-->
                    </tr>					
                </thead>
                <tbody id="listrequest">
					<th></th>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <input type="text" id="nama_obat2" class="pull-left" autocomplete="off">		
		<button aria-hidden="true" data-dismiss="modal" class="btn" id="pilihceklis">Pilih</button>
        <button aria-hidden="true" data-dismiss="modal" class="btn">Close</button>		
    </div>
</div>
			
<script type="text/javascript">
    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });
	
	$('#jam_log').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
    });
	
	$('#simpanlog').click(function(){
		//alert('bagos');
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
    });
	
	$('#tgl_entry').datepicker({
        format: 'yyyy-mm-dd'
    });
	
    $('#tgl_distribusi').datepicker({
        format: 'dd-mm-yyyy'
    });
	
	$('#jam_distribusi').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
    });
	
	$('#kd_unit_asal').change(function(){
		$.ajax({
			url: '<?php echo base_url() ?>index.php/transapotek/aptdistribusi/ambilunittujuan/',
			async:false,
			type:'get',
			data:{query:$(this).val()},
			success:function(data){
				//typeahead.process(data)
				$('#kd_unit_tujuan').empty();
				$.each(data,function(i,l){
					//alert(l);
					$('#kd_unit_tujuan').append('<option value="'+l.kd_unit_apt+'">'+l.nama_unit_apt+'</option>');
				});
				
			},
			dataType:'json'                         
        });
	});
	
	function pilihrequest(no_permintaan,tgl_permintaan,unit_tujuan) {
		$('.focused').find('.barisnomor').val(no_permintaan);
		$.ajax({
			url: '<?php echo base_url() ?>index.php/transapotek/aptdistribusi/ambildetilpermintaan/', //ambil detil requestnya
			async:false,
			type:'get',
			//data:{query:no_pemesanan},
			data:{query:no_permintaan},
			success:function(data){
			//typeahead.process(data)
				$('#bodyinput').empty();
				$.each(data,function(i,l){
					//alert(l);		
					$('#bodyinput').append('<tr><td style="text-align:center;"><input type="checkbox" class="barisinput cleared" /></td>'+
												'<td><input type="text" name="no_permintaan[]" value="'+l.no_permintaan+'" style="width:150px !important;" class="input-medium barisnomor cleared"></td>'+
												'<td><input type="text" name="kd_obat[]" value="'+l.kd_obat1+'" style="width:100px !important;" class="input-medium bariskodeobat cleared"></td>'+
												'<td><input type="text" name="nama_obat[]" value="'+l.nama_obat+'" style="width:540px !important;" class="input-xlarge barisnamaobat cleared"></td>'+
												'<td><input type="text" name="satuan_kecil[]" value="'+l.satuan_kecil+'" style="width:130px;" class="input-medium barissatuan cleared" readonly ></td>'+
												'<td><input type="text" name="tgl_expire[]" value="'+l.tgl_expire1+'" style="width:100px;" class="input-small baristanggal cleared" readonly ></td>'+									
												'<td><input type="text" name="jml_req[]" value="'+l.jml_req+'" class="input-small barisrequest cleared" readonly></td>'+									
												'<td><input type="text" name="qty[]" value="'+l.jml_req+'" class="input-small barisqty cleared" ></td>'+
												'<td><input type="hidden" name="jml_stok[]" value="'+l.jml_stok+'" class="input-medium barisstok cleared"></td>'+
												'<td><input type="hidden" name="min_stok[]" value="'+l.min_stok+'" class="input-mini barisminstok cleared"></td>'+
											'</tr>');
					
				});	
				$('#daftarrequest').modal("hide");
				
				$("#bodyinput tr:last input[name='qty[]']").focus();
				$('#bodyinput tr').removeClass('focused'); 
				$("#bodyinput tr:last input[name='qty[]']").parent().parent('tr').addClass('focused');
				
				$('.barisnamaobat, .barisnomor, .bariskodeobat, .barissatuan, .baristanggal, .barisqty, .barisstok, .barisminstok, .barisrequest').click(function(){  
					$('#bodyinput tr').removeClass('focused');
					$(this).parent().parent('tr').addClass('focused');
				})
			},
			dataType:'json'                         
		}); 
    }
	
	$('.barisnomor').keyup(function(e){ 
		if(e.keyCode == 13){
			//alert('xx')

			$.ajax({
				url: '<?php echo base_url() ?>index.php/transapotek/aptdistribusi/ambildaftarpermintaan/',
				async:false,
				type:'get',
				data:{query:$(this).val(),tes:$('#kd_unit_tujuan').val()},
				success:function(data){
					//typeahead.process(data)
					$('#listrequest').empty();
					$.each(data,function(i,l){
						//alert(l);
						//$('#listbarang').append('<tr><td><input type="checkbox" class="ceklis" name="ceklis" value="'+l.no_ro+'"/></td><td style="text-align:center;">'+l.kd_barang+'</td><td>'+l.nama_barang+'</td><td style="text-align:center;">'+l.satuan+'</td><td style="text-align:right;">'+l.jml_req+'</td><td><a class="btn" onclick=\'pilihbarang("'+l.no_ro+'","'+l.kd_barang+'","'+l.nama_barang+'","'+l.satuan+'","'+l.jml_req+'","'+l.jml_stok+'")\'>Pilih</a></td></tr>');
						$('#listrequest').append('<tr><td><input type="checkbox" class="ceklis" name="ceklis" value="'+l.no_permintaan+'"/></td><td style="text-align:center;">'+l.no_permintaan+'</td><td>'+l.tgl_permintaan+'</td><td style="text-align:right;">'+l.unit_tujuan+'</td></tr>');
					});                        
				},
				dataType:'json'                         
			}); 
			var ex = document.getElementById('dataTable2');
			if ( ! $.fn.DataTable.fnIsDataTable( ex ) ) {
				$('#dataTable2').dataTable({
				"sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "Show _MENU_ entries"
				}
				});
				var oTable = $('#dataTable2').dataTable();
				$('#nama_obat2').keyup(function(e){

					oTable.fnFilter( $(this).val() );
					if(e.keyCode == 13){
						//alert('xx')
						return false;
					}
				});
		   }

			$('#daftarrequest').modal("show");                                      
		}
	});
	
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
        $('.focused').find('input[name="jml_req[]"]').focus();
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
								'<td><input type="text" name="no_permintaan[]" value="" style="width:150px !important;" class="input-medium barisnomor cleared" ></td>'+
								'<td><input type="text" name="kd_obat[]" value="" style="width:100px !important;" class="input-medium bariskodeobat cleared"></td>'+
								'<td><input type="text" name="nama_obat[]" value="" style="width:540px !important;" class="input-xlarge barisnamaobat cleared"></td>'+
								'<td><input type="text" name="satuan_kecil[]" value="" style="width:130px;" class="input-medium barissatuan cleared" readonly ></td>'+
								'<td><input type="text" name="tgl_expire[]" value="" style="width:100px;" class="input-small baristanggal cleared" readonly ></td>'+									
								'<td><input type="text" name="jml_req[]" value="" class="input-small barisrequest cleared" readonly></td>'+									
								'<td><input type="text" name="qty[]" value="" class="input-small barisqty cleared"></td>'+
								'<td><input type="hidden" name="jml_stok[]" value="" class="input-medium barisstok cleared"></td>'+
								'<td><input type="hidden" name="min_stok[]" value="" class="input-mini barisminstok cleared"></td>'+
							'</tr>');
	
		
		$("#bodyinput tr:last input[name='kd_obat[]']").focus();
		$('#bodyinput tr').removeClass('focused'); 
		$("#bodyinput tr:last input[name='kd_obat[]']").parent().parent('tr').addClass('focused');
		
		$('.barisnamaobat, .barisnomor, .bariskodeobat, .barissatuan, .baristanggal, .barisqty, .barisstok, .barisminstok, .barisrequest').click(function(){  
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
			var od=$('.focused').find('.barisnomor').val();
            if(e.keyCode == 13){
				if(od==''){
					$('.bariskodeobat').parent().parent('tr').removeClass('focused');
					$(this).parent().parent('tr').addClass('focused');

					$("#dataTable").dataTable().fnDestroy();
					$('#dataTable').dataTable( {
						"bProcessing": true,
						"bServerSide": true,
						"sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptdistribusi/ambildaftarobatbykode/",
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
            }
        }); 
		
		$('.barisnamaobat').keyup(function(e){ //di dlm function tambah baris
			var od=$('.focused').find('.barisnomor').val();
            if(e.keyCode == 13){
				if(od==''){
					$('.barisnamaobat').parent().parent('tr').removeClass('focused');
					$(this).parent().parent('tr').addClass('focused');

					$("#dataTable").dataTable().fnDestroy();
					$('#dataTable').dataTable( {
						"bProcessing": true,
						"bServerSide": true,
						"sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptdistribusi/ambildaftarobatbynama/",
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
            }
        });
		
		$('.barisnomor').keyup(function(e){ 
			if(e.keyCode == 13){
				//alert('xx')

				$.ajax({
					url: '<?php echo base_url() ?>index.php/transapotek/aptdistribusi/ambildaftarpermintaan/',
					async:false,
					type:'get',
					data:{query:$(this).val(),tes:$('#kd_unit_tujuan').val()},
					success:function(data){
						//typeahead.process(data)
						$('#listrequest').empty();
						$.each(data,function(i,l){
							$('#listrequest').append('<tr><td><input type="checkbox" class="ceklis" name="ceklis" value="'+l.no_permintaan+'"/></td><td style="text-align:center;">'+l.no_permintaan+'</td><td style="text-align:center;">'+l.tgl_permintaan+'</td><td style="text-align:center;">'+l.unit_tujuan+'</td></tr>');
						});                        
					},
					dataType:'json'                         
				}); 
				var ex = document.getElementById('dataTable2');
				if ( ! $.fn.DataTable.fnIsDataTable( ex ) ) {
					$('#dataTable2').dataTable({
					"sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
					"sPaginationType": "bootstrap",
					"oLanguage": {
						"sLengthMenu": "Show _MENU_ entries"
					}
					});
					var oTable = $('#dataTable2').dataTable();
					$('#nama_obat2').keyup(function(e){
						oTable.fnFilter( $(this).val() );
						if(e.keyCode == 13){
							//alert('xx')
							return false;
						}
					});
			   }
				$('#daftarrequest').modal("show");                                      
			}
		});
		
		$('#pilihceklis').click(function(){ //bwt tombol pilih yg kalo udh di ceklis--> di dlm form popup
			var ceklis=""; 
			$('.ceklis').each(function(){
				 if($(this).attr('checked')){
					ceklis+=$(this).val()+',';					
				}
			});
			$.ajax({
				url: '<?php echo base_url() ?>index.php/transapotek/aptdistribusi/ambildetilpermintaan/', //ambil detil requestnya
				async:false,
				type:'get',
				data:{query:ceklis},
				success:function(data){
				//typeahead.process(data)
					$('#bodyinput').empty();
					$.each(data,function(i,l){
						$('#bodyinput').append('<tr><td style="text-align:center;"><input type="checkbox" class="barisinput cleared" /></td>'+
												'<td><input type="text" name="no_permintaan[]" value="'+l.no_permintaan+'" style="width:150px !important;" class="input-medium barisnomor cleared"></td>'+
												'<td><input type="text" name="kd_obat[]" value="'+l.kd_obat1+'" style="width:100px !important;" class="input-medium bariskodeobat cleared"></td>'+
												'<td><input type="text" name="nama_obat[]" value="'+l.nama_obat+'" style="width:540px !important;" class="input-xlarge barisnamaobat cleared"></td>'+
												'<td><input type="text" name="satuan_kecil[]" value="'+l.satuan_kecil+'" style="width:130px;" class="input-medium barissatuan cleared" readonly ></td>'+
												'<td><input type="text" name="tgl_expire[]" value="'+l.tgl_expire1+'" style="width:100px;" class="input-small baristanggal cleared" readonly ></td>'+									
												'<td><input type="text" name="jml_req[]" value="'+l.jml_req+'" class="input-small barisrequest cleared" readonly></td>'+									
												'<td><input type="text" name="qty[]" value="'+l.jml_req+'" class="input-small barisqty cleared" ></td>'+
												'<td><input type="hidden" name="jml_stok[]" value="'+l.jml_stok+'" class="input-medium barisstok cleared"></td>'+
												'<td><input type="hidden" name="min_stok[]" value="'+l.min_stok+'" class="input-mini barisminstok cleared"></td>'+
											'</tr>');
						
					});	
					$('#daftarrequest').modal("hide");
					
					$("#bodyinput tr:last input[name='qty[]']").focus();
					$('#bodyinput tr').removeClass('focused'); 
					$("#bodyinput tr:last input[name='qty[]']").parent().parent('tr').addClass('focused');
					
					$('.barisnamaobat, .barisnomor, .bariskodeobat, .barissatuan, .baristanggal, .barisqty, .barisstok, .barisminstok, .barisrequest').click(function(){  
						$('#bodyinput tr').removeClass('focused');
						$(this).parent().parent('tr').addClass('focused');
					})
					
				},
				dataType:'json'                         
			});	 
		})
		
	}); //akhir function tambah baris
	
	$('.barisnamaobat, .barisnomor, .bariskodeobat, .barissatuan, .baristanggal, .barisqty, .barisstok, .barisminstok, .barisrequest').click(function(){  
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
		var od=$('.focused').find('.barisnomor').val();
		if(e.keyCode == 13){
			if(od==''){
				//alert('xx')
				$('.bariskodeobat').parent().parent('tr').removeClass('focused');
				$(this).parent().parent('tr').addClass('focused');

				$("#dataTable").dataTable().fnDestroy();
				$('#dataTable').dataTable( {
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptdistribusi/ambildaftarobatbykode/",
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
		}
	}); 
	
	$('.barisnamaobat').keyup(function(e){ 
		if(e.keyCode == 13){
			var od=$('.focused').find('.barisnomor').val();
			if(od==''){
				//alert('xx')    
				$('.barisnamaobat').parent().parent('tr').removeClass('focused');
				$(this).parent().parent('tr').addClass('focused');

				$("#dataTable").dataTable().fnDestroy();
				$('#dataTable').dataTable( {
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptdistribusi/ambildaftarobatbynama/",
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