<div class="banner-section">
		<div class="containers">
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			  <!-- Indicators -->
			  <ol class="carousel-indicators">
			  <?php
			  $c=0;
			  	$getBanner = $db->query("select * from tblbanner where status = '0' order by placeorder asc");
			  	while ($setBanner = $getBanner->fetch_object()) {
			  	?>
			    <li data-target="#carousel-example-generic" data-slide-to="<?php echo $c ?>" class="<?php echo $c==0 ? "active" : "" ?>"></li>
			    <?php
			    $c++;
			    }
			  	?>
			  </ol>

			  <!-- Wrapper for slides -->
			  <div class="carousel-inner" role="listbox">
			  <?php
			  $c=0;
			  	$getBanner = $db->query("select * from tblbanner where status = '0' order by placeorder asc");
			  	while ($setBanner = $getBanner->fetch_object()) {
			  	?>
			    <div class="item <?php echo $c==0 ? "active" : "" ?>">
			      <img src="slider/<?php echo $setBanner->banimg ?>" alt="<?php echo $setBanner->bantitle ?>">
			      <div class="carousel-caption">
			        <?php echo $setBanner->bantitle ?>
			      </div>
			    </div>
			    <?php
			    $c++;
			    }
			  	?>
			    
			    
			  </div>

			  <!-- Controls -->
			  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
			    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			    <span class="sr-only">Previous</span>
			  </a>
			  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
			    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			    <span class="sr-only">Next</span>
			  </a>
			</div>
		</div>
	</div>