<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class Shop extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $perPage = 12;
        $products = $productModel->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->where('products.is_active', 1)
            ->paginate($perPage);

        $data = [
            'title'      => 'Shop - Cychez Store',
            'products'   => $products,
            'pager'      => $productModel->pager,
            'categories' => $categoryModel->getActiveCategories(),
            'shopHeader' => true,
        ];

        return view('shop/index', $data);
    }

    public function category($categoryId)
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $category = $categoryModel->find($categoryId);

        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $perPage = 12;
        $products = $productModel->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->where('products.category_id', $categoryId)
            ->where('products.is_active', 1)
            ->paginate($perPage);

        $data = [
            'title'      => $category['name'] . ' - Cychez Store',
            'category'   => $category,
            'products'   => $products,
            'pager'      => $productModel->pager,
            'categories' => $categoryModel->getActiveCategories(),
            'shopHeader' => true,
        ];

        return view('shop/index', $data);
    }

    public function product($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->getProductWithCategory($id);

        if (!$product || !$product['is_active']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $relatedProducts = $productModel->getProductsByCategory($product['category_id'], 4);

        $data = [
            'title'           => $product['name'] . ' - Cychez Store',
            'product'         => $product,
            'relatedProducts' => $relatedProducts,
            'shopHeader' => true,
        ];

        return view('shop/product', $data);
    }

    public function search()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $keyword = $this->request->getGet('q');

        if (empty($keyword)) {
            return redirect()->to('/shop');
        }

        $products = $productModel->searchProducts($keyword);

        $data = [
            'title'      => 'Search Results for "' . $keyword . '" - Cychez Store',
            'products'   => $products,
            'keyword'    => $keyword,
            'categories' => $categoryModel->getActiveCategories(),
            'shopHeader' => true,
        ];

        return view('shop/index', $data);
    }
}