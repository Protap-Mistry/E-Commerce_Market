<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>

    <div class="grid_10">
	
        <div class="box round first grid">
            <h2>Update Site Title and Description</h2>
            <div class="block sloginblock">
                <div style="float: left; width: 70%;">                                                 
                    <form action="" method="POST" enctype="multipart/form-data">

                        <?php
                            $format= new Format();
                            if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']))
                            {

                                $update_title_slogan= $format->updateTitleSlogan($_POST);

                                if(isset($update_title_slogan)){
                                    echo $update_title_slogan;
                               }
                            }

                            $title_slogan= $format->showTitleSlogan();                     
                            if($title_slogan)
                            {
                                foreach ($title_slogan as $key => $value)
                                {   
                                
                        ?>

                        <table class="form">
                            					
                            <tr>
                                <td>
                                    <label>Website Title</label>
                                </td>
                                <td>
                                    <input type="text" value="<?php echo $value['title']; ?>"  name="title" class="medium" />
                                </td>
                            </tr>
        					 <tr>
                                <td>
                                    <label>Website Slogan</label>
                                </td>
                                <td>
                                    <input type="text" value="<?php echo $value['slogan'];; ?>" name="slogan" class="medium" />
                                </td>
                            </tr>
        					 <tr>
                                <td>
                                    <label>Website Logo</label>
                                </td>
                                <td>
                                    <input type="file" name="logo" />
                                </td>
                            </tr>
        					
        					 <tr>
                                <td></td>

                               <?php 
                                    if(Session::get('role') == '0' || Session::get('role') == '2')
                                    {
                                ?> 

                                    <td>
                                        <input type="submit" name="submit" Value="Update" />
                                    </td>

                                <?php }else { ?>
                         
                                <div style="color:red; font-weight: bold;">
                                    <?php echo "No Update option available for *Author";} ?>
                                </div>

                            </tr>
                        </table>
                    </form>
                </div>
                <div style="float: left; width: 20%;">
                    Logo <br>
                    <img src="<?php echo $value['logo']; ?>" alt="logo" height="150px" width="170px" name="logo">
                </div>

                <?php } } ?>

            </div>
        </div>
    </div>
        
<?php include 'include/footer.php'; ?>