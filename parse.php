// built with parse.php<br>
songs:<br>
<?php

$pages = array('Unstoppable', 'Secret Diary', 'Night Ripper', 'Feed The Animals', 'All Day');

$songs = array();
$songs_count = 0;
foreach ($pages as $page){
	$html = file_get_contents("http://www.illegal-tracklist.net/Tracklists/".str_replace(" ", "", $page));
	$dom = new domDocument();
	$dom->loadHTML($html);
	$xpath = new DOMXpath($dom);
	$body = $xpath->query('//div[@id="wikitext"]/*');
	
	$previous = false;
	foreach ($body as $element){
		if ($previous && $previous->nodeName == 'h2' && $element->nodeName == 'ul'){
			// the name of the girltalk song it's in
			preg_match('/\"([a-z0-9\-\'\, \(\)\.]+)\"/i', $previous->nodeValue, $title_match);
			$song = $title_match[0];
			
			foreach ($element->childNodes as $li){
				// strip tags, any time data, split into artist - song (assumes no "space dash space" in artist name)
				list($artist, $sample) = explode(" - ", trim(preg_replace('/\d+:\d+/', '', strip_tags($li->nodeValue)), " -"), 2);
				
				$artist = str_replace(array('(', ')'), '', $artist);
				
				// we only care about what's inside the double quotes
				$sample = preg_replace('/\"(.*)\".*/', '$1', $sample);
				
				// sometimes songs are used more than once, this guarantees unique keys, and doesn't affect display
				// will we need more than 10000?
				$idx = trim(str_pad($songs_count, 5, "0", STR_PAD_LEFT) . " " . strtolower($artist . " " . $sample));
				
				$songs[$idx] = array(
					'sample' => trim($sample),
					'artist' => trim($artist),
					'song' => trim($song),
					'album' => $page
				);

				// sometimes the samples have start times, sometimes they dont
				// sometimes there is more than one time, but we only care about the first value
				if (preg_match('/(\d*:\d*)/', $li->nodeValue, $time_match)){
					// calculate seconds so we don't have to do it in js later
					list($minutes, $seconds) = explode(":", $time_match[0], 2);
					$songs[$idx]['seconds'] = ($minutes * 60) + $seconds;
					$songs[$idx]['time'] = $time_match[0];
				}
				
				$songs_count++;
			}
		}

		$previous = $element;
	}
}

echo nl2br(str_replace('},"', "},\n\"", json_encode($songs)));

?>