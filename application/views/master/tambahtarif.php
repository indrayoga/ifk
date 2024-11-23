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

            $('#form').ajaxForm({
                beforeSubmit: function(a,f,o) {
                    o.dataType = "json";
                    $('div.error').removeClass('error');
                    $('span.help-inline').html('');
                    $('#progress').show();
                    $('body').append('<div id="overlay1" style="position: fixed;height: 100%;width: 100%;z-index: 1000000;"></div>');
                    $('body').addClass('body1');
                    z=true;
                    $.ajax({
                    url: "<?php echo base_url(); ?>index.php/master/tarif/periksa",
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
                            $('body').removeClass('body1');
                            z=data.status;
                            for(yangerror=0;yangerror<=data.error;yangerror++){
                            //  alert(data.id[yangerror]);
                                $('#'+data.id[yangerror]).siblings('.help-inline').html('<p class="text-error">'+data.pesan[yangerror]+'</p>');
                                $('#error').html('<div class="alert alert-error fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>Terdapat beberapa kesalahan input silahkan cek inputan anda</div>');
                            }
                            $('#error').html('<div class="alert alert-error fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>'+data.pesanatas+'<br/>'+data.pesanlain+'</div>');
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
                    }
                    else if(parseInt(data.status)==0) //jika gagal
                    {
                        //apa yang terjadi jika gagal
                        $('#progress').hide();
                        $('#overlay1').remove();
                        $('body').removeClass('body1');
                        $('body').removeClass('body1');
                        $('#error').html('<div class="alert alert-success fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>'+data.pesan+'</div>');
                    }

                }
            });       

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
                                            <h5>Pencarian Data</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a href="<?php echo base_url() ?>index.php/master/tarif"> <i class="icon-list"></i> Daftar</a></li>
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
                                            <form class="form-horizontal" id="form" method="post" action="<?php echo base_url()?>index.php/master/tarif/simpan">
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="span5">
                                                            <div class="control-group">
                                                                <label for="kd_pelayanan" class="control-label">Poli/Ruangan</label>
                                                                <div class="controls with-tooltip">
                                                                    <select name="kd_unit_kerja" id="kd_unit_kerja" class="input-large" onchange="javascript:window.location.href='<?php echo base_url() ?>index.php/master/tarif/tambah/'+this.value">
                                                                    <option value="">Pilih Poli/Ruangan</option>
                                                                    <?php
                                                                    foreach ($dataunitkerja as $unitkerja) {
                                                                        # code...
                                                                        if($unitkerja['kd_unit_kerja']==$unit)$sel="selected=selected"; else $sel="";
                                                                    ?>
                                                                    <option value="<?php echo $unitkerja['kd_unit_kerja'] ?>" <?php echo $sel; ?>><?php echo $unitkerja['nama_unit_kerja'] ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    </select>
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
                                                                <label for="kd_pelayanan" class="control-label">Pelayanan</label>
                                                                <div class="controls with-tooltip">
                                                                    <select name="kd_pelayanan" id="kd_pelayanan" class="input-large">
                                                                    <option value="">Pilih Pelayanan</option>
                                                                    <?php
                                                                    foreach ($datapelayanan as $pelayanan) {
                                                                        # code...
                                                                    ?>
                                                                    <option value="<?php echo $pelayanan['kd_pelayanan'] ?>"><?php echo $pelayanan['nama_pelayanan'] ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    </select>
                                                                    <span class="help-inline"></span>
                                                                </div>
                                                            </div>                                                     
                                                        </div>
                                                        <div class="span4">
                                                            <div class="control-group">
                                                                <label for="kd_kelas" class="control-label">Kelas</label>
                                                                <div class="controls with-tooltip">
                                                                    <select name="kd_kelas" id="kd_kelas" class="input-medium">
                                                                    <option value="">Pilih Kelas</option>
                                                                    <?php
                                                                    foreach ($datakelas as $kelas) {
                                                                        # code...
                                                                    ?>
                                                                    <option value="<?php echo $kelas['kd_kelas'] ?>"><?php echo $kelas['kelas'] ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    </select>
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
                                                                <label for="kd_jenis_tarif" class="control-label">Jenis Tarif</label>
                                                                <div class="controls with-tooltip">
                                                                    <select name="kd_jenis_tarif" id="kd_jenis_tarif" class="input-medium">
                                                                    <?php
                                                                    foreach ($datajenistarif as $jenistarif) {
                                                                        # code...
                                                                    ?>
                                                                    <option value="<?php echo $jenistarif['kd_jenis_tarif'] ?>"><?php echo $jenistarif['jenis_tarif'] ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    </select>
                                                                    <span class="help-inline"></span>
                                                                </div>
                                                            </div>
                                                        </div>                                                   
                                                       <div class="span5">
                                                            <div class="control-group">
                                                                <label for="cust_code" class="control-label">Customer</label>
                                                                <div class="controls with-tooltip">
                                                                    <select name="cust_code" id="cust_code" class="input-medium">
                                                                    <?php
                                                                    foreach ($datacustomer as $customer) {
                                                                        # code...
                                                                    ?>
                                                                    <option value="<?php echo $customer['cust_code'] ?>"><?php echo $customer['customer'] ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    </select>
                                                                    <span class="help-inline"></span>
                                                                </div>
                                                            </div>
                                                        </div>                                                   
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="control-group">
                                                            <div class="controls with-tooltip">
                                                                <table style="width:600px;" id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="span5">Komponen</th>
                                                                        <th class="span1">Nilai</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php
                                                                    foreach ($datacomponent as $component) {
                                                                        # code...
                                                                    ?>
                                                                    <tr>
                                                                        <td class="span5"><?php echo $component['nama_component'] ?></td>
                                                                        <td><input style="text-align:right;" type="text" name="component[<?php echo $component['kd_component'] ?>]" class="komponen_tarif input-small"></td>
                                                                    </tr>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>                                                  
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="offset5 span5">
                                                            <div class="control-group">
                                                                <label for="tarif" class="control-label">Total Tarif</label>
                                                                <div class="controls with-tooltip">
                                                                    <input type="text" name="tarif" id="tarif" class="input-medium" style="text-align:right;">
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
                                                                <label for="tgl_berlaku" class="control-label">Tgl Berlaku</label>
                                                                <div class="controls with-tooltip">
                                                                    <input type="text" name="tgl_berlaku" id="tgl_berlaku" data-mask="99-99-9999" class="input-small">
                                                                    <span class="help-inline"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="span5">
                                                            <div class="control-group">
                                                                <label for="tgl_berakhir" class="control-label">Tgl Berakhir</label>
                                                                <div class="controls with-tooltip">
                                                                    <input type="text" name="tgl_berakhir" id="tgl_berakhir" data-mask="99-99-9999" class="input-small">
                                                                    <span class="help-inline"></span>
                                                                </div>
                                                            </div>
                                                        </div>
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

    $('#tgl_berlaku, #tgl_berakhir').datepicker({
        format:'dd-mm-yyyy'
    });

    $('.komponen_tarif').change(function(){
        var trf=0;
        $('.komponen_tarif').each(function(){
            //console.log($(this).val());
            if($(this).val()=='')val=0;else val=$(this).val();
            trf=trf+parseInt(val);
        });

        $('#tarif').val(trf);
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