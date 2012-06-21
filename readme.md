## Is This In A Girl Talk Song?

There have been several occasions where I can think of a particular sample in a girl talk song, but can't remember where or which song it's in. This helps that predicament a bit. Fortunately, there are a plethora of decent-quality Girl Talk videos on YouTube, so generally when you search for a girl talk song with "girl talk < song name >" it is the first hit.

Test out this code running on [the demo page](http://helloandre.github.com/itiagts.html)

### Highlights

 * Up and down arrows control which song is highligthed
 * Enter plays the currently highlighted song
 * Escape clears the search box and current search
 * You can use a ?q=<query> to bookmark/link to searches

### Technical stuff

 * Pulled a complete list of samples from [this site](http://www.illegal-tracklist.net/Main/HomePage).
 * Parsed it with built-in DOM traversal/searching in php and generated the objects.js with parse.php. (please don't everybody spam their site with this script)
 * All searching done client-side (even works in mobile browsers!) by using [jQuery's each](http://api.jquery.com/jQuery.each/) method
 * Youtube api stuff done using their [Data API](http://code.google.com/apis/youtube/2.0/reference.html#Searching_for_videos)

#### License

None. Nada. Public domain, bitches. Do whatever you want however you want.