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
            <h2>View Feedback</h2>
           <div class="block copyblock"> 
             <form action="" method="POST">

                <?php 
                    $format= new Format();
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){

                        echo "<script> window.location= 'inbox.php'; </script>";
                      
                    }

                    $feedback= $format->viewFeedbackById($feed_id);

                    if($feedback){
                        
                ?>
                <table class="form">					
                    <tr>
                        <td>
                            <label>Name</label>
                        </td>
                        <td>
                            <input readonly="" type="text" value="<?php echo $feedback->name; ?>" class="medium" />
                        </td>
                    </tr>              
                    
                    <tr>
                        <td>
                            <label>E-mail</label>
                        </td>
                        <td>
                            <input readonly="" type="text" value="<?php echo $feedback->email; ?>" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Feedback</label>
                        </td>
                        <td>
                            <textarea readonly="" class="tinymce">
                                <?php echo $feedback->body; ?>
                            </textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Date</label>
                        </td>
                        <td>
                            <input readonly="" type="text" value="<?php echo $format->formatDate($feedback->date); ?>" class="medium" />
                        </td>
                    </tr>
					<tr> 
                        <td></td>
                        <td>
                            <input readonly="" type="submit" name="submit" Value="Done" />
                        </td>
                    </tr>
                </table>

                <?php } ?>

                </form>
            </div>
        </div>
    </div>
        
<?php include 'include/footer.php'; ?>
