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

        var totalpenerimaan=0;
        $('.barisjumlah').each(function(){
                var val=$(this).val();
                if(val=='')val=0;
                totalpenerimaan=totalpenerimaan+parseInt(val);
        });
        $('#jumlahapprove').val(totalpenerimaan);
        $('#totalpenerimaan').val(addCommas(totalpenerimaan));

        $('#form').ajaxForm({
            beforeSubmit: function(a,f,o) {
                o.dataType = "json";
                $('div.error').removeClass('error');
                $('span.help-inline').html('');
                $('#progress').show();
                $('body').append('<div id="overlay1" style="position: fixed;height: 100%;width: 100%;z-index: 1000000;"></div>');
                $('body').addClass('body1');
                var urlnya="<?php echo base_url(); ?>index.php/penerimaan/periksapenerimaan";
                //console.log($.param(a));
                //console.log($('#form').serialize());
                z=true;
                $.ajax({
                url: urlnya,
                type:"POST",
                async: false,
                data: $.param(a),
                success: function(data){
                    //alert(data.status);
                    if(parseInt(data.status)==1){
                        z=data.status;
                        //alert('aa');
                        //alert($('input[name="harga"]').val());
                    }else if(parseInt(data.status)==0){
                        //alert('xxx');
                        $('#progress').hide();
                        z=data.status;
                        for(yangerror=0;yangerror<=data.error;yangerror++){
                            $('#'+data.id[yangerror]).siblings('.help-inline').html('<p class="text-error">'+data.pesan[yangerror]+'</p>');
                            $('#'+data.id[yangerror]).parents('row-fluid').focus();
                            //$('#error').html('<div class="alert alert-error fade in"><button data-dismiss="alert" class="close" type="button"><i class="iconic-x"></i></button>Terdapat beberapa kesalahan input silahkan cek inputan anda</div>');                                 
                        }
                        $('#error').html('<div class="alert alert-error fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>'+data.pesanatas+'<br/>'+data.pesanlain+'</div>');
                        if(parseInt(data.clearform)==1){
                            //$('#form').resetForm();
                            $('input').live('keydown', function(e) {
                                if(e.keyCode == 13){
                                    return false;                                    
                                }
                            });

                            $('#form .cleared').clearFields();
                        }
                        $('#overlay1').remove();
                        $('body').removeClass('body1');
                    }
                },
                dataType: 'json'
                });

                if(z==0)return false;
            },
            dataType:  'json',
            success: function(data) {
            //alert(data);
            if (typeof data == 'object' && data.nodeType)
            data = elementToString(data.documentElement, true);
            else if (typeof data == 'object')
            //data = objToString(data);
                if(parseInt(data.status)==1) //jika berhasil
                {
                    //apa yang terjadi jika berhasil
                    $('#progress').hide();
                    $('#overlay1').remove();
                    $('body').removeClass('body1');
                    $('#error').show();
                    $('#error').html('<div class="alert alert-success fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>'+data.pesan+'</div>');
                    if(parseInt(data.keluar)>0){
                        window.location.href='<?php echo base_url(); ?>index.php/penerimaan';
                    }
                    //if(parseInt(data.cetak)>0){
                        //window.location.href='<?php echo base_url(); ?>index.php/loket/cetakregisterpasienxls/'+data.kd_pendaftaran;  
                        //window.open('<?php echo base_url(); ?>index.php/loket/cetakregisterpasienxls/'+data.kd_pendaftaran,'_newtab');                  
                        //window.location.href='<?php echo base_url(); ?>index.php/loket/';                       
                   // }else{
                       // window.location.href='<?php echo base_url(); ?>index.php/loket/';                       
                   // }
                    
                }
                else if(parseInt(data.status)==0) //jika gagal
                {
                    //apa yang terjadi jika gagal
                    $('#progress').hide();
                    $('#overlay1').remove();
                    $('body').removeClass('body1');
                    $('#error').show();
                    $('#error').html('<div class="alert alert-success fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>'+data.pesan+'</div>');
                }

            }
        });       

    });


</script>
<style type="text/css">.datepicker{z-index:1151;}</style>
            <div id="error"></div>
            <div id="overlay"></div>
            <!-- #content -->
            <div id="content">
                <!-- .outer -->
                <div class="container-fluid outer">
                    <div class="row-fluid">
                        <!-- .inner -->
                        <div class="span12 inner">
                        <form class="form-horizontal" id="form" method="post" action="<?php echo base_url() ?>index.php/penerimaan/simpanpenerimaan">                            
                      <!--BEGIN INPUT TEXT FIELDS-->
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header class="top" style="">
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>Penerimaan</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/penerimaan/"> <i class="icon-list"></i> Daftar</a></li>
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/penerimaan/tambahpenerimaan"> <i class="icon-plus"></i> Tambah</a></li>
                                                    <?php if($this->mpenerimaan->isPosted($no_penerimaan)) $disable="disabled";else $disable=""; ?>
                                                    <li><button class="btn" id="simpan" type="submit" <?php echo $disable; ?> name="submit" value="simpan"> <i class="icon-save"></i> Simpan</button></li>
                                                    <li><button class="btn" type="submit" name="submit" <?php echo $disable; ?> value="simpankeluar"> <i class="icon-save icon-share-alt"></i> Simpan &amp; Keluar</button></li>
                                                    <!--
                                                    <li><button class="btn" type="submit" name="submit" value="hapus"> <i class="icon-remove"></i> Hapus</button></li>
                                                    
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="#" onclick="xar_confirm('<?php echo base_url() ?>index.php/penerimaan/hapus/<?php echo $no_penerimaan; ?>','Apa anda yakin akan menghapus data ini?')"> <i class="icon-remove"></i> Hapus</a></li>
                                                    -->
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" data-toggle="modal" data-original-title="Pencarian" data-placement="bottom" rel="tooltip" href="#pencarian"> <i class="icon-search"></i> Pencarian</a></li>
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" data-toggle="modal" data-original-title="Approve" data-placement="bottom" rel="tooltip" href="<?php if(empty($disable)){ ?>#approveform<?php } ?>"  <?php echo $disable; ?>> <i class="icon-ok"></i> Approve</a></li>
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
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="span5">
                                                            <div class="control-group">
                                                                <label for="no_penerimaan" class="control-label">No Penerimaan</label>
                                                                <div class="controls with-tooltip">
                                                                    <input type="text" name="no_penerimaan" id="no_penerimaan" value="<?php echo $no_penerimaan; ?>" readonly class="input-xlarge input-tooltip" data-original-title="no penerimaan" data-placement="bottom"/>
                                                                    <span class="help-inline"></span>
                                                               </div>
                                                            </div>
                                                        </div>
                                                        <div class="span6">
                                                            <div class="control-group">
                                                                <label for="tanggal" class="control-label">Tanggal</label>
                                                                <div class="controls with-tooltip">
                                                                    <input type="text" name="tanggal" id="tanggal" class="input-small input-tooltip cleared" data-original-title="tanggal" data-mask="99-99-9999" value="<?php if(empty($itemtransaksi['cso_date']))echo date('d-m-Y'); else echo convertDate($itemtransaksi['cso_date']); ?>" data-placement="bottom"/>
                                                                     <span class="help-inline"></span>
                                                               </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="span5">
                                                            <div class="control-group">
                                                                <label for="terima_dari" class="control-label">Terima Dari</label>
                                                                <div class="controls with-tooltip">
                                                                    <input type="text" name="terima_dari" id="terima_dari" class="input-xlarge input-tooltip cleared" value="<?php if(isset($itemtransaksi['personal']))echo $itemtransaksi['personal'] ?>" data-original-title="terima dari" data-placement="bottom"/>
                                                                    <span class="help-inline"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="span6">
                                                            <div class="control-group">
                                                                <label for="unit_kerja" class="control-label">Unit Kerja</label>
                                                                <div class="controls with-tooltip">
                                                                    <select class="input-large cleared" name="unit_kerja" id="unit_kerja">
                                                                        <?php
                                                                        foreach ($dataunitkerja as $unitkerja) {
                                                                            # code...
                                                                        $select="";
                                                                        if(isset($itemtransaksi['kd_unit_kerja'])){    
                                                                            if($itemtransaksi['kd_unit_kerja']==$unitkerja['kd_unit_kerja'])$select="selected=selected";else $select="";
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo $unitkerja['kd_unit_kerja'] ?>" <?php echo $select; ?>><?php echo $unitkerja['nama_unit_kerja'] ?></option>
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
                                                        <div class="control-group">
                                                            <label for="kas" class="control-label">Kas / Bank</label>
                                                            <div class="controls with-tooltip">
                                                                <select name="kas" id="kas" class="input-xxlarge cleared">
                                                                    <?php
                                                                    foreach ($dataakun as $akun) {
                                                                        # code...
                                                                    $select="";
                                                                    if(isset($itemtransaksi['account'])){
                                                                    if($itemtransaksi['account']==$akun['account'])$select="selected=selected";else $select="";
                                                                    }
                                                                    ?>
                                                                    <option value="<?php echo $akun['account'] ?>" <?php echo $select; ?>><?php echo $akun['name'] ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="span5">
                                                            <div class="control-group">
                                                                <label for="jenis_pembayaran" class="control-label">Jenis Pembayaran</label>
                                                                <div class="controls with-tooltip">
                                                                    <select name="jenis_pembayaran" id="jenis_pembayaran" class="input-xlarge cleared">
                                                                        <?php
                                                                        foreach ($datajenispembayaran as $jepem) {
                                                                            # code...
                                                                        $select="";
                                                                        if(isset($itemtransaksi['pay_code'])){
                                                                            if($itemtransaksi['pay_code']==$jepem['pay_code'])$select="selected=selected";else $select="";
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo $jepem['pay_code'] ?>" <?php echo $select; ?>><?php echo $jepem['payment'] ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="span6">
                                                            <div class="control-group">
                                                                <label for="no_pembayaran" class="control-label">No Pembayaran</label>
                                                                <div class="controls with-tooltip">
                                                                    <input type="text" name="no_pembayaran" id="no_pembayaran" value="<?php if(isset($itemtransaksi['pay_no']))echo $itemtransaksi['pay_no']; ?>" class="input-large input-tooltip" data-original-title="terima dari" data-placement="bottom"/>
                                                                    <span class="help-inline"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="control-group">
                                                            <label for="keterangan" class="control-label">Keterangan</label>
                                                            <div class="controls with-tooltip">
                                                                <input type="text" name="keterangan" id="keterangan" value="<?php if(isset($itemtransaksi['notes']))echo $itemtransaksi['notes']; ?>" class="input-xxlarge input-tooltip cleared" data-original-title="keterangan" data-placement="bottom"/>
                                                                <span class="help-inline"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>                                                                                                
                                        </div>
                                                    <div id="progress" style="display:none;"></div>

                                    </div>
                                </div>
                            </div>

                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box error">
                                        <header>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;float:left;">
                                                <ul class="nav nav-tabs">
                                                    <li><button class="btn" type="button" id="tambahbaris"> <i class="icon-plus"></i> Tambah Baris</button></li>
                                                    <li><button class="btn" type="button" id="hapusbaris"> <i class="icon-remove"></i> Hapus Baris</button></li>
                                                </ul>
                                            </div>
                                            <!-- /.toolbar -->
                                        </header>
                                        <div class="body collapse in" id="defaultTable">
                                            <table class="table responsive">
                                                <thead>
                                                    <tr>
                                                        <th class="header">&nbsp;</th>
                                                        <th class="header">Akun</th>
                                                        <th class="header">Nama Akun</th>
                                                        <th class="header">Keterangan</th>
                                                        <th class="header">Jumlah (Rp)</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bodyinput">
                                                    <?php
                                                    if(isset($itemsdetiltransaksi)){
                                                        foreach ($itemsdetiltransaksi as $itemdetil) {
                                                            # code...
                                                        ?>
                                                        <tr><td style="text-align:center;"><input type="checkbox" class="barisinput" /></td>
                                                            <td><input type="text" name="akun[]" value="<?php echo $itemdetil['account'] ?>" class="input-medium barisakun cleared"></td>
                                                            <td><input type="text" name="nama_akun[]" value="<?php echo $itemdetil['name'] ?>" class="input-large barisnamaakun cleared"></td>
                                                            <td><input type="text" name="keteranganakun[]" value="<?php echo $itemdetil['description'] ?>" class="input-xlarge cleared"></td>
                                                            <td><input type="text" name="jumlah[]" value="<?php echo $itemdetil['value'] ?>" class="input-medium barisjumlah cleared"></td>
                                                        </tr>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                     <tr>
                                                        <th class="header">&nbsp;</th>
                                                        <th class="header">&nbsp;</th>
                                                        <th class="header">&nbsp;</th>
                                                        <th class="header">&nbsp;</th>
                                                        <th class="header">Total : <input type="text" class="input-medium cleared" id="totalpenerimaan" style="text-align:right" disabled></th>
                                                    </tr>
                                               </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div aria-hidden="true" aria-labelledby="approveModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="approveform" style="display: none;">
                                <div class="modal-header">
                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                    <h3 id="helpModalLabel"><i class="icon-external-link"></i> Approve</h3>
                                </div>
                                <div class="modal-body" style="">
                                    <div class="body" id="collapse4">
                                        <div class="row-fluid">
                                        <div class="span12">
                                            <div class="control-group">
                                                <label for="no_reff" class="control-label">No Reff.</label>
                                                <div class="controls with-tooltip">
                                                    <input type="text" name="no_reff" id="no_reff" class="input-large input-tooltip" data-original-title="no reff" data-placement="bottom"/>
                                                    <span class="help-inline"></span>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="tanggalapprove" class="control-label">Tanggal.</label>
                                            <div class="controls with-tooltip">
                                                <input type="text" name="tanggalapprove" id="tanggalapprove" data-mask="99-99-9999" value="<?php echo date('d-m-Y') ?>" class="input-small input-tooltip" data-original-title="tanggal approve" data-placement="bottom"/>
                                                <span class="help-inline"></span>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="jumlahapprove" class="control-label">Jumlah.</label>
                                            <div class="controls with-tooltip">
                                                <input type="text" name="jumlahapprove" id="jumlahapprove" readonly class="input-large input-tooltip" data-original-title="jumlah" data-placement="bottom"/>
                                                <span class="help-inline"></span>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="catatan" class="control-label">Catatan.</label>
                                            <div class="controls with-tooltip">
                                                <input type="text" name="catatan" id="catatan" class="input-xlarge input-tooltip" data-original-title="catatan" data-placement="bottom"/>
                                                <span class="help-inline"></span>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="catatan" class="control-label">&nbsp;</label>
                                            <div class="controls with-tooltip">
                                                <button class="btn btn-primary" type="submit" name="submit" value="simpanapprove">OK</button>
                                                <button aria-hidden="true" data-dismiss="modal" class="btn">Cancel</button>
                                                <span class="help-inline"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button aria-hidden="true" data-dismiss="modal" class="btn">Close</button>
                                </div>
                            </div>


                            <div aria-hidden="true" aria-labelledby="approveModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="pencarian" style="display: none;width:97%;left:24% !important;">
                                <div class="modal-header">
                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                    <h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Penerimaan</h3>
                                </div>
                                <div class="modal-body" style="">
                                    <div class="body" id="collapse4">

                                            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No Penerimaan</th>
                                                        <th>Tanggal</th>
                                                        <th>Unit Kerja</th>
                                                        <th>Kas/Bank</th>
                                                        <th>Jenis Pembayaran</th>
                                                        <!--<th>Approve</th>-->
                                                        <th>Pilihan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($items as $item) {
                                                        # code...
                                                        $posted=$this->mpenerimaan->isPosted($item['cso_number']);
                                                    ?>
                                                        <tr>
                                                        <td><?php echo $item['cso_number'] ?></td>
                                                        <td><?php echo convertDate($item['cso_date']) ?></td>
                                                        <td><?php echo $item['nama_unit_kerja'] ?></td>
                                                        <td><?php echo $item['name'] ?></td>
                                                        <td><?php echo $item['payment'] ?></td>
                                                        <!--
                                                        <td style="text-align:center;"><?php if($posted)echo "<span class='badge label-success'><i class='icon-ok'></i></span>";else echo '&nbsp;' ?></td>
                                                        -->
                                                        <td style="text-align:center;width:160px;">
                                                            <?php
                                                            if($posted){
                                                                echo "<span class='badge label-success'>APPROVE</span>";
                                                            }else{
                                                            ?>
                                                                <a href="<?php echo base_url() ?>index.php/penerimaan/editpenerimaan/<?php echo $item['cso_number'] ?>" class="btn"><i class="icon-edit"></i> PILIH</a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        </tr>                                                    
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button aria-hidden="true" data-dismiss="modal" class="btn">Close</button>
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

<div aria-hidden="true" aria-labelledby="helpModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="daftarakun" style="display: none;">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Akun</h3>
    </div>
    <div class="modal-body" style="height:340px;">
        <div class="body" id="collapse4">
            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                <thead>
                    <tr>
                        <th>Akun</th>
                        <th>Nama Akun</th>
                        <th>Pilihan</th>
                    </tr>
                </thead>
                <tbody id="listakun">

                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <input type="text" class="pull-left">
        <button aria-hidden="true" data-dismiss="modal" class="btn">Close</button>
    </div>
</div>


<script type="text/javascript">
    $(function() {
        metisTable();

    });


    $('input[type="text"]').keydown(function(e){
        //get the next index of text input element
        var next_idx = $('input[type="text"]').index(this) + 1;
         
        //get number of text input element in a html document
        var tot_idx = $('body').find('input[type="text"]').length;
     
        //enter button in ASCII code
        if(e.keyCode == 13){
            //go to the next text input element
            $('input[type=text]:eq(' + next_idx + ')').focus();
            //$(this).next().focus();
            return false;
        }

    });


    $('#tanggal').datepicker({
        format: 'dd-mm-yyyy'
    });

    $('#tanggalapprove').datepicker({
        format: 'dd-mm-yyyy'
    });

    var nomorbaris=1;
    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });

    function pilihakun(akun,nama_akun)
    {
        $('.focused').find('.barisakun').val(akun);
        $('.focused').find('.barisnamaakun').val(nama_akun);
        $('#daftarakun').modal("hide");
        $('.focused').find('input[name="keteranganakun[]"]').focus();
    }
    $('#tambahbaris').click(function(){
        $('#bodyinput').append('<tr><td style="text-align:center;"><input type="checkbox" class="barisinput cleared" /></td>'+
                                    '<td><input type="text" name="akun[]" value="" class="input-medium barisakun cleared"></td>'+
                                    '<td><input type="text" name="nama_akun[]" value="" class="input-large barisnamaakun cleared"></td>'+
                                    '<td><input type="text" name="keteranganakun[]" value="" class="input-xlarge cleared"></td>'+
                                    '<td><input type="text" name="jumlah[]" value="" class="input-medium barisjumlah cleared"></td>'+
                                '</tr>');


        $("#bodyinput tr:last input[name='akun[]']").focus();

        $('.barisjumlah').change(function(){
             var totalpenerimaan=0;
           $('.barisjumlah').each(function(){
                var val=$(this).val();
                if(val=='')val=0;
                totalpenerimaan=totalpenerimaan+parseInt(val);
            });
           $('#jumlahapprove').val(totalpenerimaan);
           $('#totalpenerimaan').val(addCommas(totalpenerimaan));
        });

        $('.barisakun').keyup(function(e){
            $.ajax({
                url: '<?php echo base_url() ?>index.php/penerimaan/ambildaftarakunbykode/',
                async:false,
                type:'get',
                data:{query:$(this).val()},
                success:function(data){
                    //typeahead.process(data)
                    $('#listakun').empty();
                    $.each(data,function(i,l){
                        //alert(l);
                        $('#listakun').append('<tr><td>'+l.account+'</td><td>'+l.name+'</td><td><a class="btn" onclick=\'pilihakun("'+l.account+'","'+l.name+'")\'>Pilih</a></td></tr>');
                    });
                    
                },
                dataType:'json'                         
            }); 

            if(e.keyCode == 13){
                //alert('xx')
                $('.barisakun').parent().parent('tr').removeClass('focused');
                $(this).parent().parent('tr').addClass('focused');
                $('#daftarakun').modal("show");  
            }
        });

        $('.barisnamaakun').keyup(function(e){
            $.ajax({
                url: '<?php echo base_url() ?>index.php/penerimaan/ambildaftarakunbynama/',
                async:false,
                type:'get',
                data:{query:$(this).val()},
                success:function(data){
                    //typeahead.process(data)
                    $('#listakun').empty();
                    $.each(data,function(i,l){
                        //alert(l);
                        $('#listakun').append('<tr><td>'+l.account+'</td><td>'+l.name+'</td><td><a class="btn">Pilih</a></td></tr>');
                    });
                    
                },
                dataType:'json'                         
            }); 


            if(e.keyCode == 13){
                //alert('xx')
                $('.barisakun').parent().parent('tr').removeClass('focused');
                $(this).parent().parent('tr').addClass('focused');
                $('#daftarakun').modal("show");                                      
            }
        });


        nomorbaris++;
    });

    $('#hapusbaris').click(function(){
         $('.barisinput:checked').parents('tr').remove();
             var totalpenerimaan=0;
           $('.barisjumlah').each(function(){
                var val=$(this).val();
                if(val=='')val=0;
                totalpenerimaan=totalpenerimaan+parseInt(val);
            });
           $('#jumlahapprove').val(totalpenerimaan);
           $('#totalpenerimaan').val(addCommas(totalpenerimaan));


    });

        $('input').live('keydown', function(e) {
            if(e.keyCode == 13){
                return false;                                    
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

                 //if ($(window).scrollTop() + $(window).height() >= $('.top').height()) {
                   //  $('.top').addClass('fixed');
                 //}

            });

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