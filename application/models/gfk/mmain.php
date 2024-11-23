<?php
class MMain extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    public function getAll($tableName, $condition = '') {
        if(!empty($condition)) {
            $this->db->where($condition);
        }
        $query = $this->db->get($tableName);

        if($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    public function getRow($tableName, $condition = '') {
        if(!empty($condition)) {
            $this->db->where($condition);
        }
        $query = $this->db->get($tableName, 1);

        if($query->num_rows() > 0) {
            return $query->row_array();
        }

        return null;
    }

    public function getBulanIndonesia($stringBulan) {
        $bulanIndo = '';
        switch($stringBulan) {
            case '01':
                $bulanIndo = 'Januari';
                break;
            case '02':
                $bulanIndo = 'Februari';
                break;
            case '03':
                $bulanIndo = 'Maret';
                break;
            case '04':
                $bulanIndo = 'April';
                break;
            case '05':
                $bulanIndo = 'Mei';
                break;
            case '06':
                $bulanIndo = 'Juni';
                break;
            case '07':
                $bulanIndo = 'Juli';
                break;
            case '08':
                $bulanIndo = 'Agustus';
                break;
            case '09':
                $bulanIndo = 'September';
                break;
            case '10':
                $bulanIndo = 'Oktober';
                break;
            case '11':
                $bulanIndo = 'November';
                break;
            case '12':
                $bulanIndo = 'Desember';
                break;
            default:
                $bulanIndo = 'Terang Bulan';
        }

        return $bulanIndo;
    }

    function getPegawaiByUser($userId) {
        $this->db->where('user.id_user', $userId);
        $this->db->join('pegawai', 'pegawai.id_pegawai = user.pegawai_id', 'left');
        $query = $this->db->get('user');
        if($query->num_rows() > 0) {
            return $query->row_array();
        }

        return null;
    }
}