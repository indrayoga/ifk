 			<!-- #content -->
            <div id="content">
                <!-- .outer -->
                <div class="container-fluid outer">
                    <div class="row-fluid">
                        <!-- .inner -->
                        <div class="span12 inner">
                      <!--BEGIN INPUT TEXT FIELDS-->
						<form class="form-horizontal" method="POST" action="<?php echo base_url() ?>index.php/customer/editcustomer">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header>
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>Edit Customer</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><button type="button" onclick='window.location="<?php echo base_url() ?>index.php/customer"' class="btn"> <i class="icon-list"></i> Daftar</button></li>                                                                                                        
                                                    <li><button class="btn" type="submit" name="submit" value="submit"> <i class="icon-save icon-share-alt"></i>Simpan</button></li>                                                    
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
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">Kode </label>
                                                    <div class="controls with-tooltip">		
														<input type="hidden" name="id" value="<?php echo $cust_code ?>">
														<input type="text" id="text1" name="cust_code" value="<?php if(!empty($cust_code)) echo $cust_code ?>" readonly class="span2 input-tooltip" data-original-title="masukkan kode customer" data-placement="bottom"/>                                                        
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">Nama Customer</label>
                                                    <div class="controls with-tooltip">														
                                                        <input type="text" id="text1" name="customer" value="<?php if(!empty($customer)) echo $customer ?>" class="span5 input-tooltip" data-original-title="masukkan nama customer" data-placement="bottom"/>
                                                    </div>
                                                </div>
												<div class="control-group">
                                                    <label for="text1" class="control-label">Contact</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" id="text1" name="contact" value="<?php if(!empty($contact)) echo $contact ?>" class="span5 input-tooltip" data-original-title="masukkan nama kontak person" data-placement="bottom"/>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="text1" class="control-label">Alamat</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" id="text1" name="address" value="<?php if(!empty($address)) echo $address ?>" class="span5 input-tooltip" data-original-title="masukkan alamat customer" data-placement="bottom"/>
                                                    </div>
                                                </div> 
												<div class="control-group">
                                                    <label for="text1" class="control-label">Kota</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" id="text1" name="city" value="<?php if(!empty($city)) echo $city ?>" class="span4 input-tooltip" data-original-title="masukkan nama kota" data-placement="bottom"/>
                                                    </div>
                                                </div>
												<div class="control-group">
                                                    <label for="text1" class="control-label">Provinsi</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" id="text1" name="state" value="<?php if(!empty($state)) echo $state ?>" class="span4 input-tooltip" data-original-title="masukkan nama provinsi" data-placement="bottom"/>
                                                    </div>
                                                </div>
												<div class="control-group">
                                                    <label for="text1" class="control-label">Kode Pos</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" id="text1" name="zip" value="<?php if(!empty($zip)) echo $zip ?>" class="span2 input-tooltip" data-original-title="masukkan kode pos" data-placement="bottom"/>
                                                    </div>
                                                </div>
												<div class="control-group">
                                                    <label for="text1" class="control-label">Negara</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" id="text1" name="country" value="<?php if(!empty($country)) echo $country ?>" class="span4 input-tooltip" data-original-title="masukkan nama kota" data-placement="bottom"/>
                                                    </div>
                                                </div>
												<div class="control-group">
                                                    <label for="text1" class="control-label">Telepon 1</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" id="text1" name="phone1" value="<?php if(!empty($phone1)) echo $phone1 ?>" class="span2 input-tooltip" data-original-title="masukkan nomor telepon" data-placement="bottom"/>
                                                    </div>
                                                </div>
												<div class="control-group">
                                                    <label for="text1" class="control-label">Telepon 2</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" id="text1" name="phone2" value="<?php if(!empty($phone2)) echo $phone2 ?>" class="span2 input-tooltip" data-original-title="masukkan nomor telepon" data-placement="bottom"/>
                                                    </div>
                                                </div>
												<div class="control-group">
                                                    <label for="text1" class="control-label">Fax</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" id="text1" name="fax" value="<?php if(!empty($fax)) echo $fax ?>" class="span2 input-tooltip" data-original-title="masukkan nomor fax" data-placement="bottom"/>
                                                    </div>
                                                </div>
												<div class="control-group">
                                                    <label for="text1" class="control-label">Account</label>
                                                    <div class="controls with-tooltip">
                                                        <select class="input-large" name="account" id="account">														
															<?php
																foreach ($dataakun as $akun) {
																	# code...
																	$select="";
																	//debugvar($select);
																	//if(isset($itemakun['account'])){    
																		if($account==$akun['account'])$select="selected=selected";else $select="";
																	//}
															?>
																<option value="<?php echo $akun['account']; ?>" <?php echo $select; ?>><?php echo $akun['name'] ?></option>																
															<?php
																}
															?>
                                                        </select>
                                                    </div>
                                                </div>
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
    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });

</script>