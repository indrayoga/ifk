<script type="text/javascript">
    $(document).ready(function() {
        $('#kd_jenis_bayar').trigger('change');
    });
</script>
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
                                            <h5>LAPORAN OBAT EXPIRE/RUSAK</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a target="" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/laporanapt/rl1excelobatexpire/<?php echo $periodeawal ?>/<?php echo $periodeakhir; ?>/<?php if(empty($kd_unit_apt )) echo "null"; else echo $kd_unit_apt; ?>/<?php echo $status; ?>"> <i class="icon-print"></i> Export to Excel</a></li>
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
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/laporanapt/obatexpire">
                                                <!-- input periodeawal & periodeakhir -->
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
                                                <!-- input unit -->
                                                <div class="row-fluid">                                             
                                                    <div class="span12">
                                                        <div class="span6">
                                                            <div class="control-group">
                                                                <label for="kd_unit_apt" class="control-label">Unit Apotek</label>
                                                                <div class="controls with-tooltip">
                                                                <select  class="input-xlarge cleared" name="kd_unit_apt" id="kd_unit_apt">
                                                                <option value="">Semua Unit</option>
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
                                                <!-- input limit -->
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="span6">
                                                            <div class="control-group">
                                                                <label for="status" class="control-label">Jenis Laporan</label>
                                                                <div class="controls with-tooltip">
                                                                    <select name="status" id="status">
                                                                        <option value="">Pilih Status</option>
                                                                        <option value="0" <?php if(is_int($status) && $status==0) echo "selected=selected"; ?>>Expire</option>
                                                                        <option value="1" <?php if($status==1) echo "selected=selected"; ?>>Rusak</option>
                                                                    </select>
                                                                   <!--input type="hidden" id="alamat" name="alamat" value="<?php if(isset($itemtransaksi['alamat']))echo $itemtransaksi['alamat'] ?>" class="span4 input-tooltip" data-original-title="alamat" data-placement="bottom"/-->
                                                                    <!--&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp( List Distributor : Ctrl + D )-->
                                                                </div>
                                                                <span class="help-inline"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- submit form -->
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
                                                        <th style="text-align:center;">Sumber Dana</th>
                                                        <th style="text-align:center;">Kode Obat</th>
                                                        <th style="text-align:center;">Nama Obat</th>
                                                        <th style="text-align:center;">Satuan Kecil</th>
                                                        <th style="text-align:center;">Jumlah</th>
                                                        <th style="text-align:center;">Harga</th>
                                                        <th style="text-align:center;">Total</th>
                                                        <th style="text-align:center;">Ket</th>
                                                        <!--th style="text-align:center;">Status Pasien</th-->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $counter = 1;
                                                    $harga=0;
                                                    foreach ($items as $item) {         
                                                    ?>
                                                        <tr style="font-size:90% !important;">
                                                            <td style="text-align:center;"><?= $counter++ ?></td>
                                                            <td style="text-align:center;"><?= $item['nama_unit_apt'] ?></td>
                                                            <td style="text-align:center;"><?= $item['kd_obat'] ?></td>
                                                            <td><?= $item['nama_obat'] ?></td>
                                                            <td style="text-align:center;"><?= $item['satuan_kecil'] ?></td>
                                                            <td style="text-align:right;"><?= $item['jumlah'] ?></td>
                                                            <?php
                                                            if($item['kd_unit_apt']=='D02'){
                                                                ?>
                                                                <td style="text-align:right;"><?= $item['harga_apbd'] ?></td>
                                                                <?php $harga=$item['harga_apbd']; ?>
                                                                <?php
                                                            }
                                                            if($item['kd_unit_apt']=='D03'){
                                                                ?>
                                                                <td style="text-align:right;"><?= $item['harga_p3k'] ?></td>
                                                                <?php $harga=$item['harga_p3k']; ?>
                                                                <?php
                                                            }
                                                            if($item['kd_unit_apt']=='D04'){
                                                                ?>
                                                                <td style="text-align:right;"><?= $item['harga_buffer'] ?></td>
                                                                <?php $harga=$item['harga_buffer']; ?>
                                                                <?php
                                                            }
                                                            if($item['kd_unit_apt']=='apb'){
                                                                ?>
                                                                <td style="text-align:right;"><?= $item['harga_dak'] ?></td>
                                                                <?php $harga=$item['harga_dak']; ?>
                                                                <?php
                                                            }
                                                            if($item['kd_unit_apt']=='U02'){
                                                                ?>
                                                                <td style="text-align:right;"><?= $item['harga_program'] ?></td>
                                                                <?php $harga=$item['harga_program']; ?>
                                                                <?php
                                                            }
                                                            ?>
                                                            <td><?php echo $item['jumlah']*$harga; ?></td>
                                                            <td><?php echo $item['keterangan']; ?></td>
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
        "aaSorting": [[ 0, "asc" ]],
        "sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sLengthMenu": "Show _MENU_ entries"
        },
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