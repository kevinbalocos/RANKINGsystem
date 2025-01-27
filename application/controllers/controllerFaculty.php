<?php
defined('BASEPATH') or exit('No direct script access allowed');

class controllerFaculty extends CI_Controller
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

    public function UserFaculty()
    {
        // Assuming session holds the logged-in user ID
        $user_id = $this->session->userdata('user_id');

        // Fetch user details
        $user = $this->model_faculty->getUserById($user_id);

        // Fetch all users in the same faculty
        $fellow_faculty_members = $this->model_faculty->getUsersByFaculty($user['faculty']);

        // Pass user data and fellow faculty members to the view
        $data['user'] = $user;
        $data['fellow_faculty_members'] = $fellow_faculty_members;

        $this->load->view('Homepage/userFaculty', $data);
    }


    public function addRank()
    {
        $rank = $this->input->post('rank');
        if ($this->model_faculty->addRank($rank)) {
            $this->session->set_flashdata('success', 'Rank added successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to add rank.');
        }
        redirect('conAdmin');
    }

    public function addFaculty()
    {
        $faculty = $this->input->post('faculty');
        if ($this->model_faculty->addFaculty($faculty)) {
            $this->session->set_flashdata('success', 'Faculty added successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to add faculty.');
        }
        redirect('conAdmin');
    }

    public function FacultyAdmin()
    {
        $users = $this->auth_model->getUsers(); // Fetch all users
        $data['users'] = $users;

        // Dynamically fetch ranks and faculties
        $data['ranks'] = $this->model_faculty->getRanks();
        $data['faculties'] = $this->model_faculty->getFaculties();

        $this->load->view('adminHomepage/adminFaculty', $data);
    }


    public function updateRank()
    {
        $data = json_decode($this->input->raw_input_stream, true);
        $user_id = $data['user_id'] ?? null;
        $rank = $data['rank'] ?? null;

        if ($user_id && $this->model_faculty->updateUserRank($user_id, $rank)) {
            echo json_encode(['success' => true, 'message' => 'Rank updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update rank']);
        }
    }

    public function updateFaculty()
    {
        $data = json_decode($this->input->raw_input_stream, true);
        $user_id = $data['user_id'] ?? null;
        $faculty = $data['faculty'] ?? null;

        if ($user_id && $this->model_faculty->assignUserFaculty($user_id, $faculty)) {
            echo json_encode(['success' => true, 'message' => 'Faculty updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update faculty']);
        }
    }

    public function removeRank()
    {
        $user_id = $this->input->post('user_id');

        if ($this->model_faculty->updateUserRank($user_id, null)) {
            $this->session->set_flashdata('success', 'Rank removed successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to remove rank.');
        }

        redirect('conAdmin');
    }

    public function removeFaculty()
    {
        $user_id = $this->input->post('user_id');

        if ($this->model_faculty->assignUserFaculty($user_id, null)) { // Set faculty to NULL
            $this->session->set_flashdata('success', 'Faculty removed successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to remove faculty.');
        }

        redirect('conAdmin');
    }
    public function bulkRemoveRank()
    {
        $data = json_decode($this->input->raw_input_stream, true);
        $user_ids = $data['user_ids'] ?? [];

        if (!empty($user_ids)) {
            $removed = 0;
            foreach ($user_ids as $user_id) {
                $removed += $this->model_faculty->updateUserRank($user_id, null);
            }
            if ($removed == count($user_ids)) {
                echo json_encode(['success' => true, 'message' => 'Ranks removed successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to remove ranks']);
            }
        }
    }

    public function bulkRemoveFaculty()
    {
        $data = json_decode($this->input->raw_input_stream, true);
        $user_ids = $data['user_ids'] ?? [];

        if (!empty($user_ids)) {
            $removed = 0;
            foreach ($user_ids as $user_id) {
                $removed += $this->model_faculty->assignUserFaculty($user_id, null);
            }
            if ($removed == count($user_ids)) {
                echo json_encode(['success' => true, 'message' => 'Faculties removed successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to remove faculties']);
            }
        }
    }
    public function bulkAssignRank()
    {
        $data = json_decode($this->input->raw_input_stream, true);
        $user_ids = $data['user_ids'] ?? [];
        $rank = $data['rank'] ?? null;

        if (!empty($user_ids) && $rank) {
            $assigned = 0;
            foreach ($user_ids as $user_id) {
                $assigned += $this->model_faculty->updateUserRank($user_id, $rank);
            }
            if ($assigned == count($user_ids)) {
                echo json_encode(['success' => true, 'message' => 'Ranks assigned successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to assign ranks']);
            }
        }
    }

    public function bulkAssignFaculty()
    {
        $data = json_decode($this->input->raw_input_stream, true);
        $user_ids = $data['user_ids'] ?? [];
        $faculty = $data['faculty'] ?? null;

        if (!empty($user_ids) && $faculty) {
            $assigned = 0;
            foreach ($user_ids as $user_id) {
                $assigned += $this->model_faculty->assignUserFaculty($user_id, $faculty);
            }
            if ($assigned == count($user_ids)) {
                echo json_encode(['success' => true, 'message' => 'Faculties assigned successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to assign faculties']);
            }
        }
    }




}


?>