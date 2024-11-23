 			<!-- #content -->
            <div id="content">
                <!-- .outer -->
                <div class="container-fluid outer">
                    <div class="row-fluid">
                        <!-- .inner -->
                        <div class="span12 inner">
                      <!--BEGIN INPUT TEXT FIELDS-->
						<form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/unitkerja/editunitkerja">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header>
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>Edit Unit Kerja</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><button type="button" onclick='window.location="<?php echo base_url() ?>index.php/unitkerja"' class="btn"> <i class="icon-list"></i> Daftar</button></li>                                                                                                        
                                                    <li><button class="btn" type="submit" name="submit" value="submit"> <i class="icon-save icon-share-alt"></i> Simpan</button></li>
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
                                                    <label for="kd_unit_kerja" class="control-label">Kode Unit Kerja</label>
                                                    <div class="controls with-tooltip">
														<input type="hidden" name="id" value="<?php echo $kd_unit_kerja ?>">
														<input type="text" id="kd_unit_kerja" name="kd_unit_kerja" value="<?php if(!empty($kd_unit_kerja)) echo $kd_unit_kerja ?>" class="span2 input-tooltip" data-original-title="masukkan kode unit kerja" data-placement="bottom"/>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">Nama Unit Kerja</label>
                                                    <div class="controls with-tooltip">														
                                                        <input type="text" id="text1" name="nama_unit_kerja" value="<?php if(!empty($nama_unit_kerja)) echo $nama_unit_kerja ?>" class="span5 input-tooltip" data-original-title="masukkan nama unit kerja" data-placement="bottom"/>
                                                    </div>
                                                </div>
												<div class="control-group">
                                                    <label for="text1" class="control-label">Parent</label>
                                                    <div class="controls with-tooltip">														
                                                        <input type="text" id="text1" name="parent" value="<?php if(!empty($parent)) echo $parent ?>" class="span2 input-tooltip" data-original-title="masukkan parent" data-placement="bottom"/>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Status</label>
                                                    <div class="controls">
                                                        <label class="radio inline">
                                                            <input class="uniform" type="radio" name="aktif" id="aktif1" value="1" <?php echo set_radio('aktif','1',isset($aktif)&& $aktif=='1' ? true:false); ?> />Aktif
                                                        </label>
                                                        <label class="radio inline">
                                                            <input class="uniform" type="radio" name="aktif" id="aktif2" value="0" <?php echo set_radio('aktif','0',isset($aktif)&& $aktif=='0' ? true:false); ?> />Tidak Aktif
                                                        </label>
                                                    </div>
                                                </div>  											
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--END TEXT INPUT FIELD-->                            
                                            </form>

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
    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });

</script>