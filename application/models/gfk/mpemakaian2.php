<?php
include_once(APPPATH.'models/gfk/mmain.php');
class MPemakaian extends MMain {
    function __construct() {
        parent::__construct();
    }

    function getPemakaianpkmData($periodeawal, $periodeakhir, $unit, $puskesmas) {
    	if(!empty($unit))$kdunit=" and sop.kd_unit_apt='".$unit."'"; else $kdunit="";
    	if(!empty($puskesmas))$pkm=" and sop.id_puskesmas='".$puskesmas."'"; else $pkm="";
        $query = 'select sop.id as id_sop, sop.kd_unit_apt, sop.id_puskesmas, sop.tgl, pkm.nama,u.nama_unit_apt
				from nota_keluar_obat_puskesmas sop
				left join apt_unit u on sop.kd_unit_apt = u.kd_unit_apt
				left join gfk_puskesmas pkm on sop.id_puskesmas = pkm.id
				where sop.tgl between "'.convertDate($periodeawal).'" and "'.convertDate($periodeakhir).'" '.$kdunit.' '.$pkm.'
				';
				
        return $this->db->query($query)->result_array();
    }

	function ambilItemDataPemakaian($id){
		$query=$this->db->query("select * from nota_keluar_obat_puskesmas where id='$id'");
		return $query->row_array();
	}

	function isNumberExist($number){
		$this->db->where('id',$number);
		$query=$this->db->get('nota_keluar_obat_puskesmas');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}

	function getAllDetailPemakaian($id){ 
		$query=$this->db->query("select * from obat_keluar_puskesmas, apt_obat, 
								apt_satuan_kecil
								where 
								obat_keluar_puskesmas.kd_obat=apt_obat.kd_obat
								and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil 
								and obat_keluar_puskesmas.id='$id' 
								order by apt_obat.kd_obat asc");
		return $query->result_array(); 		
	}

}