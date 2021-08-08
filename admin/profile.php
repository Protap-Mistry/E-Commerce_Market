<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>
<?php 
   $session_id= Session::get('id');
   $session_role= Session::get('role');
?>

    <div class="grid_10">
	
        <div class="box round first grid">
            <h2>User Profile</h2>
           <div class="block copyblock"> 
             <form action="" method="POST" enctype="multipart/form-data">

                <?php 
                    $format= new Format();
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){

                        $update_user= $format->updateUserProfile($session_id, $_POST);

                        if(isset($update_user)){
                            echo $update_user;
                            //echo "<script> window.location= 'userlist.php'; </script>";
                       }
                    }

                    $select_user= $format->selectUserByIdAndRole($session_id, $session_role);

                    if($select_user){
                        
                ?>
                <table class="form">					
                    <tr>
                        <td>
                            <label>Name</label>
                        </td>
                        <td>
                            <input type="text" name="name" value="<?php echo $select_user->name; ?>" class="medium" />
                        </td>
                    </tr>
                     <tr>
                        <td>
                            <label>Username</label>
                        </td>
                        <td>
                            <input type="text" name="username" value="<?php echo $select_user->username; ?>" class="medium" />
                        </td>
                    </tr>
                     <tr>
                        <td>
                            <label>E-mail</label>
                        </td>
                        <td>
                            <input type="text" name="email" value="<?php echo $select_user->email; ?>" class="medium" />
                        </td>
                    </tr>                    
                    <tr>
                        <td style="vertical-align: top; padding-top: 9px;">
                            <label>Details</label>
                        </td>
                        <td>
                            <textarea class="tinymce" name="details">
                                <?php echo $select_user->details; ?>
                            </textarea>
                        </td>
                    </tr>
                    
					<tr>
                        <td></td> 
                        <td>
                            <input type="submit" name="submit" Value="Update" />
                            <a class="btn btn-info" href="change_backend_pass.php?backend_user_id=<?php echo $select_user->id;?>">Password Change</a>
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
