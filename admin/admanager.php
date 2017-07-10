<?php include('database/db.php'); ?>
<?php include('include/header.php');
$page = "ad";

if(isset($_POST['btnSave']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$file = $_FILES['txtImage']['name'];
		if($file!=NULL or $file!="")
		{
			$getfile = explode(".",$file);
			$setfile = $getfile[0]."_".time().".".end($getfile);
			move_uploaded_file($_FILES['txtImage']['tmp_name'],'../adimage/'.$setfile);
		}
		
		$id = maxid("tblad","id",$db);
		
		$db->query("insert into tblad set
		id			= '$id',
		image		= '".$db->real_escape_string($setfile)."',
		url			= '".$db->real_escape_string($_POST['txturl'])."',
		nolink		= '".$db->real_escape_string($_POST['txtnolink'])."',
		AdType		= '".$db->real_escape_string($_POST['txtAdType'])."',
		BotAdType	= '".$db->real_escape_string($_POST['txtBotAdType'])."',
		description = '".$db->real_escape_string($_POST['txtdescription'])."',
		AdOrder		= '".$db->real_escape_string($_POST['txtAdOrder'])."',
		PubDate		= '".date("Y-m-d h:i:s a")."',
        AdPosition  = '".$db->real_escape_string($_POST['txtAdPosition'])."',
		status		= '".$db->real_escape_string($_POST['txtStatus'])."'
		");
		
		notify("Ad Manager","Advertise Inserted Successfully",base_url()."admanager.php", FALSE,1000,0);
		
		die();
	}
}


if(isset($_POST['btnDelete']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$getFile = $db->query("select * from tblad where id = '".$_POST['id']."'");
		$setFile_u = $getFile->fetch_object();
		if(file_exists('../adimage/'.$setFile_u->image))
		{
			unlink('../adimage/'.$setFile_u->image);
		}
		$db->query("delete from tblad where id = '".$_POST['id']."'");
		notify("Banner Manager","Ad Deleted Successfully",base_url()."admanager.php", FALSE,1000,0);
		
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
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Advertisement List</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool hide-cate-list" data-widget="collapse"><i class="fa fa-plus"></i> </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="pull-right">
                    <a href="#" id="add_form_button" class="btn btn-primary">Add new Ad</a>
                </div>
                <div class="clearfix">
                </div>
                <br>
                <table id="dataTable" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="20%">URL</th>
                            <th width="15%">Ad Type</th>
                            <th width="13%">Image</th>
                            <th width="18%">Published Date</th>
                            <th width="7%">Order</th>
                            <th width="9%">Status</th>
                            <th width="13%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
						$c=0;
				$getAd = $db->query("select * from tblad order by AdType asc, AdOrder asc");
				while($setAd = $getAd->fetch_object())
				{
					$c++;
				?>
                        <tr>
                            <td><?php echo $c ?></td>
                            <td><strong><?php echo $setAd->url ?></strong></td>
                            <td><?php echo AdType($setAd->AdType); if($setAd->AdType == 2) echo "<br />Occupied Ratio: ".$setAd->BotAdType; ?></td>
                            <td><img src="../adimage/<?php echo $setAd->image ?>" class="img-responsive img-thumbnail" /></td>
                            <td><?php echo $setAd->PubDate ?></td>
                            <td align="center"><?php echo $setAd->AdOrder ?></td>
                            <td align="center"><?php echo Status($setAd->status) ?></td>
                            <td align="center"><form method="post" class="btn-tooltips">
                                    <button title="Edit" class="btn btn-primary btn-xs edit" type="submit" id="btnEdit2" name="btnEdit2"  data-id="<?php echo $setAd->id;?>" data-button="btnEdit" data-class="btn btn-primary" data-input-name="id" data-target="#edit_modal" data-toggle="modal" data-url="<?php echo base_url() ?>editad.php"><span class="fa fa-pencil"></span></button>
                                    <button title="Delete" class="btn btn-danger btn-xs delete" type="submit" id="btnDelete2" name="btnDelete2"  data-id="<?php echo $setAd->id;?>" data-button="btnDelete" data-class="btn btn-danger" data-input-name="id" data-target="#delete_modal" data-toggle="modal" data-url=""><span class="fa fa-trash"></span></button>
                                    <button title="Hide" class="btn btn-warning btn-xs hidecate" type="submit" id="btnHide2" name="btnHide2"  data-id="<?php echo $setAd->id;?>" data-button="btnHide" data-class="btn btn-warning" data-input-name="id" data-target="#hide_modal" data-toggle="modal" data-url=""><span class="fa fa-ban"></span></button>
                                    <button title="Show" class="btn btn-success btn-xs showcate" type="submit" id="btnShow2" name="btnShow2"  data-id="<?php echo $setAd->id;?>" data-button="btnShow" data-class="btn btn-success" data-input-name="id" data-target="#show_modal" data-toggle="modal" data-url=""><span class="fa fa-check"></span></button>
                                    <input type="hidden" name="rand" value="<?php echo $rand;?>">
                                </form></td>
                        </tr>
                        <?php
				}
				?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
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
            <div class="alert alert-danger">
            <strong>Image Sizes:</strong>
            	<ol>
                	<li>Quarter sized Image : 500px (W) X 250px (H)</li>
                    <li>Half sized Image : 1200px (W) X 500px (H)</li>
                    <li>Full sized Image : 1200px (W) X 300px (H)</li>
                    <li>Right Image : 500px (W) X any size (H)</li>
                    <li>Top Image : 1380px (W) X 300px (H)</li>
                </ol>
            </div>
                <form class="form-horizontal" id="AllForm" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label class="control-label" for="txturl">URL</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="txturl" id="txturl">
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
                                    <input type='file' name='txtImage' id='txtImage' class='hidden' value='' accept="image/*" required />
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
                                <option value="0">Top</option>
                                <option value="1">Right</option>
                                <option value="2">Bottom</option>
                            </select>
                        </div>
                        <div class="col-sm-6 for-bottom">
                            <label class="control-label" for="txtBotAdType">Bottom Ad Type</label>
                            <select class="form-control" name="txtBotAdType" id="txtBotAdType">
                                <option value=""></option>
                                <option value="4">Quarter</option>
                                <option value="6">Half</option>
                                <option value="12">Full</option>
                            </select>
                        </div>
                        <div class="col-sm-6 for-rnb">
                            <label class="control-label" for="txtAdOrder">Ad Order</label>
                            <input type="text" class="form-control" name="txtAdOrder" id="txtAdOrder">
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="txtStatus">Status</label>
                            <select class="form-control" name="txtStatus" id="txtStatus">
                                <option value=""></option>
                                <option value="0">Publish</option>
                                <option value="1">Hidden</option>
                            </select>
                        </div>
                        <div class="col-sm-6 for-bottom">
                            <label class="control-label" for="txtAdPosition">Position</label>
                            <select class="form-control" name="txtAdPosition" id="txtAdPosition">
                                <option value=""></option>
                                <option value="0">Up</option>
                                <option value="1">Down</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <textarea name="txtdescription" id="txtdescription" class="textarea">
</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-5">
                            <button name="btnSave" id="btnSave" class="btn btn-primary btn-lg btn-block">Save</button>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $_SESSION['rand'] ?>" name="rand">
                    <input type="hidden" value="" name="txtid">
                </form>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper --> 

<script>
	$('#add_form').hide();
    	$('#add_form_button').click(function(){
			$('#add_form').show();
			$('.hide-cate-list').trigger("click");
			$('#txtCateTitle').focus()
			$('.cate-form-title').html("Add Form");
			$('#btnSave').attr('name','btnSave');
			$('#AllForm')[0].reset();
		})
		$('.show-cate-list').click(function(){
			$('.hide-cate-list').trigger("click");
			$('#btnSave').attr('name','');
		})
		$('.for-bottom, .for-rnb').hide();
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
