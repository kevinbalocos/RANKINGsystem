<?php
defined('BASEPATH') or exit('No direct script access allowed');

class home_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();

    }
    //ADMIN
    //ADMIN
    //ADMIN
    public function setadminlogin($email, $password)
    {
        $query = $this->db->get_where('admin', ['email' => $email]);
        $admin = $query->row_array();

        if ($admin) {

            if (
                ($email == 'richmond@admin' && $password == '1234') ||
                ($email == 'trina@admin' && $password == '1234') ||
                ($email == 'kevin@admin' && $password == '1234')
            ) {
                return $admin;
            }
        }
        log_message('error', 'Invalid email or password');
        return false;
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

    }













}

