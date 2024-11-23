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
#listobat6 .ui-selecting, #listobat6 .ui-selecting { background: #FECA40; }
#listobat6 .ui-selected, #listobat6 .ui-selected { background: #F39814; color: white; }
#listobat6, #listobat6 { list-style-type: none; margin: 0; padding: 0; width: 60%; }
#listobat6 li, #listobat6 li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px; }

#listdokter .ui-selecting, #listdokter .ui-selecting { background: #FECA40; }
#listdokter .ui-selected, #listdokter .ui-selected { background: #F39814; color: white; }
#listdokter { list-style-type: none; margin: 0; padding: 0; width: 60%; }
#listdokter li, #listdokter li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px; }
</style>
<script>
$(function() {
    $( "#listobat" ).selectable({});
    $( "#listobat6" ).selectable({});
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
	Mousetrap.bindGlobal('ctrl+r', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptdisposal/tambahdisposal'; return false;});
	//Mousetrap.bindGlobal('f4', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptpemesanan'; return false;});
	
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


    Mousetrap.bind('a', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'a'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('b', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'b'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('c', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'c'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('d', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'d'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('e', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'e'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('f', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'f'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('g', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'g'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('h', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'h'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('i', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'i'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('j', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'j'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('k', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'k'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('l', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'l'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('m', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'m'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('n', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'n'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('o', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'o'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('p', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'p'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('q', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'q'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('r', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'r'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('s', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'s'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('t', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'t'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('u', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'u'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('v', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'v'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('w', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'w'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('x', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'x'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('y', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'y'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('z', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'z'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('space', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+' '); $('.focused .barisnamaobat').focus(); } return false; });
    //Mousetrap.bind('esc', function(e) { $('#tesxx').hide(); });
    //Mousetrap.bind('tab', function(e) { if($('#tesxx').is(':visible')){ $('#tesxx').hide(); } return false; });

    Mousetrap.bindGlobal(['esc','tab'], function() {

        $('#tesxx').hide();
        $( ".barisnamaobat" ).blur();
        setTimeout(function(){
            $( ".barisnamaobat" ).focus();
        }, 500);
    });

	Mousetrap.bindGlobal(['down','right'], function() {

        /* if($('#daftarobat').is(':visible')){    
            if($("#listobat .ui-selected").next().is('tr')){
				$('#modal-body-daftarobat').scrollTop($('#modal-body-daftarobat').scrollTop()+45);
				SelectSelectableElement($("#listobat"), $(".ui-selected").next('tr'));
            }else{
                return false;
            }
        }
 */
        if($('#tesxx').is(':visible')){    
            if($("#listobat6 .ui-selected").next().is('tr')){
               
                SelectSelectableElement($("#listobat6"), $(".ui-selected").next('tr'));
                $('.barisnamaobat').trigger('blur');
            }else{
                return false;
            }
        }		
        
      
		
    });
	
	Mousetrap.bindGlobal(['up','left'], function() {
        /* if($('#daftarobat').is(':visible')){ 
            if($("#listobat .ui-selected").prev().is('tr')){
				$('#modal-body-daftarobat').scrollTop($('#modal-body-daftarobat').scrollTop()-45);
				SelectSelectableElement($("#listobat"), $(".ui-selected").prev('tr'));
            }else{
                return false;
            }
        } */

        if($('#tesxx').is(':visible')){    
            if($("#listobat6 .ui-selected").prev().is('tr')){
                SelectSelectableElement($("#listobat6"), $(".ui-selected").prev('tr'));
                $('.barisnamaobat').trigger('blur');
            }else{
                return false;
            }
        }       

		
		

    });
	
    Mousetrap.bindGlobal('enter', function(e) { 
        //if (e.preventDefault) {
        //    e.preventDefault();
        //} else {
            // internet explorer
        //    e.returnValue = false;
        //}
        
        if($('#daftarobat').is(':visible')){
            $('#daftarobat').find('.ui-selected').find('.btn').trigger('click');
            return false;
        }

        if($('#tesxx').is(':visible')){
            $('#tesxx').find('.ui-selected').find('.btn').trigger('click');
            return false;
        }
      
        return false;
       // alert('x');
        //return false;
    });
	
</script>

<script type="text/javascript">

    $(document).ready(function() {
		$('#keterangan').focus();
        $('#form').ajaxForm({
            beforeSubmit: function(a,f,o) {
                o.dataType = "json";
                $('div.error').removeClass('error');
                $('span.help-inline').html('');
                $('#progress').show();
                $('body').append('<div id="overlay1" style="position: fixed;height: 100%;width: 100%;z-index: 1000000;"></div>');
                $('body').addClass('body1');
                var urlnya="<?php echo base_url(); ?>index.php/transapotek/aptdisposal/periksadisposal"; //buat validasi inputan
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
                    $('#no_disposal').val(data.no_disposal);
                    $('#btn-cetak').removeAttr('disabled');
                    $('#btn-cetak').attr('href','<?php echo base_url() ?>third-party/fpdf/buktidisposal.php?no_disposal='+data.no_disposal+'');
                    //$('#btn-tutuptrans').removeAttr('disabled');
                    if(parseInt(data.keluar)>0){
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptdisposal';
                    }
					if(parseInt(data.posting)==1){
                        $('#btn-tutuptrans').attr('value','bukatrans');
                        $('#btn-tutuptrans').text('Buka Trans');
                        //$('#btn-bayar').removeAttr('disabled');
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptdisposal/ubahdisposal/'+data.no_disposal;
                    }
                    if(parseInt(data.posting)==2){
                        //$('#btn-bayar').attr('disabled');                        
                        $('#btn-tutuptrans').attr('value','tutuptrans');
                        $('#btn-tutuptrans').text('Tutup Trans');
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptdisposal/ubahdisposal/'+data.no_disposal;
                    }
					if(parseInt(data.posting)==3){
						 window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptdisposal/ubahdisposal/'+data.no_disposal;
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
                        <?php
                        if(empty($itemsdetiltransaksi)){
                        ?>
                        <form class="form-horizontal" method="get" post="<?=base_url('transapotek/aptdisposal/tambahdisposal')?>">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <div class="accordion-body collapse in body">
                                            <input type="text" id="hari" name="hari" class="input-small input-tooltip" value="<?php echo $hari ?>" data-original-title="Jumlah hari sebelum obat kadaluarsa" data-placement="bottom"/>&nbsp;hari lagi
                                            <button type="submit">Cari </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php
                        }
                        ?>                          
                      <!--BEGIN INPUT TEXT FIELDS-->
						<form class="form-horizontal"  id="form" method="POST" action="<?php echo base_url() ?>index.php/transapotek/aptdisposal/simpandisposal">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header class="top" style="">
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>DISPOSAL OBAT</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/aptdisposal/"> <i class="icon-list"></i> Daftar / (F4)</a></li>
													<li><a target="_blank" class="btn" id="btn-cetak" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php if(!empty($no_disposal)){ echo base_url() ?>third-party/fpdf/buktidisposal.php?no_disposal=<?php echo $no_disposal;} else echo '#'; ?>" <?php if(empty($no_disposal)){ ?>disabled<?php } ?>> <i class="icon-print"></i> Cetak</a></li>													                                                    
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/aptdisposal/tambahdisposal"> <i class="icon-plus"></i> Tambah / (Ctrl+R)</a></li>
                                                    <li><button <?php if($this->mdisposal->isPosted($no_disposal))echo "disabled"; ?> class="btn" id="simpan" type="submit"  name="submit" value="simpan"> <i class="icon-save"></i> Simpan / (Ctrl+S)</button></li>
                                                    <?php
                                                    if($this->mdisposal->isPosted($no_disposal)){
                                                    ?>
                                                    <li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="bukatrans" <?php if(empty($no_disposal)){ ?>disabled<?php } ?>> <i class="icon-key"></i> Buka Trans.</button></li>
                                                    <?php
                                                    }else{
                                                    ?>
                                                    <li><button class="btn" id="btn-tutuptrans" type="submit" name="submit" value="tutuptrans" <?php if(empty($no_disposal)){ ?>disabled<?php } ?>> <i class="icon-key"></i> Tutup Trans.</button></li>
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
													<div class="span7">
														<div class="control-group">
															<label for="no_disposal" class="control-label">No. Disposal </label>
															<div class="controls with-tooltip">
																<input type="text" name="no_disposal" id="no_disposal" value="<?php echo $no_disposal; ?>" readonly class="span3 input-tooltip" data-original-title="no disposal" data-placement="bottom"/>
																<span class="help-inline"></span>
																<input type="hidden" name="jam" id="jam" value="<?php echo date('h:i:s'); ?>" data-mask="99:99:99" class="input-small"/>
																<input type="hidden" id="jam1" name="jam1" value="<?php if(isset($itemtransaksi['jamdisposal']))echo $itemtransaksi['jamdisposal'] ?>" class="input-small" data-original-title="jam disposal" data-placement="bottom"/>
																<span class="help-inline"></span>
																Tgl. Disposal <input <?php if($this->mdisposal->isPosted($no_disposal))echo "readonly"; ?> type="text" name="tanggal" id="tanggal" class="input-small input-tooltip cleared" data-original-title="tanggal" data-mask="99-99-9999" value="<?php if(empty($itemtransaksi['tanggal']))echo date('d-m-Y'); else echo convertDate($itemtransaksi['tanggal']);  ?>" data-placement="bottom"/>
																<span class="help-inline"></span>
																Approve <input type="checkbox" id="approval" name="approval" value="1" <?php echo set_checkbox('approval','1',isset($itemtransaksi['approval'])&& $itemtransaksi['approval']=='1' ? true:false); ?> disabled />
															</div>
														</div>
													</div>													
												</div>
											</div>
											<div class="row-fluid">
												<div class="span12">
													<div class="span7">
														<div class="control-group">
															<label for="keterangan" class="control-label">Keterangan </label>
															<div class="controls with-tooltip">
																<input <?php if($this->mdisposal->isPosted($no_disposal))echo "readonly"; ?> type="text" id="keterangan" name="keterangan" value="<?php if(isset($itemtransaksi['keterangan']))echo $itemtransaksi['keterangan'] ?>" class="span11 input-tooltip cleared" data-original-title="keterangan" data-placement="bottom"/>
																<span class="help-inline"></span>																
															</div>
														</div>
													</div>
												</div>
													<div id="progress" style="display:none;"></div>
											</div>																					 																						
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <div class="span7">
                                                        <div class="control-group">
                                                            <label for="keterangan" class="control-label">Status </label>
                                                            <div class="controls with-tooltip">
                                                                <select name="status" id="status">
                                                                    <option value="0" <?php if(isset($itemtransaksi['status']) && $itemtransaksi['status']==0) echo "selected=selected"; ?>>Expire</option>
                                                                    <option value="1" <?php if(isset($itemtransaksi['status']) && $itemtransaksi['status']==1) echo "selected=selected"; ?>>Rusak</option>
                                                                </select>
                                                                <span class="help-inline"></span>                                                               
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
															<li><button <?php if($this->mdisposal->isPosted($no_disposal))echo "disabled"; ?> class="btn" type="button" id="tambahbaris"> <i class="icon-plus"></i> Tambah Obat (Ctrl+B)</button></li>
															<li><button <?php if($this->mdisposal->isPosted($no_disposal))echo "disabled"; ?> class="btn" type="button" id="hapusbaris"> <i class="icon-remove"></i> Hapus Obat</button></li>
														</ul>
													</div>
												<!-- /.toolbar -->
												</header>
												<div class="body collapse in" id="defaultTable">
													<table class="table responsive">
														<thead>
															<tr style="font-size:90% !important;">
																<th class="header">&nbsp;</th>
																<th class="header">Sumber Dana</th>
																<th class="header">Kode Obat</th>
																<th class="header">Nama Obat</th>
																<th class="header">Satuan</th>
																<th class="header">Tgl.Expire</th>
																<th class="header">Qty</th>
																<th class="header">Keterangan</th>
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
																			<td style="text-align:center;">
																				<select <?php if($this->mdisposal->isPosted($no_disposal))echo "readonly"; ?> class="input-large  bariskdunitapt cleared" name="kd_unit_apt[]" id="kd_unit_apt">
		 				 															<option value="">Pilih Sumber Dana</option>
		 				 															<?php foreach ($dataunit as $dtunit){ 				
		 				 																$select="";
																						if(isset($itemdetil['kd_unit_apt'])){    
                                                                            				if($itemdetil['kd_unit_apt']==$dtunit['kd_unit_apt'])$select="selected=selected";else $select="";
                                                                        				}
																					?>
																					<option value="<?php if(!empty($dtunit)) echo $dtunit['kd_unit_apt'] ?>" <?php echo $select; ?>><?php echo $dtunit['nama_unit_apt'] ?></option>
																					<?php
																						}
																					?>
																			</td>
																			<td><input <?php if($this->mdisposal->isPosted($no_disposal))echo "readonly"; ?> type="text" name="kd_obat[]" value="<?php echo $itemdetil['kd_obat1'] ?>" style="width:150px;" class="input-small bariskodeobat cleared"></td>
																			<td><input <?php if($this->mdisposal->isPosted($no_disposal))echo "readonly"; ?> type="text" name="nama_obat[]" value="<?php echo $itemdetil['nama_obat'] ?>" style="font-size:90% !important;" class="input-large barisnamaobat cleared"></td>
																			<td><input <?php if($this->mdisposal->isPosted($no_disposal))echo "readonly"; ?> type="text" name="satuan_kecil[]" value="<?php echo $itemdetil['satuan_kecil'] ?>" style="width:100px;" class="input-medium barissatuan cleared" readonly></td>
																			<td><input <?php if($this->mdisposal->isPosted($no_disposal))echo "readonly"; ?> style="text-align:center;" type="text" name="tgl_expire[]" value="<?php echo $itemdetil['tgl_expire'] ?>" class="input-small baristanggal cleared" readonly></td>
																			<td><input <?php if($this->mdisposal->isPosted($no_disposal))echo "readonly"; ?> style="text-align:right;" type="text" name="qty[]" value="<?php echo $itemdetil['qty'] ?>" style="width:50px;font-size:90% !important;" class="input-small barisqty cleared"></td>
																			<td><input <?php if($this->mdisposal->isPosted($no_disposal))echo "readonly"; ?> style="width:300px;font-size:90% !important;" type="text" name="ket_grid[]" value="<?php echo $itemdetil['keterangan'] ?>" class="input-xlarge barisketerangan cleared"></td>
                                                                            <input type="hidden" name="harga_pokok[]"  value="<?php echo $itemdetil['harga_pokok'] ?>" class="input-medium barisharga cleared">
                                                                            <input type="hidden" name="kode_pabrik[]"  value="<?php echo $itemdetil['kd_pabrik'] ?>" class="input-mini bariskodepabrik cleared">
                                                                            <input type="hidden" name="batch[]"  value="<?php echo $itemdetil['batch'] ?>" class="input-medium barisbatch cleared">
																			<td><input style="text-align:right;" type="hidden" name="jml_stok[]" value="<?php echo $itemdetil['jml_stok'] ?>" style="width:50px;font-size:90% !important;" class="input-small barisstok cleared"></td>
																		</tr>
																	<?php
																		//$no++;
																	}
																}
															?>


                                                            <?php
                                                                if(isset($items)){
                                                                    //$no=1;
                                                                    foreach ($items as $item){                                                                           
                                                                    ?>
                                                                        <tr style="font-size:90% !important;">
                                                                            <td><input type="checkbox" class="barisinput" /></td>                                                                           
                                                                            <td style="text-align:center;">
                                                                                <select class="input-large  bariskdunitapt cleared" name="kd_unit_apt[]" id="kd_unit_apt">
                                                                                    <option value="">Pilih Sumber Dana</option>
                                                                                    <?php foreach ($dataunit as $dtunit){               
                                                                                        $select="";
                                                                                        if(isset($item['kd_unit_apt'])){    
                                                                                            if($item['kd_unit_apt']==$dtunit['kd_unit_apt'])$select="selected=selected";else $select="";
                                                                                        }
                                                                                    ?>
                                                                                    <option value="<?php if(!empty($dtunit)) echo $dtunit['kd_unit_apt'] ?>" <?php echo $select; ?>><?php echo $dtunit['nama_unit_apt'] ?></option>
                                                                                    <?php
                                                                                        }
                                                                                    ?>
                                                                            </td>
                                                                            <td><input type="text" name="kd_obat[]" value="<?php echo $item['kd_obat'] ?>" style="width:150px;" class="input-small bariskodeobat cleared"></td>
                                                                            <td><input type="text" name="nama_obat[]" value="<?php echo $item['nama_obat'] ?>" style="font-size:90% !important;" class="input-large barisnamaobat cleared"></td>
                                                                            <td><input type="text" name="satuan_kecil[]" value="<?php echo $item['satuan_kecil'] ?>" style="width:100px;" class="input-medium barissatuan cleared" readonly></td>
                                                                            <td><input style="text-align:center;" type="text" name="tgl_expire[]" value="<?php echo $item['tgl_expire'] ?>" class="input-small baristanggal cleared" readonly></td>
                                                                            <td><input style="text-align:right;" type="text" name="qty[]" value="<?php echo $item['jml_stok'] ?>" style="width:50px;font-size:90% !important;" class="input-small barisqty cleared"></td>
                                                                            <td><input style="width:300px;font-size:90% !important;" type="text" name="ket_grid[]" value="" class="input-xlarge barisketerangan cleared"></td>
                                                                            <input type="hidden" name="harga_pokok[]"  value="<?php echo $item['harga_pokok'] ?>" class="input-medium barisharga cleared">
                                                                            <input type="hidden" name="kode_pabrik[]"  value="<?php echo $item['kd_pabrik'] ?>" class="input-mini bariskodepabrik cleared">
                                                                            <input type="hidden" name="batch[]"  value="<?php echo $item['batch'] ?>" class="input-medium barisbatch cleared">
                                                                            <td><input style="text-align:right;" type="hidden" name="jml_stok[]" value="<?php echo $item['jml_stok'] ?>" style="width:50px;font-size:90% !important;" class="input-small barisstok cleared"></td>
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
<div style="display:none;position: absolute !important;right: 0;bottom: 0 !important;z-index:99999999999 !important;" id="tesxx" class=" ui-widget-content draggable">
            <table id="dataTable6" class="table table-bordered " style="background:white !important;">
                <thead>
                    <tr>                        
                        <th style="text-align:center;">Kode Obat</th>
                        <th style="text-align:center;">Nama Obat</th>
                        <th style="text-align:center;">Satuan</th>
                        <th style="text-align:center;">Tgl. Expire</th>
                        <th style="text-align:center;">Batch</th>
                        <th style="text-align:center;">Pabrik</th>
                        <th style="text-align:center;">Harga</th>
                        <th style="text-align:center;">Stok</th>
                        <th style="width:50px !important;">Pilihan</th>
                    </tr>
                </thead>
                <tbody id="listobat6">

                </tbody>
            </table>
</div>
			
<div aria-hidden="true" aria-labelledby="helpModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="daftarobat" style="display: none;width:70%;margin-left:-500px !important;"> 
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Obat Karantina</h3>
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
						<th>Jml<br>Karantina</th>                     
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
	
	$('#tanggal').datepicker({
        format: 'dd-mm-yyyy'
    });
	
    function pilihobat(kd_obat,nama_obat,satuan_kecil,tgl_expire,harga_jual,jml_stok,min_stok,kd_pabrik,batch) {
        var batal=0;
        /*$('.bariskodeobat').each(function(){
                var val=$(this).val();
                var expire=$(this).parent().parent().find('.baristanggal').val();
                console.log(expire);
                if(val==kd_obat && expire==tgl_expire){
                    $('#error').html('<div class="alert alert-error fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>Obat sudah di input</div>');
                    throw 'Obat sudah di input';
                }
        });*/
        var tgl_penjualan = $('#tgl_penjualan').val();
        $('.focused').find('.bariskodeobat').val(kd_obat);
        $('.focused').find('.barisnamaobat').val(nama_obat);
        $('.focused').find('.barissatuan').val(satuan_kecil);
        $('.focused').find('.baristanggal').val(tgl_expire);
        $('.focused').find('.barisharga').val(harga_jual);
        $('.focused').find('.barisstok').val(jml_stok);
        $('.focused').find('.bariskodepabrik').val(kd_pabrik);
        $('.focused').find('.barisbatch').val(batch);
        $('.focused').find('.barisminstok').val(min_stok);
        $('.focused').find('.baristglkeluar').val(tgl_penjualan);
        //$('#daftarobat').modal("hide");
        //$('.barisqty').trigger('change');
        //$('.barisjumlah').trigger('change');
        console.log(batch);
        $('#tesxx').hide();
        $('.focused').find('input[name="harga_jual[]"]').focus();
        $('#tesxx').hide();
        return false;
    }

	$('#tambahbaris').click(function(){
        if($('.bariskodeobat').length>0){
            $('.barisnamaobat').each(function(){
                var val=$(this).val(); 
                if(val==''){
                    alert('Nama obat tidak boleh kosong');
                    e.stopImmediatePropagation();
                    return false;
                }
            });
        }

		 var  sumberdana='<td><select  class="input-large  bariskdunitapt cleared" name="kd_unit_apt[]" id="kd_unit_apt">' +
		 				 '<option value="">Pilih Sumber Dana</option>';
		if($('.bariskodeobat').length>0){
            $('.barisstok').each(function(){
				var val=$(this).val(); 
				var minstok=$('.focused').find('.barisminstok').val();
				var nama_obat=$('.focused').find('.barisnamaobat').val();
				if(parseFloat(minstok)==parseFloat(val)){
                    alert('Obat '+nama_obat+' telah mencapai batas minimum stok !');
                }				
            });

        }

		$.ajax({

		 url: '<?php echo base_url() ?>index.php/transapotek/penjualan/sumberdana/',
		 async:false,
		 type:'get',
		 //data:{},
		 success:function(data){
			
		     $.each(data,function(i,l){
		         if(l.kd_unit_apt=='D02')
		             selected='selected=selected';
		         else
		             selected='';
		         sumberdana=sumberdana + '<option  value="'+l.kd_unit_apt+'" '+selected+'>'+l.nama_unit_apt+'</option>';
		     });    
		 },
		 dataType:'json'                         
		}); 
		sumberdana=sumberdana + '</select></td>';

		$('#bodyinput').append('<tr style="font-size:80% !important;"><td><input type="checkbox" class="barisinput cleared" /></td>'+
									sumberdana+
									'<td><input type="text" name="kd_obat[]" value="" style="" class="input-small bariskodeobat cleared"></td>'+
									'<td><input type="text" name="nama_obat[]" value="" style="font-size:90% !important;" class="input-xlarge barisnamaobat cleared"></td>'+
                                    '<td><input type="text" name="satuan_kecil[]" value="" style="width:100px;" class="input-medium barissatuan cleared" readonly></td>'+
									'<td><input style="text-align:center;" type="text" name="tgl_expire[]" value="" class="input-small baristanggal cleared" readonly></td>'+
									'<td><input style="text-align:right;" type="text" name="qty[]" value="" style="width:50px;font-size:90% !important;" class="input-small barisqty cleared"></td>'+
									'<td><input style="width:300px;font-size:90% !important;" type="text" name="ket_grid[]" value="" class="input-large barisketerangan cleared"></td>'+
                                    '<input type="hidden" name="harga_pokok[]"  value="" class="input-medium barisharga cleared">'+
                                    '<input type="hidden" name="kode_pabrik[]" value="" class="input-mini bariskodepabrik cleared">'+
                                    '<input type="hidden" name="batch[]" value="" class="input-medium barisbatch cleared">'+
						'<td><input style="text-align:right;" type="hidden" name="jml_stok[]" value="" style="width:50px;font-size:90% !important;" class="input-small barisstok cleared"></td>'+
                                '</tr>');
		
		$("#bodyinput tr:last input[name='kd_obat[]']").focus();

           var xw=$(this);
            if(xw.val()!=""){
                $('#tesxx').show();
                
                function position() {
                    $( "#tesxx" ).position({
                        of: xw,
                        my: "left top",
                        at: "left bottom",
                        collision:"fit fit"
                        });
                }
                position();

            }

        $(function() {
            $( "#tesxx" ).draggable();
        });

        $('#bodyinput tr').removeClass('focused'); 
        $("#bodyinput tr:last input[name='nama_obat[]']").parent().parent('tr').addClass('focused'); 
		
		$('.barisqty, .barisnamaobat, .bariskodeobat, .barisketerangan, .baristanggal').click(function(){  
                $('#bodyinput tr').removeClass('focused'); 
                $(this).parent().parent('tr').addClass('focused'); 
		})
		
        $('.barisketerangan').keyup(function(e){
            if(e.keyCode == 13){
                //alert('xx')
                $('#tambahbaris').trigger('click');
                return false;
            }
        });

        $('.barisqty').keyup(function(e){
            if(e.keyCode == 13){
                //alert('xx')
                $('.barisketerangan').focus();
                return false;
            }
        });

        $('.barisnamaobat').keyup(function(e){
            if(e.keyCode == 13){
                //$('.focused').find('.barisracik').focus();
                return false;
            }
        });
		
		$('.barisnamaobat').keyup(function(e){


           // if(e.keyCode == 13){
                //alert('xx')
                $('.barisnamaobat').parent().parent('tr').removeClass('focused');
                $(this).parent().parent('tr').addClass('focused');

                $("#dataTable6").dataTable().fnDestroy();
                $('#dataTable6').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptdisposal/ambildaftarobatbynama/",
					"sServerMethod": "POST",
                    "fnServerParams": function ( aoData ) {
                      aoData.push( { "name": "nama_obat", "value":""+$('.focused').find('.barisnamaobat').val()+""} );
                      aoData.push( { "name": "kd_unit_apt", "value":""+$('.focused').find('.bariskdunitapt').val()+""} );
                     // aoData.push( { "name": "kd_unit_apt", "value": $("#kd_unit_apt").val() } );
                    }
                    
                } );
				$('#dataTable6').css('width','100%');
                //$('#daftarobat').modal("show");
                    var check = function(){
                        if($('#listobat6 tr').length >0 && !$('#listobat6 tr').hasClass('ui-selected')){
                            // run when condition is met
                            $('#listobat6 tr:first').addClass('ui-selected');
                        }
                        else {
                            setTimeout(check, 1000); // check again in a second
                        }
                    }
                    check();     
            //}
            var xw=$(this);
            if(xw.val()!=""){
                $('#tesxx').show();
                
                function position() {
                    $( "#tesxx" ).position({
                        of: xw,
                        my: "left top",
                        at: "left bottom",
                        collision:"fit fit"
                        });
                }
                position();

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
                    "sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptdisposal/ambildaftarobatbykode/",
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
	
        $('.barisqty').keyup(function(e){
            if(e.keyCode == 13){
                //alert('xx')
                $('.barisketerangan').focus();
                return false;
            }
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
	
	$('.barisketerangan').keyup(function(e){
            if(e.keyCode == 13){
                //alert('xx')
                $('#tambahbaris').trigger('click');
                return false;
            }
    });
		
		$('.barisqty, .barisnamaobat, .bariskodeobat, .barisketerangan, .baristanggal').click(function(){  
                $('#bodyinput tr').removeClass('focused'); 
                $(this).parent().parent('tr').addClass('focused'); 
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
                    "sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptdisposal/ambildaftarobatbynama/",
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
                    "sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/aptdisposal/ambildaftarobatbykode/",
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
	
	$('#jam').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
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