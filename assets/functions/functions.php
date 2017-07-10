<?php
    error_reporting(0);

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
	$basename = str_replace("assets/functions/","",$basename);
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

function ConvertTags($string){
	$TagsArray = explode(',',$string);
	foreach($TagsArray as $tags)
	{
		$FinalTag .= "<a href='#'>$tags</a> ";
	}
	return $FinalTag;
}
function getCate($d,$db) {
	$getSub = $db->query("select * from article_cate where CateID = '$d'");
	$setSub = $getSub->fetch_object();
	
	$string = $setSub->CateTitle;
	
	return $string;
}
function getSubCate($d,$db) {
	$getSub = $db->query("select * from article_subcate where SubCateID = '$d'");
	$setSub = $getSub->fetch_object();
	
	$string = $setSub->CateTitle." <small>// ".getCate($setSub->CateID,$db)."</small> ";
	
	return $string;
}
function getAuthor($d,$db) {
	$getSub = $db->query("select * from tblauthor where id = '$d'");
	$setSub = $getSub->fetch_object();
	
	$string = $setSub->authorname;
	
	return $string;
}
function limit_text($text, $limit) {
    $desc = strip_tags($text); 
    $countChar = explode(" ",$desc);
    if(count($countChar) > $limit)
    {
        $detail = "";
        for ($i=0; $i < $limit; $i++) { 
            $detail .= $countChar[$i]." ";
        }
        $detail .= '...';
    }
    else
    {
        $detail = $desc;
    }
    return $detail;
}

function limit_para($string,$count)
{
    $return_string = "";
    preg_match_all("/<p>(.*)<\/p>/", $string, $matches);
    for($i=0;$i<$count;$i++)
    {
        $return_string .= $matches[0][$i];
    }
    return $return_string;
}

function paginate($db, $query, $per_page = 10,$page = 1, $url = '?'){        
        $result = $db->query("select count(*) as num from $query");
    	$row = $result->fetch_object();
    	$total = $row->num;
        $adjacents = "2"; 

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		$firstPage = 1;
        $prev = ($page == 1)? 1:$page - 1; 						
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
    	if($lastpage > 1)
    	{	
    		$pagination .= "<ul class='pagination'>";
                    //$pagination .= "<li class='details'>Page $page of $lastpage</li>";
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
				if ($page == 1)
				{
				$pagination.= "<li  class='disabled'><a>First</a></li>";
				$pagination.= "<li  class='disabled'><a>Prev</a></li>";
				}
				else
				{
				$pagination.= "<li><a href='{$url}page=$firstPage'>First</a></li>";
				$pagination.= "<li><a href='{$url}page=$prev'>Prev</a></li>";
				}
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li  class='active disabled'><a>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li  class='active'><a>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>.....</li>";
    				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>.....</li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li  class='active'><a>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>.....</li>";
    				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>.....</li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li  class='active'><a>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= "<li><a href='{$url}page=$next'>Next</a></li>";
                $pagination.= "<li><a href='{$url}page=$lastpage'>Last</a></li>";
    		}else{
    			$pagination.= "<li  class='disabled'><a>Next</a></li>";
                $pagination.= "<li  class='disabled'><a>Last</a></li>";
            }
    		$pagination.= "</ul>";		
    	}
    
    return $pagination;
    } 
?>
