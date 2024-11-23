<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');

//class Penjualan extends CI_Controller {
class Pemakaianpkm extends Rumahsakit {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -  
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */

    protected $title='GFK BALIKPAPAN';
    public $shift;

    public function __construct(){
        parent::__construct();
        $this->load->model('gfk/mpemakaian');
        $this->load->model('apotek/mpenjualan');
        //$kd_unit_apt=$this->session->userdata('kd_unit_apt');
        //

        $queryunitshift=$this->db->query('select * from unit_shift where kd_unit="APT"'); 
        $unitshift=$queryunitshift->row_array();
        $this->shift=$unitshift['shift'];
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

    public function index() {
        if(!$this->muser->isAkses("58")) {
            $this->restricted();

            return false;
        }

        $periodeawal = date('d-m-Y');
        $periodeakhir = date('d-m-Y');

        $unit = $this->input->post('kd_unit_apt');
        $puskesmas = $this->input->post('id_puskesmas');
        if($this->input->post('periodeawal')) {
            $periodeawal = $this->input->post('periodeawal');
        }

        if($this->input->post('periodeakhir')) {
            $periodeakhir= $this->input->post('periodeakhir');
        }

        $cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
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
            'spin.js',
            'main.js');
        $dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
        $jsfooter=array();
        $datafooter=array('jsfile'=>$jsfooter);

        $items = $this->mpemakaian->getPemakaianpkmData($periodeawal, $periodeakhir, $unit, $puskesmas);
        $unitList = $this->mpemakaian->getAll('apt_unit');
        $puskesmasList = $this->mpemakaian->getAll('gfk_puskesmas');

        $data=array(
            'periodeawal'=>$periodeawal,
            'periodeakhir' => $periodeakhir,
            'unit'=>$unit,
            'puskesmas'=>$puskesmas,
            'unitList' => $unitList,
            'puskesmasList' => $puskesmasList,
            'items'=>$items,
        );

        $this->load->view('headerapotek',$dataheader);
        $this->load->view('gfk/pemakaianpkm/index',$data);
        $this->load->view('footer',$datafooter);
    }

    public function kunjunganresep() {
        if(!$this->muser->isAkses("58")) {
           // $this->restricted();
           // return false;
        }

        $bulan = date('m');
        $bulan2 = date('m');
        $tahun = date('Y');

        $puskesmas = $this->input->post('id_puskesmas');
        if($this->input->post('bulan')) {
            $bulan = $this->input->post('bulan');
        }

        if($this->input->post('bulan2')) {
            $bulan2 = $this->input->post('bulan2');
        }

        if($this->input->post('tahun')) {
            $tahun= $this->input->post('tahun');
        }

        $cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
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
            'spin.js',
            'main.js');
        $dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
        $jsfooter=array();
        $datafooter=array('jsfile'=>$jsfooter);

        $items = $this->mpemakaian->getKunjunganResepPKMData($bulan,$bulan2, $tahun, $puskesmas);
        $puskesmasList = $this->mpemakaian->getAll('gfk_puskesmas');

        $data=array(
            'bulan'=>$bulan,
            'bulan2'=>$bulan2,
            'tahun' => $tahun,
            'puskesmasList' => $puskesmasList,
            'items'=>$items
        );

        $this->load->view('headerapotek',$dataheader);
        $this->load->view('gfk/pemakaianpkm/kunjunganresep',$data);
        $this->load->view('footer',$datafooter);
    }

    public function show($id) {

    }

    public function tambah() {
        if(!$this->muser->isAkses("58")){
            $this->restricted();
            return false;
        }
        
        $kode=""; 
        $id="";
        
        $cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
        $jsfileheader=array(
            'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
            //'vendor/jquery-1.9.1.min.js',
            'vendor/jquery-latest.js',
            'vendor/jquery-migrate-1.1.1.min.js',
            'vendor/jquery-ui-1.10.0.custom.min.js',
            'vendor/bootstrap.min.js',
            'lib/jquery.tablesorter.min.js',
            'lib/jquery.dataTables.min.js',
            'lib/DT_bootstrap.js',
            'lib/responsive-tables.js',
            'lib/bootstrap-datepicker.js',
            'lib/bootstrap-timepicker.js',
            'lib/bootstrap-inputmask.js',
            'lib/bootstrap-modal.js',
            'spin.js',
            'main.js',
            'jquery.form.js');
        $dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
        $jsfooter=array();
        $datafooter=array('jsfile'=>$jsfooter);
                
        $data=array(
            'id'=>'',
            'dataunit'=>$this->mpenjualan->ambilData('apt_unit'),
            'itemsdetiltransaksi'=>$this->mpemakaian->getAllDetailPemakaian($id),
            'itemtransaksi'=>$this->mpemakaian->ambilItemDataPemakaian($id),
            'datapuskesmas' => $this->mpenjualan->ambilData('gfk_puskesmas'),
        );
        $this->load->view('headerapotek',$dataheader);
        $this->load->view('gfk/pemakaianpkm/tambah',$data);
        $this->load->view('footer',$datafooter);    
    }

    public function tambahkunjunganresep() {
        if(!$this->muser->isAkses("58")){
           // $this->restricted();
         //   return false;
        }
        
        $kode=""; 
        $id="";
        
        $cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
        $jsfileheader=array(
            'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
            //'vendor/jquery-1.9.1.min.js',
            'vendor/jquery-latest.js',
            'vendor/jquery-migrate-1.1.1.min.js',
            'vendor/jquery-ui-1.10.0.custom.min.js',
            'vendor/bootstrap.min.js',
            'lib/jquery.tablesorter.min.js',
            'lib/jquery.dataTables.min.js',
            'lib/DT_bootstrap.js',
            'lib/responsive-tables.js',
            'lib/bootstrap-datepicker.js',
            'lib/bootstrap-timepicker.js',
            'lib/bootstrap-inputmask.js',
            'lib/bootstrap-modal.js',
            'spin.js',
            'main.js',
            'jquery.form.js');
        $dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
        $jsfooter=array();
        $datafooter=array('jsfile'=>$jsfooter);
                
        $data=array(
            'id'=>'',
            'item'=>$this->mpemakaian->ambilItemDataKunjunganResep($id),
            'datapuskesmas' => $this->mpenjualan->ambilData('gfk_puskesmas'),
        );
        $this->load->view('headerapotek',$dataheader);
        $this->load->view('gfk/pemakaianpkm/tambahkunjunganresep',$data);
        $this->load->view('footer',$datafooter);    
    }

    public function ubahkunjunganresep($id) {
        if(!$this->muser->isAkses("58")){
          //  $this->restricted();
          //  return false;
        }
                
        $cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
        $jsfileheader=array(
            'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
            //'vendor/jquery-1.9.1.min.js',
            'vendor/jquery-latest.js',
            'vendor/jquery-migrate-1.1.1.min.js',
            'vendor/jquery-ui-1.10.0.custom.min.js',
            'vendor/bootstrap.min.js',
            'lib/jquery.tablesorter.min.js',
            'lib/jquery.dataTables.min.js',
            'lib/DT_bootstrap.js',
            'lib/responsive-tables.js',
            'lib/bootstrap-datepicker.js',
            'lib/bootstrap-timepicker.js',
            'lib/bootstrap-inputmask.js',
            'lib/bootstrap-modal.js',
            'spin.js',
            'main.js',
            'jquery.form.js');
        $dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
        $jsfooter=array();
        $datafooter=array('jsfile'=>$jsfooter);
                
        $data=array(
            'id'=>'',
            'item'=>$this->mpemakaian->ambilItemDataKunjunganResep($id),
            'datapuskesmas' => $this->mpenjualan->ambilData('gfk_puskesmas'),
        );
       // debugvar($data['item']);
        $this->load->view('headerapotek',$dataheader);
        $this->load->view('gfk/pemakaianpkm/tambahkunjunganresep',$data);
        $this->load->view('footer',$datafooter);    
    }

    public function ubahpemakaianpkm($id){
        if(!$this->muser->isAkses("58")){
            $this->restricted();
            return false;
        }
        
        if(empty($id))return false;
        $cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
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
            'lib/bootstrap-timepicker.js',
            'lib/bootstrap-inputmask.js',
            'lib/bootstrap-modal.js',
            'spin.js',
            'main.js','jquery.form.js');
        $dataheader=array(
            'jsfile'=>$jsfileheader,
            'cssfile'=>$cssfileheader,
            'title'=>$this->title
            );
        $jsfooter=array();
        $datafooter=array(
            'jsfile'=>$jsfooter
            );
        $data=array(            
            'id'=>$id,
            'dataunit'=>$this->mpenjualan->ambilData('apt_unit'),
            'itemsdetiltransaksi'=>$this->mpemakaian->getAllDetailPemakaian($id),
            'itemtransaksi'=>$this->mpemakaian->ambilItemDataPemakaian($id),
            'datapuskesmas' => $this->mpenjualan->ambilData('gfk_puskesmas'),
        );
        $this->load->view('headerapotek',$dataheader);
        $this->load->view('gfk/pemakaianpkm/tambah',$data);
        $this->load->view('footer',$datafooter);
    }

    public function simpanpemakaianpkm(){
        
        $msg=array();
        $submit=$this->input->post('submit');
        $id=$this->input->post('id');
        $tgl_penjualan=$this->input->post('tgl_penjualan');
        $kd_unit_apt=$this->input->post('kd_unit_apt');
        $kd_obat=$this->input->post('kd_obat');
        $nama_obat=$this->input->post('nama_obat');
        $satuan_kecil=($this->input->post('satuan_kecil') != FALSE) ? $this->input->post('satuan_kecil') : NULL;
        $qty=$this->input->post('qty');
        $kd_user=$this->session->userdata('id_user');
        $id_puskesmas = $this->input->post('id_puskesmas');
        
        $msg['id']=$id;
        
        
        if($this->mpemakaian->isNumberExist($id)){ //edit
            $this->db->trans_start();   
            
            $datapenjualanedit=array(//'resep'=>$resep,
                                    'tgl'=>convertDate($tgl_penjualan),
                                    /*'kd_unit_apt' => $kd_unit_apt,*/
                                    'id_puskesmas' => $id_puskesmas
                                    );
            $this->mpenjualan->update('nota_keluar_obat_puskesmas',$datapenjualanedit,'id="'.$id.'"');   
            $urut=1;
            
            $this->mpenjualan->delete('obat_keluar_puskesmas','id="'.$id.'"');
            
            
            if(!empty($kd_obat)){
                foreach ($kd_obat as $key => $value){
                    if(empty($value))continue;
                    $datadetiledit=array('id'=>$id,'kd_obat'=>$value,'jumlah'=>$qty[$key]);
                    $this->mpenjualan->insert('obat_keluar_puskesmas',$datadetiledit);       
                    $urut++;
                }
            }
            $msg['pesan']="Data Berhasil Di Update";
            $msg['posting']=3;
            $this->db->trans_complete();
        }else { //simpan baru
            $this->db->trans_start();
            $datapenjualan=array(   'tgl'=>convertDate($tgl_penjualan),
                                    /*'kd_unit_apt' => $kd_unit_apt,*/
                                    'id_puskesmas' => $id_puskesmas

                                );
            
            $id=$this->mpenjualan->insert('nota_keluar_obat_puskesmas',$datapenjualan);
            $msg['id']=$id;         
            $urut=1;
            if(!empty($kd_obat)){
                foreach ($kd_obat as $key => $value){
                    # code...                    
                    $datadetiledit=array('id'=>$id,'kd_obat'=>$value,'jumlah'=>$qty[$key]);
                    $this->mpenjualan->insert('obat_keluar_puskesmas',$datadetiledit);       
                }
            }
            $msg['pesan']="Data Berhasil Di Simpan";
            $msg['posting']=3;
            
            
            
            $this->db->trans_complete();
            //die('stop');
        }
        $msg['status']=1;
        $msg['keluar']=0;
        $msg['simpanbayar']=0;
                    
        echo json_encode($msg);
    }

    public function simpankunjunganresep(){
        
        $msg=array();
        $submit=$this->input->post('submit');
        $id=$this->input->post('id');
        $id_puskesmas = $this->input->post('id_puskesmas');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $kunjungan_umum = $this->input->post('kunjungan_umum');
        $kunjungan_lansia_kader = $this->input->post('kunjungan_lansia_kader');
        $kunjungan_gakin = $this->input->post('kunjungan_gakin');
        $kunjungan_bpjs = $this->input->post('kunjungan_bpjs');
        $kunjungan_lembar_umum = $this->input->post('kunjungan_lembar_umum');
        $kunjungan_lembar_lansia_kader = $this->input->post('kunjungan_lembar_lansia_kader');
        $kunjungan_lembar_gakin = $this->input->post('kunjungan_lembar_gakin');
        $kunjungan_lembar_bpjs = $this->input->post('kunjungan_lembar_bpjs');
        $jumlah_resep = $this->input->post('jumlah_resep');
        $jumlah_ab = $this->input->post('jumlah_ab');
        $jumlah = $this->input->post('jumlah');
        $resep_lembar    = $this->input->post('resep_lembar');
        $resep_resep = $this->input->post('resep_resep');
        $resep_ab = $this->input->post('resep_ab');
        $jumlah_semua = $this->input->post('jumlah_semua');
        
        $msg['id']=$id;
        
        
        if($this->mpemakaian->isNumberExistKunjungaResep($id)){ //edit
            $this->db->trans_start();   
            
            $datapenjualanedit=array(//'resep'=>$resep,
                                    'id_puskesmas' => $id_puskesmas,
                                    'bulan' => $bulan,
                                    'tahun' => $tahun,
                                    'kunjungan_umum' => $kunjungan_umum,
                                    'kunjungan_lansia_kader' => $kunjungan_lansia_kader,
                                    'kunjungan_gakin' => $kunjungan_gakin,
                                    'kunjungan_bpjs' => $kunjungan_bpjs,
                                    'kunjungan_lembar_umum' => $kunjungan_lembar_umum,
                                    'kunjungan_lembar_lansia_kader' => $kunjungan_lembar_lansia_kader,
                                    'kunjungan_lembar_gakin' => $kunjungan_lembar_gakin,
                                    'kunjungan_lembar_bpjs' => $kunjungan_lembar_bpjs,
                                    'jumlah_resep' => $jumlah_resep,
                                    'jumlah_ab' => $jumlah_ab,
                                    'jumlah' => $jumlah,
                                    'resep_lembar' => $resep_lembar,
                                    'resep_resep' => $resep_resep,
                                    'resep_ab' => $resep_ab,
                                    'jumlah_semua' => $jumlah_semua
                                    );
            $this->mpenjualan->update('kunjungan_resep',$datapenjualanedit,'id="'.$id.'"');   
            $msg['pesan']="Data Berhasil Di Update";
            $msg['posting']=3;
            $this->db->trans_complete();
        }else { //simpan baru
            $this->db->trans_start();
            $datapenjualan=array(
                                    'id_puskesmas' => $id_puskesmas,
                                    'bulan' => $bulan,
                                    'tahun' => $tahun,
                                    'kunjungan_umum' => $kunjungan_umum,
                                    'kunjungan_lansia_kader' => $kunjungan_lansia_kader,
                                    'kunjungan_gakin' => $kunjungan_gakin,
                                    'kunjungan_bpjs' => $kunjungan_bpjs,
                                    'kunjungan_lembar_umum' => $kunjungan_lembar_umum,
                                    'kunjungan_lembar_lansia_kader' => $kunjungan_lembar_lansia_kader,
                                    'kunjungan_lembar_gakin' => $kunjungan_lembar_gakin,
                                    'kunjungan_lembar_bpjs' => $kunjungan_lembar_bpjs,
                                    'jumlah_resep' => $jumlah_resep,
                                    'jumlah_ab' => $jumlah_ab,
                                    'jumlah' => $jumlah,
                                    'resep_lembar' => $resep_lembar,
                                    'resep_resep' => $resep_resep,
                                    'resep_ab' => $resep_ab,
                                    'jumlah_semua' => $jumlah_semua
                                );
            
            $id=$this->mpenjualan->insert('kunjungan_resep',$datapenjualan);
            $msg['id']=$id;         
            $urut=1;
            $msg['pesan']="Data Berhasil Di Simpan";
            $msg['posting']=3;
            
            
            
            $this->db->trans_complete();
            //die('stop');
        }
        $msg['status']=1;
        $msg['keluar']=0;
        $msg['simpanbayar']=0;
                    
        echo json_encode($msg);
    }

    public function hapuspemakaianpkm($id="") {
        $msg=array();
        $error=0;
        if(empty($id)){
            $msg['pesan']="Pilih Transaksi yang akan di hapus";
            echo "<script>Alert('".$msg['pesan']."')</script>";
        }else{
            $this->db->trans_start();
            $this->mpenjualan->delete('obat_keluar_puskesmas','id="'.$id.'"');       
            $this->mpenjualan->delete('nota_keluar_obat_puskesmas','id="'.$id.'"');
            $this->db->trans_complete();    
            redirect('/gfk/pemakaianpkm/');
        }

    }

    public function hapuskunjunganresep($id="") {
        $msg=array();
        $error=0;
        if(empty($id)){
            $msg['pesan']="Pilih Transaksi yang akan di hapus";
            echo "<script>Alert('".$msg['pesan']."')</script>";
        }else{
            $this->db->trans_start();
            $this->mpenjualan->delete('kunjungan_resep','id="'.$id.'"');       
            $this->db->trans_complete();    
            redirect('/gfk/pemakaianpkm/kunjunganresep');
        }

    }

    public function ambildaftarobatbynama() {
        $nama_obat=$this->input->post('nama_obat');
        
        $this->datatables->select('apt_obat.kd_obat, replace(apt_obat.nama_obat,"\'","") as nama_obat, apt_satuan_kecil.satuan_kecil,"pilihan" as pilihan ',false);
        
        $this->datatables->from("apt_obat");
        //if(!empty($nama_obat))$this->datatables->like('apt_obat.nama_obat',$nama_obat,'both');
        if(!empty($nama_obat)){
            //$this->datatables->like('apt_obat.nama_obat',$nama_obat,'both');
            $this->datatables->where('apt_obat.nama_obat like "%'.$nama_obat.'%"'); 
        }
        
        $this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil');        
        $this->datatables->where('apt_obat.is_aktif','1');
        $this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3")\'>Pilih</a>','apt_obat.kd_obat, nama_obat, apt_satuan_kecil.satuan_kecil');     
        
        $results = $this->datatables->generate();
        echo ($results);
    }

}