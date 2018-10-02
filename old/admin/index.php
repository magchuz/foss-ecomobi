<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
	header("location:login.php");
	exit;
}
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<meta name="viewport" content="width=device-width, initial-scale=1">
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
				<li class="active"><a href="/admin/">Sitemap Maker</a></li>
				<li><a href="/admin/sitemap.php">Sitemap List</a></li>
				<li><a href="/admin/ping.php">Ping Sitemap</a></li>
				
			</ul>
		</div>
		<div class="col-md-10 content">

<title>XML Sitemap Generator</title>
<h2>Sitemap Creator Manual</h2>
 
<form method="post" action="file.php" target="_blank">
 
 
<tr>
 
<td>Url</td>
 
 
 <input class="form-control" type="text" name="url" size="80">
 
 </tr>
 
 
<tr>
 
<td>Priority</td>
 
 
 
 <input class="form-control" type="text" value="0.8" name="priority">
 
 </tr>
 
 
<tr>
 
<td>Change Frequently</td>
 
 
 <select class="form-control" name="changefreq">
<option value="always">always</option>
<option value="hourly">hourly</option>
<option value="daily" selected>daily</option>
<option value="weekly">weekly</option>
<option value="monthly">monthly</option>
<option value="yearly">yearly</option>
<option value="never">never</option>
 </select>
 
 </tr>
 
 
<tr>
 
<td>Keyword</td>
 
 
<textarea class="form-control" name="keyword" cols=50 rows=30></textarea>
 
 </tr>
 
 <br>
<tr>
<td colspan=2><button class="btn btn-primary" type="submit" name="submit">Submit</button></td>
</tr>
 
 
 </form>
 
		</div>
		<footer class="pull-left footer">
			<p class="col-md-12">
				<hr class="divider">
				Copyright &COPY; 2015 <a href="http://www.pingpong-labs.com">Gravitano</a>
			</p>
		</footer>
	</div>