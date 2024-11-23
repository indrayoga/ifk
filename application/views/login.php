<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Login</title>
        <script src="<?php echo base_url(); ?>assets/js/vendor/jquery-1.9.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/vendor/jquery-migrate-1.1.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.form.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/common.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/spin.js"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap3/css/bootstrap.min.css"/>
        <style type="text/css">
        .fixed {
            position:fixed;
            top:0px !important;
            z-index:100;
            width: 1024px;    
        }
        .body1{
            opacity: 0.4;
        }

body { 
  background: url('<?php echo base_url(); ?>assets/images/balikpapan.jpg') no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}

.panel-default {
opacity: 0.9;
margin-top:30px;
}
.form-group.last { margin-bottom:0px; }      

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
                        var urlnya="<?php echo base_url(); ?>index.php/home/periksalogin";
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
                                $('#error').html('<div class="alert alert-danger fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="glyphicon glyphicon-remove"></i></button>'+data.pesan+'</div>');
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
			
                
		       // if(data.aplikasi=='50'){
						//if(data.akses=='110'){
                            //if(data.kd_unit_apt!='U01'){
				//alert('teess');
                                window.location.href="<?php echo base_url() ?>index.php/transapotek/penjualan"
                            ///}
                            //else{
                              //  window.location.href="<?php echo base_url() ?>index.php/transapotek/aptpengajuan"
                            //}
                        //}
                    }
                });       

            });


        </script>

    </head>
    <body style="background-color:#EBEBEB !important;">
        <div id="error"></div>
        <div id="overlay"></div>
<div class="container">
    <?php
    //var_dump($_COOKIE["akses"]);
    ?>
    <div class="row">
        <div class="col-md-4 col-md-offset-7">
            <div class="panel panel-default">
                <div class="panel-heading">
                <span class="glyphicon glyphicon-lock"></span> Login Aplikasi</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" id="form" action="<?php echo base_url() ?>index.php/home/login">
                    
                                                            
                                                        
                                                        
                                                                                              
                
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="default" value=1 />
                                    Set As Default
                                </label>
                            </div>
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label for="username" class="col-sm-3 control-label">
                            Username</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">
                            Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="form-group last">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-success btn-sm">
                                Masuk</button>
                                 <button type="reset" class="btn btn-default btn-sm">
                                Reset</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="panel-footer">IFK</div>
            </div>
        </div>
    </div>
</div>

                                                    <div id="progress" style="display:none;"></div>

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap3/js/bootstrap.min.js"></script>
    </body>
<script type="text/javascript">

    $(document).ready(function(){
    $('#akses').trigger('change');

    })
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
</html>
