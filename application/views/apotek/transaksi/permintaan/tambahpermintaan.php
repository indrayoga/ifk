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
	<?php if($this->session->userdata('kd_unit_apt')!=$this->session->userdata('kd_unit_apt_gudang')) { ?>
			Mousetrap.bindGlobal('ctrl+r', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptpermintaan/tambahpermintaan'; return false;});
			
			Mousetrap.bindGlobal('ctrl+s', function() { 
				$('#simpan').trigger('click');
				return false;
			});
			
			Mousetrap.bindGlobal('ctrl+b', function() { 
				$('#tambahbaris').trigger('click');
				return false;
			});
	<?php } ?>
	
	//Mousetrap.bindGlobal('f4', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptpemesanan'; return false;});
	
	
	
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

    Mousetrap.bind('enter', function(e) { 

        if($('#daftarobat').is(':visible')){
            $('.ui-selected').find('.btn').trigger('click');
            return false;
        }
        return false;
    });
	
	Mousetrap.bindGlobal('ctrl+l', function() { 
		$('#pencarian').modal("show");
		return false;
	});
	
</script>

<script type="text/javascript">

    $(document).ready(function() {
		$('#kd_supplier').focus();
       /* var totalpengajuan=0;
        $('.barisjumlah').each(function(){
                var val=$(this).val();
                if(val=='')val=0;
                totalpengajuan=totalpengajuan+parseFloat(val);
        });
        $('#jumlahapprove').val(totalpengajuan);
        $('#totalpengajuan').val(totalpengajuan);*/

        $('#form').ajaxForm({
            beforeSubmit: function(a,f,o) {
                o.dataType = "json";
                $('div.error').removeClass('error');
                $('span.help-inline').html('');
                $('#progress').show();
                $('body').append('<div id="overlay1" style="position: fixed;height: 100%;width: 100%;z-index: 1000000;"></div>');
                $('body').addClass('body1');
                var urlnya="<?php echo base_url(); ?>index.php/transapotek/aptpermintaan/periksapermintaan"; //buat validasi inputan
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
                    $('#no_permintaan').val(data.no_permintaan);
                    $('#btn-cetak').removeAttr('disabled');
                    $('#btn-cetak').attr('href','<?php echo base_url() ?>third-party/fpdf/buktipermintaan.php?no_permintaan='+data.no_permintaan+'');
                    $('#btn-approve').removeAttr('disabled');
                    if(parseInt(data.keluar)>0){
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptpermintaan';
                    }
					if(parseInt(data.posting)==3){
						 window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptpermintaan/ubahpermintaan/'+data.no_permintaan;
					}  
					if(parseInt(data.posting)==1){
                        $('#btn-approve').attr('value','unapprove');
                        $('#btn-approve').text('Batal Approve');
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptpermintaan/ubahpermintaan/'+data.no_permintaan;
                    }
                    if(parseInt(data.posting)==2){
                        //$('#btn-bayar').attr('disabled');                        
                        $('#btn-approve').attr('value','approve');
                        $('#btn-approve').text('Approve');
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptpermintaan/ubahpermintaan/'+data.no_permintaan;
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
						<form class="form-horizontal"  id="form" method="POST" action="<?php echo base_url() ?>index.php/transapotek/aptpermintaan/simpanpermintaan">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header class="top" style="">
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>PERMINTAAN OBAT / ALKES</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/aptpermintaan/"> <i class="icon-list"></i> Daftar </a></li>
													<?php if($this->session->userdata('kd_unit_apt')!=$this->session->userdata('kd_unit_apt_gudang')) { ?>
															<li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/aptpermintaan/tambahpermintaan"> <i class="icon-plus"></i> Tambah / (Ctrl+R)</a></li>
													<?php } ?>													
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" data-toggle="modal" data-original-title="Pencarian" data-placement="bottom" rel="tooltip" href="#pencarian"> <i class="icon-search"></i> Pencarian / (Ctrl+L)</a></li>
                                                    <li><button <?php if($this->session->userdata('kd_unit_apt')==$this->session->userdata('kd_unit_apt_gudang'))echo "disabled"; ?> <?php if($this->mpermintaan->isPosted($no_permintaan))echo "disabled"; ?> class="btn" id="simpan" type="submit"  name="submit" value="simpan"> <i class="icon-save"></i> Simpan / (Ctrl+S)</button></li>
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
														<div class="control-group">
															<label for="no_permintaan" class="control-label">Nomor</label>
															<div class="controls with-tooltip">
																<input type="text" name="no_permintaan" id="no_permintaan" value="<?php echo $no_permintaan; ?>" readonly class="span2 input-tooltip" data-original-title="no permintaan" data-placement="bottom"/>
																<span class="help-inline"></span>
																Tgl. Permintaan <input <?php if($this->mpermintaan->isPosted($no_permintaan))echo "readonly"; ?> type="text" name="tgl_permintaan" id="tgl_permintaan" class="input-small input-tooltip cleared" data-original-title="tgl permintaan" data-mask="99-99-9999" value="<?php if(empty($itemtransaksi['tgl_permintaan']))echo date('d-m-Y'); else echo convertDate($itemtransaksi['tgl_permintaan']);  ?>" data-placement="bottom"/>
																<input type="hidden" name="jam_permintaan" id="jam_permintaan" value="<?php echo date('h:i:s'); ?>" data-mask="99:99:99" class="input-small"/>
																<input type="hidden" id="jam_permintaan1" name="jam_permintaan1" value="<?php if(isset($itemtransaksi['jam_permintaan']))echo $itemtransaksi['jam_permintaan'] ?>" class="input-small" data-original-title="jam permintaan" data-placement="bottom"/>
															</div>
														</div>												
												</div>
											</div>
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <!--div class="span8"-->
                                                        <div class="control-group">
                                                            <label for="keterangan" class="control-label">Keterangan </label>
                                                            <div class="controls with-tooltip">
                                                                <input <?php if($this->mpermintaan->isPosted($no_permintaan))echo "readonly"; ?> type="text" id="keterangan" name="keterangan" value="<?php if(isset($itemtransaksi['keterangan']))echo $itemtransaksi['keterangan'] ?>" class="span7 input-tooltip cleared" data-original-title="keterangan" data-placement="bottom"/>
                                                                <span class="help-inline"></span>                                                               
                                                            </div>
                                                        </div>
                                                    <!--/div-->                                                 
                                                </div>
                                                 <div id="progress" style="display:none;"></div>
                                            </div>                                                                                                                                                                              
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <!--div class="span8"-->
                                                        <div class="control-group">
                                                            <label for="asal" class="control-label">Asal Permintaan </label>
                                                            <div class="controls with-tooltip">
                                                                <input readonly type="text" id="asal" name="asal" value="<?php if(isset($itemtransaksi['nama_unit_apt']))echo $itemtransaksi['nama_unit_apt'] ?>" class="span7 input-tooltip cleared" data-original-title="keterangan" data-placement="bottom"/>
                                                                <span class="help-inline"></span>                                                               
                                                            </div>
                                                        </div>
                                                    <!--/div-->                                                 
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
															<li><button <?php if($this->session->userdata('kd_unit_apt')==$this->session->userdata('kd_unit_apt_gudang'))echo "disabled"; ?> <?php if($this->mpermintaan->isPosted($no_permintaan))echo "disabled"; ?> class="btn" type="button" id="tambahbaris"> <i class="icon-plus"></i> Tambah Obat (Ctrl+B)</button></li>
															<li><button <?php if($this->mpermintaan->isPosted($no_permintaan))echo "disabled"; ?> class="btn" type="button" id="hapusbaris"> <i class="icon-remove"></i> Hapus Obat</button></li>
														</ul>
													</div>
												<!-- /.toolbar -->
												</header>
												<div class="body collapse in" id="defaultTable">
													<table class="table responsive">
														<thead>
															<tr style="font-size:95% !important;">
																<th class="header" width="2%">&nbsp;</th>
																<th class="header" width="10%" >Kode Obat</th>
																<th class="header" width="40%">Nama Obat</th>
																<th class="header" width="10%">Satuan</th>
																<th class="header" width="7%">Tgl. Expire</th>
																<th class="header">Qty</th>
															</tr>
														</thead>
														<tbody id="bodyinput">
															<?php
																if(isset($itemsdetiltransaksi)){
																	//$no=1;
																	foreach ($itemsdetiltransaksi as $itemdetil){																			
																	?>
																		<tr style="font-size:80% !important;">
																			<td><input <?php if($this->mpermintaan->isPosted($no_permintaan))echo "readonly"; ?> type="checkbox" class="barisinput cleared" /></td>
																			<td style="text-align:left;"><input <?php if($this->mpermintaan->isPosted($no_permintaan))echo "readonly"; ?> type="text" name="kd_obat[]" value="<?php echo $itemdetil['kd_obat'] ?>" class="input-medium bariskodeobat cleared" ></td>
																			<td style="text-align:left;"><input <?php if($this->mpermintaan->isPosted($no_permintaan))echo "readonly"; ?> type="text" name="nama_obat[]" value="<?php echo $itemdetil['nama_obat'] ?>" class="input-xxlarge barisnamaobat cleared" ></td>
																			<td style="text-align:left;"><input <?php if($this->mpermintaan->isPosted($no_permintaan))echo "readonly"; ?> style="text-align:center;" type="text" name="satuan_kecil[]" value="<?php echo $itemdetil['satuan_kecil'] ?>" class="input-medium barissatuan cleared" readonly ></td>
																			<td style="text-align:left;"><input <?php if($this->mpermintaan->isPosted($no_permintaan))echo "readonly"; ?> style="text-align:center;" type="text" name="tgl_expire[]" value="<?php echo convertDate($itemdetil['tgl_expire']) ?>" class="input-small baristanggal cleared" readonly ></td>
																			<td style="text-align:left;"><input <?php if($this->mpermintaan->isPosted($no_permintaan))echo "readonly"; ?> style="text-align:right;" type="text" name="jml_req[]" value="<?php echo $itemdetil['jml_req'] ?>" class="input-small barisqty cleared" ></td>
																		</tr>
																	<?php
																		//$no++;
																	}
																}
															?>

														</tbody>
														<!--tfoot>
															<tr>
																<th colspan="14" style="text-align:right;" class="header">Total Pengajuan (Rp) : <input type="text" class="input-medium cleared" id="totalpengajuan" style="text-align:right" disabled></th>
															</tr>
														</tfoot-->
													</table>
												</div>
											</div>
										</div>
									</div>									
									
									<div aria-hidden="true" aria-labelledby="approveModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="pencarian" style="display: none;width:77%;left:34% !important;">
										<div class="modal-header">
											<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
											<h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Permintaan</h3>
										</div>
										<div class="modal-body" style="">
											<div class="body" id="collapse4">
												<table id="dataTable1" class="table table-bordered table-condensed table-hover table-striped">
													<thead>
														<tr>
															<th>No Permintaan</th>
															<th>Tgl Permintaan</th>
															<th>Keterangan</th>																														
															<th>Status Approve</th>
															<th>Status Permintaan</th>
															<th>Pilihan</th>
														</tr>
													</thead>
													<tbody>
														<?php
															foreach ($items as $item) {
															# code...	
																$status=""; $status1="";
																if($item['status_approve']==1){$status="Sudah di Approve";}
																else{$status="Belum di Approve";}
																if($item['permintaan_status']==1){$status1="Sudah di Distribusi";}
																else{$status1="Belum di Distribusi";}
														?>
																<tr>
																	<td><?php echo $item['no_permintaan'] ?></td>
																	<td><?php echo $item['tgl_permintaan'] ?></td>
																	<td><?php echo $item['keterangan'] ?></td>
																	<td><?php echo $status;?></td>
																	<td><?php echo $status1; ?></td>	
															<!--
															<td style="text-align:center;"></td>
															-->	
																	<td>
																		<a href="<?php echo base_url() ?>index.php/transapotek/aptpermintaan/ubahpermintaan/<?php echo $item['no_permintaan'] ?>" class="btn"><i class="icon-edit"></i> PILIH</a>
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

<div aria-hidden="true" aria-labelledby="helpModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="daftarsupplier" style="display: none;width:60%;margin-left:-400px !important;"> 
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Distributor</h3>
    </div>
    <div class="modal-body" style="height:340px;">
        <div class="body" id="collapse4">
			<table id="dataTable5" class="table table-bordered ">
                <thead>
                    <tr>						
                        <th>Kode</th>
                        <th>Nama Distributor</th>
						<th>Alamat</th>
                        <th style="width:50px !important;">Pilihan</th>
                    </tr>
                </thead>
                <tbody id="listsupplier">

                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <input type="text" id="nama1" class="pull-left" autocomplete="off">
        <button aria-hidden="true" data-dismiss="modal" class="btn">Close</button>
    </div>
</div>
			
<div aria-hidden="true" aria-labelledby="helpModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="daftarobat" style="display: none;width:70%;margin-left:-400px !important;"> 
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Obat</h3>
    </div>
    <div class="modal-body" id="modal-body-daftarobat" style="height:300px;">
        <div class="body" id="collapse4">
            <table id="dataTable4" class="table table-bordered">
                <thead>
                    <tr>						
                        <th>Kode Obat</th>
                        <th>Nama Obat</th>
						<th>Satuan</th>
						<th>Tgl.Expire</th> 
                        <th style="width:50px !important;">Pilihan</th>
                    </tr>
                </thead>
                <tbody id="listobat">

                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <input type="text" id="nama_obat" class="pull-left" autocomplete="off">
        <button aria-hidden="true" data-dismiss="modal" class="btn">Close</button>
    </div>
</div>
			
<script type="text/javascript">
    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });
	
	$('#tgl_permintaan').datepicker({
        format: 'dd-mm-yyyy'
    });
	
	$('#jam_permintaan').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
    });
	
	//function pilihobat(kd_obat,nama_obat,satuan_kecil,pembanding,harga_beli) {
	function pilihobat(kd_obat1,nama_obat,satuan_kecil,tgl_expire) {
        var x=0;
        $('.bariskodeobat').each(function(){
            var val=$(this).val(); 
            if(val=='')val=0;
            if(kd_obat1==val){
               // x=1;
                //alert('obat ini sudah di input'); 
               // return false;
            }
        });
        if(x){
            return false;
        }else{
            $('.focused').find('.bariskodeobat').val(kd_obat1);
            $('.focused').find('.barisnamaobat').val(nama_obat);
            $('.focused').find('.barissatuan').val(satuan_kecil);
			$('.focused').find('.baristanggal').val(tgl_expire);
			
            $('#daftarobat').modal("hide");
            $('.focused').find('input[name="tgl_expire[]"]').focus();
           
        }
		return false;
    }

	$('#tambahbaris').click(function(){
        /*if($('.bariskodeobat').length>0){
			$('.barisnamaobat').each(function(){
                var val=$(this).val(); 
                if(val==''){
                    alert('Nama obat tidak boleh kosong');
                    e.stopImmediatePropagation();
                    return false;
                }
            });
			$('.barisqtyb').each(function(){
                var val=$(this).val(); 
                if(val==''){
                    alert('Qty box tidak boleh kosong');
                    e.stopImmediatePropagation();
                    return false;
                }
            });
			
        }*/

		$('#bodyinput').append('<tr style="font-size:95% !important;"><td><input type="checkbox" class="barisinput cleared" /></td>'+
								'<td style="text-align:left;"><input type="text" name="kd_obat[]" value="" class="input-medium bariskodeobat cleared" ></td>'+
								'<td style="text-align:left;"><input type="text" name="nama_obat[]" value="" class="input-xxlarge barisnamaobat cleared" ></td>'+
								'<td style="text-align:left;"><input style="text-align:center;" type="text" name="satuan_kecil[]" value="" class="input-medium barissatuan cleared" readonly ></td>'+
								'<td style="text-align:left;"><input style="text-align:center;" type="text" name="tgl_expire[]" value="" class="input-small baristanggal cleared" readonly ></td>'+
								'<td style="text-align:left;"><input style="text-align:right;" type="text" name="jml_req[]" value="" class="input-small barisqty cleared" ></td>'+
								'</tr>');
		
		$("#bodyinput tr:last input[name='kd_obat[]']").focus();
        $('#bodyinput tr').removeClass('focused'); 
        $("#bodyinput tr:last input[name='nama_obat[]']").parent().parent('tr').addClass('focused'); 
		
		$('.barisqty, .bariskodeobat, .barisnamaobat').click(function(){  
                $('#bodyinput tr').removeClass('focused'); 
                $(this).parent().parent('tr').addClass('focused'); 
		})
		
		$('.barisqty').keyup(function(e){  
            if(e.keyCode == 13){ 
                $('#tambahbaris').trigger('click');
                return false;
            }
        });
		
		$('.barisnamaobat').keyup(function(e){
            if(e.keyCode == 13){
                //alert('xx')
                $('.barisnamaobat').parent().parent('tr').removeClass('focused');
                $(this).parent().parent('tr').addClass('focused');

                $("#dataTable4").dataTable().fnDestroy();
                $('#dataTable4').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptpermintaan/ambildaftarobatbynama/",
					"sServerMethod": "POST",
                    "fnServerParams": function ( aoData ) {
                      aoData.push( { "name": "nama_obat", "value":""+$('.focused').find('.barisnamaobat').val()+""} );
                    }
                    
                } );
				$('#dataTable4').css('width','100%');
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
		
		$('.bariskodeobat').keyup(function(e){
            if(e.keyCode == 13){
                //alert('xx')
                $('.bariskodeobat').parent().parent('tr').removeClass('focused');
                $(this).parent().parent('tr').addClass('focused');

                $("#dataTable4").dataTable().fnDestroy();
                $('#dataTable4').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptpermintaan/ambildaftarobatbykode/",
					"sServerMethod": "POST",
                    "fnServerParams": function ( aoData ) {
                      aoData.push( { "name": "kd_obat", "value":""+$('.focused').find('.bariskodeobat').val()+""} );
                    }
                    
                } );
				$('#dataTable4').css('width','100%');
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
	
	$('.barisqty').keyup(function(e){
            if(e.keyCode == 13){
                //alert('xx')
                $('#tambahbaris').trigger('click');
                return false;
            }
    });
	
		$('.barisqty, .bariskodeobat, .barisnamaobat').click(function(){  
                $('#bodyinput tr').removeClass('focused'); 
                $(this).parent().parent('tr').addClass('focused'); 
		})
		
		$('.barishargabeli').change(function(){  
			var val=$(this).val(); //harga beli  
			var qtyk=$('.focused').find('.barisqtyk').val();
			if(val=='')val=0;
			if(qtyk=='')qtyk=0;
			var total=parseFloat(val)*parseFloat(qtyk);
			$('.focused').find('.barisjumlah').val(total);
			totaltransaksi();
		})
	
	$('.bariskodeobat').keydown(function(e){
		if(e.keyCode==13){
			$(this).focus();
			return false;
		}
    });
		
	$('.barisnamaobat').keyup(function(e){
            if(e.keyCode == 13){
                //alert('xx')
                $('.barisnamaobat').parent().parent('tr').removeClass('focused');
                $(this).parent().parent('tr').addClass('focused');

                $("#dataTable4").dataTable().fnDestroy();
                $('#dataTable4').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptpermintaan/ambildaftarobatbynama/",
					"sServerMethod": "POST",
                    "fnServerParams": function ( aoData ) {
                      aoData.push( { "name": "nama_obat", "value":""+$('.focused').find('.barisnamaobat').val()+""} );
                    }
                    
                } );
				$('#dataTable4').css('width','100%');
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
		
		$('.bariskodeobat').keyup(function(e){
            if(e.keyCode == 13){
                //alert('xx')
                $('.bariskodeobat').parent().parent('tr').removeClass('focused');
                $(this).parent().parent('tr').addClass('focused');

                $("#dataTable4").dataTable().fnDestroy();
                $('#dataTable4').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptpermintaan/ambildaftarobatbykode/",
					"sServerMethod": "POST",
                    "fnServerParams": function ( aoData ) {
                      aoData.push( { "name": "kd_obat", "value":""+$('.focused').find('.bariskodeobat').val()+""} );
                    }
                    
                } );
				$('#dataTable4').css('width','100%');
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