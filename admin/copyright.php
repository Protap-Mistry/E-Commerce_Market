<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>

    <div class="grid_10">
	
        <div class="box round first grid">
            <h2>Update Copyright Text</h2>
            <div class="block copyblock"> 
             <form action="" method="POST">

                <?php
                    $format= new Format();
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']))
                    {

                        $update_copyright= $format->updateFooterCopyright($_POST);

                        if(isset($update_copyright)){
                            echo $update_copyright;
                       }
                    }

                    $footer= $format->showFooterCopyright();                     
                    if($footer)
                    {
                        foreach ($footer as $key => $value)
                        {   
                        
                ?>

                <table class="form">					
                    <tr>
                        <td>
                            <label for="">Copyright</label>
                        </td>
                        <td>
                            <input type="text" value="<?php echo $value['text']; ?>" name="copyright" class="large" />
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

                <?php } } ?>

                </form>
            </div>
        </div>
    </div>
        
<?php include 'include/footer.php'; ?>
