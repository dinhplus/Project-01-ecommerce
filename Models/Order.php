<?php

// use Model\CoreModel as Model;

class Order extends Model
{
    public function getAllOrder(
        $pageNumber = 1,
        $recordPerPage = 20,
        $descTotalPrice = false,
        $status_ids = null,
        $cid = null,
        $oid = null,
        $startTimeRange = null,
        $endTimeRange = null
    ) {
        $query = 'SELECT o.*, stt.label order_status, c.email customer_email, c.name customer_name, c.phone customer_phone_number, c.address customer_address FROM orders o JOIN order_status_define stt ON o.status_id = stt.id JOIN customers c ON o.customer_id = c.id  WHERE 1';
        if($status_ids){
            $query .= ' AND o.status_id in ('.$status_ids.')';
        }
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
        $req->execute();
        return $req->fetchAll();
    }
    public function getOrderDetail($oid)
    {
        $query = "SELECT od.order_id, od.product_id, od.quantity, od.unit_price, p.name, p.img_ref, pb.name brand, pc.label category from order_detail od join products p on p.id = od.product_id join product_brand pb on pb.id = p.brand_id join product_categories pc on pc.id = p.category_id where order_id = :order_id";
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
    public function getOrderById($oid = 0){
        $query = 'SELECT  o.*, stt.label order_status, c.email customer_email, c.name customer_name, c.phone customer_phone_number, c.address customer_address, o.name, o.phone, o.address FROM orders o JOIN order_status_define stt ON o.status_id = stt.id JOIN customers c ON o.customer_id = c.id  WHERE o.id = :oid';
        $req = self::getConnection()->prepare($query);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute([
            "oid" => $oid
        ]);
        return $req->fetch();
    }
    public function updateOrderStatus($oid, $next_status, $staff_id, $note){
        $query = "UPDATE orders SET status_id  = :status_id , staff_ref = :staff_ref, note = :note WHERE id = :oid";
        $req = self::getConnection()->prepare($query);
        return $req->execute([
            "oid" => $oid,
            "status_id" => $next_status,
            "staff_ref" => $staff_id,
            "note" => $note
        ]);

    }
    public function generateOrder($uid= null,  $staff_id = null, $name, $phone, $address, $note = ''){
        $query = "INSERT INTO orders(customer_id, staff_ref, name, phone, address, note) VALUES (:uid, :staff_ref, :name, :phone, :address, :note)";
        $req = self::getConnection()->prepare($query);
        $req->execute([
            "uid" => $uid,
            "staff_ref" => $staff_id,
            "name" => $name,
            "phone" => $phone,
            "address" => $address,
            "note" => $note,
        ]);
        $lastRecordQrr = "SELECT `AUTO_INCREMENT` as id FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'project_01' AND TABLE_NAME = 'orders'";
        $getLastRC = self::getConnection()->prepare($lastRecordQrr);
        $getLastRC->execute();

        return $getLastRC->fetch();

    }
    public function pushOrderDetail($oid, $uid = 0){
        $query = "INSERT INTO order_detail(order_id, product_id, quantity, unit_price)
            SELECT  :oid, i.product_id, i.quantity, i.unit_price
            FROM
                (select c.product_id  product_id, c.quantity quantity, p.price unit_price
                from carts c
                join products p ON p.id = c.product_id
                where c.customer_id = :uid
                and p.status_id > 1
            ) i";
        $req = self::getConnection()->prepare($query);
        return $req->execute([
            "oid" => $oid,
            "uid" => $uid
        ]);
    }
    public function updateTotalPrice($oid, $totalPrice){
        $query = "UPDATE orders SET total_price = :total_price WHERE id = :oid";
        $req = self::getConnection()->prepare($query);
        return $req->execute([
            "oid" => $oid,
            "total_price" => $totalPrice
        ]);
    }
}
