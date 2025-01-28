<?php
defined('BASEPATH') or exit('No direct script access allowed');

class admin_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    //! RECENT TASKS DASHBOARD
    public function getRecentTasks()
    {
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(10);
        return $this->db->get('tasks')->result_array();
    }


    public function getTotalTaskCount()
    {
        return $this->db->count_all('tasks');
    }


    //!USER TASK
    public function createTask($task_data)
    {
        return $this->db->insert('tasks', $task_data);
    }

    public function getTasks()
    {
        $this->db->select('tasks.*, users.username as task_for');
        $this->db->from('tasks');
        $this->db->join('users', 'users.id = tasks.task_for', 'left');
        return $this->db->get()->result_array();
    }




    public function updateTaskOwner($taskId, $newOwner)
    {
        $this->db->set('owner', $newOwner);
        $this->db->where('id', $taskId);
        return $this->db->update('tasks');
    }

    public function updateTaskField($taskId, $columnType, $newValue)
    {
        $validColumns = ['task_name', 'owner', 'status', 'due_date'];
        if (!in_array($columnType, $validColumns)) {
            return false; // Unknown column type
        }

        $this->db->set($columnType, $newValue);
        $this->db->where('id', $taskId);
        return $this->db->update('tasks');
    }

    // public function updateTaskFileInCompleted($task_id, $data)
    // {
    //     // Ensure the task_id exists in the completedtask table
    //     // If it does not exist, you may want to insert it, or else update it
    //     $this->db->where('task_id', $task_id);
    //     $existing_task = $this->db->get('completedtask')->row();

    //     if ($existing_task) {
    //         // If the task already exists in completedtask, update it
    //         return $this->db->update('completedtask', $data);
    //     } else {
    //         // If task doesn't exist in completedtask, insert it
    //         return $this->db->insert('completedtask', $data);
    //     }
    // }
    // public function getCompletedTasks()
    // {
    //     $this->db->select('completedtask.*, tasks.task_name, tasks.due_date, users.username as task_for');
    //     $this->db->from('completedtask');
    //     $this->db->join('tasks', 'tasks.id = completedtask.task_id');
    //     $this->db->join('users', 'users.id = tasks.task_for'); // Join the users table to get the task_for
    //     return $this->db->get()->result_array();
    // }




    public function getTasksByUserId($user_id)
    {
        $this->db->select('tasks.*, users.username as task_for');
        $this->db->from('tasks');
        $this->db->join('users', 'users.id = tasks.task_for', 'left');
        $this->db->where('tasks.task_for', $user_id);
        return $this->db->get()->result_array();
    }

    public function getTaskById($task_id)
    {
        return $this->db->get_where('tasks', ['id' => $task_id])->row_array();
    }



    public function getUserRankings()
    {
        $query = $this->db->query("
            SELECT 
                users.id, 
                users.username, 
                COUNT(tasks.id) AS completed_tasks, 
                IFNULL(users.points, 0) AS manual_points,
                (COUNT(tasks.id) * 100 + IFNULL(users.points, 0)) AS total_points
            FROM users
            LEFT JOIN tasks 
                ON users.id = tasks.task_for AND tasks.status = 'Completed'
            GROUP BY users.id
            ORDER BY total_points DESC
        ");
        return $query->result_array();
    }


    public function addPoints($user_id, $points)
    {
        $this->db->set('points', 'points + ' . (int) $points, FALSE); // Increment points
        $this->db->where('id', $user_id);
        return $this->db->update('users'); // Update the user's points

    }
    public function addNotification($message)
    {
        $data = [
            'message' => $message,
            'created_at' => date('Y-m-d H:i:s')  // Use current timestamp
        ];
        return $this->db->insert('notif_rankingtask', $data);
    }
    public function getNotifications()
    {
        return $this->db->order_by('created_at', 'DESC')
            ->limit(10)
            ->get('notif_rankingtask')
            ->result_array();
    }


    public function deleteNotification($notification_id)
    {
        return $this->db->delete('notif_rankingtask', ['id' => $notification_id]);
    }

    public function deleteAllNotifications()
    {
        return $this->db->empty_table('notif_rankingtask'); // Deletes all rows from the notifications table
    }


    public function saveUploadedTask($data)
    {
        // Get the logged-in user's ID
        $user_id = $this->session->userdata('user_id');

        // Add the user_id to the task data
        $data['user_id'] = $user_id;

        return $this->db->insert('user_uploadedtask', $data);
    }

    public function getUploadedTasks()
    {
        $this->db->select('user_uploadedtask.*, users.username');
        $this->db->from('user_uploadedtask');
        $this->db->join('users', 'users.id = user_uploadedtask.user_id'); // Join to get the username
        $query = $this->db->get();

        // Debugging: Check if any data was fetched
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            // Log or print to debug
            log_message('error', 'No uploaded tasks found in the database.');
            return [];  // Return an empty array if no tasks are found
        }
    }


    public function getUploadedTasksByUser($user_id)
    {
        $this->db->where('user_id', $user_id); // Filter tasks by user ID
        return $this->db->get('user_uploadedtask')->result_array(); // Return the tasks specific to the user
    }







}
