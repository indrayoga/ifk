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
	function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
		 
		return false;
		return true;
	}
	
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
                    $.ajax({
                    url: "<?php echo base_url(); ?>index.php/masterapotek/bmhpobat/periksa",
                    type:"POST",
                    async: false,
                    data: $.param(a),
                    success: function(data){
                        //alert(data.status);
                        if(parseInt(data.status)==1){
                            z=data.status;
                            //alert('aa');
                            //alert($('input[name="harga"]').val());
							/*$('#kd_dokter').val(data.kd_dokter);
							if(parseInt(data.posting)==1){
								alert('aish');
								 window.location.href='<?php echo base_url(); ?>index.php/master/dokter/edit/'+data.kd_dokter;
							}*/
                        }else if(parseInt(data.status)==0){
                            //alert('xxx');
                            $('#progress').hide();
                            $('body').removeClass('body1');
                            z=data.status;
                            for(yangerror=0;yangerror<=data.error;yangerror++){
                            //  alert(data.id[yangerror]);
                                $('#'+data.id[yangerror]).siblings('.help-inline').html('<p class="text-error">'+data.pesan[yangerror]+'</p>');
                                $('#error').html('<div class="alert alert-error fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>Terdapat beberapa kesalahan input silahkan cek inputan anda</div>');
                            }
                            $('#error').html('<div class="alert alert-error fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>'+data.pesanatas+'<br/>'+data.pesanlain+'</div>');
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
                        //$('#kd_kabupaten').val('');
                        //$('#kabupaten').val('');
                    }
                    else if(parseInt(data.status)==0) //jika gagal
                    {
                        //apa yang terjadi jika gagal
                        $('#progress').hide();
                        $('#overlay1').remove();
                        $('body').removeClass('body1');
                        $('body').removeClass('body1');
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
							<form class="form-horizontal" id="form" method="post" action="<?php echo base_url()?>index.php/masterapotek/bmhpobat/simpan">
								<div class="row-fluid">
									<div class="span12">
										<div class="box">
											<header>
												<div class="icons"><i class="icon-edit"></i></div>
												<h5>ENTRY BMHP OBAT</h5>
												<!-- .toolbar -->
												<div class="toolbar" style="height:auto;">
													<ul class="nav nav-tabs">
														<!--li><a href="<-?php echo base_url() ?>index.php/master/dokterunit/"> <i class="icon-list"></i> Tambah Baru</a></li-->
														<!--li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<-?php echo base_url() ?>index.php/master/dokterunit/"> <i class="icon-plus"></i> Tambah Baru</a></li-->                                                    
														<li><button class="btn" id="simpan" type="submit"  name="submit" value="simpan"> <i class="icon-save"></i> Simpan / Ctrl+S</button></li>
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
																<label for="kd_pelayanan" class="control-label">Pelayanan BMHP</label>
																<div class="controls with-tooltip">
																	<select name="kd_pelayanan" id="kd_pelayanan" class="input-xlarge" onchange="javascript:window.location.href='<?php echo base_url() ?>index.php/masterapotek/bmhpobat/index/'+this.value">
																		<option value="">Pilih Pelayanan</option>
																		<?php

																		foreach ($databmhp as $bmhp) {
																			# code...
																			if($kode==$bmhp['kd_pelayanan'])$sel="selected=selected"; else $sel="";
																		?>
																		<option value="<?php echo $bmhp['kd_pelayanan'] ?>" <?php echo $sel; ?>><?php echo $bmhp['nama_pelayanan'] ?></option>
																		<?php
																		}
																		?>
																	</select>
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
																<li><button class="btn" type="button" id="tambahbaris"> <i class="icon-plus"></i> Tambah Obat / Ctrl+B</button></li>
																<li><button class="btn" type="button" id="hapusbaris"> <i class="icon-remove"></i> Hapus Obat</button></li>
															</ul>
														</div>
													<!-- /.toolbar -->
													</header>
													<div class="body collapse in" id="defaultTable">
														<table class="table responsive">
															<thead>
																<tr>
																	<th class="header">&nbsp;</th>
																	<th class="header">Kd. Obat</th>
																	<th class="header">Nama Obat</th>
																	<th class="header">Satuan</th>
																	<th class="header">Qty</th>
																</tr>
															</thead>
															<tbody id="bodyinput">
																<?php
																	if(isset($detilbmhp)){
																		foreach ($detilbmhp as $detil){																			
																		?>
																			<tr>
																				<td><input type="checkbox" class="barisinput" /></td>
																				<td><input type="text" name="kd_obat[]" value="<?php echo $detil['kd_obat'] ?>" class="input-medium bariskodeobat cleared"></td>
																				<td><input type="text" name="nama_obat[]" value="<?php echo $detil['nama_obat'] ?>" style="width:830px !important;" class="input-xlarge barisnamaobat cleared"></td>
																				<td><input style="text-align:center;" type="text" name="satuan_kecil[]" value="<?php echo $detil['satuan_kecil'] ?>" style="" class="input-medium barissatuan cleared" disabled></td>
																				<td><input style="text-align:right;" type="text" name="qty[]" value="<?php echo $detil['qty'] ?>" class="input-small barisjumlah cleared"></td>
																			</tr>
																		<?php
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
							</form>
                            
                            <!--END TEXT INPUT FIELD-->                            

                            <hr>
                        </div>
                        <!-- /.inner -->
                    </div>
                    <!-- /.row-fluid -->
                </div>
                <!-- /.outer -->
            </div>
            <!-- /#content -->
<div aria-hidden="true" aria-labelledby="helpModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="daftarobat" style="display: none;width:65%;margin-left:-400px !important;"> 
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Obat</h3>
    </div>
    <div class="modal-body" id="modal-body-daftarobat" style="height:340px;">
        <div class="body" id="collapse4">
            <table id="dataTable" class="table table-bordered ">
                <thead>
                    <tr>						
                        <th style="text-align:center;">Kode Obat</th>
                        <th style="text-align:center;">Nama Obat</th>
						<th style="text-align:center;">Satuan</th>
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
	function pilihobat(kd_obat,nama_obat,satuan_kecil) {
		$('.focused').find('.bariskodeobat').val(kd_obat);
        $('.focused').find('.barisnamaobat').val(nama_obat);
        $('.focused').find('.barissatuan').val(satuan_kecil);
		$('#daftarobat').modal("hide");
        //$('.focused').find('input[name="qty[]"]').focus();
		$('.focused').find('input[name="satuan_kecil[]"]').focus();
		return false;
    }
	
	$('#tambahbaris').click(function(){		
		$('#bodyinput').append('<tr><td><input type="checkbox" class="barisinput cleared" /></td>'+
									'<td><input type="text" name="kd_obat[]" value="" class="input-medium bariskodeobat cleared"></td>'+
                                    '<td><input type="text" name="nama_obat[]" value="" style="width:830px !important;" class="input-xlarge barisnamaobat cleared"></td>'+
                                    '<td><input type="text" name="satuan_kecil[]" value="" style="text-align:center;" class="input-medium barissatuan cleared" readonly></td>'+
									'<td><input type="text" style="text-align:right;" name="qty[]" value="" class="input-small barisjumlah cleared"></td>'+									
                                '</tr>');
		
		$("#bodyinput tr:last input[name='kd_obat[]']").focus();
		
		$('.barisqty, .barisnamaobat, .bariskodeobat').click(function(){  
                $('#bodyinput tr').removeClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty
                $(this).parent().parent('tr').addClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty
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
                    "sAjaxSource": "<?php echo base_url() ?>index.php/masterapotek/bmhpobat/ambildaftarobatbykode/",
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
                    "sAjaxSource": "<?php echo base_url() ?>index.php/masterapotek/bmhpobat/ambildaftarobatbynama/",
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
		
		$('.barisjumlah').keyup(function(e){ 
            if(e.keyCode == 13){ //klo enter di baris jumlah
                //alert('xx')
                $('#tambahbaris').trigger('click');
                return false;
            }
        });
	}); //akhir function tambah baris
	
	$('#hapusbaris').click(function(){
         $('.barisinput:checked').parents('tr').remove();
    });
	
	$('.barisqty, .barisnamaobat, .bariskodeobat').click(function(){  
		$('#bodyinput tr').removeClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty
		$(this).parent().parent('tr').addClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty
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
                    "sAjaxSource": "<?php echo base_url() ?>index.php/masterapotek/bmhpobat/ambildaftarobatbykode/",
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
                    "sAjaxSource": "<?php echo base_url() ?>index.php/masterapotek/bmhpobat/ambildaftarobatbynama/",
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
	
	$('.barisjumlah').keyup(function(e){ 
		if(e.keyCode == 13){ //klo enter di baris jumlah
			//alert('xx')
			$('#tambahbaris').trigger('click');
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
    //var spinner = new Spinner(opts).spin(target);  

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