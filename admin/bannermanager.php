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
			$getfile = explode(".",$file);
			$setfile = $getfile[0]."_".time().".".end($getfile);
			move_uploaded_file($_FILES['txtImage']['tmp_name'],'../slider/'.$setfile);
		}
		
		$id = maxid("tblbanner","id",$db);
		
		$db->query("insert into tblbanner set
		id	= '$id',
		PubDate		= '".date("Y-m-d h:i:s a")."',
		bantitle	= '".$db->real_escape_string($_POST['txtbannerTitle'])."',
		banimg		= '".$db->real_escape_string($setfile)."',
		placeorder	= '".$db->real_escape_string($_POST['txtBanOrder'])."',
		banlink	= '".$db->real_escape_string($_POST['txtbanlink'])."',
		status		= '".$db->real_escape_string($_POST['txtStatus'])."'
		");
		
		notify("Banner Manager","Category Inserted Successfully",base_url()."bannermanager.php", FALSE,1000,0);
		
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
            <h3 class="box-title">Banner List</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool hide-cate-list" data-widget="collapse"><i class="fa fa-plus"></i> </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="pull-right">
                <a href="#" id="add_form_button" class="btn btn-primary">Add Banner</a>
            </div>
            <div class="clearfix">
            </div>
            <br>
            <table id="dataTable" class="table table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="26%">Banner Title</th>
                        <th width="22%">Image</th>
                        <th width="14%">Link</th>
                        <th width="5%">Published Date</th>
                        <th width="3%">Order</th>
                        <th width="11%">Status</th>
                        <th width="14%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
						$c=0;
				$getBanner = $db->query("select * from tblbanner order by placeorder asc");
				while($setBanner = $getBanner->fetch_object())
				{
					$c++;
				?>
                    <tr>
                        <td><?php echo $c ?></td>
                        <td><strong><?php echo $setBanner->bantitle ?></strong></td>
                        <td><img src="../slider/<?php echo $setBanner->banimg ?>" class="img-responsive img-thumbnail" /></td>
                        <td><?php echo $setBanner->banlink ?></td>
                        <td><?php echo $setBanner->PubDate ?></td>
                        <td align="center"><?php echo $setBanner->placeorder ?></td>
                        <td align="center"><?php echo Status($setBanner->status) ?></td>
                        <td align="center"><form method="post" class="btn-tooltips">
                                <button title="Edit" class="btn btn-primary btn-xs edit" type="submit" id="btnEdit2" name="btnEdit2"  data-id="<?php echo $setBanner->id;?>" data-button="btnEdit" data-class="btn btn-primary" data-input-name="id" data-target="#edit_modal" data-toggle="modal" data-url="<?php echo base_url() ?>editbannermanager.php"><span class="fa fa-pencil"></span></button>
                                <button title="Delete" class="btn btn-danger btn-xs delete" type="submit" id="btnDelete2" name="btnDelete2"  data-id="<?php echo $setBanner->id;?>" data-button="btnDelete" data-class="btn btn-danger" data-input-name="id" data-target="#delete_modal" data-toggle="modal" data-url=""><span class="fa fa-trash"></span></button>
                                <button title="Hide" class="btn btn-warning btn-xs hidecate" type="submit" id="btnHide2" name="btnHide2"  data-id="<?php echo $setBanner->id;?>" data-button="btnHide" data-class="btn btn-warning" data-input-name="id" data-target="#hide_modal" data-toggle="modal" data-url=""><span class="fa fa-ban"></span></button>
                                <button title="Show" class="btn btn-success btn-xs showcate" type="submit" id="btnShow2" name="btnShow2"  data-id="<?php echo $setBanner->id;?>" data-button="btnShow" data-class="btn btn-success" data-input-name="id" data-target="#show_modal" data-toggle="modal" data-url=""><span class="fa fa-check"></span></button>
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
        <form class="form-horizontal" id="AllForm" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <div class="col-sm-6">
                    <label class="control-label" for="txtbannerTitle">Banner Title</label>
                    <input type="text" class="form-control" name="txtbannerTitle" id="txtbannerTitle">
                </div>
                <div class="col-sm-6">
                <label class="control-label" for="txtImage">Select Banner</label>
                    <div class='input-group '> 
                        <span class='input-group-btn'>
                        <label class='btn btn-primary'><span class='fa fa-plus'></span> Banner Image
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
                    <input type="text" class="form-control" name="txtBanOrder" id="txtBanOrder">
                </div>
                <div class="col-sm-6">
                    <label class="control-label" for="txtbanlink">Banner Link</label>
                    <input type="text" class="form-control" name="txtbanlink" id="txtbanlink">
                </div>
                <div class="col-sm-6">
                    <label class="control-label" for="txtStatus">Status</label>
                    <select class="form-control" name="txtStatus" id="txtStatus">
                        <option value=""></option>
                        <option value="0">Publish</option>
                        <option value="1">Hidden</option>
                    </select>
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
		
		    
		
    </script>
<?php
confirm2("Banner Management","Do you want to Modify the record?","edit","edit_modal",$rand,4);
confirm2("Banner Management","Do you want to delete the record?","delete","delete_modal",$rand,1);
confirm2("Banner Management","Do you want to Modify the record?","hidecate","hide_modal",$rand,2);
confirm2("Banner Management","Do you want to Modify the record?","showcate","show_modal",$rand,3);
?>
<!-- Main Footer -->
<?php include('include/footer.php'); ?>