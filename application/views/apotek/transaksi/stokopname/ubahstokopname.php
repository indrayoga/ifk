<style type="text/css">
.fixed {
    position:fixed;
    top:0px !important;
    z-index:100;
    width: 1024px;    
}
.body1{
    opacity: 0.4;
    background-color: #000000;
}

</style>
<script type="text/javascript">
	function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
		 
		return false;
		return true;
	}
	
    $(document).ready(function() {
		$('#nama').focus();
    });
</script>
            <div id="error"></div>
            <div id="overlay"></div>
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
                                            <h5>EDIT DISTRIBUTOR</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
													<li><a href="<?php echo base_url() ?>index.php/masterapotek/aptsupplier/"> <i class="icon-list"></i> Daftar Distributor</a></li>
													<li><a href="<?php echo base_url() ?>index.php/masterapotek/aptsupplier/tambah"> <i class="icon-plus"></i> Tambah Distributor</a></li>
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
                                            <form class="form-horizontal" id="form" method="post" action="<?php echo base_url()?>index.php/transapotek/stokopname/updatestokopname">
                                                <input type="hidden" name="mode" value="edit">
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="control-group">
                                                            <label for="nomor" class="control-label">Kode</label>
                                                            <div class="controls with-tooltip">
                                                                <input type="text" name="nomor" id="nomor" readonly class="span10 input-tooltip" value="<?php echo $item['nomor']; ?>" data-original-title="nomor" data-placement="bottom"/>
                                                                <input type="hidden" name="kd_obat" id="kd_obat" readonly class="span10 input-tooltip" value="<?php echo $item['kd_obat']; ?>" data-original-title="nomor" data-placement="bottom"/>
                                                                <input type="hidden" name="kd_unit_apt" id="kd_unit_apt" readonly class="span10 input-tooltip" value="<?php echo $item['kd_unit_apt']; ?>" data-original-title="nomor" data-placement="bottom"/>
                                                                <input type="hidden" name="kd_pabrik" id="kd_pabrik" readonly class="span10 input-tooltip" value="<?php echo $item['kd_pabrik']; ?>" data-original-title="nomor" data-placement="bottom"/>
                                                                <input type="hidden" name="tgl_expired" id="tgl_expired" readonly class="span10 input-tooltip" value="<?php echo $item['tgl_expired']; ?>" data-original-title="nomor" data-placement="bottom"/>
                                                                <input type="hidden" name="harga" id="harga" readonly class="span10 input-tooltip" value="<?php echo $item['harga']; ?>" data-original-title="nomor" data-placement="bottom"/>
                                                                <input type="hidden" name="batch" id="batch" readonly class="span10 input-tooltip" value="<?php echo $item['batch']; ?>" data-original-title="nomor" data-placement="bottom"/>
                                                                <span class="help-inline"></span>
                                                            </div>
                                                        </div>
                                                    </div>                                                      
                                                </div>                                              
                                                <div class="control-group">
                                                    <label for="" class="control-label">Kode Obat</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" name="" id="" readonly class="span10 input-tooltip" value="<?php echo $item['kd_obat']; ?>" data-original-title="nama obat" data-placement="bottom"/>
                                                        <span class="help-inline"></span>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="nama_obat" class="control-label">Nama</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" name="nama_obat" id="nama_obat" readonly class="span10 input-tooltip" value="<?php echo $item['nama_obat']; ?>" data-original-title="nama obat" data-placement="bottom"/>
                                                        <span class="help-inline"></span>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="nama_obat" class="control-label">Pabrik</label>
                                                    <div class="controls with-tooltip">
                                                        <select name="kd_pabrik_baru" id="kd_pabrik_baru">
                                                            <?php
                                                            foreach ($datapabrik as $pabrik) {
                                                                # code...
                                                                if($item['kd_pabrik']==$pabrik['kd_pabrik'])$sel="selected=selected"; else $sel="";
                                                            ?>
                                                            <option value="<?php echo $pabrik['kd_pabrik'] ?>" <?php echo $sel; ?>><?php echo $pabrik['nama_pabrik'] ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <span class="help-inline"></span>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="tgl_expire_baru" class="control-label">Tgl. Expire</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" name="tgl_expire_baru" id="tgl_expire_baru" data-mask="99-99-9999" class="span10 input-tooltip" value="<?php echo convertDate($item['tgl_expired']); ?>" data-original-title="tgl expire" data-placement="bottom"/>
                                                        <span class="help-inline"></span>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="batch_baru" class="control-label">Batch</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" name="batch_baru" id="batch_baru" class="span10 input-tooltip" value="<?php echo $item['batch']; ?>" data-original-title="tgl expire" data-placement="bottom"/>
                                                        <span class="help-inline"></span>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="harga_baru" class="control-label">Harga</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" name="harga_baru" id="harga_baru" class="span10 input-tooltip" value="<?php echo $item['harga']; ?>" data-original-title="tgl expire" data-placement="bottom"/>
                                                        <span class="help-inline"></span>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="stok_baru" class="control-label">Jumlah</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" name="stok_baru" id="stok_baru" value="<?php echo $item['stok_baru']; ?>" class="span10 input-tooltip" data-original-title="stok baru" data-placement="bottom"/>
                                                        <span class="help-inline"></span>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="format_baru" class="control-label">Barcode</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" name="format_baru" id="format_baru" value="<?php echo $item['format']; ?>" class="span10 input-tooltip" data-original-title="stok baru" data-placement="bottom"/>
                                                        <span class="help-inline"></span>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">&nbsp;</label>
                                                    <div class="controls with-tooltip">
                                                        <button class="btn btn-primary" type="submit"><i class="icon-ok"></i> Simpan</button>
                                                        <button class="btn " type="reset"><i class="icon-undo"></i> Reset</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <div id="progress" style="display:none;"></div>                                                                                    
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
<script type="text/javascript">
    var opts = {
      lines: 9, // The number of lines to draw
      length: 40, // The length of each line
      width: 9, // The line thickness
      radius: 0, // The radius of the inner circle
      corners: 1, // Corner roundness (0..1)
      rotate: 0, // The rotation offset
      direction: 1, // 1: clockwise, -1: counterclockwise
      color: '#000', // #rgb or #rrggbb
      speed: 1.4, // Rounds per second
      trail: 54, // Afterglow percentage
      shadow: false, // Whether to render a shadow
      hwaccel: false, // Whether to use hardware acceleration
      className: 'spinner', // The CSS class to assign to the spinner
      zIndex: 2e9, // The z-index (defaults to 2000000000)
      top: 'auto', // Top position relative to parent in px
      left: '470px' // Left position relative to parent in px
    };
    var target = document.getElementById('progress');
    var spinner = new Spinner(opts).spin(target);    
</script>