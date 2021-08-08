<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>

    <div class="grid_10">
	
        <div class="box round first grid">
            <h2>Update Social Media</h2>
            <div class="block">               
             <form action="" method="POST">

                <?php
                    $format= new Format();
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']))
                    {

                        $update_social= $format->updateSocial($_POST);

                        if(isset($update_social)){
                            echo $update_social;
                       }
                    }

                    $social= $format->showSocial();                     
                    if($social)
                    {
                        foreach ($social as $key => $value)
                        {   
                        
                ?>

                <table class="form">					
                    <tr>
                        <td>
                            <label>Facebook</label>
                        </td>
                        <td>
                            <input type="text" name="fb" value="<?php echo $value['fb']; ?>" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Whatsapp</label>
                        </td>
                        <td>
                            <input type="text" name="wapp" value="<?php echo $value['wapp']; ?>" class="medium" />
                        </td>
                    </tr>

					 <tr>
                        <td>
                            <label>Twitter</label>
                        </td>
                        <td>
                            <input type="text" name="twtr" value="<?php echo $value['twtr']; ?>" class="medium" />
                        </td>
                    </tr>
					
					 <tr>
                        <td>
                            <label>E-mail</label>
                        </td>
                        <td>
                            <input type="text" name="email" value="<?php echo $value['email']; ?>" class="medium" />
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

                <?php }} ?>

                </form>
            </div>
        </div>
    </div>
        
<?php include 'include/footer.php'; ?>
