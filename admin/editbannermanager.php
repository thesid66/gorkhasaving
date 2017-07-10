<?php include('database/db.php'); ?>
<?php include('include/header.php');
$page = "banner";

if(isset($_POST['btnSave']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$file = $_FILES['txtImage']['name'];
		if($file!=NULL or $file!="")
		{
            unlink('../slider/'.$_POST['txtoldimg']);
			$getfile = explode(".",$file);
			$setfile = $getfile[0]."_".time().".".end($getfile);
			move_uploaded_file($_FILES['txtImage']['tmp_name'],'../slider/'.$setfile);
		}
        else
        {
            $setfile = $_POST['txtoldimg'];
        }
		
		$db->query("update tblbanner set
		PubDate		= '".date("Y-m-d h:i:s a")."',
		bantitle	= '".$db->real_escape_string($_POST['txtbannerTitle'])."',
		banimg		= '".$db->real_escape_string($setfile)."',
		placeorder	= '".$db->real_escape_string($_POST['txtBanOrder'])."',
		banlink	= '".$db->real_escape_string($_POST['txtbanlink'])."',
		status		= '".$db->real_escape_string($_POST['txtStatus'])."'
        where
        id = '".$_POST['txtid']."'
		");
		
		notify("Banner Manager","Category Modified Successfully",base_url()."bannermanager.php", FALSE,1000,0);
		
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
		notify("Banner Manager","Category Deleted Successfully",base_url()."bannermanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnHide']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tblbanner set status = '1' where id = '".$_POST['id']."'");
		notify("Banner Manager","Category Modified Successfully",base_url()."bannermanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnShow']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tblbanner set status = '0' where id = '".$_POST['id']."'");
		notify("Banner Manager","Category Modified Successfully",base_url()."bannermanager.php", FALSE,1000,0);
		
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
        <h1> Banner Manager </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title cate-form-title">Edit Form</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool show-cate-list" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        <?php
        $getBanner = $db->query("select * from tblbanner where id = '{$_POST['id']}'");
        $setBanner = $getBanner->fetch_object();
        ?>
        <form class="form-horizontal" id="AllForm" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <div class="col-sm-6">
                    <label class="control-label" for="txtbannerTitle">Banner Title</label>
                    <input type="text" class="form-control" name="txtbannerTitle" value="<?php echo $setBanner->bantitle ?>" id="txtbannerTitle">
                </div>
                <div class="col-sm-6">
                <label class="control-label" for="txtImage">Select Banner</label>
                    <div class='input-group '> 
                        <span class='input-group-btn'>
                        <label class='btn btn-primary'><span class='fa fa-plus'></span> Banner Image
                            <input type='file' name='txtImage' id='txtImage' class='hidden' value='' accept="image/*" />
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
            <div class="form-group">
                <div class="col-sm-6">
                    <label class="control-label" for="txtBanOrder">Banner Order</label>
                    <input type="text" class="form-control" name="txtBanOrder" value="<?php echo $setBanner->placeorder ?>" id="txtBanOrder">
                </div>
                <div class="col-sm-6">
                    <label class="control-label" for="txtbanlink">Banner Link</label>
                    <input type="text" class="form-control" name="txtbanlink" value="<?php echo $setBanner->banlink ?>" id="txtbanlink">
                </div>
                <div class="col-sm-6">
                    <label class="control-label" for="txtStatus">Status</label>
                    <select class="form-control" name="txtStatus" id="txtStatus">
                        <option value=""></option>
                        <option <?php echo $setBanner->status == 0 ? "selected" : "" ?> value="0">Publish</option>
                        <option <?php echo $setBanner->status == 1 ? "selected" : "" ?> value="1">Hidden</option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <img src="../slider/<?php echo $setBanner->banimg ?>" class="img-responsive">
                    <input type="hidden" name="txtoldimg" value="<?php echo $setBanner->banimg ?>">
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-2 col-sm-offset-5">
                    <button name="btnSave" id="btnSave" class="btn btn-primary btn-lg btn-block">Save</button>
                </div>
            </div>
            <input type="hidden" value="<?php echo $_SESSION['rand'] ?>" name="rand">
            <input type="hidden" value="<?php echo $setBanner->id ?>" name="txtid">
        </form>
    </div>
    <!-- /.box-body -->
</div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper --> 


<!-- Main Footer -->
<?php include('include/footer.php'); ?>