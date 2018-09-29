<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
	header("location:login.php");
	exit;
}
?>
<?php
/*
* Sitemap Submitter
* Use this script to submit your site maps automatically to Google, Bing.MSN and Ask
* Trigger this script on a schedule of your choosing or after your site map gets updated.
*/

//Set this to be your site map URL
$sitemapUrl = "http://www.example.com/sitemap.xml";

// cUrl handler to ping the Sitemap submission URLs for Search Engines…
function myCurl($url){
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  return $httpCode;
}

function gugel($alamat){
	//Google
$url = "http://www.google.com/webmasters/sitemaps/ping?sitemap=".$alamat;
$returnCode = myCurl($url);
echo "<p>Google Sitemaps has been pinged (return code: $returnCode).</p>";
}

function bing ($alamat){
	//Bing / MSN
$url = "http://www.bing.com/ping?siteMap=".$alamat;
$returnCode = myCurl($url);
echo "<p>Bing / MSN Sitemaps has been pinged (return code: $returnCode).</p>";
}

function ask ($alamat) {
	//ASK
$url = "http://submissions.ask.com/ping?sitemap=".$alamat;
$returnCode = myCurl($url);
echo "<p>ASK.com Sitemaps has been pinged (return code: $returnCode).</p>";
}

if (!empty($_POST["url"])) {
gugel($_POST["url"]);
bing($_POST["url"]);
ask($_POST["url"]);
}

?>
<title>Sitemap Pinger</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<nav class="navbar navbar-default navbar-static-top">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">
				FOSS EcoMobi AGC Admin Panel
			</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">			
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
	<div class="container-fluid main-container">
		<div class="col-md-2 sidebar">
			<ul class="nav nav-pills nav-stacked">
				<li><a href="/admin/">Sitemap Maker</a></li>
				<li ><a href="/admin/sitemap.php">Sitemap List</a></li>
				<li class="active"><a href="/admin/ping.php">Ping Sitemap</a></li>
				
			</ul>
		</div>
		<div class="col-md-10 content">
    <section>
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
    	 <div class="well">
             <form action="ping.php" method="post">
              <div class="input-group">
                 <input class="btn btn-lg" name="url" id="url" type="text" placeholder="Sitemap URL" required>
                 <button class="btn btn-info btn-lg" type="submit">Submit</button>
              </div>
             </form>
    	 </div>
		</div>
	</div>
</div>
</section>
		</div>
		<footer class="pull-left footer">
			<p class="col-md-12">
				<hr class="divider">
				Copyright &COPY; 2015 <a href="http://www.pingpong-labs.com">Gravitano</a>
			</p>
		</footer>
	</div>
	<style>
	section {
    padding: 100px 0;
    text-align: center;
}
select.frecuency {
    border: none;
    font-style: italic;
    background-color: transparent;
    cursor: pointer;
    -webkit-transform: translateY(0);
    transform: translateY(0);
    -webkit-transition: -webkit-transform .35s ease-in;
    transition: -webkit-transform .35s ease-in;
    border-bottom: none;
}
select.frecuency:focus {
    outline: none;
    border-bottom: 5px solid #39b3d7;
    -webkit-transform: translateY(-5px);
    transform: translateY(-5px);
    -webkit-transition: -webkit-transform .35s ease-in;
    transition: -webkit-transform .35s ease-in;
}
.free {
    text-transform: uppercase;
}
.input-group {
    margin: 20px auto;
    width: 100%;
}
input.btn.btn-lg,
input.btn.btn-lg:focus {
    outline: none;
    width: 60%;
    height: 60px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}
button.btn {
    width: 40%;
    height: 60px;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}
.promise {
    color: #999;
}
	</style>