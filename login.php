<?$timea=microtime();?>
<?php
	$pa="sdfasdfascamofneio234caz";
	if($_POST)
	{
		session_start();
		$username=htmlspecialchars($_POST['username']);
		$passwd=$_POST['passwd'];
		if($username!=="catofes")
		{
			header("Location:login.php?status=error");
			exit(0);
		}	
		if($passwd!=="301415GHZ")
		{
			header("Location:login.php?status=error");
			exit(0);
		}
		$cookie=substr(MD5($username.$pa.microtime()),16);
		setcookie($username,$cookie,time()+3600,"/");
		$_SESSION['username'] = $username;
		$_SESSION['cookie']=$cookie;
		header("Location: admin.php");// Set-Cookie: ".$username.$cookie.";expires=".gmstrftime("%A, %d-%b-%Y %H:%M:%S GMT", time() + (600))."; path=/; domain=catofes.com"); 
		exit(0);
	}
?>
	
<!DOCTYPE html>
<html>
	<head>
		<title>登录 新番</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link href="dist/css/bootstrap.css" rel="stylesheet">
		<link href="css/login.css" rel="stylesheet">
	</head>
	<body>
		<div class="navbar navbar-inverse navbar-static-top">
			<div class="container">
				<div class="navbar-header">
					<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="#" class="navbar-brand">新番</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li><a href="index.php">四月新番</a></li>
						<li><a href="list.php">文件列表</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row row-offcanvas row-offcanvas-right">
				<div class="col-xs-12 col-sm-9">
					<p class="pull-right visible-xs">
						<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">下拉菜单</button>
					</p>
				</div>
			</div>
		</div>
		<div class="container">
			<?if($_GET['status']==="error") echo "<div class=\"alert alert-danger\">用户名密码错误</div>";?>
			<form class="form-signin" method="post" action="login.php" onSubmit="return this" >
				<h2 class="form-signin-heading">登录</h2>
				<input type="text" id=username" name="username" class="form-control" placeholder="Username" required="" autofocus="" autocomplete="off">
				<input type="password"id="passwd" name="passwd" class="form-control" placeholder="Password" required="">
				<label class="checkbox">
					<input type="checkbox" value="remember-me"> 记住我
				</label>
				<button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
			</form>
		</div>
        <div class="footer">
			<div class="container">
				<p class="text-muted credit">
				Provide by
				<a href="about.php">Catofes</a>
				.Generate time:
				<? echo $timeb=microtime()-$timea;?>
				s  
				</p>
			</div>
		</div>
		<script src="dist/js/bootstrap.min.js"></script>
	</body>
</html>


