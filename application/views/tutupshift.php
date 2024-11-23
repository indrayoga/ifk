            <form class="form-horizontal" action="<?php echo base_url() ?>index.php/rumahsakit/updateshift" method="post" >
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
                                            <h5>Tutup Shift</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                 	<li><button class="btn" type="submit"> <i class="icon-save icon-share-alt"></i> Update Shift</button></li>
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
                                        <?php 
                                            $queryunitshift=$this->db->query('select * from unit_shift where kd_unit="RWJ"'); 
                                            $unitshift=$queryunitshift->row_array();
                                            if($unitshift['shift']==$unitshift['jml_shift']){
                                                $shiftselanjutnya=1;
                                            }else{
                                                $shiftselanjutnya=$unitshift['shift']+1;
                                            }
                                        ?>                                        
                                        <div id="div-1" class="accordion-body collapse in body">
                                                <input type="hidden" name="unit" id="unit" value="<?php echo $unit; ?>">
                                                <div class="control-group">
                                                    <label for="shiftselanjutnya" class="control-label">Shift Selanjutnya</label>
                                                    <div class="controls with-tooltip">
                                                        <input type="text" id="shiftselanjutnya" name="" disabled class="span3 input-tooltip" data-original-title="" data-placement="bottom" value="<?php echo $shiftselanjutnya ?>"/>
                                                        <input type="hidden" id="shiftselanjutnya" name="shiftselanjutnya" class="span3 input-tooltip" data-original-title="" data-placement="bottom" value="<?php echo $shiftselanjutnya ?>"/>
                                                        <input type="text" id="jamupdate" name="jamupdate" disabled class="span3 input-tooltip" data-original-title="" data-placement="bottom" value="<?php echo date('d-m-Y h:i:s') ?>"/>
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