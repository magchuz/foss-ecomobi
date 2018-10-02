<?php
$token_ekomobi = "";
$q = str_replace("-"," ",$_GET["q"]);
if (empty($q)) {
$q = 'Mobil';	
}
//URL Encode Percent from php.com
function myUrlEncode($string) {
    $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
    $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
    return str_replace($entities, $replacements, urlencode($string));
}
//Bukalapax
$bl_get = file_get_contents('https://api.bukalapak.com/v2/products.json?keywords='.myUrlEncode($q));
$bl_array = json_decode($bl_get, true);
//Tokopedia
$tp_get = file_get_contents('https://ace.tokopedia.com/search/product/v3?scheme=https&device=desktop&related=true&_catalog_rows=0&catalog_rows=0&_rows=0&source=search&ob=23&st=product&rows=11&q='.myUrlEncode($q).'&unique_id=32a89e84dc3a46c893ebce3626caaff5');
$tp_array = json_decode($tp_get, true);
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
//Text to Rupiah
function rupiah($angka){
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
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
$string = '{jual|menjual} '.ucwords($q).' {dengan|bersama|dgn} {tarif|bayaran|biaya|harga} paling murah dan {gratis|free|cuma-cuma} {belanja|biaya|ongkos} {bingkis|kirim} ke {seluruhnya|semua|seluruh} Indonesia. {beli|bayar|belanja} '.ucwords($q).' via Bukalapak atau {lagi|berulang|juga|kembali|masih|pula|sedang|semula|serta|tambah|tengah|terus|pun} Tokopedia {dengan|bersama|dgn} {tiket|ticket|kupon|karcis} {diskon|potongan harga|discount|disc} {khusus|kusus|husus} {gratis|free|cuma-cuma} {ongkir|ongkos kirim} '.ucwords($q);
?>
<?php
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
<html lang="id-ID" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
<meta charset="UTF-8">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="description" content="<?php echo(ucwords($spintax->process($string)))?>"/>
<meta name="keyword" content="Produk, daftar harga , perbandingan harga"/>
<link rel="canonical" href="<?php echo(strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://'.$_SERVER['HTTP_HOST'])?>"/>
<meta name="language" content="id" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo(strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://'.$_SERVER['HTTP_HOST'])?>" />
<meta property="og:image" content="https://guestbackyard.com/assets/images/icon.png" />
<meta property="og:image:width" content="640" />
<meta property="og:image:height" content="640" />
<!------ Meta TAG  ---------->
<title><?php echo(ucwords($q))?> - Foss Ecomobi AGC</title>
<script async='async' src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script async='async' src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script async='async' src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
</head>
<body>
<!-- A grey horizontal navbar that becomes vertical on small screens -->
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="./">Foss Ecomobi AGC</a>
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
	for ($x = 0; $x <= 10; $x++) {	
	if (!empty($bl_array['products'][$x]['name'])) {
	echo '<div class="col-md-4">
	<figure class="card card-product">
		<div class="img-wrap">
<img class = "lazy" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="https://i'.mt_rand(0, 3).'.wp.com/'.str_replace( 'https://', '', $bl_array['products'][$x]['images'][0] ).'" alt="Gambar Untuk '.ucwords($bl_array['products'][$x]['name']).'"></div>
		<figcaption class="info-wrap">
				<h4 class="title">'.getExcerpt(ucwords($bl_array['products'][$x]['name']), 40).'</h4>
				<p class="desc">Produk ini Dijual Di : Bukalapak</p>
		</figcaption>
		<div class="bottom-wrap">
				<a href="http://go.ecotrackings.com/?token='.$token_ekomobi.'&url='.myUrlEncode($bl_array['products'][$x]['url']).'" class="btn btn-sm btn-primary float-right">Order Now</a>	
				<div class="price-wrap h5">
					<span class="price-new">'.rupiah($bl_array['products'][$x]['price']).'</span>
				</div> <!-- price-wrap.// -->
		</div> <!-- bottom-wrap.// -->
	</figure>
</div> <!-- col // -->';
	}	
	if (!empty($tp_array['data']['products'][$x]['name'])) {
	echo '<div class="col-md-4">
	<figure class="card card-product">
		<div class="img-wrap">
<img class = "lazy" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="https://i'.mt_rand(0, 3).'.wp.com/'.str_replace( 'https://', '', $tp_array['data']['products'][$x]['image_url']).'" alt="Gambar Untuk '.ucwords($tp_array['data']['products'][$x]['name']).'"></div>
		<figcaption class="info-wrap">
				<h4 class="title">'.getExcerpt(ucwords($tp_array['data']['products'][$x]['name']), 40).'</h4>
				<p class="desc">Produk ini Dijual Di : Tokopedia</p>
		</figcaption>
		<div class="bottom-wrap">
				<a href="http://go.ecotrackings.com/?token=jtOD4qKnccctQrsDPZPbd&url='.myUrlEncode($tp_array['data']['products'][$x]['url']).'" class="btn btn-sm btn-primary float-right">Order Now</a>	
				<div class="price-wrap h5">
					<span class="price-new">'.$tp_array['data']['products'][$x]['price'].'</span>
				</div> <!-- price-wrap.// -->
		</div> <!-- bottom-wrap.// -->
	</figure>
</div> <!-- col // -->';
	}		
	}
?>
</div> <!-- row.// -->



</div> 
<!--container.//-->

<br><br><br>
<script>
function Click() {
   var spasi = document.getElementById("query").value.replace(/\s+$/, '');	
   var replaced = spasi.replace(/ /g, '-');

    location.href = './'+replaced;
}
// Get the input field
var input = document.getElementById("query");

// Execute a function when the user releases a key on the keyboard
input.addEventListener("keyup", function(event) {
  // Cancel the default action, if needed
  event.preventDefault();
  // Number 13 is the "Enter" key on the keyboard
  if (event.keyCode === 13) {
    // Trigger the button element with a click
    document.getElementById("search").click();
  }
});
</script>
<script type='text/javascript'>//<![CDATA[
function ignielLazyLoad(){eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('u B(){Y(v e=o.1r("B"),t=0;t<e.1q;t++)Q(e[t])&&(e[t].N=e[t].1p("1n-N"))}u Q(e){v t=e.1t();Z t.1x>=0&&t.1w>=0&&t.1v<=(y.1u||o.T.1m)&&t.1k<=(y.1c||o.T.1b)}v b=["\\r\\m\\m\\D\\G\\a\\f\\c\\M\\n\\p\\c\\a\\f\\a\\k","\\h\\f","\\r\\c\\c\\r\\l\\A\\D\\G\\a\\f\\c","\\g\\h\\r\\m","\\p\\l\\k\\h\\g\\g","\\V\\1a\\1e\\R\\h\\f\\c\\a\\f\\c\\M\\h\\r\\m\\a\\m","\\w\\p\\a\\1l\\p\\c\\k\\n\\l\\c","\\r","\\1f\\w\\a\\k\\L\\1j\\a\\g\\a\\l\\c\\h\\k\\W\\g\\g","\\g\\a\\f\\q\\c\\A","\\w\\p\\a\\k\\W\\q\\a\\f\\c","\\c\\a\\p\\c","\\m\\h\\l\\w\\F\\a\\f\\c\\D\\g\\a\\F\\a\\f\\c","\\1i\\h\\m\\L","\\l\\g\\n\\l\\1g","\\p\\l\\k\\h\\g\\g\\1h\\h\\J","\\c\\h\\J","\\q\\a\\c\\S\\h\\w\\f\\m\\n\\f\\q\\R\\g\\n\\a\\f\\c\\1z\\a\\l\\c","\\A\\k\\a\\X","\\a\\1y\\a\\l","\\q\\a\\c\\D\\g\\a\\F\\a\\f\\c\\S\\L\\1F\\m","\\p\\l\\k\\h\\g\\g\\U\\a\\n\\q\\A\\c","\\n\\f\\f\\a\\k\\U\\a\\n\\q\\A\\c","\\J\\k\\a\\G\\a\\f\\c\\V\\a\\X\\r\\w\\g\\c","\\n\\c\\a\\F"];u I(d,j){y[b[0]]?y[b[0]](d,j):y[b[2]](b[1]+d,j)}I(b[3],B),I(b[4],B),o[b[0]](b[5],u(){b[6];Y(v d=o[b[8]](b[7]),j=d[b[9]],s=/1D|1B/i[b[11]](1G[b[10]])?o[b[12]]:o[b[13]],C=u(d,j,s,C){Z(d/=C/2)<1?s/2*d*d*d+j:s/2*((d-=2)*d*d+2)+j};j--;){d[b[1C]](j)[b[0]](b[14],u(d){v j,E=s[b[15]],x=o[b[1A]](/[^#]+$/[b[19]](1H[b[18]])[0])[b[17]]()[b[16]],z=s[b[1d]]-y[b[1s]],O=z>E+x?x:z-E,K=1o,H=u(d){j=j||d;v x=d-j,z=C(x,E,O,K);s[b[15]]=z,K>x&&P(H)};P(H),d[b[1E]]()})}});',62,106,'||||||||||x65|_0x1b5d|x74|_0xdd48x2||x6E|x6C|x6F||_0xdd48x3|x72|x63|x64|x69|document|x73|x67|x61|_0xdd48x4||function|var|x75|_0xdd48x7|window|_0xdd48x8|x68|lazy|_0xdd48x5|x45|_0xdd48x6|x6D|x76|_0xdd48xb|registerListener|x70|_0xdd48xa|x79|x4C|src|_0xdd48x9|requestAnimationFrame|isInViewport|x43|x42|documentElement|x48|x44|x41|x66|for|return|||||||||||x4F|clientWidth|innerWidth|21|x4D|x71|x6B|x54|x62|x53|left|x20|clientHeight|data|900|getAttribute|length|getElementsByClassName|22|getBoundingClientRect|innerHeight|top|right|bottom|x78|x52|20|trident|24|firefox|23|x49|navigator|this'.split('|'),0,{}));} eval(function(p,a,c,k,e,d){e=function(c){return c.toString(36)};if(!''.replace(/^/,String)){while(c--){d[c.toString(a)]=k[c]||c.toString(a)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('j 4=["\\7\\9\\9\\e\\d\\a\\b\\8\\i\\g\\h\\8\\a\\b\\a\\k","\\f\\c\\7\\9","\\7\\8\\8\\7\\m\\l\\e\\d\\a\\b\\8","\\c\\b\\f\\c\\7\\9"];5[4[0]]?5[4[0]](4[1],6,!1):5[4[2]]?5[4[2]](4[1],6):5[4[3]]=6;5[4[0]]?5[4[0]](4[1],6,!1):5[4[2]]?5[4[2]](4[1],6):5[4[3]]=6;',23,23,'||||_0xdfb4|window|ignielLazyLoad|x61|x74|x64|x65|x6E|x6F|x76|x45|x6C|x69|x73|x4C|var|x72|x68|x63'.split('|'),0,{}));
//]]></script>
<a href="#" class="ignielToTop"></a>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<style>
.card-product .img-wrap {
    border-radius: 3px 3px 0 0;
    overflow: hidden;
    position: relative;
    height: 220px;
    text-align: center;
}
.card-product .img-wrap img {
    max-height: 100%;
    max-width: 100%;
    object-fit: cover;
}
.card-product .info-wrap {
    overflow: hidden;
    padding: 15px;
    border-top: 1px solid #eee;
}
.card-product .bottom-wrap {
    padding: 15px;
    border-top: 1px solid #eee;
}

.label-rating { margin-right:10px;
    color: #333;
    display: inline-block;
    vertical-align: middle;
}

.card-product .price-old {
    color: #999;
}
/* Back to Top Pure CSS by igniel.com */
html {scroll-behavior:smooth;}
.ignielToTop {width:50px; height:50px; position:fixed; bottom:50px; right: 50px; z-index:99; cursor:pointer; border-radius:100px; transition:all .5s; background:#008c5f url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7.41,15.41L12,10.83L16.59,15.41L18,14L12,8L6,14L7.41,15.41Z' fill='%23fff'/%3E%3C/svg%3E") no-repeat center center;}
.ignielToTop:hover {background:#1d2129 url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7.41,15.41L12,10.83L16.59,15.41L18,14L12,8L6,14L7.41,15.41Z' fill='%23fff'/%3E%3C/svg%3E") no-repeat center center;}
</style>
</body>
<?php
	// We're done! Save the cached content to a file
	$fp = fopen($cachefile, 'w');
	fwrite($fp, ob_get_contents());
	fclose($fp);
	// finally send browser output
	ob_end_flush();
?>
