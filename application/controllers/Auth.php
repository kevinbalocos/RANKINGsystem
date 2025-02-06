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


        $this->email_config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'erankingsystem@gmail.com', // Your email
            'smtp_pass' => 'xcgs aayk sabg smwd', // Your password (or App Password)
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];



    }




    public function manage_users()
    {
        $data['pending_users'] = $this->auth_model->getPendingUsers();
        $data['approved_users'] = $this->auth_model->getUsersByStatus('approved');
        $data['rejected_users'] = $this->auth_model->getUsersByStatus('rejected');
        $this->load->view('adminHomepage/approve_users_account', $data);
    }

    public function approve_user($user_id)
    {
        $user = $this->auth_model->getUserById($user_id);

        if ($user) {
            $this->auth_model->updateUserStatus($user_id, 'approved');

            // Send approval email
            $subject = "Account Approved";
            $message = "Hello " . $user['username'] . ",<br><br>Your account has been approved. You can now log in.<br><br>Thank you!";

            $this->send_email($user['email'], $subject, $message);

            $this->session->set_flashdata('message', 'User approved and notified.');
        }

        redirect(base_url('auth/manage_users'));
    }

    public function reject_user($user_id)
    {
        $user = $this->auth_model->getUserById($user_id);

        if ($user) {
            $this->auth_model->updateUserStatus($user_id, 'rejected');

            // Send rejection email
            $subject = "Account Rejected";
            $message = "Hello " . $user['username'] . ",<br><br>We regret to inform you that your account registration has been rejected.<br><br>Thank you!";

            $this->send_email($user['email'], $subject, $message);

            // Flash message for rejection
            $this->session->set_flashdata('message', 'Your account was rejected by the admin.');

        }

        redirect(base_url('auth/manage_users'));
    }


    private function send_email($to, $subject, $message)
    {
        $this->load->library('email');
        $this->email->initialize($this->email_config); // ✅ Use saved email config

        $this->email->from('erankingsystem@gmail.com', 'HR ADMIN'); // Change sender email
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);


        if ($this->email->send()) {
            return true;
        } else {
            log_message('error', $this->email->print_debugger());
            return false;
        }
    }






    public function index()
    {
        $data['pending_users'] = $this->auth_model->getPendingUsers();
        $data['approved_users'] = $this->auth_model->getUsersByStatus('approved');
        $data['rejected_users'] = $this->auth_model->getUsersByStatus('rejected');
        $this->load->view('forlogin/frontpage', $data);
    }

    public function contact()
    {
        $this->load->view('forlogin/frontpage_contact');
    }

    public function registeradmin()
    {
        $this->load->view('forlogin/viewregisteradmin');
    }
    public function feedback_contact()
    {
        $data['feedbacks'] = $this->auth_model->getFeedbackMessages(); // Get feedback from the model
        $this->load->view('adminHomepage/Feedback', $data); // Pass data to the view
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
        $this->load->view('forlogin/frontpage');

        $data['error'] = '';  // Initialize error variable

        if ($this->input->post('email') && $this->input->post('password')) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            // Get user data from the model
            $user = $this->auth_model->setlogin($email, $password);

            if ($user) {
                if ($user['status'] === 'approved') {
                    $this->session->set_userdata('user_id', $user['id']);
                    $this->session->set_userdata('username', $user['username']);
                    redirect(base_url('Home'));
                } else {
                    // Handle cases where the user is pending or rejected
                    if ($user['status'] === 'rejected') {
                        $data['error'] = 'Your account has been rejected by the admin.';
                    } else {
                        $data['error'] = 'Your account is pending approval.';
                    }
                }
            } else {
                // In case of invalid login (wrong email or password)
                $data['error'] = 'Invalid email or password';
            }
        }

        // Load the login view with the error message if any
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

        // Check if validation runs
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(['status' => 'error', 'message' => $errors]);
            return;
        }

        // Check if email already exists
        $email = $this->input->post('email');
        $existing_user = $this->auth_model->getUserByEmail($email);
        if ($existing_user) {
            echo json_encode(['status' => 'error', 'message' => 'Email is already in use.']);
            return;
        }

        // Prepare the data for registration
        $data = array(
            'id' => null,
            'username' => $this->input->post('username'),
            'email' => $email,
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'address' => $this->input->post('address'),
            'phoneNo' => $this->input->post('phoneNo'),
            'gender' => $this->input->post('gender'),
            'birth_date' => $this->input->post('birth_date'),
            'status' => 'pending'  // Set user status to pending
        );

        if ($this->auth_model->register($data)) {
            echo json_encode(['status' => 'success', 'message' => 'Registration successful! Please wait for admin approval.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Registration failed. Please try again.']);
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

    public function deleteFeedback($id)
    {
        if ($this->auth_model->deleteFeedbackById($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Feedback deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete feedback']);
        }
    }









}



?>