<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Aptsupplier extends CI_Controller {
class Aptsupplier extends Rumahsakit {

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

	protected $title='GFK KOTA BALIKPAPAN';

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('utilities');
		$this->load->library('pagination');
		$this->load->model('apotek/msupplierapt');

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
		if(!$this->muser->isAkses("17")){
			$this->restricted();
			return false;
		}
		
		$nama='';
		$is_aktif='';
		
		if($this->input->post('nama')!=''){
			$nama=$this->input->post('nama');
		}
		if($this->input->post('is_aktif')!=''){
			$is_aktif=$this->input->post('is_aktif');
		}
		
		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js',
							'vendor/jquery-1.9.1.min.js',
							'vendor/jquery-migrate-1.1.1.min.js',
							'vendor/jquery-ui-1.10.0.custom.min.js',
							'vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js',
							'lib/jquery.dataTables.min.js',
							'lib/DT_bootstrap.js',
							'lib/responsive-tables.js',
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
		$data=array('items'=>$this->msupplierapt->ambilDataSupplier($nama,$is_aktif),
					'nama'=>$nama,
					'is_aktif'=>$is_aktif);
		//debugvar($data);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/supplier/aptsupplier',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function tambah()
	{
		if(!$this->muser->isAkses("18")){
			$this->restricted();
			return false;
		}
		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','timepicker.css','theme.css');
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
		$data=array();
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/supplier/tambahsupplierapt',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksa()
	{
		$msg=array();
		$submit=$this->input->post('submit');
		$mode=$this->input->post('mode');
		$kd_supplier=$this->input->post('kd_supplier');
		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$kota=$this->input->post('kota');
		$kode_pos=$this->input->post('kode_pos');
		$telp=$this->input->post('telp');
		$fax=$this->input->post('fax');
		$email=$this->input->post('email');
		$is_aktif=$this->input->post('is_aktif');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if($mode!="edit"){
			if($this->msupplierapt->isExist('apt_supplier','kd_supplier',$kd_supplier)){
				$jumlaherror++;
				$msg['id'][]="kd_supplier";
				$msg['pesan'][]="Kode supplier sudah ada";
			}			
		}
		/*if(empty($kd_supplier)){
			$jumlaherror++;
			$msg['id'][]="kd_supplier";
			$msg['pesan'][]="Kode supplier Harus di Isi";
		}*/
		if(empty($nama)){
			$jumlaherror++;
			$msg['id'][]="nama";
			$msg['pesan'][]="Nama supplier Harus di Isi";
		}
		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}
		
		echo json_encode($msg);
	}

	public function simpan(){
		//$msg=array();
		//$submit=$this->input->post('submit');
		$kd_supplier=$this->input->post('kd_supplier');
		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$kota=$this->input->post('kota');
		$kode_pos=$this->input->post('kode_pos');
		$telp=$this->input->post('telp');
		$fax=$this->input->post('fax');
		$email=$this->input->post('email');
		$is_aktif=$this->input->post('is_aktif');
		
		$kode=$this->msupplierapt->autoNumber();
		$kodebaru=$kode+1;
		$kodebaru=str_pad($kodebaru,4,0,STR_PAD_LEFT); 
		$kd_supplier="DS".$kodebaru;
		$msg['kd_supplier']=$kd_supplier;
		
		$tambahsupplier=array('kd_supplier'=>$kd_supplier,
							  'nama'=>$nama,
							  'alamat'=>$alamat,
							  'kota'=>$kota,
							  'kode_pos'=>$kode_pos,
							  'telp'=>$telp,
							  'fax'=>$fax,
							  'email'=>$email,
							  'is_aktif'=>$is_aktif);
		$this->msupplierapt->insert('apt_supplier',$tambahsupplier);
		
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;
		$msg['posting']=3;

		echo json_encode($msg);
	}

	public function update(){
		$kd_supplier=$this->input->post('kd_supplier');
		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$kota=$this->input->post('kota');
		$kode_pos=$this->input->post('kode_pos');
		$telp=$this->input->post('telp');
		$fax=$this->input->post('fax');
		$email=$this->input->post('email');
		$is_aktif=$this->input->post('is_aktif');
		
		$msg['kd_supplier']=$kd_supplier;
		
		$edit=array('nama'=>$nama,
					'alamat'=>$alamat,
					'kota'=>$kota,
					'kode_pos'=>$kode_pos,
					'telp'=>$telp,
					'fax'=>$fax,
					'email'=>$email,
					'is_aktif'=>$is_aktif);
		$this->msupplierapt->update('apt_supplier',$edit,'kd_supplier="'.$kd_supplier.'"');
		
		$msg['pesan']="Data Berhasil Di Edit";
		$msg['status']=1;
		$msg['posting']=3;

		echo json_encode($msg);
	}

	public function edit($id=""){
		if(!$this->muser->isAkses("19")){
			$this->restricted();
			return false;
		}
		
		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','timepicker.css','theme.css');
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
		
		$data=array('items'=>$this->msupplierapt->ambilItemData('apt_supplier','kd_supplier="'.urldecode($id).'"'));
		//debugvar($data);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/supplier/editsupplierapt',$data);
		$this->load->view('footer',$datafooter);

	}
	public function hapus($id=""){
		if(!$this->muser->isAkses("20")){
			$this->restricted();
			return false;
		}
		if(!empty($id)){
			$this->msupplierapt->delete('apt_supplier','kd_supplier="'.$id.'"');
			redirect('/masterapotek/aptsupplier/');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */