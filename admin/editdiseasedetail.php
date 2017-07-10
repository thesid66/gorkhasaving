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
		
		$db->query("update tbldiseasedetail set
        DiseaseID = '".$_SESSION['DiseaseID']."',
        Title = '".$db->real_escape_string($_POST['txtTitle'])."',
        Description = '".$db->real_escape_string($_POST['txtDescription'])."',
		Status		= '".$db->real_escape_string($_POST['txtStatus'])."'
        where
        recID = '".$_POST['txtrecID']."'
		");
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
            $getDisease = $db->query("select * from tbldiseasedetail where recID = '".$_GET['id']."'");
            $setDisease = $getDisease->fetch_object();
        ?>
        <h1> <?php echo $setDisease->Title ?> </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title cate-form-title">Edit Form</h3>
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
                            <input type="text" class="form-control" name="txtTitle" id="txtTitle" value="<?php echo $setDisease->Title ?>">
                        </div>
                        
                        <div class="col-sm-6">
                            <label class="control-label" for="txtStatus">Status</label>
                            <select class="form-control" name="txtStatus" id="txtStatus">
                                <option value=""></option>
                                <option <?php if($setDisease->Status == 0) echo "selected"; ?> value="0">Publish</option>
                                <option <?php if($setDisease->Status == 1) echo "selected"; ?> value="1">Hidden</option>
                            </select>
                        </div>

                        <div class="col-sm-12">
                            <label class="control-label" for="txtDescription">Description</label>
                            <textarea name="txtDescription" id="txtDescription" class="form-control textarea"><?php echo $setDisease->Description; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-5">
                            <button name="btnSave" id="btnSave" class="btn btn-primary btn-lg btn-block">Save</button>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $_SESSION['rand'] ?>" name="rand">
                    <input type="hidden" value="<?php echo $setDisease->recID ?>" name="txtrecID">
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