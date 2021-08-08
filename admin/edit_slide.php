<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>
<?php 
    if(!isset($_GET['slide_id']) || $_GET['slide_id']== null){
        header("Location: slidelist.php");
    }
    else
    {
        $slide_id= $_GET['slide_id'];
    }
?>

    <div class="grid_10">
	
        <div class="box round first grid">
            <h2>Update a Slider</h2>
           <div class="block copyblock"> 
             <form action="" method="POST" enctype="multipart/form-data">

                <?php 
                    $format= new Format();
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){

                        $update_the_slide= $format->updateTheSlide($slide_id, $_POST);

                        if(isset($update_the_slide)){
                            echo $update_the_slide;
                            echo "<script> window.location= 'slidelist.php'; </script>";
                       }
                    }

                    $select_the_slide= $format->selectTheSlideById($slide_id);

                    if($select_the_slide){
                        
                ?>
                <table class="form">					
                    <tr>
                        <td>
                            <label>Title</label>
                        </td>
                        <td>
                            <input type="text" name="title" value="<?php echo $select_the_slide->title; ?>" class="medium" />
                        </td>
                    </tr>
                                     
                    <tr>
                        <td>
                            <label>Upload Image</label>
                        </td>
                        <td>
                            <img src="<?php echo $select_the_slide->image; ?>" height="50px" width="70px" alt="slider_image">
                            <input type="file" name="image"/>
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
