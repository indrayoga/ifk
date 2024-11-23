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
					//url: "<?php echo base_url(); ?>index.php/log_master/masterbarang/periksa",
                    url: "<?php echo base_url(); ?>index.php/master/profil/periksa",
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
						/*$('#kd_profil').val(data.kd_profil); //baru
						if(parseInt(data.posting)==3){
							 window.location.href='<?php echo base_url(); ?>index.php/master/profil/edit/'+data.kd_profil;
						}*/
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
                                            <h5>EDIT PROFIL</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
													<li><a href="<?php echo base_url() ?>index.php/master/profil/"> <i class="icon-list"></i> Daftar</a></li>
													<li><a href="<?php echo base_url() ?>index.php/master/profil/tambah"> <i class="icon-plus"></i> Tambah</a></li>
                                                    <!--<li class="dropdown">
                                                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                                            <i class="icon-th-large"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="">q</a></li>
                                                            <li><a href="">a</a></li>
                                                            <li><a href="">b</a></li>
                                                        </ul>
                                                    </li>-->
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
                                            <form class="form-horizontal" id="form" method="post" action="<?php echo base_url()?>index.php/master/profil/update">
                                                <input type="hidden" name="mode" value="edit">
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="span7">
															<div class="control-group">
																<label for="kd_profil" class="control-label">Kode </label>
																<div class="controls with-tooltip">
																	<input type="text" name="kd_profil" id="kd_profil" value="<?php echo $kd_profil; ?>" readonly class="span3 input-tooltip" data-original-title="kd profil" data-placement="bottom"/>
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
																<label for="nama_profil" class="control-label">Nama Profil</label>
																<div class="controls with-tooltip">
																	<!--input type="text" name="nama_profil" id="nama_profil" class="span11 input-tooltip"
																		value="<-?php if(isset($itemtransaksi['nama_profil']))echo $itemtransaksi['nama_profil'] ?>" data-original-title="nama profil" data-placement="bottom"/-->
																	<textarea id="nama_profil" name="nama_profil" cols="90" rows="2" class="input-xxlarge" style="width:310px"><?php if(isset($itemtransaksi['nama_profil']))echo $itemtransaksi['nama_profil'] ?></textarea>
																	<span class="help-inline"></span>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="row-fluid">
													<div class="span12">
														<div class="control-group">
															<label for="alamat_profil" class="control-label">Alamat</label>
															<div class="controls with-tooltip">
																<textarea id="alamat_profil" name="alamat_profil" cols="90" rows="3" class="input-xlarge" style="width:310px"><?php if(isset($itemtransaksi['alamat_profil']))echo $itemtransaksi['alamat_profil'] ?></textarea>
																<span class="help-inline"></span>
															</div>
														</div>																												
													</div>
												</div>
												<div class="row-fluid">
													<div class="span12">
														<div class="span7">
															<div class="control-group">
																<label for="kota" class="control-label">Kota</label>
																<div class="controls with-tooltip">
																	<input type="text" name="kota" id="kota" class="span8 input-tooltip"
																		value="<?php if(isset($itemtransaksi['kota']))echo $itemtransaksi['kota'] ?>" data-original-title="kota" data-placement="bottom"/>
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
																<label for="telp_profil" class="control-label">Telepon</label>
																<div class="controls with-tooltip">
																	<input align="right" type="text" name="telp_profil" id="telp_profil" class="span5 input-tooltip"
																		value="<?php if(isset($itemtransaksi['telp_profil']))echo $itemtransaksi['telp_profil'] ?>" data-original-title="telepon" data-placement="bottom"/>																	
																	<span class="help-inline"></span>
																	&nbspFax &nbsp&nbsp<input align="right" type="text" name="fax_profil" id="fax_profil" class="span5 input-tooltip"
																		value="<?php if(isset($itemtransaksi['telp_profil']))echo $itemtransaksi['telp_profil'] ?>" data-original-title="fax" data-placement="bottom"/>
																</div>
															</div>
														</div>
													</div>
												</div>	
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="span7">
                                                            <div class="control-group">
                                                                <label for="email" class="control-label">Email</label>
                                                                <div class="controls with-tooltip">
                                                                    <input align="right" type="text" name="email" id="email" class="span5 input-tooltip"
                                                                        value="<?php if(isset($itemtransaksi['email']))echo $itemtransaksi['email'] ?>" data-original-title="email" data-placement="bottom"/>                                                                    
                                                                    <span class="help-inline"></span>
                                                                    &nbspWeb &nbsp&nbsp<input align="right" type="text" name="web" id="web" class="span5 input-tooltip"
                                                                        value="<?php if(isset($itemtransaksi['website']))echo $itemtransaksi['website'] ?>" data-original-title="web" data-placement="bottom"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>                                              
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="span7">
                                                            <div class="control-group">
                                                                <label for="nip_kepala" class="control-label">NIP KEPALA GFK</label>
                                                                <div class="controls with-tooltip">
                                                                    <input align="right" type="text" name="nip_kepala" id="nip_kepala" class="span5 input-tooltip"
                                                                        value="<?php if(isset($itemtransaksi['nip_kepala']))echo $itemtransaksi['nip_kepala'] ?>" data-original-title="nip" data-placement="bottom"/>                                                                    
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
                                                                <label for="nama_kepala" class="control-label">NAMA KEPALA GFK</label>
                                                                <div class="controls with-tooltip">
                                                                    <input align="right" type="text" name="nama_kepala" id="nama_kepala" class="span5 input-tooltip"
                                                                        value="<?php if(isset($itemtransaksi['nama_kepala']))echo $itemtransaksi['nama_kepala'] ?>" data-original-title="nip" data-placement="bottom"/>                                                                    
                                                                    <span class="help-inline"></span>
                                                                </div>
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
	
	$('#kd_kelurahan').change(function(){
		$.ajax({
			url: '<?php echo base_url() ?>index.php/master/profil/ambilkecamatan/',
			async:false,
			type:'get',
			data:{query:$(this).val()},
			success:function(data){
				$('#kd_kecamatan').val(data.kd_kecamatan);	
				$('#kecamatan').val(data.kecamatan);	
			},
			dataType:'json'                         
		});
		$('#kota').focus();
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