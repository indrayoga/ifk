<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mutasi extends CI_Controller {

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
		$this->load->model('logistik/mmutasi');
	}
	
	public function index(){ //kalo di apotek yg function mutasiobat di laporanapt
		$kd_lokasi=$this->session->userdata('kd_lokasi');
		$bulan=date('m');
		$tahun=date('Y');
		/*if($this->input->post('kd_unit_apt')!=''){
			$kd_unit_apt=$this->input->post('kd_unit_apt');
		}*/
		if($this->input->post('bulan')!=''){
			$bulan=$this->input->post('bulan');
		}
		if($this->input->post('tahun')!=''){
			$tahun=$this->input->post('tahun');
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
		$data=array('items'=>$this->mmutasi->getMutasiBarang($kd_lokasi,$bulan,$tahun),
					//'items'=>$this->mmutasi->getObat($kd_unit_apt,$bulan,$tahun), //nanti bikin query bwt manggil dari tabel apt_mutasi_obat
					//'items'=>$this->mmutasi->getMutasiObat($bulan,$tahun),
					'kd_lokasi'=>$kd_lokasi,
					'bulan'=>$bulan,
					'tahun'=>$tahun
					);
		//debugvar($data);
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/transaksi/mutasi/mutasi',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function carimutasibarang(){
		//$kd_unit_apt=$this->input->post('kd_unit_apt');
		$kd_lokasi=$this->session->userdata('kd_lokasi');
		$bulan=$this->input->post('bulan');
		$tahun=$this->input->post('tahun');
		$submit=$this->input->post('submit');
		$items=array();
		$msg=array();
		
		if($bulan=='01'){$bulan2=1;}
		if($bulan=='02'){$bulan2=2;}
		if($bulan=='03'){$bulan2=3;}
		if($bulan=='04'){$bulan2=4;}
		if($bulan=='05'){$bulan2=5;}
		if($bulan=='06'){$bulan2=6;}
		if($bulan=='07'){$bulan2=7;}
		if($bulan=='08'){$bulan2=8;}
		if($bulan=='09'){$bulan2=9;}
		if($bulan=='10'){$bulan2=10;}
		if($bulan=='11'){$bulan2=11;}
		if($bulan=='12'){$bulan2=12;}
		
		$a=$bulan2-1;   if($a=='0'){$a1='12';$b=$tahun-1;} //kalo dy mutasi obatnya bulan januari
						if($a=='1'){$a1='01';$b=$tahun;}
						if($a=='2'){$a1='02';$b=$tahun;}
						if($a=='3'){$a1='03';$b=$tahun;}
						if($a=='4'){$a1='04';$b=$tahun;}
						if($a=='5'){$a1='05';$b=$tahun;}
						if($a=='6'){$a1='06';$b=$tahun;}
						if($a=='7'){$a1='07';$b=$tahun;}
						if($a=='8'){$a1='08';$b=$tahun;}
						if($a=='9'){$a1='09';$b=$tahun;}
						if($a=='10'){$a1='10';$b=$tahun;}
						if($a=='11'){$a1='11';$b=$tahun;} //kalo dy mutasi obatnya bulan desember
		
		$terima=$this->mmutasi->getPenerimaan($bulan,$tahun); //masuk_penerimaan
		if(!empty($terima)){
			foreach($terima as $satu){
				$kd_barang=$satu['kd_barang'];
				$qty=$satu['jml_penerimaan'];
				if($this->mmutasi->isBarangExist($kd_barang,$bulan,$tahun)){
					$data=array('masuk_penerimaan'=>$qty);
					$this->mmutasi->update('log_mutasi_barang',$data,'kd_lokasi="'.$kd_lokasi.'" and kd_barang="'.$kd_barang.'" and bulan="'.$bulan.'" and "'.$tahun.'"');
				}
				else{
					$data=array('tahun'=>$tahun,'bulan'=>$bulan,'kd_barang'=>$kd_barang,'kd_lokasi'=>$kd_lokasi,'masuk_penerimaan'=>$qty);
					$this->mmutasi->insert('log_mutasi_barang',$data);
				
				}
			}
		}
		
		$terimadistribusi=$this->mmutasi->getDistribusi1($bulan,$tahun); //masuk distribusi --->kd_unit_tujuan
		if(!empty($terimadistribusi)){
			foreach($terimadistribusi as $dua){
				$kd_barang=$dua['kd_barang'];
				$qtydis=$dua['jml_distribusi'];
				if($this->mmutasi->isBarangExist($kd_barang,$bulan,$tahun)){
					$data=array('masuk_distribusi'=>$qtydis);
					$this->mmutasi->update('log_mutasi_barang',$data,'kd_lokasi="'.$kd_lokasi.'" and kd_barang="'.$kd_barang.'" and bulan="'.$bulan.'" and "'.$tahun.'"');
				}
				else{
					$data=array('tahun'=>$tahun,'bulan'=>$bulan,'kd_barang'=>$kd_barang,'kd_lokasi'=>$kd_lokasi,'masuk_distribusi'=>$qtydis);
					$this->mmutasi->insert('log_mutasi_barang',$data);
				}
			}
		}
		
		$keluardistribusi=$this->mmutasi->getDistribusi($bulan,$tahun); //keluar distribusi --->kd_unit_asal
		if(!empty($keluardistribusi)){
			foreach($keluardistribusi as $tiga){
				$kd_barang=$tiga['kd_barang'];
				$qtydis=$tiga['jml_distribusi'];
				if($this->mmutasi->isBarangExist($kd_barang,$bulan,$tahun)){
					$data=array('keluar_distribusi'=>$qtydis);
					$this->mmutasi->update('log_mutasi_barang',$data,'kd_lokasi="'.$kd_lokasi.'" and kd_barang="'.$kd_barang.'" and bulan="'.$bulan.'" and "'.$tahun.'"');
				}
				else{
					$data=array('tahun'=>$tahun,'bulan'=>$bulan,'kd_barang'=>$kd_barang,'kd_lokasi'=>$kd_lokasi,'keluar_distribusi'=>$qtydis);
					$this->mmutasi->insert('log_mutasi_barang',$data);
				}
			}
		}
		
		$keluarpakai=$this->mmutasi->getPemakaian($bulan,$tahun); 
		if(!empty($keluarpakai)){
			foreach($keluarpakai as $empat){
				$kd_barang=$empat['kd_barang'];
				$qty=$empat['jml_pemakaian'];
				if($this->mmutasi->isBarangExist($kd_barang,$bulan,$tahun)){
					$data=array('keluar_pemakaian'=>$qty);
					$this->mmutasi->update('log_mutasi_barang',$data,'kd_lokasi="'.$kd_lokasi.'" and kd_barang="'.$kd_barang.'" and bulan="'.$bulan.'" and "'.$tahun.'"');
				}
				else{
					$data=array('tahun'=>$tahun,'bulan'=>$bulan,'kd_barang'=>$kd_barang,'kd_lokasi'=>$kd_lokasi,'keluar_pemakaian'=>$qty);
					$this->mmutasi->insert('log_mutasi_barang',$data);
				}
			}
		}
		
		$stokopname=$this->mmutasi->getStokopname($bulan,$tahun); 
		if(!empty($stokopname)){
			foreach($stokopname as $lima){
				$kd_barang=$lima['kd_barang'];
				$qty=$lima['stok_opname'];
				if($this->mmutasi->isBarangExist($kd_barang,$bulan,$tahun)){
					$data=array('stok_opname'=>$qty);
					$this->mmutasi->update('log_mutasi_barang',$data,'kd_lokasi="'.$kd_lokasi.'" and kd_barang="'.$kd_barang.'" and bulan="'.$bulan.'" and "'.$tahun.'"');
				}
				else{
					$data=array('tahun'=>$tahun,'bulan'=>$bulan,'kd_barang'=>$kd_barang,'kd_lokasi'=>$kd_lokasi,'stok_opname'=>$qty);
					$this->mmutasi->insert('log_mutasi_barang',$data);
				}
			}
		}
		
		
		$barang=$this->mmutasi->ambilBarang($bulan,$tahun);
		if(!empty($barang)){ //kalo misalnya data bulan sebelumnya ada
			foreach($barang as $enam){
				$kd_barang=$enam['kd_barang'];
				$saldo_awal=$this->mmutasi->saldoawal($b,$a1,$kd_barang);
				if($saldo_awal==''){ //kalo yg bulan kmrn ga ada
					//stok+out_unit+out_jual+retur_pbf-in_pbf-in_unit-retur_jual
					$stok=$this->mmutasi->ambilstok($kd_barang);					
					$masuk_penerimaan=$this->mmutasi->masukpenerimaan($bulan,$tahun,$kd_barang);
					$masuk_distribusi=$this->mmutasi->masukdistribusi($bulan,$tahun,$kd_barang);
					$keluar_distribusi=$this->mmutasi->keluardistribusi($bulan,$tahun,$kd_barang);
					$keluar_pemakaian=$this->mmutasi->keluarpemakaian($bulan,$tahun,$kd_barang);
					$stokop=$this->mmutasi->stokopname($bulan,$tahun,$kd_barang);
					//$saldo_awal=$stok+$keluar_distribusi+$keluar_pemakaian-$masuk_penerimaan-$masuk_distribusi;
					$saldo_awal=$stok+$keluar_distribusi+$keluar_pemakaian+$stokop-$masuk_penerimaan-$masuk_distribusi;
					if($saldo_awal<0){$saldoawal=0;}
					else{$saldoawal=$saldo_awal;}
					//$jml=;
					$saldoakhir=($saldoawal+$masuk_penerimaan+$masuk_distribusi)-($keluar_pemakaian+$keluar_distribusi+$stokop);
								
					//$saldoakhir=($saldoawal+($masuk_penerimaan+$masuk_distribusi)+$stokop)-($keluar_pemakaian+$keluar_distribusi);
					//$totalawal=$saldo_awal*$hargabeli;
					$data=array('saldo_awal'=>$saldoawal,'saldo_akhir'=>$saldoakhir);
					$this->mmutasi->update('log_mutasi_barang',$data,'kd_lokasi="'.$kd_lokasi.'" and kd_barang="'.$kd_barang.'" and bulan="'.$bulan.'" and "'.$tahun.'"');
				}
				else { //kalo yg bln kmrn ada
					$data=array('saldo_awal'=>$saldo_awal);
					$this->mmutasi->update('log_mutasi_barang',$data,'kd_lokasi="'.$kd_lokasi.'" and kd_barang="'.$kd_barang.'" and bulan="'.$bulan.'" and "'.$tahun.'"');
				}
			}
		} 

		$msg['status']=1;
		$msg['kd_lokasi']=$kd_lokasi;
		$msg['bulan']=$bulan;
		$msg['tahun']=$tahun;
		$msg['pesan']="";
		$msg['cetak']=0;
		//$msg['items']='';
		$msg['items']=$this->mmutasi->getMutasiBarang($kd_lokasi,$bulan,$tahun);
		//$msg['items']=$this->mmutasi->getMutasiObat($bulan,$tahun);
		if($submit=="cetak"){
			$msg['cetak']=1;
		}
		echo json_encode($msg);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */