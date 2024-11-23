<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai extends CI_Controller {

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
	protected $akses='109';

	public function __construct()
	{
		parent::__construct();

		$this->load->model('master/mpegawai');

	}
	public function index()
	{
		$propinsi=$this->input->post('propinsi');
		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js',
							'vendor/jquery-1.9.1.min.js',
							'vendor/jquery-migrate-1.1.1.min.js',
							'vendor/jquery-ui-1.10.0.custom.min.js',
							'vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js',
							'lib/bootstrap-datepicker.js',
							'lib/bootstrap-inputmask.js',
							'lib/jquery.dataTables.min.js',
							'lib/DT_bootstrap.js',
							'lib/responsive-tables.js',
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
			'datajenispegawai'=>$this->mpegawai->ambilData('jenis_pegawai')
			
		);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('master/pegawai',$data);
		$this->load->view('footer',$datafooter);
	}


	public function ajaxdatapegawai()
	{
		$this->datatables->select('@rownum:=@rownum+1 as rownum,nama_pegawai,jk,alamat,no_telepon,tempat_lahir,tanggal_lahir,b.jenis_pegawai,nip_pegawai,id_pegawai',false);
		$this->datatables->edit_column('nama_pegawai', '<input type="hidden" value="$1" class="idpegawai" />$2', 'id_pegawai,nama_pegawai');
		$this->datatables->from("(SELECT @rownum:=0) r,pegawai a");
		$this->datatables->join('jenis_pegawai b','a.jenis_pegawai=b.id_jenis_pegawai');
		//$this->db->order_by('a.tgl_pendaftaran','desc');

		//$data['result'] = $this->datatables->generate();
		$results = $this->datatables->generate();
		//$data['aaData'] = $results['aaData']->;
		echo ($results);
	}
	
	public function ambildatapegawai($id=""){
		$item=$this->mpegawai->ambilItemData('pegawai','id_pegawai="'.$id.'"');
		if(empty($item)){
			return false;
		}
		$item['tanggal_lahir']=convertDate($item['tanggal_lahir']);
		echo json_encode($item);
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

		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}

		echo json_encode($msg);

	}

	public function simpan(){
		$id_pegawai=$this->input->post('id_pegawai');
		$nama_pegawai=$this->input->post('nama_pegawai');
		$jk=$this->input->post('jk');
		$alamat=$this->input->post('alamat');
		$no_telepon=$this->input->post('no_telepon');
		$tempat_lahir=$this->input->post('tempat_lahir');
		$tanggal_lahir=$this->input->post('tanggal_lahir');
		$jenis_pegawai=$this->input->post('jenis_pegawai');
		$nip_pegawai=$this->input->post('nip_pegawai');

		if(!empty($id_pegawai)){
			$data=array(
				'nama_pegawai'=>$nama_pegawai,
				'jk'=>$jk,
				'alamat'=>$alamat,
				'no_telepon'=>$no_telepon,
				'tempat_lahir'=>$tempat_lahir,
				'nip_pegawai'=>$nip_pegawai,
				'tanggal_lahir'=>convertDate($tanggal_lahir),
				'jenis_pegawai'=>$jenis_pegawai
			);			
			$this->mpegawai->update('pegawai',$data,'id_pegawai="'.$id_pegawai.'"');		
		}else{
			$data=array(
				'nama_pegawai'=>$nama_pegawai,
				'jk'=>$jk,
				'alamat'=>$alamat,
				'no_telepon'=>$no_telepon,
				'tempat_lahir'=>$tempat_lahir,
				'nip_pegawai'=>$nip_pegawai,
				'tanggal_lahir'=>convertDate($tanggal_lahir),
				'jenis_pegawai'=>$jenis_pegawai
			);			
			$this->mpegawai->insert('pegawai',$data);		
		}
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function hapus($id=""){
		if(!empty($id)){
			$this->mpegawai->delete('pegawai','id_pegawai="'.$id.'"');
			$msg['status']=1;
			echo json_encode($msg);
		}
	}




	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */