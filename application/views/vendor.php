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
                                            <h5>Pencarian Data</h5>							
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><button class="btn" type="button" onclick='window.location="<?php echo base_url() ?>index.php/vendor/tambahvendor"'> <i class="icon-plus"></i> Tambah</button></li>
                                                    <li><a href="#"> <i class="icon-edit"></i> Edit</a></li>
                                                    <!--<li class="dropdown">
                                                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                                            <i class="icon-th-large"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="">q</a></li>
                                                            <li><a href="">a</a></li>
                                                            <li><a href="">b</a></li>
                                                        </ul>
                                                    </li>-->
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
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/vendor">
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">Nama Vendor</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" id="text1" name="vendor" class="span3 input-tooltip" data-original-title="masukkan nama vendor yang ingin dicari" data-placement="bottom"/>												
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
                                            <h5>Daftar Vendor</h5>
                                        </header>
                                        <div id="collapse4" class="body">
                                            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="7%">Kode</th>                                                        
														<th width="22%">Nama Vendor</th>
														<th width="28%">Alamat</th>
														<th width="14%">No. Telpon</th>
														<th width="14%">Fax</th>
														<th width="14%">Akun</th>
														<th>Pilihan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
													<?php
														//$no=1;
														foreach($items as $item){
														//debugvar($items);
													?>
													<tr>
														<td><?php echo $item['vend_code']; ?></TD>
														<td><?php echo $item['vendor']; ?></td>
														<td><?php echo $item['gabung1']; ?></td>
														<td><?php echo $item['telp']; ?></td>
														<td><?php echo $item['fax']; ?></td>
														<td><?php echo $item['name']; ?></td>
														<td style="text-align:center;width:160px;">
                                                            <a href="<?php echo base_url() ?>index.php/vendor/ubahvendor/<?php echo $item['vend_code'] ?>" class="btn"><i class="icon-edit"></i> Edit</a>
                                                            <a href="#" onClick="xar_confirm('<?php echo base_url() ?>index.php/vendor/hapusvendor/<?php echo $item['vend_code'] ?>','Apakah Anda ingin menghapus data ini?')" class="btn btn-danger"><i class="icon-remove"></i> Hapus</a>
																		
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
            $(function() {
                metisTable();

                
            });
        </script>
