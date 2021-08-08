<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>
<?php 
    if(!isset($_GET['product_id']) || $_GET['product_id']== null){
        
        echo "<script> window.location= 'order_details.php'; </script>";
    }
    else
    {
        $product_id= $_GET['product_id'];
    }
?>

    <div class="grid_10">
    
        <div class="box round first grid">
            <h2>Ordered Product Details</h2>
           <div class="block copyblock"> 
             <form action="" method="POST">

                <?php 
                    $format= new Format();
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){

                        echo "<script> window.location= 'order_details.php'; </script>";
                      
                    }

                    $ordered_product= $format->getOrderedProductById($product_id);

                    if($ordered_product){
                        
                ?>
                <table class="form">                    
                    <tr>
                        <td>
                            <label>Name</label>
                        </td>
                        <td>
                            <input readonly="" type="text" value="<?php echo $ordered_product->productName; ?>" class="medium" />
                        </td>
                    </tr>              
                    <tr>
                       <td>
                            <label>Category</label>
                        </td>
                        <td>
                            <input readonly="" type="text" value="<?php echo $ordered_product->categoryName; ?>" class="medium" />
                        </td>
                    </tr>
                    <tr>
                       <td>
                            <label>Brand</label>
                        </td>
                        <td>
                            <input readonly="" type="text" value="<?php echo $ordered_product->brandName; ?>" class="medium" />
                        </td>
                    </tr>
                    <tr>
                       <td>
                            <label>Image</label>
                        </td>
                        <td>
                            <img src="<?php echo $ordered_product->image; ?>" alt="Product Image" />
                        </td>
                    </tr>
                    <tr>
                       <td>
                            <label>Price</label>
                        </td>
                        <td>
                            <input readonly="" type="text" value="<?php echo $ordered_product->price; ?>" class="medium" />
                        </td>
                    </tr>      
                    <tr> 
                        <td></td>
                        <td>
                            <input readonly="" type="submit" name="submit" Value="Done" />
                        </td>
                    </tr>
                </table>

                <?php } ?>

                </form>
            </div>
        </div>
    </div>
        
<?php include 'include/footer.php'; ?>
