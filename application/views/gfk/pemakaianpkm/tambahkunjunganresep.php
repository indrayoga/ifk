<?php 

    session_start();


?>

<style>
#feedback { font-size: 1.4em; }
#listobat .ui-selecting, #listobat .ui-selecting { background: #FECA40; }
#listobat .ui-selected, #listobat .ui-selected { background: #F39814; color: white; }
#listobat, #listobat { list-style-type: none; margin: 0; padding: 0; width: 60%; }
#listobat li, #listobat li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px; }
#listobat6 .ui-selecting, #listobat6 .ui-selecting { background: #FECA40; }
#listobat6 .ui-selected, #listobat6 .ui-selected { background: #F39814; color: white; }
#listobat6, #listobat6 { list-style-type: none; margin: 0; padding: 0; width: 60%; }
#listobat6 li, #listobat6 li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px; }

#listdokter .ui-selecting, #listdokter .ui-selecting { background: #FECA40; }
#listdokter .ui-selected, #listdokter .ui-selected { background: #F39814; color: white; }
#listdokter { list-style-type: none; margin: 0; padding: 0; width: 60%; }
#listdokter li, #listdokter li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px; }
</style>
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
<script>
$(function() {
    $( "#listobat" ).selectable({});
    $( "#listobat6" ).selectable({});
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
    Mousetrap.bindGlobal('f6', function() { 
window.open(
  '<?php echo base_url() ?>index.php/gfk/pemakaianpkm/tambahkunjunganresep',
  '_newtab' // <- This is what makes it open in a new window.
);

    });
    
    Mousetrap.bindGlobal('f10', function() { 
        window.location.href='<?php echo base_url() ?>index.php/gfk/pemakaianpkm/tambahkunjunganresep'
        return false;
    });
    
    Mousetrap.bindGlobal('ctrl+b', function() { 
        $('#tambahbaris').trigger('click');
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
    //Mousetrap.bind('esc', function(e) { $('#tesxx').hide(); });
    //Mousetrap.bind('tab', function(e) { if($('#tesxx').is(':visible')){ $('#tesxx').hide(); } return false; });

    Mousetrap.bindGlobal(['esc','tab'], function() {

        $('#tesxx').hide();
        $( ".barisnamaobat" ).blur();
        setTimeout(function(){
            $( ".barisnamaobat" ).focus();
        }, 500);
    });

    Mousetrap.bindGlobal(['down','right'], function() {

        /* if($('#daftarobat').is(':visible')){    
            if($("#listobat .ui-selected").next().is('tr')){
                $('#modal-body-daftarobat').scrollTop($('#modal-body-daftarobat').scrollTop()+45);
                SelectSelectableElement($("#listobat"), $(".ui-selected").next('tr'));
            }else{
                return false;
            }
        }
 */
        if($('#tesxx').is(':visible')){    
            if($("#listobat6 .ui-selected").next().is('tr')){
               
                SelectSelectableElement($("#listobat6"), $(".ui-selected").next('tr'));
                $('.barisnamaobat').trigger('blur');
            }else{
                return false;
            }
        }       
        
      
        
    });
    
    Mousetrap.bindGlobal(['up','left'], function() {
        /* if($('#daftarobat').is(':visible')){ 
            if($("#listobat .ui-selected").prev().is('tr')){
                $('#modal-body-daftarobat').scrollTop($('#modal-body-daftarobat').scrollTop()-45);
                SelectSelectableElement($("#listobat"), $(".ui-selected").prev('tr'));
            }else{
                return false;
            }
        } */

        if($('#tesxx').is(':visible')){    
            if($("#listobat6 .ui-selected").prev().is('tr')){
                SelectSelectableElement($("#listobat6"), $(".ui-selected").prev('tr'));
                $('.barisnamaobat').trigger('blur');
            }else{
                return false;
            }
        }       

        
        

    });
    
    Mousetrap.bindGlobal('enter', function(e) { 

        if($('#tesxx').is(':visible')){
            $('#tesxx').find('.ui-selected').find('.btn').trigger('click');
            return false;
        }
      
        return false;
       // alert('x');
        //return false;
    });
        
    Mousetrap.bindGlobal('f12', function() { 
        $('#simpan').trigger('click');
        return false;
    });
    
</script> 
<script type="text/javascript">
    
    $(document).ready(function() {
        

        $('#form').ajaxForm({
            beforeSubmit: function(a,f,o) {
                o.dataType = "json";
                $('div.error').removeClass('error');
                $('span.help-inline').html('');
                $('#progress').show();
                $('body').append('<div id="overlay1" style="position: fixed;height: 100%;width: 100%;z-index: 1000000;"></div>');
                $('body').addClass('body1');
                var urlnya="<?php echo base_url(); ?>index.php/gfk/pemakaianpkm/periksapemakaianpkm"; //buat validasi inputan
                z=true;
                $.ajax({
                url: urlnya,
                type:"POST",
                async: false,
                data: $.param(a),
                success: function(data){
                    //alert(data.status);
                    if(parseInt(data.status)==1){
                        z=data.status;
                        //alert('aa');
                        //alert($('input[name="harga"]').val());
                    }else if(parseInt(data.status)==0){
                     //   alert('xxx');
                        $('#progress').hide();
                        z=data.status;
                        for(yangerror=0;yangerror<=data.error;yangerror++){
                            $('#'+data.id[yangerror]).siblings('.help-inline').html('<p class="text-error">'+data.pesan[yangerror]+'</p>');
                            $('#'+data.id[yangerror]).parents('row-fluid').focus();
                            //$('#error').html('<div class="alert alert-error fade in"><button data-dismiss="alert" class="close" type="button"><i class="iconic-x"></i></button>Terdapat beberapa kesalahan input silahkan cek inputan anda</div>');                                 
                        }
                        $('#error').html('<div class="alert alert-error fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>'+data.pesanatas+'<br/>'+data.pesanlain+'</div>');

                        if(parseInt(data.clearform)==1){
                            //$('#form').resetForm();
                            $('input').live('keydown', function(e) {
                                if(e.keyCode == 13){
                                    return false;                                    
                                }
                            });

                            $('#form .cleared').clearFields();
                        }
                        $('#overlay1').remove();
                        $('body').removeClass('body1');
                    }
                },
                dataType: 'json'
                });

                if(z==0)return false;
            },
            dataType:  'json',
            success: function(data) {
            //alert(data);
            if (typeof data == 'object' && data.nodeType)
            data = elementToString(data.documentElement, true);
            else if (typeof data == 'object')
            //data = objToString(data);
                if(parseInt(data.status)==1) //jika berhasil
                {
                    //apa yang terjadi jika berhasil
                    $('#progress').hide();
                    $('#overlay1').remove();
                    $('body').removeClass('body1');
                    $('#error').show();
                    $('#error').html('<div class="alert alert-success fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>'+data.pesan+'</div>');

                        window.location.href='<?php echo base_url(); ?>index.php/gfk/pemakaianpkm/ubahkunjunganresep/'+data.id;
                   
                }
                else if(parseInt(data.status)==0) //jika gagal
                {
                    //apa yang terjadi jika gagal
                    $('#progress').hide();
                    $('#overlay1').remove();
                    $('body').removeClass('body1');
                    $('#error').show();
                    $('#error').html('<div class="alert alert-success fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>'+data.pesan+'</div>');
                }

            }
        });       

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
            <!--BEGIN INPUT TEXT FIELDS-->
            <form class="form-horizontal"  id="form" method="POST" action="<?php echo base_url() ?>index.php/gfk/pemakaianpkm/simpankunjunganresep">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <header class="top" style="">
                                <div class="icons"><i class="icon-edit"></i></div>
                                <h5>KUNJUNGAN RESEP PUSKESMAS </h5>
                                <!-- .toolbar -->
                                <div class="toolbar" style="height:auto;">
                                    <ul class="nav nav-tabs">
                                        <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/gfk/pemakaianpkm/kunjunganresep"> <i class="icon-list"></i> Daftar </a></li>
                                        <li><button class="btn" id="simpan" type="submit"  name="submit" value="simpan"> <i class="icon-save"></i> Simpan / F12</button></li>
                                        <li><a  class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/gfk/pemakaianpkm/tambahkunjunganresep"> <i class="icon-plus"></i> Tambah / (F6)</a></li>
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
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="tgl_penjualan" class="control-label">Periode </label>
                                                <div class="controls with-tooltip">
                                                    <input type="HIDDEN" name="id" id="id" value="<?php if(isset($item['id'])) echo $item['id']; ?>" class="input-small">
                                                    <select name="bulan" id="bulan" class="input-medium">
                                                        <option value="01" <?php if(isset($item['bulan']) && $item['bulan']=='01') echo "selected=selected"; ?>>Januari</option>
                                                        <option value="02" <?php if(isset($item['bulan']) && $item['bulan']=='02') echo "selected=selected"; ?>>Februari</option>
                                                        <option value="03" <?php if(isset($item['bulan']) && $item['bulan']=='03') echo "selected=selected"; ?>>Maret</option>
                                                        <option value="04" <?php if(isset($item['bulan']) && $item['bulan']=='04') echo "selected=selected"; ?>>April</option>
                                                        <option value="05" <?php if(isset($item['bulan']) && $item['bulan']=='05') echo "selected=selected"; ?>>Mei</option>
                                                        <option value="06" <?php if(isset($item['bulan']) && $item['bulan']=='06') echo "selected=selected"; ?>>Juni</option>
                                                        <option value="07" <?php if(isset($item['bulan']) && $item['bulan']=='07') echo "selected=selected"; ?>>Juli</option>
                                                        <option value="08" <?php if(isset($item['bulan']) && $item['bulan']=='08') echo "selected=selected"; ?>>Agustus</option>
                                                        <option value="09" <?php if(isset($item['bulan']) && $item['bulan']=='09') echo "selected=selected"; ?>>September</option>
                                                        <option value="10" <?php if(isset($item['bulan']) && $item['bulan']=='10') echo "selected=selected"; ?>>Oktober</option>
                                                        <option value="11" <?php if(isset($item['bulan']) && $item['bulan']=='11') echo "selected=selected"; ?>>November</option>
                                                        <option value="12" <?php if(isset($item['bulan']) && $item['bulan']=='12') echo "selected=selected"; ?>>Desember</option>
                                                    </select>
                                                    Tahun
                                                    <input type="text" maxlength="4" name="tahun" value="<?php if(isset($item['tahun'])) echo $item['tahun']; ?>" id="tahun" required class="input-small">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="id_puskesmas" class="control-label">Puskesmas </label>
                                                <div class="controls with-tooltip">
                                                    <select id="id_puskesmas" name="id_puskesmas">
                                                        <?php
                                                        foreach ($datapuskesmas as $puskesmas) {
                                                            # code...
                                                            $selected = false;
                                                            if($item['id_puskesmas'] == $puskesmas['id']) {
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
                                        </div>
                                    </div>
                                </div>                                
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="kunjungan_umum" class="control-label">Jumlah Kunjungan Pasien Umum </label>
                                                <div class="controls with-tooltip">
                                                    <input type="text" name="kunjungan_umum" id="kunjungan_umum" value="<?php if(isset($item['kunjungan_umum'])) echo $item['kunjungan_umum']; ?>" class="input-small">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="kunjungan_lansia_kader" class="control-label">Jumlah Kunjungan Pasien Lansia Kader </label>
                                                <div class="controls with-tooltip">
                                                    <input type="text" name="kunjungan_lansia_kader" id="kunjungan_lansia_kader" value="<?php if(isset($item['kunjungan_lansia_kader'])) echo $item['kunjungan_lansia_kader']; ?>" class="input-small">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="kunjungan_gakin" class="control-label">Jumlah Kunjungan Pasien Gakin </label>
                                                <div class="controls with-tooltip">
                                                    <input type="text" name="kunjungan_gakin" id="kunjungan_gakin" value="<?php if(isset($item['kunjungan_gakin'])) echo $item['kunjungan_gakin']; ?>" class="input-small">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="kunjungan_bpjs" class="control-label">Jumlah Kunjungan Pasien BPJS </label>
                                                <div class="controls with-tooltip">
                                                    <input type="text" name="kunjungan_bpjs" id="kunjungan_bpjs" value="<?php if(isset($item['kunjungan_bpjs'])) echo $item['kunjungan_bpjs']; ?>" class="input-small">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="kunjungan_lembar_umum" class="control-label">Jumlah Kunjungan Resep (Lembar) Umum </label>
                                                <div class="controls with-tooltip">
                                                    <input type="text" name="kunjungan_lembar_umum" id="kunjungan_lembar_umum" value="<?php if(isset($item['kunjungan_lembar_umum'])) echo $item['kunjungan_lembar_umum']; ?>" class="input-small">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="kunjungan_lembar_lansia_kader" class="control-label">Jumlah Kunjungan Resep (Lembar) Lansia Kader </label>
                                                <div class="controls with-tooltip">
                                                    <input type="text" name="kunjungan_lembar_lansia_kader" id="kunjungan_lembar_lansia_kader"  value="<?php if(isset($item['kunjungan_lembar_lansia_kader'])) echo $item['kunjungan_lembar_lansia_kader']; ?>" class="input-small">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="kunjungan_lembar_gakin" class="control-label">Jumlah Kunjungan Resep (Lembar) Gakin </label>
                                                <div class="controls with-tooltip">
                                                    <input type="text" name="kunjungan_lembar_gakin" id="kunjungan_lembar_gakin"  value="<?php if(isset($item['kunjungan_lembar_gakin'])) echo $item['kunjungan_lembar_gakin']; ?>" class="input-small">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="kunjungan_lembar_bpjs" class="control-label">Jumlah Kunjungan Resep (Lembar) BPJS </label>
                                                <div class="controls with-tooltip">
                                                    <input type="text" name="kunjungan_lembar_bpjs" id="kunjungan_lembar_bpjs"  value="<?php if(isset($item['kunjungan_lembar_bpjs'])) echo $item['kunjungan_lembar_bpjs']; ?>" class="input-small">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="jumlah_resep" class="control-label">Jumlah Resep </label>
                                                <div class="controls with-tooltip">
                                                    <input type="text" name="jumlah_resep" id="jumlah_resep" value="<?php if(isset($item['jumlah_resep'])) echo $item['jumlah_resep']; ?>" class="input-small">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="jumlah_ab" class="control-label">Jumlah AB </label>
                                                <div class="controls with-tooltip">
                                                    <input type="text" name="jumlah_ab" id="jumlah_ab" value="<?php if(isset($item['jumlah_ab'])) echo $item['jumlah_ab']; ?>" class="input-small">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="jumlah" class="control-label">Jumlah </label>
                                                <div class="controls with-tooltip">
                                                    <input type="text" name="jumlah" id="jumlah" value="<?php if(isset($item['jumlah'])) echo $item['jumlah']; ?>" class="input-small">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="resep_lembar" class="control-label">Resep Yang Tidak Terlayani (Jml Lembar) </label>
                                                <div class="controls with-tooltip">
                                                    <input type="text" name="resep_lembar" id="resep_lembar" value="<?php if(isset($item['resep_lembar'])) echo $item['resep_lembar']; ?>" class="input-small">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="resep_resep" class="control-label">Resep Yang Tidak Terlayani (R/) </label>
                                                <div class="controls with-tooltip">
                                                    <input type="text" name="resep_resep" id="resep_resep" value="<?php if(isset($item['resep_resep'])) echo $item['resep_resep']; ?>" class="input-small">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="resep_ab" class="control-label">Resep Yang Tidak Terlayani (R/AB) </label>
                                                <div class="controls with-tooltip">
                                                    <input type="text" name="resep_ab" id="resep_ab" value="<?php if(isset($item['resep_ab'])) echo $item['resep_ab']; ?>" class="input-small">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="jumlah_semua" class="control-label">Jumlah Resep </label>
                                                <div class="controls with-tooltip">
                                                    <input type="text" name="jumlah_semua" id="jumlah_semua" value="<?php if(isset($item['jumlah_semua'])) echo $item['jumlah_semua']; ?>" class="input-small">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        
                            <br/>
                            <br/>
                            <br/>
                        <!--/div-->                        
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
<div style="display:none;position: absolute !important;right: 0;bottom: 0 !important;z-index:99999999999 !important;" id="tesxx" class=" ui-widget-content draggable">
            <table id="dataTable6" class="table table-bordered " style="background:white !important;">
                <thead>
                    <tr>                        
                        <th style="text-align:center;">Kode Obat</th>
                        <th style="text-align:center;">Nama Obat</th>
                        <th style="text-align:center;">Satuan</th>
                        <th style="width:50px !important;">Pilihan</th>
                    </tr>
                </thead>
                <tbody id="listobat6">
                </tbody>
            </table>
</div>
      
<script type="text/javascript">

    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });
            
     $('#tgl_penjualan').datepicker({
        format: 'dd-mm-yyyy'
    });

    function pilihobat(kd_obat,nama_obat,satuan_kecil) {
        var batal=0;
        var tgl_penjualan = $('#tgl_penjualan').val();
        $('.focused').find('.bariskodeobat').val(kd_obat);
        $('.focused').find('.barisnamaobat').val(nama_obat);
        $('.focused').find('.barissatuan').val(satuan_kecil);
        $('#tesxx').hide();
        $('.focused').find('input[name="satuan_kecil[]"]').focus();
        $('#tesxx').hide();
        return false;
    }
    

    $(function() {
        $( "#tesxx" ).draggable();
    });
    
    
    $(function() {
 
});

        $('#tesxx').keyup(function(e){
            $('#tesxx').show();
        })

    
    $('#tambahbaris').click(function(){
        $('#bodyinput').append(
            '<tr class="focused">'+ 
                '<td style="text-align:center; width: 11px"><input type="checkbox" class="barisinput cleared" /></td>'+
                '<td><input type="text" name="kd_obat[]"  value="" class="input-medium bariskodeobat cleared"></td>'+
                '<td><input type="text" name="nama_obat[]"  value="" autocomplete="off" style="width:300px !important;" class="input-large barisnamaobat cleared"></td>'+
                '<td><input type="text" name="satuan_kecil[]" value="" style="text-align:center;" class="input-small barissatuan cleared" readonly></td>'+
                '<td><input type="text" name="qty[]"  value="" style="text-align:right;" class="input-small barisqty cleared"></td>'+
            '</tr>');
        
        //$("#bodyinput tr:last input[name='nama_obat[]']").trigger('keydown');
            //var e = jQuery.Event("keyup");
            //e.which = 16; // # Some key code value
        //      $("#bodyinput tr:last input[name='nama_obat[]']").select();
        //  $("#bodyinput tr:last input[name='nama_obat[]']").trigger(e);
//
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

        
        $('.barisqty').change(function(){  
            
        });

        $('.barisqty').keyup(function(e){
            if(e.keyCode == 13){
                //alert('disni');
                 $('#tambahbaris').trigger('click');
            }

        });
        
        $('.barisqty, .barisnamaobat, .bariskodeobat').click(function(){  
                $('#bodyinput tr').removeClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty
                $(this).parent().parent('tr').addClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty
        }); 
              
        $('.barisnamaobat').keyup(function(e){
            if(e.keyCode == 13){
                $('.focused').find('.barissatuan').focus();
                return false;
            }
        });

        $('.barissatuan').keyup(function(e){
            if(e.keyCode == 13){
                $('.focused').find('.barisqty').focus();
                return false;
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
                    "sAjaxSource": "<?php echo base_url() ?>index.php/gfk/pemakaianpkm/ambildaftarobatbynama/",
                    "sServerMethod": "POST",
                    "fnServerParams": function ( aoData ) {
                      aoData.push( { "name": "nama_obat", "value":""+$('.focused').find('.barisnamaobat').val()+""} );
                      aoData.push( { "name": "kd_unit_apt", "value":""+$('#kd_unit_apt').val()+""} );
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


        $('.baristglkeluar').datepicker({
            format: 'dd-mm-yyyy'
        });
    }); //akhir function tambah baris
    
    $('#hapusbaris').click(function(){
         $('.barisinput:checked').parents('tr').remove();
    });
    
    
    $('input').live('keydown', function(e) {
            if(e.keyCode == 13){
                return false;                                    
            }
        });
    
    $(window).bind('scroll', function() {
        var p = $(window).scrollTop();
        var offset = $(window).offset();
        if(parseInt(p)>1){            
            $('.top').addClass('fixed');
        }else{
            $('.top').removeClass('fixed');
        }
        //if ($(window).scrollTop() + $(window).height() >= $('.top').height()) {
        //  $('.top').addClass('fixed');
        //}
    });

    
    $('.barisqty').keyup(function(e){ 
            if(e.keyCode == 13){ //klo enter di baris jumlah
                $('#tambahbaris').trigger('click');
                return false;
            }
        });
        
    $('.barisqty').change(function(){  
    });
    
        
    $('.barisqty,  .barisnamaobat, .bariskodeobat').click(function(){  
        $('#bodyinput tr').removeClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty
        $(this).parent().parent('tr').addClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty
    }); 
    
    
    $('.barisnamaobat').keyup(function(e){
            $('.barisnamaobat').parent().parent('tr').removeClass('focused');
            $(this).parent().parent('tr').addClass('focused');

            $("#dataTable6").dataTable().fnDestroy();
            $('#dataTable6').dataTable( {
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo base_url() ?>index.php/gfk/pemakaianpkm/ambildaftarobatbynama/",
                "sServerMethod": "POST",
                "fnServerParams": function ( aoData ) {
                  aoData.push( { "name": "nama_obat", "value":""+$('.focused').find('.barisnamaobat').val()+""} );
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
        
    $('input[type="text"]').keydown(function(e){
        //get the next index of text input element
        var next_idx = $('input[type="text"]').index(this) + 1;
         
        //get number of text input element in a html document
        var tot_idx = $('body').find('input[type="text"]').length;
     
        //enter button in ASCII code
        if(e.keyCode == 13){
            //go to the next text input element
            if($(this).parent()[0]['nodeName']=='TD'){
                return false;
            }
            //$('input[type=text]:eq(' + next_idx + ')').focus();
            //$(this).next().focus();
            return false;


        }

    });
    
    var opts = {
      lines: 9, // The number of lines to draw
      length: 40, // The length of each line
      width: 9, // The line thickness
      radius: 0, // The radius of the inner circle
      corners: 1, // Corner roundness (0..1)
      rotate: 0, // The rotation offset
      direction: 1, // 1: clockwise, -1: counterclockwise
      color: '#000', // #rgb or #rrggbb
      speed: 1.4, // Rounds per second
      trail: 54, // Afterglow percentage
      shadow: false, // Whether to render a shadow
      hwaccel: false, // Whether to use hardware acceleration
      className: 'spinner', // The CSS class to assign to the spinner
      zIndex: 2e9, // The z-index (defaults to 2000000000)
      top: 'auto', // Top position relative to parent in px
      left: '470px' // Left position relative to parent in px
    };
    var target = document.getElementById('progress');
    var spinner = new Spinner(opts).spin(target);   

$(document).ready(function() {
    $("#daftarobat").on("show", function () {
      $("body").addClass("modal-open");

    }).on("hidden", function () {
        if($('#daftarobat').is(':visible')){
            $("body").addClass("modal-open");
        }else{
            $("body").removeClass("modal-open");
        }
    });

 }); 


$(function(){
$('input,select').bind('keyup', function(eInner) {
if (eInner.keyCode == 13)
{
var el = null; // element to jump to
// if we have a tabindex, just jump to the next tabindex
var tabindex = $(this).attr('tabindex');
if (tabindex) {
tabindex ++;
if ($('[tabindex=' + tabindex + ']')) {
el = $('[tabindex=' + tabindex + ']');  
}
}
if (el == null) { // just take the next one
var i = $(":input").index(this)*1;
i++;
el = $(":input:eq(" + i + ")");
if (!el) el = null;
}
if (el == null || el.attr('type') == "submit") {
return true;    
}
 
if (el != null) {
el.focus(); 
}
return false;
}
}); 
 
});
</script>


