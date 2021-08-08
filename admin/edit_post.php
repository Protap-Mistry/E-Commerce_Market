<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>
<?php 
    if(!isset($_GET['post_id']) || $_GET['post_id']== null){
        header("Location: postlist.php");
    }
    else
    {
        $post_id= $_GET['post_id'];
    }
?>

    <div class="grid_10">
	
        <div class="box round first grid">
            <h2>Update a Post</h2>
           <div class="block copyblock"> 
             <form action="" method="POST" enctype="multipart/form-data">

                <?php 
                    $format= new Format();
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){

                        $update_post= $format->updatePost($post_id, $_POST);

                        if(isset($update_post)){
                            echo $update_post;
                            echo "<script> window.location= 'postlist.php'; </script>";
                       }
                    }

                    $select_post= $format->selectPostById($post_id);

                    if($select_post){
                        
                ?>
                <table class="form">					
                    <tr>
                        <td>
                            <label>Title</label>
                        </td>
                        <td>
                            <input type="text" name="title" value="<?php echo $select_post->title; ?>" class="medium" />
                        </td>
                    </tr>
                 
                    <tr>
                        <td>
                            <label>Category</label>
                        </td>
                        <td>
                            <select id="select" name="category">
                                <option>Select Category</option>

                                 <?php 

                                    $category= $format->showPostCategory();                     
                                    if($category){
                                        foreach ($category as $key => $value) {
                                
                                ?>

                                <option 
                                    <?php 
                                        if($select_post->category_id == $value['id'])
                                        { 
                                    ?>
                                        selected="selected";    
                                       
                                    <?php  } ?>

                                    value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>

                                <?php }} ?>

                            </select>
                        </td>
                    </tr>
               
                    <tr>
                        <td>
                            <label>Upload Image</label>
                        </td>
                        <td>
                            <img src="<?php echo $select_post->image; ?>" height="50px" width="70px" alt="post_logo">
                            <input type="file" name="image"/>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-top: 9px;">
                            <label>Content</label>
                        </td>
                        <td>
                            <textarea class="tinymce" name="body">
                                <?php echo $select_post->body; ?>
                            </textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Author</label>
                        </td>
                        <td>
                            <input type="text" name="author" value="<?php echo Session::get('username'); ?>" class="medium" />
                            <input type="hidden" name="userid" value="<?php echo Session::get('id'); ?>" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Tag(s)</label>
                        </td>
                        <td>
                            <input type="text" name="tags" value="<?php echo $select_post->tags; ?>" class="medium" />
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
