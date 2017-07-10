<?php 
	include_once 'assets/functions/functions.php';
	$getSiteDetail = $db->query("select address, sitename, shortinfo, sitelogo, contact, email, website, facebook, twitter, googleplus, youtube from usertable limit 1");
	$setSiteDetail = $getSiteDetail->fetch_object();

	include_once 'includes/header.php';
	include_once 'includes/topmenu.php';
	include_once 'includes/banner.php';
?>

	<div class="welcome-section">
		<div class="container">
			<div class="col-sm-6">
				<?php
				$getMainPG = $db->query("select * from tblarticle where mainpg = '1'");
				$setMainPG = $getMainPG->fetch_object();
				?>
				<h3>Welcome to <?php echo $setSiteDetail->sitename ?></h3>
				<?php echo limit_para($setMainPG->description,2) ?>
				<a class="btn btn-info btn-sm" href="<?php echo base_url() ?>articles.php?id=<?php echo $setMainPG->id ?>">[+] Read More</a>
			</div>
			<div class="col-sm-6">
				<div>
				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
				    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
				    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
				    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
				    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">
				    <div role="tabpanel" class="tab-pane active" id="home">...</div>
				    <div role="tabpanel" class="tab-pane" id="profile">...</div>
				    <div role="tabpanel" class="tab-pane" id="messages">...</div>
				    <div role="tabpanel" class="tab-pane" id="settings">...</div>
				  </div>

				</div>
			</div>
		</div>
	</div>
	
<?php
	include_once 'includes/footer.php';
?>