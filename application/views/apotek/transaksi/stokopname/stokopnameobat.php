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
	 
        $('#form').ajaxForm({
            beforeSubmit: function(a,f,o) {
                o.dataType = "json";
                $('div.error').removeClass('error');
                $('span.help-inline').html('');
                $('#progress').show();
                $('body').append('<div id="overlay1" style="position: fixed;height: 100%;width: 100%;z-index: 1000000;"></div>');
                $('body').addClass('body1');
                var urlnya="<?php echo base_url(); ?>index.php/transapotek/stokopname/periksastokopname"; //buat validasi inputan
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
                    //$('#btn-cetak').attr('href','<?php echo base_url() ?>third-party/fpdf/buktipenerimaan.php?no_penerimaan='+data.no_penerimaan+'');
                    $('#btn-tutuptrans').removeAttr('disabled'); //baru
					if(parseInt(data.keluar)>0){
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/stokopname/simpanstokopname';
                    }
                    $('#btn-tutuptrans').removeAttr('disabled');
                    
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
						<form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/stokopname/stokopnameobat">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header class="top" style="">
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>STOKOPNAME OBAT</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">                                                    
													
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
																	<label for="nama_unit_apt" class="control-label">Sumber Dana</label>
																	<div class="controls with-tooltip">
																																				
																		<select  class="input-xlarge cleared" name="kd_unit_apt" id="kd_unit_apt">
																			<option value="">Pilih Sumber Dana</option>
																			<?php
																			foreach ($sumberdana as $sd) {
																				$select="";																							if(isset($kd_unit_apt)){
	if($kd_unit_apt==$sd['kd_unit_apt']) $select="selected=selected"; else $select="";
} ?>
	<option value="<?php if(!empty($sd)) echo $sd['kd_unit_apt'] ?>" <?php echo $select; ?>><?php echo $sd['nama_unit_apt'] ?></option>
																			<?php
																			}
																			?>
</select>
																		
																	</div>
																</div>
															</div>
														</div>
													</div>
											<!--? } ?-->
											<div class="row-fluid">
												<div class="span12">
													<div class="span9">
														<div class="control-group">
															<label for="nama_obat" class="control-label">Nama Obat</label>
															<div class="controls with-tooltip">
																<input type="text" id="nama_obat" name="nama_obat" value="<?php echo $nama_obat?>" class="span7 input-tooltip" data-original-title="nama obat" data-placement="bottom"/>
																<input type="hidden" id="kd_obat" name="kd_obat" value="<?php echo $kd_obat?>" class="span2 input-tooltip" data-original-title="kd obat" data-placement="bottom"/>
																
															</div>
														</div>
													</div>													
												</div>
											</div>											
											<div class="control-group">
												<label for="text1" class="control-label">&nbsp;</label>
												<div class="controls with-tooltip">
													<button class="btn btn-primary" type="submit" name="submit" value=1><i class="icon-search"></i> Buka Data</button>
													<button class="btn " type="reset" name="reset" value="reset"><i class="icon-undo"></i> Reset</button>
													
												</div>
											</div>
											<div class="row-fluid">
												<div class="span12">
													<div class="box">
														<header>
															<div class="icons"><i class="icon-move"></i></div>
															<h5></h5>
														</header>
														<div id="collapse4" class="body">
															<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
																<thead>
																	<tr style="font-size:100% !important;">
																		<th style="text-align:center;" width="5px">No</th>
																		<th style="text-align:center;">Kode</th>
																		<th style="text-align:center;">Nama Obat</th>
																		<th style="text-align:center;">Satuan</th>
																		<th style="text-align:center;">Tgl. Expire</th>
																		<th style="text-align:center;">Fisik</th>
																		<th style="text-align:center;">Sumber Dana</th>																		
																	</tr>
																</thead>
																<tbody class="with-tooltip">
																	<?php
																	$no=1;	
																	foreach ($items as $item) {
																	?>
																		<tr style="font-size:100% !important;" class="showmodal input-tooltip" id="<?php echo $item['kd_obat']; ?>" unit="<?php echo $item['kd_unit_apt']; ?>" tgl="<?php echo $item['tgl_expire']; ?>" data-original-title="double click untuk edit">
																			<td style="text-align:center;"><?php echo $no; ?></td>
																			<td style="text-align:center;"><?php echo $item['kd_obat'] ?></td>                                                            
																			<td><?php echo $item['nama_obat'] ?></td>
																			<td style="text-align:center;"><?php echo $item['satuan_kecil'] ?></td>
																			<td style="text-align:center;"><?php echo $item['tgl_expire'] ?></td>
																			<td style="text-align:right;"><?php echo $item['jml_stok'] ?></td>
																			<td style="text-align:center;"><?php echo $item['nama_unit_apt'] ?></td>			
																		</tr>                                                    
																	<?php
																	$no++;
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
																		
									<!--/div-->									
										
                                </div>
                            </div>
                            <!--END TEXT INPUT FIELD-->                            
                        </form>
						
						<div aria-hidden="true" aria-labelledby="approveModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="formpenyesuaian" style="display: none;width:40%;margin-left:-280px !important;">
							<div class="modal-header">
								<button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
								<h3 id="helpModalLabel"><i class="icon-external-link"></i> Penyesuaian Stok</h3>
							</div>
							<form class="form-horizontal"  id="form" method="POST" action="<?php echo base_url() ?>index.php/transapotek/stokopname/simpanstokopname">											
								<div class="modal-body" style="height:355px;">
									<div class="body" id="collapse4">
										<div class="row-fluid">
											<div class="span12">
												<div class="span9">
													<div class="control-group">
														<label for="tanggal" class="control-label">Periode</label>
														<div class="controls with-tooltip">
															<input type="text" id="tanggal" name="tanggal" class="input-small input-tooltip" data-mask="99-99-9999"
																   value="<?php echo $tanggal?>" data-original-title="masukkan tanggal stokopname" data-placement="bottom"/>
															<input type="hidden" name="jam" id="jam" value="<?php echo date('h:i:s'); ?>" data-mask="99:99:99" class="input-small"/>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row-fluid">
											<div class="span12">
												<div class="control-group">
													<label for="kd_obat2" class="control-label">Kode</label>
													<div class="controls with-tooltip">
														<input type="text" style="text-align:right;" name="kd_obat2" id="kd_obat2" readonly class="span10 input-tooltip" value="" data-original-title="kd obat" data-placement="bottom"/>
														<span class="help-inline"></span>
														
														<input type="hidden" style="text-align:right;" name="kd_unit_apt1" id="kd_unit_apt1" readonly class="input-small input-tooltip" value="" data-original-title="kd unit apt" data-placement="bottom"/>
													</div>
												</div>
											</div>														
										</div>												
										<div class="control-group">
											<label for="nama_obat2" class="control-label">Nama</label>
											<div class="controls with-tooltip">
												<input type="text" style="text-align:right;" name="nama_obat2" id="nama_obat2" readonly class="span10 input-tooltip" value="" data-original-title="nama obat" data-placement="bottom"/>
												<span class="help-inline"></span>
											</div>
										</div>
										<div class="control-group">
											<label for="tgl_expire" class="control-label">Tgl. Expire</label>
											<div class="controls with-tooltip">
												<input type="text" style="text-align:right;" name="tgl_expire" id="tgl_expire" readonly class="span10 input-tooltip" value="" data-original-title="tgl expire" data-placement="bottom"/>
												<span class="help-inline"></span>
											</div>
										</div>
										<div class="control-group">
											<label for="stoklama" class="control-label">Stok Lama</label>
											<div class="controls with-tooltip">
												<input type="text" style="text-align:right;" name="stoklama" id="stoklama" readonly class="span10 input-tooltip" value="" data-original-title="stok lama" data-placement="bottom"/>
												<span class="help-inline"></span>
											</div>
										</div>
										<div class="control-group">
											<label for="stokbaru" class="control-label">Stok Baru</label>
											<div class="controls with-tooltip">
												<input type="text" style="text-align:right;" name="stokbaru" id="stokbaru" class="span10 input-tooltip" data-original-title="stok baru" data-placement="bottom"/>
												<span class="help-inline"></span>
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
												<button class="btn btn-primary" type="submit" name="submit" value="simpanstokopname" id="simpanstokopname">OK</button>
												<button aria-hidden="true" data-dismiss="modal" class="btn">Cancel</button>
												<span class="help-inline"></span>
											</div>
										</div>
									</div>
								</div>
							</form>
							<div class="modal-footer">
								<button aria-hidden="true" data-dismiss="modal" class="btn">Close</button>
							</div>
						</div>

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
	var dataTable = $('#dataTable').dataTable({
		"aaSorting": [[ 0, "asc" ]],
		"sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "Show _MENU_ entries"
		}
	});
	
	$('#dataTable').on('dblclick','.showmodal',function(){
		
        $.ajax({
            url: '<?php echo base_url() ?>index.php/transapotek/stokopname/ambilitems/',
            async:false,
            type:'get',
            data:{query:$(this).attr('id'),unit:$(this).attr('unit'),tgl:$(this).attr('tgl')},
            success:function(data){
                
                    $('#kd_obat2').val(data.kd_obat);
                    $('#nama_obat2').val(data.nama_obat);
					$('#tgl_expire').val(data.tgl_expire);
                    $('#stoklama').val(data.jml_stok);
					$('#kd_unit_apt1').val(data.kd_unit_apt);
                                        
            },
            dataType:'json'                         
        }); 
		//$('#stokbaru').focus();
        $('#formpenyesuaian').modal("show");	
	});
	
	$('#tanggal').datepicker({
		format: 'dd-mm-yyyy'
	});
	
	    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });
	
    $('#simpanstokopname').click(function(){
		var batal=0;
		var stokbaru=$('#stokbaru').val();
		var alasan=$('#alasan').val();
		if(stokbaru==''){
			alert('Stok baru tidak boleh kosong !');
			$('#stokbaru').focus();
			batal=1;
			return false;
		}
		else {
			if(alasan==''){
				alert('Alasan tidak boleh kosong !');
				$('#alasan').focus();
				batal=1;
				return false;
			}
		}
		if(batal)return false;
        $('#formpenyesuaian').modal("hide");
		location.reload();
    });
	
	$('.showmodal').dblclick(function(){
        $.ajax({
            url: '<?php echo base_url() ?>index.php/transapotek/stokopname/ambilitems/',
            async:false,
            type:'get',
            data:{query:$(this).attr('id'),unit:$(this).attr('unit'),tgl:$(this).attr('tgl')},
            success:function(data){
                //typeahead.process(data)
                    $('#kd_obat2').val(data.kd_obat);
                    $('#nama_obat2').val(data.nama_obat);
					$('#tgl_expire').val(data.tgl_expire);
                    $('#stoklama').val(data.jml_stok);
					$('#kd_unit_apt1').val(data.kd_unit_apt);
                    //$('#alasan').html('');                    
            },
            dataType:'json'                         
        }); 
		//$('#stokbaru').focus();
        $('#formpenyesuaian').modal("show");
    });
	
	function pilihobat(kd_obat,nama_obat) {
		$('#kd_obat').val(kd_obat);
        	$('#nama_obat').val(nama_obat);
		$('#daftarobat').modal("hide");
        
    	}
	
	$('#jam').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
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