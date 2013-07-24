<? 
require("header.php"); 

if (!empty($_POST['title']))
{

	$q = query("SELECT id FROM count ORDER BY id DESC");
	$count = $q[0]['id'];
	$qq = query("INSERT INTO count (id) VALUES (NULL)");
	
	$last = array_pop(explode('.', $_FILES["file"]["name"]));
	
	$name = $count.".".$last;
	
	$allowedExts = array("jpg", "jpeg", "gif", "png", "pdf", "doc", "docx");
	
	$extension = end(explode(".", $_FILES["file"]["name"]));
	if (($_FILES["file"]["size"] < 5000000)
	&& in_array($extension, $allowedExts))
	  {
	  if ($_FILES["file"]["error"] > 0)
		{
		echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		$proceed = false;
		}
	  else
		{
			move_uploaded_file($_FILES["file"]["tmp_name"],
			"lessons/" . $name);
		
			$link = "lessons/".$name;
			$proceed = true;
			
		  }
		}
	else
	  {
	  echo "Error in uploading file.";
	  $proceed = false;
	  }

	if ($proceed)
	{
		$tags = explode(",", $_POST['tags']);
		query("INSERT INTO lessonplans (title, difficulty, summary, link, author) VALUES (?, ?, ?, ?, ?)", $_POST['title'], intval($_POST['difficulty']), $_POST['summary'], $link, $_POST['author']);
		$thingidq = query("SELECT * FROM lessonplans WHERE title = ? ORDER BY date DESC", $_POST['title']);
		$thingid = $thingidq[0]['id'];
		foreach ($tags as $tag)
		{
			$q = query("SELECT * FROM tags WHERE tag = ?", $tag);
			if (empty($q))
			{
				query("INSERT INTO tags (tag) VALUES (?)", $tag);
				$q = query("SELECT * FROM tags WHERE tag = ?", $tag);
			}
			$tagid = $q[0]['id'];
			query("INSERT INTO tag_links (tag_id, thing_id) VALUES (?, ?)", $tagid, $thingid);
		}
	}
}
?>

	<div class="row">
		<div class="large-12 columns">
			<h3>Add Lesson Plan</h3>
			<center>
				<a href="addplan.php"><div class="button radius large">Fill out Template (recommended)</div></a>
				<a href="addplan2.php"><div class="button radius large success">Upload from Computer</div></a>
				<a href="addplan3.php"><div class="button radius large">Upload from Link</div></a>
			</center>
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<div class="panel">
			<form id="f" name="f" action="addplan2.php" method="post" enctype="multipart/form-data">
				<div class="row">
			      <div class="large-4 columns">
			      	<label><h5>Upload a File</h5></label>
        			<input type="file" id="file" name="file">
        		  </div>
        		</div>
				<div class="row">
			      <div class="large-4 columns">
			      	<label>Title</label>
        			<input type="text" id="title" name="title" placeholder="Lesson Title">
        		  </div>
        		</div>
        		<div class="row">
			      <div class="large-4 columns">
			      	<label>Author</label>
        			<input type="text" id="author" name="author" placeholder="Original Citation">
        		  </div>
        		</div>
				<input type="hidden" name="difficulty" id="difficulty" value="">
				<div class="row">
					<div class="large-4 columns">
					Difficulty: <a href="#" data-dropdown="drop2" id="difffillin">Select</a>
						<ul id="drop2" class="f-dropdown tiny" data-dropdown-content>
						  <li><div class="difficult">1</div></li>
						  <li><div class="difficult">2</div></li>
						  <li><div class="difficult">3</div></li>
						  <li><div class="difficult">4</div></li>
						  <li><div class="difficult">5</div></li>
						</ul>
					</div>
				</div>
				<div class="row"><br></div>
				<div class="row">
					<div class="large-12 columns">
						<label>Tags</label>
						<input type="text" name="tags" id="tags" placeholder="Comma-separated tags">
					</div>
				</div>
				<div class="row">
				  <div class="large-12 columns">
					<label>Summary</label>
					<textarea name="summary" id="summary" placeholder="A general summary of this lesson."></textarea>
				  </div>
				</div>
				<div class="button radius alert" id="submit">Submit</div>
			</form>
			</div>	
		</div>
	</div>

  <script>
  document.write('<script src=' +
  ('__proto__' in {} ? 'js/vendor/zepto' : 'js/vendor/jquery') +
  '.js><\/script>')
  </script>
  
  <script src="js/foundation.min.js"></script>
  <!--
  
  <script src="js/foundation/foundation.js"></script>
  
  <script src="js/foundation/foundation.alerts.js"></script>
  
  <script src="js/foundation/foundation.clearing.js"></script>
  
  <script src="js/foundation/foundation.cookie.js"></script>
  
  <script src="js/foundation/foundation.dropdown.js"></script>
  
  <script src="js/foundation/foundation.forms.js"></script>
  
  <script src="js/foundation/foundation.joyride.js"></script>
  
  <script src="js/foundation/foundation.magellan.js"></script>
  
  <script src="js/foundation/foundation.orbit.js"></script>
  
  <script src="js/foundation/foundation.reveal.js"></script>
  
  <script src="js/foundation/foundation.section.js"></script>
  
  <script src="js/foundation/foundation.tooltips.js"></script>
  
  <script src="js/foundation/foundation.topbar.js"></script>
  
  <script src="js/foundation/foundation.interchange.js"></script>
  
  <script src="js/foundation/foundation.placeholder.js"></script>
  
  <script src="js/foundation/foundation.abide.js"></script>
  
  -->
  
  <script>
    $(document).foundation();
    
    $(document).ready(function() {
        
    	function validate() 
    	{
    		valid = true;
    		$('input, textArea').each(function(){
				if($.trim($(this).val()) == ''){
					$(this).parent().append('<div style="color: red; font-size: 12px;">This is a required field.</div>');
					valid = false;
				}
			});
			return valid;
    	}
    
    	$('.difficult').click(function() {
    		var diffval = $(this).html();
    		$('input[name=difficulty]').val(diffval);
    		$('#difffillin').html(diffval);
    	});
    	
    	$('#submit').click(function() {
    		if (validate())
    			$("#f").submit();
    	});
    
    });
  </script>
</body>
</html>
