<?php
   // include_once "classes/category.php";
    include_once "lib/Database.php";
    include_once "link.php";
?>

<?php
$db     = new Database();
$type 	= new Type();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $typeName = $_POST["typeName"];
        // Call the catAdd method with provided data
        $addtype = $type->typeAdd($_POST);
        if ($addtype) {
            echo '<script>alert("Type Added Successfully")</script>';
        } else {
            echo '<script>alert("Failed to Add the Type")</script>';
        }
        echo '<meta http-equiv="refresh" content="0.001;url=addtype">';
            exit;
    }

?>


    <div class="colorlib-shop">
    <div class="container">
        <h2 class="section-title">Add New Category</h2>
        <div class="block">
            <form id="addProductForm" action="" method="post" enctype="multipart/form-data">
            <table class="add-product-form table table-success  table-hover">
                <tr>
                    <td>
                        <label class="form-label">Category Name</label>
                    </td>

                    <td >
                        <input type="text" id="typeName" name="typeName" placeholder="New Type Name..." class="form-control" />
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
            <h2 class="section-title">Type List</h2>
            <div class="block">

                <table class="table" id="table_type_data">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">S.N.</th>
                            <th scope="col">Type ID</th>
                            <th scope="col">Category Name</th>
                            <th cope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $typeList = $protyp->typeList();
                    if($typeList){
                        $i= 0;
                        while ($result = $typeList->fetch_assoc()){
                        $i++;
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $result['proTypeId'];?></td>
                        <td><?php echo $result['typeName'];?></td>
                        <td>
                                <a href="typeedit?proTypeId=<?php echo $result['proTypeId'];?>"><i class="far fa-edit"></i></a> ||
                                <span class="acction-button">
                                <a class="delete-btn" href='deletetype?proTypeId=<?php echo $result['proTypeId'];?>'><i class="fas fa-trash-alt"></i></a>
                                </span>
                            </td>
                    </tr>
                    <?php }}else{
                                echo "<p style='color:red'>No Data Found!</p>";
                    } ?>
                    </tbody>
                </table>

            </div>
        </div>
</div>
</div>


