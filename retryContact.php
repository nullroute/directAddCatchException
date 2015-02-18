<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script>
$.fn.extend({
    loadImg: function(url, timeout) {
        // init deferred object
        var defer = $.Deferred(),
            $img = this,
            img = $img.get(0),
            timer = null;

        // define load and error events BEFORE setting the src
        // otherwise IE might fire the event before listening to it
        $img.load(function(e) {
            var that = this;
            // defer this check in order to let IE catch the right image size
            window.setTimeout(function() {
                // make sure the width and height are > 0
                ((that.width > 0 && that.height > 0) ? 
                    defer.resolveWith : 
                    defer.rejectWith)($img);
            }, 1);
        }).error(function(e) {
            defer.rejectWith($img);
        });

        // start loading the image
        img.src = url;

        // check if it's already in the cache
        if (img.complete) {
            defer.resolveWith($img);
        } else if (0 !== timeout) {
            // add a timeout, by default 15 seconds
            timer = window.setTimeout(function() {
                defer.rejectWith($img);
            }, timeout || 15000);
        }

        // return the promise of the deferred object
        return defer.promise().always(function() {
            // stop the timeout timer
            window.clearTimeout(timer);
            timer = null;
            // unbind the load and error event
            this.off("load error");
        });
    }
});
</script>
<?php

$handle = fopen("contacts.txt", "r");
if ($handle) {
	$lineArray = array();
    while (($line = fgets($handle)) !== false) {
		$line = trim(preg_replace('/\s\s+/', ' ', $line));
		array_push($lineArray, $line);
        // process the line read.
	}
    fclose($handle);
} else {
    // error opening the file.
	echo "Error opening File";
} 

file_put_contents("contacts.txt", "");

foreach($lineArray as $line){
?>
<script>
var otherImage = $('<img />').loadImg("<?=$line?>").done(function() {
    $('body').append(this).append($('<span />').text(this.attr('src') + ' found!').css('color', 'green'));
}).fail(function(){
    $('body').append($('<p />').html(this.attr('src') + ' not found').css('color', 'red'));
		var data = new Array();
        $.ajax({
          url: 'http://www.yourdomain.com/retainContact.php',
          type: "GET",
          data: {request: "<?=$line?>"}
        }).done(function(data) {
				alert(data);
		});
});
</script>

<?php		
}
?>