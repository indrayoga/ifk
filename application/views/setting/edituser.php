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
                var urlnya="<?php echo base_url(); ?>index.php/setting/periksauser1";
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
                    window.location.href="<?php echo base_url() ?>index.php/setting/user";    
                
                }
                else if(parseInt(data.status)==0) //jika gagal
                {
                    //apa yang terjadi jika gagal
                    $('#progress').hide();
                    $('#overlay1').remove();
                    $('body').removeClass('body1');
                    $('#error').show();
                    $('#error').html('<div class="alert alert-success fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>'+data.pesan+'</div>');
                    window.location.href="<?php echo base_url() ?>index.php/setting/user";    
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
                      <!--BEGIN INPUT TEXT FIELDS-->
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header>
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>Update User</h5>
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
                                            <!-- /.toolbar -->
                                        </header>
                                        <div id="div-1" class="accordion-body collapse in body">
                                            <form class="form-horizontal" id="form" method="post" action="<?php echo base_url() ?>index.php/setting/updateuser">
                                                
                                               
                                                
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="control-group">
                                                            <label for="username" class="control-label">Username</label>
                                                            <div class="controls with-tooltip">
                                                                <input type="hidden" name="id_user" value="<?php if(isset($item['id_user'])) echo $item['id_user']; ?>" id="" class="input-medium">
                                                                <input type="text" name="username"  value="<?php if(isset($item['username'])) echo $item['username']; ?>" id="username" class="input-medium">
                                                                <span class="help-inline"></span>
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                                <div class="row-fluid">
                                                    <div style="width: 45%; float: left;">
                                                        <div class="input-append">
                                                            <input id="box1Filter" type="text" placeholder="Filter">
                                                            <button id="box1Clear" class="btn btn-warning" type="button">x</button>
                                                        </div>
                                                        <select id="box1View" multiple="multiple" name="akses[]" style="width: 100%;" size="16">
                                                            <?php
                                                            foreach ($dataakses as $akses) {
                                                                # code...
                                                                //if($this->msetting->isItemMapping($unit,$pelayanan['kd_pelayanan']))continue;
                                                            ?>
                                                            <option value="<?php echo $akses['id_akses'] ?>"><?php echo $akses['akses'] ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <br/>

                                                        <div class="alert alert-block">
                                                            <span id="box1Counter" class="countLabel"></span>
                                                            <select id="box1Storage">

                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div style="width: 10%;float: left; text-align: center; padding-top: 6%;">
                                                        <div class="btn-group btn-group-vertical" style="white-space: normal;">
                                                            <button id="to2" type="button" class="btn btn-primary">
                                                                <i class="icon-chevron-right"></i>
                                                            </button>
                                                            <button id="allTo2" type="button" class="btn btn-primary">
                                                                <i class="icon-forward"></i>
                                                            </button>
                                                            <button id="allTo1" type="button" class="btn btn-danger">
                                                                <i class="icon-backward"></i>
                                                            </button>
                                                            <button id="to1" type="button" class="btn btn-danger">
                                                                <i class=" icon-chevron-left icon-white"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div style="width: 45%;float: left;">
                                                        <div class="input-append">
                                                            <input id="box2Filter" type="text" placeholder="Filter">
                                                            <button id="box2Clear" class="btn btn-warning" type="button">x</button>
                                                        </div>
                                                        <select id="box2View" name="aksesuser[]" multiple="multiple" style="width: 100%;" size="16">
                                                            <?php
                                                            if(!empty($unit)){
                                                                $query=$this->db->query('select * from akses_unit a join akses b on a.id_akses=b.id_akses where id_user="'.$id_user.'" and b.aplikasi="'.$app.'" and a.kd_unit_kerja="'.$unit.'" ');
                                                            }else{
                                                                $query=$this->db->query('select * from user_akses a join akses b on a.id_akses=b.id_akses where id_user="'.$id_user.'" and b.aplikasi="'.$app.'" ');
                                                            }
                                                            $dataaksesuser=$query->result_array();
                                                            foreach ($dataaksesuser as $aksesuser) {
                                                                # code...
                                                                //if($this->msetting->isItemMapping($unit,$pelayanan['kd_pelayanan']))continue;
                                                            ?>
                                                            <option value="<?php echo $aksesuser['id_akses'] ?>"><?php echo $aksesuser['akses'] ?></option>
                                                            <?php
                                                            }
                                                            ?>                                                            
                                                        </select><br/>

                                                        <div class="alert alert-block">
                                                            <span id="box2Counter" class="countLabel"></span>
                                                            <select id="box2Storage"> </select>
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
    $.configureBoxes(
      );

    $('#tanggal').datepicker({
        format: 'dd-mm-yyyy'
    });


    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
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

</script>