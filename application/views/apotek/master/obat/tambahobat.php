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
		$('#kd_golongan').trigger('change');
		<?php if($this->session->userdata('kd_unit_apt')!=$this->session->userdata('kd_unit_apt_gudang')) { ?>
				$('#min_stok').focus();
		<?php } else { ?>
				$('#nama_obat').focus();
		<?php } ?>		
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
                    url: "<?php echo base_url(); ?>index.php/masterapotek/obat/periksa",
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
                        $('#kd_obat').val(data.kd_obat);
						if(parseInt(data.posting)==3){
							 window.location.href='<?php echo base_url(); ?>index.php/masterapotek/obat/edit/'+data.kd_obat;
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
								<form class="form-horizontal" id="form" method="post" action="<?php echo base_url()?>index.php/masterapotek/obat/simpan">
									<div class="row-fluid">
										<div class="span12">
											<div class="box">
												<header>
													<div class="icons"><i class="icon-edit"></i></div>
													<h5>ENTRY OBAT / ALKES</h5>
													<!-- .toolbar -->
													<div class="toolbar" style="height:auto;">
														<ul class="nav nav-tabs">
															<li><a href="<?php echo base_url() ?>index.php/masterapotek/obat/"> <i class="icon-list"></i> Daftar Obat</a></li>
															<?php if($this->session->userdata('kd_unit_apt')==$this->session->userdata('kd_unit_apt_gudang')){ ?>
																		<li><a href="<?php echo base_url() ?>index.php/masterapotek/obat/tambah"> <i class="icon-plus"></i> Tambah Obat</a></li>
															<?php } ?>
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
																	<label for="kd_obat" class="control-label">Kode</label>
																	<div class="controls with-tooltip">
																		<input  type="text" name="kd_obat" id="kd_obat" class="span5 input-tooltip"
																			value="" data-original-title="kd obat" data-placement="bottom" />
																			&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Aktif &nbsp&nbsp<input  type="checkbox" checked id="is_aktif" name="is_aktif" value="1" />
																		<span class="help-inline"></span>
																	</div>                                                                
																</div>
															</div>
														</div>
													</div>
													<div class="row-fluid" style="display:none;">
														<div class="span12">
															<div class="span6">
																<div class="control-group">
																	<label for="kd_produk" class="control-label">Kode Produk</label>
																	<div class="controls with-tooltip">
																		<input  type="text" name="kd_produk" id="kd_produk" class="span5 input-tooltip" value="" data-original-title="kd produk" data-placement="bottom" />
																		<span class="help-inline"></span>
																	</div>                                                                
																</div>
															</div>
														</div>
													</div>
													<div class="row-fluid">
														<div class="span12">
															<div class="span6">
																<div class="control-group">
																	<label for="nama_obat" class="control-label">Nama Obat</label>
																	<div class="controls with-tooltip">
																		<input   type="text" name="nama_obat" id="nama_obat" class="span11 input-tooltip"
																			value="" data-original-title="nama obat / alkes" data-placement="bottom"/>
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
																	<label for="kd_satuan_kecil" class="control-label">Satuan Obat</label>
																	<div class="controls with-tooltip">
																		<select  name="kd_satuan_kecil" class="input-medium">
																		<option value="">--pilih satuan--</option>																
																			<?php
																			foreach ($datakecil as $kecil) {
																				# code...
																				
																			?>
																			<option value="<?php echo $kecil['kd_satuan_kecil'] ?>"><?php echo $kecil['satuan_kecil'] ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="help-inline"></span>
																		Pabrik Obat / Alkes
																		<select  name="kd_pabrik" class="input-large">
																		<option value="">--pilih pabrik--</option>																
																			<?php
																			foreach ($datapabrik as $pab) {
																				# code...
																			?>
																			<option value="<?php echo $pab['kd_pabrik'] ?>"><?php echo $pab['nama_pabrik'] ?></option>
																			<?php
																			}
																			?>
																		</select>
																	</div>
																</div>                                                           
															</div>														
														</div>
													</div>
													<div class="row-fluid">
														<div class="span12">
															<div class="span7">
																<div class="control-group">
																	<label for="kd_satuan_kecil" class="control-label">Kelas Therapi</label>
																	<div class="controls with-tooltip">
																		<select  name="kd_therapi" class="input-medium">
																		<option value="">--pilih Kelas--</option>																
																			<?php
																			foreach ($datatherapi as $therapi) {
																				# code...
																			?>
																			<option value="<?php echo $therapi['kd_therapi'] ?>"><?php echo $therapi['therapi'] ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="help-inline"></span>
																		FORNAS
																		<select  id="fornas" name="fornas" class="input-medium">
																		<option value="">--pilih--</option>																
																			<option value="1">FORNAS</option>
																			<option value="0">NON FORNAS</option>
																		</select>
																	</div>
																</div>                                                           
															</div>														
														</div>
													</div>
													<div class="row-fluid">
														<div class="span12">
															<div class="span6">
																<div class="control-group">
																	<label for="kd_golongan" class="control-label">Golongan</label>
																	<div class="controls with-tooltip">
																		<select  id="kd_golongan" name="kd_golongan" class="input-medium">
																		<option value="">--pilih golongan--</option>																
																			<?php
																			foreach ($datagolongan as $gol) {
																				# code...
																			?>
																			<option value="<?php echo $gol['kd_golongan'] ?>"><?php echo $gol['golongan'] ?></option>																			
																			<?php
																			}
																			?>
																		</select>
																		<span class="help-inline"></span>
																		Nomenklatur
																		<select  id="kd_sub" name="kd_sub" class="input-medium">
																		<option value="">--pilih sub--</option>																
																			<?php
																			foreach ($datasub as $sub) {
																				# code...
																			?>
																			<option value="<?php echo $sub['kd_sub'] ?>"><?php echo $sub['sub_golongan'] ?></option>
																			
																			<?php
																			}
																			?>
																		</select>
																	</div>
																</div>
															</div>													
														</div>
													</div>
													<div class="row-fluid">
														<div class="span12">
															<div class="span5">
																<div class="control-group">
																	<label for="harga_dasar" class="control-label">Isi Satuan Kecil</label>
																	<div class="controls with-tooltip">
																		<input  align="right" type="text" name="isi_kemasan" id="isi_kemasan" class="span4 input-tooltip"
																			value="1" data-placement="bottom"/>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="row-fluid">
														<div class="span12">
															<div class="span5">
																<div class="control-group">
																	<label for="harga_dasar" class="control-label"> Satuan Kemasan Kecil</label>
																	<div class="controls with-tooltip">
																		<input  align="right" type="text" name="satuan_kecil" id="satuan_kecil" class="span4 input-tooltip"
																			value="" data-placement="bottom"/>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="row-fluid">
														<div class="span12">
															<div class="span5">
																<div class="control-group">
																	<label for="harga_dasar" class="control-label">Harga Beli RFS</label>
																	<div class="controls with-tooltip">
																		<input  align="right" type="text" name="harga_beli" id="harga_beli" class="span4 input-tooltip"
																			value="" data-original-title="harga beli rfs" data-placement="bottom"/>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="row-fluid">
														<div class="span12">
															<div class="span5">
																<div class="control-group">
																	<label for="harga_beli" class="control-label">Harga Jual RFS</label>
																	<div class="controls with-tooltip">
																		<input  align="right" type="text" name="harga_jual" id="harga_jual" class="span4 input-tooltip"
																			value="" data-original-title="harga jual RFS" data-placement="bottom"/>
																		<span class="help-inline"></span>
																	</div>
																</div>
															</div>
														</div>
													</div>	
													<div class="row-fluid">
														<div class="span12">
															<div class="span5">
																<div class="control-group">
																	<label for="harga_apbd" class="control-label">Harga APBD 1</label>
																	<div class="controls with-tooltip">
																		<input  align="right" type="text" name="harga_apbd" id="harga_apbd" class="span4 input-tooltip"
																			value="" data-original-title="harga apbd" data-placement="bottom"/>
																		<span class="help-inline"></span>
																	</div>
																</div>
															</div>
														</div>
													</div>	
													<div class="row-fluid">
														<div class="span12">
															<div class="span5">
																<div class="control-group">
																	<label for="harga_p3k" class="control-label">Harga APBD 2</label>
																	<div class="controls with-tooltip">
																		<input  align="right" type="text" name="harga_p3k" id="harga_p3k" class="span4 input-tooltip"
																			value="" data-original-title="harga_p3k" data-placement="bottom"/>
																		<span class="help-inline"></span>
																	</div>
																</div>
															</div>
														</div>
													</div>																	
													<div class="row-fluid">
														<div class="span12">
															<div class="span5">
																<div class="control-group">
																	<label for="harga_buffer" class="control-label">Harga LAIN LAIN</label>
																	<div class="controls with-tooltip">
																		<input  align="right" type="text" name="harga_buffer" id="harga_buffer" class="span4 input-tooltip"
																			value="" data-original-title="harga buffer" data-placement="bottom"/>
																		<span class="help-inline"></span>
																	</div>
																</div>
															</div>
														</div>
													</div>				
													<div class="row-fluid">
														<div class="span12">
															<div class="span5">
																<div class="control-group">
																	<label for="harga_jpkmm" class="control-label">Harga JPKMM</label>
																	<div class="controls with-tooltip">
																		<input  align="right" type="text" name="harga_jpkmm" id="harga_jpkmm" class="span4 input-tooltip"
																			value="" data-original-title="harga jpkmm" data-placement="bottom"/>
																		<span class="help-inline"></span>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="row-fluid">
														<div class="span12">
															<div class="span5">
																<div class="control-group">
																	<label for="harga_program" class="control-label">Harga Program</label>
																	<div class="controls with-tooltip">
																		<input  align="right" type="text" name="harga_program" id="harga_program" class="span4 input-tooltip"
																			value="" data-original-title="harga program" data-placement="bottom"/>
																		<span class="help-inline"></span>
																	</div>
																</div>
															</div>
														</div>
													</div>			
													<div class="row-fluid">
														<div class="span12">
															<div class="span5">
																<div class="control-group">
																	<label for="harga_dak" class="control-label">Harga APBN</label>
																	<div class="controls with-tooltip">
																		<input  align="right" type="text" name="harga_dak" id="harga_dak" class="span4 input-tooltip"
																			value="" data-original-title="harga dak" data-placement="bottom"/>
																		<span class="help-inline"></span>
																	</div>
																</div>
															</div>
														</div>
													</div>			
																           
												</div>
											</div>
											
											<div class="row-fluid">
												<div class="span12">
													<div class="box error">
														<header>
														<!-- .toolbar -->
															<div class="icons"><i class="icon-edit"></i></div>
															<?php if($this->session->userdata('kd_unit_apt')==$this->session->userdata('kd_unit_apt_gudang')) { ?>
																		<h5>SETTING MIN.STOK & EOQ OBAT : <?php if($unit=$this->mobat->ambilNamaUnit($this->session->userdata('kd_unit_apt'))) echo strtoupper($unit); ?></h5>
															<?php } else { ?>
																		<h5>SETTING MIN.STOK OBAT : <?php if($unit=$this->mobat->ambilNamaUnit($this->session->userdata('kd_unit_apt'))) echo strtoupper($unit); ?></h5>
															<?php } ?>
														<!-- /.toolbar -->
														</header>
														<div id="div-2" class="accordion-body collapse in body">
															<div class="row-fluid">
																	<div class="span12">
																		<div class="span5">
																			<div class="control-group">
																				<label for="min_stok" class="control-label">Minimum Stok</label>
																				<div class="controls with-tooltip">
																					<input align="right" type="text" name="min_stok" id="min_stok" class="span3 input-tooltip"
																						value="" data-original-title="min stok" data-placement="bottom"/>
																					<span class="help-inline"></span>
																				</div>
																			</div>
																		</div>																	
																	</div>																
																</div>
															<?php if($this->session->userdata('kd_unit_apt')==$this->session->userdata('kd_unit_apt_gudang')) { ?>
																	<div class="row-fluid">
																		<div class="span12">
																			<div class="span5">
																				<div class="control-group">
																					<label for="max_stok" class="control-label">EOQ</label>
																					<div class="controls with-tooltip">
																						<input align="right" type="text" name="max_stok" id="max_stok" class="span3 input-tooltip"
																							value="" data-original-title="max stok" data-placement="bottom"/>
																						<span class="help-inline"></span>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
															<? } ?>	
														</div>
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
															<li><button class="btn" type="button" id="tambahbaris"> <i class="icon-plus"></i> Tambah Barcode</button></li>
															<li><button class="btn" type="button" id="hapusbaris"> <i class="icon-remove"></i> Hapus Barcode</button></li>
														</ul>
													</div>
												<!-- /.toolbar -->
												</header>
												<div class="body collapse in" id="defaultTable">
													<table class="table responsive">
														<thead>
															<tr>
																<th class="header">&nbsp;</th>
																<th class="header">Kode Barcode</th>
																<th class="header">Satuan</th>
																<th class="header">Deskripsi</th>
																<th class="header">fractions</th>																
															</tr>
														</thead>
														<tbody id="bodyinput">
														</tbody>
													</table>																									
												</div>
											</div>
										</div>
									</div>

															<div class="control-group">
																<label for="text2" class="control-label">&nbsp;</label>
																<div class="controls with-tooltip">
																	<!--button class="btn btn-primary" id="simpansetting" type="button"> <i class="icon-ok"></i> Simpan</button-->
																	<button class="btn btn-primary" type="submit"><i class="icon-ok"></i> Simpan Obat</button>
																	<button class="btn " type="reset"><i class="icon-undo"></i> Reset</button>
																</div>
															</div>
															<div id="progress" style="display:none;"></div>

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

	$('input').live('keydown', function(e) {
            if(e.keyCode == 13){
                return false;                                    
            }
        });

	$('#tambahbaris').click(function(){
		var satuan="<select  name='kd_satuan_barcode[]' class='input-medium'>"

			<?php foreach ($datakecil as $kecil) {
			?>
			satuan +="<option value=\"<?php echo $kecil['kd_satuan_kecil'] ?>\"><?php echo $kecil['satuan_kecil'] ?></option>";
			<?php
			}
			?>
		satuan +="</select>";

		$('#bodyinput').append('<tr><td style="text-align:center;"><input type="checkbox" class="barisinput cleared" /></td>'+
									'<td><input type="text" name="kd_barcode[]"  value="" class="input-medium bariskodeobat cleared"></td>'+
									'<td>'+satuan+'</td>'+
                                    '<td><input type="text" name="deskripsi[]"  value="" autocomplete="off" style="width:300px !important;" class="input-large barisnamaobat cleared"></td>'+
                                    '<td><input type="text" name="fractions[]" required value="" style="text-align:right;" class="input-small barisqty cleared"></td>'+
                                '</tr>');
		
		$("#bodyinput tr:last input[name='kd_barcode[]']").focus();
        $("#bodyinput tr:last").addClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty


        $(function() {
            $( "#tesxx" ).draggable();
        });
		
		
		$('.barisqty, .barisnamaobat, .bariskodeobat').click(function(){  
                $('#bodyinput tr').removeClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty
                $(this).parent().parent('tr').addClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty
		});	
		

        $('.bariskodeobat').keyup(function(e){
            if(e.keyCode == 13){
                $('.focused').find('.barisnamaobat').focus();
                return false;
            }
        });

      
        $('.barisnamaobat').keyup(function(e){
            if(e.keyCode == 13){
                $('.focused').find('.barisqty').focus();
                return false;
            }
        });

       $('.barisqty').keyup(function(e){
            if(e.keyCode == 13){
            	 $('#tambahbaris').trigger('click');
            }

        });
	
		
	}); //akhir function tambah baris
	
	$('#hapusbaris').click(function(){
         $('.barisinput:checked').parents('tr').remove();
    });

	$('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });
	
	$('#kd_kategori').change(function(){
		if($(this).val()=="CTK"){
			//$('#kd_sumber').text('Simpan Transfer');
			$('#kd_sumber').prop("disabled", false);
		}
		else {
			$('#kd_sumber').prop("disabled", true);
		}
	})
	
	$('#kd_golongan').change(function(){
		$.ajax({
			url: '<?php echo base_url() ?>index.php/masterapotek/obat/cekgolongan/',
			async:false,
			type:'get',
			data:{query:$('#kd_golongan').val()},
			success:function(data){
				var gol=data;
				if(gol=="OBAT"){
					$('#kd_sub').prop("disabled", false);
					$('#kd_sub').focus();
				}else {
					$('#kd_sub').prop("disabled", true);
					$('#ket_obat').focus();
				}
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
