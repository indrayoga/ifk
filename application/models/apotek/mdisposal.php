<?



class Mdisposal extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}

	function ambilDataDisposal($no_disposal,$periodeawal,$periodeakhir){
		$this->db->select("no_disposal,date_format(tanggal,'%d-%m-%Y %H:%i:%s') as tanggal,keterangan,approval",FALSE);
		if(!empty($no_disposal))$this->db->like('no_disposal',$no_disposal,'both');
		if(!empty($periodeawal))$this->db->where("date_format(date(tanggal),'%Y-%m-%d')>=",convertDate($periodeawal));
		if(!empty($periodeakhir))$this->db->where("date_format(date(tanggal),'%Y-%m-%d')<=",convertDate($periodeakhir));
		
		$this->db->order_by('no_disposal','desc');
		
		$query=$this->db->get("apt_disposal");		
		return $query->result_array(); 
	}
	
	function ambilItemData3($kd_unit_apt,$kd_milik,$value){
		$this->db->select('harga_pokok',FALSE);
		if(!empty($kd_unit_apt)) $this->db->where('kd_unit_apt',$kd_unit_apt);
		if(!empty($kd_milik)) $this->db->where('kd_milik',$kd_milik);
		if(!empty($value)) $this->db->where('kd_obat',$value);
		$query= $this->db->get("apt_stok_unit");
		$harga_pokok=$query->row_array();
		return $harga_pokok['harga_pokok'];
	}
	
	/*function ambilStok($kd_unit_apt,$value,$tgl_expire){
		$this->db->select('jml_stok',FALSE);
		if(!empty($kd_unit_apt)) $this->db->where('kd_unit_apt',$kd_unit_apt);
		if(!empty($value)) $this->db->where('kd_obat',$value);
		if(!empty($tgl_expire)) $this->db->where('tgl_expire',$tgl_expire);
		$query= $this->db->get("apt_stok_unit");
		$jml_stok=$query->row_array();
		if(empty($jml_stok))return 0;
		return $jml_stok['jml_stok'];
	}*/
	function ambilStok($kd_unit_apt,$value,$tgl_expire,$kd_pabrik="",$batch="",$harga=""){
		$this->db->select('jml_stok',FALSE);
		if(!empty($kd_unit_apt)) $this->db->where('kd_unit_apt',$kd_unit_apt);
		if(!empty($value)) $this->db->where('kd_obat',$value);
		if(!empty($tgl_expire)) $this->db->where('tgl_expire',$tgl_expire);
		if(!empty($kd_pabrik)) $this->db->where('kd_pabrik',$kd_pabrik);
		if(!empty($batch)) $this->db->where('batch',$batch);
		if(!empty($harga)) $this->db->where('harga_pokok',$harga);
		$query= $this->db->get("apt_stok_unit");
		$jml_stok=$query->row_array();
		if(empty($jml_stok)) return 0;
		return $jml_stok['jml_stok'];
	}
	
	function isPosted($nodisposal)
	{
		$this->db->where('no_disposal',$nodisposal);
		$this->db->where('approval',1);
		$query=$this->db->get('apt_disposal');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function ambilData1($kd_obat){ 
		/*$query=$this->db->query("select apt_obat.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl,
								apt_obat.pembanding from apt_unit,apt_obat,
								apt_stok_unit,apt_golongan,apt_jenis_obat,apt_margin_harga,apt_satuan_kecil,apt_milik where apt_unit.kd_unit_apt=apt_stok_unit.kd_unit_apt 
								and apt_obat.kd_obat=apt_stok_unit.kd_obat and apt_obat.kd_golongan=apt_golongan.kd_golongan 
								and apt_obat.kd_jenis_obat=apt_jenis_obat.kd_jenis_obat and apt_obat.kd_golongan=apt_margin_harga.kd_golongan 
								and apt_obat.kd_jenis_obat=apt_margin_harga.kd_jenis_obat and apt_golongan.kd_golongan=apt_margin_harga.kd_golongan 
								and apt_jenis_obat.kd_jenis_obat=apt_margin_harga.kd_jenis_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil 
                                and apt_milik.kd_milik=apt_stok_unit.kd_milik and apt_obat.kd_obat like '%$kd_obat%' 
								order by apt_unit.kd_unit_apt asc");*/
		$query=$this->db->query("select apt_obat.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,apt_obat.pembanding from apt_obat,apt_satuan_kecil
								where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_obat.kd_obat like '%$kd_obat%' 
								order by apt_obat.nama_obat asc");
		return $query->result_array();
	}
	
	function ambilData2($nama_obat){ 
		$query=$this->db->query("SELECT apt_obat.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, apt_obat.pembanding, ifnull( substring_index( apt_stok_unit.jml_stok, '.', 1 ) , 0 ) AS jml_stok, nama_unit_apt
									FROM apt_obat
									LEFT JOIN apt_satuan_kecil ON apt_obat.kd_satuan_kecil = apt_satuan_kecil.kd_satuan_kecil
									LEFT JOIN apt_stok_unit ON apt_obat.kd_obat = apt_stok_unit.kd_obat
									LEFT JOIN apt_unit ON apt_unit.kd_unit_apt = apt_stok_unit.kd_unit_apt
									WHERE (
									apt_unit.nama_unit_apt LIKE '%gudang farmasi%'
									OR apt_unit.nama_unit_apt IS NULL
									) 
								and apt_obat.nama_obat like '%$nama_obat%' order by apt_obat.kd_obat asc");
		
		return $query->result_array(); 			
	}
	
	function ambilDatakode($kd_obat){ 
		$query=$this->db->query("SELECT apt_obat.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, apt_obat.pembanding, ifnull( substring_index( apt_stok_unit.jml_stok, '.', 1 ) , 0 ) AS jml_stok, nama_unit_apt
									FROM apt_obat
									LEFT JOIN apt_satuan_kecil ON apt_obat.kd_satuan_kecil = apt_satuan_kecil.kd_satuan_kecil
									LEFT JOIN apt_stok_unit ON apt_obat.kd_obat = apt_stok_unit.kd_obat
									LEFT JOIN apt_unit ON apt_unit.kd_unit_apt = apt_stok_unit.kd_unit_apt
									WHERE (
									apt_unit.nama_unit_apt LIKE '%gudang farmasi%'
									OR apt_unit.nama_unit_apt IS NULL
									) 
								and apt_obat.kd_obat like '%$kd_obat%' order by apt_obat.kd_obat asc");
		
		return $query->result_array(); 			
	}
	
	function autoNumber($tahun,$bulan){ 
		$this->db->select('max(right(apt_disposal.no_disposal,3)) as a',false);
		$this->db->where('year(apt_disposal.tanggal)',$tahun);
		//$this->db->where('month(apt_disposal.tanggal)',$bulan);
		$this->db->where('mid(apt_disposal.no_disposal,6,2)',$bulan);
		$query=$this->db->get("apt_disposal");
		$item= $query->row_array();
		return $item['a'];
		
	}

	function ambilData($table,$condition=""){
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		return $query->result_array();
	}

	function ambilItemData($no_disposal){
		$query=$this->db->query("select no_disposal,date_format(tanggal,'%Y-%m-%d') as tanggal,keterangan,status,
								date_format(tanggal,'%H:%i:%s') as jamdisposal,approval from apt_disposal where apt_disposal.no_disposal='$no_disposal'");
		return $query->row_array();
	}
	
	/*function ambilItemData($table,$condition=""){
		
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		return $query->row_array();
	}*/
	
	function ambilKodeUnit(){
		$query=$this->db->query("select kd_unit_apt as kode from apt_unit where nama_unit_apt like '%gudang farmasi%'");
		$kd_unit_apt=$query->row_array();
		return $kd_unit_apt['kode'];
	}
	
	function ambilItemData1($table,$condition=""){
		$this->db->select('kd_unit_apt',FALSE);
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		$kd_unit_apt=$query->row_array();
		return $kd_unit_apt['kd_unit_apt'];
	}
	
    function insert($table,$data) {  
		$this->db->insert($table,$data);
		return true;
    }	

    function update($table,$data,$id) {
    	if(!empty($id)){
    		$this->db->where($id,null,false);
    	}		
		$this->db->update($table, $data);
		return true;
    }	

	function delete($table,$id) {
		$this->db->where($id,null,false);
		$this->db->delete($table);
		return true;
    }
	
	function getAllDetailDisposal($no_disposal){  
		$query=$this->db->query("select *,apt_disposal_detail.kd_obat as kd_obat1,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,(select sum(jml_stok) from apt_stok_unit where kd_obat=kd_obat1 and kd_unit_apt=apt_disposal_detail.kd_unit_apt and tgl_expire=apt_disposal_detail.tgl_expire) as jml_stok,
								apt_disposal_detail.qty,apt_disposal_detail.keterangan,date_format(apt_disposal_detail.tgl_expire,'%d-%m-%Y') as tgl_expire,apt_disposal_detail.kd_unit_apt,apt_disposal_detail.kd_pabrik from apt_disposal,apt_disposal_detail,apt_obat,apt_satuan_kecil where apt_disposal.no_disposal=apt_disposal_detail.no_disposal
								and apt_disposal_detail.kd_obat=apt_obat.kd_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and 
								apt_disposal.no_disposal='$no_disposal'"); 
		return $query->result_array(); 		
	}

	function isNumberExist($number){
		$this->db->where('no_disposal',$number);
		$query=$this->db->get('apt_disposal');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function cekStok($value,$kd_unit_apt){
		$this->db->where('kd_obat',$value);
		$this->db->where('kd_unit_apt',$kd_unit_apt);
		$query=$this->db->get('apt_stok_unit');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function isObat($kd_obat)
	{
		$this->db->where('kd_obat',$kd_obat);
		//$this->db->where('type','D');
		$query=$this->db->get('apt_obat');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function getDisposal($no_disposal){
		$this->db->select("no_disposal,date_format(tanggal,'%d-%m-%Y %H:%i:%s') as tanggal,keterangan,approval",FALSE);
		if(!empty($no_disposal))$this->db->like('no_disposal',$no_disposal,'both');
		
		$query=$this->db->get("apt_disposal");
		return $query->row_array();
	}
	
	function ambilNama($value){
		$query=$this->db->query("select nama_obat from apt_obat where kd_obat='$value'");
		$nama=$query->row_array();
		//if(empty($nama))return 
		return $nama['nama_obat'];
	}
}
	
?>