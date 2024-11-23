<?



class Mapprover extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}
	
	/*function ambilDataObat($kd_obat,$nama_obat,$kd_sub_jenis){
		if(!empty($kd_obat)) $this->db->like('apt_obat.kd_obat',$kd_obat);
		if(!empty($nama_obat)) $this->db->like('apt_obat.nama_obat',$nama_obat);
		if(!empty($kd_sub_jenis)) $this->db->like('apt_sub_jenis.kd_sub_jenis',$kd_sub_jenis);
		
		$this->db->join('apt_jenis_obat','apt_jenis_obat.kd_jenis_obat=apt_obat.kd_jenis_obat','left');
		$this->db->join('apt_sub_jenis','apt_sub_jenis.kd_sub_jenis=apt_obat.kd_sub_jenis','left');
		$this->db->join('apt_golongan','apt_golongan.kd_golongan=apt_obat.kd_golongan','left');
		
		$this->db->order_by('apt_obat.kd_obat','asc');
		$query=$this->db->get('apt_obat');
		/*$query=$this->db->query("select apt_obat.kd_obat,apt_obat.nama_obat,apt_jenis_obat.jenis_obat,apt_sub_jenis.sub_jenis,apt_golongan.golongan from apt_obat,apt_sub_jenis,
								apt_golongan,apt_jenis_obat where apt_obat.kd_sub_jenis=apt_sub_jenis.kd_sub_jenis and apt_obat.kd_jenis_obat=apt_jenis_obat.kd_jenis_obat and
								apt_obat.kd_golongan=apt_golongan.kd_golongan and apt_obat.kd_obat like '%$kd_obat%' and apt_obat.nama_obat like '%$nama_obat%' 
								and apt_sub_jenis.kd_sub_jenis like '$kd_sub_jenis' order by apt_obat.kd_obat");*/
		/*return $query->result_array(); 			
	}*/
	
	function ambilDataApprover($nama_approver){
		$query=$this->db->query("select approval.kd_app,pegawai.nama_pegawai,approval.urut from approval,pegawai,user
								where approval.id_user=user.id_user and user.id_pegawai=pegawai.id_pegawai and
								pegawai.nama_pegawai like '%$nama_approver%' order by approval.kd_app");
		return $query->result_array(); 
	}
	
	function ambilItemDataApprover($kd_app){
		$query=$this->db->query("select approval.kd_app,user.id_pegawai,pegawai.nama_pegawai,approval.urut,user.id_user from approval,pegawai,user
								where approval.id_user=user.id_user and user.id_pegawai=pegawai.id_pegawai and approval.kd_app='$kd_app'");
		return $query->row_array(); 
	}
	
	function autoNumber(){
		$this->db->select('max(kd_app) as a',FALSE);
		$query = $this->db->get('approval');
		$kode=$query->row_array();
		return $kode['a'];
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

	function isNumberExist($number){
		$this->db->where('kd_obat',$number);
		$query=$this->db->get('apt_obat');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function isParent($tabelrelasi,$where,$id)
	{
		$this->db->where($where,$id);
		$query=$this->db->get($tabelrelasi);
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function muncultanggal(){
		$query=$this->db->query("select date_format(sysdate(),'%Y-%m-%d') as tanggal");
		$tanggal=$query->row_array();
		return $tanggal['tanggal'];
	}
	
	function isExist($tabel,$where,$id)
	{
		$this->db->where($where,$id);
		$query=$this->db->get($tabel);
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function ambilNamaUnit($kd_unit_apt){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select nama_unit_apt from apt_unit where kd_unit_apt='$kd_unit_apt'");
		$unit=$query->row_array();
		if(empty($unit)) return 0;
		return $unit['nama_unit_apt'];
	}
	
	function ambilgolongan($kd_golongan){
		$query=$this->db->query("select golongan from apt_golongan where kd_golongan='$kd_golongan'");
		$golongan=$query->row_array();
		if(empty($golongan)) return '-';
		return $golongan['golongan'];
	}
	
	function ambilexpire($kd_obat){
		$query=$this->db->query("select tgl_expire from apt_stok_unit where kd_unit_apt='U01' and kd_obat='$kd_obat'");
		$tgl=$query->row_array();
		if(empty($tgl)) return '0000-00-00';
		return $tgl['tgl_expire'];
	}
	
	function ambilStok($kd_obat){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select sum(jml_stok) as jml_stok from apt_stok_unit where kd_unit_apt='$kd_unit_apt' and kd_obat='$kd_obat'");
		$stok=$query->row_array();
		if(empty($stok)) return 0;
		return $stok['jml_stok'];
	}
	
	function cekObat($kd_obat,$kd_unit_apt){
		$this->db->where('kd_obat',$kd_obat);
		$this->db->where('kd_unit_apt',$kd_unit_apt);
		$query=$this->db->get('apt_setting_obat');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function ambilusername1($id_pegawai){
		if(!empty($id_pegawai)){
			$this->db->where('id_pegawai', $id_pegawai);
		}
		$query= $this->db->get('user');
		return $query->result_array();
	}
	
	function ambilurutnya(){
		$query=$this->db->query("select max(urut) as urut from approval");
		$urut=$query->row_array();
		if(empty($urut)) return 0;
		return $urut['urut'];
	}
	
}
	
?>