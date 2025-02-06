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
        $this->load->library('upload');


        date_default_timezone_set('Asia/Manila');
    }
    // In controllerFaculty
    public function UserFaculty()
    {
        $user_id = $this->session->userdata('user_id');
        $user = $this->model_faculty->getUserById($user_id);

        // Fetch user points using the new getUserPoints method
        $user_points = $this->model_faculty->getUserPoints($user_id);

        // Get the rank label (current rank)
        $rank_label = $this->getRankLabel($user['rank'] ?? 'Unspecified');

        // Get the next rank for the user
        $next_rank_label = $this->getNextRankLabel($user['rank'] ?? 'Unspecified');

        // Get file submissions for the current user
        $file_submissions = $this->model_faculty->getFileSubmissionsByUser($user_id);

        // Get the next rank's order (rank order)
        $next_rank_order = $this->getNextRankOrder($user['rank'] ?? 'Unspecified');

        // Fetch fellow faculty members (excluding the current user)
        $fellow_faculty_members = $this->model_faculty->getFellowFacultyMembers($user_id);

        // Pass the necessary data to the view
        $data['user'] = $user;
        $data['rank_label'] = $rank_label;
        $data['user_points'] = $user_points;
        $data['next_rank_label'] = $next_rank_label;
        $data['file_submissions'] = $file_submissions;
        $data['next_rank_order'] = $next_rank_order;
        $data['fellow_faculty_members'] = $fellow_faculty_members;

        $this->load->view('Homepage/userFaculty', $data);
    }



    public function getNextRankOrder($currentRank)
    {
        $rankOrder = [
            'Instructor I',
            'Instructor II',
            'Instructor III',
            'Assistant Professor I',
            'Assistant Professor II',
            'Associate Professor I',
            'Associate Professor II',
            'Associate Professor III',
            'Associate Professor IV',
            'Professor I',
            'Professor II'
        ];
        $currentRankIndex = array_search($currentRank, $rankOrder);
        if ($currentRankIndex !== false && $currentRankIndex + 1 < count($rankOrder)) {
            return $rankOrder[$currentRankIndex + 1];
        }
        return 'No next rank available';

    }

    public function getNextRankLabel($currentRank)
    {
        $rankRequirements = [
            'Instructor I' => 'BS/AB Graduate with Government Examination (CPA, Civil Service, Nursing Board Exam, etc)',
            'Instructor II' => 'BS/AB with Government Examination and MA/MBA Units',
            'Instructor III' => 'BS/AB with Government Examination with Complete Academic Requirements, no thesis',
            'Assistant Professor I' => 'BS/AB with Full MA',
            'Assistant Professor II' => 'Full MA with Government',
            'Associate Professor I' => 'Full MA with 3-15 Doctoral Units',
            'Associate Professor II' => 'Full MA with 18-30 Doctoral Units',
            'Associate Professor III' => 'Full MA with 33-45 Doctoral Units',
            'Associate Professor IV' => 'Full MA with over 45 Doctoral Units',
            'Professor I' => 'Full-fledged Doctor for 10 years',
            'Professor II' => 'Full-fledged Doctor for 11 years and above'
        ];

        $rankOrder = [
            'Instructor I',
            'Instructor II',
            'Instructor III',
            'Assistant Professor I',
            'Assistant Professor II',
            'Associate Professor I',
            'Associate Professor II',
            'Associate Professor III',
            'Associate Professor IV',
            'Professor I',
            'Professor II'
        ];

        $currentRankIndex = array_search($currentRank, $rankOrder);
        if ($currentRankIndex !== false && $currentRankIndex + 1 < count($rankOrder)) {
            return $rankRequirements[$rankOrder[$currentRankIndex + 1]];
        }

        return 'No next rank available';
    }


    public function getRankLabel($rank)
    {
        switch ($rank) {
            case 'Instructor I':
                return 'BS/AB Graduate with Government Examination (CPA, Civil Service, Nursing Board Exam, etc)';
            case 'Instructor II':
                return 'BS/AB with Government Examination and MA/MBA Units';
            case 'Instructor III':
                return 'BS/AB with Government Examination with Complete Academic Requirements, no thesis';
            case 'Assistant Professor I':
                return 'BS/AB with Full MA';
            case 'Assistant Professor II':
                return 'Full MA with Government';
            case 'Associate Professor I':
                return 'Full MA with 3-15 Doctoral Units';
            case 'Associate Professor II':
                return 'Full MA with 18-30 Doctoral Units';
            case 'Associate Professor III':
                return 'Full MA with 33-45 Doctoral Units';
            case 'Associate Professor IV':
                return 'Full MA with over 45 Doctoral Units';
            case 'Professor I':
                return 'Full-fledged Doctor for 10 years';
            case 'Professor II':
                return 'Full-fledged Doctor for 11 years and above';
            default:
                return 'Unspecified Label';
        }
    }

    public function submitFile()
    {
        $user_id = $this->session->userdata('user_id');
        $user = $this->model_faculty->getUserById($user_id);

        $rank = $user['rank'];
        $label = $this->getRankLabel($rank);
        $next_rank_label = $this->getNextRankLabel($rank); // Get the next rank label
        $next_rank_order = $this->getNextRankOrder($rank); // Get the next rank order

        if ($_FILES['file']['error'] == 0) {
            $uploadPath = 'uploads/rank_requirements_faculty';
            $filePath = $uploadPath . $_FILES['file']['name'];

            if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
                // Save file, label, next rank label, next rank order, and set 'approved' to 0
                $this->model_faculty->saveFileSubmission($user_id, $filePath, $label, $next_rank_label, $next_rank_order, 0);

                echo json_encode(['success' => true, 'message' => 'File uploaded successfully with label: ' . $label]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No file uploaded or error in file upload']);
        }
    }
    public function approveFile($submission_id)
    {
        $submission = $this->model_faculty->getFileSubmissionById($submission_id);

        if ($submission) {
            $approval = $this->model_faculty->approveFileSubmission($submission_id);

            if ($approval) {
                $this->model_faculty->awardPoints($submission['user_id'], 1000);
                $this->model_faculty->updateUserRankAfterApproval($submission['user_id']);

                // Add Notification for Rank Up
                $message = "Your file has been approved, and you've been awarded 1000 points. Your rank has been updated!";
                $this->model_faculty->addfaculty_rankup_Notification($submission['user_id'], $message);

                echo json_encode([
                    'success' => true,
                    'message' => 'File approved, points awarded, rank updated, and notification sent.'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to approve the file.'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Submission not found.'
            ]);
        }
    }

    public function declineFile($submission_id)
    {
        $submission = $this->model_faculty->getFileSubmissionById($submission_id);

        if ($submission) {
            if ($this->model_faculty->deleteFileSubmission($submission_id)) {
                // Add Notification for Decline
                $message = "Your file submission has been declined.";
                $this->model_faculty->addfaculty_rankup_Notification($submission['user_id'], $message);  // Corrected the method name here

                echo json_encode([
                    'success' => true,
                    'message' => 'File declined successfully and notification sent.'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to decline the file.'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Submission not found.'
            ]);
        }
    }




    public function addRank()
    {
        $rank = $this->input->post('rank');
        // Check if the rank already exists
        if ($this->model_faculty->checkRankExists($rank)) {
            echo json_encode(['success' => false, 'message' => 'Rank already exists.']);
        } else {
            if ($this->model_faculty->addRank($rank)) {
                echo json_encode(['success' => true, 'message' => 'Rank added successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add rank.']);
            }
        }
    }

    public function addFaculty()
    {
        $faculty = $this->input->post('faculty');
        // Check if the faculty already exists
        if ($this->model_faculty->checkFacultyExists($faculty)) {
            echo json_encode(['success' => false, 'message' => 'Faculty already exists.']);
        } else {
            if ($this->model_faculty->addFaculty($faculty)) {
                echo json_encode(['success' => true, 'message' => 'Faculty added successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add faculty.']);
            }
        }
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
    public function deleteRank()
    {
        // Retrieve the JSON data sent by the client
        $inputData = json_decode($this->input->raw_input_stream, true);

        if (isset($inputData['rank_id'])) {
            $rankId = $inputData['rank_id'];
            if ($this->model_faculty->deleteRank($rankId)) {
                // Rank deleted successfully
                echo json_encode(['success' => true]);
            } else {
                // Failed to delete rank
                echo json_encode(['success' => false]);
            }
        } else {
            // Invalid input
            echo json_encode(['success' => false, 'message' => 'Rank ID missing']);
        }
    }


    public function deleteFaculty()
    {
        // Retrieve the JSON data sent by the client
        $inputData = json_decode($this->input->raw_input_stream, true);

        // Check if faculty ID exists
        if (isset($inputData['faculty_id'])) {
            $facultyId = $inputData['faculty_id'];

            // Call the model method to delete the faculty
            $result = $this->model_faculty->deleteFaculty($facultyId);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Faculty deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete faculty']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Faculty ID missing']);
        }
    }






}


?>