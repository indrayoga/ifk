<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Aptgrouping extends CI_Controller {
class Aptgrouping extends Rumahsakit {

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
		$this->load->model('apotek/mgrouping');
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
		if(!$this->muser->isAkses("33")){
			$this->restricted();
			return false;
		}
		
		$no_grouping='';
		$periodeawal=date('d-m-Y');
		$periodeakhir=date('d-m-Y');
		
		if($this->input->post('no_grouping')!=''){
			$no_grouping=$this->input->post('no_grouping');
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
							'lib/bootstrap-timepicker.js',
							'lib/bootstrap-inputmask.js',
							'spin.js',
							'main.js');
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		$data=array('no_grouping'=>$no_grouping,
					'periodeawal'=>$periodeawal,
					'periodeakhir'=>$periodeakhir,
					'items'=>$this->mgrouping->ambilDataGrouping($no_grouping,$periodeawal,$periodeakhir));
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/grouping/aptgrouping',$data);
		$this->load->view('footer',$datafooter);
	}
		
	public function tambahgrouping(){
		if(!$this->muser->isAkses("34")){
			$this->restricted();
			return false;
		}
		
		$kode=""; $no_grouping="";
		
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
							'lib/bootstrap-timepicker.js',
							'lib/bootstrap-inputmask.js',
							'lib/bootstrap-modal.js',
							'spin.js',
							'main.js');
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		
		$data=array('no_grouping'=>'',	
					'itemsdetiltransaksi'=>$this->mgrouping->getPengajuanDetil(),
					//'itemtransaksi'=>$this->mgrouping->ambilItemData('apt_grouping_pengajuan','no_grouping="'.$no_grouping.'"'),
					'itemtransaksi'=>$this->mgrouping->ItemGrouping($no_grouping),
					'items'=>$this->mgrouping->ambilDataGrouping('','',''),
					'supplier'=>$this->mgrouping->ambilData('apt_supplier'));
		//debugvar($data);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/grouping/tambahgrouping',$data);
		$this->load->view('footer',$datafooter);	
	}
	
	public function ubahgrouping($no_grouping=""){
		if(!$this->muser->isAkses("35")){
			$this->restricted();
			return false;
		}
		
		if(empty($no_grouping))return false;
		
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
			'no_grouping'=>$no_grouping,
			//'itemtransaksi'=>$this->mgrouping->ambilItemData('apt_grouping_pengajuan','no_grouping="'.$no_grouping.'"'),
			'itemtransaksi'=>$this->mgrouping->ItemGrouping($no_grouping),
			'itemsdetiltransaksi'=>$this->mgrouping->getPengajuanDetil1($no_grouping),
			'items'=>$this->mgrouping->ambilDataGrouping('','',''),
			'supplier'=>$this->mgrouping->ambilData('apt_supplier')
		);
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/grouping/tambahgrouping',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function simpangrouping(){
		$msg=array();
		$submit=$this->input->post('submit');
		$no_grouping=$this->input->post('no_grouping');
		$tgl_grouping=$this->input->post('tgl_grouping');
		$keterangan=$this->input->post('keterangan');
		
		$kd_supplier=$this->input->post('kd_supplier');
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$qty_kcl=$this->input->post('qty_kcl');
		$harga_beli=$this->input->post('harga_beli');
		$tgl_entry=$this->input->post('tgl_entry');
		$jam_grouping=$this->input->post('jam_grouping');
		$jam_grouping1=$this->input->post('jam_grouping1');
		$kd=$this->input->post('kd');
		//$kd_user=$this->session->userdata('id_user'); 
		$msg['no_grouping']=$no_grouping;
		$msg['posting']=0;
		
		//debugvar($submit);
		if($submit=="simpan"){
			if($this->mgrouping->isNumberExist($no_grouping)){ //edit
				$tgl_grouping1=convertDate($tgl_grouping)." ".$jam_grouping1;
				$datagrup=array(//'tgl_grouping'=>convertDate($tgl_grouping),
								'tgl_grouping'=>$tgl_grouping1,
								'keterangan'=>$keterangan,
								'status_pesan'=>0);
					
				$this->mgrouping->update('apt_grouping_pengajuan',$datagrup,'no_grouping="'.$no_grouping.'"');
				$this->mgrouping->delete('apt_grouping_pengajuan_det','no_grouping="'.$no_grouping.'"');			
				
				$urut=1;
				if(!empty($kd_obat)){
					foreach ($kd_obat as $key => $value){
						# code...
						if(empty($value))continue;
						$datadetil=array('no_grouping'=>$no_grouping,
										'urut_grouping'=>$urut,
										'kd_supplier'=>$kd_supplier[$key],
										'kd_obat'=>$value,
										'qty_kcl'=>$qty_kcl[$key],
										'harga_beli'=>$harga_beli[$key]);
						$this->mgrouping->insert('apt_grouping_pengajuan_det',$datadetil);													
						$urut++;					
					}
				}
				$msg['pesan']="Data Berhasil Di Update";
				//$msg['posting']=3;
			}
			else { //simpan baru GRP201401.00001
				$tgl=explode("-", $tgl_grouping);
				$kode=$this->mgrouping->autoNumber($tgl[2],$tgl[1]);
				$kodebaru=$kode+1;
				$kodebaru=str_pad($kodebaru,5,0,STR_PAD_LEFT); 
				$no_grouping="GRP".$tgl[2]."".$tgl[1].".".$kodebaru;
				$msg['no_grouping']=$no_grouping;
				$tgl_grouping1=convertDate($tgl_grouping)." ".$jam_grouping;
				$datagrup=array('no_grouping'=>$no_grouping,
								//'tgl_grouping'=>convertDate($tgl_grouping),
								'tgl_grouping'=>$tgl_grouping1,
								'keterangan'=>$keterangan,
								'status_pesan'=>0);
				
				$this->mgrouping->insert('apt_grouping_pengajuan',$datagrup);
				$urut=1;
				if(!empty($kd_obat)){
					foreach ($kd_obat as $key => $value){
						# code...
						if(empty($value))continue;
						$datadetil=array('no_grouping'=>$no_grouping,
										'urut_grouping'=>$urut,
										'kd_supplier'=>$kd_supplier[$key],
										'kd_obat'=>$value,
										'qty_kcl'=>$qty_kcl[$key],
										'harga_beli'=>$harga_beli[$key],
										'jml_penerimaan'=>0);
						$this->mgrouping->insert('apt_grouping_pengajuan_det',$datadetil);													
						$urut++;
						
					}
				}
				$group=array('is_grouping'=>1);
				$this->mgrouping->update('apt_pengajuan',$group,'is_grouping="0"');
				
				$msg['pesan']="Data Berhasil Di Simpan";
			}
			$msg['posting']=3;
			$msg['keluar']=0;
		}
		if($submit=="buatpesanan"){
			if($kd=='1'){
				//debugvar('1---> ok jawabannya');
				$supplier=$this->mgrouping->getAllSupplier($no_grouping);
				foreach($supplier as $supp){
					$kd_supp=$supp['kd_supplier'];
					
					$jambuat=$this->mgrouping->jamsekarang();
					$tglbuat=$this->mgrouping->tglsekarang();
					//$tglpesan=convertDate($tgl_grouping)." ".$jambuat;
					$tglpesan=convertDate($tglbuat)." ".$jambuat;
					//$tgl=explode("-", $tgl_grouping);
					$tgl=explode("-", $tglbuat);
					$kode=$this->mgrouping->autoNumberPemesanan($tgl[2],$tgl[1]);
					$kodebaru=$kode+1;
					$kodebaru=str_pad($kodebaru,4,0,STR_PAD_LEFT); 
					$no_pemesanan="PM.".$tgl[2].".".$tgl[1].".".$kodebaru;
					
					$obat=$this->mgrouping->ambilObat($no_grouping,$kd_supp);
					$urutobat=1;
					foreach($obat as $obt){
						$kodeobat=$obt['kd_obat'];
						$kiteye=$obt['qty_kcl'];
						$hb=$obt['harga_beli'];
						$ppn=10;					
						$dataobat=array('no_pemesanan'=>$no_pemesanan,
										'urut'=>$urutobat,
										'kd_obat'=>$kodeobat,
										'qty_box'=>$kiteye,
										'qty_kcl'=>$kiteye,
										'harga_beli'=>$hb,
										'diskon'=>0,
										'ppn'=>$ppn,
										'jml_penerimaan'=>0);
						$this->mgrouping->insert('apt_pemesanan_detail',$dataobat);
						$urutobat++;
					}
					$datapesan=array('no_pemesanan'=>$no_pemesanan,
									'kd_supplier'=>$kd_supp,
									//'tgl_pemesanan'=>convertDate($tgl_grouping),
									'tgl_pemesanan'=>$tglpesan,
									'keterangan'=>'-',
									//'tgl_tempo'=>convertDate($tgl_grouping),
									'tgl_tempo'=>convertDate($tglbuat),
									'status_approve'=>0,
									'no_grouping'=>$no_grouping);
					$this->mgrouping->insert('apt_pemesanan',$datapesan);
				}
				$sta=array('status_pesan'=>1);
				$this->mgrouping->update('apt_grouping_pengajuan',$sta,'no_grouping="'.$no_grouping.'"');
				
				$msg['pesan']="Pemesanan berhasil disimpan ";
				$msg['posting']=3;
			}
			/*else{
				debugvar('0---> cancel jawabannya');
			}*/
			/**/
		}
		$msg['status']=1;
		echo json_encode($msg);
	}

	public function hapusgrouping($no_grouping=""){
		if(!$this->muser->isAkses("36")){
			$this->restricted();
			return false;
		}
		
		$msg=array();
		$error=0;		
		$this->mgrouping->delete('apt_grouping_pengajuan','no_grouping="'.$no_grouping.'"');
		$this->mgrouping->delete('apt_grouping_pengajuan_det','no_grouping="'.$no_grouping.'"');	
		redirect('/transapotek/aptgrouping/');
	}
	
	
	public function ambildaftarobatbykode()	{
		$kd_obat=$this->input->post('kd_obat');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');		
		
		$this->datatables->select("apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl_expire,
		 substring_index(apt_stok_unit.jml_stok,'.',1) as jml_stok,'pilihan' as pilihan,ifnull(apt_obat.min_stok,0) as min_stok,apt_obat.pembanding",false);
		
		$this->datatables->from("apt_obat");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6","$7")\'>Pilih</a>','apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,tgl_expire,
																																		jml_stok,min_stok,apt_obat.pembanding');		
		if(!empty($kd_obat))$this->datatables->like('apt_obat.kd_obat',$kd_obat,'both');
		
		$this->datatables->where('apt_stok_unit.kd_unit_apt',$kd_unit_apt);
		$this->datatables->where('apt_stok_unit.jml_stok >','0');
		
		$this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil');
		$this->datatables->join('apt_stok_unit','apt_obat.kd_obat=apt_stok_unit.kd_obat');
		$this->datatables->join('apt_unit','apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt');
		$results = $this->datatables->generate();
		echo ($results);
	}
	
	public function ambildaftarobatbynama()
	{
		$nama_obat=$this->input->post('nama_obat');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');		
		
		$this->datatables->select("apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl_expire,
		 substring_index(apt_stok_unit.jml_stok,'.',1) as jml_stok,'pilihan' as pilihan,ifnull(apt_obat.min_stok,0) as min_stok,apt_obat.pembanding",false);
		
		$this->datatables->from("apt_obat");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6","$7")\'>Pilih</a>','apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,tgl_expire,
																																		jml_stok,min_stok,apt_obat.pembanding');		
		if(!empty($nama_obat))$this->datatables->like('apt_obat.nama_obat',$nama_obat,'both');
		
		$this->datatables->where('apt_stok_unit.kd_unit_apt',$kd_unit_apt);
		$this->datatables->where('apt_stok_unit.jml_stok >','0');
		
		$this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil');
		$this->datatables->join('apt_stok_unit','apt_obat.kd_obat=apt_stok_unit.kd_obat');
		$this->datatables->join('apt_unit','apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt');
		$results = $this->datatables->generate();
		echo ($results);
	}
	
	public function periksagrouping() {
		$msg=array();
		$submit=$this->input->post('submit');
		$no_grouping=$this->input->post('no_grouping');
		$tgl_grouping=$this->input->post('tgl_grouping');
		$keterangan=$this->input->post('keterangan');
		
		$kd_supplier=$this->input->post('kd_supplier');
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$qty_kcl=$this->input->post('qty_kcl');
		$harga_beli=$this->input->post('harga_beli');
		$tgl_entry=$this->input->post('tgl_entry');	
		$kd=$this->input->post('kd');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="hapus"){
			if(empty($no_grouping)){
				$msg['pesanatas']="Pilih Transaksi yang akan di hapus";
			}else{
				$this->mgrouping->delete('apt_grouping_pengajuan','no_grouping="'.$no_grouping.'"');
				$this->mgrouping->delete('apt_grouping_pengajuan_det','no_grouping="'.$no_grouping.'"');
				$msg['pesanatas']="Data Berhasil Di Hapus";
			}
			$msg['status']=0;
			$msg['clearform']=1;
			echo json_encode($msg);
		}
		else{
			if(empty($tgl_grouping)){
				$jumlaherror++;
				$msg['id'][]="tgl_grouping";
				$msg['pesan'][]="Kolom Tanggal Harus di Isi";
			}
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value) {
					# code...
					if(empty($value))continue;
					if(empty($qty_kcl[$key])){
						$msg['status']=0;
						$nama=$this->mgrouping->ambilNama($value);
						$msg['pesanlain'].="Qty ".$nama." Tidak boleh Kosong <br/>";					
					}
					if(empty($harga_beli[$key])){
						$msg['status']=0;
						$nama=$this->mgrouping->ambilNama($value);
						$msg['pesanlain'].="Harga Beli ".$nama." Tidak boleh Kosong <br/>";					
					}
					if(empty($kd_supplier[$key])){
						$msg['status']=0;
						$nama=$this->mgrouping->ambilNama($value);
						$msg['pesanlain'].="Supplier ".$nama." belum dipilih <br/>";					
					}
				}
			}
			if($jumlaherror>0){
				$msg['status']=0;
				$msg['error']=$jumlaherror;
				//$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
				$msg['pesanatas']="Data masih ada yang kosong, silahkan cek inputan anda !";
			}
		}
		echo json_encode($msg);
	}
	
	public function ambilitem()
	{
		$q=$this->input->get('query');
		//$items=$this->mgrouping->ambilItemData('apt_grouping_pengajuan','no_grouping="'.$q.'"');
		$items=$this->mgrouping->ItemGrouping($q);
		//$items2=$this->mgrouping->getDistribusi2($q);
		//$items=array_merge($items1,$items2);
		echo json_encode($items);
	}
	
	public function ambilitems()
	{
		$q=$this->input->get('query');
		$items=$this->mgrouping->getPengajuanDetil2($q);
		echo json_encode($items);
	}
	
	public function buatpemesanan(){
		$no_grouping=$this->input->post('no_grouping');
		$tgl_grouping=$this->input->post('tgl_grouping');
		$keterangan=$this->input->post('keterangan');
		
		/*$kd_supplier=$this->input->post('kd_supplier');
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$qty_kcl=$this->input->post('qty_kcl');
		$harga_beli=$this->input->post('harga_beli');
		$tgl_entry=$this->input->post('tgl_entry');
		$jam_grouping=$this->input->post('jam_grouping');
		$jam_grouping1=$this->input->post('jam_grouping1');*/
		
		debugvar($no_grouping);
		$supplier=$this->mgrouping->getAllSupplier($no_grouping);
		foreach($supplier as $supp){
			$kd_supp=$supp['kd_supplier'];
			
			$jambuat=$this->mgrouping->jamsekarang();
			$tglpesan=convertDate($tgl_grouping)." ".$jambuat;
			$tgl=explode("-", $tgl_grouping);
			$kode=$this->mgrouping->autoNumberPemesanan($tgl[2],$tgl[1]);
			$kodebaru=$kode+1;
			$kodebaru=str_pad($kodebaru,4,0,STR_PAD_LEFT); 
			$no_pemesanan="PM.".$tgl[2].".".$tgl[1].".".$kodebaru;
			
			$obat=$this->mgrouping->ambilObat($no_grouping,$kd_supp);
			$urutobat=1;
			foreach($obat as $obt){
				$kodeobat=$obt['kd_obat'];
				$kiteye=$obt['qty_kcl'];
				$hb=$obt['harga_beli'];
				$ppn=10;					
				$dataobat=array('no_pemesanan'=>$no_pemesanan,
								'urut'=>$urutobat,
								'kd_obat'=>$kodeobat,
								'qty_box'=>$kiteye,
								'qty_kcl'=>$kiteye,
								'harga_beli'=>$hb,
								'diskon'=>0,
								'ppn'=>$ppn,
								'jml_penerimaan'=>0);
				$this->mgrouping->insert('apt_pemesanan_detail',$dataobat);
				$urutobat++;
			}
			$datapesan=array('no_pemesanan'=>$no_pemesanan,
							'kd_supplier'=>$kd_supp,
							//'tgl_pemesanan'=>convertDate($tgl_grouping),
							'tgl_pemesanan'=>$tglpesan,
							'keterangan'=>'-',
							'tgl_tempo'=>convertDate($tgl_grouping),
							'status_approve'=>0,
							'no_grouping'=>$no_grouping);
			$this->mgrouping->insert('apt_pemesanan',$datapesan);
		}
		$sta=array('status_pesan'=>1);
		$this->mgrouping->update('apt_grouping_pengajuan',$sta,'no_grouping="'.$no_grouping.'"');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
