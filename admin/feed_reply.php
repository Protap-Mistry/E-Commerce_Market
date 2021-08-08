<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>
<?php 
    if(!isset($_GET['feed_id']) || $_GET['feed_id']== null){

        echo "<script> window.location= 'inbox.php'; </script>";
    }
    else
    {
        $feed_id= $_GET['feed_id'];
    }
?>

    <div class="grid_10">
	
        <div class="box round first grid">
            <h2>Reply Feedback</h2>
           <div class="block copyblock"> 
             <form action="" method="POST">

                <?php 
                    $format= new Format();
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){

                        $reply_by_email= $format->feedReply($feed_id, $_POST);

                        if(isset($reply_by_email)){
                            echo $reply_by_email;
                       }
                      
                    }                       
                ?>

                <table class="form">					
                    <tr>
                        <td>
                            <label>To</label>
                        </td>

                        <?php 
                            $feedback= $format->viewFeedbackById($feed_id);

                            if($feedback){
                        ?>

                        <td>
                            <input readonly="" name="toemail" type="text" value="<?php echo $feedback->email; ?>" class="medium" />
                        </td>

                        <?php } ?>

                    </tr>
                    <tr>
                        <td>
                            <label>From</label>
                        </td>
                        <td>
                            <input name="fromemail" type="text" placeholder="Put Author E-mail" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Subject</label>
                        </td>
                        <td>
                            <input name="subject" type="text" placeholder="Put E-mail Subject" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Feedback</label>
                        </td>
                        <td>
                            <textarea name="reply" class="tinymce">
                                
                            </textarea>
                        </td>
                    </tr>
					<tr>
                        <td></td> 
                        <td>
                            <input readonly="" type="submit" name="submit" Value="Reply" />
                        </td>
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
