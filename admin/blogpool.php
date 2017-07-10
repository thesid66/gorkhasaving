<?php include('database/db.php'); ?>
<?php include('include/header.php');
$page = "blogpool";

if(isset($_POST['btnAdd']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$BlogID = maxid("tblblog","BlogID",$db);
		
		$db->query("insert into tblblog set
		BlogID      = '$BlogID',
		ArticleID	= '".$db->real_escape_string($_POST['txtArticleID'])."'
		");
		
		notify("Blog Manager","Blog Inserted Successfully",base_url()."blogpool.php", FALSE,1000,0);
		
		die();
	}
}

if(isset($_POST['btnDelete']))
{
	if($_SESSION['rand'] == $_POST['rand'])
	{
		$db->query("delete from tblblog where BlogID = '".$_POST['BlogID']."'");
		notify("Blog Manager","Blog Deleted Successfully",base_url()."blogpool.php", FALSE,1000,0);
		
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
        <h1> Blog Manager </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Blog List</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool hide-cate-list" data-widget="collapse"><i class="fa fa-plus"></i> </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form method="post">
                    <div class="col-sm-10">
                        <select name="txtArticleID" id="txtArticleID" class="form-control">
                            <option value=""></option>
                            <?php
                            $getArticles = $db->query("select * from tblarticle order by id desc");
                            while ($setArticles = $getArticles->fetch_object()) {
                            ?>
                            <option value="<?php echo $setArticles->id ?>"><?php echo $setArticles->topic ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <input type="hidden" name="rand" value="<?php echo $rand;?>">
                        <button type="submit" name="btnAdd" class="btn btn-primary btn-block">Add</button>
                    </div>
                    <div class="clearfix">
                    </div>
                </form>
                <br>
                <table id="dataTable" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="87%">Title</th>
                            <th width="13%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                $getCate = $db->query("select tblblog.*, tblarticle.topic from tblblog, tblarticle where tblblog.ArticleID = tblarticle.id order by tblblog.BlogID asc");
                while($setCate = $getCate->fetch_object())
                {
                ?>
                        <tr>
                            <td><?php echo $setCate->topic ?></td>
                            <td align="center"><form method="post" class="btn-tooltips">
                            
                                    <button title="Delete" class="btn btn-danger btn-xs delete" type="submit" id="btnDelete2" name="btnDelete2"  data-id="<?php echo $setCate->BlogID;?>" data-button="btnDelete" data-class="btn btn-danger" data-input-name="BlogID" data-target="#delete_modal" data-toggle="modal" data-url=""><span class="fa fa-trash"></span></button>
                     
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
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper --> 

 
    <?php
confirm2("Blog Management","Do you want to delete the record?","delete","delete_modal",$rand,1);
?>
<!-- Main Footer -->
<?php include('include/footer.php'); ?>