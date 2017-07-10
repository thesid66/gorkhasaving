<?php include('database/db.php'); ?>
<?php include('include/header.php');
$page = "disease";

if(!$_SESSION['DiseaseID'])
{
    $_SESSION['DiseaseID'] = $_GET['id'];
}

if(isset($_POST['btnSave']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$recID = maxid("tbldiseasedetail","recID",$db);
		
		$db->query("insert into tbldiseasedetail set
		recID		= '$recID',
        DiseaseID = '".$_SESSION['DiseaseID']."',
        Title = '".$db->real_escape_string($_POST['txtTitle'])."',
        Description = '".$db->real_escape_string($_POST['txtDescription'])."',
		Status		= '".$db->real_escape_string($_POST['txtStatus'])."'
		");
		notify("Detail Manager","Detail Inserted Successfully",base_url()."diseasedetail.php", FALSE,1000,0);
		
		die();
	}
}

if(isset($_POST['btnEdit']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tbldiseasedetail set
        DiseaseName = '".$db->real_escape_string($_POST['txtDiseaseName'])."',
        DiseaseDetail = '".$db->real_escape_string($_POST['txtDiseaseDetail'])."',
		Status		= '".$db->real_escape_string($_POST['txtStatus'])."'
		where
		DiseaseID		= '".$db->real_escape_string($_POST['txtDiseaseID'])."'
		");
		
		notify("Detail Manager","Detail Modified Successfully",base_url()."diseasedetail.php", FALSE,1000,0);
		
		die();
	}
}

if(isset($_POST['btnDelete']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("delete from tbldiseasedetail where recID = '".$_POST['recID']."'");
		notify("Detail Manager","Detail Deleted Successfully",base_url()."diseasedetail.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnHide']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tbldiseasedetail set Status = '1' where recID = '".$_POST['recID']."'");
		notify("Detail Manager","Detail Modified Successfully",base_url()."diseasedetail.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnShow']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tbldiseasedetail set Status = '0' where recID = '".$_POST['recID']."'");
		notify("Detail Manager","Detail Modified Successfully",base_url()."diseasedetail.php", FALSE,1000,0);
		
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
        <?php
            $getDisease = $db->query("select * from tbldisease where DiseaseID = '".$_SESSION['DiseaseID']."'");
            $setDisease = $getDisease->fetch_object();
        ?>
        <h1> <?php echo $setDisease->DiseaseName ?> </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="box box-success">
            <div class="box-header with-border">

                <h3 class="box-title">Detail List</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool hide-cate-list" data-widget="collapse"><i class="fa fa-plus"></i> </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="pull-right">
                    <a href="#" id="add_form_button" class="btn btn-primary">Add Detail</a>
                </div>
                <div class="clearfix">
                </div>
                <br>
                <table id="dataTable" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="10%">Title</th>
                            <th width="55%">Description</th>
                            <th width="5%">Status</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
				$getCate = $db->query("select * from tbldiseasedetail where DiseaseID = '".$_SESSION['DiseaseID']."' order by recID asc") or return_error();
				while($setCate = $getCate->fetch_object())
				{
				?>
                        <tr>
                            <td><?php echo $setCate->Title ?></td>
                            <td><?php echo $setCate->Description ?></td>
                            <td align="center"><?php echo Status($setCate->Status) ?></td>
                            <td align="center"><form method="post" class="btn-tooltips">
                                <a class="btn btn-primary btn-xs" href="editdiseasedetail.php?id=<?php echo $setCate->recID ?>" title="Edit"><span class="fa fa-pencil"></a>
                                <button title="Delete" class="btn btn-danger btn-xs delete" type="submit" id="btnDelete2" name="btnDelete2"  data-id="<?php echo $setCate->recID;?>" data-button="btnDelete" data-class="btn btn-danger" data-input-name="recID" data-target="#delete_modal" data-toggle="modal" data-url=""><span class="fa fa-trash"></span></button>
                                
                                <button title="Hide" class="btn btn-warning btn-xs hidecate" type="submit" id="btnHide2" name="btnHide2"  data-id="<?php echo $setCate->recID;?>" data-button="btnHide" data-class="btn btn-warning" data-input-name="recID" data-target="#hide_modal" data-toggle="modal" data-url=""><span class="fa fa-ban"></span></button>
                                
                                <button title="Show" class="btn btn-success btn-xs showcate" type="submit" id="btnShow2" name="btnShow2"  data-id="<?php echo $setCate->recID;?>" data-button="btnShow" data-class="btn btn-success" data-input-name="recID" data-target="#show_modal" data-toggle="modal" data-url=""><span class="fa fa-check"></span></button>
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
                            <label class="control-label" for="txtTitle">Title</label>
                            <input type="text" class="form-control" name="txtTitle" id="txtTitle">
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
                            <label class="control-label" for="txtDescription">Description</label>
                            <textarea name="txtDescription" id="txtDescription" class="form-control textarea"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-5">
                            <button name="btnSave" id="btnSave" class="btn btn-primary btn-lg btn-block">Save</button>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $_SESSION['rand'] ?>" name="rand">
                    <input type="hidden" value="" name="txtrecID">
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
confirm2("Detail Management","Do you want to delete the record?","delete","delete_modal",$rand,1);
confirm2("Detail Management","Do you want to Modify the record?","hidecate","hide_modal",$rand,2);
confirm2("Detail Management","Do you want to Modify the record?","showcate","show_modal",$rand,3);
?>
<!-- Main Footer -->
<?php include('include/footer.php'); ?>