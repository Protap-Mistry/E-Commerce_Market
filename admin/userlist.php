<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>

    <div class="grid_10">
        <div class="box round first grid">
            <h2>Backend Users List</h2>
            <div class="block">

        		<!--delete portion -->
				<?php
					$format= new Format();

					if(isset($_GET['user_id']))
					{
						$id= $_GET['user_id'];

						$delete_user= $format->deleteUser($id);
						
						if($delete_user){
							echo $delete_user;
						}
					}
				?>

                <table class="data display datatable" id="example">
				<thead>
					<tr>
						<th width="5%">Serial</th>
						<th width="10%">Name</th>
						<th width="10%">Username</th>
						<th width="10%">E-mail</th>
						<th width="20%">Details</th>
						<th width="5%">Role</th>
						<th width="10%">Actions</th>
					</tr>
				</thead>
				<tbody>

					<?php
						$format= new Format();

						$users= $format->showUserList();						
						if($users){
							$i=0;
							foreach ($users as $key => $value) {
								$i++;
					
					?>

					<tr class="odd gradeX">
						<td><?php echo $i; ?></td>
						<td><?php echo $value['name']; ?></a></td>
						<td><?php echo $value['username']; ?></td>
						<td><?php echo $value['email']; ?></td>
						<td><?php echo $format->textShorten($value['details'], 200); ?></td>
						<td>
							<?php 
								if($value['role'] == '0'){
									echo "Admin";
								}elseif($value['role'] == '1'){
									echo "Author";
								}else
								{
									echo "Editor";
								}
							 ?>								
						</td>
						<td>
							<a href="view_user.php?user_id=<?php echo $value['id']; ?>">View</a>

							<?php 
								if(Session::get('id') == $value['id'] || Session::get('role') == '0')
								{
							?>

								|| <a onclick="return confirm('Are u sure to delete?');" href="?user_id=<?php echo $value['id']; ?>">Delete</a>

							<?php } ?>

						</td>
					</tr>
					
					<?php }} ?>

				</tbody>
			</table>

           </div>
        </div>

         <div class="box round first grid">
            <h2>Frontend Users List</h2>
            <div class="block">

        		<!--delete portion -->
				<?php
					$format= new Format();

					if(isset($_GET['f_user_id']))
					{
						$id= $_GET['f_user_id'];

						$f_delete_user= $format->deleteFrontendUser($id);
						
						if($f_delete_user){
							echo $f_delete_user;
						}
					}
				?>

                <table class="data display datatable" id="example">
				<thead>
					<tr>
						<th width="5%">Serial</th>
						<th width="10%">Name</th>
						<th width="5%">Country</th>
						<th width="10%">City</th>
						<th width="5%">Zipcode</th>
						<th width="10%">Address</th>
						<th width="10%">Phone</th>
						<th width="10%">E-mail</th>
						<th width="5%">Action</th>
					</tr>
				</thead>
				<tbody>

					<?php
						$format= new Format();

						$fusers= $format->showFrontendUserList();						
						if($fusers){
							$i=0;
							foreach ($fusers as $key => $value) {
								$i++;
					
					?>

					<tr class="odd gradeX">
						<td><?php echo $i; ?></td>
						<td><?php echo $value['customerName']; ?></a></td>
						<td><?php echo $value['country']; ?></td>
						<td><?php echo $value['city']; ?></td>
						<td><?php echo $value['zipcode']; ?></td>
						<td><?php echo $value['address']; ?></td>
						<td><?php echo $value['phone']; ?></td>
						<td><?php echo $value['email']; ?></td>
						
						<td>

							<?php 
								if(Session::get('id') == $value['id'] || Session::get('role') == '0')
								{
							?>

								<a onclick="return confirm('Are u sure to delete?');" href="?f_user_id=<?php echo $value['id']; ?>">Delete</a>

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