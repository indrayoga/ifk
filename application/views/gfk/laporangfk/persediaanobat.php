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
        var bulan=$('#bulan').val();
        var tahun=$('#tahun').val();
        var kd_unit_apt=$('#kd_unit_apt').val();
        var id_puskesmas=$('#id_puskesmas').val();
        window.location.href='<?php echo base_url() ?>index.php/gfk/laporangfk/lplpopkmxls/'+bulan+'/'+tahun+'/'+kd_unit_apt+'/'+id_puskesmas;
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
                                            <h5>LAPORAN LPLPO PUSKESMAS</h5>
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
                                            <form id="form" class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/gfk/laporangfk/lplpopkm">                                                
                                                
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="span7">
                                                            <div class="control-group">
                                                                <label for="bulan" class="control-label">Periode</label>
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
                                                                    <select name="tahun" id="tahun" class="input-small">
                                                                        <option value="<?php echo date('Y'); ?>" <?php if($tahun==date('Y')) echo "selected=selected"; ?>><?php echo date('Y'); ?></option>
                                                                        <option value="<?php echo date('Y')-1; ?>" <?php if($tahun==date('Y')-1) echo "selected=selected"; ?>><?php echo date('Y')-1; ?></option>
                                                                        <option value="<?php echo date('Y')-2; ?>" <?php if($tahun==date('Y')-2) echo "selected=selected"; ?>><?php echo date('Y')-2; ?></option>
                                                                        <option value="<?php echo date('Y')-3; ?>" <?php if($tahun==date('Y')-3) echo "selected=selected"; ?>><?php echo date('Y')-3; ?></option>
                                                                        <option value="<?php echo date('Y')-4; ?>" <?php if($tahun==date('Y')-4) echo "selected=selected"; ?>><?php echo date('Y')-4; ?></option>
                                                                        <option value="<?php echo date('Y')-5; ?>" <?php if($tahun==date('Y')-5) echo "selected=selected"; ?>><?php echo date('Y')-5; ?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <!--<div class="control-group">
                                                            <label for="text1" class="control-label">Sumber Dana</label>
                                                            <div class="controls with-tooltip">
                                                                <select   name="kd_unit_apt" id="kd_unit_apt" class="input-medium">
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
                                                        </div>-->
                                                        <div class="control-group">
                                                            <label for="id_puskesmas" class="control-label">Puskesmas </label>
                                                            <div class="controls with-tooltip">
                                                                <select id="id_puskesmas" name="id_puskesmas">
                                                                    <option value="">Pilih Puskesmas</option>
                                                                    <?php
                                                                    foreach ($puskesmasList as $item) {
                                                                        # code...
                                                                        $selected = false;
                                                                        if($id_puskesmas == $item['id']) {
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

                                                        </div>                                                      
                                                    </div>  
                                                        <div id="progress" style="display:none;"></div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">&nbsp;</label>
                                                    <div class="controls with-tooltip">
                                                        <button class="btn btn-primary" type="submit" name="submit" value="cari"><i class="icon-search"></i> Submit</button>
                                                        <button class="btn " type="button" name="submit1" id="cetak" value="cetak"><i class="icon-print"></i> CETAK EXCEL</button>                                                        
                                                    </div>
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
                                                        <th style="text-align:center;" rowspan="2">NO</th>
                                                        <th style="text-align:center;" rowspan="2">KD OBAT</th>
                                                        <th style="text-align:center;" rowspan="2">NAMA OBAT</th>
                                                        <th style="text-align:center;" rowspan="2">SATUAN</th>
                                                        <th style="text-align:center;" rowspan="2">SALDO AWAL</th>
                                                        <th style="text-align:center;" rowspan="2">PENERIMAAN</th>
                                                        <th style="text-align:center;" rowspan="2">PEMAKAIAN</th>
                                                        <th style="text-align:center;" rowspan="2">SISA STOK</th>
                                                        <th style="text-align:center;" rowspan="2">STOK OPTIMUM</th>
                                                        <th style="text-align:center;" rowspan="2">PERMINTAAN</th>
                                                        <th style="text-align:center;" colspan="5">PEMBERIAN</th>
                                                        <th style="text-align:center;" rowspan="2">TOTAL</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align:center;">APBN</th>
                                                        <th style="text-align:center;">PROGRAM</th>
                                                        <th style="text-align:center;">APBD 1</th>
                                                        <th style="text-align:center;">APBD 2</th>
                                                        <th style="text-align:center;">LAIN2</th>
                                                    </tr>                                                     
                                                </thead>
                                                <tbody id="listmutasi">
                                                    <?php
                                                    $no=1;
                                                            $jum_bulan = 1;        
                                                    foreach ($items as $item) {
                                                        $item['opt']=$item['saldo_akhir']+$item['out_jual'] + ( $item['out_jual'] * 20/100 );
                                                        if($item['out_jual'] > 0){
                                                        $item['permintaan']=$item['opt'] - $item['saldo_akhir'];
                                                        }else{
                                                        $item['permintaan']=0;
                                                        }
                                                        $queryapbn=$this->db->query('select sum(qty) as qty from apt_penjualan_detail a join apt_penjualan b on a.no_penjualan=b.no_penjualan where a.kd_obat="'.$item['kd_obat'].'" and customer_id="'.$item['id_puskesmas'].'" and a.kd_unit_apt="apb" and month(b.tgl_penjualan)="'.$bulan.'" and year(b.tgl_penjualan)="'.$tahun.'" ');
                                                        $queryapbd1=$this->db->query('select sum(qty) as qty from apt_penjualan_detail a join apt_penjualan b on a.no_penjualan=b.no_penjualan where a.kd_obat="'.$item['kd_obat'].'" and customer_id="'.$item['id_puskesmas'].'" and a.kd_unit_apt="D02" and month(b.tgl_penjualan)="'.$bulan.'" and year(b.tgl_penjualan)="'.$tahun.'" ');
                                                        $queryapbd2=$this->db->query('select sum(qty) as qty from apt_penjualan_detail a join apt_penjualan b on a.no_penjualan=b.no_penjualan where a.kd_obat="'.$item['kd_obat'].'" and customer_id="'.$item['id_puskesmas'].'" and a.kd_unit_apt="D03" and month(b.tgl_penjualan)="'.$bulan.'" and year(b.tgl_penjualan)="'.$tahun.'" ');
                                                        $querylain=$this->db->query('select sum(qty) as qty from apt_penjualan_detail a join apt_penjualan b on a.no_penjualan=b.no_penjualan where a.kd_obat="'.$item['kd_obat'].'" and customer_id="'.$item['id_puskesmas'].'" and a.kd_unit_apt="D04" and month(b.tgl_penjualan)="'.$bulan.'" and year(b.tgl_penjualan)="'.$tahun.'" ');
                                                        $queryprogram=$this->db->query('select sum(qty) as qty from apt_penjualan_detail a join apt_penjualan b on a.no_penjualan=b.no_penjualan where a.kd_obat="'.$item['kd_obat'].'" and customer_id="'.$item['id_puskesmas'].'" and a.kd_unit_apt="U02" and month(b.tgl_penjualan)="'.$bulan.'" and year(b.tgl_penjualan)="'.$tahun.'" ');
                                                        $rowapbn=$queryapbn->row_array();
                                                        $rowapbd1=$queryapbd1->row_array();
                                                        $rowapbd2=$queryapbd2->row_array();
                                                        $rowlain=$querylain->row_array();
                                                        $rowprogram=$queryprogram->row_array();
                                                   ?>
                                                        <tr style="font-size:90% !important;">
                                                            <td style="text-align:right;"><?php echo number_format($no)?></td>
                                                            <td><?php echo $item['kd_obat'] ?></td>
                                                            <td ><?php echo $item['nama_obat']?></td>
                                                            <td ><?php echo $item['satuan_kecil']?></td> 
                                                            <td style="text-align:right;"><?php echo $item['saldo_awal'] ?></td>
                                                            <td style="text-align:right;"><?php echo $item['in_pbf'] ?></td>
                                                            <td style="text-align:right;"><?php echo $item['out_jual'] ?></td>
                                                            <td style="text-align:right;"><?php echo $item['saldo_akhir'] ?></td>
                                                            <td style="text-align:right;"><?php echo $item['opt'] ?></td>
                                                            <td style="text-align:right;"><?php echo $item['permintaan'] ?></td>
                                                            <td style="text-align:right;"><?php echo $rowapbn['qty'] ?></td>
                                                            <td style="text-align:right;"><?php echo $rowprogram['qty'] ?></td>
                                                            <td style="text-align:right;"><?php echo $rowapbd1['qty'] ?></td>
                                                            <td style="text-align:right;"><?php echo $rowapbd2['qty'] ?></td>
                                                            <td style="text-align:right;"><?php echo $rowprogram['qty'] ?></td>
                                                            <td style="text-align:right;"><?php echo $rowapbn['qty']+$rowprogram['qty']+$rowapbd1['qty']+$rowapbd2['qty']+$rowprogram['qty'] ?></td>
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