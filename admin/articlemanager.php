<?php include('database/db.php'); ?>
<?php include('include/header.php');
$page = "article";

unset($_SESSION['articleid']);

if(isset($_POST['btnSave']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$file = $_FILES['txtarticleimage']['name'];
		if($file!=NULL or $file!="")
		{
			$getfile = explode(".",$file);
			$setfile = $getfile[0]."_".time().".".end($getfile);
			move_uploaded_file($_FILES['txtarticleimage']['tmp_name'],'../newsimage/'.$setfile);
		}
		
		$id = maxid("tblarticle","id",$db);
		
		$db->query("insert into tblarticle set
		id			= '$id',
		pageorder	= '".$db->real_escape_string($_POST['txtpageorder'])."',
		groupid		= '".$db->real_escape_string($_POST['txtgroupid'])."',
		subgroupid	= '".$db->real_escape_string($_POST['txtsubgroupid'])."',
		topic		= '".$db->real_escape_string($_POST['txttopic'])."',
		pagelevel	= '".$db->real_escape_string($_POST['txtpagelevel'])."',
		parentid	= '".$db->real_escape_string($_POST['txtparentid'])."',
		submittedby	= 'Admin',
		submitdate	= '".date("Y-m-d h:i:s a")."',
		description	= '".$db->real_escape_string($_POST['txtdescription'])."',
		status		= '".$db->real_escape_string($_POST['txtstatus'])."',
		articleimage= '".$setFile."',
		articletags	= '".$db->real_escape_string($_POST['txtarticletags'])."',
		authorid	= '".$db->real_escape_string($_POST['txtauthorid'])."',
		type		= '".$db->real_escape_string($_POST['txttype'])."',
		urltype		= '".$db->real_escape_string($_POST['txturltype'])."',
		urllink		= '".$db->real_escape_string($_POST['txturllink'])."',
		trending	= '".$db->real_escape_string($_POST['txttrending'])."'
		");

        $getSubscriber = $db->query("select * from tblsubscriber");
        while($setSubscriber = $getSubscriber->fetch_object())
        {
            $emails .= $setSubscriber->SubEmail.",";
        }
        $emails = rtrim($emails,",");

        $to=$emails;
        $subject = 'Vetnepal.com | New update is available';
        $from = "Vet Nepal <noreply@vetnepal.com>";
        $headers = 'From: '.$from."\r\n".
        'Reply-To: '.$from."\r\n" .
        'X-Mailer: PHP/' . phpversion();
        
        $message = "Dear Subscriber,";
        $message.="\n";
        $message.= "Vet Nepal is a first Technology and Services portal from Nepal, developed & maintained by qualified Professionals, IT and Management Team working in Nepal and aboard, to provide in-depth highly competent Information and Technology." ; 
        $message.="\n\n";
        $message.="New update is available in vetnepal.com. Please follow the following link for more information.";
        $message.="\n\n";
        $message.="http://www.vetnepal.com/article.php?id=".$id;
        
        $message.="\n\n";
        $message.= "For more information, please contact us :";
        $message.="\n\n";
        $message.="Address : Vet Nepal Pvt. Ltd. Kupandole, Lalitpur, Nepal.\nContact : Please Get in Touch\nEmail : info.vetnepal@gmail.com, info@vetnepal.com";

        mail($to, $subject, $message, $headers);
        
		
		notify("Article Manager","Article Inserted Successfully",base_url()."articlemanager.php", FALSE,1000,0);
		
		die();
	}
}



if(isset($_POST['btnDelete']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("delete from tblarticle where id = '".$_POST['id']."'");
		notify("Article Manager","Article Deleted Successfully",base_url()."articlemanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnHide']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tblarticle set status = '1' where id = '".$_POST['id']."'");
		notify("Article Manager","Article Modified Successfully",base_url()."articlemanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnShow']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tblarticle set status = '0' where id = '".$_POST['id']."'");
		notify("Article Manager","Article Modified Successfully",base_url()."articlemanager.php", FALSE,1000,0);
		
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
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Article List</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool hide-cate-list" data-widget="collapse"><i class="fa fa-plus"></i> </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="pull-left">
                    <div class="alert alert-danger"><em>Click on article title to manage comments</em></div>
                </div>
                <div class="pull-right">
                    <div id="add_form_button" class="btn btn-primary">
                        Add Article
                    </div>
                </div>
                <div class="clearfix">
                </div>
                <br>
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Article Title</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Published Date</th>
                            <th>status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
				$getArticle = $db->query("select * from tblarticle order by groupid asc, subgroupid asc, pageorder asc");
				while($setArticle = $getArticle->fetch_object())
				{
				?>
                        <tr>
                            <td><a href="commentmanager.php?id=<?php echo $setArticle->id; ?>"><?php echo $setArticle->topic ?></a></td>
                            <td><?php echo getMainCate($setArticle->groupid,$db) ?></td>
                            <td><?php echo getSubCate($setArticle->subgroupid,$db) ?></td>
                            <td><?php echo $setArticle->submitdate ?></td>
                            <td align="center"><?php echo status($setArticle->status) ?></td>
                            <td align="center"><form method="post" class="btn-tooltips">
                                    <button title="Edit" class="btn btn-primary btn-xs edit" type="submit" id="btnEdit2" name="btnEdit2"  data-id="<?php echo $setArticle->id;?>" data-button="btnEdit" data-class="btn btn-primary" data-input-name="id" data-target="#edit_modal" data-toggle="modal" data-url="<?php echo base_url() ?>editarticle.php"><span class="fa fa-pencil"></span></button>
                                    <button title="Delete" class="btn btn-danger btn-xs delete" type="submit" id="btnDelete2" name="btnDelete2"  data-id="<?php echo $setArticle->id;?>" data-button="btnDelete" data-class="btn btn-danger" data-input-name="id" data-target="#delete_modal" data-toggle="modal" data-url=""><span class="fa fa-trash"></span></button>
                                    <button title="Hide" class="btn btn-warning btn-xs hidecate" type="submit" id="btnHide2" name="btnHide2"  data-id="<?php echo $setArticle->id;?>" data-button="btnHide" data-class="btn btn-warning" data-input-name="id" data-target="#hide_modal" data-toggle="modal" data-url=""><span class="fa fa-ban"></span></button>
                                    <button title="Show" class="btn btn-success btn-xs showcate" type="submit" id="btnShow2" name="btnShow2"  data-id="<?php echo $setArticle->id;?>" data-button="btnShow" data-class="btn btn-success" data-input-name="id" data-target="#show_modal" data-toggle="modal" data-url=""><span class="fa fa-check"></span></button>
                                    <button title="Show" class="btn btn-success btn-xs default" type="submit" id="btnDefault2" name="btnDefault2"  data-id="<?php echo $setArticle->id;?>" data-button="btnDefault" data-class="btn btn-success" data-input-name="id" data-target="#default_modal" data-toggle="modal" data-url=""><span class="fa fa-star"></span></button>
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
                            <label class="control-label" for="txttopic">Article Title</label>
                            <input type="text" class="form-control" name="txttopic" id="txttopic">
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
                            <label class="control-label" for="txtpageorder">Article Order</label>
                            <input type="text" class="form-control" name="txtpageorder" id="txtpageorder">
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="txtstatus">Status</label>
                            <select class="form-control" name="txtstatus" id="txtstatus">
                                <option value=""></option>
                                <option value="0">Publish</option>
                                <option value="1">Hidden</option>
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
                                <option value="<?php echo $setMainCate->CateID ?>"><?php echo $setMainCate->CateTitle ?></option>
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
                                <option value="<?php echo $setSubCate->SubCateID ?>"><?php echo $setSubCate->CateTitle ?></option>
                                <?php
								}
								?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="txttype">Article Type</label>
                            <select name="txttype" size="1" id="txttype" class="form-control">
                                <option value="1">Content</option>
								<option value="2">Link </option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="txtpagelevel">Article Level</label>
                            <select name="txtpagelevel" size="1" id="txtpagelevel" class="form-control">
                                <option value="1">Level 1</option>
                                <option value="2">Level 2</option>
                            </select>
                        </div>
                        <div class="col-sm-6 after-level">
                            <label class="control-label" for="txtparentid">Parent Article</label>
                            <select name="txtparentid" size="1" id="txtparentid" class="form-control"></select>
                        </div>
                        <div class="col-sm-6 for-link">
                            <label class="control-label" for="txturllink">Link (URL)</label>
                            <input type="text" class="form-control" name="txturllink" id="txturllink" >
                        </div>
                        <div class="col-sm-6 for-link">
                            <label class="control-label" for="txturltype">Link Type</label>
                            <select name="txturltype" size="1" id="txturltype" class="form-control">
                                <option value="0">Internal</option>
								<option value="1">External</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="txttrending">Trending</label>
                            <select name="txttrending" size="1" id="txttrending" class="form-control">
                                <option value="0">No</option>
								<option value="1">Yes</option>
                            </select>
                        </div>
                        <div class="col-sm-6 no-link">
                            <label class="control-label" for="txtarticletags">Article Tags</label>
                            <input type="text" class="form-control tagss" name="txtarticletags" id="txtarticletags" placeholder="Add a tag">
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
                                <option value="<?php echo $setSubCate->id ?>"><?php echo $setSubCate->authorname ?></option>
                                <?php
								}
								?>
                            </select>
                        </div>
                        
                    </div>
                    <div class="form-group no-link">
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
			
			aid = $(this).attr('id')
			$.ajax({
				type:'POST',
				data:'id='+aid,
				dataType : "json",
				url:"<?php echo base_url() ?>api/article.php",
				success: process_response
			})
		});
		  $('.for-link, .after-level').hide();
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
			if(page_level != "Level 1")
			{
				$('.after-level').show();
			}
			else
			{
				$('.after-level').hide();
			}
		})
		
    </script>
<?php
confirm2("Article Management","Do you want to delete the record?","delete","delete_modal",$rand,1);
confirm2("Article Management","Do you want to Modify the record?","hidecate","hide_modal",$rand,2);
confirm2("Article Management","Do you want to Modify the record?","showcate","show_modal",$rand,3);
confirm2("Article Management","Do you want to Modify the record?","edit","edit_modal",$rand,4);

?>
<!-- Main Footer -->
<?php include('include/footer.php'); ?>