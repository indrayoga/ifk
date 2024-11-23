<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
include_once(APPPATH.'third_party/phpexcelreader/Excel/reader.php');

//class Stokopname extends CI_Controller {
class Stokopname extends Rumahsakit {

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
		$this->load->model('apotek/mstokopname');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		//if(empty($kd_unit_apt)){
		//	redirect('/home/');
		//}
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
	
	public function index()
	{
		if(!$this->muser->isAkses("80")){
			$this->restricted();
			return false;
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
							'lib/bootstrap-timepicker.js',
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
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function stokopnameobat(){
		if(!$this->muser->isAkses("80")){
			$this->restricted();
			return false;
		}
		
		$tanggal=date('d-m-Y');
		$nama_obat='';
		$kd_obat='';
		$submit=$this->input->post('submit');
		$submit1=$this->input->post('submit1');
		$periodeawal=date('d-m-Y');
		$periodeakhir=date('d-m-Y');
		if($this->input->post('nama_obat')!=''){
			$nama_obat=$this->input->post('nama_obat');
		}
		if($this->input->post('kd_obat')!=''){
			$kd_obat=$this->input->post('kd_obat');
		}
		if($this->input->post('periodeawal')!=''){
			$periodeawal=$this->input->post('periodeawal');
		}
		if($this->input->post('periodeakhir')!=''){
			$periodeakhir=$this->input->post('periodeakhir');
		}
		if($this->input->post('kd_unit_apt')!=''){
			$kd_unit_apt=$this->input->post('kd_unit_apt');
		}else{$kd_unit_apt='';}
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
							'lib/bootstrap-timepicker.js',
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
					//'items'=>$this->mstokopname->getStokopname($kd_barang,$kd_lokasi,$kd_kategori),
					'kd_unit_apt'=>$kd_unit_apt,
					'tanggal'=>$tanggal,
					'periodeawal'=>$periodeawal,
					'periodeakhir'=>$periodeakhir,
				    	'sumberdana'=>$this->mstokopname->sumberdana(),
					'dataunit'=>$this->mstokopname->ambilData('apt_unit'),
					'nama_obat'=>$nama_obat,
					'kd_obat'=>$kd_obat,
					'kd_unit_apt'=>$kd_unit_apt
					);
		
		//if($submit==1) $data['items']=$this->mstokopname->getStokopname($kd_obat,$kd_unit_apt);
		if($submit==1) $data['items']=$this->mstokopname->getStokopname($nama_obat,$kd_unit_apt);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/stokopname/stokopnameobat',$data);
		$this->load->view('footer',$datafooter);
	}

	public function ubah($nomor=""){
		
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
		
		$data=array(
				'datapabrik'=>$this->mstokopname->ambilData('apt_pabrik'),
				'item'=>$this->mstokopname->getItemStokopname($nomor)
			);
		//debugvar($data);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/stokopname/ubahstokopname',$data);
		$this->load->view('footer',$datafooter);

	}
	
	public function simpanstokopname(){	
		$msg=array();
		$submit=$this->input->post('submit');
		$tanggal=$this->input->post('tanggal');
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$kd_unit_apt=$this->input->post('kd_unit_apt');
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		//$kd_lokasi=$this->input->post('kd_lokasi');
		
		$kd_obat2=$this->input->post('kd_obat2');
		$nama_obat2=$this->input->post('nama_obat2');
		$tgl_expire=$this->input->post('tgl_expire');
		$stoklama=$this->input->post('stoklama');
		$stokbaru=$this->input->post('stokbaru');
		$alasan=$this->input->post('alasan');
		$kd_unit_apt1=$this->input->post('kd_unit_apt1');
		$jam=$this->input->post('jam');
		$kd_milik="01";
		//$tanggal=$this->input->post('tanggal');
		//$kd_user=0;
		$this->db->trans_start();
		$msg['status']=1;
		$kd_user=$this->session->userdata('id_user'); 
		
		if($submit=="simpanstokopname"){
			//debugvar($tanggal);
			$kode=$this->mstokopname->nomor();
			$nomor=$kode+1;
			$msg['nomor']=$nomor;
			$selisih=$stokbaru-$stoklama;
			
			$tgl=convertDate($tanggal)." ".$jam;
			$datasimpan=array('nomor'=>$nomor,
							//'tanggal'=>convertDate($tanggal),
							'tanggal'=>$tgl,
							'kd_unit_apt'=>$kd_unit_apt1,
							'kd_obat'=>$kd_obat2,
							'kd_milik'=>$kd_milik,
							//'tgl_expired'=>convertDate($tgl_expire),
							'tgl_expired'=>$tgl_expire,
							'qty'=>$selisih,
							'alasan'=>$alasan,
							'kd_user'=>$kd_user,
							'stok_lama'=>$stoklama,
							'stok_baru'=>$stokbaru);
			//debugvar($datasimpan);
			$this->mstokopname->insert('history_perubahan_stok',$datasimpan);
			
			$datastok=array('jml_stok'=>$stokbaru);
			$this->mstokopname->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$kd_unit_apt1.'" and kd_obat="'.$kd_obat2.'" and tgl_expire="'.$tgl_expire.'"');
			
			$msg['pesan']="Stokopname berhasil disimpan";
		}

		$this->db->trans_complete();
		echo json_encode($msg);
	}
	
	public function updatestokopname(){	
		$msg=array();
		$submit=$this->input->post('submit');
		$nomor=$this->input->post('nomor');
		$kd_obat=$this->input->post('kd_obat');
		$kd_unit_apt=$this->input->post('kd_unit_apt');	
		$kd_pabrik=$this->input->post('kd_pabrik');
		$tgl_expired=$this->input->post('tgl_expired');
		$harga=$this->input->post('harga');
		$batch=$this->input->post('batch');
		$tgl_expire_baru=convertDate($this->input->post('tgl_expire_baru'));
		$batch_baru=$this->input->post('batch_baru');
		$harga_baru=$this->input->post('harga_baru');
		$stok_baru=$this->input->post('stok_baru');
		$kd_pabrik_baru=$this->input->post('kd_pabrik_baru');
		$format_baru=$this->input->post('format_baru');
		$kd_milik="01";
		//$tanggal=$this->input->post('tanggal');
		//$kd_user=0;
		$this->db->trans_start();

		$msg['status']=1;
		$kd_user=$this->session->userdata('id_user'); 
		$item=$this->mstokopname->ambilItemData('history_perubahan_stok','nomor="'.$nomor.'"');
		$stokobat=$this->mstokopname->ambilItemData('apt_stok_unit',' kd_unit_apt="'.$item['kd_unit_apt'].'" and kd_obat="'.$item['kd_obat'].'" and kd_milik="'.$item['kd_milik'].'" and kd_pabrik="'.$item['kd_pabrik'].'" and tgl_expire="'.$item['tgl_expired'].'" and harga_pokok="'.$item['harga'].'" and batch="'.$item['batch'].'" ');
		$stokunitbaru=$stokobat['jml_stok']+($stok_baru-$item['stok_baru']);
		if($stokunitbaru<0){
			debugvar('error: stok akan minus');
		}

		$updatedatastok=array(
						'tgl_expire'=>$tgl_expire_baru,
						'kd_pabrik'=>$kd_pabrik_baru,
						'harga_pokok'=>$harga_baru,
						'batch'=>$batch_baru,
						'format'=>$format_baru,
						'jml_stok'=>$stokunitbaru
						);
		$updatedatapenjualan=array(
						'tgl_expire'=>$tgl_expire_baru,
						'kd_pabrik'=>$kd_pabrik_baru,
						'harga_pokok'=>$harga_baru,
						'batch'=>$batch_baru
						);
		$this->mstokopname->update('apt_stok_unit',$updatedatastok,'kd_unit_apt="'.$item['kd_unit_apt'].'" and kd_obat="'.$item['kd_obat'].'" and kd_milik="'.$item['kd_milik'].'" and kd_pabrik="'.$item['kd_pabrik'].'" and tgl_expire="'.$item['tgl_expired'].'" and harga_pokok="'.$item['harga'].'" and batch="'.$item['batch'].'" ');
		$this->mstokopname->update('apt_penjualan_detail',$updatedatapenjualan,'kd_unit_apt="'.$item['kd_unit_apt'].'" and kd_obat="'.$item['kd_obat'].'" and kd_milik="'.$item['kd_milik'].'" and kd_pabrik="'.$item['kd_pabrik'].'" and tgl_expire="'.$item['tgl_expired'].'" and harga_pokok="'.$item['harga'].'" and batch="'.$item['batch'].'" ');

		$selisih=$stok_baru-$item['stok_lama'];		
		$datasimpan=array(
						'tgl_expired'=>$tgl_expire_baru,
						'kd_pabrik'=>$kd_pabrik_baru,
						'qty'=>$selisih,
						'harga'=>$harga_baru,
						'batch'=>$batch_baru,
						'format'=>$format_baru,
						'stok_baru'=>$stok_baru);
		//debugvar($datasimpan);
		$this->mstokopname->update('history_perubahan_stok',$datasimpan,'nomor="'.$nomor.'"');
				
		redirect('transapotek/laporanapt/stokopname');
	}

	public function periksastokopname(){
		$msg=array();
		$submit=$this->input->post('submit');
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$kd_unit_apt=$this->input->post('kd_unit_apt');
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		
		$kd_obat2=$this->input->post('kd_obat2');
		$nama_obat2=$this->input->post('nama_obat2');
		$tgl_expire=$this->input->post('tgl_expire');
		$stoklama=$this->input->post('stoklama');
		$stokbaru=$this->input->post('stokbaru');
		$alasan=$this->input->post('alasan');
		$kd_unit_apt1=$this->session->userdata('kd_unit_apt1');
		$tanggal=$this->input->post('tanggal');
		$jam=$this->input->post('jam');
		
		//$kd_user=0;
		//$kd_lokasi=$this->session->userdata('kd_lokasi');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="hapus"){
		}
		else{
			/*if(empty($stokbaru)){
				$jumlaherror++;
				$msg['id'][]="qty";
				$msg['pesan'][]="Kolom stok baru harus di isi";
			}*/
			if($jumlaherror>0){
				$msg['status']=0;
				$msg['error']=$jumlaherror;
				$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
			}
		}
		echo json_encode($msg);
	}
	
	public function ambilobatbynama(){
		$q=$this->input->get('query');
		$kd_unit_apt=$this->input->get('kd_unit_apt');
		$items=$this->mstokopname->ambilData4($q,$kd_unit_apt);
		echo json_encode($items);
	}
	
	public function ambilitems() {
		$q=$this->input->get('query');
		$unit=$this->input->get('unit');
		$tgl=$this->input->get('tgl');
		$items=$this->mstokopname->ambilData2($q,$unit,$tgl);
		echo json_encode($items);
	}

	public function stokopnameobat2() {
		if(!$this->muser->isAkses("80")) {
			$this->restricted();

			return false;
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
							'lib/bootstrap-timepicker.js',
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

		$data = array(
			'sumberdana' => $this->mstokopname->sumberdana(),
		);
		$this->load->view('headerapotek', $dataheader);
		$this->load->view('apotek/transaksi/stokopname/stokopnameobat2', $data);
		$this->load->view('footer', $datafooter);
	}

	public function exportstokopname(){
		if(!$this->muser->isAkses("92")){
			$this->restricted();
			return false;
		}
		
		$tanggal=date('d-m-Y');
		$kd_unit_apt='';

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
							'lib/bootstrap-timepicker.js',
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
			'sumberdana'=>$this->mstokopname->ambilData('apt_unit'),
			'kd_unit_apt'=>$kd_unit_apt
		);
		
		//debugvar($data);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/stokopname/exportstokopname',$data);
		$this->load->view('footer',$datafooter);		
	}

	public function periksaprosesimportstokopname(){
		$msg=array();
		$msg['kd_obat']="";
		$kd_unit_apt=$this->input->post('kd_unit_apt');
		$data = new Spreadsheet_Excel_Reader();
		$data->read($_FILES['file']['tmp_name']); 
		$baris = $data->sheets[0]['numRows'];
		//die('dihere');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesan']="";
		$msg['pesanlain']="";
		$x=7;
		//die($x);
		while($x<=$data->sheets[0]['numRows']) {
			$obat = isset($data->sheets[0]['cells'][$x][1]) ? $data->sheets[0]['cells'][$x][1] : '';
			$unit = isset($data->sheets[0]['cells'][$x][2]) ? $data->sheets[0]['cells'][$x][2] : '';
			$tglexp = isset($data->sheets[0]['cells'][$x][5]) ? $data->sheets[0]['cells'][$x][5] : '';
			$jmlstok = isset($data->sheets[0]['cells'][$x][6]) ? $data->sheets[0]['cells'][$x][6] : '0';
			$stokopname = isset($data->sheets[0]['cells'][$x][7]) ? $data->sheets[0]['cells'][$x][7] : '0';
			$harga = isset($data->sheets[0]['cells'][$x][8]) ? $data->sheets[0]['cells'][$x][8] : '';
			$kd_pabrik = isset($data->sheets[0]['cells'][$x][9]) ? $data->sheets[0]['cells'][$x][9] : '';
			$batch = isset($data->sheets[0]['cells'][$x][11]) ? $data->sheets[0]['cells'][$x][11] : '';
			$thnpenerimaan = isset($data->sheets[0]['cells'][$x][12]) ? $data->sheets[0]['cells'][$x][12] : '';
			$obat=str_replace("\0", "", $obat);
			$unit=str_replace("\0", "", $unit);
			$tglexp=str_replace("\0", "", $tglexp);
			$jmlstok=str_replace("\0", "", $jmlstok);
			$harga=str_replace("\0", "", $harga);
			$kd_pabrik=str_replace("\0", "", $kd_pabrik);
			$batch=str_replace("\0", "", $batch);
			$thnpenerimaan=str_replace("\0", "", $thnpenerimaan);

			if($unit!=$kd_unit_apt){
				$jumlaherror++;
				$msg['pesan'].="Kode Unit Pada Baris ".$x." dan Kolom B Tidak Cocok, Kode Yang Benar Adalah ".$kd_unit_apt." <br/>";
			}

			if(!$this->mstokopname->isObat($obat)){
				$jumlaherror++;
				$msg['pesan'].="Kode Obat Pada Baris ".$x." dan Kolom A Tidak Cocok Dengan yang Ada di Database <br/>";
			}
			if(!validateDateMySQL($tglexp) && $tglexp!="0000-00-00"){
				$jumlaherror++;
				$msg['pesan'].="Format Tanggal Pada Baris ".$x." dan Kolom E Tidak Sesuai, Gunakan Format yyyy-mm-dd <br/>";
			}
			if(!is_numeric($jmlstok)){
				$jumlaherror++;
				$msg['pesan'].="Nilai Jml Stok Pada Baris ".$x." dan Kolom F Harus Angka <br/>";				
			}
			if(!is_numeric($stokopname)){
				$jumlaherror++;
				$msg['pesan'].="Nilai Stokopname Pada Baris ".$x." dan Kolom G Harus Angka <br/>";				
			}
			/*if(!is_numeric($thnpenerimaan)){
				$jumlaherror++;
				$msg['pesan'].="Tahun Penerimaan Pada Baris ".$x." dan Kolom K Harus Angka <br/>";				
			}
			if(empty($thnpenerimaan)){
				$jumlaherror++;
				$msg['pesan'].="Tahun Penerimaan Pada Baris ".$x." dan Kolom K Harus Angka <br/>";				
			}*/

			$x++;
		}
		if($jumlaherror>0){
		  //  die($msg['pesan']);
			$msg['status']=0;
		}else{
			$x=7;
			$this->db->trans_start();
			$kd_user=$this->session->userdata('id_user');
			while($x<=$data->sheets[0]['numRows']) {

				$obat = isset($data->sheets[0]['cells'][$x][1]) ? $data->sheets[0]['cells'][$x][1] : '';
				$unit = isset($data->sheets[0]['cells'][$x][2]) ? $data->sheets[0]['cells'][$x][2] : '';
				$tglexp = isset($data->sheets[0]['cells'][$x][5]) ? $data->sheets[0]['cells'][$x][5] : '';
				$jmlstok = isset($data->sheets[0]['cells'][$x][6]) ? $data->sheets[0]['cells'][$x][6] : '0';
				$stokopname = isset($data->sheets[0]['cells'][$x][7]) ? $data->sheets[0]['cells'][$x][7] : '0';
				$harga = isset($data->sheets[0]['cells'][$x][8]) ? $data->sheets[0]['cells'][$x][8] : '';
				$kd_pabrik = isset($data->sheets[0]['cells'][$x][9]) ? $data->sheets[0]['cells'][$x][9] : '';
				$batch = isset($data->sheets[0]['cells'][$x][11]) ? $data->sheets[0]['cells'][$x][11] : '';
				$thnpenerimaan = isset($data->sheets[0]['cells'][$x][12]) ? $data->sheets[0]['cells'][$x][12] : '';
				$kemasan = isset($data->sheets[0]['cells'][$x][13]) ? $data->sheets[0]['cells'][$x][13] : '';
				$satuan_kemasan = isset($data->sheets[0]['cells'][$x][14]) ? $data->sheets[0]['cells'][$x][14] : '';

				$obat=str_replace("\0", "", $obat);
				$unit=str_replace("\0", "", $unit);
				$tglexp=str_replace("\0", "", $tglexp);
				$jmlstok=str_replace("\0", "", $jmlstok);
				$harga=str_replace("\0", "", $harga);
				$kd_pabrik=str_replace("\0", "", $kd_pabrik);
				$batch=str_replace("\0", "", $batch);
				$thnpenerimaan=str_replace("\0", "", $thnpenerimaan);
				$kemasan=str_replace("\0", "", $kemasan);
				$satuan_kemasan=str_replace("\0", "", $satuan_kemasan);
				$selisih=$stokopname-$jmlstok;
				// if($x==11)debugvar($data);
				if(empty($stokopname) || $stokopname==0){
					$x++;
					continue;
				}
				$kode=$this->mstokopname->nomor();
				$nomor=$kode+1;
				/*
				$digit1=$this->mstokopname->getDigitPertama($unit);
				//list($tglpenerimaan,$blnpenerimaan,$thnpenerimaan)=explode("-", $tgl_penerimaan);
				list($tglexpire,$blnexpire,$thnexpire)=explode("-", $tglexp);
				$digit2=substr($thnpenerimaan,-2);
				$digit3=$blnexpire;
				$digit4=substr($thnexpire,-2);
				if(empty($batch))$digit5=$obat; else $digit5=$batch;
				$format=$digit1.$digit2.$digit3.$digit4.$digit5;
				$lastbarcode=$this->mstokopname->getMaxBarcode($digit1.$digit2);
				$barcode=$digit1.$digit2.str_pad($lastbarcode+1,4,"0",STR_PAD_LEFT);
				*/
				$datasimpan=array('nomor'=>$nomor,
								//'tanggal'=>convertDate($tanggal),
								'tanggal'=>date('Y-m-d H:i:s'),
								'kd_unit_apt'=>$unit,
								'kd_obat'=>$obat,
								'kd_milik'=>'01',
								'kd_pabrik'=>$kd_pabrik,
								//'tgl_expired'=>convertDate($tgl_expire),
								'tgl_expired'=>$tglexp,
								//'qty'=>$selisih,
								'qty'=>$stokopname,
								'harga'=>$harga,
								'batch'=>$batch,
								'alasan'=>"SO Via Excel",
								'kd_user'=>$kd_user,
								'stok_lama'=>$jmlstok,
								'stok_baru'=>$stokopname,
								'kemasan_kecil'=>$kemasan,
								'satuan_kemasan_kecil'=>$satuan_kemasan
								//'format'=>$format
								//'barcode'=>$barcode
								);
				//debugvar($datasimpan);
				$this->mstokopname->insert('history_perubahan_stok',$datasimpan);

				//$this->db->query("replace into apt_stok_unit set kd_unit_apt='".$unit."',kd_obat='".$obat."',kd_milik='01',tgl_expire='".$tglexp."',jml_stok='".$stokopname."',batch='".$batch."',kd_pabrik='".$kd_pabrik."',harga_pokok='".$harga."',format='".$format."',barcode='".$barcode."' ");
				$this->db->query("replace into apt_stok_unit set kd_unit_apt='".$unit."',kd_obat='".$obat."',kd_milik='01',tgl_expire='".$tglexp."',jml_stok='".$stokopname."',batch='".$batch."',kd_pabrik='".$kd_pabrik."',harga_pokok='".$harga."' ");
				
				$x++;
			}		
			$this->db->trans_complete();
			$msg['pesan']="Import Data Berhasil";
		}
		//$kd_user=0;
		//$kd_lokasi=$this->session->userdata('kd_lokasi');
				
		echo json_encode($msg);
	}

	public function importstokopname(){
		if(!$this->muser->isAkses("93")){
			$this->restricted();
			return false;
		}
		
		$tanggal=date('d-m-Y');
		$kd_unit_apt='';

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
							'lib/bootstrap-timepicker.js',
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
			'sumberdana'=>$this->mstokopname->ambilData('apt_unit'),
			'kd_unit_apt'=>$kd_unit_apt
		);
		
		//debugvar($data);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/stokopname/importstokopname',$data);
		$this->load->view('footer',$datafooter);		
	}

	public function stokopnamexls($kd_unit_apt=""){ //bwt yg penjualan obat
		$kd_unit_apt=$this->input->post('kd_unit_apt');
		$this->load->library('phpexcel'); 
		$this->load->library('PHPExcel/iofactory');
		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
		$objPHPExcel->getActiveSheet()->mergeCells('A3:G3');
		$objPHPExcel->getActiveSheet()->mergeCells('A4:G4');

		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(10); //NO
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(10); //TGL JUAL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(45); //NO JUAL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(15); //KODE
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(15); //NAMA
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(10); //UNIT
		
		for($x='A';$x<='G';$x++){
			$objPHPExcel->getActiveSheet()->getStyle($x.'2')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
		}	
		for($x='A';$x<='G';$x++){
			$objPHPExcel->getActiveSheet()->getStyle($x.'3')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
		}	
		for($x='A';$x<='G';$x++){
			$objPHPExcel->getActiveSheet()->getStyle($x.'4')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
		}	
		for($x='A';$x<='G';$x++){
			$objPHPExcel->getActiveSheet()->getStyle($x.'5')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
		}	
		$objPHPExcel->getActiveSheet()->setCellValue ('A2','STOKOPNAME');
		$objPHPExcel->getActiveSheet()->setCellValue ('A3','GFK BALIKPAPAN');
		
		if($kd_unit_apt==''){ $objPHPExcel->getActiveSheet()->setCellValue ('A4','Semua Sumber');}
		else{
			$namaunit=$this->mstokopname->namaUnit($kd_unit_apt);
			$objPHPExcel->getActiveSheet()->setCellValue ('A4','Unit : '.$namaunit);
		}

		for($x='A';$x<='L';$x++){
			$objPHPExcel->getActiveSheet()->getStyle($x.'6')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
		
			$objPHPExcel->getActiveSheet()->getStyle($x.'6')->applyFromArray(array('font'    => array('name'      => 'calibri','horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
																			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'size'		=>12,'color'     => array('rgb' => '000000')),
																			'borders' => array('bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
																			'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
																			'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
																			'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
		}		
		$objPHPExcel->getActiveSheet()->setCellValue ('A6','KD OBAT.');
		$objPHPExcel->getActiveSheet()->setCellValue ('B6','KD UNIT');
		$objPHPExcel->getActiveSheet()->setCellValue ('C6','NAMA OBAT');
		$objPHPExcel->getActiveSheet()->setCellValue ('D6','NAMA UNIT');
		$objPHPExcel->getActiveSheet()->setCellValue ('E6','TGL EXPIRE');
		$objPHPExcel->getActiveSheet()->setCellValue ('F6','JML STOK');
		$objPHPExcel->getActiveSheet()->setCellValue ('G6','STOK OPNAME');
		$objPHPExcel->getActiveSheet()->setCellValue ('H6','HARGA');
		$objPHPExcel->getActiveSheet()->setCellValue ('I6','KD PABRIK');
		$objPHPExcel->getActiveSheet()->setCellValue ('J6','NAMA PABRIK');
		$objPHPExcel->getActiveSheet()->setCellValue ('K6','BATCH');
		$objPHPExcel->getActiveSheet()->setCellValue ('L6','THN PENERIMAAN');
		$items=array();
		$items=$this->mstokopname->getExportStokopname($kd_unit_apt);
		$baris=7;
		$nomor=1;
		$total=0;
		foreach ($items as $item) {
			# code...
			for($x='A';$x<='L';$x++){
				if($x=='A'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));					
				}else if($x=='B'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='C'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='D'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='E'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='F'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='G'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='H'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='I'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='J'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='K'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}
			
				$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->applyFromArray(array(
					'font'    => array('name'      => 'calibri','horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=>12,'color'     => array('rgb' => '000000')),'borders' => array('bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000')),'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000')))));
			}

			$objPHPExcel->getActiveSheet()->setCellValueExplicit ('A'.$baris,$item['kd_obat'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->setCellValue ('B'.$baris,$item['kd_unit_apt']);
			$objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,$item['nama_obat']);
			if(empty($item['nama_unit_apt']))$item['nama_unit_apt']=$namaunit;
			$objPHPExcel->getActiveSheet()->setCellValue ('D'.$baris,$item['nama_unit_apt']);
			$objPHPExcel->getActiveSheet()->setCellValue ('E'.$baris,$item['tgl_expire']);			
			$objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,$item['jml_stok']);
			$objPHPExcel->getActiveSheet()->setCellValue ('H'.$baris,$item['harga']);
			$objPHPExcel->getActiveSheet()->setCellValue ('I'.$baris,$item['kd_pabrik']);
			$objPHPExcel->getActiveSheet()->setCellValue ('J'.$baris,$item['nama_pabrik']);
			$objPHPExcel->getActiveSheet()->setCellValue ('K'.$baris,$item['batch']);
			$nomor=$nomor+1; $baris=$baris+1;
		}	
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save("download/stokopname.xls");
		// Load the DB utility class
		$this->load->dbutil();

		// Backup your entire database and assign it to a variable
		//$backup =& $this->dbutil->backup();

		// Load the file helper and write the file to your server
		//$this->load->helper('file');
		//write_file('download/backup-'.date('Y-m-d').'.zip', $backup);

		// Load the download helper and send the file to your desktop
		//$this->load->helper('download');
		//force_download('backup-'.date('Y-m-d').'.gz', $backup); 		
		redirect(base_url()."download/stokopname.xls");
		//header("Location: ".base_url()."download/laporanpenjualanobat.xls");
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
