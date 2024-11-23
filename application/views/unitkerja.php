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
                                                    <li><button class="btn" type="button" onclick='window.location="<?php echo base_url() ?>index.php/unitkerja/tambahunitkerja"'> <i class="icon-plus"></i> Tambah</button></li>
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
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/unitkerja">
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">Nama Unit Kerja</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" id="text1" name="nama_unit_kerja" class="span3 input-tooltip" data-original-title="masukkan nama unit kerja yang ingin dicari" data-placement="bottom"/>												
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
                                            <h5>Daftar Unit Kerja</h5>
                                        </header>
                                        <div id="collapse4" class="body">
                                            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th width="20%">Kode Unit Kerja</th>
														<th width="40%">Unit Kerja</th>
														<th width="10%">Parent</th>
														<th width="10%">Status</th>
                                                        <th>Pilihan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
													<?php
														$no=1;
														//debugvar($items['nama_unit_kerja']);
														foreach($items as $item){									
															if($item['aktif']=="1"){
																$aktif="Aktif";
															}else{
																$aktif="Tidak Akitf";
															}
													?>
													<tr>
														<td><?php echo $no; ?></td>
														<td><?php echo $item['kd_unit_kerja']; ?></td>
														<td><?php echo $item['nama_unit_kerja']; ?></td>
														<td><?php echo $item['parent']; ?></td>
														<td><?php echo $aktif; ?></td>												
														<td style="text-align:center;width:160px;">
															<a href="<?php echo base_url() ?>index.php/unitkerja/ubahunitkerja/<?php echo $item['kd_unit_kerja'] ?>" class="btn" type="button"><i class="icon-edit"></i> Edit</a>
															<a href="<?php echo base_url() ?>index.php/unitkerja/hapusunitkerja/<?php echo $item['kd_unit_kerja'] ?>" class="btn btn-danger" type="button"><i class="icon-remove"></i> Hapus</a>
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
            $(function() {
                metisTable();

                
            });
        </script>
