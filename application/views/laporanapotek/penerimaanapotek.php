
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
                                            <h5>LAPORAN PENERIMAAN OBAT</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a target="_blank" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>third-party/fpdf/laporanpenerimaanapotek.php?periodeawal=<?php echo $periodeawal ?>&periodeakhir=<?php echo $periodeakhir; ?>&kd_unit_apt=<?php echo $kd_unit_apt; ?>&kd_supplier=<?php echo $kd_supplier; ?>"> <i class="icon-print"></i> PDF</a></li>
                                                    <!--li><a target="" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<-?php echo base_url() ?>index.php/transapotek/laporanapt/rl1excelpenerimaan/<-?php echo $periodeawal ?>/<-?php echo $periodeakhir; ?>/<-?php echo $tgl_tempo; ?>/<-?php echo $shift; ?>/<-?php echo $kd_unit_apt; ?>/<-?php echo $kd_supplier; ?>"> <i class="icon-print"></i> Export to Excel</a></li-->
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
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/laporanapt/penerimaanapotek">
                                                <div class="row-fluid">
													<div class="span12">
														<div class="span4">
															<div class="control-group">
																<label for="periodeawal" class="control-label">Tgl. Penerimaan</label>
																<div class="controls with-tooltip">
																	<input type="text" id="periodeawal" name="periodeawal" class="input-small input-tooltip" data-mask="99-99-9999"
																		   value="<?php echo $periodeawal ?>" data-original-title="masukkan tanggal awal" value="<?php echo $periodeawal?>" data-placement="bottom"/>
																		   s/d
																	<input type="text" id="periodeakhir" name="periodeakhir" class="input-small input-tooltip" data-mask="99-99-9999"
																		   value="<?php echo $periodeakhir ?>" data-original-title="masukkan tanggal akhir" value="<?php echo $periodeakhir?>" data-placement="bottom"/>
																</div>
															</div> 
														</div>
														 <div id="div-1" class="accordion-body collapse in body">
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/laporanapt/kartustok">
                                            	 <div class="control-group">
                                                    <label for="nama_obat" class="control-label">Sumber Dana</label>
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
														<div class="span6">
                                                            <div class="control-group">
                                                                <label for="kd_supplier" class="control-label">Supplier</label>
                                                                <div class="controls with-tooltip">
                                                                    <select id="kd_supplier" name="kd_supplier" class="input-large">
                                                                        <option value="">Semua</option>
                                                                        <?php
                                                                        foreach ($datasupplier as $sup) {
                                                                            # code...
																			if ($sup['kd_supplier']== $kd_supplier){
																				$cek = "selected=selected";
																			}
																			else {
																				$cek = "";
																			}
                                                                        ?>
                                                                        <option value="<?php echo $sup['kd_supplier'] ?>" <?php echo $cek; ?>><?php echo $sup['nama'] ?></option>
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
                                                    <tr style="font-size:80% !important;" >
                                                        <th style="text-align:center;">No</th>
                                                        <th style="text-align:center;">Sumber Dana</th>
                                                        <th style="text-align:center;">No. Terima</th>
                                                        <th style="text-align:center;">Suplier</th>
                                                        <th style="text-align:center;">No. Faktur</th>
                                                        
                                                        <th style="text-align:center;">Tgl. Terima</th>
                                                        <th style="text-align:center;">Nama Obat</th>
														<th style="text-align:center;">Sat</th>
														<th style="text-align:center;">Qty</th>
														<th style="text-align:center;">Harga Dasar</th>
														<th style="text-align:center;">Discount</th>
														<th style="text-align:center;">PPN</th>
														<th style="text-align:center;">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no=1; $totalpenerimaan=0;
                                                    foreach ($items as $item) {
                                                    ?>
                                                        <tr style="font-size:75% !important;">
                                                            <td style="text-align:center;"><?php echo $no; ?></td>
                                                            <td style="text-align:center;"><?php echo $item['nama_unit_apt'] ?></td>
                                                            <td style="text-align:center;"><?php echo $item['no_penerimaan'] ?></td>
                                                            <td style="text-align:center;"><?php echo $item['nama'] ?></td>
                                                            <td style="text-align:center;"><?php echo $item['no_faktur'] ?></td>
                                                            <td style="text-align:center;"><?php echo $item['tgl_penerimaan'] ?></td>
															<td><?php echo $item['nama_obat'] ?></td>
															<td style="text-align:center;"><?php echo $item['satuan_kecil'] ?></td>
															<td style="text-align:center;"><?php echo number_format($item['qty_kcl'],2,',','.') ?></td>
															<td style="text-align:right;"><?php echo number_format($item['harga_beli'],2,',','.') ?></td>
															<?php 
																$disc_prs=$item['disc_prs'];
																$ppn_item=$item['ppn_item'];
																$isidiskon=$item['isidiskon'];
																$harga_beli=$item['harga_beli'];
																$qty_kcl=$item['qty_kcl'];
																if($disc_prs==0){
																	$hargabelidiscount=0;
																}
																else{
																	$hargabelidiscount=($disc_prs/100)*$harga_beli*$qty_kcl;																	
																}
																//nyari jumlah1
																if($hargabelidiscount!=0){ //kalo pake diskon persen
																	$jumlah1=($qty_kcl*$harga_beli)-$hargabelidiscount;
																}
																else if($isidiskon!=0){ //kalo pake diskon bukan persen
																	$jumlah1=($qty_kcl*$harga_beli)-$isidiskon;
																}
																else{
																	$jumlah1=($qty_kcl*$harga_beli);
																}
																
																//total
																$isippn=$jumlah1*($ppn_item/100);
																$total=$jumlah1+$isippn;
																
															if($disc_prs!=0){ ?>
																<td style="text-align:center;"><?php echo number_format($hargabelidiscount,2,',','.'); ?></td>
															<?php } else if($isidiskon!=0){ ?>
																<td style="text-align:center;"><?php echo number_format($isidiskon,2,',','.') ?></td>
															<?php } else { ?>
																<td style="text-align:center;"><?php echo 0; ?></td>
															<?php } ?>
															<td style="text-align:center;"><?php echo number_format($isippn,2,',','.') ?></td>
                                                            <td style="text-align:right;"><?php echo number_format($total,2,',','.') ?></td>
                                                        </tr>                                                    
                                                    <?php
                                                    $no++;
													$totalpenerimaan=$totalpenerimaan+$total;
                                                    }
                                                    ?>
                                                </tbody>
												<tfoot>
													<tr>
														<th colspan="12" style="text-align:right;" class="header">Total Penerimaan (Rp) : <input style="text-align:right;width:130px;font-size:95% !important;" type="text" class="input-medium cleared" id="totalpenerimaan" value="<?php  echo number_format($totalpenerimaan,2,',','.');?>" disabled></th>
													</tr>
												</tfoot>
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