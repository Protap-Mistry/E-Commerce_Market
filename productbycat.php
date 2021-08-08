<?php include 'inc/header.php' ;?>
<?php 
    if(isset($_GET['category_id'])){

        $category_id= $_GET['category_id'];
    }
?>
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
		     <?php 
	    		$format= new Format();
				$category_from_product= $format->getCategoryFromProduct($category_id);						
				if($category_from_product)
				{

			?> 
		    	<div class="content_top">
		    		<div class="heading">
		    			<h3>Latest from <span style="color: #CC3636"><?php echo $category_from_product->categoryName;?></span> category</h3>
		    		</div>
		    		<div class="clear"></div>
		    	</div>
		    <?php } ?>
    	
	    <div class="section group">
	    	
		    <?php 
				$product_by_category= $format->showProductByCategory($category_id, $track_start_page, $show_per_page);						
				if($product_by_category)
				{
					foreach ($product_by_category as $key => $value) 
					{
		

			?> 
				  		    						
				<div class="grid_1_of_4 images_1_of_4">
					 <a href="details.php?pro_id=<?php echo $value['id']; ?>"><img src="admin/<?php echo $value['image']; ?>" alt="Product image" /></a>
					 <h2><?php echo $value['productName']; ?> </h2>
					 <p><?php echo $format->textShorten($value['body'], 60); ?></p>
					 <p><span class="price">$ <?php echo $value['price']; ?></span></p>
				     <div class="button"><span><a href="details.php?pro_id=<?php echo $value['id']; ?>" class="details">Details</a></span></div>
				</div>	

			
			<?php } }else { ?>
				<div style="text-align: center; color: red; font-size: 20px;">
					<?php echo "Products of this category aren't available !!!"; ?>
				</div>
			<?php } ?>

		</div>
		<!--pagination part-2 start-->
		<?php				
			$pagination_result= $format->paginationForShowingDifferentCategoriesProducts($category_id);

			$total_pages= ceil($pagination_result/$show_per_page);

			echo "<span class='pagination'> 
					<a href='productbycat.php?category_id=$category_id&page=1'>Start</a>";

					for ($i=1; $i <=$total_pages ; $i++) { 
						
						echo "<a href='productbycat.php?category_id=$category_id&page=$i'>$i</a>";
					}

					echo "<a href='productbycat.php?category_id=$category_id&page=$total_pages'>End</a> 
				</span>";
		?>
		<!--pagination part-2 end-->
    </div>
</div>
<?php include 'inc/footer.php' ;?>