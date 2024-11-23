<script src="<?php echo base_url(); ?>assets/js/mousetrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/mousetrap-global-bind.min.js"></script> 
<script type="text/javascript">
    Mousetrap.bindGlobal('ctrl+r', function() { window.location.href='<?php echo base_url() ?>index.php/gfk/pemakaianpkm/tambahkunjunganresep'; return false;});
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
                                <h5>PENCARIAN DATA KUNJUNGAN RESEP PUSKESMAS</h5>                         
                                <!-- .toolbar -->
                                <div class="toolbar" style="height:auto;">
                                    <ul class="nav nav-tabs">
                                        <!--li><button class="btn" type="button" onclick='window.location="<-?php echo base_url() ?>index.php/transapotek/penjualan/tambahpenjualan"'> <i class="icon-plus"></i> Tambah</button></li-->                                                    
                                        <li><a href="<?php echo base_url() ?>index.php/gfk/pemakaianpkm/tambahkunjunganresep"> <i class="icon-plus"></i> Tambah (Ctrl + R)</a></li>
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
                                <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/gfk/pemakaianpkm/kunjunganresep">
                                    <div class="control-group">
                                        <label for="periodeawal" class="control-label">Periode</label>
                                        <div class="controls with-tooltip">
                                            <select name="bulan" id="bulan" class="input-medium">
                                                <option value="01" <?php if($bulan=='01') echo "selected=selected"; ?>>Januari</option>
                                                <option value="02" <?php if($bulan=='02') echo "selected=selected"; ?>>Februari</option>
                                                <option value="03" <?php if($bulan=='03') echo "selected=selected"; ?>>Maret</option>
                                                <option value="04" <?php if($bulan=='04') echo "selected=selected"; ?>>April</option>
                                                <option value="05" <?php if($bulan=='05') echo "selected=selected"; ?>>Mei</option>
                                                <option value="06" <?php if($bulan=='06') echo "selected=selected"; ?>>Juni</option>
                                                <option value="07" <?php if($bulan=='07') echo "selected=selected"; ?>>Juli</option>
                                                <option value="08" <?php if($bulan=='08') echo "selected=selected"; ?>>Agustus</option>
                                                <option value="09" <?php if($bulan=='09') echo "selected=selected"; ?>>September</option>
                                                <option value="10" <?php if($bulan=='10') echo "selected=selected"; ?>>Oktober</option>
                                                <option value="11" <?php if($bulan=='11') echo "selected=selected"; ?>>November</option>
                                                <option value="12" <?php if($bulan=='12') echo "selected=selected"; ?>>Desember</option>
                                            </select>
                                            <select name="bulan2" id="bulan2" class="input-medium">
                                                <option value="01" <?php if($bulan2=='01') echo "selected=selected"; ?>>Januari</option>
                                                <option value="02" <?php if($bulan2=='02') echo "selected=selected"; ?>>Februari</option>
                                                <option value="03" <?php if($bulan2=='03') echo "selected=selected"; ?>>Maret</option>
                                                <option value="04" <?php if($bulan2=='04') echo "selected=selected"; ?>>April</option>
                                                <option value="05" <?php if($bulan2=='05') echo "selected=selected"; ?>>Mei</option>
                                                <option value="06" <?php if($bulan2=='06') echo "selected=selected"; ?>>Juni</option>
                                                <option value="07" <?php if($bulan2=='07') echo "selected=selected"; ?>>Juli</option>
                                                <option value="08" <?php if($bulan2=='08') echo "selected=selected"; ?>>Agustus</option>
                                                <option value="09" <?php if($bulan2=='09') echo "selected=selected"; ?>>September</option>
                                                <option value="10" <?php if($bulan2=='10') echo "selected=selected"; ?>>Oktober</option>
                                                <option value="11" <?php if($bulan2=='11') echo "selected=selected"; ?>>November</option>
                                                <option value="12" <?php if($bulan2=='12') echo "selected=selected"; ?>>Desember</option>
                                            </select>
                                            <select name="tahun" id="tahun" class="input-small">
                                                <option value="<?php echo date('Y'); ?>" <?php if($tahun==date('Y')) echo "selected=selected"; ?>><?php echo date('Y'); ?></option>
                                                <option value="<?php echo date('Y')-1; ?>" <?php if($tahun==date('Y')-1) echo "selected=selected"; ?>><?php echo date('Y')-1; ?></option>
                                                <option value="<?php echo date('Y')-1; ?>" <?php if($tahun==date('Y')-2) echo "selected=selected"; ?>><?php echo date('Y')-2; ?></option>
                                                <option value="<?php echo date('Y')-1; ?>" <?php if($tahun==date('Y')-3) echo "selected=selected"; ?>><?php echo date('Y')-3; ?></option>
                                                <option value="<?php echo date('Y')-1; ?>" <?php if($tahun==date('Y')-4) echo "selected=selected"; ?>><?php echo date('Y')-4; ?></option>
                                                <option value="<?php echo date('Y')-1; ?>" <?php if($tahun==date('Y')-5) echo "selected=selected"; ?>><?php echo date('Y')-5; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="id_puskesmas" class="control-label">Puskesmas </label>
                                        <div class="controls with-tooltip">
                                            <select id="id_puskesmas" name="id_puskesmas">
                                                <option value="">SEMUA</option>
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
                                    <div class="control-group">
                                        <label for="text1" class="control-label">&nbsp;</label>
                                        <div class="controls with-tooltip">
                                            <button class="btn btn-primary" type="submit" name="cari" value="cari"><i class="icon-search"></i> Cari</button>
                                            <button class="btn " type="submit" name="reset" value="reset"><i class="icon-undo"></i> Reset</button>
                                            <a href="<?=base_url('index.php/gfk/laporangfk/pemakaianpkmxls/'.$tahun)?>" class="btn btn-info">Cetak</a>
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
                                <h5>DAFTAR KUNJUNGAN RESEP PUSKESMAS</h5>
                            </header>
                            <div id="collapse4" class="body">
                                <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">Bulan</th>
                                            <th style="text-align:center;">Tahun</th>
                                            <th style="text-align:center;">Puskesmas</th>
                                            <th style="text-align:center;">Umum</th>
                                            <th style="text-align:center;">Askes</th>
                                            <th style="text-align:center;">Gakin</th>
                                            <th style="text-align:center;">Lansia/Kader</th>
                                        </tr>
                                    </thead>
                                    <tbody class="with-tooltip">
                                        <?php
                                            //$no=1;
                                            foreach($items as $item){
                                            //debugvar($items);                                                     
                                        ?>
                                        <tr class="">
                                            <td style="text-align:center;"><?php echo $item['bulan']; ?></td>
                                            <td style="text-align:center;"><?php echo $item['tahun']; ?></td>
                                            <td style="text-align:center;"><?php echo $item['nama']; ?></td>
                                            <td style="text-align:center;"><?php echo $item['kunjungan_umum']; ?></td>
                                            <td style="text-align:center;"><?php echo $item['kunjungan_bpjs']; ?></td>
                                            <td style="text-align:center;"><?php echo $item['kunjungan_gakin']; ?></td>
                                            <td style="text-align:center;"><?php echo $item['kunjungan_lansia_kader']; ?></td>
                                            <td style="text-align:center;width:160px;">                                                           
                                                <a href="<?php echo base_url() ?>index.php/gfk/pemakaianpkm/ubahkunjunganresep/<?php echo $item['id'] ?>" class="btn"><i class="icon-edit"></i> Edit</a>
                                                <a href="#" onClick="xar_confirm('<?php echo base_url() ?>index.php/gfk/pemakaianpkm/hapuskunjunganresep/<?php echo $item['id'] ?>','Apakah Anda ingin menghapus data ini?')" class="btn btn-danger"><i class="icon-remove"></i> Hapus</a>
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