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
													<li><a href="<?php echo base_url() ?>index.php/masterapotek/subgolongan/tambah"> <i class="icon-plus"></i> Tambah Sub</a></li>
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
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/masterapotek/subgolongan">
                                                <div class="control-group">
                                                    <label for="sub_golongan" class="control-label">Sub Golongan </label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" id="sub_golongan" name="sub_golongan" value="<?php echo $sub_golongan; ?>" class="span3 input-tooltip" data-original-title="masukkan nama sub golongan obat yang ingin dicari" data-placement="bottom"/>												
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
                                            <h5>DAFTAR SUB GOLONGAN OBAT / ALKES</h5>
                                        </header>
                                        <div id="collapse4" class="body">
                                            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                                <thead>
                                                    <tr>
														<th style="text-align:center;">No.</th>
                                                        <th style="text-align:center;">Kode Sub</th>                                                        
														<th style="text-align:center;">Sub Golongan Obat</th>														
														<th style="text-align:center;">Pilihan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
													<?php
														$no=1;
														foreach($items as $item){
														//debugvar($items);
													?>
													<tr>
														<td style="text-align:center;"><?php echo $no; ?></td>
														<td><?php echo $item['kd_sub']; ?></td>
														<td><?php echo $item['sub_golongan']; ?></td>														
														<td style="text-align:center;width:160px;">
															<!--?php
                                                            if($this->mgolongan->isParent('apt_obat','kd_golongan',$item['kd_golongan'])){
                                                            ?-->
                                                            &nbsp;
                                                            <!--?php
                                                            }else{
                                                            ?-->
                                                            <a href="<?php echo base_url() ?>index.php/masterapotek/subgolongan/edit/<?php echo $item['kd_sub'] ?>" class="btn"><i class="icon-edit"></i> Edit</a>
                                                            <a href="#" onClick="xar_confirm('<?php echo base_url() ?>index.php/masterapotek/subgolongan/hapus/<?php echo $item['kd_sub'] ?>','Apakah Anda ingin menghapus data ini?')" class="btn btn-danger"><i class="icon-remove"></i> Hapus</a>																		
															<!--?php
                                                            }
                                                            ?-->
                                                        </td>
													</tr>
													<?php
															$no++;
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