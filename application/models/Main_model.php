<?php class Main_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    //  Mengambil Data Dosen dengan NIP
    function getDosenByNIP($arrayNipDosen)
    {
        $this->db->select('nip, nama, pendidikan_terakhir, foto, b.program_studi');
        $this->db->from('dosen a');
        $this->db->join('program_studi b', 'a.program_studi = b.kd_program_studi');
        $this->db->where('nip', "$arrayNipDosen");
        $query = $this->db->get();
        return $query;
    }

    // Hitung Banyak Data Skripsi
    function banyakData()
    {
        return $this->db->count_all_results('tugas_akhir');
    }

    // Mengambil Data Skripsi dengan NIP
    function getSkripsiByDosen($nip)
    {
        $this->db->where('dp_satu', "$nip");
        $this->db->or_where('dp_dua', "$nip");
        $query = $this->db->get('tugas_akhir');
        return $query;
    }

    // Fungsi Pencarian
    function searchtitle($keyword, $toLowerKeyword, $id_session)
    {
        // Inisiasi Time Ke Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');
        // Input Data ke tabel Pencarian
        $data = array(
            'id' => bin2hex(random_bytes(5)),
            'keyword' => $toLowerKeyword,
            'waktu' => date('Y-m-d H:i:s')
        );
        // Insert data ke tabel Pencarian
        $this->db->insert('pencarian', $data);

        // WordMark
        $wordMark = '/[{}()""!,.:?]/';

        // Mengambil data Stopword
        $queryStopword = $this->db->get('stopword');
        foreach ($queryStopword->result_array() as $row) {
            $arrayStopwords[] = '/\b' . $row['stopword'] . '\b/';
        }
        $stopWord = $arrayStopwords;

        // Mengambil Data Kata Imbuhan & Kata Dasar
        $this->db->select('kata_imbuhan, kata_dasar');
        $this->db->from('kata_imbuhan');
        $queryKataImbuhan = $this->db->get();

        foreach ($queryKataImbuhan->result_array() as $row) {
            $kataImbuhan[] = $row['kata_imbuhan'];
            $kataDasar[] = $row['kata_dasar'];
        }
        $search = $kataImbuhan;
        $replace = $kataDasar;

        // Nomor Dokumen
        $num_doc = 1;

        // Mengambil Data Skripsi dari tabel Tugas_akhir
        $this->db->select('judul_skripsi, abstrak, no_reg, dp_satu, dp_dua');
        $this->db->from('tugas_akhir');
        $querySkripsi = $this->db->get();
        foreach ($querySkripsi->result_array() as $row) {
            $namaDokumen = "<b>Dokumen " . $num_doc++ . "</b>";
            $idDokumen = $row['no_reg'];

            // echo $namaDokumen . "<br>";
            // echo "<b>DOKUMEN ASLI</b><br>";

            $judulskripsi = $row['judul_skripsi'];
            $abstrakskripsi = $row['abstrak'];
            $dosen1 = $row['dp_satu'];
            $dosen2 = $row['dp_dua'];

            // echo $judulskripsi . "<br>";
            // echo $abstrakskripsi . "<br>";

            $judulKecil = strtolower($judulskripsi);
            $abstrakKecil = strtolower($abstrakskripsi);
            $judulRemove = preg_replace($wordMark, "", $judulKecil);
            $abstrakRemove = preg_replace($wordMark, "", $abstrakKecil);
            $mergeData = $judulRemove . " " . $abstrakRemove;
            $removeKataImbuhan = str_replace($search, $replace, $mergeData);
            $s = array_count_values(explode(" ", $removeKataImbuhan));
            $clear = preg_replace($stopWord, array(''), $removeKataImbuhan);

            // echo "<br>";
            // echo "<b>Bersih</b><br>";
            // echo $clear . "<br><br>";

            $sum = 0;
            $pangkat_sum = 0;
            $cek = 0;
            $cek_after = 0;

            // echo "<br><br>";

            foreach ($s as $kata => $banyakKata) {
                if ($kata != "") {

                    // Ambil data Kata dan nilainya dari DB
                    $this->db->where('term', "$kata");
                    $query = $this->db->get('index');
                    if ($query->num_rows() > 0) {
                        foreach ($query->result_array() as $row) {
                        }
                        $W_Dokumen = $row['idf'] * $banyakKata;
                        // echo $kata . " " . round($row['idf'], 3) . " " . $banyakKata . " = " . round($W_Dokumen, 3)  . "<br>";

                        // Bobot sebelum dipangkatkan
                        $sum += $W_Dokumen;
                        // Bobot setelah dipangkatkan
                        $pangkat_sum += pow($W_Dokumen, 2);
                    }
                    // Untuk REGEX PREG_REPLACE
                    $regex_ToLowerKeyword = '/\b' . $toLowerKeyword . '\b/';
                    $regex_kata = '/\b' . $kata . '\b/';

                    if (preg_match($regex_ToLowerKeyword, $regex_kata)) {
                        $this->db->select('term, idf');
                        $this->db->where('term', $regex_kata);
                        $query = $this->db->get('index');

                        if ($query->num_rows() > 0) {
                            foreach ($query->result_array() as $row) {
                            }
                            $cek += $row['idf'];
                            $cek_after += pow($row['idf'], 2);
                        }
                    }
                    $asf = array($namaDokumen => $cek);
                }
            }
            // print_r($asf);

            // echo "<br><br>";
            // SUM sebelum dipangkatkan
            // echo "<b>Total Bobot Dokumen = " . round($sum, 3) . "</b>";
            // echo "<br>";

            // SUM setelah dipangkatkan
            $sum_sqrt = sqrt($pangkat_sum);

            // echo "<b>Panjang Bobot Dokumen  = " . round($sum_sqrt, 3)  . "</b>";
            // echo "<br>";
            // Nilai Kata Kunci sebelum dipangkat
            // echo "<b>Nilai Kata Kunci = $cek</b>";
            // echo "<br>";
            // // Nilai kata kunci setelah dipangkatkan
            // echo "<b>Nilai Kata Kunci Sqrt = " . sqrt($cek_after) . "</b><br>";

            $arrayToLowerKeyword = explode(" ", $toLowerKeyword);
            $hitungkoma_awal = 0;
            $hargaKataKunci = 0;

            // Ubah Kata Kunci ke array
            foreach ($arrayToLowerKeyword as $row) {
                $this->db->select('term, idf');
                $this->db->from('index');
                $this->db->where('term', $row);
                $query = $this->db->get();

                // Cek apakah array diatas ada dalam DB
                if ($query->num_rows() > 0) {
                    foreach ($query->result_array() as $row) {
                        $idf = $row['idf'];
                        $kata = $row['term'];
                    }
                    // $hitungkoma_akhir adalah berapa banyak kata (kata kunci) di dalam array abstrak (per judul) * $idf
                    $hitungkoma_akhir = substr_count($removeKataImbuhan, $kata) * pow($idf, 2);

                    // echo "<br>";
                    // echo substr_count($removeKataImbuhan, $kata) . "<br><br>";
                    // echo pow($idf, 2) . "<br><br>";
                    // echo "<b>" . $hitungkoma_akhir . "</b><br>";
                    // echo "<b>" . $kata . " " . round($idf, 3) . "</b><br>";

                    $p = round($idf, 3);
                    $pangkatKataKunci = pow($idf, 2);

                    // echo $pangkatKataKunci . "<br>";

                    // Jika $kata ada dalam DB
                    // echo "Kata <b>$kata = " . round($pangkatKataKunci, 3) . "</b><br>";
                } else {
                    // Jika $kata tidak ada dalam DB
                    $hitungkoma_akhir = 0;
                    $pangkatKataKunci = 0;
                    // echo "<b>Kata $row TIDAK ADA</b>";
                }
                $hitungkoma_awal += $hitungkoma_akhir;
                $hargaKataKunci += $pangkatKataKunci;
            }
            // echo "<br>";
            // echo "<b>Hasil total = $hitungkoma_awal </b><br>";
            // echo "Panjang Bobot Kata Kunci = " . round(sqrt($hargaKataKunci), 3)  . "</b><br>";
            $kali = sqrt($hargaKataKunci) * $sum_sqrt;

            if ($kali == '0') {
                $hasilAkhir = 0;

                // echo "<b>FIX NILAI AKHIR = $hasilAkhir</b>";
                // echo "<br><br>";
            } else {
                $akar_hitungkoma_awal = sqrt($hitungkoma_awal);
                $end = round(sqrt($hargaKataKunci), 3) * round($sum_sqrt, 3);
                $mm = sqrt($hargaKataKunci) * $sum_sqrt;
                $digit_3 = round($mm, 3);

                // echo "<b> COSIM = " . round(sqrt($hargaKataKunci), 3) . " " . round($sum_sqrt, 3)  . " = " . $digit_3 . "</b><br>";

                $hasilAkhir = $hitungkoma_awal / $digit_3;
                // echo "<b>FIX NILAI AKHIRRR = $hasilAkhir </b>";
                // echo "<br><br>";
            }
            $namaDokumenArray = array(
                'idDokumen' => $idDokumen,
                'hasil_akhir' => $hasilAkhir,
                'dosen_satu' => $dosen1,
                'dosen_dua' => $dosen2,
            );
            $x[] = $namaDokumenArray;
        }
        // echo "<br><br>";
        echo "<b>Hasil Pencarian</b>";
        // echo "<br><br>";

        $ccc = array_column($x, 'hasil_akhir', 'idDokumen');

        // MENGAMBIL 2 LIMIT
        arsort($ccc);
        // print_r($ccc);

        $val = array_sum($ccc);

        // echo "<br><br>";
        // echo "<br><br>";

        // CEK APAKAH HASIL PENCARIAN == 0 (TIDAK KETEMU)
        if ($val == '0') {
            return FALSE;
        } else {
            foreach ($ccc as $DocId => $value) {
                if ($value != 0) {
                    $this->db->select('no_reg, judul_skripsi, abstrak, dp_satu, dp_dua');
                    $this->db->from('tugas_akhir');
                    $this->db->where('no_reg', "$DocId");
                    $query = $this->db->get();

                    if ($query->num_rows() > 0) {
                        foreach ($query->result_array() as $row) {
                            $judul = $row['judul_skripsi'];
                            $dosen_satu = $row['dp_satu'];
                            $dosen_dua = $row['dp_dua'];
                        }

                        // echo $judul . "<br>";
                        // echo $value . "<br>";
                        // echo $dosen_satu . "<br>";
                        // echo $dosen_dua . "<br>";
                    }
                    $vv[] = $dosen_satu;
                    $ww[] = $dosen_dua;
                    $xx[] = $judul;
                    $zz[] = $value;

                    $bb = array_merge($vv, $ww);

                    $array[] = array(
                        'judul' => $judul,
                        'nilai' => $value,
                        'dosen_satu' => $dosen_satu,
                        'dosen_dua' => $dosen_dua,
                    );
                    $hasilDosen = array_count_values($bb);
                    arsort($hasilDosen);
                }
            }
            foreach ($array as $key => $value) {
                $param = array(
                    'id' => bin2hex(random_bytes(10)),
                    'id_session' => "$id_session",
                    'keyword' => $toLowerKeyword,
                    'judul' => $value['judul'],
                    'dosen_1' => $value['dosen_satu'],
                    'dosen_2' => $value['dosen_dua'],
                    'skor' => $value['nilai']
                );
                $this->db->insert('hasil_pencarian', $param);
            }
            // return array
            return $hasilDosen;
        }
        // echo "<br><br>";
    }
    function get_result_judul($id_session)
    {
        $this->db->select('id, id_session, keyword, judul, b.nama AS nama_dosen_1, c.nama AS nama_dosen_2, skor');
        $this->db->from('hasil_pencarian a');
        $this->db->join('dosen b', 'a.dosen_1 = b.nip');
        $this->db->join('dosen c', 'a.dosen_2 = c.nip');
        $this->db->where('id_session', $id_session);
        $this->db->order_by('skor', 'DESC');
        $query = $this->db->get();
        return $query;
    }
    function GetResultProfile($id_session)
    {
        $this->db->select('b.foto, b.nama, b.nip, b.program_studi AS dosen_program_studi, skor, skor_persen, c.program_studi');
        $this->db->from('result_profile a');
        $this->db->join('dosen b', 'a.nip_searching = b.nip');
        $this->db->join('program_studi c', 'b.program_studi = c.kd_program_studi');
        $this->db->where('id_session_searching', $id_session);
        $query = $this->db->get();
        return $query;
    }
    function GetJudulByNip($nip)
    {
        $this->db->select('a.nip, a.nama, a.foto, b.program_studi AS program_studi');
        $this->db->from('dosen a');
        $this->db->join('program_studi b', 'a.program_studi = b.kd_program_studi');
        $this->db->where('nip', $nip);
        $query = $this->db->get();
        return $query;
    }
    function GetSkripsiByNip($nip)
    {
        $query = "SELECT judul_skripsi FROM tugas_akhir WHERE dp_satu = '$nip' OR dp_dua = '$nip'";
        $exe_query = $this->db->query($query);
        return $exe_query;
    }
}
