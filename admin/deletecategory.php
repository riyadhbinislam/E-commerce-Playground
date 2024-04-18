<?php
   // include_once "classes/category.php";
    include_once "lib/Database.php";
    include_once "link.php";
    require_once 'classes/category.php';
?>

<?php
$db     = new Database();
$ct 	= new Category();

if (isset($_GET['proCategoriesId']) && $_GET['proCategoriesId'] != NULL) {
    $proCategoriesId = $_GET["proCategoriesId"];

    // Fetch tag details from the database
    $query = "SELECT catName FROM tbl_categories WHERE proCategoriesId = '$proCategoriesId'";
    $result = $db->select($query);
    if ($result) {
        // Check if any rows were returned
        if ($result->num_rows > 0) {
            $categoryresult = $result->fetch_assoc();

            if ($categoryresult) {
                $catName = $categoryresult['catName'];

                // Perform tag deletion using the instantiated object
                $delcat = $ct->DeleteCategory($proCategoriesId);
                if ($delcat) {
                    echo '<meta http-equiv="refresh" content="0.001;url=addcategories">';
                    //echo "<script>alert('Success to Delete Category \"$catName\"')</script>";
                    exit;
                } else {
                    echo '<meta http-equiv="refresh" content="0.001;url=addcategories">';
                    //echo "<script>alert('Failed to Delete Category \"$catName\"')</script>";
                    exit;
                }
            } else {
                // Tag not found with provided ID
                echo "<script>alert('Brand Not Found with ID: $proCategoriesId')</script>";
                echo '<meta http-equiv="refresh" content="0.001;url=addcategories">';
                exit;
            }
        } else {
            echo "<script>alert('Brand tag ID provided for deletion')</script>";
            echo '<meta http-equiv="refresh" content="0.001;url=addcategories">';
            exit;
        }
    }
}
?>
