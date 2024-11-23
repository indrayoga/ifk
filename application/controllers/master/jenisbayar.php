<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenisbayar extends CI_Controller {

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
	public function index()
	{
		$jenis_bayar=$this->input->post('jenis_bayar');
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
			'items'=>$this->mmaster->ambilData("jenis_bayar",'jenis_bayar like "%'.$jenis_bayar.'%" '),
			
		);
		$this->load->view('master/header',$dataheader);
		$this->load->view('master/jenisbayar',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function tambah()
	{
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
			
		);

		$this->load->view('master/header',$dataheader);
		$this->load->view('master/tambahjenisbayar',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksa()
	{
		$msg=array();
		$mode=$this->input->post('mode');
		$submit=$this->input->post('submit');
		$kd_jenis_bayar=$this->input->post('kd_jenis_bayar');
		$jenis_bayar=$this->input->post('jenis_bayar');
		$tag=$this->input->post('tag');
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if(empty($kd_jenis_bayar)){
			$jumlaherror++;
			$msg['id'][]="kd_jenis_bayar";
			$msg['pesan'][]="Kode Harus di Isi";
		}

		if($mode!="edit"){
			if($this->mmaster->isExist('jenis_bayar','kd_jenis_bayar',$kd_jenis_bayar)){
				$jumlaherror++;
				$msg['id'][]="kd_jenis_bayar";
				$msg['pesan'][]="Kode Sudah Ada";
			}			
		}

		if(empty($jenis_bayar)){
			$jumlaherror++;
			$msg['id'][]="jenis_bayar";
			$msg['pesan'][]="Kolom Jenis Bayar Harus di Isi";
		}

		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}

		echo json_encode($msg);

	}

	public function simpan(){
		$kd_jenis_bayar=$this->input->post('kd_jenis_bayar');
		$jenis_bayar=$this->input->post('jenis_bayar');
		$tag=$this->input->post('tag');
		$data=array(
			'kd_jenis_bayar'=>$kd_jenis_bayar,
			'jenis_bayar'=>$jenis_bayar,
			'tag'=>$tag
		);
		$this->mmaster->insert('jenis_bayar',$data);		
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function update(){
		$kd_jenis_bayar=$this->input->post('kd_jenis_bayar');
		$jenis_bayar=$this->input->post('jenis_bayar');
		$tag=$this->input->post('tag');
		$data=array(
			'jenis_bayar'=>$jenis_bayar,
			'tag'=>$tag
		);
		$this->mmaster->update('jenis_bayar',$data,'kd_jenis_bayar="'.$kd_jenis_bayar.'"');		
		$msg['pesan']="Data Berhasil Di Update";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function edit($id=""){
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
			'item'=>$this->mmaster->ambilItemData('jenis_bayar','kd_jenis_bayar="'.$id.'"')
		);
		$this->load->view('master/header',$dataheader);
		$this->load->view('master/editjenisbayar',$data);
		$this->load->view('footer',$datafooter);

	}
	public function hapus($id=""){
		if(!empty($id)){
			$this->mmaster->delete('jenis_bayar','kd_jenis_bayar="'.$id.'"');
			redirect('/master/jenisbayar');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */