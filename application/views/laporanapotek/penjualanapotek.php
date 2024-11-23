
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
                                            <h5>LAPORAN PENJUALAN OBAT PER RESEP</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a target="_blank" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>third-party/fpdf/laporanpenjualanapotek.php?periodeawal=<?php echo $periodeawal ?>&periodeakhir=<?php echo $periodeakhir; ?>&shiftapt=<?php echo $shiftapt; ?>&is_lunas=<?php echo $is_lunas; ?>&resep=<?php echo $resep; ?>"> <i class="icon-print"></i> PDF</a></li>
                                                    <li>
                                                        <a class="accordion-toggle minimize-box" data-toggle="collapse" href="#div-1">
                                                            <i class="icon-chevron-up"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- /.toolbar value="<-?php echo $periodeawal; ?>"-->
                                        </header>
                                        <div id="div-1" class="accordion-body collapse in body">
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/laporanapt/penjualanapotek">
                                                <div class="row-fluid">
													<div class="span12">
														<div class="span5">
															<div class="control-group">
																<label for="periodeawal" class="control-label">Tgl. Penjualan</label>
																<div class="controls with-tooltip">
																	<input type="text" id="periodeawal" name="periodeawal" class="input-small input-tooltip" data-mask="99-99-9999"
																		   data-original-title="masukkan tanggal awal" value="<?php echo $periodeawal?>" data-placement="bottom"/>
																		   s/d
																	<input type="text" id="periodeakhir" name="periodeakhir" class="input-small input-tooltip" data-mask="99-99-9999"
																		   data-original-title="masukkan tanggal akhir" value="<?php echo $periodeakhir?>" data-placement="bottom"/>
																</div>
															</div> 
														</div>
													</div>
												</div>
												<div class="row-fluid">												
                                                    <div class="span12">
                                                        <div class="span5">
                                                            <div class="control-group">
                                                                <label for="shiftapt" class="control-label">Shift</label>
                                                                <div class="controls with-tooltip">
                                                                    <select name="shiftapt" id="shiftapt" class="input-medium">
																		<option value="" <?php if($shiftapt=='0') echo "selected=selected"; ?>>Semua Shift</option>
                                                                        <option value="1" <?php if($shiftapt=='1') echo "selected=selected"; ?>>1</option>
                                                                        <option value="2" <?php if($shiftapt=='2') echo "selected=selected"; ?>>2</option>                                                                        
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
                                                                <label for="is_lunas" class="control-label">Status Bayar</label>
                                                                <div class="controls with-tooltip">
                                                                    <select name="is_lunas" id="is_lunas" class="input-medium">
																		<option value="" <?php if($is_lunas=='') echo "selected=selected"; ?>> Semua </option>
                                                                        <option value="0" <?php if($is_lunas=='0') echo "selected=selected"; ?>> Belum Lunas </option>
                                                                        <option value="1" <?php if($is_lunas=='1') echo "selected=selected"; ?>> Lunas </option>                                                                        
                                                                    </select>	
																	<select name="resep" id="resep" class="input-medium">
																		<option value="" <?php if($resep=='2') echo "selected=selected"; ?>>Semua</option>
																		<option value="0" <?php if($resep=='0') echo "selected=selected"; ?>>Tanpa Resep</option>
                                                                        <option value="1" <?php if($resep=='1') echo "selected=selected"; ?>>Dengan Resep</option>                                                                                                                                                
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
                                                    <tr style="font-size:90% !important;">
                                                        <th style="text-align:center;">No</th>
                                                        <th style="text-align:center;">No. Penjualan</th>
														<th style="text-align:center;">Tgl. Penjualan</th>
                                                        <th style="text-align:center;">Nama Pasien</th>
                                                        <th style="text-align:center;">Resep</th>
														<th style="text-align:center;">Jml. Trans.</th>
														<th style="text-align:center;">Status</th>														
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no=1;
                                                    foreach ($items as $item) {
														if($item['resep']=="1"){
															$resep="Ya";
														}else{
															$resep="Tidak";
														}
                                                    ?>
                                                        <tr style="font-size:90% !important;">
                                                            <td style="text-align:center;"><?php echo $no."."; ?></td>
                                                            <td style="text-align:center;"><?php echo $item['no_penjualan'] ?></td>
                                                            <td style="text-align:center;"><?php echo convertDate($item['tgl_penjualan']) ?></td>
															<td><?php echo $item['nama_pasien'] ?></td>
															<td style="text-align:center;"><?php echo $resep ?></td>
															<!--td style="text-align:right;"><-?php echo number_format($item['adm_resep']) ?></td-->
															<td style="text-align:right;"><?php echo number_format($item['total_transaksi']) ?></td>
															<!--td style="text-align:right;"><-?php echo number_format($item['total_bayar']) ?></td-->
															<?php if($item['is_lunas']==1){ $status="Lunas";} else {$status="Belum Lunas";}?>
															<td style="text-align:center;"><?php echo $status ?></td>
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
	
	/*$('#tgl_tempo').datepicker({
		format: 'yyyy-mm-dd'
	});*/
</script>