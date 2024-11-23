
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
                                            <h5>Laporan Penjualan Obat</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a target="" class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/laporanapt/rl1excel/<?php echo $periodeawal ?>/<?php echo $periodeakhir; ?>/<?php echo $kd_unit_apt; ?>/<?php echo $kd_obat; ?>"> <i class="icon-print"></i> Export to Excel</a></li>
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
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/laporanapt/penjualanobat">
                                                <div class="row-fluid">
													<div class="span12">
														<div class="span5">
															<div class="control-group">
																<label for="periodeawal" class="control-label">Tgl. Penjualan</label>
																<div class="controls with-tooltip">
																	<input type="text" id="periodeawal" name="periodeawal" class="input-small input-tooltip" data-mask="99-99-9999"
																		   data-original-title="masukkan tanggal awal" value="<?php echo $periodeawal?>" data-placement="bottom"/>
																		   s/d
																	<input type="text" id="periodeakhir" name="periodeakhir" class="input-small input-tooltip" data-mask="99-99-9999"
																		   data-original-title="masukkan tanggal akhir" value="<?php echo $periodeakhir?>" data-placement="bottom"/>
																</div>
															</div> 
														</div>
													</div>
												</div>
												<div class="row-fluid">													
													<div class="span9">
														<div class="control-group">
															<label for="kd_unit_apt" class="control-label">Unit Apotek</label>
															<div class="controls with-tooltip">
																<select id="kd_unit_apt" name="kd_unit_apt" class="input-xlarge">
																	<option value="">Pilih Semua Unit</option>
																	<?php
																	foreach ($unitapotek as $unit) {
																		# code...
																		if ($unit['kd_unit_apt']== $kd_unit_apt){
																			$cek = "selected=selected";
																		}
																		else {
																			$cek = "";
																		}
																	?>
																	<option value="<?php echo $unit['kd_unit_apt'] ?>" <?php echo $cek; ?>><?php echo $unit['nama_unit_apt'] ?></option>
																	<?php
																	}
																	?>
																</select>																
															</div>
														</div>
													</div>
												</div>
												<div class="row-fluid">
													<div class="span9">
														<div class="control-group">
															<label for="kd_obat" class="control-label">Obat</label>
															<div class="controls with-tooltip">
																<input type="text" id="kd_obat" name="kd_obat" value="<?php echo $kd_obat?>" class="span2 input-tooltip" data-original-title="pemilihan obat berdasarkan kode obat" data-placement="bottom"/>
																<input type="text" id="nama_obat" name="nama_obat" value="<?php echo $nama_obat?>" class="span6 input-tooltip" data-original-title="pemilihan obat berdasarkan nama obat" data-placement="bottom"/>																		
															</div>
														</div>
													</div>
												</div>
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">&nbsp;</label>
                                                    <div class="controls with-tooltip">
                                                        <button class="btn btn-primary" type="submit"><i class="icon-search"></i> Cari</button>
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
                                                    <tr style="font-size:80% !important;" >
                                                        <th style="text-align:center;">Kode Obat</th>
                                                        <th style="text-align:center;">Nama Obat</th>
														<th style="text-align:center;">Jml.Penjualan</th>
                                                        <th style="text-align:center;">Sisa Stok Gudang</th> 
                                                    </tr>
                                                </thead>
                                                <tbody class="with-tooltip">
                                                    <?php
                                                    //$no=1;
                                                    foreach ($items as $item) {
                                                    ?>
                                                        <tr class="showmodal input-tooltip" id="<?php echo $item['kd_obat1']; ?>" unit="<?php echo $item['kd_unit_apt']; ?>" data-original-title="double click untuk detil">
                                                            <td style="text-align:center;"><?php echo $item['kd_obat1'] ?></td>
															<td><?php echo $item['nama_obat'] ?></td>
                                                            <td style="text-align:right;"><?php echo number_format($item['qty']) ?></td>
															<td style="text-align:right;"><?php echo number_format($item['jml_stok']) ?></td>
                                                        </tr>                                                    
                                                    <?php
                                                    //$no++;
                                                    }
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
    <div class="modal-body" style="height:340px;">
        <div class="body" id="collapse4">
            <table id="dataTable1" class="table table-bordered table-condensed table-hover table-striped">
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

<div aria-hidden="true" aria-labelledby="approveModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="detilmodal" style="display: none;width:67%;margin-left:-0;left:230px;top:35px;">
	<div class="modal-header">
		<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	    <h3 id="helpModalLabel"><i class="icon-external-link"></i> Detil Penjualan</h3>
	</div>
	<div class="modal-body" style="">
		<div class="body" id="collapse4">
			<table class="table table-condensed responsive">
				<tr>
					<td>Kode Obat</td>
					<td id="tdkodeobat">: </td>  														
				</tr>
				<tr>
					<td>Nama Obat</td>
					<td id="tdnamaobat">: </td> 								
				</tr>
				<tr>
					<td>Periode</td>
					<td id="tdawal">: </td> 								
				</tr>
			</table>
			<table class="table table-bordered responsive">
				<thead>
					<tr>
						<th class="header">&nbsp;</th>
						<th class="header" style="text-align:center;">Tgl.Penjualan</th>
						<th class="header" style="text-align:center;">No.Penjualan</th>
						<th class="header" style="text-align:center;">Unit Apotek</th>
						<th class="header" style="text-align:center;">Jml.Penjualan</th>						
					</tr>
				</thead>
				<tbody id="bodyinput">
				</tbody>
				<tfoot>
			   </tfoot>
			</table>

		</div>
	</div>
	<div class="modal-footer">
		<button aria-hidden="true" data-dismiss="modal" class="btn btn-warning">Close</button>
	</div>
</div>


<script type="text/javascript">
	/*$('#dataTable').dataTable({
		"aaSorting": [[ 1, "asc" ]],
		"sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "Show _MENU_ entries"
		}
	});*/
	
	$('.with-tooltip').tooltip({
		selector: ".input-tooltip"
	});
	
	$('.showmodal').dblclick(function(){
		$.ajax({
            url: '<?php echo base_url() ?>index.php/transapotek/laporanapt/ambilitem/',
            async:false,
            type:'get',
            data:{query:$(this).attr('id')},
            success:function(data){
                //typeahead.process(data)
                    $('#tdkodeobat').html('');
					$('#tdnamaobat').html('');
					var awal=$('#periodeawal').val();
					var akhir=$('#periodeakhir').val();
					$('#tdawal').html('');
                $.each(data,function(i,l){
                    $('#tdkodeobat').html(': '+data.kd_obat);					
					$('#tdnamaobat').html(': '+data.nama_obat);					
					$('#tdawal').html(': '+awal+' s/d '+akhir);		
                });
                
            },
            dataType:'json'                         
        });
		
        $.ajax({
            url: '<?php echo base_url() ?>index.php/transapotek/laporanapt/ambilitems/',
            async:false,
            type:'get',
            data:{awal:$('#periodeawal').val(),akhir:$('#periodeakhir').val(),unit:$('#kd_unit_apt').val(),query:$(this).attr('id')},
            success:function(data){
                //typeahead.process(data)
                $('#bodyinput').empty();
                var no=1;
                $.each(data,function(i,l){
                    //alert(l);
                    //totalall=totalall+parseInt(l.total);
					$('#bodyinput').append('<tr><td style="text-align:center;">'+no+'</td><td style="text-align:center;">'+l.tgl_penjualan+'</td><td style="text-align:center;">'+l.no_penjualan+'</td><td style="text-align:center;">'+l.nama_unit_apt+'</td><td style="text-align:right;">'+addCommas(l.qty)+'</td></tr>');
                    no++;
                });
                //$('#tdtotal').html(addCommas(totalall));
            },
            dataType:'json'                         
        });
        $('#detilmodal').modal("show");
    });
	
	$('#periodeawal').datepicker({
		format: 'dd-mm-yyyy'
	});
			
	$('#periodeakhir').datepicker({
		format: 'dd-mm-yyyy'
	});
	
	function pilihobat(kd_obat,nama_obat) {
		$('#kd_obat').val(kd_obat);
        $('#nama_obat').val(nama_obat);
		$('#daftarobat').modal("hide");
        $('#bulan').focus();
    }
	
	$('#nama_obat').keyup(function(e){
		if(e.keyCode == 13){

            $.ajax({
                url: '<?php echo base_url() ?>index.php/transapotek/laporanapt/ambilobatbynama/',
                async:false,
                type:'get',
                data:{query:$(this).val()},
                success:function(data){
                //typeahead.process(data)
					$('#listobat').empty();
					$.each(data,function(i,l){
						//alert(l);
						$('#listobat').append('<tr><td>'+l.kd_obat+'</td><td>'+l.nama_obat+'</td><td><a class="btn" onclick=\'pilihobat("'+l.kd_obat+'","'+l.nama_obat+'")\'>Pilih</a></td></tr>');
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
	
	$('#kd_obat').keyup(function(e){
		if(e.keyCode == 13){

            $.ajax({
                url: '<?php echo base_url() ?>index.php/transapotek/laporanapt/ambilobatbykode/',
                async:false,
                type:'get',
                data:{query:$(this).val()},
                success:function(data){
                //typeahead.process(data)
					$('#listobat').empty();
					$.each(data,function(i,l){
						//alert(l);
						$('#listobat').append('<tr><td>'+l.kd_obat+'</td><td>'+l.nama_obat+'</td><td><a class="btn" onclick=\'pilihobat("'+l.kd_obat+'","'+l.nama_obat+'")\'>Pilih</a></td></tr>');
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
	
</script>