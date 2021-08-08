<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>

<?php 
    if(!Session::get('role') == '0'){
        echo "<script> window.location= 'index.php'; </script>";
    }
?>

    <div class="grid_10">
	
        <div class="box round first grid">
            <h2>Add New User</h2>
           <div class="block copyblock"> 
             <form action="" method="POST">

                <?php 
                    $format= new Format();
                    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])){

                        $user= $format->addUser($_POST);

                        if(isset($user)){
                            echo $user;
                       }
                    }
                ?>
                <table class="form">					
                    <tr>
                        <td><label>Username</label></td>
                        <td>
                            <input type="text" name="username" placeholder="Enter User Name..." class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td><label>E-mail</label></td>
                        <td>
                            <input type="text" name="email" placeholder="Enter Your E-mail Address..." class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td><label>Password</label></td>
                        <td>
                            <input type="password" name="password" placeholder="Enter Your Password..." class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td><label>User Category</label></td>
                        <td>
                            <select id="select" name="role">
                                <option>Select User Role</option>
                                <option value="0">Admin</option>
                                <option value="1">Author</option>
                                <option value="2">Editor</option>
                            </select>                                
                        </td>
                    </tr>
					<tr>
                        <td></td> 
                        <td>
                            <input type="submit" name="submit" Value="Add" />
                            <input type="reset" name="clear" Value="Clear" />
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        </div>
    </div>
        
<?php include 'include/footer.php'; ?>
