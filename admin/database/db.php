<?php
	error_reporting(0);
	session_start();
	
	$idle_time = 30*60;
	
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "";
	$dbase = "gorkhasavingdb";
	
	$db = new mysqli($dbhost,$dbuser,$dbpass,$dbase);
	if($db->connect_errno)
	{
		return_error();
	}
	
	$db->query("set names utf8");
	
	date_default_timezone_set("Asia/Kathmandu");
	
	function AdType($d) {
		$d = ($d == 0 ? "Top" : ($d == 1 ? "Right" : "Bottom")) ;
		
		return $d;
	}
	
	
	function getSubCate($d,$db) {
		$getMainCate = $db->query("select * from article_subcate where SubCateID = '$d'");
		$setMainCate = $getMainCate->fetch_object();
		
		return $setMainCate->CateTitle;
	}
	
	function getMainCate($d,$db) {
		$getMainCate = $db->query("select * from article_cate where CateID = '$d'");
		$setMainCate = $getMainCate->fetch_object();
		
		return $setMainCate->CateTitle;
	}
	
	function CateType($d) {
		$d = ($d == 1 ? "Single" : ($d == 2 ? "Menu" : ($d == 3 ? "Mega Menu" : ($d == 4 ? "Mega Menu (inc. Image)" : 
		($d == 5 ? "News & Updates" : "Popular Posts"))))) ;
		
		return $d;
	}
	function Status($d) {
		$d = $d == 0 ? "<span class='badge bg-green'>Published</span>" :  "<span class='badge bg-red'>Hidden</span>" ;
		
		return $d;
	}
	
	function maxid($table,$id,$db) {
		$getmax = "select max($id+1) as $id from $table";
		$res = $db->query($getmax);
		$final = $res->fetch_object();
		if($final->$id==NULL)
		{
			return "1";
		}
		else
		{
			return $final->$id;
		}
	}
	
	function base_url() {
		$HOST="http://".$_SERVER['HTTP_HOST'];
		$ROOT_DIR= $_SERVER['DOCUMENT_ROOT'];
		$DS=DIRECTORY_SEPARATOR;
		if ($DS=="\\") $DS = "/";
		$filedir = dirname(__FILE__);
		$filedir=str_replace("\\",$DS,$filedir);
		$filedir=str_replace($ROOT_DIR,"",$filedir);
		$basename = $HOST . $DS . $filedir;
		
		$basename = $basename."/";
		$basename = str_replace("//","/",$basename);
		$basename = str_replace("http:/","http://",$basename);
		$basename = str_replace("database/","",$basename);
		return $basename;
	}
	
	function return_error(){
	?>

<div class="col-sm-6 col-sm-offset-3">
    <div class="panel panel-danger">
        <div class="panel-heading">
            <div class="panel-title">
                Fatal Error
            </div>
        </div>
        <div class="panel-body">
            <?php
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "<br>Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "<br>Debugging error: " . mysqli_connect_error() . PHP_EOL;
            
            ?>
        </div>
    </div>
</div>
<?php
}
function RandomVal($val=10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $val; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function notify($title, $text, $url, $noclose = TRUE, $timeout=0, $dis_after = 0)
{
	if($dis_after == 0)
	{
	?>
  <script>
  $(document).ready(function(e) {
		$('#myModal').modal('show');
  });
	</script>
    <?php
	}
	else
	{
	?>
    <script>
  setTimeout(function(e) {
		$('#myModal').modal();
  },<?php echo $dis_after; ?>);
	</script>
    <?php
	}
	?>
  <div class="modal modal-info" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm"  style="top:25%;">
		  <div class="modal-content">
			  <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="panel-title" id="myModalLabel"><strong><?php echo $title;?></strong></h4>
        </div>
        <div class="modal-body">
					<?php echo $text;?>
        </div>
				<?php if ($noclose)
				{
					?>
        <div class="modal-footer">
        <button id="close" type="button" class="btn btn-default" data-dismiss="modal" autofocus>Close</button>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
	<?php if (isset($url))
	{ ?>
<script>
/*	$('#close').click(function(e) {
		window.location='<?php echo $url;?>'; 
  }); */
	$('#myModal').on('hide.bs.modal', function (e) {
		window.location='<?php echo $url;?>'; 
	});
</script>
	<?php } ?>
	<?php if ((isset($timeout) && ($timeout > 0)))
	{
		?>
<script>
		window.setTimeout(function() { $('#myModal').modal('hide'); },<?php echo $timeout;?>);
</script>
		<?php } ?>
  <?php
}
function confirm2($title, $text,$buttonClass,$modalID,$rand,$ID)
{
	?>
<div id="<?php echo $modalID;?>" class="modal">
	<div class="modal-dialog modal-sm" style="top:25%;">
      <div class="modal-content">
        <div class="modal-header">
            <button data-dismiss="modal" aria-hidden="true" class="close">×</button>
             <h4 class="modal-title"><?php echo $title;?></h4>
        </div>
        <div class="modal-body">
             <p><?php echo $text;?></p>
        </div>
        <div class="modal-footer">
        	<form method="post" id="FormSubmit<?php echo $ID;?>">
        	<button id="btnYes<?php echo $ID;?>" class="btn btn-danger">Yes</button>
          <button data-dismiss="modal" aria-hidden="true" class="btn btn-default" autofocus>No</button>
          <input type="hidden" name="rand" id="rand" value="<?php echo  $rand;?>">
					<input type="hidden" id="input<?php echo $ID;?>">
          </form>
        </div>
      </div>
    </div>
</div>
<script>
$('button.<?php echo $buttonClass;?>').click(function(ev) {
	ev.preventDefault();
	$('#<?php echo $modalID;?>').removeData('bs.modal');
	var ID = $(this).data('id');
	var INPUTNAME = $(this).data('input-name');
	var URL = $(this).data('url');

	$("#input<?php echo $ID;?>").attr("name",INPUTNAME);
	$("#input<?php echo $ID;?>").val(ID);

	$("#btnYes<?php echo $ID;?>").attr("class",$(this).data('class'));
	$("#btnYes<?php echo $ID;?>").attr("name",$(this).data('button'));
	$("#FormSubmit<?php echo $ID;?>").attr("action",URL);
	});
</script>    
<?php
}
?>