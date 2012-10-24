<?php

	include 'main.php';
	writeHeader('Imgur Subreddit Viewer');

	echo('<body style="background-color: #121211; color: #FFF"><center>');

	if(empty($_GET)||$_GET["r"]=='')
		$sub = 'earthporn';
	else $sub = $_GET["r"];//'earthporn';
	echo('<h1>'.$sub.'</h1>');
	echo('<h4>click an image to download it<br  />or mouseover for more details</h4>');
	$url = 'http://imgur.com/r/'.$sub;
	$str = file_get_contents($url);
	$start = strpos($str,'posts')+7;
	$stop = strrpos($str, "imagelist-loader");
	$str = substr($str,$start,$stop-$start);
	$ctr=0;
	$tok = strtok($str, "<");
	$links = array();
	while ($tok !== false) {
		if(strpos($tok, "i")==1) {
			$links[$ctr] = substr($tok,8,5);
			$ctr++;
			$tok = strtok("<");
			$tok = strtok("<");
			$links[$ctr] = substr($tok,strrpos($tok,'title')+7);
			$ctr++;
			$tok = strtok("<");
			$links[$ctr] = substr($tok,2);
			$ctr++;
		}
    	$tok = strtok("<");
	}
	$tempid = $links[0];
	$temptitle = $links[1];
	for($i=0;$i<sizeof($links)-1;$i++) {
		if(($i+1)%3==1) {
			$tempid=$links[$i];
		}
		else if(($i+1)%3==2) {
			$temptitle=$links[$i];
		}
		else if(($i+1)%3==0) {
			echo('<a href="http://imgur.com/download/'.$tempid.'/'.$temptitle.'"><img alt="" src="http://i.imgur.com/'.$tempid.'b.jpg" title="'.$temptitle.'   ('.$links[$i].')"  /></a>');
		}
	}
?>
</center>
</body>
</html>