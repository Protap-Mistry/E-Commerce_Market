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
            <h2>Update a Product</h2>
           <div class="block copyblock"> 
             <form action="" method="POST" enctype="multipart/form-data">

                <?php 
                    $format= new Format();
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){

                        $update_product= $format->updateProduct($product_id, $_POST);

                        if(isset($update_product)){
                            echo $update_product;
                            echo "<script> window.location= 'productlist.php'; </script>";
                       }
                    }

                    $select_product= $format->selectProductById($product_id);

                    if($select_product){
                        
                ?>
                <table class="form">					
                    <tr>
                        <td>
                            <label>Name</label>
                        </td>
                        <td>
                            <input type="text" name="productName" value="<?php echo $select_product->productName; ?>" class="medium" />
                        </td>
                    </tr>
                 
                    <tr>
                        <td>
                            <label>Category</label>
                        </td>
                        <td>
                            <select id="select" name="category_id">
                                <option>Select Category</option>

                                 <?php 

                                    $category= $format->showCategory();                     
                                    if($category){
                                        foreach ($category as $key => $value) {
                                
                                ?>

                                <option 
                                    <?php 
                                        if($select_product->category_id == $value['id'])
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
                            <select id="select" name="brand_id">
                                <option>Select Brand</option>

                                <?php 

                                    $brand= $format->showBrand();                     
                                    if($brand){
                                        foreach ($brand as $key => $value) {
                                
                                ?>

                                <option 
                                    <?php 
                                        if($select_product->brand_id == $value['id'])
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
                            <label>Upload Image</label>
                        </td>
                        <td>
                            <img src="<?php echo $select_product->image; ?>" height="50px" width="70px" alt="product_logo">
                            <input type="file" name="image"/>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-top: 9px;">
                            <label>Content</label>
                        </td>
                        <td>
                            <textarea class="tinymce" name="body">
                                <?php echo $select_product->body; ?>
                            </textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Price</label>
                        </td>
                        <td>
                            <input type="text" name="price" value="<?php echo $select_product->price; ?>" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Type</label>
                        </td>
                        <td>
                            <select id="select" name="type">
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
                            <input type="submit" name="submit" Value="Update" />
                        </td>
                    </tr>
                </table>

                <?php } ?>

                </form>
            </div>
        </div>
    </div>
     <!-- Load TinyMCE -->
    <script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            setupTinyMCE();
            setDatePicker('date-picker');
            $('input[type="checkbox"]').fancybutton();
            $('input[type="radio"]').fancybutton();
        });
    </script>
       
<?php include 'include/footer.php'; ?>
