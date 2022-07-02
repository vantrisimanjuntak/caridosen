<?php class Control_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function login($username, $password, $timelogin, $ip_address)
    {

        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $queryLogin = $this->db->get('superuser');
        if ($queryLogin->num_rows() > 0) {
            foreach ($queryLogin->result_array() as $row) {
                $sess = array(
                    'username' => $row['username'],
                    'password' => $row['password'],
                    'alias' => $row['alias']
                );
                $this->session->set_userdata($sess);
            }

            $data = array(
                'id' => bin2hex(random_bytes(4)),
                'login_id' => $row['id'],
                'time_login' => $timelogin,
                'ip_address' => $ip_address
            );
            $this->db->insert('login_time', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // For Dosen
    function getAllDosen()
    {
        $this->db->select('*');
        $this->db->from('dosen');
        $this->db->join('program_studi', 'program_studi.kd_program_studi = dosen.program_studi');
        $this->db->join('pendidikan_terakhir', 'pendidikan_terakhir.id = dosen.pendidikan_terakhir');
        $this->db->order_by('nama', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    function checknip($nip)
    {
        $this->db->select('nip');
        $this->db->from('dosen');
        $this->db->where('nip', $nip);
        $queryCheckNIP = $this->db->get();

        if ($queryCheckNIP->num_rows() > 0) {
            echo "Data sudah ada ";
            echo
            '<script>
                $("#nama, #program_studi, #pendidikan_terakhir, #foto, #tambah").prop("disabled", true);
                </script>';
        } else {
            echo '<i class="fa fa-check" aria-hidden="true" style="color:yellow"></i>';
            echo
            '<script>$("#nama, #program_studi, #pendidikan_terakhir, #foto, #tambah").prop("disabled", false);</script>';
        }
    }
    function addLecture($nip, $nama, $prodi, $pendidikan_terakhir)
    {
        $data = array(
            'nip' => (string) $nip,
            'nama' => $nama,
            'program_studi' => $prodi,
            'pendidikan_terakhir' => $pendidikan_terakhir,
            'foto' => $this->uploadImageNewDosen()
        );
        if ($data) {
            $this->db->insert('dosen', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function editLecture($nip, $nama, $prodi, $pendidikan_terakhir)
    {
        $this->db->select('nip, foto');
        $this->db->from('dosen');
        $this->db->where('nip', $nip);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $foto = $row['foto'];
            }
        }


        $data = array(
            'nama' => $nama,
            'program_studi' => $prodi,
            'pendidikan_terakhir' => $pendidikan_terakhir,
            'foto' => $this->updateImageNewDosen($nip),
        );
        if ($data) {
            unlink("./assets/images/dosen_profile/" . $foto);
            $this->db->update('dosen', $data, array('nip' => $nip));
            return TRUE;
        } else {
            return FALSE;
        }
    }
    function deleteLecture($nip)
    {
        $this->db->select('nip, foto');
        $this->db->from('dosen');
        $this->db->where('nip', $nip);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $foto = $row['foto'];
            }

            $this->db->delete('dosen', array('nip' => $nip));
            unlink("./assets/images/dosen_profile/" . $foto);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    function getAllProdi()
    {
        return $this->db->get('program_studi')->result_array();
    }
    function pendidikanTerakhir()
    {
        return $this->db->get('pendidikan_terakhir')->result_array();
    }
    public function uploadImageNewDosen()
    {
        $config['upload_path'] = './assets/images/dosen_profile/';
        $config['allowed_types'] = 'png|jpeg|jpg|gif';
        $config['max_size'] = '2048';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['file_name'] = bin2hex(random_bytes(7));

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            return $this->upload->data('file_name');
        }
    }
    public function updateImageNewDosen()
    {
        $config['upload_path'] = './assets/images/dosen_profile/';
        $config['allowed_types'] = 'png|jpeg|jpg|gif';
        $config['max_size'] = '2048';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['overwrite'] = TRUE;
        $config['file_name'] = bin2hex(random_bytes(7));

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('foto')) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            return $this->upload->data('file_name');
        }
    }

    // For Skripsi
    function getAllSkripsi()
    {
        $this->db->select('a.no_reg, a.mahasiswa, a.judul_skripsi, a.abstrak, d.program_studi AS prodi, b.nama AS dp_satu, c.nama AS dp_dua');
        $this->db->from('tugas_akhir a');
        $this->db->join('dosen b', 'a.dp_satu = b.nip');
        $this->db->join('dosen c', 'a.dp_dua = c.nip');
        $this->db->join('program_studi d', 'a.ta_program_studi = d.kd_program_studi');
        // $this->db->order_by('nama', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
        // return $this->db->get('tugas_akhir')->result_array();
    }
    function submitSkripsi($no_reg, $nim, $judulskripsi, $abstrak, $dp1, $dp2, $mergeData, $program_studi)
    {
        $data = array(
            'no_reg' => "$no_reg",
            'mahasiswa' => $nim,
            'judul_skripsi' => $judulskripsi,
            'abstrak' => $abstrak,
            'dp_satu' => $dp1,
            'dp_dua' => $dp2,
            'ta_program_studi' => $program_studi
        );

        $this->db->insert('tugas_akhir', $data);


        // Banyak Data Skripsi
        // $getDataSkripsi = $this->db->get('tugas_akhir');
        $totalSkripsi = $this->db->count_all_results('tugas_akhir');

        // Get Kata Imbuhan
        $this->db->select('kata_imbuhan, kata_dasar');
        $this->db->from('kata_imbuhan');
        $queryKataImbuhan = $this->db->get();
        foreach ($queryKataImbuhan->result_array() as $row) {
            $kataImbuhan[] = $row['kata_imbuhan'];
            $kataDasar[] = $row['kata_dasar'];
        }
        $search = $kataImbuhan;
        $replace = $kataDasar;

        $removeKataImbuhan = str_replace($search, $replace, $mergeData);

        // Mengubah ABSTRAK menjadi array
        $arrayAbstrak = array_unique(explode(" ", $removeKataImbuhan));
        foreach ($arrayAbstrak as $kata) {
            // Check if KATA is not empty
            if ($kata != "") {
                $this->db->where('term', $kata);
                $cekKataKata = $this->db->get('index');
                // Cek if KATA is available
                if ($cekKataKata->num_rows() > 0) {
                    foreach ($cekKataKata->result_array() as $row) {
                        $id = $row['id'];
                        $katakata = $row['term'];
                        $totalDokumen = $row['total_dokumen'];
                    }
                    $totalDokumen++;

                    $this->db->set('total_dokumen', $totalDokumen);
                    $this->db->where('term', $katakata);
                    $this->db->update('index');
                } else {
                    // If KATA is unavailable
                    $IdfBaru = log10($totalSkripsi / 1);
                    $data = array(
                        'term' => "$kata",
                        'no_doc' => $no_reg,
                        'total_dokumen' => 1,
                        'idf' => $IdfBaru,
                    );
                    $this->db->insert('index', $data);
                }
            }
        }
        // UPDATE IDF
        $queryTableIndex = $this->db->get('index')->result_array();
        foreach ($queryTableIndex as $row) {
            $idf = log10($totalSkripsi / $row['total_dokumen']);
            $this->db->set('idf', $idf);
            $this->db->where('term', $row['term']);
            $this->db->update('index');
        }
        return TRUE;
    }
    function checknim($nim)
    {
        // CHECK IF MAHASISWA IS AVAILABLE
        $this->db->select('nim');
        $this->db->from('mahasiswa');
        $this->db->where('nim', $nim);
        $queryMahasiswa = $this->db->get();

        // check if the MAHASISWA has submitted the SKRIPSI
        $this->db->select('mahasiswa');
        $this->db->from('tugas_akhir');
        $this->db->where('mahasiswa', $nim);
        $querySubmit = $this->db->get();

        // JIKA MAHASISWA ADA DAN SKRIPSI BELUM DIINPUT
        if ($queryMahasiswa->num_rows() > 0 && $querySubmit->num_rows() == null) {
            echo '<i class="fa fa-check" aria-hidden="true" style="color:#5eaaa8"></i>';
            echo '<script>
                $("#judulskripsi, #abstrak, #dp_satu, #dp_dua, #program_studi, #btnSubmit").removeAttr("disabled", true);
                    </script>';
        }
        // JIKA MAHASISWA ADA DAN SKRIPSI SUDAH DIINPUT 
        else if ($queryMahasiswa->num_rows() > 0 && $querySubmit->num_rows() > 0) {
            echo "SKRIPSI SUDAH DIINPUT";
            echo '<script>
                $("#judulskripsi, #abstrak, #dp_satu, #dp_dua, #program_studi #btnSubmit").prop("disabled", true);
                    </script>';
        }
        // JIKA MAHASISWA TIDAK ADA 
        else {
            echo '<i class="fa fa-times" aria-hidden="true">&nbsp;NIM TIDAK ADA</i>';
            echo '<script>
                $("#judulskripsi, #abstrak, #dp_satu, #dp_dua, #program_studi #btnSubmit").prop("disabled", true);
                    </script>';
        }
    }

    function details_skripsi_prodi()
    {
    }

    // For Mahasiswa
    function getAllMahasiswa()
    {
        $this->db->select('*');
        $this->db->from('mahasiswa');
        $this->db->join('program_studi', 'program_studi.kd_program_studi = mahasiswa.program_studi');
        $this->db->order_by('nama', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    function checkNIMBeforeAdd($nim)
    {
        $this->db->select('nim');
        $this->db->from('mahasiswa');
        $this->db->where('nim', $nim);
        $queryGetMahasiswa = $this->db->get();

        if ($queryGetMahasiswa->num_rows() > 0) {
            echo 'Data sudah ada';
            echo '<script>
            $("#nama, #program_studi, #tambah").prop("disabled", true);
                </script>';
        } else {
            echo '<i class="fa fa-check" aria-hidden="true" style="color:yellow"></i>';
            echo '<script>
                $("#nim_mhs, #nama, #program_studi, #tambah").removeAttr("disabled", true);
                    </script>';
        }
    }
    function addMahasiswa($nim, $nama, $program_studi)
    {
        $data = array(
            'nim' => $nim,
            'nama' => $nama,
            'program_studi' => $program_studi
        );
        if ($data) {
            $this->db->insert('mahasiswa', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    function editMahasiswa($nama, $program_studi, $nim)
    {
        $data = array(
            'nama' => $nama,
            'program_studi' => $program_studi,
        );
        if ($data) {
            $this->db->update('mahasiswa', $data, array('nim' => $nim));
            return TRUE;
        } else {
            return FALSE;
        }
    }
    function deleteMahasiswa($nim)
    {
        $this->db->where('nim', $nim);
        $query = $this->db->delete('mahasiswa');
        return TRUE;
    }

    // For Imbuhan
    function getAllImbuhan()
    {
        $queryGetAllImbuhan = $this->db->get('kata_imbuhan')->result_array();
        return $queryGetAllImbuhan;
    }

    function addImbuhan($kata_imbuhan, $kata_dasar)
    {
        $this->db->select('kata_imbuhan, kata_dasar');
        $this->db->from('kata_imbuhan');
        $this->db->where('kata_imbuhan', $kata_imbuhan);
        $this->db->where('kata_dasar', $kata_dasar);
        $queryImbuhan = $this->db->get();

        if ($queryImbuhan->num_rows() > 0) {
            return FALSE;
        } else {
            $data = array(
                'id' => bin2hex(random_bytes(2)),
                'kata_imbuhan' => $kata_imbuhan,
                'kata_dasar' => $kata_dasar
            );
            $this->db->insert('kata_imbuhan', $data);
            return TRUE;
        }
    }
    function deleteImbuhan($id)
    {
        $this->db->where('id', $id);
        $queryGetImbuhan = $this->db->get('kata_imbuhan');
        if ($queryGetImbuhan->num_rows() > 0) {
            $this->db->where('id', $id);
            $this->db->delete('kata_imbuhan');
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // For Stopwords
    function getAllStopword()
    {
        return $this->db->get('stopword');
    }
    function addStopword($stopword)
    {
        $this->db->where('stopword', $stopword);
        $query = $this->db->get('stopword');

        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            $data = array(
                'id' => bin2hex(random_bytes(3)),
                'stopword' => $stopword
            );
            $this->db->insert('stopword', $data);
            return TRUE;
        }
    }
    function deleteStopword($id)
    {
        $this->db->where('id', $id);
        $queryGetStopwords = $this->db->get('stopword');
        if ($queryGetStopwords->num_rows() > 0) {
            $this->db->where('id', $id);
            $this->db->delete('stopword');
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
