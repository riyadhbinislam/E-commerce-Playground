<?php
   // include_once "classes/category.php";
    include_once "lib/Database.php";
    include_once "link.php";
    require_once 'classes/tag.php';
?>

<?php
$db     = new Database();
$tag 	= new Tag();

if (isset($_GET['proTagId']) && $_GET['proTagId'] != NULL) {
    $proTagId = $_GET["proTagId"];

    // Fetch tag details from the database
    $query = "SELECT tagName FROM tbl_tag WHERE proTagId = '$proTagId'";
    $result = $db->select($query);
    if ($result) {
        // Check if any rows were returned
        if ($result->num_rows > 0) {
            $tag = $result->fetch_assoc();

            if ($tag) {
                $tagName = $tag['tagName'];

                // Instantiate the Tag object
                $tagObj = new Tag(); // Assuming the Tag class is defined in Tag.php

                // Perform tag deletion using the instantiated object
                $deltag = $tagObj->DeleteTag($proTagId);
                if ($deltag) {
                    echo '<meta http-equiv="refresh" content="0.001;url=addtag">';
                    //echo "<script>alert('Tag \"$tagName\" Deleted Successfully')</script>";
                    exit;
                } else {
                    echo '<meta http-equiv="refresh" content="0.001;url=addtag">';
                    //echo "<script>alert('Failed to Delete Tag \"$tagName\"')</script>";
                    exit;
                }
            } else {
                // Tag not found with provided ID
                echo "<script>alert('Tag Not Found with ID: $proTagId')</script>";
                echo '<meta http-equiv="refresh" content="0.001;url=addtag">';
                exit;
            }
        } else {
            echo "<script>alert('No tag ID provided for deletion')</script>";
            echo '<meta http-equiv="refresh" content="0.001;url=addtag">';
            exit;
        }
    }
}
?>
