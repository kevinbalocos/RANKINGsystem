<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model('admin_model');
        $this->load->model('home_model');
        $this->load->model('model_faculty');
        date_default_timezone_set('Asia/Manila');


    }

    public function index()
    {
        $this->load->view('forlogin/frontpage');
    }

    public function contact()
    {
        $this->load->view('forlogin/frontpage_contact');
    }

    public function registeradmin()
    {
        $this->load->view('forlogin/viewregisteradmin');
    }


    public function login()
    {
        $this->load->view('forlogin/viewlogin');
    }
    public function viewregister()
    {
        $this->load->view('forlogin/viewregister');
    }

    public function REGISTERorLOGIN()
    {
        $this->load->view('forlogin/REGISTERorLOGIN');
    }
    public function viewlogin()
    {
        // Load frontpage (This includes the navbar and hero section)
        $this->load->view('forlogin/frontpage');

        // The error will be passed to viewlogin
        $data['error'] = ''; // Default to no error

        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->auth_model->setlogin($email, $password);

            if ($user) {
                // Successful login, set session and redirect
                $this->session->set_userdata('user_id', $user['id']);
                $this->session->set_userdata('username', $user['username']);
                redirect(base_url('Home'));
            } else {
                // Login failed, pass error message
                $data['error'] = 'Invalid email or password';
            }
        }

        // Load the login page with error (if any)
        $this->load->view('forlogin/viewlogin', $data);
    }



    public function register()
    {
        // Set validation rules
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('phoneNo', 'Phone Number', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('birth_date', 'Birth Date', 'required');

        $data = array(
            'id' => null,
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'address' => $this->input->post('address'),
            'phoneNo' => $this->input->post('phoneNo'),
            'gender' => $this->input->post('gender'),
            'birth_date' => $this->input->post('birth_date'),
        );

        $password = $this->input->post('password');
        $confirmPassword = $this->input->post('confirm_password');

        // Check if the password and confirm password match
        if ($password !== $confirmPassword) {
            $this->load->view('forlogin/frontpage');  // Include frontpage layout
            $this->load->view('forlogin/viewregister', ['error' => 'Passwords do not match']);
        } else {
            // Passwords match, proceed with registration
            // Check if the email already exists in the database
            $existingUser = $this->auth_model->getUserByEmail($data['email']);

            if ($existingUser) {
                // Load the registration page with SweetAlert2 error
                $this->load->view('forlogin/viewregister', ['error' => 'Email is already in use']);
            } else {
                if ($this->auth_model->register($data)) {
                    redirect(base_url('auth'));  // Redirect to login page or home
                } else {
                    $this->load->view('forlogin/frontpage');  // Include frontpage layout
                    $this->load->view('forlogin/viewregister', ['error' => 'Registration failed']);
                }
            }
        }
    }


    public function aboutranking()
    {
        $this->load->view('forlogin/aboutranking');
    }

    public function viewadmin()
    {
        $this->load->view('Homepage/viewadmin');
    }


    public function adminlogin()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        // Attempt login
        $admin = $this->home_model->setadminlogin($email, $password);

        if ($admin) {
            // Login successful, set session and proceed to admin page
            $this->session->set_userdata('admin_id', $admin['admin_id']);
            $this->session->set_userdata('admin_name', $admin['username']);

            // You can load view dynamically without redirect
            redirect(base_url('conAdmin'));

        } else {
            // Failed login, show SweetAlert error and stay on current page
            $this->load->view('forlogin/frontpage');  // Include frontpage layout
            $this->load->view('Homepage/viewadmin', ['error' => 'Invalid email or password']);
        }
    }
    public function contact_submit()
    {
        // Form validation
        $this->form_validation->set_rules('name', 'Full Name', 'required');
        $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
        $this->form_validation->set_rules('message', 'Your Message', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, load the contact page again
            $this->load->view('forlogin/frontpage_contact');
        } else {
            // Get the form data
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $message = $this->input->post('message');

            // Check if the email is registered
            $user = $this->auth_model->getUserByEmail($email);


            if (!$user) {
                // Email not registered, show an error message
                $this->load->view('forlogin/frontpage_contact', ['error' => 'You are not yet registered']);
            } else {
                // Save the contact message to the database
                $data = [
                    'name' => $name,
                    'email' => $email,
                    'message' => $message,
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $insertSuccess = $this->auth_model->saveContactMessage($data);
                if ($insertSuccess) {
                    $this->load->view('forlogin/frontpage_contact', ['success' => 'Your message has been sent']);
                } else {
                    $this->load->view('forlogin/frontpage_contact', ['error' => 'Failed to send the message']);
                }
            }
        }
    }




}



?>