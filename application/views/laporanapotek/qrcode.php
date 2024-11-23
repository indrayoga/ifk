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
body.modal-open {
    overflow: hidden;
}

</style>
<style>
#feedback { font-size: 1.4em; }
#listobat .ui-selecting, #listobat .ui-selecting { background: #FECA40; }
#listobat .ui-selected, #listobat .ui-selected { background: #F39814; color: white; }
#listobat, #listobat { list-style-type: none; margin: 0; padding: 0; width: 60%; }
#listobat li, #listobat li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px; }
</style>
<script>
$(function() {
    $( "#listobat" ).selectable({});
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
<script src="<?php echo base_url(); ?>assets/js/mousetrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/mousetrap-global-bind.min.js"></script> 
<script type="text/javascript">
	Mousetrap.bind(['down','right'], function() {

        if($('#daftarobat').is(':visible')){    
            if($("#listobat .ui-selected").next().is('tr')){
				$('#modal-body-daftarobat').scrollTop($('#modal-body-daftarobat').scrollTop()+45);
				SelectSelectableElement($("#listobat"), $(".ui-selected").next('tr'));
            }else{
                return false;
            }
        }
    });
	
	Mousetrap.bind(['up','left'], function() {
        if($('#daftarobat').is(':visible')){ 
            if($("#listobat .ui-selected").prev().is('tr')){
				$('#modal-body-daftarobat').scrollTop($('#modal-body-daftarobat').scrollTop()-45);
				SelectSelectableElement($("#listobat"), $(".ui-selected").prev('tr'));
            }else{
                return false;
            }
        }
    });
	
    Mousetrap.bind('enter', function(e) { 

        if($('#daftarobat').is(':visible')){
            $('.ui-selected').find('.btn').trigger('click');
            return false;
        }
        return false;
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
                                            <h5>QR CODE</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <!--li><a target="_blank" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<-?php echo base_url() ?>third-party/fpdf/kartustok.php?kd_obat=<-?php echo $kd_obat ?>&kd_unit_apt=<-?php echo $kd_unit_apt; ?>&bulan=<-?php echo $bulan; ?>&tahun=<-?php echo $tahun; ?>"> <i class="icon-print"></i> PDF</a></li-->
                                                    <!--<li><a target="" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/laporanapt/rl1excelkartustok/<?php echo $kd_obat ?>/<?php echo $kd_unit_apt; ?>/<?php echo $bulan; ?>/<?php echo $tahun; ?>"> <i class="icon-print"></i> Export to Excel</a></li>-->
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
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/Qrcode_Controller/laporan_qrcode">
                                            	 <div class="control-group">
                                                    <label for="nama_obat" class="control-label">Sumber Dana</label>
                                                    <div class="controls with-tooltip">
														<select  class="input-xlarge cleared" name="kd_unit_apt" id="kd_unit_apt">
																			<option value="">Pilih Sumber Dana</option>
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
                                                <div class="control-group">
                                                    <label for="nama_obat" class="control-label">Nama Obat</label>
                                                    <div class="controls with-tooltip">
														<input type="text" id="nama_obat" autocomplete="off" name="nama_obat" value="<?php echo $nama_obat?>" class="span5 input-tooltip" data-original-title="nama obat" data-placement="bottom"/>
														<input type="hidden" id="kd_obat" name="kd_obat" value="<?php echo $kd_obat?>" class="span3 input-tooltip" data-original-title="kd obat" data-placement="bottom"/>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">&nbsp;</label>
                                                    <div class="controls with-tooltip">
                                                        <button class="btn btn-primary" type="submit"><i class="icon-search"></i> Cari</button>
                                                        <button class="btn " type="reset" name="reset" value="reset"><i class="icon-undo"></i> Reset</button>														
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
                                            <h5></h5>
                                        </header>
                                        <div id="collapse4" class="body">
                                            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                                <thead>
                                                    <tr style="font-size:95% !important;">

                                                        <th style="text-align:center;">Sumber Dana</th>
                                                        <th style="text-align:center;">Kode Obat</th>
                                                        <th style="text-align:center;">Nama Obat</th>
                                                        <th style="text-align:center;">Tgl. Expire</th>
                                                        <th style="text-align:center;">Batch</th>
                                                        <th style="text-align:center;">Format QR Code</th>
                                                        <th style="text-align:center;">Aksi</th>
														<!--th>Saldo</th-->
														<!--th>Jumlah</th-->														
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($items as $key ) { 
                                                        $batch=$key['batch'];
                                                        
                                                        if(empty($batch)){
                                                            $batch=$key['kd_obat'];
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td><?=$key['nama_unit_apt']?></td>
                                                            <td><?=$key['kd_obat']?></td>
                                                            <td><?=$key['nama_obat']?></td>
                                                            <td><?=$key['te']?></td>
                                                            <td><?=$key['batch']?></td>
                                                            <td><?=$key['qrcode']?></td>
                                                            <td><a target="_newtab" href="<?php echo base_url(); ?>index.php/transapotek/Qrcode_Controller/setQRCode_single/<?=$key['kd_obat']?>/<?=$batch?>/<?=$key['te']?>/<?=$key['kd_unit_apt']?>">Cek QR Code</a></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                                <tfoot>
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
	$('.with-tooltip').tooltip({
		selector: ".input-tooltip"
	});
	
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
	
	/*var opts = {
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
    var spinner = new Spinner(opts).spin(target);*/
	
	$(document).ready(function() {
		$("#daftarobat").on("show", function () {
		  $("body").addClass("modal-open");

		}).on("hidden", function () {
			if($('#daftarobat').is(':visible')){
				$("body").addClass("modal-open");
			}else{
				$("body").removeClass("modal-open");
			}
		});

	}); 
	
</script>