<?php

    session_start();

	define("DATABASE", "crimsor9_dlp");

    define("PASSWORD", "Rubiks_a5245557");

    define("SERVER", "localhost");

    define("USERNAME", "crimsor9");
    
    function condense($str)
	{
		if (strlen($str)>20)
			return substr($str, 0, 20)."...";
		return $str;
	}

	function thumber($id, $title, $price, $pic)
	{
        // echo '<div class = "outer-item">';
		echo '<div class="span2" >';  
        echo '<p><div class="outer"><div class="image"><img onclick="TINY.box.show({iframe:\'item.php?q='.$id.'\',boxid:\'frameless\',width:750,height:550,fixed:false,maskid:\'bluemask\',maskopacity:40,closejs:function(){closeJS()}})" src="img/thumbs/'.$pic.'">';    
		 $query = query("SELECT * FROM items WHERE id = ?", $id);
         if (isset($_SESSION['userid']))
         {
            $q = query("SELECT * FROM users WHERE id = ?", $_SESSION['userid']);
         }
        if ($query[0]['seller']==$_SESSION['userid'] || $q[0]['admin']==1)
        {
             echo '<a href="delete.php?q='.$id.'" class = "delete"></a>';
        } 
		echo '<div class="texter"><h2><span>'.condense($title).'</span></h2>';
		echo '<div class="price"><h2><span>$'.$price.'</span></h2></div></div></div></div></p>';
		echo '</div><!--/span-->';
	}
	function logout()
    {
        // unset any session variables
        $_SESSION = array();

        // expire cookie
        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 42000);
        }

        // destroy session
        session_destroy();
    }
	function query(/* $sql [, ... ] */)
    {
        // SQL statement
        $sql = func_get_arg(0);

        // parameters, if any
        $parameters = array_slice(func_get_args(), 1);

        // try to connect to database
        static $handle;
        if (!isset($handle))
        {
            try
            {
                // connect to database
                $handle = new PDO("mysql:dbname=" . DATABASE . ";host=" . SERVER, USERNAME, PASSWORD);

                // ensure that PDO::prepare returns false when passed invalid SQL
                $handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            }
            catch (Exception $e)
            {
                // trigger (big, orange) error
                trigger_error($e->getMessage(), E_USER_ERROR);
                exit;
            }
        }
// 
//       // prepare SQL statement
         $statement = $handle->prepare($sql);
//         if ($statement === false)
//         {
//             // trigger (big, orange) error
//             trigger_error($handle->errorInfo()[2], E_USER_ERROR);
//             exit;
//         }

        // execute SQL statement
        $results = $statement->execute($parameters);

        // return result set's rows, if any
        if ($results !== false)
        {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

	function construct_slider($id)
	{
		echo "<script>\n";
		echo "var slider = new Array();\n";
		$q = "SELECT * FROM item_pictures WHERE itemid = ".$id;
		$pics = query($q);
		$count = 0;
		foreach ($pics as $prepic)
		{
			$pic = $prepic["picname"];
			echo "slider[".$count."] = \"".$pic."\"\n";
			$count++;
		}
		echo "</script>\n";
	}

?>