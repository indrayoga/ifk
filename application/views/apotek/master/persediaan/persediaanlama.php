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
                var urlnya="<?php echo base_url(); ?>index.php/masterapotek/persediaanobat/periksastokopname"; //buat validasi inputan
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
                   // $('#no_penjualan').val(data.no_penjualan); //baru
                    //$('#btn-cetak').removeAttr('disabled'); //baru
                    //$('#btn-cetak').attr('href','<?php echo base_url() ?>third-party/fpdf/buktipenerimaan.php?no_penerimaan='+data.no_penerimaan+'');
                    $('#btn-tutuptrans').removeAttr('disabled'); //baru
					if(parseInt(data.keluar)>0){
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/penyesuaian/simpanstokopname';
                    }
                   /* if(parseInt(data.simpanbayar)>0){
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/penjualan/ubahpenjualan/'+data.no_penjualan;
                    }*/

                 //   $('#no_penjualan').val(data.no_penjualan);
                    //$('#btn-cetak').removeAttr('disabled');
                   // $('#btn-cetak').attr('href','<?php echo base_url() ?>third-party/fpdf/cetakbill.php?no_penjualan='+data.no_penjualan+'');
                  //  $('#btn-cetakkwitansi').removeAttr('disabled');
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
						<form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/masterapotek/persediaanobat/simpanstokopname">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header class="top" style="">
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>PERSEDIAAN OBAT / ALKES</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">  
													<li><button class="btn" id="simpan" type="submit"  name="submit" value="simpan"> <i class="icon-save"></i> Buat Pengajuan Obat</button></li>
                                                    <li><a target="_blank" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>third-party/fpdf/rekappenjualanobat.php?kd_unit_apt=<?php echo $kd_unit_apt ?>"> <i class="icon-print"></i> Export Persediaan ke PDF</a></li>
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
													<div class="span5">
														<div class="control-group">
															<label for="stok" class="control-label">Stok</label>
															<div class="controls with-tooltip">																
																<select name="stok" id="stok" class="input-small">
																	<option value="1" <?php if($stok=='1') echo "selected=selected"; ?>> >= </option>
																	<option value="2" <?php if($stok=='2') echo "selected=selected"; ?>> > </option>
																	<option value="3" <?php if($stok=='3') echo "selected=selected"; ?>> <= </option>
																	<option value="4" <?php if($stok=='4') echo "selected=selected"; ?>> < </option>																																		
																	<option value="5" <?php if($stok=='5') echo "selected=selected"; ?>> = </option>																		
																</select>
																<input type="text" name="isistok" id="isistok" class="input-small input-tooltip cleared" data-original-title="isistok" value="<?php echo $isistok?>" data-placement="bottom"/>
																<span class="help-inline"></span>
															</div>
														</div>
													</div>
												</div>
											</div>                                               
											<div class="control-group">
												<label for="text1" class="control-label">&nbsp;</label>
												<div class="controls with-tooltip">
													<button class="btn btn-primary" type="submit" name="cari" value="cari"><i class="icon-search"></i> Cari</button>
													<button class="btn " type="submit" name="reset" value="reset"><i class="icon-undo"></i> Reset</button>
												</div>
											</div>
											<div class="row-fluid">
												<div class="span12">
													<div class="box">
														<header>
															<div class="icons"><i class="icon-move"></i></div>
															<h5>UNIT : <?php if($unit=$this->mpersediaanobat->ambilNamaUnit($this->session->userdata('kd_unit_apt'))) echo strtoupper($unit); ?></h5>
														</header>
														<div id="collapse4" class="body">
															<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
																<thead>
																	<tr style="font-size:95% !important;">
																		<th style="text-align:center;"></th>
																		<th style="text-align:center;">Kode</th>
																		<th style="text-align:center;">Nama Obat</th>
																		<th style="text-align:center;">Satuan</th>																		
																		<th style="text-align:center;">Tgl.Expire</th>
																		<th style="text-align:center;">Harga Beli</th>
																		<th style="text-align:center;">Min. Stok</th>
																		<th style="text-align:center;">Stok</th>									
																	</tr>
																</thead>
																<tbody>
																	<?php
																	$no=1;													
																	foreach ($items as $item) {																		
																		$stok=$item['jml_stok'];
																		$kode=$item['kd_obat1'];
																		$minstok=$item['min_stok'];
																		$minstok1=0;
																		if($minstok==''){$minstok1=0;}
																		else{$minstok1=$minstok;}
																		
																		if($stok<=$minstok1){  ?>
																			<tr style="font-size:95% !important;">
																				<td style="text-align:center;background-color: #00FF7F;" ><input type="checkbox" name=class="barisinput cleared" /></td>
																				<td style="text-align:center;background-color: #00FF7F;"><?php echo $kode; ?></td>                                                            
																				<td style="background-color: #00FF7F;"><?php echo $item['nama_obat'] ?></td>
																				<td style="text-align:center;background-color: #00FF7F;"><?php echo $item['satuan_kecil'] ?></td>
																				<td style="text-align:center;background-color: #00FF7F;"><?php echo convertDate($item['tgl_expire']) ?></td>
																				<td style="text-align:right;background-color: #00FF7F;"><?php echo $item['harga_pokok'] ?></td>
																				<td style="text-align:right;background-color: #00FF7F;"><?php echo $minstok1; ?></td>
																				<td style="text-align:right;background-color: #00FF7F;"><?php echo $stok; ?></td>	
																			</tr> 
																		<?php } else { ?>
																			<tr style="font-size:95% !important;">
																				<td style="text-align:center;"><input type="checkbox" class="barisinput cleared" /></td>
																				<td style="text-align:center;"><?php echo $kode; ?></td>                                                            
																				<td><?php echo $item['nama_obat'] ?></td>
																				<td style="text-align:center;"><?php echo $item['satuan_kecil'] ?></td>
																				<td style="text-align:center;"><?php echo convertDate($item['tgl_expire']) ?></td>
																				<td style="text-align:right;"><?php echo $item['harga_pokok'] ?></td>
																				<td style="text-align:right;"><?php echo $minstok1; ?></td>
																				<td style="text-align:right;"><?php echo $stok; ?></td>	
																			</tr>
																		<? } ?>                                            
																	<?php
																	//$no++;
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
	$('#dataTable').dataTable({
		"aaSorting": [[ 0, "asc" ]],
		"sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "Show _MENU_ entries"
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
    var spinner = new Spinner(opts).spin(target);	

</script>