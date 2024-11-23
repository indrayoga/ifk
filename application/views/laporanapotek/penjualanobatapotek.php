
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
                                            <h5>LAPORAN PENJUALAN OBAT </h5>
                                            
                                        </header>
                                        <div id="div-1" class="accordion-body collapse in body">
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/laporanapt/penjualanobatapotek">
                                                <div class="row-fluid">
													<div class="span12">
														<div class="span6">
															<div class="control-group">
																<label for="periodeawal" class="control-label">Tgl. Penjualan</label>
																<div class="controls with-tooltip">
																	<input type="text" id="periodeawal" name="periodeawal" class="input-small input-tooltip" data-mask="99-99-9999"
																		   value="<?php echo $periodeawal ?>" data-original-title="masukkan tanggal awal" value="<?php echo $periodeawal?>" data-placement="bottom"/>
																		   s/d
																	<input type="text" id="periodeakhir" name="periodeakhir" class="input-small input-tooltip" data-mask="99-99-9999"
																		   value="<?php echo $periodeakhir ?>" data-original-title="masukkan tanggal akhir" value="<?php echo $periodeakhir?>" data-placement="bottom"/>
																</div>
															</div> 
														</div>
													</div>
												</div>
												<div class="row-fluid">
													<div class="span12">														
														<div class="span6">
                                                            <div class="control-group">
																<label for="kd_unit_apt" class="control-label">Sumber Dana</label>
																<div class="controls with-tooltip">
																		<select  class="input-xlarge cleared" name="kd_unit_apt" id="kd_unit_apt">
																			<option value="">Pilih Sumber Dana</option>
																			<?php
																			foreach ($sumberdana as $sd) {
																				$select="";
																				if(isset($kd_unit_apt)){
																					if($kd_unit_apt==$sd['kd_unit_apt'])$select="selected=selected";else $select="";
																				}
																		
																			?>
																				<option value="<?php if(!empty($sd)) echo $sd['kd_unit_apt'] ?>" <?php echo $select; ?>><?php echo $sd['nama_unit_apt'] ?></option>
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
                                            <div class="icons"><i class="icon-move"></i></div>
                                            <h5></h5>
                                        </header>
                                        <div id="collapse4" class="body">
                                            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                                <thead>
                                                    <tr style="font-size:90% !important;" >
                                                        <th style="text-align:center;">No</th>
                                                        <th style="text-align:center;">No. Resep</th>
                                                        <th style="text-align:center;">Tgl. Resep</th>
                                                        <th style="text-align:center;">Nama Obat</th>
                                                        <th style="text-align:center;">Sumber Dana</th>
                                                        <th style="text-align:center;">Sat</th>
                                                        <th style="text-align:center;">Qty</th>
														<th style="text-align:center;">Tgl.Expire</th>
														<th style="text-align:center;">Harga</th>
														<th style="text-align:center;">Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no=1;
                                                    foreach ($items as $item) {
														$jumlah=$item['harga_jual'] * $item['qty'];
                                                    ?>
                                                        <tr style="font-size:80% !important;">
                                                            <td style="text-align:center;"><?php echo $no; ?></td>
                                                            <td style="text-align:center;"><?php echo $item['no_penjualan'] ?></td>
                                                            <td style="text-align:center;"><?php echo convertDate($item['tgl_penjualan']) ?></td>
                                                            <td><?php echo $item['nama_obat'] ?></td>
                                                            <td><?php echo $item['nama_unit_apt'] ?></td>
															<td style="text-align:center;"><?php echo $item['satuan_kecil'] ?></td>
															<td style="text-align:right;"><?php echo number_format($item['qty'],2,',','.') ?></td>
															<td style="text-align:center;"><?php echo convertDate($item['tgl_expire']) ?></td>														
															<td style="text-align:right;"><?php echo number_format($item['harga_jual'],2,',','.') ?></td>
                                                        	<td style="text-align:right;"><?php echo number_format($jumlah,2,',','.') ?></td>
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
	
	$('#periodeawal').datepicker({
		format: 'dd-mm-yyyy'
	});
			
	$('#periodeakhir').datepicker({
		format: 'dd-mm-yyyy'
	});
	
	$('#tgl_tempo').datepicker({
		format: 'dd-mm-yyyy'
	});
</script>