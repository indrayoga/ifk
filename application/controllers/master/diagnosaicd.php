<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
class Diagnosaicd extends Rumahsakit {

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
	protected $akses='109';

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('utilities');
		$this->load->library('pagination');
		$this->load->model('master/mmaster');
		
		if(!$this->muser->isLogin()){
			redirect('/home/');
			return false;
		}

	}

	public function restricted(){
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
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

		$this->load->view('master/header',$dataheader);
		$data=array();
		parent::view_restricted($data);
		$this->load->view('footer');
	}

	public function index()
	{
		if(!$this->muser->isAkses("951")){
			$this->restricted();
			return false;
		}
		$diagnosa=$this->input->post('diagnosa');
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','theme.css');
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

		$data=array(
			'items'=>$this->mmaster->ambilDiagnosaICD($diagnosa)
			
		);
		$this->load->view('master/header',$dataheader);
		$this->load->view('master/diagnosaicd',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function tambah()
	{
		if(!$this->muser->isAkses("952")){
			$this->restricted();
			return false;
		}
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','timepicker.css','theme.css');
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

		$this->load->view('master/header',$dataheader);
		$this->load->view('master/tambahdiagnosaicd',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksa()
	{
		$msg=array();
		$mode=$this->input->post('mode');
		$submit=$this->input->post('submit');
		$kd_diagnosa_icd=$this->input->post('kd_diagnosa_icd');
		$no_dtd=$this->input->post('no_dtd');
		$diagnosa=$this->input->post('diagnosa');
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if(empty($kd_diagnosa_icd)){
			$jumlaherror++;
			$msg['id'][]="kd_diagnosa_icd";
			$msg['pesan'][]="Kd. Diagnosa ICD Harus di Isi";
		}

		if($mode!="edit"){
			if($this->mmaster->isExist('diagnosa_icd','kd_diagnosa_icd',$kd_diagnosa_icd)){
				$jumlaherror++;
				$msg['id'][]="kd_diagnosa_icd";
				$msg['pesan'][]="Kd. Diagnosa ICD sudah ada";
			}			
		}

		if(empty($diagnosa)){
			$jumlaherror++;
			$msg['id'][]="diagnosa";
			$msg['pesan'][]="Kolom Diagnosa Harus di Isi";
		}

		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}

		echo json_encode($msg);

	}

	public function simpan(){
		$kd_diagnosa_icd=$this->input->post('kd_diagnosa_icd');
		$no_dtd=$this->input->post('no_dtd');
		$diagnosa=$this->input->post('diagnosa');
		
		$data=array(
			'kd_diagnosa_icd'=>$kd_diagnosa_icd,
			'no_dtd'=>$no_dtd,
			'diagnosa'=>$diagnosa
		);
		$this->mmaster->insert('diagnosa_icd',$data);
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function update(){
		$kd_diagnosa_icd=$this->input->post('kd_diagnosa_icd');
		$no_dtd=$this->input->post('no_dtd');
		$diagnosa=$this->input->post('diagnosa');
		
		$data=array(
			'no_dtd'=>$no_dtd,
			'diagnosa'=>$diagnosa
		);
		$this->mmaster->update('diagnosa_icd',$data,'kd_diagnosa_icd="'.$kd_diagnosa_icd.'"');
		$msg['pesan']="Data Berhasil Di Edit";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function edit($id=""){
		if(!$this->muser->isAkses("953")){
			$this->restricted();
			return false;
		}
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','timepicker.css','theme.css');
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

		$data=array(
			'item'=>$this->mmaster->ambilItemData('diagnosa_icd','kd_diagnosa_icd="'.urldecode($id).'"')
		);
		//debugvar($data);
		$this->load->view('master/header',$dataheader);
		$this->load->view('master/editdiagnosaicd',$data);
		$this->load->view('footer',$datafooter);

	}
	public function hapus($id=""){
		if(!$this->muser->isAkses("954")){
			$this->restricted();
			return false;
		}
		if(!empty($id)){
			$this->mmaster->delete('diagnosa_icd','kd_diagnosa_icd="'.$id.'"');
			redirect('/master/diagnosaicd');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */