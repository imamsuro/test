<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            // validasinya sukses
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        // jika usernya ada
        if ($user) {
            //jika user aktif
            if ($user['isactive'] == 1) {
                // cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'roleid' => $user['roleid']
                    ];
                    $this->session->set_userdata($data);

                    if ($user['roleid'] == 1) {
                        redirect('admin');
                    } else {

                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password! </div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email has not been activated! </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered yet! </div>');
            redirect('auth');
        }
    }

    public function registration()
    {

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', ['is_unique' => 'This email already registered!']);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', ['matches' => 'password dont match!', 'min_length' => 'password too short']);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[3]|matches[password1]');


        if ($this->form_validation->run() == false) {

            $data['title'] = 'Aplikasi Manajemen Surat Pertanahan';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email', true);
            $data = [

                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'roleid' => 2,
                'isactive' => 0,
                'datecreated' => time()
            ];

            // gawe token
            $token = base64_encode(random_bytes(32));
            $usertoken = [
                'email' => $email,
                'token' => $token,
                'datecreated' => time()
            ];

            $this->db->set('userid', 'UUID()', FALSE);
            $this->db->insert('user', $data);
            $this->db->set('usertokenid', 'UUID()', FALSE);
            $this->db->insert('usertoken', $usertoken);
            //pake _ itu private

            $this->_sendEmail($token, 'verify');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Congratulation! your account has ben created. Please Activated Your Account! </div>');
            redirect('auth');
        }
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'aikosuryaindonesia@gmail.com',
            'smtp_pass' => '1triliun',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);
        $this->email->from('aikosuryaindonesia@gmail.com', 'PT. Aiko Surya Indonesia');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('Click this link to verify your account : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>');
        } else if ($type == 'forgot') {
            $this->email->subject('Reset Password');
            $this->email->message('Click this link to reset your account : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
        }
        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $usertoken = $this->db->get_where('usertoken', ['token' => $token])->row_array();

            if ($usertoken) {

                if (time() - $usertoken['datecreated'] < (60 * 60 * 24)) {
                    $this->db->set('isactive', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    $this->db->delete('usertoken', ['email' => $email]);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Congratulation! your account has ben activated. Please Login! </div>');
                    redirect('auth');
                } else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('usertoken', ['email' => $email]);
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account Activation Failed! Token expired</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account Activation Failed! Wrong token, Please using token from email</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account Activation Failed! Wrong email</div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('roleid');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out</div>');
        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }

    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgotpassword');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'isactive' => 1])->row_array();

            if ($user) {
                $token = base64_encode(random_bytes(32));
                $usertoken = [
                    'email' => $email,
                    'token' => $token,
                    'datecreated' => time()
                ];

                $this->db->set('usertokenid', 'UUID()', FALSE);
                $this->db->insert('usertoken', $usertoken);

                $this->_sendEmail($token, 'forgot');
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Please check your email to reset your password! </div>');
                redirect('auth');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered or not activated yet</div>');
                redirect('auth/forgotpassword');
            }
        }
    }

    public function resetPassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $usertoken = $this->db->get_where('usertoken', ['token' => $token])->row_array();
            if ($usertoken) {
                $this->session->set_userdata('resetemail', $email);
                $this->changePassword();
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset Password Failed, Wrong Token</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset Password Failed, Wrong Email</div>');
            redirect('auth');
        }
    }


    public function changePassword()
    {
        if (!$this->session->userdata('resetemail')) {
            redirect('auth');
        }
        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[3]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Password', 'trim|required|min_length[3]|matches[password1]');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Change Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/changepassword');
            $this->load->view('templates/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('resetemail');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('resetemail');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password has been changed! Please Login! </div>');
            redirect('auth');
        }
    }
}
