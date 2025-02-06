<?php
defined('BASEPATH') or exit('No direct script access allowed');

class conRealtimeChat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_realtimechat');
        $this->load->library('session');
        $this->load->database();
    }

    public function userRealtimechat()
    {
        $data['admins'] = $this->model_realtimechat->getAdmins();
        $this->load->view('Homepage/user_realtime_chat', $data);
    }

    public function adminRealtimechat()
    {
        if (!$this->session->userdata('admin_id')) {
            redirect('admin/login');
        }
        $data['users'] = $this->model_realtimechat->getUsers();
        $this->load->view('adminHomepage/admin_realtime_chat', $data);
    }

    public function fetchMessages()
    {
        $sender_id = $this->session->userdata('user_id') ?: $this->session->userdata('admin_id');
        $receiver_id = $this->input->post('receiver_id');

        if (!$sender_id || !$receiver_id) {
            echo json_encode(['status' => 'error', 'message' => 'Missing sender or receiver']);
            return;
        }

        // Fetch messages between sender and receiver
        $messages = $this->model_realtimechat->getChatMessages($sender_id, $receiver_id);
        echo json_encode($messages);
    }

    public function sendMessage()
    {
        $sender_id = $this->session->userdata('user_id') ?: $this->session->userdata('admin_id');
        $receiver_id = $this->input->post('receiver_id');
        $message = $this->input->post('message');

        if (!$sender_id || !$receiver_id || !$message) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            return;
        }

        // Save the message in the database
        $data = [
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ];

        if ($this->model_realtimechat->sendMessage($data)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Message not sent']);
        }
    }
}
