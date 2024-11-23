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
                                <h5>LAPORAN DISTRIBUSI OBAT PER PUSKESMAS</h5>
                                <!-- .toolbar -->
                                <div class="toolbar" style="height:auto;">
                                    <ul class="nav nav-tabs">
                                        <!-- <li><a target="_blank" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>third-party/fpdf/gfk/distribusi.php?periodeawal=<?php echo $periodeawal ?>&periodeakhir=<?php echo $periodeakhir; ?>&kd_unit_apt=<?php echo $kd_unit_apt; ?>&puskesmas=<?php echo (!empty($puskesmas) ? $puskesmas['id'] : ''); ?>"> <i class="icon-print"></i> PDF</a></li> -->
                                        <li><a target="" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/gfk/laporangfk/exceldistribusiobat/<?php echo $periodeawal ?>/<?php echo $periodeakhir; ?>/<?php if(empty($kd_unit_apt )) echo "null"; else echo $kd_unit_apt; ?>/<?php echo $kd_obat; ?>/<?php echo $puskesmas; ?>/"> <i class="icon-print"></i> Export to Excel</a></li>
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
                                <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/gfk/laporangfk/distribusiobatpuskesmas">
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
                                                    <label for="id_puskesmas" class="control-label">Puskesmas</label>
                                                    <div class="controls with-tooltip">
                                                    <select  class="input-xlarge cleared" name="id_puskesmas" id="id_puskesmas">
                                                        <option value="">Semua</option>
                                                        <?php
                                                            foreach ($puskesmasList as $pkm) {
                                                                $select="";
                                                                if(isset($puskesmas)){
                                                                    if($puskesmas['id'] ==$pkm['id'])$select="selected=selected";else $select="";
                                                                }
                                                        ?>
                                                                <option value="<?php if(!empty($pkm)) echo $pkm['id'] ?>" <?php echo $select; ?>><?php echo $pkm['nama'] ?></option>
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
                                                    <label for="nama_obat" class="control-label">Nama Obat</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" id="nama_obat" autocomplete="off" name="nama_obat" value="<?php echo $nama_obat?>" class="span7 input-tooltip" data-original-title="nama obat" data-placement="bottom"/>
                                                        <input type="hidden" id="kd_obat" name="kd_obat" value="<?php echo $kd_obat?>" class="span3 input-tooltip" data-original-title="kd obat" data-placement="bottom"/>
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
                                            <th style="text-align:center;">Sumber Dana</th>
                                            <th style="text-align:center;">Puskesmas</th>
                                            <th style="text-align:center;" class="span2">Distribusi</th>
                                            <th style="text-align:center;" class="span2">Harga</th>
                                            <th style="text-align:center;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $counter = 1;
                                        $totalpenjualan = 0;
                                        $totaldistribusi = 0;
                                        foreach ($items as $item):
                                            $subtotal = $item['distribusi'] * $item['harga'];
                                            $totalpenjualan += $subtotal;
                                            $totaldistribusi += $item['distribusi'];
                                        ?>  
                                            <tr style="font-size:90% !important;">
                                                <td style="text-align:right"><?php echo $counter++; ?></td>
                                                <td style="text-align:left;"><?php echo $item['nama_unit_apt'] ?></td>
                                                <td style="text-align:left;"><?php echo $item['nama'] ?></td>
                                                <td style="text-align:right;" class="span2"><?php echo number_format($item['harga'],2,',','.') ?></td>
                                                <td style="text-align:right;" class="span2"><?php echo $item['distribusi'] ?></td>
                                                <td style="text-align:right;"><?php echo number_format($subtotal,2,',','.'); ?></td>
                                            </tr>
                                        <?php
                                        endforeach;
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th style="text-align:right;"colspan="4">Total</th>
                                            <th style="text-align:right;"><input type="text" class="input-medium" style="text-align:right;" value="<?php echo $totaldistribusi; ?>" readonly></th>
                                            <th style="text-align:right;" class="header">Rp. <input style="text-align:right;width:130px;font-size:95% !important;" type="text" class="input-medium cleared" id="totalpenjualan" value="<?php  echo number_format($totalpenjualan,2,',','.');?>" disabled></th>
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
<div aria-hidden="true" aria-labelledby="helpModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="daftarobat" style="display: none;width:60%;margin-left:-400px !important;"> 
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Obat</h3>
    </div>
    <div class="modal-body" id="modal-body-daftarobat" style="height:340px;">
        <div class="body" id="collapse4">
            <table id="dataTable4" class="table table-bordered">
                <thead>
                    <tr>                        
                        <th>Kode Obat</th>
                        <th>Nama Obat</th>
                        <th style="width:50px !important;">Pilihan</th>
                    </tr>
                </thead>
                <tbody id="listobat">

                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <input type="text" id="nama_obat1" class="pull-left" autocomplete="off"> 
        <button aria-hidden="true" data-dismiss="modal" class="btn">Close</button>
    </div>
</div>

<script type="text/javascript">
    $('#dataTable').dataTable({
        "aaSorting": [[ 0, "asc" ]],
        "sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sLengthMenu": "Show _MENU_ entries"
        }
    });
    
    function pilihobat(kd_obat,nama_obat) {
        $('#kd_obat').val(kd_obat);
        $('#nama_obat').val(nama_obat);
        $('#daftarobat').modal("hide");
        $('#bulan').focus();
    }
    
    $('#nama_obat').keyup(function(e){
        if(e.keyCode == 13){
            //alert('xx')
            //$('.barisnamaobat').parent().parent('tr').removeClass('focused');
            //$(this).parent().parent('tr').addClass('focused');

            $("#dataTable4").dataTable().fnDestroy();
            $('#dataTable4').dataTable( {
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/laporanapt/ambilobatbynama/",
                "sServerMethod": "POST",
                "fnServerParams": function ( aoData ) {
                  aoData.push( { "name": "nama_obat", "value":""+$('#nama_obat').val()+""} );
                }
                
            } );
            $('#dataTable4').css('width','100%');
            $('#daftarobat').modal("show");
                var check = function(){
                    if($('#listobat tr').length >0 && !$('#listobat tr').hasClass('ui-selected')){
                        // run when condition is met
                        $('#listobat tr:first').addClass('ui-selected');
                    }
                    else {
                        setTimeout(check, 1000); // check again in a second
                    }
                }
                check();     
        }
    });
    
    /*$('input').live('keydown', function(e) {
            if(e.keyCode == 13){
                return false;                                    
            }
    });*/
    
    $(window).bind('scroll', function() {
        var p = $(window).scrollTop();
        var offset = $(window).offset();
        if(parseInt(p)>1){            
            $('.top').addClass('fixed');
        }else{
            $('.top').removeClass('fixed');
        }
        //if ($(window).scrollTop() + $(window).height() >= $('.top').height()) {
        //  $('.top').addClass('fixed');
        //}
    });
    
    $('input[type="text"]').keydown(function(e){
        //get the next index of text input element
        var next_idx = $('input[type="text"]').index(this) + 1;
         
        //get number of text input element in a html document
        var tot_idx = $('body').find('input[type="text"]').length;
     
        //enter button in ASCII code
        if(e.keyCode == 13){
            //go to the next text input element
            if($(this).parent()[0]['nodeName']=='TD'){
                return false;
            }
            //$('input[type=text]:eq(' + next_idx + ')').focus();
            //$(this).next().focus();
            return false;


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