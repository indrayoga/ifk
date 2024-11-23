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
	//Mousetrap.bindGlobal('ctrl+r', function() { window.location.href='<?php echo base_url() ?>index.php/transapotek/penjualan/tambahpenjualan'; return false;});
    Mousetrap.bindGlobal('f6', function() { 
        //window.location.href='<?php echo base_url() ?>index.php/transapotek/penjualan/tambahpenjualan'; return false;


window.open(
  '<?php echo base_url() ?>index.php/transapotek/penjualan/tambahpenjualan',
  '_newtab' // <- This is what makes it open in a new window.
);

    });
    
    Mousetrap.bindGlobal('f10', function() { 
        window.location.href='<?php echo base_url() ?>index.php/transapotek/penjualan/tambahpenjualan'
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
    Mousetrap.bind('esc', function(e) { $('#tesxx').hide(); });
    Mousetrap.bind('tab', function(e) { if($('#tesxx').is(':visible')){ $('#tesxx').hide(); } return false; });

    Mousetrap.bindGlobal(['esc','tab'], function() {

        $('#tesxx').hide();
        $( ".barisnamaobat" ).blur();
        //setTimeout(function(){
            //$( ".barisnamaobat" ).focus();
       // }, 500);
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
        //if (e.preventDefault) {
        //    e.preventDefault();
        //} else {
            // internet explorer
        //    e.returnValue = false;
        //}
        
        if($('#daftarobat').is(':visible')){
            $('#daftarobat').find('.ui-selected').find('.btn').trigger('click');
            return false;
        }

        if($('#tesxx').is(':visible')){
            $('#tesxx').find('.ui-selected').find('.btn').trigger('click');
            return false;
        }
      
        return false;
       // alert('x');
        //return false;
    });
	
	Mousetrap.bindGlobal('f2', function() {
		var newdate = document.getElementById('tgl_penjualan').value;
		var tg=newdate.split('-');
		var tgl=tg[2]+'-'+tg[1]+'-'+tg[0];
        if($('#nama_pasien').is(':focus')){
            $.ajax({
                url: '<?php echo base_url() ?>index.php/transapotek/penjualan/ambilpasienbynama/',
                async:false,
                type:'get',                                                                 
                data:{query:$("#nama_pasien").val(),tes:$('.uniform:checked').val(),dor:tgl},
                success:function(data){
                //typeahead.process(data)
                    $('#listpasien').empty();
                    $.each(data,function(i,l){
                        //alert(l.kd_unit_kerja1);
                        $('#listpasien').append('<tr><td>'+l.no_daftar+'</td><td>'+l.no_reg+'</td><td>'+l.nama_pasien+'</td><td>'+l.tanggal+'</td><td>'+l.nm_unit+'</td><td><a class="btn" onclick=\'pilihpasien("'+l.id_asp+'","'+l.no_reg+'","'+l.nama_pasien+'","'+l.kd_unit+'","'+l.kd_dokter+'","'+l.nm_dokter+'","'+l.tanggal+'","'+l.nm_unit+'")\'>Pilih</a></td></tr>');
                    }); 
                },
                dataType:'json'                         
            }); 
            $('#daftarpasien').modal("show");
            $('#nama_pasien2').focus(); 
            var ex = document.getElementById('dataTable2');
            if ( ! $.fn.DataTable.fnIsDataTable( ex ) ) {
                $('#dataTable2').dataTable({
                    "sDom": "<'pull-right'l>t<'row-fluid'<'span6'f><'span6'p>>",
                    "sPaginationType": "bootstrap",
                    "oLanguage": {
                        "sLengthMenu": "Show _MENU_ entries"
                    }
                });
                var oTable = $('#dataTable2').dataTable();
                $('#nama_pasien1').keyup(function(e){
                    oTable.fnFilter( $(this).val() );
                    if(e.keyCode == 13){
                        //alert('xx')
                        return false;
                    }
                });
            };
            return false;
        }

        
        

	});	
	
	
	Mousetrap.bindGlobal('f12', function() { 
		$('#simpan').trigger('click');
		return false;
	});
	
</script> 
<script type="text/javascript">
	
    $(document).ready(function() {
		$('#nama_pasien').focus();
		$('#cust_code').trigger('change');
        var totalpenjualan=0; var sisa=0;

        $('.barisjumlah').each(function(){
                var val=$(this).val();
                if(val=='')val=0;
                totalpenjualan=totalpenjualan+parseInt(val);
        });
        
		$('#totalpenjualan').val(totalpenjualan.toFixed(2));
		

        $('#form').ajaxForm({
            beforeSubmit: function(a,f,o) {
                o.dataType = "json";
                $('div.error').removeClass('error');
                $('span.help-inline').html('');
                $('#progress').show();
                $('body').append('<div id="overlay1" style="position: fixed;height: 100%;width: 100%;z-index: 1000000;"></div>');
                $('body').addClass('body1');
                var urlnya="<?php echo base_url(); ?>index.php/transapotek/penjualan/periksapenjualan"; //buat validasi inputan
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
                    $('#no_penjualan').val(data.no_penjualan); //baru
                   
					if(parseInt(data.keluar)>0){
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/penjualan/ubahpenjualan/'+data.no_penjualan;
                    }
                    if(parseInt(data.simpanbayar)>0){
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/penjualan/ubahpenjualan/'+data.no_penjualan;
                    }

                    $('#no_penjualan').val(data.no_penjualan);
                   

                    if(parseInt(data.posting)==1 || parseInt(data.posting)==3){
                      
                      
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/penjualan/ubahpenjualan/'+data.no_penjualan;
                    }
                    if(parseInt(data.posting)==2){
                      
                        window.location.href='<?php echo base_url(); ?>index.php/transapotek/penjualan/ubahpenjualan/'+data.no_penjualan;
                    }
					//if(parseInt(data.posting)==3){
                      //   window.location.href='<?php echo base_url(); ?>index.php/transapotek/penjualan/tambahpenjualan/'+data.no_penjualan;
                    //}
					if(parseInt(data.simpanbayar)==1){
                         //window.location.href='<?php echo base_url(); ?>third-party/fpdf/cetakbill.php?no_penjualan='+data.no_penjualan;
						 window.open('<?php echo base_url(); ?>third-party/fpdf/cetakbill.php?no_penjualan='+data.no_penjualan,'_newtab');                  
                    }
                   
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
			<form class="form-horizontal"  id="form" method="POST" action="<?php echo base_url() ?>index.php/transapotek/penjualan/simpanpenjualan">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <header class="top" style="">
                                <div class="icons"><i class="icon-edit"></i></div>
                                <h5>TAMBAH OBAT KELUAR </h5>
                                <!-- .toolbar -->
                                <div class="toolbar" style="height:auto;">
                                    <ul class="nav nav-tabs">
                                        <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/penjualan/"> <i class="icon-list"></i> Daftar </a></li>
                                        <!--li><a target="_blank" <-?php if(!$isTutup)echo "disabled"; ?> class="btn" id="btn-cetak" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<-?php if(!empty($no_penjualan)){ echo base_url() ?>third-party/fpdf/cetak.php?no_penjualan=<-?php echo $no_penjualan;} else echo '#'; ?>" <-?php if(empty($no_penjualan)){ ?>disabled<-?php } ?>> <i class="icon-print"></i> Bill</a></li-->
										<!--  <li><button type="button" target="_blank" <?php if(!$this->mpenjualan->isSaved($no_penjualan))echo "disabled"; ?> class="btn" id="btn-cetak" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" onclick=""  <?php if(empty($no_penjualan)){ ?>disabled<?php } ?>> <i class="icon-print"></i> Bill</button></li> 
										<li><a target="_blank" <?php if(!$isTutup)echo "disabled"; ?> class="btn" id="btn-cetakkwitansi" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" data-toggle="modal" data-original-title="Cetak Kwitansi" data-placement="bottom" rel="tooltip" href="#cetakkwitansiform" <?php if(empty($no_penjualan)){ ?>disabled<?php } ?>> <i class="icon-print"></i> Kwitansi</a></li> -->
										<li><button class="btn" id="simpan" type="submit"  name="submit" value="simpan"> <i class="icon-save"></i> Simpan / (F12)</button></li>
                                        <li><a  class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/penjualan/tambahpenjualan"> <i class="icon-plus"></i> Tambah / (F6)</a></li>
                                        <li><a class="btn" style="border-style:solid;border-width:1px;line-height: 21px !important;padding: 4px 12px;border-bottom:1px solid !important;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/penjualan/tambahpenjualan"> <i class="icon-undo"></i>  Cancel / (F10) </a></li>
                                        <li><a class="btn" style="border-style:solid; border-width: 1px; line-height: 21px !important; padding: 4px 12px; border-bottom: 1px solid !important; border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/penjualan/cetaksbbkexcel<?php echo (!empty($no_penjualan) ? '/' . $no_penjualan : '') ?>" <?php echo (empty($no_penjualan) ? "disabled" : "") ?>><i class="icon-print"></i> Cetak SBBK</a></li>
                                        <li>
                                            <?php
                                            if(@$itemtransaksi['kirim']==1){
                                            ?>
                                            <a class="btn" style="border-style:solid; border-width: 1px; line-height: 21px !important; padding: 4px 12px; border-bottom: 1px solid !important; border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) #B3B3B3 !important;" href="#" disabled><i class="icon-print"></i> Kirim Ke Puskesmas</a>

                                            <?php
                                            }else{
                                            ?>
                                            <a class="btn" style="border-style:solid; border-width: 1px; line-height: 21px !important; padding: 4px 12px; border-bottom: 1px solid !important; border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) #B3B3B3 !important;" href="<?php echo base_url() ?>index.php/transapotek/penjualan/kirim<?php echo (!empty($no_penjualan) ? '/' . $no_penjualan : '') ?>" <?php echo (empty($no_penjualan) ? "disabled" : "") ?>><i class="icon-print"></i> Kirim Ke Puskesmas</a>

                                            <?php
                                            }
                                            ?>
                                        </li>
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
												<label for="no_penjualan" class="control-label">No. Transaksi </label>
												<div class="controls with-tooltip">
													<input type="text" name="no_penjualan" id="no_penjualan" value="<?php echo $no_penjualan; ?>" readonly class="span7 input-tooltip" data-original-title="no penjualan" data-placement="bottom"/>
													<span class="help-inline"></span>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="tgl_penjualan" class="control-label">Tgl. Transaksi </label>
												<div class="controls with-tooltip">
													<input type="text" name="tgl_penjualan" id="tgl_penjualan" class="input-small input-tooltip cleared" data-original-title="tgl penjualan" data-mask="99-99-9999" value="<?php if(empty($itemtransaksi['tgl_penjualan']))echo date('d-m-Y'); else echo convertDate($itemtransaksi['tgl_penjualan']); ?>" data-placement="bottom"/>
													<input type="hidden" id="tgl_penjualan2" name="tgl_penjualan2" value="<?php if(isset($itemtransaksi['tgl_penjualan']))echo $itemtransaksi['tgl_penjualan'] ?>" class="span3 input-tooltip" data-original-title="tgl penjualan" data-placement="bottom"/>
													<span class="help-inline"></span>
													<input type="hidden" id="shiftapt" name="shiftapt" value="<?php if(isset($itemtransaksi['shiftapt']))echo $itemtransaksi['shiftapt'] ?>" class="span2 input-tooltip" data-original-title="shift" data-placement="bottom" readonly />
												</div>
											</div>
										</div>
									</div>
								</div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="no_sbbk" class="control-label">No. SBBK </label>
                                                <div class="controls with-tooltip">
                                                    <input type="text" name="no_sbbk" required id="no_sbbk" value="<?= isset($itemtransaksi['no_sbbk']) ? $itemtransaksi['no_sbbk'] : '' ?>" class="span7 input-tooltip" data-original-title="Nomor SBBK" data-placement="bottom"/>
                                                    <span class="help-inline"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="id_puskesmas" class="control-label">Jenis SBBK </label>
                                                <div class="controls with-tooltip">
                                                    <select id="jenis_sbbk" name="jenis_sbbk">
                                                        <option value="0">Pilih Jenis SBBK</option>
                                                        <option value="1" <?= (isset($itemtransaksi['jenis_sbbk']) && $itemtransaksi['jenis_sbbk']==1) ? "selected=selected" :  "" ?> >Psikotropika</option>
                                                        <option value="2" <?= (isset($itemtransaksi['jenis_sbbk']) && $itemtransaksi['jenis_sbbk']==2) ? "selected=selected" : "" ?> >Narkotika</option>
                                                        <option value="3" <?= (isset($itemtransaksi['jenis_sbbk']) && $itemtransaksi['jenis_sbbk']==3) ? "selected=selected" : "" ?> >Prekursor</option>
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
												<label for="id_puskesmas" class="control-label">Customer </label>
												<div class="controls with-tooltip">
													<select id="id_puskesmas" name="id_puskesmas">
                                                        <?php
                                                        foreach ($datapuskesmas as $puskesmas) {
                                                            # code...
                                                            $selected = false;
                                                            if(isset($itemtransaksi['customer_id']) && $itemtransaksi['customer_id'] == $puskesmas['id']) {
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
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="id_puskesmas" class="control-label">Jenis Transaksi </label>
                                                <div class="controls with-tooltip">
                                                    <select id="kd_jenis_transaksi" name="kd_jenis_transaksi"><option value="0">Pilih Jenis Transaksi</option>
                                                        <?php

                                                        foreach ($jenistransaksi as $jt) {
                                                            # code...
                                                            $selected = false;
                                                            if(isset($itemtransaksi['kd_jenis_transaksi']) && $itemtransaksi['kd_jenis_transaksi'] == $jt['kode']) {
                                                                $selected = true;
                                                            }
                                                        ?>

                                                        <option value="<?php echo $jt['kode'] ?>" <?=  $selected ? 'selected="selected"' : '' ?>><?php echo $jt['nama'] ?></option>
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
                        </div>
						
						<div class="row-fluid">
							<div class="span12">
								<div class="box error">
									<header>
									<!-- .toolbar -->
										<div class="toolbar" style="height:auto;float:left;">
											<ul class="nav nav-tabs">
												<li><button class="btn" type="button" id="tambahbaris"> <i class="icon-plus"></i> Tambah Obat (Ctrl+B)</button></li>
												<li><button class="btn" type="button" id="hapusbaris"> <i class="icon-remove"></i> Hapus Obat</button></li>
											</ul>
										</div>
									<!-- /.toolbar -->
									</header>
									<div class="body collapse in" id="defaultTable">
										<table class="table responsive">
											<thead>
												<tr>
													<th class="header" style="width: 11px"></th>
                                                    <th class="header span1">Sumber Dana</th>
                                                    <th class="header input-medium">Kd.Obat</th>
													<th class="header span2">Nama Obat</th>
                                                    <th class="header span1" >Satuan</th>
                                                    <th class="header span1" >Batch</th>
													<th class="header span1" >Tgl.Expire</th>
                                                    <th class="header span1" >Tgl. Keluar</th>
													<th class="header span1" >Harga (Rp)</th>																
                                                    <th class="header span1" style="">Jumlah</th>
                                                    <th class="header span1" style="">Jml isi Kemasan</th>
													<th class="header span1" style="">Jumlah (Rp)</th>
												</tr>
											</thead>
											<tbody id="bodyinput">
												<?php
													if(isset($itemsdetiltransaksi)){
														//$no=1;
														foreach ($itemsdetiltransaksi as $itemdetil){
																																
														?>
															<tr>
																
																<td style="text-align:center;"><input type="checkbox" class="barisinput" /></td>

                                                                            <td style="text-align:center;">
                                                                                <select  class="input-small bariskdunitapt cleared" name="kd_unit_apt[]" id="kd_unit_apt">
                                                                                    <option value="">Pilih Sumber Dana</option>
                                                                                    <?php foreach ($dataunit as $dtunit){               
                                                                                        $select="";
                                                                                        if(isset($dtunit['kd_unit_apt'])){    
                                                                                            if($itemdetil['kd_unit_apt']==$dtunit['kd_unit_apt'])$select="selected=selected";else $select="";
                                                                                        }
                                                                                    ?>
                                                                                    <option value="<?php if(!empty($dtunit)) echo $dtunit['kd_unit_apt'] ?>" <?php echo $select; ?>><?php echo $dtunit['nama_unit_apt'] ?></option>
                                                                                    <?php
                                                                                        }
                                                                                    ?>
                                                                            </td>
																<td>
                                                                    <input <?php if($isTutup)echo "readonly"; ?> type="text" name="kd_obat[]" value="<?php echo $itemdetil['kd_obat'] ?>" class="input-small bariskodeobat cleared">
                                                                    <input <?php if($isTutup)echo "readonly"; ?> type="hidden" name="kd_pabrik[]" value="<?php echo $itemdetil['kd_pabrik'] ?>" class="input-medium bariskodepabrik cleared">
                                                                </td>
																<td><input <?php if($isTutup)echo "readonly"; ?> type="text" name="nama_obat[]" value="<?php echo $itemdetil['nama_obat'] ?>" style="" class="input-large barisnamaobat cleared"></td>
                                                                <td><input <?php if($isTutup)echo "readonly"; ?> style="text-align:center;" type="text" name="satuan_kecil[]" value="<?php echo $itemdetil['satuan_kecil'] ?>" style="" class="input-small barissatuan cleared" disabled></td>
                                                                <td><input <?php if($isTutup)echo "readonly"; ?> style="text-align:center;" type="text" name="batch[]" value="<?php echo $itemdetil['batch'] ?>" style="" class="input-small barisbatch cleared" readonly></td>
																<td><input <?php if($isTutup)echo "readonly"; ?> style="text-align:center;" type="text" name="tgl_expire[]" value="<?php echo $itemdetil['tgl_expire'] ?>" class="input-small baristanggal cleared" readonly></td>
                                                                <td><input <?php if($isTutup)echo "readonly"; ?> type="text" name="tgl_keluar[]" class="baristglkeluar input-small input-tooltip cleared" data-original-title="Tgl keluar" data-mask="99-99-9999" value="<?php if(empty($itemdetil['tgl_keluar']))echo date('d-m-Y'); else echo $itemdetil['tgl_keluar']; ?>" data-placement="bottom"/></td>
																<td><input <?php if($isTutup)echo "readonly"; ?> style="text-align:right;" type="text" id="harga_jual" name="harga_jual[]" value="<?php echo $itemdetil['harga_jual'] ?>" class="input-small barisharga cleared" readonly></td>
                                                                <td><input <?php if($isTutup)echo "readonly"; ?> style="text-align:right;" type="text" id="qty" name="qty[]" value="<?php echo $itemdetil['qty'] ?>" class="input-mini barisqty cleared"></td>
                                                                <td style="text-align:right;">
                                                                    <input <?php if($isTutup)echo "readonly"; ?> style="text-align:right;" type="text" name="qty_kecil[]" value="<?php echo $itemdetil['qty_kecil'] ?>" class="input-mini barisqtykecil cleared" readonly>
                                                                    <input type="hidden" name="isi_kemasan[]" value="<?php echo $itemdetil['isi_kemasan'] ?>" class="input-mini barisisikemasan cleared">
                                                                </td>
                                                                <td style="text-align:right;"><input <?php if($isTutup)echo "readonly"; ?> style="text-align:right;" type="text" name="total[]" value="<?php echo number_format(($itemdetil['harga_jual']*$itemdetil['qty']),2,'.','') ?>" class="input-medium barisjumlah cleared" readonly></td>
																<input type="hidden" name="jml_stok[]" value="<?php echo $itemdetil['jml_stok'] ?>" class="input-medium barisstok cleared">
                                                                <input type="hidden" name="qty11[]" value="<?php echo $itemdetil['qty'] ?>" class="input-medium barisqty11 cleared">
																<input type="hidden" name="racikan1[]" value="" class="input-mini barisracik1 cleared">
															</tr>
														<?php
															//$no++;
														}
													}
												?>
											</tbody>
											<tfoot id="xxx">
                                                <tr>
                                                    <th colspan="11" style="text-align:right;" class="header">Total (Rp) : <input type="text" class="input-medium cleared" id="totalpenjualan" style="text-align:right" disabled></th>
                                                </tr>
											</tfoot>
										</table>																									
									</div>
								</div>
							</div>
						</div>
						    <br/>
                            <br/>
                            <br/>
						<!--/div-->
						
						<div aria-hidden="true" aria-labelledby="approveModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="cetakkwitansiform" style="display: none;">
							<div class="modal-header">
								<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
								<h3 id="helpModalLabel1"><i class="icon-external-link"></i> Cetak Kwitansi</h3>
							</div>
							<div class="modal-body" style="">
								<div class="body" id="collapse4">												
									<div class="control-group">
										<label for="terima1" class="control-label">Telah terima dari</label>
										<div class="controls with-tooltip">
											<input type="text" style="text-align:left;" name="terima1" id="terima1" class="input-xlarge input-tooltip" value="Tn./Ny." data-original-title="terima1" data-placement="bottom"/>														
											<span class="help-inline"></span>
										</div>
									</div>																								
									<div class="control-group">
										<label for="terbilang" class="control-label">Terbilang</label>
										<div class="controls with-tooltip">
											<input type="text" style="text-align:left;" name="terbilang" id="terbilang" class="input-xlarge input-tooltip" value="<?php if(!empty($itemtransaksi))echo numericToString($itemtransaksi['total_transaksi']).'Rupiah' ?>" data-original-title="terbilang" data-placement="bottom"/>
											<span class="help-inline"></span>
										</div>
									</div>
									<div class="control-group">
										<label for="untuk" class="control-label">Untuk</label>
										<div class="controls with-tooltip">
											<textarea id="untuk" name="untuk" cols="90" rows="3" class="input-large" style="width:270px">Untuk pembayaran biaya obat-obatan</textarea>
											<span class="help-inline"></span>
										</div>
									</div>
									<div class="control-group">
										<label for="totalcetak" class="control-label">Total</label>
										<div class="controls with-tooltip">
											<input type="text" style="text-align:right;" name="totalcetak" id="totalcetak" class="input-large input-tooltip" value="<?php if(!empty($itemtransaksi)) echo 'Rp '.number_format($itemtransaksi['total_transaksi']) ?>" data-original-title="totalcetak" data-placement="bottom"/>
											<span class="help-inline"></span>
										</div>
									</div>												
									<div class="control-group">
										<label for="catatan" class="control-label">&nbsp;</label>
										<div class="controls with-tooltip">	
											<button class="btn btn-primary" type="btn" name="btn-kwitansi" id="cetakkwitansi" >OK</button>
											<button aria-hidden="true" data-dismiss="modal" class="btn">Cancel</button>
											<span class="help-inline"></span>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button aria-hidden="true" data-dismiss="modal" class="btn">Close</button>
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
<div style="display:none;position: absolute !important;right: 0;bottom: 0 !important;z-index:99999999999 !important;" id="tesxx" class=" ui-widget-content draggable">
            <table id="dataTable6" class="table table-bordered " style="background:white !important;">
                <thead>
                    <tr>                        
                        <th style="text-align:center;">Kode Obat</th>
                        <th style="text-align:center;">Nama Obat</th>
                        <th style="text-align:center;">Satuan</th>
                        <th style="text-align:center;">Tgl. Expire</th>
                        <th style="text-align:center;">Batch</th>
                        <th style="text-align:center;">Pabrik</th>
                        <th style="text-align:center;">Harga</th>
                        <th style="text-align:center;">Stok</th>
                        <th style="text-align:center;">Isi Kemasan</th>
                        <th style="width:50px !important;">Pilihan</th>
                    </tr>
                </thead>
                <tbody id="listobat6">
                </tbody>
            </table>
</div>

<div aria-hidden="true" aria-labelledby="helpModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="daftarobat" style="display: none;width:70%;margin-left:-400px !important;"> 
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Obat</h3>
    </div>
    <div class="modal-body" id="modal-body-daftarobat" style="height:340px;">
        <div class="body" id="collapse4">
            <table id="dataTable5" class="table table-bordered ">
                <thead>
                    <tr>						
                        <th style="text-align:center;">Kode Obat</th>
                        <th style="text-align:center;">Nama Obat</th>
                        <th style="text-align:center;">Satuan</th>
                        <th style="text-align:center;">Tgl. Expire</th>
                        <th style="text-align:center;">Batch</th>
                        <th style="text-align:center;">Pabrik</th>
						<th style="text-align:center;">Harga</th>
                        <th style="text-align:center;">Stok</th>
                        <th style="text-align:center;">Isi Kemasan</th>
                        <th style="width:50px !important;">Pilihan</th>
                    </tr>
                </thead>
                <tbody id="listobat">

                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <input type="text" id="nama_obat1" class="pull-left" autocomplete="off">
        <button aria-hidden="true" data-dismiss="modal" class="btn">Close</button>
    </div>
</div>

<div aria-hidden="true" aria-labelledby="helpModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="daftarpasien" style="display: none;width:80%;margin-left:-700px !important;"> 
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h3 id="helpModalLabel"><i class="icon-external-link"></i> Daftar Pasien</h3>
    </div>
	<div class="row-fluid">
		<div class="span12">
			<div class="box">
				<header class="top" style="">
					<div class="icons"><i class="icon-edit"></i></div>
                    <h5>Asal Pasien</h5>
				</header>
				<div id="div-2" class="accordion-body collapse in body">
					<div class="row-fluid">
						<div class="span12">
							<div class="span6">
								
							</div>
							<div class="span6">
								<div class="control-group" align="right">
									<input type="text" id="nama_pasien2" name="nama_pasien2" class="span8 input-tooltip" data-original-title="nama pasien" data-placement="bottom"/>
									<input type="hidden" name="tgl_entry" id="tgl_entry" class="input-small input-tooltip cleared" data-original-title="tgl entry" data-mask="9999-99-99" value="<?php if(empty($tgl_entry))echo date('Y-m-d'); else echo $tgl_entry; ?>" data-placement="bottom"/>
									<!--input type="submit" name="submitcari" id="submitcari" value="cari"/-->
								</div>								
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div class="modal-body"  style="height:260px;">
        <div class="body" id="collapse4">
            <table id="dataTable4"  class="table table-bordered table-condensed table-hover table-striped">
                <thead>
					<tr>	
						<th style="text-align:center;">No Register</th>
                        <th style="text-align:center;">No. Pendaftaran</th>
						<th style="text-align:center;">Nama</th>
						<th style="text-align:center;">Tgl. Daftar</th>
						<th style="text-align:center;">Jenis Pelayanan</th>
						<th style="text-align:center;" style="width:50px !important;">Pilihan</th>
                    </tr>					
                </thead>
                <tbody id="listpasien">	
				
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <input type="text" id="nama_pasien1" class="pull-left" autocomplete="off">		
		<button aria-hidden="true" data-dismiss="modal" class="btn">Close</button>		
    </div>
</div>



			
<script type="text/javascript">

$('#tipe').change(function(){
    //alert('xx');
    var val=$(this).val();
    //alert(val);
    //$('#cust_code option[tipe!='+val+']').attr('hidden','hidden');
    $('#cust_code option[tipe!='+val+']').attr('hidden','hidden');
    $('#cust_code option[tipe='+val+']').removeAttr('hidden');
    $('#cust_code option[tipe='+val+']').show();
    $('#cust_code option[tipe='+val+']').prop('selected',true);
});

            $('#btn-cetak').bind('click', function(e){
                    var r = confirm("Cetak Struk?");
                    //if($('#kd_pasien').val()=="")alert('Pilih pasien dulu');
                    if (r == true)
                      {
                            jsWebClientPrint.print('useDefaultPrinter=1&printerName=null&kd_user=<?php echo $this->session->userdata('id_user') ?>&no_penjualan=<?php echo $no_penjualan; ?>')
                            //jsWebClientPrint.print('useDefaultPrinter=1&printerName=null&kd_pasien='+$('#kd_pasien').val()+'');
                          /* $.ajax({
                                url: '<?php echo base_url() ?>index.php/reg/rwj/cetakstruk/'+$('#kd_pasien').val(),
                                type:"POST",
                                async: false,
                                success: function(data){

                                },
                                dataType: 'json'
                            });*/
                      }
                    else
                      {
                      return false;
                      }                    
                    //$('#cetakstruk').attr('href','<?php echo base_url() ?>index.php/reg/rwj/cetakstruk/'+data.kd_pasien);
                //    e.preventDefault();
            })

        $('#terima').keyup(function(e){
            if(e.keyCode == 13){
                console.log('xx')
                $('#kembali').focus();
                return false;
            }
        });


    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });
	
	$('#jam_pelayanan').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
    });
	
	$('#cetakkwitansi').click(function(){
        $('#cetakkwitansiform').modal("hide");
    });
	
	 $('#tgl_penjualan').datepicker({
        format: 'dd-mm-yyyy'
    });

    $('.baristglkeluar').datepicker({
        format: 'dd-mm-yyyy',
        orientation: 'auto left'
    });
	
	$('#cust_code').change(function(){
		if($(this).val()=="0"){
			$('#tgl_penjualan').prop("disabled", true);			
		}
		else {
			$('#tgl_penjualan').prop("disabled", false);
		}
	});
	
	$('#cetakkwitansi').click(function(){
		var terima=$('#terima1').val();
		var terbilang=$('#terbilang').val();
		var untuk=$('#untuk').val();
		var totalcetak=$('#totalcetak').val();
		window.open('<?php echo base_url(); ?>/third-party/fpdf/cetakkwitansi.php?terima='+terima+'&terbilang='+terbilang+'&untuk='+untuk+'&totalcetak='+totalcetak+'','_newtab');
		return false;
	});
	
	$('#bayar').change(function(){
		var val=$(this).val(); //ambil yg di bayar
		var bayar1=$('#bayar1').val(); 
		if(val=='')val=0;
		if(bayar1=='')bayar1=0;
        //var sisa=parseFloat(bayar1)-parseFloat(val);
        var sisa=parseFloat(val)-parseFloat(bayar1);
		$('#sisa').val(sisa.toFixed(2));
	});
	
	$('#terima').change(function(){
		var val=$(this).val(); //ambil terima
		var bayar=$('#bayar').val(); 
		if(val=='')val=0;
		if(bayar=='')bayar=0;
		var kembali=parseFloat(val)-parseFloat(bayar);
		$('#kembali').val(kembali.toFixed(2));
	});
	
	
	function pilihpasien(kd_pasien,no_pendaftaran,nama_pasien,cust_code,kd_dokter,dokter) {
		$('#kd_pasien').val(kd_pasien);
		$('#no_pendaftaran').val(no_pendaftaran);
        $('#nama_pasien').val(nama_pasien);
		$('#cust_code').val(cust_code);
		$('#kd_dokter').val(kd_dokter);
		$('#nama_dokter').val(dokter);
		$('#daftarpasien').modal("hide");
        $('#cust_code').focus();
    }

	function pilihobat(kd_obat,nama_obat,satuan_kecil,tgl_expire,harga_jual,jml_stok,isi_kemasan,kd_pabrik,batch) {
		var batal=0;
		/*$('.bariskodeobat').each(function(){
                var val=$(this).val();
                var expire=$(this).parent().parent().find('.baristanggal').val();
                console.log(expire);
                if(val==kd_obat && expire==tgl_expire){
                    $('#error').html('<div class="alert alert-error fade in navbar navbar-fixed-top" style="margin-left:70px;margin-right:70px;"><button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>Obat sudah di input</div>');
                    throw 'Obat sudah di input';
    			}
        });*/
        var tgl_penjualan = $('#tgl_penjualan').val();
		$('.focused').find('.bariskodeobat').val(kd_obat);
        $('.focused').find('.barisnamaobat').val(nama_obat);
        $('.focused').find('.barissatuan').val(satuan_kecil);
        $('.focused').find('.baristanggal').val(tgl_expire);
		$('.focused').find('.barisharga').val(harga_jual);
        $('.focused').find('.barisstok').val(jml_stok);
        $('.focused').find('.bariskodepabrik').val(kd_pabrik);
        $('.focused').find('.barisbatch').val(batch);
		$('.focused').find('.barisisikemasan').val(isi_kemasan);
        $('.focused').find('.baristglkeluar').val(tgl_penjualan);
		//$('#daftarobat').modal("hide");
		$('.focused').find('.barisqty').trigger('change');
		//$('.barisjumlah').trigger('change');
        console.log('dd');
        $('#tesxx').hide();
        $('.focused').find('input[name="harga_jual[]"]').focus();
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
		var  sumberdana='<td><select  class="input-small  bariskdunitapt cleared" name="kd_unit_apt[]" id="kd_unit_apt">' +
		 				 '<option value="">Pilih Sumber Dana</option>';
		/*if($('.bariskodeobat').length>0){
            $('.barisstok').each(function(){
				var val=$(this).val(); 
				var minstok=$('.focused').find('.barisminstok').val();
				var nama_obat=$('.focused').find('.barisnamaobat').val();
				if(parseFloat(minstok)==parseFloat(val)){
                    alert('Obat '+nama_obat+' telah mencapai batas minimum stok !');
                }				
            });
        }*/

		 $.ajax({
			
           url: '<?php echo base_url() ?>index.php/transapotek/penjualan/sumberdana/',
              async:false,
              type:'get',
              //data:{},
              success:function(data){
            	
                  $.each(data,function(i,l){
                      if(l.kd_unit_apt=='D03')
                          selected='selected=selected';
                      else
                          selected='';
                      sumberdana=sumberdana + '<option  value="'+l.kd_unit_apt+'" '+selected+'>'+l.nama_unit_apt+'</option>';
                  });    
              },
              dataType:'json'                         
          }); 
		 // sumberdana=sumberdana + '</select>';
		$('#bodyinput').append(
            '<tr class="focused">'+ 
                '<td style="text-align:center; width: 11px"><input type="checkbox" class="barisinput cleared" /></td>'+
                sumberdana+
				'<td><input type="hidden" name="kd_pabrik[]"  value="" class="input-medium bariskodepabrik cleared"><input type="text" name="kd_obat[]"  value="" class="input-small bariskodeobat cleared"></td>'+
                '<td><input type="text" name="nama_obat[]"  value="" autocomplete="off" style="" class="input-large barisnamaobat cleared"></td>'+
                '<td><input type="text" name="satuan_kecil[]" value="" style="text-align:center;" class="input-small barissatuan cleared" readonly></td>'+
                '<td><input type="text" name="batch[]" value="" style="text-align:center;" class="input-small barisbatch cleared" readonly></td>'+
				'<td><input type="text" name="tgl_expire[]" value="" style="text-align:center;" class="input-small baristanggal cleared" readonly ></td>'+
                '<td><input style="text-align:center" type="text" name="tgl_keluar[]" value="" class="input-small baristglkeluar cleared"></td>' +
				'<td><input type="text" name="harga_jual[]" value="" style="text-align:right;" class="input-small barisharga cleared" readonly ></td>'+		
                '<td><input type="text" name="qty[]"  value="" style="text-align:right;" class="input-mini barisqty cleared"></td>'+
                '<td><input type="text" name="qty_kecil[]"  value="" readonly style="text-align:right;" class="input-mini barisqtykecil cleared"><input type="hidden" name="isi_kemasan[]" value="" class="input-mini barisisikemasan cleared"></td>'+
                '<td style="text-align:right;"><input type="text"  style="text-align:right;" name="total[]" value="" class="input-medium barisjumlah cleared" readonly ></td>'+
				'<input type="hidden" name="jml_stok[]"  value="" class="input-medium barisstok cleared">'+
				''+
                '<input type="hidden" name="qty11[]" value="" class="input-medium barisqty11 cleared">'+
				'<td><input type="hidden" name="racikan1[]" value="" class="input-mini barisracik1 cleared"></td>'+
            '</tr>');
		
		//$("#bodyinput tr:last input[name='nama_obat[]']").trigger('keydown');
			//var e = jQuery.Event("keyup");
			//e.which = 16; // # Some key code value
        //   	$("#bodyinput tr:last input[name='nama_obat[]']").select();
		//	$("#bodyinput tr:last input[name='nama_obat[]']").trigger(e);
//
        //$("#bodyinput tr:last input[name='nama_obat[]']").focus();
        $("#bodyinput tr:last select[name='kd_unit_apt[]']").focus();

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
           	$('.barisjumlah').each(function(){
                var val=$(this).val(); //ngambil jumlah
                if(val=='')val=0;
                    totalpenjualan=totalpenjualan+parseFloat(val); //buat totalin perbarisnya
                    total1=parseFloat(totalpenjualan);
            });
            total1=parseFloat(total1);

           $('#totalpenjualan').val(total1.toFixed(2));

        });
		
		$('.barisqty').change(function(){  
			
			var val=$(this).val(); var total=0;
            var harga=$('.focused').find('.barisharga').val();
            var isikemasan=$('.focused').find('.barisisikemasan').val();
			if(val=='') val=0;
			if(harga=='')harga=0;	
            total=(parseFloat(val)*parseFloat(harga));
            isi=(parseFloat(val)*parseFloat(isikemasan));
            $('.focused').find('.barisjumlah').val(total.toFixed(2));   
            $('.focused').find('.barisqtykecil').val(isi);   
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
                             $('.bariskodeobat').trigger('blur');
                            $('#listobat6 tr:first').addClass('ui-selected');

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


            if(e.keyCode == 13){
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
            }
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
			totaltransaksi();
            var totalpenjualan=0; var total1=0;	
           $('.barisjumlah').each(function(){
                var val=$(this).val();
                if(val=='')val=0;
                totalpenjualan=totalpenjualan+parseFloat(val);
            });
		   $('#totalpenjualan').val(totalpenjualan.toFixed(2));
    });
	
	$('#hapusbayar').click(function(){
		//$('.bariscekbok:checked').parents('tr').remove();
		$('.bariscekbok').parents('tr').remove();
		$.ajax({
			url: '<?php echo base_url() ?>index.php/transapotek/penjualan/hapuspembayaran/',
			async:false,
			type:'post',
			data:{query:$('#no_penjualan').val(),query1:$('#no_pendaftaran').val()},
			success:function(data){				
				alert('Pembayaran lama berhasil dihapus');
				location.reload();
			},
			dataType:'json'                         
		});	 
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

	$('.barisjumlah').change(function(){ //di dlm function tambah baris
        var totalpenjualan=0;  var total1=0;
                
		$('.barisjumlah').each(function(){
			var val=$(this).val(); //ngambil jumlah
			if(val=='')val=0;
				totalpenjualan=totalpenjualan+parseFloat(val); //buat totalin perbarisnya
		});
                //total1=parseFloat(total1)+parseFloat(bhp);
                total1=parseFloat(total1);

	   $('#totalpenjualan').val(total1.toFixed(2));
    });
	

	
	$('.barisqty').keyup(function(e){ 
            if(e.keyCode == 13){ //klo enter di baris jumlah
                //alert('xx')
                $('#tambahbaris').trigger('click');
                return false;
            }
        });
		
	$('.barisqty').change(function(){  
		
		var val=$(this).val(); var total=0;
        var harga=$('.focused').find('.barisharga').val();
        var isikemasan=$('.focused').find('.barisisikemasan').val();
		if(val=='') val=0;
        if(harga=='')harga=0;
        if(isikemasan=='')isikemasan=0;
		//if(resep=='')resep=0;
        total=(parseFloat(val)*parseFloat(harga));
        qtykecil=(parseFloat(val)*parseFloat(isikemasan));
        $('.focused').find('.barisjumlah').val(total.toFixed(2));   
        $('.focused').find('.barisqtykecil').val(qtykecil.toFixed(2));   
		$('.barisjumlah').trigger('change');
	});
	
		
	$('.barisqty, .barisracik,  .barisnamaobat, .bariskodeobat').click(function(){  
		$('#bodyinput tr').removeClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty
		$(this).parent().parent('tr').addClass('focused'); //bwt ngilangin fokus sebelumnya,,klo misalnya mw update qty
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
                      aoData.push( { "name": "kd_unit_apt", "value":""+$('.focused').find('.bariskdunitapt').val()+""} );
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
	
	
	$("#rd").click(function(){
		$('#nama_pasien2').trigger("keydown");
	})
	$("#rj").click(function(){
		$('#nama_pasien2').trigger("keydown");
	})
	$("#ri").click(function(){
		$('#nama_pasien2').trigger("keydown");
	})
	
	$('#nama_pasien2').keydown(function(e){
			
            $.ajax({
                url: '<?php echo base_url() ?>index.php/transapotek/penjualan/ambilpasienbynama/',
                async:false,
                type:'get',
				data:{query:$(this).val(),tes:$('.uniform:checked').val(),dor:$('#tgl_entry').val()},
                success:function(data){
					$('#listpasien').empty();
					$.each(data,function(i,l){
						$('#listpasien').append('<tr><td>'+l.no_daftar+'</td><td>'+l.no_reg+'</td><td>'+l.nama_pasien+'</td><td>'+l.tanggal+'</td><td>'+l.nm_unit+'</td><td><a class="btn" onclick=\'pilihpasien("'+l.id_asp+'","'+l.no_reg+'","'+l.nama_pasien+'","'+l.kd_unit+'","'+l.kd_dokter+'","'+l.nm_dokter+'","'+l.tanggal+'","'+l.kd_unit+'")\'>Pilih</a></td></tr>');
					});    
                },
                dataType:'json'                         
            }); 
          

	});
	
	
	
	
	function totaltransaksi(){
		var totalracik=0; var total1=0;
		$('.barisracik1').each(function(){
			var val=$(this).val();
			if(val=='')val=0;
            totalracik=totalracik+parseFloat(val);
        });
		var total=$('#totalpenjualan').val();
		total1=total1+totalracik;
       $('#total_transaksi').val(total1.toFixed(2));
	   $('#total_bayar').val(total1.toFixed(2));
       $('#adm_racik').val(totalracik);
       $('#jumlah').val(total1.toFixed(2));
    }
	
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

    history.pushState(null, null, '');
    window.addEventListener('popstate', function(event) {
    history.pushState(null, null, '');
    });

</script>


    <script type="text/javascript">
        var wcppGetPrintersDelay_ms = 5000; //5 sec

        function wcpGetPrintersOnSuccess(){
            // Display client installed printers
            if(arguments[0].length > 0){
                var p=arguments[0].split("|");
                var options = '';
                for (var i = 0; i < p.length; i++) {
                    options += '<option>' + p[i] + '</option>';
                }
                $('#installedPrinters').css('visibility','visible');
                $('#installedPrinterName').html(options);
                $('#installedPrinterName').focus();
                $('#loadPrinters').hide();                                                        
            }else{
                alert("No printers are installed in your system.");
            }
        }

        function wcpGetPrintersOnFailure() {
            // Do something if printers cannot be got from the client
            alert("No printers are installed in your system.");
        }
    </script>

    <?php
    //Specify the ABSOLUTE URL to the php file that will create the ClientPrintJob object
    //In this case, this same page
  //  echo WebClientPrint::createScript(Utils::getRoot().'/simibnusina/billapotek.php')
    ?>
