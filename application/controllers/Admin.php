<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
    }


    public function index()

    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        //echo 'Welcome ' . $data['user']['name'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->db->order_by('rolename', 'ASC');

        $data['role'] = $this->db->get('role')->result_array();



        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }


    public function roleAccess($roleid)
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get_where('role', ['roleid' => $roleid])->row_array();
        $this->db->where('usermenuid !=', 1);
        $data['menu'] = $this->db->get('usermenu')->result_array();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/roleaccess', $data);
        $this->load->view('templates/footer');
    }

    public function changeAccess()
    {
        $menuid = $this->input->post('menuId');
        $roleid = $this->input->post('roleId');

        $data = [
            'roleid' => $roleid,
            'usermenuid' => $menuid

        ];

        $result = $this->db->get_where('useraccessmenu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('useraccessmenu', $data);
        } else {
            $this->db->delete('useraccessmenu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed! </div>');
    }

    public function addRole()
    {
        $this->db->set('roleid', 'UUID()', FALSE);
        $this->db->insert('role', ['rolename' => $this->input->post('role')]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role Added </div>');
        redirect('admin/role');
    }

    public function deleteRole($roleid)
    {
        $this->db->where('roleid', $roleid);
        $this->db->delete('role');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role <b>deleted</b> </div>');
        redirect('admin/role');
    }

    public function seksi()
    {
        $data['title'] = 'Seksi';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->db->order_by('namaseksi', 'ASC');
        $data['seksi'] = $this->db->get('seksi')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/seksi', $data);
        $this->load->view('templates/footer');
    }

    public function tambahSeksi()
    {
        $data = [
            'namaseksi' => $this->input->post('namaseksi'),
            'kodeseksi' => $this->input->post('kodeseksi'),
            'keterangan' => $this->input->post('keterangan')
        ];
        $this->db->set('seksiid', 'UUID()', FALSE);
        $this->db->insert('seksi', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Seksi berhasil ditambahkan</div>');
        redirect('admin/seksi');
    }

    public function hapusSeksi($seksiid)

    {
        $this->db->where('seksiid', $seksiid);
        $this->db->delete('seksi');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Seksi <strong>dihapus</strong> </div>');
        redirect('admin/seksi');
    }
}
