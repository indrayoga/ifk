<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Golongan extends CI_Controller {
class Golongan extends Rumahsakit {

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
		$this->load->model('apotek/mgolongan');

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
		if(!$this->muser->isAkses("9")){
			$this->restricted();
			return false;
		}
		
		$golongan=$this->input->post('golongan');
		
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
		$data=array('golongan'=>$golongan,
					'items'=>$this->mgolongan->ambilDataGolongan($golongan));
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/golongan/golongan',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function tambah()
	{
		if(!$this->muser->isAkses("10")){
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
		$this->load->view('apotek/master/golongan/tambahgolongan',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksa()
	{
		$msg=array();
		$mode=$this->input->post('mode');
		$submit=$this->input->post('submit');
		$kd_golongan=$this->input->post('kd_golongan');
		$golongan=$this->input->post('golongan');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if($mode!="edit"){
			if($this->mgolongan->isExist('apt_golongan','kd_golongan',$kd_golongan)){
				$jumlaherror++;
				$msg['id'][]="kd_golongan";
				$msg['pesan'][]="Kode golongan sudah ada";
			}			
		}
		if(empty($kd_golongan)){
			$jumlaherror++;
			$msg['id'][]="kd_golongan";
			$msg['pesan'][]="Kode golongan Harus di Isi";
		}			
		if(empty($golongan)){
			$jumlaherror++;
			$msg['id'][]="golongan";
			$msg['pesan'][]="Golongan obat harus di isi";
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
		$kd_golongan=$this->input->post('kd_golongan');
		$golongan=$this->input->post('golongan');
		
		$msg['kd_golongan']=strtoupper($kd_golongan);
		$tambahgolongan=array('kd_golongan'=>strtoupper($kd_golongan),
								'golongan'=>strtoupper($golongan));
		$this->mgolongan->insert('apt_golongan',$tambahgolongan);
		
		$tambahmargin=array('kd_golongan'=>strtoupper($kd_golongan),
							'kd_jenis_obat'=>139,
							'nilai_margin'=>1.2);
		$this->mgolongan->insert('apt_margin_harga',$tambahmargin);
		
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;
		$msg['posting']=3;

		echo json_encode($msg);
	}

	public function update(){
		$kd_golongan=$this->input->post('kd_golongan');
		$kd_golongan1=$this->input->post('kd_golongan1');
		$golongan=$this->input->post('golongan');
		
		$msg['kd_golongan']=strtoupper($kd_golongan);
		$edit=array('kd_golongan'=>strtoupper($kd_golongan),
					'golongan'=>strtoupper($golongan));
		$this->mgolongan->update('apt_golongan',$edit,'kd_golongan="'.$kd_golongan1.'"');
		
		$editmargin=array('kd_golongan'=>strtoupper($kd_golongan));
		$this->mgolongan->update('apt_margin_harga',$editmargin,'kd_golongan="'.$kd_golongan1.'"');
		
		$msg['pesan']="Data Berhasil Di Edit";
		$msg['status']=1;
		$msg['posting']=3;

		echo json_encode($msg);
	}

	public function edit($id=""){
		if(!$this->muser->isAkses("11")){
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
		
		$data=array('items'=>$this->mgolongan->ambilItemData('apt_golongan','kd_golongan="'.urldecode($id).'"'));
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/golongan/editgolongan',$data);
		$this->load->view('footer',$datafooter);

	}
	public function hapus($id=""){
		if(!$this->muser->isAkses("12")){
			$this->restricted();
			return false;
		}
		
		if(!empty($id)){
			$this->mgolongan->delete('apt_golongan','kd_golongan="'.$id.'"');
			$this->mgolongan->delete('apt_margin_harga','kd_golongan="'.$id.'"');
			redirect('/masterapotek/golongan/');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */