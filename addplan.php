<? 
require("header.php"); 

if (!empty($_POST['title']))
{
	$tags = explode(",", $_POST['tags']);
	query("INSERT INTO templates (objectives, prereqs, content, activities, timing, eval, plus) VALUES (?, ?, ?, ?, ?, ?, ?)", $_POST['objectives'], $_POST['prereqs'], $_POST['content'], $_POST['activities'], $_POST['timing'], $_POST['eval'], $_POST['plus']);
	$linkq = query("SELECT * FROM templates WHERE objectives=? ORDER BY id DESC", $_POST['objectives']);
	$link = "template.php?q=".$linkq[0]['id'];
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
?>

	<div class="row">
		<div class="large-12 columns">
			<h3>Add Lesson Plan</h3>
			<center>
				<a href="addplan.php"><div class="button radius large success">Fill out Template (recommended)</div></a>
				<a href="addplan2.php"><div class="button radius large">Upload from Computer</div></a>
				<a href="addplan3.php"><div class="button radius large">Upload from Link</div></a>
			</center>
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<div class="panel">
			<form id="f" name="f" action="addplan.php" method="post">
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
				<div class="row">
				  <div class="large-12 columns">
					<label>Objectives</label>
					<textarea name="objectives" id="objectives" placeholder="A specific statement of goals for the lesson, phrased as specific things students will know or be able to do by the end of the lesson."></textarea>
				  </div>
				</div>
				<div class="row">
				  <div class="large-12 columns">
					<label>Scaffolding Knowledge and Prerequisites</label>
					<textarea name="prereqs" id="prereqs" placeholder="Knowledge from previous lessons that students will be asked to apply again and should be reminded of before the lesson. An explanation of how this lesson builds on previous lessons."></textarea>
				  </div>
				</div>
				<div class="row">
				  <div class="large-12 columns">
					<label>Content</label>
					<textarea name="content" id="content" style="height: auto;" rows="20" placeholder="A specific list of all of the content that will be taught in the lesson. A more detailed explanation of all of the content that will be conveyed during the lesson. Could be used as detailed lecture notes. A clear explanation of how the class will move from one area to the next."></textarea>
				  </div>
				</div>
				<div class="row">
				  <div class="large-12 columns">
					<label>Activities</label>
					<textarea name="activities" id="activities" style="height: auto;" rows="8" placeholder="A list of possible activities that can be used to teach the lesson with clear links to objectives and content."></textarea>
				  </div>
				</div>
				<div class="row">
				  <div class="large-12 columns">
					<label>Lesson Timing</label>
					<textarea name="timing" id="timing" placeholder="A proposed breakdown for a 60 minute lesson with optional extensions for a 90 minute lesson."></textarea>
				  </div>
				</div>
				<div class="row">
				  <div class="large-12 columns">
					<label>Evaluation Techniques</label>
					<textarea name="eval" id="eval" placeholder="An explanation of how student knowledge of objectives will be evaluated at the end of the lesson and how analytics will be used to inform follow-up instruction."></textarea>
				  </div>
				</div>
				<div class="row">
				  <div class="large-12 columns">
					<label>Additional Materials</label>
					<textarea name="plus" id="plus" placeholder="Materials or activities that students who found the lesson interesting can continue to work on at home to further their knowledge of the area."></textarea>
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
