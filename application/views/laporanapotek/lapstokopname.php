<?php
		//debugvar($stok);

?>
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
                                            <h5>LAPORAN STOKOPNAME OBAT</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a target="" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/laporanapt/rl1excelstokopname/<?php if(empty($bulan)) echo "null"; else echo $bulan; ?>/<?php if(empty($tahun)) echo "null"; else echo $tahun; ?>/<?php if(empty($kd_unit_apt)) echo "null"; else echo $kd_unit_apt; ?>"> <i class="icon-print"></i> Export to Excel</a></li>
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
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/laporanapt/stokopname">                                                
												<div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="span7">
                                                            <div class="control-group">
                                                                <label for="bulan" class="control-label">Periode</label>
                                                                <div class="controls with-tooltip">
                                                                    <select name="bulan" id="bulan" class="input-medium">
                                                                        <option value="01" <?php if($bulan=='01') echo "selected=selected"; ?>>Januari</option>
                                                                        <option value="02" <?php if($bulan=='02') echo "selected=selected"; ?>>Februari</option>
                                                                        <option value="03" <?php if($bulan=='03') echo "selected=selected"; ?>>Maret</option>
                                                                        <option value="04" <?php if($bulan=='04') echo "selected=selected"; ?>>April</option>
                                                                        <option value="05" <?php if($bulan=='05') echo "selected=selected"; ?>>Mei</option>
                                                                        <option value="06" <?php if($bulan=='06') echo "selected=selected";; ?>>Juni</option>
                                                                        <option value="07" <?php if($bulan=='07') echo "selected=selected"; ?>>Juli</option>
                                                                        <option value="08" <?php if($bulan=='08') echo "selected=selected"; ?>>Agustus</option>
                                                                        <option value="09" <?php if($bulan=='09') echo "selected=selected"; ?>>September</option>
                                                                        <option value="10" <?php if($bulan=='10') echo "selected=selected"; ?>>Oktober</option>
                                                                        <option value="11" <?php if($bulan=='11') echo "selected=selected"; ?>>November</option>
                                                                        <option value="12" <?php if($bulan=='12') echo "selected=selected"; ?>>Desember</option>
                                                                    </select>
                                                                    <select name="tahun" id="tahun" class="input-small">
                                                                        <option value="<?php echo date('Y'); ?>" <?php if($tahun==date('Y')) echo "selected=selected"; ?>><?php echo date('Y'); ?></option>
                                                                        <option value="<?php echo date('Y')-1; ?>" <?php if($tahun==date('Y')-1) echo "selected=selected"; ?>><?php echo date('Y')-1; ?></option>
                                                                        <option value="<?php echo date('Y')-1; ?>" <?php if($tahun==date('Y')-2) echo "selected=selected"; ?>><?php echo date('Y')-2; ?></option>
                                                                        <option value="<?php echo date('Y')-1; ?>" <?php if($tahun==date('Y')-3) echo "selected=selected"; ?>><?php echo date('Y')-3; ?></option>
                                                                        <option value="<?php echo date('Y')-1; ?>" <?php if($tahun==date('Y')-4) echo "selected=selected"; ?>><?php echo date('Y')-4; ?></option>
                                                                        <option value="<?php echo date('Y')-1; ?>" <?php if($tahun==date('Y')-5) echo "selected=selected"; ?>><?php echo date('Y')-5; ?></option>
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
                                                    <tr>
                                                        <th style="text-align:center;">NO</th>
														<th style="text-align:center;">TGL STOKOPNAME</th>
                                                        <th style="text-align:center;">NAMA OBAT</th>
                                                        <th style="text-align:center;">SATUAN</th>
                                                        <th style="text-align:center;">PABRIK</th>
                                                        <th style="text-align:center;">TGL. EXPIRE</th>
                                                        <th style="text-align:center;">BATCH</th>
														<th style="text-align:center;">STOK LAMA</th>
														<th style="text-align:center;">STOK BARU</th>
														<th style="text-align:center;">HARGA</th>
                                                        <th style="text-align:center;">NILAI</th>
                                                        <th style="text-align:center;">PILIHAN</th>
														<!--th>Jumlah</th-->														
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no=1;
													$nilai=0;
                                                    $total=0;
                                                    foreach ($items as $item) {
														$nilai=$item['harga']*$item['stok_baru'];
                                                        $total=$total+$nilai;
                                                    ?>
                                                        <tr>
                                                            <td style="text-align:center;"><?php echo $no; ?></td>
															<td style="text-align:center;"><?php echo $item['tanggal'] ?></td>
                                                            <td><?php echo $item['nama_obat'] ?></td>
                                                            <td style="text-align:center;"><?php echo $item['satuan_kecil'] ?></td>                                                         
                                                            <td style="text-align:center;"><?php echo $item['nama_pabrik'] ?></td>                                                         
															<td style="text-align:center;"><?php echo convertDate($item['tgl_expired']) ?></td>
                                                            <td style="text-align:center;"><?php echo $item['batch'] ?></td>                                                         
															<td style="text-align:right;"><?php echo number_format($item['stok_lama'],2,'.',',') ?></td>
															<td style="text-align:right;"><?php echo number_format($item['stok_baru'],2,'.',',') ?></td>
															<td style="text-align:right;"><?php echo number_format($item['harga'],2,'.',',') ?></td>
															<td style="text-align:right;"><?php echo number_format($nilai,2,'.',',') ?></td>
                                                            <td><a href="<?php echo base_url('index.php/transapotek/stokopname/ubah/'.$item['nomor']); ?>" class="btn">Edit</a></td>
															<!--td style="text-align:right;"><-?php echo $item[''] ?></td-->
                                                        </tr>                                                    
                                                    <?php
                                                    $no++;
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="10">T O T A L</td>
                                                        <td><?php echo number_format($total,2,'.',',') ?></td>
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
</script>
