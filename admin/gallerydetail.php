<?php include('database/db.php'); ?>
<?php include('include/header.php');
$page = "photo";

if(!isset($_SESSION['GalID']))
{
    $_SESSION['GalID'] = $_POST['pageid'];
    header('location: gallerydetail.php');
}

if(isset($_POST['btnSave']))
{
    if($_SESSION['rand'] == $_POST['rand'])
    {
        $pageid = maxid("gallerydetails","id",$db);

        $imageFile = $_FILES['txtImage']['name'];

        if ($imageFile != NULL or $imageFile != "") {
            $ArFile = explode('.', $imageFile);
            $NewFile = $ArFile[0]."_".time().".".end($ArFile);
            move_uploaded_file($_FILES['txtImage']['tmp_name'], "../galleryimages/".$NewFile);
        }
        
        $db->query("insert into gallerydetails set
        id = '$pageid',
        pageid      = '".$_SESSION['GalID']."',
        pagetitle   = '".$db->real_escape_string($_POST['txtpagetitle'])."',
        pubdate     = '".date('Y-m-d h:i:s a')."',
        image       = '".$db->real_escape_string($NewFile)."',
        status      = '0',
        CoverImage  = '0'
        ");
        
        notify("Photo Manager","Photo Inserted Successfully",base_url()."gallerydetail.php", FALSE,1000,0);
        
        die();
    }
}

if(isset($_POST['btnEdit']))
{
    if($_SESSION['rand'] == $_POST['rand'])
    {
        $db->query("update gallerydetails set
        pagetitle   = '".$db->real_escape_string($_POST['txtpagetitle'])."',
        status      = '".$db->real_escape_string($_POST['txtstatus'])."'
        where
        pageid      = '".$db->real_escape_string($_POST['txtpageid'])."'
        ");
        
        notify("Photo Manager","Photo Modified Successfully",base_url()."gallerydetail.php", FALSE,1000,0);
        
        die();
    }
}

if(isset($_POST['btnDelete']))
{
    if($_SESSION['rand'] == $_POST['rand'])
    {
        $getFile = $db->query("select image from gallerydetails where id = '".$_POST['id']."'");
        $setFile = $getFile->fetch_object();
        if(file_exists("../galleryimages/".$setFile->image))
        {
            unlink('../galleryimages/'.$setFile->image);
        }
        $db->query("delete from gallerydetails where id = '".$_POST['id']."'");
        notify("Photo Manager","Photo Deleted Successfully",base_url()."gallerydetail.php", FALSE,1000,0);
        
        die();
    }
}
if(isset($_POST['btnHide']))
{
    if($_SESSION['rand'] == $_POST['rand'])
    {
        $db->query("update gallerydetails set Status = '1' where id = '".$_POST['id']."'");
        notify("Photo Manager","Photo Modified Successfully",base_url()."gallerydetail.php", FALSE,1000,0);
        
        die();
    }
}
if(isset($_POST['btnShow']))
{
    if($_SESSION['rand'] == $_POST['rand'])
    {
        $db->query("update gallerydetails set Status = '0' where id = '".$_POST['id']."'");
        notify("Photo Manager","Photo Modified Successfully",base_url()."gallerydetail.php", FALSE,1000,0);
        
        die();
    }
}

if(isset($_POST['btnCover']))
{
    if($_SESSION['rand'] == $_POST['rand'])
    {
        $db->query("update gallerydetails set CoverImage = '0' where pageid = '".$_SESSION['GalID']."'");
        $db->query("update gallerydetails set CoverImage = '1' where id = '".$_POST['id']."'");
        notify("Photo Manager","Photo Modified Successfully",base_url()."gallerydetail.php", FALSE,1000,0);
        
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
        <h1>
            Photo Manager
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Gallery List
                </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool hide-cate-list" data-widget="collapse" type="button">
                        <i class="fa fa-plus">
                        </i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="pull-right">
                    <a class="btn btn-primary" href="#" id="add_form_button">
                        Add Images
                    </a>
                    <a class="btn btn-info" href="<?php echo base_url() ?>photomanager.php">
                        Back
                    </a>
                </div>
                <div class="clearfix">
                </div>
                <br>
                    <table class="table table-bordered table-hover" id="dataTable" width="100%">
                        <thead>
                            <tr>
                                <th width="35%">
                                    Photo Title
                                </th>
                                <th width="12%">
                                    Image
                                </th>
                                <th width="19%">
                                    Published Date
                                </th>
                                <th width="19%">
                                    Status
                                </th>
                                <th width="15%">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                $getCate = $db->
                            query("select * from gallerydetails where pageid = '".$_SESSION['GalID']."' order by id asc");
                while($setCate = $getCate->fetch_object())
                {
                ?>
                            <tr>
                                <td><?php echo $setCate->pagetitle ?>
                                    <?php
                                    if ($setCate->CoverImage == 1) {
                                        echo "<span class='label label-success'>Cover</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <img class="img-thumbnail img-responsive" src="../galleryimages/<?php echo $setCate->image ?>"/>
                                </td>
                                <td align="center">
                                    <?php echo ($setCate->pubdate) ?>
                                </td>
                                <td align="center">
                                    <?php echo Status($setCate->status) ?>
                                </td>
                                <td align="center">
                                    <form class="btn-tooltips" method="post">
                                        <button class="btn btn-primary btn-xs edit" data-button="btnEdit" data-class="btn btn-info" data-id="<?php echo $setCate->id;?>" data-input-name="id" data-target="#edit_modal" data-toggle="modal" data-url="<?php echo base_url() ?>editimage.php" id="btnEdit2" name="btnEdit" title="Cover" type="submit">
                                            <span class="fa fa-pencil">
                                            </span></button>

                                        <button class="btn btn-info btn-xs cover" data-button="btnCover" data-class="btn btn-info" data-id="<?php echo $setCate->id;?>" data-input-name="id" data-target="#cover_modal" data-toggle="modal" data-url="" id="btnCover2" name="btnCover" title="Cover" type="submit">
                                            <span class="fa fa-eye">
                                            </span></button>

                                        <button class="btn btn-danger btn-xs delete" data-button="btnDelete" data-class="btn btn-danger" data-id="<?php echo $setCate->id;?>" data-input-name="id" data-target="#delete_modal" data-toggle="modal" data-url="" id="btnDelete2" name="btnDelete2" title="Delete" type="submit">
                                            <span class="fa fa-trash">
                                            </span>
                                        </button>
                                        <button class="btn btn-warning btn-xs hidecate" data-button="btnHide" data-class="btn btn-warning" data-id="<?php echo $setCate->id;?>" data-input-name="id" data-target="#hide_modal" data-toggle="modal" data-url="" id="btnHide2" name="btnHide2" title="Hide" type="submit">
                                            <span class="fa fa-ban">
                                            </span>
                                        </button>
                                        <button class="btn btn-success btn-xs showcate" data-button="btnShow" data-class="btn btn-success" data-id="<?php echo $setCate->id;?>" data-input-name="id" data-target="#show_modal" data-toggle="modal" data-url="" id="btnShow2" name="btnShow2" title="Show" type="submit">
                                            <span class="fa fa-check">
                                            </span>
                                        </button>
                                        <input name="rand" type="hidden" value="<?php echo $rand;?>">
                                        </input>
                                    </form>
                                </td>
                            </tr>
                            <?php
                }
                ?>
                        </tbody>
                    </table>
                </br>
            </div>
            <!-- /.box-body -->
        </div>
        <div class="box box-success" id="add_form">
            <div class="box-header with-border">
                <h3 class="box-title cate-form-title">
                    Add Form
                </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-minus">
                        </i>
                    </button>
                    <button class="btn btn-box-tool show-cate-list" data-widget="remove" type="button">
                        <i class="fa fa-times">
                        </i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form class="form-horizontal" id="AllForm" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label class="control-label" for="txtpagetitle">
                                Image Title
                            </label>
                            <input class="form-control" id="txtpagetitle" name="txtpagetitle" type="text">
                            </input>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="txtImage">
                                Select Image
                            </label>
                            <div class="input-group ">
                                <span class="input-group-btn">
                                    <label class="btn btn-primary">
                                        <span class="fa fa-plus">
                                        </span>
                                        Choose
                                        <input accept="image/*" class="hidden" id="txtImage" name="txtImage" required="" type="file" value=""/>
                                    </label>
                                </span>
                                <input class="form-control" disabled="disabled" id="disp-file" placeholder="Image Holder">
                                    <span class="input-group-btn rmove-btn">
                                        <button class="btn btn-danger" id="remove" type="button">
                                            <span class="fa fa-times">
                                            </span>
                                        </button>
                                    </span>
                                </input>
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
                            <button class="btn btn-primary btn-lg btn-block" id="btnSave" name="btnSave">
                                Save
                            </button>
                        </div>
                    </div>
                    <input name="rand" type="hidden" value="<?php echo $_SESSION['rand'] ?>">
                        <input name="txtpageid" type="hidden" value="">
                        </input>
                    </input>
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
            
            linkid = $(this).attr('id')
            $.ajax({
                type:'POST',
                data:'linkid='+linkid,
                dataType : "json",
                url:"<?php echo base_url() ?>api/photo.php",
                success: process_response
            })
        });
</script>
<?php
confirm2("Photo Management","Do you want to modify the record?","edit","edit_modal",$rand,6);
confirm2("Photo Management","Do you want to delete the record?","delete","delete_modal",$rand,1);
confirm2("Photo Management","Do you want to Modify the record?","hidecate","hide_modal",$rand,2);
confirm2("Photo Management","Do you want to Modify the record?","showcate","show_modal",$rand,3);
confirm2("Photo Management","Do you want to add images on this gallery?","addgal","addgal_modal",$rand,4);
confirm2("Photo Management","Do you want to Cover this as gallery cover?","cover","cover_modal",$rand,5);
?>
<!-- Main Footer -->
<?php include('include/footer.php'); ?>
