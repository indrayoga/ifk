<script src="<?php echo base_url(); ?>assets/js/mousetrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/mousetrap-global-bind.min.js"></script> 
<script type="text/javascript">
    Mousetrap.bindGlobal('ctrl+r', function() { window.location.href='<?php echo base_url() ?>index.php/gfk/stokopnamepkm/tambah'; return false;});
    //Mousetrap.bindGlobal('f6', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/penjualan'; return false;});
</script>
<style type="text/css">
.fixed {
    position:fixed;
    top:0px !important;
    z-index:100;
    width: 100%;    
}
</style>

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
                            <header class="top">
                                <div class="icons"><i class="icon-edit"></i></div>
                                <h5>PENCARIAN DATA STOKOPNAME PUSKESMAS</h5>                         
                                <!-- .toolbar -->
                                <div class="toolbar" style="height:auto;">
                                    <ul class="nav nav-tabs">
                                        <!--li><button class="btn" type="button" onclick='window.location="<-?php echo base_url() ?>index.php/transapotek/penjualan/tambahpenjualan"'> <i class="icon-plus"></i> Tambah</button></li-->                                                    
                                        <li><a href="<?php echo base_url() ?>index.php/gfk/stokopnamepkm/tambah"> <i class="icon-plus"></i> Tambah (Ctrl + R)</a></li>
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
                                <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/gfk/stokopnamepkm">
                                    <div class="control-group">
                                        <label for="periodeawal" class="control-label">Periode</label>
                                        <div class="controls with-tooltip">
                                            <input type="text" id="periodeawal" name="periodeawal" class="input-small input-tooltip" data-mask="99-99-9999"
                                                   value="<?php echo $periodeawal?>" data-original-title="masukkan tanggal awal" data-placement="bottom"/>
                                                   -
                                            <input type="text" id="periodeakhir" name="periodeakhir" class="input-small input-tooltip" data-mask="99-99-9999"
                                                   value="<?php echo $periodeakhir?>" data-original-title="masukkan tanggal akhir" data-placement="bottom"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="id_puskesmas" class="control-label">Puskesmas </label>
                                        <div class="controls with-tooltip">
                                            <select id="id_puskesmas" name="id_puskesmas">
                                                <option value="">Semua Puskesmas</option>
                                                <?php
                                                foreach ($puskesmasList as $item) {
                                                    # code...
                                                    $selected = false;
                                                    if($puskesmas == $item['id']) {
                                                        $selected = true;
                                                    }
                                                ?>

                                                <option value="<?php echo $item['id'] ?>" <?=  $selected ? 'selected="selected"' : '' ?>>
                                                    <?php echo $item['nama'] ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <span class="help-inline"></span>                                                               
                                        </div>
                                    </div>
                                    <!--
                                    <div class="control-group">
                                        <label for="unit" class="control-label">Sumber Dana </label>
                                        <div class="controls with-tooltip">
                                            <select id="kd_unit_apt" name="kd_unit_apt" class="input-tooltip" data-original-name="Sumber Dana" data-placement="bottom">
                                                <option value="">Semua Sumber Dana</option>
                                                <?php
                                                foreach ($unitList as $item) {
                                                    # code...
                                                    $selected = false;
                                                    if($unit == $item['kd_unit_apt']) {
                                                        $selected = true;
                                                    }
                                                ?>

                                                <option value="<?php echo $item['kd_unit_apt'] ?>" <?=  $selected ? 'selected="selected"' : '' ?>>
                                                    <?php echo $item['nama_unit_apt'] ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <span class="help-inline"></span>                                                               
                                        </div>
                                    </div>
                                    -->
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
                                <h5>DAFTAR STOKOPNAME PUSKESMAS</h5>
                            </header>
                            <div id="collapse4" class="body">
                                <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">Tanggal</th>
                                            <th style="text-align:center;">Puskesmas</th>                                                        
                                            <th style="text-align:center;">Unit</th>
                                            <th style="text-align:center;">Pilihan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="with-tooltip">
                                        <?php
                                            //$no=1;
                                            foreach($items as $item){
                                            //debugvar($items);                                                     
                                        ?>
                                        <tr class="">
                                            <td style="text-align:center;"><?php echo convertDate($item['tgl']); ?></td>
                                            <td style="text-align:center;"><?php echo $item['nama']; ?></td>
                                            <td style="text-align:center;"><?php echo $item['nama_unit_apt']; ?></td>
                                            <td style="text-align:center;width:160px;">                                                           
                                                <a href="<?php echo base_url() ?>index.php/gfk/stokopnamepkm/ubahstokopnamepkm/<?php echo $item['id_sop'] ?>" class="btn"><i class="icon-edit"></i> Edit</a>
                                                <a href="#" onClick="xar_confirm('<?php echo base_url() ?>index.php/gfk/stokopnamepkm/hapusstokopnamepkm/<?php echo $item['id_sop'] ?>','Apakah Anda ingin menghapus data ini?')" class="btn btn-danger"><i class="icon-remove"></i> Hapus</a>
                                            </td>
                                        </tr>
                                        <?php
                                            //  $no++;
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
$(document).ready(function() {
    $('#dataTable').dataTable({
        "aaSorting": [[ 0, "desc" ]],
        "sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sLengthMenu": "Show _MENU_ entries"
        }
    });

    $(window).bind('scroll', function() {
        var p = $(window).scrollTop();
        var offset = $(window).offset();
        if(parseInt(p)>1){            
            $('.top').addClass('fixed');
        }else{
            $('.top').removeClass('fixed');
        }
    });

    $('#periodeawal').datepicker({
        format: 'dd-mm-yyyy'
    });
            
    $('#periodeakhir').datepicker({
        format: 'dd-mm-yyyy'
    });
            
    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });
});
</script>