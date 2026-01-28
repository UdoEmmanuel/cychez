<?php

namespace Config;

$routes = Services::routes();

if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// Public Routes
$routes->get('/', 'Home::index');
$routes->get('about', 'Home::about');
$routes->get('contact', 'Home::contact');
$routes->post('contact', 'Home::contactPost');
$routes->get('service', 'Home::service');
$routes->get('faqs', 'Home::faqs');
$routes->get('terms', 'Home::terms');

// Authentication Routes
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::loginPost');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::registerPost');
$routes->get('logout', 'Auth::logout');

// Shop Routes
$routes->get('shop', 'Shop::index');
$routes->get('shop/category/(:num)', 'Shop::category/$1');
$routes->get('product/(:num)', 'Shop::product/$1');
$routes->get('search', 'Shop::search');

// Cart Routes
$routes->get('cart', 'Cart::index');
$routes->post('cart/add', 'Cart::add');
$routes->post('cart/update', 'Cart::update');
$routes->post('cart/remove', 'Cart::remove');
$routes->get('cart/clear', 'Cart::clear');
$routes->get('cart/get-count', 'Cart::getCount');

// Wishlist Routes
$routes->get('wishlist', 'Wishlist::index', ['filter' => 'auth']);
$routes->post('wishlist/add', 'Wishlist::add', ['filter' => 'auth']);
$routes->post('wishlist/remove', 'Wishlist::remove', ['filter' => 'auth']);
$routes->get('wishlist/clear', 'Wishlist::clear', ['filter' => 'auth']);
$routes->get('wishlist/get-count', 'Wishlist::getCount'); // For AJAX count updates
$routes->post('wishlist/move-to-cart', 'Wishlist::moveToCart', ['filter' => 'auth']);

// Checkout Routes
$routes->get('checkout', 'Checkout::index', ['filter' => 'auth']);
$routes->post('checkout/process', 'Checkout::process', ['filter' => 'auth']);
$routes->post('checkout/getCities', 'Checkout::getCities', ['filter' => 'auth']);
$routes->post('checkout/getAreas', 'Checkout::getAreas', ['filter' => 'auth']);
$routes->post('checkout/previewShipping', 'Checkout::previewShipping', ['filter' => 'auth']);

// Payment Routes
$routes->post('payment/initialize', 'Payment::initialize', ['filter' => 'auth']);
$routes->get('payment/callback', 'Payment::callback');
$routes->get('payment/verify/(:segment)', 'Payment::verify/$1');

// Account Routes
$routes->group('account', ['filter' => 'auth'], function($routes) {
    // Main dashboard page
    $routes->get('/', 'Account::dashboard');
    
    // AJAX Tab Loading - MUST come before other routes
    $routes->get('tab/(:segment)', 'Account::tab/$1');
    
    // Order detail (specific route before general 'orders')
    $routes->get('order/(:num)', 'Account::orderDetail/$1');
    // AJAX Order view (specific route for viewing order in tab)
    $routes->get('view-order/(:num)', 'Account::viewOrder/$1');
    // POST routes for updates
    $routes->post('profile/update', 'Account::updateProfile');
    $routes->post('tracking/track', 'Account::trackOrder');
    $routes->post('wishlist/add', 'Account::addToWishlist');
    $routes->post('wishlist/remove', 'Account::removeFromWishlist');
});

// Admin Routes
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('dashboard', 'Admin\Dashboard::index');
    
    // Products
    $routes->get('products', 'Admin\Products::index');
    $routes->get('products/create', 'Admin\Products::create');
    $routes->post('products/store', 'Admin\Products::store');
    $routes->get('products/edit/(:num)', 'Admin\Products::edit/$1');
    $routes->post('products/update/(:num)', 'Admin\Products::update/$1');
    $routes->get('products/delete/(:num)', 'Admin\Products::delete/$1');
    
    // Orders
    $routes->get('orders', 'Admin\Orders::index');
    $routes->get('orders/view/(:num)', 'Admin\Orders::view/$1');
    $routes->post('orders/update-status', 'Admin\Orders::updateStatus');
    
    // Shipping Zones
    $routes->get('shipping-zones', 'Admin\ShippingZones::index');
    $routes->get('shipping-zones/create', 'Admin\ShippingZones::create');
    $routes->post('shipping-zones/store', 'Admin\ShippingZones::store');
    $routes->get('shipping-zones/edit/(:num)', 'Admin\ShippingZones::edit/$1');
    $routes->post('shipping-zones/update/(:num)', 'Admin\ShippingZones::update/$1');
    $routes->get('shipping-zones/delete/(:num)', 'Admin\ShippingZones::delete/$1');
    $routes->get('shipping-zones/view/(:num)', 'Admin\ShippingZones::view/$1');
    $routes->get('shipping-zones/toggle-active/(:num)', 'Admin\ShippingZones::toggleActive/$1');
    $routes->post('shipping-zones/update-fee', 'Admin\ShippingZones::updateFee');
    
    // Shipping Locations
    $routes->get('shipping-zones/(:num)/locations', 'Admin\ShippingLocations::index/$1');
    $routes->get('shipping-zones/(:num)/locations/create', 'Admin\ShippingLocations::create/$1');
    $routes->post('shipping-zones/(:num)/locations/store', 'Admin\ShippingLocations::store/$1');
    $routes->get('shipping-zones/(:num)/locations/(:num)/delete', 'Admin\ShippingLocations::delete/$1/$2');
    $routes->get('shipping-zones/(:num)/locations/bulk-create', 'Admin\ShippingLocations::bulkCreate/$1');
    $routes->post('shipping-zones/(:num)/locations/bulk-store', 'Admin\ShippingLocations::bulkStore/$1');
}); 

// Thank You Page
$routes->get('thank-you', 'Home::thankyou');

$routes->set404Override(function () {
    echo view('pages/404');
});


if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}