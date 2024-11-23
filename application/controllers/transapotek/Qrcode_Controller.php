<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
include_once(APPPATH.'controllers/rumahsakit.php');

//class Penjualan extends CI_Controller {
class Qrcode_Controller extends Rumahsakit {

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
	public $shift;

	public function __construct(){
		parent::__construct();
		$this->load->model('apotek/mpenjualan');
		$this->load->model('apotek/mlaporanapt');
		$this->load->model('apotek/mqrcode');
		$this->load->model('gfk/mmain');

		$this->load->library('ciqrcode');
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		//

        $queryunitshift=$this->db->query('select * from unit_shift where kd_unit="APT"'); 
        $unitshift=$queryunitshift->row_array();
		$this->shift=$unitshift['shift'];
	}

	public function laporan_qrcode(){
		$nama_obat='';
		$kd_obat='';
		$kd_unit_apt='';
		$submit1=$this->input->post('submit1');
		
		if($this->input->post('kd_unit_apt')!=''){
			$kd_unit_apt=$this->input->post('kd_unit_apt');
		}
		
		if($this->input->post('nama_obat')!=''){
			$nama_obat=$this->input->post('nama_obat');
		}
		if($this->input->post('kd_obat')!=''){
		    
			$kd_obat=$this->input->post('kd_obat');
			$obat="AND a.kd_obat='$kd_obat'";
		}else{
		    $obat="";
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
							'lib/bootstrap-modal.js',
							'spin.js',
							'main.js');
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);

		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		$data=array(
					'sumberdana'=>$this->mlaporanapt->sumberdana(),
					'items'=>$this->db->query("SELECT *, Date_Format(a.tgl_expire, '%d-%m-%Y')  as te FROM apt_stok_unit a 
						JOIN apt_obat b ON a.kd_obat=b.kd_obat 
						JOIN apt_unit c ON a.kd_unit_apt=c.kd_unit_apt 
							WHERE 
							a.kd_unit_apt='$kd_unit_apt' 
							$obat
							")->result_array(),
					'nama_obat'=>$nama_obat,
					'kd_obat'=>$kd_obat,
					'kd_unit_apt'=>$kd_unit_apt);
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('laporanapotek/qrcode',$data);
		$this->load->view('footer',$datafooter);
	}
	/*
	public function setQRCode($bat=''){
		if (!empty($bat)) {
			$isi="AND batch='$bat'";
		}else{$isi="";}

		$data=$this->mpenjualan->ambilData('apt_stok_unit',"batch!='' AND tgl_expire!='0000-00-00' $isi ");
		echo "<table border=1><th>kd_unit_apt</th><th>tgl_expire</th><th>batch</th><th>qrcode</th>
		";
		foreach ($data as $key ) {
			$qrcode=$this->mqrcode->getQRCode($key['kd_unit_apt'],$key['tgl_expire'],$key['batch']);

			$this->mqrcode->GenerateQRCode($qrcode);
			$datas=[
				'qrcode'=>$qrcode
			];
			$batch=$key['batch'];
			$tgl_expire=$key['tgl_expire'];
			$kd_unit_apt=$key['kd_unit_apt'];

			$this->mpenjualan->update('apt_stok_unit',$datas,"batch='$batch' AND tgl_expire='$tgl_expire' AND kd_unit_apt='$kd_unit_apt'");

			echo "<tr>";
			echo "<td>".$key['kd_unit_apt']."</td>";
			echo "<td>".$key['tgl_expire']."</td>";
			echo "<td>".$key['batch']."</td>";
			echo "<td><img src='".base_url()."temp/".$qrcode.".png'>".$qrcode."</td>";
			echo "</tr>";
		}
		echo "</table>";
	}*/

	public function setQRCode_single($kd_obat,$bat,$tgl_expire,$kd_unit_apt){

		//$obat=$this->mpenjualan->ambilItemData('apt_stok_unit',"batch!='' AND tgl_expire!='0000-00-00' $isi ");
		$bat=str_replace('plntit','/',$bat);
		if($bat==$kd_obat || $bat=='0000'){
		    $qq="a.kd_obat='$kd_obat' AND";
		    $new_batch=$kd_obat.$kd_unit_apt;
		}else{
		    $qq="a.kd_obat='$kd_obat' AND batch='$bat' AND";
		    $new_batch=$bat;
		}
		
		
		
		if($tgl_expire=='00-00-0000'){
		    
		}else{
		    $tgl_expire=explode('-', $tgl_expire);
		    $tgl_expire=$tgl_expire[2].'-'.$tgl_expire[1].'-'.$tgl_expire[0];
		}
		
		
		$obat=$this->db->query("SELECT *, a.tgl_expire as te FROM apt_stok_unit a JOIN apt_obat b ON a.kd_obat=b.kd_obat 
			WHERE 
			$qq
			a.tgl_expire='$tgl_expire' AND
			a.kd_unit_apt='$kd_unit_apt'
			")->row_array();

		
		if(!empty($obat)) {
			echo "<table >";
			$qrcode=$this->mqrcode->getQRCode($obat['kd_unit_apt'],$obat['te'],$new_batch);

			$this->mqrcode->GenerateQRCode($qrcode);

			$datas=[
				'qrcode'=>$qrcode
			];
			$batch=$obat['batch'];
			$tgl_expire=$obat['te'];
			$kd_unit_apt=$obat['kd_unit_apt'];

			$this->mpenjualan->update('apt_stok_unit',$datas,"kd_obat='$kd_obat' AND batch='$batch' AND  tgl_expire='$tgl_expire' AND kd_unit_apt='$kd_unit_apt'");

			echo "<tr><td style=\"text-align:center;\"><img style=\"width:200px;\" src='".base_url()."temp/".$qrcode.".png'><br>".$qrcode."<br>".$obat['nama_obat']."</td>";
			echo "</tr>";
			echo "</table>";
		}else{
			echo "reload halaman ini untuk melihat QRCode...";
			$dpo=$this->db->query("SELECT * FROM apt_penerimaan_detail
			WHERE 
			kd_obat='$kd_obat' AND
			kd_unit_apt='$kd_unit_apt' AND
			tgl_expire='$tgl_expire' AND 
			no_batch='$bat'
			
			ORDER BY tgl_entry DESC
			LIMIT 1
			")->row_array();
			$data1=array('kd_unit_apt'=>$dpo['kd_unit_apt'],
								'kd_obat'=>$dpo['kd_obat'],
								'kd_milik'=>$dpo['kd_milik'],
								'kd_pabrik'=>$dpo['kd_pabrik'],
								'batch'=>$dpo['no_batch'],
								'tgl_expire'=>$dpo['tgl_expire'],
								'harga_pokok'=>$dpo['harga_pokok'],
								'format'=>$dpo['format'],
								'barcode'=>$dpo['barcode'],
								'qrcode'=>$dpo['qrcode'],
								'jml_stok'=>$dpo['qty_kcl']);
			$this->mpenjualan->insert('apt_stok_unit',$data1);
    			
		}
		
	}
	
	public function api($menu,$batch=""){

		$par = $menu;

		if($par=="dataCustomer")
		{
			$data 	= $this->db->query("select * from gfk_puskesmas order by nama ASC")->result_array(); 

			echo json_encode($data);

		}else if($par=="jenis_transaksi")
		{ 
			$data 	= $this->db->query( "select * from jenis_transaksi")->result_array(); 

			echo json_encode($data);
		}else if($par=='cariDataObat2')
		{
			$data=array();
			$data['obat'] 	= $this->db->query("select *,a.tgl_expire as te from apt_stok_unit a JOIN apt_obat b on b.kd_obat=a.kd_obat JOIN apt_unit c on c.kd_unit_apt=a.kd_unit_apt where a.qrcode = '$batch' ")->row_array(); 

			if(empty($data['obat'])){
				$data['status']=0;
			}else{
				$data['status']=1;
			}

			echo json_encode($data);

		}else if($par=='simpan'){
			$data=array();
			$tanggal=explode('/',$this->input->post('tanggal'));
			$tgl=$tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
			$bulan=$tanggal[1];
			$tahun=$tanggal[2];

			$customer=$this->input->post('customer');
			$no_penjualan=$this->input->post('no_penjualan');
			$jenis_transaksi=$this->input->post('jenis_transaksi');

			$datas=[
				//'no_penjualan'=>$no_penjualan,
				'tgl_penjualan'=>$tgl,
				'cust_code'=>$customer,
				'customer_id'=>$customer,
				'kd_jenis_transaksi'=>$jenis_transaksi
			];


			if(empty($no_penjualan)){

				$no_penjualan=$this->db->query("SELECT (MAX(substr(no_penjualan,-5))+1) as nilai from apt_penjualan WHERE month(tgl_penjualan)='$bulan' AND year(tgl_penjualan)='$tahun'")->row_array();
				$no_penjualan="R.".$tanggal[2].".".$tanggal[1].".".str_pad($no_penjualan['nilai'],5,"0",STR_PAD_LEFT);

				$datas['no_penjualan']=$no_penjualan;

				$this->mpenjualan->insert('apt_penjualan',$datas);

			}else{
				$this->mpenjualan->update('apt_penjualan',$datas,"no_penjualan='$no_penjualan'");
				$this->mpenjualan->delete('apt_penjualan_detail',"no_penjualan='$no_penjualan'");
			}
				
			$kd_obat=$this->input->post('kd_obat');
			$kd_unit_apt=$this->input->post('kd_unit_apt');
			$batch=$this->input->post('batch');
			$qty=$this->input->post('qty');


			$urut=1;

			$jasa="0";
			$shiftapt="1";
			$kd_milik="01";


			$data['batch']=$batch;
			$data['kd_obat']=$kd_obat;

			$data['status']=1;

			foreach ($kd_obat as $key => $value){
				# code...
				$obat=$this->db->query("SELECT * FROM apt_stok_unit a  WHERE a.kd_obat='$value' AND batch='$batch[$key]'")->row_array();	
				
				if(!empty($obat)){
					$datadetil=array('no_penjualan'=>$no_penjualan,
									'urut'=>$urut,
									'kd_unit_apt'=>$obat['kd_unit_apt'],
									'kd_obat'=>$value,
									'kd_milik'=>$kd_milik,
									'tgl_expire'=>$obat['tgl_expire'],
									'qty'=>$qty[$key],
									'qty_kecil'=>$qty[$key],
									'batch'=>$batch[$key],
									'kd_pabrik'=>$obat['kd_pabrik'],
									'harga_pokok'=>$obat['harga_pokok'],
									'harga_jual'=>$obat['harga_pokok'],
									'total'=>$obat['harga_pokok']*$qty[$key],
									'markup'=>0,
									'tgl_keluar' => $tgl,
									);

					$this->mpenjualan->insert('apt_penjualan_detail',$datadetil);
					//update stok masing-masing obat
					$jml_stok=$this->mpenjualan->ambilStok($obat['kd_unit_apt'],$value,$obat['tgl_expire'],$obat['kd_pabrik'],$batch[$key],$obat['harga_pokok']);
					$sisastok=$jml_stok-$qty[$key];
					$datastok=array('jml_stok'=>$sisastok);
					$this->mpenjualan->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$obat['kd_unit_apt'].'" and kd_obat="'.$value.'" and tgl_expire="'.$obat['tgl_expire'].'" and kd_pabrik="'.$obat['kd_pabrik'].'" and batch="'.$batch[$key].'" and harga_pokok="'.$obat['harga_pokok'].'" ');
				}else{
					$data['status']=0;
					$data['pesan']="Kode obat :".$value." tidak ditemukan pada database offline ! Pastikan anda telah syncron stok.";
				}

					
				$urut++;				
				
				
			}

			

			echo json_encode($data);
		}

		else if($par=='getSBBK')
		{
			$data=array();

			$now=date('Y-m-d');

			$sbbk=$this->db->query("Select *,b.nama as nama_pkm,c.nama as nama_jt,date(tgl_penjualan) as tgl from apt_penjualan a 
				JOIN gfk_puskesmas b ON a.customer_id=b.id 
				JOIN jenis_transaksi c ON c.kode=a.kd_jenis_transaksi
				WHERE no_sbbk is Null AND date(tgl_penjualan) = '$now' ORDER BY no_penjualan DESC")->result_array();

			echo json_encode($sbbk);
		}

		else if($par=='getSBBK_1')
		{
			$data=array();
			$no_penjualan=$this->input->post('no_penjualan');

			$now=date('Y-m-d');

			$sbbk=$this->db->query("Select *,b.nama as nama_pkm,c.nama as nama_jt,date(tgl_penjualan) as tgl from apt_penjualan a 
				JOIN gfk_puskesmas b ON a.customer_id=b.id 
				JOIN jenis_transaksi c ON c.kode=a.kd_jenis_transaksi
				WHERE no_sbbk is Null AND date(tgl_penjualan) = '$now' AND no_penjualan='$no_penjualan'")->row_array();

			echo json_encode($sbbk);
		}

		else if($par=="dataCustomer_1")
		{
			$id=$this->input->post('customer_id');
			$data 	= $this->db->query("select * from gfk_puskesmas WHERE id=$id order by nama ASC")->row_array(); 

			echo json_encode($data);

		}
		else if($par=="dataJenisTransaksi_1")
		{
			$kode=$this->input->post('kd_jenis_transaksi');
			$data 	= $this->db->query("select * from jenis_transaksi WHERE kode='$kode' ")->row_array(); 

			echo json_encode($data);

		}

		else if($par=="getDetailObat")
		{
			$no_penjualan=$this->input->post('no_penjualan');
			$data 	= $this->db->query("select *,a.tgl_expire as te from apt_penjualan_detail a JOIN apt_obat b on b.kd_obat=a.kd_obat JOIN apt_unit c on c.kd_unit_apt=a.kd_unit_apt WHERE no_penjualan='$no_penjualan' ")->result_array(); 

			echo json_encode($data);

		}

		else if($par=="removeTransaksi")
		{

			$no_penjualan=$this->input->post('no_penjualan');
			$this->mpenjualan->delete('apt_penjualan_detail',"no_penjualan='$no_penjualan'");
			$this->mpenjualan->delete('apt_penjualan',"no_penjualan='$no_penjualan'");

			$data['status']=1;
			echo json_encode($data);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
