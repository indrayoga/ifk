<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
class Dokterunit extends Rumahsakit {

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
		$this->load->model('master/mdokterunit');

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

	public function index($unit1=''){		

		if(!$this->muser->isAkses("950")){
			$this->restricted();
			return false;
		}
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
		$data=array('datapoli'=>$this->mdokterunit->ambilData('unit_kerja'),
					'datadokter'=>$this->mdokterunit->getDokter($unit1),
					'unit'=>$unit1);
		
		$this->load->view('master/header',$dataheader);
		$this->load->view('master/dokterunit',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksa()
	{
		$msg=array();
		$mode=$this->input->post('mode');
		$submit=$this->input->post('submit');
		$kd_dokter=$this->input->post('kd_dokter');
		$nama_dokter=$this->input->post('nama_dokter');
		$kd_unit_kerja=$this->input->post('kd_unit_kerja');
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if(empty($kd_unit_kerja)){
			$jumlaherror++;
			$msg['id'][]="kd_unit_kerja";
			$msg['pesan'][]="Unit belum di pilih";
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
		$kd_unit_kerja=$this->input->post('kd_unit_kerja');
		$kd_dokter=$this->input->post('kd_dokter');
		$nama_dokter=$this->input->post('nama_dokter');
		if($submit=="simpan"){
			$this->mdokterunit->delete('dokter_unit_kerja','kd_unit="'.$kd_unit_kerja.'"');
			foreach ($kd_dokter as $key => $value) {
				# code...
				$data=array('kd_unit'=>$kd_unit_kerja,
									'kd_dokter'=>$value);
				$this->mdokterunit->insert('dokter_unit_kerja',$data);
			}
			$msg['pesan']="Data Berhasil Di Simpan";
			$msg['status']=1;
		}		
		echo json_encode($msg);
	}

	public function ambildokterbykode(){
		$q=$this->input->get('query');
		$items=$this->mdokterunit->ambilData3($q);
		echo json_encode($items);
	}
	
	public function ambildokterbynama(){
		$q=$this->input->get('query');
		$items=$this->mdokterunit->ambilData4($q);
		echo json_encode($items);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */