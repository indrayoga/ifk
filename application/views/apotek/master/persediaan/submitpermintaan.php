<script type="text/javascript">
    $(document).ready(function() {
		var totalsubmit=0;
        $('.barisjumlah').each(function(){
                var val=$(this).val();
                if(val=='')val=0;
                totalsubmit=totalsubmit+parseFloat(val);
        });
        $('#totalsubmit').val(totalsubmit.toFixed(2));
		
        $('#form').ajaxForm({
            beforeSubmit: function(a,f,o) {
                o.dataType = "json";
                $('div.error').removeClass('error');
                $('span.help-inline').html('');
                $('#progress').show();
                $('body').append('<div id="overlay1" style="position: fixed;height: 100%;width: 100%;z-index: 1000000;"></div>');
                $('body').addClass('body1');
                var urlnya="<?php echo base_url(); ?>index.php/masterapotek/persediaan/periksasubmit"; //buat validasi inputan
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
                    $('#no_pengajuan').val(data.no_pengajuan); //baru
					if(parseInt(data.keluar)>0){
                        window.location.href='<?php echo base_url(); ?>index.php/masterapotek/persediaan';
                    }
					if(parseInt(data.posting)==3){
                         //window.location.href='<?php echo base_url(); ?>index.php/masterapotek/persediaan/persediaanobat';
						 window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptpermintaan';
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
						<form class="form-horizontal"  id="form" method="POST" action="<?php echo base_url() ?>index.php/masterapotek/persediaan/editsubmitpermintaan">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header class="top" style="">
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>SUBMIT PERMINTAAN OBAT / ALKES</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><button class="btn" id="simpan" type="submit"  name="submit" value="simpan"> <i class="icon-save"></i> Submit / (Ctrl+S)</button></li>
													<li><button class="btn" id="batal" type="submit"  name="batal" value="batal"> <i class="icon-remove"></i> Batal </button></li>
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
													<!--div class="span8"-->
														<div class="control-group">
															<label for="keterangan" class="control-label">Keterangan </label>
															<div class="controls with-tooltip">
																<input type="text" id="keterangan" name="keterangan" value="<?php if(isset($itemtransaksi['keterangan']))echo $itemtransaksi['keterangan'] ?>" class="span4 input-tooltip cleared" data-original-title="keterangan" data-placement="bottom"/>
																<span class="help-inline"></span>
																<input type="hidden" name="no_submit" id="no_submit" value="<?php echo $no_submit; ?>" readonly class="span1 input-tooltip" data-original-title="no pengajuan" data-placement="bottom"/>
																<input type="hidden" name="tgl_submit" id="tgl_submit" class="input-small input-tooltip cleared" data-original-title="tgl submit" data-mask="99-99-9999" value="<?php if(empty($itemtransaksi['tgl_submit']))echo date('d-m-Y'); else echo convertDate($itemtransaksi['tgl_submit']);  ?>" data-placement="bottom"/>
																<input type="hidden" name="jam_submit" id="jam_submit" value="<?php echo date('h:i:s'); ?>" data-mask="99:99:99" class="input-small"/>
																<input type="hidden" id="jam_submit1" name="jam_submit1" value="<?php if(isset($itemtransaksi['jam_submit']))echo $itemtransaksi['jam_submit'] ?>" class="input-small" data-original-title="jam submit" data-placement="bottom"/>
															</div>
														</div>
													<!--/div-->													
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
															<li><button class="btn" type="button" id="hapusbaris"> <i class="icon-remove"></i> Hapus Obat</button></li>
														</ul>
													</div>
												<!-- /.toolbar -->
												</header>
												<div class="body collapse in" id="defaultTable">
													<table class="table responsive">
														<thead>
															<tr style="font-size:80% !important;">
																<th class="header" width="2%">&nbsp;</th>
																<th class="header" width="10%">Kode Obat</th>
																<th class="header" width="40%">Nama Obat</th>
																<th class="header" width="10%">Satuan</th>
																<th class="header">Jml.Req</th>
																<!--th class="header">Jumlah </th-->
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
																			<td style="text-align:left;"><input type="text" name="kd_obat[]" value="<?php echo $itemdetil['kd_obat'] ?>" style="width:100px;" class="input-small bariskodeobat cleared"></td>
																			<td style="text-align:left;"><input type="text" name="nama_obat[]" value="<?php echo $itemdetil['nama_obat'] ?>" style="width:500px;" class="input-xlarge barisnamaobat cleared"></td>
																			<td style="text-align:left;"><input type="text" name="satuan_kecil[]" value="<?php echo $itemdetil['satuan_kecil'] ?>" style="width:100px;" class="input-medium barissatuan cleared" readonly></td>
																			<!--td><input <-?php if($this->mpersediaanobat->isPosted($no_pemesanan))echo "readonly"; ?> type="text" name="tgl_expire[]" value="<-?php echo $itemdetil['tgl_expire'] ?>" class="input-small baristanggal cleared"></td-->
																			<td style="text-align:left;"><input style="text-align:right;" type="text" name="jml_req[]" value="<?php echo $itemdetil['jml_req'] ?>" style="width:70px;" class="input-small barisjumreq cleared"></td>
																			<!--input type="hidden" name="qty_kcl[]" value="<-?php echo $itemdetil['qty_kcl'] ?>" style="width:70px;" class="input-small barisqtyk cleared" readonly-->																			
																			<!--td style="text-align:right;"><input style="text-align:right;" type="text" name="jumlah[]" style="width:100px;font-size:90% !important;" value="<-?php echo number_format($itemdetil['jumlah'],2,'.','') ?>" class="input-medium barisjumlah cleared" readonly></td-->																			
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
			
<script type="text/javascript">
    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });
	
	$('#batal').click(function(){
		var tanya = confirm("Yakin submit pengajuan dibatalkan ?")
		var nomor=$('#no_submit').val();
		if (tanya){
			$.ajax({
				url: '<?php echo base_url() ?>index.php/masterapotek/persediaan/hapussubmitpermintaan/',
				async:false,
				type:'post',
				data:{query:$('#no_submit').val()},
				success:function(data){	
					window.location.href='<?php echo base_url(); ?>index.php/masterapotek/persediaan/persediaanobat';
				},
				dataType:'json'                         
			});
		}
		else{
			//alert("Submit batal")
			//location.reload();
			window.location.href='<?php echo base_url(); ?>index.php/masterapotek/persediaan/submitpermintaan/'+nomor;
		}
	})
	
	$('#tgl_submit').datepicker({
        format: 'dd-mm-yyyy'
    });
	
	$('#jam_submit').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
    });
	
	$('#hapusbaris').click(function(){
         $('.barisinput:checked').parents('tr').remove();	   
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
	
	$('.barisjumreq, .barisnamaobat, .baristanggal').click(function(){  
			$('#bodyinput tr').removeClass('focused'); 
			$(this).parent().parent('tr').addClass('focused'); 
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

</script>