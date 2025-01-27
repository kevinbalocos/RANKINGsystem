<?php
defined('BASEPATH') or exit('No direct script access allowed');

class conAdmin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('auth_model');
        $this->load->model('home_model');
        $this->load->library('session');
        $this->load->database();
        $this->load->helper('download');
        $this->load->model('model_faculty');
        date_default_timezone_set('Asia/Manila');


    }

    public function index()
    {
        $this->load->view('Authadmin/adminhome');
    }
    public function userUploadedTasks()
    {
        // Fetch uploaded tasks
        $uploaded_tasks = $this->admin_model->getUploadedTasks(); // Assuming this function retrieves uploaded tasks from the database

        // Map uploaded tasks to their corresponding statuses
        foreach ($uploaded_tasks as &$file) {
            $task = $this->admin_model->getTaskById($file['task_id']); // Assuming this method exists
            $file['status'] = $task['status'] ?? 'Unknown';
        }

        // Pass the data to the view
        $data['uploaded_tasks'] = $uploaded_tasks;

        // Load the view
        $this->load->view('adminHomepage/userUploadedTask', $data);
    }


    private function resizeImage($image_path)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $image_path;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 800;
        $config['height'] = 600;

        $this->load->library('image_lib', $config);

        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }

        $this->image_lib->clear();
    }

    public function userinfo()
    {
        $data['users'] = $this->auth_model->getUsers();
        $this->load->view('adminHomepage/userinfo', $data);
    }
    public function viewuserinfo($user_id)
    {
        $user = $this->auth_model->getUserById($user_id);

        if ($user) {
            $this->load->view('adminHomepage/viewuserinfo', ['user' => $user]);
        } else {
            echo "User not found.";
        }
    }

    public function updateuserinfo($user_id)
    {
        $user_data = [
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
            'phoneNo' => $this->input->post('phoneNo'),
            'gender' => $this->input->post('gender'),
            'birth_date' => $this->input->post('birth_date'),
        ];

        log_message('info', 'User Data: ' . print_r($user_data, true));

        $result = $this->auth_model->updateUser($user_id, $user_data);

        if ($result) {
            redirect(base_url('conAdmin'));
        } else {
            echo "Failed to update user.";
        }
    }



    public function edituserinfo($user_id)
    {
        $user = $this->auth_model->getUserById($user_id);

        if ($user) {
            $this->load->view('adminHomepage/edituserinfo', ['user' => $user]);
        } else {
            echo "User not found.";
        }
    }

    public function tasks()
    {
        $data['tasks'] = $this->admin_model->getTasks(); // Get all active tasks
        // $data['completedTasks'] = $this->admin_model->getCompletedTasks(); // Get completed tasks
        $data['users'] = $this->auth_model->getUsers(); // Fetch users for dropdown
        $this->load->view('adminHomepage/createtask', $data); // Load task creation page
    }


    public function updateOwner()
    {
        $input = json_decode(file_get_contents('php://input'), true); // Get the JSON input
        $taskId = $input['taskId'];
        $newOwner = $input['newOwner'];

        // Validate the inputs (you might want to do more validation based on your requirements)
        if (!empty($taskId) && !empty($newOwner)) {
            // Update the owner in the database
            $result = $this->admin_model->updateTaskOwner($taskId, $newOwner);

            // Return a JSON response
            if ($result) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
        }
    }

    public function updateTaskField()
    {
        $input = json_decode(file_get_contents('php://input'), true); // Get the JSON input
        $taskId = $input['taskId'];
        $columnType = $input['columnType'];
        $newValue = $input['newValue'];

        // Validate the inputs
        if (!empty($taskId) && !empty($columnType) && !empty($newValue)) {
            // Call the model method to update the field
            $result = $this->admin_model->updateTaskField($taskId, $columnType, $newValue);

            // Return a JSON response
            if ($result) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
        }
    }
    public function deleteTask()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $taskId = $input['taskId'];

        if (!empty($taskId)) {
            // Start transaction
            $this->db->trans_start();

            // Delete the related records in the user_uploadedtask table
            $this->db->where('task_id', $taskId);
            $this->db->delete('user_uploadedtask');

            // Delete the task from the tasks table
            $this->db->where('id', $taskId);
            $this->db->delete('tasks');

            // Complete transaction
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete task']);
            } else {
                echo json_encode(['status' => 'success']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Task ID is required']);
        }
    }






    public function deleteuserinfo($user_id)
    {
        $result = $this->auth_model->deleteUser($user_id);

        redirect(base_url('conAdmin'));

    }

    public function dashboard()
    {
        $user_id = $this->session->userdata('user_id'); // Assuming user ID is stored in session

        // Get recent tasks and total tasks
        $recentTasks = $this->admin_model->getRecentTasks();
        $totalTask = $this->admin_model->getTotalTaskCount(); // Total tasks count
        $users = $this->auth_model->getUsers(); // Fetch total users

        // Fetch all uploaded files from the 'userrequirements' table, including the user_id
        $uploaded_files = $this->db->select('userrequirements.*, users.username')
            ->join('users', 'users.id = userrequirements.user_id', 'left')
            ->get('userrequirements')->result_array();  // Fetch all uploaded files with uploader info

        // Calculate weekly approved and denied files
        // Calculate weekly approved and denied files
        $approved_files_by_day = [];
        $denied_files_by_day = [];
        $days_of_week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($days_of_week as $index => $day) {
            // Calculate the start and end times for each day in the current week
            $start_of_week = strtotime('monday this week');
            $start_of_day = $start_of_week + ($index * 24 * 60 * 60); // Offset by the index (days)
            $end_of_day = $start_of_day + (24 * 60 * 60) - 1; // End of the day (23:59:59)

            $approved_files_by_day[] = $this->db->where('status', 'approved')
                ->where('updated_at >=', date('Y-m-d H:i:s', $start_of_day)) // Adjusted for current week's day
                ->where('updated_at <=', date('Y-m-d H:i:s', $end_of_day))
                ->count_all_results('userrequirements');

            $denied_files_by_day[] = $this->db->where('status', 'denied')
                ->where('updated_at >=', date('Y-m-d H:i:s', $start_of_day)) // Adjusted for current week's day
                ->where('updated_at <=', date('Y-m-d H:i:s', $end_of_day))
                ->count_all_results('userrequirements');
        }



        // Count totals for stats
        $totalUploaded = count($uploaded_files);
        $approvedFiles = $this->db->where('status', 'approved')->count_all_results('userrequirements');
        $deniedFiles = $this->db->where('status', 'denied')->count_all_results('userrequirements');

        // Calculate the progress for each user
        foreach ($users as &$user) {
            $userId = $user['id']; // Assuming you have an 'id' field for users
            $totalFiles = $this->db->where('user_id', $userId)->count_all_results('userrequirements');
            $approvedCount = $this->db->where(['user_id' => $userId, 'status' => 'approved'])->count_all_results('userrequirements');
            $user['progress'] = ($totalFiles > 0) ? ($approvedCount / $totalFiles) * 100 : 0; // Calculate progress
        }

        // Count the total number of uploaded, approved, and denied files
        $pendingTasks = $this->db->where('status', 'Not Started')->count_all_results('tasks');
        $completedTasks = $this->db->where('status', 'Completed')->count_all_results('tasks');

        // Fetch notifications for the user (unread notifications only)
        $notifications = $this->db->get_where('notifications', ['user_id' => $user_id])->result_array();

        // Pass the data to the view
        $data['recentTasks'] = $recentTasks;
        $data['totalTask'] = $totalTask;
        $data['completedTasks'] = $completedTasks;
        $data['pendingTasks'] = $pendingTasks;
        $data['users'] = $users;
        $data['uploaded_files'] = $uploaded_files;  // All uploaded files are passed here
        $data['totalUploaded'] = $totalUploaded;
        $data['approvedFiles'] = $approvedFiles;
        $data['deniedFiles'] = $deniedFiles;
        $data['notifications'] = $notifications;
        $data['approved_files_by_day'] = $approved_files_by_day;
        $data['denied_files_by_day'] = $denied_files_by_day;

        // Load the dashboard view
        $this->load->view('Homepage/dashboard', $data);
    }


    //! CREATE TASK
    public function processCreateTask()
    {
        $task_name = $this->input->post('task_name');
        $due_date = $this->input->post('due_date');
        $owner = $this->input->post('owner');
        $task_for = $this->input->post('task_for'); // Array of user IDs

        if (empty($task_for)) {
            redirect(base_url('conAdmin/tasks'));
            return;
        }

        // Handle "Select All" logic
        if (in_array('all', $task_for)) {
            $users = $this->auth_model->getUsers(); // Fetch all user IDs
            $task_for = array_column($users, 'id');
        }

        // Insert task for each selected user
        foreach ($task_for as $user_id) {
            $task_data = [
                'task_name' => $task_name,
                'owner' => $owner,
                'task_for' => $user_id,
                'status' => 'Not Started',
                'due_date' => $due_date,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->admin_model->createTask($task_data);
        }

        // Redirect to the dashboard
        redirect(base_url('conAdmin'));
    }



    public function rankingtask()
    {
        $data['rankings'] = $this->admin_model->getUserRankings();
        $data['users'] = $this->auth_model->getUsers(); // Fetch all users
        $data['notifications'] = $this->admin_model->getNotifications(); // Fetch notifications
        $this->load->view('adminHomepage/adminRankbyTask', $data);
    }
    public function deleteNotification($notification_id)
    {
        $result = $this->admin_model->deleteNotification($notification_id);
        if ($result) {
            $this->session->set_flashdata('success', 'Notification deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete notification.');
        }
        redirect(base_url('conAdmin'));
    }
    public function deleteAllNotifications()
    {
        $result = $this->admin_model->deleteAllNotifications();
        if ($result) {
            $this->session->set_flashdata('success', 'All notifications deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete all notifications.');
        }
        redirect(base_url('conAdmin'));
    }

    public function resetRankPoints()
    {
        $user_id = $this->input->post('user_id');

        if ($user_id === 'all') {
            // Reset points for all users
            $this->db->set('points', 0); // Set points to 0
            $result = $this->db->update('users'); // Update all users

            // Add notification
            $message = "Rank points reset to 0 for all users.";
            $this->admin_model->addNotification($message);
        } else {
            // Reset points for a specific user
            $this->db->set('points', 0); // Set points to 0
            $this->db->where('id', $user_id);
            $result = $this->db->update('users'); // Update the selected user

            // Add notification
            $user = $this->db->get_where('users', ['id' => $user_id])->row();
            $message = "Rank points reset to 0 for user: " . htmlspecialchars($user->username);
            $this->admin_model->addNotification($message);
        }

        if ($result) {
            $this->session->set_flashdata('success', 'Rank points reset successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to reset rank points.');
        }

        redirect(base_url('conAdmin')); // Reload rankings page
    }

    public function resetSpecificPoints()
    {
        $user_id = $this->input->post('user_id');
        $points_to_reset = $this->input->post('points_to_reset');

        if (empty($points_to_reset) || $points_to_reset <= 0) {
            $this->session->set_flashdata('error', 'Please specify a valid number of points to reset.');
            redirect(base_url('conAdmin')); // Redirect back to admin page
            return;
        }

        if ($user_id === 'all') {
            // Decrease points for all users
            $this->db->set('points', "GREATEST(points - $points_to_reset, 0)", FALSE);
            $result = $this->db->update('users');

            // Add notification
            $message = "Reduced $points_to_reset points for all users.";
            $this->admin_model->addNotification($message);

        } else {
            // Decrease points for a specific user
            $this->db->set('points', "GREATEST(points - $points_to_reset, 0)", FALSE);
            $this->db->where('id', $user_id);
            $result = $this->db->update('users');

            // Add notification
            $user = $this->db->get_where('users', ['id' => $user_id])->row();
            $message = "Reduced $points_to_reset points for user: " . htmlspecialchars($user->username);
            $this->admin_model->addNotification($message);
        }

        if ($result) {
            $this->session->set_flashdata('success', 'Points reset successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to reset points.');
        }

        redirect(base_url('conAdmin')); // Redirect back to admin page
    }


    public function addPointsToUser()
    {
        $user_id = $this->input->post('user_id');
        $points = $this->input->post('points');

        if (!empty($points)) {
            if ($user_id === 'all') {
                // Apply points to all users
                $this->db->set('points', 'points + ' . (int) $points, FALSE); // Increment points
                $result = $this->db->update('users'); // Update all users

                // Add notification
                $message = "Added $points points for all users.";
                $this->admin_model->addNotification($message);

            } else {
                // Apply points to a specific user
                $this->db->set('points', 'points + ' . (int) $points, FALSE); // Increment points
                $this->db->where('id', $user_id);
                $result = $this->db->update('users'); // Update the selected user

                // Add notification
                $user = $this->db->get_where('users', ['id' => $user_id])->row();
                $message = "Added $points points for user: " . htmlspecialchars($user->username);
                $this->admin_model->addNotification($message);
            }

            if ($result) {
                $this->session->set_flashdata('success', 'Points added successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to add points.');
            }
        } else {
            $this->session->set_flashdata('error', 'Points are required.');
        }

        redirect(base_url('conAdmin')); // Reload rankings page
    }

    //conadmin
    public function userDashboard()
    {
        // Retrieve user ID from session
        $user_id = $this->session->userdata('user_id');

        // Ensure user ID is available
        if (!$user_id) {
            show_error("User not logged in or session expired.", 403, "Access Denied");
            return;
        }

        // Fetch uploaded files for the logged-in user
        $uploaded_files = $this->db->get_where('userrequirements', ['user_id' => $user_id])->result_array();

        // Count the total number of uploaded, approved, and pending files
        $totalUploaded = count($uploaded_files);
        $pendingFiles = $this->db->where(['user_id' => $user_id, 'status' => 'pending'])->count_all_results('userrequirements');
        $approvedFiles = $this->db->where(['user_id' => $user_id, 'status' => 'approved'])->count_all_results('userrequirements');

        // Calculate progress (based on the approved files count)
        $progress = ($totalUploaded > 0) ? ($approvedFiles / $totalUploaded) * 100 : 0;

        // Fetch notifications for the user (unread notifications only)
        $notifications = $this->db->get_where('notifications', ['user_id' => $user_id, 'status' => 'unread'])->result_array();

        // Pass the data to the view
        $data['uploaded_files'] = $uploaded_files;
        $data['totalUploaded'] = $totalUploaded;
        $data['pendingFiles'] = $pendingFiles;
        $data['approvedFiles'] = $approvedFiles;
        $data['progress'] = $progress;
        $data['notifications'] = $notifications;

        // Load the view
        $this->load->view('Homepage/viewuserdashboard', $data);
    }


    // Generalized file upload function
    public function uploadFile($fileType, $directory)
    {
        $user_id = $this->session->userdata('user_id'); // Retrieve user ID from session

        if (!$user_id) {
            show_error("User not logged in.", 403, "Access Denied");
            return;
        }

        // Check file name length
        $fileName = $_FILES[$fileType]['name'];
        if (strlen($fileName) > 30) {
            echo json_encode(['status' => 'error', 'message' => 'File name exceeds the 30 character limit.']);
            return; // Exit if file name is too long
        }

        // Configure upload settings
        $config['upload_path'] = './uploads/' . $directory; // Dynamic upload path
        $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx'; // Allowed file types
        $config['max_size'] = 2048; // Maximum file size in KB (2MB)
        $config['file_name'] = time() . '_' . $fileName; // Unique file name

        // Load the upload library
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($fileType)) {
            // If upload fails, return the error in JSON format
            $error = $this->upload->display_errors();
            echo json_encode(['status' => 'error', 'message' => $error]);
        } else {
            // If upload succeeds, save file details in the database
            $fileData = $this->upload->data();
            $data = [
                'user_id' => $user_id,
                'file_name' => $fileData['file_name'],
                'file_path' => 'uploads/' . $directory . '/' . $fileData['file_name'],
                'file_type' => $directory, // File type corresponds to the directory (e.g., 'resume', 'sss', 'pagibig')
                'status' => 'pending', // Default status
                'uploaded_at' => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('userrequirements', $data);
            echo json_encode(['status' => 'success', 'message' => 'File uploaded successfully!']);
        }
    }


    // paths
    public function uploadGeneralFile()
    {
        $this->uploadFile('requirements_file', 'requirements');

    }


    public function uploadSSSFile()
    {
        $this->uploadFile('sss_file', 'sss_files');


    }

    public function uploadPagibigFile()
    {
        $this->uploadFile('pagibig_file', 'pagibig_files');

    }



    //! APPROVE DENY
    public function updateFileStatus()
    {
        $file_id = $this->input->post('file_id');
        $status = $this->input->post('status');

        if ($file_id && in_array($status, ['approved', 'denied'])) {
            // Update the file status
            $this->db->where('id', $file_id);
            $this->db->update('userrequirements', ['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);

            // Get the user who uploaded the file and the file type
            $file = $this->db->get_where('userrequirements', ['id' => $file_id])->row_array();
            $user_id = $file['user_id'];
            $file_type = $file['file_type']; // Get the file type from the database

            // Create a notification message
            $message = "Your " . ucfirst($file_type) . " file has been " . $status . "."; // Capitalize the file type for better readability

            // Insert the notification into the database
            $this->db->insert('notifications', [
                'user_id' => $user_id,
                'message' => $message,
                'status' => 'unread',
            ]);

            echo json_encode(['status' => 'success', 'message' => "File has been $status and notification sent."]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid input or action.']);
        }
    }




    public function deleteFile()
    {
        $file_id = $this->input->post('file_id');

        if ($file_id) {
            // Get file details to delete the physical file
            $file = $this->db->get_where('userrequirements', ['id' => $file_id])->row_array();
            if ($file) {
                $file_path = './' . $file['file_path'];
                if (file_exists($file_path)) {
                    unlink($file_path); // Delete the file from the server
                }

                // Delete the record from the database
                $this->db->where('id', $file_id);
                $this->db->delete('userrequirements');

                echo json_encode(['status' => 'success', 'message' => 'File has been deleted.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'File not found.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid file ID.']);
        }
    }

    public function requirementstatus()
    {
        // Retrieve user ID from the session
        $user_id = $this->session->userdata('user_id'); // Assuming user ID is stored in session

        // Ensure the user is logged in
        if (!$user_id) {
            show_error("User not logged in.", 403, "Access Denied");
            return;
        }

        // Fetch only the uploaded tasks for the current user
        $uploaded_tasks = $this->admin_model->getUploadedTasksByUser($user_id); // Modify to fetch tasks specific to the logged-in user

        // Map uploaded tasks to their corresponding statuses
        foreach ($uploaded_tasks as &$file) {
            $task = $this->admin_model->getTaskById($file['task_id']); // Assuming this method exists
            $file['status'] = $task['status'] ?? 'Unknown';
        }

        // Fetch the user's progress
        $users = $this->auth_model->getUsers(); // Assuming this function gets all users
        foreach ($users as &$user) {
            $userId = $user['id']; // Assuming you have an 'id' field for users
            $totalFiles = $this->db->where('user_id', $userId)->count_all_results('userrequirements');
            $approvedCount = $this->db->where(['user_id' => $userId, 'status' => 'approved'])->count_all_results('userrequirements');
            $user['progress'] = ($totalFiles > 0) ? ($approvedCount / $totalFiles) * 100 : 0; // Calculate progress
        }

        // Fetch the uploaded files for the logged-in user
        $uploaded_files = $this->db->get_where('userrequirements', ['user_id' => $user_id])->result_array();

        // Fetch notifications for the user (unread notifications only)
        $notifications = $this->db->get_where('notifications', ['user_id' => $user_id])->result_array();

        // Pass the data to the view
        $data['uploaded_tasks'] = $uploaded_tasks;
        $data['uploaded_files'] = $uploaded_files;
        $data['notifications'] = $notifications;
        $data['users'] = $users;  // Ensure $users is passed to the view

        // Load the view
        $this->load->view('Homepage/requirement_status', $data);
    }

    // Delete a specific notification by ID
    public function deleteRequirement_statusNotification($id)
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
            return;
        }

        $this->db->where(['id' => $id, 'user_id' => $user_id]);
        $this->db->delete('notifications');

        if ($this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Notification deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Notification not found or could not be deleted.']);
        }

    }
    public function deleteTaskbyUploadedTask($taskId)
    {
        // Ensure the user is logged in and has permission
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
            return;
        }

        // Verify that the task exists before attempting to delete it
        $this->db->where('id', $taskId);
        $query = $this->db->get('user_uploadedtask');

        if ($query->num_rows() == 0) {
            echo json_encode(['status' => 'error', 'message' => 'Task not found.']);
            return;
        }

        // Delete the task
        $this->db->where('id', $taskId);
        $this->db->delete('user_uploadedtask');

        if ($this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Task deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete task.']);
        }
    }

    // Delete all notifications for the logged-in user
    public function deleteAllRequirement_statusNotifications()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
            return;
        }

        $this->db->where('user_id', $user_id);
        $this->db->delete('notifications');

        if ($this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'All notifications deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No notifications to delete.']);
        }
    }




    public function userfiles()
    {
        $users = $this->auth_model->getUsers(); // Fetch total users
        $uploaded_files = $this->db->get('userrequirements')->result_array();
        $notifications = $this->admin_model->getNotifications(); // Fetch notifications

        $data['uploaded_files'] = $uploaded_files;
        $data['users'] = $users;
        $data['notifications'] = $notifications; // Pass notifications
        $this->load->view('adminHomepage/UserUploadedFiles', $data);
    }

    public function bulkUpdateFileStatus()
    {
        $file_ids = $this->input->post('file_ids');
        $status = $this->input->post('status');

        if ($file_ids && in_array($status, ['approved', 'denied'])) {
            $this->db->where_in('id', $file_ids);
            $this->db->update('userrequirements', ['status' => $status]);

            echo json_encode(['status' => 'success', 'message' => ucfirst($status) . ' all selected files.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
        }
    }

    public function bulkDeleteFiles()
    {
        $file_ids = $this->input->post('file_ids');

        if ($file_ids) {
            $this->db->where_in('id', $file_ids);
            $this->db->delete('userrequirements');

            echo json_encode(['status' => 'success', 'message' => 'Deleted all selected files.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No files selected for deletion.']);
        }
    }





}