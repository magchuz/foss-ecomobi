<?php 
session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
	header("location:login.php");
	exit;
}
error_reporting(0);
function text_to_strip($text) { return str_replace(" ", "-", seotext($text)); } function seotext($str) { $str = str_replace("(", "", $str); $str = str_replace(")", "", $str); $str = str_replace("&", "", $str); $str = str_replace(",", "", $str); $str = str_replace("]", "", $str); $str = str_replace(";", "", $str); $str = str_replace("[", "", $str); $str = str_replace("!", "", $str); $str = str_replace('"', '', $str); $str = str_replace("_", "", $str); $str = str_replace("/", "", $str); $str = str_replace("@", "", $str); $str = str_replace("$", "", $str); $str = str_replace("%", "", $str); $str = str_replace("^", "", $str); $str = str_replace("~", "", $str); $str = str_replace("*", "", $str); $str = str_replace("'", "", $str); $str = str_replace("|", "", $str); $str = str_replace("+", "", $str); $str = str_replace(":", "", $str); $str = str_replace("?", "", $str); $str = str_replace("#", "", $str); $str = str_replace(".", "", $str); $str = str_replace("}", "", $str); $str = str_replace("{", "", $str); $variable = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,é"); $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,e"); $i=0; foreach ($variable as $key=> $value) {
			$str = str_replace($value, $replace[$i], $str);
			$i++;
		}
		$str = implode('-',array_filter(explode('-',$str)));
		return strtolower($str);
	}
    $acak = mt_rand();			
	if($_POST['keyword']<>'' or $_POST['priority']<>'' or $_POST['url']<>'' or $_POST['changefreq']<>'')
	{
		$text = explode("\n", $_POST['keyword']);
		$content = '<?xml version="1.0" encoding="UTF-8"?>
		<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		foreach ($text as $key => $value) {
			$content .='<url>';
			$content .='<loc>'.$_POST['url'].rtrim(text_to_strip($value)).'</loc>';
			$content .='<lastmod>'.date("c").'</lastmod>';
			$content .='<changefreq>'.$_POST['changefreq'].'</changefreq>';
			$content .='<priority>'.$_POST['priority'].'</priority>';
			$content .='</url>';
		}
		$content .='</urlset>';
		$file = '../sitemap/sitemap-'.$acak.'.xml';
		$current = file_get_contents($file);
		file_put_contents($file, $content);
		
		$robots = '../robots.txt';
		$isi = file_get_contents($robots);
		$isi .= "Sitemap :".$_POST["url"]."sitemap/sitemap-$acak.xml\n";
		file_put_contents($robots, $isi);
		
		$list = '../list.txt';
		$listsi = file_get_contents($list);
		$listsi .= $_POST["url"]."sitemap/sitemap-$acak.xml\n";
		file_put_contents($list, $listsi);		
        echo $_POST["url"]."sitemap/sitemap-$acak.xml";		
		exit;
	}
	?>
<script>
window.close;
</script>