<?php
// Assuming $db is an instance of the Database class
if (!isset($_GET['cartId']) || $_GET['cartId'] == NULL) {
    echo "<script>window.location = 'cart';</script>";
} else {
    $postid = $_GET["cartId"];
    $query = "SELECT * FROM tbl_cart WHERE cartId='$postid'";
    $getData = $db->select($query);

    if ($getData) {
        $delquery = "DELETE FROM tbl_cart WHERE cartId='$postid' ";
        $delData = $db->delete($delquery);
        // Redirect to show all data in the table again after deleting a row
        echo '<meta http-equiv="refresh" content="0;url=cart">';
    }

};
?>