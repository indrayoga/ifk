<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bmhpobat extends CI_Controller {

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
		$this->load->model('apotek/mbmhpobat');
	}
	
	public function index($kode1='')
	{
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
		$data=array('databmhp'=>$this->mbmhpobat->ambilData1(),
					'detilbmhp'=>$this->mbmhpobat->getBMHP($kode1),
					'kode'=>$kode1);
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/bmhpobat/bmhpobat',$data);
		$this->load->view('footer',$datafooter);
	}
	
	
	public function periksa()
	{
		$msg=array();
		$submit=$this->input->post('submit');
		$kd_pelayanan=$this->input->post('kd_pelayanan');
		$kd_obat=$this->input->post('kd_obat');		
		$qty=$this->input->post('qty');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if(empty($kd_pelayanan)){
			$jumlaherror++;
			$msg['id'][]="kd_pelayanan";
			$msg['pesan'][]="Pelayanan BMHP belum dipilih !";
		}
		
		if(!empty($kd_obat)){
			foreach ($kd_obat as $key => $value) {
				# code...
				if(empty($value))continue;
				if(empty($qty[$key])){
					$msg['status']=0;
					$nama=$this->mbmhpobat->ambilNama($value);
					$msg['pesanlain'].="Qty ".$nama." Tidak boleh Kosong <br/>";					
				}
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
		$msg=array();
		$submit=$this->input->post('submit');
		$kd_pelayanan=$this->input->post('kd_pelayanan');
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$qty=$this->input->post('qty');
		if($submit=="simpan"){
			$this->mbmhpobat->delete('list_pelayanan_obat','kd_pelayanan="'.$kd_pelayanan.'"');
			foreach ($kd_obat as $key => $value) {
				# code...
				if(empty($value))continue;
				$data=array('kd_pelayanan'=>$kd_pelayanan,
							'kd_obat'=>$value,
							'qty'=>$qty[$key]);
				$this->mbmhpobat->insert('list_pelayanan_obat',$data);
			}
			$msg['pesan']="Data Berhasil Di Simpan";
			$msg['status']=1;
		}		
		echo json_encode($msg);
	}
	
	public function ambildaftarobatbynama() {
		/*$q=$this->input->get('query');
		$items=$this->mbmhpobat->ambilData2($q);
		echo json_encode($items);*/
		$nama_obat=$this->input->post('nama_obat');
		
		$this->datatables->select("apt_obat.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,'pilihan' as pilihan",false);
		
		$this->datatables->from("apt_obat");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3")\'>Pilih</a>','apt_obat.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil');		
		if(!empty($nama_obat))$this->datatables->like('apt_obat.nama_obat',$nama_obat,'both');
		
		$this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil');
		$results = $this->datatables->generate();
		echo ($results);		
	}
	
	public function ambildaftarobatbykode() {
		$kd_obat=$this->input->post('kd_obat');
		
		$this->datatables->select("apt_obat.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,'pilihan' as pilihan",false);
		
		$this->datatables->from("apt_obat");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3")\'>Pilih</a>','apt_obat.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil');		
		if(!empty($kd_obat))$this->datatables->like('apt_obat.kd_obat',$kd_obat,'both');
		
		$this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil');
		$results = $this->datatables->generate();
		echo ($results);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */