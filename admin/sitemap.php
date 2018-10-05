<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
	header("location:login.php");
	exit;
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
				<li><a href="/admin/">Home</a></li>									
				<li><a href="/admin/sitemap-maker.php">Sitemap Maker</a></li>
				<li class="active"><a href="/admin/sitemap.php">Sitemap List</a></li>
				<li><a href="/admin/ping.php">Ping Sitemap</a></li>
				
			</ul>
		</div>
		<div class="col-md-10 content">
    <div class="row custyle">
        <div class="table-responsive panel panel-primary filterable">
            <table class="table table-striped custab">
                <thead>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="#" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Nama File" disabled></th>
                        <th><input type="text" class="form-control" placeholder="URL Sitemap" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Path Sitemap" disabled></th>						
                    </tr>
                </thead>
                <tbody>
				<?php 
				$array = explode("\n", file_get_contents('../list.txt'));
                for( $i = 0; $i<count($array); $i++ ) {
					echo '<tr>
                        <td>'.$i.'</td>
                        <td>'.pathinfo($array[$i], PATHINFO_BASENAME).'</td>
                        <td>'.$array[$i].'</td>
                        <td>sitemap/'.pathinfo($array[$i], PATHINFO_BASENAME).'</td>
						</tr>';
                }				
				?>
                </tbody>
            </table>
        </div>
    </div>
		</div>
		<footer class="pull-left footer">
			<p class="col-md-12">
				<hr class="divider">
				Copyright &COPY; 2015 <a href="http://www.pingpong-labs.com">Gravitano</a>
			</p>
		</footer>
	</div>