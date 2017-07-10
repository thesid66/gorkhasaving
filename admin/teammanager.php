<?php include('database/db.php'); ?>
<?php include('include/header.php');
$page = "team";

if(isset($_POST['btnSave']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$file = $_FILES['txtImage']['name'];
		if($file!=NULL or $file!="")
		{
			$getfile = explode(".",$file);
			$setfile = $getfile[0]."_".time().".".end($getfile);
			move_uploaded_file($_FILES['txtImage']['tmp_name'],'../uploads/team/'.$setfile);
		}
		
		$id = maxid("tblstaff","StaffID",$db);
		
		$db->query("insert into tblstaff set
		StaffID     = '$id',
		Fullname	= '".$db->real_escape_string($_POST['txtFullname'])."',
		Image		= '".$db->real_escape_string($setfile)."',
		Placeorder	= '".$db->real_escape_string($_POST['txtPlaceorder'])."',
		SPost     	= '".$db->real_escape_string($_POST['txtSPost'])."',
		Status		= '".$db->real_escape_string($_POST['txtStatus'])."'
		");
		
		notify("Team Manager","Personeel Inserted Successfully",base_url()."teammanager.php", FALSE,1000,0);
		
		die();
	}
}

if(isset($_POST['btnEdit']))
{
    if($_SESSION['rand'] == $_POST['rand'])
    {
        $getFile = $db->query("select * from tblstaff where StaffID = '".$_POST['txtStaffID']."'");
        $setFile_u = $getFile->fetch_object();

        $file = $_FILES['txtImage']['name'];
        if($file!=NULL or $file!="")
        {
            $getfile = explode(".",$file);
            $setfile = $getfile[0]."_".time().".".end($getfile);
            move_uploaded_file($_FILES['txtImage']['tmp_name'],'../uploads/team/'.$setfile);
        }
        else
        {
            $setfile = $setFile_u->Image;
        }

        $db->query("update tblstaff set
        Fullname    = '".$db->real_escape_string($_POST['txtFullname'])."',
        Image       = '".$db->real_escape_string($setfile)."',
        Placeorder  = '".$db->real_escape_string($_POST['txtPlaceorder'])."',
        SPost       = '".$db->real_escape_string($_POST['txtSPost'])."',
        Status      = '".$db->real_escape_string($_POST['txtStatus'])."'
        where
        StaffID     = '".$db->real_escape_string($_POST['txtStaffID'])."'
        ");
        
        notify("Team Manager","Personeel Inserted Successfully",base_url()."teammanager.php", FALSE,1000,0);
        
        die();
    }
}


if(isset($_POST['btnDelete']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$getFile = $db->query("select * from tblstaff where StaffID = '".$_POST['StaffID']."'");
		$setFile_u = $getFile->fetch_object();
		if(file_exists('../uploads/team/'.$setFile_u->Image))
		{
			unlink('../uploads/team/'.$setFile_u->Image);
		}
		$db->query("delete from tblstaff where StaffID = '".$_POST['StaffID']."'");
		notify("Team Manager","Personeel Deleted Successfully",base_url()."teammanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnHide']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tblstaff set status = '1' where StaffID = '".$_POST['StaffID']."'");
		notify("Team Manager","Personeel Modified Successfully",base_url()."teammanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnShow']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tblstaff set status = '0' where StaffID = '".$_POST['StaffID']."'");
		notify("Team Manager","Personeel Modified Successfully",base_url()."teammanager.php", FALSE,1000,0);
		
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
        <h1> Team Manager </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Team list</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool hide-cate-list" data-widget="collapse"><i class="fa fa-plus"></i> </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="pull-right">
                <a href="#" id="add_form_button" class="btn btn-primary">Add Personeel</a>
            </div>
            <div class="clearfix">
            </div>
            <br>
            <table id="dataTable" class="table table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="26%">Name</th>
                        <th width="14%">Post</th>
                        <th width="22%">Image</th>
                        <th width="3%">Order</th>
                        <th width="11%">Status</th>
                        <th width="14%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
						$c=0;
				$getStaff = $db->query("select * from tblstaff order by placeorder asc");
				while($setTeam = $getStaff->fetch_object())
				{
					$c++;
				?>
                    <tr>
                        <td><?php echo $c ?></td>
                        <td><strong><?php echo $setTeam->Fullname ?></strong></td>
                        <td><?php echo $setTeam->SPost ?></td>
                        <td><img src="../uploads/team/<?php echo $setTeam->Image ?>" class="img-responsive img-thumbnail" /></td>
                        <td align="center"><?php echo $setTeam->Placeorder ?></td>
                        <td align="center"><?php echo Status($setTeam->Status) ?></td>
                        <td align="center"><form method="post" class="btn-tooltips">
                                <a class="btn btn-primary btn-xs edit-cate" id="<?php echo $setTeam->StaffID ?>" href="#" title="Edit"><span class="fa fa-pencil"></a>
                                <button title="Delete" class="btn btn-danger btn-xs delete" type="submit" id="btnDelete2" name="btnDelete2"  data-id="<?php echo $setTeam->StaffID;?>" data-button="btnDelete" data-class="btn btn-danger" data-input-name="StaffID" data-target="#delete_modal" data-toggle="modal" data-url=""><span class="fa fa-trash"></span></button>
                                <button title="Hide" class="btn btn-warning btn-xs hidecate" type="submit" id="btnHide2" name="btnHide2"  data-id="<?php echo $setTeam->StaffID;?>" data-button="btnHide" data-class="btn btn-warning" data-input-name="StaffID" data-target="#hide_modal" data-toggle="modal" data-url=""><span class="fa fa-ban"></span></button>
                                <button title="Show" class="btn btn-success btn-xs showcate" type="submit" id="btnShow2" name="btnShow2"  data-id="<?php echo $setTeam->StaffID;?>" data-button="btnShow" data-class="btn btn-success" data-input-name="StaffID" data-target="#show_modal" data-toggle="modal" data-url=""><span class="fa fa-check"></span></button>
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
                    <label class="control-label" for="txtFullname">Name</label>
                    <input type="text" class="form-control" name="txtFullname" id="txtFullname">
                </div>
                <div class="col-sm-6">
                    <label class="control-label" for="txtSPost">Post</label>
                    <input type="text" class="form-control" name="txtSPost" id="txtSPost">
                </div>
                
            </div>
            <div class="form-group">
                <div class="col-sm-6">
                    <label class="control-label" for="txtPlaceorder">Rank Order</label>
                    <input type="text" class="form-control" name="txtPlaceorder" id="txtPlaceorder">
                </div>
                <div class="col-sm-6">
                    <label class="control-label" for="txtImage">Select Iamge</label>
                    <div class='input-group'> 
                        <span class='input-group-btn'>
                        <label class='btn btn-primary'><span class='fa fa-plus'></span> Image
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
                                $('.rmove-btn').show();
                            })
                            $('#remove').click(function(){
                                control.replaceWith( control = control.clone( true ) );
                                $('#disp-file').val("");
                                $('.rmove-btn').hide();
                            });
                        });
                    </script>
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
            <input type="hidden" value="" name="txtStaffID">
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
            $('#txtImage').attr('required','required')
            return false;
        })
        $('.show-cate-list').click(function(){
            $('.hide-cate-list').trigger("click");
            $('#btnSave').attr('name','');
            // return false;
        })
        $('.edit-cate').click(function(){
            $('#add_form').show();
            $('.hide-cate-list').trigger("click");
            $('#txtFullname').focus()
            $('.cate-form-title').html("Edit Form");
            $('#btnSave').attr('name','btnEdit');
            $('#txtImage').removeAttr('required')
            
            StaffID = $(this).attr('id')
            $.ajax({
                type:'POST',
                data:'StaffID='+StaffID,
                dataType : "json",
                url:"<?php echo base_url() ?>api/staff.php",
                success: process_response
            })
            return false
        });
		    
		
    </script>
<?php
// confirm2("Team Management","Do you want to Modify the record?","edit","edit_modal",$rand,4);
confirm2("Team Management","Do you want to delete the record?","delete","delete_modal",$rand,1);
confirm2("Team Management","Do you want to Modify the record?","hidecate","hide_modal",$rand,2);
confirm2("Team Management","Do you want to Modify the record?","showcate","show_modal",$rand,3);
?>
<!-- Main Footer -->
<?php include('include/footer.php'); ?>