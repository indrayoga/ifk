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
	Mousetrap.bindGlobal('ctrl+r', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptpemesanan/tambahpemesananapt'; return false;});
	Mousetrap.bindGlobal('f4', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptpemesanan'; return false;});
	
	Mousetrap.bindGlobal('ctrl+s', function() { 
		$('#simpan').trigger('click');
		return false;
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
	
	Mousetrap.bindGlobal('ctrl+b', function() { 
		$('#tambahbaris').trigger('click');
		return false;
	});
	
	Mousetrap.bindGlobal('ctrl+l', function() { 
		$('#pencarian').modal("show");
		return false;
	});
	
	Mousetrap.bindGlobal('ctrl+d', function() { 
		$.ajax({
			url: '<?php echo base_url() ?>index.php/transapotek/aptpemesanan/ambilsupplierbynama/',
			async:false,
			type:'get',
			data:{query:$("#nama").val()},
			success:function(data){
			//typeahead.process(data)
				$('#listsupplier').empty();
				$.each(data,function(i,l){
					//alert(l);
					$('#listsupplier').append('<tr><td>'+l.kd_supplier+'</td><td>'+l.nama+'</td><td>'+l.alamat+'</td><td><a class="btn" onclick=\'pilihsupplier("'+l.kd_supplier+'","'+l.nama+'")\'>Pilih</a></td></tr>');
				}); 
			},
			dataType:'json'                         
		});
		$('#daftarsupplier').modal("show");
		var ex = document.getElementById('dataTable5');
		if ( ! $.fn.DataTable.fnIsDataTable( ex ) ) {
			$('#dataTable5').dataTable({
				"sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "Show _MENU_ entries"
				}
			});
			var oTable = $('#dataTable5').dataTable();
			$('#nama1').keyup(function(e){
				oTable.fnFilter( $(this).val() );
				if(e.keyCode == 13){
					//alert('xx')
					return false;
				}
			});
		};
		return false;
	});
	
</script>

<script type="text/javascript">

    $(document).ready(function() {
		$('#kd_supplier').focus();
        var totalpemesanan=0;
        $('.barisjumlah').each(function(){
                var val=$(this).val();
                if(val=='')val=0;
                totalpemesanan=totalpemesanan+parseFloat(val);
        });
        $('#jumlahapprove').val(totalpemesanan);
        $('#totalpemesanan').val(totalpemesanan.toFixed(2));

        $('#form').ajaxForm({
            beforeSubmit: function(a,f,o) {
                o.dataType = "json";
                $('div.error').removeClass('error');
                $('span.help-inline').html('');
                $('#progress').show();
                $('body').append('<div id="overlay1" style="position: fixed;height: 100%;width: 100%;z-index: 1000000;"></div>');
                $('body').addClass('body1');
                var urlnya="<?php echo base_url(); ?>index.php/transapotek/aptpemesanan/periksapemesanan"; //buat validasi inputan
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
                    $('#no_pemesanan').val(data.no_pemesanan);
                    $('#btn-cetak').removeAttr('disabled');
                    $('#btn-cetak').attr('href','<?php echo base_url() ?>third-party/fpdf/buktipemesanan.php?no_pemesanan='+data.no_pemesanan+'');
                    //$('#btn-tutuptrans').removeAttr('disabled');
                    if(parseInt(data.keluar)>0){
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptpemesanan';
                    }
					if(parseInt(data.posting)==3){
						 window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptpemesanan/ubahpemesanan/'+data.no_pemesanan;
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
						<form class="form-horizontal"  id="form" method="POST" action="<?php echo base_url() ?>index.php/transapotek/aptpemesanan/simpanpemesanan">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header class="top" style="">
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>PEMESANAN OBAT / ALKES</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/aptpemesanan/"> <i class="icon-list"></i> Daftar / (F4)</a></li>
													<li><a target="_blank" class="btn" id="btn-cetak" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php if(!empty($no_pemesanan)){ echo base_url() ?>third-party/fpdf/buktipemesanan.php?no_pemesanan=<?php echo $no_pemesanan;} else echo '#'; ?>" <?php if(empty($no_pemesanan)){ ?>disabled<?php } ?>> <i class="icon-print"></i> Cetak</a></li>													                                                    
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/aptpemesanan/tambahpemesananapt"> <i class="icon-plus"></i> Tambah / (Ctrl+R)</a></li>
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" data-toggle="modal" data-original-title="Pencarian" data-placement="bottom" rel="tooltip" href="#pencarian"> <i class="icon-search"></i> Pencarian / (Ctrl+L)</a></li>
                                                    <li><button class="btn" id="simpan" type="submit"  name="submit" value="simpan"> <i class="icon-save"></i> Simpan / (Ctrl+S)</button></li>
                                                    <!--li><button class="btn" type="submit" name="submit" value="simpankeluar"> <i class="icon-save icon-share-alt"></i> Simpan &amp; Keluar</button></li-->
                                                    <!--
                                                    <li><a class="btn" id="btn-bayar" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" data-toggle="modal" data-original-title="Pencarian" data-placement="bottom" rel="tooltip" href="<-?php if(!empty($no_pemesanan) && $this->mpemesananapt->isPosted($no_pemesanan)){ ?>#bayartransaksi<-?php } ?>" <-?php if(empty($no_pemesanan) || !$this->mpemesananapt->isPosted($no_pemesanan)){ ?>disabled<-?php } ?>> <i class="icon-money"></i> Bayar.</a></li>
                                                    -->                                                    
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
															<label for="no_pemesanan" class="control-label">No. Pemesanan </label>
															<div class="controls with-tooltip">
																<input type="text" name="no_pemesanan" id="no_pemesanan" value="<?php echo $no_pemesanan; ?>" readonly class="span6 input-tooltip" data-original-title="no pemesanan" data-placement="bottom"/>
																<span class="help-inline"></span>
																<input type="hidden" name="jam_pemesanan" id="jam_pemesanan" value="<?php echo date('h:i:s'); ?>" data-mask="99:99:99" class="input-small"/>
																<input type="hidden" id="jam_pemesanan1" name="jam_pemesanan1" value="<?php if(isset($itemtransaksi['jam_pemesanan']))echo $itemtransaksi['jam_pemesanan'] ?>" class="input-small" data-original-title="jam pemesanan" data-placement="bottom"/>
																<input type="hidden" id="kd_applogin" name="kd_applogin" value="<?php if(isset($applogin['kd_app']))echo $applogin['kd_app'] ?>" class="span3 input-tooltip" data-original-title="kd_applogin" data-placement="bottom"/>
															</div>
														</div>
													</div>
													<div class="span7">
														<div class="control-group">
															<label for="kd_supplier" class="control-label">Distributor </label>
															<div class="controls with-tooltip">
																<input type="text" id="kd_supplier" name="kd_supplier" value="<?php if(isset($itemtransaksi['kd_supplier']))echo $itemtransaksi['kd_supplier'] ?>" class="span2 input-tooltip" data-original-title="kd distributor" data-placement="bottom"/>																
																<input type="text" id="nama" name="nama" value="<?php if(isset($itemtransaksi['nama']))echo $itemtransaksi['nama'] ?>" class="span9 input-tooltip" data-original-title="nama distributor" data-placement="bottom"/>																																
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
															<label for="tgl_pemesanan" class="control-label">Tgl. Pemesanan </label>
															<div class="controls with-tooltip">
																<input type="text" name="tgl_pemesanan" id="tgl_pemesanan" class="input-small input-tooltip cleared" data-original-title="tgl pemesanan" data-mask="99-99-9999" value="<?php if(empty($itemtransaksi['tgl_pemesanan']))echo date('d-m-Y'); else echo convertDate($itemtransaksi['tgl_pemesanan']);  ?>" data-placement="bottom"/>
																<span class="help-inline"></span>
																Tgl. Jatuh Tempo
																<input type="text" name="tgl_tempo" id="tgl_tempo" class="input-small input-tooltip cleared" data-original-title="tgl tempo" data-mask="99-99-9999" value="<?php if(empty($itemtransaksi['tgl_tempo']))echo date('d-m-Y'); else echo convertDate($itemtransaksi['tgl_tempo']);  ?>" data-placement="bottom"/>
															</div>
														</div>
													</div>
													<div class="span7">
														<div class="control-group">
															<label for="keterangan" class="control-label">Keterangan </label>
															<div class="controls with-tooltip">
																<input type="text" id="keterangan" name="keterangan" value="<?php if(isset($itemtransaksi['keterangan']))echo $itemtransaksi['keterangan'] ?>" class="span11 input-tooltip cleared" data-original-title="keterangan" data-placement="bottom"/>
																<span class="help-inline"></span>																
															</div>
														</div>
													</div>
												</div>
												<div id="progress" style="display:none;"></div>
											</div>
											<!--div class="row-fluid">
												<div class="span12">
													<div class="span4">
														<div class="control-group">
															<label for="tgl_tempo" class="control-label">Tgl. Jatuh Tempo </label>
															<div class="controls with-tooltip">
																<input type="text" name="tgl_tempo" id="tgl_tempo" class="input-small input-tooltip cleared" data-original-title="tgl tempo" data-mask="99-99-9999" value="<-?php if(empty($itemtransaksi['tgl_tempo']))echo date('d-m-Y'); else echo convertDate($itemtransaksi['tgl_tempo']);  ?>" data-placement="bottom"/>
																<span class="help-inline"></span>																
															</div>
														</div>
													</div>													
												</div>												 
											</div-->																						 																						
                                        </div>
                                    </div>
									
									<div class="row-fluid">
										<div class="span12">
											<div class="box error">
												<header>
												<!-- .toolbar -->
													<div class="toolbar" style="height:auto;float:left;">
														<ul class="nav nav-tabs">
															<li><button class="btn" type="button" id="tambahbaris"> <i class="icon-plus"></i> Tambah Obat (Ctrl+B)</button></li>
															<li><button class="btn" type="button" id="hapusbaris"> <i class="icon-remove"></i> Hapus Obat</button></li>
														</ul>
													</div>
												<!-- /.toolbar -->
												</header>
												<div class="body collapse in" id="defaultTable">
													<table class="table responsive">
														<thead>
															<tr style="font-size:80% !important;">
																<th class="header">&nbsp;</th>
																<th class="header">Kode Obat</th>
																<th class="header">Nama Obat</th>
																<th class="header">Satuan</th>
																<!--th class="header" style="width:50px;padding:0 !important;text-align:center;">Tgl.Exp.</th-->
																<th class="header">Qty</th>																
																<!--th class="header">Qty Kcl</th-->
																<th class="header">Harga Beli</th>
																<th class="header">Disc.%</th>
																<th class="header">PPN %</th>
																<th class="header">Jumlah </th>
															</tr>
														</thead>
														<tbody id="bodyinput">
															<?php
																if(isset($itemsdetiltransaksi)){
																	//$no=1;
																	foreach ($itemsdetiltransaksi as $itemdetil){																			
																	?>
																		<tr style="font-size:80% !important;">
																			<td><input type="checkbox" class="barisinput" /></td>
																			<td><input type="text" name="kd_obat[]" value="<?php echo $itemdetil['kd_obat'] ?>" style="width:150px;" class="input-small bariskodeobat cleared"></td>
																			<td><input type="text" name="nama_obat[]" value="<?php echo $itemdetil['nama_obat'] ?>" style="width:450px;font-size:90% !important;" class="input-xlarge barisnamaobat cleared"></td>
																			<td><input type="text" name="satuan_kecil[]" value="<?php echo $itemdetil['satuan_kecil'] ?>" style="width:100px;" class="input-medium barissatuan cleared" readonly></td>
																			<!--td><input <-?php if($this->mpemesananapt->isPosted($no_pemesanan))echo "readonly"; ?> type="text" name="tgl_expire[]" value="<-?php echo $itemdetil['tgl_expire'] ?>" class="input-small baristanggal cleared"></td-->
																			<input type="hidden" name="pembanding[]" value="<?php echo $itemdetil['pembanding'] ?>" class="input-small barispembanding cleared">
																			<td><input style="text-align:right;" type="text" name="qty_box[]" value="<?php echo $itemdetil['qty_box'] ?>" style="width:70px;font-size:90% !important;" class="input-small barisqtyb cleared"></td>
																			<input type="hidden" name="qty_kcl[]" value="<?php echo $itemdetil['qty_kcl'] ?>" style="width:70px;" class="input-small barisqtyk cleared" readonly>
																			<td><input style="text-align:right;" type="text" name="harga_beli[]" value="<?php echo number_format($itemdetil['harga_beli'],2,'.','') ?>" style="width:80px;font-size:90% !important" class="input-small barishargabeli cleared"></td>																			
																			<td><input style="text-align:right;" type="text" name="diskon[]" value="<?php echo $itemdetil['diskon'] ?>" style="width:30px;font-size:90% !important;" class="input-mini barisdiskon cleared"></td>																			
																			<td><input style="text-align:right;" type="text" name="ppn[]" value="<?php echo $itemdetil['ppn'] ?>" style="width:30px;font-size:90% !important;" class="input-mini barisppn cleared"></td>
																			<td style="text-align:right;"><input style="text-align:right;" type="text" name="jumlah[]" style="width:100px;font-size:90% !important;" value="<?php echo number_format($itemdetil['jumlah'],2,'.','') ?>" class="input-medium barisjumlah cleared" readonly></td>																			
																		</tr>
																	<?php
																		//$no++;
																	}
																}
															?>

														</tbody>
														<tfoot>
															<tr>
																<th colspan="14" style="text-align:right;" class="header">Total Pemesanan (Rp) : <input type="text" class="input-medium cleared" id="totalpemesanan" style="text-align:right" disabled></th>
															</tr>
														</tfoot>
													</table>
												</div>
											</div>
										</div>
									</div>
									
									<!--div class="row-fluid">
											<div class="box error">
												<header>
													<div class="toolbar" style="height:auto;float:left;">
														<ul class="nav nav-tabs">
															<li><button <-?php if($this->mpemesananapt->cek($no_pemesanan)) {echo "enabled";} else {echo "disabled";}?> class="btn" id="approve" type="submit" name="submit" value="approve"> <i class="icon-ok"></i> Approve</button></li>
														</ul>
													</div>
												</header>
												<div class="body collapse in" id="defaultTable1">
													<table class="table responsive">
														<thead>
															<tr>
																<th class="header">&nbsp;</th>
																<th>No</th>
																<th>Nama</th>
																<th class="span9">Approve</th>
															</tr>
														</thead>
														<tbody>
															<-?php
																if(isset($itemapprove)){
																	$no=1; $status="";
																	foreach ($itemapprove as $item1){
																		if($item1['is_app']){
																			$status="Sudah Approve";
																		}
																		else{
																			$status="Belum Approve";
																		}
																	?>
																		<tr>
																			<td style="text-align:center;"><input type="hidden" class="bariscekbok" /></td>
																			<input type="hidden" name="kd_app[]" value="<-?php echo $item1['kd_app'] ?>" class="input-small bariskode cleared" readonly>
																			<td style="padding:0 !important;"><input style="text-align:center;" type="text" name="no[]" value="<-?php echo $no; ?>" class="input-mini barisno cleared" readonly></td>
																			<td style="padding:0 !important;"><input type="text" name="nama_pegawai[]" value="<-?php echo $item1['nama_pegawai'] ?>" class="input-xxlarge barisnama cleared" readonly></td>
																			<td style="padding:0 !important;"><input style="text-align:center;" type="text" name="status[]" value="<-?php echo $status; ?>" class="input-large barisstatus cleared" readonly></td>
																			<input type="hidden" name="urut[]" value="<-?php echo $item1['urut'] ?>" class="input-small barisurut cleared" readonly>
																			<input type="hidden" name="is_app[]" value="<-?php echo $item1['is_app'] ?>" class="input-small barisapp cleared" readonly>
																		</tr>																		
																	<-?php
																		$no++;
																	}
																}
															?>
														</tbody>
														<tfoot>
														</tfoot>
													</table>
												</div>
											</div>
										</div-->
									
									<div aria-hidden="true" aria-labelledby="approveModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="pencarian" style="display: none;width:77%;left:34% !important;">
										<div class="modal-header">
											<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
											<h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Pemesanan</h3>
										</div>
										<div class="modal-body" style="">
											<div class="body" id="collapse4">
												<table id="dataTable1" class="table table-bordered table-condensed table-hover table-striped">
													<thead>
														<tr>
															<th>No Pemesanan</th>
															<th>Tgl Pesan</th>
															<th>Distributor</th>
															<th>Keterangan</th>															
															<th>Tgl Tempo</th>
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
																	<td><?php echo $item['no_pemesanan'] ?></td>
																	<td><?php echo $item['tgl_pemesanan'] ?></td>
																	<td><?php echo $item['nama'] ?></td>
																	<td><?php echo $item['keterangan'] ?></td>
																	<td><?php echo convertDate($item['tgl_tempo']) ?></td>																	
															<!--
															<td style="text-align:center;"></td>
															-->	
																	<td>
																		<a href="<?php echo base_url() ?>index.php/transapotek/aptpemesanan/ubahpemesanan/<?php echo $item['no_pemesanan'] ?>" class="btn"><i class="icon-edit"></i> PILIH</a>
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
        <input type="text" id="nama_obat" class="pull-left" autocomplete="off">
        <button aria-hidden="true" data-dismiss="modal" class="btn">Close</button>
    </div>
</div>
			
<script type="text/javascript">
    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });
	
	$('#tgl_pemesanan').datepicker({
        format: 'dd-mm-yyyy'
    });
	
	$('#tgl_tempo').datepicker({
        format: 'dd-mm-yyyy'
    });
	
	$('#jam_pemesanan').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
    });
	
	function pilihsupplier(kd_supplier,nama) {
		$('#kd_supplier').val(kd_supplier);
        $('#nama').val(nama);
		//$('#alamat').val(alamat);
        //$('.focused').find('#alamat').val(alamat);
        $('#daftarsupplier').modal("hide");
        $('#keterangan').focus();
    }

    function totaltransaksi(){
        var totalpemesanan=0; var total1=0;
        $('.barisjumlah').each(function(){
            var val=$(this).val(); 
            if(val=='')val=0;
            totalpemesanan=totalpemesanan+parseFloat(val);             
        });
       $('#jumlahapprove').val(totalpemesanan);
       $('#totalpemesanan').val(totalpemesanan.toFixed(2));
    }
    
	//function pilihobat(kd_obat,nama_obat,satuan_kecil,pembanding,harga_beli) {
	//function pilihobat(kd_obat1,nama_obat,satuan_kecil,pembanding,max_stok,harga_beli) {
	function pilihobat(kd_obat1,nama_obat,satuan_kecil,pembanding,max_stok,harga_dasar) {
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
            //$('.focused').find('.baristanggal').val(tgl);
            //$('.focused').find('.barisqtyb').val(1);
			//$('.focused').find('.barisqtyb').val(1);			
			$('.focused').find('.barisqtyb').val(max_stok);
            $('.focused').find('.barisqtyk').val(max_stok*pembanding);
            $('.focused').find('.barispembanding').val(pembanding);			
            //$('.focused').find('.barishargabeli').val(harga_beli);
			$('.focused').find('.barishargabeli').val(parseFloat(harga_dasar).toFixed(2));
			$('.focused').find('.barisdiskon').val(0);
			$('.focused').find('.barisppn').val(10);
            
           // jumlahharga();
		   $('.barishargabeli').trigger('change');
			totaltransaksi();
            $('#daftarobat').modal("hide");
            $('.focused').find('input[name="qty_box[]"]').focus();
           
        }
		return false;
    }

	$('#tambahbaris').click(function(){
        if($('.bariskodeobat').length>0){
            $('.baristanggal').each(function(){
                var val=$(this).val(); 
                if(val==''){
                    alert('tanggal expire tidak boleh kosong');
                    e.stopImmediatePropagation();
                    return false;
                }
            });
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
			$('.barishargabeli').each(function(){
                var val=$(this).val(); 
                if(val==''){
                    alert('Harga beli tidak boleh kosong');
                    e.stopImmediatePropagation();
                    return false;
                }
            });
        }


		$('#bodyinput').append('<tr style="font-size:80% !important;"><td><input type="checkbox" class="barisinput cleared" /></td>'+
									'<td><input type="text" name="kd_obat[]" value="" style="width:150px;" class="input-small bariskodeobat cleared"></td>'+
									'<td><input type="text" name="nama_obat[]" value="" style="width:450px;font-size:90% !important;" class="input-xlarge barisnamaobat cleared"></td>'+
                                    '<td><input type="text" name="satuan_kecil[]" value="" style="width:100px;" class="input-medium barissatuan cleared" readonly></td>'+
									//'<td><input type="text" name="tgl_expire[]" style="width:80px !important;font-size:90% !important;" data-mask="99-99-9999" value="" class="input-small baristanggal cleared"></td>'+
									'<input type="hidden" name="pembanding[]" value="" class="input-small barispembanding cleared">'+
									'<td><input style="text-align:right;" type="text" name="qty_box[]" value="" style="width:70px;font-size:90% !important;" class="input-small barisqtyb cleared"></td>'+
									'<input type="hidden" name="qty_kcl[]" value="" style="width:70px;font-size:90% !important;" class="input-small barisqtyk cleared" readonly>'+
									'<td><input style="text-align:right;" type="text" name="harga_beli[]" value="" style="width:80px;font-size:90% !important" class="input-small barishargabeli cleared"></td>'+
									'<td><input style="text-align:right;" type="text" name="diskon[]" value="" style="width:30px;font-size:90% !important;" class="input-mini barisdiskon cleared"></td>'+
									'<td><input style="text-align:right;" type="text" name="ppn[]" value="" style="width:30px;font-size:90% !important;" class="input-mini barisppn cleared"></td>'+
									'<td style="text-align:right;"><input style="text-align:right;" style="width:100px;font-size:90% !important;" type="text" name="jumlah[]" value="" class="input-medium barisjumlah cleared" readonly></td>'+
                                '</tr>');
		
		$("#bodyinput tr:last input[name='kd_obat[]']").focus();
        $('#bodyinput tr').removeClass('focused'); 
        $("#bodyinput tr:last input[name='nama_obat[]']").parent().parent('tr').addClass('focused'); 
		
		$('.barisjumlah').change(function(){ 
            var totalpemesanan=0; 
			$('.barisjumlah').each(function(){
                var val=$(this).val();
                if(val=='')val=0;
                totalpemesanan=totalpemesanan+parseFloat(val);				
            });
           $('#jumlahapprove').val(totalpemesanan);
           $('#totalpemesanan').val(totalpemesanan.toFixed(2));		   
        });
		
		$('.barisqtyb').change(function(){ 
            var val=$(this).val();  //ngambil qty b            
            var pembanding=$('.focused').find('.barispembanding').val();
            var qtyk=parseFloat(val) * parseFloat(pembanding); //ngupdate qty k
			
			var disc=$('.focused').find('.barisdiskon').val();
			var hargabeli=$('.focused').find('.barishargabeli').val();
			var ppn=$('.focused').find('.barisppn').val();
			if(val=='')val=0;
			if(disc=='')disc=0;
			if(hargabeli=='')hargabeli=0;
			if(ppn=='')ppn=0;
			var hargabelidisc=((parseFloat(disc)/100)*parseFloat(hargabeli)*parseFloat(qtyk));
			var subtotal1=(parseFloat(qtyk)*parseFloat(hargabeli))-hargabelidisc;
			var subtotal2=parseFloat(subtotal1)+(parseFloat(subtotal1)*(parseFloat(ppn)/100));
			
			$('.focused').find('.barisjumlah').val(subtotal2.toFixed(2));			
            $('.focused').find('.barisqtyk').val(qtyk);
            //jumlahharga();
			totaltransaksi();
            $('.focused').find('input[name="harga_beli[]"]').focus();
        });
		
		$('.barisqtyb, .barishargabeli, .barisnamaobat, .baristanggal, .barisdiskon, .barisppn').click(function(){  
                $('#bodyinput tr').removeClass('focused'); 
                $(this).parent().parent('tr').addClass('focused'); 
		})
		
		$('.barishargabeli').change(function(){  
			var val=$(this).val(); //harga beli  
			var disc=$('.focused').find('.barisdiskon').val();
			var qtyk=$('.focused').find('.barisqtyk').val();
			var ppn=$('.focused').find('.barisppn').val();
			if(val=='')val=0;
			if(disc=='')disc=0;
			if(qtyk=='')qtyk=0;
			if(ppn=='')ppn=0;
			var hargabelidisc=((parseFloat(disc)/100)*parseFloat(val)*parseFloat(qtyk));
			var subtotal1=(parseFloat(qtyk)*parseFloat(val))-hargabelidisc;
			var subtotal2=parseFloat(subtotal1)+(parseFloat(subtotal1)*(parseFloat(ppn)/100));
			$('.focused').find('.barisjumlah').val(subtotal2.toFixed(2));
			totaltransaksi();
		})
		
		$('.barisdiskon').change(function(){  
			var val=$(this).val(); //diskon 
			var hargabeli=$('.focused').find('.barishargabeli').val();
			var qtyk=$('.focused').find('.barisqtyk').val();
			var ppn=$('.focused').find('.barisppn').val();
			if(val=='')val=0;
			if(hargabeli=='')hargabeli=0;
			if(qtyk=='')qtyk=0;
			if(ppn=='')ppn=0;
			var hargabelidisc=((parseFloat(val)/100)*parseFloat(hargabeli)*parseFloat(qtyk));
			var subtotal1=(parseFloat(qtyk)*parseFloat(hargabeli))-hargabelidisc;
			var subtotal2=parseFloat(subtotal1)+(parseFloat(subtotal1)*(parseFloat(ppn)/100));
			$('.focused').find('.barisjumlah').val(subtotal2.toFixed(2));
			totaltransaksi();
		})
		
		$('.barisppn').change(function(){  
			var val=$(this).val(); //ppn 
			var hargabeli=$('.focused').find('.barishargabeli').val();
			var qtyk=$('.focused').find('.barisqtyk').val();
			var disc=$('.focused').find('.barisdiskon').val();
			if(val=='')val=0;
			if(hargabeli=='')hargabeli=0;
			if(qtyk=='')qtyk=0;
			if(disc=='')disc=0;
			var hargabelidisc=((parseFloat(disc)/100)*parseFloat(hargabeli)*parseFloat(qtyk));
			var subtotal1=(parseFloat(qtyk)*parseFloat(hargabeli))-hargabelidisc;
			var subtotal2=parseFloat(subtotal1)+(parseFloat(subtotal1)*(parseFloat(val)/100));
			$('.focused').find('.barisjumlah').val(subtotal2.toFixed(2));
			totaltransaksi();
		})
		
		$('.barisjumlah').keyup(function(e){  
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
                    "sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptpemesanan/ambildaftarobatbynama/",
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
                    "sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptpemesanan/ambildaftarobatbykode/",
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
            var totalpemesanan=0; var total1=0;
			
           $('.barisjumlah').each(function(){
                var val=$(this).val();
                if(val=='')val=0;
                totalpemesanan=totalpemesanan+parseFloat(val);				
            });
           $('#jumlahapprove').val(totalpemesanan);
           $('#totalpemesanan').val(totalpemesanan.toFixed(2));		   
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
	
	$('.barisjumlah').keyup(function(e){
            if(e.keyCode == 13){
                //alert('xx')
                $('#tambahbaris').trigger('click');
                return false;
            }
    });
	
		$('.barisjumlah').change(function(){ 
            var totalpemesanan=0; 
			$('.barisjumlah').each(function(){
                var val=$(this).val();
                if(val=='')val=0;
                totalpemesanan=totalpemesanan+parseFloat(val);				
            });
           $('#jumlahapprove').val(totalpemesanan);
           $('#totalpemesanan').val(totalpemesanan.toFixed(2));
        });
		
		$('.barisqtyb').change(function(){ 
            var val=$(this).val();  //ngambil qty b            
            var pembanding=$('.focused').find('.barispembanding').val();
            var qtyk=parseFloat(val) * parseFloat(pembanding); //ngupdate qty k
			
			var disc=$('.focused').find('.barisdiskon').val();
			var hargabeli=$('.focused').find('.barishargabeli').val();
			var ppn=$('.focused').find('.barisppn').val();
			if(val=='')val=0;
			if(disc=='')disc=0;
			if(hargabeli=='')hargabeli=0;
			if(ppn=='')ppn=0;
			var hargabelidisc=((parseFloat(disc)/100)*parseFloat(hargabeli)*parseFloat(qtyk));
			var subtotal1=(parseFloat(qtyk)*parseFloat(hargabeli))-hargabelidisc;
			var subtotal2=parseFloat(subtotal1)+(parseFloat(subtotal1)*(parseFloat(ppn)/100));
			
			$('.focused').find('.barisjumlah').val(subtotal2.toFixed(2));			
            $('.focused').find('.barisqtyk').val(qtyk);
            //jumlahharga();
			totaltransaksi();
            $('.focused').find('input[name="harga_beli[]"]').focus();
        });
		
		$('.barisqtyb, .barishargabeli, .barisnamaobat, .baristanggal, .barisdiskon, .barisppn').click(function(){  
                $('#bodyinput tr').removeClass('focused'); 
                $(this).parent().parent('tr').addClass('focused'); 
		})
		
	$('.barishargabeli').change(function(){ 
		var val=$(this).val(); //harga beli  
		var disc=$('.focused').find('.barisdiskon').val();
		var qtyk=$('.focused').find('.barisqtyk').val();
		var ppn=$('.focused').find('.barisppn').val();
		if(val=='')val=0;
		if(disc=='')disc=0;
		if(qtyk=='')qtyk=0;
		if(ppn=='')ppn=0;
		var hargabelidisc=((parseFloat(disc)/100)*parseFloat(val)*parseFloat(qtyk));
		var subtotal1=(parseFloat(qtyk)*parseFloat(val))-hargabelidisc;
		var subtotal2=parseFloat(subtotal1)+(parseFloat(subtotal1)*(parseFloat(ppn)/100));
		$('.focused').find('.barisjumlah').val(subtotal2.toFixed(2));
		totaltransaksi();
	})
	
	$('.barisdiskon').change(function(){  
		var val=$(this).val(); //diskon 
		var hargabeli=$('.focused').find('.barishargabeli').val();
		var qtyk=$('.focused').find('.barisqtyk').val();
		var ppn=$('.focused').find('.barisppn').val();
		if(val=='')val=0;
		if(hargabeli=='')hargabeli=0;
		if(qtyk=='')qtyk=0;
		if(ppn=='')ppn=0;
		var hargabelidisc=((parseFloat(val)/100)*parseFloat(hargabeli)*parseFloat(qtyk));
		var subtotal1=(parseFloat(qtyk)*parseFloat(hargabeli))-hargabelidisc;
		var subtotal2=parseFloat(subtotal1)+(parseFloat(subtotal1)*(parseFloat(ppn)/100));
		$('.focused').find('.barisjumlah').val(subtotal2.toFixed(2));
		totaltransaksi();
	})
	
	$('.barisppn').change(function(){  
		var val=$(this).val(); //ppn 
		var hargabeli=$('.focused').find('.barishargabeli').val();
		var qtyk=$('.focused').find('.barisqtyk').val();
		var disc=$('.focused').find('.barisdiskon').val();
		if(val=='')val=0;
		if(hargabeli=='')hargabeli=0;
		if(qtyk=='')qtyk=0;
		if(disc=='')disc=0;
		var hargabelidisc=((parseFloat(disc)/100)*parseFloat(hargabeli)*parseFloat(qtyk));
		var subtotal1=(parseFloat(qtyk)*parseFloat(hargabeli))-hargabelidisc;
		var subtotal2=parseFloat(subtotal1)+(parseFloat(subtotal1)*(parseFloat(val)/100));
		$('.focused').find('.barisjumlah').val(subtotal2.toFixed(2));
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
                    "sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptpemesanan/ambildaftarobatbynama/",
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
                    "sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptpemesanan/ambildaftarobatbykode/",
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
		
	$('#kd_supplier').keyup(function(e){
		if(e.keyCode == 13){
            $.ajax({
                url: '<?php echo base_url() ?>index.php/transapotek/aptpemesanan/ambilsupplierbykode/',
                async:false,
                type:'get',
                data:{query:$(this).val()},
                success:function(data){
                //typeahead.process(data)
					$('#listsupplier').empty();
					$.each(data,function(i,l){
						//alert(l);
						$('#listsupplier').append('<tr><td>'+l.kd_supplier+'</td><td>'+l.nama+'</td><td>'+l.alamat+'</td><td><a class="btn" onclick=\'pilihsupplier("'+l.kd_supplier+'","'+l.nama+'")\'>Pilih</a></td></tr>');
					});    
                },
                dataType:'json'                         
            }); 
            $('#daftarsupplier').modal("show");
		}
		var ex = document.getElementById('dataTable5');
        if ( ! $.fn.DataTable.fnIsDataTable( ex ) ) {
            $('#dataTable5').dataTable({
                "sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
				"sPaginationType": "bootstrap",
                "oLanguage": {
					"sLengthMenu": "Show _MENU_ entries"
                }
            });
            var oTable = $('#dataTable5').dataTable();
            $('#nama1').keyup(function(e){
				oTable.fnFilter( $(this).val() );
                if(e.keyCode == 13){
                    //alert('xx')
                    return false;
                }
            });
        }
	});
	
	$('#nama').keyup(function(e){
		if(e.keyCode == 13){

            $.ajax({
                url: '<?php echo base_url() ?>index.php/transapotek/aptpemesanan/ambilsupplierbynama/',
                async:false,
                type:'get',
                data:{query:$(this).val()},
                success:function(data){
                //typeahead.process(data)
					$('#listsupplier').empty();
					$.each(data,function(i,l){
						//alert(l);
						$('#listsupplier').append('<tr><td>'+l.kd_supplier+'</td><td>'+l.nama+'</td><td>'+l.alamat+'</td><td><a class="btn" onclick=\'pilihsupplier("'+l.kd_supplier+'","'+l.nama+'")\'>Pilih</a></td></tr>');
					});    
                },
                dataType:'json'                         
            }); 
            $('#daftarsupplier').modal("show");
		}
		var ex = document.getElementById('dataTable5');
        if ( ! $.fn.DataTable.fnIsDataTable( ex ) ) {
            $('#dataTable5').dataTable({
                "sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
				"sPaginationType": "bootstrap",
                "oLanguage": {
					"sLengthMenu": "Show _MENU_ entries"
                }
            });
            var oTable = $('#dataTable5').dataTable();
            $('#nama1').keyup(function(e){
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