<?php
defined('BASEPATH') or exit('No direct script access allowed');

class conNotification extends CI_Controller
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
        $this->load->model('model_notification');

        date_default_timezone_set('Asia/Manila');
    }

    public function getUnreadNotifications($user_id)
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            echo json_encode(['error' => 'User not logged in']);
            return;
        }

        return $this->db->where('user_id', $user_id)
            ->where('status', 'unread')
            ->order_by('created_at', 'DESC') // Sort by latest
            ->get('notifications_requirements')
            ->result_array();
    }

    public function markAsRead()
    {
        $notification_id = $this->input->post('id');
        $this->model_notification->markAsRead($notification_id);
        echo json_encode(['status' => 'success']);
    }


}
