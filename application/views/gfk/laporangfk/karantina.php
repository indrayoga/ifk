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
                                <h5>LAPORAN KARANTINA</h5>
                                <!-- .toolbar -->
                                <div class="toolbar" style="height:auto;">
                                    <ul class="nav nav-tabs">
                                        <!-- <li><a target="_blank" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>third-party/fpdf/gfk/distribusi.php?periodeawal=<?php echo $periodeawal ?>&periodeakhir=<?php echo $periodeakhir; ?>&kd_unit_apt=<?php echo $kd_unit_apt; ?>"> <i class="icon-print"></i> PDF</a></li> -->
                                        <li><a target="" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/gfk/laporangfk/excelkarantina/<?php echo $periodeawal ?>/<?php echo $periodeakhir; ?>/<?php if(empty($kd_unit_apt )) echo "null"; else echo $kd_unit_apt; ?>"> <i class="icon-print"></i> Export to Excel</a></li>
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
                                <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/gfk/laporangfk/karantina">
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
                                                    <label for="kd_unit_apt" class="control-label">Sumber</label>
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
                                            <th style="text-align:center;">No Transaksi</th>
                                            <th style="text-align:center;">Sumber</th>
                                            <th style="text-align:center;">Kd.Obat</th>
                                            <th style="text-align:center;">Nama Obat</th>
                                            <th style="text-align:center;">Qty</th>
                                            <th style="text-align:center;">Satuan</th>
                                            <th style="text-align:center;">Tgl Expire</th>
                                            <th style="text-align:center;">Keterangan</th>
                                            <th style="text-align:center;">Harga</th>
                                            <th style="text-align:center;">Total</th>
                                            <th style="text-align:center;">Pilihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    
                                         $totaldistribusi=0;
                                        foreach ($items as $item):         
                                            $totaldistribusi += ($item['qty']*$item['harga_pokok']);
                                        ?>
                                            <tr style="font-size:90% !important;">
                                                <td style="text-align:center;"><?php echo $item['no_disposal'] ?></td>
                                                <td style="text-align:center;"><?php echo $item['nama_unit_apt'] ?></td>
                                                <td style="text-align:center;"><?php echo $item['kd_obat'] ?></td>
                                                <td><?php echo $item['nama_obat'] ?></td>
                                                <td style="text-align:right;"><?php echo $item['qty'] ?></td>
                                                <td style="text-align:right;"><?php echo $item['satuan_kecil'] ?></td> 
                                                <td style="text-align:right;"><?php echo $item['tgl_expire'] ?></td>
                                                <td style="text-align:right;"><?php echo $item['keterangan'] ?></td>
                                                <td style="text-align:right;"><?php echo $item['harga_pokok'] ?></td>
                                                <td style="text-align:right;"><?php echo ($item['qty']*$item['harga_pokok']) ?></td>
                                                <td style="text-align:center;"><a href="<?=base_url('index.php/transapotek/aptdisposal/kembalikan/'.$item['no_disposal'].'/'.$item['urut'])?>">Kembalikan</a></td>
                                            </tr>                                             
                                        <?php
                                        endforeach;
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="10" style="text-align:right;" class="header">Total Penjualan (Rp) : <input style="text-align:right;width:130px;font-size:95% !important;" type="text" class="input-medium cleared" id="totalpenjualan" value="<?php  echo number_format($totaldistribusi,2,',','.');?>" disabled></th>
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
    
    // $('#kd_jenis_bayar').change(function(){
    //     if($(this).val()=="003"){
    //         //$('#kd_sumber').text('Simpan Transfer');
    //         $('#cust_code').prop("disabled", false);
    //     }
    //     else {
    //         $('#cust_code').prop("disabled", true);
    //     }
    // })
    
    /*$('#tgl_penjualan').change(function(){
        $.ajax({
            url: '<?php echo base_url() ?>index.php/transapotek/laporanapt/ambiltglkemaren/',
            async:true,
            type:'post',
            data:{query:$('#tgl_penjualan').val()},
            success:function(data,result){  
                //alert(result);
                alert(this.data);
                alert(this.result);
                /*$.each(result,function(i,l){
                    alert('2');
                    $('#tgl_kemaren').html(result.yesterday);
                    alert('3');
                }); */  
            /*},
            dataType:'json'                         
        });  
    });*/
    
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