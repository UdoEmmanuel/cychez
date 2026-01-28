<?php

namespace App\Controllers;

use App\Models\OrderModel;

class Payment extends BaseController
{
    public function initialize()
    {
        $orderId = session()->get('pending_order_id');

        if (!$orderId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No pending order found',
            ]);
        }

        $orderModel = new OrderModel();
        $order = $orderModel->find($orderId);

        if (!$order) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Order not found',
            ]);
        }

        $paystackSecretKey = env('paystack.secretKey');
        $amount = $order['total_amount'] * 100; // Total now includes shipping

        $url = "https://api.paystack.co/transaction/initialize";

        $fields = [
            'email'     => $order['email'],
            'amount'    => $amount,
            'reference' => $order['order_number'],
            'callback_url' => env('paystack.callbackUrl', base_url('payment/callback')),
            'metadata'  => json_encode([
                'order_id' => $order['id'],
                'order_number' => $order['order_number'],
                'cart_total' => $order['total_amount'] - $order['shipping_fee'],
                'shipping_fee' => $order['shipping_fee'],
            ]),
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $paystackSecretKey,
            "Content-Type: application/json",
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if ($result && $result['status']) {
            $orderModel->update($order['id'], [
                'payment_reference' => $order['order_number'],
            ]);

            return $this->response->setJSON([
                'success'          => true,
                'authorization_url' => $result['data']['authorization_url'],
                'access_code'      => $result['data']['access_code'],
                'reference'        => $result['data']['reference'],
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to initialize payment',
        ]);
    }

    public function callback()
    {
        $reference = $this->request->getGet('reference');

        if (!$reference) {
            session()->setFlashdata('error', 'Invalid payment reference');
            return redirect()->to('/cart');
        }

        return redirect()->to('/payment/verify/' . $reference);
    }

    public function verify($reference)
    {
        $paystackSecretKey = env('paystack.secretKey');
        $url = "https://api.paystack.co/transaction/verify/" . $reference;

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$paystackSecretKey}",
            ],
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (!$result || !$result['status'] || $result['data']['status'] !== 'success') {
            session()->setFlashdata('error', 'Payment verification failed.');
            return redirect()->to('/cart');
        }

        $orderModel = new OrderModel();
        $order = $orderModel->findByPaymentReference($reference);

        if (!$order) {
            session()->setFlashdata('error', 'Order not found.');
            return redirect()->to('/');
        }

        // Idempotency check (VERY IMPORTANT)
        if ($order['payment_status'] === 'paid') {
            return redirect()->to('/thank-you?order=' . $order['order_number']);
        }

        // Update order
        $orderModel->update($order['id'], [
            'payment_status'  => 'paid',
            'delivery_status' => 'processing',
        ]);

        // Refresh order
        $order = $orderModel->find($order['id']);

        // Attach shipping info from session (for email views)
        if ($shippingData = session()->get('pending_order_shipping')) {
            $order['is_riverine'] = $shippingData['is_riverine'] ?? false;
            $order['shipping_zone_name'] = $shippingData['zone_name'] ?? '';
        }

        // Send emails via service ✅
        $emailService = service('orderEmail');
        $emailService->send($order);

        // Cleanup
        helper('cart');
        clear_cart();

        session()->remove(['pending_order_id', 'pending_order_shipping']);

        session()->setFlashdata('success', 'Payment successful! Your order has been confirmed.');
        return redirect()->to('/thank-you?order=' . $order['order_number']);
    }
}