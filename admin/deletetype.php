<?php
   // include_once "classes/category.php";
    include_once "lib/Database.php";
    include_once "link.php";
    require_once 'classes/tag.php';
?>
<style>
nav.colorlib-nav {
    display: none;
}
</style>
<?php
$db         = new Database();
$typeObj    = new Type();


if (isset($_GET['proTypeId']) && $_GET['proTypeId'] != NULL) {
    $proTypeId = $_GET["proTypeId"];

    // Fetch tag details from the database
    $query = "SELECT * FROM tbl_type WHERE proTypeId = '$proTypeId'";
    $result = $db->select($query);
    if ($result) {
        // Check if any rows were returned
        if ($result->num_rows > 0) {
            // Fetch rows one by one
            $type = $result->fetch_assoc();
            if ($type) {
                $typeName = $type['typeName'];
                // Perform tag deletion using the instantiated object
                $deltype = $typeObj->DeleteType($proTypeId);
                if ($deltype) {
                    echo '<meta http-equiv="refresh" content="0.0001;url=addtype">';
                    //echo "<script>alert('Type \"$typeName\" Deleted Successfully')</script>";
                    exit;
                } else {
                    echo '<meta http-equiv="refresh" content="0.0001;url=addtype">';
                    //echo "<script>alert('Failed to Delete Type \"$typeName\"')</script>";
                    exit;
                }
            } else {
                // Tag not found with provided ID
                echo "<script>alert('Type Not Found with ID: $proTypeId')</script>";
                echo '<meta http-equiv="refresh" content="0.001;url=addtype">';
                exit;
            }
        } else {
            echo "<script>alert('No type ID provided for deletion')</script>";
            echo '<meta http-equiv="refresh" content="0.001;url=addtype">';
            exit;
        }
    }

    // Fetch tag details from the database
//     $query = "SELECT typeName FROM tbl_type WHERE proTypeId = '$proTypeId'";
//     $result = $db->select($query);
//     $typeresult = $result->fetch_assoc(MYSQLI_ASSOC);

//     if ($typeresult) {
//         $tagName = $typeresult['typeName'];
//         // Perform tag deletion using the instantiated object
//         $deltype = $typeObj->DeleteType($proTypeId);
//         if ($deltype) {
//             header('Location: addtype');
//             echo "<script>alert('Type \"$tagName\" Deleted Successfully')</script>";
//             exit;
//         } else {
//             header('Location: addtype');
//             echo "<script>alert('Failed to Delete Type \"$tagName\"')</script>";
//             exit;
//         }
//     } else {
//         // Type not found with provided ID
//         echo "<script>alert('Type Not Found with ID: $proTypeId')</script>";
//         echo '<meta http-equiv="refresh" content="0.001;url=addtype">';
//         exit;
//     }
// } else {
//     echo "<script>alert('No Type ID provided for deletion')</script>";
//     echo '<meta http-equiv="refresh" content="0.001;url=addtype">';
//     exit;
}
?>
