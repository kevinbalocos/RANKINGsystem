<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_realtimechat extends CI_Model
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






    // public function getUsers()
    // {
    //     $query = $this->db->get('users');

    //     if (!$query) {

    //         $db_error = $this->db->error();
    //         log_message('error', 'Database Error: ' . print_r($db_error, true));
    //     }

    //     return $query->result_array();
    // }

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



    // Get all admins
    public function getAdmins()
    {
        $query = $this->db->get('admin');
        return $query->result_array();
    }

    // Get all users
    public function getUsers()
    {
        $query = $this->db->get('users');
        return $query->result_array();
    }

    // Get messages between sender and receiver
    public function getChatMessages($sender_id, $receiver_id)
    {
        $this->db->where("(sender_id = $sender_id AND receiver_id = $receiver_id) 
                            OR (sender_id = $receiver_id AND receiver_id = $sender_id)", null, false);
        $this->db->order_by('timestamp', 'ASC');
        return $this->db->get('chat_messages')->result_array();
    }

    // Send message
    public function sendMessage($data)
    {
        return $this->db->insert('chat_messages', $data);
    }
}

