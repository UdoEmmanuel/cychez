<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class Home extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $data = [
            'title'             => 'Home - Cychez Store',
            'site_name'         => 'CYCHEZ',
            'featuredProducts'  => $productModel->getFeaturedProducts(8),
            'categories'        => $categoryModel->getActiveCategories(),
            
            // Empty arrays for sections not yet implemented
            'sliders'           => [],
            'featuredCategory'  => null,
            'banners'           => [],
            'features'          => [],
            'testimonials'      => [],
            'socialFeeds'       => [],
        ];

        return view('home/index', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About Us - Cychez Store',
        ];

        return view('pages/about', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Contact Us - Cychez Store',
        ];

        return view('pages/contact', $data);
    }

    public function contactPost()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name'  => 'required|min_length[2]|max_length[50]',
            'email'      => 'required|valid_email',
            'phone'      => 'required|min_length[10]|max_length[20]',
            'subject'    => 'required|min_length[3]|max_length[200]',
            'message'    => 'required|min_length[10]|max_length[1000]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Get form data
        $firstName = $this->request->getPost('first_name');
        $lastName = $this->request->getPost('last_name');
        $email = $this->request->getPost('email');
        $phone = $this->request->getPost('phone');
        $subject = $this->request->getPost('subject');
        $message = $this->request->getPost('message');

        try {
            // Prepare email
            $emailService = \Config\Services::email();

            // Clear any previous settings
            $emailService->clear();

            // Set recipient (your company email from env)
            $adminEmail = env('site.adminEmail', 'cychezbeauty@gmail.com');
            $emailService->setTo($adminEmail);
            
            // Set sender (your configured email, not customer's)
            $emailService->setFrom(
                env('email.fromEmail', 'udoemmanuel888@gmail.com'),
                env('email.fromName', 'Cychez Store')
            );
            
            // Set reply-to (customer's email so you can reply directly)
            $emailService->setReplyTo($email, $firstName . ' ' . $lastName);
            
            // Set subject
            $emailService->setSubject('Contact Form: ' . $subject);
            
            // Create email body with HTML
            $emailBody = view('emails/contact_email', [
                'first_name' => $firstName,
                'last_name'  => $lastName,
                'email'      => $email,
                'phone'      => $phone,
                'subject'    => $subject,
                'message'    => $message
            ]);
            
            $emailService->setMessage($emailBody);

            // Send email
            if ($emailService->send()) {
                return redirect()->to('/contact')->with('success', 'Thank you for contacting us! We will get back to you soon.');
            } else {
                // Log the error for debugging
                log_message('error', 'Email send failed: ' . $emailService->printDebugger(['headers']));
                
                return redirect()->back()->withInput()->with('error', 'Failed to send message. Please try again or contact us directly at ' . $adminEmail);
            }
        } catch (\Exception $e) {
            // Log the exception
            log_message('error', 'Email exception: ' . $e->getMessage());
            
            return redirect()->back()->withInput()->with('error', 'An error occurred. Please try again later.');
        }
    }

    public function service()
    {
        $data = [
            'title' => 'Our Services - Cychez Store',
        ];

        return view('pages/service', $data);
    }

    public function faqs()
    {
        $data = [
            'title' => 'FAQs - Cychez Store',
        ];

        return view('pages/faqs', $data);
    }

    public function terms()
    {
        $data = [
            'title' => 'Terms of Use - Cychez Store',
        ];

        return view('pages/terms', $data);
    }

    public function thankyou()
    {
        // Get order number from query string
        $orderNumber = $this->request->getGet('order');
        
        if (!$orderNumber) {
            session()->setFlashdata('error', 'Invalid order reference');
            return redirect()->to('/');
        }

        $orderModel = new OrderModel();
        $order = $orderModel->findByOrderNumber($orderNumber);

        if (!$order) {
            session()->setFlashdata('error', 'Order not found');
            return redirect()->to('/');
        }

        // Verify this order belongs to the logged-in user (security check)
        if ($order['user_id'] != session()->get('user_id')) {
            session()->setFlashdata('error', 'Unauthorized access');
            return redirect()->to('/');
        }

        // Get order items with product details
        $orderItemModel = new OrderItemModel();
        $order['items'] = $orderItemModel->getOrderItems($order['id']);

        $data = [
            'title' => 'Thank You - Order Confirmed',
            'order' => $order,
        ];

        return view('pages/thankyou', $data);
    }
}