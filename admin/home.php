<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
	header("location:login.php");
	exit;
	}
if(!empty($_POST["nama"])){
$set = '../settings.json';
$setisi = '{
    "nama": "'.$_POST["nama"].'",
    "url": "'.$_POST["url"].'",
    "meta": "'.$_POST["meta"].'",
	"token": "'.$_POST["token"].'"

}';
file_put_contents($set, $setisi);
	}
$nama = "";
$url = "";
$meta = "";
$token = "";	
$set_isi = file_get_contents('../settings.json');
$set_array = json_decode($set_isi, true);	
if(!empty($set_array['nama'])){
$nama = $set_array['nama'];
$url = $set_array['url'];
$meta = $set_array['meta'];
$token = $set_array['token'];
	}
	?>
<title>Sitemap List</title>
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
				<li class="active"><a href="/admin/home.php">Home</a></li>			
				<li><a href="/admin/">Sitemap Maker</a></li>
				<li ><a href="/admin/sitemap.php">Sitemap List</a></li>
				<li><a href="/admin/ping.php">Ping Sitemap</a></li>				
			</ul>
		</div>
		<div class="col-md-10 content">
        <form action="" method="post">
		<h4>Nama Website</h4>
		<input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Website" value="<?php echo($nama); ?>" required>
		<h4>URL Website</h4>
		<input type="text" class="form-control" id="url" name="url" placeholder="URL Website" value="<?php echo($url); ?>" required>
		<h4>Spintax Meta Description</h4>
		<input type="text" class="form-control" id="meta" name="meta" placeholder="Spintax Meta Description" value="<?php echo($meta); ?>" required>
		<h4>Token EcoMobi</h4>
		<input type="text" class="form-control" id="token" name="token" placeholder="Token EcoMobi" value="<?php echo($token); ?>" required>		
		</br>
		<button class="btn btn-primary" type="submit" name="submit">Submit</button>
        </form>		
		</div>
		<footer class="pull-left footer">
			<p class="col-md-12">
				<hr class="divider">
				Copyright &COPY; 2015 <a href="http://www.pingpong-labs.com">Gravitano</a>
			</p>
		</footer>
	</div>