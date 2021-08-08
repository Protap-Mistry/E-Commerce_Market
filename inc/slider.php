<div class="header_bottom">
		<div class="header_bottom_left">
			<div class="section group">
				<?php 
					$format= new Format();
					$get_brand= $format->getIPhoneBrandLatestProduct();

					if($get_brand)
					{
						foreach ($get_brand as $key => $value) 
						{

				?>
				 
				<div class="listview_1_of_2 images_1_of_2">
					<div class="listimg listimg_2_of_1">
						<a href="details.php?pro_id=<?php echo $value['id']; ?>"> <img src="admin/<?php echo $value['image']; ?>" alt="Latest brand image" /></a>
					</div>
				    <div class="text list_2_of_1">
						<h2>IPhone</h2>
						<p><?php echo $value['productName']; ?></p>
						<p><span class="price">$ <?php echo $value['price']; ?></span></p>
						<div class="button"><span><a href="details.php?pro_id=<?php echo $value['id']; ?>">Details</a></span></div>
				   </div>
			   </div>
			   <?php }} ?>
			   <?php 
					
					$get_brand= $format->getCanonBrandLatestProduct();

					if($get_brand)
					{
						foreach ($get_brand as $key => $value) 
						{

				?>
				<div class="listview_1_of_2 images_1_of_2">
					<div class="listimg listimg_2_of_1">
						 <a href="details.php?pro_id=<?php echo $value['id']; ?>"> <img src="admin/<?php echo $value['image']; ?>" alt="Latest brand image" /></a>
					</div>
				    <div class="text list_2_of_1">
						<h2>Canon</h2>
						<p><?php echo $value['productName']; ?></p>
						<p><span class="price">$ <?php echo $value['price']; ?></span></p>
						<div class="button"><span><a href="details.php?pro_id=<?php echo $value['id']; ?>">Details</a></span></div>
				   </div>
			   </div>
			   <?php }} ?>
			  
			</div>
			<div class="section group">
			 	<?php 
					
					$get_brand= $format->getAcerBrandLatestProduct();

					if($get_brand)
					{
						foreach ($get_brand as $key => $value) 
						{

				?>
				<div class="listview_1_of_2 images_1_of_2">
					<div class="listimg listimg_2_of_1">
						 <a href="details.php?pro_id=<?php echo $value['id']; ?>"> <img src="admin/<?php echo $value['image']; ?>" alt="Latest brand image" /></a>
					</div>
				    <div class="text list_2_of_1">
						<h2>Acer</h2>
						<p><?php echo $value['productName']; ?></p>
						<p><span class="price">$ <?php echo $value['price']; ?></span></p>
						<div class="button"><span><a href="details.php?pro_id=<?php echo $value['id']; ?>">Details</a></span></div>
				   </div>
			   </div>
			   <?php }} ?>
			   <?php 
					
					$get_brand= $format->getHPBrandLatestProduct();

					if($get_brand)
					{
						foreach ($get_brand as $key => $value) 
						{

				?>
				<div class="listview_1_of_2 images_1_of_2">
					<div class="listimg listimg_2_of_1">
						 <a href="details.php?pro_id=<?php echo $value['id']; ?>"> <img src="admin/<?php echo $value['image']; ?>" alt="Latest brand image" /></a>
					</div>
				    <div class="text list_2_of_1">
						<h2>HP</h2>
						<p><?php echo $value['productName']; ?></p>
						<p><span class="price">$ <?php echo $value['price']; ?></span></p>
						<div class="button"><span><a href="details.php?pro_id=<?php echo $value['id']; ?>">Details</a></span></div>
				   </div>
				</div>
				<?php }} ?>
			</div>
			
		  	<div class="clear"></div>
		</div>
		<div class="header_bottom_right_images">
			<section class="slider">
				<div class="flexslider">
				 	<ul class="slides">				 		
				 		<?php 
					 		$format= new Format();
					 		$show= $format->showSlideList();
					 		if($show){
					 			foreach ($show as $key => $value) {
					 				# code...
					 		?>
				            <li><a href="#"><img src="admin/<?php echo $value['image']; ?>" alt="Slider Image"></a></li>

			            <?php }	} ?>				 						 		
            		</ul>															    
				</div>
	      	</section>
			<!-- FlexSlider -->
	    </div>
	  <div class="clear"></div>
  </div>	