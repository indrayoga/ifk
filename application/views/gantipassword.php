            <form class="form-horizontal" action="<?php echo base_url() ?>index.php/rumahsakit/gantipassword" method="post" >
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
                                            <h5>Ganti password</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                 	<li><button class="btn" type="submit"> <i class="icon-save icon-share-alt"></i> Ganti Password</button></li>
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
                                                <input type="hidden" name="id_user" id="id_user" value="<?php echo $this->session->userdata('id_user'); ?>">
                                                <div class="control-group">
                                                    <label for="username" class="control-label">Username</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" id="username" name="username" class="span3 input-tooltip" data-original-title="" data-placement="bottom" value="<?php echo $this->session->userdata('username'); ?>"/>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="password" class="control-label">Password</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="password" id="password" name="password" class="span3 input-tooltip" data-original-title="" data-placement="bottom" value=""/>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--END TEXT INPUT FIELD-->                            

                            <hr>
                        </div>
                        <!-- /.inner -->
                    </div>
                    <!-- /.row-fluid -->
                </div>
                <!-- /.outer -->
            </div>
            <!-- /#content -->
            </form>

<script type="text/javascript">
    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });

</script>