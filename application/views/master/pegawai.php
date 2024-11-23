<style>
#feedback { font-size: 1.4em; }
#selectable .ui-selecting { background: #FECA40; }
#selectable .ui-selected { background: #F39814; color: white; }
#selectable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
#selectable li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px; }
</style>
<script>
$(function() {
    $( "#selectable" ).selectable({
        selected: function( event, ui ) {
                    $('#btnedit').removeClass("disabled");
                    $('#btnhapus').removeClass("disabled");        

        }
    });
});

function SelectSelectableElement (selectableContainer, elementsToSelect)
{
    // add unselecting class to all elements in the styleboard canvas except the ones to select
    $(".ui-selected", selectableContainer).not(elementsToSelect).removeClass("ui-selected").addClass("ui-unselecting");
    
    // add ui-selecting class to the elements to select
    $(elementsToSelect).not(".ui-selected").addClass("ui-selected");

    // trigger the mouse stop event (this will select all .ui-selecting elements, and deselect all .ui-unselecting elements)
    selectableContainer.selectable('refresh');
    //selectableContainer.data("selectable")._mouseStop(null);
    //return false;
}
</script>
<script>
    $(document).ready(function() {
            var $lmTable = $('#dataTable').dataTable( {
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo base_url() ?>index.php/master/pegawai/ajaxdatapegawai",
                "sServerMethod": "POST"
                
            } );
            $('#btnrefresh').click(function(){
                $lmTable.fnDraw();
            });
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
                    url: "<?php echo base_url(); ?>index.php/master/pegawai/validasi",
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
                                $('#'+data.id[yangerror]).siblings('.help-block').html('<p class="text-error">'+data.pesan[yangerror]+'</p>');
                                $('#error').html('<div class="alert alert-error fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="glyphicon glyphicon-remove glyphicon-white"></i></button>Terdapat beberapa kesalahan input silahkan cek inputan anda</div>');
                            }
                            $('#error').html('<div class="alert alert-danger fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="glyphicon glyphicon-remove glyphicon-white"></i></button>'+data.pesanatas+'<br/>'+data.pesanlain+'</div>');
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
                    $('#progress').hide();
                    $('#overlay1').remove();
                    $('body').removeClass('body1');
                    $('#error').show();
                    $('#error').html('<div class="alert alert-success fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="glyphicon glyphicon-remove glyphicon-white"></i></button>'+data.pesan+'</div>');
                    $lmTable.fnDraw();
                    $('#btntambah').trigger('click');
                }
            });       
    });


Mousetrap.bind('down', function() {
    //$('#selectable').next('tr').trigger('click');    
    if($(".ui-selected").next().is('tr')){
        SelectSelectableElement($("#selectable"), $(".ui-selected").next('tr'));
    }else{
        return false;
    }
});
Mousetrap.bind('up', function() {
    //$('#selectable').next('tr').trigger('click');
    if($(".ui-selected").prev().is('tr')){
        SelectSelectableElement($("#selectable"), $(".ui-selected").prev('tr'));
    }else{
        return false;
    }
});

Mousetrap.bind('ctrl+n', function() {
    $('#btntambah').trigger('click');

    return false;
});
Mousetrap.bind('ctrl+s', function() {           
    $('#btnsimpan').trigger('click');
    return false;
});
Mousetrap.bind('enter', function() {           
    $('#btnedit').trigger('click');
    return false;
});
Mousetrap.bind('del', function() {           
    $('#btnhapus').trigger('click');
    return false;
});

</script>            <!-- #content -->
            <div id="content">
                <!-- .outer -->
                <div class="container-fluid outer">
                    <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header class="top">
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>Form</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li class=" with-tooltip"><button id="btnrefresh" class="btn btn-info input-tooltip" data-original-title=""><i class="icon-reload"></i> <strong>Refresh</strong></button></li>
                                                    <li class=" with-tooltip"><button id="btnsimpan" class="btn btn-primary input-tooltip disabled" data-original-title="ctrl+x"><i class="icon-save"></i> <strong>Simpan</strong></button></li>
                                                    <li class=" with-tooltip"><button id="btntambah" class="btn btn-primary input-tooltip" data-original-title="ctrl+"><i class="icon-plus"></i> <strong>Tambah Baru</strong></button></li>
                                                    <li class=" with-tooltip"><button id="btnedit" class="btn btn-info input-tooltip disabled" data-original-title="enter"><i class="icon-edit icon-white"></i> <strong>Edit</strong></button></li>
                                                    <li class=" with-tooltip"><button id="btnhapus" class="btn btn-danger input-tooltip disabled" data-original-title="del"><i class="icon-list icon-white"></i> <strong>Hapus</strong></button></li>
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
                                            <form class="form-horizontal" id="form" method="POST" action="<?php echo base_url() ?>index.php/master/pegawai/simpan">
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="span4">
                                                            <div class="control-group">
                                                                <label for="nama_pegawai" class="control-label wajib">Nama Pegawai</label>
                                                                <div class="controls with-tooltip">
                                                                    <input type="hidden" id="id_pegawai" name="id_pegawai" class="input-medium input-tooltip"
                                                                        value=""   data-original-title="masukkan nama pegawai" data-placement="bottom"/>
                                                                    <input type="text" id="nama_pegawai" name="nama_pegawai" class="input-medium input-tooltip"
                                                                        value=""   data-original-title="masukkan nama pegawai" data-placement="bottom"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="span3">
                                                            <div class="control-group">
                                                                <label for="jk" class="control-label">L/P</label>
                                                                <div class="controls with-tooltip">
                                                                    <select name="jk" id="jk" class="input-medium">
                                                                        <option value="L">Laki-laki</option>
                                                                        <option value="P">Perempuan</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="span3">
                                                            <div class="control-group">
                                                                <label for="no_telepon" class="control-label">No Telp</label>
                                                                <div class="controls with-tooltip">
                                                                    <input type="text" id="no_telepon" name="no_telepon" class="input-medium input-tooltip"
                                                                        value=""   data-original-title="masukkan no telp" data-placement="bottom"/>
                                                                </div>
                                                            </div>
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="span4">
                                                            <div class="control-group">
                                                                <label for="alamat" class="control-label">Alamat </label>
                                                                <div class="controls with-tooltip">
                                                                    <input type="text" id="alamat" name="alamat" class="input-large input-tooltip" 
                                                                        value=""   data-original-title="masukkan alamat" data-placement="bottom"/>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="span3">
                                                            <div class="control-group">
                                                                <label for="tanggal_lahir" class="control-label">Tanggal Lahir</label>
                                                                <div class="controls with-tooltip">
                                                                    <input type="text" id="tanggal_lahir" name="tanggal_lahir" data-mask="99-99-9999" class="input-small input-tooltip" data-mask="99-99-9999"
                                                                        value=""   data-original-title="masukkan tanggal lahir" data-placement="bottom"/>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="span3">
                                                            <div class="control-group">
                                                                <label for="tempat_lahir" class="control-label">Tempat Lahir</label>
                                                                <div class="controls with-tooltip">
                                                                    <input type="text" id="tempat_lahir" name="tempat_lahir" class="input-medium input-tooltip"
                                                                        value=""   data-original-title="masukkan tempat lahir" data-placement="bottom"/>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="span5">
                                                            <div class="control-group">
                                                                <label for="jenis_pegawai" class="control-label">Jenis Pegawai </label>
                                                                <div class="controls with-tooltip">
                                                                    <select name="jenis_pegawai" id="jenis_pegawai">
                                                                        <?php
                                                                        foreach ($datajenispegawai as $pegawai) {
                                                                            # code...
                                                                        ?>
                                                                        <option value="<?php echo $pegawai['id_jenis_pegawai'] ?>"><?php echo $pegawai['jenis_pegawai'] ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="span3">
                                                            <div class="control-group">
                                                                <label for="nip_pegawai" class="control-label">NIP Pegawai</label>
                                                                <div class="controls with-tooltip">
                                                                    <input type="text" id="nip_pegawai" name="nip_pegawai" class="input-medium input-tooltip"
                                                                        value=""   data-original-title="masukkan nip" data-placement="bottom"/>
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
                                                        <div id="progress" style="display:none;"></div>                                        

                    <div class="row-fluid">
                        <!-- .inner -->
                        <div class="span12 inner">
                      <!--BEGIN INPUT TEXT FIELDS-->
                            <!--END TEXT INPUT FIELD-->                            
                            <!--Begin Datatables-->
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header>
                                            <div class="icons"><i class="icon-move"></i></div>
                                            <h5>Daftar Pegawai</h5>
                                        </header>
                                        <div id="collapse4" class="body">
                                            <table id="dataTable" class="table table-bordered table-condensed ">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Pegawai</th>
                                                        <th>L/P</th>
                                                        <th>Alamat</th>
                                                        <th>No Telp</th>
                                                        <th>Tempat lahir</th>
                                                        <th>Tanggal lahir</th>
                                                        <th>Jenis pegawai</th>
                                                        <th>NIP pegawai</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="selectable">

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
            $('#btntambah').click(function(){
                $('#id_pegawai').val('');
                $('#nama_pegawai').val('');
                $('#no_telepon').val('');
                $('#alamat').val('');
                $('#tempat_lahir').val('');
                $('#tanggal_lahir').val('');
                $('#nip_pegawai').val('');
                $('#nama_pegawai').focus();
                $('#btnsimpan').removeClass('disabled');
                $('#btnedit').addClass('disabled');
                $('#btnhapus').addClass('disabled');
                $('#selectable tr').removeClass("ui-selected");
                $('.scrollup').trigger('click');
            });

            $('#btnedit').click(function(){
                if(!$('#selectable tr').hasClass('ui-selected')){
                    return false;
                }

                var id=$('#selectable .ui-selected td input.idpegawai').val();

               $.ajax({
                    url: "<?php echo base_url(); ?>index.php/master/pegawai/ambildatapegawai/"+id,
                    type:"POST",
                    async: false,
                    success: function(data){
                        $('#id_pegawai').val(data.id_pegawai);                        
                        $('#nama_pegawai').val(data.nama_pegawai);                        
                        $('#no_telepon').val(data.no_telepon);                        
                        $('#jk').val(data.jk);                        
                        $('#alamat').val(data.alamat);                        
                        $('#tanggal_lahir').val(data.tanggal_lahir);                        
                        $('#tempat_lahir').val(data.tempat_lahir);                        
                        $('#jenis_pegawai').val(data.jenis_pegawai);    
                        $('#nip_pegawai').val(data.nip_pegawai);    
                         $('#btnsimpan').removeClass('disabled');                    
                    },
                    dataType: 'json'
                });  
                $('.scrollup').trigger('click');
                $('#nama_pegawai').focus();
            });

            $('#btnhapus').click(function(){
                if(!$('#selectable tr').hasClass('ui-selected')){
                    return false;
                }

                var id=$('#selectable .ui-selected td input.idpegawai').val();
                var alert=window.confirm('Anda Yakin Menghapus data tersebut?');
                if(alert){
                   $.ajax({
                        url: "<?php echo base_url(); ?>index.php/master/pegawai/hapus/"+id,
                        type:"POST",
                        async: false,
                        success: function(data){
                            $('#btnrefresh').trigger('click');
                        },
                        dataType: 'json'
                    });                      
                }

            });

    $('#btnsimpan').click(function(){
        $('#form').submit();
    });

    $('#tanggal_lahir').datepicker({
        format: 'dd-mm-yyyy'
    });

    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
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