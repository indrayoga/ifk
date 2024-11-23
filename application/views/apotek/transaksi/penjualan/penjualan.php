<script src="<?php echo base_url(); ?>assets/js/mousetrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/mousetrap-global-bind.min.js"></script> 
<script type="text/javascript">
	Mousetrap.bindGlobal('ctrl+r', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/penjualan/tambahpenjualan'; return false;});
	//Mousetrap.bindGlobal('f6', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/penjualan'; return false;});
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
                                        <header class="top fixed" style="width:100%">
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>PENCARIAN DATA OBAT KELUAR</h5>							
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <!--li><button class="btn" type="button" onclick='window.location="<-?php echo base_url() ?>index.php/transapotek/penjualan/tambahpenjualan"'> <i class="icon-plus"></i> Tambah</button></li-->                                                    
                                                    <!--<li><a href="<?php echo base_url() ?>index.php/transapotek/penjualan/tambahpenjualan"> <i class="icon-plus"></i> Tambah (Ctrl + R)</a></li>-->
                                                    
                                                    <li><a href="<?=base_url('index.php/transapotek/laporanapt/rl1excelpenjualanobat/'.$periodeawal.'/'.$periodeakhir.'/'.$id_puskesmas)?>"> <i class="icon-print"></i> Cetak</a></li>
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
                                            <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/transapotek/penjualan">
												<div class="row-fluid">
													<div class="span12">
														<div class="span4">
															<div class="control-group">
																<label for="no_sbbk" class="control-label">No. SBBK</label>
																<div class="controls with-tooltip">
																	<input type="text" id="no_sbbk" name="no_sbbk" value="<?php echo $no_sbbk; ?>" class="input-medium input-tooltip" data-original-title="masukkan no penjualan yang ingin dicari" data-placement="bottom"/>												
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
                                                                <label for="id_puskesmas" class="control-label">Customer </label>
                                                                <div class="controls with-tooltip">
                                                                    <select id="id_puskesmas" name="id_puskesmas">
                                                                        <option value="">Pilih</option>
                                                                        <?php
                                                                        foreach ($datapuskesmas as $puskesmas) {
                                                                            # code...
                                                                            $selected = false;
                                                                            if(isset($id_puskesmas) && $id_puskesmas == $puskesmas['id']) {
                                                                                $selected = true;
                                                                            }
                                                                        ?>

                                                                        <option value="<?php echo $puskesmas['id'] ?>" <?=  $selected ? 'selected="selected"' : '' ?>>
                                                                            <?php echo $puskesmas['nama'] ?>
                                                                        </option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <span class="help-inline"></span>                                                               
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label for="kd_jenis_transaksi" class="control-label">Jenis Transaksi </label>
                                                                <div class="controls with-tooltip">
                                                                    <select id="kd_jenis_transaksi" name="kd_jenis_transaksi">
                                                                        <option value="">Pilih Jenis Transaksi</option>
                                                                        <?php
                                                                        foreach ($jenistransaksi as $jt) {
                                                                            # code...
                                                                            $selected = false;
                                                                            if(isset($kd_jenis_transaksi) && $kd_jenis_transaksi == $jt['kode']) {
                                                                                $selected = true;
                                                                            }
                                                                        ?>

                                                                        <option value="<?php echo $jt['kode'] ?>" <?=  $selected ? 'selected="selected"' : '' ?>>
                                                                            <?php echo $jt['nama'] ?>
                                                                        </option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <span class="help-inline"></span>                                                               
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
                                            <p>*Tambah SBBK Wajib melalui IFK Offline</p>
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
                                            <h5>DAFTAR OBAT KELUAR</h5>
                                        </header>
                                        <div id="collapse4" class="body">
                                            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align:center;">Nomor</th>
                                                        <th style="text-align:center;">No. SBBK</th>                                                        
                                                        <th style="text-align:center;">Jenis Transaksi</th>                                                        
														<th style="text-align:center;">Tanggal</th>
														<th style="text-align:center;">Customer</th>
														<th style="text-align:center;">Total Transaksi</th>
														<th style="text-align:center;">Status</th>
														<th style="text-align:center;">Pilihan</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="with-tooltip">
													<?php
														//$no=1;
                                                        $total = 0;
														foreach($items as $item){
                                                            $item['total_transaksi']=$this->mpenjualan->getTotalPenjualan($item['no_penjualan']);
                                                            $total += $item['total_transaksi'];
														//debugvar($items);														
													?>
													<tr class="showmodal input-tooltip" id="<?php echo $item['no_penjualan']; ?>" data-original-title="double click untuk detil">
														<td style="text-align:center;"><?php echo $item['no_penjualan']; ?></td>
                                                        <td style="text-align:center;"><?php echo $item['no_sbbk']; ?></td>
                                                        <td style="text-align:center;"><?php echo $item['nama']; ?></td>
														<td style="text-align:center;"><?php echo convertDate($item['tgl_penjualan']) ?></td>
														<td style="text-align:left;"><?php echo $item['puskesmas']; ?></td>
														<td style="text-align:right;"><?php echo number_format($item['total_transaksi'], 2, ',', '.') ?></td>
														<td style="text-align:center;"><?php  if($item['kirim']==1){echo"terkirim";}else{echo "-";} ?></td>
														<td style="text-align:center;width:160px;">                                                           
                                                            <?php
                                                            if($item['tutup']){																
                                                                ?>
                                                                &nbsp;
																<a href="<?php echo base_url() ?>index.php/transapotek/penjualan/ubahpenjualan/<?php echo $item['no_penjualan'] ?>" class="btn"><i class="icon-edit"></i>Lihat Data</a>
                                                                    <?php
                                                            }else{
                                                            ?>
															<a href="<?php echo base_url() ?>index.php/transapotek/penjualan/ubahpenjualan/<?php echo $item['no_penjualan'] ?>" class="btn"><i class="icon-edit"></i> Edit</a>
                                                            <a href="#" onClick="xar_confirm('<?php echo base_url() ?>index.php/transapotek/penjualan/hapuspenjualan/<?php echo $item['no_penjualan'] ?>','Apakah Anda ingin menghapus data ini?')" class="btn btn-danger"><i class="icon-remove"></i> Hapus</a>
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
                                                <tfoot>
                                                    <tr>
                                                        <td style="text-align:right;"colspan="4">TOTAL</td>
                                                        <td style="text-align:right;"><?php echo number_format($total,2,',','.') ?></td>
                                                    </tr>
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
			
			<div aria-hidden="true" aria-labelledby="approveModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="detilmodal" style="display: none;width:97%;margin-left:-0;left:10px;top:5px;">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>         
                    <h3 id="helpModalLabel"><i class="icon-external-link"></i> Detil Penjualan</h3>
                </div>
                <div class="modal-body" style="">
                    <div class="body" id="collapse4">
                        <table class="table table-condensed responsive">
                            <tr>
                                <td>No Transaksi</td>
                                <td id="tdpenjualan">: </td>  
								<td></td>								
								<td>Unit </td>
                                <td id="tdunitapotek">: </td>   
								<td></td>
								<td>Status Penjualan</td>
                                <td id="tdlunas">: </td>						
                            </tr>
                            <tr>
                                <td>Tgl. Transaksi</td>
                                <td id="tdtanggal">: </td>  
								<td></td>
								<td>BHP</td>
                                <td id="tdbhp">: </td>
								<td></td>
								<td>Tutup Faktur</td>
                                <td id="tdtutup">: </td>
                            </tr>
                            <tr>								
                                <td>Nama Puskesmas</td>
                                <td id="tdnamapuskesmas">:  </td>
								<td></td>
								<td>Shift</td>
                                <td id="tdshift">: </td>
								<td></td>
								<td>Jumlah Transaksi</td>
                                <td id="tdjumlahtransaksi">: </td>								
                            </tr>
                            <tr>
                                <td colspan="6"></td>
								<td>Jumlah Bayar</td>
                                <td colspan="3" id="tdjumlahbayar">: </td>
								<td></td>                                
                            </tr>
                        </table>
                        <table class="table table-bordered responsive">
                            <thead>
                                <tr>
                                    <th class="header">&nbsp;</th>
                                    <th class="header" style="text-align:center;">Nama Obat</th>
                                    <th class="header" style="text-align:center;">Satuan</th>
                                    <th class="header" style="text-align:center;">Tgl. Expire</th>
                                    <th class="header" style="text-align:center;">Harga (Rp)</th>
									<th class="header" style="text-align:center;">Qty</th>
									<th class="header" style="text-align:center;">Jumlah (Rp)</th>
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
                                    <th class="header" style="text-align:right;">T O T A L</th>
                                    <th class="header" id="tdtotal" style="text-align:right;"> </th>
                                </tr>
                           </tfoot>
                        </table>

                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-success" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="#" id="detilcetak"><i class="icon-print"></i> Cetak SBBK</a>
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
            url: '<?php echo base_url() ?>index.php/transapotek/penjualan/ambilitem/',
            async:false,
            type:'get',
            data:{query:$(this).attr('id')},
            success:function(data){
                //typeahead.process(data)
                    $('#tdpenjualan').html('');
                    $('#tdresep').html('');
                    $('#tdbhp').html('');
		    		$('#tdlunas').html('');
                    $('#tdtanggal').html('');
                    $('#tdshift').html('');
                    //$('#tdjasatuslah').html('');
                    $('#tdtutup').html('');
                    $('#tdnamapuskesmas').html('');
					//$('#tdjasaresep').html('');
					$('#tdunitapotek').html('');
					$('#tdjenispasien').html('');
					$('#tdjumlahtransaksi').html('');
					$('#tddokter').html('');
					$('#tdjumlahbayar').html('');
                    $('#detilcetak').attr('href','#');
                $.each(data,function(i,l){
                    $('#tdpenjualan').html(': '+data.no_penjualan);
					if(data.resep=='1') a='Ya';
					else a='Tidak';
                    $('#tdresep').html(': '+a);
                    $('#tdbhp').html(': '+addCommas(data.bhp));
					if(data.is_lunas=='1') b='Lunas';
					else b='Belum Lunas';
                    $('#tdlunas').html(': '+b);
                    $('#tdtanggal').html(': '+data.tgl_penjualan);
                    $('#tdshift').html(': '+data.shiftapt);
     
					if(data.tutup=='1') c='Posting';
					else c='Belum';
                    $('#tdtutup').html(': '+c);
					$('#tdnamapuskesmas').html(': '+data.nama_puskesmas);
					//$('#tdjasaresep').html(': '+addCommas(data.adm_resep));
					$('#tdunitapotek').html(': ' + data.nama_unit_apt);
					$('#tdjenispasien').html(': '+data.jenis);
					$('#tdjumlahtransaksi').html(': '+addCommas(data.total_transaksi));
					if(data.nm_dokter==null) d='-';
					else d=data.nm_dokter;
					$('#tddokter').html(': '+d);
					$('#tdjumlahbayar').html(': '+addCommas(data.total_bayar));
                    $('#detilcetak').attr('href','<?php echo base_url() . "/index.php/transapotek/penjualan/cetaksbbkexcel/" ?>' + data.no_penjualan);
                });
                
            },
            dataType:'json'                         
        }); 

        $.ajax({
            url: '<?php echo base_url() ?>index.php/transapotek/penjualan/ambilitems/',
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
                    //totalall=totalall+parseInt(l.total);
					totalall=totalall+parseFloat(l.total);
					if(l.adm_resep==null)adm=0;
					else adm=l.adm_resep;
                    $('#bodyinput').append('<tr><td style="text-align:center;">'+no+'</td><td>'+l.nama_obat+'</td><td style="text-align:center;">'+l.satuan_kecil+'</td><td style="text-align:center;">'+l.tgl_expire+'</td><td style="text-align:right;">'+addCommas(l.harga_jual)+'</td><td style="text-align:right;">'+addCommas(l.qty)+'</td><td style="text-align:right;">'+addCommas(l.total)+'</td></tr>');
                    no++;
                });
                
                $('#tdtotal').html(addCommas(totalall));
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
