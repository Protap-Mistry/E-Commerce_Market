<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
    Session::checkSession();
?>

<?php 
    if(isset($_GET['backend_user_id']))
    {
        $userid= (int) $_GET['backend_user_id']; 
        $sesid= Session::get("id");

        if($userid!=$sesid)
        {
            header("Location: index.php");
        }               
    }   
    $format= new Format();

    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit']))
    {
        $updatepass= $format-> updatePassword($userid, $_POST);
    }
?>

    <div class="grid_10">
	
        <div class="box round first grid">
            <h2>Change Password</h2>
            <div class="block"> 
                <?php
                    if(isset($updatepass))
                    {
                        echo $updatepass;
                    }
                ?>              
             <form action="" method="POST">
                <table class="form">					
                    <tr>
                        <td>
                            <label>Old Password</label>
                        </td>
                        <td>
                            <input type="password" placeholder="Enter Old Password..."  name="old_pass" class="medium" />
                        </td>
                    </tr>
					 <tr>
                        <td>
                            <label>New Password</label>
                        </td>
                        <td>
                            <input type="password" placeholder="Enter New Password..." name="new_pass" class="medium" />
                        </td>
                    </tr>
					 
					
					 <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submit" Value="Update" />
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        </div>
    </div>
        
<?php include 'include/footer.php'; ?>