<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Aptdisposal extends CI_Controller {
class Aptdisposal extends Rumahsakit {

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

	public function __construct(){
		parent::__construct();
		$this->load->model('apotek/mdisposal');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
        $this->load->model('gfk/mlaporangfk');
		
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
		if(!$this->muser->isAkses("49")){
			$this->restricted();
			return false;
		}
		
		$no_disposal='';
		$periodeawal=date('d-m-Y');
		$periodeakhir=date('d-m-Y');
		
		if($this->input->post('no_disposal')!=''){
			$no_disposal=$this->input->post('no_disposal');
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
		
		$data=array('no_disposal'=>$no_disposal,
					'periodeawal'=>$periodeawal,
					'periodeakhir'=>$periodeakhir,
					'items'=>$this->mdisposal->ambilDataDisposal($no_disposal,$periodeawal,$periodeakhir));
		
		//debugvar($items);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/disposal/aptdisposal',$data);
		$this->load->view('footer',$datafooter);
	}
		
	public function tambahdisposal(){
		if(!$this->muser->isAkses("50")){
			$this->restricted();
			return false;
		}
		
		$kode=""; $no_disposal=""; 
		
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
		$hari = $this->input->get('hari');
		$hari = empty($hari) ? 90 : $hari;
		$data=array('no_disposal'=>'',
					'itemtransaksi'=>$this->mdisposal->ambilItemData($no_disposal),
					'itemsdetiltransaksi'=>$this->mdisposal->getAllDetailDisposal($no_disposal),
					'dataunit'=>$this->mdisposal->ambilData('apt_unit'),
					'hari'=>$hari,
       				'items' => $this->mlaporangfk->getObatKadaluarsa($hari,'')
					);
		//debugvar($data['itemtransaksi']);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/disposal/tambahdisposal',$data);
		$this->load->view('footer',$datafooter);	
	}
	
	public function ubahdisposal($no_disposal=""){
		if(!$this->muser->isAkses("51")){
			$this->restricted();
			return false;
		}
		
		$sum="";
		if(empty($no_disposal))return false;
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
		$data=array('no_disposal'=>$no_disposal,
					'itemtransaksi'=>$this->mdisposal->ambilItemData($no_disposal),
					'dataunit'=>$this->mdisposal->ambilData('apt_unit'),
					'itemsdetiltransaksi'=>$this->mdisposal->getAllDetailDisposal($no_disposal),
					'hari'=>'',
					'items'=>array()
					);
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/disposal/tambahdisposal',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function simpandisposal(){
		$msg=array();
		$submit=$this->input->post('submit');
		$no_disposal=$this->input->post('no_disposal');
		$tanggal=$this->input->post('tanggal');
		$keterangan=$this->input->post('keterangan');
		$approval=$this->input->post('approval');
		$jam=$this->input->post('jam');
		$jam1=$this->input->post('jam1');
		
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$tgl_expire=$this->input->post('tgl_expire');
		$qty=$this->input->post('qty');
		$ket_grid=$this->input->post('ket_grid');
		$jml_stok=$this->input->post('jml_stok');
		$batch=$this->input->post('batch');
		$kode_pabrik=$this->input->post('kode_pabrik');
		$harga_pokok=$this->input->post('harga_pokok');
		$kd_milik="01";
		$kd_unit_karantina="U03";
		$kd_user=$this->session->userdata('id_user');
		$kd_unit_apt=$this->input->post('kd_unit_apt');
		
		$msg['no_disposal']=$no_disposal;

		$this->db->trans_start();		
		if($submit=="tutuptrans"){
			if(empty($no_disposal))return false;
			$updatedisposal=array('approval'=>1);
			$this->mdisposal->update('apt_disposal',$updatedisposal,'no_disposal="'.$no_disposal.'"');
			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					if(empty($value))continue;
					$tglexp=convertDate($tgl_expire[$key]);
						//$jml_stoka=$this->mdisposal->ambilStok($kd_unit_apt[$key],$value,$tglexp);
						$jml_stoka=$this->mdisposal->ambilStok($kd_unit_apt[$key],$value,convertDate($tgl_expire[$key]),$kode_pabrik[$key],$batch[$key],$harga_pokok[$key]);
						$sisastok=$jml_stoka-$qty[$key];
						$datastok=array('jml_stok'=>$sisastok,'is_sync'=>0);
						$this->mdisposal->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$kd_unit_apt[$key].'" and kd_obat="'.$value.'" and tgl_expire="'.$tglexp.'"  and kd_pabrik="'.$kode_pabrik[$key].'" and batch="'.$batch[$key].'"  and harga_pokok="'.$harga_pokok[$key].'"  ');	
				}
			}
			$this->db->trans_complete();
			$msg['status']=1;
			$msg['posting']=1;
			$msg['pesan']="Tutup Transksi Berhasil";
			echo json_encode($msg);
			return false;
		}
		if($submit=="bukatrans"){
			if(empty($no_disposal))return false;
			$updatedisposal=array('approval'=>0);
			$this->mdisposal->update('apt_disposal',$updatedisposal,'no_disposal="'.$no_disposal.'"');
			
			$items=$this->mdisposal->getAllDetailDisposal($no_disposal);
			foreach($items as $itemdetil){
				$kode=$itemdetil['kd_obat1'];
				$kiteye=$itemdetil['qty'];
				$tglexp=$itemdetil['tgl_expire'];
				
				//$stokawal=$this->mdisposal->ambilStok($itemdetil['kd_unit_apt'],$kode,$tglexp); 
				$jml_stoka=$this->mdisposal->ambilStok($itemdetil['kd_unit_apt'],$kode,convertDate($tglexp),$itemdetil['kd_pabrik'],$itemdetil['batch'],$itemdetil['harga_pokok']);
				$stokakhir=$kiteye+$jml_stoka;
				$datastok=array('jml_stok'=>$stokakhir,'is_sync'=>0);
				$this->mdisposal->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$itemdetil['kd_unit_apt'].'" and kd_obat="'.$kode.'" and tgl_expire="'.$tglexp.'"  and kd_pabrik="'.$itemdetil['kd_pabrik'].'" and batch="'.$itemdetil['batch'].'"  and harga_pokok="'.$itemdetil['harga_pokok'].'"  ');
			}
			$this->db->trans_complete();
			$msg['status']=1;
			$msg['posting']=2;
			$msg['pesan']="Buka Transksi Berhasil";
			echo json_encode($msg);
			return false;
		}
		
		if($this->mdisposal->isNumberExist($no_disposal)){ //edit
			$tgl_disposal1=convertDate($tanggal)." ".$jam1;
		    $datadisposaledit=array('tanggal'=>$tgl_disposal1,
									'keterangan'=>$keterangan);
				
			$this->mdisposal->update('apt_disposal',$datadisposaledit,'no_disposal="'.$no_disposal.'"');
			$urut=1;
			
			$this->mdisposal->delete('apt_disposal_detail','no_disposal="'.$no_disposal.'"');
			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					if(empty($value))continue;					
					$datadetiledit=array('no_disposal'=>$no_disposal,
										'urut'=>$urut,
										'kd_unit_apt'=>$kd_unit_apt[$key],
										'kd_obat'=>$value,
										'kd_milik'=>$kd_milik,
										'tgl_expire'=>convertDate($tgl_expire[$key]),
										'qty'=>$qty[$key],
										'batch'=>$batch[$key],
										'kd_pabrik'=>$kode_pabrik[$key],
										'harga_pokok'=>$harga_pokok[$key],
										'keterangan'=>$ket_grid[$key]);
					$this->mdisposal->insert('apt_disposal_detail',$datadetiledit);										
					$urut++;
				}
			}

			$msg['pesan']="Data Berhasil Di Update";
			$msg['posting']=3;
		}else { //simpan baru
			$tgl=explode("-", $tanggal);
			$kode=$this->mdisposal->autoNumber($tgl[2],$tgl[1]);
			$kodebaru=$kode+1;
			$kodebaru=str_pad($kodebaru,3,0,STR_PAD_LEFT); 
			$no_disposal="DSP".substr(($tgl[2]),2,2)."".$tgl[1]."".$kodebaru;
			//if($this->mdisposal->isNumberExist($no_disposal)){

			//}
			$msg['no_disposal']=$no_disposal;
			
			$tgl_disposal1=convertDate($tanggal)." ".$jam;
			$datadisposal=array('no_disposal'=>$no_disposal,
									'tanggal'=>$tgl_disposal1,
									'keterangan'=>$keterangan,
									'kd_user'=>$kd_user);
			
			$this->mdisposal->insert('apt_disposal',$datadisposal);
			$urut=1;
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					# code...
					if(empty($value))continue;										
					$datadetil=array('no_disposal'=>$no_disposal,
									'urut'=>$urut,
									'kd_unit_apt'=>$kd_unit_apt[$key],
									'kd_obat'=>$value,
									'kd_milik'=>$kd_milik,
									'tgl_expire'=>convertDate($tgl_expire[$key]),
									'qty'=>$qty[$key],
									'batch'=>$batch[$key],
									'kd_pabrik'=>$kode_pabrik[$key],
									'harga_pokok'=>$harga_pokok[$key],
									'keterangan'=>$ket_grid[$key]);
					//debugvar($datadetil);
					$this->mdisposal->insert('apt_disposal_detail',$datadetil);	
										
					$urut++;
				}
			}
			$msg['pesan']="Data Berhasil Di Simpan";
			$msg['posting']=3;
		}

		$this->db->trans_complete();
		$msg['status']=1;
		$msg['keluar']=0;
		if($submit=="simpankeluar"){
			$msg['keluar']=1;
		}
		echo json_encode($msg);
	}
	
	public function hapusdisposal($no_disposal=""){
		if(!$this->muser->isAkses("52")){
			$this->restricted();
			return false;
		}
		//$kd_unit_apt="";
		$msg=array();
		$error=0;
		if(empty($no_disposal)){
			$msg['pesan']="Pilih Transaksi yang akan di hapus";
			echo "<script>Alert('".$msg['pesan']."')</script>";
		}else{		
			$this->db->trans_start();
			$this->mdisposal->delete('apt_disposal','no_disposal="'.$no_disposal.'"');
			$this->mdisposal->delete('apt_disposal_detail','no_disposal="'.$no_disposal.'"');	
			$this->db->trans_complete();		
			redirect('/transapotek/aptdisposal/');
		}
	}
		
	public function ambildaftarobatbynama(){
		$nama_obat=$this->input->post('nama_obat');
		$kd_unit_apt=$this->input->post('kd_unit_apt');
		//debugvar($kd_unit_apt);
		$this->datatables->select('apt_stok_unit.kd_obat, replace(apt_obat.nama_obat,"\'","") as nama_obat, apt_satuan_kecil.satuan_kecil, date_format(apt_stok_unit.tgl_expire,"%d-%m-%Y") as tgl_expire,apt_stok_unit.batch,nama_pabrik,
						 ifnull(harga_pokok,0) as harga_jual,apt_stok_unit.jml_stok,"pilihan" as pilihan,ifnull(apt_obat.min_stok,0) as min_stok,apt_stok_unit.kd_pabrik ',false);
		
		$this->datatables->from("apt_obat");
		//if(!empty($nama_obat))$this->datatables->like('apt_obat.nama_obat',$nama_obat,'both');
		if(!empty($nama_obat)){
			//$this->datatables->like('apt_obat.nama_obat',$nama_obat,'both');
			$this->datatables->where('(apt_obat.nama_obat like "%'.$nama_obat.'%" or apt_obat.kd_obat in (select kd_obat from obat_barcode where kd_barcode like "%'.$nama_obat.'%") ) ');
		}
		
		$this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil','left');
		$this->datatables->join('apt_stok_unit','apt_obat.kd_obat=apt_stok_unit.kd_obat');
		$this->datatables->join('apt_pabrik','apt_stok_unit.kd_pabrik=apt_pabrik.kd_pabrik','left');
		$this->datatables->join('apt_unit','apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt');
		
		$this->datatables->where('apt_unit.kd_unit_apt',$kd_unit_apt);
		$this->datatables->where('apt_stok_unit.jml_stok >','0');
		$this->datatables->where('apt_obat.is_aktif','1');
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6","$7","$8","$9")\'>Pilih</a>','apt_stok_unit.kd_obat, nama_obat, apt_satuan_kecil.satuan_kecil, tgl_expire, harga_jual,apt_stok_unit.jml_stok,min_stok,apt_stok_unit.kd_pabrik,apt_stok_unit.batch');		
		
		$results = $this->datatables->generate();
		echo ($results);
	}
	
	public function ambildaftarobatbykode(){
		$kd_obat=$this->input->post('kd_obat');
		
		$this->datatables->select("apt_obat.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil,date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl_expire ,ifnull( sum(substring_index( apt_stok_unit.jml_stok, '.', 1 )) , 0 ) as jml_stok, 'Pilihan' as pilihan,apt_obat.pembanding,nama_unit_apt",false);
		
		$this->datatables->from("apt_obat");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6")\'>Pilih</a>','apt_obat.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil,tgl_expire ,jml_stok, nama_unit_apt');		
		if(!empty($kd_obat))$this->datatables->like('apt_obat.kd_obat',$kd_obat,'both');
		
		$this->datatables->where('apt_unit.kd_unit_apt','U03');
		$this->datatables->where('apt_obat.is_aktif','1');
		$this->datatables->where('apt_stok_unit.jml_stok > ',0);
		
		$this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil','left');
		$this->datatables->join('apt_stok_unit','apt_obat.kd_obat=apt_stok_unit.kd_obat','left');
		$this->datatables->join('apt_unit','apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt','left');
		$this->db->group_by("apt_stok_unit.kd_obat,apt_stok_unit.tgl_expire");
		$results = $this->datatables->generate();
		//debugvar($results);
		echo ($results);		
	}
	
	public function ambilsupplierbykode(){
		$q=$this->input->get('query');
		$items=$this->mdisposal->ambilData3($q);
		echo json_encode($items);
	}
	
	public function ambilsupplierbynama(){
		$q=$this->input->get('query');
		$items=$this->mdisposal->ambilData4($q);
		echo json_encode($items);
	}
	
	public function periksadisposal() {
		$msg=array();
		$submit=$this->input->post('submit');
		$no_disposal=$this->input->post('no_disposal');
		$tanggal=$this->input->post('tanggal');
		$keterangan=$this->input->post('keterangan');
		$approval=$this->input->post('approval');
		$jam=$this->input->post('jam');
		$jam1=$this->input->post('jam1');
		
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$tgl_expire=$this->input->post('tgl_expire');
		$qty=$this->input->post('qty');
		$ket_grid=$this->input->post('ket_grid');
		$jml_stok=$this->input->post('jml_stok');
		$kd_milik="01";
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="hapus"){
			if(empty($no_disposal)){
				$msg['pesanatas']="Pilih Transaksi yang akan di hapus";
			}else{
				$this->mdisposal->delete('apt_disposal','no_disposal="'.$no_disposal.'"');
				$this->mdisposal->delete('apt_disposal_detail','no_disposal="'.$no_disposal.'"');
				$msg['pesanatas']="Data Berhasil Di Hapus";
			}
			$msg['status']=0;
			$msg['clearform']=1;
			echo json_encode($msg);
		}
		else if($submit=="bukatrans"){}
		else if($submit=="tutuptrans"){}
		else{
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value) {
					# code...
					if(empty($value))continue;
					if(empty($qty[$key])){
						$msg['status']=0;
						$msg['pesanlain'].="Qty ".$value." tidak boleh Kosong <br/>";					
					}
					if($qty[$key]>$jml_stok[$key]){
						$msg['status']=0;
						$nama=$this->mdisposal->ambilNama($value);
						$msg['pesanlain'].="Jumlah obat ".$nama." yang diinput tidak boleh melebihi jumlah obat ".$nama." yang dikarantina.<br/>";
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
	
	public function ambilitem()
	{
		$q=$this->input->get('query');
		$items=$this->mdisposal->getDisposal($q);

		echo json_encode($items);
	}
	
	public function ambilitems()
	{
		$q=$this->input->get('query');
		$items=$this->mdisposal->getAllDetailDisposal($q);

		echo json_encode($items);
	}

	public function kembalikan($no_disposal,$urut){
		$itemdetil=$this->db->get_where('apt_disposal_detail',array('no_disposal'=>$no_disposal,'urut'=>$urut))->row_array();

		$kode=$itemdetil['kd_obat'];
		$kiteye=$itemdetil['qty'];
		$tglexp=$itemdetil['tgl_expire'];
		
		$jml_stoka=$this->mdisposal->ambilStok($itemdetil['kd_unit_apt'],$kode,convertDate($tglexp),$itemdetil['kd_pabrik'],$itemdetil['batch'],$itemdetil['harga_pokok']);
		$stokakhir=$kiteye+$jml_stoka;
		$datastok=array('jml_stok'=>$stokakhir);

		$this->mdisposal->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$itemdetil['kd_unit_apt'].'" and kd_obat="'.$kode.'" and tgl_expire="'.$tglexp.'"  and kd_pabrik="'.$itemdetil['kd_pabrik'].'" and batch="'.$itemdetil['batch'].'"  and harga_pokok="'.$itemdetil['harga_pokok'].'" ');

		$this->db->delete('apt_disposal_detail',array('no_disposal'=>$no_disposal,'urut'=>$urut));
		redirect('gfk/laporangfk/karantina');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
