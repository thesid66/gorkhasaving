<?php include('database/db.php'); ?>
<?php include('include/header.php');
$page = "article";

if(isset($_POST['btnSave']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$getOldImage = $db->query("select * from tblarticle where id = '".$db->real_escape_string($_POST['txtid'])."'");
		$setOldImage = $getOldImage->fetch_object();
		
		$newFile = $_FILES['txtarticleimage']['name'];
		if($newFile != NULL or $newFile != "")
		{
			if(file_exists("../newsimage/".$setOldImage->articleimage))
			{
				unlink("../newsimage/".$setOldImage->articleimage);
			}
			$ModFile = explode('.',$newFile);
			$setFile = $ModFile[0].'_'.time().".".end($ModFile);
			move_uploaded_file($_FILES['txtarticleimage']['tmp_name'],'../newsimage/'.$setFile);
		}
		else
		{
			$setFile = $setOldImage->articleimage;
		}
		$db->query("update tblarticle set
		pageorder	= '".$db->real_escape_string($_POST['txtpageorder'])."',
		groupid		= '".$db->real_escape_string($_POST['txtgroupid'])."',
		subgroupid	= '".$db->real_escape_string($_POST['txtsubgroupid'])."',
		topic		= '".$db->real_escape_string($_POST['txttopic'])."',
		pagelevel	= '".$db->real_escape_string($_POST['txtpagelevel'])."',
		parentid	= '".$db->real_escape_string($_POST['txtparentid'])."',
		description	= '".$db->real_escape_string($_POST['txtdescription'])."',
		status		= '".$db->real_escape_string($_POST['txtstatus'])."',
		articleimage= '".$setFile."',
		articletags	= '".$db->real_escape_string($_POST['txtarticletags'])."',
		authorid	= '".$db->real_escape_string($_POST['txtauthorid'])."',
		type		= '".$db->real_escape_string($_POST['txttype'])."',
		urltype		= '".$db->real_escape_string($_POST['txturltype'])."',
		urllink		= '".$db->real_escape_string($_POST['txturllink'])."',
		trending	= '".$db->real_escape_string($_POST['txttrending'])."'
		where
		id = '".$db->real_escape_string($_POST['txtid'])."'
		");
		notify("Article Manager","Article Updated Successfully",base_url()."articlemanager.php", FALSE,1000,0);
		
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
        <h1> Article Manager </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <?php
		$getArticle = $db->query("select * from tblarticle where id = '".$db->real_escape_string($_POST['id'])."'");
		$setArticle = $getArticle->fetch_object();
		?>
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
                <form class="form-horizontal" id="AllForm" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label class="control-label" for="txttopic">Article Title</label>
                            <input type="text" class="form-control" name="txttopic" id="txttopic" value="<?php echo $setArticle->topic ?>">
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="txtarticleimage">Select Article Image</label>
                            <div class='input-group '>
                                <span class='input-group-btn'>
                                <label class='btn btn-primary'><span class='fa fa-plus'></span> Article Image
                                    <input type='file' name='txtarticleimage' id='txtarticleimage' class='hidden' value='' accept="image/*" />
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
								var control = $('#txtarticleimage');
								$('#txtarticleimage').change(function(){
									$('#disp-file').val($('input[type=file]')[0].files[0].name)
									$('.rmove-btn').show()
								})
								$('#remove').click(function(){
									control.replaceWith( control = control.clone( true ) );
									$('#disp-file').val("")
									$('.rmove-btn').hide();
									$('#art-image').attr('src', '').hide();
								})
								
								
						
							})
							</script>
                            <em class="text-danger">Image will be displayed below editor</em>
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
                            <label class="control-label" for="txtpageorder">Article Order</label>
                            <input type="text" class="form-control" name="txtpageorder" id="txtpageorder" value="<?php echo $setArticle->pageorder ?>">
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="txtstatus">Status</label>
                            <select class="form-control" name="txtstatus" id="txtstatus">
                                <option value=""></option>
                                <option <?php if($setArticle->status == 0) echo "selected"; ?> value="0">Publish</option>
                                <option <?php if($setArticle->status == 1) echo "selected"; ?> value="1">Hidden</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="txtgroupid">Category </label>
                            <select class="form-control" name="txtgroupid" id="txtgroupid">
                                <option value=""></option>
                                <?php
								$getMainCate = $db->query("select * from article_cate order by CateOrder asc");
								while($setMainCate = $getMainCate->fetch_object())
								{
								?>
                                <option <?php if($setArticle->groupid == $setMainCate->CateID) echo "selected"; ?> value="<?php echo $setMainCate->CateID ?>"><?php echo $setMainCate->CateTitle ?></option>
                                <?php
								}
								?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="txtsubgroupid">Sub Category </label>
                            <select class="form-control" name="txtsubgroupid" id="txtsubgroupid">
                                <option value=""></option>
                                <?php
								$getSubCate = $db->query("select * from article_subcate order by CateOrder asc");
								while($setSubCate = $getSubCate->fetch_object())
								{
								?>
                                <option <?php if($setArticle->subgroupid == $setSubCate->SubCateID) echo "selected"; ?> value="<?php echo $setSubCate->SubCateID ?>"><?php echo $setSubCate->CateTitle ?></option>
                                <?php
								}
								?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="txttype">Article Type</label>
                            <select name="txttype" size="1" id="txttype" class="form-control">
                                <option <?php if($setArticle->type == 1) echo "selected"; ?> value="1">Content</option>
								<option <?php if($setArticle->type == 2) echo "selected"; ?> value="2">Link </option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="txtpagelevel">Article Level</label>
                            <select name="txtpagelevel" size="1" id="txtpagelevel" class="form-control">
                                <option <?php if($setArticle->pagelevel == 1) echo "selected"; ?> value="1">Level 1</option>
                                <option <?php if($setArticle->pagelevel == 2) echo "selected"; ?> value="2">Level 2</option>
                            </select>
                        </div>
                        <div class="col-sm-6 after-level">
                            <label class="control-label" for="txtparentid">Parent Article</label>
                            <select name="txtparentid" size="1" id="txtparentid" class="form-control"></select>
                        </div>
                        <div class="col-sm-6 for-link">
                            <label class="control-label" for="txturllink">Link (URL)</label>
                            <input type="text" class="form-control" name="txturllink" id="txturllink" value="<?php echo $setArticle->urllink ?>">
                        </div>
                        <div class="col-sm-6 for-link">
                            <label class="control-label" for="txturltype">Link Type</label>
                            <select name="txturltype" size="1" id="txturltype" class="form-control">
                                <option <?php if($setArticle->urltype == 0) echo "selected"; ?> value="0">Internal</option>
								<option <?php if($setArticle->urltype == 1) echo "selected"; ?> value="1">External</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="txttrending">Trending</label>
                            <select name="txttrending" size="1" id="txttrending" class="form-control">
                                <option <?php if($setArticle->trending == 0) echo "selected"; ?> value="0">No</option>
								<option <?php if($setArticle->trending == 1) echo "selected"; ?> value="1">Yes</option>
                            </select>
                        </div>
                        <div class="col-sm-6 no-link">
                            <label class="control-label" for="txtarticletags">Article Tags</label>
                            <input type="text" class="form-control tagss" name="txtarticletags" id="txtarticletags" placeholder="Add a tag" value="<?php echo $setArticle->articletags ?>">
                        </div>
                        <div class="col-sm-6 no-link">
                            <label class="control-label" for="txtauthorid">Author</label>
                            <select class="form-control" name="txtauthorid" id="txtauthorid">
                                <option value=""></option>
                                <?php
								$getSubCate = $db->query("select * from tblauthor order by authorname asc");
								while($setSubCate = $getSubCate->fetch_object())
								{
								?>
                                <option <?php if($setArticle->authorid == $setSubCate->id) echo "selected"; ?> value="<?php echo $setSubCate->id ?>"><?php echo $setSubCate->authorname ?></option>
                                <?php
								}
								?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group no-link">
                        <div class="col-sm-12">
                            <textarea name="txtdescription" id="txtdescription" class="textarea"><?php echo $setArticle->description ?></textarea>
                            
                        </div>
                    </div>
                     <div class="form-group">
                        <div class="col-sm-6">
                            <img src="../newsimage/<?php echo $setArticle->articleimage ?>" class="img-responsive" id="art-image" />
                            <script>
                            function readIMG(input) {
									if (input.files && input.files[0]) {
										var reader = new FileReader();
							
										reader.onload = function (e) {
											$('#art-image').attr('src', e.target.result);
										}
							
										reader.readAsDataURL(input.files[0]);
									}
								}
								<?php if($setArticle->articleimage == '') { ?>
								$('#art-image').hide();
								<?php } ?>
								$("#txtarticleimage").change(function(){
									$('#art-image').show();
									readIMG(this);
								});
                            </script>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-5">
                            <button name="btnSave" id="btnSave" class="btn btn-primary btn-lg btn-block">Save</button>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $_SESSION['rand'] ?>" name="rand">
                    <input type="hidden" value="<?php echo $setArticle->id ?>" name="txtid">
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
    	
		$('.show-cate-list').click(function(){
			window.location="<?php echo base_url(); ?>articlemanager.php";
		})
		<?php
		if($setArticle->pagelevel == 1)
		{
		?>
			$('.after-level').hide();
		<?php
		}
		else
		{
		?>
			$('.after-level').show();
		<?php
		}
		?>
		  $('.for-link').hide();
		$('#txttype').change(function(){
			a_type = $(this).val();
			
			if(a_type == 1)
			{
				$('.no-link').show();
				$('.for-link').hide();
			}
			else
			{
				$('.no-link').hide();
				$('.for-link').show();
			}
		})  
		$('#txtpagelevel').change(function(){
			page_level = $(this).val();
			if(page_level != 1)
			{
				$('.after-level').show();
			}
			else
			{
				$('.after-level').hide();
			}
		})
		
    </script>

<!-- Main Footer -->
<?php include('include/footer.php'); ?>