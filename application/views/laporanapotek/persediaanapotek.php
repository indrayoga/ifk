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
                                            <h5>LAPORAN PERSEDIAAN OBAT</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                        <li><a target="_blank" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/laporanapt/rl1excelpersediaanobat/<?php echo $stok; ?>/<?php echo $isistok; ?>/<?php echo $kd_unit_apt; ?>/<?php echo $kd_golongan; ?>"> <i class="icon-print"></i> XLS</a></li>
                                                        <li><a target="_blank" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>third-party/fpdf/laporanpersediaanapotek.php?kd_golongan=<?php echo $kd_golongan; ?>&stok=<?php echo $stok; ?>&isistok=<?php echo $isistok; ?>&kd_unit_apt=<?php echo $kd_unit_apt; ?>"> <i class="icon-print"></i> PDF</a></li>
																			                                                    
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
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/laporanapt/persediaanapotek">
                                               <div class="row-fluid">												
                                                    <div class="span12">
                                                        <div class="span5">
                                                            <div class="control-group">
                                                                <label for="kd_golongan" class="control-label">Golongan</label>
                                                                <div class="controls with-tooltip">
                                                                    <select id="kd_golongan" name="kd_golongan" class="input-large">
                                                                        <option value="">Semua</option>
                                                                        <?php
                                                                        foreach ($golongan as $gol) {
                                                                            # code...
																			if ($gol['kd_golongan']== $kd_golongan){
																				$cek = "selected=selected";
																			}
																			else {
																				$cek = "";
																			}
                                                                        ?>
                                                                        <option value="<?php echo $gol['kd_golongan'] ?>" <?php echo $cek; ?>><?php echo $gol['golongan'] ?></option>
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
														<div class="span5">
															<div class="control-group">
																<label for="stok" class="control-label">Stok</label>
                                                                <div class="controls with-tooltip">																
                                                                    <select name="stok" id="stok" class="input-small">
																		<option value="1" <?php if($stok=='1') echo "selected=selected"; ?>> > </option>
                                                                        <option value="2" <?php if($stok=='2') echo "selected=selected"; ?>> < </option>
                                                                        <option value="3" <?php if($stok=='3') echo "selected=selected"; ?>> >= </option>
																		<option value="4" <?php if($stok=='4') echo "selected=selected"; ?>> <= </option>
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
                                                    <tr style="font-size:95% !important;">
                                                        <th style="text-align:center;">No</th>
                                                        <th style="text-align:center;">Kode</th>
                                                        <th style="text-align:center;">Nama Obat</th>
														<th style="text-align:center;">Satuan</th>
														<th style="text-align:center;">Stok</th>
														<th style="text-align:center;">Sumber Dana</th>
														<th style="text-align:center;">Harga</th>
														<th style="text-align:center;">NILAI</th>
														<!--th>Jumlah</th-->														
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no=1; $total=0;
                                                    foreach ($items as $item) {
														$nilai=$item['jml_stok']*$item['harga_pokok'];
                                                    ?>
                                                        <tr style="font-size:95% !important;">
                                                            <td style="text-align:center;"><?php echo $no; ?></td>
                                                            <td><?php echo $item['kd_obat'] ?></td>
                                                            <td><?php echo $item['nama_obat'] ?></td>
															<td style="text-align:center;"><?php echo $item['satuan_kecil'] ?></td>
															<td style="text-align:center;"><?php echo number_format($item['jml_stok'],0,'','.') ?></td>
															<td><?php echo $item['nama_unit_apt'] ?></td>
															<td style="text-align:right;"><?php echo number_format($item['harga_pokok'],2,',','.') ?></td>
															<td style="text-align:right;"><?php echo number_format($nilai,2,',','.') ?></td>
                                                        </tr>                                                    
                                                    <?php
                                                    $no++;
													$total=$total+$nilai;
                                                    }
                                                    ?>
                                                </tbody>
												<tfoot>
													<tr>
														<th colspan="11" style="text-align:right;" class="header">Total Persediaan (Rp) : <input style="text-align:right;width:200px;font-size:95% !important;" type="text" class="input-medium cleared" id="totalpersediaan" value="<?php  echo number_format($total,2,',','.');?>" disabled></th>
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