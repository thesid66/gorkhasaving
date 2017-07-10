<?php include('database/db.php'); ?>
<?php include('include/header.php');
$page = "links";

if(isset($_POST['btnSave']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$id = maxid("tbllinks","id",$db);
		
		$db->query("insert into tbllinks set
		id	= '$id',
		officename	= '".$db->real_escape_string($_POST['txtofficename'])."',
		links		= '".$db->real_escape_string($_POST['txtlinks'])."',
		linktype	= '".$db->real_escape_string($_POST['txtlinktype'])."',
		status		= '".$db->real_escape_string($_POST['txtstatus'])."'
		");
		
		notify("Links Manager","Links Inserted Successfully",base_url()."linksmanager.php", FALSE,1000,0);
		
		die();
	}
}

if(isset($_POST['btnEdit']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tbllinks set
		officename	= '".$db->real_escape_string($_POST['txtofficename'])."',
		links		= '".$db->real_escape_string($_POST['txtlinks'])."',
		linktype	= '".$db->real_escape_string($_POST['txtlinktype'])."',
		status		= '".$db->real_escape_string($_POST['txtstatus'])."'
		where
		id		= '".$db->real_escape_string($_POST['txtid'])."'
		");
		
		notify("Links Manager","Links Modified Successfully",base_url()."linksmanager.php", FALSE,1000,0);
		
		die();
	}
}

if(isset($_POST['btnDelete']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("delete from tbllinks where id = '".$_POST['id']."'");
		notify("Links Manager","Links Deleted Successfully",base_url()."linksmanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnHide']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tbllinks set Status = '1' where id = '".$_POST['id']."'");
		notify("Links Manager","Links Modified Successfully",base_url()."linksmanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnShow']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tbllinks set Status = '0' where id = '".$_POST['id']."'");
		notify("Links Manager","Links Modified Successfully",base_url()."linksmanager.php", FALSE,1000,0);
		
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
        <h1> Links Manager </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Links List</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool hide-cate-list" data-widget="collapse"><i class="fa fa-plus"></i> </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="pull-right">
                    <a href="#" id="add_form_button" class="btn btn-primary">Add Links</a>
                </div>
                <div class="clearfix">
                </div>
                <br>
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Links Title</th>
                            <th>Link</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
				$getCate = $db->query("select * from tbllinks order by id asc");
				while($setCate = $getCate->fetch_object())
				{
				?>
                        <tr>
                            <td><?php echo $setCate->officename ?></td>
                            <td><?php echo $setCate->links ?></td>
                            <td><?php echo $setCate->linktype == 0 ? "Related Links" : "Other Links" ?></td>
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
                        <div class="col-sm-6">
                            <label class="control-label" for="txtofficename">Links Title</label>
                            <input type="text" class="form-control" name="txtofficename" id="txtofficename">
                        </div>
                        
                        <div class="col-sm-6">
                            <label class="control-label" for="txtlinks">Links</label>
                            <input type="text" class="form-control" name="txtlinks" id="txtlinks">
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="txtlinktype">Link Type</label>
                            <select class="form-control" name="txtlinktype" id="txtlinktype">
                                <option value=""></option>
                                <option value="0">Related Links</option>
                                <option value="1">Other Links</option>
                            </select>
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
				url:"<?php echo base_url() ?>api/links.php",
				success: process_response
			})
		});
		    
		
    </script> 
    <?php
confirm2("Links Management","Do you want to delete the record?","delete","delete_modal",$rand,1);
confirm2("Links Management","Do you want to Modify the record?","hidecate","hide_modal",$rand,2);
confirm2("Links Management","Do you want to Modify the record?","showcate","show_modal",$rand,3);
?>
<!-- Main Footer -->
<?php include('include/footer.php'); ?>