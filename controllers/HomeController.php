<?php
require_once __DIR__ . '/../models/ProductModel.php';

class HomeController
{
    public function index()
    {
        $featured = Product::getFeatured(4); // 
        $latest = Product::getLatestProduct(4); // 
        $favorite = Product::getFavoriteProduct(4); //
        require 'views/home/index.php';
    }
}
