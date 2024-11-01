<?php

/*xBooster Share Apis */

	function shareapi($network="none",$iconsize="32",$title="none",$icon="none",$nonce="",$post_id="0"){

		$thispage = current_url($_SERVER);

		if ( $network == "pinterest" ){

			$render = '<a href="javascript:selectPinImage()" class="xbooster_share" data-postid="'.$post_id.'" data-pin-do="buttonBookmark" data-do="share" data-nonce="' . $nonce . '" data-network="' . $network . '" ><img class="xboostericon '.$network.'" src="' . $icon  . '" style="width:'.$iconsize.'" alt="'. $title .'"></a>';


		} else if ( $network == "facebook" ) {
		//  href="https%3A%2F%2Fparse.com"

			$render = '<a  class="xbooster_share share_'.$network.'" href="https://www.facebook.com/sharer/sharer.php?u='.urlencode($thispage).'"  data-postid="'.$post_id.'"  data-do="share" data-nonce="' . $nonce . '" data-network="' . $network . '" ><img class="xboostericon '.$network.'" src="' . $icon  . '" style="width:'.$iconsize.'" alt="'. $title .'"></a>';

		} else if ( $network == "twitter" ) {
		//  href="https%3A%2F%2Fparse.com"

			$render = '<a  class="xbooster_share share_'.$network.'" href="http://twitter.com/share" data-do="share" data-nonce="' . $nonce . '" data-postid="'.$post_id.'"  data-network="' . $network . '" ><img class="xboostericon '.$network.'" src="' . $icon  . '" style="width:'.$iconsize.'" alt="'. $title .'"></a>';

		} else {

			$render = '<a  class="xbooster_share" data-pin-do="buttonBookmark" data-do="share" data-nonce="' . $nonce . '" data-postid="'.$post_id.'"  data-network="' . $network . '" ><img class="xboostericon '.$network.'" src="' . $icon  . '" style="width:'.$iconsize.'" alt="'. $title .'"></a>';

		}

		return $render;

	}



	function current_url($s)
	{
		$ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
		$sp = strtolower($s['SERVER_PROTOCOL']);
		$protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
		$port = $s['SERVER_PORT'];
		$port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
		$host = isset($s['HTTP_X_FORWARDED_HOST']) ? $s['HTTP_X_FORWARDED_HOST'] : isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : $s['SERVER_NAME'];
		return $protocol . '://' . $host . $port . $s['REQUEST_URI'];
	}