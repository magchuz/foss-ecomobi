<?php
error_reporting(0);
$q = str_replace("-"," ",$_GET["q"]);
if (empty($q)) {
$q = 'Mobil';	
}
//Settings
$set_get = file_get_contents('./settings.json');
$set = json_decode($set_get, true);

//Bukalapax
$bl_get = file_get_contents('https://api.bukalapak.com/v2/products.json?keywords='.rawurlencode($q));
$bl_array = json_decode($bl_get, true);

//Tokopedia
$tp_get = file_get_contents('https://ace.tokopedia.com/search/product/v3?scheme=https&device=desktop&related=true&_catalog_rows=0&catalog_rows=0&_rows=0&source=search&ob=23&st=product&rows=11&q='.rawurlencode($q).'&unique_id=32a89e84dc3a46c893ebce3626caaff5');
$tp_array = json_decode($tp_get, true);

//Shopeh

// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://shopee.co.id/api/v2/search_items/?by=relevancy&keyword=mobil&limit=10&newest=0&order=desc&page_type=search',
    CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36'

));
// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);
$sp_array = json_decode($resp, true);

//Excerpt
function getExcerpt($text, $numb)
{
    $text = strip_tags($text);
    if (strlen($text) > $numb) {
        $text = substr($text, 0, $numb);
        $text = substr($text, 0, strrpos($text, " "));
        $text = $text . '...';
    }
    return $text;
}

//Spintax 
class Spintax
{
    public function process($text)
    {
        return preg_replace_callback(
            '/\{(((?>[^\{\}]+)|(?R))*)\}/x',
            array($this, 'replace'),
            $text
        );
    }
    public function replace($text)
    {
        $text = $this->process($text[1]);
        $parts = explode('|', $text);
        return $parts[array_rand($parts)];
    }
}
//Meta Desc
$spintax = new Spintax();
$sepintax = $set['meta'];
$string = str_replace("[KEYWORD]",$q,$sepintax);
//Caching HTML

	// define the path and name of cached file
	$cachefile = './cache/'.$q.'.php';
	// define how long we want to keep the file in seconds. I set mine to 5 hours.
	$cachetime = 18000;
	// Check if the cached file is still fresh. If it is, serve it up and exit.
	if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
   	include($cachefile);
    	exit;
	}
	// if there is either no file OR the file to too old, render the page and capture the HTML.
	ob_start();
?>

<!DOCTYPE html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<html lang="id-ID" prefix="og:http://ogp.me/ns# fb:http://ogp.me/ns/fb#">
<meta charset="UTF-8">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="description" content="<?php echo(ucwords($spintax->process($string)))?>"/>
<meta name="keyword" content="Produk, daftar harga , perbandingan harga"/>
<link rel="canonical" href="<?php echo(strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://'.$_SERVER['HTTP_HOST'])?>"/>
<meta name="language" content="id" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo(strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://'.$_SERVER['HTTP_HOST'])?>" />
<meta property="og:image" content="/og_image.png" />
<meta property="og:image:width" content="640" />
<meta property="og:image:height" content="640" />
<!------ Meta TAG  ---------->
<title><?php echo(ucwords($q));?> - <?php echo($set['nama']); ?></title>
<script async='async' src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script async='async' src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script async='async' src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script async='async' src="script.js"></script>

<!------ Include the above in your HEAD tag ---------->
<?php echo $set['head']; ?>
</head>
<body>
<?php echo($set['body']);?>
<!-- A grey horizontal navbar that becomes vertical on small screens -->
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="./"><?php echo($set['nama']); ?></a>
</nav>
<div class="container">
    <br/>
	<div class="row justify-content-center">
                        <div class="col-12 col-md-10 col-lg-8">
                            <form class="card card-sm">
                                <div class="card-body row no-gutters align-items-center">
                                    <div class="col-auto">
                                    </div>
                                    <!--end of col-->
                                    <div class="col">
                                        <input id="query" class="form-control form-control-lg form-control-borderless" type="search" placeholder="Search topics or keywords">
                                    </div>
                                    <!--end of col-->
                                    <div class="col-auto">
                                        <button style="margin-left: 12px;" onclick= "Click()" id="search" class="btn btn-lg btn-success" type="button">Search</button>
                                    </div>
                                    <!--end of col-->
                                </div>
                            </form>
                        </div>
                        <!--end of col-->
                    </div>
</div>
<br>
<div class="container">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="./">Home</a></li>
    <li class="breadcrumb-item"><a href="./">Harga</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo(ucwords($q))?></li>
  </ol>
</nav>
<div class="row py-4">
<?php
foreach ($bl_array['products'] as $produk_bl) {
	echo '<div class="col-md-4">
	<figure class="card card-product">
		<div class="img-wrap">
<img class = "lazy" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="https://i'.mt_rand(0, 3).'.wp.com/'.str_replace( 'https://', '', $produk_bl['images'][0] ).'" alt="Gambar Untuk '.ucwords($produk_bl['name']).'"></div>
		<figcaption class="info-wrap">
				<h4 class="title">'.getExcerpt(ucwords($produk_bl['name']), 40).'</h4>
				<p class="desc">Produk ini Dijual Di : Bukalapak</p>
		</figcaption>
		<div class="bottom-wrap">
				<a href="https://go.ecotrackings.com/?token='.$set['token'].'&url='.rawurlencode($produk_bl['url']).'" class="btn btn-sm btn-primary float-right">Order Now</a>	
				<div class="price-wrap h5">
					<span class="price-new">Rp '.number_format($produk_bl['price'],0,',','.').'</span>
				</div> <!-- price-wrap.// -->
		</div> <!-- bottom-wrap.// -->
	</figure>
</div> <!-- col // -->';
    }	
    foreach ($tp_array['data']['products'] as $produk_tp) {   
	echo '<div class="col-md-4">
	<figure class="card card-product">
		<div class="img-wrap">
<img class = "lazy" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="https://i'.mt_rand(0, 3).'.wp.com/'.str_replace( 'https://', '', $produk_tp['image_url']).'" alt="Gambar Untuk '.ucwords($produk_tp['name']).'"></div>
		<figcaption class="info-wrap">
				<h4 class="title">'.getExcerpt(ucwords($produk_tp['name']), 40).'</h4>
				<p class="desc">Produk ini Dijual Di : Tokopedia</p>
		</figcaption>
		<div class="bottom-wrap">
				<a href="https://go.ecotrackings.com/?token='.$set['token'].'&url='.rawurlencode($produk_tp['url']).'" class="btn btn-sm btn-primary float-right">Order Now</a>	
				<div class="price-wrap h5">
					<span class="price-new">'.$produk_tp['price'].'</span>
				</div> <!-- price-wrap.// -->
		</div> <!-- bottom-wrap.// -->
	</figure>
</div> <!-- col // -->';
    }	
    foreach ($sp_array['items'] as $produk_sp) {   
$sp_adv = file_get_contents('https://shopee.co.id/api/v2/item/get?itemid='.$produk_sp['itemid'].'&shopid='.$produk_sp['shopid']);
$sp_advar = json_decode($sp_adv, true);
$sp_url = "https://shopee.co.id/" . preg_replace('/\s+/', '-',$sp_advar['item']['name']);
$sp_url = str_replace(array('[[',']]'),'',$sp_url) . "-i.".$sp_advar['item']['shopid'].".".$sp_advar['item']['itemid'];


        echo '<div class="col-md-4">
        <figure class="card card-product">
            <div class="img-wrap">
    <img class = "lazy" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="https://i'.mt_rand(0, 3).'.wp.com/cf.shopee.co.id/file/'.$sp_advar['item']['image'].'" alt="Gambar Untuk '.ucwords($sp_advar['item']['name']).'"></div>
            <figcaption class="info-wrap">
                    <h4 class="title">'.getExcerpt(ucwords($sp_advar['item']['name']), 40).'</h4>
                    <p class="desc">Produk ini Dijual Di : Shopee</p>
            </figcaption>
            <div class="bottom-wrap">
                    <a href="https://go.ecotrackings.com/?token='.$set['token'].'&url='.rawurlencode($sp_url).'" class="btn btn-sm btn-primary float-right">Order Now</a>	
                    <div class="price-wrap h5">
                        <span class="price-new">Rp '.number_format($sp_advar['item']['price_min'] / 100000,0,',','.').'</span>
                    </div> <!-- price-wrap.// -->
            </div> <!-- bottom-wrap.// -->
        </figure>
    </div> <!-- col // -->';
        }
?>
</div> <!-- row.// -->



</div> 
<!--container.//-->

<br><br><br>
<a href="#" class="ignielToTop"></a>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">

</body>
<?php
	// We're done! Save the cached content to a file
	$fp = fopen($cachefile, 'w');
	fwrite($fp, ob_get_contents());
	fclose($fp);
    ob_end_flush();
?>