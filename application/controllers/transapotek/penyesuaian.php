<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penyesuaian extends CI_Controller {

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

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('utilities');
		$this->load->library('pagination');
		$this->load->model('apotek/mpenyesuaianapt');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		
	}
	
	public function index()
	{
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
							'main.js','style-switcher.js');
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
	
	public function penyesuaianstok(){
		$nama_obat='';
		$kd_obat='';
		$periodeawal=date('d-m-Y');
		$periodeawal='';
		$periodeakhir=date('d-m-Y');
		$periodeakhir='';
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$submit=$this->input->post('submit');
		$submit1=$this->input->post('submit1');
		
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
		$dataheader=array(
			'jsfile'=>$jsfileheader,
			'cssfile'=>$cssfileheader,
			'title'=>$this->title
			);

		$jsfooter=array();
		$datafooter=array(
			'jsfile'=>$jsfooter
		);
		
		//debugvar($nomor);
		$data=array('items'=>array(),
					'nama_obat'=>$nama_obat,
					'kd_obat'=>$kd_obat,
					'periodeawal'=>$periodeawal,
					'periodeakhir'=>$periodeakhir,
					'kd_unit_apt'=>$kd_unit_apt
		);
		if($submit==1) $data['items']=$this->mpenyesuaianapt->getStokopname($kd_obat,$periodeawal,$periodeakhir,$kd_unit_apt);
		if($submit1=="excel") {
			$this->load->helper('file');
			$this->load->dbutil();
			//ntr tambahin yg jika kondisinya kosong
			if($kd_obat!="") { $a1=" and apt_obat.kd_obat='$kd_obat'";}
			else {$a1="";}
			$a = $a1;
			/*$query = $this->db->query("select concat('/',apt_stok_unit.kd_obat) as kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl_expire,
										apt_stok_unit.jml_stok from apt_stok_unit,apt_obat,apt_unit,apt_satuan_kecil where apt_stok_unit.kd_obat=apt_obat.kd_obat
										and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil 
										$a and apt_stok_unit.kd_unit_apt='$kd_unit_apt' order by apt_stok_unit.kd_obat");*/
			$query = $this->db->query("select apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl_expire,
										apt_stok_unit.jml_stok from apt_stok_unit,apt_obat,apt_unit,apt_satuan_kecil where apt_stok_unit.kd_obat=apt_obat.kd_obat
										and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil 
										$a and apt_stok_unit.kd_unit_apt='$kd_unit_apt' order by apt_stok_unit.kd_obat");
			$delimiter = ",";
			$newline = "\r\n";

			$x= $this->dbutil->csv_from_result($query, $delimiter, $newline); 
			//$data = 'Some file data';

			if ( write_file('./uploads/stokopnameobat.csv', $x)) {
				// Load the download helper and send the file to your desktop
				$this->load->helper('download');
				force_download('./uploads/stokopnameobat.csv', $x); 
			}
		} 
		//debugvar($data);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/penyesuaian/penyesuaianstok',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function simpanstokopname(){	
		$msg=array();
		$submit=$this->input->post('submit');
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$periodeawal=$this->input->post('periodeawal');
		$periodeakhir=$this->input->post('periodeakhir');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		
		$kd_obat2=$this->input->post('kd_obat2');
		$nama_obat2=$this->input->post('nama_obat2');
		$stoklama=$this->input->post('stoklama');
		$tgl_expire2=$this->input->post('tgl_expire2');
		$stokbaru=$this->input->post('stokbaru');
		$alasan=$this->input->post('alasan');
		$kd_unit_apt1=$this->input->post('kd_unit_apt1');
		$tanggal=$this->input->post('tanggal');
		$kd_milik="01";
		//$kd_user=0;
		$kd_user=$this->session->userdata('id_user'); 
		
		$msg['status']=1;
		
		if($submit=="simpanstokopname"){
			$kode=$this->mpenyesuaianapt->nomor();
			$nomor=$kode+1;
			$msg['nomor']=$nomor;
			
			$selisih=$stokbaru-$stoklama;
			
			$datasimpan=array('nomor'=>$nomor,'tanggal'=>$tanggal,'kd_unit_apt'=>$kd_unit_apt1,
						'kd_obat'=>$kd_obat2,'kd_milik'=>$kd_milik,'tgl_expired'=>convertDate($tgl_expire2),
						'qty'=>$selisih,'alasan'=>$alasan,'kd_user'=>$kd_user);
			$this->mpenyesuaianapt->insert('history_perubahan_stok',$datasimpan);
			
			$datastok=array('jml_stok'=>$stokbaru);
			$this->mpenyesuaianapt->update('apt_stok_unit',$datastok,'kd_unit_apt="'.$kd_unit_apt1.'" and kd_obat="'.$kd_obat2.'" and tgl_expire="'.convertDate($tgl_expire2).'"');
			
			$msg['pesan']="Stokopname berhasil disimpan";
		}
		echo json_encode($msg);
	}
	
	public function periksastokopname() {
		$msg=array();
		$submit=$this->input->post('submit');
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$periodeawal=$this->input->post('periodeawal');
		$periodeakhir=$this->input->post('periodeakhir');
		//$kd_unit_apt=$this->input->post('kd_unit_apt');
		
		$kd_obat2=$this->input->post('kd_obat2');
		$nama_obat2=$this->input->post('nama_obat2');
		$stoklama=$this->input->post('stoklama');
		$tgl_expire2=$this->input->post('tgl_expire2');
		$stokbaru=$this->input->post('stokbaru');
		$alasan=$this->input->post('alasan');
		$kd_unit_apt1=$this->input->post('kd_unit_apt1');
		$tanggal=$this->input->post('tanggal');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		//$kd_user=0;
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="hapus"){
		}
		else{
			if(empty($stokbaru)){
				$jumlaherror++;
				$msg['id'][]="qty";
				$msg['pesan'][]="Kolom stok baru harus di isi";
			}
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
		$items=$this->mpenyesuaianapt->ambilData4($q);
		echo json_encode($items);
	}
	
	public function ambilitems() {
		$q=$this->input->get('query');
		$tgl=$this->input->get('tgl');
		$unit=$this->input->get('unit');
		$items=$this->mpenyesuaianapt->ambilData2($q,$tgl,$unit);
		//debugvar($items);
		echo json_encode($items);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
