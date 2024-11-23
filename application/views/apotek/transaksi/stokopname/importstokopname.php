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
                    $('#btn-tutuptrans').removeAttr('disabled'); //baru
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/stokopname/importstokopname';
					if(parseInt(data.keluar)>0){
                        window.location.href='<?php echo base_url(); ?>index.php/masterapotek/persediaan/persediaanobat';
                    }
                    $('#btn-tutuptrans').removeAttr('disabled');
                    
                }
                else if(parseInt(data.status)==0) //jika gagal
                {
                    //apa yang terjadi jika gagal
                    $('#progress').hide();
                    $('#overlay1').remove();
                    $('body').removeClass('body1');
                    $('#error').show();
                    $('#error').html('<div class="alert alert-danger fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>'+data.pesan+'</div>');
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
						<form id="form" class="form-horizontal" enctype="multipart/form-data" method="POST" action="<?php echo base_url() ?>index.php/transapotek/stokopname/periksaprosesimportstokopname">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header class="top" style="">
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>IMPORT STOKOPNAME OBAT</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">                                                    
													<!--li><a target="" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/stokopname/rl1excelstokopname/<?php if(empty($nama_obat)) echo "null"; else echo $nama_obat; ?>/<?php if(empty($kd_obat )) echo "null"; else echo $kd_obat; ?>/<?php if(empty($kd_unit_apt )) echo "null"; else echo $kd_unit_apt; ?>/<?php echo $periodeakhir; ?>"> <i class="icon-print"></i> Export to Excel</a></li-->
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
													<div class="span7">
														<div class="control-group">
                                                            <label for="kd_unit_apt" class="control-label">Unit</label>
                                                            <div class="controls with-tooltip">
                                                                <select  class="input-xlarge cleared" name="kd_unit_apt" id="kd_unit_apt">
                                                                <!-- <option value="">Semua</option> -->
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
													<div class="span7">
														<div class="control-group">
															<label for="nama_unit_apt" class="control-label">File</label>
															<div class="controls with-tooltip">
																<input type="file" name="file" id="file" required class="span7 " />
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="control-group">
												<label for="text1" class="control-label">&nbsp;</label>
												<div class="controls with-tooltip">
													<button class="btn btn-primary" type="submit" name="submit" value=1><i class="icon-search"></i> Buka Data</button>
													<button class="btn " type="reset" name="reset" value="reset"><i class="icon-undo"></i> Reset</button>
													<!--a href="<-?php echo base_url() ?>index.php/transapotek/penyesuaian/exportcoba">Export</a-->
													<!--button class="btn " type="submit" name="submit1" value="excel"><i class="icon-print"></i> Export to Excel</button-->
												</div>
											</div>

                                        </div>
                                    </div>
																		
									<!--/div-->									
										
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