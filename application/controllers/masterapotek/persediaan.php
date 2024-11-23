<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Persediaan extends CI_Controller {
class Persediaan extends Rumahsakit {

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

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('utilities');
		$this->load->library('pagination');
		$this->load->model('apotek/mpersediaanobat');
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
	
	public function index()
	{
		if(!$this->muser->isAkses("21")){
			$this->restricted();
			return false;
		}
		
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
							'main.js','style-switcher.js');
		$dataheader=array(
			'jsfile'=>$jsfileheader,
			'cssfile'=>$cssfileheader,
			'title'=>$this->title
			);

		$jsfooter=array();
		$datafooter=array(
			'jsfile'=>$jsfooter
			);

		$data=array();
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function persediaanobat(){
		if(!$this->muser->isAkses("25")){
			$this->restricted();
			return false;
		}
		
		$nama_obat='';
		$stok='1';
		$isistok='';
		$kd_unit_apt=$this->input->post('kd_unit_apt');
		$submit=$this->input->post('submit');
		$submit1=$this->input->post('submit1');
		
		if($this->input->post('nama_obat')!=''){
			$nama_obat=$this->input->post('nama_obat');
		}
		if($this->input->post('stok')!=''){
			$stok=$this->input->post('stok');
		}
		if($this->input->post('isistok')!=''){
			$isistok=$this->input->post('isistok');
		}
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
		
		//debugvar($nomor);
		$data=array('nama_obat'=>$nama_obat,
					'stok'=>$stok,
					'isistok'=>$isistok,
					'datasumberdana'=>$this->mpersediaanobat->ambilData('apt_unit'),
					'items'=>$this->mpersediaanobat->ambilPersediaan($nama_obat,$stok,$isistok,$kd_unit_apt),
					'kd_unit_apt'=>$kd_unit_apt
		);
		//debugvar($data);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/persediaan/persediaanobat',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function simpanpengajuanobat(){	
		$this->db->trans_start();
		$an=$this->input->post('query');
		$tglhrini=date('d-m-Y');
		$jam=$this->mpersediaanobat->sisdet();
		
		$tgl=explode("-", $tglhrini);
		$kode=$this->mpersediaanobat->autoNumberPengajuan($tgl[2],$tgl[1]);
		$kodebaru=$kode+1;
		$kodebaru=str_pad($kodebaru,4,0,STR_PAD_LEFT); 
		$no_pengajuan="PG.".$tgl[2].".".$tgl[1].".".$kodebaru;
		$tglhrini1=convertDate($tglhrini)." ".$jam;
		$datapengajuan=array('no_pengajuan'=>$no_pengajuan,
								//'kd_supplier'=>$kd_supplier,
								//'tgl_pengajuan'=>convertDate($tglhrini),
								'tgl_pengajuan'=>$tglhrini1,
								'keterangan'=>'-',
								'is_grouping'=>0,
								'status_approve'=>0);
		
		$this->mpersediaanobat->insert('apt_pengajuan',$datapengajuan);
		$urut=1;
		$an1=explode(",", $an);
		$i=count($an1)-1; //maxnya
		for($a=0;$a<$i;$a++){
			//$an2=explode(".", $an1[$a]);
			$kd_obat=$an1[0];
			//$tgl_expire=$an2[1];
			$item=$this->mpersediaanobat->ambildetilobat($kd_obat);
			$qty=$item['max_stok'];
			//$harga_beli=$item['harga_beli'];
			$harga_dasar=$item['harga_dasar'];
			$datadetil=array('no_pengajuan'=>$no_pengajuan,
							'urut_pengajuan'=>$urut,
							'kd_obat'=>$kd_obat,
							'qty_kcl'=>$qty,
							//'harga_beli'=>$harga_beli);
							'harga_beli'=>$harga_dasar);
			//debugvar($datadetil);
			$this->mpersediaanobat->insert('apt_pengajuan_detail',$datadetil);								
			$urut++;
		}
		$items=$this->mpersediaanobat->ambilApprover();
		foreach($items as $itemapprove){
			$kd_app=$itemapprove['kd_app'];
			$is_app=$itemapprove['is_app'];
			$dataapprove=array('kd_app'=>$kd_app,
								'no_pengajuan'=>$no_pengajuan,
								'is_app'=>$is_app);
			$this->mpersediaanobat->insert('apt_app_pengajuan',$dataapprove);								
		}
		$this->db->trans_complete();
	}
	
	public function submitpengajuanobat(){
		$msg=array();
		$this->db->trans_start();
		$an=$this->input->post('query');
		$tglhrini=date('d-m-Y');
		$jam=$this->mpersediaanobat->sisdet();
		
		$tgl=explode("-", $tglhrini);
		$kode=$this->mpersediaanobat->autonumbersubmit();
		$kodebaru=$kode+1;
		//$kodebaru=str_pad($kodebaru,4,0,STR_PAD_LEFT); 
		$no_submit=$kodebaru;
		$tglhrini1=convertDate($tglhrini)." ".$jam;
		$datasubmit=array('no_submit'=>$no_submit,
								'tgl_submit'=>$tglhrini1,
								'keterangan'=>'-');
		
		$this->mpersediaanobat->insert('apt_submit',$datasubmit);
		$urut=1;
		$an1=explode(",", $an);
		$i=count($an1)-1; //maxnya
		for($a=0;$a<$i;$a++){
			//$an2=explode(".", $an1[$a]);
			//$kd_obat=$an1[0];
			$kd_obat=$an1[$a];
			//$tgl_expire=$an2[1];
			$item=$this->mpersediaanobat->ambildetilobat($kd_obat);
			$qty=$item['max_stok'];
			//$harga_beli=$item['harga_beli'];
			$harga_dasar=$item['harga_dasar'];
			$datadetil=array('no_submit'=>$no_submit,
							'urut_submit'=>$urut,
							'kd_obat'=>$kd_obat,
							'qty_kcl'=>$qty,
							'harga_beli'=>$harga_dasar);
			$this->mpersediaanobat->insert('apt_submit_detail',$datadetil);								
			$urut++;
		}
		$this->db->trans_complete();
		$msg['no_submit']=$no_submit;
		echo json_encode($msg);
	}
	
	public function submitpermintaanobat(){
		$msg=array();
		$this->db->trans_start();
		$an=$this->input->post('query');
		$tglhrini=date('d-m-Y');
		$jam=$this->mpersediaanobat->sisdet();
		
		$tgl=explode("-", $tglhrini);
		$kode=$this->mpersediaanobat->autonumbersubmit1();
		$kodebaru=$kode+1;
		//$kodebaru=str_pad($kodebaru,4,0,STR_PAD_LEFT); 
		$no_submit=$kodebaru;
		$tglhrini1=convertDate($tglhrini)." ".$jam;
		$datasubmit=array('no_submit'=>$no_submit,
								'tgl_submit'=>$tglhrini1,
								'keterangan'=>'-');
		
		$this->mpersediaanobat->insert('apt_submit_permintaan',$datasubmit);
		$urut=1;
		$an1=explode(",", $an);
		$i=count($an1)-1; //maxnya
		for($a=0;$a<$i;$a++){
			//$an2=explode(".", $an1[$a]);
			//$kd_obat=$an1[0];
			$kd_obat=$an1[$a];
			//debugvar($kd_obat);
			//$tgl_expire=$an2[1];
			$item=$this->mpersediaanobat->ambildetilobat($kd_obat);
			$qty=$item['max_stok'];
			//$harga_beli=$item['harga_beli'];
			//$harga_dasar=$item['harga_dasar'];
			$datadetil=array('no_submit'=>$no_submit,
							'urut_submit'=>$urut,
							'kd_obat'=>$kd_obat,
							'jml_req'=>$qty);
			$this->mpersediaanobat->insert('apt_submit_permintaan_detail',$datadetil);								
			$urut++;
		}
		$this->db->trans_complete();
		$msg['no_submit']=$no_submit;
		echo json_encode($msg);
	}
	
	public function editsubmit(){
		$msg=array();
		$this->db->trans_start();
		$submit=$this->input->post('submit');
		$no_submit=$this->input->post('no_submit');
		$tgl_submit=$this->input->post('tgl_submit');
		$jam_submit=$this->input->post('jam_submit');
		$jam_submit1=$this->input->post('jam_submit1');
		$keterangan=$this->input->post('keterangan');
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$pembanding=$this->input->post('pembanding');
		$qty_box=$this->input->post('qty_box'); 
		//$qty_kcl=$this->input->post('qty_kcl');
		$harga_beli=$this->input->post('harga_beli');
		
		if($submit=="simpan"){
			$tgl=explode("-", $tgl_submit);
			$kode=$this->mpersediaanobat->autoNumberPengajuan($tgl[2],$tgl[1]);
			$kodebaru=$kode+1;
			$kodebaru=str_pad($kodebaru,4,0,STR_PAD_LEFT); 
			$no_pengajuan="PG.".$tgl[2].".".$tgl[1].".".$kodebaru;
			$msg['no_pengajuan']=$no_pengajuan;
			$tgl_pengajuan1=convertDate($tgl_submit)." ".$jam_submit;
			$datapengajuan=array('no_pengajuan'=>$no_pengajuan,
								'tgl_pengajuan'=>$tgl_pengajuan1,
								'keterangan'=>$keterangan,
								'is_grouping'=>0,
								'status_approve'=>0);
			
			$this->mpersediaanobat->insert('apt_pengajuan',$datapengajuan);
			$urut=1;
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					# code...
					if(empty($value))continue;
					//if($qty_kcl[$key]==''){$qty_kcl[$key]=0;}
					$datadetil=array('no_pengajuan'=>$no_pengajuan,
									'urut_pengajuan'=>$urut,
									'kd_obat'=>$value,
									//'qty_kcl'=>$qty_kcl[$key],
									'qty_kcl'=>$qty_box[$key],
									'harga_beli'=>$harga_beli[$key]);
					//debugvar($datadetil);
					$this->mpersediaanobat->insert('apt_pengajuan_detail',$datadetil);
										
					$urut++;
				}
			}
			$items=$this->mpersediaanobat->ambilApprover();
			foreach($items as $itemapprove){
				$kd_app=$itemapprove['kd_app'];
				$is_app=$itemapprove['is_app'];
				$dataapprove=array('kd_app'=>$kd_app,
									'no_pengajuan'=>$no_pengajuan,
									'is_app'=>$is_app);
				$this->mpersediaanobat->insert('apt_app_pengajuan',$dataapprove);								
			}
			$msg['keluar']=0;
			$msg['posting']=3;
		}
		$this->db->trans_complete();
		$msg['status']=1;
		
		echo json_encode($msg);
	}
	
	public function editsubmitpermintaan(){
		$msg=array();
		$this->db->trans_start();
		$submit=$this->input->post('submit');
		$no_submit=$this->input->post('no_submit');
		$tgl_submit=$this->input->post('tgl_submit');
		$jam_submit=$this->input->post('jam_submit');
		$jam_submit1=$this->input->post('jam_submit1');
		$keterangan=$this->input->post('keterangan');
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$jml_req=$this->input->post('jml_req'); 
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$kd_user=$this->session->userdata('id_user');
		
		if($submit=="simpan"){
			$tgl=explode("-", $tgl_submit);
			$kode=$this->mpersediaanobat->autoNumberPermintaan($tgl[2],$tgl[1]);
			$kodebaru=$kode+1;			
			$kodebaru=str_pad($kodebaru,4,0,STR_PAD_LEFT); 
			$no_permintaan="OD.".$tgl[2].".".$tgl[1].".".$kodebaru;
			$msg['no_permintaan']=$no_permintaan;
			$tgl_permintaan1=convertDate($tgl_submit)." ".$jam_submit;
			$datapermintaan=array('no_permintaan'=>$no_permintaan,
								'kd_unit_apt'=>$kd_unit_apt,
								'tgl_permintaan'=>$tgl_permintaan1,
								'keterangan'=>$keterangan,
								'permintaan_status'=>0,
								'status_approve'=>0,
								'kd_user'=>$kd_user);
			
			$this->mpersediaanobat->insert('apt_permintaan_obat',$datapermintaan);
			$urut=1;
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					# code...
					if(empty($value))continue;
					//if($qty_kcl[$key]==''){$qty_kcl[$key]=0;}
					$tglexpire=$this->mpersediaanobat->ambilexpireobat($value);
					$datadetil=array('no_permintaan'=>$no_permintaan,
									'urut'=>$urut,
									'kd_obat'=>$value,
									'tgl_expire'=>$tglexpire,
									'jml_req'=>$jml_req[$key],
									'jml_distribusi'=>0);
					//debugvar($datadetil);
					$this->mpersediaanobat->insert('apt_permintaan_obat_det',$datadetil);
										
					$urut++;
				}
			}
			$msg['keluar']=0;
			$msg['posting']=3;
		}
		$msg['status']=1;
		$this->db->trans_complete();
		echo json_encode($msg);
	}
	
	public function simpanpermintaanobat(){	
		$an=$this->input->post('query');
		$this->db->trans_start();
		$tglhrini=date('d-m-Y');
		$jam=$this->mpersediaanobat->sisdet();
		$an1=explode(",", $an);
		$i=count($an1)-1; //maxnya
		
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$kd_user=$this->session->userdata('id_user'); 
		
		$tgl=explode("-", $tglhrini);
		$kode=$this->mpersediaanobat->autoNumberPermintaan($tgl[2],$tgl[1]);
		$kodebaru=$kode+1;
		$kodebaru=str_pad($kodebaru,4,0,STR_PAD_LEFT); 
		$no_permintaan="OD.".$tgl[2].".".$tgl[1].".".$kodebaru;
		//debugvar($jam);
		$tglhrini1=convertDate($tglhrini)." ".$jam;
		$datapermintaan=array('no_permintaan'=>$no_permintaan,
								'kd_unit_apt'=>$kd_unit_apt,
								//'tgl_permintaan'=>convertDate($tglhrini),
								'tgl_permintaan'=>$tglhrini1,
								'keterangan'=>'-',
								'permintaan_status'=>0,
								'status_approve'=>0,
								'kd_user'=>$kd_user);
			
		$this->mpersediaanobat->insert('apt_permintaan_obat',$datapermintaan);
		$urut=1;
		for($a=0;$a<$i;$a++){
			$an2=explode(".", $an1[$a]);
			$kd_obat=$an2[0];
			$tgl_expire=$an2[1];
			$item=$this->mpersediaanobat->ambildetilobat($kd_obat);
			$qty=$item['max_stok'];
			//$harga_beli=$item['harga_beli'];
			$harga_dasar=$item['harga_dasar'];
			$datadetil=array('no_permintaan'=>$no_permintaan,
							'urut'=>$urut,
							'kd_obat'=>$kd_obat,
							'tgl_expire'=>$tgl_expire,
							'jml_req'=>$qty,
							'jml_distribusi'=>0);
			//debugvar($datadetil);
			$this->mpersediaanobat->insert('apt_permintaan_obat_det',$datadetil);	
			$urut++;
		}
		/*$items=$this->mpersediaanobat->ambilApprover();
		foreach($items as $itemapprove){
			$kd_app=$itemapprove['kd_app'];
			$is_app=$itemapprove['is_app'];
			$dataapprove=array('kd_app'=>$kd_app,
								'no_permintaan'=>$no_permintaan,
								'is_app'=>$is_app);
			$this->mpersediaanobat->insert('apt_app_permintaan',$dataapprove);								
		}*/
		$this->db->trans_complete();
	}
	
	public function submit($no_submit=""){
	if(empty($no_submit))return false;
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
		
		$data=array('no_submit'=>$no_submit,
					'itemtransaksi'=>$this->mpersediaanobat->ambilItemDataSubmit($no_submit),
					'itemsdetiltransaksi'=>$this->mpersediaanobat->getAllDetailSubmit($no_submit));
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/persediaan/submitpengajuan',$data);
		$this->load->view('footer',$datafooter);	
	}
	
	public function submitpermintaan($no_submit=""){
	if(empty($no_submit))return false;
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
		
		$data=array('no_submit'=>$no_submit,
					'itemtransaksi'=>$this->mpersediaanobat->ambilItemDataSubmitPermintaan($no_submit),
					'itemsdetiltransaksi'=>$this->mpersediaanobat->getAllDetailSubmitPermintaan($no_submit));
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/persediaan/submitpermintaan',$data);
		$this->load->view('footer',$datafooter);	
	}
	
	public function hapussubmit(){
		$this->db->trans_start();
		$q=$this->input->post('query');	//no_submit
		$this->mpersediaanobat->delete('apt_submit','no_submit="'.$q.'"');
		$this->mpersediaanobat->delete('apt_submit_detail','no_submit="'.$q.'"');
		//echo json_encode($items);
		$this->db->trans_complete();
	}
	
	public function hapussubmitpermintaan(){
		$this->db->trans_start();
		$q=$this->input->post('query');	//no_submit
		$this->mpersediaanobat->delete('apt_submit_permintaan','no_submit="'.$q.'"');
		$this->mpersediaanobat->delete('apt_submit_permintaan_detail','no_submit="'.$q.'"');
		$this->db->trans_complete();
		//echo json_encode($items);
	}
	
	public function periksasubmit() {
		$msg=array();
		$submit=$this->input->post('submit');
		$no_submit=$this->input->post('no_submit');
		$tgl_submit=$this->input->post('tgl_submit');
		$jam_submit=$this->input->post('jam_submit');
		$jam_submit1=$this->input->post('jam_submit1');
		$keterangan=$this->input->post('keterangan');
		
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$pembanding=$this->input->post('pembanding');
		$qty_box=$this->input->post('qty_box'); 
		//$qty_kcl=$this->input->post('qty_kcl');
		$harga_beli=$this->input->post('harga_beli');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		echo json_encode($msg);
	}

	public function rl1excelpersediaanobat($stok="",$kd_jenis_obat="",$isistok="",$kd_sub_jenis="",$kd_unit_apt="",$kd_golongan=""){
		$stok1="";  $stoka="";  $isistok1="";
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
		
		//$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(2.14); 
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(4.14); //NO
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(10); //kode
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(28); //nama obat
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(8.5); //satuan
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(11.5); //tgl expire
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(6.5); //stok
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(10); //harga beli
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(12); //jumlah
		//debugvar($kd_unit_apt);
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
		$objPHPExcel->getActiveSheet()->setCellValue ('A2','RUMAH SAKIT');
		$objPHPExcel->getActiveSheet()->setCellValue ('A3','IBNU SINA');
		$objPHPExcel->getActiveSheet()->setCellValue ('A4','Kota Balikpapan');		
		$objPHPExcel->getActiveSheet()->setCellValue ('A6','LAPORAN PERSEDIAAN OBAT / ALKES');		
		
		$namaunit=$this->mlaporanapt->namaUnit($kd_unit_apt);
		if($namaunit=='0' or $namaunit=='') {$objPHPExcel->getActiveSheet()->setCellValue ('A7','Unit : Semua Sumber');}
		else {$objPHPExcel->getActiveSheet()->setCellValue ('A7','Unit : '.$namaunit);}
						
		if($stok=='1'){$stok1="lebih besar dari"; $stoka=">";}
		else if($stok=='2'){$stok1="lebih kecil dari"; $stoka="<";}
		else if($stok=='3'){$stok1="lebih besar sama dengan"; $stoka=">=";}
		else if($stok=='4'){$stok1="lebih kecil sama dengan"; $stoka="<=";}
		else {$stok1="sama dengan"; $stoka="=";}
		
		if($isistok=='' or $isistok=='null'){$isistok1=0;} 
		else {$isistok1=$isistok;}		
		$objPHPExcel->getActiveSheet()->setCellValue ('A8','Stok '.$stok1.' '.$isistok1);
		
		for($x='A';$x<='H';$x++){
			$objPHPExcel->getActiveSheet()->getStyle($x.'10')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
		
			$objPHPExcel->getActiveSheet()->getStyle($x.'10')->applyFromArray(array('font'    => array('name'      => 'calibri','horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
																			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'size'		=>11 /*untuk ukuran tulisan judul kolom2 di tabel*/,'color'     => array('rgb' => '000000')),
																			'borders' => array('bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
																			'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
																			'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
																			'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
		}		
		$objPHPExcel->getActiveSheet()->setCellValue ('A10','NO.');
		$objPHPExcel->getActiveSheet()->setCellValue ('B10','KODE');
		$objPHPExcel->getActiveSheet()->setCellValue ('C10','NAMA OBAT');
		$objPHPExcel->getActiveSheet()->setCellValue ('D10','SAT.');
		$objPHPExcel->getActiveSheet()->setCellValue ('E10','TGL. EXPIRE');
		$objPHPExcel->getActiveSheet()->setCellValue ('F10','STOK');
		$objPHPExcel->getActiveSheet()->setCellValue ('G10','HRG.BELI');
		$objPHPExcel->getActiveSheet()->setCellValue ('H10','JUMLAH');
		$items=array();
		$items=$this->mlaporanapt->getAllPersediaanApotek($stok,$kd_jenis_obat,$isistok,$kd_sub_jenis,$kd_unit_apt,$kd_golongan);
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
				}else if($x=='D'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='E'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='F'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='G'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='H'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}				
				$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->applyFromArray(array(
					'font'    => array('name'      => 'calibri','horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=>11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,'color'     => array('rgb' => '000000')),'borders' => array('bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000')),'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000')))));
			}
			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,$nomor);
			$objPHPExcel->getActiveSheet()->setCellValue ('B'.$baris,$item['kd_obat']);
			$objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,$item['nama_obat']);
			$objPHPExcel->getActiveSheet()->setCellValue ('D'.$baris,$item['satuan_kecil']);
			$objPHPExcel->getActiveSheet()->setCellValue ('E'.$baris,convertDate($item['tgl_expire']));
			$objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,number_format($item['jml_stok']));
			$objPHPExcel->getActiveSheet()->setCellValue ('G'.$baris,number_format($item['harga_pokok']));
			$objPHPExcel->getActiveSheet()->setCellValue ('H'.$baris,number_format($item['jumlah']));
					
			$nomor=$nomor+1; $baris=$baris+1; $total=$total+$item['jumlah'];
		}	
		for($x='A';$x<='H';$x++){
			if($x=='A'){
				$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));					
			}else if($x=='H'){
				$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
			}				
			$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->applyFromArray(array(
				'font'    => array('name'      => 'calibri','horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'size'		=>11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,'color'     => array('rgb' => '000000')),'borders' => array('bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('rgb' => '000000')),'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
				'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('rgb' => '000000')))));
		}
		//$objPHPExcel->getActiveSheet()->mergeCells('B8:I8');
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':G'.$baris);
		$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,'T O T A L :');
		$objPHPExcel->getActiveSheet()->setCellValue ('H'.$baris,number_format($total));
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save("download/persediaanobat.xls");
		header("Location: ".base_url()."download/persediaanobat.xls");
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
