<? 

if (empty($_GET['q']))
{
	header('location: index.php');
}
else
{
	require("header.php"); 
	
	$everything = query("SELECT * FROM templates WHERE id = ?", $_GET['q']);
	$t = $everything[0];
	$lq = query("SELECT * FROM lessonplans WHERE link = ?", "template.php?q=".$_GET['q']);
	$l = $lq[0];
	$tagsq = query("SELECT * FROM tag_links WHERE thing_id = ?", $l['id']);
	$tags = array();
	foreach ($tagsq as $tagid)
	{
		$tagq = query("SELECT * FROM tags WHERE id = ?", $tagid);
		array_push($tags, $tagq[0]);
	}
}
?>

	<div class="row">
		<div class="large-12 columns">
			<div class="panel">
				<div class="row">
			      <div class="large-4 columns">
			      	<h4><? echo $l['title']; ?></h4>
			      </div>
        		</div>
        		<div class="row">
			      <div class="large-4 columns">
					<h5><? echo $l['author']; ?></h5>
        		  </div>
        		</div>
				<div class="row">
					<div class="large-4 columns">
					<p>Difficulty: <? echo $l['difficulty']; ?></p>
					</div>
				</div>
				<div class="row">
					<div class="large-12 columns">
					<p>
					<? foreach ($tags as $tag)
							echo '<a class="tag" href="tags.php?q='.$tag['id'].'">'.$tag['tag'].'</a>' ; 
					?>
					</p>
					</div>
				</div>
				<div class="row">
				  <div class="large-12 columns">
				 	 <h5>Summary</h5>
				  <p><? echo $l['summary']; ?></p>
				  </div>
				</div>
				<div class="row">
				  <div class="large-12 columns">
				  	<h5>Objectives</h5>
					<p><? echo $t['objectives']; ?></p>
				  </div>
				</div>
				<div class="row">
				  <div class="large-12 columns">
				  	<h5>Scaffolding Knowledge and Prerequisites</h5>
					<p><? echo $t['prereqs']; ?></p>
				  </div>
				</div>
				<div class="row">
				  <div class="large-12 columns">
					<h5>Content</h5>
					<p><? echo $t['content']; ?></p>
				  </div>
				</div>
				<div class="row">
				  <div class="large-12 columns">
					<h5>Activities</h5>
					<p><? echo $t['activities']; ?></p>
				  </div>
				</div>
				<div class="row">
				  <div class="large-12 columns">
					<h5>Lesson Timing</h5>
					<p><? echo $t['timing']; ?></p>
				  </div>
				</div>
				<div class="row">
				  <div class="large-12 columns">
					<h5>Evaluation Techniques</h5>
					<p><? echo $t['eval']; ?></p>
				  </div>
				</div>
				<div class="row">
				  <div class="large-12 columns">
					<h5>Additional Materials</h5>
					<p><? echo $t['eval']; ?></p>
				  </div>
				</div>
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
