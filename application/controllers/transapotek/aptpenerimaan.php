<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Aptpenerimaan extends CI_Controller {
class Aptpenerimaan extends Rumahsakit {

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

	public function __construct(){
		parent::__construct();
		$this->load->model('apotek/mpenerimaanapt');
		
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
	
	public function index()	{
		
		if(!$this->muser->isAkses("21")){
			$this->restricted();
			return false;
		}
		
		$no_penerimaan='';
		$kd_supplier='';
		$periodeawal=date('d-m-Y');
		$periodeakhir=date('d-m-Y');
		
		if($this->input->post('no_penerimaan')!=''){
			$no_penerimaan=$this->input->post('no_penerimaan');
		}
		if($this->input->post('kd_supplier')!=''){
			$kd_supplier=$this->input->post('kd_supplier');
		}
		if($this->input->post('periodeawal')!=''){
			$periodeawal=$this->input->post('periodeawal');
		}
		if($this->input->post('periodeakhir')!=''){
			$periodeakhir=$this->input->post('periodeakhir');
		}
		
		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js','vendor/jquery-1.9.1.min.js','vendor/jquery-migrate-1.1.1.min.js','vendor/jquery-ui-1.10.0.custom.min.js','vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js','lib/jquery.dataTables.min.js','lib/DT_bootstrap.js','lib/responsive-tables.js',
							'lib/bootstrap-datepicker.js',
							'lib/bootstrap-inputmask.js',
							'lib/bootstrap-timepicker.js',
							'spin.js',
							'main.js');
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		$data=array('no_penerimaan'=>$no_penerimaan,
					'kd_supplier'=>$kd_supplier,
					'periodeawal'=>$periodeawal,
					'periodeakhir'=>$periodeakhir,
					'datasupplier'=>$this->mpenerimaanapt->ambilData("apt_supplier","is_aktif='1'"),
					'items'=>$this->mpenerimaanapt->ambilDataPenerimaan($no_penerimaan,$kd_supplier,$periodeawal,$periodeakhir));
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/penerimaan/aptpenerimaan',$data);
		$this->load->view('footer',$datafooter);
	}
		
	public function tambahpenerimaanapt(){
		if(!$this->muser->isAkses("42")){
			$this->restricted();
			return false;
		}
		
		$kode=""; $no_penerimaan=""; $sum=""; $kd_applogin="";
		
// 		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
// 		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js','vendor/jquery-1.9.1.min.js','vendor/jquery-migrate-1.1.1.min.js','vendor/jquery-ui-1.10.0.custom.min.js','vendor/bootstrap.min.js',
// 							'lib/jquery.tablesorter.min.js','lib/jquery.dataTables.min.js','lib/DT_bootstrap.js','lib/responsive-tables.js',
// 							'lib/bootstrap-datepicker.js',
// 							'lib/bootstrap-inputmask.js',
// 							'lib/bootstrap-timepicker.js',
// 							'spin.js',
// 							'main.js');
		
		
		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js',
				//'vendor/jquery-1.9.1.min.js',
				'vendor/jquery-latest.js',
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
				'main.js',
				'jquery.form.js');
		
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
				
		$sum=$this->mpenerimaanapt->ambilHarga();
		$kd_applogin=$this->mpenerimaanapt->ambilApp();
		$data=array('no_penerimaan'=>'',
					'datasupplier'=>$this->mpenerimaanapt->ambilData('apt_supplier'),
					'datapabrik'=>$this->mpenerimaanapt->ambilData('apt_pabrik'),
					'sum'=>$sum,
					'itemsdetiltransaksi'=>$this->mpenerimaanapt->getAllDetailPenerimaan($no_penerimaan),
					'itemtransaksi'=>$this->mpenerimaanapt->ambilItemData($no_penerimaan),
					'itemharga'=>$this->mpenerimaanapt->ambilHarga(),
					'sumberdana'=>$this->mpenerimaanapt->sumberdana(),
					//'items'=>$this->mpenerimaanapt->ambilDataPenerimaan('','','',''),
					'kd_applogin'=>$kd_applogin);
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/penerimaan/tambahpenerimaanapt',$data);
		$this->load->view('footer',$datafooter);	
	}
	
	function pabrik(){
		$query= $this->db->get('apt_pabrik');
		$items=$query->result_array();
		echo json_encode($items);
	}
	
	public function ubahpenerimaan($no_penerimaan=""){
		if(!$this->muser->isAkses("43")){
			$this->restricted();
			return false;
		}
		
		$sum=""; $kd_applogin="";
		
		if(empty($no_penerimaan))return false;
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
		$sum=$this->mpenerimaanapt->ambilHarga();
		$kd_applogin=$this->mpenerimaanapt->ambilApp();
		$data=array(		
			'datasupplier'=>$this->mpenerimaanapt->ambilData('apt_supplier'),
			'sumberdana'=>$this->mpenerimaanapt->sumberdana(),
					'datapabrik'=>$this->mpenerimaanapt->ambilData('apt_pabrik'),
			'no_penerimaan'=>$no_penerimaan,
			'sum'=>$sum,
			'itemsdetiltransaksi'=>$this->mpenerimaanapt->getAllDetailPenerimaan($no_penerimaan),
			'itemtransaksi'=>$this->mpenerimaanapt->ambilItemData($no_penerimaan),
			'itemharga'=>$this->mpenerimaanapt->ambilHarga(),
			'kd_applogin'=>$kd_applogin
		);
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/penerimaan/tambahpenerimaanapt',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function tambahobatpenerimaan($no_penerimaan=""){
		if(!$this->muser->isAkses("43")){
			$this->restricted();
			return false;
		}
		
		$sum=""; $kd_applogin="";
		
		if(empty($no_penerimaan))return false;
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
		$sum=$this->mpenerimaanapt->ambilHarga();
		$kd_applogin=$this->mpenerimaanapt->ambilApp();
		$data=array(		
			'datasupplier'=>$this->mpenerimaanapt->ambilData('apt_supplier'),
			'sumberdana'=>$this->mpenerimaanapt->sumberdana(),
					'datapabrik'=>$this->mpenerimaanapt->ambilData('apt_pabrik'),
			'no_penerimaan'=>$no_penerimaan,
			'sum'=>$sum,
			'itemsdetiltransaksi'=>$this->mpenerimaanapt->getAllDetailPenerimaan($no_penerimaan),
			'itemtransaksi'=>$this->mpenerimaanapt->ambilItemData($no_penerimaan),
			'itemharga'=>$this->mpenerimaanapt->ambilHarga(),
			'kd_applogin'=>$kd_applogin
		);
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/penerimaan/tambahobatpenerimaanapt',$data);
		$this->load->view('footer',$datafooter);
	}

	public function detilpenerimaan($no_penerimaan=""){
		if(!$this->muser->isAkses("43")){
			$this->restricted();
			return false;
		}
		
		$sum=""; $kd_applogin="";
		
		if(empty($no_penerimaan))return false;
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
		$sum=$this->mpenerimaanapt->ambilHarga();
		$kd_applogin=$this->mpenerimaanapt->ambilApp();
		$data=array(		
			'datasupplier'=>$this->mpenerimaanapt->ambilData('apt_supplier'),
			'sumberdana'=>$this->mpenerimaanapt->sumberdana(),
					'datapabrik'=>$this->mpenerimaanapt->ambilData('apt_pabrik'),
			'no_penerimaan'=>$no_penerimaan,
			'sum'=>$sum,
			'itemsdetiltransaksi'=>$this->mpenerimaanapt->getAllDetailPenerimaan($no_penerimaan),
			'itemtransaksi'=>$this->mpenerimaanapt->ambilItemData($no_penerimaan),
			'itemharga'=>$this->mpenerimaanapt->ambilHarga(),
			'kd_applogin'=>$kd_applogin
		);
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/penerimaan/detilpenerimaanapt',$data);
		$this->load->view('footer',$datafooter);
	}

	public function simpanpenerimaan(){
		$msg=array();
		$submit=$this->input->post('submit');
		$no_penerimaan=$this->input->post('no_penerimaan');
		$tgl_penerimaan=$this->input->post('tgl_penerimaan');
		$no_faktur=$this->input->post('no_faktur');
		$tgl_faktur=$this->input->post('tgl_faktur');
		$posting=$this->input->post('posting');
		$lunas=$this->input->post('lunas');
		$tgl_tempo=$this->input->post('tgl_tempo');
		$kd_supplier=$this->input->post('kd_supplier');
		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$materai=$this->input->post('materai');
		$keterangan=$this->input->post('keterangan');
		$jumlah=$this->input->post('jumlah');
		$discount=$this->input->post('discount');
		$discount1=$this->input->post('discount1');
		$sum=$this->input->post('sum');
		$tgl_entry=$this->input->post('tgl_entry');
		$update=$this->input->post('update');
		
		$jam_penerimaan=$this->input->post('jam_penerimaan');
		$jam_penerimaan1=$this->input->post('jam_penerimaan1');
		$apf_number1=$this->input->post('apf_number1');
		
		$no_pemesanan=$this->input->post('no_pemesanan');
		$kd_obat=$this->input->post('kd_obat');
		$kd_pabrik=$this->input->post('kd_pabrik');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$tgl_expire=$this->input->post('tgl_expire');
		$pembanding=$this->input->post('pembanding');
		$nama_unit_apt=$this->input->post('nama_unit_apt');
		$kd_unit_apt=$this->input->post('kd_unit_apt');
		$milik=$this->input->post('milik');
		$qty_box=$this->input->post('qty_box'); 
		$jml_penerimaan=$this->input->post('jml_penerimaan');
		//$qty_kcl=$this->input->post('qty_kcl');
		$qty_kcl=$this->input->post('qty_box');
		$harga_beli=$this->input->post('harga_beli');
		$harga_avg=$this->input->post('harga_avg');
		$disc_prs=$this->input->post('disc_prs');
		$isidiskon=$this->input->post('isidiskon');
		$harga_belidisc=$this->input->post('harga_belidisc');
		$jumlah1=$this->input->post('jumlah1');
		$sum=$this->input->post('sum');
		$ppn_item=$this->input->post('ppn_item');
		$bonus=$this->input->post('bonus');		
		$no_batch=$this->input->post('no_batch');
		$ppn=$this->input->post('ppn');
		$kode_sas=$this->input->post('kode_sas');
		
		$alasan=$this->input->post('alasan');
		$tgl_log=$this->input->post('tgl_log');
		$jam_log=$this->input->post('jam_log');
		

		$this->db->trans_start();
		$shift="1";
		$kd_milik="01";
		//$kd_unit_apt=$this->mpenerimaanapt->ambilKodeUnit();
		$kd_user=$this->session->userdata('id_user'); 
		$msg['no_penerimaan']=$no_penerimaan;
		$msg['posting']=0;
						
		$tgl=explode("-", $tgl_penerimaan);
		$kode=$this->mpenerimaanapt->autoNumber($tgl[2],$tgl[1]);
		$kodebaru=$kode+1;
		$kodebaru=str_pad($kodebaru,3,0,STR_PAD_LEFT); 
		$no_penerimaan="TRM.".$tgl[2].".".$tgl[1].".".$kodebaru;
		$msg['no_penerimaan']=$no_penerimaan;
		$tgl_penerimaan1=convertDate($tgl_penerimaan)." ".$jam_penerimaan;
		$datapenerimaan=array('no_penerimaan'=>$no_penerimaan,
								'no_faktur'=>$no_faktur,
								'tgl_faktur'=>convertDate($tgl_faktur),
								'shift'=>$shift,
								'kd_unit_apt'=>$kd_unit_apt,
								'kd_supplier'=>$kd_supplier,
								//'tgl_penerimaan'=>convertDate($tgl_penerimaan),
								'tgl_penerimaan'=>$tgl_penerimaan1,
								'posting'=>$posting,
								'jumlah'=>$jumlah,
								'materai'=>$materai,
								'tgl_tempo'=>convertDate($tgl_tempo),
								'lunas'=>$lunas,
								'retur'=>0,
								'keterangan'=>$keterangan,
								'discount'=>$discount1,
								'ppn'=>$ppn,
								'kd_user'=>$kd_user);
		
		$this->mpenerimaanapt->insert('apt_penerimaan',$datapenerimaan);
		$urut=1;
		$urut_pesan=1;
		if(!empty($kd_obat)){
			foreach ($kd_obat as $key => $value){
				# code...
				if(empty($value))continue;	
				if($no_pemesanan[$key]==''){$urut_pesan='';}
				$tgl=convertDate($tgl_expire[$key]);
				$digit1=$this->mpenerimaanapt->getDigitPertama($kd_unit_apt);
				list($tglpenerimaan,$blnpenerimaan,$thnpenerimaan)=explode("-", $tgl_penerimaan);
				list($tglexpire,$blnexpire,$thnexpire)=explode("-", $tgl_expire[$key]);
				$digit2=substr($thnpenerimaan,-2);
				$digit3=$blnexpire;
				$digit4=substr($thnexpire,-2);
				if(empty($no_batch[$key]))$digit5=$value; else $digit5=$no_batch[$key];
				$format=$digit1.$digit2.$digit3.$digit4.$digit5;
				$qrcode=$digit1.$digit3.$digit4.$digit5;
				$lastbarcode=$this->mpenerimaanapt->getMaxBarcode($digit1.$digit2);
				$barcode=$digit1.$digit2.str_pad($lastbarcode+1,4,"0",STR_PAD_LEFT);

				$hargajual=$harga_beli[$key]+((11/100)*$harga_beli[$key]);
				$hargajual=round($hargajual);
				$datadetil=array('no_penerimaan'=>$no_penerimaan,
								'urut'=>$urut,
								'kd_unit_apt'=>$kd_unit_apt,
								'kd_obat'=>$value,
								'kd_pabrik'=>$kd_pabrik[$key],
								'kd_milik'=>$kd_milik,
								'tgl_expire'=>convertDate($tgl_expire[$key]),
								'harga_beli'=>$harga_beli[$key],
								'harga_avg'=>$harga_avg[$key],
								'qty_box'=>$qty_box[$key],
								'qty_kcl'=>$qty_kcl[$key],
								'disc_prs'=>$disc_prs[$key],
								'harga_belidisc'=>$harga_belidisc[$key],
								'ppn_item'=>$ppn,
								'bonus'=>$bonus[$key],
								'no_pemesanan'=>$no_pemesanan[$key],
								'urut_pesan'=>$urut_pesan,
								'tgl_entry'=>$tgl_entry,
								'update'=>$update[$key],
								'isidiskon'=>$isidiskon[$key],
								'no_batch'=>$no_batch[$key],
								'format'=>$qrcode,
								'kode_sas'=>$kode_sas[$key],
								'barcode'=>$barcode,
								'qrcode'=>$qrcode,
								'harga_pokok'=>$hargajual
								);

				$this->mpenerimaanapt->insert('apt_penerimaan_detail',$datadetil);
				if($this->mpenerimaanapt->cekStok($value,$kd_unit_apt,$tgl,$kd_pabrik[$key],$no_batch[$key],$hargajual)){//kalo datanya ada
					$hargabeli=0;
					$jml_stok=$this->mpenerimaanapt->ambilStok($kd_unit_apt,$value,$tgl,$kd_pabrik[$key],$no_batch[$key],$hargajual);
					$harga_pokok=$this->mpenerimaanapt->ambildistok($kd_unit_apt,$value,$tgl,$kd_pabrik[$key],$no_batch[$key]);
					$sisastok=$jml_stok+$qty_kcl[$key]+$bonus[$key];
					if($update[$key]==1){ //kalo ceklis update HB
						$hargabeli=$harga_beli[$key];
					}
					else{ //kalo ga ceklis update HB
						$hargabeli=$harga_pokok;
					}
					$datastok=array(
						'jml_stok'=>$sisastok,
						'is_sync'=>0,
						'kode_sas'=>$kode_sas[$key],					
					);
					$this->mpenerimaanapt->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$kd_unit_apt.'" and kd_obat="'.$value.'" and tgl_expire="'.$tgl.'" and kd_pabrik="'.$kd_pabrik[$key].'" and batch="'.$no_batch[$key].'" and harga_pokok="'.$hargajual.'" ');
				}
				else{ //kalo datanya ga ada	
					$hargabeli=0;
					$harga_pokok=$this->mpenerimaanapt->ambildistok1($value);
					$jml_stok=$qty_kcl[$key]+$bonus[$key];
					$hargabeli=$harga_beli[$key];
					//$hargajual=$harga_beli[$key]+((10/100)*$harga_beli[$key]);
					$data1=array('kd_unit_apt'=>$kd_unit_apt,
								'kd_obat'=>$value,
								'kd_milik'=>$kd_milik,
								'kd_pabrik'=>$kd_pabrik[$key],
								'batch'=>$no_batch[$key],
								'tgl_expire'=>convertDate($tgl_expire[$key]),
								'harga_pokok'=>$hargajual,
								'format'=>$qrcode,
								'barcode'=>$barcode,
								'qrcode'=>$qrcode,
								'kode_sas'=>$kode_sas[$key],					
								'jml_stok'=>$jml_stok);
					$this->mpenerimaanapt->insert('apt_stok_unit',$data1);
				}
				//$updateobat=array('harga_beli'=>$harga_beli[$key]);
				//$this->mpenerimaanapt->update('apt_obat',$updateobat,'kd_obat="'.$value.'"');
				
				$urut++;
				$urut_pesan++;
			}
		}
		$datatotal=array('jumlah'=>$jumlah,'posting'=>1);
		$this->mpenerimaanapt->update('apt_penerimaan',$datatotal,'no_penerimaan="'.$no_penerimaan.'"');

		$this->db->trans_complete();
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['posting']=3;

		$msg['status']=1;
		$msg['keluar']=0;
		if($submit=="simpankeluar"){
			$msg['keluar']=1;
		}
		echo json_encode($msg);
	}
	
	public function updatenotapenerimaan()
	{
		# code...
		$submit=$this->input->post('submit');
		$no_penerimaan=$this->input->post('no_penerimaan');
		$no_faktur=$this->input->post('no_faktur');
		$tgl_faktur=$this->input->post('tgl_faktur');
		$tgl_penerimaan=$this->input->post('tgl_penerimaan');
		$jam_penerimaan=$this->input->post('jam_penerimaan');
		$tgl_tempo=$this->input->post('tgl_tempo');
		$kd_supplier=$this->input->post('kd_supplier');
		$keterangan=$this->input->post('keterangan');
		$tgl_penerimaan1=convertDate($tgl_penerimaan)." ".$jam_penerimaan;

		$datapenerimaan=array(
								'no_faktur'=>$no_faktur,
								'tgl_faktur'=>convertDate($tgl_faktur),
								'tgl_tempo'=>convertDate($tgl_tempo),
								'tgl_penerimaan'=>$tgl_penerimaan1,
								'kd_supplier'=>$kd_supplier,
								'keterangan'=>$keterangan);
		
		$this->mpenerimaanapt->update('apt_penerimaan',$datapenerimaan,'no_penerimaan="'.$no_penerimaan.'"');
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;
		echo json_encode($msg);
	}	

	public function updatepenerimaan(){
		$msg=array();
		$submit=$this->input->post('submit');
		$no_penerimaan=$this->input->post('no_penerimaan');
		$tgl_penerimaan=$this->input->post('tgl_penerimaan');
		$no_faktur=$this->input->post('no_faktur');
		$tgl_faktur=$this->input->post('tgl_faktur');
		$posting=$this->input->post('posting');
		$lunas=$this->input->post('lunas');
		$tgl_tempo=$this->input->post('tgl_tempo');
		$kd_supplier=$this->input->post('kd_supplier');
		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$materai=$this->input->post('materai');
		$keterangan=$this->input->post('keterangan');
		$jumlah=$this->input->post('jumlah');
		$discount=$this->input->post('discount');
		$discount1=$this->input->post('discount1');
		$sum=$this->input->post('sum');
		$tgl_entry=$this->input->post('tgl_entry');
		$update=$this->input->post('update');
		
		$jam_penerimaan=$this->input->post('jam_penerimaan');
		$jam_penerimaan1=$this->input->post('jam_penerimaan1');
		$apf_number1=$this->input->post('apf_number1');
		
		$no_pemesanan=$this->input->post('no_pemesanan');
		$kd_obat=$this->input->post('kd_obat');
		$kd_pabrik=$this->input->post('kd_pabrik');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$tgl_expire=$this->input->post('tgl_expire');
		$pembanding=$this->input->post('pembanding');
		$nama_unit_apt=$this->input->post('nama_unit_apt');
		$kd_unit_apt=$this->input->post('kd_unit_apt');
		$milik=$this->input->post('milik');
		$qty_box=$this->input->post('qty_box'); 
		$jml_penerimaan=$this->input->post('jml_penerimaan');
		//$qty_kcl=$this->input->post('qty_kcl');
		$qty_kcl=$this->input->post('qty_box');
		$harga_beli=$this->input->post('harga_beli');
		$harga_avg=$this->input->post('harga_avg');
		$disc_prs=$this->input->post('disc_prs');
		$isidiskon=$this->input->post('isidiskon');
		$harga_belidisc=$this->input->post('harga_belidisc');
		$jumlah1=$this->input->post('jumlah1');
		$sum=$this->input->post('sum');
		$ppn_item=$this->input->post('ppn_item');
		$bonus=$this->input->post('bonus');		
		$no_batch=$this->input->post('no_batch');
		$kode_sas=$this->input->post('kode_sas');
		$ppn=$this->input->post('ppn');
		
		$alasan=$this->input->post('alasan');
		$tgl_log=$this->input->post('tgl_log');
		$jam_log=$this->input->post('jam_log');
		

		$this->db->trans_start();
		$shift="1";
		$kd_milik="01";
		//$kd_unit_apt=$this->mpenerimaanapt->ambilKodeUnit();
		$kd_user=$this->session->userdata('id_user'); 
		$msg['no_penerimaan']=$no_penerimaan;
		$msg['posting']=0;
						
		$tgl=explode("-", $tgl_penerimaan);
		$urut_pesan=1;
		if(!empty($kd_obat)){
			foreach ($kd_obat as $key => $value){
				# code...
				if(empty($value))continue;	
				if($no_pemesanan[$key]==''){$urut_pesan='';}
				$tgl=convertDate($tgl_expire[$key]);
				$digit1=$this->mpenerimaanapt->getDigitPertama($kd_unit_apt);
				list($tglpenerimaan,$blnpenerimaan,$thnpenerimaan)=explode("-", $tgl_penerimaan);
				list($tglexpire,$blnexpire,$thnexpire)=explode("-", $tgl_expire[$key]);
				$digit2=substr($thnpenerimaan,-2);
				$digit3=$blnexpire;
				$digit4=substr($thnexpire,-2);
				if(empty($no_batch[$key]))$digit5=$value; else $digit5=$no_batch[$key];
				$format=$digit1.$digit2.$digit3.$digit4.$digit5;
				$qrcode=$digit1.$digit3.$digit4.$digit5;
				$lastbarcode=$this->mpenerimaanapt->getMaxBarcode($digit1.$digit2);
				$barcode=$digit1.$digit2.str_pad($lastbarcode+1,4,"0",STR_PAD_LEFT);
				$hargajual=$harga_beli[$key]+((11/100)*$harga_beli[$key]);

				$urut=$this->mpenerimaanapt->getMaxurut($no_penerimaan);
				$urut=$urut+1;
				$datadetil=array('no_penerimaan'=>$no_penerimaan,
								'urut'=>$urut,
								'kd_unit_apt'=>$kd_unit_apt,
								'kd_obat'=>$value,
								'kd_pabrik'=>$kd_pabrik[$key],
								'kd_milik'=>$kd_milik,
								'tgl_expire'=>convertDate($tgl_expire[$key]),
								'harga_beli'=>$harga_beli[$key],
								'harga_avg'=>$harga_avg[$key],
								'qty_box'=>$qty_box[$key],
								'qty_kcl'=>$qty_kcl[$key],
								'disc_prs'=>$disc_prs[$key],
								'harga_belidisc'=>$harga_belidisc[$key],
								'ppn_item'=>$ppn_item[$key],
								'bonus'=>$bonus[$key],
								'no_pemesanan'=>$no_pemesanan[$key],
								'urut_pesan'=>$urut_pesan,
								'tgl_entry'=>$tgl_entry,
								'update'=>$update[$key],
								'isidiskon'=>$isidiskon[$key],
								'no_batch'=>$no_batch[$key],
								'format'=>$qrcode,
								'barcode'=>$barcode,
								'qrcode'=>$qrcode,
								'kode_sas'=>$kode_sas[$key],
								'harga_pokok'=>$hargajual
								);

				$this->mpenerimaanapt->insert('apt_penerimaan_detail',$datadetil);

				$hargajual=$harga_beli[$key]+((11/100)*$harga_beli[$key]);
				$hargajual=round($hargajual);
				if($this->mpenerimaanapt->cekStok($value,$kd_unit_apt,$tgl,$kd_pabrik[$key],$no_batch[$key],$hargajual)){//kalo datanya ada
					$hargabeli=0;
					$jml_stok=$this->mpenerimaanapt->ambilStok($kd_unit_apt,$value,$tgl,$kd_pabrik[$key],$no_batch[$key],$hargajual);
					$harga_pokok=$this->mpenerimaanapt->ambildistok($kd_unit_apt,$value,$tgl,$kd_pabrik[$key],$no_batch[$key]);
					$sisastok=$jml_stok+$qty_kcl[$key]+$bonus[$key];
					if($update[$key]==1){ //kalo ceklis update HB
						$hargabeli=$harga_beli[$key];
					}
					else{ //kalo ga ceklis update HB
						$hargabeli=$harga_pokok;
					}
					$datastok=array('jml_stok'=>$sisastok,'is_sync'=>0);
					//$obt1=array('harga_pokok'=>$hargabeli);
					$this->mpenerimaanapt->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$kd_unit_apt.'" and kd_obat="'.$value.'" and tgl_expire="'.$tgl.'" and kd_pabrik="'.$kd_pabrik[$key].'" and batch="'.$no_batch[$key].'" and harga_pokok="'.$hargajual.'" ');
					//$this->mpenerimaanapt->update('apt_obat',$obt,'kd_obat="'.$value.'"');
					//$this->mpenerimaanapt->update('apt_stok_unit',$obt1,'kd_obat="'.$value.'"'); //20-01-2018 --> bwt update hb
				}
				else{ //kalo datanya ga ada	
					$hargabeli=0;
					$harga_pokok=$this->mpenerimaanapt->ambildistok1($value);
					$jml_stok=$qty_kcl[$key]+$bonus[$key];
					$hargabeli=$harga_beli[$key];
					$hargajual=$harga_beli[$key]+((11/100)*$harga_beli[$key]);
					$hargajual=round($hargajual);
					$data1=array('kd_unit_apt'=>$kd_unit_apt,
								'kd_obat'=>$value,
								'kd_milik'=>$kd_milik,
								'kd_pabrik'=>$kd_pabrik[$key],
								'batch'=>$no_batch[$key],
								'tgl_expire'=>convertDate($tgl_expire[$key]),
								'harga_pokok'=>$hargajual,
								'format'=>$qrcode,
								'barcode'=>$barcode,
								'qrcode'=>$qrcode,
								'jml_stok'=>$jml_stok);
					$this->mpenerimaanapt->insert('apt_stok_unit',$data1);
				}
				//$updateobat=array('harga_beli'=>$harga_beli[$key]);
				//$this->mpenerimaanapt->update('apt_obat',$updateobat,'kd_obat="'.$value.'"');
				
				$urut_pesan++;
			}
		}

		$this->db->trans_complete();
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['posting']=3;

		$msg['status']=1;
		$msg['keluar']=0;
		if($submit=="simpankeluar"){
			$msg['keluar']=1;
		}
		echo json_encode($msg);
	}

	public function hapuspenerimaan($no_penerimaan=""){
		if(!$this->muser->isAkses("44")){
			$this->restricted();
			return false;
		}
		
		$msg=array();
		$error=0;
		if(empty($no_penerimaan)){
			$msg['pesan']="Pilih Transaksi yang akan di hapus";
			echo "<script>Alert('".$msg['pesan']."')</script>";
		}else{
			$item=$this->mpenerimaanapt->ambilItemDataxx('apt_penerimaan_detail','no_penerimaan="'.$no_penerimaan.'" ');
			if(count($item)>0){
				debugvar('Sdh ada obat, Silahkan hapus dulu obatnya');				
			}
			$this->db->trans_start();
			$this->mpenerimaanapt->delete('apt_penerimaan','no_penerimaan="'.$no_penerimaan.'"');
			$this->db->trans_complete();		
			redirect('/transapotek/aptpenerimaan/');
		}
	}
		
	public function hapusobatpenerimaan($no_penerimaan="",$urut=""){
		if(!$this->muser->isAkses("44")){
			$this->restricted();
			return false;
		}
		
		$msg=array();
		$error=0;
		$item=$this->mpenerimaanapt->ambilItemDataxx('apt_penerimaan_detail','no_penerimaan="'.$no_penerimaan.'" and urut="'.$urut.'"');
		//debugvar($item);
		$queryjual=$this->mpenerimaanapt->ambilItemData('apt_penjualan_detail','kd_unit_apt="'.$item['kd_unit_apt'].'" and kd_obat="'.$item['kd_obat'].'" and kd_pabrik="'.$item['kd_pabrik'].'" and tgl_expire="'.$item['tgl_expire'].'" and harga_pokok="'.$item['harga_pokok'].'" and batch="'.$item['no_batch'].'" ');
		$querydisposal=$this->mpenerimaanapt->ambilItemData('apt_disposal_detail','kd_unit_apt="'.$item['kd_unit_apt'].'" and kd_obat="'.$item['kd_obat'].'" and kd_pabrik="'.$item['kd_pabrik'].'" and tgl_expire="'.$item['tgl_expire'].'" and harga_pokok="'.$item['harga_pokok'].'" and batch="'.$item['no_batch'].'" ');
		if(count($queryjual)>0 || count($querydisposal)>0){
			debugvar('Data sudah ada di penjualan atau disposal. <a href="javascript:history.back()">Kembali</a>');
		}else{
			$this->mpenerimaanapt->delete('apt_stok_unit','kd_unit_apt="'.$item['kd_unit_apt'].'" and kd_obat="'.$item['kd_obat'].'" and kd_pabrik="'.$item['kd_pabrik'].'" and tgl_expire="'.$item['tgl_expire'].'" and harga_pokok="'.$item['harga_pokok'].'" and batch="'.$item['no_batch'].'" ');
			$this->mpenerimaanapt->delete('apt_penerimaan_detail','no_penerimaan="'.$no_penerimaan.'" and urut="'.$urut.'" ');	

		}
		redirect('transapotek/aptpenerimaan/detilpenerimaan/'.$no_penerimaan);
	}
		
	public function ambildaftarobatbynama(){
		$nama_obat=$this->input->post('nama_obat');
		//if(empty($nama_obat))return;
		$harga="apt_obat.harga_dasar";
		$kd_unit=$this->input->post('kd_unit_apt');
		$kd_pabrik=$this->input->post('kd_pabrik');
		if($kd_unit=='D01')
			$harga="apt_obat.harga_beli";
		if($kd_unit=='D02')
			$harga="apt_obat.harga_apbd";
		if($kd_unit=='D03')
			$harga="apt_obat.harga_p3k";
		if($kd_unit=='D04')
			$harga="apt_obat.harga_buffer";
		if($kd_unit=='Dak')
			$harga="apt_obat.harga_dak";
		if($kd_unit=='U01')
			$harga="apt_obat.harga_jpkmm";
		if($kd_unit=='U02')
			$harga="apt_obat.harga_program";
		//die($kd_unit);
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$this->datatables->select('apt_obat.kd_obat as kd_obat1,apt_pabrik.nama_pabrik, replace(apt_obat.nama_obat,"\'","") as nama_obat, apt_satuan_kecil.satuan_kecil,ifnull(apt_stok_unit.harga_pokok,0) as harga,
									"pilihan" as pilihan,apt_obat.pembanding
									',false);
		
		$this->datatables->from("apt_obat");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6","$7")\'>Pilih</a>','kd_obat1,nama_obat,apt_satuan_kecil.satuan_kecil,jml_stok,apt_obat.pembanding,max_stok,'.$harga);
		if(is_numeric($nama_obat)){
			$this->datatables->where('apt_obat.kd_obat in (select kd_obat from obat_barcode where kd_barcode = "'.$nama_obat.'") ');			
		}else {
			//$this->datatables->like('apt_obat.nama_obat',$nama_obat,'both');
			$this->datatables->where('apt_obat.nama_obat like "%'.$nama_obat.'%" or apt_obat.kd_obat in (select kd_obat from obat_barcode where kd_barcode like "%'.$nama_obat.'%") ');
		}
		$this->datatables->where('apt_stok_unit.kd_pabrik',$kd_pabrik);
		
		$this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil','left');
		$this->datatables->join('apt_stok_unit','apt_obat.kd_obat=apt_stok_unit.kd_obat','left');
		$this->datatables->join('apt_pabrik','apt_stok_unit.kd_pabrik=apt_pabrik.kd_pabrik','left');
		//$this->datatables->join('obat_barcode','apt_obat.kd_obat=obat_barcode.kd_obat','left');
		//$this->datatables->join('apt_stok_unit','apt_obat.kd_obat=apt_stok_unit.kd_obat','left');
		//$this->datatables->join('apt_unit','apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt');
		$this->db->group_by('apt_obat.kd_obat');
		$results = $this->datatables->generate();
		//debugvar($results);
		echo ($results);
	}
	
	public function ambildaftarobatbykode(){
		$nama_obat=$this->input->get('query');
		//if(empty($nama_obat))return;
		$harga="apt_obat.harga_dasar";
		$kd_unit=$this->input->post('kd_unit_apt');
		if($kd_unit=='D01')
			$harga="apt_obat.harga_beli";
		if($kd_unit=='D02')
			$harga="apt_obat.harga_apbd";
		if($kd_unit=='D03')
			$harga="apt_obat.harga_p3k";
		if($kd_unit=='D04')
			$harga="apt_obat.harga_buffer";
		if($kd_unit=='Dak')
			$harga="apt_obat.harga_dak";
		if($kd_unit=='U01')
			$harga="apt_obat.harga_jpkmm";
		if($kd_unit=='U02')
			$harga="apt_obat.harga_program";
		//die($kd_unit);
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$this->db->select("apt_obat.kd_obat as kd_obat1, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil,".$harga." as harga_beli,
									'pilihan' as pilihan,apt_obat.pembanding
									",false);
		
		//$this->db->from("apt_obat");
		//$this->db->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6","$7")\'>Pilih</a>','kd_obat1,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,jml_stok,apt_obat.pembanding,max_stok,'.$harga);
		$this->db->where('apt_obat.kd_obat in (select kd_obat from obat_barcode where kd_barcode = "'.$nama_obat.'") ');			
		//$this->datatables->where('apt_stok_unit.kd_unit_apt',$kd_unit);
		
		$this->db->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil','left');
		//$this->datatables->join('obat_barcode','apt_obat.kd_obat=obat_barcode.kd_obat','left');
		//$this->datatables->join('apt_stok_unit','apt_obat.kd_obat=apt_stok_unit.kd_obat','left');
		//$this->datatables->join('apt_unit','apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt');
		//$this->db->group_by('apt_obat.kd_obat');
		$results = $this->db->get('apt_obat');
		$res=$results->result_array();
		//debugvar($results);
		echo json_encode($res);
		//echo ($results);
	}
	
	public function ambilsupplierbykode(){
		$q=$this->input->get('query');
		$items=$this->mpenerimaanapt->ambilData3($q);
		echo json_encode($items);
	}
	
	public function ambilsupplierbynama(){
		$q=$this->input->get('query');
		$items=$this->mpenerimaanapt->ambilData4($q);
		echo json_encode($items);
	}
	
	public function periksapenerimaan() {
		$msg=array();
		$submit=$this->input->post('submit');
		$no_penerimaan=$this->input->post('no_penerimaan');
		$tgl_penerimaan=$this->input->post('tgl_penerimaan');
		$no_faktur=$this->input->post('no_faktur');
		$tgl_faktur=$this->input->post('tgl_faktur');
		$shift=$this->input->post('shift');
		$posting=$this->input->post('posting');
		$lunas=$this->input->post('lunas');
		$tgl_tempo=$this->input->post('tgl_tempo');
		$kd_supplier=$this->input->post('kd_supplier');
		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$materai=$this->input->post('materai');
		$keterangan=$this->input->post('keterangan');
		$jumlah=$this->input->post('jumlah');
		$discount=$this->input->post('discount');
		$discount1=$this->input->post('discount1');
		$sum=$this->input->post('sum');
		
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$tgl=$this->input->post('tgl');
		$tgl_expire=$this->input->post('tgl_expire');
		$pembanding=$this->input->post('pembanding');
		$nama_unit_apt=$this->input->post('nama_unit_apt');
		$milik=$this->input->post('milik');
		$qty_box=$this->input->post('qty_box'); 
		$qty_kcl=$this->input->post('qty_kcl');
		$harga_beli=$this->input->post('harga_beli');
		$harga_avg=$this->input->post('harga_avg');
		$disc_prs=$this->input->post('disc_prs');
		$harga_belidisc=$this->input->post('harga_belidisc');
		$jumlah1=$this->input->post('jumlah1');
		$ppn_item=$this->input->post('ppn_item');
		$isidiskon=$this->input->post('isidiskon');
		$bonus=$this->input->post('bonus');
		$update=$this->input->post('update');
		//$no_batch=$this->input->post('no_batch');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="hapus"){
			if(empty($no_penerimaan)){
				$msg['pesanatas']="Pilih Transaksi yang akan di hapus";
			}else{
				$this->mpenerimaanapt->delete('apt_penerimaan','no_penerimaan="'.$no_penerimaan.'"');
				$this->mpenerimaanapt->delete('apt_penerimaan_detail','no_penerimaan="'.$no_penerimaan.'"');
				$msg['pesanatas']="Data Berhasil Di Hapus";
			}
			$msg['status']=0;
			$msg['clearform']=1;
			echo json_encode($msg);
		}
		else{
			if(empty($kd_supplier)){
				$jumlaherror++;
				$msg['id'][]="kd_supplier";
				$msg['pesan'][]="Supplier Harus di Isi";
			}
			/*if(empty($nama)){
				$jumlaherror++;
				$msg['id'][]="nama";
				$msg['pesan'][]="Supplier Harus di Isi";
			}*/
			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value) {
					# code...
					if(empty($value))continue;					
					if(empty($qty_box[$key])){
						$msg['status']=0;
						$nama=$this->mpenerimaanapt->ambilNama($value);
						$msg['pesanlain'].="Qty B".$nama." tidak boleh Kosong <br/>";					
					}
					if(empty($tgl_expire[$key])){
						$msg['status']=0;
						$nama=$this->mpenerimaanapt->ambilNama($value);
						$msg['pesanlain'].="Tgl. Expire ".$nama." tidak boleh kosong <br/>";					
					}
					/* if(empty($no_batch[$key])){
						$msg['status']=0;
						$nama=$this->mpenerimaanapt->ambilNama($value);
						$msg['pesanlain'].="No. Batch ".$nama." tidak boleh kosong <br/>";					
					} */
					if(empty($harga_beli[$key])){
						$msg['status']=0;
						$nama=$this->mpenerimaanapt->ambilNama($value);
						$msg['pesanlain'].="Harga B".$nama." tidak boleh Kosong <br/>";					
					}
				}
			}
			if($jumlaherror>0){
				$msg['status']=0;
				$msg['error']=$jumlaherror;
				$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
			}
			/*if($this->mpenerimaanapt->isPosted($no_penerimaan) && $submit!="bukatrans"){
				$jumlaherror++;
				$msg['status']=0;
				$msg['pesanatas']="Transaksi ini tidak bisa di Edit atau Hapus,karena sudah di Tutup";
			}*/

		}
		echo json_encode($msg);
	}
	
	public function ambilitem()
	{
		$q=$this->input->get('query');
		$items=$this->mpenerimaanapt->getPenerimaan($q);

		echo json_encode($items);
	}
	
	public function ambilitems()
	{
		$q=$this->input->get('query');
		$items=$this->mpenerimaanapt->getAllDetailPenerimaan($q);

		echo json_encode($items);
	}
	
	public function ambildetilpemesanan()
	{
		$q=$this->input->get('query');
		$q=rtrim($q, ",");
		$itemdetil=$this->mpenerimaanapt->getdetilpemesanan($q);
		echo json_encode($itemdetil);
	}
	
	public function ambilpemesananbykode(){
		$q=$this->input->get('query');
		$tes=$this->input->get('tes');
		$items=$this->mpenerimaanapt->datapesanan($tes,$q);
		echo json_encode($items);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
