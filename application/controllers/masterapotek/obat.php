<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Obat extends CI_Controller {
class Obat extends Rumahsakit {

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

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('utilities');
		$this->load->library('pagination');
		$this->load->model('apotek/mobat');
	}
	
	public function restricted(){
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

		//$this->load->view('master/header',$dataheader);
		$this->load->view('headerapotek',$dataheader);
		$data=array();
		parent::view_restricted($data);
		$this->load->view('footer');
	}
	
	public function index($nama_obat="NULL",$kd_satuan_kecil="NULL")
	{
		//if(!$this->muser->isAkses("1")){
			//$this->restricted();
			//return false;
		//}
		if($this->input->post('nama_obat')!='')$nama_obat=$this->input->post('nama_obat');
		if($this->input->post('kd_satuan_kecil')!='')$kd_satuan_kecil=$this->input->post('kd_satuan_kecil');
		
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
		$data=array('nama_obat'=>$nama_obat,
					'kd_satuan_kecil'=>$kd_satuan_kecil,
					'satuanobat'=>$this->mobat->ambilData('apt_satuan_kecil'),
					//'items'=>$this->mobat->ambilDataObat($nama_obat,$kd_satuan_kecil)
					);
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/obat/obat',$data);
		$this->load->view('footer',$datafooter);
	}

	public function dataobat($nama_obat="NULL",$satuan_kecil="NULL")
	{

		$this->datatables->select('a.kd_obat,a.kd_produk,
								a.nama_obat,
								b.satuan_kecil,
								REPLACE(REPLACE(REPLACE(FORMAT(harga_beli, 0), ".", "@"), ",", "."), "@", ","),
								REPLACE(REPLACE(REPLACE(FORMAT(harga_dasar, 0), ".", "@"), ",", "."), "@", ","),
								REPLACE(REPLACE(REPLACE(FORMAT(harga_apbd, 0), ".", "@"), ",", "."), "@", ","),
								REPLACE(REPLACE(REPLACE(FORMAT(harga_p3k, 0), ".", "@"), ",", "."), "@", ","),
								REPLACE(REPLACE(REPLACE(FORMAT(harga_buffer, 0), ".", "@"), ",", "."), "@", ","),
								REPLACE(REPLACE(REPLACE(FORMAT(harga_program, 0), ".", "@"), ",", "."), "@", ","),
								REPLACE(REPLACE(REPLACE(FORMAT(harga_dak, 0), ".", "@"), ",", "."), "@", ","),
								isi_kemasan,a.satuan_kecil as satuan,
								if(is_aktif=1,"Aktif","Tidak Aktif") as status,
									"" as pilihan,"" as bar,"" as indikator,
									a.is_aktif
								',false);
		$this->datatables->from("apt_obat a");
		$this->datatables->edit_column('pilihan', '<a class="btn btn-info" href="'.base_url().'index.php/masterapotek/obat/aktivasi/$1/$2">Aktifkan/Tidak Aktifkan</a> <a class="btn btn-info" href="'.base_url().'index.php/masterapotek/obat/edit/$1">Edit</a> <a class="btn btn-danger" href="#" onClick="xar_confirm(\''.base_url().'index.php/masterapotek/obat/hapus/$1\',\'Apakah Anda ingin menghapus data ini?\')">Hapus</a> ', 'a.kd_obat, a.is_aktif');		
		$this->datatables->edit_column('bar', '<a class="btn btn-info" href="'.base_url().'third-party/fpdf/barcodeobat.php?kd_produk=$1" target="_newtab">Cetak Barcode</a> ', 'a.kd_obat');		
		$this->datatables->edit_column('indikator', '<a class="btn btn-info" href="'.base_url().'index.php/masterapotek/obat/indikator/$1/$2">Masukkan ke dalam Indikator Obat</a> ', 'a.kd_obat, a.is_aktif');		
		$this->datatables->join('apt_satuan_kecil b','a.kd_satuan_kecil=b.kd_satuan_kecil','left');
		if(!empty($nama_obat) && $nama_obat !='NULL')$this->datatables->like('a.nama_obat',$nama_obat,'both');
		if(!empty($satuan_kecil) && $satuan_kecil !='NULL')$this->datatables->where('kd_satuan_kecil',$satuan_kecil);

		//$data['result'] = $this->datatables->generate();
		$results = $this->datatables->generate();
		//$data['aaData'] = $results['aaData']->;
		$x=json_decode($results);
		$b=$x->aaData;
		echo ($results);
	}
	
	public function aktivasi($kd_obat,$status){
		if($status==1){
			$data=array('is_aktif'=>0);
		}else{
			$data=array('is_aktif'=>1);
		}
		$this->mobat->update('apt_obat',$data,'kd_obat="'.$kd_obat.'" ');
		redirect('/masterapotek/obat/');
	}

	public function indikator($kd_obat,$status){
		if($status==0){
			die('gagal, obat dalam status tidak aktif');
		}
		if($this->db->get_where('apt_indikator_obat',array('kd_obat'=>$kd_obat))->num_rows()){
			die('gagal, obat sudah ada di daftar indikator obat');
		}
		$data = array('kd_obat'=>$kd_obat);
		$this->db->insert('apt_indikator_obat',$data);
		redirect('/masterapotek/obat/');
	}

	public function tambah()
	{
		if(!$this->muser->isAkses("2")){
			$this->restricted();
			return false;
		}
		
		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','timepicker.css','theme.css');
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

		$data=array('databesar'=>$this->mobat->ambilData('apt_satuan_besar'),
					'datakecil'=>$this->mobat->ambilData('apt_satuan_kecil'),
					'datajenis'=>$this->mobat->ambilData('apt_jenis_obat'),
					'datasub'=>$this->mobat->ambilData('apt_sub_golongan'),
					'datagolongan'=>$this->mobat->ambilData('apt_golongan'),
					'datatherapi'=>$this->mobat->ambilData('obat_therapi'),
					'datapabrik'=>$this->mobat->ambilData('apt_pabrik'));
					
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/obat/tambahobat',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksa()
	{
		$msg=array();
		$mode=$this->input->post('mode');
		$submit=$this->input->post('submit');
		$kd_obat=$this->input->post('kd_obat');
		$kd_produk=$this->input->post('kd_produk');
		$kd_satuan_kecil=$this->input->post('kd_satuan_kecil');
		$kd_golongan=$this->input->post('kd_golongan');
		$nama_obat=$this->input->post('nama_obat');
	//	$ket_obat=$this->input->post('ket_obat');
	//	$generic=$this->input->post('generic');
	//	$is_aktif=$this->input->post('is_aktif');
		//$jml_stok=$this->input->post('jml_stok');
		//$min_stok=$this->input->post('min_stok');
		//$kd_pabrik=$this->input->post('kd_pabrik');
		//$max_stok=$this->input->post('max_stok');
		///$harga_beli=$this->input->post('harga_beli');
		//$no_batch=$this->input->post('no_batch');
		//$tgl=$this->input->post('tgl');
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if($mode!="edit"){
			if($this->mobat->isExist('apt_obat','kd_obat',$kd_obat)){
				$jumlaherror++;
				$msg['id'][]="kd_obat";
				$msg['pesan'][]="Kd. Obat sudah ada";
			}			
		}
		/*if(empty($kd_obat)){
			$jumlaherror++;
			$msg['id'][]="kd_obat";
			$msg['pesan'][]="Kode obat Harus di Isi";
		}*/
		if(empty($kd_satuan_kecil)){
			$jumlaherror++;
			$msg['id'][]="kd_satuan_kecil";
			$msg['pesan'][]="Satuan harus di pilih";
		}
		if(empty($kd_golongan)){
			$jumlaherror++;
			$msg['id'][]="kd_golongan";
			$msg['pesan'][]="Golongan harus di pilih";
		}
		if(empty($nama_obat)){
			$jumlaherror++;
			$msg['id'][]="nama_obat";
			$msg['pesan'][]="Nama Obat Harus di Isi";
		}
		/*if(empty($pembanding)){
			$jumlaherror++;
			$msg['id'][]="pembanding";
			$msg['pesan'][]="Pembanding obat harus di isi";
		}*/			
		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}
		
		echo json_encode($msg);
	}

	public function simpan(){
		$kd_obat=$this->input->post('kd_obat');
		$kd_produk=$this->input->post('kd_produk');
		$kd_satuan_kecil=$this->input->post('kd_satuan_kecil');
		$kd_golongan=$this->input->post('kd_golongan');
		$kd_nomenklatur=$this->input->post('kd_nomenklatur');
		if($this->input->post('kd_sub') == null)
			$kd_sub=null;
		else 
		$kd_sub=$this->input->post('kd_sub');
		$nama_obat=$this->input->post('nama_obat');
		$is_aktif=$this->input->post('is_aktif');
		$jml_stok=$this->input->post('jml_stok');
		$min_stok=$this->input->post('min_stok');
		$max_stok=$this->input->post('max_stok');
		$harga_beli=$this->input->post('harga_beli');
		$harga_jual=$this->input->post('harga_jual');
		$harga_apbd=$this->input->post('harga_apbd');
		$harga_p3k=$this->input->post('harga_p3k');
		$harga_buffer=$this->input->post('harga_buffer');
		$harga_program=$this->input->post('harga_program');
		$harga_dak=$this->input->post('harga_dak');
		$harga_jpkmm=$this->input->post('harga_jpkmm');
		$kd_pabrik=$this->input->post('kd_pabrik');
 		$kd_therapi=$this->input->post('kd_therapi');
 		$fornas=$this->input->post('fornas');
 		
		$kd_barcode=$this->input->post('kd_barcode');
		$deskripsi=$this->input->post('deskripsi');
		$fractions=$this->input->post('fractions');
		$kd_satuan_barcode=$this->input->post('kd_satuan_barcode');
		$isi_kemasan=$this->input->post('isi_kemasan');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$tanggal=$this->mobat->muncultanggal(); 
		$thn=substr($tanggal,0,4); $bln=substr($tanggal,5,2); $tgl1=substr($tanggal,8,2);
		$tgl11=($thn+5).'-'.$bln.'-'.$tgl1;
		
		
		
		$msg['kd_obat']=$kd_obat;
		
		$tambahobat=array('kd_obat'=>$kd_obat,
						  'kd_produk'=>$kd_produk,
						  'kd_satuan_besar'=>$kd_satuan_kecil,
						  'kd_satuan_kecil'=>$kd_satuan_kecil,
						  'kd_jenis_obat'=>'139',
						  'kd_sub_jenis'=>'22',
						  'kd_golongan'=>$kd_golongan,
						  'kd_nomenklatur'=>$kd_nomenklatur,
						  'nama_obat'=>$nama_obat,
						  'is_aktif'=>$is_aktif,
						  'pembanding'=>1,
						  'harga_beli'=>$harga_beli,
						  'harga_dasar'=>$harga_jual,
						  'harga_apbd'=>$harga_apbd,
						  'harga_p3k'=>$harga_p3k,
						  'harga_buffer'=>$harga_buffer,
						  'harga_program'=>$harga_program,
						  'harga_dak'=>$harga_dak,
						  'harga_jpkmm'=>$harga_jpkmm,
						  'kd_pabrik'=>$kd_pabrik,
						  'kd_therapi'=>$kd_therapi,
						  'isi_kemasan'=>$isi_kemasan,
						  'satuan_kecil'=>$satuan_kecil,
						  'fornas'=>$fornas,
						  'kd_sub'=>$kd_sub);
		$this->mobat->insert('apt_obat',$tambahobat);
		


		$query= $this->db->get('apt_unit');
		$items=$query->result_array();
		foreach($items as $item){
			$settingobat=array('kd_obat'=>$kd_obat,
					'kd_unit_apt'=>$item['kd_unit_apt'],
					'min_stok'=>$min_stok,
					'max_stok'=>$max_stok);
			$this->mobat->insert('apt_setting_obat',$settingobat);
			$settingstokawal=array('kd_obat'=>$kd_obat,
					'kd_unit_apt'=>$item['kd_unit_apt'],
					'kd_milik'=>'01',
					'tgl_expire'=>'0000-00-00',
					'harga_pokok'=>0,
					'jml_stok'=>0);
			$this->mobat->insert('apt_stok_unit',$settingstokawal);
		}
		
		if(!empty($kd_barcode)){
			$this->mobat->delete("obat_barcode",'kd_obat="'.$kd_obat.'" ');
			foreach ($kd_barcode as $key => $value) {
				# code...
				$databarcode=array('kd_obat'=>$kd_obat,
									'kd_barcode'=>$value,
									'kd_satuan'=>$kd_satuan_barcode[$key],
									'deskripsi'=>$deskripsi[$key],
									'fractions'=>$fractions[$key]);
				$this->mobat->insert('obat_barcode',$databarcode);
			}
		}else{
			$this->mobat->delete("obat_barcode",'kd_obat="'.$kd_obat.'" ');
		}
		
		
		//input ke simo
		$simodb = $this->load->database('simo', TRUE);
		$simodb->insert('apt_obat',$tambahobat);
		
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;
		$msg['posting']=3;

		echo json_encode($msg);
	}

	public function update(){
		$kd_obat=$this->input->post('kd_obat');
		$kd_obat_lama=$this->input->post('kd_obat_lama');
		$kd_produk=$this->input->post('kd_produk');
		$kd_satuan_kecil=$this->input->post('kd_satuan_kecil');
		$kd_golongan=$this->input->post('kd_golongan');
		if($this->input->post('kd_sub') == null )
		$kd_sub=null;
		else 
			$kd_sub=$this->input->post('kd_sub');
		$nama_obat=$this->input->post('nama_obat');
		//$generic=$this->input->post('generic');
		$is_aktif=$this->input->post('is_aktif');
		$jml_stok=$this->input->post('jml_stok');
		$min_stok=$this->input->post('min_stok');
		$max_stok=$this->input->post('max_stok');
		$harga_beli=$this->input->post('harga_beli');
		$harga_jual=$this->input->post('harga_jual');
		$harga_apbd=$this->input->post('harga_apbd');
		$harga_p3k=$this->input->post('harga_p3k');
		$harga_buffer=$this->input->post('harga_buffer');
		$harga_jpkmm=$this->input->post('harga_jpkmm');
		$harga_program=$this->input->post('harga_program');
		$harga_dak=$this->input->post('harga_dak');
		$tgl=$this->input->post('tgl');
		$kd_pabrik=$this->input->post('kd_pabrik');
		$kd_therapi=$this->input->post('kd_therapi');
		$fornas=$this->input->post('fornas');
		
		$kd_barcode=$this->input->post('kd_barcode');
		$deskripsi=$this->input->post('deskripsi');
		$fractions=$this->input->post('fractions');
		$kd_satuan_barcode=$this->input->post('kd_satuan_barcode');
		$isi_kemasan=$this->input->post('isi_kemasan');
		$satuan_kecil=$this->input->post('satuan_kecil');

		$kd_unit_gudang=$this->session->userdata('kd_unit_apt_gudang');
		$minstok=0; $maxstok=0;
		if($min_stok==''){$minstok=0;}
		else{$minstok=$min_stok;}
		
		if($max_stok==''){$maxstok=0;}
		else{$maxstok=$max_stok;}
		
		
			$editobat=array('kd_produk'=>$kd_produk,
						'kd_obat'=>$kd_obat,
						'kd_satuan_besar'=>$kd_satuan_kecil,
						'kd_satuan_kecil'=>$kd_satuan_kecil,
						'kd_golongan'=>$kd_golongan,
						'nama_obat'=>$nama_obat,
						'is_aktif'=>$is_aktif,
						'pembanding'=>1,
						'harga_beli'=>$harga_beli,
						'harga_dasar'=>$harga_jual,
						'harga_apbd'=>$harga_apbd,
						'harga_p3k'=>$harga_p3k,
						'harga_buffer'=>$harga_buffer,
						'harga_jpkmm'=>$harga_jpkmm,
						'harga_program'=>$harga_program,
						'harga_dak'=>$harga_dak,
						'kd_pabrik'=>$kd_pabrik,
 						'kd_therapi'=>$kd_therapi,
						'isi_kemasan'=>$isi_kemasan,
						'satuan_kecil'=>$satuan_kecil,
						'fornas'=>$fornas,
						'kd_sub'=>$kd_sub);
			$this->mobat->update('apt_obat',$editobat,'kd_obat="'.$kd_obat_lama.'"');
			
			
		
		$kd_unit_apt="D01";
		$this->mobat->delete("apt_setting_obat",'kd_obat="'.$kd_obat_lama.'" ');
		if($this->mobat->cekObat($kd_obat,$kd_unit_apt)){ //kalo ada
			
				$dua=array('min_stok'=>$minstok,
							'max_stok'=>$maxstok);
						
			$this->mobat->update('apt_setting_obat',$dua,'kd_obat="'.$kd_obat.'" and kd_unit_apt="'.$kd_unit_apt.'"');
		}
		else{ //kalo ga ada
			$satu=array('kd_obat'=>$kd_obat,
						'kd_unit_apt'=>$kd_unit_apt,
						'min_stok'=>$minstok,
						'max_stok'=>$maxstok);
			$this->mobat->insert('apt_setting_obat',$satu);
		}
		
		if(!empty($kd_barcode)){
			$this->mobat->delete("obat_barcode",'kd_obat="'.$kd_obat_lama.'" ');
			foreach ($kd_barcode as $key => $value) {
				# code...
				$databarcode=array('kd_obat'=>$kd_obat,
									'kd_barcode'=>$value,
									'kd_satuan'=>$kd_satuan_barcode[$key],
									'deskripsi'=>$deskripsi[$key],
									'fractions'=>$fractions[$key]);
				$this->mobat->insert('obat_barcode',$databarcode);
			}
		}else{
			$this->mobat->delete("obat_barcode",'kd_obat="'.$kd_obat_lama.'" ');
		}

		//input ke simo
		$simodb = $this->load->database('simo', TRUE);
		$simodb->update('apt_obat',$editobat,array('kd_obat'=>$kd_obat_lama));

		$msg['kd_obat']=$kd_obat;
		
		$msg['pesan']="Data Berhasil Di Edit";
		$msg['status']=1;
		$msg['posting']=3;

		echo json_encode($msg);
	}

	public function edit($id=""){
		if(!$this->muser->isAkses("3")){
			$this->restricted();
			return false;
		}
		
		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','timepicker.css','theme.css');
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
		
		$data=array('databesar'=>$this->mobat->ambilData('apt_satuan_besar'),
					'datatherapi'=>$this->mobat->ambilData('obat_therapi'),
					'datakecil'=>$this->mobat->ambilData('apt_satuan_kecil'),
					'datajenis'=>$this->mobat->ambilData('apt_jenis_obat'),
					'datasub'=>$this->mobat->ambilData("apt_sub_golongan"),
					'datagolongan'=>$this->mobat->ambilData('apt_golongan'),					
					'databarcode'=>$this->mobat->ambilData('obat_barcode','kd_obat="'.urldecode($id).'"'),					
					'items'=>$this->mobat->ambilItemData('apt_obat','kd_obat="'.urldecode($id).'"'),
					'datapabrik'=>$this->mobat->ambilData('apt_pabrik'),
					'itemsetting'=>$this->mobat->ambilItemData('apt_setting_obat','kd_obat="'.urldecode($id).'" and kd_unit_apt="D01"'),
					'kd_obat'=>$id,
					'itemexpire'=>$this->mobat->ambilItemData('apt_stok_unit','kd_obat="'.urldecode($id).'" and kd_unit_apt="U01"'));
//debugvar($id);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/obat/editobat',$data);
		$this->load->view('footer',$datafooter);

	}
	
	public function hapus($id=""){
		if(!$this->muser->isAkses("4")){
			$this->restricted();
			return false;
		}
		
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		if(!empty($id)){
			$this->mobat->delete('apt_obat','kd_obat="'.$id.'"');
			$this->mobat->delete('apt_setting_obat','kd_obat="'.$id.'" and kd_unit_apt="'.$kd_unit_apt.'"');
			$simodb = $this->load->database('simo', TRUE);
			$simodb->delete('apt_obat',array('kd_obat'=>$id));
			//$this->mobat->delete('apt_stok_unit','kd_obat="'.$id.'" and kd_unit_apt="U01"');
			redirect('/masterapotek/obat/');
		}
	}
	
	public function cekgolongan(){
		$q=$this->input->get('query');
		$items=$this->mobat->ambilgolongan($q);
		echo json_encode($items);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
