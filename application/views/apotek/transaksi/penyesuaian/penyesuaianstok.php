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
                var urlnya="<?php echo base_url(); ?>index.php/transapotek/penyesuaian/periksastokopname"; //buat validasi inputan
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
						<form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/penyesuaian/penyesuaianstok">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header class="top" style="">
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>Stokopname Obat</h5>
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
													<div class="span6">
														<div class="control-group">
															<label for="nama_obat" class="control-label">Nama Obat / Alkes</label>
															<div class="controls with-tooltip">
																<input type="text" id="nama_obat" name="nama_obat" value="<?php echo $nama_obat?>" class="span12 input-tooltip" data-original-title="nama obat" data-placement="bottom"/>
																<input type="hidden" id="kd_obat" name="kd_obat" value="<?php echo $kd_obat?>" class="span3 input-tooltip" data-original-title="kd obat" data-placement="bottom"/>
																<!--input type="text" id="nomor" name="nomor" value="<-?php echo $nomor?>" class="span3 input-tooltip" data-original-title="nomor" data-placement="bottom"/-->
															</div>
														</div>
													</div>													
												</div>
											</div> 
											<div class="row-fluid">
												<div class="span12">
													<div class="span6">
														<div class="control-group">
															<label for="tgl_expire" class="control-label">Tgl. Expired </label>
															<div class="controls with-tooltip">
																<input type="text" id="periodeawal" name="periodeawal" class="input-small input-tooltip" data-mask="99-99-9999"
																	    data-original-title="masukkan tanggal awal" value="<?php echo $periodeawal ?>" data-placement="bottom"/>
																		s/d
																<input type="text" id="periodeakhir" name="periodeakhir" class="input-small input-tooltip" data-mask="99-99-9999"
																		data-original-title="masukkan tanggal akhir" value="<?php echo $periodeakhir ?>" data-placement="bottom"/>
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
													<!--a href="<-?php echo base_url() ?>index.php/transapotek/penyesuaian/exportcoba">Export</a-->
													<button class="btn " type="submit" name="submit1" value="excel"><i class="icon-print"></i> Export to Excel</button>
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
																	<tr style="font-size:80% !important;">
																		<th style="text-align:center;">No</th>
																		<th style="text-align:center;">Kode</th>
																		<th style="text-align:center;">Nama Obat</th>
																		<th style="text-align:center;">Satuan</th>
																		<th style="text-align:center;">Tgl. Expired</th>																		
																		<th style="text-align:center;">Qty / Stok</th>	
																		<th style="text-align:center;">Unit</th>
																	</tr>
																</thead>
																<tbody class="with-tooltip">
																	<?php
																	$no=1;													
																	foreach ($items as $item) {											
																	?>
																		<tr style="font-size:80% !important;" class="showmodal input-tooltip" id="<?php echo $item['kd_obat']; ?>" tgl="<?php echo $item['tgl_expire']; ?>" unit="<?php echo $item['kd_unit_apt']; ?>" data-original-title="double click untuk edit">
																			<td style="text-align:center;"><?php echo $no."."; ?></td>
																			<td style="text-align:center;"><?php echo $item['kd_obat'] ?></td>                                                            
																			<td><?php echo $item['nama_obat'] ?></td>
																			<td style="text-align:center;"><?php echo $item['satuan_kecil'] ?></td>
																			<td style="text-align:center;"><?php echo convertDate($item['tgl_expire']) ?></td>
																			<td style="text-align:center;"><?php echo $item['jml_stok'] ?></td>
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
											<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
											<h3 id="helpModalLabel"><i class="icon-external-link"></i> Penyesuaian Stok</h3>
										</div>
										<form class="form-horizontal"  id="form" method="POST" action="<?php echo base_url() ?>index.php/transapotek/penyesuaian/simpanstokopname">											
											<div class="modal-body" style="height:360px;">
												<div class="body" id="collapse4">
													<div class="row-fluid">
														<div class="span12">
															<div class="control-group">
																<label for="kd_obat2" class="control-label">Kode</label>
																<div class="controls with-tooltip">
																	<input type="text" style="text-align:right;" name="kd_obat2" id="kd_obat2" readonly class="span10 input-tooltip" value="" data-original-title="kd obat" data-placement="bottom"/>
																	<span class="help-inline"></span>
																	<input type="hidden" name="tanggal" id="tanggal" class="input-small input-tooltip cleared" data-original-title="tanggal" data-mask="9999-99-99" value="<?php if(empty($tanggal))echo date('Y-m-d'); else echo convertDate($tanggal); ?>" data-placement="bottom"/>
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
														<label for="stoklama" class="control-label">Stok</label>
														<div class="controls with-tooltip">
															<input type="text" style="text-align:right;" name="stoklama" id="stoklama" readonly class="span10 input-tooltip" value="" data-original-title="stok lama" data-placement="bottom"/>
															<span class="help-inline"></span>
														</div>
													</div>
													<div class="control-group">
														<label for="tgl_expire2" class="control-label">Tgl. Expired</label>
														<div class="controls with-tooltip">
															<input type="text" style="text-align:right;" name="tgl_expire2" id="tgl_expire2" readonly class="span10 input-tooltip" data-original-title="tgl expire" data-placement="bottom"/>
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

<div aria-hidden="true" aria-labelledby="helpModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="daftarobat" style="display: none;width:60%;margin-left:-400px !important;"> 
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Obat</h3>
    </div>
    <div class="modal-body" style="height:340px;">
        <div class="body" id="collapse4">
            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                <thead>
                    <tr>						
                        <th>Kode Obat</th>
                        <th>Nama Obat</th>
						<th>Satuan</th>
						<th>Tgl. Expire</th>
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
	$('#dataTable').dataTable({
		"aaSorting": [[ 0, "asc" ]],
		"sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "Show _MENU_ entries"
		}
	});
	
    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });
	
    $('#simpanstokopname').click(function(){
        $('#formpenyesuaian').modal("hide");
		location.reload();
    });
	
	$('#periodeawal').datepicker({
        format: 'dd-mm-yyyy'
    });
	
	$('#periodeakhir').datepicker({
        format: 'dd-mm-yyyy'
    });
	
	$('.showmodal').dblclick(function(){
        $.ajax({
            url: '<?php echo base_url() ?>index.php/transapotek/penyesuaian/ambilitems/',
            async:false,
            type:'get',
            data:{query:$(this).attr('id'),tgl:$(this).attr('tgl'),unit:$(this).attr('unit')},
            success:function(data){
                //typeahead.process(data)
                    $('#kd_obat2').val(data.kd_obat);
                    $('#nama_obat2').val(data.nama_obat);
                    $('#stoklama').val(data.jml_stok);
					$('#tgl_expire2').val(data.tgl_expire);
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
        //$('#periodeawal').focus();
    }
	
	$('#nama_obat').keyup(function(e){
		if(e.keyCode == 13){

            $.ajax({
                url: '<?php echo base_url() ?>index.php/transapotek/penyesuaian/ambilobatbynama/',
                async:false,
                type:'get',
                data:{query:$(this).val()},
                success:function(data){
                //typeahead.process(data)
					$('#listobat').empty();
					$.each(data,function(i,l){
						//alert(l);
						$('#listobat').append('<tr><td>'+l.kd_obat+'</td><td>'+l.nama_obat+'</td><td>'+l.satuan_kecil+'</td><td>'+l.tgl_expire+'</td><td><a class="btn" onclick=\'pilihobat("'+l.kd_obat+'","'+l.nama_obat+'")\'>Pilih</a></td></tr>');
					});    
                },
                dataType:'json'                         
            }); 
            $('#daftarobat').modal("show");
		}
		var ex = document.getElementById('dataTable1');
        if ( ! $.fn.DataTable.fnIsDataTable( ex ) ) {
            $('#dataTable1').dataTable({
                "sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
				"sPaginationType": "bootstrap",
                "oLanguage": {
					"sLengthMenu": "Show _MENU_ entries"
                }
            });
            var oTable = $('#dataTable1').dataTable();
            $('#nama_obat1').keyup(function(e){ //ngikutin id di popup
				oTable.fnFilter( $(this).val() );
                if(e.keyCode == 13){
                    //alert('xx')
                    return false;
                }
            });
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
    var spinner = new Spinner(opts).spin(target);	

</script>