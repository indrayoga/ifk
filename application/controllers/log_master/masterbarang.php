<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Masterbarang extends CI_Controller {

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
		$nama_barang=$this->input->post('nama_barang');
		$kd_kategori=$this->input->post('kd_kategori');
		
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
			'datakategori'=>$this->mlogistik->ambilData('log_kategori_barang'),
			'datasatuan'=>$this->mlogistik->ambilData('log_satuan'),
			'datamerk'=>$this->mlogistik->ambilData('log_merk'),
			'items'=>$this->mlogistik->ambilBarang($nama_barang,$kd_kategori)
			
		);
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/master/barang/masterbarang',$data);
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
			'datakategori'=>$this->mlogistik->ambilData('log_kategori_barang'),
			'datasatuan'=>$this->mlogistik->ambilData('log_satuan'),
			'datamerk'=>$this->mlogistik->ambilData('log_merk')
		);

		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/master/barang/tambahbarang',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksa()
	{
		$msg=array();
		$mode=$this->input->post('mode');
		$submit=$this->input->post('submit');
		$kd_barang=$this->input->post('kd_barang');
		//$no_inventaris=$this->input->post('no_inventaris');
		$nama_barang=$this->input->post('nama_barang');
		$kd_kategori=$this->input->post('kd_kategori');
		$kd_satuan=$this->input->post('kd_satuan');
		$kd_merk=$this->input->post('kd_merk');
		//$is_aktif=$this->input->post('is_aktif');
		$harga_beli=$this->input->post('harga_beli');
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if(empty($kd_barang)){
			$jumlaherror++;
			$msg['id'][]="kd_barang";
			$msg['pesan'][]="Kd. Barang Harus di Isi";
		}
		if($mode!="edit"){
			if($this->mlogistik->isExist('log_master_barang','kd_barang',$kd_barang)){
				$jumlaherror++;
				$msg['id'][]="kd_barang";
				$msg['pesan'][]="Kd. Barang sudah ada";
			}			
		}
		if(empty($nama_barang)){
			$jumlaherror++;
			$msg['id'][]="nama_barang";
			$msg['pesan'][]="Kolom Nama Barang Harus di Isi";
		}		
		if(empty($kd_kategori)){
			$jumlaherror++;
			$msg['id'][]="kd_kategori";
			$msg['pesan'][]="Kategori Barang Belum di Pilih";
		}
		if(empty($kd_satuan)){
			$jumlaherror++;
			$msg['id'][]="kd_satuan";
			$msg['pesan'][]="Satuan Barang Belum di Pilih";
		}
		if(empty($kd_merk)){
			$jumlaherror++;
			$msg['id'][]="kd_merk";
			$msg['pesan'][]="Merk Barang Belum di Pilih";
		}
		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}
		echo json_encode($msg);
	}

	public function simpan(){
		$kd_barang=$this->input->post('kd_barang');
		$no_inventaris=$this->input->post('no_inventaris');
		$nama_barang=$this->input->post('nama_barang');
		$kd_kategori=$this->input->post('kd_kategori');
		$kd_satuan=$this->input->post('kd_satuan');
		$kd_merk=$this->input->post('kd_merk');
		$is_aktif=$this->input->post('is_aktif');
		$harga_beli=$this->input->post('harga_beli');
		
		$data=array(
			'kd_barang'=>$kd_barang,
			'no_inventaris'=>$no_inventaris,
			'nama_barang'=>$nama_barang,
			'kd_kategori'=>$kd_kategori,
			'kd_satuan'=>$kd_satuan,
			'kd_merk'=>$kd_merk,
			'is_aktif'=>$is_aktif,
			'harga_beli'=>$harga_beli
		);
		$this->mlogistik->insert('log_master_barang',$data);
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function update(){
		$kd_barang=$this->input->post('kd_barang');
		$no_inventaris=$this->input->post('no_inventaris');
		$nama_barang=$this->input->post('nama_barang');
		$kd_kategori=$this->input->post('kd_kategori');
		$kd_satuan=$this->input->post('kd_satuan');
		$kd_merk=$this->input->post('kd_merk');
		$is_aktif=$this->input->post('is_aktif');
		$harga_beli=$this->input->post('harga_beli');
		
		$data=array(
			'no_inventaris'=>$no_inventaris,
			'nama_barang'=>$nama_barang,
			'kd_kategori'=>$kd_kategori,
			'kd_satuan'=>$kd_satuan,
			'kd_merk'=>$kd_merk,
			'is_aktif'=>$is_aktif,
			'harga_beli'=>$harga_beli
		);
		$this->mlogistik->update('log_master_barang',$data,'kd_barang="'.$kd_barang.'"');
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
			'datakategori'=>$this->mlogistik->ambilData('log_kategori_barang'),
			'datasatuan'=>$this->mlogistik->ambilData('log_satuan'),
			'datamerk'=>$this->mlogistik->ambilData('log_merk'),
			'item'=>$this->mlogistik->ambilItemData('log_master_barang','kd_barang="'.urldecode($id).'"')
		);
		//debugvar($data);
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/master/barang/editbarang',$data);
		$this->load->view('footer',$datafooter);

	}
	public function hapus($id=""){
		if(!empty($id)){
			$this->mlogistik->delete('log_master_barang','kd_barang="'.$id.'"');
			redirect('/log_master/masterbarang');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */