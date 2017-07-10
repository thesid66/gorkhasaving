<?php include('database/db.php'); ?>
<?php include('include/header.php');
$page = "photo";

unset($_SESSION['GalID']);

if(isset($_POST['btnSave']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$pageid = maxid("gallery","pageid",$db);
		
		$db->query("insert into gallery set
		pageid		= '$pageid',
		pagetitle	= '".$db->real_escape_string($_POST['txtpagetitle'])."',
		pubdate		= '".date('Y-m-d h:i:s a')."',
		status		= '".$db->real_escape_string($_POST['txtstatus'])."'
		");
		
		notify("Photo Manager","Photo Inserted Successfully",base_url()."photomanager.php", FALSE,1000,0);
		
		die();
	}
}

if(isset($_POST['btnEdit']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update gallery set
		pagetitle	= '".$db->real_escape_string($_POST['txtpagetitle'])."',
		status		= '".$db->real_escape_string($_POST['txtstatus'])."'
		where
		pageid		= '".$db->real_escape_string($_POST['txtpageid'])."'
		");
		
		notify("Photo Manager","Photo Modified Successfully",base_url()."photomanager.php", FALSE,1000,0);
		
		die();
	}
}

if(isset($_POST['btnDelete']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("delete from gallery where pageid = '".$_POST['pageid']."'");
		notify("Photo Manager","Photo Deleted Successfully",base_url()."photomanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnHide']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update gallery set Status = '1' where pageid = '".$_POST['pageid']."'");
		notify("Photo Manager","Photo Modified Successfully",base_url()."photomanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnShow']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update gallery set Status = '0' where pageid = '".$_POST['pageid']."'");
		notify("Photo Manager","Photo Modified Successfully",base_url()."photomanager.php", FALSE,1000,0);
		
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
        <h1> Photo Manager </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">photo List</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool hide-cate-list" data-widget="collapse"><i class="fa fa-plus"></i> </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="pull-right">
                    <a href="#" id="add_form_button" class="btn btn-primary">Add photo</a>
                </div>
                <div class="clearfix">
                </div>
                <br>
                <table id="dataTable" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="25%">Photo Title</th>
                            <th width="16%">Cover Image</th>
                            <th width="17%">Published Date</th>
                            <th width="17%">Status</th>
                            <th width="12%">&nbsp;</th>
                            <th width="13%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
				$getCate = $db->query("select * from gallery order by pageid asc") or return_error();
				while($setCate = $getCate->fetch_object())
				{
				?>
                        <tr>
                            <td><?php echo $setCate->pagetitle ?></td>
                            <td><?php 
                            $getCover = $db->query("select image from gallerydetails where CoverImage = '1' and pageid = '".$setCate->pageid."'");
                            $setCover = $getCover->fetch_object();
                             ?><img src="../galleryimages/<?php echo $setCover->image ?>" class="img-thumbnail img-responsive" alt=""></td>
                            <td align="center"><?php echo ($setCate->pubdate) ?></td>
                            <td align="center"><?php echo Status($setCate->status) ?></td>
                            <td align="center">
                            <form method="post" class="btn-tooltips">
                                
                                <button title="Add Gallery Images" class="btn btn-primary btn-xs addgal" type="submit" id="btnAddGal2" name="btnAddGal2"  data-id="<?php echo $setCate->pageid;?>" data-button="btnAddGal" data-class="btn btn-primary" data-input-name="pageid" data-target="#addgal_modal" data-toggle="modal" data-url="<?php echo base_url(); ?>gallerydetail.php"><span class="fa fa-image"></span> Add Images</button>
                                
                                </span>
                            </td>
                            <td align="center"><form method="post" class="btn-tooltips">
                                <a class="btn btn-primary btn-xs edit-cate" id="<?php echo $setCate->pageid ?>" href="#" title="Edit"><span class="fa fa-pencil"></a>
                                <button title="Delete" class="btn btn-danger btn-xs delete" type="submit" id="btnDelete2" name="btnDelete2"  data-id="<?php echo $setCate->pageid;?>" data-button="btnDelete" data-class="btn btn-danger" data-input-name="pageid" data-target="#delete_modal" data-toggle="modal" data-url=""><span class="fa fa-trash"></span></button>
                                
                                <button title="Hide" class="btn btn-warning btn-xs hidecate" type="submit" id="btnHide2" name="btnHide2"  data-id="<?php echo $setCate->pageid;?>" data-button="btnHide" data-class="btn btn-warning" data-input-name="pageid" data-target="#hide_modal" data-toggle="modal" data-url=""><span class="fa fa-ban"></span></button>
                                
                                <button title="Show" class="btn btn-success btn-xs showcate" type="submit" id="btnShow2" name="btnShow2"  data-id="<?php echo $setCate->pageid;?>" data-button="btnShow" data-class="btn btn-success" data-input-name="pageid" data-target="#show_modal" data-toggle="modal" data-url=""><span class="fa fa-check"></span></button>
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
                <form class="form-horizontal" id="AllForm" method="post">
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label class="control-label" for="txtpagetitle">Photo Title</label>
                            <input type="text" class="form-control" name="txtpagetitle" id="txtpagetitle">
                        </div>
                        
                        <div class="col-sm-6">
                            <label class="control-label" for="txtstatus">Status</label>
                            <select class="form-control" name="txtstatus" id="txtstatus">
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
                    <input type="hidden" value="" name="txtpageid">
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
		$('.edit-cate').click(function(){
			$('#add_form').show();
			$('.hide-cate-list').trigger("click");
			$('#txtCateTitle').focus()
			$('.cate-form-title').html("Edit Form");
			$('#btnSave').attr('name','btnEdit');
			
			linkid = $(this).attr('id')
			$.ajax({
				type:'POST',
				data:'linkid='+linkid,
				dataType : "json",
				url:"<?php echo base_url() ?>api/photo.php",
				success: process_response
			})
		});
		    
		
    </script> 
    <?php
confirm2("photo Management","Do you want to delete the record?","delete","delete_modal",$rand,1);
confirm2("photo Management","Do you want to Modify the record?","hidecate","hide_modal",$rand,2);
confirm2("photo Management","Do you want to Modify the record?","showcate","show_modal",$rand,3);
confirm2("photo Management","Do you want to add images on this gallery?","addgal","addgal_modal",$rand,4);
?>
<!-- Main Footer -->
<?php include('include/footer.php'); ?>