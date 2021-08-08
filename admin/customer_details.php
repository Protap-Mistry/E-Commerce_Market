<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>
<?php 
    if(!isset($_GET['customer_id']) || $_GET['customer_id']== null){
        
        echo "<script> window.location= 'order_details.php'; </script>";
    }
    else
    {
        $customer_id= $_GET['customer_id'];
    }
?>

    <div class="grid_10">
    
        <div class="box round first grid">
            <h2>Ordered Customer Details</h2>
           <div class="block copyblock"> 
             <form action="" method="POST">

                <?php 
                    $format= new Format();
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){

                        echo "<script> window.location= 'order_details.php'; </script>";
                      
                    }

                    $ordered_customer= $format->getCustomerById($customer_id);

                    if($ordered_customer){
                        
                ?>
                <table class="form">                    
                    <tr>
                        <td>
                            <label>Name</label>
                        </td>
                        <td>
                            <input readonly="" type="text" value="<?php echo $ordered_customer->customerName; ?>" class="medium" />
                        </td>
                    </tr>              
                    <tr>
                       <td>
                            <label>Country</label>
                        </td>
                        <td>
                            <input readonly="" type="text" value="<?php echo $ordered_customer->country; ?>" class="medium" />
                        </td>
                    </tr>
                    <tr>
                       <td>
                            <label>City</label>
                        </td>
                        <td>
                            <input readonly="" type="text" value="<?php echo $ordered_customer->city; ?>" class="medium" />
                        </td>
                    </tr>
                    <tr>
                       <td>
                            <label>Zipcode</label>
                        </td>
                        <td>
                            <input readonly="" type="text" value="<?php echo $ordered_customer->zipcode; ?>" class="medium" />
                        </td>
                    </tr>
                    <tr>
                       <td>
                            <label>Address</label>
                        </td>
                        <td>
                            <input readonly="" type="text" value="<?php echo $ordered_customer->address; ?>" class="medium" />
                        </td>
                    </tr>
                    <tr>
                       <td>
                            <label>Phone</label>
                        </td>
                        <td>
                            <input readonly="" type="text" value="<?php echo $ordered_customer->phone; ?>" class="medium" />
                        </td>
                    </tr> 
                    <tr>
                        <td>
                            <label>E-mail</label>
                        </td>
                        <td>
                            <input readonly="" type="text" value="<?php echo $ordered_customer->email; ?>" class="medium" />
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
