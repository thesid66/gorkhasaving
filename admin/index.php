<?php include('database/db.php'); ?>
<?php include('include/header.php') ?>
    <!-- Main Header -->
    <?php
	if(isset($_POST['btnSaveSite']))
	{
		$getOldImage = $db->query("select * from usertable");
		$setOldImage = $getOldImage->fetch_object();
		
		$Logo = $_FILES['txtSiteLogo']['name'];
        
		if($Logo != NULL or $Logo != "")
		{
			if(file_exists('../images/'.$setOldImage->sitelogo))
			     $getfile = explode(".",$Logo);
			
            $setfile = $getfile[0]."_".time().".".end($getfile);
			move_uploaded_file($_FILES['txtSiteLogo']['tmp_name'],'../images/'.$setfile);
		}
		else
		{
			$setfile = $setOldImage->sitelogo;
		}
		
		$db->query("update usertable set 
		address		= '".$db->real_escape_string($_POST['txtAddress'])."',	
		shortinfo	= '".$db->real_escape_string($_POST['txtShortInfo'])."',
		sitename	= '".$db->real_escape_string($_POST['txtWebsiteName'])."',
		sitelogo	= '".$db->real_escape_string($setfile)."',
		contact		= '".$db->real_escape_string($_POST['txtContactNo'])."',
		email		= '".$db->real_escape_string($_POST['txtEmail'])."',
		website		= '".$db->real_escape_string($_POST['txtWebsite'])."',
		facebook	= '".$db->real_escape_string($_POST['txtFacebook'])."',
		twitter		= '".$db->real_escape_string($_POST['txtTwitter'])."',
		googleplus	= '".$db->real_escape_string($_POST['txtGooglePlus'])."',
		youtube		= '".$db->real_escape_string($_POST['txtYoutube'])."'
		
		");
	}
	?>
    <?php include('include/toppart.php'); ?>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar"> 
        
        <!-- sidebar: style can be found in sidebar.less -->
        <?php include('include/sidebar.php'); ?>
        <!-- /.sidebar --> 
    </aside>
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Dashboard <small>Quick Info</small> </h1>
        </section>
        
        <!-- Main content -->
        <section class="content">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-aqua"><i class="fa fa-rss"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Category</span> <span class="info-box-number">1,410</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-green"><i class="fa fa-files-o"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Articles</span> <span class="info-box-number">410</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-yellow"><i class="fa fa-sticky-note"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Ads</span> <span class="info-box-number">13,648</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-red"><i class="fa fa-comments"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Comments</span> <span class="info-box-number">93,139</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box box-widget widget-user-2">
                 <?php
					$GetInfo = $db->query("select * from usertable where userid = '$userid'");
					$setInfo = $GetInfo->fetch_object();
			     ?>
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-yellow">
                        
                            <img class="img-responsive" src="../images/<?php  echo $setInfo->sitelogo ?>" alt="User Avatar">
                        
                        <!-- /.widget-user-image -->
                        <h3><?php echo $username ?></h3>
                        <h5>System Administrator</h5>
                    </div>
                    <div class="box-footer no-padding">
                       
                        <ul class="nav nav-stacked">
                            <li>
                                <a href="#"><?php echo $username; ?> <span class="pull-right btn btn-success btn-xs"><span class="fa fa-check"></span></span></a>
                            </li>
                            <li>
                                <a href="#">
                                <?php if($setInfo->address) { echo $setInfo->address ?>
                                <span class="pull-right btn btn-success btn-xs"><span class="fa fa-check"></span></span>
                                <?php } else { ?>
                                <em>Address</em> <span class="pull-right btn btn-danger btn-xs"><span class="fa fa-times"></span></span>
                                <?php } ?>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <?php if($setInfo->contact) { echo $setInfo->contact ?>
                                <span class="pull-right btn btn-success btn-xs"><span class="fa fa-check"></span></span>
                                <?php } else { ?>
                                <em>Contact</em> <span class="pull-right btn btn-danger btn-xs"><span class="fa fa-times"></span></span>
                                <?php } ?>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <?php if($setInfo->email) { echo $setInfo->email ?>
                                <span class="pull-right btn btn-success btn-xs"><span class="fa fa-check"></span></span>
                                <?php } else { ?>
                                <em>Email</em> <span class="pull-right btn btn-danger btn-xs"><span class="fa fa-times"></span></span>
                                <?php } ?>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <?php if($setInfo->website) { echo $setInfo->website ?>
                                <span class="pull-right btn btn-success btn-xs"><span class="fa fa-check"></span></span>
                                <?php } else { ?>
                                <em>Website</em> <span class="pull-right btn btn-danger btn-xs"><span class="fa fa-times"></span></span>
                                <?php } ?>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <?php if($setInfo->facebook) { echo $setInfo->facebook ?>
                                <span class="pull-right btn btn-success btn-xs"><span class="fa fa-check"></span></span>
                                <?php } else { ?>
                                <em>Facebook</em> <span class="pull-right btn btn-danger btn-xs"><span class="fa fa-times"></span></span>
                                <?php } ?>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <?php if($setInfo->twitter) { echo $setInfo->twitter ?>
                                <span class="pull-right btn btn-success btn-xs"><span class="fa fa-check"></span></span>
                                <?php } else { ?>
                                <em>Twitter</em> <span class="pull-right btn btn-danger btn-xs"><span class="fa fa-times"></span></span>
                                <?php } ?>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <?php if($setInfo->googleplus) { echo $setInfo->googleplus ?>
                                <span class="pull-right btn btn-success btn-xs"><span class="fa fa-check"></span></span>
                                <?php } else { ?>
                                <em>Google+</em> <span class="pull-right btn btn-danger btn-xs"><span class="fa fa-times"></span></span>
                                <?php } ?>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <?php if($setInfo->youtube) { echo $setInfo->youtube ?>
                                <span class="pull-right btn btn-success btn-xs"><span class="fa fa-check"></span></span>
                                <?php } else { ?>
                                <em>Youtube</em> <span class="pull-right btn btn-danger btn-xs"><span class="fa fa-times"></span></span>
                                <?php } ?>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <?php if($setInfo->instagram) { echo $setInfo->instagram ?>
                                <span class="pull-right btn btn-success btn-xs"><span class="fa fa-check"></span></span>
                                <?php } else { ?>
                                <em>Instagram</em> <span class="pull-right btn btn-danger btn-xs"><span class="fa fa-times"></span></span>
                                <?php } ?>
                                </a>
                            </li>
                            <li >
                                <a href="#" data-toggle="modal" data-target="#configure" class="bg-orange"><span class="fa fa-cog"></span> Configure Detail</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clearfix">
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    
    <div class="modal fade" id="configure">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Configure Site</h4>
                </div>
                <form method="post" class="form-horizontal" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label for="txtWebsiteName" class="control-label">Website Name</label>
                                <input type="text" class="form-control" name="txtWebsiteName" id="txtWebsiteName" value="<?php echo $setInfo->sitename ?>">
                            </div>
                            <div class="col-sm-6">
                                <label for="txtAddress" class="control-label">Address</label>
                                <input type="text" class="form-control" name="txtAddress" id="txtAddress" value="<?php echo $setInfo->address ?>">
                            </div>
                            <div class="col-sm-6">
                                <label for="txtContactNo" class="control-label">Contact No</label>
                                <input type="text" class="form-control" name="txtContactNo" id="txtContactNo" value="<?php echo $setInfo->contact ?>">
                            </div>
                            <div class="col-sm-6">
                                <label for="txtEmail" class="control-label">Email</label>
                                <input type="text" class="form-control" name="txtEmail" id="txtEmail" value="<?php echo $setInfo->email ?>">
                            </div>
                            <div class="col-sm-6">
                                <label for="txtWebsite" class="control-label">Website</label>
                                <input type="text" class="form-control" name="txtWebsite" id="txtWebsite" value="<?php echo $setInfo->website ?>">
                            </div>
                            <div class="col-sm-6">
                                <label for="txtFacebook" class="control-label">Facebook</label>
                                <input type="text" class="form-control" name="txtFacebook" id="txtFacebook" value="<?php echo $setInfo->facebook ?>">
                            </div>
                            <div class="col-sm-6">
                                <label for="txtTwitter" class="control-label">Twitter</label>
                                <input type="text" class="form-control" name="txtTwitter" id="txtTwitter" value="<?php echo $setInfo->twitter ?>">
                            </div>
                            <div class="col-sm-6">
                                <label for="txtGooglePlus" class="control-label">Google +</label>
                                <input type="text" class="form-control" name="txtGooglePlus" id="txtGooglePlus" value="<?php echo $setInfo->googleplus ?>">
                            </div>
                            <div class="col-sm-6">
                                <label for="txtInstagram" class="control-label">Youtube</label>
                                <input type="text" class="form-control" name="txtYoutube" id="txtYoutube" value="<?php echo $setInfo->youtube ?>">
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label" for="txtSiteLogo">Site Logo</label>
                                <div class='input-group '>
                                    <span class='input-group-btn'>
                                    <label class='btn btn-primary'><span class='fa fa-plus'></span> Select
                                        <input type='file' name='txtSiteLogo' id='txtSiteLogo' class='hidden' value='' accept="image/*" />
                                    </label>
                                    </span>
                                    <input class='form-control' disabled='disabled' id='disp-file' placeholder='Image Holder'>
                                    <span class='input-group-btn rmove-btn'>
                                    <button type='button' class='btn btn-danger' id='remove'><span class='fa fa-times'></span></button>
                                    </span>
                                </div>
                                <script>
							$(document).ready(function(){
								$('.rmove-btn').hide();
								var control = $('#txtSiteLogo');
								$('#txtSiteLogo').change(function(){
									$('#disp-file').val($('input[type=file]')[0].files[0].name)
									$('.rmove-btn').show()
								})
								$('#remove').click(function(){
									control.replaceWith( control = control.clone( true ) );
									$('#disp-file').val("")
									$('.rmove-btn').hide();
									$('#image').attr('src','').hide();
								})
								
								function readIMG(input) {
									if (input.files && input.files[0]) {
										var reader = new FileReader();
							
										reader.onload = function (e) {
											$('#image').attr('src', e.target.result);
										}
							
										reader.readAsDataURL(input.files[0]);
									}
								}
								<?php if($setInfo->sitelogo == "") { ?>
							$('#image').hide();
							<?php } ?>
								$("#txtSiteLogo").change(function(){
									$('#image').show();
									readIMG(this);
								});
							})
							</script>
                            </div>
                            <div class="col-sm-6">
                            	<label class="control-label" for="txtShortInfo">Short Info</label>
                                <textarea name="txtShortInfo" class="form-control" id="txtShortInfo"><?php echo $setInfo->shortinfo ?></textarea>
                            </div>
                            <div class="col-sm-6">
                            	<img src="../images/<?php echo $setInfo->sitelogo ?>" class="img-responsive img-thumbnail" style="margin-top:15px;" id="image">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" name="btnSaveSite" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Main Footer -->
    <?php include('include/footer.php'); ?>