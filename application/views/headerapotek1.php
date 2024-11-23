<html class="no-js">
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?php echo isset($title) ? $title : "" ?></title>
        <meta name="description" content="SIM RS, Planet IT">
        <meta name="viewport" content="width=device-width">
        <?php
        //debugvar($cssfile);
            foreach ($cssfile as $css) {
                # code...
                ?>
                <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/<?php echo $css; ?>">
                <?php
            }
        ?>                  
        <style type="text/css">
            select, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"]{
                height:30px;
                border: 1px solid;
             }
             label{
                 font-weight:bold;
             }
        </style>        
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <!--[if IE 7]>
        <link type="text/css" rel="stylesheet" href="assets/css/font-awesome-ie7.min.css"/>
        <![endif]-->

		<?php
			foreach ($jsfile as $js) {
				# code...
				?>
				<script src="<?php echo base_url(); ?>assets/js/<?php echo $js; ?>"></script>
				<?php
			}
		?>					
		<script type="text/javascript">
		
		//$('body').off('.data-api');


        </script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.form.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/common.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/mousetrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/mousetrap-global-bind.min.js"></script>
        <script type="text/javascript">
			//Mousetrap.bind('ctrl+shift+t', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/penjualan/tambahpenjualan'; return false;});
			<?php if($this->session->userdata('kd_unit_apt')!=$this->session->userdata('kd_unit_apt_gudang')) { ?>
				Mousetrap.bindGlobal('f6', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/penjualan'; return false;});
				Mousetrap.bindGlobal('f9', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/returpenjualanobat'; return false;});
			<?php } else { ?>			
				Mousetrap.bindGlobal('f4', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptpemesanan'; return false;});
				Mousetrap.bindGlobal('f7', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptpenerimaan'; return false;});
				Mousetrap.bindGlobal('f8', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptreturobat'; return false;});	
			<?php } ?>					
			Mousetrap.bindGlobal('f10', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptdistribusi'; return false;});
          
		  $('input[type="text"]').keyup()
            $(document).ready(function() {

            $('input[type="text"]').on('keyup', function(e){
                    if (e.which == 27) { 
                        $(this).trigger( "blur" ); // unbind the blur event
                       // alert(this);
                    }    
                });                                  
            });            
        </script>
        <style type="text/css">
            #content .container-fluid{
                padding:0 !important;
            }
            #top > .navbar {
                border-top: 0px !important;
            }            
        </style>

        <script>
 
            /* bootstrap-dropdown.js v2.0.2
 
             * http://twitter.github.com/bootstrap/javascript.html#dropdowns
             * ============================================================
             * Copyright 2012 Twitter, Inc.
             *
             * Licensed under the Apache License, Version 2.0 (the "License");
             * you may not use this file except in compliance with the License.
             * You may obtain a copy of the License at
             *
             * http://www.apache.org/licenses/LICENSE-2.0
             *
             * Unless required by applicable law or agreed to in writing, software
             * distributed under the License is distributed on an "AS IS" BASIS,
             * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
             * See the License for the specific language governing permissions and
             * limitations under the License.
           */
     !function( $ ){
       "use strict"
      /* DROPDOWN CLASS DEFINITION
             * ========================= */
            var toggle = '[data-toggle="dropdown"]'
            , Dropdown = function ( element ) {
                var $el = $(element).on('click.dropdown.data-api', this.toggle)
                $('html').on('click.dropdown.data-api', function () {
                    $el.parent().removeClass('open')
                })
            }
            Dropdown.prototype = {
                constructor: Dropdown
                , toggle: function ( e ) {
                    var $this = $(this)
                    , selector = $this.attr('data-target')
                    , $parent
                    , isActive
 
                    if (!selector) {
                        selector = $this.attr('href')
                        selector = selector && selector.replace(/.*(?=#[^\s]*$)/, '') //strip for ie7
                    }
 
                    $parent = $(selector)
                    $parent.length || ($parent = $this.parent())
                    isActive = $parent.hasClass('open')
                    clearMenus()
                        !isActive && $parent.toggleClass('open')
                    return false
                }
            }
 
            function clearMenus() {
                $(toggle).parent().removeClass('open')
            }
            /* DROPDOWN PLUGIN DEFINITION
             * ========================== */
            $.fn.dropdown = function ( option ) {
                return this.each(function () {
                    var $this = $(this)
                    , data = $this.data('dropdown')
                    if (!data) $this.data('dropdown', (data = new Dropdown(this)))
                    if (typeof option == 'string') data[option].call($this)
                })
            }
            $.fn.dropdown.Constructor = Dropdown
            /* APPLY TO STANDARD DROPDOWN ELEMENTS
             * =================================== */
            $(function () {
                $('html').on('click.dropdown.data-api', clearMenus)
                $('body').on('click.dropdown.data-api', toggle, Dropdown.prototype.toggle)
            })
        }( window.jQuery );
        </script>

        <script type='text/javascript'>//<![CDATA[
        $(window).load(function(){
            jQuery('.submenu').hover(function () {
                jQuery(this).children('ul').removeClass('submenu-hide').addClass('submenu-show');
            }, function () {
                jQuery(this).children('ul').removeClass('.submenu-show').addClass('submenu-hide');
            }).find("a:first").append(" &raquo; ");
        });//]]>

        $(document).ready(function(){
            $('#changeSidebarPos').trigger('click');
        });

function disableCtrlKeyCombination(e)
{
//list all CTRL + key combinations you want to disable
var forbiddenKeys = new Array('s','n');
var key;
var isCtrl;

if(window.event)
{
key = window.event.keyCode;     //IE
if(window.event.ctrlKey)
isCtrl = true;
else
isCtrl = false;
}
else
{

key = e.which;     //firefox
if(e.ctrlKey)
isCtrl = true;
else
isCtrl = false;
}

//if ctrl is pressed check if other key is in forbidenKeys array
if(isCtrl)
{
for(i=0; i<forbiddenKeys.length; i++)
{
//case-insensitive comparation
if(forbiddenKeys[i].toLowerCase() == String.fromCharCode(key).toLowerCase())
{
//alert('Key combination CTRL + '+String.fromCharCode(key) +' has been disabled.');
return false;
}
}
}
return true;
}

        </script>

        <style>
            .submenu-show
            {
                border-radius: 3px;
                display: block;
                left: 100%;
                margin-top: -25px !important;
                moz-border-radius: 3px;
                position: absolute;
                webkit-border-radius: 3px;
            }
            .submenu-hide
            {
                display: none !important;
                float: right;
                position: relative;
                top: auto;
            }
            .navbar .submenu-show:before
            {
                border-bottom: 7px solid transparent;
                border-left: none;
                border-right: 7px solid rgba(0, 0, 0, 0.2);
                border-top: 7px solid transparent;
                left: -7px;
                top: 10px;
            }
 
            .navbar .submenu-show:after
            {
                border-bottom: 6px solid transparent;
                border-left: none;
                border-right: 6px solid #fff;
                border-top: 6px solid transparent;
                left: 10px;
                left: -6px;
                top: 11px;
            }
        </style>


        <style type="text/css">
            .navbar-inner {
                box-shadow: 0 3px 6px rgba(0, 0, 0, 0.5);           
            }        
            .container {
                box-shadow: 0 3px 6px rgba(0, 0, 0, 0.5);           
            }        
            .dropdown-menu {
                box-shadow: 0 3px 6px rgba(0, 0, 0, 0.5);           
            }        
            .divider-vertical {
                border-color: #EEEEEE !important;
                box-shadow: 0 3px 6px rgba(0, 0, 0, 0.5);           
            }        
         
        </style>                

	</head>
	<body onkeypress="return disableCtrlKeyCombination(event);" onkeydown="return disableCtrlKeyCombination(event);">
        <!-- BEGIN WRAP -->
        <div id="wrap" style="">


            <!-- BEGIN TOP BAR -->
            <div id="top">
                <!-- .navbar -->
                <div class="navbar navbar-static-top">
                    <div class="navbar-inner">
                        <div class="container-fluid">
                            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </a>
                            <!--a class="brand" href="index.html">SIM RS</a-->
                            <!-- .topnav -->
                            <div class="btn-toolbar topnav">
                                <div class="btn-group">
                                    <a id="changeSidebarPos" class="btn btn-success" rel="tooltip"
                                    data-original-title="Show / Hide Sidebar" data-placement="bottom">
                                        <i class="icon-resize-horizontal"></i>
                                    </a>
                                </div>
                                <!--
                                <div class="btn-group">
                                    <a class="btn btn-inverse" rel="tooltip" data-original-title="E-mail" data-placement="bottom">
                                        <i class="icon-envelope"></i>
                                        <span class="label label-warning">5</span>
                                    </a>
                                    <a class="btn btn-inverse" rel="tooltip" href="#" data-original-title="Messages"
                                       data-placement="bottom">
                                        <i class="icon-comments"></i>
                                        <span class="label label-important">4</span>
                                    </a>
                                </div>
                            -->
                                <div class="btn-group">
                                    <!--
                                    <a class="btn btn-inverse" rel="tooltip" href="#" data-original-title="Document"
                                       data-placement="bottom">
                                        <i class="icon-file"></i>
                                    </a>
                                -->
                                    <a href="#helpModal" class="btn btn-inverse" rel="tooltip" data-placement="bottom"
                                       data-original-title="Help" data-toggle="modal">
                                        <i class="icon-question-sign"></i>
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <a class="btn btn-inverse" data-placement="bottom" data-original-title="Logout" rel="tooltip"
                                       href="<?php echo base_url() ?>index.php/home/logout"><i class="icon-off"></i></a></div>
                            </div>
                            <!-- /.topnav -->
                            <div class="nav-collapse collapse">
                                <!-- .nav -->
                                <ul class="nav">
                                    <li class="dropdown">
                                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                            File Master <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="dropdown submenu">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class=" icon-doc-1"></i>Master</a>
                                                <ul class="dropdown-menu submenu-show submenu-hide">
                                                    <li><a href="<?php echo base_url() ?>index.php/masterapotek/obat"><i class="icon-angle-right"></i> Obat / Alkes</a></li>                                                  
                                                    <li class="divider"></li>
													<?php if($this->session->userdata('kd_unit_apt')==$this->session->userdata('kd_unit_apt_gudang')) { ?>
																<li><a href="<?php echo base_url() ?>index.php/masterapotek/satuankecil"><i class="icon-angle-right"></i> Satuan Obat / Alkes</a></li>
																<li class="divider"></li>
																<li><a href="<?php echo base_url() ?>index.php/masterapotek/golongan"><i class="icon-angle-right"></i> Golongan Obat / Alkes</a></li>
																<li class="divider"></li>
																<li><a href="<?php echo base_url() ?>index.php/masterapotek/aptsupplier"><i class="icon-angle-right"></i> Distributor Obat / Alkes</a></li>													
																<li class="divider"></li>
													<? } ?>                                                    
													<li><a href="<?php echo base_url() ?>index.php/masterapotek/bmhpobat"><i class="icon-angle-right"></i> BMHP Obat / Alkes</a></li>
													<li class="divider"></li>
													<li><a href="<?php echo base_url() ?>index.php/masterapotek/persediaan/persediaanobat"><i class="icon-angle-right"></i> Persediaan Obat / Alkes</a></li>
													<li class="divider"></li>
													<li><a href="<?php echo base_url() ?>index.php/masterapotek/monitoring/monitoring"><i class="icon-angle-right"></i> Monitoring Stok</a></li>
                                                </ul>
                                            </li> 
                                        </ul>
                                    </li>
									<li class="dropdown">
                                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                            File Setting <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="dropdown submenu">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class=" icon-doc-1"></i>Setting</a>
                                                <ul class="dropdown-menu submenu-show submenu-hide">                                                    
													<li><a href="<?php echo base_url() ?>index.php/masterapotek/tarifapt/tarifbungkus"><i class="icon-angle-right"></i> Tarif Per Bungkus</a></li>
													<li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/masterapotek/tarifapt/tarifresep"><i class="icon-angle-right"></i> Tarif Jasa Resep</a></li>
                                                </ul>
                                            </li> 
                                        </ul>
                                    </li>
									<li class="dropdown">
										<a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                            File Transaksi <b class="caret"></b>
                                        </a>
										<ul class="dropdown-menu">
											<li class="dropdown submenu">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class=" icon-doc-1"></i>Transaksi</a>
												<ul class="dropdown-menu submenu-show submenu-hide">
													<?php if($this->session->userdata('kd_unit_apt')==$this->session->userdata('kd_unit_apt_gudang')) { ?>
															<li><a href="<?php echo base_url() ?>index.php/transapotek/aptpengajuan/"><i class="icon-angle-right"></i> Pengajuan Obat ke Distributor</a></li>
															<li class="divider"></li>
															<li><a href="<?php echo base_url() ?>index.php/transapotek/aptgrouping/"><i class="icon-angle-right"></i> Grouping Pengajuan Obat </a></li>
															<li class="divider"></li>
															<li><a href="<?php echo base_url() ?>index.php/transapotek/aptpemesanan/"><i class="icon-angle-right"></i> Pemesanan Obat &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspF4</a></li>
															<li class="divider"></li>
															<li><a href="<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/"><i class="icon-angle-right"></i> Penerimaan Obat &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspF7</a></li>
															<li class="divider"></li>
															<li><a href="<?php echo base_url() ?>index.php/transapotek/aptreturobat/"><i class="icon-angle-right"></i> Retur Penerimaan Obat &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspF8</a></li>
															<li class="divider"></li>
													<?php } ?>													
													<li><a href="<?php echo base_url() ?>index.php/transapotek/aptdistribusi/"><i class="icon-angle-right"></i> Distribusi Obat &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspF10</a></li>													
													<?php if($this->session->userdata('kd_unit_apt')!=$this->session->userdata('kd_unit_apt_gudang')) { ?>
																<li class="divider"></li>
																<li><a href="<?php echo base_url() ?>index.php/transapotek/returpenjualanobat/"><i class="icon-angle-right"></i> Retur Penjualan Obat &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspF9</a></li>
																<li class="divider"></li>
																<li><a href="<?php echo base_url() ?>index.php/transapotek/penjualan/"><i class="icon-angle-right"></i> Penjualan Obat &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspF6</a></li>
													<?php } ?>
															<li class="divider"></li>
															<li><a href="<?php echo base_url() ?>index.php/transapotek/aptpermintaan/"><i class="icon-angle-right"></i> Permintaan Obat </a></li>
												</ul>
											</li>
										</ul>
									</li>
									<li class="dropdown">
										<a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                            File Laporan <b class="caret"></b>
                                        </a>
										<ul class="dropdown-menu">
											<li class="dropdown submenu">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class=" icon-doc-1"></i>Laporan</a>
												<ul class="dropdown-menu submenu-show submenu-hide">
													<li><a href="<?php echo base_url() ?>index.php/transapotek/laporanapt/distribusiapotek"><i class="icon-angle-right"></i> Distribusi Obat</a></li>
													<li class="divider"></li>
													<?php if($this->session->userdata('kd_unit_apt')==$this->session->userdata('kd_unit_apt_gudang')) { ?>
														<li><a href="<?php echo base_url() ?>index.php/transapotek/laporanapt/penerimaanapotek"><i class="icon-angle-right"></i> Penerimaan Obat</a></li>
														<li class="divider"></li>
													<?php } ?> 
													<?php if($this->session->userdata('kd_unit_apt')!=$this->session->userdata('kd_unit_apt_gudang')){ ?>
														<li><a href="<?php echo base_url() ?>index.php/transapotek/laporanapt/penjualanapotek"><i class="icon-angle-right"></i> Penjualan Obat Per Resep</a></li> 
														<li class="divider"></li>
														<li><a href="<?php echo base_url() ?>index.php/transapotek/laporanapt/penjualanobat"><i class="icon-angle-right"></i> Penjualan Obat</a></li> 
														<li class="divider"></li>
														<li><a href="<?php echo base_url() ?>index.php/transapotek/laporanapt/rekappenjualan"><i class="icon-angle-right"></i> Rekap Penjualan Obat</a></li> 
														<li class="divider"></li>
													<?php } ?>													
													<li><a href="<?php echo base_url() ?>index.php/transapotek/laporanapt/persediaanapotek"><i class="icon-angle-right"></i> Persediaan Obat</a></li> 
													<li class="divider"></li>
													<li><a href="<?php echo base_url() ?>index.php/transapotek/laporanapt/kartustok"><i class="icon-angle-right"></i> Kartu Stok Obat</a></li> 
													<li class="divider"></li>
													<li><a href="<?php echo base_url() ?>index.php/transapotek/laporanapt/mutasiobat"><i class="icon-angle-right"></i> Mutasi Obat</a></li> 
													<li class="divider"></li>
													<li><a href="<?php echo base_url() ?>index.php/transapotek/penyesuaian/penyesuaianstok"><i class="icon-angle-right"></i> Stokopname Obat</a></li>													
												</ul>
											</li>
										</ul>
									</li>
									<?php if(($this->session->userdata('kd_unit_apt')!=$this->session->userdata('kd_unit_apt_gudang')) or ($this->session->userdata('kd_unit_apt')==$this->session->userdata('kd_unit_apt2'))) { ?>
										<li><a href="<?php echo base_url() ?>index.php/transapotek/laporanapt/tutuppenjualan"><i></i> Tutup Penjualan</a></li> 
									<?php } ?>	
                                </ul>
                                <!-- /.nav -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.navbar -->
            </div>
            <!-- END TOP BAR -->
			<div class="headerImg"></div>
            <div class="menu">
                <ul class="ul-menu">
                </ul>
            </div>

            <!-- BEGIN HEADER.head -->
            <!--<header class="head">
                <div class="search-bar">
                    <div class="row-fluid">
                        
                    </div>

                </div>
                -->
                <!-- ."main-bar -->
                <!--
                <div class="main-bar">
                    <div class="container-fluid">
                        <div class="row-fluid">
                            <div class="span12">
                                <h3><i class="icon-home"></i> Dashboard</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </header>-->
            <!-- END HEADER.head -->
            <!-- BEGIN LEFT  -->
            <div id="left">
                <!-- .user-media -->
                
                <div class="media user-media hidden-phone" style="font-weight:bold;padding:0px;background-color:#F5F5F5;color:#008000;">

                    <div class="media-body hidden-tablet">

                    </div>
                </div>
                
                <!-- /.user-media -->

                <!-- BEGIN MAIN NAVIGATION -->
                <ul id="menu" class="unstyled accordion collapse in">
                    <!--<li class="accordion-group active">
                        <a data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#dashboard-nav">
                            <i class="icon-dashboard icon-large"></i> Dashboard <span
                                class="label label-inverse pull-right">2</span>
                        </a>
                        <ul class="collapse in" id="dashboard-nav">
                            <li><a href="index.html"><i class="icon-angle-right"></i> Default Style</a></li>
                            <li><a href="alterne.html"><i class="icon-angle-right"></i> Alternative Style</a></li>
                        </ul>
                    </li>-->

                    <!--<li class="accordion-group ">
                        <a data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#component-nav">
                            <i class="icon-tasks icon-large"></i> Components <span class="label label-inverse pull-right">2</span>
                        </a>
                        <ul class="collapse " id="component-nav">
                            <li><a href="icon.html"><i class="icon-angle-right"></i> Icon & Button</a></li>
                            <li><a href="progress.html"><i class="icon-angle-right"></i> Progress</a></li>
                        </ul>
                    </li>-->

                </ul>
                <!-- END MAIN NAVIGATION -->

            </div>
            <!-- END LEFT -->            


<!--modal laporan-->
