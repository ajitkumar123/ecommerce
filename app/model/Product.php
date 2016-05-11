<?php

/**
 * Created by PhpStorm.
 * User: ajit
 * Date: 5/5/16
 * Time: 12:19 AM
 */
include_once 'Model.php';

class Product extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function fetchData($q,$category = '',
       Array $subcategorys = [], Array $brand_tagged = [], $price_range = '',
        $stock = false,
        $from = 1, $length = 21
    ){

        $sql = "
            SELECT SQL_CALC_FOUND_ROWS id, `title`, `thumbnail`, `available_price`, `mrp`, `stock` FROM `product`
        ";
        $sql .= $this->getSql($q,$category ,
                $subcategorys,
                $brand_tagged ,
                $price_range ,
                $stock,
                $from, $length
            );

        $stmt = $this->dbObj->prepare($sql);
        $stmt->execute();
        $result =  $stmt->fetchAll();

        if(empty($result)){
            $sql = "
            SELECT SQL_CALC_FOUND_ROWS id, `title`, `thumbnail`, `available_price`, `mrp`, `stock` FROM `product`
        ";
            $sql .= $this->getSql($q,$category ,
                $subcategorys,
                $brand_tagged ,
                $price_range ,
                $stock,
                $from, $length,'Like'
            );

            $stmt = $this->dbObj->prepare($sql);
            $stmt->execute();
            $result =  $stmt->fetchAll();
        }

        return $result;

    }

    private function getSql($q, $category ,
        $subcategorys, $brand_taggeds , $price_range ,
        $stock,
        $from, $length,
        $using = 'Full Text'
    ){

        $sql = "";$cond = [];
        if(!empty($category)){
            $cond[] = "category = '".$category."'" ;
        }
        if(!empty($subcategorys)){
            $sub_sql = " (";
            foreach($subcategorys as $subcategory) {
                $sqlSub[] = " subcategory = '" . $subcategory . "'";
            }
            $sub_sql .= implode(' OR ', $sqlSub);
            $sub_sql .= " ) ";
            $cond[] = $sub_sql ;
            unset($sqlSub);
        }
        if(!empty($brand_taggeds)){
            $sub_sql = " (";
            foreach($brand_taggeds as $brand_tagged) {
                $sqlSub[] = " brand_tagged = '" . $brand_tagged . "'";
            }
            $sub_sql .= implode(' OR ', $sqlSub);
            $sub_sql .= " )";
            $cond[] = $sub_sql ;
        }

        if(!empty($price_range)){
            $price = explode('to', $price_range);
            $start = isset($price[0]) ? $price[0] : 0;
            $end = isset($price[1]) ? $price[1] : 0;
            if($start <= $end){
                if($start !== 0 )
                    $cond[] = "available_price > ".$start ;
                if($end !== 0)
                    $cond[] = "available_price < ".$end ;
            }

        }

        if(!empty($stock) && $stock == 'yes'){
            $cond[] = "stock != 'Out of Stock' " ;
        }
        if(!empty($q) && $using == 'Full Text'){
            $cond[] .= ' MATCH(category, subcategory, brand_tagged, category_tagged, title ) AGAINST( "'.$q.'"  )';
        }
        if(!empty($q) && $using == 'Like'){
            $cond[] .= ' (category LIKE "%'.$q.'%"
                        OR subcategory LIKE "%'.$q.'%"
                        OR brand_tagged LIKE "%'.$q.'%"
                        OR category_tagged LIKE "%'.$q.'%"
                        OR title LIKE "%'.$q.'%" )';
        }
        if(!empty($cond)){
            $sql .= " WHERE ". implode(' AND ', $cond);
        }
        if(!empty($q) && $using = 'Full Text' ){
            $sql .= ' ORDER BY MATCH(category, subcategory, brand_tagged, category_tagged, title ) AGAINST( "'.$q.'"  ) DESC';
        }
        $sql .= " LIMIT ".($from-1)*$length . ', '. $length;

        return $sql;
    }

    public function getTotalCount(){
        $stmt = $this->dbObj->query('SELECT FOUND_ROWS() AS count');

        return $stmt->fetch()->count;

    }

    public function categoryFilter(){

        $sql = "
            SELECT DISTINCT category FROM `product`
        ";
        $stmt = $this->dbObj->query($sql);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function brandFilter($category, Array $subcategorys = []){

        $sql = "
            SELECT distinct brand_tagged FROM `product` WHERE category = ?
        ";
        if(!empty($subcategorys)) {
            $sql .= " AND (";
            foreach($subcategorys as $subcategory) {
                $sqlSub[] = " subcategory = '" . $subcategory . "'";
            }
            $sql .= implode(' OR ', $sqlSub);
            $sql .= " )";
        }

        $stmt = $this->dbObj->prepare($sql);
        $stmt->execute([$category]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    public function subcategoryFilter($category){

        $sql = "
            SELECT distinct subcategory FROM `product` WHERE category = ?
        ";
        $stmt = $this->dbObj->prepare($sql);
        $stmt->execute([$category]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

}
