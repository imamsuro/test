<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat extends CI_Controller
{
    public function index()
    {
        echo "Surat Masuk";
    }

    public function suratMasuk()
    {
        $data['title'] = 'Manajemen Surat Masuk';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('surat/suratmasuk');
            $this->load->view('templates/footer');
        } else { }
    }

    public function agenda()
    {
        $data['title'] = 'Manajemen Agenda Surat';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['agenda'] = $this->db->get('agenda')->result_array();

        $this->form_validation->set_rules('agenda', 'Agenda', 'required');


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('surat/agenda');
            $this->load->view('templates/footer');
        } else {
            $this->db->set('agendaid', 'UUID()', FALSE);
            $this->db->insert('agenda', ['namaagenda' => $this->input->post('agenda')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Agenda Ditambahkan </div>');
            redirect('surat/agenda');
        }
    }
}
