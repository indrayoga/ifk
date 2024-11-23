<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
class Admpendaftaran extends Rumahsakit {

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

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('utilities');
		$this->load->library('pagination');
		$this->load->model('master/madmpendaftaran');

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
	
	public function index($unit1='')
	{
		if(!$this->muser->isAkses("908")){
			$this->restricted();
			return false;
		}
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
		$jsfileheader=array('vendor/jquery-1.9.1.min.js',
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
							'spin.js');
		$dataheader=array(
			'jsfile'=>$jsfileheader,
			'cssfile'=>$cssfileheader,
			'title'=>$this->title
			);

		$jsfooter=array();
		$datafooter=array(
			'jsfile'=>$jsfooter
			);
		$data=array('detilbmhp'=>$this->madmpendaftaran->getBMHP($unit1),
					'datapelayanan'=>$this->madmpendaftaran->ambilData(),
					'datapelayananunit'=>$this->madmpendaftaran->getAllPelayananUnit($unit1),
					'unit'=>$unit1);
		
		$this->load->view('master/header',$dataheader);
		$this->load->view('master/admpendaftaran',$data);
		$this->load->view('footer',$datafooter);
	}
	
	
	public function periksa()
	{
		$msg=array();
		$submit=$this->input->post('submit');
		$unit=$this->input->post('unit');		
		$pelayananunit=$this->input->post('pelayananunit');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if(empty($unit)){
			$jumlaherror++;
			$msg['id'][]="unit";
			$msg['pesan'][]="Unit belum dipilih !";
		}		
		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}
		
		echo json_encode($msg);
	}
	
	public function simpan(){
		$msg=array();
		$submit=$this->input->post('submit');
		$unit=$this->input->post('unit');		
		$pelayananunit=$this->input->post('pelayananunit');
		if($submit=="simpan"){
			$this->madmpendaftaran->delete('administrasi_pendaftaran','unit="'.$unit.'"');
			foreach ($pelayananunit as $pelayanan) {
				# code...
				$data=array('unit'=>$unit,
							'kd_pelayanan'=>$pelayanan);
				$this->madmpendaftaran->insert('administrasi_pendaftaran',$data);
			}
			$msg['pesan']="Data Berhasil Di Simpan";
			$msg['status']=1;
		}		
		echo json_encode($msg);
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */