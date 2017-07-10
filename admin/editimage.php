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

        $imageFile = $_FILES['txtImage']['name'];

        if ($imageFile != NULL or $imageFile != "") {
            unlink('../galleryimages/'.$_POST['txtoldimage']);
            $ArFile = explode('.', $imageFile);
            $NewFile = $ArFile[0]."_".time().".".end($ArFile);
            move_uploaded_file($_FILES['txtImage']['tmp_name'], "../galleryimages/".$NewFile);
        }
        else
        {
            $NewFile = $_POST['txtoldimage'];
        }
        
        $db->query("update gallerydetails set
        pagetitle   = '".$db->real_escape_string($_POST['txtpagetitle'])."',
        image       = '".$db->real_escape_string($NewFile)."'
        where
        id = '".$_POST['txtpageid']."'
        ");
        
        notify("Photo Manager","Photo Updated Successfully",base_url()."gallerydetail.php", FALSE,1000,0);
        
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
        
        <div class="box box-success" >
            <div class="box-header with-border">
                <h3 class="box-title cate-form-title">
                    Edit Form
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
                    <?php
                    $getImage = $db->query("select * from gallerydetails where id = '".$_POST['id']."'");
                    $setImage = $getImage->fetch_object();
                    ?>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label class="control-label" for="txtpagetitle">
                                Image Title
                            </label>
                            <input class="form-control" id="txtpagetitle" value="<?php echo $setImage->pagetitle ?>" name="txtpagetitle" type="text">
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
                                        <input accept="image/*" class="hidden" id="txtImage" name="txtImage" type="file"/>
                                    </label>
                                </span>
                                <input class="form-control" disabled="disabled" id="disp-file" placeholder="Image Holder">
                                    <span class="input-group-btn rmove-btn">
                                        <button class="btn btn-danger" id="remove" type="button">
                                            <span class="fa fa-times">
                                            </span>
                                        </button>
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
                        <div class="col-sm-6">
                            <img src="../galleryimages/<?php echo $setImage->image ?>" class="img-responsive">
                            <input type="hidden" value="<?php echo $setImage->image ?>" name="txtoldimage">
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
                        <input name="txtpageid" type="hidden" value="<?php echo $setImage->id ?>">
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
