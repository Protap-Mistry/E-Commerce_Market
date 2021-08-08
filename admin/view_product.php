<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>
<?php 
    if(!isset($_GET['product_id']) || $_GET['product_id']== null){
        
        echo "<script> window.location= 'productlist.php'; </script>";
    }
    else
    {
        $product_id= $_GET['product_id'];
    }
?>

    <div class="grid_10">
	
        <div class="box round first grid">
            <h2>View Product</h2>
           <div class="block copyblock"> 
             <form action="" method="POST">

                <?php 
                    $format= new Format();
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){

                        echo "<script> window.location= 'productlist.php'; </script>";
                      
                    }

                    $product= $format->selectProductById($product_id);

                    if($product){
                        
                ?>
                <table class="form">					
                    <tr>
                        <td>
                            <label>Name</label>
                        </td>
                        <td>
                            <input readonly="" type="text" value="<?php echo $product->productName; ?>" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Category</label>
                        </td>
                        <td>
                            <select id="select" readonly="">
                                

                                 <?php 

                                    $category= $format->showCategory();                     
                                    if($category){
                                        foreach ($category as $key => $value) {
                                
                                ?>

                                <option 
                                    <?php 
                                        if($product->category_id == $value['id'])
                                        { 
                                    ?>
                                        selected="selected";    
                                       
                                    <?php  } ?>

                                    value="<?php echo $value['id']; ?>"><?php echo $value['categoryName']; ?></option>

                                <?php }} ?>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Brand</label>
                        </td>
                        <td>
                            <select id="select" readonly="">
                                

                                 <?php 

                                    $brand= $format->showBrand();                     
                                    if($brand){
                                        foreach ($brand as $key => $value) {
                                
                                ?>

                                <option 
                                    <?php 
                                        if($product->brand_id == $value['id'])
                                        { 
                                    ?>
                                        selected="selected";    
                                       
                                    <?php  } ?>

                                    value="<?php echo $value['id']; ?>"><?php echo $value['brandName']; ?></option>

                                <?php }} ?>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Product Image</label>
                        </td>
                        <td>
                            <img src="<?php echo $product->image; ?>" height="100px" width="200px" alt="product_logo">
                        </td>
                    </tr>              
                    <tr>
                        <td style="vertical-align: top; padding-top: 9px;">
                            <label>Content</label>
                        </td>
                        <td>
                            <textarea class="tinymce" readonly="">
                                <?php echo $product->body; ?>
                            </textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>Price</label>
                        </td>
                        <td>
                            <input type="text" readonly="" value="<?php echo $product->price; ?>" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Type</label>
                        </td>
                        <td>
                            <select id="select" readonly="">
                                <option>Select Type</option>
                                <?php 
                                    if($select_product->type == 0){
                                ?>
                                    <option selected="selected" value="0">Featured</option>
                                    <option value="1">General</option>
                                <?php 

                                    }else{
                                ?>
                                    <option value="0">Featured</option>
                                    <option selected="selected" value="1">General</option>
                                <?php }?>
                            </select>
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
