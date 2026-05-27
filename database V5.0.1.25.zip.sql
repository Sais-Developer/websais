-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 15 Mar 2026 pada 19.44
-- Versi server: 10.6.21-MariaDB-cll-lve-log
-- Versi PHP: 8.4.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smadcsth_demoesandik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `nokartu` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `idsiswa` int(11) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `idpeg` int(11) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `masuk` varchar(50) DEFAULT NULL,
  `pulang` varchar(50) DEFAULT NULL,
  `ket` varchar(5) DEFAULT NULL,
  `bulan` varchar(50) DEFAULT NULL,
  `tahun` varchar(50) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi_les`
--

CREATE TABLE `absensi_les` (
  `id` int(11) NOT NULL,
  `nokartu` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `idsiswa` varchar(11) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `idpeg` varchar(11) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `masuk` varchar(50) DEFAULT NULL,
  `pulang` varchar(50) DEFAULT NULL,
  `ket` varchar(5) DEFAULT NULL,
  `bulan` varchar(50) DEFAULT NULL,
  `tahun` varchar(50) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `absen_daring`
--

CREATE TABLE `absen_daring` (
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `idsiswa` varchar(11) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `ket` varchar(11) DEFAULT NULL,
  `jam` varchar(50) DEFAULT NULL,
  `bulan` varchar(50) DEFAULT NULL,
  `tahun` varchar(50) DEFAULT NULL,
  `mapel` varchar(11) DEFAULT NULL,
  `guru` varchar(11) DEFAULT NULL,
  `kode` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absen_daring`
--

INSERT INTO `absen_daring` (`id`, `tanggal`, `idsiswa`, `kelas`, `ket`, `jam`, `bulan`, `tahun`, `mapel`, `guru`, `kode`) VALUES
(1, '2026-03-15', '1', '10-A', 'H', '19:37:02', '03', '2026', '3', '1', 'Belajar Materi ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `absen_jjm`
--

CREATE TABLE `absen_jjm` (
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `idpeg` int(11) DEFAULT NULL,
  `masuk` varchar(50) DEFAULT NULL,
  `ket` varchar(11) DEFAULT NULL,
  `jjm` varchar(11) DEFAULT NULL,
  `bulan` varchar(50) DEFAULT NULL,
  `tahun` varchar(50) DEFAULT NULL,
  `jadwal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `absen_rapor`
--

CREATE TABLE `absen_rapor` (
  `id` int(11) NOT NULL,
  `idsiswa` int(11) NOT NULL,
  `nis` varchar(50) DEFAULT NULL,
  `sakit` int(11) NOT NULL,
  `izin` int(11) NOT NULL,
  `alpha` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `tapel` varchar(50) NOT NULL,
  `ket` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `adm_tp`
--

CREATE TABLE `adm_tp` (
  `id` int(11) NOT NULL,
  `tingkat` int(11) DEFAULT NULL,
  `lingkup` varchar(255) DEFAULT NULL,
  `tujuan` text DEFAULT NULL,
  `mapel` int(11) DEFAULT NULL,
  `guru` int(11) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `adm_tp`
--

INSERT INTO `adm_tp` (`id`, `tingkat`, `lingkup`, `tujuan`, `mapel`, `guru`, `semester`) VALUES
(1, 7, 'aaa', 'aaaa', 3, 1, 1),
(2, 7, 'bbb', 'bb', 3, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `agenda`
--

CREATE TABLE `agenda` (
  `id` int(11) NOT NULL,
  `hari` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `bulan` varchar(50) DEFAULT NULL,
  `tahun` varchar(50) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `kegiatan` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `guru` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `alumni`
--

CREATE TABLE `alumni` (
  `id_alumni` int(11) NOT NULL,
  `tgl_mutasi` date DEFAULT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `nisn` varchar(16) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jk` varchar(5) DEFAULT NULL,
  `t_lahir` varchar(50) DEFAULT NULL,
  `tgl_lahir` varchar(50) DEFAULT NULL,
  `agama` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `nowa` varchar(20) DEFAULT NULL,
  `tahun_masuk` varchar(10) DEFAULT NULL,
  `tahun_lulus` varchar(10) DEFAULT NULL,
  `kelas` varchar(20) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `nama_instansi` varchar(50) DEFAULT NULL,
  `alamat_instansi` text DEFAULT NULL,
  `kontak_instansi` varchar(50) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `ket` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `arsip_jawaban`
--

CREATE TABLE `arsip_jawaban` (
  `id_jawaban` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_bank` int(11) NOT NULL,
  `id_soal` int(11) NOT NULL,
  `jawaban` text NOT NULL,
  `jenis` int(11) NOT NULL,
  `warna` varchar(100) DEFAULT NULL,
  `skor` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `banksoal`
--

CREATE TABLE `banksoal` (
  `id_bank` int(11) NOT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `idmapel` int(11) DEFAULT NULL,
  `tingkat` varchar(11) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `model` int(11) DEFAULT NULL,
  `soal_agama` varchar(50) DEFAULT NULL,
  `idguru` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `banksoal`
--

INSERT INTO `banksoal` (`id_bank`, `kode`, `idmapel`, `tingkat`, `jurusan`, `model`, `soal_agama`, `idguru`, `status`) VALUES
(1, 'BINDO-A', 3, '10', 'UMUM', 1, '', 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bell`
--

CREATE TABLE `bell` (
  `id` int(11) NOT NULL,
  `hari` varchar(10) DEFAULT NULL,
  `jam` varchar(20) DEFAULT NULL,
  `nada` varchar(3) DEFAULT NULL,
  `sudah_main` tinyint(4) NOT NULL DEFAULT 0,
  `waktu_main` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `bell_nada`
--

CREATE TABLE `bell_nada` (
  `idb` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bell_nada`
--

INSERT INTO `bell_nada` (`idb`, `nama`) VALUES
(1, 'JAM PERTAMA'),
(2, 'JAM KEDUA'),
(3, 'JAM KETIGA'),
(4, 'JAM KEEMPAT'),
(5, 'JAM KELIMA'),
(6, 'JAM KEENAM'),
(7, 'JAM KETUJUH'),
(8, 'JAM KEDELAPAN'),
(9, 'JAM KESEMBILAN'),
(10, 'JAM KESEPULUH'),
(11, 'JAM KESEBELAS'),
(12, 'JAM KEDUABELAS'),
(13, 'MAPEL HARI INI SELESAI'),
(14, 'MAPEL AKHIR PEKAN SELESAI'),
(15, 'ISTIRAHAT PERTAMA'),
(16, 'WAKTU ISTIRAHAT PERTAMA SELESAI'),
(17, 'ISTIRAHAT KEDUA'),
(18, 'WAKTU ISTIRAHAT KEDUA SELESAI'),
(19, 'WAKTU IBADAH SHOLAT'),
(20, 'UPACARA BENDERA 5 MENIT LAGI'),
(21, 'UPACARA BENDERA DIMUALAI'),
(22, 'WAKTU IBADAH SHOLAT JUMAT'),
(23, 'SELURUH PESERTA & PENGAWAS UJIAN MEMASUKI RUANGAN'),
(24, 'PESERTA UJIAN DIPERSILAHKAN MENGERJAKAN UJIAN'),
(25, 'WAKTU UJIAN 5 MENIT LAGI'),
(26, 'WAKTU UJIAN TELAH HABIS');

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `id_berita` int(11) NOT NULL,
  `id_bank` int(11) NOT NULL,
  `sesi` varchar(10) NOT NULL,
  `ruang` varchar(20) NOT NULL,
  `jenis` varchar(30) NOT NULL,
  `ikut` varchar(10) DEFAULT NULL,
  `susulan` varchar(10) DEFAULT NULL,
  `no_susulan` mediumtext DEFAULT NULL,
  `mulai` varchar(10) DEFAULT NULL,
  `selesai` varchar(10) DEFAULT NULL,
  `nama_proktor` varchar(50) DEFAULT NULL,
  `nip_proktor` varchar(50) DEFAULT NULL,
  `nama_pengawas` varchar(50) DEFAULT NULL,
  `nip_pengawas` varchar(50) DEFAULT NULL,
  `catatan` mediumtext DEFAULT NULL,
  `tgl_ujian` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `budig`
--

CREATE TABLE `budig` (
  `id` int(11) NOT NULL,
  `judul` varchar(50) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal` timestamp NULL DEFAULT current_timestamp(),
  `ikon` varchar(50) DEFAULT NULL,
  `file` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `budig`
--

INSERT INTO `budig` (`id`, `judul`, `deskripsi`, `tanggal`, `ikon`, `file`) VALUES
(1, 'Bahasa Indonesia 10', 'Buku Bahasa Indonesia Kelas 10 kurmer', '2025-11-03 15:24:18', 'ikon_6908c92202e0f.png', 'buku_6908c92203dba.pdf'),
(2, 'Matematika 10', 'Buku Matematika Kelas 10 Kurmer', '2025-11-03 15:25:24', 'ikon_6908c963cb655.png', 'buku_6908c963cd64b.pdf'),
(3, 'Buku Bahasa Inggris 10', 'Buku Bahasa Inggris kelas 10 kurmer', '2025-11-03 15:26:30', 'ikon_6908c9a629e73.png', 'buku_6908c9a62a657.pdf'),
(4, 'Pendidikan Agama Islam 10', 'Buku PAI kelas 10 kurmer', '2025-11-03 15:28:29', 'ikon_6908ca1d8f29d.png', 'buku_6908ca1d8f78b.pdf'),
(5, 'Pendidikan kewarganegaraan 10', 'Buku Pendidikan Kewarganegaraan kelas 10 kurmer', '2025-11-03 15:31:14', 'ikon_6908cac2c9be7.png', 'buku_6908cac2c9fd7.pdf'),
(7, 'PJOK 11', 'Buku PJOK kelas 11 Kurmer', '2025-11-03 15:38:18', 'ikon_6908cc69b05ca.jpg', 'buku_6908cc69b0c3f.pdf'),
(8, 'Informatika 10', 'Buku Informatika kelas 10', '2025-11-03 15:39:37', 'ikon_6908ccb9e6eda.jpg', 'buku_6908ccb9e7664.pdf'),
(9, 'Sejarah 10', 'Buku Sejarah kelas 10', '2025-11-03 15:40:49', 'ikon_6908cd01201f0.png', 'buku_6908cd0120475.pdf'),
(10, 'Buku Bahasa Inggris 11', 'Buku bahasa inggris kelas 11 kurmer', '2025-11-04 04:19:15', 'ikon_69097ec334366.png', 'buku_69097ec334d47.pdf'),
(12, 'Bahasa Indonesia 11', 'Buku bahasa Indonesia kelas 11 kurmer', '2025-11-04 04:23:20', 'ikon_69097fb8e7c9c.png', 'buku_69097fb8e8a55.pdf'),
(13, 'Pendidikan kewarganegaraan 11', 'Buku PKN kelas 11 kurmer', '2025-11-04 04:24:44', 'ikon_6909800c0eeea.jpg', 'buku_6909800c0f162.pdf'),
(14, 'Matematika 11', 'Buku Matematika kelas 11 kurmer', '2025-11-04 04:25:40', 'ikon_6909804427215.jpg', 'buku_69098044279ea.pdf'),
(15, 'Pendidikan Agama Islam 11', 'Buku PAI kelas 11 kurmer', '2025-11-04 04:28:10', 'ikon_690980d928fa9.png', 'buku_690980d92e62b.pdf'),
(16, 'PKWU sems 1 11', 'Buku PKWU semester 1 kelas 11 kurmer', '2025-11-04 04:29:18', 'ikon_6909811e04b02.jpg', 'buku_6909811e052ba.pdf'),
(17, 'PKWU sems 2 11', 'Buku PKWU semester 2 kelas 11 kurmer', '2025-11-04 04:30:05', 'ikon_6909814dbd241.jpg', 'buku_6909814dbf580.pdf'),
(19, 'Pendidikan Agama Islam 12', 'Buku Pendidikan Agama Islam kelas 12 kurtilas', '2025-11-04 04:51:50', 'ikon_6909866639a8d.png', 'buku_690986663a338.pdf'),
(21, 'Bahasa Indonesia 12', 'Buku bahasa Indonesia kelas 12 kurtilas', '2025-11-04 04:57:41', 'ikon_690987c55118a.jpg', 'buku_690987c5526d6.pdf'),
(22, 'Buku Bahasa Inggris 12', 'Buku Bahasa Inggris kelas 12 kurtilas', '2025-11-04 04:59:17', 'ikon_6909882552c13.jpg', 'buku_6909882554b14.pdf'),
(23, 'Matematika 12', 'Buku Matematika Kelas 12 kurtilas', '2025-11-04 05:00:21', 'ikon_690988650bcbe.jpg', 'buku_690988650c05d.pdf'),
(24, 'Pendidikan kewarganegaraan 12', 'Buku PKN kelas 12 kurtilas', '2025-11-04 05:01:31', 'ikon_690988ab366af.jpg', 'buku_690988ab36a00.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bulan`
--

CREATE TABLE `bulan` (
  `id` int(11) NOT NULL,
  `bln` varchar(5) NOT NULL,
  `ket` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data untuk tabel `bulan`
--

INSERT INTO `bulan` (`id`, `bln`, `ket`) VALUES
(1, '01', 'Januari'),
(2, '02', 'Februari'),
(3, '03', 'Maret'),
(4, '04', 'April'),
(5, '05', 'Mei'),
(6, '06', 'Juni'),
(7, '07', 'Juli'),
(8, '08', 'Agustus'),
(9, '09', 'September'),
(10, '10', 'Oktober'),
(11, '11', 'Nopember'),
(12, '12', 'Desember');

-- --------------------------------------------------------

--
-- Struktur dari tabel `catatan_pelanggaran`
--

CREATE TABLE `catatan_pelanggaran` (
  `id` int(11) NOT NULL,
  `idpel` int(11) DEFAULT NULL,
  `id_siswa` int(11) NOT NULL,
  `poin` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `catatan_pelanggaran`
--

INSERT INTO `catatan_pelanggaran` (`id`, `idpel`, `id_siswa`, `poin`, `tanggal`, `status`) VALUES
(1, 1, 85, 2, '2025-12-02', 0),
(2, 21, 85, 50, '2025-12-02', 0),
(3, 21, 86, 50, '2025-12-02', 0),
(4, 2, 2, 1, '2025-12-10', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `catatan_rapor`
--

CREATE TABLE `catatan_rapor` (
  `id` int(11) NOT NULL,
  `idsiswa` int(11) DEFAULT NULL,
  `nis` varchar(50) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `tapel` varchar(50) DEFAULT NULL,
  `ket` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cp_elemen`
--

CREATE TABLE `cp_elemen` (
  `id_elemen` int(11) NOT NULL,
  `id_lingkup` int(11) DEFAULT NULL,
  `elemen` text DEFAULT NULL,
  `capaian` text DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `waktu` int(11) DEFAULT NULL,
  `ke` int(11) DEFAULT NULL,
  `ringkasan` text DEFAULT NULL,
  `gambaran` text DEFAULT NULL,
  `media` text DEFAULT NULL,
  `sumber` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cp_elemen`
--

INSERT INTO `cp_elemen` (`id_elemen`, `id_lingkup`, `elemen`, `capaian`, `semester`, `waktu`, `ke`, `ringkasan`, `gambaran`, `media`, `sumber`) VALUES
(1, 1, 'mm', 'aaa', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 'bbb', 'bb', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 2, 'aaaaaaaaaa', 'bbbbbbbbbbbbb', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `datareg`
--

CREATE TABLE `datareg` (
  `id` int(11) NOT NULL,
  `nokartu` varchar(50) DEFAULT NULL,
  `idsiswa` varchar(11) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `idpeg` varchar(11) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `nowa` varchar(50) DEFAULT NULL,
  `nada` varchar(11) DEFAULT NULL,
  `folder` text DEFAULT NULL,
  `idjari` int(11) DEFAULT NULL,
  `serial` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `deskrip_kebiasaan`
--

CREATE TABLE `deskrip_kebiasaan` (
  `id` int(11) NOT NULL,
  `kebiasaan` varchar(50) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `deskrip_kebiasaan`
--

INSERT INTO `deskrip_kebiasaan` (`id`, `kebiasaan`, `deskripsi`) VALUES
(1, 'Bangun pagi', 'menunjukkan kedisiplinan dan tanggung jawab dengan membiasakan diri bangun pagi untuk memulai kegiatan dengan semangat'),
(2, 'Beribadah', 'menunjukkan ketekunan dan keimanan dengan melaksanakan ibadah sesuai keyakinan secara teratur dan penuh kesadaran'),
(3, 'Berolahraga', 'menjaga kebugaran jasmani dengan rutin berolahraga dan berpartisipasi dalam kegiatan fisik di sekolah'),
(4, 'Makan sehat dan bergizi', 'membiasakan diri mengonsumsi makanan sehat dan bergizi sebagai bentuk kepedulian terhadap kesehatan diri'),
(5, 'Gemar belajar', 'menunjukkan rasa ingin tahu yang tinggi, semangat belajar, dan tanggung jawab terhadap tugas-tugas sekolah'),
(6, 'Bermasyarakat', 'mampu bekerja sama, menghargai orang lain, dan aktif berkontribusi positif dalam lingkungan sekolah maupun masyarakat'),
(7, 'Tidur cepat', 'menunjukkan kedisiplinan dalam menjaga pola hidup sehat dengan beristirahat cukup dan tidur tepat waktu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_trx`
--

CREATE TABLE `detail_trx` (
  `id` int(11) NOT NULL,
  `id_transaksi` varchar(255) NOT NULL,
  `idsiswa` int(11) NOT NULL,
  `idproduk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id_guru` int(11) NOT NULL,
  `nokartu` varchar(50) DEFAULT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `level` varchar(11) NOT NULL DEFAULT 'guru',
  `walas` varchar(50) DEFAULT 'Bukan Walas',
  `sts` int(11) NOT NULL DEFAULT 0,
  `nowa` varchar(13) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `saldo` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id_guru`, `nokartu`, `nip`, `nama`, `username`, `password`, `jabatan`, `level`, `walas`, `sts`, `nowa`, `foto`, `saldo`) VALUES
(1, NULL, '379168267809826863', 'Christiano Ronald, S.Pd.', 'guru1', 'guru1', 'Guru', 'guru', '10-A', 0, '0882021733186', NULL, 0),
(2, NULL, '197307071997101001', 'Anaya Putri, S.Pd. M.Pd.', 'guru2', 'guru2', 'Guru', 'guru', '12-A', 0, '0882021733186', NULL, 0),
(3, NULL, NULL, 'Hesly Anjur, M.Pd.', 'staff1', 'staff1', 'Staff', 'staff', 'Bukan Walas', 0, '0882021733185', '', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_mengajar`
--

CREATE TABLE `jadwal_mengajar` (
  `id_jadwal` int(11) NOT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `hari` varchar(50) NOT NULL,
  `mapel` int(11) DEFAULT NULL,
  `guru` int(11) DEFAULT NULL,
  `dari` varchar(50) DEFAULT NULL,
  `sampai` varchar(50) DEFAULT NULL,
  `jjm` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal_mengajar`
--

INSERT INTO `jadwal_mengajar` (`id_jadwal`, `kelas`, `hari`, `mapel`, `guru`, `dari`, `sampai`, `jjm`) VALUES
(1, '12-A', 'Mon', 3, 1, '06:00', '22:00', '32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawaban`
--

CREATE TABLE `jawaban` (
  `id_jawaban` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_bank` int(11) NOT NULL,
  `id_soal` int(11) NOT NULL,
  `jawaban` text NOT NULL,
  `jenis` int(11) NOT NULL,
  `warna` varchar(100) DEFAULT NULL,
  `ragu` int(11) DEFAULT NULL,
  `skor` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawaban_tugas`
--

CREATE TABLE `jawaban_tugas` (
  `id_jawaban` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `id_tugas` int(11) DEFAULT NULL,
  `jawaban` longtext DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tgl_dikerjakan` datetime DEFAULT NULL,
  `tgl_update` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nilai` varchar(5) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `mapel` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal`
--

CREATE TABLE `jurnal` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `guru` varchar(11) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `mapel` varchar(50) DEFAULT NULL,
  `materi` text DEFAULT NULL,
  `aktivitas` text DEFAULT NULL,
  `metode` text DEFAULT NULL,
  `media` text DEFAULT NULL,
  `kendala` text DEFAULT NULL,
  `rencana_lanjutan` text DEFAULT NULL,
  `ketercapaian` enum('Tercapai','Belum Tercapai','Perlu Pengayaan','Perlu Remedial') DEFAULT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_pelanggaran`
--

CREATE TABLE `kategori_pelanggaran` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_pelanggaran`
--

INSERT INTO `kategori_pelanggaran` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Seragam'),
(2, 'Disiplin'),
(3, 'Kebersihan'),
(4, 'Perilaku'),
(5, 'Kehadiran');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kebiasaan_harian`
--

CREATE TABLE `kebiasaan_harian` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `id_guru` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `bangun_pagi` varchar(50) DEFAULT NULL,
  `subuh` tinyint(1) DEFAULT 0,
  `dzuhur` tinyint(1) DEFAULT 0,
  `ashar` tinyint(1) DEFAULT 0,
  `maghrib` tinyint(1) DEFAULT 0,
  `isya` tinyint(1) DEFAULT 0,
  `subuh_pilihan` varchar(50) DEFAULT NULL,
  `dzuhur_pilihan` varchar(50) DEFAULT NULL,
  `ashar_pilihan` varchar(50) DEFAULT NULL,
  `maghrib_pilihan` varchar(50) DEFAULT NULL,
  `isya_pilihan` varchar(50) DEFAULT NULL,
  `dhuha` tinyint(11) DEFAULT 0,
  `dhuha_pilihan` varchar(50) DEFAULT NULL,
  `ibadah_lainnya` varchar(100) DEFAULT NULL,
  `olahraga_jenis` varchar(100) DEFAULT NULL,
  `olahraga_durasi` varchar(50) DEFAULT NULL,
  `mapel` varchar(100) DEFAULT NULL,
  `menu_makan` text DEFAULT NULL,
  `kegiatan_masyarakat` text DEFAULT NULL,
  `istirahat` varchar(50) DEFAULT NULL,
  `paraf_ortu` varchar(200) DEFAULT NULL,
  `paraf_guru` varchar(200) DEFAULT NULL,
  `catatan_guru` text DEFAULT NULL,
  `ortu` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` varchar(11) DEFAULT NULL,
  `idsiswa` int(11) DEFAULT NULL,
  `idpeg` int(11) DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kode`
--

CREATE TABLE `kode` (
  `id` int(11) NOT NULL,
  `jenjang` varchar(50) DEFAULT NULL,
  `jenis` varchar(11) DEFAULT NULL,
  `kd` varchar(50) DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `sub` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kode`
--

INSERT INTO `kode` (`id`, `jenjang`, `jenis`, `kd`, `ket`, `sub`) VALUES
(1, 'SMK', '1', 'A', 'A. Muatan Nasional', ''),
(2, 'SMK', '1', 'B', 'B. Muatan Kewilayahan', ''),
(3, 'SMK', '1', 'C1', 'C1. Dasar Bidang Keahlian', 'C. Muatan Peminatan Kejuruan'),
(4, 'SMK', '1', 'C2', 'C2. Dasar Program Keahlian', ''),
(5, 'SMK', '1', 'C3', 'C3. Kompetensi Keahlian', ''),
(6, 'SMP', '1', 'A', 'A. Umum', ''),
(7, 'SMP', '1', 'B', 'B. Muatan Lokal', ''),
(8, 'SMA', '1', 'A', 'A. Umum', ''),
(9, 'SMA', '1', 'B', 'B. Umum', ''),
(10, 'SMA', '1', 'C', 'C. Peminatan', ''),
(11, 'SD', '1', 'A', 'A. Umum', ''),
(12, 'SD', '1', 'B', 'B. Muatan Lokal', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kokurikuler`
--

CREATE TABLE `kokurikuler` (
  `idk` int(11) NOT NULL,
  `idsiswa` int(11) DEFAULT NULL,
  `nis` varchar(50) DEFAULT NULL,
  `mampu` text DEFAULT NULL,
  `kurang` text DEFAULT NULL,
  `smt` int(11) DEFAULT NULL,
  `tapel` varchar(50) DEFAULT NULL,
  `keter` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `konseling`
--

CREATE TABLE `konseling` (
  `id_konseling` int(11) NOT NULL,
  `idsiswa` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `total_poin` int(11) DEFAULT NULL,
  `teguran` int(11) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `tindakan_lanjutan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lampu`
--

CREATE TABLE `lampu` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `status` varchar(11) NOT NULL DEFAULT 'OF'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lampu`
--

INSERT INTO `lampu` (`id`, `nama`, `status`) VALUES
(1, 'Lampu 1', 'ON'),
(2, 'Lampu 2', 'ON'),
(3, 'Lampu 3', 'ON'),
(4, 'Lampu 4', 'ON'),
(5, 'Lampu 5', 'ON'),
(6, 'Lampu 6', 'ON'),
(7, 'Lampu 7', 'ON'),
(8, 'Lampu 8', 'ON');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_ujian`
--

CREATE TABLE `log_ujian` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_bank` int(11) DEFAULT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `waktu` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `id` int(11) NOT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `nama_mapel` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mapel`
--

INSERT INTO `mapel` (`id`, `kode`, `nama_mapel`) VALUES
(1, 'PABP', 'Penddidikan Agama dan Budi Pekerti'),
(2, 'PPKn', 'Pendidikan Pancasila dan Kewarganegaraan'),
(3, 'BINDO', 'Bahasa Indonesia'),
(4, 'MTK', 'Matematika'),
(5, 'IPA', 'Ilmu Pengetahuan Alam'),
(6, 'IPS', 'Ilmu Pengetahuan Sosial'),
(7, 'BING', 'Bahasa Inggris'),
(8, 'PJOK', 'Pendidikan Jasmani Olahraga dan Kesehatan'),
(9, 'INFO', 'Informatika'),
(10, 'PRK', 'Prakarya'),
(11, 'BSUND', 'Bahasa Sunda'),
(12, 'TIK', 'Tekhnologi Indormasi dan Komunikasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel_rapor`
--

CREATE TABLE `mapel_rapor` (
  `id` int(11) NOT NULL,
  `idmapel` varchar(50) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `tingkat` varchar(11) DEFAULT NULL,
  `kelompok` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mapel_rapor`
--

INSERT INTO `mapel_rapor` (`id`, `idmapel`, `jurusan`, `tingkat`, `kelompok`) VALUES
(1, '1', 'semua', '7', '6'),
(2, '2', 'semua', '7', '6'),
(3, '3', 'semua', '7', '6');

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi`
--

CREATE TABLE `materi` (
  `idm` int(11) NOT NULL,
  `mapel` varchar(11) DEFAULT NULL,
  `kelas` text DEFAULT NULL,
  `guru` varchar(11) DEFAULT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `isimateri` longtext DEFAULT NULL,
  `file` text DEFAULT NULL,
  `youtube` text DEFAULT NULL,
  `dari` date DEFAULT NULL,
  `sampai` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `materi`
--

INSERT INTO `materi` (`idm`, `mapel`, `kelas`, `guru`, `judul`, `isimateri`, `file`, `youtube`, `dari`, `sampai`) VALUES
(1, '3', 'a:5:{i:0;s:4:\"10-A\";i:1;s:4:\"10-B\";i:2;s:4:\"11-A\";i:3;s:4:\"11-B\";i:4;s:4:\"12-A\";}', '1', 'Teks Negosiai', '&lt;p&gt;Teks negosiasi adalah&amp;nbsp;&lt;mark class=&quot;HxTRcb&quot; data-sfc-cb=&quot;&quot;&gt;bentuk interaksi sosial berupa dialog tawar-menawar antara dua pihak atau lebih yang memiliki perbedaan kepentingan untuk mencapai kesepakatan bersama yang saling menguntungkan&lt;/mark&gt;&amp;nbsp;(win-win solution). Teks ini umumnya digunakan dalam jual beli, perjanjian kerja, maupun penyelesaian sengketa.&lt;/p&gt;', 'materi_69b6a71d9c8466.60233297.pdf', '', '2026-03-15', '2026-03-23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menjodohkan`
--

CREATE TABLE `menjodohkan` (
  `id` int(11) NOT NULL,
  `idbank` int(11) DEFAULT NULL,
  `nomor` int(11) DEFAULT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `warna` varchar(50) DEFAULT NULL,
  `jawab` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menjodohkan`
--

INSERT INTO `menjodohkan` (`id`, `idbank`, `nomor`, `kode`, `warna`, `jawab`) VALUES
(16, NULL, NULL, '5.1.', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_bayar`
--

CREATE TABLE `m_bayar` (
  `id` int(11) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `model` int(11) NOT NULL DEFAULT 2,
  `jumlah` int(11) NOT NULL DEFAULT 1,
  `total` int(11) NOT NULL DEFAULT 0,
  `angsuran` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_eskul`
--

CREATE TABLE `m_eskul` (
  `id` int(11) NOT NULL,
  `eskul` varchar(50) DEFAULT NULL,
  `guru` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `m_eskul`
--

INSERT INTO `m_eskul` (`id`, `eskul`, `guru`) VALUES
(1, 'Pramuka', 1),
(2, 'Palang Merah Remaja (PMR)', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_hari`
--

CREATE TABLE `m_hari` (
  `idh` int(11) NOT NULL,
  `hari` varchar(50) NOT NULL,
  `inggris` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data untuk tabel `m_hari`
--

INSERT INTO `m_hari` (`idh`, `hari`, `inggris`) VALUES
(1, 'Senin', 'Mon'),
(2, 'Selasa', 'Tue'),
(3, 'Rabu', 'Wed'),
(4, 'Kamis', 'Thu'),
(5, 'Jumat', 'Fri'),
(6, 'Sabtu', 'Sat'),
(7, 'Minggu', 'Sun');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_kelas`
--

CREATE TABLE `m_kelas` (
  `id` int(11) NOT NULL,
  `level` varchar(11) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `fase` varchar(11) DEFAULT NULL,
  `bk` varchar(50) DEFAULT NULL,
  `pk` varchar(50) DEFAULT NULL,
  `kk` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `m_kelas`
--

INSERT INTO `m_kelas` (`id`, `level`, `kelas`, `jurusan`, `fase`, `bk`, `pk`, `kk`) VALUES
(1, '10', '10-A', 'UMUM', 'E', NULL, NULL, NULL),
(2, '10', '10-B', 'UMUM', 'E', NULL, NULL, NULL),
(3, '11', '11-A', 'UMUM', 'F', NULL, NULL, NULL),
(4, '11', '11-B', 'UMUM', 'F', NULL, NULL, NULL),
(5, '12', '12-A', 'UMUM', 'F', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_pesan`
--

CREATE TABLE `m_pesan` (
  `id` int(11) NOT NULL,
  `pesan1` mediumtext DEFAULT NULL,
  `pesan2` mediumtext DEFAULT NULL,
  `pesan3` mediumtext DEFAULT NULL,
  `pesan4` mediumtext DEFAULT NULL,
  `ket` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data untuk tabel `m_pesan`
--

INSERT INTO `m_pesan` (`id`, `pesan1`, `pesan2`, `pesan3`, `pesan4`, `ket`) VALUES
(1, 'Assalamualaikum Wr. Wb', 'Kami informasikan kepada orang tua peserta didik atas nama :', 'Telah hadir disekolah untuk mengikuti Kegiatan Belajar Mengajar di *_SMP TARUNA BAKTI CIKADU_* dan informasi kehadiran peserta didik ini menggunakan Absensi Digital *RFID* pada ', 'Demikian Informasi ini disampaikan untuk menjadi Sarana Monitoring orang tua peserta didik terhadap putra putrinya. \r\n', NULL),
(2, 'Assalamualaikum Wr. Wb', 'Kami informasikan kepada orang tua peserta didik atas nama :', 'Telah selesai melaksanakan Kegiatan Belajar Mengajar (KBM) di SMP TARUNA BAKTI CIKADU & telah pulang dari lingkungan sekolah.\r\n\r\nInformasi ini menggunakan E-Presensi Digital *RFID* pada', 'Demikian Informasi ini disampaikan untuk menjadi Sarana Monitoring orang tua peserta didik terhadap putra putrinya. ', NULL),
(3, 'Assalamualaikum Wr.Wb', 'Kami informasikan kepada Pimpinan *SMP TARUNA BAKTI CIKADU,* Bahwa:', 'Telah hadir di sekolah untuk melaksanakan *_Kegiatan Belajar Mengajar_* (KBM) dan *HADIR* menggunakan Absensi Digital *RFID* pada ', 'Demikian Informasi ini disampaikan untuk menjadi Sarana Monitoring Kepala Sekolah terhadap Kehadiran Pendidik dan Kependidikan. ', NULL),
(4, 'Assalamualaikum Wr. Wb', 'Kami informasikan kepada Pimpinan *SMP TARUNA BAKTI CIKADU* Bahwa: ', 'Telah selesai melaksanakan *_Kegiatan Belajar Mengajar_* (KBM) dan *Melakukan Presensi Pulang* menggunakan Absensi Digital *RFID* pada ', 'Demikian Informasi ini disampaikan untuk menjadi Sarana Monitoring Kepala Sekolah terhadap Seluruh GTK .\r\n', NULL),
(5, 'Assalamualaikum wr.wb', 'Kami informasikan Bahwa Ananda\r\n\r\n', 'Telah hadir dalam Kegiatan Ekstrakurikuler menggunakan Absesi Digital pada ', 'Demikian Informasi kami sampaikan untuk menjadi Sarana Monitoring Orang Tua Siswa terhadap putra putrinya. Terima kasih dan salam hangat dari Kami, Pesan ini tidak perlu dibalas', NULL),
(6, 'Assalamualaikum wr.wb', 'Kami informasikan Bahwa Ananda', 'Telah selesai dalam mengikuti Kegiatan Ekstrakurikuler menggunakan Absesi Digital RFID pada ', 'Demikian Informasi kami sampaikan untuk menjadi Sarana Monitoring Kepala Sekolah terhadap para pegawai. Terima kasih dan salam hangat dari Kami,Pesan ini tidak perlu dibalas ', NULL),
(7, 'Assalamualaikum wr.wb', 'Kami informasikan kepada Kepala Sekolah Bahwa Sdr/i :', 'Telah hadir dalam Kegiatan Ekstrakurikuler menggunakan Absesi Digital *RFID* pada', 'Demikian Informasi kami sampaikan untuk menjadi Sarana Monitoring Orang Tua Siswa terhadap putra putrinya. Terima kasih dan salam hangat dari Kami,Pesan ini tidak perlu dibalas', NULL),
(8, 'Assalamualaikum wr.wb', 'Kami informasikan kepada Kepala Sekolah Bahwa Sdr/i :', 'Telah selesai dalam Kegiatan Ekstrakurikuler New Sandik menggunakan Absesi Digital *RFID* pada', 'Demikian Informasi kami sampaikan untuk menjadi Sarana Monitoring Kepala Sekolah terhadap para pegawai. Terima kasih dan salam hangat dari Kami,Pesan ini tidak perlu dibalas', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int(11) NOT NULL,
  `id_ujian` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_bank` int(11) DEFAULT NULL,
  `ujian_mulai` datetime DEFAULT NULL,
  `ujian_berlangsung` datetime DEFAULT NULL,
  `ujian_selesai` datetime DEFAULT NULL,
  `nilai` text DEFAULT NULL,
  `skor` text DEFAULT NULL,
  `online` int(11) NOT NULL DEFAULT 0,
  `ipaddress` varchar(50) DEFAULT NULL,
  `hapus` int(11) NOT NULL DEFAULT 2,
  `katrol` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_capaian`
--

CREATE TABLE `nilai_capaian` (
  `id` int(11) NOT NULL,
  `idsiswa` int(11) DEFAULT NULL,
  `nis` varchar(50) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `idmapel` int(11) DEFAULT NULL,
  `nilai` int(11) DEFAULT NULL,
  `rendah` text DEFAULT NULL,
  `tinggi` text DEFAULT NULL,
  `ket` varchar(50) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `tapel` varchar(50) DEFAULT NULL,
  `guru` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `nilai_capaian`
--

INSERT INTO `nilai_capaian` (`id`, `idsiswa`, `nis`, `kelas`, `idmapel`, `nilai`, `rendah`, `tinggi`, `ket`, `semester`, `tapel`, `guru`) VALUES
(1, 1, '20221001', 'VII-A', 3, 73, 'aaa', 'bb', 'PAS', 1, '2025/2026', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_harian`
--

CREATE TABLE `nilai_harian` (
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `mapel` varchar(11) DEFAULT NULL,
  `idsiswa` varchar(11) DEFAULT NULL,
  `kelas` varchar(11) DEFAULT NULL,
  `guru` varchar(11) DEFAULT NULL,
  `nilai` varchar(11) DEFAULT NULL,
  `smt` varchar(11) DEFAULT NULL,
  `tp` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_rapor`
--

CREATE TABLE `nilai_rapor` (
  `id` int(11) NOT NULL,
  `idsiswa` int(11) DEFAULT NULL,
  `nis` varchar(50) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `idmapel` int(11) DEFAULT NULL,
  `nilai` int(11) DEFAULT NULL,
  `ket` varchar(50) DEFAULT NULL,
  `kodenilai` varchar(50) NOT NULL,
  `semester` int(11) DEFAULT NULL,
  `tapel` varchar(50) DEFAULT NULL,
  `guru` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `nilai_rapor`
--

INSERT INTO `nilai_rapor` (`id`, `idsiswa`, `nis`, `kelas`, `idmapel`, `nilai`, `ket`, `kodenilai`, `semester`, `tapel`, `guru`) VALUES
(1, 1, '20221001', 'VII-A', 3, 80, 'PAS', 'PH', 1, '2025/2026', 1),
(2, 2, '20221002', 'VII-A', 3, NULL, 'PAS', 'PH', 1, '2025/2026', 1),
(3, 3, '20221003', 'VII-A', 3, NULL, 'PAS', 'PH', 1, '2025/2026', 1),
(4, 4, '20221004', 'VII-A', 3, NULL, 'PAS', 'PH', 1, '2025/2026', 1),
(5, 5, '20221005', 'VII-A', 3, NULL, 'PAS', 'PH', 1, '2025/2026', 1),
(6, 6, '20221006', 'VII-A', 3, NULL, 'PAS', 'PH', 1, '2025/2026', 1),
(7, 7, '20221007', 'VII-A', 3, NULL, 'PAS', 'PH', 1, '2025/2026', 1),
(8, 8, '20221008', 'VII-A', 3, NULL, 'PAS', 'PH', 1, '2025/2026', 1),
(9, 9, '20221009', 'VII-A', 3, NULL, 'PAS', 'PH', 1, '2025/2026', 1),
(10, 10, '20221010', 'VII-A', 3, NULL, 'PAS', 'PH', 1, '2025/2026', 1),
(11, 11, '20221011', 'VII-A', 3, NULL, 'PAS', 'PH', 1, '2025/2026', 1),
(12, 12, '20221012', 'VII-A', 3, NULL, 'PAS', 'PH', 1, '2025/2026', 1),
(13, 13, '20221013', 'VII-A', 3, NULL, 'PAS', 'PH', 1, '2025/2026', 1),
(14, 14, '20221014', 'VII-A', 3, NULL, 'PAS', 'PH', 1, '2025/2026', 1),
(15, 15, '20221015', 'VII-A', 3, NULL, 'PAS', 'PH', 1, '2025/2026', 1),
(16, 16, '20221016', 'VII-A', 3, NULL, 'PAS', 'PH', 1, '2025/2026', 1),
(17, 17, '20221017', 'VII-A', 3, NULL, 'PAS', 'PH', 1, '2025/2026', 1),
(18, 18, '20221018', 'VII-A', 3, NULL, 'PAS', 'PH', 1, '2025/2026', 1),
(19, 19, '20221019', 'VII-A', 3, NULL, 'PAS', 'PH', 1, '2025/2026', 1),
(20, 20, '20221020', 'VII-A', 3, NULL, 'PAS', 'PH', 1, '2025/2026', 1),
(21, 1, '20221001', 'VII-A', 3, 70, 'PAS', 'PTS', 1, '2025/2026', 1),
(22, 2, '20221002', 'VII-A', 3, 0, 'PAS', 'PTS', 1, '2025/2026', 1),
(23, 3, '20221003', 'VII-A', 3, 0, 'PAS', 'PTS', 1, '2025/2026', 1),
(24, 4, '20221004', 'VII-A', 3, 0, 'PAS', 'PTS', 1, '2025/2026', 1),
(25, 5, '20221005', 'VII-A', 3, 0, 'PAS', 'PTS', 1, '2025/2026', 1),
(26, 6, '20221006', 'VII-A', 3, 0, 'PAS', 'PTS', 1, '2025/2026', 1),
(27, 7, '20221007', 'VII-A', 3, 0, 'PAS', 'PTS', 1, '2025/2026', 1),
(28, 8, '20221008', 'VII-A', 3, 0, 'PAS', 'PTS', 1, '2025/2026', 1),
(29, 9, '20221009', 'VII-A', 3, 0, 'PAS', 'PTS', 1, '2025/2026', 1),
(30, 10, '20221010', 'VII-A', 3, 0, 'PAS', 'PTS', 1, '2025/2026', 1),
(31, 11, '20221011', 'VII-A', 3, 0, 'PAS', 'PTS', 1, '2025/2026', 1),
(32, 12, '20221012', 'VII-A', 3, 0, 'PAS', 'PTS', 1, '2025/2026', 1),
(33, 13, '20221013', 'VII-A', 3, 0, 'PAS', 'PTS', 1, '2025/2026', 1),
(34, 14, '20221014', 'VII-A', 3, 0, 'PAS', 'PTS', 1, '2025/2026', 1),
(35, 15, '20221015', 'VII-A', 3, 0, 'PAS', 'PTS', 1, '2025/2026', 1),
(36, 16, '20221016', 'VII-A', 3, 0, 'PAS', 'PTS', 1, '2025/2026', 1),
(37, 17, '20221017', 'VII-A', 3, 0, 'PAS', 'PTS', 1, '2025/2026', 1),
(38, 18, '20221018', 'VII-A', 3, 0, 'PAS', 'PTS', 1, '2025/2026', 1),
(39, 19, '20221019', 'VII-A', 3, 0, 'PAS', 'PTS', 1, '2025/2026', 1),
(40, 20, '20221020', 'VII-A', 3, 0, 'PAS', 'PTS', 1, '2025/2026', 1),
(41, 1, '20221001', 'VII-A', 3, 70, 'PAS', 'PAS', 1, '2025/2026', 1),
(42, 2, '20221002', 'VII-A', 3, NULL, 'PAS', 'PAS', 1, '2025/2026', 1),
(43, 3, '20221003', 'VII-A', 3, NULL, 'PAS', 'PAS', 1, '2025/2026', 1),
(44, 4, '20221004', 'VII-A', 3, NULL, 'PAS', 'PAS', 1, '2025/2026', 1),
(45, 5, '20221005', 'VII-A', 3, NULL, 'PAS', 'PAS', 1, '2025/2026', 1),
(46, 6, '20221006', 'VII-A', 3, NULL, 'PAS', 'PAS', 1, '2025/2026', 1),
(47, 7, '20221007', 'VII-A', 3, NULL, 'PAS', 'PAS', 1, '2025/2026', 1),
(48, 8, '20221008', 'VII-A', 3, NULL, 'PAS', 'PAS', 1, '2025/2026', 1),
(49, 9, '20221009', 'VII-A', 3, NULL, 'PAS', 'PAS', 1, '2025/2026', 1),
(50, 10, '20221010', 'VII-A', 3, NULL, 'PAS', 'PAS', 1, '2025/2026', 1),
(51, 11, '20221011', 'VII-A', 3, NULL, 'PAS', 'PAS', 1, '2025/2026', 1),
(52, 12, '20221012', 'VII-A', 3, NULL, 'PAS', 'PAS', 1, '2025/2026', 1),
(53, 13, '20221013', 'VII-A', 3, NULL, 'PAS', 'PAS', 1, '2025/2026', 1),
(54, 14, '20221014', 'VII-A', 3, NULL, 'PAS', 'PAS', 1, '2025/2026', 1),
(55, 15, '20221015', 'VII-A', 3, NULL, 'PAS', 'PAS', 1, '2025/2026', 1),
(56, 16, '20221016', 'VII-A', 3, NULL, 'PAS', 'PAS', 1, '2025/2026', 1),
(57, 17, '20221017', 'VII-A', 3, NULL, 'PAS', 'PAS', 1, '2025/2026', 1),
(58, 18, '20221018', 'VII-A', 3, NULL, 'PAS', 'PAS', 1, '2025/2026', 1),
(59, 19, '20221019', 'VII-A', 3, NULL, 'PAS', 'PAS', 1, '2025/2026', 1),
(60, 20, '20221020', 'VII-A', 3, NULL, 'PAS', 'PAS', 1, '2025/2026', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_skl`
--

CREATE TABLE `nilai_skl` (
  `id` int(11) NOT NULL,
  `idsiswa` varchar(11) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `mapel` varchar(11) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `nilai` varchar(50) DEFAULT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `ket` varchar(50) DEFAULT NULL,
  `ki` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pay_lain`
--

CREATE TABLE `pay_lain` (
  `id_lain` int(11) NOT NULL,
  `idpeg` int(11) DEFAULT NULL,
  `tugas` varchar(50) DEFAULT NULL,
  `besar` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pay_lain`
--

INSERT INTO `pay_lain` (`id_lain`, `idpeg`, `tugas`, `besar`) VALUES
(2, 1, 'Kepala Sekolah', '3500000'),
(4, 1, 'Wali Kelas', '50000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pdb`
--

CREATE TABLE `pdb` (
  `id` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT 0,
  `tahun` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pdb`
--

INSERT INTO `pdb` (`id`, `jumlah`, `tahun`) VALUES
(1, 0, '2025');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggaran`
--

CREATE TABLE `pelanggaran` (
  `id` int(11) NOT NULL,
  `nama_pelanggaran` varchar(100) NOT NULL,
  `poin` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggaran`
--

INSERT INTO `pelanggaran` (`id`, `nama_pelanggaran`, `poin`, `id_kategori`) VALUES
(1, 'Tidak pakai seragam', 2, 1),
(2, 'Terlambat masuk kelas', 1, 2),
(3, 'Membolos', 3, 2),
(4, 'Membuang sampah sembarangan', 1, 3),
(5, 'Seragam tidak lengkap', 2, 1),
(6, 'Atribut pribadi berlebihan', 2, 1),
(7, 'Sakit', 1, 5),
(10, 'Izin', 1, 5),
(11, 'Tanpa Keterangan', 5, 5),
(12, 'Keterlambatan', 3, 2),
(13, 'Tidak taat aturan', 2, 2),
(14, 'Sikap dan Prilaku', 2, 2),
(15, 'Bekas makanan berserakan', 2, 3),
(16, 'Tidak melaksanakan tugas piket', 2, 3),
(17, 'Buang sampah sembarang ', 2, 3),
(18, 'Tidak hormat Guru', 2, 4),
(19, 'Berbicara kasar', 1, 4),
(20, 'Berpacaran disekolah', 3, 4),
(21, 'Merokok atau membawa barang terlarang', 50, 4),
(22, 'Mencuri barang di area sekolah', 2, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id_aplikasi` int(11) NOT NULL,
  `aplikasi` varchar(50) DEFAULT NULL,
  `sekolah` varchar(50) DEFAULT NULL,
  `npsn` varchar(50) DEFAULT NULL,
  `jenjang` varchar(50) DEFAULT NULL,
  `kepsek` varchar(50) DEFAULT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `nowa` varchar(13) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `desa` varchar(50) DEFAULT NULL,
  `kecamatan` varchar(50) DEFAULT NULL,
  `kabupaten` varchar(50) DEFAULT NULL,
  `propinsi` varchar(50) DEFAULT NULL,
  `waktu` varchar(100) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `web` varchar(100) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `telp` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tp` varchar(50) DEFAULT NULL,
  `semester` varchar(1) DEFAULT NULL,
  `url_api` varchar(100) DEFAULT NULL,
  `wa_token` varchar(100) DEFAULT NULL,
  `header` text DEFAULT NULL,
  `server` varchar(50) NOT NULL DEFAULT 'PUSAT',
  `token_api` text DEFAULT NULL,
  `mesin` int(11) NOT NULL DEFAULT 1,
  `notif` varchar(8) DEFAULT NULL,
  `jenis_ujian` varchar(50) DEFAULT NULL,
  `kode_ujian` varchar(50) DEFAULT NULL,
  `header_kartu` varchar(255) DEFAULT NULL,
  `kode_server` varchar(50) NOT NULL DEFAULT 'SANDIK-01',
  `jjm` varchar(50) DEFAULT NULL,
  `honor` varchar(50) DEFAULT NULL,
  `webcam` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data untuk tabel `pengaturan`
--

INSERT INTO `pengaturan` (`id_aplikasi`, `aplikasi`, `sekolah`, `npsn`, `jenjang`, `kepsek`, `nip`, `nowa`, `alamat`, `desa`, `kecamatan`, `kabupaten`, `propinsi`, `waktu`, `logo`, `web`, `fax`, `telp`, `email`, `tp`, `semester`, `url_api`, `wa_token`, `header`, `server`, `token_api`, `mesin`, `notif`, `jenis_ujian`, `kode_ujian`, `header_kartu`, `kode_server`, `jjm`, `honor`, `webcam`) VALUES
(1, 'SISTEM APLIKASI PENDIDIK', 'SMA NEGERI 1 NUSANTARA', '70892683561', 'SMA', 'Dr. George Washington, S.Pd. M.Pd.', '3027357152866821', '0882021733186', 'Jln. Merdeka Barat', 'Suka', 'Maju', 'Nusantara', 'Nusa Utara', 'Asia/Jakarta', 'logo558.png', 'https://app.newsandik.com', '-', '081380774602', 'sma1@esandik.my.id', '2025/2026', '2', 'https://api.fonnte.com', 'YnHMd7THBfozaQM9VHR3', 'DINAS PENDIDIKAN KABUPATEN NUSANTARA', 'https://', 'M4L4N9KJ9vUTCuZwEdisxxx', 2, '06:00:00', 'Penilaian Sumatif Akhir Semester', 'PSAS', 'KARTU PESERTA UJIAN', 'K02170240-A2425', '30', '20000', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul`, `isi`, `tanggal`) VALUES
(1, 'Petunjuk', '<p>Selamat Datang, Silahkan Ikuti sesuai petun juk danmketentuan ujian!</p>', '2026-03-15 19:26:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesan_terkirim`
--

CREATE TABLE `pesan_terkirim` (
  `id` int(11) NOT NULL,
  `idsiswa` varchar(11) DEFAULT NULL,
  `idpeg` varchar(11) DEFAULT NULL,
  `waktu` varchar(50) DEFAULT NULL,
  `ket` varchar(5) DEFAULT NULL,
  `nowa` varchar(14) DEFAULT NULL,
  `isi` mediumtext DEFAULT NULL,
  `sender` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `peskul`
--

CREATE TABLE `peskul` (
  `id` int(11) NOT NULL,
  `eskul` varchar(100) DEFAULT NULL,
  `idsiswa` int(11) DEFAULT NULL,
  `nis` varchar(50) DEFAULT NULL,
  `nilai` varchar(11) DEFAULT NULL,
  `ket` varchar(11) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `tapel` varchar(50) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_aspek`
--

CREATE TABLE `pkl_aspek` (
  `id_aspek` int(11) NOT NULL,
  `kode_aspek` varchar(10) DEFAULT NULL,
  `nama_aspek` varchar(100) NOT NULL,
  `kategori` enum('Sikap','Keterampilan','Kemandirian','Laporan') NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `bobot` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pkl_aspek`
--

INSERT INTO `pkl_aspek` (`id_aspek`, `kode_aspek`, `nama_aspek`, `kategori`, `deskripsi`, `bobot`) VALUES
(1, 'A1', 'Kedisiplinan', 'Sikap', 'Datang tepat waktu, menaati peraturan kerja', 10),
(2, 'A2', 'Tanggung Jawab', 'Sikap', 'Menyelesaikan tugas sesuai instruksi', 10),
(3, 'A3', 'Kejujuran', 'Sikap', 'Jujur dan transparan dalam pekerjaan', 10),
(4, 'A4', 'Kerjasama', 'Sikap', 'Bekerjasama dengan rekan kerja dengan baik', 10),
(5, 'B1', 'Keterampilan Teknis', 'Keterampilan', 'Menguasai alat dan prosedur kerja', 25),
(6, 'B2', 'Kualitas Hasil Kerja', 'Keterampilan', 'Hasil pekerjaan sesuai standar industri', 15),
(7, 'B3', 'K3 (Keselamatan dan Kesehatan Kerja)', 'Keterampilan', 'Menerapkan prosedur K3 dengan benar', 5),
(8, 'C1', 'Inisiatif dan Kreativitas', 'Kemandirian', 'Menunjukkan ide dan solusi baru dalam pekerjaan', 5),
(9, 'D1', 'Laporan dan Presentasi', 'Laporan', 'Membuat laporan lengkap dan mempresentasikan hasil dengan baik', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_dudi`
--

CREATE TABLE `pkl_dudi` (
  `id` int(11) NOT NULL,
  `nama_dudi` varchar(150) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `instruktur` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_jurnal`
--

CREATE TABLE `pkl_jurnal` (
  `id` int(11) NOT NULL,
  `idsiswa` int(11) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `dudi` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `idk` int(11) DEFAULT NULL,
  `jurnal` text DEFAULT NULL,
  `foto_jurnal` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `catatan` varchar(255) DEFAULT NULL,
  `ttd` varchar(255) DEFAULT NULL,
  `pembina` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_kegiatan`
--

CREATE TABLE `pkl_kegiatan` (
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `bulan` varchar(11) DEFAULT NULL,
  `jam` varchar(50) DEFAULT NULL,
  `lat` varchar(50) DEFAULT NULL,
  `lon` varchar(50) DEFAULT NULL,
  `idsiswa` varchar(11) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `kegiatan` text DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `dudi` varchar(11) DEFAULT NULL,
  `ket` varchar(1) NOT NULL DEFAULT 'H',
  `ttd` varchar(100) DEFAULT NULL,
  `instruktur` varchar(50) DEFAULT NULL,
  `pulang` varchar(50) DEFAULT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_kompetensi`
--

CREATE TABLE `pkl_kompetensi` (
  `id_kompetensi` int(11) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `kompeten` varchar(255) DEFAULT NULL,
  `deskrip` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pkl_kompetensi`
--

INSERT INTO `pkl_kompetensi` (`id_kompetensi`, `jurusan`, `kompeten`, `deskrip`) VALUES
(1, 'TKJ', 'Instalasi Jaringan LAN', 'Mampu merancang dan menginstal jaringan lokal (LAN).'),
(2, 'TKJ', 'Konfigurasi Router & Switch', 'Melakukan konfigurasi dasar perangkat jaringan.'),
(3, 'TKJ', 'Maintenance Jaringan', 'Melakukan pemeliharaan dan troubleshooting jaringan.'),
(4, 'TKJ', 'Instalasi Sistem Operasi Jaringan', 'Menginstal dan mengelola OS berbasis server (Linux/Windows).'),
(5, 'TKJ', 'Pemrograman Web Dasar', 'Mampu membuat aplikasi web menggunakan HTML, CSS, dan JavaScript.'),
(6, 'TKJ', 'Pemrograman Berbasis Database', 'Mengembangkan aplikasi CRUD menggunakan PHP & MySQL.'),
(7, 'TKJ', 'Version Control dengan Git', 'Menggunakan Git untuk kolaborasi pengembangan perangkat lunak.'),
(8, 'TKJ', 'Pengujian Aplikasi (Testing)', 'Melakukan uji fungsionalitas dan debugging aplikasi.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_nilai`
--

CREATE TABLE `pkl_nilai` (
  `id_nilai` int(11) NOT NULL,
  `idsiswa` int(11) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `idguru` int(11) DEFAULT NULL,
  `iddudi` int(11) DEFAULT NULL,
  `idkompetensi` int(11) DEFAULT NULL,
  `aspek` varchar(100) DEFAULT NULL,
  `nilai` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_presensi`
--

CREATE TABLE `pkl_presensi` (
  `id` int(11) NOT NULL,
  `idsiswa` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `masuk` int(11) DEFAULT NULL,
  `ket` varchar(11) DEFAULT 'H',
  `jam_masuk` timestamp NOT NULL DEFAULT current_timestamp(),
  `pulang` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_siswa`
--

CREATE TABLE `pkl_siswa` (
  `id` int(11) NOT NULL,
  `idsiswa` int(11) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `dudi` int(11) DEFAULT NULL,
  `idguru` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` varchar(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `kategori` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk_kategori`
--

CREATE TABLE `produk_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk_kategori`
--

INSERT INTO `produk_kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Makanan'),
(2, 'Minuman'),
(3, 'Gorengan'),
(4, 'Snack');

-- --------------------------------------------------------

--
-- Struktur dari tabel `saldo`
--

CREATE TABLE `saldo` (
  `id_saldo` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `idsiswa` int(11) NOT NULL,
  `debet` int(11) NOT NULL DEFAULT 0,
  `kredit` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sapras`
--

CREATE TABLE `sapras` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(200) NOT NULL,
  `idk` int(11) DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `kondisi` enum('Baik','Rusak Ringan','Rusak Berat') NOT NULL,
  `sumber_dana` varchar(150) DEFAULT NULL,
  `lokasi_id` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sapras`
--

INSERT INTO `sapras` (`id`, `nama_barang`, `idk`, `jumlah`, `kondisi`, `sumber_dana`, `lokasi_id`, `foto`, `keterangan`) VALUES
(1, 'Laptop Acer Aspire 5', 1, 15, 'Rusak Ringan', 'Komite Sekolah', 9, '1765097951_arduino.jpg', 'Digunakan untuk pembelajaran di lab komputer'),
(2, 'Kursi Belajar Kayu', 2, 30, 'Baik', 'Dana Sekolah', 4, 'kursi_kelas.jpg', 'Kursi untuk siswa kelas 1'),
(3, 'Sapu Ijuk', 3, 5, 'Baik', 'Komite', 10, 'sapu_ijuk.jpg', 'Alat kebersihan umum'),
(4, 'Printer Epson L3110', 1, 2, 'Rusak Ringan', 'BOS', 3, 'printer_epson.jpg', 'Butuh penggantian tinta dan cleaning head'),
(5, 'Bola Futsal', 5, 4, 'Baik', 'Donasi', 8, 'bola_futsal.jpg', 'Untuk kegiatan olahraga rutin'),
(6, 'Router TP-Link Archer C6', 6, 3, 'Rusak Berat', 'BOS', 9, 'router_tplink.jpg', 'Tidak bisa menyala'),
(7, 'Mikroskop Optik', 7, 2, 'Baik', 'Dana Lab', 9, 'mikroskop.jpg', 'Untuk praktikum IPA'),
(8, 'Whiteboard Magnetik', 2, 1, 'Baik', 'Dana Sekolah', 5, 'whiteboard.jpg', 'Digunakan di kelas 2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sapras_kate`
--

CREATE TABLE `sapras_kate` (
  `id` int(11) NOT NULL,
  `kategori` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sapras_kate`
--

INSERT INTO `sapras_kate` (`id`, `kategori`) VALUES
(1, 'Peralatan Elektronik'),
(2, 'Perabotan'),
(3, 'Alat Kebersihan'),
(4, 'Alat Tulis Kantor (ATK)'),
(5, 'Peralatan Olahraga'),
(6, 'Perangkat Jaringan'),
(7, 'Laboratorium'),
(8, 'Lainnya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sapras_ruangan`
--

CREATE TABLE `sapras_ruangan` (
  `id` int(11) NOT NULL,
  `nama_ruangan` varchar(150) NOT NULL,
  `lokasi` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sapras_ruangan`
--

INSERT INTO `sapras_ruangan` (`id`, `nama_ruangan`, `lokasi`) VALUES
(1, 'Ruang Kepala Sekolah', 'Lantai 1'),
(2, 'Ruang Guru', 'Lantai 1'),
(3, 'Ruang TU', 'Lantai 1'),
(4, 'Ruang Kelas 1', 'Gedung A'),
(5, 'Ruang Kelas 2', 'Gedung A'),
(6, 'Ruang Kelas 3', 'Gedung A'),
(7, 'Ruang Perpustakaan', 'Gedung B'),
(8, 'Ruang UKS', 'Gedung B'),
(9, 'Ruang Lab Komputer', 'Gedung C'),
(10, 'Gudang', 'Belakang Sekolah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sinkron`
--

CREATE TABLE `sinkron` (
  `id` int(11) NOT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `jumlah` varchar(50) DEFAULT NULL,
  `tanggal` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data untuk tabel `sinkron`
--

INSERT INTO `sinkron` (`id`, `kode`, `jumlah`, `tanggal`) VALUES
(1, 'SISWA', '0', NULL),
(2, 'PEGAWAI', '0', NULL),
(3, 'MAPEL', '0', NULL),
(4, 'KELAS', '0', NULL),
(5, 'BANK', '0', NULL),
(6, 'SOAL', '0', NULL),
(7, 'JENIS', '0', NULL),
(8, 'JADWAL', '0', NULL),
(9, 'REG', '0', NULL),
(10, 'KBM', '0', NULL),
(11, 'ESKUL', '0', NULL),
(12, 'JJM', '0', NULL),
(13, 'WAKTU', '0', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nis` varchar(50) DEFAULT NULL,
  `nisn` varchar(50) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `level` varchar(11) DEFAULT NULL,
  `fase` varchar(2) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `jk` varchar(1) DEFAULT NULL,
  `agama` varchar(50) DEFAULT NULL,
  `nowa` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `sts` int(11) NOT NULL DEFAULT 0,
  `online` int(11) NOT NULL DEFAULT 0,
  `blok` int(11) NOT NULL DEFAULT 0,
  `saldo` int(11) NOT NULL DEFAULT 0,
  `nopes` varchar(50) DEFAULT NULL,
  `ruang` varchar(50) DEFAULT NULL,
  `sesi` int(11) DEFAULT NULL,
  `server` varchar(50) DEFAULT NULL,
  `t_lahir` varchar(50) DEFAULT NULL,
  `tgl_lahir` varchar(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `desa` varchar(50) DEFAULT NULL,
  `kec` varchar(50) DEFAULT NULL,
  `kab` varchar(50) DEFAULT NULL,
  `ayah` varchar(50) DEFAULT NULL,
  `ibu` varchar(50) DEFAULT NULL,
  `pek_ayah` varchar(50) DEFAULT NULL,
  `pek_ibu` varchar(50) DEFAULT NULL,
  `total_poin` int(11) NOT NULL DEFAULT 0,
  `id_teguran` int(11) DEFAULT NULL,
  `ket` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nis`, `nisn`, `nama`, `level`, `fase`, `kelas`, `jurusan`, `jk`, `agama`, `nowa`, `foto`, `username`, `password`, `sts`, `online`, `blok`, `saldo`, `nopes`, `ruang`, `sesi`, `server`, `t_lahir`, `tgl_lahir`, `alamat`, `desa`, `kec`, `kab`, `ayah`, `ibu`, `pek_ayah`, `pek_ibu`, `total_poin`, `id_teguran`, `ket`) VALUES
(1, '20221001', '0001', 'ABIWANTA RIZKY WIDYA AGUNG', '10', 'E', '10-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-1', 'US-1', 0, 0, 0, 0, 'US-SMA-001', '1', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(2, '20221002', '0002', 'AISYAH TRI CAHYA', '10', 'E', '10-A', 'UMUM', 'P', 'Islam', '', NULL, 'US-2', 'US-2', 0, 0, 0, 0, 'US-SMA-002', '1', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(3, '20221003', '0003', 'AISYAH VARDA URIFA', '10', 'E', '10-A', 'UMUM', 'P', 'Islam', '', NULL, 'US-3', 'US-3', 0, 0, 0, 0, 'US-SMA-003', '1', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(4, '20221004', '0004', 'ALVERO DHIKO LEVANO', '10', 'E', '10-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-4', 'US-4', 0, 0, 0, 0, 'US-SMA-004', '1', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(5, '20221005', '0005', 'ANAVELIA FRANSISCA SIMANJUNTAK', '10', 'E', '10-A', 'UMUM', 'P', 'Kristen', '', NULL, 'US-5', 'US-5', 0, 0, 0, 0, 'US-SMA-005', '1', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(6, '20221006', '0006', 'ANDREAS NOVA ANDRIANO', '10', 'E', '10-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-6', 'US-6', 0, 0, 0, 0, 'US-SMA-006', '1', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(7, '20221007', '0007', 'AUREL GRESIASEPTIANA', '10', 'E', '10-A', 'UMUM', 'P', 'Kristen', '', NULL, 'US-7', 'US-7', 0, 0, 0, 0, 'US-SMA-007', '1', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(8, '20221008', '0008', 'AYESSHA SILVIA AMELLYA', '10', 'E', '10-A', 'UMUM', 'P', 'Kristen', '', NULL, 'US-8', 'US-8', 0, 0, 0, 0, 'US-SMA-008', '1', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(9, '20221009', '0009', 'BELLA AYU INDAH SARI', '10', 'E', '10-A', 'UMUM', 'P', 'Islam', '', NULL, 'US-9', 'US-9', 0, 0, 0, 0, 'US-SMA-009', '1', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(10, '20221010', '0010', 'DANELA CRISTIANE', '10', 'E', '10-A', 'UMUM', 'P', 'Kristen', '', NULL, 'US-10', 'US-10', 0, 0, 0, 0, 'US-SMA-010', '1', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(11, '20221011', '0011', 'DANY SAFA\'AD', '10', 'E', '10-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-11', 'US-11', 0, 0, 0, 0, 'US-SMA-011', '1', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(12, '20221012', '0012', 'DENIS SABRINA', '10', 'E', '10-B', 'UMUM', 'P', 'Islam', '', NULL, 'US-12', 'US-12', 0, 0, 0, 0, 'US-SMA-012', '2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(13, '20221013', '0013', 'FADILLAH RAMADHANI', '10', 'E', '10-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-13', 'US-13', 0, 0, 0, 0, 'US-SMA-013', '2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(14, '20221014', '0014', 'FAKHRI RAHMAD JULIAN', '10', 'E', '10-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-14', 'US-14', 0, 0, 0, 0, 'US-SMA-014', '2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(15, '20221015', '0015', 'FIRA RAHAYU DWIYANING P', '10', 'E', '10-B', 'UMUM', 'P', 'Islam', '', NULL, 'US-15', 'US-15', 0, 0, 0, 0, 'US-SMA-015', '2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(16, '20221016', '0016', 'Gantari Sastra Paramadiwa', '10', 'E', '10-B', 'UMUM', 'P', 'Islam', '', NULL, 'US-16', 'US-16', 0, 0, 0, 0, 'US-SMA-016', '2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(17, '20221017', '0017', 'GILANG ANDRIANTAMA', '10', 'E', '10-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-17', 'US-17', 0, 0, 0, 0, 'US-SMA-017', '2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(18, '20221018', '0018', 'HERI PRASETYO', '10', 'E', '10-B', 'UMUM', 'L', 'Kristen', '', NULL, 'US-18', 'US-18', 0, 0, 0, 0, 'US-SMA-018', '2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(19, '20221019', '0019', 'IRFAN ANTONY FAUZAN IBNI', '11', 'F', '11-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-19', 'US-19', 0, 0, 0, 0, 'US-SMA-019', '3', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(20, '20221020', '0020', 'KARINA MEGA KASIH', '11', 'F', '11-A', 'UMUM', 'P', 'Kristen', '', NULL, 'US-20', 'US-20', 0, 0, 0, 0, 'US-SMA-020', '3', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(21, '20221021', '0021', 'LUTFI AVRILIA', '11', 'F', '11-A', 'UMUM', 'P', 'Islam', '', NULL, 'US-21', 'US-21', 0, 0, 0, 0, 'US-SMA-021', '3', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(22, '20221022', '0022', 'MUHAMMAD ALIF WALID MAULIDDIN', '11', 'F', '11-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-22', 'US-22', 0, 0, 0, 0, 'US-SMA-022', '3', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(23, '20221023', '0023', 'NICO ANDREAN HASAN EFENDI', '11', 'F', '11-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-23', 'US-23', 0, 0, 0, 0, 'US-SMA-023', '3', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(24, '20221024', '0024', 'PURI AYU CHRISTIANI', '11', 'F', '11-A', 'UMUM', 'P', 'Kristen', '', NULL, 'US-24', 'US-24', 0, 0, 0, 0, 'US-SMA-024', '3', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(25, '20221025', '0025', 'RAHMAT RENDI SANTOSO', '11', 'F', '11-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-25', 'US-25', 0, 0, 0, 0, 'US-SMA-025', '3', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(26, '20221026', '0026', 'RAIHAN NUR FATHONI', '11', 'F', '11-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-26', 'US-26', 0, 0, 0, 0, 'US-SMA-026', '3', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(27, '20221027', '0027', 'Riko Yoji Zebrian', '11', 'F', '11-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-27', 'US-27', 0, 0, 0, 0, 'US-SMA-027', '3', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(28, '20221028', '0028', 'ROHMAN ALFIANSYAH', '11', 'F', '11-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-28', 'US-28', 0, 0, 0, 0, 'US-SMA-028', '3', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(29, '20221029', '0029', 'RUSTALINO ADE ENDARTO', '11', 'F', '11-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-29', 'US-29', 0, 0, 0, 0, 'US-SMA-029', '3', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(30, '20221030', '0030', 'RYAN AHMAD AFFANDI', '11', 'F', '11-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-30', 'US-30', 0, 0, 0, 0, 'US-SMA-030', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(31, '20221031', '0031', 'SEPTARIA EKA KRISTANTI', '11', 'F', '11-B', 'UMUM', 'P', 'Kristen', '', NULL, 'US-31', 'US-31', 0, 0, 0, 0, 'US-SMA-031', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(32, '20221032', '0032', 'STEVANIA HARVIANING CRISTIANI', '11', 'F', '11-B', 'UMUM', 'P', 'Kristen', '', NULL, 'US-32', 'US-32', 0, 0, 0, 0, 'US-SMA-032', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(33, '20221033', '0033', 'WIDYA LESTARI', '11', 'F', '11-B', 'UMUM', 'P', 'Islam', '', NULL, 'US-33', 'US-33', 0, 0, 0, 0, 'US-SMA-033', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(34, '20221034', '0034', 'ACHMAD ARIFIN', '11', 'F', '11-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-34', 'US-34', 0, 0, 0, 0, 'US-SMA-034', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(35, '20221035', '0035', 'AISAH CINDY PRATAMA', '11', 'F', '11-B', 'UMUM', 'P', 'Islam', '', NULL, 'US-35', 'US-35', 0, 0, 0, 0, 'US-SMA-035', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(36, '20221036', '0036', 'AISYAH NUR RAHMA', '11', 'F', '11-B', 'UMUM', 'P', 'Islam', '', NULL, 'US-36', 'US-36', 0, 0, 0, 0, 'US-SMA-036', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(37, '20221037', '0037', 'Aji Wahyudi', '11', 'F', '11-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-37', 'US-37', 0, 0, 0, 0, 'US-SMA-037', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(38, '20221038', '0038', 'ANDRE RIZKY YULIANTO', '11', 'F', '11-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-38', 'US-38', 0, 0, 0, 0, 'US-SMA-038', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(39, '20221039', '0039', 'ANGGUN RITA AMELIA', '11', 'F', '11-B', 'UMUM', 'P', 'Islam', '', NULL, 'US-39', 'US-39', 0, 0, 0, 0, 'US-SMA-039', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(40, '20221040', '0040', 'ANISA KURNIA ISTIANI', '11', 'F', '11-B', 'UMUM', 'P', 'Islam', '', NULL, 'US-40', 'US-40', 0, 0, 0, 0, 'US-SMA-040', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(41, '20221041', '0041', 'BAGAS PRASETYA', '11', 'F', '11-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-41', 'US-41', 0, 0, 0, 0, 'US-SMA-041', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(42, '20221042', '0042', 'BILAL AHMAD', '11', 'F', '11-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-42', 'US-42', 0, 0, 0, 0, 'US-SMA-042', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(43, '20221043', '0043', 'DARIL ALIF ZULKARNAEN', '11', 'F', '11-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-43', 'US-43', 0, 0, 0, 0, 'US-SMA-043', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(44, '20221044', '0044', 'Derian Putra Pratama', '11', 'F', '11-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-44', 'US-44', 0, 0, 0, 0, 'US-SMA-044', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(45, '20221045', '0045', 'ERISTA VELANICA PUTRI', '11', 'F', '11-B', 'UMUM', 'P', 'Islam', '', NULL, 'US-45', 'US-45', 0, 0, 0, 0, 'US-SMA-045', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(46, '20221046', '0046', 'FARAH NADIA TAUFIQY', '11', 'F', '11-B', 'UMUM', 'P', 'Islam', '', NULL, 'US-46', 'US-46', 0, 0, 0, 0, 'US-SMA-046', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(47, '20221047', '0047', 'FERNANDO VICKY ALVIANSAH', '11', 'F', '11-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-47', 'US-47', 0, 0, 0, 0, 'US-SMA-047', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(48, '20221048', '0048', 'GABRIELLA NATAZHA SALSABILLA', '11', 'F', '11-B', 'UMUM', 'P', 'Islam', '', NULL, 'US-48', 'US-48', 0, 0, 0, 0, 'US-SMA-048', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(49, '20221049', '0049', 'GIOVANO HERNINO SAPUTRA', '11', 'F', '11-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-49', 'US-49', 0, 0, 0, 0, 'US-SMA-049', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(50, '20221050', '0050', 'IQBAL JAUHAR RAVANDA', '11', 'F', '11-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-50', 'US-50', 0, 0, 0, 0, 'US-SMA-050', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(51, '20221051', '0051', 'IZZATUL HASANAH RAFIATUZ ZAHRO', '11', 'F', '11-B', 'UMUM', 'P', 'Islam', '', NULL, 'US-51', 'US-51', 0, 0, 0, 0, 'US-SMA-051', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(52, '20221052', '0052', 'LEITISYA ZEINNARA', '11', 'F', '11-B', 'UMUM', 'P', 'Islam', '', NULL, 'US-52', 'US-52', 0, 0, 0, 0, 'US-SMA-052', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(53, '20221053', '0053', 'M. AJI FIKI RAHMATDANI SOFIULLOH', '11', 'F', '11-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-53', 'US-53', 0, 0, 0, 0, 'US-SMA-053', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(54, '20221054', '0054', 'MILA PUTRI MIRANDA', '11', 'F', '11-B', 'UMUM', 'P', 'Islam', '', NULL, 'US-54', 'US-54', 0, 0, 0, 0, 'US-SMA-054', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(55, '20221055', '0055', 'MOH. AVATAR', '11', 'F', '11-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-55', 'US-55', 0, 0, 0, 0, 'US-SMA-055', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(56, '20221056', '0056', 'MUHAMMAD HABIBI', '11', 'F', '11-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-56', 'US-56', 0, 0, 0, 0, 'US-SMA-056', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(57, '20221057', '0057', 'Muhhamad Rudianto', '11', 'F', '11-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-57', 'US-57', 0, 0, 0, 0, 'US-SMA-057', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(58, '20221058', '0058', 'NABHAN RADINKA KEVAN', '11', 'F', '11-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-58', 'US-58', 0, 0, 0, 0, 'US-SMA-058', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(59, '20221059', '0059', 'NICO ALFIANO PRATAMA', '11', 'F', '11-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-59', 'US-59', 0, 0, 0, 0, 'US-SMA-059', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(60, '20221060', '0060', 'RAHMAD RIVALDI', '11', 'F', '11-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-60', 'US-60', 0, 0, 0, 0, 'US-SMA-060', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(61, '20221061', '0061', 'RAISYA SOFIA BUNGA FIRDAUS', '11', 'F', '11-B', 'UMUM', 'P', 'Islam', '', NULL, 'US-61', 'US-61', 0, 0, 0, 0, 'US-SMA-061', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(62, '20221062', '0062', 'RANIKA ARUM PRATIWI', '11', 'F', '11-B', 'UMUM', 'P', 'Islam', '', NULL, 'US-62', 'US-62', 0, 0, 0, 0, 'US-SMA-062', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(63, '20221063', '0063', 'RATNA ANIZAH', '11', 'F', '11-B', 'UMUM', 'P', 'Islam', '', NULL, 'US-63', 'US-63', 0, 0, 0, 0, 'US-SMA-063', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(64, '20221064', '0064', 'Riski Maulana', '11', 'F', '11-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-64', 'US-64', 0, 0, 0, 0, 'US-SMA-064', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(65, '20221065', '0065', 'SABIAN SYAUQI ARATA', '11', 'F', '11-B', 'UMUM', 'L', 'Islam', '', NULL, 'US-65', 'US-65', 0, 0, 0, 0, 'US-SMA-065', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(66, '20221066', '0066', 'SALSA WULAN DELIMA', '11', 'F', '11-B', 'UMUM', 'P', 'Islam', '', NULL, 'US-66', 'US-66', 0, 0, 0, 0, 'US-SMA-066', '4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(67, '20221067', '0067', 'VILWA SYEIRA EN NADIA', '12', 'F', '12-A', 'UMUM', 'P', 'Islam', '', NULL, 'US-67', 'US-67', 0, 0, 0, 0, 'US-SMA-067', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(68, '20221068', '0068', 'WIGNYO ADAM', '12', 'F', '12-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-68', 'US-68', 0, 0, 0, 0, 'US-SMA-068', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(69, '20221069', '0069', 'ADELIA DWI NURFADILA', '12', 'F', '12-A', 'UMUM', 'P', 'Islam', '', NULL, 'US-69', 'US-69', 0, 0, 0, 0, 'US-SMA-069', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(70, '20221070', '0070', 'AHMAT', '12', 'F', '12-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-70', 'US-70', 0, 0, 0, 0, 'US-SMA-070', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(71, '20221071', '0071', 'AIRIN KHORIZAH NUR RAHMAH', '12', 'F', '12-A', 'UMUM', 'P', 'Islam', '', NULL, 'US-71', 'US-71', 0, 0, 0, 0, 'US-SMA-071', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(72, '20221072', '0072', 'ANDIKA NUR FURQON NASRULLAH', '12', 'F', '12-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-72', 'US-72', 0, 0, 0, 0, 'US-SMA-072', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(73, '20221073', '0073', 'ANITA KURNIAWATI', '12', 'F', '12-A', 'UMUM', 'P', 'Islam', '', NULL, 'US-73', 'US-73', 0, 0, 0, 0, 'US-SMA-073', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(74, '20221074', '0074', 'AYNA RO\'IFFATUL AZIZAH', '12', 'F', '12-A', 'UMUM', 'P', 'Islam', '', NULL, 'US-74', 'US-74', 0, 0, 0, 0, 'US-SMA-074', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(75, '20221075', '0075', 'BILGHIS AZZAHRA', '12', 'F', '12-A', 'UMUM', 'P', 'Islam', '', NULL, 'US-75', 'US-75', 0, 0, 0, 0, 'US-SMA-075', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(76, '20221076', '0076', 'DIAN ILHAM AJI ROHIM', '12', 'F', '12-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-76', 'US-76', 0, 0, 0, 0, 'US-SMA-076', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(77, '20221077', '0077', 'ELVYN ANDHIKA PUTRA PRATAMA', '12', 'F', '12-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-77', 'US-77', 0, 0, 0, 0, 'US-SMA-077', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(78, '20221078', '0078', 'FARHAN NUR HUDA', '12', 'F', '12-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-78', 'US-78', 0, 0, 0, 0, 'US-SMA-078', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(79, '20221079', '0079', 'FITRAH HANUM NIMASAYU', '12', 'F', '12-A', 'UMUM', 'P', 'Islam', '', NULL, 'US-79', 'US-79', 0, 0, 0, 0, 'US-SMA-079', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(80, '20221080', '0080', 'GRIZTA BAYU FEBRIAN FAJAR YUWONO', '12', 'F', '12-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-80', 'US-80', 0, 0, 0, 0, 'US-SMA-080', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(81, '20221081', '0081', 'INGGAR AYU NISWARI', '12', 'F', '12-A', 'UMUM', 'P', 'Islam', '', NULL, 'US-81', 'US-81', 0, 0, 0, 0, 'US-SMA-081', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(82, '20221082', '0082', 'ISYA DIKRI SUDRAJAD', '12', 'F', '12-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-82', 'US-82', 0, 0, 0, 0, 'US-SMA-082', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(83, '20221083', '0083', 'KARUNIA EKA PUTRI', '12', 'F', '12-A', 'UMUM', 'P', 'Islam', '', NULL, 'US-83', 'US-83', 0, 0, 0, 0, 'US-SMA-083', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(84, '20221084', '0084', 'LALA PUTRI MAHARANI', '12', 'F', '12-A', 'UMUM', 'P', 'Islam', '', NULL, 'US-84', 'US-84', 0, 0, 0, 0, 'US-SMA-084', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(85, '20221085', '0085', 'M. FAKHRI ADIS AL-FIKRI', '12', 'F', '12-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-85', 'US-85', 0, 0, 0, 0, 'US-SMA-085', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(86, '20221086', '0086', 'MOCHAMAD JUAN RAFANDA YUSWADI', '12', 'F', '12-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-86', 'US-86', 0, 0, 0, 0, 'US-SMA-086', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(87, '20221087', '0087', 'MUHAMMAD DAVIN PRAYOGA', '12', 'F', '12-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-87', 'US-87', 0, 0, 0, 0, 'US-SMA-087', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(88, '20221088', '0088', 'MUHAMMAD HARIS ALFARIZI', '12', 'F', '12-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-88', 'US-88', 0, 0, 0, 0, 'US-SMA-088', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(89, '20221089', '0089', 'MUHAMMAD SYAQIF ALI MAHRUS', '12', 'F', '12-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-89', 'US-89', 0, 0, 0, 0, 'US-SMA-089', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(90, '20221090', '0090', 'MUTIARA EQUILA KHAIRUNNISA', '12', 'F', '12-A', 'UMUM', 'P', 'Islam', '', NULL, 'US-90', 'US-90', 0, 0, 0, 0, 'US-SMA-090', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(91, '20221091', '0091', 'NABILA AURELIA PUTRI SUSANTO', '12', 'F', '12-A', 'UMUM', 'P', 'Islam', '', NULL, 'US-91', 'US-91', 0, 0, 0, 0, 'US-SMA-091', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(92, '20221092', '0092', 'NAYLA SA\'BANINA', '12', 'F', '12-A', 'UMUM', 'P', 'Islam', '', NULL, 'US-92', 'US-92', 0, 0, 0, 0, 'US-SMA-092', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(93, '20221093', '0093', 'NOWHA ABDUL AZIZ', '12', 'F', '12-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-93', 'US-93', 0, 0, 0, 0, 'US-SMA-093', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(94, '20221094', '0094', 'QIBRAN AHMAD FARIQIN', '12', 'F', '12-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-94', 'US-94', 0, 0, 0, 0, 'US-SMA-094', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(95, '20221095', '0095', 'RISA DEWI ANDINI', '12', 'F', '12-A', 'UMUM', 'P', 'Islam', '', NULL, 'US-95', 'US-95', 0, 0, 0, 0, 'US-SMA-095', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(96, '20221096', '0096', 'SANDI IRAWAN', '12', 'F', '12-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-96', 'US-96', 0, 0, 0, 0, 'US-SMA-096', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(97, '20221097', '0097', 'VICHO MADA ADHYASTA', '12', 'F', '12-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-97', 'US-97', 0, 0, 0, 0, 'US-SMA-097', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(98, '20221098', '0098', 'VIVIAN RISKY FASHA', '12', 'F', '12-A', 'UMUM', 'P', 'Islam', '', NULL, 'US-98', 'US-98', 0, 0, 0, 0, 'US-SMA-098', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(99, '20221099', '0099', 'WALIT HASIN AHMAD', '12', 'F', '12-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-99', 'US-99', 0, 0, 0, 0, 'US-SMA-099', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(100, '20221100', '0100', 'Wildan Al Amin', '12', 'F', '12-A', 'UMUM', 'L', 'Islam', '', NULL, 'US-100', 'US-100', 0, 0, 0, 0, 'US-SMA-100', '5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `skkb`
--

CREATE TABLE `skkb` (
  `id` int(11) NOT NULL,
  `header` text NOT NULL,
  `fungsi` int(11) DEFAULT NULL,
  `file` text DEFAULT NULL,
  `fungsi2` int(11) DEFAULT NULL,
  `isi` longtext NOT NULL,
  `foter` text NOT NULL,
  `nosurat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `skkb`
--

INSERT INTO `skkb` (`id`, `header`, `fungsi`, `file`, `fungsi2`, `isi`, `foter`, `nosurat`) VALUES
(1, 'DINAS PENDIDIKAN KABUPATEN CIANJUR', 0, '', 1, '<p>Adalah benar siswa SMP Taruna Bakti Cikadu dan sepanjang pengetahuan kami anak tersebut <strong>Berkelakuan Baik dan tidak pernah terlibat Narkoba</strong>.</p>', '<p>Demikian Surat Keterangan ini kami buat dengan sesungguhnya dan sebenarnya, dan agar dapat dipergunakan sesuai peruntukkannya.</p>', '432.1/STBC/VI/2025');

-- --------------------------------------------------------

--
-- Struktur dari tabel `skl`
--

CREATE TABLE `skl` (
  `id_skl` int(11) NOT NULL,
  `tingkat` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) NOT NULL,
  `nama_surat` varchar(50) NOT NULL,
  `tgl_surat` varchar(50) NOT NULL,
  `header` mediumtext DEFAULT NULL,
  `pembuka` mediumtext NOT NULL,
  `isi_surat` mediumtext NOT NULL,
  `penutup` mediumtext NOT NULL,
  `sttd` int(1) NOT NULL,
  `sstp` int(1) NOT NULL,
  `nilai` int(1) NOT NULL,
  `kelompok` int(1) NOT NULL,
  `dibuka` datetime DEFAULT NULL,
  `ditutup` datetime DEFAULT NULL,
  `tulisan` text DEFAULT NULL,
  `kuri` int(11) NOT NULL DEFAULT 1,
  `stempel` varchar(50) DEFAULT NULL,
  `ttd` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `skl`
--

INSERT INTO `skl` (`id_skl`, `tingkat`, `no_surat`, `nama_surat`, `tgl_surat`, `header`, `pembuka`, `isi_surat`, `penutup`, `sttd`, `sstp`, `nilai`, `kelompok`, `dibuka`, `ditutup`, `tulisan`, `kuri`, `stempel`, `ttd`) VALUES
(1, '9', '421/STBC/SKL/VI/2025', 'SURAT KETERANGAN LULUS', '14 Juni 2025', 'header_1764301489.jpg', '<p>Berdasarkan hasil Rapat Dewan Guru SMP Taruna Bakti Cikadu tanggal 29 Mei 2025, Kepala SMK SMP Taruna Bakti Cikadu Kabupaten Cianjur, dengan ini menerangkan bahwa :</p>', '<p>Bahwa nama yang tersebut diatas adalah benar Siswa/Siswi SMP Taruna Bakti Cikadu dan telah melaksanakan Ujian Sekolah serta dinyatakan</p>', '<p>Demikian Surat Keterangan Lulus (SKL) ini dibuat dengan sebenarnya untuk dapat digunakan sebagaimana mestinya menjelang diterbitkannya ijazah yang bersangkutan.</p>', 1, 1, 1, 1, '2025-11-29 06:00:00', '2025-12-18 07:00:00', 'tes', 2, 'stempel_1764301597.png', 'ttd_1764301597.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `soal`
--

CREATE TABLE `soal` (
  `id_soal` int(11) NOT NULL,
  `id_bank` int(11) DEFAULT NULL,
  `nomor` int(11) DEFAULT NULL,
  `soal` longtext DEFAULT NULL,
  `jenis` int(11) DEFAULT NULL,
  `pilA` longtext DEFAULT NULL,
  `pilB` longtext DEFAULT NULL,
  `pilC` longtext DEFAULT NULL,
  `pilD` longtext DEFAULT NULL,
  `pilE` longtext DEFAULT NULL,
  `perA` longtext DEFAULT NULL,
  `perB` longtext DEFAULT NULL,
  `perC` longtext DEFAULT NULL,
  `perD` longtext DEFAULT NULL,
  `perE` longtext DEFAULT NULL,
  `jawaban` longtext DEFAULT NULL,
  `fileSoal` varchar(255) DEFAULT NULL,
  `fileA` varchar(255) DEFAULT NULL,
  `fileB` varchar(255) DEFAULT NULL,
  `fileC` varchar(255) DEFAULT NULL,
  `fileD` varchar(255) DEFAULT NULL,
  `fileE` varchar(255) DEFAULT NULL,
  `warna` text DEFAULT NULL,
  `max_skor` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `soal`
--

INSERT INTO `soal` (`id_soal`, `id_bank`, `nomor`, `soal`, `jenis`, `pilA`, `pilB`, `pilC`, `pilD`, `pilE`, `perA`, `perB`, `perC`, `perD`, `perE`, `jawaban`, `fileSoal`, `fileA`, `fileB`, `fileC`, `fileD`, `fileE`, `warna`, `max_skor`) VALUES
(1, 1, 1, 'Sampah anorganik lebih lama terurai dibandingkan dengan sampah organik. Waktu dekomposisi popok sekali pakai lebih lama dari plastik, namun kurang dari kulit sintetis. Berapa waktu dekomposisi yang mungkin dari popok sekali pakai?', 1, '100 tahun', '250 tahun', '375 tahun', '475 tahun', '575 tahun', '', '', '', '', '', 'D', 'img_1773577687_9823.jpg', '', '', '', '', '', '', 1),
(2, 1, 2, 'Manakah dari berikut ini yang merupakan satuan dalam Sistem Internasional (SI)? (Pilih lebih dari satu jawaban)', 2, 'Newton', 'Joule', 'Calorie', 'Watt', 'Liter', '', '', '', '', '', 'A,B,D', '', '', '', '', '', '', '', 3),
(3, 1, 3, 'Tentukan pernyataan berikut sebagai Benar (B) atau Salah (S).', 3, 'Fotosintesis hanya terjadi pada tumbuhan yang hidup di air.', 'Oksigen adalah salah satu hasil dari proses fotosintesis.', 'Semua makhluk hidup membutuhkan energi untuk bertahan hidup.', 'Mitokondria dikenal sebagai pusat penghasil energi sel.', 'Karbondioksida diserap oleh akar tumbuhan dari dalam tanah.', '', '', '', '', '', 'S,B,B,B,S', '', '', '', '', '', '', '', 5),
(4, 1, 4, 'Jodohkan yang paling sesuai.', 4, 'Ekonomi Tradisional', 'Ekonomi Pasar', 'Ekonomi Komando', 'Ekonomi Campuran', 'Ekonomi Syariah', 'Semua kegiatan ekonomi diatur oleh pemerintah.', 'Kegiatan ekonomi berdasarkan kebiasaan dan tradisi.', 'Harga ditentukan oleh permintaan dan penawaran.', 'Perpaduan antara mekanisme pasar dan kontrol negara.', 'Berdasarkan prinsip-prinsip Islam dan hukum syariah', 'B,C,A,D,E', '', '', '', '', '', '', '#00BCD4,#F44336,#4CAF50,#FF9800,#0277BD', 5),
(5, 1, 5, 'Sebutkan tiga contoh sikap yang mencerminkan nilai-nilai Pancasila dalam kehidupan sehari-hari!', 5, '', '', '', '', '', '', '', '', '', '', 'gotong royong, menghormati orang tua, tidak memaksakan kehendak.', '', '', '', '', '', '', '', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `mode` varchar(11) NOT NULL,
  `perpus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data untuk tabel `status`
--

INSERT INTO `status` (`id`, `mode`, `perpus`) VALUES
(1, '1', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_face`
--

CREATE TABLE `status_face` (
  `id` int(11) NOT NULL,
  `mode` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data untuk tabel `status_face`
--

INSERT INTO `status_face` (`id`, `mode`) VALUES
(1, '3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tanggal_rapor`
--

CREATE TABLE `tanggal_rapor` (
  `id` int(11) NOT NULL,
  `tanggal` varchar(50) NOT NULL,
  `semester` int(11) DEFAULT NULL,
  `tapel` varchar(50) DEFAULT NULL,
  `ket` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tanggal_rapor`
--

INSERT INTO `tanggal_rapor` (`id`, `tanggal`, `semester`, `tapel`, `ket`) VALUES
(1, '12 Agustus 2025', 1, '2025/2026', 'PAS');

-- --------------------------------------------------------

--
-- Struktur dari tabel `teguran`
--

CREATE TABLE `teguran` (
  `id_teguran` int(11) NOT NULL,
  `min_poin` int(11) DEFAULT NULL,
  `max_poin` int(11) DEFAULT NULL,
  `jenis_teguran` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `teguran`
--

INSERT INTO `teguran` (`id_teguran`, `min_poin`, `max_poin`, `jenis_teguran`, `keterangan`) VALUES
(1, 5, 10, 'Teguran Lisan', 'Peringatan secara langsung dari guru atau wali kelas, tanpa surat resmi'),
(2, 11, 20, 'Teguran Tertulis', 'Siswa mendapat surat peringatan (SP1) dan dipanggil ke ruang BK'),
(3, 21, 30, 'Peringatan Kedua (SP2)', 'Surat peringatan kedua, disertai panggilan orang tua dan sesi konseling wajib.'),
(4, 31, 40, 'Peringatan Ketiga (SP3)', 'Siswa diawasi lebih ketat, wajib ikut pembinaan khusus (bimbingan karakter, kerja sosial, dll).'),
(5, 41, 50, 'Skorsing', 'Siswa diskors sementara dan wajib mengikuti konseling intensif.'),
(6, 51, 100, 'Drop Out', 'Langkah terakhir jika perilaku tidak menunjukkan perubahan.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `temp_finger`
--

CREATE TABLE `temp_finger` (
  `id` int(11) NOT NULL,
  `idsiswa` varchar(11) DEFAULT NULL,
  `idpeg` varchar(11) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `nowa` varchar(50) DEFAULT NULL,
  `idjari` int(11) DEFAULT NULL,
  `serial` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmpbayar`
--

CREATE TABLE `tmpbayar` (
  `nokartu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmpface`
--

CREATE TABLE `tmpface` (
  `nokartu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmpreg`
--

CREATE TABLE `tmpreg` (
  `nokartu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmpsis`
--

CREATE TABLE `tmpsis` (
  `nokartu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `id_transaksi` varchar(255) DEFAULT NULL,
  `id_siswa` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_harga` varchar(11) NOT NULL,
  `metode` varchar(50) DEFAULT NULL,
  `reff` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `id_transaksi`, `id_siswa`, `tanggal`, `total_harga`, `metode`, `reff`, `status`) VALUES
(1, '690751ac75157', 65, '2025-11-02 12:42:22', '7000', '1', '20251102194222', 1),
(2, '6912e08bbe39d', 83, '2025-11-11 07:06:51', '12500', '2', '20251111140651', 1),
(3, '6912e0b25cc40', 83, '2025-11-11 07:07:30', '12000', '1', '20251111140730', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_kantin`
--

CREATE TABLE `transaksi_kantin` (
  `id_trx` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `idsiswa` int(11) DEFAULT NULL,
  `idpeg` int(11) DEFAULT NULL,
  `idb` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT 1,
  `harga` int(11) DEFAULT 0,
  `total_harga` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `ket` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `trx_bayar`
--

CREATE TABLE `trx_bayar` (
  `id_trx` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `idsiswa` int(11) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `idbayar` int(11) NOT NULL,
  `bayar` int(11) NOT NULL DEFAULT 0,
  `ke` int(11) NOT NULL DEFAULT 1,
  `bukti` varchar(100) NOT NULL,
  `bulan` varchar(50) DEFAULT NULL,
  `tahun` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `id_tugas` int(255) NOT NULL,
  `guru` varchar(11) DEFAULT NULL,
  `kelas` mediumtext DEFAULT NULL,
  `mapel` varchar(255) DEFAULT NULL,
  `judul` varchar(50) DEFAULT NULL,
  `tugas` longtext DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tgl_mulai` datetime NOT NULL,
  `tgl_selesai` datetime NOT NULL,
  `tgl` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ujian`
--

CREATE TABLE `ujian` (
  `id_jadwal` int(11) NOT NULL,
  `tingkat` varchar(50) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `idbank` varchar(11) DEFAULT NULL,
  `soal_agama` varchar(50) DEFAULT NULL,
  `tgl_ujian` datetime DEFAULT NULL,
  `tgl_selesai` datetime NOT NULL,
  `lama_ujian` int(11) NOT NULL DEFAULT 60,
  `sesi` int(11) NOT NULL DEFAULT 1,
  `kkm` int(11) NOT NULL DEFAULT 0,
  `pelanggaran` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `reset` int(11) NOT NULL DEFAULT 0,
  `token` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ujian`
--

INSERT INTO `ujian` (`id_jadwal`, `tingkat`, `jurusan`, `idbank`, `soal_agama`, `tgl_ujian`, `tgl_selesai`, `lama_ujian`, `sesi`, `kkm`, `pelanggaran`, `status`, `reset`, `token`) VALUES
(1, '10', 'UMUM', '1', '', '2026-03-15 19:00:00', '2026-03-24 20:00:00', 90, 1, 0, 10, 1, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `walas` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `nowa` varchar(13) DEFAULT NULL,
  `sts` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nip`, `username`, `password`, `level`, `jabatan`, `walas`, `foto`, `nama`, `nowa`, `sts`) VALUES
(1, NULL, 'admin', '$2y$10$t3L.GQrBJJHa5gPSooBuhOiZYk4yFgJT7TqBvqPI1bU57mJFQOrAG', 'admin', NULL, NULL, NULL, 'Admin Sekolah', NULL, 1),
(12, NULL, 'admin1', '$2y$10$tSgq/mIvP2ENhMLW9zthke6zrLclQPqIE39JJyeU6nKzI5XY.ESqa', 'admin', NULL, NULL, '', 'Lionel Messi, S.Pd. Gr.', NULL, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `waktu`
--

CREATE TABLE `waktu` (
  `id` int(11) NOT NULL,
  `hari` varchar(50) DEFAULT NULL,
  `masuk` varchar(50) DEFAULT NULL,
  `pulang` varchar(50) DEFAULT NULL,
  `alpha` varchar(50) DEFAULT NULL,
  `masuk_eskul` varchar(50) DEFAULT NULL,
  `jam_eskul` varchar(50) DEFAULT NULL,
  `pulang_eskul` varchar(50) DEFAULT NULL,
  `piket` varchar(50) NOT NULL DEFAULT '21:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data untuk tabel `waktu`
--

INSERT INTO `waktu` (`id`, `hari`, `masuk`, `pulang`, `alpha`, `masuk_eskul`, `jam_eskul`, `pulang_eskul`, `piket`) VALUES
(1, 'Mon', '07:00', '19:00', '09:00', '14:00', NULL, '15:00', '21:00'),
(2, 'Tue', '07:00', '19:00', '09:00', '14:00', NULL, '15:00', '21:00'),
(3, 'Wed', '07:00', '17:00', '08:00', NULL, NULL, NULL, '21:00'),
(4, 'Thu', '07:00', '13:00', '09:00', '14:00', NULL, '15:00', '21:00'),
(5, 'Fri', '07:00', '21:00', '09:00', NULL, NULL, NULL, '21:00'),
(6, 'Sat', '07:00', '23:00', '09:00', NULL, NULL, NULL, '21:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `absensi_les`
--
ALTER TABLE `absensi_les`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `absen_daring`
--
ALTER TABLE `absen_daring`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `absen_jjm`
--
ALTER TABLE `absen_jjm`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `absen_rapor`
--
ALTER TABLE `absen_rapor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unik_absen` (`idsiswa`,`tapel`,`semester`,`ket`);

--
-- Indeks untuk tabel `adm_tp`
--
ALTER TABLE `adm_tp`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id_alumni`);

--
-- Indeks untuk tabel `arsip_jawaban`
--
ALTER TABLE `arsip_jawaban`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_soal` (`id_soal`);

--
-- Indeks untuk tabel `banksoal`
--
ALTER TABLE `banksoal`
  ADD PRIMARY KEY (`id_bank`);

--
-- Indeks untuk tabel `bell`
--
ALTER TABLE `bell`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `bell_nada`
--
ALTER TABLE `bell_nada`
  ADD PRIMARY KEY (`idb`);

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indeks untuk tabel `budig`
--
ALTER TABLE `budig`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `bulan`
--
ALTER TABLE `bulan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `catatan_pelanggaran`
--
ALTER TABLE `catatan_pelanggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `catatan_rapor`
--
ALTER TABLE `catatan_rapor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unik_absen` (`idsiswa`,`tapel`,`semester`,`ket`);

--
-- Indeks untuk tabel `cp_elemen`
--
ALTER TABLE `cp_elemen`
  ADD PRIMARY KEY (`id_elemen`);

--
-- Indeks untuk tabel `datareg`
--
ALTER TABLE `datareg`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `deskrip_kebiasaan`
--
ALTER TABLE `deskrip_kebiasaan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `detail_trx`
--
ALTER TABLE `detail_trx`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indeks untuk tabel `jadwal_mengajar`
--
ALTER TABLE `jadwal_mengajar`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indeks untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_soal` (`id_soal`);

--
-- Indeks untuk tabel `jawaban_tugas`
--
ALTER TABLE `jawaban_tugas`
  ADD PRIMARY KEY (`id_jawaban`);

--
-- Indeks untuk tabel `jurnal`
--
ALTER TABLE `jurnal`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori_pelanggaran`
--
ALTER TABLE `kategori_pelanggaran`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `kebiasaan_harian`
--
ALTER TABLE `kebiasaan_harian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `kode`
--
ALTER TABLE `kode`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kokurikuler`
--
ALTER TABLE `kokurikuler`
  ADD PRIMARY KEY (`idk`);

--
-- Indeks untuk tabel `konseling`
--
ALTER TABLE `konseling`
  ADD PRIMARY KEY (`id_konseling`);

--
-- Indeks untuk tabel `lampu`
--
ALTER TABLE `lampu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `log_ujian`
--
ALTER TABLE `log_ujian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mapel_rapor`
--
ALTER TABLE `mapel_rapor`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`idm`);

--
-- Indeks untuk tabel `menjodohkan`
--
ALTER TABLE `menjodohkan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `m_bayar`
--
ALTER TABLE `m_bayar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `m_eskul`
--
ALTER TABLE `m_eskul`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `m_hari`
--
ALTER TABLE `m_hari`
  ADD PRIMARY KEY (`idh`);

--
-- Indeks untuk tabel `m_kelas`
--
ALTER TABLE `m_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `m_pesan`
--
ALTER TABLE `m_pesan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indeks untuk tabel `nilai_capaian`
--
ALTER TABLE `nilai_capaian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nilai_harian`
--
ALTER TABLE `nilai_harian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nilai_rapor`
--
ALTER TABLE `nilai_rapor`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nilai_skl`
--
ALTER TABLE `nilai_skl`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pay_lain`
--
ALTER TABLE `pay_lain`
  ADD PRIMARY KEY (`id_lain`);

--
-- Indeks untuk tabel `pdb`
--
ALTER TABLE `pdb`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pelanggaran`
--
ALTER TABLE `pelanggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id_aplikasi`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pesan_terkirim`
--
ALTER TABLE `pesan_terkirim`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `peskul`
--
ALTER TABLE `peskul`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pkl_aspek`
--
ALTER TABLE `pkl_aspek`
  ADD PRIMARY KEY (`id_aspek`);

--
-- Indeks untuk tabel `pkl_dudi`
--
ALTER TABLE `pkl_dudi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pkl_jurnal`
--
ALTER TABLE `pkl_jurnal`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pkl_kegiatan`
--
ALTER TABLE `pkl_kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pkl_kompetensi`
--
ALTER TABLE `pkl_kompetensi`
  ADD PRIMARY KEY (`id_kompetensi`);

--
-- Indeks untuk tabel `pkl_nilai`
--
ALTER TABLE `pkl_nilai`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indeks untuk tabel `pkl_presensi`
--
ALTER TABLE `pkl_presensi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pkl_siswa`
--
ALTER TABLE `pkl_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `fk_produk_kategori` (`kategori`);

--
-- Indeks untuk tabel `produk_kategori`
--
ALTER TABLE `produk_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `saldo`
--
ALTER TABLE `saldo`
  ADD PRIMARY KEY (`id_saldo`);

--
-- Indeks untuk tabel `sapras`
--
ALTER TABLE `sapras`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sapras_kate`
--
ALTER TABLE `sapras_kate`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sapras_ruangan`
--
ALTER TABLE `sapras_ruangan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sinkron`
--
ALTER TABLE `sinkron`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indeks untuk tabel `skkb`
--
ALTER TABLE `skkb`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `skl`
--
ALTER TABLE `skl`
  ADD PRIMARY KEY (`id_skl`);

--
-- Indeks untuk tabel `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id_soal`);

--
-- Indeks untuk tabel `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `status_face`
--
ALTER TABLE `status_face`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tanggal_rapor`
--
ALTER TABLE `tanggal_rapor`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `teguran`
--
ALTER TABLE `teguran`
  ADD PRIMARY KEY (`id_teguran`);

--
-- Indeks untuk tabel `temp_finger`
--
ALTER TABLE `temp_finger`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tmpbayar`
--
ALTER TABLE `tmpbayar`
  ADD PRIMARY KEY (`nokartu`);

--
-- Indeks untuk tabel `tmpface`
--
ALTER TABLE `tmpface`
  ADD PRIMARY KEY (`nokartu`);

--
-- Indeks untuk tabel `tmpreg`
--
ALTER TABLE `tmpreg`
  ADD PRIMARY KEY (`nokartu`);

--
-- Indeks untuk tabel `tmpsis`
--
ALTER TABLE `tmpsis`
  ADD PRIMARY KEY (`nokartu`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `transaksi_kantin`
--
ALTER TABLE `transaksi_kantin`
  ADD PRIMARY KEY (`id_trx`);

--
-- Indeks untuk tabel `trx_bayar`
--
ALTER TABLE `trx_bayar`
  ADD PRIMARY KEY (`id_trx`);

--
-- Indeks untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id_tugas`);

--
-- Indeks untuk tabel `ujian`
--
ALTER TABLE `ujian`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `waktu`
--
ALTER TABLE `waktu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `absensi_les`
--
ALTER TABLE `absensi_les`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `absen_daring`
--
ALTER TABLE `absen_daring`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `absen_jjm`
--
ALTER TABLE `absen_jjm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `absen_rapor`
--
ALTER TABLE `absen_rapor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `adm_tp`
--
ALTER TABLE `adm_tp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id_alumni` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `arsip_jawaban`
--
ALTER TABLE `arsip_jawaban`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `banksoal`
--
ALTER TABLE `banksoal`
  MODIFY `id_bank` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `bell`
--
ALTER TABLE `bell`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `bell_nada`
--
ALTER TABLE `bell_nada`
  MODIFY `idb` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `budig`
--
ALTER TABLE `budig`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `bulan`
--
ALTER TABLE `bulan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `catatan_pelanggaran`
--
ALTER TABLE `catatan_pelanggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `catatan_rapor`
--
ALTER TABLE `catatan_rapor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `cp_elemen`
--
ALTER TABLE `cp_elemen`
  MODIFY `id_elemen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `datareg`
--
ALTER TABLE `datareg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `deskrip_kebiasaan`
--
ALTER TABLE `deskrip_kebiasaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `detail_trx`
--
ALTER TABLE `detail_trx`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jadwal_mengajar`
--
ALTER TABLE `jadwal_mengajar`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jawaban_tugas`
--
ALTER TABLE `jawaban_tugas`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jurnal`
--
ALTER TABLE `jurnal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategori_pelanggaran`
--
ALTER TABLE `kategori_pelanggaran`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `kebiasaan_harian`
--
ALTER TABLE `kebiasaan_harian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `kode`
--
ALTER TABLE `kode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `kokurikuler`
--
ALTER TABLE `kokurikuler`
  MODIFY `idk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `konseling`
--
ALTER TABLE `konseling`
  MODIFY `id_konseling` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lampu`
--
ALTER TABLE `lampu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `log_ujian`
--
ALTER TABLE `log_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `mapel_rapor`
--
ALTER TABLE `mapel_rapor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `materi`
--
ALTER TABLE `materi`
  MODIFY `idm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `menjodohkan`
--
ALTER TABLE `menjodohkan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `m_bayar`
--
ALTER TABLE `m_bayar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `m_eskul`
--
ALTER TABLE `m_eskul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `m_hari`
--
ALTER TABLE `m_hari`
  MODIFY `idh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `m_kelas`
--
ALTER TABLE `m_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `m_pesan`
--
ALTER TABLE `m_pesan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `nilai_capaian`
--
ALTER TABLE `nilai_capaian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `nilai_harian`
--
ALTER TABLE `nilai_harian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `nilai_rapor`
--
ALTER TABLE `nilai_rapor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT untuk tabel `nilai_skl`
--
ALTER TABLE `nilai_skl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pay_lain`
--
ALTER TABLE `pay_lain`
  MODIFY `id_lain` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pdb`
--
ALTER TABLE `pdb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pelanggaran`
--
ALTER TABLE `pelanggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id_aplikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pesan_terkirim`
--
ALTER TABLE `pesan_terkirim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `peskul`
--
ALTER TABLE `peskul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pkl_aspek`
--
ALTER TABLE `pkl_aspek`
  MODIFY `id_aspek` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pkl_dudi`
--
ALTER TABLE `pkl_dudi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pkl_jurnal`
--
ALTER TABLE `pkl_jurnal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pkl_kegiatan`
--
ALTER TABLE `pkl_kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pkl_kompetensi`
--
ALTER TABLE `pkl_kompetensi`
  MODIFY `id_kompetensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `pkl_nilai`
--
ALTER TABLE `pkl_nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pkl_presensi`
--
ALTER TABLE `pkl_presensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pkl_siswa`
--
ALTER TABLE `pkl_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `produk_kategori`
--
ALTER TABLE `produk_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `saldo`
--
ALTER TABLE `saldo`
  MODIFY `id_saldo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sapras`
--
ALTER TABLE `sapras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `sapras_kate`
--
ALTER TABLE `sapras_kate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `sapras_ruangan`
--
ALTER TABLE `sapras_ruangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `sinkron`
--
ALTER TABLE `sinkron`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT untuk tabel `skkb`
--
ALTER TABLE `skkb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `skl`
--
ALTER TABLE `skl`
  MODIFY `id_skl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `soal`
--
ALTER TABLE `soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `status_face`
--
ALTER TABLE `status_face`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tanggal_rapor`
--
ALTER TABLE `tanggal_rapor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `teguran`
--
ALTER TABLE `teguran`
  MODIFY `id_teguran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `temp_finger`
--
ALTER TABLE `temp_finger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `transaksi_kantin`
--
ALTER TABLE `transaksi_kantin`
  MODIFY `id_trx` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `trx_bayar`
--
ALTER TABLE `trx_bayar`
  MODIFY `id_trx` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id_tugas` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ujian`
--
ALTER TABLE `ujian`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `waktu`
--
ALTER TABLE `waktu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  ADD CONSTRAINT `jawaban_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`),
  ADD CONSTRAINT `jawaban_ibfk_2` FOREIGN KEY (`id_soal`) REFERENCES `soal` (`id_soal`);

--
-- Ketidakleluasaan untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pelanggaran`
--
ALTER TABLE `pelanggaran`
  ADD CONSTRAINT `pelanggaran_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_pelanggaran` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
