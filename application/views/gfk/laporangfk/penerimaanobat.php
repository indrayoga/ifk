<!--<script type="text/javascript">
    // $(document).ready(function() {
    //     $('#kd_jenis_bayar').trigger('change');
    // });
</script> -->
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
                                <h5>LAPORAN PENERIMAAN OBAT</h5>
                                <!-- .toolbar -->
                                <div class="toolbar" style="height:auto;">
                                    <ul class="nav nav-tabs">
                                        <!-- <li><a target="_blank" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>third-party/fpdf/gfk/distribusi.php?periodeawal=<?php echo $periodeawal ?>&periodeakhir=<?php echo $periodeakhir; ?>&kd_unit_apt=<?php echo $kd_unit_apt; ?>&puskesmas=<?php echo (!empty($puskesmas) ? $puskesmas['id'] : ''); ?>"> <i class="icon-print"></i> PDF</a></li> -->
                                        <li><a target="" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/gfk/laporangfk/excelpenerimaanobat/<?php echo $periodeawal ?>/<?php echo $periodeakhir; ?>/<?php if(empty($kd_unit_apt )) echo "null"; else echo $kd_unit_apt; ?>/<?php echo (!empty($supplier) ? $supplier['kd_supplier'] : 'null'); ?>/<?=$kategori?>"> <i class="icon-print"></i> Export to Excel</a></li>
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
                                <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/gfk/laporangfk/penerimaanobat">
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <div class="span6">
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
                                            </div>                                                      
                                        </div>
                                    </div>
                                    <div class="row-fluid">                                             
                                        <div class="span12">
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label for="kd_unit_apt" class="control-label">Sumber Dana</label>
                                                    <div class="controls with-tooltip">
                                                    <select  class="input-xlarge cleared" name="kd_unit_apt" id="kd_unit_apt">
                                                        <option value="">Semua</option>
                                                        <?php
                                                            foreach ($sumberdana as $sd) {
                                                                $select="";
                                                                if(isset($kd_unit_apt)){
                                                                    if($kd_unit_apt==$sd['kd_unit_apt'])$select="selected=selected";else $select="";
                                                                }
                                                                
                                                        ?>
                                                                <option value="<?php if(!empty($sd)) echo $sd['kd_unit_apt'] ?>" <?php echo $select; ?>><?php echo $sd['nama_unit_apt'] ?></option>
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
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label for="id_supplier" class="control-label">Supplier </label>
                                                    <div class="controls with-tooltip">
                                                    <select  class="input-xlarge cleared" name="id_supplier" id="id_supplier">
                                                        <option value="">Semua</option>
                                                        <?php
                                                            foreach ($distributorList as $splr) {
                                                                $select="";
                                                                if(isset($supplier)){
                                                                    if($supplier['kd_supplier'] ==$splr['kd_supplier'])$select="selected=selected";else $select="";
                                                                }
                                                        ?>
                                                                <option value="<?php if(!empty($splr)) echo $splr['kd_supplier'] ?>" <?php echo $select; ?>><?php echo $splr['nama'] ?></option>
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
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label for="id_supplier" class="control-label"> Kategori </label>
                                                    <div class="controls with-tooltip">
                                                    <select  class="input-xlarge cleared" name="kategori" id="covid">
                                                        <option value="1" <?php if(!empty($kategori) AND $kategori==1)echo"selected"; ?>>Non Logistik Covid</option>
                                                        <option value="2" <?php if(!empty($kategori) AND $kategori==2)echo"selected"; ?>>Logistik Covid</option>
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">                                             
                                        <div class="span12">
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label for="kd_unit_apt" class="control-label">&nbsp;</label>
                                                    <div class="controls with-tooltip">
                                                        <button class="btn btn-primary" type="submit"><i class="icon-search"></i> Cari</button>
                                                        <button class="btn " type="submit" name="reset" value="reset"><i class="icon-undo"></i> Reset</button>
                                                        
                                                    </div>
                                                </div>
                                            </div>
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
                                
                            </header>
                            <div id="collapse4" class="body">
                                <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                    <thead>
                                        <tr style="font-size:90% !important;">
                                            <th style="text-align:center;">No.</th>
                                            <th style="text-align:center;">Supplier</th>
                                            <th style="text-align:center;">Tgl Penerimaan</th>
                                            <th style="text-align:center;">No Faktur</th>
                                            <th style="text-align:center;">Kode Obat</th>
                                            <th style="text-align:center;">Nama Obat</th>
                                            <th style="text-align:center;">Satuan</th>
                                            <th style="text-align:center;">Batch</th>
                                            <th style="text-align:center;">Tgl Expire</th>
                                            <th style="text-align:center;">Jumlah</th>
                                            <th style="text-align:center;">Harga</th>
                                            <th style="text-align:center;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $counter = 1;
                                        $grandtotal = 0;
                                        foreach ($items as $item):
                                            $subtotal = $item['jumlah'] + $item['bonus'];
                                            $total = $item['harga_pokok'] * ($item['jumlah'] + $item['bonus']);
                                            $grandtotal+=$total;
                                        ?>  
                                            <tr style="font-size:90% !important;">
                                                <td style="text-align:right"><?php echo $counter++; ?></td>
                                                <td style="text-align:center;"><?php echo $item['nama_supplier'] ?></td>
                                                <td style="text-align:center;"><?php echo $item['tgl_penerimaan'] ?></td>
                                                <td style="text-align:center;"><?php echo $item['no_faktur'] ?></td>
                                                <td><?php echo $item['kd_obat'] ?></td>
                                                <td><?php echo $item['nama_obat'] ?></td>
                                                <td style="text-align:center;"><?php echo $item['satuan_kecil'] ?></td> 
                                                <td style="text-align:center;"><?php echo $item['no_batch'] ?></td> 
                                                <td style="text-align:center;"><?php echo $item['tgl_expire'] ?></td> 
                                                <td style="text-align:right;"><?php echo $item['jumlah'] ?></td>
                                                <td style="text-align:right;"><?php echo $item['harga_pokok'] ?></td>
                                                <td style="text-align:right;"><?php echo number_format($total,2,',','.'); ?></td>
                                            </tr>
                                        <?php
                                        endforeach;
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th style="text-align:right;"colspan="9">Total</th>
                                            <th style="text-align:right;" class="header">Rp. <input style="text-align:right;width:130px;font-size:95% !important;" type="text" class="input-medium cleared" id="totalpenjualan" value="<?php  echo number_format($grandtotal,2,',','.');?>" disabled></th>
                                        </tr>
                                    </tfoot>
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
    
    $('#periodeawal').datepicker({
        format: 'dd-mm-yyyy'
    });
    
    $('#periodeakhir').datepicker({
        format: 'dd-mm-yyyy'
    });

</script>