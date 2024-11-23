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
                                                    <li><a href="<?php echo base_url() ?>index.php/master/tarif/tambah"> <i class="icon-plus"></i> Tambah</a></li>
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
                                            <form class="form-horizontal" method="post" action="<?php echo base_url()?>index.php/master/tarif">
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="span5">
                                                            <div class="control-group">
                                                                <label for="kd_pelayanan" class="control-label">Pelayanan</label>
                                                                <div class="controls with-tooltip">
                                                                    <select name="kd_pelayanan" class="input-xlarge">
                                                                    <option value="">Pilih Pelayanan</option>
                                                                    <?php
                                                                    foreach ($datapelayanan as $pelayanan) {
                                                                        # code...
                                                                        if($kd_pelayanan==$pelayanan['kd_pelayanan'])$sel="selected=selected"; else $sel="";
                                                                    ?>
                                                                    <option value="<?php echo $pelayanan['kd_pelayanan'] ?>" <?php echo $sel; ?>><?php echo $pelayanan['nama_pelayanan'] ?></option>
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
                                                                <label for="kd_jenis_tarif" class="control-label">Jenis Tarif</label>
                                                                <div class="controls with-tooltip">
                                                                    <select name="kd_jenis_tarif" class="input-xlarge">
                                                                    <option value="">Pilih Jenis Tarif</option>
                                                                    <?php
                                                                    foreach ($datajenistarif as $jenistarif) {
                                                                        # code...
                                                                        if($kd_jenis_tarif==$jenistarif['kd_jenis_tarif'])$sel="selected=selected"; else $sel="";
                                                                    ?>
                                                                    <option value="<?php echo $jenistarif['kd_jenis_tarif'] ?>" <?php echo $sel; ?>><?php echo $jenistarif['jenis_tarif'] ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="span5">
                                                            <div class="control-group">
                                                                <label for="kd_kelas" class="control-label">Kelas</label>
                                                                <div class="controls with-tooltip">
                                                                    <select name="kd_kelas" class="input-xlarge">
                                                                    <option value="">Pilih Kelas Pelayanan</option>
                                                                    <?php
                                                                    foreach ($datakelas as $kelas) {
                                                                        if($kd_kelas==$kelas['kd_kelas'])$sel="selected=selected"; else $sel="";
                                                                        # code...
                                                                    ?>
                                                                    <option value="<?php echo $kelas['kd_kelas'] ?>" <?php echo $sel; ?>><?php echo $kelas['kelas'] ?></option>
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
                                            <h5>Daftar Tarif</h5>
                                        </header>
                                        <div id="collapse4" class="body">
                                            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Jenis Tarif</th>
                                                        <th>Pelayanan</th>
                                                        <th>Kelas</th>
                                                        <th>Tgl Berlaku</th>
                                                        <th>Tarif</th>
                                                        <th>Tgl Berakhir</th>
                                                        <th style="width:200px !important;">Pilihan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
													
													foreach($items as $item){
												?>
                                                    <tr>
                                                        <td><?php echo $item['jenis_tarif'] ?></td>
                                                        <td><?php echo $item['nama_pelayanan'] ?></td>
                                                        <td><?php echo $item['kelas'] ?></td>
                                                        <td><?php echo $item['tgl_berlaku'] ?></td>
                                                        <td><?php echo $item['tarif'] ?></td>
                                                        <td><?php echo $item['tgl_berakhir'] ?></td>
                                                        <td style="text-align:center;width:160px;">
                                                            <a href="<?php echo base_url() ?>index.php/master/tarif/edit/?id=<?php echo $item['kd_jenis_tarif'] ?>&kd_pelayanan=<?php echo $item['kd_pelayanan'] ?>&kd_kelas=<?php echo $item['kd_kelas'] ?>&tgl_berlaku=<?php echo $item['tgl_berlaku'] ?>" class="btn"><i class="icon-edit"></i> Edit</a>
                                                            <a href="<?php echo base_url() ?>index.php/master/tarif/hapus/<?php echo $item['kd_jenis_tarif'] ?>/<?php echo $item['kd_pelayanan'] ?>/<?php echo $item['kd_kelas'] ?>/<?php echo $item['tgl_berlaku'] ?>" class="btn btn-danger"><i class="icon-remove"></i> Hapus</a>
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
    $('#dataTable').dataTable({
    "sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
    "sPaginationType": "bootstrap",
    "oLanguage": {
        "sLengthMenu": "Show _MENU_ entries"
    }
    });
        </script>
