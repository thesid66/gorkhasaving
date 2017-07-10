<section class="sidebar">

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <!-- Optionally, you can add icons to the links -->
        <li <?php if($page == "category") { ?>class="active"<?php } ?>><a href="<?php echo base_url() ?>categorymanager.php"><i class="fa fa-rss fa-fw"></i> <span>Category Manager</span></a></li>
        <li <?php if($page == "subcategory") { ?>class="active"<?php } ?>><a href="<?php echo base_url() ?>subcategorymanager.php"><i class="fa fa-fw fa-rss"></i> <span>Sub Category Manager</span></a></li>
        <li <?php if($page == "author") { ?>class="active"<?php } ?>><a href="<?php echo base_url() ?>authormanager.php"><i class="fa fa-fw fa-users"></i> <span>Author Manager</span></a></li>
        <li <?php if($page == "article") { ?>class="active"<?php } ?>><a href="<?php echo base_url() ?>articlemanager.php"><i class="fa fa-files-o fa-fw"></i> <span>Article Manager</span></a></li>
        <li <?php if($page == "banner") { ?>class="active"<?php } ?>><a href="<?php echo base_url() ?>bannermanager.php"><i class="fa fa-image fa-fw"></i> <span>Banner Manager</span></a></li>
        <li <?php if($page == "team") { ?>class="active"<?php } ?>><a href="<?php echo base_url() ?>teammanager.php"><i class="fa fa-users fa-fw"></i> <span>Team Manager</span></a></li>
        <li <?php if($page == "ad") { ?>class="active"<?php } ?>><a href="<?php echo base_url() ?>admanager.php"><i class="fa fa-audio-description fa-fw"></i> <span>Advertisement Manager</span></a></li>
        <li <?php if($page == "publication") { ?>class="active"<?php } ?>><a href="<?php echo base_url() ?>publicationmanager.php"><i class="fa fa-files-o fa-fw"></i> <span>Publication Manager</span></a></li>
        <li <?php if($page == "links") { ?>class="active"<?php } ?>><a href="<?php echo base_url() ?>linksmanager.php"><i class="fa fa-link fa-fw"></i> <span>Links Manager</span></a></li>
        <li <?php if($page == "video") { ?>class="active"<?php } ?>><a href="<?php echo base_url() ?>videomanager.php"><i class="fa fa-video-camera fa-fw"></i> <span>Video Manager</span></a></li>
        <li <?php if($page == "photo") { ?>class="active"<?php } ?>><a href="<?php echo base_url() ?>photomanager.php"><i class="fa fa-instagram fa-fw"></i> <span>Photo Gallery Manager</span></a></li>
        <li <?php if($page == "disease") { ?>class="active"<?php } ?>><a href="<?php echo base_url() ?>diseasemanager.php"><i class="fa fa-bug fa-fw"></i> <span>Disease Manager</span></a></li>
        <li <?php if($page == "network") { ?>class="active"<?php } ?>><a href="<?php echo base_url() ?>networkmanager.php"><i class="fa fa-globe fa-fw"></i> <span>Network Manager</span></a></li>
        <li <?php if($page == "blogpool") { ?>class="active"<?php } ?>><a href="<?php echo base_url() ?>blogpool.php"><i class="fa fa-globe fa-fw"></i> <span>Blog Manager</span></a></li>
        <li <?php if($page == "subscriber") { ?>class="active"<?php } ?>><a href="<?php echo base_url() ?>subscriber.php"><i class="fa fa-link fa-fw"></i> <span>Subscriber Manager</span></a></li>
        
        
      </ul>
      <!-- /.sidebar-menu -->
    </section>