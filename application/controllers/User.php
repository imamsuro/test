<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
    }

    public function index()

    {
        $data['title'] = 'Profil Saya';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        //echo 'Welcome ' . $data['user']['name'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function editProfile()
    {
        $data['title'] = 'Edit Profil';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['seksi'] = $this->db->get('seksi')->result_array();


        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/editprofile', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $nip = $this->input->post('nip');

            //cek jika ada gambar yang diupload
            $uploadimage = $_FILES['image']['name'];

            if ($uploadimage) {
                $config['allowed_types']    = 'gif|jpg|png';
                $config['max_size']         = '2048';
                $config['upload_path']      = './assets/img/profile/';

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    $oldimage = $data['user']['image'];
                    if ($oldimage != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $oldimage);
                    }
                    $newimage = $this->upload->data('file_name');
                    $this->db->set('image', $newimage);
                } else {
                    //echo $this->upload->display_errors();
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('user');
                }
            }

            $data = array(
                'name' => $name,
                'nip' => $nip
            );

            $this->db->where('email', $email);
            $this->db->update('user', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Profile has been updated </div>');
            redirect('user');
        }
    }

    public function changePassword()

    {
        $data['title'] = 'Ganti Password';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('currentpassword', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('newpassword1', 'New Password', 'required|trim|min_length[3]|matches[newpassword2]');
        $this->form_validation->set_rules('newpassword2', 'Confirm Password', 'required|trim|min_length[3]|matches[newpassword1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/footer');
        } else {
            $currentpassword = $this->input->post('currentpassword');
            $newpassword = $this->input->post('newpassword1');
            if (!password_verify($currentpassword, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong current password </div>');
                redirect('user/changepassword');
            } else {
                if ($currentpassword == $newpassword) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New password cannot be the same as the current password </div>');
                    redirect('user/changepassword');
                } else {
                    $passwordhash = password_hash($newpassword, PASSWORD_DEFAULT);
                    $this->db->set('password', $passwordhash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password Changed! </div>');
                    redirect('user/changepassword');
                }
            }
        }
    }

    public function buatUser()
    {
        $data['title'] = 'Buat User';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['seksi'] = $this->db->get('seksi')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', ['is_unique' => 'Email sudah terdaftar']);
        $this->form_validation->set_rules('nip', 'NIP', 'required|trim|exact_length[18]|is_unique[user.nip]', ['is_unique' => 'NIP sudah terdaftar', 'excact_length' => 'NIP harus 18 digit']);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', ['matches' => 'password tidak sama!', 'min_length' => 'password terlalu pendek']);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[3]|matches[password1]');


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/buatuser', $data);
            $this->load->view('templates/footer');
        } else {
            $email = $this->input->post('email', true);
            $data = [

                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'roleid' => 2,
                'isactive' => 1,
                'datecreated' => time(),
                'nip' => $this->input->post('nip'),
                'seksi' => $this->input->post('namaseksi')
            ];

            $this->db->set('userid', 'UUID()', FALSE);
            $this->db->insert('user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User Telah Berhasil Dibuat </div>');
            redirect('user/buatuser');
        }
    }
}
