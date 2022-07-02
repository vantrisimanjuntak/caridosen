<?php class Cari extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Main_model');
    }

    function index()
    {
        $data['title'] = 'Pencarian';
        $this->load->view('home_view', $data);
    }
    function searchtitle()
    {
        $rand = bin2hex(random_bytes(20));
        $this->session->set_userdata('id_session', $rand);
        $id_session = $this->session->userdata('id_session');

        $banyakSkripsi = $this->Main_model->banyakData();
        $keyword = $this->input->post('judul_skripsi');
        $toLowerKeyword = strtolower($keyword);
        $query = $this->Main_model->searchtitle($keyword, $toLowerKeyword, $id_session);

        if ($query) {
            foreach ($query as $arrayNipDosen => $skorDosen) {
                $queryDosen = $this->Main_model->getDosenByNIP($arrayNipDosen);
                $queryGetSkripsi = $this->Main_model->getSkripsiByDosen($arrayNipDosen);
                foreach ($queryDosen->result_array() as $data) {
                    $nip = $data['nip'];
                }
                foreach ($queryGetSkripsi->result_array() as $row) {
                    $judul = $row['judul_skripsi'];
                }
                $c[] = array(
                    'nip' => "$nip",
                    'nama' => $data['nama'],
                    'foto' => $data['foto'],
                    'program_studi' => $data['program_studi'],
                    'skor' => $skorDosen,
                    'judul' => $judul,
                    'skorPersen' => ($skorDosen / $banyakSkripsi) * 100
                );

                // INSERT TO HASIL_PENCARIAN TABEL
            }

            $data['hasil'] = $c;

            foreach ($data['hasil'] as $a => $b) {
                foreach ($b as $c) {
                }
                $params = array(
                    'id' => bin2hex(random_bytes(10)),
                    'id_session_searching' => $id_session,
                    'nip_searching' => $b['nip'],
                    'skor' => $b['skor'],
                    'skor_persen' => $b['skorPersen']
                );

                $this->db->insert('result_profile', $params);
            }

            $data['get_result'] = $this->Main_model->get_result_judul($id_session);
            $data['data_profile'] = $this->Main_model->GetResultProfile($id_session);
            $this->load->view('home/search_result_view', $data);
        } else {
            $this->load->view('home/not_found_view');
        }
    }
    function countData()
    {
        $banyakSkripsi = $this->Main_model->banyakData();
        echo $banyakSkripsi;
    }
    function showSkripsiByNip($nip)
    {
        $nip = $this->uri->segment('4');
        if ($nip) {
            $data['nip'] = 'Data Dosen';
            $data['profile'] = $this->Main_model->GetJudulByNip($nip);
            $data['skripsi'] = $this->Main_model->GetSkripsiByNip($nip);
            foreach ($data['profile']->result_array() as $dataProfile) {
            }
            foreach ($data['skripsi']->result_array() as $dataSkripsi) {
                $judul_judul[] = $dataSkripsi['judul_skripsi'];
            }
            $full['data'] = array(
                'foto' => $dataProfile['foto'],
                'nama' => $dataProfile['nama'],
                'nip' => $dataProfile['nip'],
                'prodi' => $dataProfile['program_studi'],
                'judul_skripsi' => $judul_judul
            );
            foreach ($full['data'] as $key => $value) {
            }
            $this->load->view('show_profile', $full);
        }
    }
}
