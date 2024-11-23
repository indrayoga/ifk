<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Aptreturobat extends CI_Controller {
class Aptreturobat extends Rumahsakit {

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

	protected $title='SIM RS - Sistem Informasi Rumah Sakit';

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('utilities');
		$this->load->library('pagination');
		$this->load->model('apotek/mreturapt');
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
		if(!$this->muser->isAkses("45")){
			$this->restricted();
			return false;
		}
		
		//$no_retur=$this->input->post('no_retur');
		//$periodeawal=$this->input->post('periodeawal');
		//$periodeakhir=$this->input->post('periodeakhir');
		
		$no_retur='';
		$periodeawal=date('d-m-Y');
		$periodeakhir=date('d-m-Y');
		
		if($this->input->post('no_retur')!=''){
			$no_retur=$this->input->post('no_retur');
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
		$data=array('no_retur'=>$no_retur,
					'periodeawal'=>$periodeawal,
					'periodeakhir'=>$periodeakhir,
					'items'=>$this->mreturapt->ambilDataRetur($no_retur,$periodeawal,$periodeakhir));
		//debugvar($data);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/returobat/aptreturobat',$data);
		$this->load->view('footer',$datafooter);
	}
		
	public function tambahreturobat(){
		if(!$this->muser->isAkses("46")){
			$this->restricted();
			return false;
		}
		
		$kode=""; $no_retur=""; $kd_applogin=""; $no_penerimaan="";
		$no_penerimaan=$this->input->post('no_penerimaan');
		
		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js','vendor/jquery-1.9.1.min.js','vendor/jquery-migrate-1.1.1.min.js','vendor/jquery-ui-1.10.0.custom.min.js','vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js','lib/jquery.dataTables.min.js','lib/DT_bootstrap.js','lib/responsive-tables.js',
							'lib/bootstrap-datepicker.js',
							'lib/bootstrap-inputmask.js',
							'lib/bootstrap-timepicker.js',
							'spin.js',
							'main.js');
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		
		/*$kode=$this->mreturapt->autoNumber(date('Y'),date('m'));
		$kodebaru=$kode+1;
		$kodebaru=str_pad($kodebaru,5,0,STR_PAD_LEFT); 
		$no_retur="RTR.".date('Y').".".date('m').".".$kodebaru;*/
		
		$kd_applogin=$this->mreturapt->ambilApp();
		
		$data=array('no_retur'=>'',
					'no_penerimaan'=>$no_penerimaan,
					//'no_penerimaan'=>'',
					'itemtransaksi'=>$this->mreturapt->ambilItemDataTrans($no_retur),
					'itemsdetiltransaksi'=>$this->mreturapt->getAllDetailRetur($no_retur),
					'items'=>$this->mreturapt->ambilDataRetur('','',''),
					'itemapprove'=>$this->mreturapt->ambilApprover(),
					'kd_applogin'=>$kd_applogin
					);
		//debugvar($data);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/returobat/tambahreturobat',$data);
		$this->load->view('footer',$datafooter);	
	}
	
	public function ubahreturobat($no_retur=""){
		if(!$this->muser->isAkses("47")){
			$this->restricted();
			return false;
		}
		
		$sum="";
		$kd_applogin="";
		
		if(empty($no_retur))return false;
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
							'lib/bootstrap-timepicker.js',
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
		
		$kd_applogin=$this->mreturapt->ambilApp();
		
		$data=array(
			'no_retur'=>$no_retur,
			'itemtransaksi'=>$this->mreturapt->ambilItemDataTrans($no_retur),			
			'itemsdetiltransaksi'=>$this->mreturapt->getAllDetailRetur($no_retur),
			'items'=>$this->mreturapt->ambilDataRetur('','',''),
			'itemapprove'=>$this->mreturapt->tampilApprover($no_retur),
			'kd_applogin'=>$kd_applogin
			);
		//debugvar($data);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/returobat/tambahreturobat',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function simpanreturobat(){
		$msg=array();
		$submit=$this->input->post('submit');
		$no_retur=$this->input->post('no_retur');
		$no_penerimaan=$this->input->post('no_penerimaan');
		$no_batch=$this->input->post('no_batch');
		$tgl_penerimaan=$this->input->post('tgl_penerimaan');
		$tgl_retur=$this->input->post('tgl_retur');
		//$shift=$this->input->post('shift');
		$lunas=$this->input->post('lunas');
		$posting=$this->input->post('posting');
		$kd_supplier=$this->input->post('kd_supplier');
		$nama=$this->input->post('nama');
		$keterangan=$this->input->post('keterangan');
		$jumlah=$this->input->post('jumlah');
		//$kd_user=$this->input->post('kd_user');		
		
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$qty_kcl=$this->input->post('qty_kcl');
		$qty_box=$this->input->post('qty_box');
		$qty=$this->input->post('qty');
		$tgl_expire=$this->input->post('tgl_expire');
		$harga_beli=$this->input->post('harga_beli');
		$harga_belidisc=$this->input->post('harga_belidisc');
		$total=$this->input->post('total');
		$kd_milik=$this->input->post('kd_milik');
		$ppn_item=$this->input->post('ppn_item');
		$bonus=$this->input->post('bonus');
		
		$hasil1=$this->input->post('hasil1');
		$hasil2=$this->input->post('hasil2');
		
		$jam_retur=$this->input->post('jam_retur');
		$jam_retur1=$this->input->post('jam_retur1');
		
		$nama_pegawai=$this->input->post('nama_pegawai');
		$status=$this->input->post('status');
		$kd_app=$this->input->post('kd_app');
		$kd_applogin=$this->input->post('kd_applogin');
		
		$this->db->trans_start();
		$shift="1";
		$kd_milik="01";
		//$kd_unit_apt=$this->mreturapt->ambilKodeUnit();
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$kd_user=$this->session->userdata('id_user'); 
		$msg['no_retur']=$no_retur;
		
		/*if($submit=="tutuptrans"){
			if(empty($no_retur))return false;
			$updateretur=array('posting'=>1);
			$this->mreturapt->update('apt_retur_obat',$updateretur,'no_retur="'.$no_retur.'"');
			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					if(empty($value))continue;
					$tglexpire=convertDate($tgl_expire[$key]);
					$jml_stok_awal=$this->mreturapt->ambilStokAwal($kd_unit_apt,$value,$tglexpire);
					$sisastok=$jml_stok_awal-$qty_box[$key];
					$datastok=array('jml_stok'=>$sisastok);
					$this->mreturapt->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$kd_unit_apt.'" and kd_obat="'.$value.'" and tgl_expire="'.$tglexpire.'"');					
				}
			}		
			$updatepenerimaan=array('retur'=>1);
			$this->mreturapt->update('apt_penerimaan',$updatepenerimaan,'no_penerimaan="'.$no_penerimaan.'"');
			
			$msg['status']=1;
			$msg['posting']=1;
			$msg['pesan']="Tutup Transaksi Berhasil";
			echo json_encode($msg);
			return false;
		}*/
		/*if($submit=="bukatrans"){
			if(empty($no_retur))return false;
			$updateretur=array('posting'=>0);
			$this->mreturapt->update('apt_retur_obat',$updateretur,'no_retur="'.$no_retur.'"');
			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					if(empty($value))continue;
					$tglexpire=convertDate($tgl_expire[$key]);
					$jml_stok_awal=$this->mreturapt->ambilStokAwal($kd_unit_apt,$value,$tglexpire);
					$sisastok=$jml_stok_awal+$qty[$key];
					$datastok=array('jml_stok'=>$sisastok);
					$this->mreturapt->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$kd_unit_apt.'" and kd_obat="'.$value.'" and tgl_expire="'.$tglexpire.'"');					
				}
			}
			$updatepenerimaan=array('retur'=>0);
			$this->mreturapt->update('apt_penerimaan',$updatepenerimaan,'no_penerimaan="'.$no_penerimaan.'"');					
			
			$msg['status']=1;
			$msg['posting']=2;
			$msg['pesan']="Buka Transaksi Berhasil";
			echo json_encode($msg);
			return false;
		}*/
		if($this->mreturapt->isNumberExist($no_retur)){
			$tgl_retur1=convertDate($tgl_retur)." ".$jam_retur1;
			$datareturedit=array('shift'=>$shift,
								'no_penerimaan'=>$no_penerimaan,
								'no_batch'=>$no_batch,
								//'tgl_retur'=>convertDate($tgl_retur),
								'tgl_retur'=>$tgl_retur1,
								'jumlah'=>$jumlah,
								'lunas'=>$lunas,
								'posting'=>$posting,
								'keterangan'=>$keterangan,
								'kd_user'=>$kd_user);
			$this->mreturapt->update('apt_retur_obat',$datareturedit,'no_retur="'.$no_retur.'"');	
			$urut=1;
			$this->mreturapt->delete('apt_retur_obat_detail','no_retur="'.$no_retur.'"');
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					if(empty($value))continue;
					$datadetiledit=array('no_retur'=>$no_retur,
										'urut'=>$urut,
										'kd_unit_apt'=>$kd_unit_apt,
										'kd_obat'=>$value,
										'kd_milik'=>$kd_milik,
										'tgl_expire'=>convertDate($tgl_expire[$key]),
										'qty_kcl'=>$qty_kcl[$key],
										'harga_beli'=>$harga_beli[$key],
										'qty_box'=>$qty_box[$key],
										'ppn_item'=>$ppn_item[$key]);
					$this->mreturapt->insert('apt_retur_obat_detail',$datadetiledit);						
					$urut++;
				}
			}
			$msg['pesan']="Data Berhasil Di Update";
			$msg['tutup']=1;
		}
		else{
			$tgl=explode("-", $tgl_retur);
			$kode=$this->mreturapt->autoNumber($tgl[2],$tgl[1]);
			$kodebaru=$kode+1;
			$kodebaru=str_pad($kodebaru,3,0,STR_PAD_LEFT); 
			$no_retur="RTR.".$tgl[2].".".$tgl[1].".".$kodebaru;
			$msg['no_retur']=$no_retur;
			$tgl_retur1=convertDate($tgl_retur)." ".$jam_retur;
			$dataretur=array('no_retur'=>$no_retur,
							'shift'=>$shift,
							'no_penerimaan'=>$no_penerimaan,
							'no_batch'=>$no_batch,
							//'tgl_retur'=>convertDate($tgl_retur),
							'tgl_retur'=>$tgl_retur1,
							'jumlah'=>$jumlah,
							'lunas'=>$lunas,
							'posting'=>$posting,
							'keterangan'=>$keterangan,
							'kd_user'=>$kd_user,
							'status_approve'=>0);
			$this->mreturapt->insert('apt_retur_obat',$dataretur);
			$urut=1;
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					if(empty($value))continue;
					$datadetiledit=array('no_retur'=>$no_retur,
										'urut'=>$urut,
										'kd_unit_apt'=>$kd_unit_apt,
										'kd_obat'=>$value,
										'kd_milik'=>$kd_milik,
										'tgl_expire'=>convertDate($tgl_expire[$key]),
										'qty_kcl'=>$qty_kcl[$key],
										'harga_beli'=>$harga_beli[$key],
										'qty_box'=>$qty_box[$key],
										'ppn_item'=>$ppn_item[$key]);
					$this->mreturapt->insert('apt_retur_obat_detail',$datadetiledit);						
					$urut++;
				}
			}
			
			if(!empty($kd_app)){
				foreach ($kd_app as $key => $value){
					if(empty($value))continue;
					$dataapp=array('kd_app'=>$value,
									'no_retur'=>$no_retur,
									'is_app'=>0);
					$this->mreturapt->insert('apt_app_returpenerimaan',$dataapp);
				}
			}
			
			$msg['pesan']="Data Berhasil Di Simpan";
			$msg['tutup']=1;
		}
		$msg['status']=1;
		$msg['keluar']=0;
		
		if($submit=="approve"){
			if(empty($no_retur))return false;
			$updateapprove=array('is_app'=>1);
			$this->mreturapt->update('apt_app_returpenerimaan',$updateapprove,'kd_app="'.$kd_applogin.'" and no_retur="'.$no_retur.'"');
			
			$count=$this->mreturapt->countApprover($no_retur);
			$countisap=$this->mreturapt->countIsApp($no_retur);
			if($countisap==$count){
				$up=array('status_approve'=>1);
				$this->mreturapt->update('apt_retur_obat',$up,'no_retur="'.$no_retur.'"');
				
				$updateretur=array('posting'=>1);
				$this->mreturapt->update('apt_retur_obat',$updateretur,'no_retur="'.$no_retur.'"');
				
				if(!empty($kd_obat)){
					foreach ($kd_obat as $key => $value){
						if(empty($value))continue;
						$tglexpire=convertDate($tgl_expire[$key]);
						$jml_stok_awal=$this->mreturapt->ambilStokAwal($kd_unit_apt,$value,$tglexpire);
						$sisastok=$jml_stok_awal-$qty_box[$key];
						$datastok=array('jml_stok'=>$sisastok);
						$this->mreturapt->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$kd_unit_apt.'" and kd_obat="'.$value.'" and tgl_expire="'.$tglexpire.'"');					
					}
				}		
				$updatepenerimaan=array('retur'=>1);
				$this->mreturapt->update('apt_penerimaan',$updatepenerimaan,'no_penerimaan="'.$no_penerimaan.'"');
			}
			$this->db->trans_complete();
			$msg['status']=1;
			$msg['posting']=3;
			$msg['pesan']="Approve Berhasil";
			echo json_encode($msg);
			return false;
		}
		if($submit=="unapprove"){
			if(empty($no_retur))return false;
			$updateapprove=array('is_app'=>0);
			$this->mreturapt->update('apt_app_returpenerimaan',$updateapprove,'kd_app="'.$kd_applogin.'" and no_retur="'.$no_retur.'"');
			
			$count=$this->mreturapt->countApprover($no_retur);
			$countisap=$this->mreturapt->countIsApp($no_retur);
			if($countisap!=$count){
				$up=array('status_approve'=>0);
				$this->mreturapt->update('apt_retur_obat',$up,'no_retur="'.$no_retur.'"');
				
				$updateretur=array('posting'=>0);
				$this->mreturapt->update('apt_retur_obat',$updateretur,'no_retur="'.$no_retur.'"');
				
				if(!empty($kd_obat)){
					foreach ($kd_obat as $key => $value){
						if(empty($value))continue;
						$tglexpire=convertDate($tgl_expire[$key]);
						$jml_stok_awal=$this->mreturapt->ambilStokAwal($kd_unit_apt,$value,$tglexpire);
						$sisastok=$jml_stok_awal+$qty[$key];
						$datastok=array('jml_stok'=>$sisastok);
						$this->mreturapt->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$kd_unit_apt.'" and kd_obat="'.$value.'" and tgl_expire="'.$tglexpire.'"');					
					}
				}
				$updatepenerimaan=array('retur'=>0);
				$this->mreturapt->update('apt_penerimaan',$updatepenerimaan,'no_penerimaan="'.$no_penerimaan.'"');
			}
			$this->db->trans_complete();
			$msg['status']=1;
			$msg['posting']=4;
			$msg['pesan']="Batal approve berhasil";
			echo json_encode($msg);
			return false;
		}
		echo json_encode($msg);
	}
	
	public function hapusretur($no_retur=""){
		if(!$this->muser->isAkses("48")){
			$this->restricted();
			return false;
		}
		
		$msg=array();
		$error=0;
		$this->db->trans_start();
		if(empty($no_retur)){
			$msg['pesan']="Pilih Transaksi yang akan di hapus";
			echo "<script>Alert('".$msg['pesan']."')</script>";
		}else{
			$this->mreturapt->delete('apt_retur_obat','no_retur="'.$no_retur.'"');
			$this->mreturapt->delete('apt_retur_obat_detail','no_retur="'.$no_retur.'"');
			$this->mreturapt->delete('apt_app_returpenerimaan','no_retur="'.$no_retur.'"');
			$this->db->trans_complete();
			redirect('/transapotek/aptreturobat/');
		}
	}
	
	public function ambilpenerimaanbykode(){
		$q=$this->input->get('query');
		$items=$this->mreturapt->ambilData3($q);
		echo json_encode($items);
	}

	public function periksaretur() {
		$msg=array();
		$submit=$this->input->post('submit');
		$no_retur=$this->input->post('no_retur');
		$no_penerimaan=$this->input->post('no_penerimaan');
		$no_batch=$this->input->post('no_batch');
		$tgl_penerimaan=$this->input->post('tgl_penerimaan');
		$tgl_retur=$this->input->post('tgl_retur');
		$shift=$this->input->post('shift');
		$lunas=$this->input->post('lunas');
		$posting=$this->input->post('posting');
		$kd_supplier=$this->input->post('kd_supplier');
		$nama=$this->input->post('nama');
		$keterangan=$this->input->post('keterangan');
		$jumlah=$this->input->post('jumlah');
		$total_bayar=$this->input->post('total_bayar');
		
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$qty_kcl=$this->input->post('qty_kcl');
		$qty_box=$this->input->post('qty_box');
		$qty=$this->input->post('qty');
		$tgl_expire=$this->input->post('tgl_expire');
		$harga_beli=$this->input->post('harga_beli'); 
		$total=$this->input->post('total');
		$kd_milik=$this->input->post('kd_milik');
		$ppn_item=$this->input->post('ppn_item');
		
		$nama_pegawai=$this->input->post('nama_pegawai');
		$status=$this->input->post('status');
		$kd_app=$this->input->post('kd_app');
		$kd_applogin=$this->input->post('kd_applogin');
		
		$hasil1=$this->input->post('hasil1');
		$hasil2=$this->input->post('hasil2');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="approve"){
			if($this->mreturapt->isAppExist($no_retur,$kd_applogin)){ //ngecek, yg login bs approve retur nomor ini apa ga...kalo bisa : 				
				$isapp=$this->mreturapt->statusisaplogin($no_retur,$kd_applogin); //ngecek yg login udh pernah approve ke no retur ini apa blm
				//debugvar($isapp);
				if($isapp==1){ //kalo udh pernah approve
					$jumlaherror++;
					$msg['id'][]="no_retur";
					$msg['pesan'][]="Anda telah melakukan approve untuk nomor retur ".$no_retur;
				}
				else { //kalo blm pernah approve
					$urutapp=$this->mreturapt->urutapprover($kd_applogin); //urutnya yang login				
					if($urutapp!=1){ //kalo yg login, bukan urut 1
						$urutapp1=$this->mreturapt->urutapprover1($urutapp,$no_retur); //ambil is_app sebelumnya
						//debugvar($urutapp1);
						if($urutapp1==0){ //cek is_app sebelumnya
							$namapegawai=$this->mreturapt->pegawai($urutapp,$no_retur); //ambil nama pegawai sbelumnya
							$jumlaherror++;
							$msg['id'][]="no_retur";
							$msg['pesan'][]="Anda tidak bisa melakukan approve, karena user ".$namapegawai." belum melakukan approve.";
						}						
					}
				}
			}
			else{ //kalo yg login ga bs ngelakukan approve
				$jumlaherror++;
				$msg['id'][]="no_retur";
				$msg['pesan'][]="Anda tidak bisa melakukan approve untuk nomor retur ini.";
			}
		}
		if($submit=="unapprove"){
			$urutapp=$this->mreturapt->urutapprover($kd_applogin); //urutnya yang login				
			if($urutapp!=1){ //kalo yg login, bukan urut 1
				$urutapp1=$this->mreturapt->urutapprover1($urutapp,$no_retur); //ambil is_app sebelumnya
				//debugvar($urutapp1);
				if($urutapp1==1){ //cek is_app sebelumnya
					$namapegawai=$this->mreturapt->pegawai($urutapp,$no_retur); //ambil nama pegawai sbelumnya
					$jumlaherror++;
					$msg['id'][]="no_retur";
					$msg['pesan'][]="Anda belum bisa melakukan batal approve, karena user ".$namapegawai." sudah melakukan approve.";
				}						
			}
		}
		if($submit=="hapus"){
			if(empty($no_retur)){
				$msg['pesanatas']="Pilih Transaksi yang akan di hapus";
			}else{
				$this->mreturapt->delete('apt_retur_obat','no_retur="'.$no_retur.'"');
				$this->mreturapt->delete('apt_retur_obat_detail','no_retur="'.$no_retur.'"');
				$this->mreturapt->delete('apt_app_returpenerimaan','no_retur="'.$no_retur.'"');
				$msg['pesanatas']="Data Berhasil Di Hapus";
			}
			$msg['status']=0;
			$msg['clearform']=1;
			echo json_encode($msg);
		}
		else{
			if(empty($tgl_retur)){
				$jumlaherror++;
				$msg['id'][]="tgl_retur";
				$msg['pesan'][]="Kolom Tanggal Harus di Isi !";
			}
			if(empty($no_penerimaan)){
				$jumlaherror++;
				$msg['id'][]="no_penerimaan";
				$msg['pesan'][]="No Penerimaan Harus di Isi !";
			}
			if(empty($no_batch)){
				$jumlaherror++;
				$msg['id'][]="no_batch";
				$msg['pesan'][]="No Batch Harus di Isi !";
			}
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value) {
					# code...
					if(empty($value))continue;
					if(empty($qty_box[$key])){
						$msg['status']=0;
						$nama=$this->mreturapt->ambilNama($value);
						$msg['pesanlain'].="Qty ".$nama." Tidak boleh Kosong ! <br/>";					
					}
					if($qty_box[$key]>$qty[$key]){
						$msg['status']=0;
						$nama=$this->mreturapt->ambilNama($value);
						$msg['pesanlain'].="Jumlah Qty ".$nama." yang diretur tidak boleh melebihi jumlah penerimaan !<br/>";					
					}
					if(empty($no_retur)){
						if($hasil1[$key]=="ada"){
							$msg['status']=0;
							$nama=$this->mreturapt->ambilNama($value);
							$msg['pesanlain'].="Obat ".$nama." dengan no. batch ".$no_batch." dan tgl.expired ".convertDate($tgl_expire[$key])." tidak bisa di retur, karena sudah terpakai di transaksi penjualan !<br/>";					
						}
						if($hasil2[$key]=="ada"){
							$msg['status']=0;
							$nama=$this->mreturapt->ambilNama($value);
							$msg['pesanlain'].="Obat ".$nama." dengan no. batch ".$no_batch." dan tgl.expired ".convertDate($tgl_expire[$key])." tidak bisa di retur, karena sudah di distribusikan !<br/>";					
						}
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
	
	public function ambildetilpenerimaan()
	{
		$q=$this->input->get('query');
		$items=$this->mreturapt->getdetilpenerimaan($q);
		echo json_encode($items);
	}
	
	public function ambilitem()
	{
		$q=$this->input->get('query');
		$items=$this->mreturapt->getRetur($q);
		echo json_encode($items);
	}
	
	public function ambilitems()
	{
		$q=$this->input->get('query');
		$items=$this->mreturapt->getAllDetailRetur($q);
		echo json_encode($items);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
