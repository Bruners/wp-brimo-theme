<?php

/**
 * Displays panel below top menu
 *
 * @package WordPress
 * @subpackage brimo
 * @since 1.0
 * @version 1.0
 */


/**
 * Caching the body of a HTTP response
 * Licensed under WTFPL
 * @param $url string
 * @param $skip_cache bool
 * @return mixed $data | FALSE
 */

if ( ! function_exists( 'cache_url' ) ) :
	function cache_url($url, $skip_cache = FALSE) {
		// settings
		$cachetime = 86400; // 24 hours
		$where = "cache";
		if ( ! is_dir($where)) {
			mkdir($where);
		}

		$hash = md5($url);
		$file = "$where/$hash.cache";

		// check the bloody file.
		$mtime = 0;
		if (file_exists($file)) {
			$mtime = filemtime($file);
		}
		$filetimemod = $mtime + $cachetime;

		// if the renewal date is smaller than now, return true; else false (no need for update)
		if ($filetimemod < time() OR $skip_cache) {
			$ch = curl_init($url);
			curl_setopt_array($ch, array(
				CURLOPT_HEADER         => FALSE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_USERAGENT      => 'Googlebot/2.1 (+http://www.google.com/bot.html)',
				CURLOPT_FOLLOWLOCATION => TRUE,
				CURLOPT_MAXREDIRS      => 5,
				CURLOPT_CONNECTTIMEOUT => 15,
				CURLOPT_TIMEOUT        => 30,
			));
			$data = curl_exec($ch);
			curl_close($ch);

			// save the file if there's data
			if ($data AND ! $skip_cache) {
				file_put_contents($file, $data);
			}
		} else {
			$data = file_get_contents($file);
		}

		return $data;
	}
endif;

?>

	<div class="tidal-panel border-bottom">
		<div class="ticker-wrap">
			<div class="ticker">

				<div class="ticker__item ticker__copyright"><a href='https://www.kartverket.no/sehavniva/'><?php echo __('© Kartverket', 'rbf1982');?></a></div>
		        <?php

		            $lat = 66.9118833;
		            $lon = 13.6214626;
		            $fromtime = new DateTime('NOW');
		            $fromtime->modify('-1 day');
		            $fromtime->format("Y-m-d");

		            $totime = clone $fromtime;
		            $totime->modify('+4 day');

		            $tdtime = clone $fromtime;
		            $tdtime->format('d.m');

		            $feed = "https://api.sehavniva.no/tideapi.php?lat=".$lat."&lon=".$lon."&fromtime=".$fromtime->format("Y-m-d\T18:00:00P")."&totime=".$totime->format("Y-m-d\T00:00:00P")."&datatype=tab&refcode=cd&place=Reipå&file=&lang=nb&interval=10&dst=1&tzone=&tide_request=locationdata";

		            $dir = get_stylesheet_directory_uri() . "/img/";

		            libxml_use_internal_errors(TRUE);
		            try {
		                $xml = simplexml_load_string(cache_url($feed));

		                if ($xml != "") {
		                    foreach ($xml->locationdata->data->waterlevel as $level):
		                        $flag = $level['flag'];
		                        $time = DateTime::createFromFormat('Y-m-d\TH:i:s+P',$level['time'])->format('H:i');
		                        $datetime = DateTime::createFromFormat('Y-m-d\TH:i:s+P',$level['time'])->format('d.m');

		                        if ($tdtime != $datetime) {
		                        	echo "<a href='/tidevannstabell'>";
		                            echo "<div class='ticker__item ticker__time'><em>".$datetime."</em> &#x25BA;</div>";
		   							echo "</a>";
		                            $tdtime = $datetime;
		                        };
		                        $value = round($level['value']);
		                        echo "<a href='/tidevannstabell'>";
		                        echo "<div class='ticker__item'>",$time,"<img class='ticker__image ",$flag,"-tide' src='",$dir, $flag,"-tide.png' alt='",$flag,"-tide' height='25' width='25'>",$value," cm</div>";
		                        echo "</a>";
		                    endforeach;
		                };
		            } catch (Exception $e) {
		                echo "<div class='ticker__item'>" . __('Unable to load tide data', 'rbf1982') . "</div>";
		            }
		        ?>
		        <div class="ticker__item ticker__copyright"><a href='https://www.kartverket.no/sehavniva/'><?php echo __('© Kartverket', 'rbf1982');?></a></div>
			</div>
		</div>
	</div>
