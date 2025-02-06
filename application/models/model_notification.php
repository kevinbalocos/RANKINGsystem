<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_notification extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();

    }


    public function getUnreadNotifications($user_id)
    {
        return $this->db->where('user_id', $user_id)
            ->where('status', 'unread')
            ->order_by('created_at', 'DESC')
            ->get('notifications_requirements')
            ->result_array();
    }

    public function markAsRead($notification_id)
    {
        $this->db->where('id', $notification_id)
            ->update('notifications_requirements', ['status' => 'read']);
    }
}
