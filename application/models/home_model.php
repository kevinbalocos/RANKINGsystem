<?php
defined('BASEPATH') or exit('No direct script access allowed');

class home_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
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

    //PRODUCTS TO GET ORDER
    //PRODUCTS TO GET ORDER
    //PRODUCTS TO GET ORDER

    public function getProducts()
    {

        $query = $this->db->get('products');
        return $query->result_array();
    }

    public function getProductDetails($productId)
    {

        $query = $this->db->get_where('products', ['product_id' => $productId]);
        return $query->row_array();
    }

    public function saveOrder($user_id, $productId, $product_name, $quantity)
    {
        $product = $this->getProductDetails($productId);

        if (!$product) {
            return false;
        }

        $totalPrice = $product['price'] * $quantity;

        date_default_timezone_set('Asia/Manila');

        $data = [
            'user_id' => $user_id,
            'product_name' => $product_name,
            'product_id' => $productId,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'order_date' => date('Y-m-d h:i:s A'),
            'status' => 'Pending',
        ];

        // Inside saveOrder function
        $this->db->insert('usersorder', $data);

        // Fetch the inserted order_id
        $order_id = $this->db->insert_id();

        // Log client action with the correct order_id
        $this->logClientAction('buy', $order_id);
    }









    //STOCKS
    //STOCKS
    //STOCKS

    public function updateStocksProducts($productId, $quantity)
    {
        $product = $this->getProductDetails($productId);

        if ($product) {
            $itemSold = $product['item_sold'] + $quantity;

            $this->db->where('product_id', $productId);
            $this->db->update('products', ['item_sold' => $itemSold]);

            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }
    public function deductStock($productId, $quantity)
    {
        $product = $this->getProductDetails($productId);

        if ($product) {
            $newStock = $product['stock'] - $quantity;

            $this->db->where('product_id', $productId);
            $this->db->update('products', ['stock' => $newStock]);

            return $this->db->affected_rows() > 0;
        }

        return false;
    }



    //! CLIENTS ORDERS

    public function getCustomerOrders($user_id)
    {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('usersorder');
        return $query->result_array();
    }
    public function getOrderDetails($orderId)
    {
        $query = $this->db->get_where('usersorder', ['order_id' => $orderId]);
        return $query->row_array();
    }

    public function deleteOrder($orderId)
    {

        $this->db->where('order_id', $orderId);
        $this->db->delete('usersorder');


        $this->logClientAction('delete', $orderId);

    }




    //! CLIENT NOTIFICATIONS
    public function getRecentClientActions()
    {
        $this->db->order_by('created_at', 'desc');
        $this->db->limit(10); // Changable limit 
        $query = $this->db->get('client_notifications');
        return $query->result_array();
    }

    private function logClientAction($action, $orderId)
    {
        $orderDetails = $this->getOrderDetails($orderId);
        $productName = $orderDetails['product_name'];

        $data = [
            'action' => $action,
            'order_id' => $orderId,
            'product_name' => $productName,
        ];

        $this->db->insert('client_notifications', $data);
    }


 






}

