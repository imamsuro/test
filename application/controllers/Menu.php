<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
    }

    public function index()

    {
        $data['title'] = 'Manajemen Menu';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        //echo 'Welcome ' . $data['user']['name'];

        $data['menu'] = $this->db->get('usermenu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('usermenu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu Added </div>');
            redirect('menu');
        }
    }

    public function submenu()
    {
        $data['title'] = 'Manajemen Submenu';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('usermenu')->result_array();

        $this->load->model('Menu_model', 'menu');
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('usermenu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('usermenuid', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'Url', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'usermenuid' => $this->input->post('usermenuid'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'isactive' => $this->input->post('isactive')
            ];
            $this->db->insert('usersubmenu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Submenu Added </div>');
            redirect('menu/submenu');
        }
    }

    public function deleteMenu($usermenuid)
    {
        $this->load->model('Menu_model', 'menu');
        $this->menu->deleteMenu($usermenuid);
        $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Menu <b>deleted</b> </div>');
        redirect('menu');
    }
}
