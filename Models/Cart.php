<?php

class Cart extends Model
{
    public function getCart($uid){
        $query = "SELECT c.quantity item_quantity, p.name, p.description, p.img_ref, p.price unit_price, p.status_id, br.name brand, ctg.label category FROM carts c JOIN products p ON p.id = c.product_id JOIN product_categories ctg ON ctg.id = p.category_id JOIN product_brand br ON br.id = p.brand_id  WHERE c.customer_id = :uid AND p.status_id > 1";
        $req = self::getConnection()->prepare($query);
        $req->execute([
            'uid' => $uid,
        ]);
        return $req->fetchAll();
    }
    public function addItem($uid, $pid, $item_quantity = 1)
    {
        $query = "INSERT INTO carts (customer_id, product_id, quantity) VALUES (:uid, :pid, :quantity)";
        $req = self::getConnection()->prepare($query);
        return $req->execute([
            'uid' => $uid,
            "pid" => $pid,
            "quantity" => $item_quantity
        ]);
    }

    public function updateCartItemQuantity($uid, $pid, $item_quantity = 0)
    {
        $query = "UPDATE carts SET quantity = :quantity WHERE customer_id = :uid AND  product_id = :pid";
        $req = self::getConnection()->prepare($query);
        return $req->execute([
            'uid' => $uid,
            "pid" => $pid,
            "quantity" => $item_quantity
        ]);
    }
    public function getItemQuantity($uid, $pid){
        $query = "SELECT sum(c.quantity) quantity FROM (SELECT quantity FROM carts WHERE product_id = :pid AND customer_id != :uid) c";
        $req = self::getConnection()->prepare($query);
        $req->execute([
            'uid' => $uid,
            "pid" => $pid,
        ]);
        $res = $req->fetch();
        return $res["quantity"];
    }
    public function getAddable($uid, $pid){
        $query = "SELECT product_id, customer_id from carts where customer_id = :uid AND product_id = :pid";
        $req = self::getConnection()->prepare($query);
        $req->execute([
            'uid' => intval($uid),
            'pid' => intval($pid)
        ]);
        $result = $req->fetchAll();
        if(!$result){
            return true;
        }
        else return false;
    }
    public function cleanUpCart($uid){
        $query = "DELETE FROM carts where customer_id = :uid";
        $req = self::getConnection()->prepare($query);
        return $req->execute([
            'uid' => intval($uid)
        ]);
    }
}