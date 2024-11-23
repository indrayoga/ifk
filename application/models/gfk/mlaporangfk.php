<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH.'models/gfk/mmain.php');

class MLaporangfk extends MMain {
    function __construct() {
        parent::__construct();
    }

    function getDistribusi($periodeawal, $periodeakhir, $kd_unit_apt = '') {
        $query = 
            "select o.kd_obat, o.nama_obat, sk.satuan_kecil, " . (!empty($kd_unit_apt) ? "su.jml_stok" : "sq1.stok") . " as stok, ifnull(sum(pj.qty), 0) as distribusi 
            from apt_penjualan p 
            left join apt_penjualan_detail pj on pj.no_penjualan = p.no_penjualan
                and p.tgl_penjualan between '" . convertDate($periodeawal) . "' and '" . convertDate($periodeakhir) . "' " .
            (!empty($kd_unit_apt) ? "and p.kd_unit_apt = '" . $kd_unit_apt . "' " : "")
            . "right join apt_obat o on pj.kd_obat = o.kd_obat 
            join apt_satuan_kecil sk on sk.kd_satuan_kecil = o.kd_satuan_kecil " .
            (!empty($kd_unit_apt) ? "left join apt_stok_unit su on su.kd_obat = o.kd_obat and su.kd_unit_apt = '" . $kd_unit_apt . "'" : 
            "left join (select kd_obat, sum(jml_stok) as stok from apt_stok_unit group by kd_obat) as sq1 on o.kd_obat = sq1.kd_obat")
            ." group by o.kd_obat;";
        return $this->db->query($query)->result_array();
    }

    function getDistribusiTerbesar($periodeawal, $periodeakhir, $kd_unit_apt = '') {
        $query = 
            "select o.kd_obat, o.nama_obat, sk.satuan_kecil, " . (!empty($kd_unit_apt) ? "su.jml_stok" : "sq1.stok") . " as stok, ifnull(sum(pj.qty), 0) as distribusi 
            from apt_penjualan p 
            left join apt_penjualan_detail pj on pj.no_penjualan = p.no_penjualan
                right join apt_obat o on pj.kd_obat = o.kd_obat 
            join apt_satuan_kecil sk on sk.kd_satuan_kecil = o.kd_satuan_kecil ".
            (!empty($kd_unit_apt) ? "left join apt_stok_unit su on su.kd_obat = o.kd_obat " : 
            "left join (select kd_obat, sum(jml_stok) as stok from apt_stok_unit group by kd_obat) as sq1 on o.kd_obat = sq1.kd_obat ")
            ."where p.tgl_penjualan between '" . convertDate($periodeawal) . "' and '" . convertDate($periodeakhir) . "'".
            (!empty($kd_unit_apt) ? "and su.kd_unit_apt = '" . $kd_unit_apt . "' " : 
            "")
            .
            "group by o.kd_obat order by distribusi desc limit 20;";
        return $this->db->query($query)->result_array();
    }

    function getDistribusiPuskesmas($periodeawal, $periodeakhir, $kd_unit_apt = '', $id_puskesmas = '', $kd_nomenklatur = '') {
        $periodeawal = convertDate($periodeawal);
        $periodeakhir = convertDate($periodeakhir);
        $pkm = (!empty($id_puskesmas) ? " and pj.customer_id = $id_puskesmas" : "");
        $unit = (!empty($kd_unit_apt) ? " and pjd.kd_unit_apt = '$kd_unit_apt'" : "");
        $nomen = (!empty($kd_nomenklatur) ? " and o.kd_nomenklatur = '$kd_nomenklatur'" : "");

        $unit2 = (!empty($kd_unit_apt) ? " and dd.kd_unit_apt = '$kd_unit_apt'" : "");
        $nomen2 = (!empty($kd_nomenklatur) ? " and o.kd_nomenklatur = '$kd_nomenklatur'" : "");

        $query = "SELECT o.kd_obat, o.nama_obat, sk.satuan_kecil, ifnull(sum(pjd.qty), 0) as distribusi, ifnull(pjd.harga_jual, 0) as harga,sum(pjd.total) as total
            from apt_penjualan pj join apt_penjualan_detail pjd on pj.no_penjualan = pjd.no_penjualan 
            join apt_obat o on o.kd_obat = pjd.kd_obat
            left join apt_satuan_kecil sk on sk.kd_satuan_kecil = o.kd_satuan_kecil
            where date(pj.tgl_penjualan) between '$periodeawal' and '$periodeakhir' $pkm $unit $nomen
            union
            select o.kd_obat, o.nama_obat, sk.satuan_kecil, ifnull(sum(dd.qty),0) as distribusi, ifnull(dd.harga_pokok, 0) as harga, sum(dd.qty*dd.harga_pokok) as total
            from apt_disposal d
            join apt_disposal_detail dd ON d.no_disposal = dd.no_disposal 
            join apt_obat o on o.kd_obat = dd.kd_obat 
            left join apt_satuan_kecil sk on sk.kd_satuan_kecil = o.kd_satuan_kecil
            where date(d.tanggal) between '$periodeawal' and '$periodeakhir' $unit2 $nomen2
            group by o.kd_obat";
            //debugvar($query);
        return $this->db->query($query)->result_array();
    }

    function getDistribusiPuskesmasBatch($periodeawal, $periodeakhir, $kd_unit_apt = '', $id_puskesmas = '', $kd_nomenklatur = '',$kd_jenis_transaksi="",$exclude_lplpo="") {
        $periodeawal = convertDate($periodeawal);
        $periodeakhir = convertDate($periodeakhir);
        $pkm = (!empty($id_puskesmas) ? " and pj.customer_id = $id_puskesmas" : "");
        $unit = (!empty($kd_unit_apt) ? " and pjd.kd_unit_apt = '$kd_unit_apt'" : "");
        $nomen = (!empty($kd_nomenklatur) ? " and o.kd_nomenklatur = '$kd_nomenklatur'" : "");

        $unit2 = (!empty($kd_unit_apt) ? " and dd.kd_unit_apt = '$kd_unit_apt'" : "");
        $nomen2 = (!empty($kd_nomenklatur) ? " and o.kd_nomenklatur = '$kd_nomenklatur'" : "");
        if(!empty($kd_jenis_transaksi)) {
            $trx = " AND pj.kd_jenis_transaksi = '" . $kd_jenis_transaksi . "' ";
        }else{
            $trx = "";
        }
        if(!empty($exclude_lplpo)){
            $exc_lplpo = " and pj.kd_jenis_transaksi not in ('LPLPO','LPLPO-OKT') ";
        }else{
            $exc_lplpo = "";
        }

        $query = "SELECT o.kd_obat, o.nama_obat, sk.satuan_kecil, ifnull(sum(pjd.qty), 0) as distribusi, 
        ifnull(pjd.harga_jual, 0) as harga,sum(pjd.total) as total,pjd.batch,pjd.tgl_expire,kd_jenis_transaksi,nama_unit_apt
            from apt_penjualan pj join apt_penjualan_detail pjd on pj.no_penjualan = pjd.no_penjualan 
            join apt_obat o on o.kd_obat = pjd.kd_obat
            left join apt_satuan_kecil sk on sk.kd_satuan_kecil = o.kd_satuan_kecil 
            LEFT JOIN jenis_transaksi jt ON pj.kd_jenis_transaksi = jt.kode
            left join apt_unit on pjd.kd_unit_apt=apt_unit.kd_unit_apt
            where date(pj.tgl_penjualan) between '$periodeawal' and '$periodeakhir' $pkm $unit $nomen $trx $exc_lplpo
            group by o.kd_obat,pjd.batch";
            //debugvar($query);
        return $this->db->query($query)->result_array();
    }

    function getDistribusiObat($periodeawal, $periodeakhir, $kd_unit_apt = '', $kd_obat = '', $id_puskesmas = '') {
        $periodeawal = convertDate($periodeawal);
        $periodeakhir = convertDate($periodeakhir);
        $unit = (!empty($kd_unit_apt) ? " and pjd.kd_unit_apt = '$kd_unit_apt'" : "");
        $pkm = (!empty($id_puskesmas) ? " and pj.customer_id = $id_puskesmas" : "");

        $query = "SELECT o.kd_obat, o.nama_obat,pkm.nama,unit.nama_unit_apt, sk.satuan_kecil, pjd.qty as distribusi, ifnull(pjd.harga_jual, 0) as harga
            from apt_penjualan pj join apt_penjualan_detail pjd on pj.no_penjualan = pjd.no_penjualan 
            join apt_obat o on o.kd_obat = pjd.kd_obat
            left join apt_satuan_kecil sk on sk.kd_satuan_kecil = o.kd_satuan_kecil
            left join gfk_puskesmas pkm on pj.customer_id=pkm.id
            left join apt_unit unit on pjd.kd_unit_apt=unit.kd_unit_apt
            where date(pj.tgl_penjualan) between '$periodeawal' and '$periodeakhir' $pkm $unit
            and pjd.kd_obat='$kd_obat'
            ";
            //debugvar($query);
        return $this->db->query($query)->result_array();
    }

    function getPenerimaanObat($periodeawal, $periodeakhir, $kd_unit_apt, $id_distributor,$kategori="") {
        $periodeawal=convertDate($periodeawal);
        $periodeakhir=convertDate($periodeakhir);
        $unit = (!empty($kd_unit_apt) ? " and pn.kd_unit_apt = '$kd_unit_apt'" : "");
        $supplier = (!empty($id_distributor) ? " and pn.kd_supplier = '$id_distributor'" : "");
        if(!empty($kategori)){
            if($kategori==2){
                $kat="AND SUBSTR(o.kd_obat,6,3) = 'c19'";
            }else{
                $kat="AND SUBSTR(o.kd_obat,6,3) != 'c19'";
            }
        }else{
            $kat="";
        }
        $query=$this->db->query("SELECT pn.tgl_penerimaan ,o.kd_obat, o.nama_obat, sk.satuan_kecil,pnd.harga_pokok, pn.keterangan,
            pn.no_faktur,pnd.tgl_expire,pnd.no_batch,supp.nama as nama_supplier,
            ifnull(sum(pnd.qty_kcl), 0) as jumlah, ifnull(sum(pnd.bonus), 0) as bonus, ifnull(sum(pnd.disc_prs), 0) as diskon
            FROM apt_penerimaan pn join apt_penerimaan_detail pnd on pn.no_penerimaan = pnd.no_penerimaan
            join apt_obat o on o.kd_obat = pnd.kd_obat
            left join apt_satuan_kecil sk on o.kd_satuan_kecil = sk.kd_satuan_kecil 
            left join apt_supplier supp on pn.kd_supplier = supp.kd_supplier
            where date(pn.tgl_penerimaan) between '$periodeawal' and '$periodeakhir'
                $unit $supplier $kat
            group by o.kd_obat,pnd.harga_beli
            ORDER BY pn.tgl_penerimaan ASC");
        return $query->result_array();
    }

    function getPenerimaanObat2($periodeawal, $periodeakhir, $kd_unit_apt, $id_distributor,$kategori="") {
        $periodeawal=convertDate($periodeawal);
        $periodeakhir=convertDate($periodeakhir);
        $unit = (!empty($kd_unit_apt) ? " and pn.kd_unit_apt = '$kd_unit_apt'" : "");
        $supplier = (!empty($id_distributor) ? " and pn.kd_supplier = '$id_distributor'" : "");
        if(!empty($kategori)){
            if($kategori==2){
                $kat="AND SUBSTR(o.kd_obat,6,3) = 'c19'";
            }else{
                $kat="AND SUBSTR(o.kd_obat,6,3) != 'c19'";
            }
        }else{
            $kat="";
        }
        $query=$this->db->query("SELECT pn.tgl_penerimaan ,o.kd_obat, o.nama_obat, sk.satuan_kecil,pnd.harga_pokok, pn.keterangan,
            pn.no_faktur,pnd.tgl_expire,pnd.no_batch,supp.nama as nama_supplier,
            ifnull(sum(pnd.qty_kcl), 0) as jumlah, ifnull(sum(pnd.bonus), 0) as bonus, ifnull(sum(pnd.disc_prs), 0) as diskon
            FROM apt_penerimaan pn join apt_penerimaan_detail pnd on pn.no_penerimaan = pnd.no_penerimaan
            join apt_obat o on o.kd_obat = pnd.kd_obat
            left join apt_satuan_kecil sk on o.kd_satuan_kecil = sk.kd_satuan_kecil 
            left join apt_supplier supp on pn.kd_supplier = supp.kd_supplier
            where date(pn.tgl_penerimaan) between '$periodeawal' and '$periodeakhir'
                $unit $supplier $kat
            group by pnd.kd_obat,pnd.kd_unit_apt,pnd.kd_pabrik,pnd.tgl_expire,pnd.no_batch,pnd.harga_pokok
            ORDER BY pn.tgl_penerimaan ASC");
        return $query->result_array();
    }

    function getPersediaanObat($bulan, $tahun, $kd_unit_apt) {
        $unit = (!empty($kd_unit_apt) ? " and amo.kd_unit_apt = '$kd_unit_apt'" : "");

        $query = $this->db->query("SELECT o.nama_obat, sk.satuan_kecil, amo.*
            from apt_mutasi_obat amo
            left join apt_obat o on amo.kd_obat = o.kd_obat
            left join apt_satuan_kecil sk on o.kd_satuan_kecil = sk.kd_satuan_kecil
            group by amo.kd_obat
            having (amo.bulan = $bulan
                and amo.tahun = $tahun
                $unit) 
                and (amo.saldo_awal <> 0 or in_unit > 0  or retur_jual > 0  
                    or out_jual > 0  or out_unit > 0  or retur_pbf > 0  
                    or saldo_akhir >0  or stok_opname > 0)
            order by amo.kd_obat;");

        $results = $query->result_array();
        $return = array();
        foreach ($results as $row) {
            $row['jum_masuk'] = ($row['in_pbf'] + $row['in_unit']) - $row['retur_pbf'] + $row['stok_opname']; // hitung jum_masuk
            $row['jum_keluar'] = ($row['out_jual'] + $row['out_unit']) - $row['retur_jual']; // hitung jum_keluar
            $row['persediaan'] = ($row['saldo_awal'] + $row['jum_masuk']);
            $row['opt'] = $row['saldo_akhir'] + $row['jum_keluar'] + ($row['jum_keluar'] * 20/100);
            $row['total'] = $row['saldo_akhir'] * $row['harga_beli'];
            $return[] = $row;
        }

        return $return;
    }

    function getLPLPOPKM($bulan, $tahun, $kd_unit_apt,$id_puskesmas) {

        $query = $this->db->query(" select * from apt_obat a join apt_mutasi_obat_puskesmas b on a.kd_obat=b.kd_obat join apt_satuan_kecil c on a.kd_satuan_kecil=c.kd_satuan_kecil
                    where id_puskesmas='".$id_puskesmas."' and bulan='".$bulan."' and tahun='".$tahun."'
                ");

        $results = $query->result_array();

        return $results;
    }

    function getLDistribusiPuskesmas($bulan, $tahun, $kd_unit_apt,$id_puskesmas) {

        $query = $this->db->query(" select * from apt_obat a join apt_mutasi_obat_puskesmas b on a.kd_obat=b.kd_obat join apt_satuan_kecil c on a.kd_satuan_kecil=c.kd_satuan_kecil
                    where id_puskesmas='".$id_puskesmas."' and bulan='".$bulan."' and tahun='".$tahun."'
                ");

        $results = $query->result_array();

        return $results;
    }

    public function getObatKadaluarsa($hari, $kd_unit_apt) {
        $unit = !empty($kd_unit_apt) ? " and su.kd_unit_apt = '$kd_unit_apt'" : "";
        $hari = empty($hari) ? 90 : $hari;

        $query = $this->db->query("SELECT su.*,o.kd_obat, o.nama_obat, date_format(su.tgl_expire,'%d-%m-%Y') as tgl_expire, su.jml_stok, u.nama_unit_apt, sk.satuan_kecil,su.harga_pokok
            from apt_stok_unit su join apt_obat o on o.kd_obat = su.kd_obat
            left join apt_satuan_kecil sk on sk.kd_satuan_kecil = o.kd_satuan_kecil
            left join apt_unit u on u.kd_unit_apt = su.kd_unit_apt
            where (su.tgl_expire between curdate() and date_add(curdate(),interval ".$hari." day) or (su.tgl_expire < curdate() and su.tgl_expire != '0000-00-00')) and su.jml_stok > 0
                $unit
            order by tgl_expire desc");

        return $query->result_array();
    }
}
