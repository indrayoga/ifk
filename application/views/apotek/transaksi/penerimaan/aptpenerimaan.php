<script src="<?php echo base_url(); ?>assets/js/mousetrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/mousetrap-global-bind.min.js"></script> 
<script type="text/javascript">
	Mousetrap.bindGlobal('ctrl+r', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/tambahpenerimaanapt'; return false;});
	Mousetrap.bindGlobal('f7', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptpenerimaan'; return false;});
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
                                            <h5>PENCARIAN DATA PENERIMAAN</h5>							
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a href="<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/tambahpenerimaanapt"> <i class="icon-plus"></i> Tambah Penerimaan / (Ctrl + R)</a></li>
                                                    <li><a href="<?=base_url('index.php/transapotek/laporanapt/rl1excelpenerimaanobat/'.$periodeawal.'/'.$periodeakhir)?>"> <i class="icon-print"></i> Cetak</a></li>    
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
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/aptpenerimaan">
												<div class="row-fluid">
													<div class="span12">
														<div class="span4">
															<div class="control-group">
																<label for="no_penerimaan" class="control-label">No Penerimaan</label>
																<div class="controls with-tooltip">
																	<input type="text" id="no_penerimaan" name="no_penerimaan" class="input-medium input-tooltip" data-original-title="masukkan no penerimaan yang ingin dicari" data-placement="bottom"/>												
																</div>
															</div>
														</div>
														<div class="span6">
															<div class="control-group">
																<label for="kd_supplier" class="control-label">Distributor</label>
																<div class="controls with-tooltip">
																	<select id="kd_supplier" name="kd_supplier" class="input-xlarge">
																		<option value="">--pilih distributor--</option>
																		<?php
																		foreach ($datasupplier as $supplier) {
																			# code...
																			if ($supplier['kd_supplier']== $kd_supplier){
																					$cek = "selected=selected";
																				}
																				else {
																					$cek = "";
																				}
																		?>
																		<option value="<?php echo $supplier['kd_supplier'] ?>" <?php echo $cek; ?>><?php echo $supplier['nama'] ?></option>
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
													<label for="periodeawal" class="control-label">Periode</label>
													<div class="controls with-tooltip">
														<input type="text" id="periodeawal" name="periodeawal" class="input-small input-tooltip" data-mask="99-99-9999"
															   value="<?php echo $periodeawal ?>" data-original-title="masukkan tanggal awal" data-placement="bottom"/>
															   -
														<input type="text" id="periodeakhir" name="periodeakhir" class="input-small input-tooltip" data-mask="99-99-9999"
															   value="<?php echo $periodeakhir ?>" data-original-title="masukkan tanggal akhir" data-placement="bottom"/>
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
                                            <h5>DAFTAR TRANSAKSI PENERIMAAN OBAT / ALKES</h5>
                                        </header>
                                        <div id="collapse4" class="body">
                                            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                                <thead>
                                                    <tr> 
                                                        <th width="14%" style="text-align:center;">Nomor</th>
                                                        <th width="14%" style="text-align:center;">No Faktur</th>
														<th width="22%" style="text-align:center;">Nama Distributor</th>
														<th width="11%" style="text-align:center;">Tanggal</th>														
														<th width="19%" style="text-align:center;">Sumber</th>
                                                        <th width="17%" style="text-align:center;">Status</th>
                                                        <th width="17%" style="text-align:center;">Total</th>
														<th style="text-align:center;">Pilihan</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="with-tooltip">
													<?php
														//$no=1;
														foreach($items as $item){
														//debugvar($items);
														if($item['posting']=="1"){
															$posting="Tutup Faktur";
														}else{
															$posting="&nbsp;";
														}
                                                        $query=$this->db->query('select sum(qty_kcl*harga_pokok) as jumlah from apt_penerimaan_detail where no_penerimaan="'.$item['no_penerimaan'].'"');
													    $total=$query->row_array();
                                                    ?>
													<tr class="showmodal input-tooltip" id="<?php echo $item['no_penerimaan']; ?>" data-original-title="double click untuk detil">
														<td style="text-align:center;"><?php echo $item['no_penerimaan']; ?></td>
														<td style="text-align:center;"><?php echo $item['no_faktur']; ?></td>
														<td><?php echo $item['nama']; ?></td>
														<td style="text-align:center;"><?php echo $item['tgl_penerimaan'] ?></td>
														<td><?php echo $item['nama_unit_apt']; ?>&nbsp;</td>
														<td style="text-align:center;"><?php echo $posting; ?></td>														
                                                        <td><?php echo number_format($total['jumlah'],0,'','.'); ?>&nbsp;</td>
														<td style="text-align:center;width:160px;">
                                                            <a href="<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/tambahobatpenerimaan/<?php echo $item['no_penerimaan'] ?>" class="btn"><i class="icon-edit"></i> Tambah Obat</a>
                                                            <a href="<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/detilpenerimaan/<?php echo $item['no_penerimaan'] ?>" class="btn"><i class="icon-edit"></i> Detil</a>
                                                            <a target="_newtab" href="<?php echo base_url() ?>third-party/fpdf/buktipenerimaan.php?no_penerimaan=<?php echo $item['no_penerimaan'] ?>" class="btn"><i class="icon-edit"></i> Cetak</a>
                                                            <?php
                                                            $itemx=$this->mpenerimaanapt->ambilItemDataxx('apt_penerimaan_detail','no_penerimaan="'.$item['no_penerimaan'].'" ');
                                                            if(count($itemx)<1){
                                                            ?>
                                                            <a href="#" onClick="xar_confirm('<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/hapuspenerimaan/<?php echo $item['no_penerimaan'] ?>','Apakah Anda ingin menghapus data ini?')" class="btn btn-danger"><i class="icon-remove"></i> Hapus</a>
                                                            <?php
                                                            }
                                                            ?>
                                                            <?php
                                                            if($item['posting']){
                                                                ?>
                                                                &nbsp;
                                                                    <?php
                                                            }else{
                                                            ?>
                                                            <a href="#" onClick="xar_confirm('<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/hapuspenerimaan/<?php echo $item['no_penerimaan'] ?>','Apakah Anda ingin menghapus data ini?')" class="btn btn-danger"><i class="icon-remove"></i> Hapus</a>
                                                            <?php
                                                            }
                                                            ?>																		
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
			
			<div aria-hidden="true" aria-labelledby="approveModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="detilmodal" style="display: none;width:97%;margin-left:-0;left:10px;top:5px;">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                   <!--
                    <div class="toolbar pull-right" style="height:auto;">
                        <ul class="nav nav-tabs">
                            <li><button class="btn" href="<?php echo base_url() ?>index.php/penerimaan/tambahpenerimaan"> <i class="icon-plus"></i> Tambah</button></li>
                        </ul>
                    </div>   
                    -->                 
                    <h3 id="helpModalLabel"><i class="icon-external-link"></i> Detil Penerimaan</h3>
                </div>
                <div class="modal-body" style="">
                    <div class="body" id="collapse4">
                        <table class="table table-condensed responsive">
                            <tr>
                                <td>No Penerimaan</td>
                                <td id="tdpenerimaan">: </td> 
								<td>Jumlah Transaksi</td>
                                <td id="tdjumtransaksi">: </td>								
                            </tr>
                            <tr>
                                <td>Tgl. Penerimaan</td>
                                <td id="tdtanggalterima">: </td> 
								<td>Shift</td>
                                <td id="tdshift">: </td>
								
                            </tr>
                            <tr>
                                <td>Tgl. Jatuh Tempo</td>
                                <td id="tdtanggaltempo">:  </td>
								<td>Tutup Faktur</td>
                                <td id="tdtutup">: </td>								
                            </tr>
                            <tr>
								<td>No. Faktur</td>
                                <td id="tdnofaktur">: </td> 
								<td>Distributor</td>
                                <!--td id="tdkdsupplier">: </td-->
								<td id="tdnamasupplier">: </td>								
                            </tr>
                            <tr>
                                <td>Tgl. Faktur</td>
                                <td id="tdtglfaktur">: </td>
								<td>Keterangan</td>
                                <td id="tdketerangan">: </td>								
                            </tr>
							<tr>
								<td>Materai</td>
                                <td id="tdmaterai">:  </td>
								<td>Discount</td>
                                <td id="tddiscount">: </td>
							</tr>
                        </table>
                        <table class="table table-bordered responsive">
                            <thead>
                                <tr>
                                    <th class="header">&nbsp;</th>
                                    <th class="header" style="text-align:center;">Nama Obat</th>
                                    <th class="header" style="text-align:center;">Satuan</th>
                                    <th class="header" style="text-align:center;">Tgl. Expire</th>
                                    <th class="header" style="text-align:center;">Qty B</th>
									<th class="header" style="text-align:center;">Qty K</th>
									<th class="header" style="text-align:center;">Harga B</th>
									<!--th class="header">Harga R</th-->
									<th class="header" style="text-align:center;">Disc.%</th>
									<th class="header" style="text-align:center;">Harga Disc.</th>
									<th class="header" style="text-align:center;">Jumlah</th>
									<th class="header" style="text-align:center;">PPN %</th>
									<th class="header" style="text-align:center;">Bonus</th>
									<th class="header" style="text-align:center;">Total</th>
                                </tr>
                            </thead>
                            <tbody id="bodyinput">
                            </tbody>
                            <tfoot>
                                 <tr>
                                    <th class="header">&nbsp;</th>
                                    <th class="header">&nbsp;</th>
                                    <th class="header">&nbsp;</th>
									<th class="header">&nbsp;</th>
									<th class="header">&nbsp;</th>
									<th class="header">&nbsp;</th>
									<th class="header">&nbsp;</th>
									<th class="header">&nbsp;</th>
									<th class="header">&nbsp;</th>
									<th class="header">&nbsp;</th>
									<th class="header">&nbsp;</th>									
                                    <th class="header">T O T A L</th>
                                    <th class="header" id="tdtotal" style="text-align:right;"> </th>
                                </tr>
                           </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-success" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="#" id="detilcetak"> <i class="icon-print"></i> Cetak</a>
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
            url: '<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/ambilitem/',
            async:false,
            type:'get',
            data:{query:$(this).attr('id')},
            success:function(data){
                //typeahead.process(data)
                    $('#tdpenerimaan').html('');
                    $('#tdtanggalterima').html('');
					$('#tdnofaktur').html('');
					$('#tdtglfaktur').html('');
                    $('#tdshift').html('');
					$('#tdlunas').html('');
                    $('#tdtutup').html('');
                    $('#tdtanggaltempo').html('');
                    $('#tdkdsupplier').html('');
                    $('#tdnamasupplier').html('');
                    $('#tdmaterai').html('');
					$('#tdketerangan').html('');
					$('#tdjumtransaksi').html('');
					$('#tddiscount').html('');
					$('#detilcetak').attr('href','');
                $.each(data,function(i,l){
                    //alert(l);

                    $('#tdpenerimaan').html(': '+data.no_penerimaan);
					$('#tdtanggalterima').html(': '+data.tgl_penerimaan);
					$('#tdnofaktur').html(': '+data.no_faktur);
					$('#tdtglfaktur').html(': '+data.tgl_faktur);
					$('#tdshift').html(': '+data.shift);
					
					if(data.lunas=='1') b='Lunas';
					else b='Belum Lunas';
                    $('#tdlunas').html(': '+b);
					
					if(data.posting=='1') c='Tutup Faktur';
					else c='Belum Tutup Faktur';
                    $('#tdtutup').html(': '+c);
					
                    $('#tdtanggaltempo').html(': '+data.tgl_tempo);                    
                    //$('#tdkdsupplier').html(': '+data.kd_supplier);					
					$('#tdnamasupplier').html(': '+data.nama);
					$('#tdmaterai').html(': '+addCommas(data.materai));
					$('#tdketerangan').html(': '+data.keterangan);
					$('#tdjumtransaksi').html(': '+addCommas(data.jumlah));
					$('#tddiscount').html(': '+addCommas(data.discount));
					$('#detilcetak').attr('href','<?php echo base_url() ?>third-party/fpdf/buktipenerimaan.php?no_penerimaan='+data.no_penerimaan);
					$('#detilcetak').attr('target','_blank');
                });
                
            },
            dataType:'json'                         
        }); 

        $.ajax({
            url: '<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/ambilitems/',
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
                    totalall=totalall+parseInt(l.total1);
                    //$('#bodyinput').append('<tr><td>'+no+'</td><td>'+l.nama_obat+'</td><td style="text-align:center;">'+l.satuan_kecil+'</td><td style="text-align:center;">'+l.tgl_expire+'</td><td style="text-align:center;">'+l.qty_box+'</td><td style="text-align:center;">'+l.qty_kcl+'</td><td>'+addCommas(l.harga_beli)+'</td><td>'+addCommas(l.sum)+'</td><td>'+l.disc_prs+'</td><td>'+addCommas(l.harga_belidisc)+'</td><td>'+addCommas(l.jum)+'</td><td>'+l.ppn_item+'&nbsp;</td><td style="text-align:right;">'+addCommas(l.total1)+'</td></tr>');
					$('#bodyinput').append('<tr><td>'+no+'</td><td>'+l.nama_obat+'</td><td style="text-align:center;">'+l.satuan_kecil+'</td><td style="text-align:center;">'+l.tgl_expire+'</td><td style="text-align:center;">'+l.qty_box+'</td><td style="text-align:center;">'+l.qty_kcl+'</td><td style="text-align:right;">'+addCommas(l.harga_beli)+'</td><td style="text-align:center;">'+l.disc_prs+'</td><td style="text-align:right;">'+addCommas(l.harga_belidisc)+'</td><td style="text-align:right;">'+addCommas(l.jum)+'</td><td style="text-align:center;">'+l.ppn_item+'&nbsp;</td><td style="text-align:center;">'+l.bonus+'&nbsp;</td><td style="text-align:right;">'+addCommas(l.total1)+'</td></tr>');
                    no++;
                });
                $('#tdtotal').html(addCommas(totalall));
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
