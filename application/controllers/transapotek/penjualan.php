<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH.'controllers/rumahsakit.php');

//class Penjualan extends CI_Controller {
class Penjualan extends Rumahsakit {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the ambil_apt_obatdefault controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	protected $title='GFK KOTA BALIKPAPAN';
	public $shift;

	public function __construct(){
		parent::__construct();
		$this->load->model('apotek/mpenjualan');
		$this->load->model('apotek/mlaporanapt');
		$this->load->model('gfk/mmain');
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		//

        $queryunitshift=$this->db->query('select * from unit_shift where kd_unit="APT"'); 
        $unitshift=$queryunitshift->row_array();
		$this->shift=$unitshift['shift'];
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
		//if(!$this->muser->isAkses("57")){
		//	$this->restricted();
		//	return false;
		//}
		
		$no_penjualan='';
		$no_sbbk = '';
		$kd_unit_apt='';
		$id_puskesmas='';
		$kd_jenis_transaksi='';
		$periodeawal=date('d-m-Y');
		$periodeakhir=date('d-m-Y');
		
		
		if($this->input->post('no_penjualan')!=''){
			$no_penjualan=$this->input->post('no_penjualan');
		}
		if($this->input->post('id_puskesmas')!=''){
			$id_puskesmas=$this->input->post('id_puskesmas');
		}
		if($this->input->post('kd_jenis_transaksi')!=''){
			$kd_jenis_transaksi=$this->input->post('kd_jenis_transaksi');
		}
		// if($this->input->post('kd_unit_apt')!=''){
		// 	$kd_unit_apt=$this->input->post('kd_unit_apt');
		// }
		if($this->input->post('periodeawal')!=''){
			$periodeawal=$this->input->post('periodeawal');
		}
		if($this->input->post('periodeakhir')!=''){
			$periodeakhir=$this->input->post('periodeakhir');
		}
		if($this->input->post('no_sbbk')) {
			$no_sbbk = $this->input->post('no_sbbk');
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
							'spin.js',
							'main.js');
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		
		$items = $this->mpenjualan->ambilDataObatKeluar($no_sbbk, $periodeawal, $periodeakhir,$id_puskesmas,$kd_jenis_transaksi);
		$data=array(
			'no_sbbk' => $no_sbbk,
			'no_penjualan'=>$no_penjualan,
			'kd_unit_apt'=>$kd_unit_apt,
			'periodeawal'=>$periodeawal,
			'id_puskesmas'=>$id_puskesmas,
			'kd_jenis_transaksi'=>$kd_jenis_transaksi,
			'datapuskesmas' => $this->mpenjualan->ambilData('gfk_puskesmas'),
			'jenistransaksi' => $this->mpenjualan->ambilData('jenis_transaksi'),
			'periodeakhir'=>$periodeakhir,
			'items'=>$items,
		);
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/penjualan/penjualan',$data);
		$this->load->view('footer',$datafooter);
	}
		
	public function tambahpenjualan(){
		if(!$this->muser->isAkses("58")){
			// $this->restricted();
			// return false;
		}
		
		$kode=""; $no_penjualan="";
		
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
		
		
		$data=array('no_penjualan'=>'',
					'dataunit'=>$this->mpenjualan->ambilData('apt_unit'),
					'jenistransaksi'=>$this->mpenjualan->ambilData('jenis_transaksi'),
					'itemsdetiltransaksi'=>$this->mpenjualan->getAllDetailPenjualan($no_penjualan),
					'itemtransaksi'=>$this->mpenjualan->ambilItemDataPenjualan($no_penjualan),
					'datapuskesmas' => $this->mpenjualan->ambilData('gfk_puskesmas'),
					);
		//debugvar();
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/penjualan/tambahpenjualan',$data);
		$this->load->view('footer',$datafooter);	
	}
	
	public function ubahpenjualan($no_penjualan=""){
		if(!$this->muser->isAkses("59")){
			// $this->restricted();
			// return false;
		}
		
		if(empty($no_penjualan))return false;
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
							'main.js','jquery.form.js');
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
			'jenispasien'=>$this->mpenjualan->ambilData('jenis_pasien'),			
			'dataunit'=>$this->mpenjualan->ambilData('apt_unit'),
			'jenisbayar'=>$this->mpenjualan->ambilData('apt_jenis_bayar'),
			'no_penjualan'=>$no_penjualan,
			'itemtransaksi'=>$this->mpenjualan->ambilItemDataObatKeluar($no_penjualan),
			'itemsdetiltransaksi'=>$this->mpenjualan->getAllDetailObatKeluar2($no_penjualan),
			'itembayar'=>$this->mpenjualan->getAllDataPembayaran($no_penjualan),
			'itembayarform'=>$this->mpenjualan->ambilTotal($no_penjualan),
			'itembungkus'=>$this->mpenjualan->ambilItemData('sys_setting','key_data="TARIF_PERBUNGKUS"'),
			//'items'=>$this->mpenjualan->ambilDataPenjualan('','','','',''),
			'jasamedis'=>$this->mpenjualan->jasamedis(),
			//'itemsah'=>$this->mpenjualan->ambilDataPenjualan1('','','','')
			'isTutup' => $this->mpenjualan->isPosted($no_penjualan),
			'isLunas' => $this->mpenjualan->isPosted1($no_penjualan),
			'jenistransaksi'=>$this->mpenjualan->ambilData('jenis_transaksi'),
			'datapuskesmas' => $this->mpenjualan->ambilData('gfk_puskesmas'),
		);
		// debugvar($data['itemsdetiltransaksi']);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/penjualan/tambahpenjualan',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function simpanpenjualan(){
		
		$msg=array();
		$submit=$this->input->post('submit');
		$no_penjualan=$this->input->post('no_penjualan');
		$no_pendaftaran=($this->input->post('no_pendaftaran') != FALSE) ? $this->input->post('no_pendaftaran') : NULL;
		$is_lunas=$this->input->post('is_lunas');
		$tgl_penjualan=$this->input->post('tgl_penjualan');
		// $tgl_penjualan2=$this->input->post('tgl_penjualan2');
		$tutup=$this->input->post('tutup');
		$kd_pasien=($this->input->post('kd_pasien') != FALSE) ? $this->input->post('kd_pasien') : NULL;
		$nama_pasien=$this->input->post('nama_pasien');
		$cust_code=$this->input->post('cust_code');
		$jenis_sbbk=$this->input->post('jenis_sbbk');
		$bhp=$this->input->post('bhp');
		$total_transaksi=$this->input->post('total_transaksi');
		$total_bayar=$this->input->post('total_bayar');
		$tglpenjualan=date('Y-m-d');
		$kd_unit_apt=$this->input->post('kd_unit_apt');
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=($this->input->post('satuan_kecil') != FALSE) ? $this->input->post('satuan_kecil') : NULL;
		$qty=$this->input->post('qty');
		$qty11=$this->input->post('qty11');
		$tgl_expire=$this->input->post('tgl_expire');
		$harga_jual=$this->input->post('harga_jual'); 
		$total=$this->input->post('total');
		$nama_unit_apt=$this->input->post('nama_unit_apt');
		$tipe=$this->input->post('tipe');
		$milik=($this->input->post('milik') != FALSE) ? $this->input->post('milik') : NULL;
		$kd_user=$this->session->userdata('id_user');
		$id_puskesmas = $this->input->post('id_puskesmas');
		$no_sbbk = $this->input->post('no_sbbk');
		$kd_jenis_transaksi=$this->input->post('kd_jenis_transaksi');
		$tgl_keluar = $this->input->post('tgl_keluar');
		$batch = $this->input->post('batch');
		$kd_pabrik = $this->input->post('kd_pabrik');
		$qty_kecil = $this->input->post('qty_kecil');
		$jasa="0";
		$shiftapt="1";
		$kd_milik="01";
		
		//debugvar($total_transaksi);
		$tgl_bayar=$this->input->post('tgl_bayar');
		$kd_jenis_bayar=$this->input->post('kd_jenis_bayar');
		$jenis_bayar=$this->input->post('jenis_bayar');
		$bayar=$this->input->post('bayar');
		$sisa=$this->input->post('sisa');
		$terima=$this->input->post('terima');
		$kembali=$this->input->post('kembali');
		
		$tgl_pelayanan=$this->input->post('tgl_pelayanan');
		$jam_pelayanan=$this->input->post('jam_pelayanan');
		$jam_penjualan=$this->input->post('jam_penjualan');
		$qty=$this->input->post('qty');
		
		$msg['no_penjualan']=$no_penjualan;

		if($submit=="tutuptrans"){
			$this->db->trans_start();
			if(empty($no_penjualan))return false;
			$updatedistribusi=array('tutup'=>1);
			$this->mpenjualan->update('apt_penjualan',$updatedistribusi,'no_penjualan="'.$no_penjualan.'"');
			$msg['status']=1;
			$msg['posting']=1;
			$msg['pesan']="Tutup Transaksi Berhasil";
			$this->db->trans_complete();
			echo json_encode($msg);
			return false;
		}
		if($submit=="bukatrans"){
			if(empty($no_penjualan))return false;
			$this->db->trans_start();
			$updatedistribusi=array('tutup'=>0);
			$this->mpenjualan->update('apt_penjualan',$updatedistribusi,'no_penjualan="'.$no_penjualan.'"');
			$msg['status']=1;
			$msg['posting']=2;
			$msg['pesan']="Buka Transaksi Berhasil";
			$this->db->trans_complete();
			echo json_encode($msg);
			return false;
		}
		
		
		if($this->mpenjualan->isNumberExist($no_penjualan)){ //edit
			$k=" disini";
			$this->db->trans_start();	
			
			$tgl_penjualan=convertDate($tgl_penjualan)." ".date('H:i:s');			

			$datapenjualanedit=array(//'resep'=>$resep,
									'is_lunas'=>$is_lunas,
									'tgl_penjualan'=>$tgl_penjualan,
									'shiftapt'=>$this->shift,
									'tutup'=>$tutup,
									// 'kd_pasien'=>$kd_pasien,
									// 'nama_pasien'=>$nama_pasien,
									'cust_code'=>$cust_code,
									'total_transaksi'=>$total_transaksi,
									'total_bayar'=>$total_bayar,
									'no_pendaftaran'=>$no_pendaftaran,
									'status'=>0,
									'customer_id' => $id_puskesmas,
									'jenis_sbbk'=>$jenis_sbbk,
									'kd_jenis_transaksi'=>$kd_jenis_transaksi,
									'no_sbbk' => $no_sbbk);
			$this->mpenjualan->update('apt_penjualan',$datapenjualanedit,'no_penjualan="'.$no_penjualan.'"');	
			$urut=1;
			
			//menguragi stok di tabel apt_stok_unit
			$itemsdetiltransaksi=$this->mpenjualan->getAllDetailPenjualan($no_penjualan);
			foreach ($itemsdetiltransaksi as $itemdetil){
				$jml_stok=0;
				$sisastok=0;
				$jml_stok=$this->mpenjualan->ambilStok($itemdetil['kd_unit_apt'],$itemdetil['kd_obat'],convertDate($itemdetil['tgl_expire']),$itemdetil['kd_pabrik'],$itemdetil['batch'],$itemdetil['harga_jual']);
				//$jml_stok=$this->mpenjualan->ambilStok($itemdetil['kd_unit_apt'],$itemdetil['kd_obat'],convertDate($itemdetil['tgl_expire']));
				$sisastok=$jml_stok+$itemdetil['qty'];
				$datastok=array('jml_stok'=>$sisastok);
				$this->mpenjualan->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$itemdetil['kd_unit_apt'].'" and kd_obat="'.$itemdetil['kd_obat'].'" and tgl_expire="'.convertDate($itemdetil['tgl_expire']).'"  and kd_pabrik="'.$itemdetil['kd_pabrik'].'" and batch="'.$itemdetil['batch'].'"  and harga_pokok="'.$itemdetil['harga_jual'].'" ');
			}
			$this->mpenjualan->delete('apt_penjualan_detail','no_penjualan="'.$no_penjualan.'"');
			
			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					if(empty($value))continue;
					// if(empty($batch[$key]))$batch[$key]="";
					$datadetiledit=array(
						'no_penjualan'=>$no_penjualan,
						'urut'=>$urut,
						'kd_unit_apt'=>$kd_unit_apt[$key],
						'kd_obat'=>$value,
						'kd_milik'=>$kd_milik,
						'tgl_expire'=>convertDate($tgl_expire[$key]),
						'batch'=>$batch[$key],
						'kd_pabrik'=>$kd_pabrik[$key],
						'qty'=>$qty[$key],
						'qty_kecil'=>$qty_kecil[$key],
						'harga_pokok'=>$harga_jual[$key],
						'harga_jual'=>$harga_jual[$key],
						'total'=>$total[$key],
						'markup'=>0,
						'jasa'=>$jasa, 
						'tgl_keluar' => convertDate($tgl_keluar[$key])
					);
					$this->mpenjualan->insert('apt_penjualan_detail',$datadetiledit);		
					//update stok masing-masing obat
					$jml_stok=$this->mpenjualan->ambilStok($kd_unit_apt[$key],$value,convertDate($tgl_expire[$key]),$kd_pabrik[$key],$batch[$key],$harga_jual[$key]);
					$sisastok=$jml_stok-$qty[$key];
					$datastok=array('jml_stok'=>$sisastok,'is_sync'=>0);
					$this->mpenjualan->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$kd_unit_apt[$key].'" and kd_obat="'.$value.'" and tgl_expire="'.convertDate($tgl_expire[$key]).'" and kd_pabrik="'.$kd_pabrik[$key].'" and batch="'.$batch[$key].'"  and harga_pokok="'.$harga_jual[$key].'"');
					$urut++;
				}
			}
			$count=$this->mpenjualan->countObat($no_penjualan);
			$datatotal=array('total_transaksi'=>$total_transaksi,'total_bayar'=>$total_transaksi,'jum_item_obat'=>$count);
			$this->mpenjualan->update('apt_penjualan',$datatotal,'no_penjualan="'.$no_penjualan.'"');		
			$msg['pesan']="Data Berhasil Di Update";
			$msg['posting']=3;
			$this->db->trans_complete();
		}else { //simpan baru
			$this->db->trans_start();
			if($tgl_penjualan==''){$tgl_penjualan=convertDate($tglpenjualan);}
			$tgl=explode("-", $tgl_penjualan);
			$tgl_penjualan=convertDate($tgl_penjualan)." ".date('H:i:s');			
			$kode=$this->mpenjualan->autoNumber($tgl[2],$tgl[1]);
			$kodebaru=$kode+1;
			$kodebaru=str_pad($kodebaru,5,0,STR_PAD_LEFT); 
			$kodeawal="R";
			$no_penjualan=$kodeawal.".".$tgl[2].".".$tgl[1].".".$kodebaru;
			$msg['no_penjualan']=$no_penjualan;			
			// $tgl_penjualan=convertDate($tgl_penjualan)." ".$jam_pelayanan;
			$datapenjualan=array('no_penjualan'=>$no_penjualan,
								'is_lunas'=>$is_lunas,
								'tgl_penjualan'=>$tgl_penjualan,
								'shiftapt'=>$this->shift,
								'tutup'=>$tutup,
								// 'kd_pasien'=>$kd_pasien,
								// 'nama_pasien'=>$nama_pasien,
								'cust_code'=>'1',
								'total_transaksi'=>$total_transaksi,
								'total_bayar'=>$total_bayar,
								'no_pendaftaran'=>$no_pendaftaran,
								'status'=>0,
								'bhp'=>$bhp,
								'tgl_tutup'=>'0000-00-00 00:00:00',
								//'kd_unit_apt' => $kd_unit_apt,
								'jenis_sbbk'=>$jenis_sbbk,
								'kd_jenis_transaksi'=>$kd_jenis_transaksi,
								'customer_id' => $id_puskesmas,
								'no_sbbk' => $no_sbbk,
								'user_id' => $this->session->userdata('id_user'),
								);
			
			$this->mpenjualan->insert('apt_penjualan',$datapenjualan);
			$urut=1;
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					# code...
					if(empty($value))continue;
					if(empty($tgl_keluar[$key])) {
						$tgl_keluar[$key] = $tgl_penjualan;
					}			
					
					$datadetil=array('no_penjualan'=>$no_penjualan,
									'urut'=>$urut,
									'kd_unit_apt'=>$kd_unit_apt[$key],
									'kd_obat'=>$value,
									'kd_milik'=>$kd_milik,
									'tgl_expire'=>convertDate($tgl_expire[$key]),
									'qty'=>$qty[$key],
									'qty_kecil'=>$qty_kecil[$key],
									'batch'=>$batch[$key],
									'kd_pabrik'=>$kd_pabrik[$key],
									'harga_pokok'=>$harga_jual[$key],
									'harga_jual'=>$harga_jual[$key],
									'total'=>$total[$key],
									'markup'=>0,
									'tgl_keluar' => convertDate($tgl_keluar[$key]),
									);
					$this->mpenjualan->insert('apt_penjualan_detail',$datadetil);
					//update stok masing-masing obat
					$jml_stok=$this->mpenjualan->ambilStok($kd_unit_apt[$key],$value,convertDate($tgl_expire[$key]),$kd_pabrik[$key],$batch[$key],$harga_jual[$key]);
					$sisastok=$jml_stok-$qty[$key];
					$datastok=array('jml_stok'=>$sisastok);
					$this->mpenjualan->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$kd_unit_apt[$key].'" and kd_obat="'.$value.'" and tgl_expire="'.convertDate($tgl_expire[$key]).'" and kd_pabrik="'.$kd_pabrik[$key].'" and batch="'.$batch[$key].'" and harga_pokok="'.$harga_jual[$key].'" ');
					$urut++;				
				}
			}
			$count=$this->mpenjualan->countObat($no_penjualan);
			//$datatotal=array('total_transaksi'=>$total_transaksi,'total_bayar'=>$total_transaksi,'jum_item_obat'=>$count);
			 $datatotal=array('total_transaksi'=>$total_transaksi,
			 'total_bayar'=>$total_transaksi,
					'jum_item_obat'=>$count,
					'is_lunas'=>1
					);
			
			$this->mpenjualan->update('apt_penjualan',$datatotal,'no_penjualan="'.$no_penjualan.'"');
			$msg['pesan']="Data Berhasil Di Simpan";
			$msg['posting']=3;
			
			
			
			$this->db->trans_complete();
			//die('stop');
		}
		$msg['status']=1;
		$msg['keluar']=0;
		$msg['simpanbayar']=0;
		if($submit=="simpankeluar"){
			$msg['keluar']=1;
		}
					
		echo json_encode($msg);
	}
	
	public function hapuspenjualan($no_penjualan=""){
		if(!$this->muser->isAkses("60")){
			// $this->restricted();
			// return false;
		}
		
		$msg=array();
		$error=0;
		if(empty($no_penjualan)){
			$msg['pesan']="Pilih Transaksi yang akan di hapus";
			echo "<script>Alert('".$msg['pesan']."')</script>";
		}else{
	        $penjualan = $this->mpenjualan->getPenjualanWithPuskesmas($no_penjualan);
	        if($penjualan['tanggal_kirim'])die('sbbk sudah dikirim ke puskesmas, tidak bisa di hapus');
			$this->db->trans_start();
			$itemsdetiltransaksi=$this->mpenjualan->getAllDetailPenjualan($no_penjualan);
			foreach ($itemsdetiltransaksi as $itemdetil){
				$jml_stok=0;
				$sisastok=0;
				//$jml_stok=$this->mpenjualan->ambilStok($itemdetil['kd_unit_apt'],$itemdetil['kd_obat'],convertDate($itemdetil['tgl_expire']));
				$jml_stok=$this->mpenjualan->ambilStok($itemdetil['kd_unit_apt'],$itemdetil['kd_obat'],convertDate($itemdetil['tgl_expire']),$itemdetil['kd_pabrik'],$itemdetil['batch'],$itemdetil['harga_jual']);
				$sisastok=$jml_stok+$itemdetil['qty'];
				$datastok=array('jml_stok'=>$sisastok);
				$this->mpenjualan->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$itemdetil['kd_unit_apt'].'" and kd_obat="'.$itemdetil['kd_obat'].'" and tgl_expire="'.convertDate($itemdetil['tgl_expire']).'" and kd_pabrik="'.$itemdetil['kd_pabrik'].'" and batch="'.$itemdetil['batch'].'" and harga_pokok="'.$itemdetil['harga_jual'].'" ');
			}
			$this->mpenjualan->delete('apt_penjualan_detail','no_penjualan="'.$no_penjualan.'"');		
			$this->mpenjualan->delete('apt_penjualan','no_penjualan="'.$no_penjualan.'"');
			$this->db->trans_complete();	
			redirect('/transapotek/penjualan/');
		}
	}
	
	public function ambildaftarobatbynama() {
		$nama_obat=$this->input->post('nama_obat');
		$kd_unit_apt=$this->input->post('kd_unit_apt');
		
		$this->datatables->select('apt_stok_unit.kd_obat, replace(apt_obat.nama_obat,"\'","") as nama_obat, apt_satuan_kecil.satuan_kecil, date_format(apt_stok_unit.tgl_expire,"%d-%m-%Y") as tgl_expire,apt_stok_unit.batch,nama_pabrik,
						 ifnull(harga_pokok,0) as harga_jual,apt_stok_unit.jml_stok,ifnull(apt_obat.isi_kemasan,0) as isi_kemasan,"pilihan" as pilihan,apt_stok_unit.kd_pabrik ',false);
		
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
		//$this->datatables->where('apt_stok_unit.jml_stok >','0');
		$this->datatables->where('apt_obat.is_aktif','1');
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6","$7","$8","$9")\'>Pilih</a>','apt_stok_unit.kd_obat, nama_obat, apt_satuan_kecil.satuan_kecil, tgl_expire, harga_jual,apt_stok_unit.jml_stok,isi_kemasan,apt_stok_unit.kd_pabrik,apt_stok_unit.batch');		
		
		$results = $this->datatables->generate();
		echo ($results);
	}
	
	public function ambildaftarobatbykode() {
		$kd_obat=$this->input->post('kd_obat');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		
		$this->datatables->select("apt_stok_unit.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl_expire,
						(apt_stok_unit.harga_pokok * apt_margin_harga.nilai_margin) as harga_jual,apt_stok_unit.jml_stok,'pilihan' as pilihan,ifnull(apt_obat.min_stok,0) as min_stok ",false);
		
		$this->datatables->from("apt_obat");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6","$7")\'>Pilih</a>','apt_stok_unit.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, tgl_expire, harga_jual,apt_stok_unit.jml_stok,min_stok');		
		if(!empty($kd_obat))$this->datatables->like('apt_obat.kd_obat',$kd_obat,'both');
		
		$this->datatables->where('apt_stok_unit.kd_unit_apt',$kd_unit_apt);
		$this->datatables->where('apt_stok_unit.jml_stok >','0');
		$this->datatables->where('apt_obat.is_aktif','1');
		
		$this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil');
		$this->datatables->join('apt_stok_unit','apt_obat.kd_obat=apt_stok_unit.kd_obat');
		$this->datatables->join('apt_golongan','apt_obat.kd_golongan=apt_golongan.kd_golongan');
		$this->datatables->join('apt_jenis_obat','apt_obat.kd_jenis_obat=apt_jenis_obat.kd_jenis_obat');
		$this->datatables->join('apt_unit','apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt');
		$this->datatables->join('apt_margin_harga ','apt_jenis_obat.kd_jenis_obat=apt_margin_harga.kd_jenis_obat and apt_golongan.kd_golongan=apt_margin_harga.kd_golongan');
		$results = $this->datatables->generate();
		echo ($results);		
	}
	
	
	
	
	public function periksapenjualan() {
		$msg=array();
		$submit=$this->input->post('submit');
		$no_penjualan=$this->input->post('no_penjualan');
		$no_pendaftaran=$this->input->post('no_pendaftaran');
		$is_lunas=$this->input->post('is_lunas');
		$tgl_penjualan=$this->input->post('tgl_penjualan');
		$shiftapt=$this->input->post('shiftapt');
		$tutup=$this->input->post('tutup');
		$kd_pasien=$this->input->post('kd_pasien');
		$nama_pasien=$this->input->post('nama_pasien');		
		$total_transaksi=$this->input->post('total_transaksi');
		$total_bayar=$this->input->post('total_bayar');
		//$kd_unit_kerja1=$this->input->post('kd_unit_kerja1');
		
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$qty=$this->input->post('qty');
		$qty11=$this->input->post('qty11');
		$tgl=$this->input->post('tgl');
		$hrg=$this->input->post('hrg'); 
		$racikan=$this->input->post('racikan');
		$adm_resep=$this->input->post('adm_resep');
		$total=$this->input->post('total');
		$nama_unit_apt=$this->input->post('nama_unit_apt');
		$milik=$this->input->post('milik');
		$jml_stok=$this->input->post('jml_stok');
		
		$total_transaksi=$this->input->post('total_transaksi');
		
		$tgl_pelayanan=$this->input->post('tgl_pelayanan');
		$jam_pelayanan=$this->input->post('jam_pelayanan');
		$jam_penjualan=$this->input->post('jam_penjualan');
		$qty=$this->input->post('qty');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="hapus"){
			if(empty($no_penjualan)){
				$msg['pesanatas']="Pilih Transaksi yang akan di hapus";
			}else{
				$this->mpenjualan->delete('apt_penjualan','no_penjualan="'.$no_penjualan.'"');
				$this->mpenjualan->delete('apt_penjualan_detail','no_penjualan="'.$no_penjualan.'"');
				$msg['pesanatas']="Data Berhasil Di Hapus";
			}
			$msg['status']=0;
			$msg['clearform']=1;
			echo json_encode($msg);
		}
		//else if($submit=="simpanbayar" or $submit=="bukatrans" or $submit=="tutuptrans" or $submit=="transferapotek"){}
		else if($submit=="simpanbayar" or $submit=="bukatrans" or $submit=="tutuptrans"){}
		else if($submit=="transferapotek"){
			if(empty($no_pendaftaran)){
				$msg['status']=0;
				//$nama=$this->mpenjualan->ambilNama($value);
				$msg['pesanlain'].="Anda tidak bisa melakukan transfer pembayaran tagihan apotek.<br/>";
			}
		}
		else{
			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value) {
					# code...
					if(empty($value))continue;
					
					if(empty($qty[$key])){
						$msg['status']=0;
						$nama=$this->mpenjualan->ambilNama($value);
						$msg['pesanlain'].="Qty ".$nama." Tidak boleh Kosong <br/>";					
					}
					if($this->mpenjualan->isNumberExist($no_penjualan)){
						if($qty[$key]>($jml_stok[$key]+$qty11[$key])) {
							$msg['status']=0;
							$nama=$this->mpenjualan->ambilNama($value);
							$msg['pesanlain'].="Stok ".$nama." tidak mencukupi <br/>";
						}												
					}else{
						if($qty[$key]>$jml_stok[$key]){
							$msg['status']=0;
							$nama=$this->mpenjualan->ambilNama($value);
							$msg['pesanlain'].="Stok ".$nama." tidak mencukupi <br/>";
						}						
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
		$items=$this->mpenjualan->getPenjualanWithPuskesmas($q);

		echo json_encode($items);
	}
	
	public function ambilitems()
	{
		$q=$this->input->get('query');
		$items=$this->mpenjualan->getAllDetailPenjualan($q);

		echo json_encode($items);
	}
	
	function sumberdana(){
		$query= $this->db->get('apt_unit');
		$items=$query->result_array();
		echo json_encode($items);
	}
	
	public function ambilpasienbynama(){
		$q=$this->input->get('query');
		$tes=$this->input->get('tes');
		$dor=$this->input->get('dor');
		$items=$this->mpenjualan->ambilDataPasien($q,$tes,$dor);
		echo json_encode($items);
	}
	
	public function hapuspembayaran(){
		$q=$this->input->post('query');	//no_penjualan
		$q1=$this->input->post('query1'); //no_pendaftaran
		//debugvar($q1);
		$is_lunas=0;
		$tutuptransaksi=0;
		$this->db->trans_start();
		$lunas=array('is_lunas'=>$is_lunas,'tutup'=>$tutuptransaksi);		
		$this->mpenjualan->update('apt_penjualan',$lunas,'no_penjualan="'.$q.'"');
		
		$item=$this->mpenjualan->getAllDetailPenjualan($q);
		//debugvar($item);
		foreach($item as $itemdetil){ 
			$kode=$itemdetil['kd_obat'];
			$kiteye=$itemdetil['qty'];
			$tglexpire=convertDate($itemdetil['tgl_expire']);
			$kd_unit_apt=$itemdetil['kd_unit_apt'];			
			$jml_stok=$this->mpenjualan->ambilStok($kd_unit_apt,$kode,$tglexpire);
			$stokakhir=$kiteye+$jml_stok;
			$datastoka=array('jml_stok'=>$stokakhir);
			$this->mpenjualan->update('apt_stok_unit',$datastoka,'kd_unit_apt="'.$kd_unit_apt.'" and kd_obat="'.$kode.'" and tgl_expire="'.$tglexpire.'"');			
		}		
		
		$id_bayar=$this->mpenjualan->jenisbayar($q);
		if($id_bayar=='002'){
			//$this->mpenjualan->delete('biaya_pelayanan','no_transaksiresep="'.$q.'" and no_pendaftaran="'.$q1.'" and kd_pelayanan="TROAPT"');			
			$this->mpenjualan->delete('biaya_pelayanan','no_transaksiresep="'.$q.'" and no_pendaftaran="'.$q1.'"');
		}
		$items=$this->mpenjualan->delete('apt_penjualan_bayar','no_penjualan="'.$q.'"');	
		$this->db->trans_complete();	
		echo json_encode($items);
	}
	
	public function bill($no_penjualan=""){
		//error_reporting(0);


		$tmpdir = sys_get_temp_dir(); # ambil direktori temporary untuk simpan file. 
		$file = tempnam($tmpdir, 'ctk.doc'); # nama file temporary yang akan dicetak ak
		$handle = fopen($file, 'w'); 
		$condensed = Chr(27) . Chr(33) . Chr(4); 
		$pagelength = Chr(27) . Chr(67) . Chr(48). Chr(6); 
		$bold1 = Chr(27) . Chr(69); 
		$bold0 = Chr(27) . Chr(70); 
		$initialized = chr(27).chr(64); 
		$condensed1 = chr(15); 
		$condensed0 = chr(18); 
		$right = chr(27).chr(97).chr(2); 
		$left = chr(27).chr(97).chr(0); 
		$center = chr(27).chr(97).chr(1); 
		
		//$kd_user=$this->session->userdata('id_user');
		$user=$this->mpenjualan->ambilnamauser();
		$item=$this->mpenjualan->ambilItemDataPenjualan($no_penjualan);
		$kd_pasien='';
		if($item['kd_pasien']==''){$kd_pasien="-";}
		else{$kd_pasien=$item['kd_pasien'];}
		
		$Data = $initialized; 
		$Data .= $condensed1; 
		//$Data .= $pagelength; 
		$Data .= "POLIKLINIK IBNUSINA (MUARA RAPAK BALIKPAPAN)\n"; 
		$Data .= "Faktur Standard Penjualan                                 Tunai\n"; 
		$Data .= "Print Date : ".date('d-m-Y h:i:s')."".str_pad($no_penjualan,30," ",STR_PAD_LEFT)."\n"; 
		$Data .= "Kasir      : ".$user."         \n"; 
		$Data .= "Pasien     : ".$kd_pasien." / ".$item['nama_pasien']."         \n"; 
		$Data .= "---------------------------------------------------------------\n"; 
		//$Data .= "No| ".$bold1."COBA CETAK".$bold0." |\n"; 
		$Data .= "No.| Nama Item                     | @Harga | Qty  |  Jml Harga\n"; 
		$Data .= "---------------------------------------------------------------\n"; 
		$subtotal=0;
		$no=1;
		$items=array();
		$items=$this->mpenjualan->getdetil($no_penjualan);		
		foreach ($items as $isi){
			# code...
			$Data .= "".$no."  | ".str_pad(substr($isi['nama_obat'],0,29),30," ",STR_PAD_RIGHT)."| ".str_pad($isi['harga_jual'], 5," ",STR_PAD_LEFT)."| ".str_pad($isi['qty'], 5," ",STR_PAD_LEFT)."| ".str_pad($isi['total'], 10," ",STR_PAD_LEFT)."\n"; 
			$subtotal=$subtotal+$isi['total'];
			$no++;
		}
		//$Data .= "02 | Sanmag Tab                    | 832    | 10   |       8316\n"; 
		$Data .= "---------------------------------------------------------------\n"; 
		$Data .= "Sub Total                          | Rp. ".str_pad($subtotal, 22," ",STR_PAD_LEFT)."\n"; 
		$Data .= "Grand Total                        | Rp. ".str_pad($subtotal, 22," ",STR_PAD_LEFT)."\n"; 
		$Data .= "                                   ".str_pad('', 28,"-",STR_PAD_LEFT)."\n"; 
		$Data .= "Jumlah Bayar                       | Rp. ".str_pad($subtotal, 22," ",STR_PAD_LEFT)."\n\n"; 
		$Data .= "----------------------Terima Kasih ----------------------------\n\n\n\n"; 
		fwrite($handle, $Data); 
		fclose($handle); 
		//copy($file.'images/logo.png', "//192.168.1.3/EPSONLX"); # Lakukan cetak 
		copy($file, "//PLANET-IT/EPSONLX"); # Lakukan cetak 
		unlink($file);
	}

	public function bill2($no_penjualan=""){
		//error_reporting(0);

            //Create ESC/POS commands for sample receipt
            $esc = '0x1B'; //ESC byte in hex notation
            $newLine = '0x0A'; //LF byte in hex notation

            $cmds = $esc . "@"; //Initializes the printer (ESC @)
            $cmds .= $esc . '!' . '0x38'; //Emphasized + Double-height + Double-width mode selected (ESC ! (8 + 16 + 32)) 56 dec => 38 hex
            $cmds .= 'BEST DEAL STORES'; //text to print
            $cmds .= $newLine . $newLine;
            $cmds .= $esc . '!' . '0x00'; //Character font A selected (ESC ! 0)
            $cmds .= 'COOKIES                   5.00'; 
            $cmds .= $newLine;
            $cmds .= 'MILK 65 Fl oz             3.78';
            $cmds .= $newLine + $newLine;
            $cmds .= 'SUBTOTAL                  8.78';
            $cmds .= $newLine;
            $cmds .= 'TAX 5%                    0.44';
            $cmds .= $newLine;
            $cmds .= 'TOTAL                     9.22';
            $cmds .= $newLine;
            $cmds .= 'CASH TEND                10.00';
            $cmds .= $newLine;
            $cmds .= 'CASH DUE                  0.78';
            $cmds .= $newLine + $newLine;
            $cmds .= $esc . '!' . '0x18'; //Emphasized + Double-height mode selected (ESC ! (16 + 8)) 24 dec => 18 hex
            $cmds .= '# ITEMS SOLD 2';
            $cmds .= $esc . '!' . '0x00'; //Character font A selected (ESC ! 0)
            $cmds .= $newLine . $newLine;
            $cmds .= '11/03/13  19:53:17';

            //Create a ClientPrintJob obj that will be processed at the client side by the WCPP
            $cpj = new ClientPrintJob();
            //set ESC/POS commands to print...
            $cpj->clientPrinter = new DefaultPrinter();
            $cpj->printerCommands = $cmds;
            $cpj->formatHexValues = true;

            ob_clean();
            echo $cpj->sendToClient();
            ob_end_flush(); 
            exit();
	}
	
	public function ambil_apt_obat(){
	    $kd_obat=$this->input->post('kd_obat');
	    $query=$this->db->query("SELECT * FROM apt_obat WHERE kd_obat='$kd_obat'")->row_array();
	    echo json_encode($query);
	    
	}
	
	public function ambil_semua_apt_obat(){
	    $query=$this->db->query("SELECT * FROM apt_obat")->result_array();
	    echo json_encode($query);
	    
	}
	
	public function sync_stok(){
	    // WHERE is_sync=0
	    $query=$this->db->query("SELECT * FROM apt_stok_unit")->result_array();
	    echo json_encode($query);
	    
	}
	
	public function update_sync_stok(){
	    $msg=array();
	    $this->db->query("Update apt_stok_unit SET is_sync=1");
	    $msg['status']=1;
	    echo json_encode($msg);
	    
	}
	
	public function upload_sbbk(){

		$msg=array();

		$datapenjualan=array('no_penjualan'=>$this->input->post('no_penjualan'),
								'is_lunas'=>1,
								'tgl_penjualan'=>convertDate($this->input->post('tgl_penjualan')),
								'shiftapt'=>$this->input->post('shiftapt'),
								'tutup'=>0,
								// 'kd_pasien'=>$kd_pasien,
								// 'nama_pasien'=>$nama_pasien,
								'cust_code'=>$this->input->post('customer_id'),
								'total_transaksi'=>$this->input->post('total_transaksi'),
								'total_bayar'=>$this->input->post('total_transaksi'),
								'no_pendaftaran'=>NULL,
								'status'=>0,
								'kirim'=>$this->input->post('status'),
								'bhp'=>0,
								'tgl_tutup'=>convertDate($this->input->post('tgl_penjualan')).' 00:00:00',
								//'kd_unit_apt' => $kd_unit_apt,
								'jenis_sbbk'=>$this->input->post('jenis_sbbk'),
								'kd_jenis_transaksi'=>$this->input->post('kd_jenis_transaksi'),
								'customer_id' => $this->input->post('customer_id'),
								'no_sbbk' => $this->input->post('no_sbbk'),
								'user_id' => $this->input->post('user_id'),
								);
			
			//cek apakah no_penjualan sudah ada
			$no_penjualan=$this->input->post('no_penjualan');
			$cek_penjualan=$this->db->query("SELECT no_penjualan FROM apt_penjualan WHERE no_penjualan='$no_penjualan'")->row_array();
			if(empty($cek_penjualan['no_penjualan'])){
			    $this->mpenjualan->insert('apt_penjualan',$datapenjualan);
			}else{
			    //aktifkan script dibawah ini jika tgl 27 nov anda sudah menyesuaikan ifk offline dgn online
			    
			    $this->mpenjualan->update('apt_penjualan',$datapenjualan,'no_penjualan="'.$no_penjualan.'"');
			    //mengembalikan stok di tabel apt_stok_unit
    			$itemsdetiltransaksi=$this->mpenjualan->getAllDetailPenjualan($no_penjualan);
    			foreach ($itemsdetiltransaksi as $itemdetil){
    				$jml_stok=0;
    				$sisastok=0;
    				$jml_stok=$this->mpenjualan->ambilStok($itemdetil['kd_unit_apt'],$itemdetil['kd_obat'],convertDate($itemdetil['tgl_expire']),$itemdetil['kd_pabrik'],$itemdetil['batch'],$itemdetil['harga_jual']);
    				//$jml_stok=$this->mpenjualan->ambilStok($itemdetil['kd_unit_apt'],$itemdetil['kd_obat'],convertDate($itemdetil['tgl_expire']));
    				$sisastok=$jml_stok+$itemdetil['qty'];
    				$datastok=array('jml_stok'=>$sisastok);
    				$this->mpenjualan->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$itemdetil['kd_unit_apt'].'" and kd_obat="'.$itemdetil['kd_obat'].'" and tgl_expire="'.convertDate($itemdetil['tgl_expire']).'"  and kd_pabrik="'.$itemdetil['kd_pabrik'].'" and batch="'.$itemdetil['batch'].'"  and harga_pokok="'.$itemdetil['harga_jual'].'" ');
    			}
			    
			    $this->db->query("Delete from apt_penjualan_detail WHERE no_penjualan='$no_penjualan'");
			    
			}
			

			$urut=1;
			$jum=count($this->input->post('detil'));

			for ($i=0; $i < $jum; $i++) {  
				
				$datadetil=array('no_penjualan'=>$this->input->post('no_penjualan'),
								'urut'=>$urut,
								'kd_unit_apt'=>$this->input->post('detil')[$i]['kd_unit_apt'],
								'kd_obat'=>$this->input->post('detil')[$i]['kd_obat'],
								'kd_milik'=>$this->input->post('detil')[$i]['kd_milik'],
								'tgl_expire'=>convertDate($this->input->post('detil')[$i]['tgl_expire']),
								'qty'=>$this->input->post('detil')[$i]['qty'],
								'qty_kecil'=>$this->input->post('detil')[$i]['qty_kecil'],
								'batch'=>$this->input->post('detil')[$i]['batch'],
								'kd_pabrik'=>$this->input->post('detil')[$i]['kd_pabrik'],
								'harga_pokok'=>$this->input->post('detil')[$i]['harga_pokok'],
								'harga_jual'=>$this->input->post('detil')[$i]['harga_jual'],
								'total'=>$this->input->post('detil')[$i]['harga_pokok']*$this->input->post('detil')[$i]['harga_pokok'],
								'markup'=>0,
								'tgl_keluar' => convertDate($this->input->post('detil')[$i]['tgl_keluar']),
								);
				$this->mpenjualan->insert('apt_penjualan_detail',$datadetil);
				
				//update stok masing-masing obat
				$jml_stok=$this->mpenjualan->ambilStok($this->input->post('detil')[$i]['kd_unit_apt'],$this->input->post('detil')[$i]['kd_obat'],convertDate($this->input->post('detil')[$i]['tgl_expire']),$this->input->post('detil')[$i]['kd_pabrik'],$this->input->post('detil')[$i]['batch'],$this->input->post('detil')[$i]['harga_jual']);
				$sisastok=$jml_stok-$this->input->post('detil')[$i]['qty'];
				$datastok=array('jml_stok'=>$sisastok);
				$this->mpenjualan->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$this->input->post('detil')[$i]['kd_unit_apt'].'" and kd_obat="'.$this->input->post('detil')[$i]['kd_obat'].'" and tgl_expire="'.convertDate($this->input->post('detil')[$i]['tgl_expire']).'" and kd_pabrik="'.$this->input->post('detil')[$i]['kd_pabrik'].'" and batch="'.$this->input->post('detil')[$i]['batch'].'" and harga_pokok="'.$this->input->post('detil')[$i]['harga_jual'].'" ');
				$urut++;				
			}

		$msg['status']=1;
		$msg['no_penjualan']=$this->input->post('no_penjualan');


		
		
		
		$penjualan = $this->mpenjualan->getPenjualanWithPuskesmas($no_penjualan);
        $items = $this->mpenjualan->getAllDetailObatKeluar2($no_penjualan);
		$this->mpenjualan->updatekirim($no_penjualan); //update tanggal kirim
		$simoifk = $this->load->database('default', TRUE);
		$simodb = $this->load->database('simo', TRUE);
		$puskesmas = $simodb->get_where('simpus_puskesmas',array('kode'=>$penjualan['kode_puskesmas']))->row_array();
        
        $stat=1;
		if(!empty($penjualan['no_penerimaan_simo'])){
			$no_penerimaan = $penjualan['no_penerimaan_simo'];
			$penerimaan = $simodb->get_where('apt_penerimaan',array('no_penerimaan'=>$penjualan['no_penerimaan_simo']))->row_array();
			if($penerimaan['posting']==1){
			    $stat=0;
				$this->db->db_select('default');
				$this->db->update('apt_penjualan',array('kirim'=>1),array('no_penjualan'=>$no_penjualan));
				//die('data sudah di tutup transaksi, tidak bisa di update lagi');
			}else{
			    $tgl_penerimaan=$penerimaan['tgl_penerimaan'];
			    $start_here=$penerimaan['start_here'];
			    $simodb->delete('apt_penerimaan_detail',array('no_penerimaan' => $no_penerimaan));
			    $simodb->delete('apt_penerimaan',array('no_penerimaan' => $no_penerimaan));
			}
			
		}else{
			$simodb->select('max(right(apt_penerimaan.no_penerimaan,3)) as a',false);
			$simodb->where('year(apt_penerimaan.tgl_penerimaan)',date('Y'));
			$simodb->where('month(apt_penerimaan.tgl_penerimaan)',date('m'));
			//$this->db->join('apt_penerimaan_detail','apt_penerimaan_detail.no_penerimaan=apt_penerimaan.no_penerimaan');
			//$this->db->where('a.type',1);
			$query=$simodb->get("apt_penerimaan");
			$item= $query->row_array();
			if($item['a']>=999){ //ada kasus urut sudah sampai 999 padahal 100-700 masih kosong
			    $simodb->select('max(right(apt_penerimaan.no_penerimaan,3)) as a',false);
    			$simodb->where('year(apt_penerimaan.tgl_penerimaan)',date('Y'));
    			$simodb->where('month(apt_penerimaan.tgl_penerimaan)',date('m'));
    			$simodb->where("date(apt_penerimaan.tgl_penerimaan) >= '2021-04-20'");
    			$simodb->where("start_here",1);
    			$query=$simodb->get("apt_penerimaan");
    			$item= $query->row_array();
			}
			$last_number=$item['a'];
			
			$kodebaru=$last_number+1;
			$kodebaru=str_pad($kodebaru,3,0,STR_PAD_LEFT); 
			$no_penerimaan="TRM.".date('Y').".".date('m').".".$kodebaru;
			$tgl_penerimaan=date('Y-m-d H:i:s');
			$start_here=1;

		}
		
		if($this->input->post('status')==1 AND !empty($puskesmas)){
		    if($stat==1){
		        $datapenerimaan=array('no_penerimaan'=>$no_penerimaan,
    								'no_faktur'=>$penjualan['no_sbbk'],
    								'tgl_faktur'=>convertDate($penjualan['tgl_penjualan']),
    								'shift'=>1,
    								'kd_unit_apt'=>null,
    								'kd_supplier'=>'DS0118',
    								//'tgl_penerimaan'=>convertDate($tgl_penerimaan),
    								'tgl_penerimaan'=>$tgl_penerimaan,
    								'posting'=>0,
    								'jumlah'=>0,
    								'materai'=>0,
    								'tgl_tempo'=>null,
    								'lunas'=>0,
    								'retur'=>0,
    								'keterangan'=>'',
    								'discount'=>'',
    								'id_puskesmas'=> $puskesmas['id'],
    								'jenis_sbbk'=> $penjualan['jenis_sbbk'],
    								'kd_jenis_transaksi'=> $penjualan['kd_jenis_transaksi'],
    								'kd_user'=>null);
    			
    			$datapenerimaan['start_here']=$start_here;
    			
    			
    		
        		$simodb->insert('apt_penerimaan',$datapenerimaan);
        		$urut=1;
        		$urut_pesan=1;
        		$jumlah = 0;
        		foreach ($items as $item){
        			# code...
        			if(empty($item))continue;	
        			//if($no_pemesanan[$key]==''){$urut_pesan='';}
        			$datadetil=array('no_penerimaan'=>$no_penerimaan,
        							'urut'=>$urut,
        							'kd_unit_apt'=>$item['kd_unit_apt'],
        							'kd_obat'=>$item['kd_obat'],
        							'kd_milik'=>$item['kd_milik'],
        							'tgl_expire'=>convertDate($item['tgl_expire']),
        							'harga_beli'=>($item['harga_pokok']/($item['qty_kecil']/$item['qty'])),
        							'qty_box'=>$item['qty'],
        							'qty_kcl'=>$item['qty_kecil'],
        						//	'disc_prs'=>$disc_prs[$key],
        							//'harga_belidisc'=>$harga_belidisc[$key],
        							//'ppn_item'=>$ppn_item[$key],
        							'bonus'=>0,
        							//'no_pemesanan'=>$no_pemesanan[$key],
        							'urut_pesan'=>null,
        							'tgl_entry'=>date('Y-m-d H:i:s'),
        							'id_puskesmas'=> $puskesmas['id'],
        							'no_batch'=>$item['batch'],
        							'update'=>null);
        							//'isidiskon'=>$isidiskon[$key],
        							//'no_batch'=>$no_batch[$key]);
        
        			$simodb->insert('apt_penerimaan_detail',$datadetil);
        
        			//$updateobat=array('harga_beli'=>$harga_beli[$key]);
        			//$this->mpenerimaanapt->update('apt_obat',$updateobat,'kd_obat="'.$value.'"');
        			$jumlah += $item['qty']*$item['harga_pokok'];
        			$urut++;
        			$urut_pesan++;
        		}
        		$datatotal=array('jumlah'=>$jumlah);
        		$simodb->update('apt_penerimaan',$datatotal,array('no_penerimaan'=>$no_penerimaan));
        		$simodb->close();
        		$this->db->db_select('default');
        		$this->db->update('apt_penjualan',
        							array('no_penerimaan_simo'=>$no_penerimaan),
        							array('no_penjualan' => $no_penjualan)
        						);
		        $msg['pesan']=$this->kirim2($this->input->post('no_penjualan'));
		        
		    }else{
		        $msg['pesan']='data sudah di tutup transaksi, tidak bisa di update lagi';
		    }
		    
		    
		    
		   
		}else{
		    $msg['pesan']="Berhasil upload ! No.Penjualan : ".$no_penjualan;
		}
		

		echo json_encode($msg);

	}

	public function kirim2($no_penjualan)
	{
		return "Berhasil upload ! No.Penjualan : ".$no_penjualan;
	}
	
	public function send($no_penjualan)
	{
        
    		

	}

	public function kirim($no_penjualan)
	{
        $penjualan = $this->mpenjualan->getPenjualanWithPuskesmas($no_penjualan);
        $items = $this->mpenjualan->getAllDetailObatKeluar2($no_penjualan);
		$this->mpenjualan->updatekirim($no_penjualan);
		$simoifk = $this->load->database('default', TRUE);
		$simodb = $this->load->database('simo', TRUE);
		$puskesmas = $simodb->get_where('simpus_puskesmas',array('kode'=>$penjualan['kode_puskesmas']))->row_array();

		if(!empty($penjualan['no_penerimaan_simo'])){
			$no_penerimaan = $penjualan['no_penerimaan_simo'];
			$penerimaan = $simodb->get_where('apt_penerimaan',array('no_penerimaan'=>$penjualan['no_penerimaan_simo']))->row_array();
			if($penerimaan['posting']==1){
				$this->db->db_select('default');
				$this->db->update('apt_penjualan',array('kirim'=>1),array('no_penjualan'=>$no_penjualan));
				die('data sudah di tutup transaksi, tidak bisa di update lagi');
			}
			$simodb->delete('apt_penerimaan_detail',array('no_penerimaan' => $no_penerimaan));
			$simodb->delete('apt_penerimaan',array('no_penerimaan' => $no_penerimaan));
		}else{
			$simodb->select('max(right(apt_penerimaan.no_penerimaan,3)) as a',false);
			$simodb->where('year(apt_penerimaan.tgl_penerimaan)',date('Y'));
			$simodb->where('month(apt_penerimaan.tgl_penerimaan)',date('m'));
			//$this->db->join('apt_penerimaan_detail','apt_penerimaan_detail.no_penerimaan=apt_penerimaan.no_penerimaan');
			//$this->db->where('a.type',1);
			$query=$simodb->get("apt_penerimaan");
			$item= $query->row_array();
			$kodebaru=$item['a']+1;
			$kodebaru=str_pad($kodebaru,3,0,STR_PAD_LEFT); 
			$no_penerimaan="TRM.".date('Y').".".date('m').".".$kodebaru;

		}
		$datapenerimaan=array('no_penerimaan'=>$no_penerimaan,
								'no_faktur'=>$penjualan['no_sbbk'],
								'tgl_faktur'=>convertDate($penjualan['tgl_penjualan']),
								'shift'=>1,
								'kd_unit_apt'=>null,
								'kd_supplier'=>'DS0118',
								//'tgl_penerimaan'=>convertDate($tgl_penerimaan),
								'tgl_penerimaan'=>date('Y-m-d H:i:s'),
								'posting'=>0,
								'jumlah'=>0,
								'materai'=>0,
								'tgl_tempo'=>null,
								'lunas'=>0,
								'retur'=>0,
								'keterangan'=>'',
								'discount'=>'',
								'id_puskesmas'=> $puskesmas['id'],
								'jenis_sbbk'=> $penjualan['jenis_sbbk'],
								'kd_jenis_transaksi'=> $penjualan['kd_jenis_transaksi'],
								'kd_user'=>null);
		
		$simodb->insert('apt_penerimaan',$datapenerimaan);
		$urut=1;
		$urut_pesan=1;
		$jumlah = 0;
		foreach ($items as $item){
			# code...
			if(empty($item))continue;	
			//if($no_pemesanan[$key]==''){$urut_pesan='';}
			$datadetil=array('no_penerimaan'=>$no_penerimaan,
							'urut'=>$urut,
							'kd_unit_apt'=>$item['kd_unit_apt'],
							'kd_obat'=>$item['kd_obat'],
							'kd_milik'=>$item['kd_milik'],
							'tgl_expire'=>convertDate($item['tgl_expire']),
							'harga_beli'=>($item['harga_pokok']/($item['qty_kecil']/$item['qty'])),
							'qty_box'=>$item['qty'],
							'qty_kcl'=>$item['qty_kecil'],
						//	'disc_prs'=>$disc_prs[$key],
							//'harga_belidisc'=>$harga_belidisc[$key],
							//'ppn_item'=>$ppn_item[$key],
							'bonus'=>0,
							//'no_pemesanan'=>$no_pemesanan[$key],
							'urut_pesan'=>null,
							'tgl_entry'=>date('Y-m-d H:i:s'),
							'id_puskesmas'=> $puskesmas['id'],
							'no_batch'=>$item['batch'],
							'update'=>null);
							//'isidiskon'=>$isidiskon[$key],
							//'no_batch'=>$no_batch[$key]);

			$simodb->insert('apt_penerimaan_detail',$datadetil);

			//$updateobat=array('harga_beli'=>$harga_beli[$key]);
			//$this->mpenerimaanapt->update('apt_obat',$updateobat,'kd_obat="'.$value.'"');
			$jumlah += $item['qty']*$item['harga_pokok'];
			$urut++;
			$urut_pesan++;
		}
		$datatotal=array('jumlah'=>$jumlah);
		$simodb->update('apt_penerimaan',$datatotal,array('no_penerimaan'=>$no_penerimaan));
		$simodb->close();
		$this->db->db_select('default');
		$this->db->update('apt_penjualan',
							array('no_penerimaan_simo'=>$no_penerimaan,'kirim'=>1),
							array('no_penjualan' => $no_penjualan)
						);

		redirect('transapotek/penjualan');
	}

	public function cetakSbbkExcel($no_penjualan) {
		if(empty($no_penjualan)) {
            return false;
        }
        $this->load->library('phpexcel'); 
        $this->load->library('PHPExcel/iofactory');
        $objPHPExcel = new PHPExcel();
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $sheet->getPageMargins()
        	->setLeft(.1)
        	->setRight(.1);


        $profil = $this->mmain->getRow('profil');
        //$id_kepala = $profil['kepala_id'];
        //$kepala = $this->mmain->getRow('pegawai', "id_pegawai = $id_kepala");

        $penjualan = $this->mpenjualan->getPenjualanWithPuskesmas($no_penjualan);
        $userPegawai = $this->mmain->getPegawaiByUser($penjualan['user_id']);

        $timestamp = strtotime($penjualan['tgl_penjualan']);

        // set columns width : 134 total
        $sheet->getColumnDimension('A')->setWidth(5); // no
        $sheet->getColumnDimension('B')->setWidth(15); // nama barang
        $sheet->getColumnDimension('C')->setWidth(12); 
        $sheet->getColumnDimension('D')->setWidth(8); // jumlah
        $sheet->getColumnDimension('E')->setWidth(10); // harga jual
        $sheet->getColumnDimension('F')->setWidth(10); // subtotal
        $sheet->getColumnDimension('G')->setWidth(15); // no batch
        $sheet->getColumnDimension('H')->setWidth(11); // no batch
        $sheet->getColumnDimension('I')->setWidth(11); // no batch
        $sheet->getColumnDimension('J')->setWidth(7.5); // no batch

        //merge cells for title and description
        for($i = 1; $i <= 6; $i++) {
            $sheet->mergeCells('A'. $i . ':J' . $i);
        }

        $sheet->mergeCells('A7:B7');
        $sheet->mergeCells('C7:F7');
        $sheet->mergeCells('A8:B8');
        $sheet->mergeCells('C8:H8');

        // define the styleArray to use for the rest of this sheet
        $styleArray = array(
            'font' => array (
                'bold' => true,
                'name' => 'calibri',
                'size' => 11,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
            ),
            'borders' => array(),
        );

        $styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        $sheet->getStyle('A4:H6')->applyFromArray($styleArray);
        // change
        $sheet->setCellValue('A1', 'INSTALASI FARMASI KOTA BALIKPAPAN');
        $sheet->setCellValue('A2', 'JL. MANGGA NO.21 TELP. 736094');
        $sheet->setCellValue('A4', 'SURAT BUKTI BARANG KELUAR');
        $sheet->setCellValue('A5', 'NO: ' . $penjualan['no_sbbk']);

       // $sheet->getStyle('A7:G8')->applyFromArray($styleArray);
        $sheet->setCellValue('A7', 'PUSKESMAS');
        $sheet->setCellValue('C7', ': ' . $penjualan['nama_puskesmas']);
        $sheet->setCellValue('A8', 'BULAN');
        $sheet->setCellValue('C8', ': ' . $this->mmain->getBulanIndonesia(date('m', $timestamp)));
        
        // // set styles for table headings
        $styleArray['borders'] = array(
        	'allborders' => array(
	            'style' => PHPExcel_Style_Border::BORDER_THIN, 
	            'color' => array('rgb' => '000000')
        	),
        );
        $styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        $styleArray['alignment']['wrapText'] = true;
        $styleArray['font']['size'] = 11;

        // set the heading style and values
        $sheet->getStyle('A9:J9')->applyFromArray($styleArray);
        $sheet->mergeCells('B9:C9');

        $sheet->setCellValue('A9', 'NO.');
        $sheet->setCellValue('B9', 'NAMA BARANG');
        $sheet->setCellValue('D9', 'JUMLAH');
        $sheet->setCellValue('E9', 'HARGA');
        $sheet->setCellValue('F9', 'TOTAL');
        $sheet->setCellValue('G9', 'BATCH');
        $sheet->setCellValue('H9', 'TGL ED');
        $sheet->setCellValue('I9', 'KET');
        $sheet->setCellValue('J9', 'SUMBER');

        // datacells value
//			'itemsdetiltransaksi'=>$this->mpenjualan->getAllDetailObatKeluar2($no_penjualan),

        $items = $this->mpenjualan->getAllDetailObatKeluar2($no_penjualan);

        $rowOffset = 9;
        $counter = 0;

        $styleArray['font']['bold'] = false;
        $total=0;
        foreach($items as $item) {
            $rowCellNum = ++$counter + $rowOffset;
            $sheet->mergeCells('B' . $rowCellNum . ':C' . $rowCellNum);

            $styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
            $sheet->getStyle('D' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->getStyle('G' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->getStyle('H' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->getStyle('I' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->getStyle('J' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->setCellValueExplicit('D' . $rowCellNum, number_format($item['qty'],0,' ','.'));        // col 3: qty
            $sheet->setCellValueExplicit('E' . $rowCellNum, number_format(round($item['harga_jual']),0,',','.'));        // col 3: qty
            $sheet->setCellValueExplicit('F' . $rowCellNum, number_format($item['qty']*round($item['harga_jual']),0,',','.'));       // col 6: tgl_expire
            $sheet->setCellValue('G' . $rowCellNum, $item['batch']);       // col 6: tgl_expire
            $sheet->setCellValue('G' . $rowCellNum, $item['batch']);       // col 6: tgl_expire
            $sheet->setCellValue('H' . $rowCellNum, $item['tgl_expire']);       // col 6: tgl_expire
            $sheet->setCellValue('I' . $rowCellNum, $item['tgl_keluar']);       // col 6: tgl_expire
            $sheet->setCellValue('J' . $rowCellNum, $item['nama_unit_apt']);         // col 7: keterangan/ tgl_keluar
            $total=$total+($item['qty']*$item['harga_jual']);
            $styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
            $sheet->getStyle('A' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->getStyle('E' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->getStyle('F' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->setCellValue('A' . $rowCellNum, $counter);                  // col 1: no
           // $sheet->setCellValue('E' . $rowCellNum, number_format($item['harga_jual'], 2, '.',','));     // col 4: harga_jual
            //$sheet->setCellValue('F' . $rowCellNum, number_format($item['total'], 2, '.',','));    // col 5: subtotal

            $styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
            $sheet->getStyle('B' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->getStyle('C' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->setCellValue('B' . $rowCellNum, $item['nama_obat']);   // col 2: nama obat
            $sheet->getStyle('B' . $rowCellNum)->getAlignment()->setWrapText(true);
        }
        	$rowCellNum++;
            $styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
            $sheet->getStyle('A' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->getStyle('E' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->getStyle('F' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->getStyle('B' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->getStyle('C' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->getStyle('D' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->getStyle('G' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->getStyle('H' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->getStyle('I' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->getStyle('J' . $rowCellNum)->applyFromArray($styleArray);
            $sheet->mergeCells('B' . $rowCellNum . ':C' . $rowCellNum);
            $sheet->setCellValue('A' . $rowCellNum, '');                  // col 1: no
            $sheet->setCellValue('B' . $rowCellNum, 'T O T A L');                  // col 1: no
            $sheet->setCellValue('D' . $rowCellNum, '');        // col 3: qty
            $sheet->setCellValue('E' . $rowCellNum, '');        // col 3: qty
            $sheet->setCellValueExplicit('F' . $rowCellNum, number_format($total,0,'','.'));       // col 6: tgl_expire
            $sheet->setCellValue('G' . $rowCellNum, '');       // col 6: tgl_expire
            $sheet->setCellValue('H' . $rowCellNum, '');       // col 6: tgl_expire
            $sheet->setCellValue('I' . $rowCellNum, '');       // col 6: tgl_expire
            $sheet->setCellValue('J' . $rowCellNum, '');         // col 7: keterangan/ tgl_keluar

        // table footer
        $rowCellNum = ++$counter + $rowOffset;

        $rowCellNum += 2;

        $styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        $styleArray['borders'] = array();
        $styleArray['font']['bold'] = false;

        $sheet->getStyle('G'. $rowCellNum . ':I' . $rowCellNum)->applyFromArray($styleArray);
        $sheet->mergeCells('G'. $rowCellNum . ':I' . $rowCellNum);
        $sheet->setCellValue('G' . $rowCellNum, $profil['kota'] . ', ' . date('d', $timestamp) . ' ' . $this->mmain->getBulanIndonesia(date('m', $timestamp)) . ' ' . date('Y', $timestamp));

        $rowCellNum++;
        $sheet->getStyle('A'. $rowCellNum . ':C' . $rowCellNum)->applyFromArray($styleArray);
        $sheet->mergeCells('A' . $rowCellNum . ':C' . $rowCellNum);
        $sheet->setCellValue('A' . $rowCellNum, 'Mengetahui,');

        $rowCellNum++;
        $sheet->getStyle('A'. $rowCellNum . ':C' . $rowCellNum)->applyFromArray($styleArray);
        $sheet->mergeCells('A' . $rowCellNum . ':C' . $rowCellNum);
        $sheet->setCellValue('A' . $rowCellNum, 'Kepala Instalasi Farmasi');

        $sheet->getStyle('D' . $rowCellNum . ':F' . $rowCellNum)->applyFromArray($styleArray);
        $sheet->mergeCells('D' . $rowCellNum . ':F' . $rowCellNum);
       	$sheet->setCellValue('D' . $rowCellNum, 'Yang Menyerahkan,');

        $sheet->getStyle('G' . $rowCellNum . ':I' . $rowCellNum)->applyFromArray($styleArray);
        $sheet->mergeCells('G' . $rowCellNum . ':I' . $rowCellNum);
        $sheet->setCellValue('G' . $rowCellNum, 'Yang Menerima,');

        $rowCellNum += 4;
        $sheet->getStyle('A'. $rowCellNum . ':C' . $rowCellNum)->applyFromArray($styleArray);
        $sheet->mergeCells('A' . $rowCellNum . ':C' . $rowCellNum);
        $sheet->setCellValue('A' . $rowCellNum, $profil['nama_kepala']);

        $sheet->getStyle('D' . $rowCellNum . ':F' . $rowCellNum)->applyFromArray($styleArray);
        $sheet->mergeCells('D' . $rowCellNum . ':F' . $rowCellNum);
        $sheet->setCellValue('D' . $rowCellNum, 'Marsudiyanti Ningtyas');

        $sheet->getStyle('G' . $rowCellNum . ':I' . $rowCellNum)->applyFromArray($styleArray);
        $sheet->mergeCells('G' . $rowCellNum . ':I' . $rowCellNum);
        $sheet->setCellValue('G' . $rowCellNum, '..................');

        $rowCellNum++;
        $sheet->getStyle('A'. $rowCellNum . ':C' . $rowCellNum)->applyFromArray($styleArray);
        $sheet->mergeCells('A' . $rowCellNum . ':C' . $rowCellNum);
        $sheet->setCellValue('A' . $rowCellNum, $profil['nip_kepala']);

        $sheet->getStyle('D' . $rowCellNum . ':F' . $rowCellNum)->applyFromArray($styleArray);
        $sheet->mergeCells('D' . $rowCellNum . ':F' . $rowCellNum);
        $sheet->setCellValue('D' . $rowCellNum, 'Nip. 19750707 200604 2 008');

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save("download/sbbk.xls");
        header("Location: ".base_url()."download/sbbk.xls");
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
