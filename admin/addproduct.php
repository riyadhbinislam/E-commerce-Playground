<?php

    include_once "lib/Database.php";
    include_once "link.php";
?>

<?php
$db = new Database();
$pro = new Product();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Call the proAdd method with provided data
        $addpro = $pro->proAdd($_POST, $_FILES);
        if ($addpro) {
            echo '<script>alert("Product Added Successfully")</script>';
        } else{
            echo '<script>alert("Failed to Add the product")</script>';
        }
        // Redirect back to the same page
        echo '<meta http-equiv="refresh" content="0;url=addproduct">'; // Refresh the page after 0 seconds
        exit;
};?>



    <div class="colorlib-shop">
    <div class="container">
        <h2 class="section-title">Add New Product</h2>
        <div class="block">
            <form id="addProductForm" action="" method="post" enctype="multipart/form-data">
            <table class="add-product-form table table-success  table-hover">
                <tr>
                    <td>
                        <label class="form-label">Product Name</label>
                    </td>

                    <td >
                        <input type="text" id="proName" name="proName" placeholder="Enter Product Title..." class="form-control" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="form-label">Category</label>
                    </td>
                    <td>
                        <select id="proCategoriesId" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="proCategoriesId" >
                            <option>Select Category</option>
                            <?php
                                $query = "SELECT * FROM tbl_categories";
                                $category = $db->select($query);
                                if ($category) {
                                    while ($result = $category->fetch_assoc()) {?>
                                        <option value="<?php echo $result['proCategoriesId']; ?>"><?php echo $result['catName']; ?></option>
                            <?php }} ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="form-label">Brand</label>
                    </td>
                    <td>
                        <select class="form-select" id="proBrandId" name="proBrandId">
                            <option>Select Brand</option>
                            <?php
                                $query = "SELECT * FROM tbl_brand";
                                $category = $db->select($query);
                                if ($category) {
                                    while ($result = $category->fetch_assoc()) {?>
                                        <option value="<?php echo $result['proBrandId']; ?>"><?php echo $result['brandName']; ?></option>
                            <?php }} ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="form-label">Type</label>
                    </td>
                    <td>
                        <select class="form-select" id="proTypeId"name="proTypeId">
                            <option>Select Type</option>
                            <?php
                                $query = "SELECT * FROM tbl_type";
                                $category = $db->select($query);
                                if ($category) {
                                    while ($result = $category->fetch_assoc()) {?>
                                        <option value="<?php echo $result['proTypeId']; ?>"><?php echo $result['typeName']; ?></option>
                            <?php }} ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="form-label">Tag</label>
                    </td>
                    <td>
                        <select class="select" id="proTagId"name="proTagId">
                            <option>Select TAG</option>
                            <?php
                                $query = "SELECT * FROM tbl_tag";
                                $category = $db->select($query);
                                if ($category) {
                                    while ($result = $category->fetch_assoc()) {?>
                                        <option value="<?php echo $result['proTagId']; ?>"><?php echo $result['tagName']; ?></option>
                            <?php }} ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label class="form-label">Product Description</label>
                    </td>
                    <td>
                        <textarea type="text" class="form-control" id="proDescription" name="proDescription" placeholder="Enter Product Description..." id="" cols="40" rows="5"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="form-label">Product Manufacturer</label>
                    </td>
                    <td>
                        <textarea type="text" class="form-control" id="proManufacturer" name="proManufacturer" placeholder="Enter Product Description..." id="" cols="40" rows="5"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="form-label">Product Reviews</label>
                    </td>
                    <td>
                        <textarea type="text" class="form-control" id="proReviews" name="proReviews" placeholder="Enter Product Description..." id="" cols="40" rows="5"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label class="form-label">Product Price</label>
                    </td>
                    <td>
                        <input type="text" id="proPrice" name="proPrice" placeholder="Enter Product Price..." class="form-control" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="form-label">Product Size</label>
                    </td>

                    <td >
                        <input type="text" id="proSize" name="proSize" placeholder="Enter Product Size..." class="form-control" />


                    </td>
                </tr>

                <tr>
                    <td>
                        <label class="form-label">Upload Product Image</label>
                    </td>
                    <td>
                        <input id="proImg" name="proImg" class="form-control form-control-lg" type="file" id="formFileMultiple" multiple>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <input id="submit" type="submit" name="submit" Value="Save" class=" btn btn-primary"/>
                    </td>
                </tr>
            </table>
        </form>
        </div>
    </div>
</div>

<div class="container">
    <h2>Product Data</h2>
    <div class="table-responsive">
        <table class="table table-striped" id="table_pro_data">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>CategoriesId</th>
                    <th>BrandId</th>
                    <th>TypeId</th>
                    <th>TagId</th>
                    <th>Description</th>
                    <th>Manufacturer</th>
                    <th>Reviews</th>
                    <th>Price</th>
                    <th>Size</th>

                    <th cope="col">Action</th>

                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch product data and loop through each row to display it
                $products = $pro->proList();

                if ($products) {
                    while ($result = $products->fetch_assoc()) {
                        // echo '<pre>';
                        // print_r( $result );
                        // echo '</pre>';
                        ?>
                        <tr>
                            <td>
                                <img src="../<?php echo $result['proImg']; ?>" alt="<?php echo $result['proName']; ?>" style="max-width: 100px;">
                            </td>
                            <td><?php echo $result['proName']; ?></td>
                            <td><?php echo $result['categoryName']; ?></td>
                            <td><?php echo $result['brandName']; ?></td>
                            <td><?php echo $result['typeName']; ?></td>
                            <td><?php echo $result['tagName']; ?></td>
                            <td><?php echo $fm->readmore($result['proDescription'], 50); ?></td>
                            <td><?php echo $fm->readmore($result['proManufacturer'], 50); ?></td>
                            <td><?php echo $fm->readmore($result['proReviews'], 50); ?></td>
                            <td><?php echo $result['proPrice']; ?></td>
                            <td><?php echo $result['proSize']; ?></td>


                            <td>
                                <a href="catedit.php?catid=<?php echo $result['proId'];?>"><i class="far fa-edit"></i></a> ||
                                <span class="acction-button">
                                <a onclick="return confirm ('Are You sure to Delete')" href="?proId=<?php echo $result['proId'];?>"><i class="fas fa-trash-alt"></i></a>
                                </span>
                            </td>

                        </tr>
                    <?php }
                } else {
                    ?>
                    <tr>
                        <td colspan="11">No products found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

    </div>
</div>


<script type="javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    function loadTable(){
        $.ajax({
          url: 'addproduct',
          type: 'POST',
          data: formData,
          success: function(data) {
              $("#table_pro_data").html(data);
          },
      });
    }
    loadTable();
});
</script>