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
                                                    <li><a href="<?php echo base_url() ?>index.php/akun/tambahakun"> <i class="icon-plus"></i> Tambah</a></li>
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
                                            <form class="form-horizontal" method="post" action="<?php echo base_url()?>index.php/akun">
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">Nama Akun</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" id="text1" class="span3 input-tooltip"
                                                               data-original-title="masukkan nama akun yang ingin dicari" data-placement="bottom" name="akun"/>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">Group</label>
                                                    <div class="controls with-tooltip">
                                                        <select name="group">
                                                            <option value=''>Semua</option>
                                                            <option value='1'>Asset</option>
                                                            <option value='2'>Kewajiban/Liability</option>
                                                            <option value='3'>Modal</option>
                                                            <option value='4'>Pendapatan</option>
                                                            <option value='5'>Biaya</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">&nbsp;</label>
                                                    <div class="controls with-tooltip">
                                                        <button class="btn btn-primary" type="submit"><i class="icon-search"></i> Cari</button>
                                                        <button class="btn " type="reset"><i class="icon-undo"></i> Reset</button>
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
                                            <h5>Daftar Akun</h5>
                                        </header>
                                        <div id="collapse4" class="body">
                                            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>&nbsp;</th>
                                                        <th>Akun</th>
                                                        <th>Nama Akun</th>
                                                        <th>Tipe</th>
                                                        <th>Level</th>
                                                        <th>Induk</th>
                                                        <th>Group</th>
                                                        <th>Pilihan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
													
													foreach($items as $item){
												?>
                                                    <tr>
                                                        <td><input type="checkbox"></td>
                                                        <td><?php echo $item['account'] ?></td>
                                                        <td><?php echo $item['name'] ?></td>
                                                        <td><?php echo $item['type'] ?></td>
                                                        <td><?php echo $item['levels'] ?></td>
                                                        <td><?php echo $item['parent'] ?></td>
                                                        <td><?php echo $item['groups'] ?></td>
                                                        <td style="text-align:center;width:160px;">
                                                            <a href="<?php echo base_url() ?>index.php/akun/editAkun/<?php echo $item['account'] ?>" class="btn"><i class="icon-edit"></i> Edit</a>
                                                            <a href="<?php echo base_url() ?>index.php/akun/deleteAkun/<?php echo $item['account'] ?>" class="btn btn-danger"><i class="icon-remove"></i> Hapus</a>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
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
