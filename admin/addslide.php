<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>

    <div class="grid_10">
	
        <div class="box round first grid">
            <h2>Add New Slide</h2>
            <div class="block">

             <form action="" method="POST" enctype="multipart/form-data">

                <?php 
                    $format= new Format();
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){

                        $slide= $format->addSlide($_POST);

                        if(isset($slide)){
                            echo $slide;
                       }
                    }
                ?>
            
                <table class="form">
                   
                    <tr>
                        <td>
                            <label>Title</label>
                        </td>
                        <td>
                            <input type="text" name="title" placeholder="Enter Slide Title..." class="medium" />
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
        
<?php include 'include/footer.php'; ?>