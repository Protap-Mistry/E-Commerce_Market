<?php include 'inc/header.php' ;?>

<div class="main">
    <div class="content">
    	
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
		<div class="content_top">
    		<div class="heading">
    			<h3>iPhone</h3>
    		</div>
    		<div class="clear"></div>
    	</div>	    	
		<div class="section group">
		    <?php 
				$format= new Format();
				$get_brand= $format->getIPhoneBrandAllProducts($track_start_page, $show_per_page);

				if($get_brand)
				{
					foreach ($get_brand as $key => $value) 
					{

			?>
				<div class="grid_1_of_4 images_1_of_4">
					<a href="details.php?pro_id=<?php echo $value['id']; ?>"> <img src="admin/<?php echo $value['image']; ?>" alt="iPhone Brand Product Image" /></a>
					<h2><?php echo $value['productName']; ?></h2>
					<p><?php echo $format->textShorten($value['body'], 60); ?></p>
					<p><span class="price">$ <?php echo $value['price']; ?></span></p>
				    <div class="button"><span><a href="details.php?pro_id=<?php echo $value['id']; ?>">Add to cart</a></span></div>
				</div>
			<?php } } ?>
				
		</div>
		<!--pagination part-2 start-->
		<?php				
			$pagination_result= $format->paginationForShowingIPhoneBrandAllProducts();

			$total_pages= ceil($pagination_result/$show_per_page);

			echo "<span class='pagination'> 
					<a href='topbrands.php?page=1'>Start</a>";

					for ($i=1; $i <=$total_pages ; $i++) { 
						
						echo "<a href='topbrands.php?page=$i'>$i</a>";
					}

					echo "<a href='topbrands.php?page=$total_pages'>End</a> 
				</span>";
		?>
		<!--pagination part-2 end-->

		<div class="content_top">
    		<div class="heading">
    			<h3>Acer</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
    	<div class="section group">
			<?php 
				$get_brand= $format->getAcerBrandAllProducts($track_start_page, $show_per_page);

				if($get_brand)
				{
					foreach ($get_brand as $key => $value) 
					{

			?>
			
				<div class="grid_1_of_4 images_1_of_4">
					<a href="details.php?pro_id=<?php echo $value['id']; ?>"> <img src="admin/<?php echo $value['image']; ?>" alt="Acer Brand Product Image" /></a>
					<h2><?php echo $value['productName']; ?></h2>
					<p><?php echo $format->textShorten($value['body'], 60); ?></p>
					<p><span class="price">$ <?php echo $value['price']; ?></span></p>
				    <div class="button"><span><a href="details.php?pro_id=<?php echo $value['id']; ?>">Add to cart</a></span></div>
				</div>				
			
			<?php } } ?>
		</div>

		<!--pagination part-2 start-->
		<?php				
			$pagination_result= $format->paginationForShowingAcerBrandAllProducts();

			$total_pages= ceil($pagination_result/$show_per_page);

			echo "<span class='pagination'> 
					<a href='topbrands.php?page=1'>Start</a>";

					for ($i=1; $i <=$total_pages ; $i++) { 
						
						echo "<a href='topbrands.php?page=$i'>$i</a>";
					}

					echo "<a href='topbrands.php?page=$total_pages'>End</a> 
				</span>";
		?>
		<!--pagination part-2 end-->

		<div class="content_bottom">
    		<div class="heading">
    			<h3>HP</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
		<div class="section group">
			<?php 
				$get_brand= $format->getHPBrandAllProducts($track_start_page, $show_per_page);

				if($get_brand)
				{
					foreach ($get_brand as $key => $value) 
					{

			?>

				<div class="grid_1_of_4 images_1_of_4">
					<a href="details.php?pro_id=<?php echo $value['id']; ?>"> <img src="admin/<?php echo $value['image']; ?>" alt="HP Brand Product Image" /></a>
					<h2><?php echo $value['productName']; ?></h2>
					<p><?php echo $format->textShorten($value['body'], 60); ?></p>
					<p><span class="price">$ <?php echo $value['price']; ?></span></p>
				    <div class="button"><span><a href="details.php?pro_id=<?php echo $value['id']; ?>">Add to cart</a></span></div>
				</div>
			<?php } } ?>

		</div>
		<!--pagination part-2 start-->
		<?php				
			$pagination_result= $format->paginationForShowingHPBrandAllProducts();

			$total_pages= ceil($pagination_result/$show_per_page);

			echo "<span class='pagination'> 
					<a href='topbrands.php?page=1'>Start</a>";

					for ($i=1; $i <=$total_pages ; $i++) { 
						
						echo "<a href='topbrands.php?page=$i'>$i</a>";
					}

					echo "<a href='topbrands.php?page=$total_pages'>End</a> 
				</span>";
		?>
		<!--pagination part-2 end-->
		<div class="content_bottom">
    		<div class="heading">
    			<h3>Canon</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
		<div class="section group">
			<?php 
				$get_brand= $format->getCanonBrandAllProducts($track_start_page, $show_per_page);

				if($get_brand)
				{
					foreach ($get_brand as $key => $value) 
					{

			?>
				<div class="grid_1_of_4 images_1_of_4">
					<a href="details.php?pro_id=<?php echo $value['id']; ?>"> <img src="admin/<?php echo $value['image']; ?>" alt="Canon Brand Product Image" /></a>
					<h2><?php echo $value['productName']; ?></h2>
					<p><?php echo $format->textShorten($value['body'], 60); ?></p>
					<p><span class="price">$ <?php echo $value['price']; ?></span></p>
				    <div class="button"><span><a href="details.php?pro_id=<?php echo $value['id']; ?>">Add to cart</a></span></div>
				</div>
			<?php } } ?>				
		</div>
		<!--pagination part-2 start-->
		<?php				
			$pagination_result= $format->paginationForShowingCanonBrandAllProducts();

			$total_pages= ceil($pagination_result/$show_per_page);

			echo "<span class='pagination'> 
					<a href='topbrands.php?page=1'>Start</a>";

					for ($i=1; $i <=$total_pages ; $i++) { 
						
						echo "<a href='topbrands.php?page=$i'>$i</a>";
					}

					echo "<a href='topbrands.php?page=$total_pages'>End</a> 
				</span>";
		?>
		<!--pagination part-2 end-->
    </div>
</div>
<?php include 'inc/footer.php' ;?>