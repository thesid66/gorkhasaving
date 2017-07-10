<?php include('database/db.php'); ?>
<?php include('include/header.php');
$page = "category";

if(isset($_POST['btnSave']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$id = maxid("article_cate","CateID",$db);
		
		$db->query("insert into article_cate set
		CateID		= '$id',
		CateTitle	= '".$db->real_escape_string($_POST['txtCateTitle'])."',
		CateType	= '".$db->real_escape_string($_POST['txtCateType'])."',
		Status		= '".$db->real_escape_string($_POST['txtStatus'])."',
		PubDate		= '".date("Y-m-d h:i:s a")."',
		CateOrder	= '".$db->real_escape_string($_POST['txtCateOrder'])."'
		");
		
		notify("Category Manager","Category Inserted Successfully",base_url()."categorymanager.php", FALSE,1000,0);
		
		die();
	}
}

if(isset($_POST['btnEdit']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update article_cate set
		CateTitle	= '".$db->real_escape_string($_POST['txtCateTitle'])."',
		CateType	= '".$db->real_escape_string($_POST['txtCateType'])."',
		Status		= '".$db->real_escape_string($_POST['txtStatus'])."',
		PubDate		= '".date("Y-m-d h:i:s a")."',
		CateOrder	= '".$db->real_escape_string($_POST['txtCateOrder'])."'
		where
		CateID		= '".$db->real_escape_string($_POST['txtCateID'])."'
		");
		
		notify("Category Manager","Category Modified Successfully",base_url()."categorymanager.php", FALSE,1000,0);
		
		die();
	}
}

if(isset($_POST['btnDelete']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("delete from article_cate where CateID = '".$_POST['CateID']."'");
		notify("Category Manager","Category Deleted Successfully",base_url()."categorymanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnHide']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update article_cate set Status = '1' where CateID = '".$_POST['CateID']."'");
		notify("Category Manager","Category Modified Successfully",base_url()."categorymanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnShow']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update article_cate set Status = '0' where CateID = '".$_POST['CateID']."'");
		notify("Category Manager","Category Modified Successfully",base_url()."categorymanager.php", FALSE,1000,0);
		
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
        <h1> Category Manager </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Category List</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool hide-cate-list" data-widget="collapse"><i class="fa fa-plus"></i> </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="pull-right">
                    <a href="#" id="add_form_button" class="btn btn-primary">Add Category</a>
                </div>
                <div class="clearfix">
                </div>
                <br>
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Category Title</th>
                            <th>Type</th>
                            <th>Published Date</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
				$getCate = $db->query("select * from article_cate order by CateOrder asc");
				while($setCate = $getCate->fetch_object())
				{
				?>
                        <tr>
                            <td><?php echo $setCate->CateTitle ?></td>
                            <td><?php echo CateType($setCate->CateType) ?></td>
                            <td><?php echo $setCate->PubDate ?></td>
                            <td align="center"><?php echo $setCate->CateOrder ?></td>
                            <td align="center"><?php echo Status($setCate->Status) ?></td>
                            <td align="center"><form method="post" class="btn-tooltips">
                            <a class="btn btn-primary btn-xs edit-cate" id="<?php echo $setCate->CateID ?>" href="#" title="Edit"><span class="fa fa-pencil"></a>
                                    <button title="Delete" class="btn btn-danger btn-xs delete" type="submit" id="btnDelete2" name="btnDelete2"  data-id="<?php echo $setCate->CateID;?>" data-button="btnDelete" data-class="btn btn-danger" data-input-name="CateID" data-target="#delete_modal" data-toggle="modal" data-url=""><span class="fa fa-trash"></span></button>
                     
                      <button title="Hide" class="btn btn-warning btn-xs hidecate" type="submit" id="btnHide2" name="btnHide2"  data-id="<?php echo $setCate->CateID;?>" data-button="btnHide" data-class="btn btn-warning" data-input-name="CateID" data-target="#hide_modal" data-toggle="modal" data-url=""><span class="fa fa-ban"></span></button>
                      
                      <button title="Show" class="btn btn-success btn-xs showcate" type="submit" id="btnShow2" name="btnShow2"  data-id="<?php echo $setCate->CateID;?>" data-button="btnShow" data-class="btn btn-success" data-input-name="CateID" data-target="#show_modal" data-toggle="modal" data-url=""><span class="fa fa-check"></span></button>
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
                            <label class="control-label" for="txtCateTitle">Category Title</label>
                            <input type="text" class="form-control" name="txtCateTitle" id="txtCateTitle">
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="txtCateType">Category Type</label>
                            <select class="form-control" name="txtCateType" id="txtCateType">
                                <option value=""></option>
                                <optgroup label=" Top Menu">
                                <option value="1">Single</option>
                                <option value="2">Menu</option>
                                <option value="3">Mega Menu</option>
                                <option value="4">Mega Menu (inc. Image)</option>
                                </optgroup>
                                <optgroup label=" Other">
                                <option value="5">News & Updates</option>
                                <option value="6">Popular Posts</option>
                                </optgroup>
                            </select>
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
                            <label class="control-label" for="txtCateOrder">Category Order</label>
                            <input type="text" class="form-control" name="txtCateOrder" id="txtCateOrder">
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
                    <input type="hidden" value="" name="txtCateID">
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
			
			cateid = $(this).attr('id')
			$.ajax({
				type:'POST',
				data:'CateID='+cateid,
				dataType : "json",
				url:"<?php echo base_url() ?>api/category.php",
				success: process_response
			})
		});
		    
		
    </script> 
    <?php
confirm2("Category Management","Do you want to delete the record?","delete","delete_modal",$rand,1);
confirm2("Category Management","Do you want to Modify the record?","hidecate","hide_modal",$rand,2);
confirm2("Category Management","Do you want to Modify the record?","showcate","show_modal",$rand,3);
?>
<!-- Main Footer -->
<?php include('include/footer.php'); ?>