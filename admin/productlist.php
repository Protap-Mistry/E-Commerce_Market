<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>

    <div class="grid_10">
        <div class="box round first grid">
            <h2>Product List</h2>
            <div class="block">

        		<!--delete portion -->
				<?php
					$format= new Format();

					if(isset($_GET['product_id']))
					{
						$id= $_GET['product_id'];

						$delete_product= $format->deleteProduct($id);
						
						if($delete_product){
							echo $delete_product;
						}
					}
				?>

                <table class="data display datatable" id="example">
				<thead>
					<tr>
						<th width="2%">Serial</th>
						<th width="10%">Name</th>
						<th width="10%">Category</th>
						<th width="5%">Brand</th>
						<th width="5%">Image</th>
						<th width="10%">Description</th>
						<th width="5%">Price</th>
						<th width="5%">Type</th>
						<th width="10%">Date</th>
						<th width="15%">Actions</th>
					</tr>
				</thead>
				<tbody>

					<?php 
						$product= $format->showProductList();						
						if($product){
							$i=0;
							foreach ($product as $key => $value) {
								$i++;
					
					?>

					<tr class="odd gradeX">
						<td><?php echo $i; ?></td>
						<td><?php echo $value['productName']; ?></td>
						<td><?php echo $value['categoryName']; ?></td>
						<td><?php echo $value['brandName']; ?></td>
						<td><img src="<?php echo $value['image']; ?>" alt="Product Image" height="40px" width="60px"/></td>
						<td><?php echo $format->textShorten($value['body'], 50); ?></td>
						<td>$ <?php echo $value['price']; ?></td>
						<td>
							<?php 
								if($value['type'] == 0){
									echo "Featured";
								}else{
									echo "General";
								}
							?>
								
							</td>
						<td><?php echo $format->formatDate($value['date']); ?></td>

						<td>
							<a href="view_product.php?product_id=<?php echo $value['id']; ?>">View</a>

							<?php 
								if(Session::get('id') == $value['id'] || Session::get('role') == '0')
								{
							?>

								|| <a href="edit_product.php?product_id=<?php echo $value['id']; ?>">Update</a> || 		
								<a onclick="return confirm('Are u sure to delete?');" href="?product_id=<?php echo $value['id']; ?>">Delete</a>

							<?php } ?>

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