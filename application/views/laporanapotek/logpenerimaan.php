
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
                                            <h5>LOG PENERIMAAN OBAT / ALKES </h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a target="_blank" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>third-party/fpdf/logpenerimaan.php?periodeawal=<?php echo $periodeawal ?>&periodeakhir=<?php echo $periodeakhir; ?>&kd_supplier=<?php echo $kd_supplier; ?>&jenis=<?php echo $jenis; ?>"> <i class="icon-print"></i>Cetak</a></li>
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
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/laporanapt/logpenerimaan">
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
														<div class="span6">
                                                            <div class="control-group">
																<!--label for="kd_unit_apt" class="control-label">Unit </label-->
																<div class="controls with-tooltip">
																	<input type="hidden" name="nama_unit_apt" id="nama_unit_apt" value="<?php if($unit=$this->mlaporanapt->ambilNamaUnit($this->session->userdata('kd_unit_apt'))) echo $unit; ?>" readonly class="span7 input-tooltip" data-original-title="nama unit" data-placement="bottom"/>
																	<input type="hidden" name="kd_unit_apt" id="kd_unit_apt" value="<?php echo $this->session->userdata('kd_unit_apt'); ?>" readonly class="span2 input-tooltip" data-original-title="kd unit apt " data-placement="bottom"/>
																</div>
															</div>
                                                        </div>
													</div>
												</div>
												<div class="row-fluid">
													<div class="span12">
														<div class="span6">
                                                            <div class="control-group">
                                                                <label for="kd_supplier" class="control-label">Supplier</label>
                                                                <div class="controls with-tooltip">
                                                                    <select id="kd_supplier" name="kd_supplier" class="input-xlarge">
                                                                        <option value="">--pilih supplier--</option>
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
												<div class="row-fluid">
													<div class="span12">
														<div class="span6">
															<div class="span6">
																<div class="control-group">
																	<label for="jenis" class="control-label">Jenis Log</label>
																	<div class="controls with-tooltip">
																		<select name="jenis" id="jenis" class="input-medium">
																			<option value="" <?php if($jenis=='') echo "selected=selected"; ?>>--pilih--</option>
																			<option value="T" <?php if($jenis=='T') echo "selected=selected"; ?>>Tutup Transaksi</option>
																			<option value="B" <?php if($jenis=='B') echo "selected=selected"; ?>>Buka Transaksi</option>                                                                        
																		</select>																																		
																	</div>
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
														<th style="text-align:center;">Tgl. Log</th>
                                                        <th style="text-align:center;">No. Penerimaan</th>
														<th style="text-align:center;">Supplier</th>														
														<th style="text-align:center;">Alasan</th>
														<th style="text-align:center;">Nama User</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no=1; $status="";
                                                    foreach ($items as $item) {
                                                    ?>
                                                        <tr style="font-size:90% !important;">
                                                            <td style="text-align:center;"><?php echo $no; ?></td>
                                                            <td style="text-align:center;"><?php echo $item['tgl'] ?></td>
															<td style="text-align:center;"><?php echo $item['no_penerimaan'] ?></td>
															<td style="text-align:left;"><?php echo $item['nama'] ?></td>															
                                                            <td style="text-align:left;"><?php echo $item['alasan'] ?></td>
                                                            <td style="text-align:left;"><?php echo $item['nama_pegawai'] ?></td>
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