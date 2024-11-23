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
                    url: "<?php echo base_url(); ?>index.php/master/dokterunit/periksa",
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
							<form class="form-horizontal" id="form" method="post" action="<?php echo base_url()?>index.php/master/dokterunit/simpan">
								<div class="row-fluid">
									<div class="span12">
										<div class="box">
											<header>
												<div class="icons"><i class="icon-edit"></i></div>
												<h5>ENTRY DOKTER UNIT</h5>
												<!-- .toolbar -->
												<div class="toolbar" style="height:auto;">
													<ul class="nav nav-tabs">
														<!--li><a href="<-?php echo base_url() ?>index.php/master/dokterunit/"> <i class="icon-list"></i> Tambah Baru</a></li-->
														<!--li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<-?php echo base_url() ?>index.php/master/dokterunit/"> <i class="icon-plus"></i> Tambah Baru</a></li-->                                                    
														<li><button class="btn" id="simpan" type="submit"  name="submit" value="simpan"> <i class="icon-save"></i> Simpan</button></li>
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
																<label for="kd_unit_kerja" class="control-label">Unit</label>
																<div class="controls with-tooltip">
																	<select name="kd_unit_kerja" id="kd_unit_kerja" class="input-xlarge" onchange="javascript:window.location.href='<?php echo base_url() ?>index.php/master/dokterunit/index/'+this.value">
																		<option value="">--Pilih Unit--</option>
																		<?php

																		foreach ($datapoli as $poli) {
																			# code...
																			if($unit==$poli['kd_unit_kerja'])$sel="selected=selected"; else $sel="";
																		?>
																		<option value="<?php echo $poli['kd_unit_kerja'] ?>" <?php echo $sel; ?>><?php echo $poli['nama_unit_kerja'] ?></option>
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
																<li><button class="btn" type="button" id="tambahbaris"> <i class="icon-plus"></i> Tambah Dokter</button></li>
																<li><button class="btn" type="button" id="hapusbaris"> <i class="icon-remove"></i> Hapus Baris</button></li>
															</ul>
														</div>
													<!-- /.toolbar -->
													</header>
													<div class="body collapse in" id="defaultTable">
														<table class="table responsive">
															<thead>
																<tr>
																	<th class="header">&nbsp;</th>
																	<th class="header">Kode Dokter</th>
																	<th class="header">Nama Dokter</th>
																</tr>
															</thead>
															<tbody id="bodyinput">
																<?php
																	if(isset($datadokter)){
																		foreach ($datadokter as $dok){																			
																		?>
																			<tr>
																				<td style="text-align:center;"><input type="checkbox" class="barisinput" /></td>
																				<td><input type="text" name="kd_dokter[]" value="<?php echo $dok['kd_dokter'] ?>" class="input-medium bariskode cleared"></td>
																				<td><input type="text" name="nama_dokter[]" value="<?php echo $dok['nama_dokter'] ?>" style="width:700px !important;" class="input-xlarge barisnama cleared"></td>																			
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
<div aria-hidden="true" aria-labelledby="helpModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="daftardokter" style="display: none;width:50%;margin-left:-400px !important;"> 
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Dokter</h3>
    </div>
    <div class="modal-body" style="height:285px;">
        <div class="body" id="collapse4">
            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                <thead>
                    <tr>						
                        <th style="text-align:center;">Kode Dokter</th>
                        <th style="text-align:center;">Nama Dokter</th>
						<th style="width:50px !important;">Pilihan</th>
                    </tr>
                </thead>
                <tbody id="listdokter">

                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <input type="text" id="nama_dokter1" class="pull-left" autocomplete="off">
        <button aria-hidden="true" data-dismiss="modal" class="btn">Close</button>
    </div>
</div>
			
<script type="text/javascript">
	function pilihdokter(kd_dokter,nama_dokter) {
		$('.focused').find('.bariskode').val(kd_dokter);
        $('.focused').find('.barisnama').val(nama_dokter);
		$('#daftardokter').modal("hide");
        $('.focused').find('input[name="nama_dokter[]"]').focus();
    }
	
	$('#tambahbaris').click(function(){		
		$('#bodyinput').append('<tr><td style="text-align:center;"><input type="checkbox" class="barisinput cleared" /></td>'+
									'<td><input type="text" name="kd_dokter[]" value="" class="input-medium bariskode cleared"></td>'+
                                    '<td><input type="text" name="nama_dokter[]" value="" style="width:700px !important;" class="input-xlarge barisnama cleared"></td>'+                                    
                                '</tr>');
		
		$("#bodyinput tr:last input[name='kd_dokter[]']").focus();
		
		$('.bariskode, .barisnama').click(function(){  
                $('#bodyinput tr').removeClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty
                $(this).parent().parent('tr').addClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty
		});	
		
		$('.barisnama').keyup(function(e){ 
            if(e.keyCode == 13){ //klo enter di baris jumlah
                //alert('xx')
                $('#tambahbaris').trigger('click');
                return false;
            }
        });
				
		/*$('.barisnama').keyup(function(e){
            if(e.keyCode == 13){
                //alert('xx')
                $('.barisnama').parent().parent('tr').removeClass('focused');
                $(this).parent().parent('tr').addClass('focused');

                $.ajax({
                    url: '<?php echo base_url() ?>index.php/master/dokterunit/ambildokterbynama/',
                    async:false,
                    type:'get',
                    data:{query:$(this).val()},
                    success:function(data){
                        //typeahead.process(data)
                        $('#listdokter').empty();
                        $.each(data,function(i,l){
                            //alert(l);
							$('#listdokter').append('<tr><td style="text-align:center;">'+l.kd_dokter+'</td><td>'+l.nama_dokter+'</td><td><a class="btn" onclick=\'pilihdokter("'+l.kd_dokter+'","'+l.nama_dokter+'")\'>Pilih</a></td></tr>');
                        });
                        
                    },
                    dataType:'json'                         
                }); 
                var ex = document.getElementById('dataTable');
                if ( ! $.fn.DataTable.fnIsDataTable( ex ) ) {
                    $('#dataTable').dataTable({
                    "sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
                    "sPaginationType": "bootstrap",
                    "oLanguage": {
                        "sLengthMenu": "Show _MENU_ entries"
                    }
                    });
                    var oTable = $('#dataTable').dataTable();
                    $('#nama_dokter1').keyup(function(e){

                        oTable.fnFilter( $(this).val() );
                        if(e.keyCode == 13){
                            //alert('xx')
                            return false;
                        }
                    });
               }

                $('#daftardokter').modal("show");                                      
            }
        });*/

		$('.bariskode').keyup(function(e){ 
            if(e.keyCode == 13){
                //alert('xx')
                $('.bariskode').parent().parent('tr').removeClass('focused');
                $(this).parent().parent('tr').addClass('focused');

                $.ajax({
                    url: '<?php echo base_url() ?>index.php/master/dokterunit/ambildokterbykode/',
                    async:false,
                    type:'get',
                    data:{query:$(this).val()},
                    success:function(data){
                        //typeahead.process(data)
                        $('#listdokter').empty();
                        $.each(data,function(i,l){
                            //alert(l);
                            $('#listdokter').append('<tr><td style="text-align:center;">'+l.kd_dokter+'</td><td>'+l.nama_dokter+'</td><td><a class="btn" onclick=\'pilihdokter("'+l.kd_dokter+'","'+l.nama_dokter+'")\'>Pilih</a></td></tr>');
                        });
                        
                    },
                    dataType:'json'                         
                }); 
                var ex = document.getElementById('dataTable');
                if ( ! $.fn.DataTable.fnIsDataTable( ex ) ) {
                    $('#dataTable').dataTable({
                    "sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
                    "sPaginationType": "bootstrap",
                    "oLanguage": {
                        "sLengthMenu": "Show _MENU_ entries"
                    }
                    });
                    var oTable = $('#dataTable').dataTable();
                    $('#nama_dokter1').keyup(function(e){

                        oTable.fnFilter( $(this).val() );
                        if(e.keyCode == 13){
                            //alert('xx')
                            return false;
                        }
                    });
               }

                $('#daftardokter').modal("show");                                      
            }
        });
	}); //akhir function tambah baris
	
	$('.barisnama').keyup(function(e){ 
            if(e.keyCode == 13){ //klo enter di baris jumlah	`
                //alert('xx')
                $('#tambahbaris').trigger('click');
                return false;
            }
        });
	
	$('#hapusbaris').click(function(){
         $('.barisinput:checked').parents('tr').remove();
    });
	
	$('.bariskode, .barisnama').click(function(){  
                $('#bodyinput tr').removeClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty
                $(this).parent().parent('tr').addClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty
		});	
	
	/*$('.barisnama').keyup(function(e){
            if(e.keyCode == 13){
                //alert('xx')
                $('.barisnama').parent().parent('tr').removeClass('focused');
                $(this).parent().parent('tr').addClass('focused');

                $.ajax({
                    url: '<?php echo base_url() ?>index.php/master/dokterunit/ambildokterbynama/',
                    async:false,
                    type:'get',
                    data:{query:$(this).val()},
                    success:function(data){
                        //typeahead.process(data)
                        $('#listdokter').empty();
                        $.each(data,function(i,l){
                            //alert(l);
							$('#listdokter').append('<tr><td style="text-align:center;">'+l.kd_dokter+'</td><td>'+l.nama_dokter+'</td><td><a class="btn" onclick=\'pilihdokter("'+l.kd_dokter+'","'+l.nama_dokter+'")\'>Pilih</a></td></tr>');
                        });
                        
                    },
                    dataType:'json'                         
                }); 
                var ex = document.getElementById('dataTable');
                if ( ! $.fn.DataTable.fnIsDataTable( ex ) ) {
                    $('#dataTable').dataTable({
                    "sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
                    "sPaginationType": "bootstrap",
                    "oLanguage": {
                        "sLengthMenu": "Show _MENU_ entries"
                    }
                    });
                    var oTable = $('#dataTable').dataTable();
                    $('#nama_dokter1').keyup(function(e){

                        oTable.fnFilter( $(this).val() );
                        if(e.keyCode == 13){
                            //alert('xx')
                            return false;
                        }
                    });
               }

                $('#daftardokter').modal("show");                                      
            }
        });*/

		$('.bariskode').keyup(function(e){ 

            if(e.keyCode == 13){
                //alert('xx')
                $('.bariskode').parent().parent('tr').removeClass('focused');
                $(this).parent().parent('tr').addClass('focused');

                $.ajax({
                    url: '<?php echo base_url() ?>index.php/master/dokterunit/ambildokterbykode/',
                    async:false,
                    type:'get',
                    data:{query:$(this).val()},
                    success:function(data){
                        //typeahead.process(data)
                        $('#listdokter').empty();
                        $.each(data,function(i,l){
                            //alert(l);
                            $('#listdokter').append('<tr><td style="text-align:center;">'+l.kd_dokter+'</td><td>'+l.nama_dokter+'</td><td><a class="btn" onclick=\'pilihdokter("'+l.kd_dokter+'","'+l.nama_dokter+'")\'>Pilih</a></td></tr>');
                        });
                        
                    },
                    dataType:'json'                         
                }); 
                var ex = document.getElementById('dataTable');
                if ( ! $.fn.DataTable.fnIsDataTable( ex ) ) {
                    $('#dataTable').dataTable({
                    "sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
                    "sPaginationType": "bootstrap",
                    "oLanguage": {
                        "sLengthMenu": "Show _MENU_ entries"
                    }
                    });
                    var oTable = $('#dataTable').dataTable();
                    $('#nama_dokter1').keyup(function(e){

                        oTable.fnFilter( $(this).val() );
                        if(e.keyCode == 13){
                            //alert('xx')
                            return false;
                        }
                    });
               }

                $('#daftardokter').modal("show");                                      
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
</script>