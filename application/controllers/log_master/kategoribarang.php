<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kategoribarang extends CI_Controller {

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
		$kategori=$this->input->post('kategori');
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
			'items'=>$this->mlogistik->ambilKategori($kategori)
			
		);
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/master/kategori/kategoribarang',$data);
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
		$this->load->view('logistik/master/kategori/tambahkategoribarang',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksa()
	{
		$msg=array();
		$mode=$this->input->post('mode');
		$submit=$this->input->post('submit');
		$kd_kategori=$this->input->post('kd_kategori');
		$kategori=$this->input->post('kategori');
		$parent=$this->input->post('parent');
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if(empty($kd_kategori)){
			$jumlaherror++;
			$msg['id'][]="kd_kategori";
			$msg['pesan'][]="Kd. Kategori Harus di Isi";
		}

		if($mode!="edit"){
			if($this->mlogistik->isExist('log_kategori_barang','kd_kategori',$kd_kategori)){
				$jumlaherror++;
				$msg['id'][]="kd_kategori";
				$msg['pesan'][]="Kd. Kategori sudah ada";
			}			
		}
		if(empty($kategori)){
			$jumlaherror++;
			$msg['id'][]="kategori";
			$msg['pesan'][]="Kolom Kategori Harus di Isi";
		}

		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}

		echo json_encode($msg);

	}

	public function simpan(){
		$kd_kategori=$this->input->post('kd_kategori');
		$kategori=$this->input->post('kategori');
		$parent=$this->input->post('parent');
		
		$data=array(
			'kd_kategori'=>$kd_kategori,
			'kategori'=>$kategori,
			'parent'=>$parent
		);
		$this->mlogistik->insert('log_kategori_barang',$data);
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function update(){
		$kd_kategori=$this->input->post('kd_kategori');
		$kategori=$this->input->post('kategori');
		$parent=$this->input->post('parent');
		
		$data=array(
			'kategori'=>$kategori,
			'parent'=>$parent
		);
		$this->mlogistik->update('log_kategori_barang',$data,'kd_kategori="'.$kd_kategori.'"');
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
			'item'=>$this->mlogistik->ambilItemData('log_kategori_barang','kd_kategori="'.urldecode($id).'"')
		);
		//debugvar($data);
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/master/kategori/editkategoribarang',$data);
		$this->load->view('footer',$datafooter);

	}
	
	public function hapus($id=""){
		if(!empty($id)){
			$this->mlogistik->delete('log_kategori_barang','kd_kategori="'.$id.'"');
			redirect('/log_master/kategoribarang/');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */