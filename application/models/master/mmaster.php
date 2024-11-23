<?


include_once(APPPATH.'models/mutility.php');
class Mmaster extends mutility {

	function __construct() {
		
		parent::__construct();
	}



	function ambilDataTarifCustomer($kd_jenis_tarif,$cust_code){
		$this->db->join('jenis_tarif b','a.kd_jenis_tarif=b.kd_jenis_tarif');
		$this->db->join('apt_customers c','a.cust_code=c.cust_code');
		if(!empty($kd_jenis_tarif))$this->db->where('a.kd_jenis_tarif',$kd_jenis_tarif);
		if(!empty($cust_code))$this->db->where('a.cust_code',$cust_code);
		$query=$this->db->get('tarif_customers a');
		return $query->result_array();
	}

	function ambilDataTarif($kd_jenis_tarif,$kd_pelayanan,$kd_kelas){
		$this->db->join('jenis_tarif b','a.kd_jenis_tarif=b.kd_jenis_tarif');
		$this->db->join('list_pelayanan c','a.kd_pelayanan=c.kd_pelayanan');
		$this->db->join('kelas_pelayanan d','a.kd_kelas=d.kd_kelas');
		if(!empty($kd_jenis_tarif))$this->db->where('a.kd_jenis_tarif',$kd_jenis_tarif);
		if(!empty($kd_pelayanan))$this->db->where('a.kd_pelayanan',$kd_pelayanan);
		if(!empty($kd_kelas))$this->db->where('a.kd_kelas',$kd_kelas);
		$query=$this->db->get('tarif a');
		return $query->result_array();
	}


	
	
	function isExistTarif($kd_jenis_tarif,$kd_pelayanan,$kd_kelas,$tgl_berlaku)
	{
		$this->db->where('kd_jenis_tarif',$kd_jenis_tarif);
		$this->db->where('kd_pelayanan',$kd_pelayanan);
		$this->db->where('kd_kelas',$kd_kelas);
		$this->db->where('tgl_berlaku',$tgl_berlaku);
		$query=$this->db->get('tarif');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function isExistComponentTarif($kd_jenis_tarif,$kd_pelayanan,$kd_kelas,$tgl_berlaku,$kd_component)
	{
		$this->db->where('kd_jenis_tarif',$kd_jenis_tarif);
		$this->db->where('kd_pelayanan',$kd_pelayanan);
		$this->db->where('kd_kelas',$kd_kelas);
		$this->db->where('tgl_berlaku',$tgl_berlaku);
		$this->db->where('kd_component',$kd_component);
		$query=$this->db->get('tarif_component');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function isExistTarifCustomer($kd_jenis_tarif,$cust_code)
	{
		$this->db->where('kd_jenis_tarif',$kd_jenis_tarif);
		$this->db->where('cust_code',$cust_code);
		$query=$this->db->get('tarif_customers');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function ambilDataKasirUnit($nama){
		$this->db->select('kasir_unit.kd_kasir,kasir.kasir,unit_kerja.kd_unit_kerja,unit_kerja.nama_unit_kerja',FALSE);
		$this->db->join('unit_kerja','kasir_unit.kd_unit_kerja=unit_kerja.kd_unit_kerja');
		$this->db->join('kasir','kasir.kd_kasir=kasir_unit.kd_kasir');
		if(!empty($nama)) $this->db->like('kasir.kasir',$nama);
			$this->db->order_by('kasir_unit.kd_kasir','asc');
		$query=$this->db->get('kasir_unit');
		return $query->result_array(); 			
	}
	
	function ambilItemKasirUnit($id,$id2){
		$this->db->select('kasir_unit.kd_kasir,kasir.kasir,unit_kerja.kd_unit_kerja,unit_kerja.nama_unit_kerja',FALSE);
		$this->db->join('unit_kerja','kasir_unit.kd_unit_kerja=unit_kerja.kd_unit_kerja');
		$this->db->join('kasir','kasir.kd_kasir=kasir_unit.kd_kasir');
		$this->db->where('kasir.kd_kasir',$id);			
		$this->db->where('unit_kerja.kd_unit_kerja',$id2);	
		$this->db->order_by('kasir_unit.kd_kasir','asc');
		$query=$this->db->get('kasir_unit');
		return $query->row_array(); 			
	}
	
	function cekKasirUnit($kd_kasir,$kd_unit_kerja){
		$this->db->where('kd_kasir',$kd_kasir);
		$this->db->where('kd_unit_kerja',$kd_unit_kerja);
		$query=$this->db->get('kasir_unit');
		$item=$query->num_rows();
		if($item)return true;
		return false; 			
	}
	
	function ambilDataRuangan($no_kamar){
	//nti tambahin unitnya....pembelinya dr unit mn......
		$this->db->select("no_kamar.no_kamar,unit_kerja.nama_unit_kerja,kelas_pelayanan.kelas");
		if(!empty($no_kamar))$this->db->like('no_kamar.no_kamar',$no_kamar,'both');
		
		$this->db->join('unit_kerja','unit_kerja.kd_unit_kerja=no_kamar.kd_unit_kerja');
		$this->db->join('kelas_pelayanan','kelas_pelayanan.kd_kelas=no_kamar.kd_kelas','left');
		$this->db->order_by('no_kamar.no_kamar','asc');
		
		$query=$this->db->get("no_kamar");		
		return $query->result_array(); 
	}
	
	function ambilDiagnosaICD($diagnosa){
		if(!empty($diagnosa))$this->db->like('diagnosa',$diagnosa,'both');
		
		$this->db->order_by('kd_diagnosa_icd','asc');
		
		$query=$this->db->get("diagnosa_icd");		
		return $query->result_array(); 
	}
	
	function ambilDiagnosaDTD($nama_dtd){
		if(!empty($nama_dtd))$this->db->like('nama_dtd',$nama_dtd,'both');
		
		$this->db->order_by('no_dtd','asc');
		
		$query=$this->db->get("diagnosa_dtd");		
		return $query->result_array(); 
	}

	function getTarifComponentItem($kd_jenis_tarif,$kd_pelayanan,$kd_kelas,$tgl_berlaku){
		$query = $this->db->query('SELECT *
						FROM `tarif_component` a
						JOIN component_tarif b ON a.kd_component = b.kd_component
						WHERE kd_jenis_tarif = "'.$kd_jenis_tarif.'"
						AND kd_pelayanan = "'.$kd_pelayanan.'"
						AND kd_kelas = "'.$kd_kelas.'"
						AND tgl_berlaku = "'.$tgl_berlaku.'"');
		return $query->result_array();
	}

	function comboLevel($value=""){
		$htmlcmb='<select id="level" name="level" class="input-small">';
			$htmlcmb.='<option value="">Level</option>';
			$i=1;
			while($i <= 9){
				if(!empty($value)){
					$sql=$this->db->query("SELECT levels FROM accounts WHERE levels=".$value);
					$items=$sql->row_array();
					if($items['levels']==$i){
						$htmlcmb.='<option value="'.$i.'" selected="selected">'.$i.'</option>';
					}else{
						$htmlcmb.='<option value="'.$i.'">'.$i.'</option>';
					}
				}else{
					$htmlcmb.='<option value="'.$i.'">'.$i.'</option>';
				}
				$i++;
			}
		$htmlcmb.='</select>';	
		return $htmlcmb;
	}

}
	
?>