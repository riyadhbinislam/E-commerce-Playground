<?php
   // include_once "classes/category.php";
    include_once "lib/Database.php";
    include_once "link.php";
?>

<?php
$db     = new Database();
$tag 	= new Tag();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tagName = $_POST["tagName"];
        // Call the catAdd method with provided data
        $addtag = $tag->tagAdd($_POST);
    }

    // End output buffering and flush buffer
ob_end_flush();
?>

    <div class="colorlib-shop">
    <div class="container">
        <h2 class="section-title">Add New Tag</h2>
        <div class="block">
            <form id="addProductForm" action="" method="post" enctype="multipart/form-data">
            <table class="add-product-form table table-success  table-hover">
                <tr>
                    <td>
                        <label class="form-label">Tag Name</label>
                    </td>

                    <td >
                        <input type="text" id="tagName" name="tagName" placeholder="New Tag Name..." class="form-control" />
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
            <h2 class="section-title">Tag List</h2>
            <div class="block">

                <table class="table" id="table_tag_data">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">S.N.</th>
                            <th scope="col">Tag ID</th>
                            <th scope="col">Tag Name</th>
                            <th cope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $taglist = $tag->tagList();
                    if($taglist){
                        $i= 0;
                        while ($result = $taglist->fetch_assoc()){
                        $i++;
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $result['proTagId'];?></td>
                        <td><?php echo $result['tagName'];?></td>
                        <td>
                            <a href="edittag?proTagId=<?php echo $result['proTagId'];?>"><i class="fa-regular fa-pen-to-square"></i></a> ||
                            <span class="acction-button">
                                <a class="delete-btn" href='deletetag?proTagId=<?php echo $result['proTagId'];?>'><i class="fas fa-trash-alt"></i></a>
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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $("#submit").on("click", function(e){
            // Function to load brand data via AJAX
            function loadTagData() {
                    $.ajax({
                        url: 'addtag', // URL to the PHP file that fetches brand data
                        type: 'POST',
                        data: formData,
                        success: function(data) {
                            $('#table_tag_data tbody').html(data); // Update table body with fetched data
                        }
                    });
                    // Initial load of brand data
                    loadTagData();
                }
    })




});
</script>