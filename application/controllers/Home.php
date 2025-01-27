<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('home_model');
        $this->load->model('auth_model');
        $this->load->library('session');
        $this->load->model('admin_model');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('upload');
        $this->load->model('model_faculty');
        date_default_timezone_set('Asia/Manila');


    }

    public function index()
    {
        $username = '';

        // Check if the user is logged in
        if ($this->session->has_userdata('user_id')) {
            // Retrieve the username from the session
            $username = $this->session->userdata('username');
        }

        // Load the view and pass the $username variable
        $data['username'] = $username;
        $data['user'] = $this->auth_model->getUserById($this->session->userdata('user_id'));
        $this->load->view('Homepage/viewhome', $data);
    }




    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('auth'));
    }


    public function stock()
    {
        $this->load->view('Homepage/stock');
    }

    public function purchaseThankyou()
    {
        $this->load->view('Thankyou/purchaseThankyou');
    }
    public function test()
    {
        $this->load->view('Thankyou/test');
    }



    //! ADMIN MODEL
    public function DefaultHome()
    {
        // Fetch all products
        $data['products'] = $this->admin_model->getProductsindefaulthome();

        $this->load->view('Homepage/DefaultHome', $data);
    }

    public function clientprofile()
    {
        // Check if the user is logged in
        if (!$this->session->has_userdata('user_id')) {
            redirect(base_url('auth'));
        }

        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->auth_model->getUserById($user_id);

        // Handle profile update form submission
        if ($this->input->post('update_profile')) {
            $this->updateProfile($user_id);
        }

        // Handle profile image upload
        if (!empty($_FILES['profile_image']['name'])) {
            $this->uploadProfileImage();
            $data['user'] = $this->auth_model->getUserById($user_id); // Refresh user data
        }

        $this->load->view('Homepage/clientprofile', $data);
    }

    public function updateProfile($user_id)
    {
        $this->load->library('form_validation');

        // Set validation rules
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('phoneNo', 'Phone Number', 'required|numeric|trim');
        $this->form_validation->set_rules('address', 'Address', 'trim');

        if ($this->form_validation->run()) {
            // Update user profile
            $update_data = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'phoneNo' => $this->input->post('phoneNo'),
                'address' => $this->input->post('address'),
            ];

            $this->auth_model->updateUser($user_id, $update_data);
            $this->session->set_flashdata('success', 'Profile updated successfully.');
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }

        redirect(base_url('Home/clientprofile'));
    }

    public function uploadProfileImage()
    {
        $user_id = $this->session->userdata('user_id');

        // Upload configuration
        $config['upload_path'] = './uploads/profile_images';
        $config['allowed_types'] = '*';
        $config['max_size'] = 10240;
        $config['file_name'] = uniqid();

        $this->upload->initialize($config);

        if ($this->upload->do_upload('profile_image')) {
            $upload_data = $this->upload->data();

            // Save image path in the database
            $image_path = 'uploads/profile_images/' . $upload_data['file_name'];
            $this->auth_model->updateUser($user_id, ['uploaded_profile_image' => $image_path]);

            $this->session->set_flashdata('success', 'Profile image updated successfully.');
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
        }

        redirect(base_url('Home'));
    }

    //! USER TASK
    //! CREATE TASK

    public function userTasks()
    {
        if (!$this->session->has_userdata('user_id')) {
            redirect(base_url('auth'));
        }

        $user_id = $this->session->userdata('user_id');
        $tasks = $this->admin_model->getTasksByUserId($user_id);

        // Ensure tasks have proper statuses (e.g., overdue logic)
        $current_date = date('Y-m-d');
        foreach ($tasks as &$task) {
            if ($task['due_date'] < $current_date && $task['status'] != 'Completed') {
                $task['status'] = 'Overdue';
            }
        }

        $uploaded_tasks = $this->admin_model->getUploadedTasks();

        // Map uploaded tasks to their corresponding statuses
        foreach ($uploaded_tasks as &$file) {
            $task = $this->admin_model->getTaskById($file['task_id']); // Assuming this method exists
            $file['status'] = $task['status'] ?? 'Unknown';
        }

        $data['tasks'] = $tasks;
        $data['uploaded_tasks'] = $uploaded_tasks;

        $data['total_tasks'] = count($tasks);
        $data['completed_tasks'] = count(array_filter($tasks, function ($task) {
            return $task['status'] == 'Completed';
        }));
        $data['pending_tasks'] = count(array_filter($tasks, function ($task) {
            return $task['status'] == 'Not Started' || $task['status'] == 'Overdue';
        }));

        $this->load->view('Homepage/usertask', $data);
    }




    public function saveTask()
    {
        if (!$this->session->has_userdata('user_id')) {
            redirect(base_url('auth'));
        }

        $user_id = $this->session->userdata('user_id');
        $username = $this->session->userdata('username');

        // Configure upload
        $config['upload_path'] = './uploads/tasks';
        $config['allowed_types'] = '*';
        $config['max_size'] = 10240;
        $config['file_name'] = uniqid();

        $this->upload->initialize($config);

        if ($this->upload->do_upload('task_file')) {
            $upload_data = $this->upload->data();
            $data = [
                'file_name' => $upload_data['file_name'],
                'username' => $username,
                'task_id' => $this->input->post('task_id'),
                'uploaded_at' => date('Y-m-d H:i:s'),
            ];

            // Save file details to the database
            $this->admin_model->saveUploadedTask($data);

            // Send JSON response back to the client
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $this->upload->display_errors()]);
        }
    }








}