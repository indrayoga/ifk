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
		$('#kd_sub').focus();
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
                    url: "<?php echo base_url(); ?>index.php/masterapotek/subgolongan/periksa",
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
                        $('#kd_sub').val(data.kd_sub);
						if(parseInt(data.posting)==3){
							 window.location.href='<?php echo base_url(); ?>index.php/masterapotek/subgolongan/edit/'+data.kd_sub;
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
                                <div class="span12">
                                    <div class="box">
                                        <header>
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>ENTRY SUB GOLONGAN OBAT / ALKES</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a href="<?php echo base_url() ?>index.php/masterapotek/subgolongan/"> <i class="icon-list"></i> Daftar Sub</a></li>
													<li><a href="<?php echo base_url() ?>index.php/masterapotek/subgolongan/tambah"> <i class="icon-plus"></i> Tambah Sub</a></li>
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
                                            <form class="form-horizontal" id="form" method="post" action="<?php echo base_url()?>index.php/masterapotek/subgolongan/simpan">
                                                <div class="row-fluid">
                                                    <div class="span12">
														<div class="control-group">
															<label for="kd_sub" class="control-label">Kode Sub</label>
															<div class="controls with-tooltip">
																<input type="text" name="kd_sub" id="kd_sub" class="span2 input-tooltip"
																	value="" data-original-title="kd sub golongan" data-placement="bottom"/>
																<span class="help-inline"></span>
															</div>
														</div>
                                                    </div>
                                                </div>
												<div class="row-fluid">
													<div class="span12">														
														<div class="control-group">
															<label for="sub_golongan" class="control-label">Sub Golongan Obat</label>
															<div class="controls with-tooltip">
																<input type="text" name="sub_golongan" id="sub_golongan" class="span5 input-tooltip"
																	value="" data-original-title="sub golongan" data-placement="bottom"/>
																<span class="help-inline"></span>
															</div>
														</div>														
													</div>
												</div>
												<div class="row-fluid">
                                                    <div class="span12">
														<div class="control-group">
															<label for="kd_golongan" class="control-label">Kode Golongan</label>
															<div class="controls with-tooltip">
																<select id="kd_golongan" name="kd_golongan" class="input-medium">
																	<option value="">--pilih--</option>
																	<?php
																	foreach ($golongan as $gol) {
																		# code...
																		if ($gol['kd_golongan']== $kd_golongan){
																			$cek = "selected=selected";
																		}
																		else {
																			$cek = "";
																		}
																	?>
																	<option value="<?php echo $gol['kd_golongan'] ?>" <?php echo $cek; ?>><?php echo $gol['golongan'] ?></option>
																	<?php
																	}
																	?>
																</select>
																<span class="help-inline"></span>
															</div>
														</div>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">&nbsp;</label>
                                                    <div class="controls with-tooltip">
                                                        <button class="btn btn-primary" type="submit"><i class="icon-ok"></i> Simpan</button>
                                                        <button class="btn " type="reset"><i class="icon-undo"></i> Reset</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <div id="progress" style="display:none;"></div>                                                                                    
                                        </div>
                                    </div>
                                </div>
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