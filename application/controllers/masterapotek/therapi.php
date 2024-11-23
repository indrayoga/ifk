<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Satuankecil extends CI_Controller {
class Therapi extends Rumahsakit {

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
		
		$therapi=$this->input->post('therapi');
		
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
		$data=array('therapi'=>$therapi,
					'items'=>$this->msatuankecil->ambilData('obat_therapi','therapi like "%'.$therapi.'%" '));
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/therapi/therapi',$data);
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
		$this->load->view('apotek/master/therapi/tambahtherapi',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksa()
	{
		$msg=array();
		$submit=$this->input->post('submit');
		$therapi=$this->input->post('therapi');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if(empty($therapi)){
			$jumlaherror++;
			$msg['id'][]="therapi";
			$msg['pesan'][]="Nama Therapi obat harus di isi";
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
		$therapi=$this->input->post('therapi');
		
		$tambah=array('therapi'=>$therapi);
		$id=$this->msatuankecil->insert('obat_therapi',$tambah);
		$msg['id']=$id;
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;
		$msg['posting']=3;

		echo json_encode($msg);
	}

	public function update(){
		$therapi=$this->input->post('therapi');
		$kd_therapi=$this->input->post('kd_therapi');
		
		$msg['id']=$kd_therapi;
		$edit=array('therapi'=>$therapi);
		$this->msatuankecil->update('obat_therapi',$edit,'kd_therapi="'.$kd_therapi.'"');
		
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
		
		$data=array('items'=>$this->msatuankecil->ambilItemData('obat_therapi','kd_therapi="'.$id.'"'));
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/therapi/edittherapi',$data);
		$this->load->view('footer',$datafooter);

	}
	public function hapus($id=""){
		if(!$this->muser->isAkses("8")){
			$this->restricted();
			return false;
		}
		
		if(!empty($id)){
			$this->msatuankecil->delete('obat_therapi','kd_therapi="'.$id.'"');
			redirect('/masterapotek/therapi/');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */