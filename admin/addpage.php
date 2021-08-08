<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>

    <div class="grid_10">
	
        <div class="box round first grid">
            <h2>Add New Page</h2>
            <div class="block">

             <form action="" method="POST">

                <?php 
                    $format= new Format();
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){

                        $page= $format->addPage($_POST);

                        if(isset($page)){
                            echo $page;
                       }
                    }
                ?>
            
                <table class="form">
                   
                    <tr>
                        <td>
                            <label>Your page name</label>
                        </td>
                        <td>
                            <input type="text" name="name" placeholder="Enter Your Page Title..." class="medium" />
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
                        <td></td>

                        <?php 
                            if(Session::get('role') == '0' || Session::get('role') == '2')
                            {
                        ?> 

                        <td>
                            <input type="submit" name="submit" Value="Create" />
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