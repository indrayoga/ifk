<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');

//class Penjualan extends CI_Controller {
class Stokopnamepkm extends Rumahsakit {

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
        $this->load->model('gfk/mstokopnamepkm');
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

        $items = $this->mstokopnamepkm->getStokopnamepkmData($periodeawal, $periodeakhir, $unit, $puskesmas);
        $unitList = $this->mstokopnamepkm->getAll('apt_unit');
        $puskesmasList = $this->mstokopnamepkm->getAll('gfk_puskesmas');

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
        $this->load->view('gfk/stokopnamepkm/index',$data);
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
            // 'jenisbayar'=>$this->mpenjualan->ambilData('apt_jenis_bayar'),
            'itemsdetiltransaksi'=>$this->mstokopnamepkm->getAllDetailStokopname($id),
            'itemtransaksi'=>$this->mstokopnamepkm->ambilItemDataStokopname($id),
            // 'itembayar'=>$this->mpenjualan->getAllDataPembayaran($no_penjualan),
            // 'itembayarform'=>$this->mpenjualan->ambilTotal($no_penjualan),
            // 'itembungkus'=>$this->mpenjualan->ambilItemData('sys_setting','key_data="TARIF_PERBUNGKUS"'),
            // 'items'=>$this->mpenjualan->ambilDataPenjualan('','','','',''),
            // 'itemsah'=>$this->mpenjualan->ambilDataPenjualan1('','','',''),
            // 'isTutup' => false,
            // 'isLunas' => false,
            'datapuskesmas' => $this->mpenjualan->ambilData('gfk_puskesmas'),
        );
        $this->load->view('headerapotek',$dataheader);
        $this->load->view('gfk/stokopnamepkm/tambah',$data);
        $this->load->view('footer',$datafooter);    
    }
    
    public function ubahstokopnamepkm($id){
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
            // 'jenisbayar'=>$this->mpenjualan->ambilData('apt_jenis_bayar'),
            'itemsdetiltransaksi'=>$this->mstokopnamepkm->getAllDetailStokopname($id),
            'itemtransaksi'=>$this->mstokopnamepkm->ambilItemDataStokopname($id),
            // 'itembayar'=>$this->mpenjualan->getAllDataPembayaran($no_penjualan),
            // 'itembayarform'=>$this->mpenjualan->ambilTotal($no_penjualan),
            // 'itembungkus'=>$this->mpenjualan->ambilItemData('sys_setting','key_data="TARIF_PERBUNGKUS"'),
            // 'items'=>$this->mpenjualan->ambilDataPenjualan('','','','',''),
            // 'itemsah'=>$this->mpenjualan->ambilDataPenjualan1('','','',''),
            // 'isTutup' => false,
            // 'isLunas' => false,
            'datapuskesmas' => $this->mpenjualan->ambilData('gfk_puskesmas'),
        );
        $this->load->view('headerapotek',$dataheader);
        $this->load->view('gfk/stokopnamepkm/tambah',$data);
        $this->load->view('footer',$datafooter);
    }

    public function simpanstokopnamepkm(){
        
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
        $tglstokopname=explode("-", $tgl_penjualan);
        $msg['id']=$id;
        
        
        if($this->mstokopnamepkm->isNumberExist($id)){ //edit
            $this->db->trans_start();   
            
            $datapenjualanedit=array(//'resep'=>$resep,
                                    'tgl'=>convertDate($tgl_penjualan),
                                    /*'kd_unit_apt' => $kd_unit_apt,*/
                                    'id_puskesmas' => $id_puskesmas
                                    );
            $this->mpenjualan->update('gfk_stokopname_puskesmas',$datapenjualanedit,'id="'.$id.'"');   
            $urut=1;
            
            $this->mpenjualan->delete('gfk_stokopname_puskesmas_detail','id="'.$id.'"');
            $this->mpenjualan->delete('apt_mutasi_obat_puskesmas','tahun="'.$tglstokopname[2].'" and bulan="'.$tglstokopname[1].'" ');
            
            
            if(!empty($kd_obat)){
                foreach ($kd_obat as $key => $value){
                    if(empty($value))continue;
                    $datadetiledit=array('id'=>$id,'kd_obat'=>$value,'jumlah'=>$qty[$key]);
                    $this->mpenjualan->insert('gfk_stokopname_puskesmas_detail',$datadetiledit);       
                    $datadetilstok=array('tahun'=>$tglstokopname[2],
                                        'bulan'=>$tglstokopname[1],
                                        'kd_obat'=>$value,
                                        'id_puskesmas'=>$id_puskesmas,
                                        'saldo_akhir'=>$qty[$key]
                                        );
                    $this->mpenjualan->insert('apt_mutasi_obat_puskesmas',$datadetilstok);       
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
            
            $id=$this->mpenjualan->insert('gfk_stokopname_puskesmas',$datapenjualan);
            $this->mpenjualan->delete('apt_mutasi_obat_puskesmas','tahun="'.$$tglstokopname[2].'" and bulan="'.$$tglstokopname[1].'" ');
            $msg['id']=$id;         
            $urut=1;
            if(!empty($kd_obat)){
                foreach ($kd_obat as $key => $value){
                    # code...                    
                    $datadetiledit=array('id'=>$id,'kd_obat'=>$value,'jumlah'=>$qty[$key]);
                    $this->mpenjualan->insert('gfk_stokopname_puskesmas_detail',$datadetiledit);       

                    $datadetilstok=array('tahun'=>$tglstokopname[2],
                                        'bulan'=>$tglstokopname[1],
                                        'kd_obat'=>$value,
                                        'id_puskesmas'=>$id_puskesmas,
                                        'saldo_akhir'=>$qty[$key]
                                        );
                    $this->mpenjualan->insert('apt_mutasi_obat_puskesmas',$datadetilstok);       
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

    public function hapusstokopnamepkm($id="") {
        $msg=array();
        $error=0;
        if(empty($id)){
            $msg['pesan']="Pilih Transaksi yang akan di hapus";
            echo "<script>Alert('".$msg['pesan']."')</script>";
        }else{
            $this->db->trans_start();
            $this->mpenjualan->delete('gfk_stokopname_puskesmas_detail','id="'.$id.'"');       
            $this->mpenjualan->delete('gfk_stokopname_puskesmas','id="'.$id.'"');
            $this->db->trans_complete();    
            redirect('/gfk/stokopnamepkm/');
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
    
    public function ambildaftarobatbykode() {
        $kd_obat=$this->input->post('kd_obat');
        $kd_unit_apt=$this->session->userdata('kd_unit_apt');
        
        $this->datatables->select("apt_stok_unit.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl_expire,
                        (apt_stok_unit.harga_pokok * apt_margin_harga.nilai_margin) as harga_jual,apt_stok_unit.jml_stok,'pilihan' as pilihan,ifnull(apt_obat.min_stok,0) as min_stok ",false);
        
        $this->datatables->from("apt_obat");
        $this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6","$7")\'>Pilih</a>','apt_stok_unit.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, tgl_expire, harga_jual,apt_stok_unit.jml_stok,min_stok');     
        if(!empty($kd_obat))$this->datatables->like('apt_obat.kd_obat',$kd_obat,'both');
        
        $this->datatables->where('apt_stok_unit.kd_unit_apt',$kd_unit_apt);
        $this->datatables->where('apt_stok_unit.jml_stok >','0');
        $this->datatables->where('apt_obat.is_aktif','1');
        
        $this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil');
        $this->datatables->join('apt_stok_unit','apt_obat.kd_obat=apt_stok_unit.kd_obat');
        $this->datatables->join('apt_golongan','apt_obat.kd_golongan=apt_golongan.kd_golongan');
        $this->datatables->join('apt_jenis_obat','apt_obat.kd_jenis_obat=apt_jenis_obat.kd_jenis_obat');
        $this->datatables->join('apt_unit','apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt');
        $this->datatables->join('apt_margin_harga ','apt_jenis_obat.kd_jenis_obat=apt_margin_harga.kd_jenis_obat and apt_golongan.kd_golongan=apt_margin_harga.kd_golongan');
        $results = $this->datatables->generate();
        echo ($results);        
    }
}
