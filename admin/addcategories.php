<?php
   // include_once "classes/category.php";
    include_once "lib/Database.php";
    include_once "link.php";
?>

<?php
$db     = new Database();
$ct 	= new category();
$rows ='';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $catName = $_POST["catName"];
        // Call the catAdd method with provided data
        $addcat = $ct->catAdd($_POST);

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
                        <input type="text" id="catName" name="catName" placeholder="New Category Name..." class="form-control" />
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

            <h2 class="section-title">Category List</h2>

            <div class="block">

            <?php
                $catList = $ct->catList();
                if($catList){
                    $i= 0;
                    while ($result = $catList->fetch_assoc()){
                        $i++;
                        $rows .= '<tr>';
                        $rows .= '<td>' . $i . '</td>';
                        $rows .= '<td>' . $result['proCategoriesId'] . '</td>';
                        $rows .= '<td>' . $result['catName'] . '</td>';
                        $rows .= '<td>';
                        $rows .= '<a href="categoryedit?proCategoriesId=' . $result['proCategoriesId'] . '"><i class="far fa-edit"></i></a> ||';
                        $rows .= '<span class="acction-button">';
                        $rows .= '<a class="delete-btn" data-proCategoriesId='.$result['proCategoriesId'].' href="deletecategory?proCategoriesId=' . $result['proCategoriesId'] . '"><i class="fas fa-trash-alt"></i></a>';
                        $rows .= '</span>';
                        $rows .= '</td>';
                        $rows .= '</tr>';
                    }} else {
                        $rows = '<tr><td colspan="4"><p style="color:red">No Data Found!</p></td></tr>';
                    }?>

                <table class="table" id="table_cat_data">
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


<script type="javascript" src="js/jquery.min.js"></script>
<script src = "https://ajax.googleapis.com/ajax/libs/jQuery/3.3.1/jQuery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    function loadTable(){
        $.ajax({
          url: 'addcategories',
          type: 'POST',
          data: formData,
          success: function(data) {
              $("#table_cat_data").html(data);
          },
      });
    }
    loadTable();
});

// $(document).on.( "click", ".delete-btn", function () {
// var proCategoriesId = $(this).data(proCategoriesId);
// var element = this;

//     $.ajax({
//             url: 'deletecategory',
//             type: 'POST',
//             data: {proCategoriesId : proCategoriesId},
//             success: function(data) {
//                 if(data == $msg){
//                 $(element).closest("tr").fadeOut();
//             }else{
//                 $("#table_cat_data").html("cant delete record");
//             }
//             },
//         });
// })

</script>