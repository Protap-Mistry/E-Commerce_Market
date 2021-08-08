<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>

        <div class="grid_10">
		
            <div class="box round first grid">
                <h2>Add New Brand</h2>
               <div class="block copyblock"> 
                 <form action="" method="POST">

                    <?php 
                        $format= new Format();
                        if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])){

                            $brand= $format->addBrand($_POST);

                            if(isset($brand)){
                                echo $brand;
                           }
                        }
                    ?>
                    <table class="form">					
                        <tr>
                            <td>Brand Name</td>
                            <td>
                                <input type="text" name="brandName" placeholder="Enter Brand Name..." class="medium" />
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
