<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>

    <div class="grid_10">
	
        <div class="box round first grid">
            <h2>Update or delete a Page</h2>
            <div class="block">

            <?php 
                if(!isset($_GET['page_id']) || $_GET['page_id']== null){
                    echo "Ooops!!! no pages found.";
                }
                else
                {
                    $page_id= $_GET['page_id'];
                }
            ?>

            <form action="" method="POST">

                <?php
                    $format= new Format();

                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){

                        $update_page= $format->updatePage($page_id, $_POST);

                        if(isset($update_page)){
                            echo $update_page;
                       }
                    }

                    $select_page= $format->selectPageById($page_id);

                    if($select_page){
                        
                ?>
            
                <table class="form">
                   
                    <tr>
                        <td>
                            <label>Your page name</label>
                        </td>
                        <td>
                            <input type="text" name="name" value="<?php echo $select_page->name; ?>" class="medium" />
                        </td>
                    </tr>
                
                    <tr>
                        <td style="vertical-align: top; padding-top: 9px;">
                            <label>Content</label>
                        </td>
                        <td>
                            <textarea class="tinymce" name="body">
                                <?php echo $select_page->body; ?>
                            </textarea>
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
                            <span><a href="delete_page.php?delete_id=<?php echo $select_page->id; ?>" style="text-decoration: none; background-color: gray; color: red; padding: 10px 15px;" onclick= "return confirm('Are u sure to remove?')" >Delete</a></span>
                        </td>

                        <?php }else { ?>
                         
                        <div style="color:red; font-weight: bold;">
                            <?php echo "No update or delete option available for *Author";} ?>
                        </div>

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