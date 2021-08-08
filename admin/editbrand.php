<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>
<?php 
    if(!isset($_GET['brand_id']) || $_GET['brand_id']== null){
        echo "<script> window.location= 'brandlist.php'; </script>";
    }
    else
    {
        $brand_id= $_GET['brand_id'];
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

                        $update_brand= $format->updateBrand($brand_id, $_POST);

                        if(isset($update_brand)){
                            echo $update_brand;
                            echo "<script> window.location= 'brandlist.php'; </script>";
                       }
                    }

                    $select_brand= $format->selectBrandById($brand_id);

                    if($select_brand){
                        
                ?>
                <table class="form">					
                    <tr>
                        <td>Category Name</td>                       
                        <td>
                            <input type="text" name="brandName" value="<?php echo $select_brand->brandName; ?>" class="medium" />
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
