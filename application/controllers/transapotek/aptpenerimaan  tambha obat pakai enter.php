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

	protected $title='SIM RS - Sistem Informasi Rumah Sakit';

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
				
		$sum=$this->mpenerimaanapt->ambilHarga();
		$kd_applogin=$this->mpenerimaanapt->ambilApp();
		$data=array('no_penerimaan'=>'',
					'datasupplier'=>$this->mpenerimaanapt->ambilData('apt_supplier'),
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
		$data=array(		'datasupplier'=>$this->mpenerimaanapt->ambilData('apt_supplier'),
					'sumberdana'=>$this->mpenerimaanapt->sumberdana(),
					'no_penerimaan'=>$no_penerimaan,
					'sum'=>$sum,
					'itemsdetiltransaksi'=>$this->mpenerimaanapt->getAllDetailPenerimaan($no_penerimaan),
					'itemtransaksi'=>$this->mpenerimaanapt->ambilItemData($no_penerimaan),
					'itemharga'=>$this->mpenerimaanapt->ambilHarga(),
					'kd_applogin'=>$kd_applogin);
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/penerimaan/tambahpenerimaanapt',$data);
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
		
		
		$tgl_history=$tgl_log." ".$jam_log;
		
		
		if($submit=="tutuptrans"){
			$jamhis=date('h:i:s');
			$tglhis=date('Y-m-d');
			$waktu_history=$tglhis." ".$jam_penerimaan;
			//debugvar($waktu_history);
			$kode=$this->mpenerimaanapt->nomor();
			$nomor=$kode+1;
			$datalogtutup=array('nomor'=>$nomor,
						//'tgl'=>$tgl_history,
						'tgl'=>$waktu_history,
						'no_penerimaan'=>$no_penerimaan,
						//'alasan'=>$alasan,
						'alasan'=>'-',
						'kd_user'=>$kd_user,
						'jenis'=>"T");
			//debugvar($datalogtutup);
			$this->mpenerimaanapt->insert('apt_log_penerimaan',$datalogtutup);
			
			if(empty($no_penerimaan))return false;
			$updatepenerimaan=array('posting'=>1);
			$this->mpenerimaanapt->update('apt_penerimaan',$updatepenerimaan,'no_penerimaan="'.$no_penerimaan.'"');			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					$tgl=convertDate($tgl_expire[$key]);
					if($this->mpenerimaanapt->cekStok($value,$kd_unit_apt,$tgl)){//kalo datanya ada
						$hargabeli=0;
						$jml_stok=$this->mpenerimaanapt->ambilStok($kd_unit_apt,$value,$tgl);
						$harga_pokok=$this->mpenerimaanapt->ambildistok($kd_unit_apt,$value,$tgl);
						$sisastok=$jml_stok+$qty_kcl[$key]+$bonus[$key];
						if($update[$key]==1){ //kalo ceklis update HB
							//$hargabelidisc=0; $hargadisc=0;
							if($harga_belidisc[$key]==''){$hargabelidisc=0;}
							else{$hargabelidisc=$harga_belidisc[$key];}
							
							if($isidiskon[$key]==''){$hargadisc=0;}
							else{$hargadisc=$isidiskon[$key];}
							
							if($disc_prs[$key]==''){$diskon=0;}
							else{$diskon=$disc_prs[$key];}
							
							if($hargabelidisc!=0){ //kalo pake diskon persen
								$hbdisk=$harga_beli[$key]-($harga_beli[$key]*($diskon/100));
								$hargabeli=$hbdisk+($hbdisk*($ppn_item[$key]/100));
							}
							else if($hargadisc!=0){ //kalo pake diskon bukan persen
								$hbdisk=($harga_beli[$key]*$qty_kcl[$key])-$hargadisc;
								$hbdiskppn=$hbdisk+($hbdisk*($ppn_item[$key]/100));
								$hargabeli=$hbdiskppn/100;
							}
							else{
								$hargabeli=$harga_beli[$key];
							}
						}
						else{ //kalo ga ceklis update HB
							$hargabeli=$harga_pokok;
						}
						$datastok=array('harga_pokok'=>$hargabeli,'jml_stok'=>$sisastok);
						//$obt=array('harga_beli'=>$harga_beli[$key]);
						$obt=array('harga_beli'=>$hargabeli,
									'harga_dasar'=>$harga_beli[$key]);
						$obt1=array('harga_pokok'=>$hargabeli);
						$this->mpenerimaanapt->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$kd_unit_apt.'" and kd_obat="'.$value.'" and tgl_expire="'.$tgl.'"');
						//$this->mpenerimaanapt->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$kd_unit_apt.'" and kd_obat="'.$value.'"');
						//$this->mpenerimaanapt->update('apt_stok_unit',$datastok,'kd_obat="'.$value.'"');
						$this->mpenerimaanapt->update('apt_obat',$obt,'kd_obat="'.$value.'"');
						$this->mpenerimaanapt->update('apt_stok_unit',$obt1,'kd_obat="'.$value.'"'); //20-01-2018 --> bwt update hb
					}
					else{ //kalo datanya ga ada	
						$hargabeli=0;
						$harga_pokok=$this->mpenerimaanapt->ambildistok1($value);
						$jml_stok=$qty_kcl[$key]+$bonus[$key];
						if($harga_belidisc[$key]==''){$hargabelidisc=0;}
						else{$hargabelidisc=$harga_belidisc[$key];}
						
						if($isidiskon[$key]==''){$hargadisc=0;}
						else{$hargadisc=$isidiskon[$key];}
						
						if($disc_prs[$key]==''){$diskon=0;}
						else{$diskon=$disc_prs[$key];}
						
						if($hargabelidisc!=0){ //kalo pake diskon persen
							//total=(parseFloat(qtyk)*parseFloat(hargabeli))-parseFloat(hargabelidisc);
							$hbdisk=$harga_beli[$key]-($harga_beli[$key]*($diskon/100));
							$hargabeli=$hbdisk+($hbdisk*($ppn_item[$key]/100));
						}
						else if($hargadisc!=0){ //kalo pake diskon bukan persen
							//total=(parseFloat(qtyk)*parseFloat(hargabeli))-parseFloat(hargadisc);
							$hbdisk=($harga_beli[$key]*$qty_kcl[$key])-$hargadisc;
							$hbdiskppn=$hbdisk+($hbdisk*($ppn_item[$key]/100));
							$hargabeli=$hbdiskppn/100;
						}
						else{
							//total=(parseFloat(qtyk)*parseFloat(hargabeli));
							$hargabeli=$harga_beli[$key];
						}
						$data1=array('kd_unit_apt'=>$kd_unit_apt,
									'kd_obat'=>$value,
									'kd_milik'=>$kd_milik,
									'tgl_expire'=>convertDate($tgl_expire[$key]),
									//'harga_pokok'=>$harga_beli[$key],
									'harga_pokok'=>$hargabeli,
									'jml_stok'=>$jml_stok);
						$this->mpenerimaanapt->insert('apt_stok_unit',$data1);
						$obt=array('harga_beli'=>$hargabeli,
									'harga_dasar'=>$harga_beli[$key]);
						$this->mpenerimaanapt->update('apt_obat',$obt,'kd_obat="'.$value.'"');
					}
					
					if($no_pemesanan[$key]!=''){
						$data4=array('jml_penerimaan'=>$qty_kcl[$key]);
						//$this->mpenerimaanapt->update('apt_pemesanan_detail',$data4,'kd_obat="'.$value.'" and no_pemesanan="'.$no_pemesanan[$key].'"'); //update jmlpenerimaan ke tabel pemesanan
						$this->mpenerimaanapt->updatepemesanan($qty_kcl[$key],'kd_obat="'.$value.'" and no_pemesanan="'.$no_pemesanan[$key].'"');
						$no_grouping=$this->mpenerimaanapt->nogrouping($no_pemesanan[$key]);
						if($no_grouping!='-'){
							$urut_grouping=$this->mpenerimaanapt->urutgrouping($no_grouping,$kd_supplier,$value);
							if($urut_grouping!='-'){
								$this->mpenerimaanapt->update('apt_grouping_pengajuan_det',$data4,'no_grouping="'.$no_grouping.'" and urut_grouping="'.$urut_grouping.'"'); //update jmlpenerimaan ke tabel detil grouping
							}
						}
					}
					
					$databatch=array('no_batch'=>$no_batch[$key]);
					$this->mpenerimaanapt->update('apt_obat',$databatch,'kd_obat="'.$value.'"'); 
				}//akhir foreach
			}
			
			$this->db->trans_complete();
			$msg['status']=1;
			$msg['posting']=1;
			$msg['pesan']="Tutup Transaksi Berhasil";
			echo json_encode($msg);
			return false;
		}
		//if($submit=="bukatrans"){
		if($submit=="simpanbuka"){
		
			$kode=$this->mpenerimaanapt->nomor();
			$nomor=$kode+1;
			$datalogbuka=array('nomor'=>$nomor,
						'tgl'=>$tgl_history,
						'no_penerimaan'=>$no_penerimaan,
						'alasan'=>$alasan,
						'kd_user'=>$kd_user,
						'jenis'=>"B");
			$this->mpenerimaanapt->insert('apt_log_penerimaan',$datalogbuka);			
			
			if(empty($no_penerimaan))return false;
			$updatepenerimaan=array('posting'=>0);
			$this->mpenerimaanapt->update('apt_penerimaan',$updatepenerimaan,'no_penerimaan="'.$no_penerimaan.'"');
			
			$items=$this->mpenerimaanapt->getAllDetailPenerimaan($no_penerimaan);
			foreach($items as $itemdetil){
				$kode=$itemdetil['kd_obat'];
				$kiteyekcl=$itemdetil['qty_kcl']; //bwt ngembaliin stok awalnya, dy dikurang dulu
				$tglexpire=convertDate($itemdetil['tgl_expire']);
				$bonus1=$itemdetil['bonus'];
				$nopemesanan=$itemdetil['no_pemesanan'];
				//debugvar($tglexpire);
				$jml_stok=$this->mpenerimaanapt->ambilStok($kd_unit_apt,$kode,$tglexpire);
				$stokakhir=$jml_stok-$kiteyekcl-$bonus1;
				$datastoka=array('jml_stok'=>$stokakhir);
				$this->mpenerimaanapt->update('apt_stok_unit',$datastoka,'kd_unit_apt="'.$kd_unit_apt.'" and kd_obat="'.$kode.'" and tgl_expire="'.$tglexpire.'"');

				//if($no_pemesanan[$key]!=''){
				if($nopemesanan!=''){
					//$data4=array('jml_penerimaan'=>$qty_kcl[$key]);
					$data4=array('jml_penerimaan'=>'0');
// edit by rian : Sisa Pesanan = jumlah Pesanan + jumlah buka transaksi 

					$query=$this->db->query('update apt_pemesanan_detail set jml_penerimaan = jml_penerimaan -'.$kiteyekcl.' where '.'kd_obat="'.$kode.'" and no_pemesanan="'.$nopemesanan.'"');

					//$this->mpenerimaanapt->update('apt_pemesanan_detail',$data4,'kd_obat="'.$kode.'" and no_pemesanan="'.$nopemesanan.'"'); //update jmlpenerimaan ke tabel pemesanan
					$no_grouping=$this->mpenerimaanapt->nogrouping($nopemesanan);
					if($no_grouping!='-'){
						$urut_grouping=$this->mpenerimaanapt->urutgrouping($no_grouping,$kd_supplier,$kode);
						if($urut_grouping!='-'){
							$this->mpenerimaanapt->update('apt_grouping_pengajuan_det',$data4,'no_grouping="'.$no_grouping.'" and urut_grouping="'.$urut_grouping.'"'); //update jmlpenerimaan ke tabel detil grouping
						}
					}
				}
			}
			$this->db->trans_complete();
			$msg['status']=1;
			$msg['posting']=2;
			$msg['pesan']="Buka Transaksi Berhasil";
			echo json_encode($msg);
			return false;
		}
		/*if($submit=="approval"){
			$now=date('d-m-Y');
			$tgl=explode("-", $now);
			$kode=$this->mpenerimaanapt->autoNumber1($tgl[2],$tgl[1]);
			$kodebaru=$kode+1;
			$kodebaru=str_pad($kodebaru,4,0,STR_PAD_LEFT); 
			$apf_number=substr($tgl[2],2,2)."".$tgl[1]."".$kodebaru;
			$vend_code=$this->mpenerimaanapt->ambilvendor($kd_supplier);
			$due_date=$this->mpenerimaanapt->tanggaltempo($now);
			$datafaktur=array('apf_number'=>$apf_number,
							'apf_date'=>convertDate($now),
							'vend_code'=>$vend_code,
							'amount'=>$jumlah,
							'posted'=>0,
							'due_date'=>$due_date,
							'notes'=>$keterangan,
							'reff'=>$no_faktur);			
			$this->mpenerimaanapt->insert('acc_ap_faktur',$datafaktur);
			
			$account=$this->mpenerimaanapt->ambilaccount($vend_code);
			$datadetil1=array('ap_number'=>$apf_number,
							'ap_date'=>convertDate($now),
							'line'=>1,
							'account'=>$account,
							'description'=>'Hutang Obat',
							'value'=>$jumlah,
							'is_debit'=>1,
							'posted'=>0);
			$this->mpenerimaanapt->insert('acc_ap_detail',$datadetil1);
			
			$account1=$this->mpenerimaanapt->ambilaccount1();
			$datadetil2=array('ap_number'=>$apf_number,
							'ap_date'=>convertDate($now),
							'line'=>2,
							'account'=>$account1,
							'description'=>'Hutang Obat',
							'value'=>$jumlah,
							'is_debit'=>0,
							'posted'=>0);
			$this->mpenerimaanapt->insert('acc_ap_detail',$datadetil2);
			
			$msg['status']=1;
			$msg['posting']=3;
			$msg['pesan']="Approval berhasil";
			echo json_encode($msg);
			return false;
		}*/
		
		if($submit=="approval"){
			$now=date('d-m-Y');
			$tgl=explode("-", $now);
			$kode=$this->mpenerimaanapt->autoNumber1($tgl[2],$tgl[1]);
			$kodebaru=$kode+1;
			$kodebaru=str_pad($kodebaru,4,0,STR_PAD_LEFT); 
			$apf_number=substr($tgl[2],2,2)."".$tgl[1]."".$kodebaru;
			$vend_code=$this->mpenerimaanapt->ambilvendor($kd_supplier);
			$due_date=$this->mpenerimaanapt->tanggaltempo($now);
			$datafaktur=array('apf_number'=>$apf_number,
							'apf_date'=>convertDate($now),
							'vend_code'=>$vend_code,
							'amount'=>$jumlah,
							'posted'=>0,
							'due_date'=>$due_date,
							'notes'=>$keterangan,
							'reff'=>$no_faktur);			
			$this->mpenerimaanapt->insert('acc_ap_faktur',$datafaktur);
			
			$account=$this->mpenerimaanapt->ambilaccount($vend_code);
			$datadetil1=array('apf_number'=>$apf_number,
							'line'=>1,
							'description'=>'Hutang Obat',
							'value'=>$jumlah,
							'is_debit'=>1,
							'account'=>$account);
			//$this->mpenerimaanapt->insert('acc_ap_detail',$datadetil1);
			$this->mpenerimaanapt->insert('acc_apfak_detail',$datadetil1);
			
			$account1=$this->mpenerimaanapt->ambilaccount1();
			$datadetil2=array('apf_number'=>$apf_number,
							'line'=>2,
							'description'=>'Hutang Obat',
							'value'=>$jumlah,
							'is_debit'=>0,
							'account'=>$account1);
			//$this->mpenerimaanapt->insert('acc_ap_detail',$datadetil2);
			$this->mpenerimaanapt->insert('acc_apfak_detail',$datadetil2);
			
			$updatepenerimaan=array('is_approve'=>1);
			$this->mpenerimaanapt->update('apt_penerimaan',$updatepenerimaan,'no_penerimaan="'.$no_penerimaan.'"');
			
			$this->db->trans_complete();
			$msg['status']=1;
			$msg['posting']=3;
			$msg['pesan']="Approval berhasil";
			echo json_encode($msg);
			return false;
		}
		if($submit=="unapprove"){
			$updatepenerimaan=array('is_approve'=>0);
			$this->mpenerimaanapt->update('apt_penerimaan',$updatepenerimaan,'no_penerimaan="'.$no_penerimaan.'"');
			
			$this->mpenerimaanapt->delete('acc_ap_faktur','apf_number="'.$apf_number1.'"');
			$this->mpenerimaanapt->delete('acc_apfak_detail','apf_number="'.$apf_number1.'"');
			
			$this->db->trans_complete();
			$msg['status']=1;
			$msg['posting']=4;
			$msg['pesan']="Batal Approval berhasil";
			echo json_encode($msg);
			return false;
		}
		
		if($this->mpenerimaanapt->isNumberExist($no_penerimaan)){ //edit
			$tgl_penerimaan1=convertDate($tgl_penerimaan)." ".$jam_penerimaan1;
		    $datapenerimaanedit=array('shift'=>$shift,
									'kd_unit_apt'=>$kd_unit_apt,
									'kd_supplier'=>$kd_supplier,
									'no_faktur'=>$no_faktur,
									'tgl_faktur'=>convertDate($tgl_faktur),
									//'tgl_penerimaan'=>convertDate($tgl_penerimaan),
									'tgl_penerimaan'=>$tgl_penerimaan1,
									'posting'=>$posting,
									'jumlah'=>$jumlah,
									'materai'=>$materai,
									'tgl_tempo'=>convertDate($tgl_tempo),
									'lunas'=>$lunas,
									//'retur'=>0,
									'keterangan'=>$keterangan,
									'discount'=>$discount1,
									'kd_user'=>$kd_user);
				
			$this->mpenerimaanapt->update('apt_penerimaan',$datapenerimaanedit,'no_penerimaan="'.$no_penerimaan.'"');
			$urut=1;
			$urut_pesan=1;
		
			$this->mpenerimaanapt->delete('apt_penerimaan_detail','no_penerimaan="'.$no_penerimaan.'"');
			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					if(empty($value))continue;
					if($no_pemesanan[$key]==''){$urut_pesan='';}
					$datadetiledit=array('no_penerimaan'=>$no_penerimaan,'urut'=>$urut,'kd_unit_apt'=>$kd_unit_apt,
						'kd_obat'=>$value,'kd_milik'=>$kd_milik,'tgl_expire'=>convertDate($tgl_expire[$key]),
						'harga_beli'=>$harga_beli[$key],'harga_avg'=>$harga_avg[$key],'qty_box'=>$qty_box[$key],'qty_kcl'=>$qty_kcl[$key],'disc_prs'=>$disc_prs[$key],
						'harga_belidisc'=>$harga_belidisc[$key],'ppn_item'=>$ppn_item[$key],'bonus'=>$bonus[$key],'no_pemesanan'=>$no_pemesanan[$key],'urut_pesan'=>$urut_pesan,
						'tgl_entry'=>$tgl_entry,'update'=>$update[$key],'isidiskon'=>$isidiskon[$key],'no_batch'=>$no_batch[$key]);
					$this->mpenerimaanapt->insert('apt_penerimaan_detail',$datadetiledit);
					
					//$updateobat=array('harga_beli'=>$harga_beli[$key]);
					//$this->mpenerimaanapt->update('apt_obat',$updateobat,'kd_obat="'.$value.'"');		
					
					$urut++;
					$urut_pesan++;
				}
			}
			$datatotal=array('jumlah'=>$jumlah);
			$this->mpenerimaanapt->update('apt_penerimaan',$datatotal,'no_penerimaan="'.$no_penerimaan.'"');		

			$this->db->trans_complete();
			$msg['pesan']="Data Berhasil Di Update";
			$msg['posting']=3;
		}else { //simpan baru
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
									'kd_user'=>$kd_user);
			
			$this->mpenerimaanapt->insert('apt_penerimaan',$datapenerimaan);
			$urut=1;
			$urut_pesan=1;
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					# code...
					if(empty($value))continue;	
					if($no_pemesanan[$key]==''){$urut_pesan='';}
					$datadetil=array('no_penerimaan'=>$no_penerimaan,
									'urut'=>$urut,
									'kd_unit_apt'=>$kd_unit_apt,
									'kd_obat'=>$value,
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
									'no_batch'=>$no_batch[$key]);

					$this->mpenerimaanapt->insert('apt_penerimaan_detail',$datadetil);

					//$updateobat=array('harga_beli'=>$harga_beli[$key]);
					//$this->mpenerimaanapt->update('apt_obat',$updateobat,'kd_obat="'.$value.'"');
					
					$urut++;
					$urut_pesan++;
				}
			}
			$datatotal=array('jumlah'=>$jumlah);
			$this->mpenerimaanapt->update('apt_penerimaan',$datatotal,'no_penerimaan="'.$no_penerimaan.'"');

			$this->db->trans_complete();
			$msg['pesan']="Data Berhasil Di Simpan";
			$msg['posting']=3;
		}
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
			$this->db->trans_start();
			$this->mpenerimaanapt->delete('apt_penerimaan','no_penerimaan="'.$no_penerimaan.'"');
			$this->mpenerimaanapt->delete('apt_penerimaan_detail','no_penerimaan="'.$no_penerimaan.'"');	
			$this->db->trans_complete();		
			redirect('/transapotek/aptpenerimaan/');
		}
	}
		
	public function ambildaftarobatbynama(){
		$nama_obat=$this->input->post('nama_obat');
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
		$this->datatables->select("apt_obat.kd_obat as kd_obat1, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil,".$harga.",
									sum(ifnull( substring_index( apt_stok_unit.jml_stok, '.', 1 ) , 0 ) ) AS jml_stok,'pilihan' as pilihan,apt_obat.pembanding,									
									(select if( count(kd_obat)>0, max_stok, 0 ) from apt_setting_obat where kd_obat=kd_obat1 and kd_unit_apt='$kd_unit') as max_stok
									",false);
		
		$this->datatables->from("apt_obat");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6","$7")\'>Pilih</a>','kd_obat1,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,jml_stok,apt_obat.pembanding,max_stok,'.$harga);
		if(!empty($nama_obat))$this->datatables->like('apt_obat.nama_obat',$nama_obat,'both');
		
		$this->datatables->where('apt_stok_unit.kd_unit_apt',$kd_unit);
		
		$this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil','left');
		$this->datatables->join('apt_stok_unit','apt_obat.kd_obat=apt_stok_unit.kd_obat','left');
		$this->datatables->join('apt_unit','apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt');
		$this->db->group_by('apt_obat.kd_obat');
		$results = $this->datatables->generate();
		//debugvar($results);
		echo ($results);
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
		$no_batch=$this->input->post('no_batch');
		
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
			if(empty($nama)){
				$jumlaherror++;
				$msg['id'][]="nama";
				$msg['pesan'][]="Supplier Harus di Isi";
			}
			
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
					if(empty($no_batch[$key])){
						$msg['status']=0;
						$nama=$this->mpenerimaanapt->ambilNama($value);
						$msg['pesanlain'].="No. Batch ".$nama." tidak boleh kosong <br/>";					
					}
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
