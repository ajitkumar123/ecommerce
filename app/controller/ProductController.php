<?php
/**
 * Created by PhpStorm.
 * User: ajit
 * Date: 5/5/16
 * Time: 12:04 AM
 */
include_once 'Controller.php';
include_once 'app/model/Product.php';
class ProductController extends Controller{
    public function __construct()
    {
        $productModel = new Product();
        $category = [];
        $subcategory = [];
        $brand = [];
        $range = '';
        $q = '';
        $stock = false;
        if(isset($_GET['category']) && !empty($_GET['category'])){
            $category = urldecode($_GET['category']);
        }
        if(isset($_GET['subcategory']) && !empty($_GET['subcategory'])){
            $subcategory = explode('-',urldecode($_GET['subcategory']));
        }
        if(isset($_GET['brands']) && !empty($_GET['brands'])){
            $brand = explode('-',urldecode($_GET['brands']));
        }
        if(isset($_GET['range']) && !empty($_GET['range'])){
            $range = urldecode($_GET['range']);
        }
        if(isset($_GET['q']) && !empty($_GET['q'])){
            $q = urldecode($_GET['q']);
        }
        if(isset($_GET['stock']) && $_GET['stock'] == 'yes'){
            $stock = urldecode($_GET['stock']);
        }
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;

        $data['list'] = $productModel->fetchData($q, $category, $subcategory, $brand, $range, $stock, $data['page']);
        $data['total'] = $productModel->getTotalCount();
        $data['filter']['category'] = $productModel->categoryFilter();
        if(!empty($category)) {
            $data['filter']['subcategory'] = $productModel->subcategoryFilter($category);
            if(!empty($subcategory))
                $data['filter']['brands'] = $productModel->brandFilter($category, $subcategory);
            else
                $data['filter']['brands'] = $productModel->brandFilter($category);
        }



        $data['current_url'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        if(!empty($category)){
            $data['selected_params']['category'] = $category;
        }
        if(!empty($subcategory)){
            $data['selected_params']['subcategory'] = $subcategory;
        }
        if(!empty($brand)){
            $data['selected_params']['brands'] = $brand;
        }
        if(!empty($stock) && $stock == 'yes'){
            $data['selected_params']['stock'] = true;
        }
        if(!empty($range)){
            $rangeArray = explode('to',$range);
            $data['selected_params']['range']['low_price'] = $rangeArray[0];
            $data['selected_params']['range']['high_price'] = $rangeArray[1];
        }

        if(isset($_GET['ajax']) && $_GET['ajax'] == 1){
            echo $this->loadView('app/view/content_snippet.php', $data);
            exit;
        }

        $this->loadView('app/view/product_view.php', $data);
    }

}