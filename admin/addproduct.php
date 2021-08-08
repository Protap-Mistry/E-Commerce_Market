<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>

    <div class="grid_10">
	
        <div class="box round first grid">
            <h2>Add New Product</h2>
            <div class="block">

             <form action="" method="POST" enctype="multipart/form-data">

                <?php 
                    $format= new Format();
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){

                        $product= $format->addProduct($_POST);

                        if(isset($product)){
                            echo $product;
                       }
                    }
                ?>
            
                <table class="form">
                   
                    <tr>
                        <td>
                            <label>Product Name</label>
                        </td>
                        <td>
                            <input type="text" name="productName" placeholder="Enter Product Title..." class="medium" />
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

                                <option value="<?php echo $value['id']; ?>"><?php echo $value['categoryName']; ?></option>

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

                                <option value="<?php echo $value['id']; ?>"><?php echo $value['brandName']; ?></option>

                                <?php }} ?>

                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>Upload Image</label>
                        </td>
                        <td>
                            <input type="file" name="image"/>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-top: 9px;">
                            <label>Content</label>
                        </td>
                        <td>
                            <textarea class="tinymce" name="body"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Price</label>
                        </td>
                        <td>
                            <input type="text" name="price" placeholder="Enter product price..." class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Type</label>
                        </td>
                        <td>
                            <select id="select" name="type">
                                <option>Select Type</option>
                                <option value="0">Featured</option>
                                <option value="1">General</option>
                            </select>
                        </td>
                    </tr>
                    
					<tr>
                        <td></td>

                        <?php
 
                            if(Session::get('role') == '0' || Session::get('role') == '2')
                            {
                        ?>
                            <td>
                                <input type="submit" name="submit" Value="Save" />
                            </td>

                        <?php }else { ?>
                         
                            <div style="color:red; font-weight: bold;">
                                <?php echo "No create option available for *Author";} ?>
                            </div>
                    </tr>
                </table>
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