<?php
defined('BASEPATH') or exit('No direct script access allowed');

class controllerAttendance extends CI_Controller
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
    // View for assigning shifts
    public function assignShift()
    {
        $data['users'] = $this->auth_model->getUsers();
        $data['attendance'] = $this->auth_model->getAllAttendance();
        $data['shifts'] = $this->auth_model->getAllShifts();
        $data['notifications'] = $this->auth_model->getAllNotifications(); // Fetch notifications

        // Load the view and pass the data
        $this->load->view('adminHomepage/adminAssignshift', $data);
    }


    // Save assigned shift
    // Save assigned shift
    public function saveShift()
    {
        $shift_start = $this->input->post('shift_start');
        $shift_end = $this->input->post('shift_end');

        // Directly proceed without validation
        $data = [
            'user_id' => $this->input->post('user_id'),
            'shift_start' => $shift_start,
            'shift_end' => $shift_end
        ];

        // Save the shift without any validation
        if ($this->auth_model->assignShift($data)) {
            $this->session->set_flashdata('success', 'Shift assigned successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to assign shift.');
        }
        redirect('conAdmin');
    }


    // Validate time format
    public function validate_time($time)
    {
        if (!preg_match('/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/', $time)) {
            $this->form_validation->set_message('validate_time', 'The {field} field must be a valid time (HH:MM).');
            return FALSE;
        }
        return TRUE;
    }
    public function userAttendance()
    {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->auth_model->getUserById($user_id);
        $data['shift'] = $this->auth_model->getShiftByUserId($user_id);
        $data['attendance'] = $this->auth_model->getAttendanceByUserId($user_id);

        $this->load->view('Homepage/userAttendance', $data);
    }


    // Check-In functionality
    public function checkIn()
    {
        $user_id = $this->session->userdata('user_id');
        $check_in_time = date('Y-m-d H:i:s');

        if ($this->auth_model->saveCheckIn($user_id, $check_in_time)) {
            // Save notification for check-in
            $username = $this->auth_model->getUsernameById($user_id); // Get the username
            $this->auth_model->saveNotification($username, 'check-in', $check_in_time);

            $this->session->set_flashdata('success', 'Check-in recorded successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to record check-in.');
        }
        redirect('Home');
    }

    public function checkOut()
    {
        $user_id = $this->session->userdata('user_id');
        $check_out_time = date('Y-m-d H:i:s');

        if ($this->auth_model->saveCheckOut($user_id, $check_out_time)) {
            // Save notification for check-out
            $username = $this->auth_model->getUsernameById($user_id); // Get the username
            $this->auth_model->saveNotification($username, 'check-out', $check_out_time);

            $this->session->set_flashdata('success', 'Check-out recorded successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to record check-out.');
        }
        redirect('Home');
    }
    // Delete specific notification
    public function deleteNotification($notification_id)
    {
        if ($this->auth_model->deleteNotificationById($notification_id)) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false]);
        }
    }
    public function cleanOldNotifications()
    {
        $this->auth_model->deleteOldNotifications(7); // Keep only the latest 7
    }

    // Delete all notifications
    public function deleteAllNotifications()
    {
        if ($this->auth_model->deleteAllNotifications()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false]);
        }
    }
    public function deleteAttendanceRecords($attendance_id)
    {
        // Attempt to delete the attendance record by ID
        if ($this->auth_model->deleteAttendanceById($attendance_id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit;
    }

    // Method for bulk delete
    public function bulkDeleteAttendance()
    {
        // Get the selected attendance IDs from the form
        $attendance_ids = $this->input->post('attendance_ids');

        if (!empty($attendance_ids)) {
            // Decode the JSON string to get the array of IDs
            $attendance_ids = json_decode($attendance_ids, true);

            if ($this->auth_model->deleteBulkAttendance($attendance_ids)) {
                $this->session->set_flashdata('success', 'Selected attendance records deleted successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to delete selected attendance records.');
            }
        } else {
            $this->session->set_flashdata('error', 'No attendance records selected.');
        }

    }


}


?>