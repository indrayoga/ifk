cara untuk singkron kan stok

-- db_gfk_balikpapan_2024.obat_history definition

CREATE TABLE `obat_history` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode_obat` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `kd_unit_apt` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `kd_milik` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `kd_pabrik` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `tgl_expire` date DEFAULT NULL,
  `harga` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `batch` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `status` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `id_join` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `stok` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2077 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


- ubah tanggal penjulan yang tanggal 11-01-2024 00:00:00 jadi 11-01-2024 23:00:00 krna itu tanggal SO
- sama kan kd_pabrik, yang belum 3 digit jadi kan 3 digit
  update history_perubahan_stok set kd_pabrik ='000' where kd_pabrik ='0'

- jalan kan script penyesuaian stok

- lakukan analisa database, check data yang minus, lakukan perubaha
- 