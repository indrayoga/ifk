<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Returpenjualanobat extends CI_Controller {
class Returpenjualanobat extends Rumahsakit {

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
		$this->load->model('apotek/mreturpenjualan');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		
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
		if(!$this->muser->isAkses("61")){
			$this->restricted();
			return false;
		}
		
		$no_retur_penjualan='';
		$periodeawal=date('d-m-Y');
		$periodeakhir=date('d-m-Y');
		
		if($this->input->post('no_retur_penjualan')!=''){
			$no_retur_penjualan=$this->input->post('no_retur_penjualan');
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
							'spin.js',
							'main.js');
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		$data=array('no_retur'=>$no_retur_penjualan,
					'periodeawal'=>$periodeawal,
					'periodeakhir'=>$periodeakhir,
					'items'=>$this->mreturpenjualan->ambilDataRetur($no_retur_penjualan,$periodeawal,$periodeakhir));
		//debugvar($data);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/returpenjualanobat/returpenjualanobat',$data);
		$this->load->view('footer',$datafooter);
	}
		
	public function tambahretur(){
		if(!$this->muser->isAkses("62")){
			$this->restricted();
			return false;
		}
		
		$no_retur_penjualan=""; 
		
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
				
		$data=array('no_retur_penjualan'=>'',
					'no_penjualan'=>'',
					'itemtransaksi'=>$this->mreturpenjualan->ambilItemDataTrans($no_retur_penjualan),
					'itemsdetiltransaksi'=>$this->mreturpenjualan->getAllDetailRetur($no_retur_penjualan),
					'itembungkus'=>$this->mreturpenjualan->ambilItemData('sys_setting','key_data="TARIF_PERBUNGKUS"')
					);
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/returpenjualanobat/tambahreturpenjualan',$data);
		$this->load->view('footer',$datafooter);	
	}
	
	public function ubahretur($no_retur_penjualan=""){
		if(!$this->muser->isAkses("63")){
			$this->restricted();
			return false;
		}
		
		if(empty($no_retur_penjualan))return false;
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
		
		$data=array('no_retur_penjualan'=>$no_retur_penjualan,
			'itemtransaksi'=>$this->mreturpenjualan->ambilItemDataTrans($no_retur_penjualan),			
			'itemsdetiltransaksi'=>$this->mreturpenjualan->getAllDetailRetur($no_retur_penjualan),
			'itembungkus'=>$this->mreturpenjualan->ambilItemData('sys_setting','key_data="TARIF_PERBUNGKUS"')
			);
		//debugvar($data);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/returpenjualanobat/tambahreturpenjualan',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function simpanretur(){
		$msg=array();
		$submit=$this->input->post('submit');
		$no_retur_penjualan=$this->input->post('no_retur_penjualan');
		$no_penjualan=$this->input->post('no_penjualan');
		$tgl_penjualan=$this->input->post('tgl_penjualan');
		$tgl_returpenjualan=$this->input->post('tgl_returpenjualan');
		$shiftapt=$this->input->post('shiftapt');
		$resep=$this->input->post('resep');
		$cust_code=$this->input->post('cust_code');
		$customer=$this->input->post('customer');
		$kd_dokter=$this->input->post('kd_dokter');
		$dokter=$this->input->post('dokter');
		$kd_pasien=$this->input->post('kd_pasien');
		$nama_pasien=$this->input->post('nama_pasien');
		$alasan=$this->input->post('alasan');
		$jum_item_obat=$this->input->post('jum_item_obat');
		$total=$this->input->post('total');
		$jam=$this->input->post('jam');
		$jam1=$this->input->post('jam1');
		
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$qty=$this->input->post('qty');
		$qty1=$this->input->post('qty1');
		$harga_jual=$this->input->post('harga_jual');
		$totalgrid=$this->input->post('totalgrid');
		$tgl_expire=$this->input->post('tgl_expire');
		
		$racikan=$this->input->post('racikan');
		$racikan1=$this->input->post('racikan1');
		$adm_resep=$this->input->post('adm_resep');
		$adm_racik=$this->input->post('adm_racik');
		$racikan1=$this->input->post('racikan1');
		$jasabungkus=$this->input->post('jasabungkus');
		
		$this->db->trans_start();
		$shift="1";
		$kd_milik="01";
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$kd_user=$this->session->userdata('id_user'); 
		$msg['no_retur_penjualan']=$no_retur_penjualan;

		if($submit=="tutuptrans"){
			if(empty($no_retur_penjualan))return false;
			$updateretur=array('tutup'=>1);
			$this->mreturpenjualan->update('retur_penjualan',$updateretur,'no_retur_penjualan="'.$no_retur_penjualan.'"');
			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					if(empty($value))continue;
					//$jml_stok_awal=$this->mreturpenjualan->ambilStokAwal($kd_unit_apt,$value);
					$tglexp=convertDate($tgl_expire[$key]);
					$jml_stok_awal=$this->mreturpenjualan->ambilStokAwal($kd_unit_apt,$value,$tglexp);
					$sisastok=$jml_stok_awal+$qty[$key];
					$datastok=array('jml_stok'=>$sisastok);
					//$this->mreturpenjualan->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$kd_unit_apt.'" and kd_obat="'.$value.'"');
					$this->mreturpenjualan->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$kd_unit_apt.'" and kd_obat="'.$value.'" and tgl_expire="'.$tglexp.'"');
				}
			}
			
			$updatepenjualan=array('returapt'=>1);
			$this->mreturpenjualan->update('apt_penjualan',$updatepenjualan,'no_penjualan="'.$no_penjualan.'"');					
			
			$qty1=1;
			$no_pendaftaran=$this->mreturpenjualan->ambilpendaftaran($no_penjualan);
			if(empty($no_pendaftaran)){
				$no_pendaftaran=NULL;
			}
			//debugvar($no_pendaftaran);
			//($this->input->post('no_pendaftaran') != FALSE) ? $this->input->post('no_pendaftaran') : NULL;
			$urut=$this->mreturpenjualan->getMaxUrutPelayanan($no_pendaftaran);
			$tglpelayanan=$this->mreturpenjualan->tanggalpelayanan();
			$kd_jenis_tarif=$this->mreturpenjualan->ambilkodejenistarif($cust_code);
			$kd_pelayanan=$this->mreturpenjualan->ambilkodepelayanan();
			$kd_kelas=$this->mreturpenjualan->ambilkodekelas($no_pendaftaran);
			$tgl_berlaku=$this->mreturpenjualan->ambiltglberlaku($kd_pelayanan);
			$total1=0-($total*$qty1);
			$kodeunitkerja="";			
			$kd_unit_kerja=$this->mreturpenjualan->ambilunit($no_pendaftaran);
			$parent=$this->mreturpenjualan->ambilparent($kd_unit_kerja);
			if($parent==10){
				$unit_kerja="Rawat Jalan"; 
				$kodeunitkerja=$kd_unit_kerja;
			}
			else if($parent==8){
				$unit_kerja="Rawat Inap";
				$kodeunitkerja1=$this->mreturpenjualan->ambilunit1($no_pendaftaran);
				if($kodeunitkerja1==0){$kodeunitkerja=$kd_unit_kerja;}
				else {$kodeunitkerja=$kodeunitkerja1;}
			}
			else{
				if($kd_unit_kerja==1){$unit_kerja="Unit Gawat Darurat";}
				if($kd_unit_kerja==10){$unit_kerja="Rawat Jalan";}
				if($kd_unit_kerja==8){$unit_kerja="Rawat Inap";}
				$kodeunitkerja=$kd_unit_kerja;
			}
			if(!empty($no_pendaftaran) || $no_pendaftaran!=NULL){
				$biaya_pelayanan=array('kd_kasir'=>'','no_pendaftaran'=>$no_pendaftaran,'urut'=>$urut+1,'kd_unit_kerja'=>$kodeunitkerja,'tgl_pelayanan'=>$tglpelayanan,
										'kd_jenis_tarif'=>$kd_jenis_tarif,'kd_pelayanan'=>$kd_pelayanan,'kd_kelas'=>$kd_kelas,'tgl_berlaku'=>$tgl_berlaku,
										'qty'=>$qty1,'harga'=>0-$total,'total'=>$total1,'shift'=>'','kd_unit_kerja_tr'=>$kd_unit_apt,
										'kd_dokter'=>$kd_dokter,'kd_user'=>$kd_user,'cust_code'=>$cust_code,'harga_asli'=>0-$total,'no_transaksiresep'=>$no_retur_penjualan);
				$this->mreturpenjualan->insert('biaya_pelayanan',$biaya_pelayanan);
			}
			$msg['status']=1;
			$msg['posting']=1;
			//$msg['pesan']="Tutup Transaksi Berhasil. Tagihan telah ditransfer ke unit : ".$unit_kerja;
			$this->db->trans_complete();
			$msg['pesan']="Tutup Transaksi Berhasil";
			echo json_encode($msg);
			return false;
		}
		if($submit=="bukatrans"){
			if(empty($no_retur_penjualan))return false;
			$updateretur=array('tutup'=>0);
			$this->mreturpenjualan->update('retur_penjualan',$updateretur,'no_retur_penjualan="'.$no_retur_penjualan.'"');
			$no_pendaftaran=$this->mreturpenjualan->ambilpendaftaran($no_penjualan);
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					if(empty($value))continue;
					$tglexp=convertDate($tgl_expire[$key]);
					//$jml_stok_awal=$this->mreturpenjualan->ambilStokAwal($kd_unit_apt,$value);
					$jml_stok_awal=$this->mreturpenjualan->ambilStokAwal($kd_unit_apt,$value,$tglexp);
					$sisastok=$jml_stok_awal-$qty[$key];
					$datastok=array('jml_stok'=>$sisastok);
					//$this->mreturpenjualan->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$kd_unit_apt.'" and kd_obat="'.$value.'"');					
					$this->mreturpenjualan->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$kd_unit_apt.'" and kd_obat="'.$value.'" and tgl_expire="'.$tglexp.'"');
				}
			}			
			$updatepenjualan=array('returapt'=>0);
			$this->mreturpenjualan->update('apt_penjualan',$updatepenjualan,'no_penjualan="'.$no_penjualan.'"');
			
			$this->mreturpenjualan->delete('biaya_pelayanan','no_transaksiresep="'.$no_retur_penjualan.'" and no_pendaftaran="'.$no_pendaftaran.'"');
			
			$msg['status']=1;
			$msg['posting']=2;
			$msg['pesan']="Buka Transaksi Berhasil";
			$this->db->trans_complete();
			echo json_encode($msg);
			return false;
		}
		if($this->mreturpenjualan->isNumberExist($no_retur_penjualan)){ //edit
			$tgl_returpenjualan1=convertDate($tgl_returpenjualan)." ".$jam1;
		    $datareturedit=array('no_penjualan'=>$no_penjualan,
								'alasan'=>$alasan,
								'kd_unit_apt'=>$kd_unit_apt,
								'cust_code'=>$cust_code,
								'resep'=>$resep,
								'shiftapt'=>$shiftapt,
								'no_resep'=>'',								
								'dokter'=>$dokter,
								'kd_pasien'=>$kd_pasien,
								'nama_pasien'=>$nama_pasien,
								'total'=>$total,
								'jml_item_obat'=>$jum_item_obat,
								//'tgl_returpenjualan'=>convertDate($tgl_returpenjualan)
								'tgl_returpenjualan'=>$tgl_returpenjualan1,
								'adm_racik'=>$adm_racik);
			$this->mreturpenjualan->update('retur_penjualan',$datareturedit,'no_retur_penjualan="'.$no_retur_penjualan.'"');	
			$urut=1;
			$urut_retur=1;
			
			$this->mreturpenjualan->delete('retur_penjualan_detail','no_retur_penjualan="'.$no_retur_penjualan.'"');
			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					if(empty($value))continue;
					$datadetiledit=array('no_retur_penjualan'=>$no_retur_penjualan,
									'urut_retur'=>$urut_retur,
									//'no_penjualan'=>$no_penjualan,
									//'urut'=>$urut,
									'kd_unit_apt'=>$kd_unit_apt,
									'kd_obat'=>$value,
									'kd_milik'=>$kd_milik,
									'tgl_expire'=>convertDate($tgl_expire[$key]),
									'qty'=>$qty[$key],
									'harga_jual'=>$harga_jual[$key],
									'total'=>$totalgrid[$key],
									'racikan'=>$racikan[$key],
									'adm_resep'=>$adm_resep[$key]);
					$this->mreturpenjualan->insert('retur_penjualan_detail',$datadetiledit);
					
					$urut_retur++;
					$urut++;
				}
			}
			$msg['pesan']="Data Berhasil Di Update";
			$msg['posting']=3;
		}
		else { //simpan baru
			$tgl=explode("-", $tgl_returpenjualan);
			$kode=$this->mreturpenjualan->autoNumber($tgl[2],$tgl[1]);
			$kodebaru=$kode+1;
			$kodebaru=str_pad($kodebaru,3,0,STR_PAD_LEFT); 
			$no_retur_penjualan="RET.".$tgl[2].".".$tgl[1].".".$kodebaru;
			$msg['no_retur_penjualan']=$no_retur_penjualan;
			
			$tgl_returpenjualan1=convertDate($tgl_returpenjualan)." ".$jam;
			$dataretur=array('no_retur_penjualan'=>$no_retur_penjualan,
							'no_penjualan'=>$no_penjualan,
							'alasan'=>$alasan,
							'kd_unit_apt'=>$kd_unit_apt,
							'cust_code'=>$cust_code,
							'resep'=>$resep,
							'shiftapt'=>$shiftapt,
							'no_resep'=>'',								
							'dokter'=>$dokter,
							'kd_pasien'=>$kd_pasien,
							'nama_pasien'=>$nama_pasien,
							'total'=>$total,
							'jml_item_obat'=>$jum_item_obat,
							//'tgl_returpenjualan'=>convertDate($tgl_returpenjualan)
							'tgl_returpenjualan'=>$tgl_returpenjualan1,
							'adm_racik'=>$adm_racik);
			
			$this->mreturpenjualan->insert('retur_penjualan',$dataretur);
			$urut_retur=1;
			$urut=1;
			//$total_transaksi=0;
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					# code...
					if(empty($value))continue;					
					$datadetil=array('no_retur_penjualan'=>$no_retur_penjualan,
									'urut_retur'=>$urut_retur,
									//'no_penjualan'=>$no_penjualan,
								//	'urut'=>$urut,
									'kd_unit_apt'=>$kd_unit_apt,
									'kd_obat'=>$value,
									'kd_milik'=>$kd_milik,
									'tgl_expire'=>convertDate($tgl_expire[$key]),
									'qty'=>$qty[$key],
									'harga_jual'=>$harga_jual[$key],
									'total'=>$totalgrid[$key],
									'racikan'=>$racikan[$key],
									'adm_resep'=>$adm_resep[$key]);
					$this->mreturpenjualan->insert('retur_penjualan_detail',$datadetil);	
					$urut_retur++;
					$urut++;				
				}
			}
			$msg['pesan']="Data Berhasil Di Simpan";
			$msg['posting']=3;
		}
		$msg['status']=1;
		$msg['keluar']=0;
		$msg['simpanbayar']=0;
		if($submit=="simpankeluar"){
			$msg['keluar']=1;
		}
		$this->db->trans_complete();
		echo json_encode($msg);
	}
	
	public function hapusretur($no_retur_penjualan=""){
		if(!$this->muser->isAkses("64")){
			$this->restricted();
			return false;
		}
		
		$msg=array();
		$error=0;
		if(empty($no_retur_penjualan)){
			$msg['pesan']="Pilih Transaksi yang akan di hapus";
			echo "<script>Alert('".$msg['pesan']."')</script>";
		}else{
			$this->db->trans_start();
			$this->mreturpenjualan->delete('retur_penjualan','no_retur_penjualan="'.$no_retur_penjualan.'"');
			$this->mreturpenjualan->delete('retur_penjualan_detail','no_retur_penjualan="'.$no_retur_penjualan.'"');			
			$this->db->trans_complete();
			redirect('/transapotek/returpenjualanobat/');
		}
	}
	
	public function ambilpenjualanbykode(){
		$q=$this->input->get('query');
		$items=$this->mreturpenjualan->ambilData3($q);
		echo json_encode($items);
	}

	public function periksaretur() {
		$msg=array();
		$submit=$this->input->post('submit');
		$no_retur_penjualan=$this->input->post('no_retur_penjualan');
		$no_penjualan=$this->input->post('no_penjualan');
		$tgl_penjualan=$this->input->post('tgl_penjualan');
		$tgl_returpenjualan=$this->input->post('tgl_returpenjualan');
		$shiftapt=$this->input->post('shiftapt');
		$resep=$this->input->post('resep');
		$cust_code=$this->input->post('cust_code');
		$customer=$this->input->post('customer');
		$kd_dokter=$this->input->post('kd_dokter');
		$dokter=$this->input->post('dokter');
		$kd_pasien=$this->input->post('kd_pasien');
		$nama_pasien=$this->input->post('nama_pasien');
		$alasan=$this->input->post('alasan');
		$jum_item_obat=$this->input->post('jum_item_obat');
		$total=$this->input->post('total');
		$jam=$this->input->post('jam');
		$jam1=$this->input->post('jam1');
		
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$qty=$this->input->post('qty');
		$qty1=$this->input->post('qty1');
		$harga_jual=$this->input->post('harga_jual');
		$totalgrid=$this->input->post('totalgrid');
		$tgl_expire=$this->input->post('tgl_expire');
		
		$racikan=$this->input->post('racikan');
		$racikan1=$this->input->post('racikan1');
		$adm_resep=$this->input->post('adm_resep');
		$adm_racik=$this->input->post('adm_racik');
		$racikan1=$this->input->post('racikan1');
		$jasabungkus=$this->input->post('jasabungkus');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="hapus"){
			if(empty($no_retur)){
				$msg['pesanatas']="Pilih Transaksi yang akan di hapus";
			}else{
				$this->mreturpenjualan->delete('apt_retur_obat','no_retur="'.$no_retur.'"');
				$this->mreturpenjualan->delete('apt_retur_obat_detail','no_retur="'.$no_retur.'"');
				$msg['pesanatas']="Data Berhasil Di Hapus";
			}
			$msg['status']=0;
			$msg['clearform']=1;
			echo json_encode($msg);
		}
		else{
			/*if(empty($no_penjualan)){
				$jumlaherror++;
				$msg['id'][]="no_penjualan";
				$msg['pesan'][]="No Penjualan Harus di Isi";
			}*/
			if(empty($tgl_returpenjualan)){
				$jumlaherror++;
				$msg['id'][]="tgl_returpenjualan";
				$msg['pesan'][]="Kolom Tanggal Harus di Isi";
			}
			if(empty($no_penjualan)){
				$jumlaherror++;
				$msg['id'][]="no_penjualan";
				$msg['pesan'][]="Nomor penjualan harus di isi";
			}
			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value) {
					# code...
					if(empty($value))continue;
					$nama=$this->mreturpenjualan->ambilNama($value);
					if(empty($qty[$key])){
						$msg['status']=0;
						//$msg['pesanlain'].="Qty ".$value." Tidak boleh Kosong <br/>";					
						$msg['pesanlain'].="Qty ".$nama." Tidak boleh Kosong <br/>";
					}
					if($qty[$key]>$qty1[$key]){
						$msg['status']=0;
						//$msg['pesanlain'].="Periksa kembali inputan Qty. Qty yang diretur tidak boleh lebih besar dari qty penjualan. <br/>";					
						$msg['pesanlain'].="Periksa kembali inputan Qty. Qty ".$nama." yang diretur tidak boleh lebih besar dari qty penjualan. <br/>";
					}					
				}
			}
			if($jumlaherror>0){
				$msg['status']=0;
				$msg['error']=$jumlaherror;
				$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
			}
		}
		echo json_encode($msg);
	}
	
	public function ambildetilpenjualan()
	{
		$q=$this->input->get('query');
		$items=$this->mreturpenjualan->getdetilpenjualan($q);
		echo json_encode($items);
	}
	
	public function ambilitem()
	{
		$q=$this->input->get('query');
		//$items=$this->mreturpenjualan->getRetur($q);
		$items=$this->mreturpenjualan->ambilItemDataTrans1($q);
		echo json_encode($items);
	}
	
	public function ambilitems()
	{
		$q=$this->input->get('query');
		$items=$this->mreturpenjualan->getAllDetailRetur($q);
		echo json_encode($items);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
