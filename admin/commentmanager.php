<?php include('database/db.php'); ?>
<?php include('include/header.php');
$page = "article";

if(!isset($_SESSION['articleid']))
{
    $_SESSION['articleid'] = $_GET['id'];
    header('location: commentmanager.php');
}

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
		
		notify("Article Manager","Article Inserted Successfully",base_url()."articlemanager.php", FALSE,1000,0);
		
		die();
	}
}

if(isset($_POST['btnReply']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tblcomments set
		reply	= '".$db->real_escape_string($_POST['txtreply'])."',
        replydate = '".date("Y-m-d h:i:s a")."'
		where
		commentid		= '".$db->real_escape_string($_POST['txtcommentid'])."'
		");
		
		notify("Reply Manager","Reply Added Successfully",base_url()."commentmanager.php", FALSE,1000,0);
		
		die();
	}
}

if(isset($_POST['btnDelete']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("delete from tblcomments where commentid = '".$_POST['commentid']."'");
		notify("Comment Manager","Comment Deleted Successfully",base_url()."commentmanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnHide']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tblcomments set status = '1' where commentid = '".$_POST['commentid']."'");
		notify("Comment Manager","Comment Modified Successfully",base_url()."commentmanager.php", FALSE,1000,0);
		
		die();
	}
}
if(isset($_POST['btnShow']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("update tblcomments set status = '0' where commentid = '".$_POST['commentid']."'");
		notify("Comment Manager","Comment Modified Successfully",base_url()."commentmanager.php", FALSE,1000,0);
		
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
                
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="12%">From</th>
                            <th width="13%">Email</th>
                            <th width="13%">Address</th>
                            <th width="21%">Comment</th>
                            <th width="21%">Reply</th>
                            <th width="5%">status</th>
                            <th width="15%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
				$getArticle = $db->query("select * from tblcomments where articleid = '".$_SESSION['articleid']."'");
				while($setArticle = $getArticle->fetch_object())
				{
				?>
                        <tr>
                            <td><?php echo $setArticle->fullname ?></td>
                            <td><?php echo ($setArticle->email) ?></td>
                            <td><?php echo ($setArticle->address) ?></td>
                            <td><?php echo $setArticle->description ?></td>
                            <td><?php echo $setArticle->reply ?></td>
                            <td align="center"><?php echo status($setArticle->status) ?></td>
                            <td align="center"><form method="post" class="btn-tooltips">
                            <a class="btn btn-primary btn-xs reply" data-id="<?php echo $setArticle->commentid;?>" data-toggle="modal" href='#modal-id'>Reply</a>
                                    <button title="Delete" class="btn btn-danger btn-xs delete" type="submit" id="btnDelete2" name="btnDelete2"  data-id="<?php echo $setArticle->commentid;?>" data-button="btnDelete" data-class="btn btn-danger" data-input-name="commentid" data-target="#delete_modal" data-toggle="modal" data-url=""><span class="fa fa-trash"></span></button>
                                    <button title="Hide" class="btn btn-warning btn-xs hidecate" type="submit" id="btnHide2" name="btnHide2"  data-id="<?php echo $setArticle->commentid;?>" data-button="btnHide" data-class="btn btn-warning" data-input-name="commentid" data-target="#hide_modal" data-toggle="modal" data-url=""><span class="fa fa-ban"></span></button>
                                    <button title="Show" class="btn btn-success btn-xs showcate" type="submit" id="btnShow2" name="btnShow2"  data-id="<?php echo $setArticle->commentid;?>" data-button="btnShow" data-class="btn btn-success" data-input-name="commentid" data-target="#show_modal" data-toggle="modal" data-url=""><span class="fa fa-check"></span></button>
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

        <div class="modal fade" id="modal-id">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Reply</h4>
                    </div>
                    <form method="post" class="form-horizontal">
                        <div class="modal-body">
                            <input type="hidden" name="txtcommentid" id="txtcommentid">
                            <input type="hidden" name="rand" value="<?php echo $rand ?>">
                            <textarea name="txtreply" id="txtreply" class="form-control" rows="3" required="required"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="btnReply">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper --> 

<script>
$(document).ready(function() {
    $('.reply').click(function(event) {
        $('#txtcommentid').val($(this).data('id'))
    });
});
	
</script>
<?php
confirm2("Comment Management","Do you want to delete the record?","delete","delete_modal",$rand,1);
confirm2("Comment Management","Do you want to Modify the record?","hidecate","hide_modal",$rand,2);
confirm2("Comment Management","Do you want to Modify the record?","showcate","show_modal",$rand,3);
confirm2("Comment Management","Do you want to Modify the record?","edit","edit_modal",$rand,4);

?>
<!-- Main Footer -->
<?php include('include/footer.php'); ?>