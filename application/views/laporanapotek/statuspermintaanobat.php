
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
                                            <h5>STATUS PERMINTAAN OBAT / ALKES </h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <!--li><a target="_blank" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>third-party/fpdf/laporanpenerimaanapotek.php?periodeawal=<?php echo $periodeawal ?>&periodeakhir=<?php echo $periodeakhir; ?>&kd_unit_apt=<?php echo $kd_unit_apt; ?>&kd_supplier=<?php echo $kd_supplier; ?>&kd_pabrik=<?php echo $kd_pabrik; ?>"> <i class="icon-print"></i> PDF</a></li-->
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
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/laporanapt/statuspermintaanobat">
                                                <!--div class="row-fluid">
													<div class="span12">
														<div class="span6">
                                                            <div class="control-group">
																<label for="kd_unit_apt" class="control-label">Unit </label>
																<div class="controls with-tooltip">
																	<input type="text" name="nama_unit_apt" id="nama_unit_apt" value="<-?php if($unit=$this->mlaporanapt->ambilNamaUnit($this->session->userdata('kd_unit_apt'))) echo $unit; ?>" readonly class="span7 input-tooltip" data-original-title="nama unit" data-placement="bottom"/>
																	<input type="hidden" name="kd_unit_apt" id="kd_unit_apt" value="<-?php echo $this->session->userdata('kd_unit_apt'); ?>" readonly class="span2 input-tooltip" data-original-title="kd unit apt " data-placement="bottom"/>
																</div>
															</div>
                                                        </div>
													</div>
												</div-->
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
												<div class="row-fluid">
													<div class="span12">
														<div class="span6">
															<div class="control-group">
																<label for="kd_unit_apt" class="control-label">Unit Apotek</label>
																<div class="controls with-tooltip">
																	<?php if($this->session->userdata('kd_unit_apt')==$this->session->userdata('kd_unit_apt_gudang')){ ?>
																			<select id="kd_unit_apt" name="kd_unit_apt" class="input-large">
																				<option value="">--pilih--</option>
																				<?php
																				foreach ($unitapotek as $unit) {
																					# code...
																					if ($unit['kd_unit_apt']== $kd_unit_apt){
																						$cek = "selected=selected";
																					}
																					else {
																						$cek = "";
																					}
																				?>
																				<option value="<?php echo $unit['kd_unit_apt'] ?>" <?php echo $cek; ?>><?php echo $unit['nama_unit_apt'] ?></option>
																				<?php
																				}
																				?>
																			</select>
																	<?php } else { ?>
																			<input type="text" name="nama_unit_apt" id="nama_unit_apt" value="<?php if($unit=$this->mlaporanapt->ambilNamaUnit($this->session->userdata('kd_unit_apt'))) echo $unit; ?>" readonly class="span9 input-tooltip" data-original-title="nama unit" data-placement="bottom"/>
																			<input type="hidden" name="kd_unit_apt" id="kd_unit_apt" value="<?php echo $this->session->userdata('kd_unit_apt'); ?>" class="span2 input-tooltip" data-original-title="kd unit apt " data-placement="bottom"/>
																	<?php } ?>                                                                    
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="row-fluid">
													<div class="span12">
														<div class="span6">
                                                            <div class="control-group">
                                                                <label for="permintaan_status" class="control-label">Status</label>
                                                                <div class="controls with-tooltip">
                                                                    <select name="permintaan_status" id="permintaan_status" class="input-xlarge">
																		<option value="" <?php if($permintaan_status=='0') echo "selected=selected"; ?>>--pilih status--</option>
                                                                        <option value="1" <?php if($permintaan_status=='1') echo "selected=selected"; ?>>Sudah Didistribusi</option>
																		<option value="2" <?php if($permintaan_status=='2') echo "selected=selected"; ?>>Sudah Didistribusi Sebagian</option>
                                                                        <option value="3" <?php if($permintaan_status=='3') echo "selected=selected"; ?>>Belum Didistribusi</option>
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
                                                        <th style="text-align:center;">No. / Tgl.<br>Permintaan</th>
                                                        <th style="text-align:center;">Kd.Obat</th>
                                                        <th style="text-align:center;">Nama Obat</th>
                                                        <th style="text-align:center;">Satuan</th>
														<th style="text-align:center;">Unit</th>
														<th style="text-align:center;">Jml<br>Permintaan</th>
														<th style="text-align:center;">Jml<br>Distribusi</th>
														<th style="text-align:center;">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no=1; $status="";
                                                    foreach ($items as $item) {
														$ab=$item['jml_req'];
														$ac=$item['jml_distribusi'];
														if($ac>=$ab){$status="Sudah Didistribusi";}
														else if($ac==0){$status="Belum Didistribusi";}
														else {$status="Sudah Didistribusi Sebagian";}
                                                    ?>
                                                        <tr style="font-size:90% !important;">
                                                            <td style="text-align:center;"><?php echo $no; ?></td>
                                                            <td style="text-align:center;"><?php echo $item['no_permintaan'].' / '.$item['tgl_permintaan'] ?></td>
                                                            <td style="text-align:center;"><?php echo $item['kd_obat'] ?></td>
                                                            <td style="text-align:left;"><?php echo $item['nama_obat'] ?></td>
															<td style="text-align:center;"><?php echo $item['satuan_kecil'] ?></td>
															<!--td style="text-align:center;"><-?php echo convertDate($item['tgl_expire']) ?></td-->
															<td style="text-align:left;"><?php echo $item['nama_unit_apt'] ?></td>
															<td style="text-align:right;"><?php echo number_format($item['jml_req'],2,',','.'); ?></td>
															<td style="text-align:right;"><?php echo number_format($item['jml_distribusi'],2,',','.'); ?></td>
                                                            <td style="text-align:center;"><?php echo $status; ?></td>
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
	
</script>