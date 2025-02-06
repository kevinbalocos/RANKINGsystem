<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
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
            return $user;  // Include status in the response
        } else {
            return false;
        }
    }
    public function getAdminByEmail($email)
    {
        $query = $this->db->get_where('admin', ['email' => $email]);
        return $query->row_array();
    }

    public function register_admin($data)
    {
        return $this->db->insert('admin', $data);
    }


    public function getUsersByStatus($status)
    {
        $query = $this->db->get_where('users', ['status' => $status]);
        return $query->result_array();
    }

    public function getPendingUsers()
    {
        $query = $this->db->get_where('users', ['status' => 'pending']);
        return $query->result_array();
    }

    public function updateUserStatus($user_id, $status)
    {
        $this->db->where('id', $user_id);
        return $this->db->update('users', ['status' => $status]);
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
        // First, delete related notifications
        $this->db->where('user_id', $user_id);
        $this->db->delete('notifications');

        // Now delete the user
        $this->db->where('id', $user_id);
        $this->db->delete('users');

        // Optionally, set a success message
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



    // In auth_model.php
    public function saveContactMessage($data)
    {
        return $this->db->insert('contact_frontpage', $data);
    }

    public function getFeedbackMessages()
    {
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('contact_frontpage');
        return $query->result_array();
    }


    public function deleteFeedbackById($id)
    {
        // First check if the feedback exists
        $this->db->where('id', $id);
        $query = $this->db->get('contact_frontpage');

        if ($query->num_rows() == 0) {
            return false; // Feedback ID not found
        }

        // Delete the feedback
        $this->db->where('id', $id);
        return $this->db->delete('contact_frontpage');
    }



    // Assign a shift
    public function assignShift($data)
    {
        $this->db->where('user_id', $data['user_id']);
        $existing_shift = $this->db->get('shifts')->row_array();

        if ($existing_shift) {
            $this->db->where('user_id', $data['user_id']);
            return $this->db->update('shifts', $data);
        } else {
            return $this->db->insert('shifts', $data);
        }
    }

    // Save check-in
// Save check-in
    public function saveCheckIn($user_id, $check_in_time)
    {
        $this->db->where('user_id', $user_id);
        $shift = $this->db->get('shifts')->row_array();

        if ($shift) {
            $shift_start_time = strtotime(date('Y-m-d') . ' ' . $shift['shift_start']);
            $check_in_timestamp = strtotime($check_in_time);

            // Calculate the status based on the check-in time
            $status = '';
            $early_minutes = 0;
            $early_seconds = 0;

            // Set a tolerance range of 5 minutes for on-time check-in
            $tolerance_range = 1 * 60; // 5 minutes in seconds

            if ($check_in_timestamp < ($shift_start_time - $tolerance_range)) {
                $status = 'Early';
                // Calculate the early time difference in minutes and seconds
                $difference = $shift_start_time - $check_in_timestamp;
                $early_minutes = floor($difference / 60);
                $early_seconds = $difference % 60;
            } elseif ($check_in_timestamp >= $shift_start_time && $check_in_timestamp <= ($shift_start_time + $tolerance_range)) {
                $status = 'On Time';
            } else {
                $status = 'Late';
            }

            // Save attendance record
            $this->db->insert('attendance', [
                'user_id' => $user_id,
                'check_in_time' => $check_in_time,
                'shift_start' => $shift['shift_start'],
                'status' => $status,
                'early_minutes' => $early_minutes, // Save the early minutes
                'early_seconds' => $early_seconds, // Save the early seconds
                'date' => date('Y-m-d', $check_in_timestamp),
                'day' => date('l', $check_in_timestamp),
            ]);
            return TRUE;
        }
        return FALSE;
    }



    // Save check-out
    public function saveCheckOut($user_id, $check_out_time)
    {
        // Find the current attendance record with a NULL check_out_time
        $this->db->where('user_id', $user_id);
        $this->db->where('check_out_time IS NULL', null, false);
        $attendance = $this->db->get('attendance')->row_array();

        if ($attendance) {
            // Retain the current status
            $current_status = $attendance['status'];

            // Update the attendance record with the check-out time
            $this->db->where('id', $attendance['id']);
            return $this->db->update('attendance', [
                'check_out_time' => $check_out_time,
                'status' => $current_status // Retain the original status
            ]);
        }

        return FALSE;
    }


    public function getShiftByUserId($user_id)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->get('shifts')->row_array();
    }

    public function getAttendanceByUserId($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('check_in_time', 'DESC');
        return $this->db->get('attendance')->result_array();
    }

    public function getAllAttendance()
    {
        // SQL to fetch all attendance data
        $this->db->select('attendance.*, users.username'); // Include username for display
        $this->db->from('attendance');
        $this->db->join('users', 'users.id = attendance.user_id'); // Join with users table
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getAllShifts()
    {
        // This method fetches the shift start and end times for all users
        $this->db->select('user_id, shift_start, shift_end');
        $query = $this->db->get('shifts'); // Assuming the table storing shifts is named 'shifts'
        return $query->result_array();
    }

    public function saveNotification($username, $action, $time)
    {
        $notification = [
            'message' => "$username $action at " . date('h:i A', strtotime($time)),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        return $this->db->insert('attendance_notifications', $notification); // Assuming you have a notifications table
    }
    public function getAllNotifications()
    {
        $this->db->order_by('created_at', 'DESC'); // Order by most recent
        $this->db->limit(8);
        return $this->db->get('attendance_notifications')->result_array();
    }

    // Inside Auth_model.php
    public function deleteOldNotifications($limit)
    {
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $limit); // Skip the first $limit entries
        $oldNotifications = $this->db->get('notifications')->result_array();

        if (!empty($oldNotifications)) {
            $idsToDelete = array_column($oldNotifications, 'id');
            $this->db->where_in('id', $idsToDelete);
            $this->db->delete('attendance_notifications');
        }
    }

    public function getUsernameById($user_id)
    {
        // Query to fetch the username based on user_id
        $this->db->select('username');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $query = $this->db->get();

        // If a user with the given user_id exists, return the username
        if ($query->num_rows() > 0) {
            return $query->row_array()['username'];
        }

        return false; // Return false if no user found
    }
    public function deleteNotificationById($notification_id)
    {
        $this->db->where('id', $notification_id);
        return $this->db->delete('attendance_notifications');
    }


    public function deleteAllNotifications()
    {
        return $this->db->empty_table('attendance_notifications');
    }

    public function deleteAttendanceById($attendance_id)
    {
        // Delete the attendance record by its ID
        $this->db->where('id', $attendance_id);
        return $this->db->delete('attendance');
    }

    // Bulk delete method
    public function deleteBulkAttendance($attendance_ids)
    {
        // Ensure attendance_ids is an array
        if (!empty($attendance_ids)) {
            // Use CI's `where_in` method to delete multiple records based on IDs
            $this->db->where_in('id', $attendance_ids);
            return $this->db->delete('attendance');  // Assuming 'attendance' is the table name
        }
        return false;
    }





}