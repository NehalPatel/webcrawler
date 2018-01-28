<?php

//removes javscript and css from the HTML
function clean_html($html)
{
	$html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $html);
	$html = preg_replace('/<link \b[^>]*>(.*?)/is', "", $html);

	return $html;
}

//collect all the anchor tags from the HTML
function getURLs($html, $base_url)
{
	preg_match_all('~<a\s+.*?</a>~is',$html,$anchors);
	$urls = array();
	$parse = parse_url($base_url);

	//if no URL found on page, return blank array
	if(empty($anchors[0]))
		return $urls;

	//clean up each URLs
	foreach ($anchors[0] as $key => $link) {
		//get the HREF from the URL
		preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $link, $result);

		$url = $result['href'][0];
		$url = rel2abs($url, $base_url);

		if( clean_url($url, $parse['host']) )
		{
			$hash = generate_hash( $url );
			$urls[$hash]['url'] = $url;
			$urls[$hash]['title'] = '';
			$urls[$hash]['data'] = '';

			//get the TITLE from the URL
			preg_match_all('/<a[^>]+title=([\'"])(?<title>.+?)\1[^>]*>/i', $link, $title);

			if( !empty($title['title'][0]) )
			{
				$urls[$hash]['title'] = $title['title'][0];
			}
		}
	}
	return $urls;
}

//if any relative URL, convert to Absolute URL
function rel2abs($rel, $base)
{
    /* return if already absolute URL */
    if (parse_url($rel, PHP_URL_SCHEME) != '') return $rel;

    /* queries and anchors */
    if ($rel[0]=='#' || $rel[0]=='?') return $base.$rel;

    /* parse base URL and convert to local variables:
       $scheme, $host, $path */
    extract(parse_url($base));

    /* remove non-directory element from path */
    $path = preg_replace('#/[^/]*$#', '', $path);

    /* destroy path if relative url points to root */
    if ($rel[0] == '/') $path = '';

    /* dirty absolute URL */
    $abs = "$host$path/$rel";

    /* replace '//' or '/./' or '/foo/../' with '/' */
    $re = array('#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#');
    for($n=1; $n>0; $abs=preg_replace($re, '/', $abs, -1, $n)) {}

    /* absolute URL is ready! */
    return $scheme.'://'.$abs;
}

//validate URL and check originate to same BASE URL
function clean_url($url, $base_url)
{
	if(filter_var($url, FILTER_VALIDATE_URL) )
	{

		$parse = parse_url($url);
		if( !empty($parse['host']) &&  $parse['host'] == $base_url )
		{
			return true;
		}

		return false;
	}
}

function generate_hash($url)
{
	return md5( $url );
}


function save_html( $urls = array() )
{
	if( empty($urls))
		return false;

	foreach ($urls as $key => $link) {
		print_r($link);
	}
}


?>