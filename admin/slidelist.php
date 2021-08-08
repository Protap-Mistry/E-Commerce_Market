<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php'; 
?>

    <div class="grid_10">
        <div class="box round first grid">
            <h2>Slider List</h2>
            <div class="block">

        		<!--delete portion -->
				<?php
					$format= new Format();

					if(isset($_GET['slide_id']))
					{
						$id= $_GET['slide_id'];

						$del_slide= $format->deleteSlide($id);
						
						if($del_slide){
							echo $del_slide;
						}
					}
				?>

                <table class="data display datatable" id="example">
				<thead>
					<tr>
						<th width="2%">Serial</th>
						<th width="10%">Slide Title</th>
						<th width="5%">Image</th>
						<th width="13%">Actions</th>
					</tr>
				</thead>
				<tbody>

					<?php 
						$slide= $format->showSlideList();						
						if($slide){
							$i=0;
							foreach ($slide as $key => $value) {
								$i++;
					
					?>

					<tr class="odd gradeX">
						<td><?php echo $i; ?></td>
						<td><?php echo $value['title']; ?></a></td>
						<td><img src="<?php echo $value['image']; ?>" height="40px" width="60px"/></td>

						<td>

							<?php 
								if(Session::get('role') == '0' || Session::get('role') == '2')
								{
							?>

								<a href="edit_slide.php?slide_id=<?php echo $value['id']; ?>">Update</a> || 		
								<a onclick="return confirm('Are u sure to delete?');" href="?slide_id=<?php echo $value['id']; ?>">Delete</a>

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