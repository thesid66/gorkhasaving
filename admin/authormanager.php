<?php include('database/db.php'); ?>
<?php include('include/header.php');
$page = "author";

if(isset($_POST['btnSave']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$id = maxid("tblauthor","id",$db);
		
		$file = $_FILES['txtauthorimg']['name'];
		if($file!=NULL or $file!="")
		{
			$getfile = explode(".",$file);
			$setfile = $getfile[0]."_".time().".".end($getfile);
			move_uploaded_file($_FILES['txtauthorimg']['tmp_name'],'../authorimage/'.$setfile);
		}
		
		$db->query("insert into tblauthor set
		id	= '$id',
		authorname	= '".$db->real_escape_string($_POST['txtauthorname'])."',
		authordesc	= '".$db->real_escape_string($_POST['txtauthordesc'])."',
		authorimg	= '".$setfile."',
		status		= '".$db->real_escape_string($_POST['txtstatus'])."'
		");
		
		notify("Author Manager","Author Inserted Successfully",base_url()."authormanager.php", FALSE,1000,0);
		
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
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Author List</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool hide-cate-list" data-widget="collapse"><i class="fa fa-plus"></i> </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="pull-right">
                    <a href="#" id="add_form_button" class="btn btn-primary">Add Author</a>
                </div>
                <div class="clearfix">
                </div>
                <br>
                <table id="dataTable" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="15%">Author Name</th>
                            <th width="8%">Image</th>
                            <th width="53%">Description</th>
                            <th width="10%">Status</th>
                            <th width="14%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
				$getCate = $db->query("select * from tblauthor order by id asc");
				while($setCate = $getCate->fetch_object())
				{
				?>
                        <tr>
                            <td><?php echo $setCate->authorname ?></td>
                            <td><img src="../authorimage/<?php echo $setCate->authorimg ?>" class="img-responsive img-circle img-thumbnail" /></td>
                            <td><?php echo $setCate->authordesc ?></td>
                            <td align="center"><?php echo Status($setCate->status) ?></td>
                            <td align="center"><form method="post" class="btn-tooltips">
                                    <button title="Edit" class="btn btn-primary btn-xs edit" type="submit" id="btnEdit2" name="btnEdit2"  data-id="<?php echo $setCate->id;?>" data-button="btnEdit" data-class="btn btn-primary" data-input-name="id" data-target="#edit_modal" data-toggle="modal" data-url="<?php echo base_url() ?>editauthor.php"><span class="fa fa-pencil"></span></button>
                                    <button title="Delete" class="btn btn-danger btn-xs delete" type="submit" id="btnDelete2" name="btnDelete2"  data-id="<?php echo $setCate->id;?>" data-button="btnDelete" data-class="btn btn-danger" data-input-name="id" data-target="#delete_modal" data-toggle="modal" data-url=""><span class="fa fa-trash"></span></button>
                                    <button title="Hide" class="btn btn-warning btn-xs hidecate" type="submit" id="btnHide2" name="btnHide2"  data-id="<?php echo $setCate->id;?>" data-button="btnHide" data-class="btn btn-warning" data-input-name="id" data-target="#hide_modal" data-toggle="modal" data-url=""><span class="fa fa-ban"></span></button>
                                    <button title="Show" class="btn btn-success btn-xs showcate" type="submit" id="btnShow2" name="btnShow2"  data-id="<?php echo $setCate->id;?>" data-button="btnShow" data-class="btn btn-success" data-input-name="id" data-target="#show_modal" data-toggle="modal" data-url=""><span class="fa fa-check"></span></button>
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
                        <div class="col-sm-4">
                            <label class="control-label" for="txtauthorname">Author Name</label>
                            <input type="text" class="form-control" name="txtauthorname" id="txtauthorname">
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label" for="txtauthorimg">Select Image</label>
                            <div class='input-group '>
                                <span class='input-group-btn'>
                                <label class='btn btn-primary'><span class='fa fa-plus'></span> Author Image
                                    <input type='file' name='txtauthorimg' id='txtauthorimg' class='hidden' value='' accept="image/*" required />
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
                       
                        <div class="col-sm-4">
                            <label class="control-label" for="txtstatus">Status</label>
                            <select class="form-control" name="txtstatus" id="txtstatus">
                                <option value=""></option>
                                <option value="0">Publish</option>
                                <option value="1">Hidden</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group no-link">
                        <div class="col-sm-12">
                            <textarea name="txtauthordesc" id="txtauthordesc" class="textarea"></textarea>
                            
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
confirm2("Author Management","Do you want to Modify the record?","edit","edit_modal",$rand,4);
?>
<!-- Main Footer -->
<?php include('include/footer.php'); ?>