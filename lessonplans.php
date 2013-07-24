<? require("header.php"); ?>

	<div class="row">
		<div class="large-12 columns">
			<h3>Lesson Plans</h3>
			<table>
				<tr>
					<th>
						<a href="#">Create Curricula</a>
					</th>
					<th>
						<a href="#">Search</a>
					</th>
					<th>
						<a href="#">Select Category</a>
						</ul>
					</th>
					<th>
						<a href="#" data-dropdown="drop2">Sort</a>
						<ul id="drop2" class="f-dropdown" data-dropdown-content>
						  <li><a href="#">Date Added</a></li>
						  <li><a href="#">Popularity</a></li>
						  <li><a href="#">Efficacy</a></li>
						</ul>
					</th>
				</tr>
			</table>
			
			<? 
				$lessons = query("SELECT * FROM lessonplans ORDER BY date DESC");
				foreach ($lessons as $lesson)
				{
					echo '<div class="row">';
					echo '<div class="large-12 columns">';
					echo '<div class="panel">';
					echo '<h4><a href="'.$lesson['link'].'">'.$lesson['title'].'</a></h4>';
					echo '<table>';
					$date = date("F j, Y", strtotime($lesson['date']));
					echo '<tr><th>'.$date.'</th><th>Difficulty: '.$lesson['difficulty'].'</th><th><a href="efficacy.php?q='.$lesson['id'].'">Efficacy Report</a></th><th>Number of Uses: '.$lesson['uses'].'</th></tr>';
					echo '</table>';
					echo '<p>'.$lesson['summary'].'</p>';
					echo '<p>Tags: ';
					$tags = query("SELECT * FROM tag_links WHERE thing_id = ?", $lesson['id']);
					$count = count($tags);
					foreach ($tags as $tag)
					{
						$gettag = query("SELECT * FROM tags WHERE id = ?", $tag['tag_id']);
						echo '<a class="tag" href="tags.php?q='.$tag['tag_id'].'">'.$gettag[0]['tag'].'</a>' ; 
						if ($count>1)
							echo ", ";
						$count--;
					}
					echo "</p></div></div></div>";

				}
			
			?>
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
  </script>
</body>
</html>
