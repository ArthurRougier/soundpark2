<?php
	include_once('../model/get_settings_playlist_tiles.php');

	$i = 1;
	$j = 1;
	while($playlistBoxes = $req->fetch())
	{
		
		?>
		<div id="box<?php echo($i);?>" class="box"
			><div class="boxInner" id="boxInner<?php echo($i);?>"
				><div class="playlist_overlay <?php 

					switch ($j) {
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
					}

				 ?>" id="playlist_overlay<?php echo($i);?>"
					><a href="../view/frommail.php?playlistId=<?php echo($playlistBoxes[0]); ?>" target="_blank"><h2><?php
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



						echo $monthLetter.", week #".$adjustedWeek;


				 	?></h2><div class="helper"></div></a
				></div
			></div
		></div>
		<?php 
		$i++;
		$j++;
	};

