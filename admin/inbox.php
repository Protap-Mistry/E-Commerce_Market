<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php';
    session::init();
    Session::checkSession(); 
?>

    <div class="grid_10">
        <div class="box round first grid">
            <h2>Inbox</h2>

            <?php 
				$feed_msg= Session::get("feed_msg");
			    if(isset($feed_msg))
			    {
			        echo $feed_msg;
			    }
			    Session::set("feed_msg", NULL);
			?>

            <div class="block"> 

				<?php
					$format= new Format();

					if(isset($_GET['feed_id']))
					{
						$id= $_GET['feed_id'];

						$status_update= $format->updateSeenFeedStatus($id);
						if($status_update){
							echo $status_update;
						}
					}
				?>

                <table class="data display datatable" id="example">
				<thead>
					<tr>
						<th width="5%">Serial</th>
						<th width="10%">Name</th>
						<th width="10%">Email</th>
						<th width="20%">Message(s)</th>
						<th width="12%">Date</th>
						<th width="10%">Action</th>
					</tr>
				</thead>
				<tbody>

					<?php
						$format= new Format();

						$feedback= $format->showFeedbackList();						
						if($feedback){
							$i=0;
							foreach ($feedback as $key => $value) {
								$i++;
					
					?>

					<tr class="odd gradeX">
						<td><?php echo $i; ?></td>
						<td><?php echo $value['name']; ?></td>
						<td><?php echo $value['email']; ?></td>
						<td><?php echo $format->textShorten($value['body'], 200); ?></td>
						<td><?php echo $format->formatDate($value['date']); ?></td>
						
						<td>
							<a href="feed_view.php?feed_id=<?php echo $value['id']; ?>">View</a>

							<?php 
	                            if(Session::get('role') == '0' || Session::get('role') == '2')
	                            {
	                        ?> 

							|| <a href="feed_reply.php?feed_id=<?php echo $value['id']; ?>">Reply</a> || 
							<a onclick="return confirm('Are u sure to move into trash?');" href="?feed_id=<?php echo $value['id']; ?>">Seen</a>

							<?php } ?>

						</td>
					</tr>
					
					<?php } }?>

				</tbody>
			</table>
           </div>
        </div>


        <div class="box round first grid">
            <h2>Seen Message(s)</h2>

            <?php 
				$feed_dlt_msg= Session::get("feed_dlt_msg");
			    if(isset($feed_dlt_msg))
			    {
			        echo $feed_dlt_msg;
			    }
			    Session::set("feed_dlt_msg", NULL);

			?>

            <div class="block">

            	<!--delete portion -->
				<?php
					$format= new Format();

					if(isset($_GET['seen_feed_id']))
					{
						$id= $_GET['seen_feed_id'];

						$delete_feed= $format->deleteSeenFeeds($id);
						if($delete_feed)
						{
							echo $delete_feed;							
						}						
					}
				?>

                <table class="data display datatable" id="example">
				<thead>
					<tr>
						<th width="5%">Serial</th>
						<th width="10%">Name</th>
						<th width="10%">Email</th>
						<th width="20%">Message(s)</th>
						<th width="12%">Date</th>
						<th width="10%">Action</th>
					</tr>
				</thead>
				<tbody>

					<?php
						$format= new Format();

						$seen_feedback= $format->showSeenFeedbackList();						
						if($seen_feedback){
							$i=0;
							foreach ($seen_feedback as $key => $value) {
								$i++;
					
					?>

					<tr class="odd gradeX">
						<td><?php echo $i; ?></td>
						<td><?php echo $value['name']; ?></td>
						<td><?php echo $value['email']; ?></td>
						<td><?php echo $format->textShorten($value['body'], 200); ?></td>
						<td><?php echo $format->formatDate($value['date']); ?></td>
						
						<?php 
                            if(Session::get('role') == '0' || Session::get('role') == '2')
                            {
                        ?>

							<td>
								<a onclick="return confirm('Are u sure to delete?');" href="?seen_feed_id=<?php echo $value['id']; ?>">Delete</a>
							</td>

						<?php }else { ?>
                         
                        <div style="color:red; font-weight: bold;">
                            <?php echo "No delete option available for *Author";} ?>
                        </div>

					</tr>
					
					<?php } }?>

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