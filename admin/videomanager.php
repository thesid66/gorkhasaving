<?php include('database/db.php'); ?>
<?php include('include/header.php');
$page = "video";

if(isset($_POST['btnSave']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$id = maxid("tblvideo","id",$db);
		
		$db->query("insert into tblvideo set
		id	= '$id',
		title	= '".$db->real_escape_string($_POST['txttitle'])."',
		link		= '".$db->real_escape_string($_POST['txtlink'])."',
		publishdate		= '".date('Y-m-d h:i:s a')."',
		status		= '".$db->real_escape_string($_POST['txtstatus'])."'
		");
		
		notify("Video Manager","Video Inserted Successfully",base_url()."videomanager.php", FALSE,1000,0);
		
		die();
	}
}

if(isset($_POST['btnEdit']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tblvideo set
		title	= '".$db->real_escape_string($_POST['txttitle'])."',
		link		= '".$db->real_escape_string($_POST['txtlink'])."',
		status		= '".$db->real_escape_string($_POST['txtstatus'])."'
		where
		id		= '".$db->real_escape_string($_POST['txtid'])."'
		");
		
		notify("video Manager","video Modified Successfully",base_url()."videomanager.php", FALSE,1000,0);
		
		die();
	}
}

if(isset($_POST['btnDelete']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("delete from tblvideo where id = '".$_POST['id']."'");
		notify("video Manager","video Deleted Successfully",base_url()."videomanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnHide']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tblvideo set Status = '1' where id = '".$_POST['id']."'");
		notify("video Manager","video Modified Successfully",base_url()."videomanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnShow']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tblvideo set Status = '0' where id = '".$_POST['id']."'");
		notify("video Manager","video Modified Successfully",base_url()."videomanager.php", FALSE,1000,0);
		
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
        <h1> video Manager </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">video List</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool hide-cate-list" data-widget="collapse"><i class="fa fa-plus"></i> </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="pull-right">
                    <a href="#" id="add_form_button" class="btn btn-primary">Add video</a>
                </div>
                <div class="clearfix">
                </div>
                <br>
                <table id="dataTable" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="25%">Video Title</th>
                            <th width="29%">Link</th>
                            <th width="19%">Published Date</th>
                            <th width="14%">Status</th>
                            <th width="13%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
				$getCate = $db->query("select * from tblvideo order by id asc");
				while($setCate = $getCate->fetch_object())
				{
				?>
                        <tr>
                            <td><?php echo $setCate->title ?></td>
                            <td><?php echo $setCate->link ?></td>
                            <td align="center"><?php echo ($setCate->publishdate) ?></td>
                            <td align="center"><?php echo Status($setCate->status) ?></td>
                            <td align="center"><form method="post" class="btn-tooltips">
                            <a class="btn btn-primary btn-xs edit-cate" id="<?php echo $setCate->id ?>" href="#" title="Edit"><span class="fa fa-pencil"></a>
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
                <form class="form-horizontal" id="AllForm" method="post">
                    <div class="form-group">
                        <div class="col-sm-4">
                            <label class="control-label" for="txttitle">Video Title</label>
                            <input type="text" class="form-control" name="txttitle" id="txttitle">
                        </div>
                        
                        <div class="col-sm-4">
                            <label class="control-label" for="txtlink">Video</label>
                            <input type="text" class="form-control" name="txtlink" id="txtlink">
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
				url:"<?php echo base_url() ?>api/video.php",
				success: process_response
			})
		});
		    
		
    </script> 
    <?php
confirm2("video Management","Do you want to delete the record?","delete","delete_modal",$rand,1);
confirm2("video Management","Do you want to Modify the record?","hidecate","hide_modal",$rand,2);
confirm2("video Management","Do you want to Modify the record?","showcate","show_modal",$rand,3);
?>
<!-- Main Footer -->
<?php include('include/footer.php'); ?>