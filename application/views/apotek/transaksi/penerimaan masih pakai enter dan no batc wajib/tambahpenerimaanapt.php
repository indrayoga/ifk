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
	Mousetrap.bindGlobal('ctrl+r', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/tambahpenerimaanapt'; return false;});
	Mousetrap.bindGlobal('f7', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptpenerimaan'; return false;});
	
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
			url: '<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/ambilsupplierbynama/',
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
	
	Mousetrap.bindGlobal('ctrl+p', function() { 
		$.ajax({
			url: '<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/ambilpemesananbykode/',
			async:false,
			type:'get',
			data:{query:$("#isipesan").val(),tes:$('#kd_supplier').val()},
			success:function(data){
			//typeahead.process(data)
				$('#listpesan').empty();
				$.each(data,function(i,l){
					//alert(l);
					$('#listpesan').append('<tr><td><input type="checkbox" class="ceklis" name="ceklis" value="'+l.no_pemesanan+'"/></td><td style="text-align:center;">'+l.no_pemesanan+'</td><td style="text-align:center;">'+l.tgl_pemesanan+'</td><td>'+l.nama+'</td></tr>');
				}); 
			},
			dataType:'json'                         
		});
		$('#daftarpesan').modal("show");
		var ex = document.getElementById('dataTable3');
		if ( ! $.fn.DataTable.fnIsDataTable( ex ) ) {
			$('#dataTable3').dataTable({
				"sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "Show _MENU_ entries"
				}
			});
			var oTable = $('#dataTable3').dataTable();
			$('#isipesan1').keyup(function(e){
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
		$('#no_faktur').focus();
		
        var totalpenerimaan=0; var total1=0; var grandtotal=0; 
		var discount1=$('#discount1').val();
		if(discount1=='')discount1=0;
		$('#discount').val(discount1);
		//alert('abis lewatin discount');
		
		var materai=$('#materai').val();
		var discount=$('#discount').val();
		if(discount=='')discount=0;
		if(materai=='')materai=0;
        $('.barisjumlah').each(function(){
                var val=$(this).val();
                if(val=='')val=0;
                totalpenerimaan=totalpenerimaan+parseFloat(val); 
				total1=(parseFloat(materai)+parseFloat(totalpenerimaan))-parseFloat(discount);
        });
        $('#totalpenerimaan').val(totalpenerimaan.toFixed(2));
		$('#jumlah').val(total1);		
		grandtotal=parseFloat(totalpenerimaan)-parseFloat(discount);
		$('#grandtotal').val(grandtotal.toFixed(2));
	
        $('#form').ajaxForm({
            beforeSubmit: function(a,f,o) {
                o.dataType = "json";
                $('div.error').removeClass('error');
                $('span.help-inline').html('');
                $('#progress').show();
                $('body').append('<div id="overlay1" style="position: fixed;height: 100%;width: 100%;z-index: 1000000;"></div>');
                $('body').addClass('body1');
                var urlnya="<?php echo base_url(); ?>index.php/transapotek/aptpenerimaan/periksapenerimaan"; //buat validasi inputan
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
                    $('#no_penerimaan').val(data.no_penerimaan);
                    $('#btn-cetak').removeAttr('disabled');
                    $('#btn-cetak').attr('href','<?php echo base_url() ?>third-party/fpdf/buktipenerimaan.php?no_penerimaan='+data.no_penerimaan+'');
                    $('#btn-tutuptrans').removeAttr('disabled');
                    if(parseInt(data.keluar)>0){
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptpenerimaan';
                    }

                    if(parseInt(data.posting)==1){
                        $('#btn-tutuptrans').attr('value','bukatrans');
                        $('#btn-tutuptrans').text('Buka Trans');
                        //$('#btn-bayar').removeAttr('disabled');
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptpenerimaan/ubahpenerimaan/'+data.no_penerimaan;
                    }
                    if(parseInt(data.posting)==2){
                        //$('#btn-bayar').attr('disabled');                        
                        $('#btn-tutuptrans').attr('value','tutuptrans');
                        $('#btn-tutuptrans').text('Tutup Trans');
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptpenerimaan/ubahpenerimaan/'+data.no_penerimaan;
                    }
					/*if(parseInt(data.posting)==3){
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptpenerimaan/ubahpenerimaan/'+data.no_penerimaan;
                    }*/
					
					if(parseInt(data.posting)==3){
                        $('#btn-approve').attr('value','unapprove');
                        $('#btn-approve').text('Batal Approve');
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptpenerimaan/ubahpenerimaan/'+data.no_penerimaan;
                    }
                    if(parseInt(data.posting)==4){
                        //$('#btn-bayar').attr('disabled');                        
                        $('#btn-approve').attr('value','approve');
                        $('#btn-approve').text('Approve');
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptpenerimaan/ubahpenerimaan/'+data.no_penerimaan;
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
						<form class="form-horizontal"  id="form" method="POST" action="<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/simpanpenerimaan">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header class="top" style="">
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>PENERIMAAN OBAT / ALKES</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/"> <i class="icon-list"></i> Daftar / (F7)</a></li>
													<li><a target="_blank" class="btn" id="btn-cetak" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php if(!empty($no_penerimaan)){ echo base_url() ?>third-party/fpdf/buktipenerimaan.php?no_penerimaan=<?php echo $no_penerimaan;} else echo '#'; ?>" <?php if(empty($no_penerimaan)){ ?>disabled<?php } ?>> <i class="icon-print"></i> Cetak</a></li>                                                    
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/tambahpenerimaanapt"> <i class="icon-plus"></i> Tambah / (Ctrl+R)</a></li>
                                                   
                                                    <li><button <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "disabled"; ?> class="btn" id="simpan" type="submit"  name="submit" value="simpan"> <i class="icon-save"></i> Simpan / (Ctrl+S)</button></li>
                                                   
													
													<?php if(empty($no_penerimaan)) { ?>
															<li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="tutuptrans" disabled> <i class="icon-key"></i> Tutup Trans.</button></li>
															<li><button class="btn" type="submit"  name="submit" value="approval" disabled> <i class="icon-ok"></i> Approval</button></li>
													<?php } else { 
																if($this->mpenerimaanapt->isPosted($no_penerimaan)) {
																	if($this->mpenerimaanapt->isPosted1($no_penerimaan)) { ?>
																			<li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="bukatrans" disabled> <i class="icon-key"></i> Buka Trans.</a></li>
																			<li><button class="btn" type="submit"  name="submit" value="unapprove"> <i class="icon-ok"></i> Batal Approve</button></li>																																				
																	<?php } else { 
																				if($kd_applogin==0){ ?>
																					<li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="bukatrans" disabled> <i class="icon-key"></i> Buka Trans.</a></li>
																				<?php }  else { ?>
																					<li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="bukatrans" data-toggle="modal" data-original-title="Log Penerimaan" data-placement="bottom" rel="tooltip" href="#bukatutupform"> <i class="icon-key"></i> Buka Trans.</a></li>
																				<?php } ?>
																		<li><button class="btn" type="submit"  name="submit" value="approval"> <i class="icon-ok"></i> Approval</button></li>
																	<?php } ?>
															<?php } else { ?>
																	<li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="tutuptrans"> <i class="icon-key"></i> Tutup Trans.</button></li>	
																	<li><button class="btn" type="submit"  name="submit" value="approval" disabled> <i class="icon-ok"></i> Approval</button></li>
															<?php } ?>
													<?php } ?>
                                                </ul>
                                            </div>
                                            <!-- /.toolbar -->
                                        </header>
                                        <div id="div-1" class="accordion-body collapse in body">
											<div class="row-fluid">
												<div class="span12">
													<div class="span5">
														<div class="control-group">
															<label for="no_penerimaan" class="control-label">No. Penerimaan </label>
															<div class="controls with-tooltip">
																<input type="text" name="no_penerimaan" id="no_penerimaan" value="<?php echo $no_penerimaan; ?>" readonly class="span7 input-tooltip" data-original-title="no penerimaan" data-placement="bottom"/>
																<span class="help-inline"></span>
																<input type="hidden" id="kd_applogin" name="kd_applogin" value="<?php echo $kd_applogin; ?>" class="span2 input-tooltip" data-original-title="kd_applogin" data-placement="bottom"/>
															</div>
														</div>
													</div>
													<div class="span7">
														<label for="no_faktur" class="control-label">No. Faktur </label>
														<div class="controls with-tooltip">
															<input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="text" name="no_faktur" id="no_faktur" value="<?php if(isset($itemtransaksi['no_faktur1']))echo $itemtransaksi['no_faktur1'] ?>" class="span5 input-tooltip" data-original-title="no faktur" data-placement="bottom"/>
															<span class="help-inline"></span>	
															Tgl. Faktur <input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="text" name="tgl_faktur" id="tgl_faktur" class="input-small input-tooltip cleared" data-original-title="tgl faktur" data-mask="99-99-9999" value="<?php if(empty($itemtransaksi['tgl_faktur']))echo date('d-m-Y'); else echo convertDate($itemtransaksi['tgl_faktur']);  ?>" data-placement="bottom"/>
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
																<input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="text" name="tgl_penerimaan" id="tgl_penerimaan" class="input-small input-tooltip cleared" data-original-title="tgl penerimaan" data-mask="99-99-9999" value="<?php if(empty($itemtransaksi['tgl_penerimaan']))echo date('d-m-Y'); else echo convertDate($itemtransaksi['tgl_penerimaan']);  ?>" data-placement="bottom"/>
																<span class="help-inline"></span>
																Shift  <input type="text" id="shift" name="shift" value="<?php if(isset($itemtransaksi['shift']))echo $itemtransaksi['shift'] ?>" class="span2 input-tooltip" data-original-title="shift" data-placement="bottom" readonly />
															</div>
														</div>
													</div>
													<div class="span7">
														<div class="control-group">
															<label for="lunas" class="control-label">Lunas </label>
															<div class="controls with-tooltip">
																<input type="checkbox" id="lunas" name="lunas" value="1" <?php echo set_checkbox('lunas','1',isset($itemtransaksi['lunas'])&& $itemtransaksi['lunas']=='1' ? true:false); ?> disabled />
																<span class="help-inline"></span>
																Tutup Faktur <input type="checkbox" id="posting" name="posting" value="1" <?php echo set_checkbox('posting','1',isset($itemtransaksi['posting'])&& $itemtransaksi['posting']=='1' ? true:false); ?> disabled />
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row-fluid">
												<div class="span12">
													<div class="span5">
														<div class="control-group">
															<label for="tgl_tempo" class="control-label">Tgl. Jatuh Tempo </label>
															<div class="controls with-tooltip">
																<input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="text" name="tgl_tempo" id="tgl_tempo" class="input-small input-tooltip cleared" data-original-title="tgl tempo" data-mask="99-99-9999" value="<?php if(empty($itemtransaksi['tgl_tempo']))echo date('d-m-Y'); else echo convertDate($itemtransaksi['tgl_tempo']);  ?>" data-placement="bottom"/>
																<span class="help-inline"></span>
																<input type="hidden" name="jam_penerimaan" id="jam_penerimaan" value="<?php echo date('h:i:s'); ?>" data-mask="99:99:99" class="input-small"/>
																<input type="hidden" id="jam_penerimaan1" name="jam_penerimaan1" value="<?php if(isset($itemtransaksi['jam_penerimaan']))echo $itemtransaksi['jam_penerimaan'] ?>" class="input-small" data-original-title="jam penerimaan" data-placement="bottom"/>
															</div>
														</div>
													</div>
													<div class="span7">
														<div class="control-group">
															<label for="kd_supplier" class="control-label">Distributor </label>
															<div class="controls with-tooltip">
																<input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="text" id="kd_supplier" name="kd_supplier" value="<?php if(isset($itemtransaksi['kd_supplier']))echo $itemtransaksi['kd_supplier'] ?>" class="span2 input-tooltip" data-original-title="kd distributor" data-placement="bottom"/>																
																<input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="text" id="nama" name="nama" value="<?php if(isset($itemtransaksi['nama']))echo $itemtransaksi['nama'] ?>" class="span9 input-tooltip" data-original-title="nama distributor" data-placement="bottom"/>																
																<!--input type="hidden" id="alamat" name="alamat" value="<?php if(isset($itemtransaksi['alamat']))echo $itemtransaksi['alamat'] ?>" class="span4 input-tooltip" data-original-title="alamat" data-placement="bottom"/-->
																&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp( List Distributor : Ctrl + D )
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
															<label for="isipesan" class="control-label">Pilih Pesanan</label>
															<div class="controls with-tooltip">
																<input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="text" id="isipesan" name="isipesan" value="" class="span12 input-tooltip cleared" data-original-title="isi pesan" data-placement="bottom" />
																&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp( List Pesanan : Ctrl + P )
																<span class="help-inline"></span>
															</div>
														</div>
													</div>													
													<div class="span7">
														<div class="control-group">
															<label for="keterangan" class="control-label">Keterangan </label>
															<div class="controls with-tooltip">
																<input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="text" id="keterangan" name="keterangan" value="<?php if(isset($itemtransaksi['keterangan']))echo $itemtransaksi['keterangan'] ?>" class="span11 input-tooltip cleared" data-original-title="keterangan" data-placement="bottom"/>
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
															<label for="isipesan" class="control-label">Sumber Dana</label>
															<div class="controls with-tooltip">
																<select  class="input-xlarge cleared" name="kd_unit_apt" id="kd_unit_apt">
																			<option value="">Pilih Sumber Dana</option>
																			<?php
																			foreach ($sumberdana as $sd) {
																				$select="";
																				
																					if($itemtransaksi['kd_unit_apt']==$sd['kd_unit_apt'])$select="selected=selected";else $select="";
																				
																		
																			?>
																				<option value="<?php if(!empty($sd)) echo $sd['kd_unit_apt'] ?>" <?php echo $select; ?>><?php echo $sd['nama_unit_apt'] ?></option>
																			<?php
																			}
																			?>
																</select>
																<span class="help-inline"></span>
															</div>
														</div>
													</div>		
													<div class="span7">
														<div class="control-group">
															<label for="jumlah" class="control-label">Jumlah Transaksi</label>
															<div class="controls with-tooltip">
																<input style="text-align:right;" type="text" id="jumlah" name="jumlah" value="<?php if(isset($itemtransaksi['jumlah']))echo number_format($itemtransaksi['jumlah'],2,'.','') ?>" class="span4 input-tooltip jumlah cleared" data-original-title="jumlah" data-placement="bottom" readonly />
																<span class="help-inline"></span>
																<input type="hidden" name="tgl_entry" id="tgl_entry" class="input-small input-tooltip cleared" data-original-title="tgl entry" data-mask="9999-99-99" value="<?php if(empty($tgl_entry))echo date('Y-m-d'); else echo convertDate($tgl_entry); ?>" data-placement="bottom"/>
																<input style="text-align:right;" type="hidden" id="discount1" name="discount1" value="<?php if(isset($itemtransaksi['discount']))echo number_format($itemtransaksi['discount'],2,'.','') ?>" class="span4 input-tooltip" data-original-title="discount" data-placement="bottom"/>
																<input type="hidden" name="apf_number1" id="apf_number1" value="<?php if(isset($itemtransaksi['apf_number']))echo $itemtransaksi['apf_number'] ?>" class="span5 input-tooltip" data-original-title="apf number" data-placement="bottom"/>
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
															<li><button <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "disabled"; ?> class="btn" type="button" id="tambahbaris"> <i class="icon-plus"></i> Tambah Obat (Ctrl+B)</button></li>
															<li><button <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "disabled"; ?> class="btn" type="button" id="hapusbaris"> <i class="icon-remove"></i> Hapus Obat</button></li>
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
																<th class="header" style="width:85px;padding:0 !important;">No. Pesan</th>
																<th class="header" style="width:160px;padding:0 !important;">Nama Obat</th>
																<th class="header" style="width:50px;padding:0 !important;text-align:center;">Satuan</th>
																<th class="header" style="width:50px;padding:0 !important;text-align:center;">Tgl.Exp</th>
																<th class="header" style="width:50px;padding:0 !important;text-align:center;">No.Batch</th>
																<th class="header" style="width:50px;padding:0 !important;text-align:center;">Qty</th>
																<!--th class="header" style="width:50px;padding:0 !important;text-align:center;">Qty K</th-->																																
																<th class="header" style="width:60px;padding:0 !important;text-align:center;">Harga B</th>
																<th class="header" style="width:60px;padding:0 !important;text-align:center;">Update HB</th>
																<!--th class="header" style="width:60px;padding:0 !important;text-align:center;">Harga R</th-->
																<th class="header" style="width:50px;padding:0 !important;text-align:center;">Disc%</th>
																<!--th class="header" style="width:60px;padding:0 !important;text-align:center;">Hrg Disc.</th-->
																<th class="header" style="width:60px;padding:0 !important;text-align:center;">Disc. (Rp)</th>
																<th class="header" style="width:60px;padding:0 !important;text-align:center;">Jumlah</th>
																<th class="header" style="width:50px;padding:0 !important;text-align:center;">PPN% </th>
																<th class="header" style="width:50px;padding:0 !important;text-align:center;">Bonus</th>
																<th class="header" style="text-align:right;width:60px;padding:0 !important;">Total </th>
															</tr>
														</thead>
														<tbody id="bodyinput">
															<?php
																if(isset($itemsdetiltransaksi)){
																	//$no=1;
																	$subtotal=0;
																	$diskonall=$this->mpenerimaanapt->ambildiskonall($no_penerimaan);
																	$grandtotal=0;
																	foreach ($itemsdetiltransaksi as $itemdetil){
																		$kiteye=$itemdetil['qty_kcl'];
																		$harga=$itemdetil['harga_beli'];
																		$discpers=$itemdetil['disc_prs'];
																		$diskon=$itemdetil['isidiskon'];
																		$ppn=$itemdetil['ppn_item'];
																		$jum1=0;
																		if($discpers=='')$discpers=0;
																		if($diskon=='')$diskon=0;
																		if($ppn=='')$ppn=0;
																		$hbdisc=($discpers/100)*$harga*$kiteye;
																		if($discpers!=0){
																			$jum1=($kiteye*$harga)-$hbdisc;
																		}
																		else{
																			if($diskon!=0){
																				$jum1=($kiteye*$harga)-$diskon;
																			}
																			else{
																				$jum1=$kiteye*$harga;
																			}
																		}
																		$totalnya=$jum1+($jum1*($ppn/100));
																	?>
																		<tr style="font-size:80% !important;"><td style="text-align:center;padding:0 !important;"><input type="checkbox" <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "disabled"; ?> class="barisinput cleared" /></td>
																			<input type="hidden" name="kd_obat[]" value="<?php echo $itemdetil['kd_obat'] ?>" style="width:85px;" class="input-small bariskodeobat cleared">
																			<td style="padding:0 !important;"><input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="text" name="no_pemesanan[]" value="<?php echo $itemdetil['no_pemesanan'] ?>" style="width:110px;font-size:90% !important;" class="input-small barisnopesan cleared"></td>
																			<td style="padding:0 !important;"><input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="text" name="nama_obat[]" value="<?php echo $itemdetil['nama_obat'] ?>" style="width:250px;font-size:90% !important;" class="input-xlarge barisnamaobat cleared"></td>
																			<td style="padding:0 !important;"><input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="text" name="satuan_kecil[]" value="<?php echo $itemdetil['satuan_kecil'] ?>" style="width:80px;font-size:90% !important;" class="input-small barissatuan cleared" readonly></td>
																			<td style="padding:0 !important;"><input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="text" name="tgl_expire[]" style="width:80px !important;font-size:90% !important;" data-mask="99-99-9999" value="<?php echo $itemdetil['tgl_expire'] ?>" class="input-small baristanggal cleared"></td>
																			<td style="padding:0 !important;"><input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="text" name="no_batch[]" style="width:80px !important;font-size:90% !important;"  value="<?php echo $itemdetil['no_batch'] ?>" class="input-small barisbatch cleared"></td>
																			<input type="hidden" name="pembanding[]" value="<?php echo $itemdetil['pembanding'] ?>" class="input-small barispembanding cleared">
																			<td style="padding:0 !important;"><input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="text" name="qty_box[]" value="<?php echo $kiteye; ?>" style="width:60px;font-size:90% !important;" class="input-small barisqtyb cleared"></td>
																			<input type="hidden" name="qty_kcl[]" value="<?php echo $itemdetil['qty_kcl'] ?>" style="width:50px;font-size:90% !important;" class="input-small barisqtyk cleared">

																			<td style="padding:0 !important;"><input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> style="text-align:right;" type="text" name="harga_beli[]" value="<?php echo number_format($harga,2,'.',''); ?>" style="width:60px !important;font-size:90% !important;" class="input-small barishargabeli cleared"></td>
																			<td style="text-align:center;padding:0 !important;"><input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "disabled"; ?> type="checkbox" <?php echo set_checkbox('update','1',isset($itemdetil['update'])&& $itemdetil['update']=='1' ? true:false); ?> class="barisceklisupdate cleared" /></td>																			
																			<input type="hidden" name="harga_avg[]" value="<?php echo $itemdetil['sum'] ?>" class="input-small barishargarata cleared" readonly>
																			<td style="padding:0 !important;"><input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="text" name="disc_prs[]" value="<?php echo $discpers; ?>" style="width:40px;font-size:90% !important;" class="input-small barisdisc cleared"></td>
																			<input style="text-align:right;" type="hidden" name="harga_belidisc[]" value="<?php echo $hbdisc; ?>" style="width:60px;font-size:90% !important;" class="input-small barishargabelidisc cleared" readonly>
																			<td style="padding:0 !important;"><input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> style="text-align:right;" type="text" name="isidiskon[]" value="<?php echo number_format($diskon,2,'.',''); ?>" style="width:60px;font-size:90% !important;" class="input-small barisisidiskon cleared"></td>
																			<td style="padding:0 !important;"><input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> style="text-align:right;" type="text" name="jumlah1[]" value="<?php echo number_format($jum1,2,'.',''); ?>" style="width:70px;font-size:90% !important;" class="input-small barisjumlah1 cleared" readonly></td>														
																			<td style="padding:0 !important;"><input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="text" name="ppn_item[]" value="<?php echo $ppn; ?>" style="width:40px;font-size:90% !important;" class="input-small barisppn cleared"></td>
																			<td style="padding:0 !important;"><input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="text" name="bonus[]" value="<?php echo $itemdetil['bonus'] ?>" style="width:50px;font-size:90% !important;" class="input-small barisbonus cleared"></td>
																			<td style="text-align:right;padding:0 !important;"><input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> style="text-align:right;" type="text" name="total[]" value="<?php echo number_format($totalnya,2,'.',''); ?>" style="width:20px;font-size:80% !important;" class="input-medium barisjumlah cleared" readonly></td>
																			<td><input type="hidden" name="update[]" value="<?php echo $itemdetil['update'] ?>" class="input-mini barisisiupdate cleared"></td>
																		</tr>
																	<?php
																		//$no++;
																		$subtotal=$subtotal+$totalnya;
																	}
																	$grandtotal=$subtotal-$diskonall;
																}
															?>

														</tbody>
														<tfoot>
															<tr>
																<th colspan="15" style="text-align:right;" class="header">Sub Total (Rp) : <input type="text" class="input-medium cleared" id="totalpenerimaan" value="<?php echo number_format($subtotal,2,'.','') ?>" style="text-align:right" readonly></th>
															</tr>
															<tr>
																<th colspan="15" style="text-align:right;" class="header">Discount (Rp) : <input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="text" class="input-medium cleared" id="discount" value="<?php echo number_format($diskonall,2,'.',''); ?>" style="text-align:right"></th>
																<!--th colspan="14" style="text-align:right;" class="header">Discount (Rp) : <input type="text" class="input-medium cleared" id="discount" style="text-align:right"></th-->
															</tr>
															<tr>
																<th colspan="15" style="text-align:right;" class="header">Total Penerimaan (Rp) : <input type="text" class="input-medium cleared" id="grandtotal" value="<?php echo number_format($grandtotal,2,'.',''); ?>" style="text-align:right" readonly></th>
																<!--th colspan="14" style="text-align:right;" class="header">Total Penerimaan (Rp) : <input type="text" class="input-medium cleared" id="grandtotal" style="text-align:right" readonly></th-->
															</tr>
														</tfoot>
													</table>
												</div>
											</div>
										</div>
									</div>
									
									<div aria-hidden="true" aria-labelledby="approveModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="bukatutupform" style="display: none;">
										<div class="modal-header">
											<button aria-hidden="true" data-dismiss="modal" class="close" type="button">\D7</button>
											<h3 id="helpModalLabel"><i class="icon-external-link"></i> Log Penerimaan</h3>
										</div>
										<div class="modal-body" style="">
											<div class="body" id="collapse4">
												<div class="row-fluid">
													<div class="span12">
														<div class="control-group">
															<label for="no_penerimaan1" class="control-label">No. Penerimaan</label>
															<div class="controls with-tooltip">
																<input type="text" name="no_penerimaan1" id="no_penerimaan1" value="<?php echo $no_penerimaan; ?>" readonly class="span7 input-tooltip" data-original-title="no penerimaan" data-placement="bottom"/>
																<span class="help-inline"></span>
																<input type="hidden" name="tgl_log" id="tgl_log" class="input-small input-tooltip cleared" data-original-title="tgl log" data-mask="9999-99-99" value="<?php echo date('Y-m-d'); ?>" data-placement="bottom"/>
																<input type="hidden" name="jam_log" id="jam_log" value="<?php echo date('h:i:s'); ?>" data-mask="99:99:99" class="input-small"/>
																<input type="hidden" name="jenis" id="jenis" value="<?php if($this->mpenerimaanapt->isPosted($no_penerimaan)) {echo 1;} else {echo 0;} ?>" class="input-mini input-tooltip cleared" data-original-title="jenis" data-placement="bottom"/>
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
														<?php if($this->mpenerimaanapt->isPosted($no_penerimaan)) { ?>
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
											<button aria-hidden="true" data-dismiss="modal" class="close" type="button">\D7</button>
											<h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Penerimaan</h3>
										</div>
										<div class="modal-body" style="">
											<div class="body" id="collapse4">
												<table id="dataTable1" class="table table-bordered table-condensed table-hover table-striped">
													<thead>
														<tr>
															<th style="text-align:center;">No Penerimaan</th>
															<th style="text-align:center;">Tanggal</th>
															<th style="text-align:center;">Distributor</th>
															<th style="text-align:center;">Keterangan</th>
															<th style="text-align:center;">Status Penerimaan</th>
															<!--<th>Approve</th>-->
															<th style="text-align:center;">Pilihan</th>
														</tr>
													</thead>
													<tbody>
														<?php
															foreach ($items as $item) {
															# code...
															if($item['lunas']=="1"){
																$lunas="Lunas";
															}else{
																$lunas="Belum Lunas";
															}
														?>
																<tr>
																	<td><?php echo $item['no_penerimaan'] ?></td>
																	<td><?php echo $item['tgl_penerimaan'] ?></td>
																	<td><?php echo $item['nama'] ?></td>
																	<td><?php echo $item['keterangan'] ?></td>
																	<td><?php echo $lunas ?></td>																	
															<!--
															<td style="text-align:center;"></td>
															-->	
																	<td>
																		<a href="<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/ubahpenerimaan/<?php echo $item['no_penerimaan'] ?>" class="btn"><i class="icon-edit"></i> PILIH</a>
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
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">\D7</button>
        <h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Distributor</h3>
    </div>
    <div class="modal-body" style="height:300px;">
        <div class="body" id="collapse4">
            <table id="dataTable5" class="table table-bordered table-condensed table-hover table-striped">
                <thead>
                    <tr>						
                        <th style="text-align:center;">Kode </th>
                        <th style="text-align:center;">Nama Distributor</th>
						<th style="text-align:center;">Alamat</th>
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
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">\D7</button>
        <h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Obat</h3>
    </div>
    <div class="modal-body" id="modal-body-daftarobat" style="height:300px;">
        <div class="body" id="collapse4">
            <table id="dataTable4" class="table table-bordered">
                <thead>
                    <tr>						
                        <th style="text-align:center;">Kode Obat</th>
                        <th style="text-align:center;">Nama Obat</th>
						<th style="text-align:center;">Satuan</th>
						<th style="text-align:center;">Harga</th>     
						<th style="text-align:center;">Stok</th>                 
                        <th style="width:50px !important;" style="text-align:center;">Pilihan</th>
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

<div aria-hidden="true" aria-labelledby="helpModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="daftarpesan" style="display: none;width:50%;margin-left:-400px !important;"> 
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">\D7</button>
        <h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Pemesanan</h3>
    </div>
    <div class="modal-body" style="height:260px;">
        <div class="body" id="collapse4">
            <table id="dataTable3" class="table table-bordered table-condensed table-hover table-striped">
                <thead>
					<tr>	
						<th>&nbsp;</th>
                        <th style="text-align:center;">No. Pesan</th>
                        <th style="text-align:center;">Tgl. Pesan</th>
						<th style="text-align:center;">Distributor</th>
						<!--th style="text-align:center;" style="width:50px !important;">Pilihan</th-->
                    </tr>					
                </thead>
                <tbody id="listpesan">
					<th></th>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <input type="text" id="isipesan1" class="pull-left" autocomplete="off">		
		<button aria-hidden="true" data-dismiss="modal" class="btn" id="pilihceklis">Pilih</button>
        <button aria-hidden="true" data-dismiss="modal" class="btn">Close</button>		
    </div>
</div>
			
<script type="text/javascript">
    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });
	
	$('#simpanlog').click(function(){
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
	
	$('#tgl_faktur').datepicker({
        format: 'dd-mm-yyyy'
    });
	
    $('#tgl_penerimaan').datepicker({
        format: 'dd-mm-yyyy'
    });
	
	$('#jam_penerimaan').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
    });
	
	$('#jam_log').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
    });
	
	$('#tgl_tempo').datepicker({
        format: 'dd-mm-yyyy'
    });
	
	$('#tgl_entry').datepicker({
        format: 'yyyy-mm-dd'
    });
	
	$('#materai').change(function(){
		var val=$(this).val(); 
		var totalpenerimaan=$('#totalpenerimaan').val();
		var discount=$('#discount').val();
		
		if(val=='') val=0;
		if(totalpenerimaan=='')totalpenerimaan=0;
		if(discount=='') discount=0;
		
		var jumlah=(parseFloat(val)+parseFloat(totalpenerimaan))-parseFloat(discount);
		$('#jumlah').val(jumlah.toFixed(2));
	});
	
	$('#discount').change(function(){
		//alert('masuk changenya discount');
		var val=$(this).val(); 
		var totalpenerimaan=$('#totalpenerimaan').val();
		var materai=$('#materai').val();
		
		if(val=='') val=0;
		if(totalpenerimaan=='')totalpenerimaan=0;
		if(materai=='') materai=0;
		
		var jumlah=(parseFloat(materai)+parseFloat(totalpenerimaan))-parseFloat(val);
		$('#jumlah').val(jumlah.toFixed(2));
		$('#grandtotal').val((parseFloat(totalpenerimaan)-parseFloat(val)).toFixed(2));
		$('#discount1').val(val.toFixed(2));
	});
	
	
	
	$('#pilihceklis').click(function(){ //bwt tombol pilih di dlm popupnya
		var ceklis="";
		$('.ceklis').each(function(){
			 if($(this).attr('checked')){
				ceklis+=$(this).val()+',';
				
				
			}
        });		
		$.ajax({
			url: '<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/ambildetilpemesanan/',
			async:false,
			type:'get',
			data:{query:ceklis},
			success:function(data){
			//typeahead.process(data)
				$('#bodyinput').empty();
				var total=0;
				$.each(data,function(i,l){
					//alert(l);		
					total=total+parseFloat(l.total1);
					
					var kiteye=l.qty;					
					var harga=l.harga_beli;					
					var discpers=l.disc_prs;
					//alert(discpers);
					var diskon=l.diskon;
					var ppn=l.ppn;
					var jum1=0;
					if(discpers=='')discpers=0;
					if(diskon=='')diskon=0;
					if(ppn=='')ppn=0;
					hbdisc=(parseFloat(discpers)/100)*parseFloat(harga)*parseFloat(kiteye);
					if(discpers!=0){
						jum1=(parseFloat(kiteye)*parseFloat($harga))-parseFloat(hbdisc);
					}
					else{
						if(diskon!=0){
							jum1=(parseFloat(kiteye)*parseFloat(harga))-parseFloat(diskon);
						}
						else{
							jum1=parseFloat(kiteye)*parseFloat(harga);
						}
					}
					$('#bodyinput').append('<tr style="font-size:80% !important;"><td style="text-align:center;padding:0 !important;"><input type="checkbox" class="barisinput cleared" /></td>'+
									'<input type="hidden" name="kd_obat[]" value="'+l.kd_obat+'" style="width:85px;" class="input-small bariskodeobat cleared">'+
									'<td style="padding:0 !important;"><input type="text" name="no_pemesanan[]" value="'+l.no_pemesanan+'" style="width:110px;font-size:90% !important;" class="input-small barisnopesan cleared"></td>'+
                                    '<td style="padding:0 !important;"><input type="text" name="nama_obat[]" value="'+l.nama_obat+'" style="width:250px;font-size:90% !important;" class="input-xlarge barisnamaobat cleared"></td>'+
                                    '<td style="padding:0 !important;"><input type="text" name="satuan_kecil[]" value="'+l.satuan_kecil+'" style="width:80px;font-size:90% !important;" class="input-small barissatuan cleared" readonly></td>'+
									'<td style="padding:0 !important;"><input type="text" name="tgl_expire[]" style="width:80px !important;font-size:90% !important;" data-mask="99-99-9999" value="" class="input-small baristanggal cleared"></td>'+
									'<td style="padding:0 !important;"><input type="text" name="no_batch[]" style="width:80px !important;font-size:90% !important;" value="" class="input-small barisbatch cleared"></td>'+
									'<input type="hidden" name="pembanding[]" value="'+l.pembanding+'" class="input-small barispembanding cleared">'+
									'<td style="padding:0 !important;"><input type="text" name="qty_box[]" value="'+l.qty+'" style="width:60px;font-size:90% !important;" class="input-small barisqtyb cleared"></td>'+
									'<input type="hidden" name="qty_kcl[]" value="'+l.qty+'" style="width:50px;font-size:90% !important;" class="input-small barisqtyk cleared">'+
'<input type="hidden" name="jml_penerimaan[]" value="'+l.jml_penerimaan+'" style="width:50px;font-size:90% !important;" class="input-small barisjmlpenerimaan cleared">'+
									'<td style="padding:0 !important;"><input style="text-align:right;" type="text" name="harga_beli[]" value="'+(parseFloat(l.harga_beli).toFixed(2))+'" style="width:60px !important;font-size:90% !important;" class="input-small barishargabeli cleared"></td>'+									
									'<td style="text-align:center;padding:0 !important;"><input type="checkbox" class="barisceklisupdate cleared" /></td>'+									
									'<input type="hidden" name="harga_avg[]" value="0" class="input-small barishargarata cleared" readonly>'+
									'<td style="padding:0 !important;"><input type="text" name="disc_prs[]" value="'+discpers+'" style="width:40px;font-size:90% !important;" class="input-small barisdisc cleared"></td>'+
									'<input style="text-align:right;" type="hidden" name="harga_belidisc[]" value="'+(hbdisc.toFixed(2))+'" style="width:60px;font-size:90% !important;" class="input-small barishargabelidisc cleared" readonly>'+
									'<td style="padding:0 !important;"><input style="text-align:right;" type="text" name="isidiskon[]" value="'+(parseFloat(diskon).toFixed(2))+'" style="width:60px;font-size:90% !important;" class="input-small barisisidiskon cleared"></td>'+
									'<td style="padding:0 !important;"><input style="text-align:right;" type="text" name="jumlah1[]" value="'+jum1.toFixed(2)+'" style="width:70px;font-size:90% !important;" class="input-small barisjumlah1 cleared" readonly></td>'+									
									'<td style="padding:0 !important;"><input type="text" name="ppn_item[]" value="'+ppn+'" style="width:40px;font-size:90% !important;" class="input-small barisppn cleared"></td>'+
									'<td style="padding:0 !important;"><input type="text" name="bonus[]" value="0" style="width:50px;font-size:90% !important;" class="input-small barisbonus cleared"></td>'+
                                    '<td style="text-align:right;padding:0 !important;"><input style="text-align:right;" type="text" name="total[]" value="'+(parseFloat(l.total1).toFixed(2))+'" style="width:20px;font-size:80% !important;" class="input-medium barisjumlah cleared" readonly></td>'+
									'<td><input type="hidden" name="update[]" value="0" class="input-mini barisisiupdate cleared"></td>'+
                                '</tr>');
					
				});	
				$('#totalpenerimaan').val(total.toFixed(2));
				$('#grandtotal').val(total.toFixed(2));
				var materai=$('#materai').val();
				var diskon=$('#discount').val();
				var subtotal=$('#totalpenerimaan').val();
				if(materai=='')materai=0;
				if(diskon=='')diskon=0;
				if(subtotal=='')subtotal=0;
				var jumlahnya=parseFloat(materai)+parseFloat(subtotal)+parseFloat(diskon);
				$('#jumlah').val(jumlahnya.toFixed(2));
				$('#daftarpesan').modal("hide");
				$('#keterangan').focus();
				
				$('.barisqtyb, .barishargabeli, .barisppn, .barisnamaobat, .baristanggal, .barisdisc, .barisppn, .barisceklisupdate, .barisisidiskon').click(function(){  
					$('#bodyinput tr').removeClass('focused'); 
					$(this).parent().parent('tr').addClass('focused'); 
				})
				
				$('.barisjumlah').change(function(){ 
					var totalpenerimaan=0; var total1=0; var grandtotal=0;
					var materai=$('#materai').val();
					var discount=$('#discount').val();
					if(discount=='')discount=0;
					if(materai=='')materai=0;
				   $('.barisjumlah').each(function(){
						var val=$(this).val(); 
						if(val=='')val=0;
						totalpenerimaan=totalpenerimaan+parseFloat(val); 
						total1=(parseFloat(materai)+parseFloat(totalpenerimaan))-parseFloat(discount);
					});
				   $('#jumlahapprove').val(totalpenerimaan);
				   $('#totalpenerimaan').val(totalpenerimaan.toFixed(2));
				   $('#jumlah').val(total1.toFixed(2));
				   
				   var subtotal=$('#totalpenerimaan').val();
				   if(subtotal=='')subtotal=0;
				   grandtotal=parseFloat(subtotal)-parseFloat(discount);
				   $('#grandtotal').val(grandtotal.toFixed(2));
				});
				
				$('.barisqtyb').change(function(){ 
					var val=$(this).val(); 					
					var pembanding=$('.focused').find('.barispembanding').val();
					if(val=='')val=0; 
					var qtykecil=parseFloat(val) * parseFloat(pembanding); //ngupdate qty k
					//var qtykecil=parseFloat(val) ; //ngupdate qty k
					$('.focused').find('.barisqtyk').val(qtykecil);
					jumlahharga();
					jumlahtotal();
					totaltransaksi();
					$('.focused').find('input[name="harga_beli[]"]').focus();

				});
				
				$('.barishargabeli').change(function(){  
					var val=$(this).val(); //harga beli  
					
					$('.focused').find('.barishargarata').val(parseFloat(val).toFixed(2));
					jumlahharga();
					jumlahtotal();
					totaltransaksi();
					$('.focused').find('input[name="disc_prs[]"]').focus();
				})
				
				$('.barisisidiskon').change(function(){ 
					jumlahharga();
					jumlahtotal();
					totaltransaksi();
					$('.focused').find('input[name="ppn_item[]"]').focus();
				});
				
				$('.barisdisc').change(function(){  
					var val=$(this).val(); //disc
					var hargabeli=$('.focused').find('.barishargabeli').val(); //hargabeli
					var qtyk=$('.focused').find('.barisqtyk').val();
					if(val=='')val=0;
					if(hargabeli=='')hargabeli=0;
					if(qtyk=='')qtyk=0;
					var hargabelidiscount= (parseFloat(val)/100)*parseFloat(hargabeli)*parseFloat(qtyk);
					
					$('.focused').find('.barishargabelidisc').val(hargabelidiscount.toFixed(2));
					//$('.barisjumlah').trigger('change');
					jumlahharga();
					jumlahtotal();
					totaltransaksi();

					$('.focused').find('input[name="ppn_item[]"]').focus();
				})
				
				$('.barisceklisupdate').click(function(){
					if($('.barisceklisupdate').is(':checked')){
						$('.focused').find('.barisisiupdate').val(1);
					}
					else {
						$('.focused').find('.barisisiupdate').val(0);
					}
				})
				
				$('.barisppn').change(function(){  
					var val=$(this).val(); //ppn
					
					jumlahtotal();
					totaltransaksi();
					$('.barisjumlah').trigger('change');
					//$('.focused').find('input[name="total[]"]').focus();
				})
			},
			dataType:'json'                         
		});	 
	})
	
	function pilihpesanan(no_pemesanan,tgl_pemesanan,nama) {
		$('#isipesan').val(no_pemesanan);
		$.ajax({
			url: '<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/ambildetilpemesanan/',
			async:false,
			type:'get',
			data:{query:no_pemesanan},
			success:function(data){
			//typeahead.process(data)
				$('#bodyinput').empty();
				var total=0;
				$.each(data,function(i,l){
					//alert(l);		
					total=total+parseFloat(l.total1);
					$('#bodyinput').append('<tr style="font-size:80% !important;"><td style="text-align:center;padding:0 !important;"><input type="checkbox" class="barisinput cleared" /></td>'+
									'<input type="hidden" name="kd_obat[]" value="'+l.kd_obat+'" style="width:85px;" class="input-small bariskodeobat cleared">'+
									'<td style="padding:0 !important;"><input type="text" name="no_pemesanan[]" value="'+l.no_pemesanan+'" style="width:150px;font-size:90% !important;" class="input-small barisnopesan cleared"></td>'+
                                    '<td style="padding:0 !important;"><input type="text" name="nama_obat[]" value="'+l.nama_obat+'" style="width:250px;font-size:90% !important;" class="input-xlarge barisnamaobat cleared"></td>'+
                                    '<td style="padding:0 !important;"><input type="text" name="satuan_kecil[]" value="'+l.satuan_kecil+'" style="width:100px;font-size:90% !important;" class="input-small barissatuan cleared" readonly></td>'+
									'<td style="padding:0 !important;"><input type="text" name="tgl_expire[]" style="width:80px !important;font-size:90% !important;" data-mask="99-99-9999" value="" class="input-small baristanggal cleared"></td>'+
									'<td style="padding:0 !important;"><input type="text" name="no_batch[]" style="width:80px !important;font-size:90% !important;" value="" class="input-small barisbatch cleared"></td>'+
									'<input type="hidden" name="pembanding[]" value="'+l.pembanding+'" class="input-small barispembanding cleared">'+
									'<td style="padding:0 !important;"><input type="text" name="qty_box[]" value="'+l.qty_box+'" style="width:60px;font-size:90% !important;" class="input-small barisqtyb cleared"></td>'+
									'<input type="hidden" name="qty_kcl[]" value="'+l.qty+'" style="width:50px;font-size:90% !important;" class="input-small barisqtyk cleared">'+
'<input type="hidden" name="jml_penerimaan[]" value="'+l.jml_penerimaan+'" style="width:50px;font-size:90% !important;" class="input-small barisqtyk cleared">'+
									'<td style="padding:0 !important;"><input style="text-align:right;" type="text" name="harga_beli[]" value="'+parseFloat(l.harga_beli).toFixed(2)+'" style="width:60px !important;font-size:90% !important;" class="input-small barishargabeli cleared"></td>'+									
									'<td style="text-align:center;padding:0 !important;"><input type="checkbox" class="barisceklisupdate cleared" /></td>'+
									'<input type="hidden" name="harga_avg[]" value="0" class="input-small barishargarata cleared" readonly>'+
									'<td style="padding:0 !important;"><input type="text" name="disc_prs[]" value="'+l.diskon+'" style="width:40px;font-size:90% !important;" class="input-small barisdisc cleared"></td>'+
									'<input style="text-align:right;" type="hidden" name="harga_belidisc[]" value="'+parseFloat(l.harga_belidisc).toFixed(2)+'" style="width:60px;font-size:90% !important;" class="input-small barishargabelidisc cleared" readonly>'+
									'<td style="padding:0 !important;"><input style="text-align:right;" type="text" name="isidiskon[]" value="'+parseFloat(l.isidiskon).toFixed(2)+'" style="width:60px;font-size:90% !important;" class="input-small barisisidiskon cleared"></td>'+
									'<td style="padding:0 !important;"><input style="text-align:right;" type="text" name="jumlah1[]" value="'+parseFloat(l.jum).toFixed(2)+'" style="width:70px;font-size:90% !important;" class="input-small barisjumlah1 cleared" readonly></td>'+									
									'<td style="padding:0 !important;"><input type="text" name="ppn_item[]" value="10" style="width:40px;font-size:90% !important;" class="input-small barisppn cleared"></td>'+
									'<td style="padding:0 !important;"><input type="text" name="bonus[]" value="0" style="width:50px;font-size:90% !important;" class="input-small barisbonus cleared"></td>'+
                                    '<td style="text-align:right;padding:0 !important;"><input style="text-align:right;" type="text" name="total[]" value="'+parseFloat(l.total1).toFixed(2)+'" style="width:20px;font-size:80% !important;" class="input-medium barisjumlah cleared" readonly></td>'+
									'<td><input type="hidden" name="update[]" value="0" class="input-mini barisisiupdate cleared"></td>'+
								'</tr>');
					
				});	
				$('#totalpenerimaan').val(total.toFixed(2));
				var materai=$('#materai').val();
				var diskon=$('#discount').val();
				var subtotal=$('#totalpenerimaan').val();
				if(materai=='')materai=0;
				if(diskon=='')diskon=0;
				if(subtotal=='')subtotal=0;
				var jumlahnya=parseFloat(materai)+parseFloat(subtotal)+parseFloat(diskon);
				$('#jumlah').val(jumlahnya.toFixed(2));
				$('#daftarpesan').modal("hide");
				$('#keterangan').focus();
				
				$('.barisqtyb, .barishargabeli, .barisppn, .barisnamaobat, .baristanggal, .barisdisc, .barisppn, .barisceklisupdate, .barisisidiskon, .barisbatch').click(function(){  
					$('#bodyinput tr').removeClass('focused'); 
					$(this).parent().parent('tr').addClass('focused'); 
				})
				
				$('.barisjumlah').change(function(){ 
					var totalpenerimaan=0; var total1=0; var grandtotal=0;
					var materai=$('#materai').val();
					var discount=$('#discount').val();
					if(discount=='')discount=0;
					if(materai=='')materai=0;
				   $('.barisjumlah').each(function(){
						var val=$(this).val(); 
						if(val=='')val=0;
						totalpenerimaan=totalpenerimaan+parseFloat(val); 
						total1=(parseFloat(materai)+parseFloat(totalpenerimaan))-parseFloat(discount);
					});
				   $('#totalpenerimaan').val(totalpenerimaan.toFixed(2));
				   $('#jumlah').val(total1.toFixed(2));
				   
				   var subtotal=$('#totalpenerimaan').val();
				   if(subtotal=='')subtotal=0;
				   grandtotal=parseFloat(subtotal)-parseFloat(discount);
				   $('#grandtotal').val(grandtotal.toFixed(2));
				});
				
				$('.barisceklisupdate').click(function(){
					if($('.barisceklisupdate').is(':checked')){
						$('.focused').find('.barisisiupdate').val(1);
					}
					else {
						$('.focused').find('.barisisiupdate').val(0);
					}
				})
				
				$('.barisqtyb').change(function(){ 
					var val=$(this).val(); 
					if(val=='')val=0; 
					var pembanding=$('.focused').find('.barispembanding').val();
					var qtykecil=parseFloat(val) * parseFloat(pembanding); //ngupdate qty k
					$('.focused').find('.barisqtyk').val(qtykecil);
					jumlahharga();
					jumlahtotal();
					totaltransaksi();
					$('.focused').find('input[name="harga_beli[]"]').focus();

				});
				
				$('.barishargabeli').change(function(){  
					var val=$(this).val(); //harga beli  
					
					$('.focused').find('.barishargarata').val(parseFloat(val).toFixed(2));
					jumlahharga();
					jumlahtotal();
					totaltransaksi();
					$('.focused').find('input[name="disc_prs[]"]').focus();
				})
				
				$('.barisdisc').change(function(){  
					var val=$(this).val(); //disc
					var hargabeli=$('.focused').find('.barishargabeli').val(); //hargabeli
					var qtyk=$('.focused').find('.barisqtyk').val();
					if(val=='')val=0;
					if(hargabeli=='')hargabeli=0;
					if(qtyk=='')qtyk=0;
					var hargabelidiscount= (parseFloat(val)/100)*parseFloat(hargabeli)*parseFloat(qtyk);
					
					$('.focused').find('.barishargabelidisc').val(hargabelidiscount.toFixed(2));
					//$('.barisjumlah').trigger('change');
					jumlahharga();
					jumlahtotal();
					totaltransaksi();

					$('.focused').find('input[name="ppn_item[]"]').focus();
				})
				
				$('.barisisidiskon').change(function(){ 
					jumlahharga();
					jumlahtotal();
					totaltransaksi();
					$('.focused').find('input[name="ppn_item[]"]').focus();
				});
				
				$('.barisppn').change(function(){  
					var val=$(this).val(); //ppn
					
					jumlahtotal();
					totaltransaksi();
					$('.barisjumlah').trigger('change');
					//$('.focused').find('input[name="total[]"]').focus();
				})
			},
			dataType:'json'                         
		}); 
    }
	
	function pilihsupplier(kd_supplier,nama) {
		$('#kd_supplier').val(kd_supplier);
        $('#nama').val(nama);
//		$('#alamat').val(alamat);
        //$('.focused').find('#alamat').val(alamat);
        $('#daftarsupplier').modal("hide");
        $('#isipesan').focus();
    }

    function jumlahharga(){
        var qtyk=$('.focused').find('.barisqtyk').val();
        var hargabeli=$('.focused').find('.barishargabeli').val();
        var hargabelidisc=$('.focused').find('.barishargabelidisc').val();
		var hargadisc=$('.focused').find('.barisisidiskon').val();
		
        if(hargabelidisc=='')hargabelidisc=0;
		if(qtyk=='')qtyk=0;
		if(hargabeli=='')hargabeli=0;
		if(hargadisc=='')hargadisc=0;
		
        var total=0;
		if(hargabelidisc!=0){ //kalo pake diskon persen
			total=(parseFloat(qtyk)*parseFloat(hargabeli))-parseFloat(hargabelidisc);
		}
		else if(hargadisc!=0){ //kalo pake diskon bukan persen
			total=(parseFloat(qtyk)*parseFloat(hargabeli))-parseFloat(hargadisc);
		}
		else{
			total=(parseFloat(qtyk)*parseFloat(hargabeli));
		}
        $('.focused').find('.barisjumlah1').val(total.toFixed(2));
		//alert('total di barisjumlah1 '+total);
    }
    
    function jumlahtotal(){
		//alert('masukjumlahtotal');
        var ppn=$('.focused').find('.barisppn').val();
        var jumlah1=$('.focused').find('.barisjumlah1').val();
        var total=0;
		if(ppn=='')ppn=0;
		if(jumlah1=='')jumlah1=0;
        total=(parseFloat(jumlah1))+((parseFloat(jumlah1))*parseFloat(ppn)/100);
        //$('.focused').find('.barisjumlah').val(Math.round(total));
		$('.focused').find('.barisjumlah').val(total.toFixed(2));
    }
    
    function totaltransaksi(){
		//alert('masuktotaltransaksi');
        var totalpenerimaan=0; var total1=0; var grandtotal=0;
        var materai=$('#materai').val();
        var discount=$('#discount').val();
        if(discount=='')discount=0;
        if(materai=='')materai=0;
        $('.barisjumlah').each(function(){
            var val=$(this).val(); 
            if(val=='')val=0;
            totalpenerimaan=totalpenerimaan+parseFloat(val); 
            total1=(parseFloat(materai)+parseFloat(totalpenerimaan))-parseFloat(discount);
        });
       $('#jumlahapprove').val(totalpenerimaan);
       $('#totalpenerimaan').val(totalpenerimaan.toFixed(2));
       $('#jumlah').val(total1.toFixed(2));
	   
	   //grandtotal=parseFloat(total1)-parseFloat(discount);
	   grandtotal=parseFloat(totalpenerimaan)-parseFloat(discount);
	   $('#grandtotal').val(grandtotal.toFixed(2));
    }
	
	//function pilihobat(kd_obat,nama_obat,satuan_kecil,pembanding,harga_beli,diskon,ppn) {
	//function pilihobat(kd_obat,nama_obat,satuan_kecil,pembanding) {
	function pilihobat(kd_obat1,nama_obat,satuan_kecil,jml_stok,pembanding,max_stok,harga_beli) {
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
            $('.focused').find('.barisqtyb').val(max_stok);
            $('.focused').find('.barisqtyk').val(max_stok*pembanding);
            $('.focused').find('.barispembanding').val(pembanding);
            $('.focused').find('.barishargabeli').val(parseFloat(harga_beli).toFixed(2));
            $('.focused').find('.barishargarata').val(0);
            $('.focused').find('.barisppn').val(10);
			$('.focused').find('.barisbonus').val(0);
			$('.focused').find('.barisdisc').val(0);
			$('.focused').find('.barishargabelidisc').val(0);


            //$('.focused').find('.barisnama').val(nama_unit_apt);
            //$('.focused').find('.barismilik').val(milik);
            jumlahharga();
            jumlahtotal();
            totaltransaksi();
            $('#daftarobat').modal("hide");
            $('.focused').find('input[name="tgl_expire[]"]').focus();
           
        }
		return false;
    }

	$('#tambahbaris').click(function(){
        if($('.bariskodeobat').length>0){
            $('.baristanggal').each(function(){
                var val=$(this).val();
				var nobatch=$('.focused').find('.barisbatch').val();
                if(val=='' || val=='__-__-____'){
                    alert('Tanggal Expire tidak boleh kosong');
					$('.focused').find('.baristanggal').focus();
                    e.stopImmediatePropagation();
                    return false;
                }
				else{
					if(nobatch==''){
						alert('No. Batch tidak boleh kosong');
						$('.focused').find('.barisbatch').focus();
						e.stopImmediatePropagation();
						return false;
					}
				}
            });

        }


		$('#bodyinput').append('<tr style="font-size:80% !important;"><td style="text-align:center;padding:0 !important;"><input type="checkbox" class="barisinput cleared" /></td>'+
									'<input type="hidden" name="kd_obat[]" value="" style="width:85px;" class="input-small bariskodeobat cleared">'+
									'<td style="padding:0 !important;"><input type="text" name="no_pemesanan[]" value="" style="width:110px;font-size:90% !important;" class="input-small barisnopesan cleared"></td>'+
                                    '<td style="padding:0 !important;"><input type="text" name="nama_obat[]" value="" style="width:250px;font-size:90% !important;" class="input-xlarge barisnamaobat cleared"></td>'+
                                    '<td style="padding:0 !important;"><input type="text" name="satuan_kecil[]" value="" style="width:80px;font-size:90% !important;" class="input-small barissatuan cleared" readonly></td>'+
									'<td style="padding:0 !important;"><input type="text" name="tgl_expire[]" style="width:80px !important;font-size:90% !important;" data-mask="99-99-9999" value="" class="input-small baristanggal cleared"></td>'+
									'<td style="padding:0 !important;"><input type="text" name="no_batch[]" style="width:80px !important;font-size:90% !important;" value="" class="input-small barisbatch cleared"></td>'+
									'<input type="hidden" name="pembanding[]" value="" class="input-small barispembanding cleared">'+
									//'<input type="hidden" name="nama_unit_apt[]" value="" class="input-small barisnama cleared">'+
									//'<input type="hidden" name="milik[]" value="" class="input-small barismilik cleared">'+									
									'<td style="padding:0 !important;"><input type="text" name="qty_box[]" value="" style="width:60px;font-size:90% !important;" class="input-small barisqtyb cleared"></td>'+
									'<input type="hidden" name="qty_kcl[]" value="" style="width:50px;font-size:90% !important;" class="input-small barisqtyk cleared">'+
'<input type="hidden" name="jml_penerimaan[]" value="" style="width:50px;font-size:90% !important;" class="input-small barisqtyk cleared">'+
									'<td style="padding:0 !important;"><input style="text-align:right;" type="text" name="harga_beli[]" value="" style="width:60px !important;font-size:90% !important;" class="input-small barishargabeli cleared"></td>'+									
									'<td style="text-align:center;padding:0 !important;"><input type="checkbox" class="barisceklisupdate cleared" /></td>'+									
									//'<td style="padding:0 !important;"><input type="hidden" name="harga_avg[]" value="" style="width:80px !important;font-size:90% !important;" class="input-small barishargarata cleared" readonly></td>'+
									'<input type="hidden" name="harga_avg[]" value="" class="input-small barishargarata cleared" readonly>'+
									'<td style="padding:0 !important;"><input type="text" name="disc_prs[]" value="" style="width:40px;font-size:90% !important;" class="input-small barisdisc cleared"></td>'+
									'<input style="text-align:right;" type="hidden" name="harga_belidisc[]" value="" style="width:60px;font-size:90% !important;" class="input-small barishargabelidisc cleared" readonly>'+
									'<td style="padding:0 !important;"><input style="text-align:right;" type="text" name="isidiskon[]" value="" style="width:60px;font-size:90% !important;" class="input-small barisisidiskon cleared"></td>'+
									'<td style="padding:0 !important;"><input style="text-align:right;" type="text" name="jumlah1[]" value="" style="width:70px;font-size:90% !important;" class="input-small barisjumlah1 cleared" readonly></td>'+																		
									'<td style="padding:0 !important;"><input type="text" name="ppn_item[]" value="" style="width:40px;font-size:90% !important;" class="input-small barisppn cleared"></td>'+
									'<td style="padding:0 !important;"><input type="text" name="bonus[]" value="" style="width:50px;font-size:90% !important;" class="input-small barisbonus cleared"></td>'+
                                    '<td style="text-align:right;padding:0 !important;"><input style="text-align:right;" type="text" name="total[]" value="" style="width:20px;font-size:80% !important;" class="input-medium barisjumlah cleared" readonly></td>'+
									'<td><input type="hidden" name="update[]" value="0" class="input-mini barisisiupdate cleared"></td>'+
								'</tr>');
		
		$("#bodyinput tr:last input[name='nama_obat[]']").focus();
        $('#bodyinput tr').removeClass('focused'); 
        $("#bodyinput tr:last input[name='nama_obat[]']").parent().parent('tr').addClass('focused'); 
		
		$('.barisjumlah').change(function(){ 
            var totalpenerimaan=0; var total1=0;  var grandtotal=0;
			var materai=$('#materai').val();
			var discount=$('#discount').val();
			if(discount=='')discount=0;
			if(materai=='')materai=0;
           $('.barisjumlah').each(function(){
                var val=$(this).val(); 
                if(val=='')val=0;
                totalpenerimaan=totalpenerimaan+parseFloat(val); 
				total1=(parseFloat(materai)+parseFloat(totalpenerimaan))-parseFloat(discount);
            });
           $('#jumlahapprove').val(totalpenerimaan);
           $('#totalpenerimaan').val(totalpenerimaan.toFixed(2));
		   $('#jumlah').val(total1.toFixed(2));
		   
		   var subtotal=$('#totalpenerimaan').val();
		   if(subtotal=='')subtotal=0;
		   grandtotal=parseFloat(subtotal)-parseFloat(discount);
		   $('#grandtotal').val(grandtotal.toFixed(2));
        });
		
		$('.barisqtyb').change(function(){ 
            var val=$(this).val(); 
            if(val=='')val=0; 
            var pembanding=$('.focused').find('.barispembanding').val();
            var qtykecil=parseFloat(val) * parseFloat(pembanding); //ngupdate qty k
            $('.focused').find('.barisqtyk').val(qtykecil);
            jumlahharga();
            jumlahtotal();
            totaltransaksi();
            $('.focused').find('input[name="harga_beli[]"]').focus();

        });
		
		$('.barisisidiskon').change(function(){ 
            jumlahharga();
            jumlahtotal();
            totaltransaksi();
            $('.focused').find('input[name="ppn_item[]"]').focus();
        });
		
		$('.barisqtyb, .barishargabeli, .barisppn, .barisnamaobat, .baristanggal, .barisdisc, .barisppn, .barisceklisupdate, .barisisidiskon, .barisbatch').click(function(){  
                $('#bodyinput tr').removeClass('focused'); 
                $(this).parent().parent('tr').addClass('focused'); 
		})
		
		$('.barishargabeli').change(function(){  
			var val=$(this).val(); //harga beli  
			
			$('.focused').find('.barishargarata').val(parseFloat(val).toFixed(2));
            jumlahharga();
            jumlahtotal();
            totaltransaksi();
			$('.focused').find('input[name="disc_prs[]"]').focus();
		})

		
		$('.barisdisc').change(function(){  
			var val=$(this).val(); //disc
			var hargabeli=$('.focused').find('.barishargabeli').val(); //hargabeli
			var qtyk=$('.focused').find('.barisqtyk').val();
			if(val=='')val=0;
			if(hargabeli=='')hargabeli=0;
			if(qtyk=='')qtyk=0;
			var hargabelidiscount= (parseFloat(val)/100)*parseFloat(hargabeli)*parseFloat(qtyk);
			
			$('.focused').find('.barishargabelidisc').val(hargabelidiscount.toFixed(2));
			//$('.barisjumlah').trigger('change');
			jumlahharga();
			jumlahtotal();
			totaltransaksi();

			$('.focused').find('input[name="ppn_item[]"]').focus();
		})
		
		$('.barisppn').change(function(){  
			var val=$(this).val(); //ppn
			
            jumlahtotal();
            totaltransaksi();
			$('.barisjumlah').trigger('change');
			//$('.focused').find('input[name="total[]"]').focus();
		})
		
		$('.barisceklisupdate').click(function(){
			if($('.barisceklisupdate').is(':checked')){
			//console.log('dfd');
				$('.focused').find('.barisisiupdate').val(1);
			}
			else {
			//console.log('dsfd');
				$('.focused').find('.barisisiupdate').val(0);
			}
		})
		
		$('.barisjumlah').keyup(function(e){  
            if(e.keyCode == 13){ 
                $('#tambahbaris').trigger('click');
                return false;
            }
        });
		
	$('.barisnamaobat').keyup(function(e){ //didalam function tambah baris
		if(e.keyCode == 13){
			//alert('xx')
			$('.barisnamaobat').parent().parent('tr').removeClass('focused');
			$(this).parent().parent('tr').addClass('focused');

			$("#dataTable4").dataTable().fnDestroy();
			$('#dataTable4').dataTable( {
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/ambildaftarobatbynama/",
				"sServerMethod": "POST",
				"fnServerParams": function ( aoData ) {
				  aoData.push( { "name": "nama_obat", "value":""+$('.focused').find('.barisnamaobat').val()+""} );
				  aoData.push( { "name": "kd_unit_apt", "value": $("#kd_unit_apt").val() } );
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
            var totalpenerimaan=0; var total1=0; var grandtotal=0;
			var materai=$('#materai').val();
			if(materai=='') materai=0;
			var discount=$('#discount').val();
			if(discount=='')discount=0;
			
           $('.barisjumlah').each(function(){
                var val=$(this).val();
                if(val=='')val=0;
                //totalpenerimaan=totalpenerimaan+parseFloat(val);
				//total1=parseFloat(materai)+parseFloat(totalpenerimaan);
				totalpenerimaan=totalpenerimaan+parseFloat(val); 
				total1=(parseFloat(materai)+parseFloat(totalpenerimaan))-parseFloat(discount);
            });
           $('#jumlahapprove').val(totalpenerimaan);
           //$('#totalpenerimaan').val(addCommas(totalpenerimaan));
		   $('#totalpenerimaan').val(totalpenerimaan.toFixed(2));
		   $('#jumlah').val(total1.toFixed(2));
		   
		   var subtotal=$('#totalpenerimaan').val();
		   if(subtotal=='')subtotal=0;
		   grandtotal=parseFloat(subtotal)-parseFloat(discount);
		   $('#grandtotal').val(grandtotal.toFixed(2));
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
            var totalpenerimaan=0; var total1=0; var grandtotal=0;
			var materai=$('#materai').val();
			var discount=$('#discount').val();
			if(discount=='')discount=0;
			if(materai=='')materai=0;
           $('.barisjumlah').each(function(){
                var val=$(this).val(); 
                if(val=='')val=0;
                totalpenerimaan=totalpenerimaan+parseFloat(val); 
				total1=(parseFloat(materai)+parseFloat(totalpenerimaan))-parseFloat(discount);
            });
           $('#jumlahapprove').val(totalpenerimaan);
           $('#totalpenerimaan').val(totalpenerimaan.toFixed(2));
		   $('#jumlah').val(total1.toFixed(2));
		   
		   var subtotal=$('#totalpenerimaan').val();
		   if(subtotal=='')subtotal=0;
		   grandtotal=parseFloat(subtotal)-parseFloat(discount);
		   $('#grandtotal').val(grandtotal.toFixed(2));
        });
		
		$('.barisqtyb').change(function(){ 
            var val=$(this).val(); 
            if(val=='')val=0; 
            var pembanding=$('.focused').find('.barispembanding').val();
            var qtykecil=parseFloat(val) * parseFloat(pembanding); //ngupdate qty k
            $('.focused').find('.barisqtyk').val(qtykecil);
            jumlahharga();
            jumlahtotal();
            totaltransaksi();
            $('.focused').find('input[name="harga_beli[]"]').focus();

        });
		
		$('.barisisidiskon').change(function(){ 
			jumlahharga();
			jumlahtotal();
			totaltransaksi();
			$('.focused').find('input[name="ppn_item[]"]').focus();
		});
		
		$('.barisqtyb, .barishargabeli, .barisppn, .barisnamaobat, .baristanggal, .barisdisc, .barisppn, .barisceklisupdate, .barisisidiskon, .barisbatch').click(function(){  
                $('#bodyinput tr').removeClass('focused'); 
                $(this).parent().parent('tr').addClass('focused'); 
		})
		
		$('.barishargabeli').change(function(){  
			var val=$(this).val(); //harga beli  
			
			$('.focused').find('.barishargarata').val(parseFloat(val).toFixed(2));
            jumlahharga();
            jumlahtotal();
            totaltransaksi();
			$('.focused').find('input[name="disc_prs[]"]').focus();
		})

		
		$('.barisdisc').change(function(){  
			var val=$(this).val(); //disc
			var hargabeli=$('.focused').find('.barishargabeli').val(); //hargabeli
			var qtyk=$('.focused').find('.barisqtyk').val();
			
			if(val=='')val=0;
			if(hargabeli=='')hargabeli=0;
			if(qtyk=='')qtyk=0;
			
			var hargabelidiscount= (parseFloat(val)/100)*parseFloat(hargabeli)*parseFloat(qtyk);
			
			$('.focused').find('.barishargabelidisc').val(hargabelidiscount.toFixed(2));
			//$('.barisjumlah').trigger('change');
			jumlahharga();
			jumlahtotal();
			totaltransaksi();

			$('.focused').find('input[name="ppn_item[]"]').focus();
		})
		
		$('.barisisidiskon').change(function(){ 
			jumlahharga();
			jumlahtotal();
			totaltransaksi();
			$('.focused').find('input[name="ppn_item[]"]').focus();
		});
		
		$('.barisppn').change(function(){  
			var val=$(this).val(); //ppn
			
            jumlahtotal();
            totaltransaksi();
			$('.barisjumlah').trigger('change');
			//$('.focused').find('input[name="total[]"]').focus();
		})
	
	$('.bariskodeobat').keydown(function(e){
            if(e.keyCode==13){
                $(this).focus();
                return false;
            }
    });
	
	
		
	$('#kd_supplier').keyup(function(e){
		if(e.keyCode == 13){
            $.ajax({
                url: '<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/ambilsupplierbykode/',
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
                url: '<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/ambilsupplierbynama/',
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
	
	$('#isipesan').keyup(function(e){
		if(e.keyCode == 13){
		
            $.ajax({
                url: '<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/ambilpemesananbykode/',
                async:false,
                type:'get',
				data:{query:$(this).val(),tes:$('#kd_supplier').val()},
                //data:{query:$(this).val()},
                success:function(data){
                //typeahead.process(data)
					$('#listpesan').empty();
					$.each(data,function(i,l){
						//alert(l);
						//$('#listpesan').append('<tr><td><input type="checkbox" class="ceklis" name="ceklis" value="'+l.no_pemesanan+'"/></td><td style="text-align:center;">'+l.no_pemesanan+'</td><td style="text-align:center;">'+l.tgl_pemesanan+'</td><td>'+l.nama+'</td><td><a class="btn" onclick=\'pilihpesanan("'+l.no_pemesanan+'","'+l.tgl_pemesanan+'","'+l.nama+'")\'>Pilih</a></td></tr>');
						$('#listpesan').append('<tr><td><input type="checkbox" class="ceklis" name="ceklis" value="'+l.no_pemesanan+'"/></td><td style="text-align:center;">'+l.no_pemesanan+'</td><td style="text-align:center;">'+l.tgl_pemesanan+'</td><td>'+l.nama+'</td></tr>');						
					});    
                },
                dataType:'json'                         
            }); 
            $('#daftarpesan').modal("show");
		}
		var ex = document.getElementById('dataTable3');
        if ( ! $.fn.DataTable.fnIsDataTable( ex ) ) {
            $('#dataTable3').dataTable({
                "sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
				"sPaginationType": "bootstrap",
                "oLanguage": {
					"sLengthMenu": "Show _MENU_ entries"
                }
            });
            var oTable = $('#dataTable3').dataTable();
            $('#isipesan1').keyup(function(e){
				oTable.fnFilter( $(this).val() );
                if(e.keyCode == 13){
                    //alert('xx')
                    return false;
                }
            });
        }
	});
	
	$('.barisceklisupdate').click(function(){
		if($('.barisceklisupdate').is(':checked')){
			$('.focused').find('.barisisiupdate').val(1);
		}
		else {
			$('.focused').find('.barisisiupdate').val(0);
		}
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
