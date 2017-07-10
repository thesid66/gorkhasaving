<?php include('database/db.php'); ?>
<?php include('include/header.php');
$page = "ad";

if(isset($_POST['btnSave']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$getOldFile = $db->query("select * from tblad where id = '".$db->real_escape_string($_POST['txtid'])."'");
		$setOldFile = $getOldFile->fetch_object();
		
		$file = $_FILES['txtImage']['name'];
		if($file!=NULL or $file!="")
		{
			if(file_exists('../adimage/'.$setOldFile->image))
			{
				unlink('../adimage/'.$setOldFile->image);
			}
			$getfile = explode(".",$file);
			$setfile = $getfile[0]."_".time().".".end($getfile);
			move_uploaded_file($_FILES['txtImage']['tmp_name'],'../adimage/'.$setfile);
		}
		else
		{
			$setfile = $setOldFile->image;
		}
		
		
		$db->query("update tblad set
		image		= '".$db->real_escape_string($setfile)."',
		url			= '".$db->real_escape_string($_POST['txturl'])."',
		nolink		= '".$db->real_escape_string($_POST['txtnolink'])."',
		AdType		= '".$db->real_escape_string($_POST['txtAdType'])."',
		BotAdType	= '".$db->real_escape_string($_POST['txtBotAdType'])."',
		description = '".$db->real_escape_string($_POST['txtdescription'])."',
		AdOrder		= '".$db->real_escape_string($_POST['txtAdOrder'])."',
		status		= '".$db->real_escape_string($_POST['txtStatus'])."',
		AdPosition  = '".$db->real_escape_string($_POST['txtAdPosition'])."'
		where
		id 			= '".$db->real_escape_string($_POST['txtid'])."'
		");
		
		notify("Ad Manager","Advertise Updated Successfully",base_url()."admanager.php", FALSE,1000,0);
		
		die();
	}
}


if(isset($_POST['btnDelete']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$getFile = $db->query("select * from tblbanner where id = '".$_POST['id']."'");
		$setFile_u = $getFile->fetch_object();
		if(file_exists('../slider/'.$setFile_u->banimg))
		{
			unlink('../slider/'.$setFile_u->banimg);
		}
		$db->query("delete from tblbanner where id = '".$_POST['id']."'");
		notify("Banner Manager","Ad Deleted Successfully",base_url()."bannermanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnHide']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tblad set status = '1' where id = '".$_POST['id']."'");
		notify("Banner Manager","Ad Modified Successfully",base_url()."admanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnShow']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tblad set status = '0' where id = '".$_POST['id']."'");
		notify("Banner Manager","Ad Modified Successfully",base_url()."admanager.php", FALSE,1000,0);
		
		die();
	}
}

$rand = RandomVal(10);
$_SESSION['rand'] = $rand;
 ?>
<!-- Main Header -->
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
        <h1> Advertisement Manager </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
        
        <div class="box box-success" id="add_form">
            <div class="box-header with-border">
                <h3 class="box-title cate-form-title">Add Form</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool show-cate-list" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <?php
			$getAd = $db->query("select * from tblad where id = '".$_POST['id']."'");
			$setAd = $getAd->fetch_object();
			?>
                <form class="form-horizontal" id="AllForm" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label class="control-label" for="txturl">URL</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="txturl" id="txturl" value="<?php echo $setAd->url ?>">
                                <span class="input-group-addon">
                                <label style="margin:0">
                                    <input type="checkbox" class="minimal" name="txtnolink" value="1">
                                    No Link </label>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="txtImage">Select Image</label>
                            <div class='input-group '>
                                <span class='input-group-btn'>
                                <label class='btn btn-primary'><span class='fa fa-plus'></span> Choose File
                                    <input type='file' name='txtImage' id='txtImage' class='hidden' value='' accept="image/*"  />
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
								var control = $('#txtImage');
								$('#txtImage').change(function(){
									$('#disp-file').val($('input[type=file]')[0].files[0].name)
									$('.rmove-btn').show()
								})
								$('#remove').click(function(){
									control.replaceWith( control = control.clone( true ) );
									$('#disp-file').val("")
									$('.rmove-btn').hide()
								})
							})
							</script>
                        </div>
                        
                        <!--<div class="col-sm-4">
                        	<label class="control-label" for="txtPubDate">Publish Date</label>
                        	<div class="input-group date">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right datepicker" name="txtPubDate" id="txtPubDate">
                            </div>
                            
                        </div>-->
                        
                        <div class="col-sm-6">
                            <label class="control-label" for="txtAdType">Ad Type</label>
                            <select class="form-control" name="txtAdType" id="txtAdType">
                                <option value=""></option>
                                <option <?php if($setAd->AdType == 0) echo "selected"; ?> value="0">Top</option>
                                <option <?php if($setAd->AdType == 1) echo "selected"; ?> value="1">Right</option>
                                <option <?php if($setAd->AdType == 2) echo "selected"; ?> value="2">Bottom</option>
                            </select>
                        </div>
                        <div class="col-sm-6 for-bottom">
                            <label class="control-label" for="txtBotAdType">Bottom Ad Type</label>
                            <select class="form-control" name="txtBotAdType" id="txtBotAdType">
                                <option value=""></option>
                                <option <?php if($setAd->BotAdType == 4) echo "selected"; ?> value="4">Quarter</option>
                                <option <?php if($setAd->BotAdType == 6) echo "selected"; ?> value="6">Half</option>
                                <option <?php if($setAd->BotAdType == 12) echo "selected"; ?> value="12">Full</option>
                            </select>
                        </div>
                        <div class="col-sm-6 for-rnb">
                            <label class="control-label" for="txtAdOrder">Ad Order</label>
                            <input type="text" class="form-control" name="txtAdOrder" id="txtAdOrder" value="<?php echo $setAd->AdOrder ?>">
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="txtStatus">Status</label>
                            <select class="form-control" name="txtStatus" id="txtStatus">
                                <option value=""></option>
                                <option <?php if($setAd->status == 0) echo "selected"; ?> value="0">Publish</option>
                                <option <?php if($setAd->status == 1) echo "selected"; ?> value="1">Hidden</option>
                            </select>
                        </div>
                        <div class="col-sm-6 for-bottom">
                            <label class="control-label" for="txtAdPosition">Position</label>
                            <select class="form-control" name="txtAdPosition" id="txtAdPosition">
                                <option value=""></option>
                                <option <?php if($setAd->AdPosition == 0) echo "selected"; ?> value="0">Up</option>
                                <option <?php if($setAd->AdPosition == 1) echo "selected"; ?> value="1">Down</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <textarea name="txtdescription" id="txtdescription" class="textarea"><?php echo $setAd->description ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-5">
                            <button name="btnSave" id="btnSave" class="btn btn-primary btn-lg btn-block">Save</button>
                        </div>
                    </div>
                    <div class="form-group">
                    <div class="col-sm-12">
                    	<img src="../adimage/<?php echo $setAd->image ?>" class="img-responsive" />
                    </div>
                    </div>
                    <input type="hidden" value="<?php echo $_SESSION['rand'] ?>" name="rand">
                    <input type="hidden" value="<?php echo $setAd->id ?>" name="txtid">
                </form>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper --> 

<script>
	
    	$('.show-cate-list').click(function(){
			window.location="<?php echo base_url(); ?>admanager.php";
		})
		<?php if($setAd->AdType < 1){ ?>
		$('.for-rnb').hide();
		<?php } ?>
		<?php if($setAd->AdType < 2){ ?>
		$('.for-bottom').hide();
		<?php } ?>
		
		$('#txtAdType').change(function(){
			AdType = $(this).val();
			
			if(AdType == 2)
			{
				$('.for-bottom').show();
				$('.for-rnb').show();
			}
			else if(AdType == 1)
			{
				$('.for-bottom').hide();
				$('.for-rnb').show();
				$('.for-bottom select').val('');
			}
			else
			{
				$('.for-bottom').hide();
				$('.for-rnb').hide();
				$('.for-bottom select, .for-bottom input').val('');
			}
		})    
		
    </script>
<?php
confirm2("Ad Management","Do you want to delete the record?","delete","delete_modal",$rand,1);
confirm2("Ad Management","Do you want to Modify the record?","hidecate","hide_modal",$rand,2);
confirm2("Ad Management","Do you want to Modify the record?","showcate","show_modal",$rand,3);
confirm2("Ad Management","Do you want to Modify the record?","edit","edit_modal",$rand,4);
?>
<!-- Main Footer -->
<?php include('include/footer.php'); ?>
