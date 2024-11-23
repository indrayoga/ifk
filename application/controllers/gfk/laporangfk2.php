<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Laporanapt extends CI_Controller {
class Laporangfk extends Rumahsakit {

    

    protected $title='GFK Kota Bontang';

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('utilities');
        $this->load->library('pagination');
        $this->load->model('gfk/mlaporangfk');
        $this->load->model('apotek/mlaporanapt');
        $this->load->helper('url');
        
    }
    
    public function restricted(){
        $cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
        $jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js',
                            'vendor/jquery-1.9.1.min.js',
                            'vendor/jquery-migrate-1.1.1.min.js',
                            'vendor/jquery-ui-1.10.0.custom.min.js',
                            'vendor/bootstrap.min.js',
                            'lib/jquery.tablesorter.min.js',
                            'lib/jquery.dataTables.min.js',
                            'lib/DT_bootstrap.js',
                            'lib/responsive-tables.js',
                            'lib/bootstrap-datepicker.js',
                            'lib/bootstrap-inputmask.js',
                            'lib/jquery.dualListBox-1.3.min.js',
                            'spin.js',
                            'main.js');
        $dataheader=array(
            'jsfile'=>$jsfileheader,
            'cssfile'=>$cssfileheader,
            'title'=>$this->title
            );

        $jsfooter=array();
        $datafooter=array(
            'jsfile'=>$jsfooter
            );

        //$this->load->view('master/header',$dataheader);
        $this->load->view('headerapotek',$dataheader);
        $data=array();
        parent::view_restricted($data);
        $this->load->view('footer');
    }

    public function distribusi() {
        if(!$this->muser->isAkses("58")){
            $this->restricted();
            return false;
        }
        $periodeawal=date('d-m-Y');
        $periodeakhir=date('d-m-Y');
        
        
        $nama_unit_apt=$this->input->post('nama_unit_apt');
        $kd_unit_apt='';
        
        if($this->input->post('periodeawal')!=''){
            $periodeawal=$this->input->post('periodeawal');
        }
        if($this->input->post('periodeakhir')!=''){
            $periodeakhir=$this->input->post('periodeakhir');
        }
        if($this->input->post('kd_unit_apt')!=''){
            $kd_unit_apt=$this->input->post('kd_unit_apt');
        }
        
        $cssfileheader=array(
            'bootstrap.css',
            'bootstrap-responsive.min.css',
            'font-awesome.min.css',
            'style.css',
            'prettify.css',
            'jquery-ui.css',
            'DT_bootstrap.css',
            'responsive-tables.css',
            'datepicker.css',
            'theme.css');
        $jsfileheader=array(
            'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
            'vendor/jquery-1.9.1.min.js',
            'vendor/jquery-migrate-1.1.1.min.js',
            'vendor/jquery-ui-1.10.0.custom.min.js',
            'vendor/bootstrap.min.js',
            'lib/jquery.tablesorter.min.js',
            'lib/jquery.dataTables.min.js',
            'lib/DT_bootstrap.js',
            'lib/responsive-tables.js',
            'lib/bootstrap-datepicker.js',
            'lib/bootstrap-inputmask.js',
            'lib/bootstrap-modal.js',
            'spin.js',
            'main.js');
        $dataheader=array(
            'jsfile'=>$jsfileheader,
            'cssfile'=>$cssfileheader,
            'title'=>$this->title
            );

        $jsfooter=array();
        $datafooter=array(
            'jsfile'=>$jsfooter
            );
        
        $items = $this->mlaporangfk->getDistribusi($periodeawal, $periodeakhir, $kd_unit_apt);

        $data=array(
            'sumberdana'=>$this->mlaporangfk->getAll('apt_unit'),
            'items' => $items,
            'periodeawal'=>$periodeawal,
            'periodeakhir'=>$periodeakhir,
            'kd_unit_apt'=>$kd_unit_apt
        );

        $this->load->view('headerapotek',$dataheader);
        $this->load->view('gfk/laporangfk/distribusi',$data);
        $this->load->view('footer',$datafooter);
    }

    public function excelDistribusi($periodeawal, $periodeakhir, $kd_unit_apt) {
        echo 'heya';
        var_dump($periodeawal, $periodeakhir, $kd_unit_apt);
    }

    public function distribusiPuskesmas() {
        if(!$this->muser->isAkses("58")){
            $this->restricted();
            return false;
        }
        $periodeawal=date('d-m-Y');
        $periodeakhir=date('d-m-Y');
        $kd_unit_apt = '';
        $puskesmas = null;
        
        if($this->input->post('periodeawal')!=''){
            $periodeawal=$this->input->post('periodeawal');
        }
        if($this->input->post('periodeakhir')!=''){
            $periodeakhir=$this->input->post('periodeakhir');
        }
        if($this->input->post('kd_unit_apt')!=''){
            $kd_unit_apt=$this->input->post('kd_unit_apt');
        }
        if($this->input->post('id_puskesmas') != '') {
            $puskesmas = $this->mlaporangfk->getRow('gfk_puskesmas', 'id = ' . $this->input->post('id_puskesmas'));
        }
        
        $cssfileheader=array(
            'bootstrap.css',
            'bootstrap-responsive.min.css',
            'font-awesome.min.css',
            'style.css',
            'prettify.css',
            'jquery-ui.css',
            'DT_bootstrap.css',
            'responsive-tables.css',
            'datepicker.css',
            'theme.css');
        $jsfileheader=array(
            'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
            'vendor/jquery-1.9.1.min.js',
            'vendor/jquery-migrate-1.1.1.min.js',
            'vendor/jquery-ui-1.10.0.custom.min.js',
            'vendor/bootstrap.min.js',
            'lib/jquery.tablesorter.min.js',
            'lib/jquery.dataTables.min.js',
            'lib/DT_bootstrap.js',
            'lib/responsive-tables.js',
            'lib/bootstrap-datepicker.js',
            'lib/bootstrap-inputmask.js',
            'lib/bootstrap-modal.js',
            'spin.js',
            'main.js');
        $dataheader=array(
            'jsfile'=>$jsfileheader,
            'cssfile'=>$cssfileheader,
            'title'=>$this->title
            );

        $jsfooter=array();
        $datafooter=array(
            'jsfile'=>$jsfooter
            );
        
        $items = $this->mlaporangfk->getDistribusiPuskesmas($periodeawal, $periodeakhir, $kd_unit_apt, (!empty($puskesmas) ? $puskesmas['id'] : ''));

        $data=array(
            'sumberdana'=>$this->mlaporangfk->getAll('apt_unit'),
            'puskesmasList' => $this->mlaporangfk->getAll('gfk_puskesmas'),
            'items' => $items,
            'periodeawal'=>$periodeawal,
            'periodeakhir'=>$periodeakhir,
            'kd_unit_apt'=>$kd_unit_apt,
            'puskesmas' => $puskesmas,
        );

        $this->load->view('headerapotek',$dataheader);
        $this->load->view('gfk/laporangfk/distribusipuskesmas',$data);
        $this->load->view('footer',$datafooter);
    }

    public function excelDistribusiPuskesmas($periodeawal, $periodeakhir, $kd_unit_apt, $id_puskesmas) {
        if($kd_unit_apt=='null')$kd_unit_apt="";
        if($id_puskesmas=='null')$id_puskesmas="";
        $this->load->library('phpexcel'); 
        $this->load->library('PHPExcel/iofactory');
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
        $objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:G3');
        $objPHPExcel->getActiveSheet()->mergeCells('A4:G4');
        $objPHPExcel->getActiveSheet()->mergeCells('A5:G5');
        $objPHPExcel->getActiveSheet()->mergeCells('A6:G6');
        $objPHPExcel->getActiveSheet()->mergeCells('A7:G7');
        $objPHPExcel->getActiveSheet()->mergeCells('A8:G8');
        
        /*$objPHPExcel->getActiveSheet()->mergeCells('B10:C10');
        $objPHPExcel->getActiveSheet()->mergeCells('D10:E10');
        $objPHPExcel->getActiveSheet()->mergeCells('F10:H10');
        $objPHPExcel->getActiveSheet()->mergeCells('J10:L10');*/
        
        /*$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(2.14); 
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(6.34); 
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(8); 
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth(15); //KODE
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(10)->setWidth(23); //NAMA OBAT
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(11)->setWidth(23); //NAMA OBAT
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(12)->setWidth(15); //NAMA OBAT
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(13)->setWidth(15); //SATUAN
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(14)->setWidth(15); //TGL EXPIRE
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(15)->setWidth(12); //QTY*/
        
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(4.14); //NO
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(15); //NODISTRIBUSI
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(25);  //TGL DISTRIBUSI
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(10); //UNIT APOTEK
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(10); //KODE OBAT
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(10); //NAMA OBAT
        //$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(10); //SATUAN
        //$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(10); //TGL EXPIRE
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(10); //QTY
        
        for($x='A';$x<='G';$x++){ //bwt judul2nya
            $objPHPExcel->getActiveSheet()->getStyle($x.'2')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
        }   
        for($x='A';$x<='G';$x++){
            $objPHPExcel->getActiveSheet()->getStyle($x.'3')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
        }   
        for($x='A';$x<='G';$x++){
            $objPHPExcel->getActiveSheet()->getStyle($x.'4')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
        }
        for($x='A';$x<='G';$x++){
            $objPHPExcel->getActiveSheet()->getStyle($x.'5')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
        }   
        for($x='A';$x<='G';$x++){
            $objPHPExcel->getActiveSheet()->getStyle($x.'6')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
        }
        for($x='A';$x<='G';$x++){
                    $objPHPExcel->getActiveSheet()->getStyle($x.'7')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
                }
        for($x='A';$x<='G';$x++){
                    $objPHPExcel->getActiveSheet()->getStyle($x.'8')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
                }       
        $objPHPExcel->getActiveSheet()->setCellValue ('A5','LAPORAN DETAIL DISTRIBUSI OBAT');
        $puskesmas = (!empty($id_puskesmas) ? $this->mlaporangfk->getRow('gfk_puskesmas', "id = $id_puskesmas") : null);
        $objPHPExcel->getActiveSheet()->setCellValue ('A6', is_null($puskesmas) ? 'SEMUA PUSKESMAS' : strtoupper($puskesmas['nama']));
        
        if($kd_unit_apt==''){ $objPHPExcel->getActiveSheet()->setCellValue ('A7','Sumber Dana: Semua Sumber');}
        else{
            $namaunit=$this->mlaporanapt->namaUnit($kd_unit_apt);
            $objPHPExcel->getActiveSheet()->setCellValue ('A7','Sumber Dana : '.$namaunit);
        }
        
        if($periodeawal!='' and $periodeakhir!=''){
            $tglawal=substr($periodeawal,0,2);      $tglakhir=substr($periodeakhir,0,2);
            $blnawal=substr($periodeawal,3,2);      $blnakhir=substr($periodeakhir,3,2);
            $thnawal=substr($periodeawal,6,10);     $thnakhir=substr($periodeakhir,6,10);
            
            if($blnawal=='01'){$blnawal1='Januari';} if($blnawal=='02'){$blnawal1='Februari';}  if($blnawal=='03'){$blnawal1='Maret';} if($blnawal=='04'){$blnawal1='April';}
            if($blnawal=='05'){$blnawal1='Mei';} if($blnawal=='06'){$blnawal1='Juni';} if($blnawal=='07'){$blnawal1='Juli';} if($blnawal=='08'){$blnawal1='Agustus';}
            if($blnawal=='09'){$blnawal1='September';} if($blnawal=='10'){$blnawal1='Oktober';} if($blnawal=='11'){$blnawal1='November';} if($blnawal=='12'){$blnawal1='Desember';}
            
            if($blnakhir=='01'){$blnakhir1='Januari';} if($blnakhir=='02'){$blnakhir1='Februari';} if($blnakhir=='03'){$blnakhir1='Maret';} if($blnakhir=='04'){$blnakhir1='April';}
            if($blnakhir=='05'){$blnakhir1='Mei';} if($blnakhir=='06'){$blnakhir1='Juni';} if($blnakhir=='07'){$blnakhir1='Juli';} if($blnakhir=='08'){$blnakhir1='Agustus';}
            if($blnakhir=='09'){$blnakhir1='September';} if($blnakhir=='10'){$blnakhir1='Oktober';} if($blnakhir=='11'){$blnakhir1='November';} if($blnakhir=='12'){$blnakhir1='Desember';}         
            
            $objPHPExcel->getActiveSheet()->setCellValue ('A8','Periode : '.$tglawal.' '.$blnawal1.' '.$thnawal.' s/d '.$tglakhir.' '.$blnakhir1.' '.$thnakhir);
        }

        for($x='A';$x<='G';$x++){
            $objPHPExcel->getActiveSheet()->getStyle($x.'10')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
        
            $objPHPExcel->getActiveSheet()->getStyle($x.'10')->applyFromArray(array('font'    => array('name'      => 'calibri','horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'size'        =>12 /*untuk ukuran tulisan judul kolom2 di tabel*/,'color'     => array('rgb' => '000000')),
                                                                            'borders' => array('bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
                                                                            'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
                                                                            'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
                                                                            'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
        }       
        $objPHPExcel->getActiveSheet()->setCellValue ('A10','NO.');
        $objPHPExcel->getActiveSheet()->setCellValue ('B10','Kd Obat.');
        $objPHPExcel->getActiveSheet()->setCellValue ('C10','Nama Obat.');
        $objPHPExcel->getActiveSheet()->setCellValue ('D10','Satuan');
        $objPHPExcel->getActiveSheet()->setCellValue ('E10','Harga');
        $objPHPExcel->getActiveSheet()->setCellValue ('F10','Distribusi');
        //$objPHPExcel->getActiveSheet()->setCellValue ('G10','SATUAN');
        //$objPHPExcel->getActiveSheet()->setCellValue ('H10','TGL. EXPIRE');
        $objPHPExcel->getActiveSheet()->setCellValue ('G10','Total');
        $items=array();
        $items=$this->mlaporangfk->getDistribusiPuskesmas($periodeawal,$periodeakhir,$kd_unit_apt,$id_puskesmas);
        $baris=11;
        $nomor=1;
        $total=0;
        $totalpenjualan = 0;
        $totaldistribusi = 0;
        foreach ($items as $item) {
            # code...
            for($x='A';$x<='G';$x++){
                if($x=='A'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                   
                }else if($x=='B'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                       
                }else if($x=='C'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                       
                }
                else if($x=='D'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                     
                }else if($x=='E'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                       
                }else if($x=='F'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                     
                }else if($x=='G'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                        
                }
            
                $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->applyFromArray(array(
                    'font'    => array('name'      => 'calibri','horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'size'      =>11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,'color'     => array('rgb' => '000000')),'borders' => array('bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')),'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
                    'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')))));
            }

            $subtotal = $item['distribusi'] * $item['harga'];
            $totalpenjualan += $subtotal;
            $totaldistribusi += $item['distribusi'];
            $objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,$nomor);
            $objPHPExcel->getActiveSheet()->setCellValue ('B'.$baris,$item['kd_obat']);
            $objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,$item['nama_obat']);
            $objPHPExcel->getActiveSheet()->setCellValue ('D'.$baris,$item['satuan_kecil'] );
            $objPHPExcel->getActiveSheet()->setCellValue ('E'.$baris,$item['harga']);
            $objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,$item['distribusi']);           
            $objPHPExcel->getActiveSheet()->setCellValue ('G'.$baris,$subtotal);
            $nomor=$nomor+1; $baris=$baris+1;
        }   


            for($x='A';$x<='G';$x++){
                if($x=='A'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                   
                }else if($x=='B'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                       
                }else if($x=='C'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                       
                }
                else if($x=='D'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                     
                }else if($x=='E'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                       
                }else if($x=='F'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                     
                }else if($x=='G'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                        
                }
            
                $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->applyFromArray(array(
                    'font'    => array('name'      => 'calibri','horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'size'      =>11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,'color'     => array('rgb' => '000000')),'borders' => array('bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')),'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
                    'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')))));
            }

        $objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,'');
        $objPHPExcel->getActiveSheet()->setCellValue ('B'.$baris,'');
        $objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,'');
        $objPHPExcel->getActiveSheet()->setCellValue ('D'.$baris,'');
        $objPHPExcel->getActiveSheet()->setCellValue ('E'.$baris,'TOTAL');
        $objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,$totaldistribusi);           
        $objPHPExcel->getActiveSheet()->setCellValue ('G'.$baris,$totalpenjualan);
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        $objWriter->save("download/laporandistribusiobat.xls");
        header("Location: ".base_url()."download/laporandistribusiobat.xls");
    }

    public function penerimaanObat() {
        if(!$this->muser->isAkses("58")){
            $this->restricted();
            return false;
        }
        $periodeawal=date('d-m-Y');
        $periodeakhir=date('d-m-Y');
        $kd_unit_apt = '';
        $supplier = null;
        
        if($this->input->post('periodeawal')!=''){
            $periodeawal=$this->input->post('periodeawal');
        }
        if($this->input->post('periodeakhir')!=''){
            $periodeakhir=$this->input->post('periodeakhir');
        }
        if($this->input->post('kd_unit_apt')!=''){
            $kd_unit_apt=$this->input->post('kd_unit_apt');
        }
        if($this->input->post('id_supplier') != '') {
            $supplier = $this->mlaporangfk->getRow('apt_supplier', "kd_supplier = '" . $this->input->post('id_supplier') . "'");
        }
        
        $cssfileheader=array(
            'bootstrap.css',
            'bootstrap-responsive.min.css',
            'font-awesome.min.css',
            'style.css',
            'prettify.css',
            'jquery-ui.css',
            'DT_bootstrap.css',
            'responsive-tables.css',
            'datepicker.css',
            'theme.css');
        $jsfileheader=array(
            'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
            'vendor/jquery-1.9.1.min.js',
            'vendor/jquery-migrate-1.1.1.min.js',
            'vendor/jquery-ui-1.10.0.custom.min.js',
            'vendor/bootstrap.min.js',
            'lib/jquery.tablesorter.min.js',
            'lib/jquery.dataTables.min.js',
            'lib/DT_bootstrap.js',
            'lib/responsive-tables.js',
            'lib/bootstrap-datepicker.js',
            'lib/bootstrap-inputmask.js',
            'lib/bootstrap-modal.js',
            'spin.js',
            'main.js');
        $dataheader=array(
            'jsfile'=>$jsfileheader,
            'cssfile'=>$cssfileheader,
            'title'=>$this->title
            );

        $jsfooter=array();
        $datafooter=array(
            'jsfile'=>$jsfooter
            );
        
        $items = $this->mlaporangfk->getPenerimaanObat($periodeawal, $periodeakhir, $kd_unit_apt, (!empty($supplier) ? $supplier['kd_supplier'] : ''));

        $data=array(
            'sumberdana'=>$this->mlaporangfk->getAll('apt_unit'),
            'distributorList' => $this->mlaporangfk->getAll('apt_supplier'),
            'items' => $items,
            'periodeawal'=>$periodeawal,
            'periodeakhir'=>$periodeakhir,
            'kd_unit_apt'=>$kd_unit_apt,
            'supplier' => $supplier,
        );

        $this->load->view('headerapotek',$dataheader);
        $this->load->view('gfk/laporangfk/penerimaanobat',$data);
        $this->load->view('footer',$datafooter);
    }

    public function excelPenerimaanObat($periodeawal, $periodeakhir, $kd_unit_apt, $id_supplier) {
        if($kd_unit_apt=='null')$kd_unit_apt="";
        if($id_supplier=='null')$id_supplier="";
        $this->load->library('phpexcel'); 
        $this->load->library('PHPExcel/iofactory');
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
        $objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
        $objPHPExcel->getActiveSheet()->mergeCells('A4:H4');
        $objPHPExcel->getActiveSheet()->mergeCells('A6:H6');
        $objPHPExcel->getActiveSheet()->mergeCells('A7:H7');
        $objPHPExcel->getActiveSheet()->mergeCells('A8:H8');
        
        /*$objPHPExcel->getActiveSheet()->mergeCells('B10:C10');
        $objPHPExcel->getActiveSheet()->mergeCells('D10:E10');
        $objPHPExcel->getActiveSheet()->mergeCells('F10:H10');
        $objPHPExcel->getActiveSheet()->mergeCells('J10:L10');*/
        
        /*$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(2.14); 
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(6.34); 
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(8); 
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth(15); //KODE
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(10)->setWidth(23); //NAMA OBAT
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(11)->setWidth(23); //NAMA OBAT
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(12)->setWidth(15); //NAMA OBAT
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(13)->setWidth(15); //SATUAN
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(14)->setWidth(15); //TGL EXPIRE
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(15)->setWidth(12); //QTY*/
        
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(4.14); //NO
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(15); //NODISTRIBUSI
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(40);  //TGL DISTRIBUSI
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(15); //UNIT APOTEK
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(10); //KODE OBAT
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(10); //NAMA OBAT
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(10); //NAMA OBAT
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(10); //NAMA OBAT
        //$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(10); //SATUAN
        //$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(10); //TGL EXPIRE
        
        for($x='A';$x<='H';$x++){ //bwt judul2nya
            $objPHPExcel->getActiveSheet()->getStyle($x.'2')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
        }   
        for($x='A';$x<='H';$x++){
            $objPHPExcel->getActiveSheet()->getStyle($x.'3')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
        }   
        for($x='A';$x<='H';$x++){
            $objPHPExcel->getActiveSheet()->getStyle($x.'4')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
        }   
        for($x='A';$x<='H';$x++){
            $objPHPExcel->getActiveSheet()->getStyle($x.'6')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
        }
        for($x='A';$x<='H';$x++){
                    $objPHPExcel->getActiveSheet()->getStyle($x.'7')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
                }
        for($x='A';$x<='H';$x++){
                    $objPHPExcel->getActiveSheet()->getStyle($x.'8')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
                }       
        $objPHPExcel->getActiveSheet()->setCellValue ('A6','LAPORAN PENERIMAAN OBAT');
        
        if($kd_unit_apt==''){ $objPHPExcel->getActiveSheet()->setCellValue ('A7','Sermber Dana: Semua Sumber');}
        else{
            $namaunit=$this->mlaporanapt->namaUnit($kd_unit_apt);
            $objPHPExcel->getActiveSheet()->setCellValue ('A7','Sumber Dana : '.$namaunit);
        }
        
        if($periodeawal!='' and $periodeakhir!=''){
            $tglawal=substr($periodeawal,0,2);      $tglakhir=substr($periodeakhir,0,2);
            $blnawal=substr($periodeawal,3,2);      $blnakhir=substr($periodeakhir,3,2);
            $thnawal=substr($periodeawal,6,10);     $thnakhir=substr($periodeakhir,6,10);
            
            if($blnawal=='01'){$blnawal1='Januari';} if($blnawal=='02'){$blnawal1='Februari';}  if($blnawal=='03'){$blnawal1='Maret';} if($blnawal=='04'){$blnawal1='April';}
            if($blnawal=='05'){$blnawal1='Mei';} if($blnawal=='06'){$blnawal1='Juni';} if($blnawal=='07'){$blnawal1='Juli';} if($blnawal=='08'){$blnawal1='Agustus';}
            if($blnawal=='09'){$blnawal1='September';} if($blnawal=='10'){$blnawal1='Oktober';} if($blnawal=='11'){$blnawal1='November';} if($blnawal=='12'){$blnawal1='Desember';}
            
            if($blnakhir=='01'){$blnakhir1='Januari';} if($blnakhir=='02'){$blnakhir1='Februari';} if($blnakhir=='03'){$blnakhir1='Maret';} if($blnakhir=='04'){$blnakhir1='April';}
            if($blnakhir=='05'){$blnakhir1='Mei';} if($blnakhir=='06'){$blnakhir1='Juni';} if($blnakhir=='07'){$blnakhir1='Juli';} if($blnakhir=='08'){$blnakhir1='Agustus';}
            if($blnakhir=='09'){$blnakhir1='September';} if($blnakhir=='10'){$blnakhir1='Oktober';} if($blnakhir=='11'){$blnakhir1='November';} if($blnakhir=='12'){$blnakhir1='Desember';}         
            
            $objPHPExcel->getActiveSheet()->setCellValue ('A8','Periode : '.$tglawal.' '.$blnawal1.' '.$thnawal.' s/d '.$tglakhir.' '.$blnakhir1.' '.$thnakhir);
        }

        for($x='A';$x<='H';$x++){
            $objPHPExcel->getActiveSheet()->getStyle($x.'10')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
        
            $objPHPExcel->getActiveSheet()->getStyle($x.'10')->applyFromArray(array('font'    => array('name'      => 'calibri','horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'size'        =>12 /*untuk ukuran tulisan judul kolom2 di tabel*/,'color'     => array('rgb' => '000000')),
                                                                            'borders' => array('bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
                                                                            'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
                                                                            'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
                                                                            'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
        }       
        $objPHPExcel->getActiveSheet()->setCellValue ('A10','NO.');
        $objPHPExcel->getActiveSheet()->setCellValue ('B10','Kd Obat.');
        $objPHPExcel->getActiveSheet()->setCellValue ('C10','Nama Obat.');
        $objPHPExcel->getActiveSheet()->setCellValue ('D10','Satuan');
        $objPHPExcel->getActiveSheet()->setCellValue ('E10','Jumlah');
        $objPHPExcel->getActiveSheet()->setCellValue ('F10','Bonus');
        //$objPHPExcel->getActiveSheet()->setCellValue ('G10','SATUAN');
        //$objPHPExcel->getActiveSheet()->setCellValue ('H10','TGL. EXPIRE');
        $objPHPExcel->getActiveSheet()->setCellValue ('G10','Diskon');
        $objPHPExcel->getActiveSheet()->setCellValue ('H10','Total');
        $items=array();
        $items=$this->mlaporangfk->getPenerimaanObat($periodeawal,$periodeakhir,$kd_unit_apt,$id_supplier);
        $baris=11;
        $nomor=1;
        $total=0;
        foreach ($items as $item) {
            # code...
            for($x='A';$x<='H';$x++){
                if($x=='A'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                   
                }else if($x=='B'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                       
                }else if($x=='C'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                       
                }
                else if($x=='D'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                     
                }else if($x=='E'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                       
                }else if($x=='F'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                     
                }else if($x=='G'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                        
                }else if($x=='H'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                        
                }
            
                $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->applyFromArray(array(
                    'font'    => array('name'      => 'calibri','horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'size'      =>11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,'color'     => array('rgb' => '000000')),'borders' => array('bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')),'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
                    'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')))));
            }

            $subtotal = $item['jumlah'] + $item['bonus'];
            $objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,$nomor);
            $objPHPExcel->getActiveSheet()->setCellValue ('B'.$baris,$item['kd_obat']);
            $objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,$item['nama_obat']);
            $objPHPExcel->getActiveSheet()->setCellValue ('D'.$baris,$item['satuan_kecil'] );
            $objPHPExcel->getActiveSheet()->setCellValue ('E'.$baris,$item['jumlah']);
            $objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,$item['bonus']);           
            $objPHPExcel->getActiveSheet()->setCellValue ('G'.$baris,$item['diskon']);
            $objPHPExcel->getActiveSheet()->setCellValue ('H'.$baris,$subtotal);
            $nomor=$nomor+1; $baris=$baris+1;
        }   
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        $objWriter->save("download/laporanpenerimaanobat.xls");
        header("Location: ".base_url()."download/laporanpenerimaanobat.xls");
    }

    public function lplpopkm() {
        if(!$this->muser->isAkses("58")){
            $this->restricted();
            return false;
        }

        $bulan = date('m');
        $tahun = date('Y');
        $kd_unit_apt = '';
        $id_puskesmas = '';
        
        if($this->input->post('bulan') != ''){
            (int)$bulan=$this->input->post('bulan');
        }
        if($this->input->post('tahun') != ''){
            $tahun=$this->input->post('tahun');
        }
        if($this->input->post('id_puskesmas') != ''){
            $id_puskesmas=$this->input->post('id_puskesmas');
        }
        if($this->input->post('kd_unit_apt') != ''){
            $kd_unit_apt=$this->input->post('kd_unit_apt');
        }
        
        $cssfileheader=array(
            'bootstrap.css',
            'bootstrap-responsive.min.css',
            'font-awesome.min.css',
            'style.css',
            'prettify.css',
            'jquery-ui.css',
            'DT_bootstrap.css',
            'responsive-tables.css',
            'datepicker.css',
            'theme.css');
        $jsfileheader=array(
            'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
            'vendor/jquery-1.9.1.min.js',
            'vendor/jquery-migrate-1.1.1.min.js',
            'vendor/jquery-ui-1.10.0.custom.min.js',
            'vendor/bootstrap.min.js',
            'lib/jquery.tablesorter.min.js',
            'lib/jquery.dataTables.min.js',
            'lib/DT_bootstrap.js',
            'lib/responsive-tables.js',
            'lib/bootstrap-datepicker.js',
            'lib/bootstrap-inputmask.js',
            'lib/bootstrap-modal.js',
            'spin.js',
            'main.js');
        $dataheader=array(
            'jsfile'=>$jsfileheader,
            'cssfile'=>$cssfileheader,
            'title'=>$this->title
            );

        $jsfooter=array();
        $datafooter=array(
            'jsfile'=>$jsfooter
            );
        
        $items = $this->mlaporangfk->getLPLPOPKM($bulan, $tahun,'',$id_puskesmas);

        $data=array(
            'sumberdana'=>$this->mlaporangfk->getAll('apt_unit'),
            'puskesmasList'=>$this->mlaporangfk->getAll('gfk_puskesmas'),
            'items' => $items,
            'bulan'=>$bulan,
            'tahun'=>$tahun,
            'kd_unit_apt'=>$kd_unit_apt,
            'id_puskesmas'=>$id_puskesmas
        );

        $this->load->view('headerapotek',$dataheader);
        $this->load->view('gfk/laporangfk/persediaanobat',$data);
        // var_dump($items);
        $this->load->view('footer',$datafooter);
    }

    public function lplpopkmxls($bulan, $tahun, $kd_unit_apt,$id_puskesmas) {
        if($kd_unit_apt=="NULL")$kd_unit_apt="";
        $this->load->library('phpexcel'); 
        $this->load->library('PHPExcel/iofactory');
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
        $objPHPExcel->getActiveSheet()->mergeCells('A2:M2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:M3');
        $objPHPExcel->getActiveSheet()->mergeCells('A4:M4');
        $objPHPExcel->getActiveSheet()->mergeCells('A6:M6');
        $objPHPExcel->getActiveSheet()->mergeCells('A7:M7');
        $objPHPExcel->getActiveSheet()->mergeCells('A8:M8');

        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(4.14); //no
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(30.5); //nama obat
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(10); //satuan
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(10); //saldo awal
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(10); //penerimaan
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(10); //persediaan
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(10); //pemakaian
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(10); //sisa stok
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth(10); //stok opt
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth(10); //permintaan
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(10)->setWidth(10); //harga
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(11)->setWidth(10); //total
        
        
        for($x='A';$x<='L';$x++){ //bwt judul2nya
            $objPHPExcel->getActiveSheet()->getStyle($x.'2')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
        }   
        for($x='A';$x<='L';$x++){
            $objPHPExcel->getActiveSheet()->getStyle($x.'3')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
        }   
        for($x='A';$x<='L';$x++){
            $objPHPExcel->getActiveSheet()->getStyle($x.'4')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
        }   
        for($x='A';$x<='L';$x++){
            $objPHPExcel->getActiveSheet()->getStyle($x.'6')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
        }
        for($x='A';$x<='L';$x++){
            $objPHPExcel->getActiveSheet()->getStyle($x.'7')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
        }
        for($x='A';$x<='L';$x++){
            $objPHPExcel->getActiveSheet()->getStyle($x.'8')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
        }
        $profil=$this->mlaporanapt->ambilItemData('profil');        
        $objPHPExcel->getActiveSheet()->setCellValue ('A6','LAPORAN LPLPO PUSKESMAS');       
        $bulan1="";
        if($bulan=='01'){$bulan1='Januari';}     if($bulan=='02'){$bulan1='Februari';}  if($bulan=='03'){$bulan1='Maret';}    if($bulan=='04'){$bulan1='April';}
        if($bulan=='05'){$bulan1='Mei';}         if($bulan=='06'){$bulan1='Juni';}      if($bulan=='07'){$bulan1='Juli';}     if($bulan=='08'){$bulan1='Agustus';}
        if($bulan=='09'){$bulan1='September';}   if($bulan=='10'){$bulan1='Oktober';}   if($bulan=='11'){$bulan1='November';} if($bulan=='12'){$bulan1='Desember';}
        $objPHPExcel->getActiveSheet()->setCellValue ('A7',$bulan1.' '.$tahun);
       // $namaunit=$this->mlaporanapt->namaUnit($kd_unit_apt);
        //$objPHPExcel->getActiveSheet()->setCellValue ('A8',$namaunit);
        
        for($x='A';$x<='J';$x++){
            $objPHPExcel->getActiveSheet()->getStyle($x.'10')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
            $objPHPExcel->getActiveSheet()->getStyle($x.'11')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
        
            $objPHPExcel->getActiveSheet()->getStyle($x.'10')->applyFromArray(array('font'    => array('name'      => 'calibri','horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'size'        =>11 /*untuk ukuran tulisan judul kolom2 di tabel*/,'color'     => array('rgb' => '000000')),
                                                                            'borders' => array('bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
                                                                            'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
                                                                            'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
                                                                            'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $objPHPExcel->getActiveSheet()->getStyle($x.'11')->applyFromArray(array('font'    => array('name'      => 'calibri','horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'size'        =>11 /*untuk ukuran tulisan judul kolom2 di tabel*/,'color'     => array('rgb' => '000000')),
                                                                            'borders' => array('bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
                                                                            'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
                                                                            'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
                                                                            'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
        }       
            
        $objPHPExcel->getActiveSheet()->setCellValue ('A10','NO.');  
        $objPHPExcel->getActiveSheet()->setCellValue ('B10','NAMA OBAT');
        $objPHPExcel->getActiveSheet()->setCellValue ('C10','SATUAN');
        $objPHPExcel->getActiveSheet()->setCellValue ('D10','SALDO AWAL');
        $objPHPExcel->getActiveSheet()->setCellValue ('E10','PENERIMAAN');
        $objPHPExcel->getActiveSheet()->setCellValue ('F10','PEMAKAIAN');
        $objPHPExcel->getActiveSheet()->setCellValue ('G10','SISA STOK');
        $objPHPExcel->getActiveSheet()->setCellValue ('H10','PERMINTAAN');
        $objPHPExcel->getActiveSheet()->setCellValue ('I10','HARGA');
        $objPHPExcel->getActiveSheet()->setCellValue ('J10','TOTAL');

        $items=array();
        $items=$this->mlaporangfk->getLPLPOPKM($bulan, $tahun, $kd_unit_apt,$id_puskesmas);
        //debugvar($kd_unit_apt);
        $baris=12;
        $nomor=1;
         $jum_bulan = 1; 
        foreach ($items as $item) {
            
            
            for($x='A';$x<='J';$x++){
                if($x=='A'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                   
                }else if($x=='B'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                     
                }else if($x=='C'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                        
                }else if($x=='D'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                        
                }else if($x=='E'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                        
                }else if($x=='F'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                        
                }else if($x=='G'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                        
                }else if($x=='H'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                        
                }else if($x=='I'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                        
                }else if($x=='J'){
                    $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                        
                }

                $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->applyFromArray(array(
                    'font'    => array('name'      => 'calibri','horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'size'      =>11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,'color'     => array('rgb' => '000000')),'borders' => array('bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')),'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
                    'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')))));
            }
            $item['opt']=$item['sisa']+$item['pemakaian'] + ( $item['pemakaian'] * 20/100 );
            if($item['pemakaian'] > 0){
            $item['permintaan']=$item['opt'] - $item['sisa'];
            }else{
            $item['permintaan']=0;
            }
            $objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,$nomor);
            $objPHPExcel->getActiveSheet()->setCellValue ('B'.$baris,$item['nama_obat']);
            $objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,$item['satuan_kecil']);    
            $objPHPExcel->getActiveSheet()->setCellValue ('D'.$baris,number_format($item['stok_awal'],2,'.',',')); 
            $objPHPExcel->getActiveSheet()->setCellValue ('E'.$baris,number_format($item['penerimaan'],2,'.',',')); 
            $objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,number_format($item['pemakaian'],2,'.',',')); 
            $objPHPExcel->getActiveSheet()->setCellValue ('G'.$baris,number_format($item['sisa'],2,'.',','));                 
            $objPHPExcel->getActiveSheet()->setCellValue ('H'.$baris,number_format($item['permintaan'],2,'.',','));    
            $objPHPExcel->getActiveSheet()->setCellValue ('I'.$baris,number_format($item['harga'],2,'.',','));    
            $objPHPExcel->getActiveSheet()->setCellValue ('J'.$baris,number_format($item['harga']*$item['permintaan'],2,'.',','));            
            $nomor=$nomor+1; $baris=$baris+1; 
             
        }
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        $objWriter->save("download/lplpopkm.xls");
        header("Location: ".base_url()."download/lplpopkm.xls");

    }

    public function obatkadaluarsa() {
        if(!$this->muser->isAkses("58")){
            $this->restricted();
            return false;
        }

        $hari = 90;
        $kd_unit_apt = '';
        
        if($this->input->post('hari') != '') {
            $hari=$this->input->post('hari');
        }
        if($this->input->post('kd_unit_apt') != ''){
            $kd_unit_apt=$this->input->post('kd_unit_apt');
        }
        
        $cssfileheader=array(
            'bootstrap.css',
            'bootstrap-responsive.min.css',
            'font-awesome.min.css',
            'style.css',
            'prettify.css',
            'jquery-ui.css',
            'DT_bootstrap.css',
            'responsive-tables.css',
            'datepicker.css',
            'theme.css');
        $jsfileheader=array(
            'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
            'vendor/jquery-1.9.1.min.js',
            'vendor/jquery-migrate-1.1.1.min.js',
            'vendor/jquery-ui-1.10.0.custom.min.js',
            'vendor/bootstrap.min.js',
            'lib/jquery.tablesorter.min.js',
            'lib/jquery.dataTables.min.js',
            'lib/DT_bootstrap.js',
            'lib/responsive-tables.js',
            'lib/bootstrap-datepicker.js',
            'lib/bootstrap-inputmask.js',
            'lib/bootstrap-modal.js',
            'spin.js',
            'main.js');
        $dataheader=array(
            'jsfile'=>$jsfileheader,
            'cssfile'=>$cssfileheader,
            'title'=>$this->title
            );

        $jsfooter=array();
        $datafooter=array(
            'jsfile'=>$jsfooter
            );
        
        $items = $this->mlaporangfk->getObatKadaluarsa($hari, $kd_unit_apt);

        $data=array(
            'sumberdana'=>$this->mlaporangfk->getAll('apt_unit'),
            'items' => $items,
            'kd_unit_apt'=>$kd_unit_apt,
            'hari' => $hari,
        );

        $this->load->view('headerapotek',$dataheader);
        $this->load->view('gfk/laporangfk/obatkadaluarsa',$data);
        $this->load->view('footer',$datafooter);
    }

    // public function excelObatKadaluarsa($hari, $kd_unit_apt) {
    //     if(strtolower($kd_unit_apt)=="null")$kd_unit_apt="";
    //     $this->load->library('phpexcel'); 
    //     $this->load->library('PHPExcel/iofactory');
    //     $objPHPExcel = new PHPExcel(); 
    //     $objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
    //     $objPHPExcel->getActiveSheet()->mergeCells('A2:M2');
    //     $objPHPExcel->getActiveSheet()->mergeCells('A3:M3');
    //     $objPHPExcel->getActiveSheet()->mergeCells('A4:M4');
    //     $objPHPExcel->getActiveSheet()->mergeCells('A6:M6');
    //     $objPHPExcel->getActiveSheet()->mergeCells('A7:M7');
    //     $objPHPExcel->getActiveSheet()->mergeCells('A8:M8');

    //     $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(4.14); //no
    //     $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(30.5); //nama obat
    //     $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(10); //satuan
    //     $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(10); //saldo awal
    //     $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(10); //penerimaan
    //     $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(10); //persediaan
    //     $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(10); //pemakaian
    //     $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(10); //sisa stok
    //     $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth(10); //stok opt
    //     $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth(10); //permintaan
    //     $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(10)->setWidth(10); //harga
    //     $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(11)->setWidth(10); //total
        
        
    //     for($x='A';$x<='L';$x++){ //bwt judul2nya
    //         $objPHPExcel->getActiveSheet()->getStyle($x.'2')->getAlignment()->applyFromArray(
    //             array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
    //     }   
    //     for($x='A';$x<='L';$x++){
    //         $objPHPExcel->getActiveSheet()->getStyle($x.'3')->getAlignment()->applyFromArray(
    //             array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
    //     }   
    //     for($x='A';$x<='L';$x++){
    //         $objPHPExcel->getActiveSheet()->getStyle($x.'4')->getAlignment()->applyFromArray(
    //             array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
    //     }   
    //     for($x='A';$x<='L';$x++){
    //         $objPHPExcel->getActiveSheet()->getStyle($x.'6')->getAlignment()->applyFromArray(
    //             array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
    //     }
    //     for($x='A';$x<='L';$x++){
    //         $objPHPExcel->getActiveSheet()->getStyle($x.'7')->getAlignment()->applyFromArray(
    //             array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
    //     }
    //     for($x='A';$x<='L';$x++){
    //         $objPHPExcel->getActiveSheet()->getStyle($x.'8')->getAlignment()->applyFromArray(
    //             array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
    //     }
    //     $profil=$this->mlaporanapt->ambilItemData('profil');        
    //     $objPHPExcel->getActiveSheet()->setCellValue ('A6','LAPORAN OBAT KADALUARSA');       
    //     $bulan1="";
    //     // if($bulan=='01'){$bulan1='Januari';}     if($bulan=='02'){$bulan1='Februari';}  if($bulan=='03'){$bulan1='Maret';}    if($bulan=='04'){$bulan1='April';}
    //     // if($bulan=='05'){$bulan1='Mei';}         if($bulan=='06'){$bulan1='Juni';}      if($bulan=='07'){$bulan1='Juli';}     if($bulan=='08'){$bulan1='Agustus';}
    //     // if($bulan=='09'){$bulan1='September';}   if($bulan=='10'){$bulan1='Oktober';}   if($bulan=='11'){$bulan1='November';} if($bulan=='12'){$bulan1='Desember';}
    //     $objPHPExcel->getActiveSheet()->setCellValue ('A7', date('d-m-Y', strtotime("+ " . $hari . " day")));
    //     $namaunit=$this->mlaporanapt->namaUnit($kd_unit_apt);
    //     $objPHPExcel->getActiveSheet()->setCellValue ('A8',$namaunit);
        
    //     for($x='A';$x<='L';$x++){
    //         $objPHPExcel->getActiveSheet()->getStyle($x.'10')->getAlignment()->applyFromArray(
    //             array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
    //         $objPHPExcel->getActiveSheet()->getStyle($x.'11')->getAlignment()->applyFromArray(
    //             array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
        
    //         $objPHPExcel->getActiveSheet()->getStyle($x.'10')->applyFromArray(array('font'    => array('name'      => 'calibri','horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //                                                                         'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'size'        =>11 /*untuk ukuran tulisan judul kolom2 di tabel*/,'color'     => array('rgb' => '000000')),
    //                                                                         'borders' => array('bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
    //                                                                         'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
    //                                                                         'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
    //                                                                         'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
    //         $objPHPExcel->getActiveSheet()->getStyle($x.'11')->applyFromArray(array('font'    => array('name'      => 'calibri','horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //                                                                         'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'size'        =>11 /*untuk ukuran tulisan judul kolom2 di tabel*/,'color'     => array('rgb' => '000000')),
    //                                                                         'borders' => array('bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
    //                                                                         'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
    //                                                                         'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
    //                                                                         'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
    //     }       
            
    //     $objPHPExcel->getActiveSheet()->setCellValue ('A10','NO.');  
    //     $objPHPExcel->getActiveSheet()->setCellValue ('B10','KD OBAT');
    //     $objPHPExcel->getActiveSheet()->setCellValue ('C10','NAMA OBAT');
    //     $objPHPExcel->getActiveSheet()->setCellValue ('D10','SATUAN');
    //     $objPHPExcel->getActiveSheet()->setCellValue ('E10','UNIT');
    //     $objPHPExcel->getActiveSheet()->setCellValue ('F10','TGL_EXPIRE');
    //     $objPHPExcel->getActiveSheet()->setCellValue ('G10','JUMLAH');

    //     $items=array();
    //     $items=$this->mlaporangfk->getObatKadaluarsa($hari, $kd_unit_apt);
    //     // var_dump($hari, $kd_unit_apt, $items);
    //     // exit();
    //     //debugvar($kd_unit_apt);
    //     $baris=12;
    //     $nomor=1;

    //     foreach ($items as $item) {
            
            
    //         for($x='A';$x<='L';$x++){
    //             if($x=='A'){
    //                 $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
    //                     array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                   
    //             }else if($x=='B'){
    //                 $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
    //                     array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                     
    //             }else if($x=='C'){
    //                 $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
    //                     array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                        
    //             }else if($x=='D'){
    //                 $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
    //                     array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                        
    //             }else if($x=='E'){
    //                 $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
    //                     array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                        
    //             }else if($x=='F'){
    //                 $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
    //                     array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                        
    //             }else if($x=='G'){
    //                 $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
    //                     array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));                                        
    //             }
    //             $objPHPExcel->getActiveSheet()->getStyle($x.$baris)->applyFromArray(array(
    //                 'font'    => array('name'      => 'calibri','horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //                 'size'      =>11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,'color'     => array('rgb' => '000000')),'borders' => array('bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,
    //                 'color' => array('rgb' => '000000')),'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
    //                 'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,
    //                 'color' => array('rgb' => '000000')))));
    //         }
    //         $objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,$nomor);
    //         $objPHPExcel->getActiveSheet()->setCellValue ('B'.$baris,$item['kd_obat']);
    //         $objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,$item['nama_obat']);    
    //         $objPHPExcel->getActiveSheet()->setCellValue ('D'.$baris,$item['satuan_kecil']); 
    //         $objPHPExcel->getActiveSheet()->setCellValue ('E'.$baris,$item['nama_unit_apt']); 
    //         $objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,$item['tgl_expire']); 
    //         $objPHPExcel->getActiveSheet()->setCellValue ('G'.$baris,number_format($item['jml_stok']));
    //         $nomor=$nomor+1; $baris=$baris+1; 
             
    //     }
    //     $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5'); 
    //     $objWriter->save("download/obatkadaluarsa.xls");
    //     header("Location: ".base_url()."download/obatkadaluarsa.xls");

    // }

    public function excelObatKadaluarsa($hari, $kd_unit_apt) {
        if(strtolower($kd_unit_apt) == 'null') {
            $kd_unit_apt = null;
        }
        $this->load->library('phpexcel'); 
        $this->load->library('PHPExcel/iofactory');
        $objPHPExcel = new PHPExcel();
        $sheet = $objPHPExcel->getActiveSheet();

        // set columns width : 134 total
        $sheet->getColumnDimension('A')->setWidth(5); // no
        $sheet->getColumnDimension('B')->setWidth(20); // kode obat
        $sheet->getColumnDimension('C')->setWidth(40); // nama obat
        $sheet->getColumnDimension('D')->setWidth(15); // satuan kecil
        $sheet->getColumnDimension('E')->setWidth(15); // unit
        $sheet->getColumnDimension('F')->setWidth(15); // tgl expire
        $sheet->getColumnDimension('G')->setWidth(15); // jumlah

        //merge cells for title and description
        for($i = 2; $i <= 4; $i++) {
            $sheet->mergeCells('A'. $i . ':G' . $i);
        }

        // cells alignment config for title and description
        $sheet->getStyle('A2:E4')->getAlignment()->applyFromArray(array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'rotation' => 0,
        ));

        // print title and descriptio

        // change
        $sheet->setCellValue('A2', 'LAPORAN OBAT KADALUARSA');
        $sheet->setCellValue('A3', 'INTERVAL ' . $hari .' Hari');
        $sheet->setCellValue('A4', $kd_unit_apt ? $this->mlaporanapt->namaUnit($kd_unit_apt) : ' SEMUA UNIT');

        // set styles for table
        $styleArray = array(
            'font' => array (
                'bold' => true,
                'name' => 'calibri',
                'size' => 11,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 
                    'color' => array('rgb' => '000000')
                ),
            ),
        );

        // set the heading style and values
        $sheet->getStyle('A6:G6')->applyFromArray($styleArray);

        $sheet->setCellValue('A6', 'NO.');
        $sheet->setCellValue('B6', 'KODE OBAT');
        $sheet->setCellValue('C6', 'NAMA OBAT');
        $sheet->setCellValue('D6', 'SATUAN KECIL');
        $sheet->setCellValue('E6', 'UNIT');
        $sheet->setCellValue('F6', 'TGL. EXPIRE');
        $sheet->setCellValue('G6', 'JUMLAH');

        // datacells value
        $items = $this->mlaporangfk->getObatKadaluarsa($hari, $kd_unit_apt); 

        $rowOffset = 6;
        $counter = 0;

        $styleArray['font']['bold'] = false;
        foreach($items as $item) {
            $rowCellNum = ++$counter + $rowOffset;
            $styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
            $sheet->getStyle('A' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->setCellValue('A' . $rowCellNum, $counter);                  // col 1: no
            
            $styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
            $sheet->getStyle('B' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->setCellValue('B' . $rowCellNum, $item['kd_obat']);          // col 2: kode obat
            
            $styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
            $sheet->getStyle('C' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->setCellValue('C' . $rowCellNum, $item['nama_obat']);        // col 3: nama obat
            
            $styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
            $sheet->getStyle('D' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->getStyle('E' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->getStyle('F' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->setCellValue('D' . $rowCellNum, $item['satuan_kecil']);     // col 4: satuan_kecil
            $sheet->setCellValue('E' . $rowCellNum, $item['nama_unit_apt']);    // col 5: unit
            $sheet->setCellValue('F' . $rowCellNum, $item['tgl_expire']);       // col 6: tgl_expire
            
            $styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
            $sheet->getStyle('G' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->setCellValue('G' . $rowCellNum, trim(number_format($item['jml_stok'], 0, '.', ',')));         // col 7: jumlah
        }

        // export to file           
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');         
        $objWriter->save("download/obatkadaluarsa.xls");
        header("Location: ".base_url()."download/obatkadaluarsa.xls");
    }
}