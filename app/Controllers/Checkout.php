<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ProductModel;
use App\Models\ShippingZoneModel;
use App\Models\ShippingLocationModel;
use App\Services\ShippingService;

class Checkout extends BaseController
{
    protected $shippingService;
    protected $shippingZoneModel;
    protected $shippingLocationModel;

    public function __construct()
    {
        $this->shippingService = new ShippingService();
        $this->shippingZoneModel = new ShippingZoneModel();
        $this->shippingLocationModel = new ShippingLocationModel();
    }

    public function index()
    {
        helper('cart');

        $cart = get_cart();

        if (empty($cart)) {
            session()->setFlashdata('error', 'Your cart is empty');
            return redirect()->to('/cart');
        }

        $user = session()->get();

        // Get distinct states from shipping_locations using raw query
        $db = \Config\Database::connect();
        $query = $db->query("
            SELECT DISTINCT sl.state
            FROM shipping_locations sl
            INNER JOIN shipping_zones sz ON sz.id = sl.zone_id
            WHERE sz.is_active = 1
            AND sl.state IS NOT NULL
            AND sl.state != ''
            ORDER BY sl.state ASC
        ");

        $results = $query->getResultArray();

        $statesList = [];
        foreach ($results as $row) {
            $statesList[$row['state']] = $row['state'];
        }

        $data = [
            'title' => 'Checkout - Cychez Store',
            'cart'  => $cart,
            'user'  => $user,
            'shopHeader' => true,
            'states' => $statesList,
        ];

        return view('checkout/index', $data);
    }

    /**
     * AJAX endpoint to get cities by state
     */
    public function getCities()
    {
        // Set JSON header first
        $this->response->setContentType('application/json');

        // Validate request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request',
            ]);
        }

        $state = $this->request->getPost('state');
        
        if (!$state) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'State is required',
            ]);
        }

        try {
            $db = \Config\Database::connect();
            
            // Use raw query - CodeIgniter 4 doesn't have whereNotNull()
            $query = $db->query("
                SELECT DISTINCT sl.city
                FROM shipping_locations sl
                INNER JOIN shipping_zones sz ON sz.id = sl.zone_id
                WHERE sz.is_active = 1
                AND sl.state = ?
                AND sl.city IS NOT NULL
                AND sl.city != ''
                ORDER BY sl.city ASC
            ", [$state]);

            $results = $query->getResultArray();

            if (empty($results)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No delivery locations available for this state. Please contact us.',
                ]);
            }

            // Extract city names into simple array
            $citiesList = [];
            foreach ($results as $row) {
                if (!empty($row['city'])) {
                    $citiesList[] = $row['city'];
                }
            }

            // Remove any duplicates and reindex
            $citiesList = array_values(array_unique($citiesList));

            return $this->response->setJSON([
                'success' => true,
                'cities' => $citiesList,
            ]);

        } catch (\Exception $e) {
            log_message('error', 'getCities error: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred while loading cities',
                'error' => ENVIRONMENT === 'development' ? $e->getMessage() : null
            ]);
        }
    }

    /**
     * AJAX endpoint to get areas by city
     */
    public function getAreas()
    {
        $this->response->setContentType('application/json');

        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request',
            ]);
        }

        $state = $this->request->getPost('state');
        $city = $this->request->getPost('city');
        
        if (!$state || !$city) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'State and city are required',
            ]);
        }

        try {
            $db = \Config\Database::connect();
            
            $query = $db->query("
                SELECT DISTINCT sl.area
                FROM shipping_locations sl
                INNER JOIN shipping_zones sz ON sz.id = sl.zone_id
                WHERE sz.is_active = 1
                AND sl.state = ?
                AND sl.city = ?
                AND sl.area IS NOT NULL
                AND sl.area != ''
                ORDER BY sl.area ASC
            ", [$state, $city]);

            $results = $query->getResultArray();

            $areasList = [];
            foreach ($results as $row) {
                if (!empty($row['area'])) {
                    $areasList[] = $row['area'];
                }
            }

            $areasList = array_values(array_unique($areasList));

            return $this->response->setJSON([
                'success' => true,
                'areas' => $areasList,
            ]);

        } catch (\Exception $e) {
            log_message('error', 'getAreas error: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred while loading areas',
            ]);
        }
    }

    /**
     * AJAX endpoint to preview shipping fee
     */
    public function previewShipping()
    {
        $this->response->setContentType('application/json');

        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request',
            ]);
        }

        $state = $this->request->getPost('state');
        $city = $this->request->getPost('city');
        $area = $this->request->getPost('area');

        if (!$state || !$city) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'State and city are required',
            ]);
        }

        // Calculate shipping
        $shippingData = $this->shippingService->calculateShippingFee($state, $city, $area);
        
        if (!$shippingData) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Shipping not available for this location',
            ]);
        }
        
        helper('cart');
        $cartTotal = get_cart_total();
        $totalAmount = $cartTotal + $shippingData['fee'];

        return $this->response->setJSON([
            'success' => true,
            'shipping_fee' => $shippingData['fee'],
            'zone_name' => $shippingData['zone_name'],
            'zone_id' => $shippingData['zone_id'],
            'is_riverine' => $shippingData['is_riverine'] ?? false,
            'requires_confirmation' => $shippingData['requires_confirmation'] ?? false,
            'cart_total' => $cartTotal,
            'total_amount' => $totalAmount,
            'formatted_shipping' => '₦' . number_format($shippingData['fee'], 2),
            'formatted_total' => '₦' . number_format($totalAmount, 2),
        ]);
    }

    public function process()
    {
        $this->response->setContentType('application/json');

        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request',
            ]);
        }

        helper('cart');

        $cart = get_cart();

        if (empty($cart)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Your cart is empty',
            ]);
        }

        $validation = \Config\Services::validation();

        $rules = [
            'first_name' => 'required|min_length[2]',
            'last_name'  => 'required|min_length[2]',
            'email'      => 'required|valid_email',
            'phone'      => 'required|min_length[10]',
            'address'    => 'required|min_length[10]',
            'city'       => 'required',
            'state'      => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please fill all required fields correctly',
                'errors'  => $validation->getErrors(),
            ]);
        }

        // Calculate shipping fee
        $state = $this->request->getPost('state');
        $city = $this->request->getPost('city');
        $area = $this->request->getPost('area');

        $shippingData = $this->shippingService->calculateShippingFee($state, $city, $area);
        
        if (!$shippingData) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Shipping is not available for the selected location',
            ]);
        }
        
        $cartTotal = get_cart_total();
        $shippingFee = $shippingData['fee'];
        $totalAmount = $cartTotal + $shippingFee;

        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();
        $productModel = new ProductModel();

        $db = \Config\Database::connect();
        $db->transStart();

        $orderData = [
            'user_id'       => session()->get('user_id'),
            'order_number'  => $orderModel->generateOrderNumber(),
            'total_amount'  => $totalAmount,
            'shipping_fee'  => $shippingFee,
            'shipping_zone_id' => $shippingData['zone_id'],
            'payment_method' => 'paystack',
            'payment_status' => 'pending',
            'delivery_status' => 'pending',
            'first_name'    => $this->request->getPost('first_name'),
            'last_name'     => $this->request->getPost('last_name'),
            'email'         => $this->request->getPost('email'),
            'phone'         => $this->request->getPost('phone'),
            'address'       => $this->request->getPost('address'),
            'city'          => $city,
            'state'         => $state,
            'country'       => 'Nigeria',
            'postal_code'   => $this->request->getPost('postal_code'),
            'notes'         => $this->request->getPost('notes'),
        ];

        $orderId = $orderModel->insert($orderData);

        if (!$orderId) {
            $db->transRollback();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to create order',
            ]);
        }

        // Reduce stock for each product
        foreach ($cart as $item) {
            if (!$productModel->reduceStock($item['id'], $item['quantity'])) {
                $db->transRollback();
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Insufficient stock for ' . $item['name'],
                ]);
            }
        }

        // Create order items
        $orderItemModel->createOrderItems($orderId, $cart);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to process order',
            ]);
        }

        // Store order ID in session for payment
        session()->set([
            'pending_order_id' => $orderId,
            'pending_order_shipping' => [
                'zone_name' => $shippingData['zone_name'],
                'is_riverine' => $shippingData['is_riverine'] ?? false,
            ],
        ]);

        // Send riverine notification if applicable
        if (!empty($shippingData['is_riverine'])) {
            $order = $orderModel->find($orderId);
            $order['is_riverine'] = true;
            $order['shipping_zone_name'] = $shippingData['zone_name'];
            $this->shippingService->sendRiverineOrderNotification($order);
        }

        return $this->response->setJSON([
            'success'  => true,
            'message'  => 'Order created successfully',
            'order_id' => $orderId,
        ]);
    }
}