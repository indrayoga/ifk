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
$(document).ready(function() {
    $('#cetak').click(function(){
        var hari=$('#hari').val();
        var kd_unit_apt=$('#kd_unit_apt').val();
        window.location.href='<?php echo base_url() ?>index.php/gfk/laporangfk/excelobatkadaluarsa/'+ hari + '/'+ ((kd_unit_apt) ? kd_unit_apt : "null");
    })
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
                                <h5>LAPORAN OBAT KADALUARSA</h5>
                                <!-- .toolbar -->
                                <div class="toolbar" style="height:auto;">
                                    <ul class="nav nav-tabs">
                                        <li>
                                            <a class="accordion-toggle minimize-box" data-toggle="collapse" href="#div-1">
                                                <i class="icon-chevron-up"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.toolbar value="<-?php echo $periodeawal; ?>"-->
                            </header>
                            <div id="div-1" class="accordion-body collapse in body">
                                <form id="form" class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/gfk/laporangfk/obatkadaluarsa">
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <div class="span8">
                                                <div class="control-group">
                                                    <label for="hari" class="span3" style="text-align:right;">Daftar Obat Kadaluarsa&nbsp;&nbsp;</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" id="hari" name="hari" class="input-small input-tooltip"
                                                               value="<?php echo $hari ?>" data-original-title="Jumlah hari sebelum obat kadaluarsa" data-placement="bottom"/>&nbsp;hari lagi
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                <label for="kd_unit_apt" class="control-label span3" style="text-align:right;">Sumber Dana&nbsp;&nbsp;</label>
                                                <div class="controls with-tooltip">
                                                    <select name="kd_unit_apt" id="kd_unit_apt" class="input-medium">
                                                        <option value="">Pilih Sumber Dana</option>
                                                            <?php
                                                                foreach ($sumberdana as $sd) {
                                                                    $select="";
                                    
                                                                    if(isset($kd_unit_apt)){
                                                                        
                                                                        if($kd_unit_apt==$sd['kd_unit_apt'])$select="selected";else $select="";
                                                                    }
                                                                    
                                                            ?>
                                                                    <option value="<?php if(!empty($sd)) echo $sd['kd_unit_apt'] ?>" <?php echo $select; ?>><?php echo $sd['nama_unit_apt'] ?></option>
                                                            <?php
                                                                }
                                                            ?>
                                                    </select>
                                                    
                                                </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="span3" for="text1" class="control-label">&nbsp;</label>
                                                    <div class="controls with-tooltip">
                                                        <button class="btn btn-primary" type="submit" name="submit" value="cari"><i class="icon-search"></i> Submit</button>
                                                        <button class="btn " type="button" name="submit1" id="cetak" value="cetak"><i class="icon-print"></i> CETAK EXCEL</button>                                                        
                                                    </div>
                                                </div>
                                            </div>                                                      
                                        </div>  
                                            <div id="progress" style="display:none;"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="progress" style="display:none;"></div>
                </div>
                <!--END TEXT INPUT FIELD-->                            
                <!--Begin Datatables-->
                <div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <header>
                                <div class="icons"><i class="icon-move"></i></div>
                                <h5></h5>
                            </header>
                            <div id="collapse4" class="body">
                                <table id="dataTable" class="table table-bordered responsive">
                                    <thead>
                                        <tr style="font-size:90% !important;">
                                            <th style="text-align:center;">NO</th>
                                            <th style="text-align:center;">KD OBAT</th>
                                            <th style="text-align:center;">NAMA OBAT</th>
                                            <th style="text-align:center;">SATUAN</th>
                                            <th style="text-align:center;">UNIT</th>
                                            <th style="text-align:center;">TGL. EXPIRED</th>
                                            <th style="text-align:center;">JUMLAH</th>
                                            <th style="text-align:center;">HARGA</th>
                                            <th style="text-align:center;">TOTAL</th>
                                        </tr>
                                                                                                 
                                    </thead>
                                    <tbody id="listmutasi">
                                        <?php
                                        $no=1;
                                        foreach ($items as $item) {
                                        ?>
                                            <tr style="font-size:90% !important;">
                                                <td style="text-align:right;"><?php echo $no ?></td>
                                                <td><?php echo $item['kd_obat'] ?></td>
                                                <td><?php echo $item['nama_obat']?></td>
                                                <td><?php echo $item['satuan_kecil']?></td> 
                                                <td style="text-align:right;"><?php echo $item['nama_unit_apt'] ?></td>
                                                <td style="text-align:right;"><?php echo $item['tgl_expire'] ?></td>
                                                <td style="text-align:right;"><?php echo $item['jml_stok'] ?></td>
                                                <td style="text-align:right;"><?php echo number_format($item['harga_pokok'],0,'','.') ?></td>
                                                <td style="text-align:right;"><?php echo number_format($item['jml_stok']*$item['harga_pokok'],0,'','.') ?></td>
                                            </tr>                                                    
                                        <?php
                                        $no++;
                                        }                                                           
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
    $('#dataTable').dataTable({
        "aaSorting": [[ 0, "asc" ]],
        "sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sLengthMenu": "Show _MENU_ entries"
        }
    });
    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });
</script>