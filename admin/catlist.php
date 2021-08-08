<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>

        <div class="grid_10">
            <div class="box round first grid">
                <h2>Category List</h2>
                <div class="block">

		           	<!--delete portion -->
					<?php
						$format= new Format();

						if(isset($_GET['catid']))
						{
							$id= $_GET['catid'];

							$delete_cat= $format->deleteCategory($id);
							
							if($delete_cat){
								echo $delete_cat;
							}
						}
					?>

                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>Serial No.</th>
							<th>Category Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>

						<?php 

							$category= $format->showCategory();						
							if($category){
								$i=0;
								foreach ($category as $key => $value) {
									$i++;
						
						?>

						<tr class="odd gradeX">
							<td><?php echo $i; ?></td>
							<td><?php echo $value['categoryName']; ?></td>
							<td>

								<?php 
									if(Session::get('role') == '0' || Session::get('role') == '2')
									{
								?>
									<a href="editcat.php?catid=<?php echo $value['id']; ?>">Edit</a> || <a onclick="return confirm('Are u sure to delete?');" href="catlist.php?catid=<?php echo $value['id']; ?>">Delete
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
