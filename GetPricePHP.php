<?php
require_once( 'wp-load.php' );
$url='https://www.digikala.com/product/dkp-1959438';
	$args = array(
			'timeout' => $meta_vals['scrape_timeout'][0],
			'sslverify' => false,
			'user-agent' => get_option('scrape_user_agent')
		);
			$response = wp_remote_get($url, $args);
if (!isset($response->errors)) {

		//	write_log("Single scraping started: " . $url);
			$body = $response['body'];
			$body = trim($body);

			if (substr($body, 0, 3) == pack("CCC", 0xef, 0xbb, 0xbf)) {
				$body = substr($body, 3);
			}
}
        	$charset =detect_html_encoding_and_replace(wp_remote_retrieve_header($response, "Content-Type"), $body);
			$body_iconv = iconv($charset, "UTF-8//IGNORE", $body);
		unset($body);
			$body_preg = preg_replace(
				array(

				'/(<table([^>]+)?>([^<>]+)?)(?!<tbody([^>]+)?>)/',
				'/(<(?!(\/tbody))([^>]+)?>)(<\/table([^>]+)?>)/',
				"'<\s*script[^>]*[^/]>(.*?)<\s*/\s*script\s*>'is",
				"'<\s*script\s*>(.*?)<\s*/\s*script\s*>'is",
				"'<\s*noscript[^>]*[^/]>(.*?)<\s*/\s*noscript\s*>'is",
				"'<\s*noscript\s*>(.*?)<\s*/\s*noscript\s*>'is"

				), array(
				'$1<tbody>',
				'$1</tbody>$4',
				"",
				"",
				"",
				""), $body_iconv);
			unset($body_iconv);
			$doc = new DOMDocument;
			$body_preg = mb_convert_encoding($body_preg, 'HTML-ENTITIES', 'UTF-8');
			@$doc->loadHTML('<?xml encoding="utf-8" ?>' . $body_preg);
			$xpath = new DOMXPath($doc);
$query = '//html/body/main/div[2]/div[1]/div/article/section[1]/div[2]/div[2]/div/div[1]/div[1]/div[9]/div[2]/div';
$entries = $xpath->query($query);
foreach ($entries as $entry) {
    echo "price {$entry->nodeValue}";
}
	 function detect_html_encoding_and_replace($header, &$body) {
		$charset_regex = preg_match("/<meta(?!\s*(?:name|value)\s*=)(?:[^>]*?content\s*=[\s\"']*)?([^>]*?)[\s\"';]*charset\s*=[\s\"']*([^\s\"'\/>]*)[\s\"']*\/?>/i", $body, $matches);
		if (empty($header)) {
			$charset_header = false;
		} else {
			$charset_header = explode(";", $header);
			if (count($charset_header) == 2) {
				$charset_header = $charset_header[1];
				$charset_header = explode("=", $charset_header);
				$charset_header = strtolower(trim(trim($charset_header[1]), "\"''"));
				if ($charset_header == "utf8") {
					$charset_header = "utf-8";
				}
			} else {
				$charset_header = false;
			}
		}
		if ($charset_regex) {
			$charset_meta = strtolower($matches[2]);
			if ($charset_meta == "utf8") {
				$charset_meta = "utf-8";
			}
			if ($charset_meta != "utf-8") {
				$body = str_replace($matches[0], "<meta charset='utf-8'>", $body);
			}
		} else {
			$charset_meta = false;
		}

		$charset_php = strtolower(mb_detect_encoding($body, mb_list_encodings(), false));

		if ($charset_header && $charset_meta) {
			return $charset_header;

		}

		if (!$charset_header && !$charset_meta) {

			return $charset_php;
		} else {
			return !empty($charset_meta) ? $charset_meta : $charset_header;
		}

	}
	
	 function detect_feed_encoding_and_replace($header, &$body) {
	    $encoding_regex = preg_match("/encoding\s*=\s*[\"']([^\"']*)\s*[\"']/i", $body, $matches);
        if (empty($header)) {
            $charset_header = false;
        } else {
            $charset_header = explode(";", $header);
            if (count($charset_header) == 2) {
                $charset_header = $charset_header[1];
                $charset_header = explode("=", $charset_header);
                $charset_header = strtolower(trim($charset_header[1]));
            } else {
                $charset_header = false;
            }
        }
        if ($encoding_regex) {
            $charset_xml = strtolower($matches[1]);
            if ($charset_xml != "utf-8") {
                $body = str_replace($matches[1], 'utf-8', $body);
            }
        } else {
            $charset_xml = false;
        }

        $charset_php = strtolower(mb_detect_encoding($body, mb_list_encodings(), false));

        if ($charset_header && $charset_xml) {
            return $charset_header;
        }

        if (!$charset_header && !$charset_xml) {
            return $charset_php;
        } else {
            return !empty($charset_xml) ? $charset_xml : $charset_header;
        }
    }
?>