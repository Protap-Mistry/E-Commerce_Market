<?php 
	include 'inc/header.php';
?>

<?php 
	if(!isset($_POST['search']) || $_POST['search']== null){
		header("Location: 404.php");
	}
	else
	{
		$search= $_POST['search'];
	}
?>

<div class="main">
    <div class="content">
    	<div class="content_top">
    		<div class="heading">
    			<h3>Featured Products</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
    	
		<div class="section group">
		    <!-- pagination part-1 start -->
		    <?php 
		    	$show_per_page= 4;
				
				if(isset($_GET['page'])){

					$page= $_GET['page'];
				}
				else{
					$page= 1;
				}

				$track_start_page= ($page-1)*$show_per_page;
		    ?>
		    <!-- pagination part-1 end -->
		    <?php 

				$format= new Format();

				$search_result= $format->searchProduct($search, $track_start_page, $show_per_page);

				if($search_result)
				{
					foreach ($search_result as $key => $value) 
				{

			?>
				<div class="grid_1_of_4 images_1_of_4">
					 <a href="details.php?pro_id=<?php echo $value['id']; ?>"><img src="admin/<?php echo $value['image']; ?>" alt="product_image"/></a>
					 <h2><?php echo $value['productName']; ?> </h2>
					 <p><?php echo $format->textShorten($value['body'], 60); ?></p>
					 <p><span class="price">$ <?php echo $value['price']; ?></span></p>
				     <div class="button"><span><a href="details.php?pro_id=<?php echo $value['id']; ?>" class="details">Details</a></span></div>
				</div>
		</div>
				<!--pagination part-2 start-->
				<?php				
					$pagination_result= $format->paginationForShowingFeaturedProducts();

					$total_pages= ceil($pagination_result/$show_per_page);

					echo "<span class='pagination'> 
							<a href='search.php?page=1'>Start</a>";

							for ($i=1; $i <=$total_pages ; $i++) { 
								
								echo "<a href='search.php?page=$i'>$i</a>";
							}

							echo "<a href='search.php?page=$total_pages'>End</a> 
						</span>";
				?>
				<!--pagination part-2 end-->
			

			<div class="content_bottom">
				<div class="heading">
					<h3>General Products</h3>
				</div>
				<div class="clear"></div>
	    	</div>
			<div class="section group">
				<div class="grid_1_of_4 images_1_of_4">
					<a href="details.php?pro_id=<?php echo $value['id']; ?>"><img src="admin/<?php echo $value['image']; ?>" alt="product_image"/></a>
					<h2><?php echo $value['productName']; ?> </h2>
					<p><?php echo $format->textShorten($value['body'], 60); ?></p>
					<p><span class="price">$ <?php echo $value['price']; ?></span></p>
				    <div class="button"><span><a href="details.php?pro_id=<?php echo $value['id']; ?>" class="details">Details</a></span></div>
				</div>			
			</div>
			<!--pagination part-2 start-->
			<?php				
				$pagination_result= $format->paginationForShowingGeneralProducts();

				$total_pages= ceil($pagination_result/$show_per_page);

				echo "<span class='pagination'> 
						<a href='search.php?page=1'>Start</a>";

						for ($i=1; $i <=$total_pages ; $i++) { 
							
							echo "<a href='search.php?page=$i'>$i</a>";
						}

						echo "<a href='search.php?page=$total_pages'>End</a> 
					</span>";
			?>
			<!--pagination part-2 end-->

		<?php }} else{ echo "Ooops!!! Sorry, Your Mind Not Found."; }?>

    </div>
</div>

<?php include 'inc/footer.php'; ?>
	