<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>

        <div class="grid_10">
            <div class="box round first grid">
                <h2>Brand List</h2>
                <div class="block">

		           	<!--delete portion -->
					<?php
						$format= new Format();

						if(isset($_GET['brand_id']))
						{
							$id= $_GET['brand_id'];

							$delete_brand= $format->deleteBrand($id);
							
							if($delete_brand){
								echo $delete_brand;
							}
						}
					?>

                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>Serial No.</th>
							<th>Brand Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>

						<?php 

							$brand= $format->showBrand();						
							if($brand){
								$i=0;
								foreach ($brand as $key => $value) {
									$i++;
						
						?>

						<tr class="odd gradeX">
							<td><?php echo $i; ?></td>
							<td><?php echo $value['brandName']; ?></td>
							<td>

								<?php 
									if(Session::get('role') == '0' || Session::get('role') == '2')
									{
								?>
									<a href="editbrand.php?brand_id=<?php echo $value['id']; ?>">Edit</a> || <a onclick="return confirm('Are u sure to delete?');" href="brandlist.php?brand_id=<?php echo $value['id']; ?>">Delete
									</a>

								<?php }else { ?>
                         
	                            <div style="color:red; font-weight: bold;">
	                                <?php echo "No action available for *Author";} ?>
	                            </div>

							</td>
						</tr>

						<?php }} ?>

					</tbody>
				</table>
               </div>
            </div>
        </div>

    <script type="text/javascript">
        $(document).ready(function () {
            setupLeftMenu();
            $('.datatable').dataTable();
			setSidebarHeight();
        });
    </script>

<?php include 'include/footer.php'; ?>
