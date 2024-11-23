            <form class="form-horizontal" action="<?php echo base_url() ?>index.php/akun/simpanAkunsap" method="post" >
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
                                            <h5>Tambah Akun</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><button type="button" onclick='window.location.href="<?php echo base_url() ?>index.php/akun/sap"' class="btn"> <i class="icon-list"></i> Daftar</button></li>
                                                 	<li><button class="btn" type="submit"> <i class="icon-save icon-share-alt"></i> Simpan &amp; Keluar</button></li>
                                                    <li><button class="btn" type="reset"> <i class="icon-remove"></i> Hapus</button></li>
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
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">Akun</label>
                                                    <div class="controls with-tooltip">
                                                    	<input type="hidden" id="id" name="id" value="<?php if(!empty($id)) echo $id; ?>" />
                                                        <input type="text" id="text1" name="akun" class="span3 input-tooltip" data-original-title="masukkan Kode Akun" data-placement="bottom" value="<?php if(!empty($akun)) echo $akun ?>"/>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">Nama Akun</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" id="text1" class="span5 input-tooltip" name="nama_akun" data-original-title="masukkan nama akun" data-placement="bottom" value="<?php if(!empty($nama_akun)) echo $nama_akun; ?>"/>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Type</label>
                                                    <div class="controls">
                                                        <label class="radio inline">
                                                            <input class="uniform" type="radio" name="type" value="G" checked="<?php if(!empty($type) and $type=='G') echo "checked"; ?>">General
                                                        </label>
                                                        <label class="radio inline">
                                                            <input class="uniform" type="radio" name="type" value="D" checked="<?php if(!empty($type) and $type=='D') echo "checked";?>">Detail
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="control-group span3">
                                                    <label class="control-label">Level</label>
                                                    <div class="controls">
                                                       <?php echo $comboLevel ?>
                                                    </div>
                                                </div>
                                                <div class="control-group span3">
                                                    <label class="control-label">Induk</label>
                                                    <div class="controls">
                                                         <input class="input-medium" type="text" name="induk" value="<?php if(!empty($induk)) echo $induk; ?>">
                                                    </div>
                                                </div>
                                                <div class="control-group span3">
                                                    <label class="control-label">Group</label>
                                                    <div class="controls">
                                                     	 <select id="group" name="group" class="input-small">
                                                        <option value="">Group</option>
                                                        <option value="1" <?php if(!empty($group) && $group=='1') echo "selected" ?>>Asset</option>
                                                        <option value="2" <?php if(!empty($group) && $group=='2') echo "selected" ?>>Kewajiban</option>
                                                        <option value="3" <?php if(!empty($group) && $group=='3') echo "selected" ?>>Modal</option>
                                                        <option value="4" <?php if(!empty($group) && $group=='4') echo "selected" ?>>Pendapatan</option>
                                                        <option value="5" <?php if(!empty($group) && $group=='5') echo "selected" ?>>Biaya</option>
                                                    </select>	
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--END TEXT INPUT FIELD-->                            

                            <hr>
                        </div>
                        <!-- /.inner -->
                    </div>
                    <!-- /.row-fluid -->
                </div>
                <!-- /.outer -->
            </div>
            <!-- /#content -->
            </form>

<script type="text/javascript">
    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });

</script>
