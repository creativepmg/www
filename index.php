<?php
function Title_radio(){
  $useragent  = "Mozilla (DNAS 2 Statuscheck)";
  $sc_host    = '198.100.152.234:8016';
  $sc_port    = '8016';
  $sc_user    = 'admin';
  $sc_pass    = 'phillip';
  $ch = curl_init($sc_host . '/admin.cgi');
  curl_setopt($ch, CURLOPT_PORT, $sc_port);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_TIMEOUT, 5);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  curl_setopt($ch, CURLOPT_USERPWD, $sc_user . ':' . $sc_pass);
  $output = curl_exec($ch);
  curl_close($ch);
  $output = str_replace(array("\n","\t","\r", "  "), " ", $output);
  preg_match("/<td width=100 nowrap><font class=default>Current Song: <\/font><\/td><td><font class=default><b>(.*?)<\/b><\/td>/", $output, $datos);
  return $datos[1];
}
?>
</html>
<head>
	<title></title>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
var sound = new Audio();
var act_volumen = 1;// varile glo

function playAudio(src) {
    sound.src = src;// URL DE MP3
    sound.load();
    sound.volume = act_volumen;//100%
    sound.addEventListener('canplay', function() {
    sound.play();// Autio Play
    });
  }


$(document).on('click','#play',function(){
sound.play();
return false;
});

$(document).on('click','#pause',function(){
sound.pause();
return false;
});


function volumen(){
$( "#volumen" ).slider({
      range: "max",
      min: 0,
      max: 100,
      value: 50,
      slide: function( event, ui ) {
      	sound.volume = ( ui.value/100 );
      	act_volumen = ( ui.value/100 );
      }
    });
}



/*

	$(document).on('click','.play, .pause',function(){
		if( $(this).attr('class') == 'play' ) {
			sound.play();
			$('.play').addClass('pause').removeClass('play');
		} else {
			sound.pause();
			$('.pause').addClass('play').removeClass('pause');
		}
	return false;
	});
*/
/*

*/ 


$( document ).ready(function() {

playAudio('http://198.100.152.234:8016/;');
volumen();

});
</script>
<style>

#volumen { width: 100px; height: 25px; background: red; position: relative; }
#volumen .ui-slider-range { height: 25px; width: 25%; }
#volumen .ui-slider-handle { position: absolute; width: 10px; height: 10px; background:#CCC; }


</style>
</head>
<body>

<a href="" id="play">Play</a> - <a href="" id="pause">Pause</a>

<div id="titulo">TEMA: <?php echo Title_radio(); ?> </div> 

<div id="volumen">volumen</div>

</body>
</html>