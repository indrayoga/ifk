<script src="<?php echo base_url(); ?>assets/js/mousetrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/mousetrap-global-bind.min.js"></script> 
<script type="text/javascript">
	Mousetrap.bindGlobal('ctrl+r', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptreturgudang/tambahreturgudang'; return false;});
	Mousetrap.bindGlobal('f10', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptreturgudang'; return false;});
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
                                            <h5>PENCARIAN DATA RETUR</h5>							
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a href="<?php echo base_url() ?>index.php/transapotek/aptreturgudang/tambahreturgudang"> <i class="icon-plus"></i> Tambah Retur / (Ctrl + R)</a></li>
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
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/aptreturgudang">
												<div class="row-fluid">
													<div class="span12">
														<div class="span4">
															<div class="control-group">
																<label for="no_retur" class="control-label">No Distribusi</label>
																<div class="controls with-tooltip">
																	<input type="text" id="no_retur" name="no_retur" value="<?php echo $no_retur; ?>" class="input-medium input-tooltip" data-original-title="masukkan no distribusi yang ingin dicari" data-placement="bottom"/>												
																</div>
															</div>
														</div>
														<!--div class="span6">
															<div class="control-group">
                                                                <label for="kd_unit_apt" class="control-label">Unit Apotek Tujuan</label>
                                                                <div class="controls with-tooltip">
                                                                    <select id="kd_unit_apt" name="kd_unit_apt" class="input-medium">
                                                                        <option value="">Pilih Unit Apotek</option>
                                                                        <-?php
                                                                        foreach ($unitapotek as $unit) {
                                                                            # code...
                                                                        ?>
                                                                        <option value="<-?php echo $unit['kd_unit_apt'] ?>"><-?php echo $unit['nama_unit_apt'] ?></option>
                                                                        <-?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
															</div>
														</div-->
													</div>													
												</div>                                                
												<div class="control-group">
													<label for="periodeawal" class="control-label">Periode</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" id="periodeawal" name="periodeawal" class="input-small input-tooltip" data-mask="99-99-9999"
                                                               value="<?php echo $periodeawal?>" data-original-title="masukkan tanggal awal" data-placement="bottom"/>
                                                               -
                                                        <input type="text" id="periodeakhir" name="periodeakhir" class="input-small input-tooltip" data-mask="99-99-9999"
                                                               value="<?php echo $periodeakhir?>" data-original-title="masukkan tanggal akhir" data-placement="bottom"/>
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
                                            <h5>DAFTAR RETUR OBAT / ALKES KE UNIT GUDANG FARMASI</h5>
                                        </header>
                                        <div id="collapse4" class="body">
                                            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                                <thead>
                                                    <tr>
														<th style="text-align:center;">No</th>
                                                        <th style="text-align:center;">No. Retur</th>                                                        
														<th style="text-align:center;">Tgl. Retur</th>
														<th style="text-align:center;">Unit Tujuan</th>
														<th style="text-align:center;">Pilihan</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="with-tooltip">
													<?php
														$no=1;
														foreach($items as $item){
													?>
													<tr class="showmodal input-tooltip" id="<?php echo $item['no_retur']; ?>" data-original-title="double click untuk detil">
														<td style="text-align:center;"><?php echo $no; ?></td>
														<td style="text-align:center;"><?php echo $item['no_retur']; ?></td>
														<td style="text-align:center;"><?php echo $item['tgl_retur']; ?></td>
														<td><?php echo $item['unit_tujuan']; ?></td>
														<td style="text-align:center;width:200px;">
                                                            <a href="<?php echo base_url() ?>index.php/transapotek/aptreturgudang/ubahreturgudang/<?php echo $item['no_retur'] ?>" class="btn"><i class="icon-edit"></i> Edit</a>
                                                            <?php if($item['posting']){
                                                            ?>
                                                            &nbsp;
                                                            <?php
                                                            }else{
                                                            ?>
                                                            <a href="#" onClick="xar_confirm('<?php echo base_url() ?>index.php/transapotek/aptreturgudang/hapusreturgudang/<?php echo $item['no_retur'] ?>','Apakah Anda ingin menghapus data ini?')" class="btn btn-danger"><i class="icon-remove"></i> Hapus</a>
                                                            <?php
                                                            } ?>
																		
                                                        </td>
													</tr>
													<?php
															$no++;
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
			
			
			<div aria-hidden="true" aria-labelledby="approveModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="detilmodal" style="display: none;width:87%;margin-left:-0;left:90px;top:5px;">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                   <!--
                    <div class="toolbar pull-right" style="height:auto;">
                        <ul class="nav nav-tabs">
                            <li><button class="btn" href="<?php echo base_url() ?>index.php/penerimaan/tambahpenerimaan"> <i class="icon-plus"></i> Tambah</button></li>
                        </ul>
                    </div>   
                    -->                 
                    <h3 id="helpModalLabel"><i class="icon-external-link"></i> Detil Retur</h3>
                </div>
                <div class="modal-body" style="">
                    <div class="body" id="collapse4">
                        <table class="table table-condensed responsive">
                            <tr>
                                <td>No Retur</td>
                                <td id="tdretur">: </td>
								<td>Unit Asal</td>
                                <td id="tdunitasal">: </td>								
                            </tr>
                            <tr>
                                <td>Tgl. Retur</td>
                                <td id="tdtanggal">: </td>                                
								<td>Unit Tujuan</td>
                                <td id="tdunittujuan">: </td>								
                            </tr> 
							<tr>
								<td>Shift</td>
                                <td id="tdshift">: </td>
							</tr>
                        </table>
                        <table class="table table-bordered responsive">
                            <thead>
                                <tr>
                                    <th class="header">&nbsp;</th>
                                    <th class="header" style="text-align:center;">Kode Obat</th>
                                    <th class="header" style="text-align:center;">Nama Obat</th>
                                    <th class="header" style="text-align:center;">Satuan</th>
                                    <th class="header" style="text-align:center;">Tgl. Expire</th>
									<th class="header" style="text-align:center;">Qty</th>									
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
                    <a class="btn btn-success" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="#" id="detilcetak"> <i class="icon-print"></i> Cetak</a>
                    <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning">Close</button>
                </div>
            </div>



<script type="text/javascript">
	$('#dataTable').dataTable({
		"aaSorting": [[ 0, "desc" ]],
		"sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "Show _MENU_ entries"
		}
	});
	
	$('.showmodal').dblclick(function(){
        $.ajax({
            url: '<?php echo base_url() ?>index.php/transapotek/aptreturgudang/ambilitem/',
            async:false,
            type:'get',
            data:{query:$(this).attr('id')},
            success:function(data){
                //typeahead.process(data)
					//alert(data.no_retur);
                    $('#tdretur').html(': '+data.no_retur);
                    $('#tdunitasal').html(': '+data.unit_asal);
                    $('#tdtanggal').html(': '+data.tgl_retur);					
                    $('#tdshift').html(': '+data.shift);
                    $('#tdunittujuan').html(': '+data.unit_tujuan);                    
                    $('#detilcetak').attr('href','<?php echo base_url() ?>third-party/fpdf/buktireturgudang.php?no_retur='+data.no_retur);
					$('#detilcetak').attr('target','_blank');
                
            },
            dataType:'json'                         
        }); 

        $.ajax({
            url: '<?php echo base_url() ?>index.php/transapotek/aptreturgudang/ambilitems/',
            async:false,
            type:'get',
            data:{query:$(this).attr('id')},
            success:function(data){
                //typeahead.process(data)
                $('#bodyinput').empty();
                var no=1;
                //var totalall=0;
                $.each(data,function(i,l){
                    //alert(l);
                  //  totalall=totalall+parseInt(l.total);
                    $('#bodyinput').append('<tr><td style="text-align:center;">'+no+'</td><td>'+l.kdobat+'</td><td>'+l.nama_obat+'</td><td style="text-align:center;">'+l.satuan_kecil+'</td><td style="text-align:center;">'+l.tglexpire+'&nbsp;</td><td style="text-align:center;">'+l.qty+'</td></tr>');
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
			
	$('.with-tooltip').tooltip({
		selector: ".input-tooltip"
	});
</script>
