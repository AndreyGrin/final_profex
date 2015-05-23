<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>404</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT.'/'; ?>css/cloud-admin.min.css" >
	
	<link href="<?php echo URL_ROOT.'/'; ?>css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- FONTS -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
</head>
<body id="not-found-bg">
	<div class="overlay"></div>
	<!-- PAGE -->
	<section id="page">
			<div class="row">
				<div class="col-md-12">
					<div class="divide-100"></div>
				</div>
			</div>
			<div class="row">
				<div class="container">
				<div class="col-md-12 not-found">
				   <div class="error">
					  404
				   </div>
				</div>
				<div class="col-md-5 not-found">
				   <div class="content">
					  <h3>Are you lost in the wild?</h3>
					  <p>
						 Sorry, but the page you're looking for has not been found<br />
						 Try checking the URL for errors, <a href="<?php echo URL_ROOT.'/'; ?>">goto home</a> or try to search below.
					  </p>
					  <form action="<?php echo URL_ROOT.'/'; ?>">
						 <div class="input-group">
							<input type="text" class="form-control" placeholder="search here...">
							<span class="input-group-btn">                   
								<button type="submit" class="btn btn-danger"><i class="fa fa-search"></i></button>
							</span>
						 </div>
					  </form>
				   </div>
				</div>
				</div>
			</div>
	</section>
	<!--/PAGE -->
</body>
</html>