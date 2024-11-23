<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
class Setting extends Rumahsakit {

	protected $title='GFK KOTA BALIKPAPAN';
	protected $akses='109';
	protected $aksesakuntansi='107';

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('utilities');
		$this->load->model('msetting');
		$this->load->model('mposting');
		$this->load->model('pasien/mpasien');
		$this->load->library('pagination');
		
	}
	public function index()
	{

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

		$this->load->view('headerapotek',$dataheader);
		$data=array();
		parent::view_restricted($data);
		$this->load->view('footer');
	}
	
	public function user()
	{
		if(!$this->muser->isAkses("900")){
			//$this->restricted();
		}
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

		$data=array(
			'items'=>$this->msetting->ambilData('user')
			);
		//debugvar($data['akunkas']);

		$this->load->view('headerapotek',$dataheader);
		$this->load->view('setting/user',$data);
		$this->load->view('footer',$datafooter);

	}
	
	public function tambahuser($aplikasi="")
	{
		if(!$this->muser->isAkses("902")){
			//$this->restricted();
			//return false;
		}
		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
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
			'datapegawai'=>$this->msetting->ambilData('pegawai'),
			'dataaplikasi'=>$this->msetting->ambilData('aplikasi'),
			'app'=>$aplikasi,
			'dataakses'=>$this->msetting->ambilData('akses','aktif=1 and aplikasi="50" ')
			);

		$this->load->view('headerapotek',$dataheader);
		$this->load->view('setting/tambahuser',$data);
		$this->load->view('footer',$datafooter);

	}

	public function edituser($id_user,$aplikasi="",$unit="")
	{
		if(!$this->muser->isAkses("901")){
			//$this->restricted();
			//return false;
		}
		$aplikasi=50;
		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
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
			'dataaplikasi'=>$this->msetting->ambilData('aplikasi'),
			'item'=>$this->msetting->ambilItemData('user','id_user="'.$id_user.'" '),
			'app'=>$aplikasi,
			'id_user'=>$id_user,
			'unit'=>$unit,
			'dataakses'=>$this->msetting->ambilData('akses','aktif=1 and aplikasi="'.$aplikasi.'" and id_akses not in(select id_akses from user_akses where id_user ="'.$id_user.'") ')
			);
		if(!empty($unit)){
			$data['dataakses']=$this->msetting->ambilData('akses','aktif=1 and aplikasi="'.$aplikasi.'" and id_akses not in(select id_akses from akses_unit where id_user ="'.$id_user.'" and kd_unit_kerja="'.$unit.'") ');			
		}
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('setting/edituser',$data);
		$this->load->view('footer',$datafooter);

	}

	public function editpassword($id_user)
	{
		if(!$this->muser->isAkses("901")){
			//$this->restricted();
			//return false;
		}
		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
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
			'datapegawai'=>$this->msetting->ambilData('pegawai'),
			'item'=>$this->msetting->ambilItemData('user','id_user="'.$id_user.'" '),
			'id_user'=>$id_user
			);

		$this->load->view('headerapotek',$dataheader);
		$this->load->view('setting/editpassword',$data);
		$this->load->view('footer',$datafooter);

	}

	public function periksasapmapping(){
		$msg=array();
		$akunsap=$this->input->post('akunsap');
		$akunkas=$this->input->post('akunkas');

		$jumlaherror=0;
		$msg['status']=1;
		
		if(empty($akunsap)){
			$jumlaherror++;
			$msg['id'][]="akunsap";
			$msg['pesan'][]="Pilih Akun SAP Dulu";
		}
		


		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
		}
		
		echo json_encode($msg);
	}

	public function periksauser(){
		$msg=array();
		$nama=$this->input->post('nama');
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		$aksesuser=$this->input->post('aksesuser');

		$jumlaherror=0;
		$msg['status']=1;
		
				
		if(empty($username)){
			$jumlaherror++;
			$msg['id'][]="username";
			$msg['pesan'][]="Username  Harus di isi";
		}
			
		if(empty($password)){
			$jumlaherror++;
			$msg['id'][]="password";
			$msg['pesan'][]="Password  Harus di isi";
		}
		
		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
		}
		
		echo json_encode($msg);
	}

	public function periksauser1(){
		$msg=array();
		$jumlaherror=0;
		$msg['status']=1;
	
	
		
		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
		}
	
		echo json_encode($msg);
	}
	
	public function periksauserpassword(){
		$msg=array();
		$username=$this->input->post('username');
		$password=$this->input->post('password');

		$jumlaherror=0;
		$msg['status']=1;
		
		if(empty($username)){
			$jumlaherror++;
			$msg['id'][]="username";
			$msg['pesan'][]="Username Harus di isi";
		}
		
		if(empty($password)){
			$jumlaherror++;
			$msg['id'][]="password";
			$msg['pesan'][]="Password Harus di isi";
		}
		


		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
		}
		
		echo json_encode($msg);
	}

	public function simpanuser()
	{
		$msg=array();
		$kd_aplikasi='50';
		$nama=$this->input->post('nama');
		$pegawai_id=$this->input->post('pegawai_id');
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		$aksesuser=$this->input->post('aksesuser');
		//debugvar($akunkas);
		$datauser=array('pegawai_id'=>$pegawai_id,
							'username'=>$username,
							'password'=>md5($password));
		$id_user=$this->msetting->insert('user',$datauser);
		//debugvar($akunkas);
		$this->db->trans_start();
		$this->db->query("replace into user_aplikasi(id_user,kd_aplikasi) values('".$id_user."','".$kd_aplikasi."') ");
		$this->msetting->delete('user_akses','id_user="'.$id_user.'"');
		foreach ($aksesuser as $akses) {
			# code...
			$datatarifunit=array('id_user'=>$id_user,
								'id_akses'=>$akses);
			$this->msetting->insert('user_akses',$datatarifunit);
		}
		$this->db->trans_complete();
		$msg['status']=1;
		$msg['pesan']="Data Berhasil Di Simpan";

		echo json_encode($msg);
	}

	public function updateuser()
	{
		$msg=array();
		$kd_aplikasi=50;
		$aksesuser=$this->input->post('aksesuser');
		$id_user=$this->input->post('id_user');
		$this->db->trans_start();
		$this->db->query("replace into user_aplikasi(id_user,kd_aplikasi) values('".$id_user."','".$kd_aplikasi."') ");
		if(!empty($aksesuser)){
			$this->msetting->delete('user_akses','id_user="'.$id_user.'" and id_akses in(select id_akses from akses where aplikasi="'.$kd_aplikasi.'")');
			foreach ($aksesuser as $akses) {
				# code...
				$datatarifunit=array('id_user'=>$id_user,
									'id_akses'=>$akses);
				$this->msetting->insert('user_akses',$datatarifunit);
			}			
		}

		$this->db->trans_complete();
		$msg['status']=1;
		$msg['pesan']="Data Berhasil Di Simpan";

		echo json_encode($msg);
	}

	public function updateuserpassword()
	{
		$msg=array();
		$id_pegawai=$this->input->post('id_pegawai');
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		$id_user=$this->input->post('id_user');
		//debugvar($akunkas);
		$datauser=array('pegawai_id'=>$id_pegawai,
							'username'=>$username,
							'password'=>md5($password));
		$this->msetting->update('user',$datauser,'id_user="'.$id_user.'" ');
		//debugvar($akunkas);

		$msg['status']=1;
		$msg['pesan']="Data Berhasil Di Simpan";

		echo json_encode($msg);
	}


	public function hapususer($id=""){
		if(!empty($id)){
			$this->msetting->delete('user','id_user="'.$id.'"');
			$this->msetting->delete('user_akses','id_user="'.$id.'"');
			redirect('/setting/user');
		}
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
