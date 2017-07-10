<?php include('database/db.php'); ?>
<?php include('include/header.php');
$page = "disease";

unset($_SESSION['DiseaseID']);

if(isset($_POST['btnSave']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$DiseaseID = maxid("tbldisease","DiseaseID",$db);
		
		$db->query("insert into tbldisease set
		DiseaseID		= '$DiseaseID',
        DiseaseName = '".$db->real_escape_string($_POST['txtDiseaseName'])."',
		DiseaseDetail	= '".$db->real_escape_string($_POST['txtDiseaseDetail'])."',
		pubdate		= '".date('Y-m-d h:i:s a')."',
		Status		= '".$db->real_escape_string($_POST['txtStatus'])."'
		");
		notify("Disease Manager","Disease Inserted Successfully",base_url()."diseasemanager.php", FALSE,1000,0);
		
		die();
	}
}

if(isset($_POST['btnEdit']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tbldisease set
        DiseaseName = '".$db->real_escape_string($_POST['txtDiseaseName'])."',
        DiseaseDetail = '".$db->real_escape_string($_POST['txtDiseaseDetail'])."',
		Status		= '".$db->real_escape_string($_POST['txtStatus'])."'
		where
		DiseaseID		= '".$db->real_escape_string($_POST['txtDiseaseID'])."'
		");
		
		notify("Disease Manager","Disease Modified Successfully",base_url()."diseasemanager.php", FALSE,1000,0);
		
		die();
	}
}

if(isset($_POST['btnDelete']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("delete from tbldisease where DiseaseID = '".$_POST['DiseaseID']."'");
		notify("Disease Manager","Disease Deleted Successfully",base_url()."diseasemanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnHide']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tbldisease set Status = '1' where DiseaseID = '".$_POST['DiseaseID']."'");
		notify("Disease Manager","Disease Modified Successfully",base_url()."diseasemanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnShow']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tbldisease set Status = '0' where DiseaseID = '".$_POST['DiseaseID']."'");
		notify("Disease Manager","Disease Modified Successfully",base_url()."diseasemanager.php", FALSE,1000,0);
		
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
        <h1> Disease Manager </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Disease List</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool hide-cate-list" data-widget="collapse"><i class="fa fa-plus"></i> </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="pull-right">
                    <a href="#" id="add_form_button" class="btn btn-primary">Add Disease</a>
                </div>
                <div class="clearfix">
                </div>
                <br>
                <table id="dataTable" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="25%">Disease Name</th>
                            <th width="16%">Detail</th>
                            <th width="17%">Published Date</th>
                            <th width="17%">Status</th>
                            <th width="12%">&nbsp;</th>
                            <th width="13%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
				$getCate = $db->query("select * from tbldisease order by DiseaseID asc") or return_error();
				while($setCate = $getCate->fetch_object())
				{
				?>
                        <tr>
                            <td><?php echo $setCate->DiseaseName ?></td>
                            <td><?php echo $setCate->DiseaseDetail ?></td>
                            <td align="center"><?php echo ($setCate->pubdate) ?></td>
                            <td align="center"><?php echo Status($setCate->Status) ?></td>
                            <td align="center"><a class="btn btn-primary btn-xs" href="diseasedetail.php?id=<?php echo $setCate->DiseaseID; ?>">Detail</a></td>
                            <td align="center"><form method="post" class="btn-tooltips">
                                <a class="btn btn-primary btn-xs edit-cate" id="<?php echo $setCate->DiseaseID ?>" href="#" title="Edit"><span class="fa fa-pencil"></a>
                                <button title="Delete" class="btn btn-danger btn-xs delete" type="submit" id="btnDelete2" name="btnDelete2"  data-id="<?php echo $setCate->DiseaseID;?>" data-button="btnDelete" data-class="btn btn-danger" data-input-name="DiseaseID" data-target="#delete_modal" data-toggle="modal" data-url=""><span class="fa fa-trash"></span></button>
                                
                                <button title="Hide" class="btn btn-warning btn-xs hidecate" type="submit" id="btnHide2" name="btnHide2"  data-id="<?php echo $setCate->DiseaseID;?>" data-button="btnHide" data-class="btn btn-warning" data-input-name="DiseaseID" data-target="#hide_modal" data-toggle="modal" data-url=""><span class="fa fa-ban"></span></button>
                                
                                <button title="Show" class="btn btn-success btn-xs showcate" type="submit" id="btnShow2" name="btnShow2"  data-id="<?php echo $setCate->DiseaseID;?>" data-button="btnShow" data-class="btn btn-success" data-input-name="DiseaseID" data-target="#show_modal" data-toggle="modal" data-url=""><span class="fa fa-check"></span></button>
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
                            <label class="control-label" for="txtDiseaseName">Disease Name</label>
                            <input type="text" class="form-control" name="txtDiseaseName" id="txtDiseaseName">
                        </div>
                        
                        <div class="col-sm-6">
                            <label class="control-label" for="txtStatus">Status</label>
                            <select class="form-control" name="txtStatus" id="txtStatus">
                                <option value=""></option>
                                <option value="0">Publish</option>
                                <option value="1">Hidden</option>
                            </select>
                        </div>

                        <div class="col-sm-12">
                            <label class="control-label" for="txtDiseaseDetail">Detail</label>
                            <textarea name="txtDiseaseDetail" id="txtDiseaseDetail" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-5">
                            <button name="btnSave" id="btnSave" class="btn btn-primary btn-lg btn-block">Save</button>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $_SESSION['rand'] ?>" name="rand">
                    <input type="hidden" value="" name="txtDiseaseID">
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
			
			DiseaseID = $(this).attr('id')
			$.ajax({
				type:'POST',
				data:'DiseaseID='+DiseaseID,
				dataType : "json",
				url:"<?php echo base_url() ?>api/disease.php",
				success: process_response
			})
		});
		    
		
    </script> 
    <?php
confirm2("Disease Management","Do you want to delete the record?","delete","delete_modal",$rand,1);
confirm2("Disease Management","Do you want to Modify the record?","hidecate","hide_modal",$rand,2);
confirm2("Disease Management","Do you want to Modify the record?","showcate","show_modal",$rand,3);
?>
<!-- Main Footer -->
<?php include('include/footer.php'); ?>