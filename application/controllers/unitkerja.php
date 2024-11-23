<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unitkerja extends CI_Controller {

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

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('utilities');
		$this->load->library('pagination');
		$this->load->model('munitkerja');
	}
	
	public function index()	{
		$cari=$this->input->post('cari');
		$nama_unit_kerja=$this->input->post('nama_unit_kerja');
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
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		//$data=array();		
		$data=array('items'=>$this->munitkerja->ambilDataUnitKerja($nama_unit_kerja));
		//debugvar($data);
		$this->load->view('header',$dataheader);
		$this->load->view('unitkerja',$data);
		$this->load->view('footer',$datafooter);
	}
		
	public function tambahunitkerja(){		
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
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		$data=array();
		$this->load->view('header',$dataheader);
		$this->load->view('tambahunitkerja',$data);
		$this->load->view('footer',$datafooter);		
	}
	
	public function ubahunitkerja($kd_unit_kerja=""){		
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
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		$items=$this->munitkerja->ambilItemData('unit_kerja','kd_unit_kerja="'.$kd_unit_kerja.'"');
		$data=array('kd_unit_kerja'=>$kd_unit_kerja,'nama_unit_kerja'=>$items['nama_unit_kerja'],'parent'=>$items['parent'],'aktif'=>$items['aktif']);
		$this->load->view('header',$dataheader);
		$this->load->view('ubahunitkerja',$data);
		$this->load->view('footer',$datafooter);		
	}
	
	public function simpanunitkerja(){	
		$submit=$this->input->post('submit');
		$reset=$this->input->post('reset');
		$kd_unit_kerja=$this->input->post('kd_unit_kerja');
		$nama_unit_kerja=$this->input->post('nama_unit_kerja');
		$parent=$this->input->post('parent');
		$aktif=$this->input->post('aktif');		
		$baris=$this->munitkerja->countUnit($kd_unit_kerja);
		//debugvar($aktif); ni sama aja kalo kyk di java tu System.out.print();
		
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
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);

		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		
		$data=array('kd_unit_kerja'=>$kd_unit_kerja,'nama_unit_kerja'=>$nama_unit_kerja,'parent'=>$parent,'aktif'=>$aktif); 
		
		if($submit=="submit1"){
			if(trim($kd_unit_kerja) == ''){			
				$data1=array('kd_unit_kerja'=>$kd_unit_kerja,'nama_unit_kerja'=>$nama_unit_kerja,'parent'=>$parent,'aktif'=>$aktif);				
				echo"<script>alert('Kode unit kerja harus diisi !')</script>";				
				$this->load->view('header',$dataheader);
				$this->load->view('tambahunitkerja',$data1);
				$this->load->view('footer',$datafooter);
			}
			else if(trim($nama_unit_kerja) == ''){
				$data2=array('kd_unit_kerja'=>$kd_unit_kerja,'nama_unit_kerja'=>$nama_unit_kerja,'parent'=>$parent,'aktif'=>$aktif);
				echo"<script>alert('Nama unit kerja harus diisi !')</script>";
				$this->load->view('header',$dataheader);
				$this->load->view('tambahunitkerja',$data2);
				$this->load->view('footer',$datafooter);
			}
			else {
				if($baris=='1'){
					$dataa=array('kd_unit_kerja'=>$kd_unit_kerja,'nama_unit_kerja'=>$nama_unit_kerja,'parent'=>$parent,'aktif'=>$aktif);
					echo"<script>alert('Unit Kerja dengan kode $kd_unit_kerja sudah ada!')</script>";
					$this->load->view('header',$dataheader);
					$this->load->view('tambahunitkerja',$dataa);
					$this->load->view('footer',$datafooter);
				}
				else if($baris=='0'){
					$this->munitkerja->insert('unit_kerja',$data);
					//echo"<script>alert('Data berhasil di simpan.');window.location='unitkerja'</script>";
					redirect('/unitkerja/');
				}
			}
		}
		if($submit=="submit"){
			if(trim($kd_unit_kerja) == ''){			
				$data1=array('kd_unit_kerja'=>$kd_unit_kerja,'nama_unit_kerja'=>$nama_unit_kerja,'parent'=>$parent,'aktif'=>$aktif);				
				echo"<script>alert('Kode unit kerja harus diisi !')</script>";				
				$this->load->view('header',$dataheader);
				$this->load->view('tambahunitkerja',$data1);
				$this->load->view('footer',$datafooter);
			}
			else if(trim($nama_unit_kerja) == ''){
				$data2=array('kd_unit_kerja'=>$kd_unit_kerja,'nama_unit_kerja'=>$nama_unit_kerja,'parent'=>$parent,'aktif'=>$aktif);
				echo"<script>alert('Nama unit kerja harus diisi !')</script>";
				$this->load->view('header',$dataheader);
				$this->load->view('tambahunitkerja',$data2);
				$this->load->view('footer',$datafooter);
			}
			else {
				if($baris=='1'){
					$dataa=array('kd_unit_kerja'=>$kd_unit_kerja,'nama_unit_kerja'=>$nama_unit_kerja,'parent'=>$parent,'aktif'=>$aktif);
					echo"<script>alert('Unit Kerja dengan kode $kd_unit_kerja sudah ada!')</script>";
					$this->load->view('header',$dataheader);
					$this->load->view('tambahunitkerja',$dataa);
					$this->load->view('footer',$datafooter);
				}
				else if($baris=='0'){
					$this->munitkerja->insert('unit_kerja',$data);
					redirect('/unitkerja/tambahunitkerja/');
				}
			}
		}
	}
	
	public function hapusunitkerja($id){
		$nama_unit_kerja=$this->input->post('nama_unit_kerja');
		
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
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		
		$baris=$this->munitkerja->countId($id);
		//debugvar($baris);
		if($baris==0){
			$this->db->delete('unit_kerja', array('kd_unit_kerja' => $id));
			redirect('/unitkerja/');			
			//echo"<script>alert('Data berhasil di hapus.');window.location='unitkerja'</script>";
		}
		else {
			echo"<script>alert('Data tidak bisa dihapus !')</script>";
			//redirect('/unitkerja/');
			$data=array('items'=>$this->munitkerja->ambilDataUnitKerja($nama_unit_kerja));
			$this->load->view('header',$dataheader);
			$this->load->view('unitkerja',$data);
			$this->load->view('footer',$datafooter);
		}
	}
	
	public function editunitkerja(){
		$submit=$this->input->post('submit');
		$id=$this->input->post('id');
		$kd_unit_kerja=$this->input->post('kd_unit_kerja');
		$nama_unit_kerja=$this->input->post('nama_unit_kerja');
		$parent=$this->input->post('parent');
		$aktif=$this->input->post('aktif');
		
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
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);		
		
		$data=array('kd_unit_kerja'=>$kd_unit_kerja,'nama_unit_kerja'=>$nama_unit_kerja,'parent'=>$parent,'aktif'=>$aktif);
		
		if($submit=="submit"){
			if(trim($kd_unit_kerja) == ''){
				$data2=array('kd_unit_kerja'=>$kd_unit_kerja,'nama_unit_kerja'=>$nama_unit_kerja,'parent'=>$parent,'aktif'=>$aktif);
				echo"<script>alert('Kode unit kerja harus diisi !')</script>";
				$this->load->view('header',$dataheader);
				$this->load->view('ubahunitkerja',$data2);
				$this->load->view('footer',$datafooter);
			}
			else if(trim($nama_unit_kerja) == ''){				
				$data3=array('kd_unit_kerja'=>$kd_unit_kerja,'nama_unit_kerja'=>$nama_unit_kerja,'parent'=>$parent,'aktif'=>$aktif);
				echo"<script>alert('Nama unit kerja harus diisi !')</script>";
				$this->load->view('header',$dataheader);
				$this->load->view('ubahunitkerja',$data3);
				$this->load->view('footer',$datafooter);
			}
			else{
				$this->munitkerja->update('unit_kerja',$data,'kd_unit_kerja="'.$id.'"');
				//echo"<script>alert('Data berhasil di edit.');window.location='unitkerja'</script>";
				redirect('/unitkerja/');
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */