<?php

namespace App\Services;

use App\Models\OrderModel;
use Config\Services;

class OrderEmailService
{
    protected $email;
    protected $orderModel;

    public function __construct()
    {
        $this->email = Services::email();
        $this->orderModel = new OrderModel();
    }

    /**
     * Send customer + admin order emails (safe to call multiple times)
     */
    public function send(array $order): bool
    {
        // Prevent duplicate sending
        if (!empty($order['email_sent_at'])) {
            return true;
        }

        $fromEmail = env('email.fromEmail');
        $fromName  = env('email.fromName');

        /**
         * =========================
         * Customer email
         * =========================
         */
        $this->email->clear();
        $this->email->setFrom($fromEmail, $fromName);
        $this->email->setTo($order['email']);
        $this->email->setSubject('Order Confirmation - ' . $order['order_number']);
        $this->email->setMessage(
            view('emails/order_confirmation', ['order' => $order])
        );

        if (!$this->email->send()) {
            log_message('error', 'Customer order email failed: ' . $this->email->printDebugger(['headers']));
            return false;
        }

        /**
         * =========================
         * Admin email
         * =========================
         */
        $this->email->clear();
        $this->email->setFrom($fromEmail, $fromName);
        $this->email->setTo(env('site.adminEmail'));
        $this->email->setSubject('New Order - ' . $order['order_number']);
        $this->email->setMessage(
            view('emails/admin_order_notification', ['order' => $order])
        );

        if (!$this->email->send()) {
            log_message('error', 'Admin order email failed: ' . $this->email->printDebugger(['headers']));
            return false;
        }

        // Mark email as sent
        $this->orderModel->update($order['id'], [
            'email_sent_at' => date('Y-m-d H:i:s'),
        ]);

        return true;
    }
}
