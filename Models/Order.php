<?php

// use Model\CoreModel as Model;

class Order extends Model
{
    public function getAllOrder(
        $pageNumber = 1,
        $recordPerPage = 20,
        $descTotalPrice = false,
        $cid = null,
        $oid = null,
        $startTimeRange = null,
        $endTimeRange = null
    ) {
        $query = 'SELECT o.*, stt.label order_status, c.email customer_email, c.name customer_name, c.phone customer_phone_number, c.address customer_address FROM orders o JOIN order_status_define stt ON o.status_id = stt.id JOIN customers c ON o.customer_id = c.id  WHERE 1';
        if($oid){
            $query .= ' AND o.id = '.$oid;
        }
        if($cid){
            $query .= ' AND o.customer_id = '.$cid;
        }
        if($startTimeRange){
            $query .= ' AND o.create_at >= '.$startTimeRange;
        }
        if($endTimeRange){
            $query .= 'AND o.create_at <= '.$startTimeRange;
        }
        if($descTotalPrice !== false && $descTotalPrice > 0){
            $query .= ' ORDER BY o.total_price DESC';
        }
        else if( $descTotalPrice !== false && $descTotalPrice < 0){
            $query .= ' ORDER BY o.total_price ASC';
        }
        $query .=  " LIMIT ".$recordPerPage." OFFSET ".(($pageNumber -1) * $recordPerPage);
        $req = self::getConnection()->prepare($query);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute();
        return $req->fetchAll();
    }
    public function getOrderDetail($oid)
    {
        $query = "SELECT od.order_id, od.product_id, od.quantity, od.unit_price, p.name from order_detail od join products p on p.id = od.product_id where order_id = :order_id";
        $req = self::getConnection()->prepare($query);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute([
            "order_id" => $oid
        ]);
        return $req->fetchAll();
    }
    public function getOrderStatusDefine()
    {
        $query = "SELECT id,label from order_status_define";
        $req = self::getConnection()->prepare($query);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute();
        return $req->fetchAll();
    }
}
