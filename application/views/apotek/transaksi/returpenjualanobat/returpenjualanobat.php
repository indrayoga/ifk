<script src="<?php echo base_url(); ?>assets/js/mousetrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/mousetrap-global-bind.min.js"></script> 
<script type="text/javascript">
	Mousetrap.bindGlobal('ctrl+r', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/returpenjualanobat/tambahretur'; return false;});
	Mousetrap.bindGlobal('f9', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/returpenjualanobat'; return false;});
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
                                            <h5>PENCARIAN DATA RETUR PENJUALAN</h5>							
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a href="<?php echo base_url() ?>index.php/transapotek/returpenjualanobat/tambahretur"> <i class="icon-plus"></i> Tambah Retur / (Ctrl + R)</a></li>
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
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/returpenjualanobat">
												<div class="row-fluid">
													<div class="span12">
														<div class="span4">
															<div class="control-group">
																<label for="no_retur" class="control-label">No Retur</label>
																<div class="controls with-tooltip">
																	<input type="text" id="no_retur" name="no_retur" value="<?php echo $no_retur; ?>" class="input-medium input-tooltip" data-original-title="masukkan no retur yang ingin dicari" data-placement="bottom"/>												
																</div>
															</div>
														</div>														
													</div>
												</div>                                                
												<div class="control-group">
													<label for="periodeawal" class="control-label">Periode</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" id="periodeawal" name="periodeawal" class="input-small input-tooltip" data-mask="99-99-9999"
                                                               value="<?php echo $periodeawal ?>" data-original-title="masukkan tanggal awal" data-placement="bottom"/>
                                                               -
                                                        <input type="text" id="periodeakhir" name="periodeakhir" class="input-small input-tooltip" data-mask="99-99-9999"
                                                               value="<?php echo $periodeakhir ?>" data-original-title="masukkan tanggal akhir" data-placement="bottom"/>
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
                                            <h5>DAFTAR RETUR PENJUALAN OBAT / ALKES</h5>
                                        </header>
                                        <div id="collapse4" class="body">
                                            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align:center;" width="20%">No. Retur</th>                                                        
														<th style="text-align:center;" width="20%">Tgl. Retur</th>
														<th style="text-align:center;" width="24%">No. Penjualan</th>
														<th style="text-align:center;" width="24%">Nama Pasien</th>
														<th style="text-align:center;" width="20%">Jumlah</th>
														<th style="text-align:center;">Pilihan</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="with-tooltip">
													<?php
														//$no=1;
														foreach($items as $item){
														//debugvar($items);														
													?>
													<tr class="showmodal input-tooltip" id="<?php echo $item['no_retur_penjualan']; ?>" data-original-title="double click untuk detil">
														<td style="text-align:center;"><?php echo $item['no_retur_penjualan']; ?></td>
														<td style="text-align:center;"><?php echo $item['tgl_returpenjualan'] ?></td>
														<td style="text-align:center;"><?php echo $item['no_penjualan']; ?></td>
														<td><?php echo $item['nama_pasien']; ?></td>
														<td style="text-align:right;"><?php echo number_format($item['total'],2,',','.'); ?></td>
														<td style="text-align:center;width:160px;">
                                                            <a href="<?php echo base_url() ?>index.php/transapotek/returpenjualanobat/ubahretur/<?php echo $item['no_retur_penjualan'] ?>" class="btn"><i class="icon-edit"></i> Edit</a>
                                                            <?php
                                                            if($item['tutup']){
                                                                ?>
                                                                &nbsp;
                                                                    <?php
                                                            }else{
                                                            ?>
                                                            <a href="#" onClick="xar_confirm('<?php echo base_url() ?>index.php/transapotek/returpenjualanobat/hapusretur/<?php echo $item['no_retur_penjualan'] ?>','Apakah Anda ingin menghapus data ini?')" class="btn btn-danger"><i class="icon-remove"></i> Hapus</a>
                                                            <?php
                                                            }
                                                            ?>																		
                                                        </td>
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
			
			<div aria-hidden="true" aria-labelledby="approveModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="detilmodal" style="display: none;width:97%;margin-left:-0;left:10px;top:5px;">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                   <!--
                    <div class="toolbar pull-right" style="height:auto;">
                        <ul class="nav nav-tabs">
                            <li><button class="btn" href="<-?php echo base_url() ?>index.php/penerimaan/tambahpenerimaan"> <i class="icon-plus"></i> Tambah</button></li>
                        </ul>
                    </div>   
                    -->                 
                    <h3 id="helpModalLabel"><i class="icon-external-link"></i> Detil Retur Penjualan Obat / Alkes</h3>
                </div>
                <div class="modal-body" style="">
                    <div class="body" id="collapse4">
                        <table class="table table-condensed responsive">
                            <tr>
                                <td>No. Retur</td>
                                <td id="tdretur">: </td>
                                <td>Tgl. Retur</td>
                                <td id="tdtglretur">: </td>
								<td>Jenis Pasien</td>
                                <td id="tdjenis">: </td>								
                            </tr>
                            <tr>
                                <td>No. Penjualan</td>
                                <td id="tdpenjualan">: </td>
                                <td>Tgl. Penjualan</td>
                                <td id="tdtglpenjualan">: </td>
								<td>Jml. Item Obat</td>
                                <td id="tdjml">: </td>
                            </tr>
                            <tr>
                                <td>Dokter</td>
                                <td id="tddokter">:  </td>
								<td>Pasien</td>
                                <td id="tdpasien">: </td>
								<td>Total Retur</td>
                                <td id="tdtotalretur">: </td>
                            </tr>
                            <tr>
                                <td>Unit Apotek</td>
                                <td id="tdunit">: </td>
								<td>Alamat</td>
                                <td id="tdalasan">: </td>
                            </tr>                            
                        </table>
                        <table class="table table-bordered responsive">
                            <thead>
                                <tr>
                                    <th class="header">&nbsp;</th>
                                    <th class="header">Nama Obat</th>
                                    <th class="header">Satuan</th>
                                    <th class="header">Tgl. Expire</th>
									<th class="header">Harga</th>
									<th class="header">Qty</th>                                    									
									<th class="header">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="bodyinput">
                            </tbody>
                            <tfoot>
                                 <tr>
                                    <th class="header">&nbsp;</th>
									<th class="header">&nbsp;</th>									
                                    <th class="header">&nbsp;</th>
									<th class="header">&nbsp;</th>
									<th class="header">&nbsp;</th>
									<th class="header">Total :</th>
                                    <th class="header" id="tdtotalgrid" style="text-align:right;"> </th>
                                </tr>
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
            url: '<?php echo base_url() ?>index.php/transapotek/returpenjualanobat/ambilitem/',
            async:false,
            type:'get',
            data:{query:$(this).attr('id')},
            success:function(data){
                //typeahead.process(data)
                    $('#tdretur').html('');
                    $('#tdtglretur').html('');
                    $('#tdjenis').html('');
					$('#tdpenjualan').html('');
                    $('#tdtglpenjualan').html('');
                    $('#tdjml').html('');
                    $('#tddokter').html('');
					$('#tdpasien').html('');
					$('#tdtotalretur').html('');
					$('#tdalasan').html('');
					$('#tdunit').html('');
                   // $('#detilcetak').attr('href','');
                $.each(data,function(i,l){
                    //alert(l);

                    $('#tdretur').html(': '+data.no_retur_penjualan);
					$('#tdtglretur').html(': '+data.tgl_returpenjualan);
					$('#tdjenis').html(': '+data.customer);
					$('#tdpenjualan').html(': '+data.no_penjualan);
					$('#tdtglpenjualan').html(': '+data.tgl_penjualan);
					$('#tdjml').html(': '+data.jml_item_obat);
					$('#tddokter').html(': '+data.dokter);
					$('#tdpasien').html(': '+data.nama_pasien);
					$('#tdtotalretur').html(': '+data.total);
					$('#tdalasan').html(': '+data.alasan);
					$('#tdunit').html(': '+data.nama_unit_apt);
					$('#detilcetak').attr('href','<?php echo base_url() ?>third-party/fpdf/buktireturpenjualan.php?no_retur_penjualan='+data.no_retur_penjualan);
					$('#detilcetak').attr('target','_blank');
                });
                
            },
            dataType:'json'                         
        }); 

        $.ajax({
            url: '<?php echo base_url() ?>index.php/transapotek/returpenjualanobat/ambilitems/',
            async:false,
            type:'get',
            data:{query:$(this).attr('id')},
            success:function(data){
                //typeahead.process(data)
                $('#bodyinput').empty();
                var no=1;
                var totalall=0;
                $.each(data,function(i,l){
                    //alert(l);
                    totalall=totalall+parseInt(l.totalgrid);
                    $('#bodyinput').append('<tr><td>'+no+'</td><td>'+l.nama_obat+'</td><td>'+l.satuan_kecil+'</td><td>'+l.tgl_expire+'</td><td>'+l.harga_jual+'</td><td>'+l.qty+'&nbsp;</td><td style="text-align:right;">'+l.totalgrid+'</td></tr>');
                    no++;
                });
                $('#tdtotalgrid').html(addCommas(totalall));
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
