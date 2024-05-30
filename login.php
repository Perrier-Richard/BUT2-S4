<!DOCTYPE html>
<html lang="en">
<head>
	<title>Log in</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="module" src="Client/login.js" defer></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
	<link href="CSS/login.css" rel="stylesheet"/>
	<link href="CSS/header.css" rel="stylesheet"/>
	<link href="CSS/main.css" rel="stylesheet"/>
	<link href="CSS/footer.css" rel="stylesheet"/>
</head>
<body>
	<header>
        <?php include("header.html"); ?>
    </header>
	<main>
		<section id="central">
			<div id="login-box" class="section-box">
				<form id="login-form">

						<span id="login-form-title">
							Log in
						</span>

						<div class="input-div">
							<input type="text" name="username" placeholder="Username">
							<span class="input-focus" data-placeholder="&#xf207;"></span>
						</div>

						<div class="input-div">
							<input type="password" name="password" placeholder="Password">
							<span class="input-focus" data-placeholder="&#xf191;"></span>
						</div>

						<div id="div-button">
							<button id="login-button">
								Login
							</button>
						</div>

				</form>
			</div>
		</section>
	</main>
	<footer>
        <?php include("footer.html"); ?>
    </footer>
</body>
</html>