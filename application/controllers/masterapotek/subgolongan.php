<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Subgolongan extends CI_Controller {
class Subgolongan extends Rumahsakit {

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
		$this->load->model('apotek/msubgolongan');

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
		if(!$this->muser->isAkses("13")){
			$this->restricted();
			return false;
		}
		
		$sub_golongan=$this->input->post('sub_golongan');
		
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
		$data=array('sub_golongan'=>$sub_golongan,
					'items'=>$this->msubgolongan->ambilDataSubGolongan($sub_golongan));
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/subgolongan/subgolongan',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function tambah()
	{
		if(!$this->muser->isAkses("14")){
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

		$data=array('golongan'=>$this->msubgolongan->ambilData('apt_golongan'));					
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/subgolongan/tambahsubgolongan',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksa()
	{
		$msg=array();
		$mode=$this->input->post('mode');
		$submit=$this->input->post('submit');
		$kd_sub=$this->input->post('kd_sub');
		$sub_golongan=$this->input->post('sub_golongan');
		$kd_golongan=$this->input->post('kd_golongan');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if($mode!="edit"){
			if($this->msubgolongan->isExist('apt_sub_golongan','kd_sub',$kd_sub)){
				$jumlaherror++;
				$msg['id'][]="kd_sub";
				$msg['pesan'][]="Kode sub golongan sudah ada";
			}			
		}
		if(empty($kd_sub)){
			$jumlaherror++;
			$msg['id'][]="kd_sub";
			$msg['pesan'][]="Kode sub golongan Harus di Isi";
		}			
		if(empty($sub_golongan)){
			$jumlaherror++;
			$msg['id'][]="sub_golongan";
			$msg['pesan'][]="Sub golongan obat harus di isi";
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
		$kd_sub=$this->input->post('kd_sub');
		$sub_golongan=$this->input->post('sub_golongan');
		$kd_golongan=$this->input->post('kd_golongan');
		
		$msg['kd_sub']=strtoupper($kd_sub);
		$tambahgolongan=array('kd_sub'=>strtoupper($kd_sub),
								'sub_golongan'=>strtoupper($sub_golongan),
								'kd_golongan'=>$kd_golongan);
		$this->msubgolongan->insert('apt_sub_golongan',$tambahgolongan);
		
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;
		$msg['posting']=3;

		echo json_encode($msg);
	}

	public function update(){
		$kd_sub=$this->input->post('kd_sub');
		$kd_sub1=$this->input->post('kd_sub1');
		$sub_golongan=$this->input->post('sub_golongan');
		$kd_golongan=$this->input->post('kd_golongan');
		
		$msg['kd_sub']=strtoupper($kd_sub);
		$edit=array('kd_sub'=>strtoupper($kd_sub),
					'sub_golongan'=>strtoupper($sub_golongan),
					'kd_golongan'=>$kd_golongan);
		$edit1=array('kd_sub'=>strtoupper($kd_sub));
		$this->msubgolongan->update('apt_sub_golongan',$edit,'kd_sub="'.$kd_sub1.'"');
		$this->msubgolongan->update('apt_obat',$edit1,'kd_sub="'.$kd_sub1.'"');
		
		$msg['pesan']="Data Berhasil Di Edit";
		$msg['status']=1;
		$msg['posting']=3;

		echo json_encode($msg);
	}

	public function edit($id=""){
		if(!$this->muser->isAkses("15")){
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
		
		$data=array('items'=>$this->msubgolongan->ambilItemData('apt_sub_golongan','kd_sub="'.urldecode($id).'"'),
					'golongan'=>$this->msubgolongan->ambilData('apt_golongan'));
		//debugvar($data);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/subgolongan/editsubgolongan',$data);
		$this->load->view('footer',$datafooter);

	}
	public function hapus($id=""){
		if(!$this->muser->isAkses("16")){
			$this->restricted();
			return false;
		}
		
		if(!empty($id)){
			$this->msubgolongan->delete('apt_sub_golongan','kd_sub="'.$id.'"');
			redirect('/masterapotek/subgolongan/');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */