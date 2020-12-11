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
        $query = 'SELECT o.*, stt.label, c.email, c.name, c.phone FROM orders o JOIN status_order_define stt ON o.status = stt.id JOIN customers c ON o.customer_id = c.id WHERE 1';

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


        $query .= 'LIMIT :recordPerPage OFFSET :offset';
        $req = self::getConnection()->prepare($query);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute([
            "recordPerPage" => $recordPerPage,
            "offset" => ($pageNumber -1) * $recordPerPage

        ]);
        return $req->fetchAll();

    }
}
