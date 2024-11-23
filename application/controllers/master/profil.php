<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
class Profil extends Rumahsakit {

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

	protected $title='GFK BALIKPAPAN';

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('utilities');
		$this->load->library('pagination');
		$this->load->model('master/mprofil');

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
		if(!$this->muser->isAkses("909")){
			//$this->restricted();
			//return false;
		}
		$nama_profil=$this->input->post('nama_profil');
		
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
		$data=array('items'=>$this->mprofil->ambilDataProfil($nama_profil));
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('master/profil',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function tambah()
	{
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

		$data=array('kd_profil'=>'',
					'datakelurahan'=>$this->mprofil->ambilData('kelurahan'),
					'datakecamatan'=>$this->mprofil->ambilData('kecamatan'));
					
		$this->load->view('master/header',$dataheader);
		$this->load->view('master/tambahprofil',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksa()
	{
		$msg=array();
		$mode=$this->input->post('mode');
		$submit=$this->input->post('submit');
		$kd_profil=$this->input->post('kd_profil');
		$nama_profil=$this->input->post('nama_profil');
		$alamat_profil=$this->input->post('alamat_profil');
		$kd_kelurahan=$this->input->post('kd_kelurahan');
		$kd_kecamatan=$this->input->post('kd_kecamatan');
		$kecamatan=$this->input->post('kecamatan');
		$kota=$this->input->post('kota');
		$telp_profil=$this->input->post('telp_profil');
		$fax_profil=$this->input->post('fax_profil');
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if($mode!="edit"){
			if($this->mprofil->isExist('profil','kd_profil',$kd_profil)){
				$jumlaherror++;
				$msg['id'][]="kd_profil";
				$msg['pesan'][]="Kd. Profil sudah ada";
			}			
		}/*if(empty($kd_profil)){
			$jumlaherror++;
			$msg['id'][]="kd_profil";
			$msg['pesan'][]="Kode profil harus di isi";
		}*/if(empty($nama_profil)){
			$jumlaherror++;
			$msg['id'][]="nama_profil";
			$msg['pesan'][]="Nama profil harus di isi";
		}if(empty($alamat_profil)){
			$jumlaherror++;
			$msg['id'][]="alamat_profil";
			$msg['pesan'][]="Alamat profil harus di isi";
		}if(empty($kota)){
			$jumlaherror++;
			$msg['id'][]="kota";
			$msg['pesan'][]="Kota harus di isi";
		}/*if(empty($telp_profil)){
			$jumlaherror++;
			$msg['id'][]="telp_profil";
			$msg['pesan'][]="Telp. profil harus di isi";
		}if(empty($fax_profil)){
			$jumlaherror++;
			$msg['id'][]="fax_profil";
			$msg['pesan'][]="Fax profil harus di isi";
		}*/			
		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}
		
		echo json_encode($msg);
	}

	public function simpan(){
		$msg=array();
		$kd_profil=$this->input->post('kd_profil');
		$nama_profil=$this->input->post('nama_profil');
		$alamat_profil=$this->input->post('alamat_profil');
		$kd_kelurahan=$this->input->post('kd_kelurahan');
		$kecamatan=$this->input->post('kecamatan');
		$kd_kecamatan=$this->input->post('kd_kecamatan');
		$kota=$this->input->post('kota');
		$telp_profil=$this->input->post('telp_profil');
		$fax_profil=$this->input->post('fax_profil');
		$email=$this->input->post('email');
		$web=$this->input->post('web');
		
		$kode=$this->mprofil->autoNumber();
		$kodebaru=$kode+1;
		$kodebaru=str_pad($kodebaru,5,0,STR_PAD_LEFT); 
		$kd_profil=$kodebaru;
		$msg['kd_profil']=$kd_profil;
		
		$tambahprofil=array('kd_profil'=>$kd_profil,
						  'nama_profil'=>$nama_profil,
						  'alamat_profil'=>$alamat_profil,
						  'telp_profil'=>$telp_profil,
						  'fax_profil'=>$fax_profil,
						  'kd_kelurahan'=>$kd_kelurahan,
						  'kd_kecamatan'=>$kd_kecamatan,
						  'email'=>$email,
						  'website'=>$web,
						  'kota'=>$kota);
		$this->mprofil->insert('profil',$tambahprofil);
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;
		$msg['posting']=3;

		echo json_encode($msg);
	}

	public function update(){
		$msg=array();
		$kd_profil=$this->input->post('kd_profil');
		$nama_profil=$this->input->post('nama_profil');
		$alamat_profil=$this->input->post('alamat_profil');
		$kd_kelurahan=$this->input->post('kd_kelurahan');
		$kecamatan=$this->input->post('kecamatan');
		$kd_kecamatan=$this->input->post('kd_kecamatan');
		$kota=$this->input->post('kota');
		$telp_profil=$this->input->post('telp_profil');
		$fax_profil=$this->input->post('fax_profil');
		$email=$this->input->post('email');
		$web=$this->input->post('web');
		$nip_kepala=$this->input->post('nip_kepala');
		$nama_kepala=$this->input->post('nama_kepala');
		
		$editprofil=array('nama_profil'=>$nama_profil,
							  'alamat_profil'=>$alamat_profil,
							  'telp_profil'=>$telp_profil,
							  'fax_profil'=>$fax_profil,
							  'email'=>$email,
							  'nip_kepala'=>$nip_kepala,
							  'nama_kepala'=>$nama_kepala,
							  'website'=>$web,
							  'kota'=>$kota);
		$this->mprofil->update('profil',$editprofil,'kd_profil="'.$kd_profil.'"');
		
		$msg['pesan']="Data Berhasil Di Edit";
		$msg['status']=1;
		//$msg['posting']=3;

		echo json_encode($msg);
	}

	public function edit($id=""){
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
		
		$data=array('kd_profil'=>$id,
					'itemtransaksi'=>$this->mprofil->ambilProfil($id),
					//'datakelurahan'=>$this->mprofil->ambilData('kelurahan'),
					//'datakecamatan'=>$this->mprofil->ambilData('kecamatan')
					);
//debugvar($id);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('master/editprofil',$data);
		$this->load->view('footer',$datafooter);

	}
	public function hapus($id=""){
		if(!empty($id)){
			$this->mprofil->delete('profil','kd_profil="'.$id.'"');
			redirect('/master/profil/');
		}
	}
	
	public function ambilkecamatan(){
		$q=$this->input->get('query');
		$items=$this->mprofil->getKecamatan($q);
		echo json_encode($items);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */