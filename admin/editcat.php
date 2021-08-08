<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>
<?php 
    if(!isset($_GET['catid']) || $_GET['catid']== null){
        echo "<script> window.location= 'catlist.php'; </script>";
    }
    else
    {
        $cat_id= $_GET['catid'];
    }
?>
    <div class="grid_10">
	
        <div class="box round first grid">
            <h2>Update a Category</h2>
           <div class="block copyblock"> 
             <form action="" method="POST">

                <?php 
                    $format= new Format();
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){

                        $update_category= $format->updateCategory($cat_id, $_POST);

                        if(isset($update_category)){
                            echo $update_category;
                            echo "<script> window.location= 'catlist.php'; </script>";
                       }
                    }

                    $select_category= $format->selectCategoryById($cat_id);

                    if($select_category){
                        
                ?>
                <table class="form">					
                    <tr>
                        <td>Category Name</td>                       
                        <td>
                            <input type="text" name="categoryName" value="<?php echo $select_category->categoryName; ?>" class="medium" />
                        </td>
                    </tr>
					<tr> 
                        <td></td>
                        <td>
                            <input type="submit" name="submit" Value="Update" />
                        </td>
                    </tr>
                </table>

                <?php } ?>

                </form>
            </div>
        </div>
    </div>
        
<?php include 'include/footer.php'; ?>
