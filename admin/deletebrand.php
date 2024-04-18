<?php
   // include_once "classes/category.php";
    include_once "lib/Database.php";
    include_once "link.php";
    require_once 'classes/tag.php';
?>

<?php
$db     = new Database();
$brand 	= new Brand();

if (isset($_GET['proBrandId']) && $_GET['proBrandId'] != NULL) {
    $proBrandId = $_GET["proBrandId"];

    // Fetch tag details from the database
    $query = "SELECT brandName FROM tbl_brand WHERE proBrandId = '$proBrandId'";
    $result = $db->select($query);
    if ($result) {
        // Check if any rows were returned
        if ($result->num_rows > 0) {
            $brandresult = $result->fetch_assoc();

            if ($brandresult) {
                $brandName = $brandresult['brandName'];

                // Perform tag deletion using the instantiated object
                $delbrand = $brand->DeleteBrand($proBrandId);
                if ($delbrand) {
                   echo '<meta http-equiv="refresh" content="0.001;url=addbrand">';
                   //echo "<script>alert('Success to Delete Category \"$brandName\"')</script>";
                   exit;
                } else {
                    echo '<meta http-equiv="refresh" content="0.001;url=addbrand">';
                    //echo "<script>alert('Failed to Delete Brand \"$brandName\"')</script>";
                    exit;
                }
            } else {
                // Tag not found with provided ID
                echo "<script>alert('Brand Not Found with ID: $proBrandId')</script>";
                echo '<meta http-equiv="refresh" content="0.001;url=addbrand">';
                exit;
            }
        } else {
            echo "<script>alert('Brand tag ID provided for deletion')</script>";
            echo '<meta http-equiv="refresh" content="0.001;url=addbrand">';
            exit;
        }
    }
}
?>
