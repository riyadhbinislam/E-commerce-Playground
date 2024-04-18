<?php
include_once 'lib/Database.php';
include_once 'helpers/format.php';
?>


<?php
class Cart
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    //add product to cart
    public function addToCart($quantity, $productId){
        $quantity   = $this->fm->validation($quantity);
        $quantity   = mysqli_real_escape_string($this->db->link, $quantity);

        $productId = $this->fm->validation($productId);
        $productId = mysqli_real_escape_string($this->db->link, $productId);

        $sId        = session_id();

        $squery      = "SELECT * FROM tbl_product WHERE proId ='$productId'";
        $result     = $this->db->select($squery)->fetch_assoc();

        $productName = $result['proName'];
        $proPrice = $result['proPrice'];
        $proImg = $result['proImg'];

        $check 	= "SELECT * FROM tbl_cart WHERE sId='$sId' AND productId='$productId'";
        $countResult 	= $this->db->select($check);
        // $check  = "SELECT * FROM tbl_cart WHERE sId='$sId' AND productId='$productId'";
        // echo "Check query: $check <br>"; // Add this line to print the query
        $countResult = $this->db->select($check);

        // $count = $countResult;

        if ($countResult ) {
            echo "<script>";
            echo "var message = 'This Product is already added in your cart.';";
            echo "alert(message);";
            echo "</script>";
            echo '<meta http-equiv="refresh" content=".001;url=cart">';
            }else{
                $query = "INSERT INTO tbl_cart (sId, productId, productName, proPrice, quantity, proImg)
                VALUES ('$sId', '$productId', '$productName', '$proPrice', '$quantity', '$proImg')";

                $inserted_row = $this->db->insert($query);

                if ($inserted_row) {
                    echo '<meta http-equiv="refresh" content=".001;url=cart">';
                }else{
                    echo "<div class='container'><h2>Cart Is Empty</h2></div>";
                    echo '<meta http-equiv="refresh" content="3;url=shop">';
                    exit;
                }
            }
        }
    //Show item from the shopping cart According to  Session ID
    public function getCartProduct(){
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
        $result = $this->db->select($query); // Assuming select() returns a MySQLi result object

        return $result;
    }

    public function updateCart($quantity, $cartId){
        $quantity   = mysqli_real_escape_string($this->db->link, $quantity);
        $cartId     = mysqli_real_escape_string($this->db->link, $cartId);


        $updateQuery    = "UPDATE tbl_cart
                           SET quantity ='$quantity'
                           WHERE cartId = '$cartId' ";
        $updatedRow     = $this->db->update($updateQuery);

        if($updatedRow){
            echo "<script>setTimeout(function(){ window.location.href = 'cart'; }, 0000);</script>";
            exit;
        } else{
            $msg = "<span class='msg-alt'>Failed To Update Quantity!</span>";
            return $msg;
        }
    }

    public function  deleteFromCart($cartId){
        $cartId     = mysqli_real_escape_string($this->db->link, $cartId);
        $query      = "DELETE FROM tbl_cart WHERE cartId = '$cartId'";
        $deleteRow  = $this->db->delete($query);

        if($deleteRow){
            $msg  = "<span class='msg-alt'>Item Deleted From Cart Successfully!</span>";
            return $msg;
        }else{
            $msg  = "<span class='msg-alt'>Item Not Deleted From Cart !</span>";
            return $msg;

        }
    }

    public function checkCartTable(){
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
        $result  = $this->db->select($query);
        return  $result;
    }

    public function delCart(){
        $sId = session_id();
        $query = "DELETE FROM tbl_cart WHERE sId = '$sId'";
        $this->db->delete($query);
    }

    public function orderProduct($userId){
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
        $getPro = $this->db->select($query);

        if($getPro){
            // Get the highest existing order group ID
            $query = "SELECT MAX(order_grp_id) AS max_id FROM tbl_order";
            $result = $this->db->select($query);
            $row = $result->fetch_assoc();
            $maxGroupId = $row['max_id'];

            // Determine the next order group ID
            $nextGroupId = uniqid();

            while($result   = $getPro->fetch_assoc()){
                $productId  = $result['productId'];
                $productName = $result['productName'];
                $quantity   = $result['quantity'];
                $proPrice      = $result['proPrice'];
                $proImg      = $result['proImg'];

                // Insert the order with the determined group ID
                $query = "INSERT INTO tbl_order (userId, productId, productName, quantity, proPrice, proImg, order_grp_id)
                          VALUES ('$userId', '$productId', '$productName', '$quantity', '$proPrice', '$proImg', '$nextGroupId')";

                $inserted_row = $this->db->insert($query);
            }

            // Once all orders are inserted, delete them from the cart
            $query = "DELETE FROM tbl_cart WHERE sId = '$sId'";
            $this->db->delete($query);
        }
    }

    // public function orderProduct($userId){
    //     $sId = session_id();
    //     $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
    //     $getPro = $this->db->select($query);

    //     if($getPro){
    //         // Generate a unique order group ID
    //         $order_grp_id = uniqid();

    //         while($result = $getPro->fetch_assoc()){
    //             $productId = $result['productId'];
    //             $productName = $result['productName'];
    //             $quantity = $result['quantity'];
    //             $proPrice = $result['proPrice'];
    //             $proImg = $result['proImg'];

    //             // Insert the order with the unique group ID
    //             $query = "INSERT INTO tbl_order (userId, productId, productName, quantity, proPrice, proImg, order_grp_id)
    //                       VALUES ('$userId', '$productId', '$productName', '$quantity', '$proPrice', '$proImg', '$order_grp_id')";

    //             $inserted_row = $this->db->insert($query);
    //         }

    //         // Once all orders are inserted, delete them from the cart
    //         $query = "DELETE FROM tbl_cart WHERE sId = '$sId'";
    //         $this->db->delete($query);
    //     }
    // }


    public function payableAmount($userId){
        $query = "SELECT * FROM tbl_order WHERE userId = '$userId' AND date= now() ";
        $result  = $this->db->select($query);
        return  $result;
    }

    public function getOrderDetails($userId){
        $query = "SELECT * FROM tbl_order WHERE userId = '$userId' ORDER BY productId DESC";
        $result  = $this->db->select($query);
        return  $result;
    }

    public function chkOrder($userId){
        $query = "SELECT * FROM tbl_order WHERE userId = '$userId'";
        $result  = $this->db->select($query);
        return  $result;
    }
    public function getAllorder(){
        $query = "SELECT * FROM tbl_order ORDER BY date  DESC";
        $result  = $this->db->select($query);
        return  $result;
    }

    public function getOrderDetailsByOrderId($orderGrpId){
        $query = "SELECT * FROM tbl_order WHERE order_grp_id = '$orderGrpId' ORDER BY productId DESC";
        $result  = $this->db->select($query);
        return  $result;
    }
}