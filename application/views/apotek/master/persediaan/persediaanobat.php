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
                                            <h5>PERSEDIAAN OBAT / ALKES UNIT : <?php if($unit=$this->mpersediaanobat->ambilNamaUnit($this->session->userdata('kd_unit_apt'))) echo strtoupper($unit); ?></h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <!--li><a target="_blank" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>third-party/fpdf/laporanpersediaanapotek.php?kd_jenis_obat=<?php echo $kd_jenis_obat ?>&kd_sub_jenis=<?php echo $kd_sub_jenis; ?>&kd_golongan=<?php echo $kd_golongan; ?>&stok=<?php echo $stok; ?>&isistok=<?php echo $isistok; ?>&kd_unit_apt=<?php echo $kd_unit_apt; ?>"> <i class="icon-print"></i> PDF</a></li>
													<li><a target="" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/laporanapt/rl1excelpersediaanobat/<?php if(empty($stok)) echo "1"; else echo $stok; ?>/<?php if(empty($kd_jenis_obat)) echo "null"; else echo $kd_jenis_obat; ?>/<?php if(empty($isistok)) echo "null"; else echo $isistok; ?>/<?php if(empty($kd_sub_jenis)) echo "null"; else echo $kd_sub_jenis; ?>/<?php if(empty($kd_unit_apt)) echo "null"; else echo $kd_unit_apt; ?>/<?php if(empty($kd_golongan )) echo "null"; else echo $kd_golongan; ?>"> <i class="icon-print"></i> Export to Excel</a></li-->												
                                                </ul>
                                            </div>
                                            <!-- /.toolbar value="<-?php echo $periodeawal; ?>"-->
                                        </header>
                                        <div id="div-1" class="accordion-body collapse in body">
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/masterapotek/persediaan/persediaanobat">
                                                <div class="control-group">
													<label for="nama_obat" class="control-label">Nama Obat</label>
													<div class="controls with-tooltip">
                                                        <input type="text" id="nama_obat" name="nama_obat" value="<?php echo $nama_obat?>" class="span3 input-tooltip" data-original-title="masukkan nama obat yang ingin dicari" data-placement="bottom"/>												
                                                    </div>
												</div>
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
												<div class="row-fluid">												
													<div class="span12">
														<div class="span5">
															<div class="control-group">
																<label for="kd_unit_apt" class="control-label">Sumber Dana</label>
                                                                <div class="controls with-tooltip">																
                                                                    <select name="kd_unit_apt" id="kd_unit_apt" class="input-large">
                                                                    	<option value="">Semua Sumber</option>
                                                                    	<?php
                                                                    	foreach ($datasumberdana as $sumberdana) {
                                                                    		# code...
                                                                    		if($sumberdana['kd_unit_apt']==$kd_unit_apt)$sel="selected=selected"; else $sel="";
                                                                    	?>
                                                                    	<option value="<?php echo $sumberdana['kd_unit_apt'] ?>" <?php echo $sel; ?>><?php echo $sumberdana['nama_unit_apt'] ?></option>
                                                                    	<?php
                                                                    	}
                                                                    	?>
                                                                    </select>
                                                                    <span class="help-inline"></span>
                                                                </div>
                                                            </div>
														</div>
													</div>
												</div>
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">&nbsp;</label>
                                                    <div class="controls with-tooltip">
                                                        <button class="btn btn-primary" type="submit"><i class="icon-search"></i> Cari</button>
                                                        <button class="btn " type="submit" name="reset" value="reset"><i class="icon-undo"></i> Reset</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--END TEXT INPUT FIELD-->                            
                            <!--Begin Datatables-->
							<div class="row-fluid">
								<div class="span12">
									<div class="box">
										<header>
											<!--div class="icons"><i class="icon-move"></i></div-->
											<!--h5></h5-->
											<div class="toolbar" style="height:auto;float:left;">											
												<ul class="nav nav-tabs">
													<?php if($this->session->userdata('kd_unit_apt')!=$this->session->userdata('kd_unit_apt_gudang')) { ?>
															<!--li><button class="btn" id="simpanpermintaan" type="submit"  name="submit" value="simpan"> <i class="icon-save"></i> Buat Permintaan Obat</button></li-->
															<li><button class="btn" id="submitpermintaan" type="submit"  name="submit" value="simpan"> <i class="icon-save"></i> Submit Permintaan Obat</button></li>
													<?php } else { ?>
															<!--li><button class="btn" id="simpanpengajuan" type="submit"  name="submit" value="simpan"> <i class="icon-save"></i> Buat Pengajuan Obat</button></li-->
															<li><button class="btn" id="submitpengajuan" type="submit"  name="submit" value="simpan"> <i class="icon-save"></i> Submit Pengajuan Obat</button></li>
															<!--li><button id="submitpengajuan" class="btn"  data-toggle="modal" data-original-title="submit pengajuan" data-placement="bottom" rel="tooltip" href="#formsubmitpengajuan"> <i class="icon-edit"></i> Submit Pengajuan Obat</button></li-->
													<?php } ?>
													<li><a target="_blank" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>third-party/fpdf/persediaanobat.php?kd_unit_apt=<?php echo $kd_unit_apt ?>&stok=<?php echo $stok; ?>&isistok=<?php echo $isistok; ?>&nama_obat=<?php echo $nama_obat; ?>"> <i class="icon-print"></i> Export Persediaan ke PDF</a></li>												
												</ul>
											</div>
										</header>
										<div id="collapse4" class="body">
											<div class="control-group">
													<font size="3"><b>Check All Kuning</b></font>
													<input type='checkbox' name='chk' id="chk" value='kuning'>
													<span class="help-inline"></span>
													<font size="3"><b>Check All Merah</b></font>
													<input type='checkbox' name='chk1' id="chk1" value='merah'>
											</div>
											<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
												<thead>
													<tr style="font-size:95% !important;">
														<th style="text-align:center;background-color: green;"></th>
														<th style="text-align:center;background-color: green;"><font color="white">Kode</font></th>
														<th style="text-align:center;background-color: green;"><font color="white">Nama Obat</font></th>
														<th style="text-align:center;background-color: green;"><font color="white">Satuan</font></th>																		
														<!--th style="text-align:center;background-color: green;"><font color="white">Tgl.Expire</font></th-->
														<th style="text-align:center;background-color: green;"><font color="white">Harga Dasar</font></th>
														<th style="text-align:center;background-color: green;"><font color="white">Min. Stok</font></th>
														<th style="text-align:center;background-color: green;"><font color="white">Stok</font></th>									
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
														//$tgl=$item['tgl_expire'];
															
														if($stok<=$minstok1){   
															if($stok<=0){ ?>
																<tr style="font-size:95% !important;">
																	<!--td style="text-align:center;background-color: #00FF7F;" ><input type="checkbox" value="<-?php echo $kode; echo "."; echo $tgl;?>" class="barisinput cleared" checked /></td-->
																	<td style="text-align:center;background-color: red;" ><input type="checkbox" value="<?php echo $kode; ?>" class="barisinput cleared"/></td>
																	<td style="text-align:center;background-color: red;"><font color="white"><?php echo $kode; ?></font></td>                                                            
																	<td style="background-color: red;"><font color="white"><?php echo $item['nama_obat'] ?></font></td>
																	<td style="text-align:center;background-color: red;"><font color="white"><?php echo $item['satuan_kecil'] ?></font></td>
																	<!--td style="text-align:center;background-color: red;"><font color="white"><-?php echo convertDate($item['tgl_expire']) ?></font></td-->
																	<td style="text-align:right;background-color: red;"><font color="white"><?php echo number_format($item['harga_dasar'],2,'.',','); ?></font></td>
																	<!--td style="text-align:right;background-color: #00FF7F;"><-?php echo $item['harga_pokok'] ?></td-->
																	<td style="text-align:right;background-color: red;"><font color="white"><?php echo number_format($minstok1,2,'.',','); ?></font></td>
																	<td style="text-align:right;background-color: red;"><font color="white"><?php echo number_format($stok,2,'.',','); ?></font></td>	
																</tr> 
														<?php } else { ?>
																<tr style="font-size:95% !important;">
																	<!--td style="text-align:center;background-color: #00FF7F;" ><input type="checkbox" value="<-?php echo $kode; echo "."; echo $tgl;?>" class="barisinput cleared" checked /></td-->
																	<td style="text-align:center;background-color: yellow;" ><input type="checkbox" value="<?php echo $kode;?>" class="barisinput cleared"/></td>
																	<td style="text-align:center;background-color: yellow;"><?php echo $kode; ?></td>                                                            
																	<td style="background-color: yellow;"><?php echo $item['nama_obat'] ?></td>
																	<td style="text-align:center;background-color: yellow;"><?php echo $item['satuan_kecil'] ?></td>
																	<!--td style="text-align:center;background-color: yellow;"><-?php echo convertDate($item['tgl_expire']) ?></td-->
																	<td style="text-align:right;background-color: yellow;"><?php echo number_format($item['harga_dasar'],2,'.',','); ?></td>
																	<!--td style="text-align:right;background-color: #00FF7F;"><-?php echo $item['harga_pokok'] ?></td-->
																	<td style="text-align:right;background-color: yellow;"><?php echo number_format($minstok1,2,'.',','); ?></td>
																	<td style="text-align:right;background-color: yellow;"><?php echo number_format($stok,2,'.',','); ?></td>	
																</tr>
														<?php } } else { ?>
															<tr style="font-size:95% !important;">
																<td style="text-align:center;"><input type="checkbox" value="<?php echo $kode; ?>" class="barisinput cleared" /></td>
																<td style="text-align:center;"><?php echo $kode; ?></td>                                                            
																<td><?php echo $item['nama_obat'] ?></td>
																<td style="text-align:center;"><?php echo $item['satuan_kecil'] ?></td>
																<!--td style="text-align:center;"><-?php echo convertDate($item['tgl_expire']) ?></td-->
																<td style="text-align:right;"><?php echo number_format($item['harga_dasar'],2,'.',','); ?></td>
																<!--td style="text-align:right;"><-?php echo $item['harga_pokok'] ?></td-->
																<td style="text-align:right;"><?php echo number_format($minstok1,2,'.',','); ?></td>
																<td style="text-align:right;"><?php echo number_format($stok,2,'.',','); ?></td>	
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
                            <!--End Datatables-->

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
	$('#dataTable1').dataTable({
		"aaSorting": [[ 0, "asc" ]],
		"sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "Show _MENU_ entries"
		}
	});
	
	/*$('#dataTable').on('click','#simpanpengajuan',function(){
		$.ajax({
            url: '<?php echo base_url() ?>index.php/log_transaksi/stokopname/ambilitems/',
            async:false,
            type:'get',
            data:{query:$(this).attr('id'),lokasi:$(this).attr('lokasi')},
            success:function(data){
                //typeahead.process(data)
                    $('#kd_barang2').val(data.kd_barang);
                    $('#nama_barang2').val(data.nama_barang);
                    $('#stoklama').val(data.jml_stok);
					$('#kd_lokasi1').val(data.kd_lokasi);
                    //$('#alasan').html('');                    
            },
            dataType:'json'                         
        }); 
		//$('#stokbaru').focus();
        $('#formpenyesuaian').modal("show");	
	});*/
	
	$('#chk').click(function(){
		if(document.getElementById('chk').checked){
			var row=1;
			$('.barisinput').each(function(){
				
				var color = document.getElementById('dataTable').rows[row].cells[0].style.backgroundColor;
				row++;
				if(color=='yellow'){
					$(this).attr('checked', true);
				}				
			});
		}
		else{
			var baris=1;
			$('.barisinput').each(function(){
				var color = document.getElementById('dataTable').rows[baris].cells[0].style.backgroundColor;
				baris++;
				if(color=='yellow'){
					$(this).attr('checked', false);
				}
				//$(this).attr('checked', false);
			});
		}
	});
	
	$('#chk1').click(function(){
		if(document.getElementById('chk1').checked){
			var row=1;
			$('.barisinput').each(function(){
				var color = document.getElementById('dataTable').rows[row].cells[0].style.backgroundColor;
				row++;
				if(color=='red'){
					$(this).attr('checked', true);
				}				
			});
		}
		else{
			var baris=1;
			$('.barisinput').each(function(){
				var color = document.getElementById('dataTable').rows[baris].cells[0].style.backgroundColor;
				baris++;
				if(color=='red'){
					$(this).attr('checked', false);
				}
				//$(this).attr('checked', false);
			});
		}
	});
	
	$('#submitpengajuan').click(function(){
		var ceklis="";
		$('.barisinput').each(function(){
			 if($(this).attr('checked')){
				ceklis+=$(this).val()+',';
			}
        });
		//alert(ceklis);
		if(ceklis==''){
			alert('Pilih obat dulu');
		}
		else{
			var answer = confirm("Yakin pengajuan ingin disubmit ?")
			if (answer){
				/*alert("Selamat datang di akun fb-ku")
				window.location = "http://www.facebook.com/sahili.jie";*/
				$.ajax({
					//url: '<?php echo base_url() ?>index.php/masterapotek/persediaan/submitpengajuanobat/',
					url: '<?php echo base_url() ?>index.php/masterapotek/persediaan/submitpengajuanobat/',
					async:false,
					type:'post',
					data:{query:ceklis},
					success:function(data){	
						alert("Data berhasil di submit")
						window.location.href='<?php echo base_url(); ?>index.php/masterapotek/persediaan/submit/'+data.no_submit;
					},
					dataType:'json'                         
				});
			}
			else{
				alert("Submit batal")
			}
			
		}
	})
	
	/*$('#submitpengajuan').click(function(){
		var ceklis="";
		$('.barisinput').each(function(){
			 if($(this).attr('checked')){
				ceklis+=$(this).val()+',';
			}
        });
		if(ceklis==''){
			alert('Pilih obat dulu');
		}
		else{
			//alert('harusnya si muncul form submit pengajuannyaaaaaaa........');
			//$('#formsubmitpengajuan').modal("show");
			$.ajax({
				url: '<?php echo base_url() ?>index.php/masterapotek/persediaan/submitpengajuanobat/',
				async:false,
				type:'post',
				data:{query:ceklis},
				success:function(data){				
					//alert('Pengajuan obat berhasil disimpan');
					//location.reload();
					//window.location.href="login.jsp?backurl="+window.location.href;
					//window.location.href="index.php/masterapotek/persediaan/";
					window.location.href='<?php echo base_url(); ?>index.php/masterapotek/persediaan/submit/'+data.no_submit;
				},
				dataType:'json'                         
			});
		}
	})*/
	
	/*$('#simpanpengajuan').click(function(){ 
		var ceklis="";
		$('.barisinput').each(function(){
			 if($(this).attr('checked')){
				ceklis+=$(this).val()+',';
				//alert($(this).val());
			}
        });
		//return false;
		//alert(ceklis);
		if(ceklis==''){
			alert('Pilih obat dulu');
		}
		else{
			$.ajax({
				url: '<?php echo base_url() ?>index.php/masterapotek/persediaan/simpanpengajuanobat/',
				async:false,
				type:'post',
				data:{query:ceklis},
				success:function(data){				
					alert('Pengajuan obat berhasil disimpan');
					location.reload();
				},
				dataType:'json'                         
			});
		}		 
	})*/
	
	/*$('#simpanpermintaan').click(function(){ 
		var ceklis="";
		$('.barisinput').each(function(){
			 if($(this).attr('checked')){
				ceklis+=$(this).val()+',';
			}
        });
		if(ceklis==''){
			alert('Pilih obat dulu');
		}
		else{
			$.ajax({
				url: '<?php echo base_url() ?>index.php/masterapotek/persediaan/simpanpermintaanobat/',
				async:false,
				type:'post',
				data:{query:ceklis},
				success:function(data){				
					alert('Permintaan obat berhasil disimpan');
					location.reload();
				},
				dataType:'json'                         
			});
		}		 
	})*/
	
	/*$('#simpanpermintaan').click(function(){ 
		var ceklis="";
		$('.barisinput').each(function(){
			 if($(this).attr('checked')){
				ceklis+=$(this).val()+',';
			}
        });
		if(ceklis==''){
			alert('Pilih obat dulu');
		}
		else{
			var answer = confirm("Yakin pengajuan ingin disubmit ?")
			if (answer){
				$.ajax({
					url: '<?php echo base_url() ?>index.php/masterapotek/persediaan/simpanpermintaanobat/',
					async:false,
					type:'post',
					data:{query:ceklis},
					success:function(data){				
						alert('Permintaan obat berhasil disimpan');
						window.location.href='<?php echo base_url(); ?>index.php/masterapotek/persediaan/persediaanobat';
						//location.reload();
					},
					dataType:'json'                         
				});
			}
			else {
				alert("Permintaan obat batal disimpan")
			}
		}		 
	})*/
	
	$('#submitpermintaan').click(function(){
		var ceklis="";
		$('.barisinput').each(function(){
			 if($(this).attr('checked')){
				ceklis+=$(this).val()+',';
			}
        });
		//alert(ceklis);
		if(ceklis==''){
			alert('Pilih obat dulu');
		}
		else{
			var answer = confirm("Yakin pengajuan ingin disubmit ?")
			if (answer){
				$.ajax({
					//url: '<?php echo base_url() ?>index.php/masterapotek/persediaan/submitpengajuanobat/',
					url: '<?php echo base_url() ?>index.php/masterapotek/persediaan/submitpermintaanobat/',
					async:false,
					type:'post',
					data:{query:ceklis},
					success:function(data){	
						alert("Data berhasil di submit")
						window.location.href='<?php echo base_url(); ?>index.php/masterapotek/persediaan/submitpermintaan/'+data.no_submit;
					},
					dataType:'json'                         
				});
			}
			else{
				alert("Submit batal")
			}
			
		}
	})
	
	$('.with-tooltip').tooltip({
		selector: ".input-tooltip"
	});
</script>