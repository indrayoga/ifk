<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Satuankecil extends CI_Controller {
class Satuankecil extends Rumahsakit {

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
		$this->load->model('apotek/msatuankecil');

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
		if(!$this->muser->isAkses("5")){
			$this->restricted();
			return false;
		}
		
		$satuan_kecil=$this->input->post('satuan_kecil');
		
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
		$data=array('satuan_kecil'=>$satuan_kecil,
					'items'=>$this->msatuankecil->ambilDataSatuanKecil($satuan_kecil));
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/satuankecil/satuankecil',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function tambah()
	{
		if(!$this->muser->isAkses("6")){
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
		$this->load->view('apotek/master/satuankecil/tambahsatuankecil',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksa()
	{
		$msg=array();
		$mode=$this->input->post('mode');
		$submit=$this->input->post('submit');
		$kd_satuan_kecil=$this->input->post('kd_satuan_kecil');
		$satuan_kecil=$this->input->post('satuan_kecil');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if($mode!="edit"){
			if($this->msatuankecil->isExist('apt_satuan_kecil','kd_satuan_kecil',$kd_satuan_kecil)){
				$jumlaherror++;
				$msg['id'][]="kd_satuan_kecil";
				$msg['pesan'][]="Kode satuan obat sudah ada";
			}			
		}
		if(empty($kd_satuan_kecil)){
			$jumlaherror++;
			$msg['id'][]="kd_satuan_kecil";
			$msg['pesan'][]="Kode satuan obat Harus di Isi";
		}			
		if(empty($satuan_kecil)){
			$jumlaherror++;
			$msg['id'][]="satuan_kecil";
			$msg['pesan'][]="Nama satuan obat harus di isi";
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
		$kd_satuan_kecil=$this->input->post('kd_satuan_kecil');
		$satuan_kecil=$this->input->post('satuan_kecil');
		
		$msg['kd_satuan_kecil']=strtoupper($kd_satuan_kecil);
		$tambah=array('kd_satuan_kecil'=>strtoupper($kd_satuan_kecil),'satuan_kecil'=>strtoupper($satuan_kecil));
		$tambah1=array('kd_satuan_besar'=>strtoupper($kd_satuan_kecil),'satuan_besar'=>strtoupper($satuan_kecil));
		$this->msatuankecil->insert('apt_satuan_kecil',$tambah);
		$this->msatuankecil->insert('apt_satuan_besar',$tambah1);
		
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;
		$msg['posting']=3;

		echo json_encode($msg);
	}

	public function update(){
		$kd_satuan_kecil=$this->input->post('kd_satuan_kecil');
		$kd_satuan_kecil1=$this->input->post('kd_satuan_kecil1');
		$satuan_kecil=$this->input->post('satuan_kecil');
		
		$msg['kd_satuan_kecil']=strtoupper($kd_satuan_kecil);
		$edit=array('kd_satuan_kecil'=>strtoupper($kd_satuan_kecil),'satuan_kecil'=>strtoupper($satuan_kecil));
		$edit1=array('kd_satuan_besar'=>strtoupper($kd_satuan_kecil),'satuan_besar'=>strtoupper($satuan_kecil));
		$edit2=array('kd_satuan_besar'=>strtoupper($kd_satuan_kecil),'kd_satuan_kecil'=>strtoupper($kd_satuan_kecil));
		$this->msatuankecil->update('apt_satuan_kecil',$edit,'kd_satuan_kecil="'.$kd_satuan_kecil1.'"');
		$this->msatuankecil->update('apt_satuan_besar',$edit1,'kd_satuan_besar="'.$kd_satuan_kecil1.'"');
		$this->msatuankecil->update('apt_obat',$edit2,'kd_satuan_kecil="'.$kd_satuan_kecil1.'"');
		
		$msg['pesan']="Data Berhasil Di Edit";
		$msg['status']=1;
		$msg['posting']=3;

		echo json_encode($msg);
	}

	public function edit($id=""){
		if(!$this->muser->isAkses("7")){
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
		
		$data=array('items'=>$this->msatuankecil->ambilItemData('apt_satuan_kecil','kd_satuan_kecil="'.$id.'"'));
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/satuankecil/editsatuankecil',$data);
		$this->load->view('footer',$datafooter);

	}
	public function hapus($id=""){
		if(!$this->muser->isAkses("8")){
			$this->restricted();
			return false;
		}
		
		if(!empty($id)){
			$this->msatuankecil->delete('apt_satuan_kecil','kd_satuan_kecil="'.$id.'"');
			$this->msatuankecil->delete('apt_satuan_besar','kd_satuan_besar="'.$id.'"');
			redirect('/masterapotek/satuankecil/');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */