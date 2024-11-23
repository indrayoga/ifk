<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//class Laporanapt extends CI_Controller {
class Automate extends CI_Controller
{

    public function hitungobat($kd_obat='')
    {
        if(!empty($kd_obat)){
            $obat = $this->db->query('select * from apt_stok_unit where kd_obat="'.$kd_obat.'" ')->result();
        }else{
            $obat = $this->db->query('select * from apt_stok_unit  ')->result();
        }

        echo 'Kosongkan tabel '. PHP_EOL;
        // for($i=1;$i<=10;$i++){
        //     echo '.';
        //     sleep(1);
        // }
        $this->db->truncate('obat_history');
        $no = 1;
        foreach ($obat as $ob) {
            echo $no.' Menghitung '.$ob->kd_obat . PHP_EOL;
            $no++;
            $stok = 0;
            $stok_keluar = 0;
            //CARI DI STOKOPNAME, TABEL : HISTORY_PERUBAHAN_STOK
            $stokSo = $this->db->get_where('history_perubahan_stok', array(
                'kd_unit_apt' => $ob->kd_unit_apt,
                'kd_obat' => $ob->kd_obat,
                'kd_milik' => $ob->kd_milik,
                'kd_pabrik' => $ob->kd_pabrik,
                'tgl_expired' => $ob->tgl_expire,
                'batch' => $ob->batch,
                'harga' => $ob->harga_pokok,
            ))->result();
            
            foreach($stokSo as $so){
                echo 'Input SO '.$ob->kd_obat.PHP_EOL;
                $this->db->insert('obat_history', array(
                    'kode_obat' => $so->kd_obat,
                    'kd_unit_apt' => $so->kd_unit_apt,
                    'kd_milik' => $so->kd_milik,
                    'kd_pabrik' => $so->kd_pabrik,
                    'tgl_expire' => $so->tgl_expired,
                    'harga' => $so->harga,
                    'batch' => $so->batch,
                    'tanggal' => $so->tanggal,
                    'qty' => $so->stok_baru,
                    'status' => 'SO',
                    'id_join' => $so->nomor,
                    'kode_sas' => $so->kode_sas
                ));
                $stok += $so->stok_baru;
            }

            $stokObatMasuk = $this->db->join('apt_penerimaan','apt_penerimaan.no_penerimaan=apt_penerimaan_detail.no_penerimaan')->get_where('apt_penerimaan_detail', array(
                'apt_penerimaan_detail.kd_unit_apt' => $ob->kd_unit_apt,
                'kd_obat' => $ob->kd_obat,
                'kd_milik' => $ob->kd_milik,
                'kd_pabrik' => $ob->kd_pabrik,
                'tgl_expire' => $ob->tgl_expire,
                'no_batch' => $ob->batch,
                'harga_pokok' => $ob->harga_pokok,
            ))->result();

            foreach ($stokObatMasuk as $obatMasuk) {
                echo 'Input Obat Masuk '.$ob->kd_obat.PHP_EOL;
                $this->db->insert('obat_history', array(
                    'kode_obat' => $obatMasuk->kd_obat,
                    'kd_unit_apt' => $obatMasuk->kd_unit_apt,
                    'kd_milik' => $obatMasuk->kd_milik,
                    'kd_pabrik' => $obatMasuk->kd_pabrik,
                    'tgl_expire' => $obatMasuk->tgl_expire,
                    'harga' => $obatMasuk->harga_pokok,
                    'batch' => $obatMasuk->no_batch,
                    'tanggal' => $obatMasuk->tgl_penerimaan,
                    'qty' => $obatMasuk->qty_kcl,
                    'status' => 'M',
                    'id_join' => $obatMasuk->no_penerimaan,
                    'kode_sas' => $obatMasuk->kode_sas
                ));
                $stok += $obatMasuk->qty_kcl;
            }

            $stokObatKeluar = $this->db->select('apt_penjualan_detail.*,apt_penjualan.tgl_penjualan')->join('apt_penjualan','apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan')->get_where('apt_penjualan_detail', array(
                'apt_penjualan_detail.kd_unit_apt' => $ob->kd_unit_apt,
                'kd_obat' => $ob->kd_obat,
                'kd_milik' => $ob->kd_milik,
                'kd_pabrik' => $ob->kd_pabrik,
                'tgl_expire' => $ob->tgl_expire,
                'batch' => $ob->batch,
                'harga_pokok' => $ob->harga_pokok,
            ))->result();

            foreach($stokObatKeluar as $obatKeluar){
                echo 'Input Obat Keluar '.$ob->kd_obat.PHP_EOL;
                $this->db->insert('obat_history', array(
                    'kode_obat' => $obatKeluar->kd_obat,
                    'kd_unit_apt' => $obatKeluar->kd_unit_apt,
                    'kd_milik' => $obatKeluar->kd_milik,
                    'kd_pabrik' => $obatKeluar->kd_pabrik,
                    'tgl_expire' => $obatKeluar->tgl_expire,
                    'harga' => $obatKeluar->harga_pokok,
                    'batch' => $obatKeluar->batch,
                    'tanggal' => $obatKeluar->tgl_penjualan,
                    'qty' => $obatKeluar->qty,
                    'status' => 'K',
                    'id_join' => $obatKeluar->no_penjualan,
                    'kode_sas' => $obatKeluar->kode_sas
                ));
                $stok_keluar += $obatKeluar->qty;
            }


            $stokObatDisposal = $this->db->join('apt_disposal','apt_disposal.no_disposal=apt_disposal_detail.no_disposal')->get_where('apt_disposal_detail', array(
                'apt_disposal_detail.kd_unit_apt' => $ob->kd_unit_apt,
                'kd_obat' => $ob->kd_obat,
                'kd_milik' => $ob->kd_milik,
                'kd_pabrik' => $ob->kd_pabrik,
                'tgl_expire' => $ob->tgl_expire,
                'batch' => $ob->batch,
                'harga_pokok' => $ob->harga_pokok,
            ))->result();

            foreach($stokObatDisposal as $obatDisposal){
                echo 'Input Obat Disposal '.$ob->kd_obat.PHP_EOL;
                $this->db->insert('obat_history', array(
                    'kode_obat' => $obatDisposal->kd_obat,
                    'kd_unit_apt' => $obatDisposal->kd_unit_apt,
                    'kd_milik' => $obatDisposal->kd_milik,
                    'kd_pabrik' => $obatDisposal->kd_pabrik,
                    'tgl_expire' => $obatDisposal->tgl_expire,
                    'harga' => $obatDisposal->harga_pokok,
                    'batch' => $obatDisposal->batch,
                    'tanggal' => $obatDisposal->tanggal,
                    'qty' => $obatDisposal->qty,
                    'status' => 'D',
                    'id_join' => $obatDisposal->no_disposal,
                    'kode_sas' => $obatDisposal->kode_sas
                ));
                $stok_keluar += $obatDisposal->qty;
            }

            // //update jumlah stok
            $this->db->update('apt_stok_unit',array(
                'stok' => $stok,
                'jml_stok' => $stok - $stok_keluar,
            ),array(
                'kd_unit_apt' => $ob->kd_unit_apt,
                'kd_obat' => $ob->kd_obat,
                'kd_milik' => $ob->kd_milik,
                'kd_pabrik' => $ob->kd_pabrik,
                'tgl_expire' => $ob->tgl_expire,
                'batch' => $ob->batch,
                'harga_pokok' => $ob->harga_pokok,
            ));


        }
    }

    public function hitungSisaStokSO(){
        //CEK SISA STOK OBAT STOKOPNAME
        $obatso = $this->db->get_where('obat_history',array('status' => 'SO'))->result();

        foreach($obatso as $obat){
            echo "Mulai Menghitung Obat ".$obat->kode_obat.PHP_EOL;
            //ambil jumlah obat di pengeluaran
            $obatKeluar = $this->db->select_sum('qty','total_qty')->get_where('obat_history', array(
                'kd_unit_apt' => $obat->kd_unit_apt,
                'kode_obat' => $obat->kode_obat,
                'kd_milik' => $obat->kd_milik,
                'kd_pabrik' => $obat->kd_pabrik,
                'tgl_expire' => $obat->tgl_expire,
                'batch' => $obat->batch,
                'harga' => $obat->harga,
                'status' => 'K'
            ))->row();
            echo "Obat Keluar : ".$obatKeluar->total_qty.PHP_EOL;

            $obatDisposal = $this->db->select_sum('qty','total_qty')->get_where('obat_history', array(
                'kd_unit_apt' => $obat->kd_unit_apt,
                'kode_obat' => $obat->kode_obat,
                'kd_milik' => $obat->kd_milik,
                'kd_pabrik' => $obat->kd_pabrik,
                'tgl_expire' => $obat->tgl_expire,
                'batch' => $obat->batch,
                'harga' => $obat->harga,
                'status' => 'D'
            ))->row();      
            echo "Obat disposal : ".$obatDisposal->total_qty.PHP_EOL;

            $totalKeluar = $obatKeluar->total_qty + $obatDisposal->total_qty;
            echo "Total Keluar : ".$totalKeluar.PHP_EOL;
            
            //update sisa stok
            echo "Update Sisa ".PHP_EOL;
            $this->db->update('obat_history',array('stok' => $obat->qty - $totalKeluar),array('id'=>$obat->id));

            //update di apt stok unit
            $this->db->update('apt_stok_unit',array('jml_stok' => $obat->qty - $totalKeluar),array(
                'kd_unit_apt' => $obat->kd_unit_apt,
                'kd_obat' => $obat->kode_obat,
                'kd_milik' => $obat->kd_milik,
                'kd_pabrik' => $obat->kd_pabrik,
                'tgl_expire' => $obat->tgl_expire,
                'batch' => $obat->batch,
                'harga_pokok' => $obat->harga,
            ));

        }

    }

    public function hitungSisaStokObatMasuk(){
        //CEK SISA STOK OBAT STOKOPNAME
        $obatMasuk = $this->db->get_where('obat_history',array('status' => 'M'))->result();

        foreach($obatMasuk as $obat){
            echo "Mulai Menghitung Obat ".$obat->kode_obat.PHP_EOL;
            //ambil jumlah obat di pengeluaran
            $obatKeluar = $this->db->select_sum('qty','total_qty')->get_where('obat_history', array(
                'kd_unit_apt' => $obat->kd_unit_apt,
                'kode_obat' => $obat->kode_obat,
                'kd_milik' => $obat->kd_milik,
                'kd_pabrik' => $obat->kd_pabrik,
                'tgl_expire' => $obat->tgl_expire,
                'batch' => $obat->batch,
                'harga' => $obat->harga,
                'status' => 'K'
            ))->row();
            echo "Obat Keluar : ".$obatKeluar->total_qty.PHP_EOL;

            $obatDisposal = $this->db->select_sum('qty','total_qty')->get_where('obat_history', array(
                'kd_unit_apt' => $obat->kd_unit_apt,
                'kode_obat' => $obat->kode_obat,
                'kd_milik' => $obat->kd_milik,
                'kd_pabrik' => $obat->kd_pabrik,
                'tgl_expire' => $obat->tgl_expire,
                'batch' => $obat->batch,
                'harga' => $obat->harga,
                'status' => 'D'
            ))->row();      
            echo "Obat disposal : ".$obatDisposal->total_qty.PHP_EOL;

            $totalKeluar = $obatKeluar->total_qty + $obatDisposal->total_qty;
            echo "Total Keluar : ".$totalKeluar.PHP_EOL;
            
            //update sisa stok
            echo "Update Sisa ".PHP_EOL;
            $this->db->update('obat_history',array('stok' => $obat->qty - $totalKeluar),array('id'=>$obat->id));
            //update di apt stok unit
            $this->db->update('apt_stok_unit',array('jml_stok' => $obat->qty - $totalKeluar),array(
                'kd_unit_apt' => $obat->kd_unit_apt,
                'kd_obat' => $obat->kode_obat,
                'kd_milik' => $obat->kd_milik,
                'kd_pabrik' => $obat->kd_pabrik,
                'tgl_expire' => $obat->tgl_expire,
                'batch' => $obat->batch,
                'harga_pokok' => $obat->harga,
            ));

        }

    }

}
