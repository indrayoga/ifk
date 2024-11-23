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
                                                    <li><a href="<?php echo base_url() ?>index.php/master/jenistarif/tambah"> <i class="icon-plus"></i> Tambah</a></li>
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
                                            <form class="form-horizontal" method="post" action="<?php echo base_url()?>index.php/master/jenistarif">
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="span5">
                                                            <div class="control-group">
                                                                <label for="jenistarif" class="control-label">Jenis Tarif</label>
                                                                <div class="controls with-tooltip">
                                                                    <input type="text" id="jenistarif" name="jenistarif" class="input-large input-tooltip"
                                                                        value=""   data-original-title="masukkan jenis tarif yang ingin dicari" data-placement="bottom"/>
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
                                            <h5>Daftar Pelayanan</h5>
                                        </header>
                                        <div id="collapse4" class="body">
                                            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Kode</th>
                                                        <th>Jenis Tarif</th>
                                                        <th style="width:200px !important;">Pilihan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
													
													foreach($items as $item){
												?>
                                                    <tr>
                                                        <td><?php echo $item['kd_jenis_tarif'] ?></td>
                                                        <td><?php echo $item['jenis_tarif'] ?></td>
                                                        <td style="text-align:center;width:160px;">
                                                            <?php
                                                            if($this->mmaster->isParent('tarif','kd_jenis_tarif',$item['kd_jenis_tarif'])){
                                                            ?>
                                                            &nbsp;
                                                            <?php
                                                            }else{
                                                            ?>
                                                            <a href="<?php echo base_url() ?>index.php/master/jenistarif/edit/<?php echo $item['kd_jenis_tarif'] ?>" class="btn"><i class="icon-edit"></i> Edit</a>
                                                            <a href="<?php echo base_url() ?>index.php/master/jenistarif/hapus/<?php echo $item['kd_jenis_tarif'] ?>" class="btn btn-danger"><i class="icon-remove"></i> Hapus</a>
                                                            <?php
                                                            }
                                                            ?>
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
