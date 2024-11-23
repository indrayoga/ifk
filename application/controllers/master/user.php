<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

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
		$this->load->model('master/muser');
		//var_dump($this->muser);
	}
	public function index()
	{
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

		$data=array(
			'datapegawai'=>$this->muser->daftarPegawai(),
			'dataakses'=>$this->muser->ambilData('akses')
			);

		$this->load->view('master/header',$dataheader);
		$this->load->view('master/tambahuser',$data);
		$this->load->view('footer',$datafooter);
	}	

	public function tampil()
	{

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

		$data=array(
			'items'=>$this->muser->daftarUser()
			);
		//debugvar($data['akunkas']);

		$this->load->view('master/header',$dataheader);
		$this->load->view('master/user',$data);
		$this->load->view('footer',$datafooter);

	}

	public function tambah()
	{
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
			
		);

		$this->load->view('header',$dataheader);
		$this->load->view('master/tambahpropinsi',$data);
		$this->load->view('footer',$datafooter);
	}

	public function validasi()
	{
		$msg=array();
		$mode=$this->input->post('mode');
		$submit=$this->input->post('submit');
		$nama_pegawai=$this->input->post('nama_pegawai');
		$jk=$this->input->post('jk');
		$alamat=$this->input->post('alamat');
		$no_telepon=$this->input->post('no_telepon');
		$tempat_lahir=$this->input->post('tempat_lahir');
		$tanggal_lahir=$this->input->post('tanggal_lahir');
		$jenis_pegawai=$this->input->post('jenis_pegawai');

		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if(empty($nama_pegawai)){
			$jumlaherror++;
			$msg['id'][]="nama_pegawai";
			$msg['pesan'][]="Nama Harus di Isi";
		}
		if(empty($no_telepon)){
			$jumlaherror++;
			$msg['id'][]="no_telepon";
			$msg['pesan'][]="No Telepon Harus di Isi";
		}

		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}

		echo json_encode($msg);

	}

	public function simpan()
	{
		$msg=array();
		$id_pegawai=$this->input->post('id_pegawai');
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		$aksesuser=$this->input->post('aksesuser');
		//debugvar($akunkas);
		$datauser=array('id_pegawai'=>$id_pegawai,'username'=>$username,
							'password'=>md5($password));
		$id_user=$this->muser->insert('user',$datauser);
		//debugvar($akunkas);
		$this->muser->delete('user_akses','id_user="'.$id_user.'"');
		foreach ($aksesuser as $akses) {
			# code...
			$datatarifunit=array('id_user'=>$id_user,
								'id_akses'=>$akses);
			$this->muser->insert('user_akses',$datatarifunit);
		}

		$msg['status']=1;
		$msg['pesan']="Data Berhasil Di Simpan";

		echo json_encode($msg);
	}

	public function hapus($id=""){
		if(!empty($id)){
			$this->muser->delete('pegawai','id_pegawai="'.$id.'"');
			$msg['status']=1;
			echo json_encode($msg);
		}
	}




	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */