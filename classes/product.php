<?php
include_once 'lib/Database.php';
include_once 'helpers/format.php';
?>

<?php
class Product
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function proAdd($data, $file) {
        $proName = $this->fm->validation($data['proName']);
        $proCategoriesId = $this->fm->validation($data['proCategoriesId']);
        $proBrandId = $this->fm->validation($data['proBrandId']);
        $proTypeId = $this->fm->validation($data['proTypeId']);
        $proTagId = $this->fm->validation($data['proTagId']);
        $proDescription = $this->fm->validation($data['proDescription']);
        $proManufacturer = $this->fm->validation($data['proManufacturer']);
        $proReviews = $this->fm->validation($data['proReviews']);
        $proPrice = $this->fm->validation($data['proPrice']);
        $proSize = $this->fm->validation($data['proSize']);



        // Escape inputs to prevent SQL injection

        $proName = mysqli_real_escape_string($this->db->link, $proName);
        $proCategoriesId = mysqli_real_escape_string($this->db->link, $proCategoriesId);
        $proBrandId = mysqli_real_escape_string($this->db->link, $proBrandId);
        $proTypeId = mysqli_real_escape_string($this->db->link, $proTypeId);
        $proTagId = mysqli_real_escape_string($this->db->link, $proTagId);
        $proDescription = mysqli_real_escape_string($this->db->link, $proDescription);
        $proManufacturer = mysqli_real_escape_string($this->db->link, $proManufacturer);
        $proReviews = mysqli_real_escape_string($this->db->link, $proReviews);
        $proPrice = mysqli_real_escape_string($this->db->link, $proPrice);
        $proSize = mysqli_real_escape_string($this->db->link, $proSize);


        $permited = array('jpg', 'jpeg', 'png', 'gif', 'webP');
        $file_name = $file['proImg']['name'];
        $file_size = $file['proImg']['size'];
        $file_temp = $file['proImg']['tmp_name'];

        $file_parts = explode('.', $file_name);
        $file_ext = strtolower(end($file_parts));
        // Assuming the script is in the root directory and 'upload' folder exists
        $upload_directory = 'images/'; // Define upload directory
        $uploaded_image = $upload_directory . uniqid() . '.' . $file_ext; // Construct upload path

        // Check if the directory exists, if not, create it
        if (!file_exists($upload_directory)) {
            mkdir($upload_directory, 0777, true); // Create directory recursively
        }

        // Check if the directory creation was successful
        if (file_exists($upload_directory)) {
            // Move the uploaded file to the upload directory
            if (move_uploaded_file($file_temp, $uploaded_image)) {
                // File moved successfully, now insert into the database
                $query = "INSERT INTO tbl_product( proName, proCategoriesId, proBrandId, proTypeId, proTagId, proDescription,   proManufacturer, proReviews, proPrice, proSize, proImg )
                        VALUES('$proName', '$proCategoriesId', '$proBrandId', '$proTypeId','$proTagId','$proDescription', '$proManufacturer', '$proReviews', '$proPrice', '$proSize', '$uploaded_image')";
                $result = $this->db->insert($query);

                if ($result) {
                    return true; // Product inserted successfully
                } else {
                    return false; // Failed to insert product
                }
            } else {
                return false; // Failed to move the uploaded file
            }
        } else {
            return false; // Failed to create upload directory
        }
    }

    public function proList(){
        $query = "SELECT tbl_product.*,
        tbl_categories.catName AS categoryName,
        tbl_brand.brandName AS brandName,
        tbl_tag.tagName AS tagName,
        tbl_type.typeName AS typeName
        FROM tbl_product
        INNER JOIN tbl_categories ON tbl_product.proCategoriesId = tbl_categories.proCategoriesId
        INNER JOIN tbl_brand ON tbl_product.proBrandId = tbl_brand.proBrandId
        INNER JOIN tbl_tag ON tbl_product.proTagId = tbl_tag.proTagId
        INNER JOIN tbl_type ON tbl_product.proTypeId = tbl_type.proTypeId
        ORDER BY tbl_product.proId DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function getProById($proId){
        $proId = $this->fm->validation($proId);
        $proId = mysqli_real_escape_string($this->db->link, $proId);

        $query = "SELECT * FROM tbl_product WHERE proId ='$proId'";
        $result = $this->db->select($query);
        return $result;
    }

    public function updateProduct($proTitle, $proPrice, $proDetails, $catid, $brandId, $typeId, $uploaded_image, $proId){
        // Validate and sanitize form data
        $proTitle = $this->fm->validation($_POST['proTitle']);
        $proPrice = $this->fm->validation($_POST['proPrice']);
        $proDetails = $this->fm->validation($_POST['proDetails']);
        $catid = $this->fm->validation($_POST['catid']);
        $brandId = $this->fm->validation($_POST['brandId']);
        $typeId = $this->fm->validation($_POST['typeId']);

        // Escape inputs to prevent SQL injection
        $proTitle = mysqli_real_escape_string($this->db->link, $proTitle);
        $proPrice = mysqli_real_escape_string($this->db->link, $proPrice);
        $proDetails = mysqli_real_escape_string($this->db->link, $proDetails);
        $catid = mysqli_real_escape_string($this->db->link, $catid);
        $brandId = mysqli_real_escape_string($this->db->link, $brandId);
        $typeId = mysqli_real_escape_string($this->db->link, $typeId);
        $proId = mysqli_real_escape_string($this->db->link, $proId);

        // Check if a file is uploaded
        if ($_FILES['image']['name']) {
            $permited = array('jpg', 'jpeg', 'png', 'gif', 'webP');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $file_parts = explode('.', $file_name);
            $file_ext = strtolower(end($file_parts));
            $uploaded_image = '../images/' . uniqid() . '.' . $file_ext;
            $upload_path = $uploaded_image;

            // Move the uploaded file to the "upload" folder
            if (in_array($file_ext, $permited) && $file_size <= 1048576) {
                if (move_uploaded_file($file_temp, $upload_path)) {
                    // Update with the new image
                    $query = "UPDATE tbl_product SET
                                proTitle    = '$proTitle',
                                proPrice    = '$proPrice',
                                proDetails  = '$proDetails',
                                catid       = '$catid',
                                brandId     = '$brandId',
                                typeId      = '$typeId',
                                proImage    = '$uploaded_image'
                                WHERE proId = '$proId'";
                } else {
                    // Failed to move the uploaded file
                    return false;
                }
            } else {
                // Invalid file type or size exceeds the limit
                return false;
            }
        } else {
            // Update without changing the image
            $query = "UPDATE tbl_product SET
                        proTitle    = '$proTitle',
                        proPrice    = '$proPrice',
                        proDetails  = '$proDetails',
                        catid       = '$catid',
                        brandId     = '$brandId',
                        typeId      = '$typeId'
                        WHERE proId = '$proId'";
        }

        // Execute the update query
        $result = $this->db->update($query);

        // Check if the update was successful
        if ($result) {
            return true; // Product updated successfully
        } else {
            return false; // Failed to update product
        }
    }


    public function DeleteProduct($proId){
        // Prepare and execute the delete query
        $query = "DELETE FROM tbl_product WHERE proId = '$proId'";
        $result = $this->db->delete($query);
        // Return the result of the deletion
        return $result;
    }
}
      // Catedit Function
?>

