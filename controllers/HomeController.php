<?php
require_once __DIR__ . '/../models/ProductModel.php';

class HomeController
{
    public function index()
    {
        $featured = Product::getFeatured(6); // ✅ gọi model, không phải ProductController
        require 'views/home/index.php';
    }
}
