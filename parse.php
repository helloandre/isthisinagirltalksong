var songs = {
<?php

$pages = array('Unstoppable', 'Secret Diary', 'Night Ripper', 'Feed The Animals', 'All Day');

foreach ($pages as $page){
	$html = file_get_contents("http://www.illegal-tracklist.net/Tracklists/".str_replace(" ", "", $page));
	$dom = new domDocument();
	$dom->loadHTML($html);
	$xpath = new DOMXpath($dom);
	$body = $xpath->query('//div[@id="wikitext"]/*');
	
	$previous = false;
	$songs = array();
	foreach ($body as $element){
		if ($previous && $previous->nodeName == 'h2' && $element->nodeName == 'ul'){
			foreach ($element->childNodes as $li){
				// the title and artist of the sample (with <a> tag's removed)
				echo "'".addslashes(trim(preg_replace(array('/<(.*)[^>]*>(.*)<\/\1>/i','/(\(?\d+:\d+\)? )+/'), '$2', $li->nodeValue), " -\n"))."':{";

				// the name of the girltalk song it's in
				preg_match('/\"([a-z0-9\-\'\, ]+)\"/i', $previous->nodeValue, $title_match);
				echo "'song':'".addslashes($title_match[0])."',";

				// album the girltalk song is on
				echo "'album':'".addslashes($page)."'";

				// sometimes the samples have start times, sometimes they dont
				if (preg_match('/(\d*:\d*)/', $li->nodeValue, $time_match)){
					echo ",'time':'".addslashes($time_match[0])."'";
				}
				
				// close up this dict
				echo "},\n";
			}
		}

		$previous = $element;
	}
}

?>
};