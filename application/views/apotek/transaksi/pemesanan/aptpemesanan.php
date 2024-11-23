<script src="<?php echo base_url(); ?>assets/js/mousetrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/mousetrap-global-bind.min.js"></script> 
<script type="text/javascript">
	Mousetrap.bindGlobal('ctrl+r', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptpemesanan/tambahpemesananapt'; return false;});
	Mousetrap.bindGlobal('f4', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptpemesanan'; return false;});
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
                                            <h5>PENCARIAN DATA PEMESANAN</h5>							
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                   <!-- <li><a href="<?php echo base_url() ?>index.php/transapotek/aptpemesanan/tambahpemesananapt"> <i class="icon-plus"></i> Tambah Pemesanan / (Ctrl + R)</a></li>-->
													<li><a target="_blank"  href="<?php echo base_url() ?>third-party/fpdf/daftarpemesanan.php?periodeawal=<?php echo $periodeawal ?>&periodeakhir=<?php echo $periodeakhir; ?>"> <i class="icon-print"></i> Cetak Daftar Pemesanan</a></li>
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
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/aptpemesanan">
												<div class="row-fluid">
													<div class="span12">
														<div class="span4">
															<div class="control-group">
																<label for="no_pemesanan" class="control-label">No Pemesanan</label>
																<div class="controls with-tooltip">
																	<input type="text" id="no_pemesanan" name="no_pemesanan" class="input-medium input-tooltip" data-original-title="masukkan no pemesanan yang ingin dicari" data-placement="bottom"/>												
																</div>
															</div>
														</div>														
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
                                            <h5>DAFTAR TRANSAKSI PEMESANAN OBAT / ALKES</h5>
                                        </header>
                                        <div id="collapse4" class="body">
                                            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                                <thead>
                                                    <tr> 
                                                        <th style="text-align:center;" width="14%">Nomor</th>
														<th style="text-align:center;" width="22%">Nama Distributor</th>
														<th style="text-align:center;" width="11%">Tanggal</th>														
														<th style="text-align:center;" width="37%">Keterangan</th>
														<th style="text-align:center;">Pilihan</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="with-tooltip">
													<?php
														//$no=1;
														foreach($items as $item){														
													?>
															<tr class="showmodal input-tooltip" id="<?php echo $item['no_pemesanan']; ?>" data-original-title="double click untuk detil">
																<td style="text-align:center;"><?php echo $item['no_pemesanan']; ?></td>
																<td><?php echo $item['nama']; ?></td>
																<td style="text-align:center;"><?php echo $item['tgl_pemesanan'] ?></td>
																<td><?php echo $item['keterangan']; ?>&nbsp;</td>
																<td style="text-align:center;width:160px;">
																	<a href="<?php echo base_url() ?>index.php/transapotek/aptpemesanan/ubahpemesanan/<?php echo $item['no_pemesanan'] ?>" class="btn"><i class="icon-edit"></i> Edit</a>																	
																	<a href="#" onClick="xar_confirm('<?php echo base_url() ?>index.php/transapotek/aptpemesanan/hapuspemesanan/<?php echo $item['no_pemesanan'] ?>','Apakah Anda ingin menghapus data ini?')" class="btn btn-danger"><i class="icon-remove"></i> Hapus</a>
																																			
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
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                   <!--
                    <div class="toolbar pull-right" style="height:auto;">
                        <ul class="nav nav-tabs">
                            <li><button class="btn" href="<-?php echo base_url() ?>index.php/penerimaan/tambahpenerimaan"> <i class="icon-plus"></i> Tambah</button></li>
                        </ul>
                    </div>   
                    -->                 
                    <h3 id="helpModalLabel"><i class="icon-external-link"></i> Detil Pemesanan</h3>
                </div>
                <div class="modal-body" style="">
                    <div class="body" id="collapse4">
                        <table class="table table-condensed responsive">
                            <tr>
                                <td>No Pemesanan</td>
                                <td id="tdpemesanan">: </td> 															
                            </tr>
                            <tr>
                                <td>Tgl. Pemesanan</td>
                                <td id="tdtanggalpesan">: </td> 
								<td>Distributor</td>
                                <td id="tdsupplier">: </td>
								
                            </tr>
                            <tr>
                                <td>Tgl. Jatuh Tempo</td>
                                <td id="tdtanggaltempo">:  </td>
								<td>Keterangan</td>
                                <td id="tdketerangan">: </td>								
                            </tr>                            
                        </table>
                        <table class="table table-bordered responsive">
                            <thead>
                                <tr>
                                    <th class="header">&nbsp;</th>
                                    <th class="header" style="text-align:center;">Nama Obat</th>
                                    <th class="header" style="text-align:center;">Satuan</th>                                    
                                    <th class="header" style="text-align:center;">Qty</th>
									<!--th class="header" style="text-align:center;">Qty Kcl</th-->
									<th class="header" style="text-align:center;">Harga</th>
									<th class="header" style="text-align:center;">Disc.%</th>
									<th class="header" style="text-align:center;">PPN %</th>									
									<th class="header" style="text-align:center;">Jumlah</th>
									
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
									<th class="header">&nbsp;</th>
									<th class="header" style="text-align:right;">Jumlah :</th>
                                    <th class="header" id="tdjumlah" style="text-align:right;"> </th>
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
            url: '<?php echo base_url() ?>index.php/transapotek/aptpemesanan/ambilitem/',
            async:false,
            type:'get',
            data:{query:$(this).attr('id')},
            success:function(data){
                //typeahead.process(data)
                    $('#tdpemesanan').html('');
                    $('#tdtanggalpesan').html('');
					$('#tdsupplier').html('');
					$('#tdtanggaltempo').html('');
                    $('#tdketerangan').html('');					
					$('#detilcetak').attr('href','');
                $.each(data,function(i,l){
                    //alert(l);

                    $('#tdpemesanan').html(': '+data.no_pemesanan);
					$('#tdtanggalpesan').html(': '+data.tgl_pemesanan);
					$('#tdsupplier').html(': '+data.nama);
                    $('#tdtanggaltempo').html(': '+data.tgl_tempo);                    
                    $('#tdketerangan').html(': '+data.keterangan);
					$('#detilcetak').attr('href','<?php echo base_url() ?>third-party/fpdf/buktipemesanan.php?no_pemesanan='+data.no_pemesanan);
					$('#detilcetak').attr('target','_blank');
                });
                
            },
            dataType:'json'                         
        }); 

        $.ajax({
            url: '<?php echo base_url() ?>index.php/transapotek/aptpemesanan/ambilitems/',
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
                    totalall=totalall+parseFloat(l.jumlah);
                    $('#bodyinput').append('<tr><td style="text-align:center;">'+no+'</td><td>'+l.nama_obat+'</td><td style="text-align:center;">'+l.satuan_kecil+'</td><td style="text-align:right;">'+l.qty_kcl+'</td><td style="text-align:right;">'+addCommas(l.harga_beli)+'</td><td style="text-align:right;">'+l.diskon+'</td><td style="text-align:right;">'+l.ppn+'&nbsp;</td><td style="text-align:right;">'+addCommas(l.jumlah)+'</td></tr>');
                    no++;
                });
                $('#tdjumlah').html(addCommas(totalall));
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
