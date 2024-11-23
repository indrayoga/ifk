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
		$('#id_pegawai').focus();	
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
                    url: "<?php echo base_url(); ?>index.php/masterapotek/approver/periksa",
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
                        $('#kd_app').val(data.kd_app);
						if(parseInt(data.posting)==3){
							 window.location.href='<?php echo base_url(); ?>index.php/masterapotek/approver/edit/'+data.kd_app;
						}
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
                            <div class="row-fluid">
								<form class="form-horizontal" id="form" method="post" action="<?php echo base_url()?>index.php/masterapotek/approver/simpan">
									<div class="row-fluid">
										<div class="span12">
											<div class="box">
												<header>
													<div class="icons"><i class="icon-edit"></i></div>
													<h5>ENTRY APPROVER</h5>
													<!-- .toolbar -->
													<div class="toolbar" style="height:auto;">
														<ul class="nav nav-tabs">
															<li><a href="<?php echo base_url() ?>index.php/masterapotek/approver/"> <i class="icon-list"></i> Daftar Approver</a></li>															
															<li><a href="<?php echo base_url() ?>index.php/masterapotek/approver/tambah"> <i class="icon-plus"></i> Tambah Approver</a></li>
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
																	<label for="kd_app" class="control-label">Kode</label>
																	<div class="controls with-tooltip">
																		<input type="text" name="kd_app" id="kd_app" class="span2 input-tooltip"
																			value="" data-original-title="kd approver" data-placement="bottom" readonly />
																		<span class="help-inline"></span>
																		Urut Approval <input type="text" name="urut" id="urut" class="span1 input-tooltip"
																			value="" data-original-title="urut" data-placement="bottom" readonly />
																		<span class="help-inline"></span>
																	</div>                                                                
																</div>
															</div>
														</div>
													</div>
													<div class="row-fluid">
														<div class="span12">
															<div class="span7">
																<div class="control-group">
																	<label for="id_pegawai" class="control-label">Pegawai</label>
																	<div class="controls with-tooltip">
																		<select name="id_pegawai" id="id_pegawai" class="input-large">
																			<option value="">--pilih pegawai--</option>																
																			<?php
																			foreach ($datakecil as $kecil) {
																				# code...
																			?>
																			<option value="<?php echo $kecil['id_pegawai'] ?>"><?php echo $kecil['nama_pegawai'] ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="help-inline"></span>
																		Username
																		<select name="id_user" id="id_user" class="input-small">
																			<option value="">--pilih--</option>																
																			<?php
																			foreach ($datausername as $user) {
																				# code...
																			?>
																			<option value="<?php echo $user['id_user'] ?>"><?php echo $user['username'] ?></option>
																			<?php
																			}
																			?>
																		</select>																		
																	</div>
																</div>                                                           
															</div>														
														</div>
													</div>
													<div class="control-group">
														<label for="text2" class="control-label">&nbsp;</label>
														<div class="controls with-tooltip">
															<!--button class="btn btn-primary" id="simpansetting" type="button"> <i class="icon-ok"></i> Simpan</button-->
															<button class="btn btn-primary" type="submit"><i class="icon-ok"></i> Simpan</button>
															<button class="btn " type="reset"><i class="icon-undo"></i> Reset</button>
														</div>
													</div>													
												</div>
											</div>
											
										</div>
									</div>
									
								</form>                                
                            </div>
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
<script type="text/javascript">
	$('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });
	
	$('#id_pegawai').change(function(){
		$.ajax({
			url: '<?php echo base_url() ?>index.php/masterapotek/approver/ambilusername/',
			async:false,
			type:'get',
			data:{query:$(this).val()},
			success:function(data){
				//typeahead.process(data)
				$('#id_user').empty();
				$.each(data,function(i,l){
					//alert(l);
					$('#id_user').append('<option value="'+l.id_user+'">'+l.username+'</option>');
				});
				
			},
			dataType:'json'                         
        });
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