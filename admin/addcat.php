<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>

        <div class="grid_10">
		
            <div class="box round first grid">
                <h2>Add New Category</h2>
               <div class="block copyblock"> 
                 <form action="" method="POST">

                    <?php 
                        $format= new Format();
                        if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])){

                            $category= $format->addCategory($_POST);

                            if(isset($category)){
                                echo $category;
                           }
                        }
                    ?>
                    <table class="form">					
                        <tr>
                            <td>Category Name</td>
                            <td>
                                <input type="text" name="categoryName" placeholder="Enter Category Name..." class="medium" />
                            </td>
                        </tr>
						<tr>
                            <td></td> 
                            <?php 
                                if(Session::get('role') == '0' || Session::get('role') == '2')
                                {
                            ?>

                            <td>
                                <input type="submit" name="submit" Value="Add" />
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
        
<?php include 'include/footer.php'; ?>
