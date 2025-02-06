<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_faculty extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function setlogin($email, $password)
    {
        $query = $this->db->get_where('users', ['email' => $email]);
        $user = $query->row_array();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {

            $db_error = $this->db->error();
            log_message('error', 'Database Error: ' . print_r($db_error, true));

            return false;
        }
    }

    public function register($data)
    {

        return $this->db->insert('users', $data);
    }
    public function getUserByEmail($email)
    {
        $query = $this->db->get_where('users', ['email' => $email]);
        return $query->row_array();
    }




    public function getUsers()
    {
        $query = $this->db->get('users');

        if (!$query) {

            $db_error = $this->db->error();
            log_message('error', 'Database Error: ' . print_r($db_error, true));
        }

        return $query->result_array();
    }

    public function getUserById($user_id)
    {
        $query = $this->db->get_where('users', ['id' => $user_id]);
        return $query->row_array();
        if ($query->num_rows() > 0) {
            $user = $query->row_array();

            if (!empty($user['birth_date'])) {
                $user['birth_date'] = date('Y-m-d', strtotime($user['birth_date']));
            }

            return $user;
        } else {
            return false;
        }
    }

    public function validateUserId($user_id)
    {
        return $this->db->where('id', $user_id)->count_all_results('users') > 0;
    }



    public function updateUser($user_id, $user_data)
    {
        $this->db->where('id', $user_id);
        return $this->db->update('users', $user_data);
    }

    public function deleteUser($user_id)
    {
        $this->db->where('id', $user_id);
        return $this->db->delete('users');
    }





    public function getUsersWithProgress()
    {
        // Query to fetch users and their progress
        $query = $this->db->query("
            SELECT u.id, u.username, 
                   (SUM(CASE WHEN ur.status = 'approved' THEN 1 ELSE 0 END) / COUNT(ur.id)) * 100 AS progress
            FROM users u
            LEFT JOIN userrequirements ur ON u.id = ur.user_id
            GROUP BY u.id
            ORDER BY progress DESC
        ");

        return $query->result_array();
    }


    public function getUsersByRank($rank)
    {
        $query = $this->db->get_where('users', ['rank' => $rank]);
        return $query->result_array();
    }

    public function updateUserRank($user_id, $rank)
    {
        $this->db->where('id', $user_id);
        return $this->db->update('users', ['rank' => $rank]);

    }
    // Fetch users by faculty
    public function getUsersByFaculty($faculty)
    {
        $this->db->where('faculty', $faculty);
        $this->db->where('faculty IS NOT NULL'); // Exclude users with no faculty
        $query = $this->db->get('users');
        return $query->result_array();
    }



    // Assign a faculty to a user
    public function assignUserFaculty($user_id, $faculty)
    {
        $this->db->where('id', $user_id);
        return $this->db->update('users', ['faculty' => $faculty]);
    }

    public function getRanks()
    {
        return $this->db->get('ranks')->result_array();
    }

    public function addRank($rank)
    {
        return $this->db->insert('ranks', ['name' => $rank]);
    }

    public function getFaculties()
    {
        return $this->db->get('faculties')->result_array();
    }

    public function addFaculty($faculty)
    {
        return $this->db->insert('faculties', ['name' => $faculty]);
    }
    public function checkRankExists($rank)
    {
        return $this->db->where('name', $rank)->count_all_results('ranks') > 0;
    }

    public function checkFacultyExists($faculty)
    {
        return $this->db->where('name', $faculty)->count_all_results('faculties') > 0;
    }

    // In the model_faculty (model_faculty.php)
    public function deleteRank($rankId)
    {
        // Ensure this function deletes the correct rank from the database
        $this->db->where('id', $rankId);
        return $this->db->delete('ranks'); // Assuming 'ranks' is the table name
    }

    public function deleteFaculty($facultyId)
    {
        // First, make sure there are no users assigned to the faculty
        $this->db->where('faculty', $facultyId);
        $this->db->update('users', ['faculty' => null]);  // Clear the faculty assignment for users

        // Now delete the faculty
        $this->db->where('id', $facultyId);
        return $this->db->delete('faculties');
    }
    public function getFellowFacultyMembers($user_id)
    {
        $this->db->where('id !=', $user_id); // Exclude the current user
        return $this->db->get('users')->result_array();
    }

    public function saveFileSubmission($user_id, $file_path, $label, $next_rank_label, $next_rank_order, $approved)
    {
        $data = [
            'user_id' => $user_id,
            'file_path' => $file_path,
            'label' => $label,
            'next_rank_label' => $next_rank_label,  // Store the next rank label
            'next_rank_order' => $next_rank_order,  // Store the next rank order
            'submitted_at' => date('Y-m-d H:i:s'),
            'approved' => $approved
        ];
        return $this->db->insert('file_submissions', $data);
    }


    public function getFileSubmissionById($submission_id)
    {
        return $this->db->get_where('file_submissions', ['id' => $submission_id])->row_array();
    }

    public function getFileSubmissionsByUser($user_id)
    {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('file_submissions'); // Assuming the table is called 'file_submissions'
        return $query->result_array(); // Return as an array
    }

    public function approveFileSubmission($submission_id)
    {
        return $this->db->update('file_submissions', ['approved' => 1], ['id' => $submission_id]);
    }

    public function updateUserRankAfterApproval($user_id)
    {
        // Logic to update the user's rank after file approval
        // Example: Update the rank to the next level
        $user = $this->getUserById($user_id);
        $new_rank = $this->calculateNextRank($user['rank']);
        return $this->updateUserRank($user_id, $new_rank);
    }

    public function calculateNextRank($current_rank)
    {
        // This can be customized based on your rank progression logic
        switch ($current_rank) {
            case 'Instructor I':
                return 'Instructor II';
            case 'Instructor II':
                return 'Instructor III';
            case 'Instructor III':
                return 'Assistant Professor I';

            case 'Assistant Professor I':
                return 'Assistant Professor II';
            case 'Assistant Professor II':
                return 'Associate Professor I';

            case 'Associate Professor I':
                return 'Associate Professor II';
            case 'Associate Professor II':
                return 'Associate Professor III';
            case 'Associate Professor III':
                return 'Associate Professor IV';
            case 'Associate Professor IV':
                return 'Professor I';

            case 'Professor I ':
                return 'Professor II';
            case 'Professor II ':
                return 'Professor II';


            default:
                return $current_rank; // No progression
        }
    }

    public function getAllFileSubmissions()
    {
        $this->db->select('file_submissions.*, users.username, file_submissions.submitted_at'); // Include submission timestamp
        $this->db->from('file_submissions');
        $this->db->join('users', 'users.id = file_submissions.user_id'); // Join with users table
        $this->db->order_by('file_submissions.submitted_at', 'DESC');
        return $this->db->get()->result_array();
    }
    public function deleteFileSubmission($submission_id)
    {
        return $this->db->delete('file_submissions', ['id' => $submission_id]);
    }
    // In model_faculty
    public function awardPoints($user_id, $points)
    {
        // Get current points for the user
        $this->db->select('points');
        $this->db->where('id', $user_id);
        $user = $this->db->get('users')->row();

        // Add the points
        $new_points = $user->points + $points;

        // Update the user's points
        $this->db->set('points', $new_points);
        $this->db->where('id', $user_id);
        $this->db->update('users');
    }
    // In your model_faculty
    public function getUserPoints($user_id)
    {
        // Get the current points for the user
        $this->db->select('points');
        $this->db->where('id', $user_id);
        $user = $this->db->get('users')->row();

        return $user ? $user->points : 0;  // Return the points, or 0 if the user does not exist
    }
    public function getPreviousRank($user_id)
    {
        // This assumes you have a 'user_rank_history' table where previous ranks are stored.
        // If not, you might need to adjust the logic or track it in your system.

        $this->db->select('rank');
        $this->db->from('user_rank_history');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('date_updated', 'DESC');
        $this->db->limit(1, 1); // Get the second last record (previous rank)
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->rank;
        }

        return null; // Return null if no previous rank is found
    }

    public function addfaculty_rankup_Notification($user_id, $message)
    {
        $data = [
            'user_id' => $user_id,
            'message' => $message,
            'status' => 'unread',  // Set the status to unread initially
        ];
        return $this->db->insert('notifications_faculty_rankup', $data);
    }

    public function getNotificationsByUser($user_id)
    {
        return $this->db->where('user_id', $user_id)
            ->order_by('created_at', 'DESC')
            ->get('notifications_faculty_rankup')
            ->result_array();
    }



}