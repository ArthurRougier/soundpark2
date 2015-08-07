<?php
	include_once('../model/get_settings_playlist_tiles.php');

	$i = 1;
	$j = 1;
	while($playlistBoxes = $req->fetch())
	{
		
		?>
		<div id="box<?php echo($i);?>" class="box"
			><div class="boxInner" id="boxInner<?php echo($i);?>"
				><figure class="playlist_overlay stack-randomrot">
					<img src="<?php echo($playlistBoxes['pic1']) ?>" alt="img01"/>
					<img src="<?php echo($playlistBoxes['pic2']) ?>" alt="img02"/>
					<img src="<?php echo($playlistBoxes['pic3']) ?>" alt="img03"/>
				</figure>

				<!-- <div class="playlist_overlay <?php 

					/*switch ($j) {
					    case 1:
					        echo "purple";
					        break;
					    case 2:
					        echo "blue";
					        break;
					    case 3:
					        echo "dark";
					        break;
				        case 4:
				            echo "red";
				            break;
			            case 5:
			                echo "black";
			                $j = 0;
			                break;
					}*/

				 ?>" id="playlist_overlay<?php echo($i);?>"
					> -->
					<a href="../view/frommail.php?playlistId=<?php echo($playlistBoxes[0]); ?>" target="_blank"><h2><?php
						$ddate = $playlistBoxes[1];
						$date = new DateTime($ddate);
						$week = $date->format("W");
						$month = $date->format("m");
						$monthLetter = $date->format("M");
						$year = $date->format("y");
						$ddate = "20".$year."-".$month."-01";
						$monthFirstDay = new DateTime($ddate);
						$monthFirstWeek = $monthFirstDay->format("W");
						$adjustedWeek = $week - ($monthFirstWeek - 1);



						echo $monthLetter.", playlist #".$playlistBoxes[0];


				 	?></h2><div class="helper"></div></a
				></div
			></div>
		<?php 
		$i++;
		$j++;
	};


?>

<script type="text/javascript">
	var allTiles = document.querySelectorAll('.box');
	for(var indexTilesPlaylist = 0 ; indexTilesPlaylist < allTiles.length ; indexTilesPlaylist++ )
	{
		allTiles[indexTilesPlaylist].addEventListener('mouseover', function(){
			this.firstChild.firstChild.classList.add("active");
		}, false);
	}
	for(var indexTilesPlaylist = 0 ; indexTilesPlaylist < allTiles.length ; indexTilesPlaylist++ )
	{
		allTiles[indexTilesPlaylist].addEventListener('mouseout', function(){
			this.firstChild.firstChild.classList.remove("active");
		}, false);
	}
	/*addEventListener('click', function(){
			this.classList.add("active");
	}, false);*/

</script>