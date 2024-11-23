<html class="no-js">
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>IFK : Instalasi Farmasi Kota Balikpapan</title>
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
	<body>
        <!-- BEGIN WRAP -->
        <div id="wrap" style="">


            <!-- BEGIN TOP BAR -->
            <div id="top">
                <!-- .navbar -->
                <div class="navbar navbar-inverse navbar-static-top">
                    <div class="navbar-inner">
                        <div class="container-fluid">
                            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </a>
                            <a class="brand" href="index.html">Metis</a>
                            <!-- .topnav -->
                            <div class="btn-toolbar topnav">
                                <div class="btn-group">
                                    <a id="changeSidebarPos" class="btn btn-success" rel="tooltip"
                                    data-original-title="Show / Hide Sidebar" data-placement="bottom">
                                        <i class="icon-resize-horizontal"></i>
                                    </a>
                                </div>
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
                                <div class="btn-group">
                                    <a class="btn btn-inverse" rel="tooltip" href="#" data-original-title="Document"
                                       data-placement="bottom">
                                        <i class="icon-file"></i>
                                    </a>
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
                                    <li class="active"><a href="index.html">Dashboard</a></li>
                                    <li><a href="<?php echo base_url() ?>berita">Tables</a></li>
                                    <li><a href="file.html">File Manager</a></li>
                                    <li class="dropdown">
                                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                            Master <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="dropdown submenu">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class=" icon-doc-1"></i>Keuangan</a>
                                                <ul class="dropdown-menu submenu-show submenu-hide">
                                                    <li><a href="<?php echo base_url() ?>index.php/akun"><i class="icon-angle-right"></i> Akun SAK</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/akun"><i class="icon-angle-right"></i> Akun SAP</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/customer"><i class="icon-angle-right"></i> Customer</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/vendor"><i class="icon-angle-right"></i> Vendor</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/unitkerja"><i class="icon-angle-right"></i> Unit Kerja</a></li>
                                        </ul>
                                    </li>
                                            <li class="dropdown submenu">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class=" icon-doc-1"></i>Wilayah</a>
                                                <ul class="dropdown-menu submenu-show submenu-hide">
                                                    <li><a href="<?php echo base_url() ?>index.php/master/propinsi"><i class="icon-angle-right"></i> Propinsi</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/master/kabupaten"><i class="icon-angle-right"></i> Kab/Kota</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/master/kecamatan"><i class="icon-angle-right"></i> Kecamatan</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/master/kelurahan"><i class="icon-angle-right"></i> Kelurahan</a></li>
                                                </ul>
                                            </li>                                            
                                            <li class="dropdown submenu">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class=" icon-doc-1"></i>Pelayanan</a>
                                                <ul class="dropdown-menu submenu-show submenu-hide">
                                                    <li><a href="<?php echo base_url() ?>index.php/master/jenispelayanan"><i class="icon-angle-right"></i> Jenis Pelayanan</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/master/listpelayanan"><i class="icon-angle-right"></i> Pelayanan</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/master/kelas"><i class="icon-angle-right"></i> Kelas Pelayanan</a></li>
                                                </ul>
                                            </li>                                            
											<li><a href="<?php echo base_url() ?>index.php/master/diagnosaicd"><i class="icon-angle-right"></i> Diagnosa ICD</a></li>
											<li><a href="<?php echo base_url() ?>index.php/master/diagnosadtd"><i class="icon-angle-right"></i> Diagnosa DTD</a></li>
                                            <li><a href="<?php echo base_url() ?>index.php/master/tarif"><i class="icon-angle-right"></i> Tarif</a></li>
                                             
											<li><a href="<?php echo base_url() ?>index.php/master/kasir"><i class="icon-angle-right"></i> Kasir</a></li>
											<li><a href="<?php echo base_url() ?>index.php/master/kasirunit"><i class="icon-angle-right"></i> Kasir Unit</a></li>
											<li><a href="<?php echo base_url() ?>index.php/master/ruangan"><i class="icon-angle-right"></i> Ruangan</a></li>
											<li class="dropdown submenu">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class=" icon-doc-1"></i>Logistik</a>
                                                <ul class="dropdown-menu submenu-show submenu-hide">
                                                    <li><a href="<?php echo base_url() ?>index.php/log_master/kategoribarang"><i class="icon-angle-right"></i> Kategori Barang</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/log_master/masterbarang"><i class="icon-angle-right"></i> Master Barang</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/log_master/lokasi"><i class="icon-angle-right"></i> Lokasi</a></li> 
													<li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/log_master/vendor"><i class="icon-angle-right"></i> Vendor</a></li> 
												</ul>
                                            </li>
											<li class="dropdown submenu">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class=" icon-doc-1"></i>Apotek</a>
                                                <ul class="dropdown-menu submenu-show submenu-hide">
                                                    <li><a href="<?php echo base_url() ?>index.php/masterapotek/obat"><i class="icon-angle-right"></i> Obat</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/masterapotek/satuanbesar"><i class="icon-angle-right"></i> Satuan Besar Obat</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/masterapotek/satuankecil"><i class="icon-angle-right"></i> Satuan Kecil Obat</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/masterapotek/golongan"><i class="icon-angle-right"></i> Golongan Obat</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/masterapotek/jenisobat"><i class="icon-angle-right"></i> Jenis Obat</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/masterapotek/subjenis"><i class="icon-angle-right"></i> Subjenis Obat</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/masterapotek/milik"><i class="icon-angle-right"></i> Milik</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/masterapotek/aptcustomer"><i class="icon-angle-right"></i> Customer Apotek</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/masterapotek/aptsupplier"><i class="icon-angle-right"></i> Supplier Apotek</a></li>
													<li class="divider"></li>
                                                    <li><a href="<?php echo base_url() ?>index.php/transapotek/penyesuaian/penyesuaianstok"><i class="icon-angle-right"></i> Stokopname</a></li>													
												</ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                            Setting <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?php echo base_url() ?>index.php/setting/user"><i class="icon-angle-right"></i> User</a></li>
                                            <li class="divider"></li>
                                            <li><a href="<?php echo base_url() ?>index.php/setting/diagnosaunit"><i class="icon-angle-right"></i> Diagnosa Unit</a></li>
                                           <li class="divider"></li>
                                            <li><a href="<?php echo base_url() ?>index.php/setting/tambahuser"><i class="icon-angle-right"></i> Tambah User</a></li>
                                            <li class="divider"></li>
                                            <li><a href="<?php echo base_url() ?>index.php/setting/tarifunit"><i class="icon-angle-right"></i> Tarif Mapping</a></li>
                                            <li class="divider"></li>
                                            <li><a href="<?php echo base_url() ?>index.php/setting/akunaruskas"><i class="icon-angle-right"></i> Arus Kas</a></li>
                                            <li class="divider"></li>
                                            <li><a href="<?php echo base_url() ?>index.php/setting/sapmapping"><i class="icon-angle-right"></i> SAK Ke SAP Mapping</a></li>
                                            <li class="divider"></li>
                                            <li><a href="<?php echo base_url() ?>index.php/setting/saldoawal"><i class="icon-angle-right"></i> Saldo Awal</a></li>
                                            <li class="divider"></li>
                                            <li><a href="<?php echo base_url() ?>index.php/setting/akunkas"><i class="icon-angle-right"></i> Akun Kas Bank</a></li>
                                            <li class="divider"></li>
                                            <li><a href="<?php echo base_url() ?>index.php/setting/aktivalancar"><i class="icon-angle-right"></i> Akun Aktiva Lancar</a></li>                                           
                                        </ul>
                                    </li>

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
                <!--
                <div class="media user-media hidden-phone">
                    <a href="" class="user-link">
                        <img src="assets/img/user.gif" alt="" class="media-object img-polaroid user-img">
                        <span class="label user-label">16</span>
                    </a>

                    <div class="media-body hidden-tablet">
                        <h5 class="media-heading">Archie</h5>
                        <ul class="unstyled user-info">
                            <li><a href="">Administrator</a></li>
                            <li>Last Access : <br/>
                                <small><i class="icon-calendar"></i> 16 Mar 16:32</small>
                            </li>
                        </ul>
                    </div>
                </div>
                -->
                <!-- /.user-media -->

                <!-- BEGIN MAIN NAVIGATION -->
                <!-- END MAIN NAVIGATION -->

            </div>
            <!-- END LEFT -->            


<!--modal laporan-->
