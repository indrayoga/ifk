
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
                                            <h5>LAPORAN DISTRIBUSI OBAT / ALKES</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a target="_blank" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>third-party/fpdf/laporandistribusiapotek.php?periodeawal=<?php echo $periodeawal ?>&periodeakhir=<?php echo $periodeakhir; ?>&kd_unit_asal=<?php echo $kd_unit_asal; ?>"> <i class="icon-print"></i> PDF</a></li>
                                                    <!--li><a target="" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<-?php echo base_url() ?>index.php/transapotek/laporanapt/rl1exceldistribusi/<-?php echo $periodeawal ?>/<-?php echo $periodeakhir; ?>/<-?php echo $kd_unit_asal; ?>"> <i class="icon-print"></i> Export to Excel</a></li-->
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
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/laporanapt/distribusiapotek">
                                                <div class="row-fluid">
													<div class="span12">
														<div class="span5">
															<div class="control-group">
																<label for="periodeawal" class="control-label">Tgl. Distribusi</label>
																<div class="controls with-tooltip">
																	<input type="text" id="periodeawal" name="periodeawal" class="input-small input-tooltip" data-mask="99-99-9999"
																		   value="<?php echo $periodeawal ?>" data-original-title="masukkan tanggal awal" value="<?php echo $periodeawal ?>" data-placement="bottom"/>
																		   s/d
																	<input type="text" id="periodeakhir" name="periodeakhir" class="input-small input-tooltip" data-mask="99-99-9999"
																		   value="<?php echo $periodeakhir ?>" data-original-title="masukkan tanggal akhir" value="<?php echo $periodeakhir ?>" data-placement="bottom"/>
																</div>
															</div> 
														</div>
													</div>
												</div>
												<div class="row-fluid">
													<div class="span12">
														<div class="control-group">
															<label for="kd_unit_asal" class="control-label">Sumber Dana</label>
															<div class="controls with-tooltip">
																<!--select class="input-large" name="kd_unit_asal" id="kd_unit_asal" readonly>
																<-?php
																	foreach ($unitapotek as $unit) {
																		$select="";
																		
																		if(isset($itemtransaksi['kd_unit_apt'])){    
                                                                            if($itemtransaksi['kd_unit_apt']==$unit['kd_unit_apt'])$select="selected=selected";else $select="";																			
                                                                        }
																		else {
																			if($unit['kd_unit_apt']==$this->session->userdata('kd_unit_apt'))$select="selected=selected";else $select=""; 
																		}
																?>
																<option value="<-?php if(!empty($unit)) echo $unit['kd_unit_apt'] ?>" <-?php echo $select; ?>><-?php echo $unit['nama_unit_apt'] ?></option>
																<-?php
																	}
																?>
																</select-->
																<input type="text" name="nama_unit_asal" id="nama_unit_asal" value="<?php if($unit=$this->mlaporanapt->ambilNamaUnit($this->session->userdata('kd_unit_apt'))) echo $unit; ?>" readonly class="span3 input-tooltip" data-original-title="unit asal" data-placement="bottom"/>
																<input type="hidden" name="kd_unit_asal" id="kd_unit_asal" value="<?php echo $this->session->userdata('kd_unit_apt'); ?>" readonly class="span2 input-tooltip" data-original-title="kd unit asal" data-placement="bottom"/>
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
                                                        <th style="text-align:center;">No. Distribusi</th>
                                                        <th style="text-align:center;">Tgl. Distribusi</th>
                                                        <th style="text-align:center;">Nama Obat</th>
														<th style="text-align:center;">Satuan</th>
														<th style="text-align:center;">Qty</th>														
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no=1;
                                                    foreach ($items as $item) {
                                                    ?>
                                                        <tr style="font-size:90% !important;">
                                                            <td style="text-align:center;"><?php echo $no."."; ?></td>
                                                            <td><?php echo $item['no_distribusi'] ?></td>
                                                            <!--td></td-->
                                                            <td style="text-align:center;"><?php echo $item['tgl_distribusi'] ?></td>
															<td><?php echo $item['nama_obat'] ?></td>
															<td style="text-align:center;"><?php echo $item['satuan_kecil'] ?></td>
															<!--td><-?php echo $item['qty'] ?></td-->
															<td style="text-align:center;"><?php echo $item['qty'] ?></td>
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
		"aaSorting": [[ 1, "asc" ]],
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