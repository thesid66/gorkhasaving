<div class="topbar-section">
		<div class="container">
			<div class="pull-left contact">
				<p>
					Call us today : <?php echo $setSiteDetail->contact; ?>
				</p>
			</div>
			<div class="pull-right sicons">
				<ul>
					<li><a href="<?php echo $setSiteDetail->facebook ?>" class="facebook"><span class="fa fa-facebook fa-fw"></span></a></li>
					<li><a href="<?php echo $setSiteDetail->twitter ?>" class="twitter"><span class="fa fa-twitter fa-fw"></span></a></li>
					<li><a href="<?php echo $setSiteDetail->youtube ?>" class="youtube"><span class="fa fa-youtube-play fa-fw"></span></a></li>
				</ul>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="topmenu-section">
		<div class="container">
			<!-- <div class="col-sm-4 sitelogo">
				<a class="navbar-brand"><img src="images/<?php echo $setSiteDetail->sitelogo ?>"></a>
				<div class="company-name">Gorkha Saving and Credit <span>Co-operative Pvt</span></div>
			</div> -->
			<div class="menu-section">
				<nav class="navbar">
				  <div class="container-fluid">
				    <!-- Brand and toggle get grouped for better mobile display -->
				    <div class="navbar-header">
				      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				      </button>
				      	<a class="navbar-brand" style="background:url(<?php echo base_url()."images/".$setSiteDetail->sitelogo ?>) no-repeat center left; background-size: 40px 40px;">
							<div class="company-name">Gorkha Saving and Credit <span>Co-operative Pvt</span></div>
						</a>
				    </div>

				    <!-- Collect the nav links, forms, and other content for toggling -->
				    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				      
				      <ul class="nav navbar-nav navbar-right">
				        <?php
				        $level2A = $level2T = "";
							$getCate = $db->query("select * from article_cate where Status = '0' and CateType < 5 order by CateOrder asc");
							while($setCate = $getCate->fetch_object())
							{
								if($setCate->CateType == 1)
									{ 
									$getSingleMenu = $db->query("select * from tblarticle where groupid = '".$setCate->CateID."'");
									$setSingleMenu = $getSingleMenu->fetch_object();
										$menutype = "single"; 
										$li_class = ""; 
										$a_param = "";
										$arrow = "";
										
										if($setSingleMenu->type == 1)
										{
											$a_href = "article.php?id=".$setSingleMenu->id;
										}
										else
										{
											$a_href = $setSingleMenu->urllink;
											if($setSingleMenu->urltype != 0)
											$a_param = "target='_blank'";
											else
											$a_param = "";
										}
									}
								else
									{ 
										$menutype = "menu"; 
										$li_class = "class = 'dropdown hasmenu'"; 
										
										$a_param = "class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\"";
										$a_href = "#";
										$arrow = "<span class=\"fa fa-angle-down\"></span>";
									}
							?>
                            <li <?php echo $li_class; ?>><a href="<?php echo $a_href; ?>" <?php echo $a_param; ?>><?php echo $setCate->CateTitle ?> <?php echo $arrow; ?></a>
                            	<?php
								if($menutype == "menu")
								{
								?>
                                <ul class="dropdown-menu">
                                	<?php
									$getArticle = $db->query("select * from tblarticle where groupid = '".$setCate->CateID."' and status = '0' order by submitdate desc, id desc limit 10");
									$c= 0;
									while($setArticle = $getArticle->fetch_object())
									{
										$c++;
										if($setArticle->type == 1)
										{
											$level2A = "article.php?id=".$setArticle->id;
										}
										else
										{
											if($setArticle->urltype == 0)
											{
												$level2T = "";
											}
											else
											{
												$level2T = "target='_blank'";
											}
											$level2A = $setArticle->urllink;
										}
									?>
                                    	<li><a href="<?php echo $level2A ?>" <?php echo $level2T ?>><?php echo $setArticle->topic ?></a></li>
                                    <?php
									}
									if($c == 10)
									{
										?>
                                        <li><a href="category.php?id=<?php echo $setSubCate->SubCateID ?>">[+] More..</a></li>
                                        <?php
									}
									?>
                                </ul>
                                <?php
								}
								?>
                            </li>
                            <?php
							}
							?>
				      </ul>
				    </div><!-- /.navbar-collapse -->
				  </div><!-- /.container-fluid -->
				</nav>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>