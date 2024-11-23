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
                                            <h5>PENCARIAN DATA</h5>							
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">													
													<li><a href="<?php echo base_url() ?>index.php/masterapotek/approver/tambah"> <i class="icon-plus"></i> Tambah Approver</a></li>
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
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/masterapotek/approver">
                                                <div class="control-group">
													<label for="nama_approver" class="control-label">Nama Approver</label>
													<div class="controls with-tooltip">
                                                        <input type="text" id="nama_approver" name="nama_approver" value="<?php echo $nama_approver?>" class="span3 input-tooltip" data-original-title="masukkan nama approver yang ingin dicari" data-placement="bottom"/>												
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
                                            <h5>DAFTAR APPROVER</h5>
                                        </header>
                                        <div id="collapse4" class="body">
                                            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align:center;">Kode</th>                                                        
														<th style="text-align:center;">Nama Approver</th>
														<th style="text-align:center;">Urut Approval</th>
														<th style="text-align:center;">Pilihan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
													<?php
														//$no=1;
														foreach($items as $item){
														//debugvar($items);
													?>
													<tr>
														<td style="text-align:center;"><?php echo $item['kd_app']; ?></TD>
														<td><?php echo $item['nama_pegawai']; ?></td>
														<td><?php echo $item['urut']; ?></td>
														<td style="text-align:center;width:160px;">
															<a href="<?php echo base_url() ?>index.php/masterapotek/approver/edit/<?php echo $item['kd_app'] ?>" class="btn"><i class="icon-edit"></i> Edit</a>
															<?php
                                                            if($this->mapprover->isParent('apt_app_pengajuan','kd_app',$item['kd_app'])){
                                                            ?>
                                                            &nbsp;
                                                            <?php
                                                            }else{
                                                            ?>
															<a href="#" onClick="xar_confirm('<?php echo base_url() ?>index.php/masterapotek/approver/hapus/<?php echo $item['kd_app'] ?>','Apakah Anda ingin menghapus data ini?')" class="btn btn-danger"><i class="icon-remove"></i> Hapus</a>
															<?php
                                                            }
                                                            ?>			
                                                        </td>
													</tr>
													<?php
															//$no++;
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
