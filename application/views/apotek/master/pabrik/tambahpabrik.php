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
		$('#nama_pabrik').focus();
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
                    url: "<?php echo base_url(); ?>index.php/masterapotek/pabrik/periksa",
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
                        $('#kd_pabrik').val(data.kd_pabrik);
						if(parseInt(data.posting)==3){
							 window.location.href='<?php echo base_url(); ?>index.php/masterapotek/pabrik/edit/'+data.kd_pabrik;
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
                                            <h5>ENTRY PABRIK OBAT</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a href="<?php echo base_url() ?>index.php/masterapotek/pabrik/"> <i class="icon-list"></i> Daftar Pabrik</a></li>
													<li><a href="<?php echo base_url() ?>index.php/masterapotek/pabrik/tambah"> <i class="icon-plus"></i> Tambah Pabrik</a></li>
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
                                            <form class="form-horizontal" id="form" method="post" action="<?php echo base_url()?>index.php/masterapotek/pabrik/simpan">
                                                <div class="row-fluid">
                                                    <div class="span12">
														<div class="control-group">
															<label for="kd_pabrik" class="control-label">Kode</label>
															<div class="controls with-tooltip">
																<input type="text" name="kd_pabrik" id="kd_pabrik" class="span1 input-tooltip"
																	value="" data-original-title="kd pabrik" data-placement="bottom" readonly />
																<span class="help-inline"></span>
															</div>
														</div>
                                                    </div>
                                                </div>
												<div class="row-fluid">
													<div class="span12">														
														<div class="control-group">
															<label for="nama_pabrik" class="control-label">Nama Pabrik</label>
															<div class="controls with-tooltip">
																<input type="text" name="nama_pabrik" id="nama_pabrik" class="span5 input-tooltip"
																	value="" data-original-title="nama pabrik" data-placement="bottom"/>
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
	$('.with-tooltip').tooltip({
        selector: ".input-tooltip"
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