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
<script type="text/javascript">
	$(document).ready(function() {
		$('#nama_obat').focus();
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
                                            <h5>MONITORING STOK</h5>							
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <!--ul class="nav nav-tabs">
                                                    <li>
                                                        <a class="accordion-toggle minimize-box" data-toggle="collapse" href="#div-1">
                                                            <i class="icon-chevron-up"></i>
                                                        </a>
                                                    </li>
                                                </ul-->
                                            </div>
                                            <!-- /.toolbar -->											
                                        </header>
                                        <div id="div-1" class="accordion-body collapse in body">
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/masterapotek/monitoring">
												<div class="row-fluid">
													<div class="span12">
														<div class="span7">
															<div class="control-group">
																<label for="nama_obat" class="control-label">Nama Obat</label>
																<div class="controls with-tooltip">
																	<input type="text" id="nama_obat" name="nama_obat" value="<?php echo $nama_obat?>" class="span9 input-tooltip nama obat cleared" data-original-title="nama obat" data-placement="bottom"/>																													
																	<input type="hidden" id="kd_obat" name="kd_obat" value="<?php echo $kd_obat?>" class="span3 input-tooltip" data-original-title="kd obat" data-placement="bottom"/>
																</div>																
															</div>
														</div>														
													</div>													
												</div>                                       
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">&nbsp;</label>
                                                    <div class="controls with-tooltip">
                                                        <button class="btn btn-primary" type="submit" name="cari" value="cari"><i class="icon-search"></i> Cari</button>
                                                        <button class="btn " type="submit" name="reset" value="reset"><i class="icon-undo"></i> Reset</button>
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
                                                    <tr>
                                                        <th style="text-align:center;">Kode Obat</th>                                                        
														<th style="text-align:center;">Nama Obat</th>
														<th style="text-align:center;">Satuan </th>
														<th style="text-align:center;">Unit Apotek</th>
														<th style="text-align:center;">Jml.Stok</th>														
                                                    </tr>
                                                </thead>
                                                <tbody class="with-tooltip">
													<?php
														//$no=1;
														foreach($items as $item){														
													?>
													<tr>
														<td style="text-align:center;"><?php echo $item['kd_obat']; ?></td>
														<td><?php echo $item['nama_obat']; ?></td>
														<td style="text-align:center;" ><?php echo $item['satuan_kecil']; ?></td>
														<td style="text-align:center;"><?php echo $item['nama_unit_apt']; ?></td>
														<td style="text-align:right;"><?php echo number_format($item['jml_stok'],2,',','.') ?></td>
													</tr>
													<?php
														//	$no++;
														} //tutup foreach
													?>
                                                    
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
			
<div aria-hidden="true" aria-labelledby="helpModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="daftarobat" style="display: none;width:60%;margin-left:-400px !important;"> 
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Obat</h3>
    </div>
    <!--div class="modal-body" id="modal-body-daftarobat" style="height:340px;"-->
	<div class="modal-body" style="height:340px;">
        <div class="body" id="collapse4">
            <!--table id="dataTable1" class="table table-bordered "-->
			<table id="dataTable1" class="table table-bordered table-condensed table-hover table-striped">
                <thead>
                    <tr>						
                        <th>Kode Obat</th>
                        <th>Nama Obat</th>
						<th>Satuan</th>
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
	$('#dataTable').dataTable({ //bwt table yg tampilan hasil query
		"aaSorting": [[ 0, "desc" ]],
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
		//return false;
    }
	
	$('#nama_obat').keyup(function(e){
		/*if(e.keyCode == 13){
			$("#dataTable1").dataTable().fnDestroy();
			$('#dataTable1').dataTable( {
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource": "<?php echo base_url() ?>index.php/masterapotek/monitoring/ambilobatbynama/",
				"sServerMethod": "POST",
				"fnServerParams": function ( aoData ) {
				  aoData.push( { "name": "nama_obat", "value":""+$('#nama_obat').val()+""} );
				}
				
			} );
			$('#dataTable1').css('width','100%');
			$('#daftarobat').modal("show");
				var check = function(){
					if($('#listobat').length >0 && !$('#listobat').hasClass('ui-selected')){
						// run when condition is met
						$('#listobat').addClass('ui-selected');
					}
					else {
						setTimeout(check, 1000); // check again in a second
					}
				}
				check();     
		}*/
		if(e.keyCode == 13){

            $.ajax({
                url: '<?php echo base_url() ?>index.php/masterapotek/monitoring/ambilobatbynama/',
                async:false,
                type:'get',
                data:{query:$(this).val()},
                success:function(data){
                //typeahead.process(data)
					$('#listobat').empty();
					$.each(data,function(i,l){
						//alert(l);
						$('#listobat').append('<tr><td style="text-align:center;">'+l.kd_obat+'</td><td>'+l.nama_obat+'</td><td style="text-align:center;">'+l.satuan_kecil+'</td><td><a class="btn" onclick=\'pilihobat("'+l.kd_obat+'","'+l.nama_obat+'")\'>Pilih</a></td></tr>');
					});    
                },
                dataType:'json'                         
            }); 
            $('#daftarobat').modal("show");
		}
		var ex = document.getElementById('dataTable1');
        if ( ! $.fn.DataTable.fnIsDataTable( ex ) ) {
            $('#dataTable1').dataTable({
                "sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
				"sPaginationType": "bootstrap",
                "oLanguage": {
					"sLengthMenu": "Show _MENU_ entries"
                }
            });
            var oTable = $('#dataTable1').dataTable();
            $('#nama_obat1').keyup(function(e){ //ngikutin id di popup
				oTable.fnFilter( $(this).val() );
                if(e.keyCode == 13){
                    //alert('xx')
                    return false;
                }
            });
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
	
	/*$(document).ready(function() {
		$("#daftarobat").on("show", function () {
		  $("body").addClass("modal-open");

		}).on("hidden", function () {
			if($('#daftarobat').is(':visible')){
				$("body").addClass("modal-open");
			}else{
				$("body").removeClass("modal-open");
			}
		});

	}); */
    		
	/*$('.with-tooltip').tooltip({
		selector: ".input-tooltip"
	});*/
</script>
