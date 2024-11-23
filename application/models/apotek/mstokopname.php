<?



class Mstokopname extends CI_Model {

	function __construct() {
		
		parent::__construct();
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
	
	function sumberdana(){
		
		$query= $this->db->get('apt_unit');
		return $query->result_array();
	}
	
	function ambilData4($nama_obat,$kd_unit_apt){
		
		$query=$this->db->query("select apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil from apt_stok_unit,
								apt_satuan_kecil,apt_obat,apt_unit where apt_stok_unit.kd_obat=apt_obat.kd_obat and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and 
								apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_stok_unit.kd_unit_apt='$kd_unit_apt' and 
								apt_obat.nama_obat like '%$nama_obat%'");
		return $query->result_array();
	}
	
	function ambilData($table,$condition=""){
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		return $query->result_array();
	}
	
	function ambilItemData($table,$condition=""){
		
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		return $query->row_array();
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
	
	function getStokopname($nama_obat,$kd_unit_apt){
		
		$this->db->select('apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,apt_stok_unit.jml_stok,
							apt_stok_unit.tgl_expire,apt_stok_unit.kd_unit_apt,apt_unit.nama_unit_apt',FALSE);
		
		if(!empty($nama_obat))$this->db->like('apt_obat.nama_obat',$nama_obat,'both');
		if(!empty($kd_unit_apt))$this->db->where('apt_stok_unit.kd_unit_apt',$kd_unit_apt);
		
		$this->db->join('apt_stok_unit','apt_obat.kd_obat=apt_stok_unit.kd_obat','left');
		$this->db->join('apt_unit','apt_unit.kd_unit_apt=apt_stok_unit.kd_unit_apt','left');
		$this->db->join('apt_satuan_kecil','apt_satuan_kecil.kd_satuan_kecil=apt_obat.kd_satuan_kecil','left');
		$this->db->order_by('apt_stok_unit.kd_obat');
		$query=$this->db->get("apt_obat");		
		return $query->result_array();
	}
	
	function getItemStokopname($nomor){
		
		$this->db->select('history_perubahan_stok.*,apt_obat.nama_obat',FALSE);
		
		$this->db->where('history_perubahan_stok.nomor',$nomor);
		
		$this->db->join('apt_obat','history_perubahan_stok.kd_obat=apt_obat.kd_obat','left');
		$query=$this->db->get("history_perubahan_stok");		
		return $query->row_array();
	}
	
	function nomor(){
		$query=$this->db->query("select max(nomor) as kode from history_perubahan_stok");
		$kode=$query->row_array();
		if(empty($kode)) return 0;
		return $kode['kode'];
	}
	
	function tanggal(){
		$query=$this->db->query("select DATE_FORMAT(sysdate(),'%Y-%m-%d') as tgl");
		$tgl=$query->row_array();
		return $tgl['tgl'];
	}
	
	function ambilData2($kd_obat,$kd_unit_apt,$tgl_expire){
		$query=$this->db->query("select apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_stok_unit.jml_stok,apt_stok_unit.tgl_expire,apt_stok_unit.kd_unit_apt from apt_obat,apt_stok_unit,
								apt_unit where apt_obat.kd_obat=apt_stok_unit.kd_obat and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and 
								apt_stok_unit.kd_obat='$kd_obat' and apt_stok_unit.kd_unit_apt='$kd_unit_apt' and apt_stok_unit.tgl_expire='$tgl_expire'");
		return $query->row_array(); 			
	}
	
	function namakategori($kd_kategori){
		$query=$this->db->query("select kategori from log_kategori_barang where kd_kategori='$kd_kategori'");
		$kategori=$query->row_array();
		return $kategori['kategori'];
	}
	
	function namaunit($kd_unit_apt){
		$query=$this->db->query("select nama_unit_apt from apt_unit where kd_unit_apt='$kd_unit_apt'");
		$unit=$query->row_array();
		return $unit['nama_unit_apt'];
	}
	
	function getStokopname1($kd_obat,$kd_unit_apt){
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		if($kd_unit_apt!="null" or $kd_unit_apt!=''){$a1=" and apt_stok_unit.kd_unit_apt='$kd_unit_apt'";}
		else {$a1="";} $a=$a1;
		
		if($kd_obat!="null"){$c1=" and apt_stok_unit.kd_obat='$kd_obat'";}
		else {$c1="";} $c=$c1;
		
		$query=$this->db->query("select apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,sum(apt_stok_unit.jml_stok) as jml_stok,apt_obat.harga_beli,
								(apt_stok_unit.jml_stok*apt_obat.harga_beli) as nilai from apt_obat,apt_stok_unit,apt_satuan_kecil
								where apt_stok_unit.kd_obat=apt_obat.kd_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil
								$c $a group by apt_stok_unit.kd_obat");
				
		return $query->result_array(); 
	}
	
	function get_all()
    {                   
        $query = $this->db->get('user_account');
        return $query;
    }

    function getExportStokopname($kd_unit_apt){
    	$query=$this->db->query("SELECT a.kd_obat, a.kd_unit_apt, b.nama_obat, c.nama_unit_apt, a.tgl_expire, a.jml_stok,a.harga_pokok as harga,a.batch,a.kd_pabrik,d.nama_pabrik
								FROM `apt_stok_unit` a
								JOIN apt_obat b ON a.kd_obat = b.kd_obat
								JOIN apt_unit c ON a.kd_unit_apt = c.kd_unit_apt
								JOIN apt_pabrik d ON a.kd_pabrik = d.kd_pabrik
								where a.kd_unit_apt='".$kd_unit_apt."'
								ORDER BY `a`.`kd_obat` ASC");
    	return $query->result_array();
    }

    function getExportStokopname2($kd_unit_apt){
    	$query=$this->db->query("SELECT a.kd_obat,a.kd_pabrik, '$kd_unit_apt' as kd_unit_apt, a.nama_obat,b.batch,if('$kd_unit_apt'='D02',harga_apbd1,if('$kd_unit_apt'='D03',harga_apbd,if('$kd_unit_apt'='apb',harga_apbn,if('$kd_unit_apt'='U02',harga_program,if('$kd_unit_apt'='D05',harga_buffer,harga_dak))))) as harga, c.nama_unit_apt, b.tgl_expire, ifnull(b.jml_stok,0) as jml_stok
								FROM `apt_obat` a
								left JOIN apt_stok_unit b ON a.kd_obat = b.kd_obat
								left JOIN apt_unit c ON b.kd_unit_apt = c.kd_unit_apt
								where a.is_aktif=1
								ORDER BY `a`.`kd_obat` ASC");
    	return $query->result_array();
    }

	function getDigitPertama($kode){
        // query
        $query = "SELECT digitbarcode as digit
                    FROM apt_unit where  kd_unit_apt='".$kode."' ";
        
        // execute query and retrieve item
        $query=$this->db->query($query);
        $item=$query->row_array();
        // return item                       
        return $item['digit'];
    }

   function getMaxBarcode($kode){
        // query
        $query = "SELECT ifnull(max(right(barcode,4)),0) as lastbarcode
                    FROM apt_stok_unit where  left(barcode,3)='".$kode."' ";
        
        // execute query and retrieve item
        $query=$this->db->query($query);
        $item=$query->row_array();
        // return item                       
        return $item['lastbarcode'];
    }
    
}
	
?>
