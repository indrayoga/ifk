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
                            <form class="form-horizontal" id="form" method="post" action="<?php echo base_url() ?>index.php/setting/simpansaldoawal">                            
                            <!--BEGIN INPUT TEXT FIELDS-->
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="box">
                                            <header class="top" style="">
                                                <div class="icons"><i class="icon-edit"></i></div>
                                                <h5>SALDO AWAL</h5>
                                                <!-- .toolbar -->
                                                <div class="toolbar" style="height:auto;">
                                                    <ul class="nav nav-tabs">
                                                        <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/fakturap/"> <i class="icon-list"></i> Daftar</a></li>
                                                        <li><button class="btn" id="simpan" type="submit" name="submit" value="simpan"> <i class="icon-save"></i> Simpan</button></li>
                                                        <li>
                                                            <a class="accordion-toggle minimize-box" data-toggle="collapse" href="#div-1">
                                                                <i class="icon-chevron-up"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- /.toolbar -->
                                            </header>
                                            <div id="progress" style="display:none;"></div>                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="box">
                                            <div class="body collapse in" id="defaultTable">
                                                <div class="span12">
                                                    Tahun
                                                    <select name="tahun" id="tahun" class="input-small">
                                                        <option value="<?php echo date('Y')-3; ?>" <?php if($tahun==date('Y')-3) echo "selected=selected"; ?>><?php echo date('Y')-3; ?></option>
                                                        <option value="<?php echo date('Y')-2; ?>" <?php if($tahun==date('Y')-2) echo "selected=selected"; ?>><?php echo date('Y')-2; ?></option>
                                                        <option value="<?php echo date('Y')-1; ?>" <?php if($tahun==date('Y')-1) echo "selected=selected"; ?>><?php echo date('Y')-1; ?></option>
                                                        <option value="<?php echo date('Y'); ?>" <?php if($tahun==date('Y')) echo "selected=selected"; ?>><?php echo date('Y'); ?></option>
                                                        <option value="<?php echo date('Y')+1; ?>" <?php if($tahun==date('Y')+1) echo "selected=selected"; ?>><?php echo date('Y')+1; ?></option>
                                                        <option value="<?php echo date('Y')+2; ?>" <?php if($tahun==date('Y')+2) echo "selected=selected"; ?>><?php echo date('Y')+2; ?></option>
                                                        <option value="<?php echo date('Y')+3; ?>" <?php if($tahun==date('Y')+3) echo "selected=selected"; ?>><?php echo date('Y')+3; ?></option>
                                                        <option value="<?php echo date('Y')+4; ?>" <?php if($tahun==date('Y')+4) echo "selected=selected"; ?>><?php echo date('Y')+4; ?></option>
                                                    </select>
                                                </div>
                                                <table class="table responsive">
                                                    <thead>
                                                        <tr>
                                                            <th class="header">Akun</th>
                                                            <th class="header">Nama Akun</th>
                                                            <th class="header" style="text-align:right;width:120px;">Debit (Rp)</th>
                                                            <th class="header" style="text-align:right;width:120px;">Kredit (Rp)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="bodyinput">
                                                        <?php
                                                        //if(isset($itemsdetiltransaksi)){
                                                        foreach ($dataakun as $akun) {
                                                            # code...
                                                            $saldoawal=$this->msetting->ambilItemData('acc_value','account="'.$akun['account'].'" and years="'.$tahun.'"');
                                                           // debugvar($saldoawal);
                                                           ?>
                                                            <tr>
                                                                <td><input type="hidden" name="akun[]" value="<?php echo $akun['account'] ?>"><?php echo $akun['account'] ?></td>
                                                                <td><?php echo $akun['name'] ?></td>
                                                                <td style="text-align:right;"><input style="text-align:right;" type="text" name="debit[]" value="<?php echo $saldoawal['DB0'] ?>" class="input-small"></td>
                                                                <td style="text-align:right;"><input style="text-align:right;" type="text" name="kredit[]" value="<?php echo $saldoawal['CR0'] ?>" class="input-small"></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                        //}
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
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


<script type="text/javascript">
	$('#tahun').change(function(){
		window.location.href="<?php echo base_url() ?>index.php/setting/saldoawal/"+$(this).val();
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

    $('input').live('keydown', function(e) {
        if(e.keyCode == 13){
            return false;                                    
        }
    });


    $(window).bind('scroll', function() {
        //console.log($(window).scrollTop());
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
