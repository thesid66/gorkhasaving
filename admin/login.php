<?php 
	include('database/db.php');
	
	$isAuthenticated = FALSE;
	
	
	$_SESSION['expire'] = time() + $idle_time;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VETNEPAL || Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>

</head>
<body class="hold-transition login-page">
<div class="login-box">
<?php
if(isset($_POST['BtnLogin']))
	{
		$form_rand = $_POST['rand'];
		if($_SESSION['random'] == $form_rand )
		{
			$username = $db->real_escape_string($_POST['txtUser']);
			$password = sha1(md5($db->real_escape_string($_POST['txtPass'])));
			
			$query = $db->query("select * from usertable where usern = '$username' and userp = '$password' limit 1");
			
			if($query->num_rows>0)
			{
				?>
                <div class="alert alert-success">
                    <p><span class="fa fa-spinner fa-pulse fa-2x fa-fw"></span> Login Successful</p>
                </div>
                <script>
                    setInterval(function(){
                        $('.alert').fadeOut('fast');
                        },1000);
					
                </script>
                
                <?php
				$result = $query->fetch_object();
				
				session_regenerate_id();
				$_SESSION['loggedin'] = TRUE;
				$_SESSION['user'] = "ADMIN";
				$_SESSION['userid'] = $result->userid;
				$_SESSION['expire'] = time() + $idle_time;
				
				$isAuthenticated = TRUE;
				
				notify("Welcome","<b>Welcome to the Admin Panel</b>",base_url(), FALSE,3000,1000);
			}
			else
			{
				?>
                <div class="alert alert-danger">
                    <p><span class="fa fa-exclamation-triangle"></span> Invalid Username and Password</p>
                </div>
                <script>
                    setInterval(function(){
                        $('.alert').fadeOut('fast');
                        },3000);
                </script>
                <?php
			}
		}
		else
		{
			?>
            <div class="alert alert-danger">
            	<p><span class="fa fa-exclamation-triangle"></span> Invalid Parameter</p>
            </div>
            <script>
            	setInterval(function(){
					$('.alert').fadeOut('fast');
					},3000);
            </script>
            <?php
		}
	}
	
	$rand = RandomVal(10);
	$_SESSION['random'] = $rand;
	if($isAuthenticated == FALSE)
	{
?>
  <div class="login-logo">
    <a href="index2.html"><b>VET</b>Nepal</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in </p>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Username" name="txtUser">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="txtPass">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <!--<div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>-->
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
        	<INPUT type="hidden" value="<?php echo $_SESSION['random'] ?>" name="rand">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name="BtnLogin">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

   <!-- <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div>
     /.social-auth-links

    <a href="#">I forgot my password</a><br>
    <a href="pages/examples/register.html" class="text-center">Register a new membership</a> -->

  </div>
  <?php
	}
  ?>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
