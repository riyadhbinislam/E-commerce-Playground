<?php
   include_once "classes/brand.php";
    include_once "lib/Database.php";
    include_once "link.php";
?>

<?php
$db     = new Database();
$brand 	= new Brand();
$rows   = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $brandName = $_POST["brandName"];
        // Call the brandAdd method with provided data
        $addbrand = $brand->brandAdd($_POST);
    }

?>

    <div class="colorlib-shop">
    <div class="container">
        <h2 class="section-title">Add New Brand</h2>
        <div class="block">
            <form id="addProductForm" action="" method="post" enctype="multipart/form-data">
            <table class="add-product-form table table-success  table-hover">
                <tr>
                    <td>
                        <label class="form-label">Brand Name</label>
                    </td>

                    <td >
                        <input type="text" id="brandName" name="brandName" placeholder="New Type Name..." class="form-control" />
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
            <h2 class="section-title">Brand List</h2>
            <div class="block">
            <?php
                $brandlist = $brand->brandList();
                if($brandlist){
                    $i= 0;
                    while ($result = $brandlist->fetch_assoc()){
                        $i++;
                        $rows .= '<tr>';
                        $rows .= '<td>' . $i . '</td>';
                        $rows .= '<td>' . $result['proBrandId'] . '</td>';
                        $rows .= '<td>' . $result['brandName'] . '</td>';
                        $rows .= '<td>';
                        $rows .= '<a href="brandedit.php?proBrandId=' . $result['proBrandId'] . '"><i class="far fa-edit"></i></a> ||';
                        $rows .= '<span class="acction-button">';
                        $rows .= '<a class="delete-btn" href="deletebrand?proBrandId=' . $result['proBrandId'] . '"><i class="fas fa-trash-alt"></i></a>';
                        $rows .= '</span>';
                        $rows .= '</td>';
                        $rows .= '</tr>';
                    }} else {
                        $rows = '<tr><td colspan="4"><p style="color:red">No Data Found!</p></td></tr>';
                    }?>

                <table class="table" id="table_brand_data">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">S.N.</th>
                            <th scope="col">Brand ID</th>
                            <th scope="col">Brand Name</th>
                            <th cope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php echo $rows;?>
                    </tbody>
                </table>

            </div>
        </div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $("#submit").on("click", function(e){
            // Function to load brand data via AJAX
            function loadBrandData() {
                    $.ajax({
                        url: 'addbrand', // URL to the PHP file that fetches brand data
                        type: 'POST',
                        data: formData,
                        success: function(data) {
                            $('#table_brand_data tbody').html(data); // Update table body with fetched data
                        }
                    });
                    // Initial load of brand data
                    loadBrandData();
                }
    })




});
</script>
