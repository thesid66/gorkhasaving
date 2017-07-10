<?php include('database/db.php'); ?>
<?php include('include/header.php');
$page = "network";

if(isset($_POST['btnSave']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
        $file = $_FILES['txtImage']['name'];
        if($file!=NULL or $file!="")
        {
            $getfile = explode(".",$file);
            $setfile = $getfile[0]."_".time().".".end($getfile);
            move_uploaded_file($_FILES['txtImage']['tmp_name'],'../uploads/images/'.$setfile);
        }

		$InfoID = maxid("tblvetinfo","InfoID",$db);
		
		$db->query("insert into tblvetinfo set
		InfoID      = '$InfoID',
		Title	    = '".$db->real_escape_string($_POST['txtTitle'])."',
        Address     = '".$db->real_escape_string($_POST['txtAddress'])."',
        ContactNo   = '".$db->real_escape_string($_POST['txtContactNo'])."',
        Email       = '".$db->real_escape_string($_POST['txtEmail'])."',
        Website     = '".$db->real_escape_string($_POST['txtWebsite'])."',
        Image       = '$setfile',
		NetworkType	= '".$db->real_escape_string($_POST['txtNetworkType'])."',
		Status		= '".$db->real_escape_string($_POST['txtStatus'])."'
		");
		
		notify("Network Manager","Network Inserted Successfully",base_url()."networkmanager.php", FALSE,1000,0);
		
		die();
	}
}

if(isset($_POST['btnEdit']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
        $getImage = $db->query("select * from tblvetinfo where InfoID = '".$_POST['txtInfoID']."'");
        $setImage = $getImage->fetch_object();

        $file = $_FILES['txtImage']['name'];
        if($file!=NULL or $file!="")
        {
            $getfile = explode(".",$file);
            $setfile = $getfile[0]."_".time().".".end($getfile);
            move_uploaded_file($_FILES['txtImage']['tmp_name'],'../uploads/images/'.$setfile);
        }
        else
        {
            $setfile = $setImage->Image;
        }

		$db->query("update tblvetinfo set
		Title       = '".$db->real_escape_string($_POST['txtTitle'])."',
        Address     = '".$db->real_escape_string($_POST['txtAddress'])."',
        ContactNo   = '".$db->real_escape_string($_POST['txtContactNo'])."',
        Email       = '".$db->real_escape_string($_POST['txtEmail'])."',
        Website     = '".$db->real_escape_string($_POST['txtWebsite'])."',
        Image       = '$setfile',
        NetworkType = '".$db->real_escape_string($_POST['txtNetworkType'])."',
		Status		= '".$db->real_escape_string($_POST['txtStatus'])."'
		where
		InfoID		= '".$db->real_escape_string($_POST['txtInfoID'])."'
		");
		
		notify("Network Manager","Network Modified Successfully",base_url()."networkmanager.php", FALSE,1000,0);
		
		die();
	}
}

if(isset($_POST['btnDelete']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
        $getImage = $db->query("select * from tblvetinfo where InfoID = '".$_POST['InfoID']."'");
        $setImage = $getImage->fetch_object();
        if(file_exists("../uploads/images/".$setImage->Image))
        {
            unlink("../uploads/images/".$setImage->Image);
        }
		$db->query("delete from tblvetinfo where InfoID = '".$_POST['InfoID']."'");
		notify("Network Manager","Network Deleted Successfully",base_url()."networkmanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnHide']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tblvetinfo set Status = '1' where InfoID = '".$_POST['InfoID']."'");
		notify("Network Manager","Network Modified Successfully",base_url()."networkmanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnShow']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tblvetinfo set Status = '0' where InfoID = '".$_POST['InfoID']."'");
		notify("Network Manager","Network Modified Successfully",base_url()."networkmanager.php", FALSE,1000,0);
		
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
        <h1> Network Manager </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Network List</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool hide-cate-list" data-widget="collapse"><i class="fa fa-plus"></i> </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="pull-right">
                    <a href="#" id="add_form_button" class="btn btn-primary">Add Network</a>
                </div>
                <div class="clearfix">
                </div>
                <br>
                <table id="dataTable" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="21%">Title</th>
                            <th width="14%">Address</th>
                            <th width="14%">Contact</th>
                            <th width="14%">Email</th>
                            <th width="14%">Website</th>
                            <th width="10%">Status</th>
                            <th width="13%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
				$getCate = $db->query("select * from tblvetinfo order by InfoID asc");
				while($setCate = $getCate->fetch_object())
				{
				?>
                        <tr>
                            <td><?php echo $setCate->Title ?></td>
                            <td><?php echo $setCate->Address ?></td>
                            <td><?php echo $setCate->ContactNo ?></td>
                            <td><?php echo $setCate->Email ?></td>
                            <td><?php echo $setCate->Website ?></td>
                            <td align="center"><?php echo Status($setCate->Status) ?></td>
                            <td align="center"><form method="post" class="btn-tooltips">
                            <a class="btn btn-primary btn-xs edit-cate" id="<?php echo $setCate->InfoID ?>" href="#" title="Edit"><span class="fa fa-pencil"></a>
                                    <button title="Delete" class="btn btn-danger btn-xs delete" type="submit" id="btnDelete2" name="btnDelete2"  data-id="<?php echo $setCate->InfoID;?>" data-button="btnDelete" data-class="btn btn-danger" data-input-name="InfoID" data-target="#delete_modal" data-toggle="modal" data-url=""><span class="fa fa-trash"></span></button>
                     
                      <button title="Hide" class="btn btn-warning btn-xs hidecate" type="submit" id="btnHide2" name="btnHide2"  data-id="<?php echo $setCate->InfoID;?>" data-button="btnHide" data-class="btn btn-warning" data-input-name="InfoID" data-target="#hide_modal" data-toggle="modal" data-url=""><span class="fa fa-ban"></span></button>
                      
                      <button title="Show" class="btn btn-success btn-xs showcate" type="submit" id="btnShow2" name="btnShow2"  data-id="<?php echo $setCate->InfoID;?>" data-button="btnShow" data-class="btn btn-success" data-input-name="InfoID" data-target="#show_modal" data-toggle="modal" data-url=""><span class="fa fa-check"></span></button>
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
                            <label class="control-label" for="txtNetworkType">Select Category</label>
                            <select name="txtNetworkType" class="form-control">
                                <option value=""></option>
                                <option value="1">Online Information</option>
                                <option value="2">Vet Network</option>
                                <option value="3">Business Partners</option>
                                option
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label" for="txtTitle">Title</label>
                            <input type="text" class="form-control" name="txtTitle" id="txtTitle">
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label" for="txtAddress">Address</label>
                            <input type="text" class="form-control" name="txtAddress" id="txtAddress">
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label" for="txtContactNo">Contact No</label>
                            <input type="text" class="form-control" name="txtContactNo" id="txtContactNo">
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label" for="txtEmail">Email</label>
                            <input type="text" class="form-control" name="txtEmail" id="txtEmail">
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label" for="txtWebsite">Website</label>
                            <input type="text" class="form-control" name="txtWebsite" id="txtWebsite">
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label" for="txtStatus">Status</label>
                            <select class="form-control" name="txtStatus" id="txtStatus">
                                <option value=""></option>
                                <option value="0">Publish</option>
                                <option value="1">Hidden</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label" for="txtImage">Image</label>
                            <div class='input-group'> 
                                <span class='input-group-btn'>
                                <label class='btn btn-primary'><span class='fa fa-plus'></span> Select
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
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-5">
                            <button name="btnSave" id="btnSave" class="btn btn-primary btn-lg btn-block">Save</button>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $_SESSION['rand'] ?>" name="rand">
                    <input type="hidden" value="" name="txtInfoID">
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
            $('#txtImage').attr('required')
            return false;
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
            $('#txtImage').removeAttr('required')
			
			InfoID = $(this).attr('id')
			$.ajax({
				type:'POST',
				data:'InfoID='+InfoID,
				dataType : "json",
				url:"<?php echo base_url() ?>api/network.php",
				success: process_response
			})
            return false;
		});
		    
		
    </script> 
    <?php
confirm2("Network Management","Do you want to delete the record?","delete","delete_modal",$rand,1);
confirm2("Network Management","Do you want to Modify the record?","hidecate","hide_modal",$rand,2);
confirm2("Network Management","Do you want to Modify the record?","showcate","show_modal",$rand,3);
?>
<!-- Main Footer -->
<?php include('include/footer.php'); ?>