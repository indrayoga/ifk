<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tarifcustomer extends CI_Controller {

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
		$kd_jenis_tarif=$this->input->post('kd_jenis_tarif');
		$cust_code=$this->input->post('cust_code');
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
			'items'=>$this->mmaster->ambilDataTarifCustomer($kd_jenis_tarif,$cust_code),
			'datajenistarif'=>$this->mmaster->ambilData('jenis_tarif'),
			'datacustomer'=>$this->mmaster->ambilData('apt_customers')			
		);
		$this->load->view('master/header',$dataheader);
		$this->load->view('master/tarifcustomer',$data);
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
			'datajenistarif'=>$this->mmaster->ambilData('jenis_tarif'),
			'datacustomer'=>$this->mmaster->ambilData('apt_customers')			
		);

		$this->load->view('master/header',$dataheader);
		$this->load->view('master/tambahtarifcustomer',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksa()
	{
		$msg=array();
		$mode=$this->input->post('mode');
		$submit=$this->input->post('submit');
		$kd_jenis_tarif=$this->input->post('kd_jenis_tarif');
		$cust_code=$this->input->post('cust_code');
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if(empty($kd_jenis_tarif)){
			$jumlaherror++;
			$msg['id'][]="kd_jenis_tarif";
			$msg['pesan'][]="Jenis Tarif Harus di Isi";
		}

		if(empty($cust_code)){
			$jumlaherror++;
			$msg['id'][]="cust_code";
			$msg['pesan'][]="Customer Harus di Isi";
		}

		if($mode!="edit"){
			if($this->mmaster->isExistTarifCustomer($kd_jenis_tarif,$cust_code)){
				$jumlaherror++;
				$msg['id'][]="kd_jenis_tarif";
				$msg['pesan'][]="Tarif customer Sudah Ada";
			}			
		}

		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}

		echo json_encode($msg);

	}

	public function simpan(){
		$kd_jenis_tarif=$this->input->post('kd_jenis_tarif');
		$cust_code=$this->input->post('cust_code');
		$data=array(
			'kd_jenis_tarif'=>$kd_jenis_tarif,
			'cust_code'=>$cust_code
		);
		$this->mmaster->insert('tarif_customers',$data);		
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function update(){
		$kd_jenis_tarif_lama=$this->input->post('kd_jenis_tarif_lama');
		$cust_code_lama=$this->input->post('cust_code_lama');
		$kd_jenis_tarif=$this->input->post('kd_jenis_tarif');
		$cust_code=$this->input->post('cust_code');
		$data=array(
			'kd_jenis_tarif'=>$kd_jenis_tarif,
			'cust_code'=>$cust_code
		);
		$this->mmaster->update('tarif_customers',$data,'kd_jenis_tarif="'.$kd_jenis_tarif_lama.'" and cust_code="'.$cust_code_lama.'"');		
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function edit($id="",$cust=""){
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
			'item'=>$this->mmaster->ambilItemData('tarif_customers','kd_jenis_tarif="'.$id.'" and cust_code="'.$cust.'"'),
			'datajenistarif'=>$this->mmaster->ambilData('jenis_tarif'),
			'datacustomer'=>$this->mmaster->ambilData('apt_customers')			
		);
		$this->load->view('master/header',$dataheader);
		$this->load->view('master/edittarifcustomer',$data);
		$this->load->view('footer',$datafooter);

	}
	public function hapus($id="",$cust=""){
		if(!empty($id)){
			$this->mmaster->delete('tarif_customers','kd_jenis_tarif="'.$id.'" and cust_code="'.$cust.'"');
			redirect('/master/tarifcustomer');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */