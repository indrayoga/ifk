<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stokopname extends CI_Controller {

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
		$this->load->model('logistik/mstokopname');
	}
	
	public function index()
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
							'main.js','style-switcher.js');
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
		$this->load->view('',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function stokopnamebarang(){
		$nama_barang='';
		$kd_barang='';
		$kd_lokasi=$this->session->userdata('kd_lokasi');
		$kd_kategori='';
		$submit=$this->input->post('submit');
		$submit1=$this->input->post('submit1');
		//debugvar($submit);
		if($this->input->post('nama_barang')!=''){
			$nama_barang=$this->input->post('nama_barang');
		}
		if($this->input->post('kd_barang')!=''){
			$kd_barang=$this->input->post('kd_barang');
		}
		if($this->input->post('kd_kategori')!=''){
			$kd_kategori=$this->input->post('kd_kategori');
		}
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
		
		$data=array('items'=>array(),
					'kategoribarang'=>$this->mstokopname->ambilData('log_kategori_barang'),
					'nama_barang'=>$nama_barang,
					'kd_barang'=>$kd_barang,
					'kd_lokasi'=>$kd_lokasi,
					'kd_kategori'=>$kd_kategori
					);
		if($submit==1) $data['items']=$this->mstokopname->getStokopname($kd_barang,$kd_lokasi,$kd_kategori);
		if($submit1=="excel") {
			$this->load->helper('file');
			$this->load->dbutil();
			if($kd_barang!="") { $a1=" and log_stok_barang.kd_barang='$kd_barang'";}
			else {$a1="";}
			$a = $a1;
			
			if($kd_kategori!="") {$b1=" and log_kategori_barang.kd_kategori='$kd_kategori'";}
			else {$b1="";}
			$b = $b1;
			
			/*$query = $this->db->query("select concat('/',log_stok_barang.kd_barang) as kd_barang,log_master_barang.nama_barang,log_satuan.satuan,
									log_stok_barang.jml_stok from log_stok_barang,log_master_barang,log_lokasi,log_satuan where
									log_stok_barang.kd_barang=log_master_barang.kd_barang and log_stok_barang.kd_lokasi=log_lokasi.kd_lokasi and
									log_master_barang.kd_satuan=log_satuan.kd_satuan $a and log_stok_barang.kd_lokasi='$kd_lokasi' order by log_stok_barang.kd_barang");*/
			$query = $this->db->query("select log_stok_barang.kd_barang,log_master_barang.nama_barang,log_satuan.satuan,log_kategori_barang.kategori,
										log_stok_barang.jml_stok from log_stok_barang,log_master_barang,log_lokasi,log_satuan,log_kategori_barang where
										log_stok_barang.kd_barang=log_master_barang.kd_barang and log_stok_barang.kd_lokasi=log_lokasi.kd_lokasi and
										log_master_barang.kd_satuan=log_satuan.kd_satuan $a and log_stok_barang.kd_lokasi='$kd_lokasi' 
										and log_master_barang.kd_kategori=log_kategori_barang.kd_kategori $b
										order by log_stok_barang.kd_barang");
			$delimiter = ",";
			$newline = "\r\n";

			$x= $this->dbutil->csv_from_result($query, $delimiter, $newline); 
			//$data = 'Some file data';

			if ( write_file('./uploads/stokopnamebarang.csv', $x)) {
				// Load the download helper and send the file to your desktop
				$this->load->helper('download');
				force_download('./uploads/stokopnamebarang.csv', $x); 
			}
		} 
		//debugvar($data);
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/transaksi/stokopname/stokopnamebarang',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function simpanstokopname(){	
		$msg=array();
		$submit=$this->input->post('submit');
		$kd_barang=$this->input->post('kd_obat');
		$nama_barang=$this->input->post('nama_barang');
		$kd_lokasi=$this->session->userdata('kd_lokasi');
		//$kd_lokasi=$this->input->post('kd_lokasi');
		
		$kd_barang2=$this->input->post('kd_barang2');
		$nama_barang2=$this->input->post('nama_barang2');
		$stoklama=$this->input->post('stoklama');
		$stokbaru=$this->input->post('stokbaru');
		$alasan=$this->input->post('alasan');
		$kd_lokasi1=$this->input->post('kd_lokasi1');
		$tanggal=$this->input->post('tanggal');
		$kd_user=0;
		$msg['status']=1;
		
		if($submit=="simpanstokopname"){
			$kode=$this->mstokopname->nomor();
			$nomor=$kode+1;
			$msg['nomor']=$nomor;
			//debugvar($nomor);
			$selisih=$stokbaru-$stoklama;
			
			$datasimpan=array('nomor'=>$nomor,'tanggal'=>$tanggal,'kd_lokasi'=>$kd_lokasi1,
						'kd_barang'=>$kd_barang2,'qty'=>$selisih,'alasan'=>$alasan,'kd_user'=>$kd_user);
			$this->mstokopname->insert('log_stokopname',$datasimpan);
			
			$datastok=array('jml_stok'=>$stokbaru);
			$this->mstokopname->update('log_stok_barang',$datastok,'kd_lokasi="'.$kd_lokasi1.'" and kd_barang="'.$kd_barang2.'"');
			
			$msg['pesan']="Stokopname berhasil disimpan";
		}
		echo json_encode($msg);
	}
	
	public function periksastokopname() {
		$msg=array();
		$submit=$this->input->post('submit');
		$kd_barang=$this->input->post('kd_obat');
		$nama_barang=$this->input->post('nama_barang');
		//$kd_lokasi=$this->input->post('kd_lokasi');
		
		$kd_barang2=$this->input->post('kd_barang2');
		$nama_barang2=$this->input->post('nama_barang2');
		$stoklama=$this->input->post('stoklama');
		$stokbaru=$this->input->post('stokbaru');
		$alasan=$this->input->post('alasan');
		$kd_lokasi1=$this->input->post('kd_lokasi1');
		$tanggal=$this->input->post('tanggal');
		$kd_user=0;
		$kd_lokasi=$this->session->userdata('kd_lokasi');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="hapus"){
		}
		else{
			if(empty($stokbaru)){
				$jumlaherror++;
				$msg['id'][]="qty";
				$msg['pesan'][]="Kolom stok baru harus di isi";
			}
			if($jumlaherror>0){
				$msg['status']=0;
				$msg['error']=$jumlaherror;
				$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
			}
		}
		echo json_encode($msg);
	}
	
	public function ambilbarangbynama(){
		$q=$this->input->get('query');
		$items=$this->mstokopname->ambilData4($q);
		echo json_encode($items);
	}
	
	public function ambilitems() {
		$q=$this->input->get('query');
		$lokasi=$this->input->get('lokasi');
		$items=$this->mstokopname->ambilData2($q,$lokasi);
		//debugvar($items);
		echo json_encode($items);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */