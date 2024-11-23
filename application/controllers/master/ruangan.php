<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
class Ruangan extends Rumahsakit {

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
		if(!$this->muser->isAkses("971")){
			$this->restricted();
			return false;
		}
		$no_kamar=$this->input->post('no_kamar');
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
			'items'=>$this->mmaster->ambilDataRuangan($no_kamar)
			
		);
		$this->load->view('master/header',$dataheader);
		$this->load->view('master/ruangan',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function tambah()
	{
		if(!$this->muser->isAkses("972")){
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
			'dataunit'=>$this->mmaster->ambilData('unit_kerja'),
			'datakelas'=>$this->mmaster->ambilData('kelas_pelayanan')
		);

		$this->load->view('master/header',$dataheader);
		$this->load->view('master/tambahruangan',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksa()
	{
		$msg=array();
		$mode=$this->input->post('mode');
		$submit=$this->input->post('submit');
		$no_kamar=$this->input->post('no_kamar');
		$kd_unit_kerja=$this->input->post('kd_unit_kerja');
		$kd_kelas=$this->input->post('kd_kelas');
		$jml_bed=$this->input->post('jml_bed');
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if(empty($no_kamar)){
			$jumlaherror++;
			$msg['id'][]="no_kamar";
			$msg['pesan'][]="No. Kamar Harus di Isi";
		}

		if($mode!="edit"){
			if($this->mmaster->isExist('no_kamar','no_kamar',$no_kamar)){
				$jumlaherror++;
				$msg['id'][]="no_kamar";
				$msg['pesan'][]="No. Kamar sudah ada";
			}			
		}

		if(empty($jml_bed)){
			$jumlaherror++;
			$msg['id'][]="jml_bed";
			$msg['pesan'][]="Kolom Jml. Kasur Harus di Isi";
		}

		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}

		echo json_encode($msg);

	}

	public function simpan(){
		$no_kamar=$this->input->post('no_kamar');
		$kd_unit_kerja=$this->input->post('kd_unit_kerja');
		$kd_kelas=$this->input->post('kd_kelas');
		$jml_bed=$this->input->post('jml_bed');
		
		$status_bed="K";
		
		$data=array(
			'no_kamar'=>$no_kamar,
			'kd_unit_kerja'=>$kd_unit_kerja,
			'kd_kelas'=>$kd_kelas,
			'jml_bed'=>$jml_bed
		);
		$this->mmaster->insert('no_kamar',$data);
		for($i=0;$i<$jml_bed;$i++){
			$bed=$i+1;
			$no_bed=str_pad($bed,2,0,STR_PAD_LEFT); 
			$databed=array(
				'no_kamar'=>$no_kamar,
				'no_bed'=>$no_bed,
				'status_bed'=>$status_bed
			);
			$this->mmaster->insert('status_bed',$databed);
		}
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function update(){
		$no_kamar=$this->input->post('no_kamar');
		$kd_unit_kerja=$this->input->post('kd_unit_kerja');
		$kd_kelas=$this->input->post('kd_kelas');
		$jml_bed=$this->input->post('jml_bed');
		
		$status_bed="K";
		
		$data=array(
			'kd_unit_kerja'=>$kd_unit_kerja,
			'kd_kelas'=>$kd_kelas,
			'jml_bed'=>$jml_bed
		);
		$this->mmaster->update('no_kamar',$data,'no_kamar="'.$no_kamar.'"');
		$this->mmaster->delete('status_bed','no_kamar="'.$no_kamar.'"');
		for($i=0;$i<$jml_bed;$i++){
			$bed=$i+1;
			$no_bed=str_pad($bed,2,0,STR_PAD_LEFT); 
			$databed=array(
				'no_kamar'=>$no_kamar,
				'no_bed'=>$no_bed,
				'status_bed'=>$status_bed
			);
			$this->mmaster->insert('status_bed',$databed);
		}
		$msg['pesan']="Data Berhasil Di Edit";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function edit($id=""){
		if(!$this->muser->isAkses("973")){
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
			'item'=>$this->mmaster->ambilItemData('no_kamar','no_kamar="'.$id.'"'),
			'dataunit'=>$this->mmaster->ambilData('unit_kerja'),
			'datakelas'=>$this->mmaster->ambilData('kelas_pelayanan')
		);
		$this->load->view('master/header',$dataheader);
		$this->load->view('master/editruangan',$data);
		$this->load->view('footer',$datafooter);

	}
	public function hapus($id=""){
		if(!$this->muser->isAkses("974")){
			$this->restricted();
			return false;
		}
		if(!empty($id)){
			$this->mmaster->delete('no_kamar','no_kamar="'.$id.'"');
			$this->mmaster->delete('status_bed','no_kamar="'.$id.'"');
			redirect('/master/ruangan');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */