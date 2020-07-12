
<div class="showalbum">

<div><strong><i>NOTA - <?php echo esc($albumData["album"]["rating"]); ?></i></strong></div>

<hr style="width:15%; margin: 0px;">

<h2><?php echo esc($albumData["album"]["name"]);?>
<span style="color:gray;"><i><small>
<?php echo "(#".esc($albumId).")"; ?>
</small></i></span>
</h2>

<h3 style="color:#4d4d4d"><?php 
	$artistsName = "";
	$firstArtist = false;
	foreach($albumData["artist"] as $artist)
	{
		if($firstArtist == false)
		{
			$artistsName = $artist["name"];
			$firstArtist = true;
		}
		else
		{
			$artistsName = $artistsName.", ".$artist["name"];
		}
 	}
	
	$studiosName = "";
	$firstStudio = false;
	foreach($albumData["studio"] as $studio)
	{
		if($firstStudio == false)
		{
			$studiosName = $studio["name"];
			$firstStudio = true;
		}
		else
		{
			$studiosName = $studiosName.", ".$studio["name"];
		}
	}
	
	echo "<i>Por ".esc($artistsName)." - ".esc($albumData["album"]["year"])." (".esc($studiosName).")</i>";	
?></h3> 

<h4 style="color:#737373"><?php
	$genresName = "";
	$firstGenre = false;
	foreach($albumData["genre"] as $genre)
	{
		if($firstGenre == false)
		{
			$genresName = $genre["name"];
			$firstGenre = true;
		}
		else
		{
			$genresName = $genresName.", ".$genre["name"];
		}
 	}
	echo "Gêneros: ".esc($genresName);
?></h4>


<br>

<table class="albumtable">
	<tr>
		<th>Faixa</th>
		<th style="width:15%">Duração</th>
	</tr>
	<tr>
		<td><hr style="width:95%; margin: 0px"></td>
		<td><hr></td>	
	</tr>
	
	<?php $backcolor = "#ffffff"?>
	<?php foreach($albumData["music"] as $music) : ?>
		<tr>
			<td style="background-color:<?php echo $backcolor; ?>"><?php echo esc($music["name"]); ?></td>
			<td style="background-color:<?php echo $backcolor; ?>"><?php echo esc($music["duration"]); ?></td>
			<?php if($backcolor == "#ffffff"){$backcolor = "#e6e6e6";}else{$backcolor = "#ffffff";} ?>
		</tr>
		<!--<tr><td><hr style="width:95%; margin: 0px"></td><td><hr></td></tr>-->
	<?php endforeach; ?>
	
</table>

<hr>
<hr>

<h3>CRÍTICAS AO ÁLBUM: </h3>

<?php if(isset($albumReviews)) : ?>

	<?php foreach($albumReviews as $review) : ?>
	
		<div class="review">
			<strong>POR: <?php echo esc($review["username"]); ?></strong>
			<hr>
			<?php echo esc($review["wording"]); ?></h5>
		</div>
		<br>
	
	<?php endforeach; ?>

<?php else : ?>

	<h4>Ainda não há nenhuma crítica para este álbum.</h4>
	
<?php endif; ?>

</div>