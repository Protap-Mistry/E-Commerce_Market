<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>
<?php 
    if(!isset($_GET['user_id']) || $_GET['user_id']== null){
        
        echo "<script> window.location= 'userlist.php'; </script>";
    }
    else
    {
        $user_id= $_GET['user_id'];
    }
?>

    <div class="grid_10">
	
        <div class="box round first grid">
            <h2>View Users</h2>
           <div class="block copyblock"> 
             <form action="" method="POST">

                <?php 
                    $format= new Format();
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){

                        echo "<script> window.location= 'userlist.php'; </script>";
                      
                    }

                    $user= $format->viewUserById($user_id);

                    if($user){
                        
                ?>
                <table class="form">					
                    <tr>
                        <td>
                            <label>Name</label>
                        </td>
                        <td>
                            <input readonly="" type="text" value="<?php echo $user->name; ?>" class="medium" />
                        </td>
                    </tr>              
                     <tr>
                        <td>
                            <label>Username</label>
                        </td>
                        <td>
                            <input readonly="" type="text" value="<?php echo $user->username; ?>" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>E-mail</label>
                        </td>
                        <td>
                            <input readonly="" type="text" value="<?php echo $user->email; ?>" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Details</label>
                        </td>
                        <td>
                            <textarea readonly="" class="tinymce">
                                <?php echo $user->details; ?>
                            </textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Role</label>
                        </td>
                        <td>
                            <input readonly="" type="text" value="<?php

                            if($user->role == '0'){
                                echo 'Admin';
                            }elseif($user->role == '1'){
                                echo 'Author';
                            }else{
                                echo 'Editor';
                            } ?>" class="medium" />
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
