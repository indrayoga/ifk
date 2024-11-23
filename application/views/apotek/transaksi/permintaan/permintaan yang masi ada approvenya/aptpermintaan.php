<script src="<?php echo base_url(); ?>assets/js/mousetrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/mousetrap-global-bind.min.js"></script> 
<script type="text/javascript">
	<?php if($this->session->userdata('kd_unit_apt')!=$this->session->userdata('kd_unit_apt_gudang')) { ?>
			Mousetrap.bindGlobal('ctrl+r', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptpermintaan/tambahpermintaan'; return false;});
	<?php } ?>	
	//Mousetrap.bindGlobal('f4', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptpemesanan'; return false;});
</script>

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
                                            <h5>PENCARIAN DATA PERMINTAAN</h5>							
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
													<?php if($this->session->userdata('kd_unit_apt')!=$this->session->userdata('kd_unit_apt_gudang')) { ?>
															<li><a href="<?php echo base_url() ?>index.php/transapotek/aptpermintaan/tambahpermintaan"> <i class="icon-plus"></i> Tambah Permintaan / (Ctrl + R)</a></li>
													<?php } ?>                                                    
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
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/aptpermintaan">
												<div class="row-fluid">
													<div class="span12">
														<div class="span4">
															<div class="control-group">
																<label for="no_permintaan" class="control-label">No Permintaan</label>
																<div class="controls with-tooltip">
																	<input type="text" id="no_permintaan" name="no_permintaan" value="<?php echo $no_permintaan; ?>" class="input-medium input-tooltip" data-original-title="masukkan no permintaan yang ingin dicari" data-placement="bottom"/>												
																</div>
															</div>
														</div>														
													</div>
												</div>
												<div class="control-group">
													<label for="periodeawal" class="control-label">Periode</label>
													<div class="controls with-tooltip">
														<input type="text" id="periodeawal" name="periodeawal" class="input-small input-tooltip" data-mask="99-99-9999"
															   value="<?php echo $periodeawal?>" data-original-title="masukkan tanggal awal" data-placement="bottom"/>
															   -
														<input type="text" id="periodeakhir" name="periodeakhir" class="input-small input-tooltip" data-mask="99-99-9999"
															   value="<?php echo $periodeakhir?>" data-original-title="masukkan tanggal akhir" data-placement="bottom"/>
													</div>
												</div>                                                
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">&nbsp;</label>
                                                    <div class="controls with-tooltip">
                                                        <button class="btn btn-primary" type="submit" name="cari" value="cari"><i class="icon-search"></i> Cari</button>
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
                                            <div class="icons"><i class="icon-move"></i></div>
                                            <h5>DAFTAR TRANSAKSI PERMINTAAN OBAT / ALKES</h5>
                                        </header>
                                        <div id="collapse4" class="body">
                                            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                                <thead>
                                                    <tr> 
                                                        <th style="text-align:center;">Nomor</th>
														<th style="text-align:center;">Tanggal</th>														
														<th style="text-align:center;">Keterangan</th>														
														<th style="text-align:center;">Status Approve</th>
														<th style="text-align:center;">Status Permintaan</th>
														<th style="text-align:center;">Pilihan</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="with-tooltip">
													<?php
														//$no=1;
														foreach($items as $item){
															$status=""; $status1="";
															if($item['status_approve']==1){$status="Sudah di Approve";}
															else {$status="Belum di Approve";}
															if($item['permintaan_status']==1){$status1="Sudah di Distribusi";}
															else{$status1="Belum di Distribusi";}
													?>
															<tr class="showmodal input-tooltip" id="<?php echo $item['no_permintaan']; ?>" data-original-title="double click untuk detil">
																<td style="text-align:center;"><?php echo $item['no_permintaan']; ?></td>
																<td style="text-align:center;"><?php echo $item['tgl_permintaan'] ?></td>
																<td><?php echo $item['keterangan']; ?> </td>
																<td style="text-align:center;"><?php echo $status; ?> </td>
																<td style="text-align:center;"><?php echo $status1; ?> </td>
																<td style="text-align:center;width:160px;">
																	<?php if($item['status_approve']==0) { ?>
																		<a href="<?php echo base_url() ?>index.php/transapotek/aptpermintaan/ubahpermintaan/<?php echo $item['no_permintaan'] ?>" class="btn"><i class="icon-edit"></i> Edit</a>
																		<?php if($this->session->userdata('kd_unit_apt')!=$this->session->userdata('kd_unit_apt_gudang')) { ?>
																				<a href="#" onClick="xar_confirm('<?php echo base_url() ?>index.php/transapotek/aptpermintaan/hapuspermintaan/<?php echo $item['no_permintaan'] ?>','Apakah Anda ingin menghapus data ini?')" class="btn btn-danger"><i class="icon-remove"></i> Hapus</a>
																		<?php } ?>																		
																	<?php } else { ?>
																		<a href="<?php echo base_url() ?>index.php/transapotek/aptpermintaan/ubahpermintaan/<?php echo $item['no_permintaan'] ?>" class="btn"><i class="icon-edit"></i> Lihat Data</a>
																	<?php } ?>
																																			
																</td>
															</tr>
													<?php
														//	$no++;
														} //tutup foreach
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
			
			<div aria-hidden="true" aria-labelledby="approveModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="detilmodal" style="display: none;width:77%;margin-left:140;left:10px;top:25px;">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                   <!--
                    <div class="toolbar pull-right" style="height:auto;">
                        <ul class="nav nav-tabs">
                            <li><button class="btn" href="<-?php echo base_url() ?>index.php/penerimaan/tambahpenerimaan"> <i class="icon-plus"></i> Tambah</button></li>
                        </ul>
                    </div>   
                    -->                 
                    <h3 id="helpModalLabel"><i class="icon-external-link"></i> Detil Permintaan Obat / Alkes</h3>
                </div>
                <div class="modal-body" style="">
                    <div class="body" id="collapse4">
                        <table class="table table-condensed responsive">
                            <tr>
                                <td>No Permintaan</td>
                                <td id="tdpermintaan">: </td> 															
                            </tr>
                            <tr>
                                <td>Tgl. Permintaan</td>
                                <td id="tdtanggal">: </td> 
								
                            </tr>
                            <tr>
								<td>Keterangan</td>
                                <td id="tdketerangan">: </td>								
                            </tr>                            
							<tr>
								<td>Status Approve</td>
                                <td id="tdstatus">: </td>								
                            </tr>
							<tr>
								<td>Status Permintaan</td>
                                <td id="tdstatus1">: </td>								
                            </tr>
                        </table>
                        <table class="table table-bordered responsive">
                            <thead>
                                <tr>
                                    <th class="header">&nbsp;</th>
									<th class="header" style="text-align:center;">Kode Obat</th>
                                    <th class="header" style="text-align:center;">Nama Obat</th>
                                    <th class="header" style="text-align:center;">Satuan</th>                                    
									<th class="header" style="text-align:center;">Tgl. Expire</th> 
                                    <th class="header" style="text-align:center;">Qty</th>
									
                                </tr>
                            </thead>
                            <tbody id="bodyinput">
                            </tbody>
                            <!--tfoot>
                                 <tr>
									<th class="header">&nbsp;</th>
                                    <th class="header">&nbsp;</th>
									<th class="header">&nbsp;</th>
									<th class="header">&nbsp;</th>
									<th class="header">&nbsp;</th>
                                    <th class="header">&nbsp;</th>
                                </tr>
                           </tfoot-->
                        </table>

                    </div>
                </div>
                <div class="modal-footer">
                    <!--a class="btn btn-success" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="#" id="detilcetak"> <i class="icon-print"></i> Cetak</a-->
                    <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning">Close</button>
                </div>
            </div>


<script type="text/javascript">
	$('#dataTable').dataTable({
		"aaSorting": [[ 0, "desc" ]],
		"sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "Show _MENU_ entries"
		}
	});
	
	$('.showmodal').dblclick(function(){
        $.ajax({
            url: '<?php echo base_url() ?>index.php/transapotek/aptpermintaan/ambilitem/',
            async:false,
            type:'get',
            data:{query:$(this).attr('id')},
            success:function(data){
                //typeahead.process(data)
					//alert(data.no_distribusi);
                    $('#tdpermintaan').html(': '+data.no_permintaan);
                    $('#tdtanggal').html(': '+data.tgl_permintaan1);					
                    $('#tdketerangan').html(': '+data.keterangan);
					var status="";
					if(data.status_approve==1){status="Sudah di Approve";}
					else{status="Belum di Approve";}
					$('#tdstatus').html(': '+status);
					var status1="";
					if(data.permintaan_status==1){status1="Sudah di Distribusi";}
					else{status1="Belum di Distribusi";}
					$('#tdstatus1').html(': '+status1);
                    //$('#detilcetak').attr('href','<?php echo base_url() ?>third-party/fpdf/buktidistribusi.php?no_distribusi='+data.no_distribusi);
					//$('#detilcetak').attr('target','_blank');
                
            },
            dataType:'json'                         
        }); 

        $.ajax({
            url: '<?php echo base_url() ?>index.php/transapotek/aptpermintaan/ambilitems/',
            async:false,
            type:'get',
            data:{query:$(this).attr('id')},
            success:function(data){
                //typeahead.process(data)
                $('#bodyinput').empty();
                var no=1;
                var totalall=0;
                $.each(data,function(i,l){
                    //alert(l);
                    $('#bodyinput').append('<tr><td style="text-align:center;">'+no+'</td><td style="text-align:center;">'+l.kd_obat+'</td><td>'+l.nama_obat+'</td><td style="text-align:center;">'+l.satuan_kecil+'</td><td style="text-align:center;">'+l.tgl_expire1+'</td><td style="text-align:right;">'+l.jml_req+'</td></tr>');
                    no++;
                });
            },
            dataType:'json'                         
        }); 

        $('#detilmodal').modal("show");
    });
	
	$('#periodeawal').datepicker({
		format: 'dd-mm-yyyy'
	});
			
	$('#periodeakhir').datepicker({
		format: 'dd-mm-yyyy'
	});
			
	$('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });
</script>
