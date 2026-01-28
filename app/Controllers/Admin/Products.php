<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use Config\Services;

class Products extends BaseController
{
    private string $productImagePath = 'assets/uploads/products/';

    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $perPage = 20;
        
        // Get search and filter parameters
        $search = $this->request->getGet('search');
        $categoryFilter = $this->request->getGet('category');
        $statusFilter = $this->request->getGet('status');
        $stockFilter = $this->request->getGet('stock');

        // Start building query
        $builder = $productModel->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id');

        // Apply search
        if ($search) {
            $builder->groupStart()
                ->like('products.name', $search)
                ->orLike('products.sku', $search)
                ->orLike('products.description', $search)
                ->groupEnd();
        }

        // Apply category filter
        if ($categoryFilter && $categoryFilter !== '') {
            $builder->where('products.category_id', $categoryFilter);
        }

        // Apply status filter
        if ($statusFilter !== null && $statusFilter !== '') {
            $builder->where('products.is_active', $statusFilter);
        }

        // Apply stock filter
        if ($stockFilter) {
            if ($stockFilter === 'low') {
                $builder->where('products.stock_quantity <=', 10);
                $builder->where('products.stock_quantity >', 0);
            } elseif ($stockFilter === 'out') {
                $builder->where('products.stock_quantity', 0);
            } elseif ($stockFilter === 'in') {
                $builder->where('products.stock_quantity >', 10);
            }
        }

        $products = $builder->paginate($perPage);

        $data = [
            'title'      => 'Products - Admin',
            'products'   => $products,
            'pager'      => $productModel->pager,
            'categories' => $categoryModel->findAll(),
            'filters'    => [
                'search'   => $search,
                'category' => $categoryFilter,
                'status'   => $statusFilter,
                'stock'    => $stockFilter,
            ],
        ];

        return view('admin/products/index', $data);
    }

    public function create()
    {
        $categoryModel = new CategoryModel();

        $data = [
            'title'      => 'Add Product - Admin',
            'categories' => $categoryModel->getActiveCategories(),
        ];

        return view('admin/products/create', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'name'           => 'required|min_length[3]|max_length[255]',
            'category_id'    => 'required|numeric',
            'price'          => 'required|decimal',
            'stock_quantity' => 'required|numeric',
            'image'          => 'uploaded[image]|max_size[image,4096]|is_image[image]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $productModel = new ProductModel();

        $image = $this->request->getFile('image');
        $imageName = null;

        if ($image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $fullPath = FCPATH . $this->productImagePath . $imageName;

            Services::image()
                ->withFile($image)
                ->resize(900, 900, true)
                ->save($fullPath, 75);
        }

        $slug = url_title($this->request->getPost('name'), '-', true);

        $productData = [
            'category_id'      => $this->request->getPost('category_id'),
            'name'             => $this->request->getPost('name'),
            'slug'             => $slug,
            'description'      => $this->request->getPost('description'),
            'price'            => $this->request->getPost('price'),
            'compare_price'    => $this->request->getPost('compare_price'),
            'cost_price'       => $this->request->getPost('cost_price'),
            'stock_quantity'   => $this->request->getPost('stock_quantity'),
            'sku'              => $this->request->getPost('sku'),
            'image'            => $imageName,
            'is_featured'      => $this->request->getPost('is_featured') ? 1 : 0,
            'is_active'        => $this->request->getPost('is_active') ? 1 : 0,
            'meta_title'       => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
        ];

        if ($productModel->insert($productData)) {
            session()->setFlashdata('toast', [
                'type' => 'success',
                'message' => 'Product added successfully'
            ]);
            return redirect()->to('/admin/products');
        }

        session()->setFlashdata('toast', [
            'type' => 'error',
            'message' => 'Failed to add product'
        ]);

        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $product = $productModel->find($id);

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'      => 'Edit Product - Admin',
            'product'    => $product,
            'categories' => $categoryModel->getActiveCategories(),
        ];

        return view('admin/products/edit', $data);
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();

        $rules = [
            'name'           => 'required|min_length[3]|max_length[255]',
            'category_id'    => 'required|numeric',
            'price'          => 'required|decimal',
            'stock_quantity' => 'required|numeric',
        ];

        if ($this->request->getFile('image')->isValid()) {
            $rules['image'] = 'max_size[image,4096]|is_image[image]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $imageName = $product['image'];
        $image = $this->request->getFile('image');

        if ($image->isValid() && !$image->hasMoved()) {

            if ($imageName && file_exists(FCPATH . $this->productImagePath . $imageName)) {
                unlink(FCPATH . $this->productImagePath . $imageName);
            }

            $imageName = $image->getRandomName();
            $fullPath = FCPATH . $this->productImagePath . $imageName;

            Services::image()
                ->withFile($image)
                ->resize(900, 900, true)
                ->save($fullPath, 75);
        }

        $slug = url_title($this->request->getPost('name'), '-', true);

        $productData = [
            'category_id'      => $this->request->getPost('category_id'),
            'name'             => $this->request->getPost('name'),
            'slug'             => $slug,
            'description'      => $this->request->getPost('description'),
            'price'            => $this->request->getPost('price'),
            'compare_price'    => $this->request->getPost('compare_price'),
            'cost_price'       => $this->request->getPost('cost_price'),
            'stock_quantity'   => $this->request->getPost('stock_quantity'),
            'sku'              => $this->request->getPost('sku'),
            'image'            => $imageName,
            'is_featured'      => $this->request->getPost('is_featured') ? 1 : 0,
            'is_active'        => $this->request->getPost('is_active') ? 1 : 0,
            'meta_title'       => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
        ];

        if ($productModel->update($id, $productData)) {
            session()->setFlashdata('toast', [
                'type' => 'success',
                'message' => 'Product updated successfully'
            ]);
            return redirect()->to('/admin/products');
        }

        session()->setFlashdata('toast', [
            'type' => 'error',
            'message' => 'Failed to update product'
        ]);

        return redirect()->back()->withInput();
    }

    public function delete($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if (!$product) {
            session()->setFlashdata('error', 'Product not found');
            return redirect()->to('/admin/products');
        }

        if ($product['image'] && file_exists(FCPATH . 'assets/uploads/products/' . $product['image'])) {
            unlink(FCPATH . 'assets/uploads/products/' . $product['image']);
        }

        if ($productModel->delete($id)) {
            session()->setFlashdata('success', 'Product deleted successfully');
        } else {
            session()->setFlashdata('error', 'Failed to delete product');
        }

        return redirect()->to('/admin/products');
    }
}