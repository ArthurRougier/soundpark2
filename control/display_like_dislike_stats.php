<?php
include_once('../model/connect_sql.php');


	$req2=$bdd->prepare('SELECT COUNT(*) FROM song WHERE song.ID_curator=?');
	$req2->execute(array($_SESSION['id_curator']));			
	$totalSongsPosted=$req2->fetch();

	$req2=$bdd->prepare('SELECT COUNT(*) FROM soundpark2.like, song WHERE like.ID_song=song.ID AND song.ID_curator=?');
	$req2->execute(array($_SESSION['id_curator']));			
	$totallikes=$req2->fetch();

	$req2=$bdd->prepare('SELECT COUNT(*) FROM soundpark2.dislike, song WHERE dislike.ID_song=song.ID AND song.ID_curator=?');
	$req2->execute(array($_SESSION['id_curator']));			
	$totaldislikes=$req2->fetch();

	$req2=$bdd->prepare('SELECT avatar_url FROM curator WHERE ID=?');
	$req2->execute(array($_SESSION['id_curator']));			
	$avatar=$req2->fetch();

	$req2=$bdd->prepare('SELECT COUNT(*) FROM automatic_next, curator WHERE curator.ID_user=automatic_next.mail AND curator.ID=?');
	$req2->execute(array($_SESSION['id_curator']));			
	$listened=$req2->fetch();


	//FAKE NUMBERS
	if ($totallikes[0]!=0)
	{
		$totallikes[0]=$totallikes[0]*4+3;
	}
?>
	
<div class="like_dislike_stat">		
	<p>
		<h2><?php echo($totalSongsPosted[0]);?></h2>
		<h3>Songs</br>posted</h3>
	</p>
</div>

<div id="curator_avatar" style="display:inline-block;">
	<img src="<?php echo($avatar[0]);?>"/ style="height:150px">	
</div>

<div class="like_dislike_stat">
	<p>
		<h2><?php echo($totallikes[0]);?></h2>
		<h3>likes</h3>
	</p>
</div>

<div class="like_dislike_stat">
	<p>
		<h2><?php echo($listened[0]);?></h2>
		<h3>listened</h3>
	</p>
</div>
