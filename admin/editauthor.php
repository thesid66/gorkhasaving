<?php include('database/db.php'); ?>
<?php include('include/header.php');
$page = "author";

if(isset($_POST['btnSave']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$getOldImage = $db->query("select * from tblauthor where id = '".$db->real_escape_string($_POST['txtid'])."'");
		$setOldImage = $getOldImage->fetch_object();
		
		
		$file = $_FILES['txtauthorimg']['name'];
		if($file!=NULL or $file!="")
		{
			if(file_exists('../authorimage/'.$setOldImage->authorimg))
			{
				unlink('../authorimage/'.$setOldImage->authorimg);
			}
			$getfile = explode(".",$file);
			$setfile = $getfile[0]."_".time().".".end($getfile);
			move_uploaded_file($_FILES['txtauthorimg']['tmp_name'],'../authorimage/'.$setfile);
		}
		else
		{
			$setfile = $setOldImage->authorimg;
		}
		
		$db->query("update tblauthor set
		authorname	= '".$db->real_escape_string($_POST['txtauthorname'])."',
		authordesc	= '".$db->real_escape_string($_POST['txtauthordesc'])."',
		authorimg	= '".$setfile."',
		status		= '".$db->real_escape_string($_POST['txtstatus'])."'
		where
		id 			= '".$db->real_escape_string($_POST['txtid'])."'
		");
		
		notify("Author Manager","Author Modified Successfully",base_url()."authormanager.php", FALSE,1000,0);
		
		die();
	}
}


if(isset($_POST['btnDelete']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("delete from tblauthor where id = '".$_POST['id']."'");
		notify("Author Manager","Author Deleted Successfully",base_url()."authormanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnHide']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tblauthor set Status = '1' where id = '".$_POST['id']."'");
		notify("Author Manager","Author Modified Successfully",base_url()."authormanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnShow']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tblauthor set Status = '0' where id = '".$_POST['id']."'");
		notify("Author Manager","Author Modified Successfully",base_url()."authormanager.php", FALSE,1000,0);
		
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
        <h1> Author Manager </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <?php
		$getAuthor = $db->query("select * from tblauthor where id = '".$_POST['id']."'");
		$setAuthor = $getAuthor->fetch_object();
		?>
        <div class="box box-success">
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
                        <div class="col-sm-4">
                            <label class="control-label" for="txtauthorname">Author Name</label>
                            <input type="text" class="form-control" name="txtauthorname" value="<?php echo $setAuthor->authorname ?>" id="txtauthorname">
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label" for="txtauthorimg">Select Image</label>
                            <div class='input-group '>
                                <span class='input-group-btn'>
                                <label class='btn btn-primary'><span class='fa fa-plus'></span> Author Image
                                    <input type='file' name='txtauthorimg' id='txtauthorimg' class='hidden' value='' accept="image/*" />
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
								var control = $('#txtauthorimg');
								$('#txtauthorimg').change(function(){
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
                       <div class="col-sm-1">
                        	<img src="../authorimage/<?php echo $setAuthor->authorimg ?>" class="img-responsive img-circle img-thumbnail" />
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label" for="txtstatus">Status</label>
                            <select class="form-control" name="txtstatus" id="txtstatus">
                                <option value=""></option>
                                <option <?php echo $setAuthor->status == 0 ? "selected" : "" ?> value="0">Publish</option>
                                <option <?php echo $setAuthor->status == 1 ? "selected" : "" ?> value="1">Hidden</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group no-link">
                        <div class="col-sm-12">
                            <textarea name="txtauthordesc" id="txtauthordesc" class="textarea"><?php echo $setAuthor->authordesc ?></textarea>
                            
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-5">
                            <button name="btnSave" id="btnSave" class="btn btn-primary btn-lg btn-block">Save</button>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $_SESSION['rand'] ?>" name="rand">
                    <input type="hidden" value="<?php echo $setAuthor->id ?>" name="txtid">
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
				url:"<?php echo base_url() ?>api/Author.php",
				success: process_response
			})
		});
		    
		
    </script>
<?php
confirm2("Author Management","Do you want to delete the record?","delete","delete_modal",$rand,1);
confirm2("Author Management","Do you want to Modify the record?","hidecate","hide_modal",$rand,2);
confirm2("Author Management","Do you want to Modify the record?","showcate","show_modal",$rand,3);
?>
<!-- Main Footer -->
<?php include('include/footer.php'); ?>