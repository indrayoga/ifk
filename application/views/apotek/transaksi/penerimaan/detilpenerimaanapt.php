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
    function number_format(number, decimals, dec_point, thousands_sep) {
  //  discuss at: http://phpjs.org/functions/number_format/
  // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: davook
  // improved by: Brett Zamir (http://brett-zamir.me)
  // improved by: Brett Zamir (http://brett-zamir.me)
  // improved by: Theriault
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // bugfixed by: Michael White (http://getsprink.com)
  // bugfixed by: Benjamin Lupton
  // bugfixed by: Allan Jensen (http://www.winternet.no)
  // bugfixed by: Howard Yeend
  // bugfixed by: Diogo Resende
  // bugfixed by: Rival
  // bugfixed by: Brett Zamir (http://brett-zamir.me)
  //  revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  //  revised by: Luke Smith (http://lucassmith.name)
  //    input by: Kheang Hok Chin (http://www.distantia.ca/)
  //    input by: Jay Klehr
  //    input by: Amir Habibi (http://www.residence-mixte.com/)
  //    input by: Amirouche
  //   example 1: number_format(1234.56);
  //   returns 1: '1,235'
  //   example 2: number_format(1234.56, 2, ',', ' ');
  //   returns 2: '1 234,56'
  //   example 3: number_format(1234.5678, 2, '.', '');
  //   returns 3: '1234.57'
  //   example 4: number_format(67, 2, ',', '.');
  //   returns 4: '67,00'
  //   example 5: number_format(1000);
  //   returns 5: '1,000'
  //   example 6: number_format(67.311, 2);
  //   returns 6: '67.31'
  //   example 7: number_format(1000.55, 1);
  //   returns 7: '1,000.6'
  //   example 8: number_format(67000, 5, ',', '.');
  //   returns 8: '67.000,00000'
  //   example 9: number_format(0.9, 0);
  //   returns 9: '1'
  //  example 10: number_format('1.20', 2);
  //  returns 10: '1.20'
  //  example 11: number_format('1.20', 4);
  //  returns 11: '1.2000'
  //  example 12: number_format('1.2000', 3);
  //  returns 12: '1.200'
  //  example 13: number_format('1 000,50', 2, '.', ' ');
  //  returns 13: '100 050.00'
  //  example 14: number_format(1e-8, 8, '.', '');
  //  returns 14: '0.00000001'

  number = (number + '')
    .replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + (Math.round(n * k) / k)
        .toFixed(prec);
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
    .split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '')
    .length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1)
      .join('0');
  }
  return s.join(dec);
}

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
    Mousetrap.bindGlobal('esc', function(e) { $('#tesxx').hide(); $('.barisnamaobat').blur(); });
    Mousetrap.bind('tab', function(e) { if($('#tesxx').is(':visible')){ $('#tesxx').hide(); } return false; });
    
  
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

    Mousetrap.bindGlobal(['left'], function() {
      

      return false;
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
                var urlnya="<?php echo base_url(); ?>index.php/transapotek/aptpenerimaan/periksapenerimaan"; //buat validasi inputan
                //console.log($.param(a));
                //console.log($('#form').serialize());
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
                        //alert('xxx');
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
                    $('#no_penerimaan').val(data.no_penerimaan);
                    $('#btn-cetak').removeAttr('disabled');
                    $('#btn-cetak').attr('href','<?php echo base_url() ?>third-party/fpdf/buktipenerimaan.php?no_penerimaan='+data.no_penerimaan+'');
                    $('#btn-tutuptrans').removeAttr('disabled');
                    if(parseInt(data.keluar)>0){
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptpenerimaan';
                    }

                    if(parseInt(data.posting)==1){
                        $('#btn-tutuptrans').attr('value','bukatrans');
                        $('#btn-tutuptrans').text('Buka Trans');
                        //$('#btn-bayar').removeAttr('disabled');
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptpenerimaan/detilpenerimaan/'+data.no_penerimaan;
                    }
                    if(parseInt(data.posting)==2){
                        //$('#btn-bayar').attr('disabled');                        
                        $('#btn-tutuptrans').attr('value','tutuptrans');
                        $('#btn-tutuptrans').text('Tutup Trans');
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptpenerimaan/detilpenerimaan/'+data.no_penerimaan;
                    }
          /*if(parseInt(data.posting)==3){
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptpenerimaan/ubahpenerimaan/'+data.no_penerimaan;
                    }*/
          
          if(parseInt(data.posting)==3){
                        $('#btn-approve').attr('value','unapprove');
                        $('#btn-approve').text('Batal Approve');
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptpenerimaan/detilpenerimaan/'+data.no_penerimaan;
                    }
                    if(parseInt(data.posting)==4){
                        //$('#btn-bayar').attr('disabled');                        
                        $('#btn-approve').attr('value','approve');
                        $('#btn-approve').text('Approve');
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/aptpenerimaan/detilpenerimaan/'+data.no_penerimaan;
                    }

                    //if(parseInt(data.cetak)>0){
                        //window.location.href='<?php echo base_url(); ?>index.php/loket/cetakregisterpasienxls/'+data.kd_pendaftaran;  
                        //window.open('<?php echo base_url(); ?>index.php/loket/cetakregisterpasienxls/'+data.kd_pendaftaran,'_newtab');                  
                        //window.location.href='<?php echo base_url(); ?>index.php/loket/';                       
                   // }else{
                       // window.location.href='<?php echo base_url(); ?>index.php/loket/';                       
                   // }
                    
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
            <form class="form-horizontal"  id="form" method="POST" action="<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/updatenotapenerimaan">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box">
                                        <header class="top" style="">
                                            <div class="icons"><i class="icon-edit"></i></div>
                                            <h5>PENERIMAAN OBAT / ALKES</h5>
                                            <!-- .toolbar -->
                                            <div class="toolbar" style="height:auto;">
                                                <ul class="nav nav-tabs">
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/"> <i class="icon-list"></i> Daftar / (F7)</a></li>
                                                    <li><button class="btn" id="simpan" type="submit"  name="submit" value="simpan"> <i class="icon-save"></i> Simpan / (Ctrl+S)</button></li>
                                    <li><a target="_blank" class="btn" id="btn-cetak" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php if(!empty($no_penerimaan)){ echo base_url() ?>third-party/fpdf/buktipenerimaan.php?no_penerimaan=<?php echo $no_penerimaan;} else echo '#'; ?>" <?php if(empty($no_penerimaan)){ ?>disabled<?php } ?>> <i class="icon-print"></i> Cetak</a></li>                                                    
                                                    <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/aptpenerimaan/tambahpenerimaanapt"> <i class="icon-plus"></i> Tambah Baru/ (Ctrl+R)</a></li>
                                                   
                                                </ul>
                                            </div>
                                            <!-- /.toolbar -->
                                        </header>
                                        <div id="div-1" class="accordion-body collapse in body">
                      <div class="row-fluid">
                        <div class="span12">
                          <div class="span5">
                            <div class="control-group">
                              <label for="no_penerimaan" class="control-label">No. Penerimaan </label>
                              <div class="controls with-tooltip">
                                <input type="text" name="no_penerimaan" id="no_penerimaan" value="<?php echo $no_penerimaan; ?>" readonly class="span7 input-tooltip" data-original-title="no penerimaan" data-placement="bottom"/>
                                <span class="help-inline"></span>
                                <input type="hidden" id="kd_applogin" name="kd_applogin" value="<?php echo $kd_applogin; ?>" class="span2 input-tooltip" data-original-title="kd_applogin" data-placement="bottom"/>
                              </div>
                            </div>
                          </div>
                          <div class="span7">
                            <label for="no_faktur" class="control-label">No. Faktur </label>
                            <div class="controls with-tooltip">
                              <input type="text" name="no_faktur" id="no_faktur" value="<?php if(isset($itemtransaksi['no_faktur1']))echo $itemtransaksi['no_faktur1'] ?>" class="span5 input-tooltip" data-original-title="no faktur" data-placement="bottom"/>
                              <span class="help-inline"></span> 
                              Tgl. Faktur <input type="text" name="tgl_faktur" id="tgl_faktur" class="input-small input-tooltip cleared" data-original-title="tgl faktur" data-mask="99-99-9999" value="<?php if(empty($itemtransaksi['tgl_faktur']))echo date('d-m-Y'); else echo convertDate($itemtransaksi['tgl_faktur']);  ?>" data-placement="bottom"/>
                            </div>
                          </div>
                        </div>
                      </div>                                                
                                            <div class="row-fluid">
                        <div class="span12">
                          <div class="span5">
                            <div class="control-group">
                              <label for="tgl_penerimaan" class="control-label">Tgl. Penerimaan </label>
                              <div class="controls with-tooltip">
                                <input type="text" name="tgl_penerimaan" id="tgl_penerimaan" class="input-small input-tooltip cleared" data-original-title="tgl penerimaan" data-mask="99-99-9999" value="<?php if(empty($itemtransaksi['tgl_penerimaan']))echo date('d-m-Y'); else echo convertDate($itemtransaksi['tgl_penerimaan']);  ?>" data-placement="bottom"/>
                                <span class="help-inline"></span>
                                Shift  <input type="text" id="shift" name="shift" value="<?php if(isset($itemtransaksi['shift']))echo $itemtransaksi['shift'] ?>" class="span2 input-tooltip" data-original-title="shift" data-placement="bottom" readonly />
                              </div>
                            </div>
                          </div>
                                                    <!--
                          <div class="span7">
                            <div class="control-group">
                              <label for="lunas" class="control-label">Lunas </label>
                              <div class="controls with-tooltip">
                                <input type="checkbox" id="lunas" name="lunas" value="1" <?php echo set_checkbox('lunas','1',isset($itemtransaksi['lunas'])&& $itemtransaksi['lunas']=='1' ? true:false); ?> disabled />
                                <span class="help-inline"></span>
                                Tutup Faktur <input type="checkbox" id="posting" name="posting" value="1" <?php echo set_checkbox('posting','1',isset($itemtransaksi['posting'])&& $itemtransaksi['posting']=='1' ? true:false); ?> disabled />
                              </div>
                            </div>
                          </div>
                                                    -->
                        </div>
                      </div>
                      <div class="row-fluid">
                        <div class="span12">
                          <div class="span5">
                            <div class="control-group">
                              <label for="tgl_tempo" class="control-label">Tgl. Jatuh Tempo </label>
                              <div class="controls with-tooltip">
                                <input type="text" name="tgl_tempo" id="tgl_tempo" class="input-small input-tooltip cleared" data-original-title="tgl tempo" data-mask="99-99-9999" value="<?php if(empty($itemtransaksi['tgl_tempo']))echo date('d-m-Y'); else echo convertDate($itemtransaksi['tgl_tempo']);  ?>" data-placement="bottom"/>
                                <span class="help-inline"></span>
                                <input type="hidden" name="jam_penerimaan" id="jam_penerimaan" value="<?php echo date('h:i:s'); ?>" data-mask="99:99:99" class="input-small"/>
                                <input type="hidden" id="jam_penerimaan1" name="jam_penerimaan1" value="<?php if(isset($itemtransaksi['jam_penerimaan']))echo $itemtransaksi['jam_penerimaan'] ?>" class="input-small" data-original-title="jam penerimaan" data-placement="bottom"/>
                              </div>
                            </div>
                          </div>
                          <div class="span7">
                            <div class="control-group">
                              <label for="kd_supplier" class="control-label">Distributor </label>
                              <div class="controls with-tooltip">
                                <input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="hidden" id="kd_supplier1" name="kd_supplier1" value="<?php if(isset($itemtransaksi['kd_supplier']))echo $itemtransaksi['kd_supplier'] ?>" class="span2 input-tooltip" data-original-title="kd distributor" data-placement="bottom"/>                                
                                <input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="hidden" id="nama" name="nama" value="<?php if(isset($itemtransaksi['nama']))echo $itemtransaksi['nama'] ?>" class="span9 input-tooltip" data-original-title="nama distributor" data-placement="bottom"/>                                
                                <select id="kd_supplier" name="kd_supplier">
                                  <?php
                                  foreach ($datasupplier as $supplier) {
                                    # code...
                                                                  $selected = false;
                                                                        if($itemtransaksi['kd_supplier'] == $supplier['kd_supplier']) {
                                                                            $selected = true;
                                                                        }
                                                                    ?>

                                                                    <option value="<?php echo $supplier['kd_supplier'] ?>" <?=  $selected ? 'selected="selected"' : '' ?>>
                                                                        <?php echo $supplier['nama'] ?>
                                                                    </option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                </select>
                                <!--input type="hidden" id="alamat" name="alamat" value="<?php if(isset($itemtransaksi['alamat']))echo $itemtransaksi['alamat'] ?>" class="span4 input-tooltip" data-original-title="alamat" data-placement="bottom"/-->
                                <!--&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp( List Distributor : Ctrl + D )-->
                                <span class="help-inline"></span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row-fluid">
                        <div class="span12">
                          <!--<div class="span5">
                            <div class="control-group">
                              <label for="isipesan" class="control-label">Pilih Pesanan</label>
                              <div class="controls with-tooltip">
                                <input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="text" id="isipesan" name="isipesan" value="" class="span12 input-tooltip cleared" data-original-title="isi pesan" data-placement="bottom" />
                                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp( List Pesanan : Ctrl + P )
                                <span class="help-inline"></span>
                              </div>
                            </div>
                          </div>-->                         
                          <div class="span7">
                            <div class="control-group">
                              <label for="keterangan" class="control-label">Keterangan </label>
                              <div class="controls with-tooltip">
                                <input type="text" id="keterangan" name="keterangan" value="<?php if(isset($itemtransaksi['keterangan']))echo $itemtransaksi['keterangan'] ?>" class="span11 input-tooltip cleared" data-original-title="keterangan" data-placement="bottom"/>
                                <span class="help-inline"></span>                               
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row-fluid">
                        <div class="span12">
                          <div class="span5">
                            <div class="control-group">
                              <label for="isipesan" class="control-label">Sumber Dana</label>
                              <div class="controls with-tooltip">
                                <select  class="input-xlarge cleared" <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> name="kd_unit_apt" id="kd_unit_apt" required>
                                      <option value="">Pilih Sumber Dana</option>
                                      <?php
                                      foreach ($sumberdana as $sd) {
                                        $select="";
                                        
                                          if(isset($itemtransaksi['kd_unit_apt']) && $itemtransaksi['kd_unit_apt']==$sd['kd_unit_apt'])$select="selected=selected";else $select="";
                                        
                                    
                                      ?>
                                        <option value="<?php if(!empty($sd)) echo $sd['kd_unit_apt'] ?>" <?php echo $select; ?>><?php echo $sd['nama_unit_apt'] ?></option>
                                      <?php
                                      }
                                      ?>
                                </select>
                                <span class="help-inline"></span>
                              </div>
                            </div>
                          </div>    
                          <div class="span7">
                            <div class="control-group">
                              <label for="jumlah" class="control-label">Jumlah Transaksi</label>
                              <div class="controls with-tooltip">
                                <input style="text-align:right;" type="text" id="jumlah" name="jumlah" value="<?php if(isset($itemtransaksi['jumlah']))echo number_format($itemtransaksi['jumlah'],2,'.','') ?>" class="span4 input-tooltip jumlah cleared" data-original-title="jumlah" data-placement="bottom" readonly />
                                <span class="help-inline"></span>
                                <input type="hidden" name="tgl_entry" id="tgl_entry" class="input-small input-tooltip cleared" data-original-title="tgl entry" data-mask="9999-99-99" value="<?php if(empty($tgl_entry))echo date('Y-m-d'); else echo convertDate($tgl_entry); ?>" data-placement="bottom"/>
                                <input style="text-align:right;" type="hidden" id="discount1" name="discount1" value="<?php if(isset($itemtransaksi['discount']))echo number_format($itemtransaksi['discount'],2,'.','') ?>" class="span4 input-tooltip" data-original-title="discount" data-placement="bottom"/>
                                <input type="hidden" name="apf_number1" id="apf_number1" value="<?php if(isset($itemtransaksi['apf_number']))echo $itemtransaksi['apf_number'] ?>" class="span5 input-tooltip" data-original-title="apf number" data-placement="bottom"/>
                              </div>
                            </div>
                          </div>
                          
                        
                        </div>  
                                                                   
                          <div id="progress" style="display:none;"></div>
                      </div>
                                        </div>
                                    </div>
                  
                  <div class="row-fluid">
                    <div class="span12">
                      <div class="box error">
                        <div class="body collapse in" id="defaultTable">
                          <table class="table responsive">
                            <thead>
                              <tr style="font-size:80% !important;">
                                <th class="header" style="width:10px;padding:0 !important;">&nbsp;</th>
                                <!--<th class="header" style="width:85px;padding:0 !important;">Kode</th>-->
                                <!--<th class="header" style="width:85px;padding:0 !important;">No. Pesan</th>-->
                                                                <th class="header" style="">Kode Obat</th>
                                                                <th class="header" style="">Pabrik</th>
                                                                <th class="header" style="">Nama Obat</th>
                                <th class="header">Satuan</th>
                                <th class="header">Tgl.Exp</th>
                                <th class="header">No.Batch</th>
                                <th class="header">Qty</th>
                                <th class="header">Harga B</th>
                                <th class="header">Jumlah</th>
                                <th class="header">Bonus</th>
                                <th class="header">Total </th>
                                <th class="header">Kode SAS </th>
                                <th class="header">Format </th>
                                <th class="header">Barcode </th>
                              </tr>
                            </thead>
                            <tbody id="bodyinput">
                              <?php
                                if(isset($itemsdetiltransaksi)){
                                  //$no=1;
                                  $subtotal=0;
                                  $diskonall=$this->mpenerimaanapt->ambildiskonall($no_penerimaan);
                                  $grandtotal=0;
                                  foreach ($itemsdetiltransaksi as $itemdetil){
                                    $kiteye=$itemdetil['qty_kcl'];
                                    $harga=$itemdetil['harga_beli'];
                                    $discpers=$itemdetil['disc_prs'];
                                    $diskon=$itemdetil['isidiskon'];
                                    $ppn=$itemdetil['ppn_item'];
                                    $jum1=0;
                                    if($discpers=='')$discpers=0;
                                    if($diskon=='')$diskon=0;
                                    if($ppn=='')$ppn=0;
                                    $hbdisc=($discpers/100)*$harga*$kiteye;
                                    if($discpers!=0){
                                      $jum1=($kiteye*$harga)-$hbdisc;
                                    }
                                    else{
                                      if($diskon!=0){
                                        $jum1=($kiteye*$harga)-$diskon;
                                      }
                                      else{
                                        $jum1=$kiteye*$harga;
                                      }
                                    }
                                    $totalnya=($kiteye*$harga);
                                  ?>
                                    <tr style="font-size:80% !important;"><td style="text-align:center;padding:0 !important;">&nbsp;</td>
                                      <td style="padding:0 !important;"><?php echo $itemdetil['kd_obat'] ?></td>
                                      <td style="text-align:left;padding:0 !important;">
                                              <?php foreach ($datapabrik as $pabrik){               
                                                  $select="";
                                                  if(isset($pabrik['kd_pabrik'])){    
                                                      if($itemdetil['kd_pabrik']==$pabrik['kd_pabrik'])echo $pabrik['nama_pabrik'];
                                                  }
                                                }
                                              ?>
                                      </td>
                                      <td style="padding:0 !important;"><?php echo $itemdetil['nama_obat'] ?></td>
                                      <td style="padding:0 !important;"><?php echo $itemdetil['satuan_kecil'] ?></td>
                                      <td style="padding:0 !important;"><?php echo $itemdetil['tgl_expire'] ?></td>
                                      <td style="padding:0 !important;"><?php echo $itemdetil['no_batch'] ?></td>
                                      <td style="padding:0 !important;"><?php echo $kiteye; ?></td>
                                      <td style="padding:0 !important;"><?php echo number_format($harga,2,'.',''); ?></td>
                                      <td style="padding:0 !important;"><?php echo number_format($jum1,2,'.',','); ?></td>                            
                                      <td style="padding:0 !important;"><?php echo $itemdetil['bonus'] ?></td>
                                      <td style="text-align:center;padding:0 !important;"><?php echo number_format($totalnya,2,'.',','); ?></td>
                                      <td style="padding:0 !important;"><?php echo $itemdetil['format'] ?></td>
                                      <?php $batch=str_replace('/','plntit',$itemdetil['no_batch']); ?>
                                      <td style="padding:0 !important;"><?php echo $itemdetil['kode_sas'] ?></td>
                                      <td style="padding:0 !important;"><a target="_newtab" href="<?php echo base_url(); ?>index.php/transapotek/Qrcode_Controller/setQRCode_single/<?=$itemdetil['kd_obat']?>/<?=$batch?>/<?=$itemdetil['tgl_expire']?>/<?=$itemtransaksi['kd_unit_apt']?>">QR Code</a> </td>
                                      <td style="padding:0 !important;"><a target="" href="<?php echo base_url("index.php/transapotek/aptpenerimaan/hapusobatpenerimaan/".$itemdetil['no_penerimaan']."/".$itemdetil['urut']) ?>">Hapus</a> </td>
                                    </tr>
                                  <?php
                                    //$no++;
                                    $subtotal=$subtotal+$totalnya;
                                  }
                                  $grandtotal=$subtotal+(($itemtransaksi['ppn']/100)*$subtotal);
                                }
                              ?>

                            </tbody>
                            <tfoot>
                              <tr>
                                <th colspan="12" style="text-align:right;" class="header">Sub Total (Rp) : <input type="text" class="input-medium cleared" id="totalpenerimaan" value="<?php echo number_format($subtotal,2,'.',',') ?>" style="text-align:right" readonly></th>
                              </tr>
                              <tr>
                                <th colspan="12" style="text-align:right;" class="header">PPN (%) : <input <?php if($this->mpenerimaanapt->isPosted($no_penerimaan))echo "readonly"; ?> type="text" class="input-medium cleared" id="discount" name="ppn" value="<?php if(isset($itemtransaksi['ppn'])) echo number_format($itemtransaksi['ppn'],2,'.',''); ?>" style="text-align:right"></th>
                                <!--th colspan="14" style="text-align:right;" class="header">Discount (Rp) : <input type="text" class="input-medium cleared" id="discount" style="text-align:right"></th-->
                              </tr>
                              <tr>
                                <th colspan="12" style="text-align:right;" class="header">Total Penerimaan (Rp) : <input type="text" class="input-medium cleared" id="subtotal" value="<?php echo number_format($grandtotal,2,'.',','); ?>" style="text-align:right" readonly></th>
                              </tr>
                            </tfoot>
                          </table>
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
      
