<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Aptpemesanan extends CI_Controller {
class Aptpemesanan extends Rumahsakit {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	protected $title='GFK KOTA BONTANG';

	public function __construct(){
		parent::__construct();
		$this->load->model('apotek/mpemesananapt');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		
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
	
	public function index()	{
		if(!$this->muser->isAkses("37")){
			$this->restricted();
			return false;
		}
		
		/*$no_pemesanan=$this->input->post('no_pemesanan');
		$periodeawal=$this->input->post('periodeawal');
		$periodeakhir=$this->input->post('periodeakhir');*/
		
		$no_pemesanan='';
		//$no_pemesanan=$this->input->post('no_pemesanan');
		$periodeawal=date('d-m-Y');
		$periodeakhir=date('d-m-Y');
		
		if($this->input->post('no_pemesanan')!=''){
			$no_pemesanan=$this->input->post('no_pemesanan');
		}
		if($this->input->post('periodeawal')!=''){
			$periodeawal=$this->input->post('periodeawal');
		}
		if($this->input->post('periodeakhir')!=''){
			$periodeakhir=$this->input->post('periodeakhir');
		}
		
		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js','vendor/jquery-1.9.1.min.js','vendor/jquery-migrate-1.1.1.min.js','vendor/jquery-ui-1.10.0.custom.min.js','vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js','lib/jquery.dataTables.min.js','lib/DT_bootstrap.js','lib/responsive-tables.js',
							'lib/bootstrap-datepicker.js',
							'lib/bootstrap-inputmask.js',
							'spin.js',
							'main.js');
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		
		$data=array('no_pemesanan'=>$no_pemesanan,
					'periodeawal'=>$periodeawal,
					'periodeakhir'=>$periodeakhir,
					'items'=>$this->mpemesananapt->ambilDataPemesanan($no_pemesanan,$periodeawal,$periodeakhir));
		
		//debugvar($items);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/pemesanan/aptpemesanan',$data);
		$this->load->view('footer',$datafooter);
	}
		
	public function tambahpemesananapt(){
		if(!$this->muser->isAkses("38")){
			$this->restricted();
			return false;
		}
		$kode=""; $no_pemesanan=""; 
		
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
							'lib/bootstrap-timepicker.js',
							'lib/bootstrap-inputmask.js',
							'lib/bootstrap-modal.js',
							'spin.js',
							'main.js');
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		
		$data=array('no_pemesanan'=>'',
					'datasupplier'=>$this->mpemesananapt->ambilData('apt_supplier'),
					'itemtransaksi'=>$this->mpemesananapt->ambilItemData($no_pemesanan),
					'itemsdetiltransaksi'=>$this->mpemesananapt->getAllDetailPemesanan($no_pemesanan),
					'items'=>$this->mpemesananapt->ambilDataPemesanan('','',''),
					'itemapprove'=>$this->mpemesananapt->ambilApprover(),
					'applogin'=>$this->mpemesananapt->ambilApp()
					);
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/pemesanan/tambahpemesananapt',$data);
		$this->load->view('footer',$datafooter);	
	}
	
	public function ubahpemesanan($no_pemesanan=""){
		if(!$this->muser->isAkses("39")){
			$this->restricted();
			return false;
		}
		$sum="";
		if(empty($no_pemesanan))return false;
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
							'lib/bootstrap-timepicker.js',
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
				
		$data=array('datasupplier'=>$this->mpemesananapt->ambilData('apt_supplier'),
					'no_pemesanan'=>$no_pemesanan,
					'itemtransaksi'=>$this->mpemesananapt->ambilItemData($no_pemesanan),
					'itemsdetiltransaksi'=>$this->mpemesananapt->getAllDetailPemesanan($no_pemesanan),
					'items'=>$this->mpemesananapt->ambilDataPemesanan('','',''),
					'itemapprove'=>$this->mpemesananapt->tampilApprover($no_pemesanan),
					'applogin'=>$this->mpemesananapt->ambilApp()
					);
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/pemesanan/tambahpemesananapt',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function simpanpemesanan(){
		$msg=array();
		$submit=$this->input->post('submit');
		$no_pemesanan=$this->input->post('no_pemesanan');
		$tgl_pemesanan=$this->input->post('tgl_pemesanan');
		$tgl_tempo=$this->input->post('tgl_tempo');
		$kd_supplier=$this->input->post('kd_supplier');
		$nama=$this->input->post('nama');
		$keterangan=$this->input->post('keterangan');
		
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$pembanding=$this->input->post('pembanding');
		$qty_box=$this->input->post('qty_box'); 
		$qty_kcl=$this->input->post('qty_kcl');
		$harga_beli=$this->input->post('harga_beli');
		$diskon=$this->input->post('diskon');
		$ppn=$this->input->post('ppn');		
		$jam_pemesanan=$this->input->post('jam_pemesanan');
		$jam_pemesanan1=$this->input->post('jam_pemesanan1');
		
		$nama_pegawai=$this->input->post('nama_pegawai');
		$status=$this->input->post('status');
		$kd_app=$this->input->post('kd_app');
		$kd_applogin=$this->input->post('kd_applogin');
		
		//$kd_user=$this->session->userdata('id_user'); 
		$this->db->trans_start();
		$msg['no_pemesanan']=$no_pemesanan;
		if($this->mpemesananapt->isNumberExist($no_pemesanan)){ //edit
			$tgl_pemesanan1=convertDate($tgl_pemesanan)." ".$jam_pemesanan1;
		    $datapemesananedit=array('kd_supplier'=>$kd_supplier,
									//'tgl_pemesanan'=>convertDate($tgl_pemesanan),
									'tgl_pemesanan'=>$tgl_pemesanan1,
									'keterangan'=>$keterangan,
									'tgl_tempo'=>convertDate($tgl_tempo));
				
			$this->mpemesananapt->update('apt_pemesanan',$datapemesananedit,'no_pemesanan="'.$no_pemesanan.'"');
			$urut=1;
			
			$this->mpemesananapt->delete('apt_pemesanan_detail','no_pemesanan="'.$no_pemesanan.'"');
			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					if(empty($value))continue;					
					$datadetiledit=array('no_pemesanan'=>$no_pemesanan,'urut'=>$urut,
										'kd_obat'=>$value,'qty_box'=>$qty_box[$key],
										'qty_kcl'=>$qty_kcl[$key],'harga_beli'=>$harga_beli[$key],
										'diskon'=>$diskon[$key],'ppn'=>$ppn[$key]);
					$this->mpemesananapt->insert('apt_pemesanan_detail',$datadetiledit);										
					$urut++;
				}
			}
			$msg['pesan']="Data Berhasil Di Update";
		}else { //simpan baru
			$tgl=explode("-", $tgl_pemesanan);
			$kode=$this->mpemesananapt->autoNumber($tgl[2],$tgl[1]);
			$kodebaru=$kode+1;
			$kodebaru=str_pad($kodebaru,4,0,STR_PAD_LEFT); 
			$no_pemesanan="PM.".$tgl[2].".".$tgl[1].".".$kodebaru;
			$msg['no_pemesanan']=$no_pemesanan;
			$tgl_pemesanan1=convertDate($tgl_pemesanan)." ".$jam_pemesanan;
			$datapemesanan=array('no_pemesanan'=>$no_pemesanan,
									'kd_supplier'=>$kd_supplier,
									//'tgl_pemesanan'=>convertDate($tgl_pemesanan),
									'tgl_pemesanan'=>$tgl_pemesanan1,
									'keterangan'=>$keterangan,
									'tgl_tempo'=>convertDate($tgl_tempo),
									'status_approve'=>0,
									'no_grouping'=>'-');
			
			$this->mpemesananapt->insert('apt_pemesanan',$datapemesanan);
			$urut=1;
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					# code...
					if(empty($value))continue;										
					$datadetil=array('no_pemesanan'=>$no_pemesanan,
									'urut'=>$urut,
									'kd_obat'=>$value,
									'qty_box'=>$qty_box[$key],
									'qty_kcl'=>$qty_kcl[$key],
									'harga_beli'=>$harga_beli[$key],
									'diskon'=>$diskon[$key],
									'ppn'=>$ppn[$key],
									'jml_penerimaan'=>0);
					//debugvar($datadetil);
					$this->mpemesananapt->insert('apt_pemesanan_detail',$datadetil);	
										
					$urut++;
				}
			}
			
			if(!empty($kd_app)){
				foreach ($kd_app as $key => $value){
					if(empty($value))continue;
					$dataapp=array('kd_app'=>$value,
							'no_pemesanan'=>$no_pemesanan,
							'is_app'=>0);
					$this->mpemesananapt->insert('app_pemesanan',$dataapp);
				}
			}	
			
			$msg['pesan']="Data Berhasil Di Simpan";
			$msg['posting']=3;
		}
		$msg['status']=1;
		$msg['keluar']=0;
		if($submit=="simpankeluar"){
			$msg['keluar']=1;
		}
		if($submit=="approve"){
			if(empty($no_pemesanan))return false;
			$updateapprove=array('is_app'=>1);
			$this->mpemesananapt->update('app_pemesanan',$updateapprove,'kd_app="'.$kd_applogin.'" and no_pemesanan="'.$no_pemesanan.'"');
			
			$count=$this->mpemesananapt->countApprover($no_pemesanan);
			$countisap=$this->mpemesananapt->countIsApp($no_pemesanan);
			if($countisap==$count){
				$up=array('status_approve'=>1);
				$this->mpemesananapt->update('apt_pemesanan',$up,'no_pemesanan="'.$no_pemesanan.'"');
			}
			$this->db->trans_complete();
			$msg['status']=1;
			$msg['posting']=3;
			$msg['pesan']="Approve Pemesanan Berhasil";
			echo json_encode($msg);
			return false;
		}
		$this->db->trans_complete();
		echo json_encode($msg);
	}
	
	public function hapuspemesanan($no_pemesanan=""){
		if(!$this->muser->isAkses("40")){
			$this->restricted();
			return false;
		}
		//$kd_unit_apt="";
		$msg=array();
		$error=0;
		$this->db->trans_start();
		if(empty($no_pemesanan)){
			$msg['pesan']="Pilih Transaksi yang akan di hapus";
			echo "<script>Alert('".$msg['pesan']."')</script>";
		}else{		
			$this->mpemesananapt->delete('apt_pemesanan','no_pemesanan="'.$no_pemesanan.'"');
			$this->mpemesananapt->delete('apt_pemesanan_detail','no_pemesanan="'.$no_pemesanan.'"');	
			$this->db->trans_complete();		
			redirect('/transapotek/aptpemesanan/');
		}
	}
		
	public function ambildaftarobatbynama(){
		$nama_obat=$this->input->post('nama_obat');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt_gudang');
		
		/*$this->datatables->select("apt_obat.kd_obat as kd_obat1, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, 
								ifnull( sum(substring_index( apt_stok_unit.jml_stok, '.', 1 )) , 0 ) as jml_stok, 
								'Pilihan' as pilihan,apt_obat.pembanding,
								(select if( count(kd_obat)>0, max_stok, 0 ) from apt_setting_obat where kd_obat=kd_obat1 and kd_unit_apt='$kd_unit_apt') as max_stok,
								apt_obat.harga_beli",false);*/
		$this->datatables->select("apt_obat.kd_obat as kd_obat1, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, 
								ifnull( sum(substring_index( apt_stok_unit.jml_stok, '.', 1 )) , 0 ) as jml_stok, 
								'Pilihan' as pilihan,apt_obat.pembanding,
								(select if( count(kd_obat)>0, max_stok, 0 ) from apt_setting_obat where kd_obat=kd_obat1 and kd_unit_apt='$kd_unit_apt') as max_stok,
								apt_obat.harga_dasar",false);
		
		$this->datatables->from("apt_obat");
		//$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6","$7","$8","$9")\'>Pilih</a>','kd_obat1, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, apt_obat.pembanding, max_stok,apt_obat.harga_beli');		
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6","$7","$8","$9")\'>Pilih</a>','kd_obat1, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, apt_obat.pembanding, max_stok,apt_obat.harga_dasar');		
		if(!empty($nama_obat))$this->datatables->like('apt_obat.nama_obat',$nama_obat,'both');
		
		$this->datatables->where('apt_stok_unit.kd_unit_apt',$kd_unit_apt);
		
		$this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil','left');
		$this->datatables->join('apt_stok_unit','apt_obat.kd_obat=apt_stok_unit.kd_obat','left');
		$this->datatables->join('apt_unit','apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt','left');
		$this->db->group_by("apt_stok_unit.kd_obat");
		$results = $this->datatables->generate();
		echo ($results);	
	}
	
	public function ambildaftarobatbykode(){
		$kd_obat=$this->input->post('kd_obat');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt_gudang');
		
		/*$this->datatables->select("apt_obat.kd_obat as kd_obat1, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, 
								ifnull( sum(substring_index( apt_stok_unit.jml_stok, '.', 1 )) , 0 ) as jml_stok, 
								'Pilihan' as pilihan,apt_obat.pembanding,
								(select if( count(kd_obat)>0, max_stok, 0 ) from apt_setting_obat where kd_obat=kd_obat1 and kd_unit_apt='$kd_unit_apt') as max_stok,
								apt_obat.harga_beli",false);*/
		$this->datatables->select("apt_obat.kd_obat as kd_obat1, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, 
								ifnull( sum(substring_index( apt_stok_unit.jml_stok, '.', 1 )) , 0 ) as jml_stok, 
								'Pilihan' as pilihan,apt_obat.pembanding,
								(select if( count(kd_obat)>0, max_stok, 0 ) from apt_setting_obat where kd_obat=kd_obat1 and kd_unit_apt='$kd_unit_apt') as max_stok,
								apt_obat.harga_dasar",false);
		
		$this->datatables->from("apt_obat");
		//$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6","$7","$8","$9")\'>Pilih</a>','kd_obat1, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, apt_obat.pembanding, max_stok,apt_obat.harga_beli');		
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6","$7","$8","$9")\'>Pilih</a>','kd_obat1, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, apt_obat.pembanding, max_stok,apt_obat.harga_dasar');		
		if(!empty($kd_obat))$this->datatables->like('apt_obat.kd_obat',$kd_obat,'both');
		
		$this->datatables->where('apt_stok_unit.kd_unit_apt',$kd_unit_apt);
		
		$this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil','left');
		$this->datatables->join('apt_stok_unit','apt_obat.kd_obat=apt_stok_unit.kd_obat','left');
		$this->datatables->join('apt_unit','apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt','left');
		$this->db->group_by("apt_stok_unit.kd_obat");
		$results = $this->datatables->generate();
		echo ($results);		
	}
	
	public function ambilsupplierbykode(){
		$q=$this->input->get('query');
		$items=$this->mpemesananapt->ambilData3($q);
		echo json_encode($items);
	}
	
	public function ambilsupplierbynama(){
		$q=$this->input->get('query');
		$items=$this->mpemesananapt->ambilData4($q);
		echo json_encode($items);
	}
	
	public function periksapemesanan() {
		$msg=array();
		$submit=$this->input->post('submit');
		$no_pemesanan=$this->input->post('no_pemesanan');
		$tgl_pemesanan=$this->input->post('tgl_pemesanan');
		$tgl_tempo=$this->input->post('tgl_tempo');
		$kd_supplier=$this->input->post('kd_supplier');
		$nama=$this->input->post('nama');
		$keterangan=$this->input->post('keterangan');
		
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$pembanding=$this->input->post('pembanding');
		$qty_box=$this->input->post('qty_box'); 
		$qty_kcl=$this->input->post('qty_kcl');
		$harga_beli=$this->input->post('harga_beli');
		$diskon=$this->input->post('diskon');
		$ppn=$this->input->post('ppn');
		
		$nama_pegawai=$this->input->post('nama_pegawai');
		$status=$this->input->post('status');
		$kd_app=$this->input->post('kd_app');
		$kd_applogin=$this->input->post('kd_applogin');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="approve"){
			if($this->mpemesananapt->isAppExist($no_pemesanan,$kd_applogin)){
				$isapp=$this->mpemesananapt->statusisaplogin($no_pemesanan,$kd_applogin);
				if($isapp==1){
					$jumlaherror++;
					$msg['id'][]="no_pemesanan";
					$msg['pesan'][]="Anda telah melakukan approve untuk nomor pemesanan ".$no_pemesanan;
				}
				else {
					$urutapp=$this->mpemesananapt->urutapprover($kd_applogin); //urutnya yang login				
					if($urutapp!=1){ //kalo yg login, bukan urut 1
						$urutapp1=$this->mpemesananapt->urutapprover1($urutapp,$no_pemesanan); //ambil is_app sebelumnya
						//debugvar($urutapp1);
						if($urutapp1==0){ //cek is_app sebelumnya
							$namapegawai=$this->mpemesananapt->pegawai($urutapp,$no_pemesanan); //ambil nama pegawai sbelumnya
							$jumlaherror++;
							$msg['id'][]="no_pemesanan";
							$msg['pesan'][]="Anda belum bisa melakukan approve, karena user ".$namapegawai." belum melakukan approve.";
						}						
					}
				}
			}
			else{
				$jumlaherror++;
				$msg['id'][]="no_pemesanan";
				$msg['pesan'][]="Anda tidak bisa melakukan approve untuk nomor pemesanan ini.";
			}
		}
		if($submit=="hapus"){
			if(empty($no_pemesanan)){
				$msg['pesanatas']="Pilih Transaksi yang akan di hapus";
			}else{
				$this->mpemesananapt->delete('apt_pemesanan','no_pemesanan="'.$no_pemesanan.'"');
				$this->mpemesananapt->delete('apt_pemesanan_detail','no_pemesanan="'.$no_pemesanan.'"');
				$msg['pesanatas']="Data Berhasil Di Hapus";
			}
			$msg['status']=0;
			$msg['clearform']=1;
			echo json_encode($msg);
		}		
		else{
			if(empty($kd_supplier)){
				$jumlaherror++;
				$msg['id'][]="kd_supplier";
				$msg['pesan'][]="Supplier Harus di Isi";
			}
			if(empty($nama)){
				$jumlaherror++;
				$msg['id'][]="nama";
				$msg['pesan'][]="Supplier Harus di Isi";
			}
			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value) {
					# code...
					if(empty($value))continue;
					if(empty($qty_box[$key])){
						$msg['status']=0;
						$msg['pesanlain'].="Qty Box".$value." tidak boleh Kosong <br/>";					
					}
					if(empty($harga_beli[$key])){
						$msg['status']=0;
						$msg['pesanlain'].="Harga".$value." tidak boleh Kosong <br/>";					
					}
				}
			}
			if($jumlaherror>0){
				$msg['status']=0;
				$msg['error']=$jumlaherror;
				$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
			}
		}
		echo json_encode($msg);
	}
	
	public function ambilitem()
	{
		$q=$this->input->get('query');
		$items=$this->mpemesananapt->getPemesanan($q);

		echo json_encode($items);
	}
	
	public function ambilitems()
	{
		$q=$this->input->get('query');
		$items=$this->mpemesananapt->getAllDetailPemesanan($q);

		echo json_encode($items);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
