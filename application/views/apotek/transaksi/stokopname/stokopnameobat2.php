<style type="text/css">
.fixed {
    position:fixed;
    top:0px !important;
    z-index:100;
    width: 1024px;    
}
.body1{
    opacity: 0.4;
    background-color: #000000;
}
body.modal-open {
    overflow: hidden;
}

</style>
<style>
#feedback { font-size: 1.4em; }
#listobat .ui-selecting, #listobat .ui-selecting { background: #FECA40; }
#listobat .ui-selected, #listobat .ui-selected { background: #F39814; color: white; }
#listobat, #listobat { list-style-type: none; margin: 0; padding: 0; width: 60%; }
#listobat li, #listobat li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px; }
</style>
<script>
$(function() {
    $( "#listobat" ).selectable({});
});

function SelectSelectableElement (selectableContainer, elementsToSelect)
{
    // add unselecting class to all elements in the styleboard canvas except the ones to select
    $(".ui-selected", selectableContainer).not(elementsToSelect).removeClass("ui-selected").addClass("ui-unselecting");
    
    // add ui-selecting class to the elements to select
    $(elementsToSelect).not(".ui-selected").addClass("ui-selected");

    // trigger the mouse stop event (this will select all .ui-selecting elements, and deselect all .ui-unselecting elements)
    selectableContainer.selectable('refresh');
    //selectableContainer.data("selectable")._mouseStop(null);
    //return false;
}
</script>
<script src="<?php echo base_url(); ?>assets/js/mousetrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/mousetrap-global-bind.min.js"></script> 

<script type="text/javascript">
    Mousetrap.bindGlobal('ctrl+r', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/tambahpenerimaanapt'; return false;});
    Mousetrap.bindGlobal('f7', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/aptpenerimaan'; return false;});
    
    Mousetrap.bindGlobal('ctrl+s', function() { 
        $('#simpan').trigger('click');
        return false;
    });

    Mousetrap.bind('a', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'a'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('b', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'b'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('c', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'c'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('d', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'d'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('e', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'e'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('f', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'f'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('g', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'g'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('h', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'h'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('i', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'i'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('j', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'j'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('k', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'k'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('l', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'l'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('m', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'m'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('n', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'n'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('o', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'o'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('p', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'p'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('q', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'q'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('r', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'r'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('s', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'s'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('t', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'t'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('u', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'u'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('v', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'v'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('w', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'w'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('x', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'x'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('y', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'y'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('z', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+'z'); $('.focused .barisnamaobat').focus(); } return false; });
    Mousetrap.bind('space', function(e) { if($('#tesxx').is(':visible')){ $('.focused .barisnamaobat').val($('.focused .barisnamaobat').val()+' '); $('.focused .barisnamaobat').focus(); } return false; });
    
    
    Mousetrap.bindGlobal(['down','right'], function() {

        /* if($('#daftarobat').is(':visible')){    
            if($("#listobat .ui-selected").next().is('tr')){
                $('#modal-body-daftarobat').scrollTop($('#modal-body-daftarobat').scrollTop()+45);
                SelectSelectableElement($("#listobat"), $(".ui-selected").next('tr'));
            }else{
                return false;
            }
        } */
        if($('#tesxx').is(':visible')){    
            if($("#listobat .ui-selected").next().is('tr')){
               
                SelectSelectableElement($("#listobat"), $(".ui-selected").next('tr'));
                $('.barisnamaobat').trigger('blur');
            }else{
                return false;
            }
        }       
    });
    
    Mousetrap.bindGlobal(['up','left'], function() {
      

      /*   if($('#daftarobat').is(':visible')){ 
            if($("#listobat .ui-selected").prev().is('tr')){
                $('#modal-body-daftarobat').scrollTop($('#modal-body-daftarobat').scrollTop()-45);
                SelectSelectableElement($("#listobat"), $(".ui-selected").prev('tr'));
            }else{
                return false;
            }
        } */
        if($('#tesxx').is(':visible')){    
            if($("#listobat .ui-selected").prev().is('tr')){
                SelectSelectableElement($("#listobat"), $(".ui-selected").prev('tr'));
                $('.barisnamaobat').trigger('blur');
            }else{
                return false;
            }
        }       
        
    });
    
    Mousetrap.bindGlobal('enter', function(e) { 

        if($('#daftarobat').is(':visible')){
            $('.ui-selected').find('.btn').trigger('click');
            return false;
        }
        if($('#tesxx').is(':visible')){
            //setTimeout(continueExecution, 10000);
            $('#tesxx').find('.ui-selected').find('.btn').trigger('click');
            //alert('xx');
            return false;
        }
        return false;
    });
    
    Mousetrap.bindGlobal('ctrl+b', function() { 
        $('#tambahbaris').trigger('click');
        return false;
    });
    
    Mousetrap.bindGlobal('ctrl+l', function() { 
        $('#pencarian').modal("show");
        return false;
    });
    
    Mousetrap.bindGlobal('ctrl+d', function() { 
        $.ajax({
            url: '<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/ambilsupplierbynama/',
            async:false,
            type:'get',
            data:{query:$("#nama").val()},
            success:function(data){
            //typeahead.process(data)
                $('#listsupplier').empty();
                $.each(data,function(i,l){
                    //alert(l);
                    $('#listsupplier').append('<tr><td>'+l.kd_supplier+'</td><td>'+l.nama+'</td><td>'+l.alamat+'</td><td><a class="btn" onclick=\'pilihsupplier("'+l.kd_supplier+'","'+l.nama+'")\'>Pilih</a></td></tr>');
                }); 
            },
            dataType:'json'                         
        });
        $('#daftarsupplier').modal("show");
        var ex = document.getElementById('dataTable5');
        if ( ! $.fn.DataTable.fnIsDataTable( ex ) ) {
            $('#dataTable5').dataTable({
                "sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "Show _MENU_ entries"
                }
            });
            var oTable = $('#dataTable5').dataTable();
            $('#nama1').keyup(function(e){
                oTable.fnFilter( $(this).val() );
                if(e.keyCode == 13){
                    //alert('xx')
                    return false;
                }
            });
        };
        return false;
    });
    
    Mousetrap.bindGlobal('ctrl+p', function() { 
        $.ajax({
            url: '<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/ambilpemesananbykode/',
            async:false,
            type:'get',
            data:{query:$("#isipesan").val(),tes:$('#kd_supplier').val()},
            success:function(data){
            //typeahead.process(data)
                $('#listpesan').empty();
                $.each(data,function(i,l){
                    //alert(l);
                    $('#listpesan').append('<tr><td><input type="checkbox" class="ceklis" name="ceklis" value="'+l.no_pemesanan+'"/></td><td style="text-align:center;">'+l.no_pemesanan+'</td><td style="text-align:center;">'+l.tgl_pemesanan+'</td><td>'+l.nama+'</td></tr>');
                }); 
            },
            dataType:'json'                         
        });
        $('#daftarpesan').modal("show");
        var ex = document.getElementById('dataTable3');
        if ( ! $.fn.DataTable.fnIsDataTable( ex ) ) {
            $('#dataTable3').dataTable({
                "sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "Show _MENU_ entries"
                }
            });
            var oTable = $('#dataTable3').dataTable();
            $('#isipesan1').keyup(function(e){
                oTable.fnFilter( $(this).val() );
                if(e.keyCode == 13){
                    //alert('xx')
                    return false;
                }
            });
        };
        return false;
    });    
</script>
<style type="text/css">.datepicker{z-index:1151;}</style>
<div id="error"></div>
<div id="overlay"></div>
<!-- #content -->
<div id="content">
    <!-- .outer -->
    <div class="container-fluid outer">
        <div class="row-fluid">
            <!-- .inner -->
            <div class="span12 inner">
                <!-- BEGIN FORM -->
                <form class="form-horizontal" id="form" method="POST" 
                    action="<?php echo base_url() ?>index.php/transapotek/stokopname/simpanstokopname2">
                    <div class="row-fluid"><!-- upper form -->
                        <div class="span12">
                            <div class="box">
                                <header class="top">
                                    <div class="icons"><i class="icon-edit"></i></div>
                                    <h5>STOKOPNAME OBAT</h5>
                                    <div class="toolbar" style="height:auto;"><!-- toolbar -->
                                        <ul class="nav nav-tabs">
                                            <li><button class="btn" id="simpan" type="submit"  name="submit" value="simpan">
                                                <i class="icon-save"></i> Simpan / (Ctrl+S)</button>
                                            </li>
                                            <li>
                                                <a class="accordion-toggle minimize-box" data-toggle="collapse" href="#div-1">
                                                    <i class="icon-chevron-up"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div> <!-- end toolbar -->
                                </header> <!-- end header -->
                                <div id="div-1" class="accordion-body collapse in body">
                                    <div class="row-fluid">                                             
                                        <div class="span12">
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label for="kd_unit_apt" class="control-label">Unit Apotek</label>
                                                    <div class="controls with-tooltip">
                                                    <select  class="input-xlarge cleared" name="kd_unit_apt" id="kd_unit_apt">
                                                        <option value="">Semua Unit</option>
                                                        <?php
                                                            foreach ($sumberdana as $sd) {
                                                                $select="";
                                                                if(isset($kd_unit_apt)){
                                                                    if($kd_unit_apt==$sd['kd_unit_apt'])$select="selected=selected";else $select="";
                                                                }
                                                                
                                                        ?>
                                                                <option value="<?php if(!empty($sd)) echo $sd['kd_unit_apt'] ?>" <?php echo $select; ?>><?php echo $sd['nama_unit_apt'] ?></option>
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
                            </div>
                        </div>
                    </div> <!-- end upper form -->
                    <div class="row-fluid"><!-- begin table -->
                        <div class="span12">
                            <div class="box error">
                                <header>
                                    <div class="toolbar" style="height:auto;float:left;">
                                        <ul class="nav nav-tabs">
                                            <li><button class="btn" type="button" id="tambahbaris"> <i class="icon-plus"></i> Tambah Obat (Ctrl+B)</button></li>
                                            <li><button class="btn" type="button" id="hapusbaris"> <i class="icon-remove"></i> Hapus Obat</button></li>
                                        </ul>
                                    </div>
                                </header>
                                <div class="body collapse in" id="defaultTable">
                                    <table class="table responsive">
                                        <thead>
                                            <tr style="font-size:80% !important; width: 100%">
                                                <th class="header" style="width:11px;"></th>
                                                <th class="header span1" style="text-align:center; width: 110px !important;">Kode Obat</th>
                                                <th class="header span2" style="text-align:center; width: 250px !important;">Nama Obat</th>
                                                <th class="header span1" style="text-align:center;">Unit</th>
                                                <th class="header span1" style="text-align:center;">Satuan</th>
                                                <th class="header span1" style="text-align:center;">Harga</th>
                                                <th class="header span1" style="text-align:center;">No.Batch</th>
                                                <th class="header span1" style="text-align:center;">Tgl.Exp</th>
                                                <th class="header span1" style="text-align:center;">Jumlah</th>
                                                <th class="header span1" style="text-align:center;">Jumlah Sekarang</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyinput">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM -->
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
$(document).ready(function() {
    $('#tambahbaris').click(function(){
        $('#bodyinput').append('<tr class="focused" style="font-size:70%">'+
                                    '<td style="text-align:center; width: 11px;"><input type="checkbox" class="barisinput cleared"></td>'+
                                    '<td style="padding: 8px 4px; text-align:center; width: 110px;"><input type="text" name="kd_obat[]" value="" class="bariskodeobat" style="padding: auto 0px; width: 110px !important;"></td>'+
                                    '<td style="text-align:center;" class="span2"><input type="text" name="nama_obat[]" value="" autocomplete="off" class="input-medium barisnamaobat cleared"></td>'+
                                    '<td class="span1"><input type="text" name="satuan_kecil[]" value="" style="text-align:center;" class="input-small barissatuan cleared" readonly></td>'+
                                    '<td class="span1"><input type="text" name="harga[]" value="" style="text-align:center;" class="input-small barisharga cleared" readonly></td>'+
                                    '<td class="span1"><input type="text" name="tgl_expire[]" value="" style="text-align:center;" class="input-small baristanggal cleared" readonly ></td>'+
                                    '<td class="span1"><input type="text" name="no_batch[]" value="" style="text-align:right;" class="input-small barisnobatch cleared" readonly ></td>'+                                                                     
                                    '<td class="span1"><input type="text" name="jumlah[]"  value="" style="text-align:right;" class="input-small barisjumlah cleared"></td>'+
                                    '<td class="span1"><input type="text" name="jumlahsekarang[]"  value="" style="text-align:right;" class="input-small barisjumlahsekarang cleared"></td>'+
                                '</tr>');

        $("#bodyinput tr:last input[name='nama_obat[]']").focus();

           // if(e.keyCode == 13){
                //alert('xx')
 
            //}
            var xw=$(this);
            if(xw.val()!=""){
                $('#tesxx').show();
                
                function position() {
                    $( "#tesxx" ).position({
                        of: xw,
                        my: "left top",
                        at: "left bottom",
                        collision:"fit fit"
                        });
                }
                position();

            }

        $(function() {
            $( "#tesxx" ).draggable();
        });

        $('.barisjumlah').change(function(){ //di dlm function tambah baris
           var totalpenjualan=0;  var total1=0;
            var bhp=$('#bhp').val();
            if(bhp=='')bhp=0;
            $('.barisjumlah').each(function(){
                var val=$(this).val(); //ngambil jumlah
                if(val=='')val=0;
                    totalpenjualan=totalpenjualan+parseFloat(val); //buat totalin perbarisnya
                    total1=parseFloat(totalpenjualan);
            });
            total1=parseFloat(total1)+parseFloat(bhp);

           $('#jumlahapprove').val(total1);
           $('#totalpenjualan').val(total1.toFixed(2));
           $('#total_transaksi').val(total1.toFixed(2));
           $('#total_bayar').val(total1.toFixed(2));

        });


        
        
        $('.barisqty').change(function(){  
            
            var val=$(this).val(); var total=0;
            var harga=$('.focused').find('.barisharga').val();
            if(val=='') val=0;
            if(harga=='')harga=0;   
            total=(parseFloat(val)*parseFloat(harga));
            $('.focused').find('.barisjumlah').val(total.toFixed(2));   
            $('.barisjumlah').trigger('change');
        });

        $('.barisqty').keyup(function(e){
            if(e.keyCode == 13){
                //alert('disni');
                 $('#tambahbaris').trigger('click');
                //Mousetrap.trigger('ctrl+b');
               /*  $("html, body").animate({
                 scrollTop:$("#pembayaranform").height()+50
                 },"slow"); */            
            }

        });

        
        
        $('.barisqty, .barisracik,  .barisnamaobat, .bariskodeobat').click(function(){  
                $('#bodyinput tr').removeClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty
                $(this).parent().parent('tr').addClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty
        }); 
        

        $('.barisharga').keyup(function(e){
            if(e.keyCode == 13){
                $('.focused').find('.barisqty').focus();
                return false;
            }
        });

      
        $('.barisnamaobat').keyup(function(e){
            if(e.keyCode == 13){
                //$('.focused').find('.barisracik').focus();
                return false;
            }
        });

        
        
        

        $('.bariskodeobat').keyup(function(e){

            if(e.keyCode == 13){
                //alert('xx')
                $('.bariskodeobat').parent().parent('tr').removeClass('focused');
                $(this).parent().parent('tr').addClass('focused');

                $("#dataTable5").dataTable().fnDestroy();
                $('#dataTable5').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/penjualan/ambildaftarobatbykode/",
                    "sServerMethod": "POST",
                    "fnServerParams": function ( aoData ) {
                      aoData.push( { "name": "kd_obat", "value":""+$('.focused').find('.bariskodeobat').val()+""} );
                    }
                    
                } );
                $('#dataTable5').css('width','100%');
                $('#daftarobat').modal("show");
                    var check = function(){
                        if($('#listobat tr').length >0 && !$('#listobat tr').hasClass('ui-selected')){
                            // run when condition is met
                            $('#listobat tr:first').addClass('ui-selected');
                        }
                        else {
                            setTimeout(check, 1000); // check again in a second
                        }
                    }
                    check();     
            }
        });
        
        $('.barisnamaobat').keyup(function(e){


           // if(e.keyCode == 13){
                //alert('xx')
                $('.barisnamaobat').parent().parent('tr').removeClass('focused');
                $(this).parent().parent('tr').addClass('focused');

                $("#dataTable6").dataTable().fnDestroy();
                $('#dataTable6').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/penjualan/ambildaftarobatbynama/",
                    "sServerMethod": "POST",
                    "fnServerParams": function ( aoData ) {
                      aoData.push( { "name": "nama_obat", "value":""+$('.focused').find('.barisnamaobat').val()+""} );
                      aoData.push( { "name": "kd_unit_apt", "value":""+$('.focused').find('.bariskdunitapt').val()+""} );
                     // aoData.push( { "name": "kd_unit_apt", "value": $("#kd_unit_apt").val() } );
                    }
                    
                } );
                $('#dataTable6').css('width','100%');
                //$('#daftarobat').modal("show");
                    var check = function(){
                        if($('#listobat6 tr').length >0 && !$('#listobat6 tr').hasClass('ui-selected')){
                            // run when condition is met
                            $('#listobat6 tr:first').addClass('ui-selected');
                        }
                        else {
                            setTimeout(check, 1000); // check again in a second
                        }
                    }
                    check();     
            //}
            var xw=$(this);
            if(xw.val()!=""){
                $('#tesxx').show();
                
                function position() {
                    $( "#tesxx" ).position({
                        of: xw,
                        my: "left top",
                        at: "left bottom",
                        collision:"fit fit"
                        });
                }
                position();

            }

        });

        $('.bariskodeobat').keyup(function(e){


           // if(e.keyCode == 13){
                //alert('xx')
                $('.barisnamaobat').parent().parent('tr').removeClass('focused');
                $(this).parent().parent('tr').addClass('focused');

                $("#dataTable6").dataTable().fnDestroy();
                $('#dataTable6').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "<?php echo base_url() ?>index.php/transapotek/penjualan/ambildaftarobatbynama/",
                    "sServerMethod": "POST",
                    "fnServerParams": function ( aoData ) {
                      aoData.push( { "name": "nama_obat", "value":""+$('.focused').find('.barisnamaobat').val()+""} );
                      aoData.push( { "name": "kd_unit_apt", "value":""+$('.focused').find('.bariskdunitapt').val()+""} );
                     // aoData.push( { "name": "kd_unit_apt", "value": $("#kd_unit_apt").val() } );
                    }
                    
                } );
                $('#dataTable6').css('width','100%');
                //$('#daftarobat').modal("show");
                    var check = function(){
                        if($('#listobat6 tr').length >0 && !$('#listobat6 tr').hasClass('ui-selected')){
                            // run when condition is met
                            $('#listobat6 tr:first').addClass('ui-selected');
                        }
                        else {
                            setTimeout(check, 1000); // check again in a second
                        }
                    }
                    check();     
            //}
            var xw=$(this);
            if(xw.val()!=""){
                $('#tesxx').show();
                
                function position() {
                    $( "#tesxx" ).position({
                        of: xw,
                        my: "left top",
                        at: "left bottom",
                        collision:"fit fit"
                        });
                }
                position();

            }

        });
    });
});
</script>