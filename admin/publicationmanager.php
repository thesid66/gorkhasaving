<?php include('database/db.php'); ?>
<?php include('include/header.php');
$page = "publication";

if(isset($_POST['btnSave']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$file = $_FILES['txtImage']['name'];
		if($file!=NULL or $file!="")
		{
			$getfile = explode(".",$file);
			$setfile = $getfile[0]."_".time().".".end($getfile);
			move_uploaded_file($_FILES['txtImage']['tmp_name'],'../downloadfile/'.$setfile);
		}
		
		$id = maxid("tbldownloads","id",$db);
		
		$db->query("insert into tbldownloads set
		id		= '$id',
		title		= '".$db->real_escape_string($_POST['txttitle'])."',
		attachedfile= '".$db->real_escape_string($setfile)."',
		shortdesc	= '".$db->real_escape_string($_POST['txtdescription'])."',
		author		= '".$db->real_escape_string($_POST['txtauthor'])."',
		pubdate		= '".date("Y-m-d h:i:s a")."',
		status		= '".$db->real_escape_string($_POST['txtstatus'])."'
		");
		
		notify("Publication Manager","Publication Inserted Successfully",base_url()."publicationmanager.php", FALSE,1000,0);
		
		die();
	}
}

if(isset($_POST['btnEdit']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tbldownloads set
		CateTitle	= '".$db->real_escape_string($_POST['txtCateTitle'])."',
		CateType	= '".$db->real_escape_string($_POST['txtCateType'])."',
		status		= '".$db->real_escape_string($_POST['txtstatus'])."',
		PubDate		= '".date("Y-m-d h:i:s a")."',
		CateOrder	= '".$db->real_escape_string($_POST['txtCateOrder'])."'
		where
		id		= '".$db->real_escape_string($_POST['txtid'])."'
		");
		
		notify("Publication Manager","Publication Modified Successfully",base_url()."publicationmanager.php", FALSE,1000,0);
		
		die();
	}
}

if(isset($_POST['btnDelete']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$getOldFile = $db->query("select attachedfile from tbldownloads where id = '".$_POST['id']."'");
		$setOldFile = $getOldFile->fetch_object();
		
		if(file_exists('../downloadfile/'.$setOldFile->attachedfile))
		{
			unlink('../downloadfile/'.$setOldFile->attachedfile);
		}
		
		$db->query("delete from tbldownloads where id = '".$_POST['id']."'");
		notify("Publication Manager","Publication Deleted Successfully",base_url()."publicationmanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnHide']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tbldownloads set status = '1' where id = '".$_POST['id']."'");
		notify("Publication Manager","Publication Modified Successfully",base_url()."publicationmanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnShow']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tbldownloads set status = '0' where id = '".$_POST['id']."'");
		notify("Publication Manager","Publication Modified Successfully",base_url()."publicationmanager.php", FALSE,1000,0);
		
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
        <h1> Publication Manager </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Publication List</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool hide-cate-list" data-widget="collapse"><i class="fa fa-plus"></i> </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="pull-right">
                    <a href="#" id="add_form_button" class="btn btn-primary">Add Publication</a>
                </div>
                <div class="clearfix">
                </div>
                <br>
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Publication Title</th>
                            <th>Author</th>
                            <th>Published Date</th>
                            <th>status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
				$getCate = $db->query("select * from tbldownloads order by id desc");
				while($setCate = $getCate->fetch_object())
				{
				?>
                        <tr>
                            <td><?php echo $setCate->title ?></td>
                            <td><?php echo ($setCate->author) ?></td>
                            <td><?php echo $setCate->pubdate ?></td>
                            <td align="center"><?php echo status($setCate->status) ?></td>
                            <td align="center"><form method="post" class="btn-tooltips">
                            
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
                        <div class="col-sm-6">
                            <label class="control-label" for="txttitle">Publication Title</label>
                            <input type="text" class="form-control" name="txttitle" id="txttitle">
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="txtImage">Select File</label>
                            <div class='input-group '>
                                <span class='input-group-btn'>
                                <label class='btn btn-primary'><span class='fa fa-plus'></span> Choose File
                                    <input type='file' name='txtImage' id='txtImage' class='hidden' value='' required />
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
                            <label class="control-label" for="txtauthor">Author</label>
                            <input type="text" class="form-control" name="txtauthor" id="txtauthor">
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="txtstatus">status</label>
                            <select class="form-control" name="txtstatus" id="txtstatus">
                                <option value=""></option>
                                <option value="0">Publish</option>
                                <option value="1">Hidden</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <textarea name="txtdescription" id="txtdescription" class="textarea"></textarea>
                            
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
			
			id = $(this).attr('id')
			$.ajax({
				type:'POST',
				data:'id='+id,
				dataType : "json",
				url:"<?php echo base_url() ?>api/Publication.php",
				success: process_response
			})
		});
		    
		
    </script> 
    <?php
confirm2("Publication Management","Do you want to delete the record?","delete","delete_modal",$rand,1);
confirm2("Publication Management","Do you want to Modify the record?","hidecate","hide_modal",$rand,2);
confirm2("Publication Management","Do you want to Modify the record?","showcate","show_modal",$rand,3);
?>
<!-- Main Footer -->
<?php include('include/footer.php'); ?>