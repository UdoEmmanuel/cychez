<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'compare_price',
        'cost_price',
        'stock_quantity',
        'sku',
        'image',
        'images',
        'is_featured',
        'is_active',
        'meta_title',
        'meta_description',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getActiveProducts($limit = null)
    {
        $builder = $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->where('products.is_active', 1);

        if ($limit) {
            $builder->limit($limit);
        }

        return $builder->findAll();
    }

    public function getFeaturedProducts($limit = 8)
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->where('products.is_active', 1)
            ->where('products.is_featured', 1)
            ->limit($limit)
            ->findAll();
    }

    public function getProductsByCategory($categoryId, $limit = null)
    {
        $builder = $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->where('products.category_id', $categoryId)
            ->where('products.is_active', 1);

        if ($limit) {
            $builder->limit($limit);
        }

        return $builder->findAll();
    }

    public function searchProducts($keyword)
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->where('products.is_active', 1)
            ->groupStart()
                ->like('products.name', $keyword)
                ->orLike('products.description', $keyword)
                ->orLike('categories.name', $keyword)
            ->groupEnd()
            ->findAll();
    }

    public function getProductWithCategory($id)
    {
        return $this->select('products.*, categories.name as category_name, categories.slug as category_slug')
            ->join('categories', 'categories.id = products.category_id')
            ->where('products.id', $id)
            ->first();
    }

    public function getLowStockProducts($threshold = 10)
    {
        return $this->where('stock_quantity <=', $threshold)
            ->where('is_active', 1)
            ->findAll();
    }

    public function reduceStock($productId, $quantity)
    {
        $product = $this->find($productId);
        if ($product && $product['stock_quantity'] >= $quantity) {
            $newQuantity = $product['stock_quantity'] - $quantity;
            return $this->update($productId, ['stock_quantity' => $newQuantity]);
        }
        return false;
    }
}