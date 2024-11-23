<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Satuan extends CI_Controller {

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
		$this->load->model('logistik/mlogistik');

	}
	public function index()
	{
		$satuan=$this->input->post('satuan');
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
			'items'=>$this->mlogistik->ambilSatuan($satuan)
			
		);
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/master/satuan/satuan',$data);
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

		$data=array();

		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/master/satuan/tambahsatuan',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksa()
	{
		$msg=array();
		$mode=$this->input->post('mode');
		$submit=$this->input->post('submit');
		$kd_satuan=$this->input->post('kd_satuan');
		$satuan=$this->input->post('satuan');
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if(empty($kd_satuan)){
			$jumlaherror++;
			$msg['id'][]="kd_satuan";
			$msg['pesan'][]="Kd. satuan Harus di Isi";
		}

		if($mode!="edit"){
			if($this->mlogistik->isExist('log_satuan','kd_satuan',$kd_satuan)){
				$jumlaherror++;
				$msg['id'][]="kd_satuan";
				$msg['pesan'][]="Kd. satuan sudah ada";
			}			
		}

		if(empty($satuan)){
			$jumlaherror++;
			$msg['id'][]="satuan";
			$msg['pesan'][]="Kolom satuan Harus di Isi";
		}

		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}

		echo json_encode($msg);

	}

	public function simpan(){
		$kd_satuan=$this->input->post('kd_satuan');
		$satuan=$this->input->post('satuan');
		
		$data=array(
			'kd_satuan'=>$kd_satuan,
			'satuan'=>$satuan
		);
		$this->mlogistik->insert('log_satuan',$data);
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function update(){
		$kd_satuan=$this->input->post('kd_satuan');
		$satuan=$this->input->post('satuan');
		
		$data=array(
			'satuan'=>$satuan
		);
		$this->mlogistik->update('log_satuan',$data,'kd_satuan="'.$kd_satuan.'"');
		$msg['pesan']="Data Berhasil Di Edit";
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
			'item'=>$this->mlogistik->ambilItemData('log_satuan','kd_satuan="'.urldecode($id).'"')
		);
		//debugvar($data);
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/master/satuan/editsatuan',$data);
		$this->load->view('footer',$datafooter);

	}
	public function hapus($id=""){
		if(!empty($id)){
			$this->mlogistik->delete('log_satuan','kd_satuan="'.$id.'"');
			redirect('/log_master/satuan');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */