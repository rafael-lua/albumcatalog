<!DOCTYPE html>
<html>
<head>
	<title>Catalago de Álbuns Musicais</title>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- Para referência ao css, usar o link-tag: https://codeigniter.com/user_guide/helpers/html_helper.html -->
	<!-- <?php echo link_tag('css/style.css'); ?> -->
	<script src="js/scripts.js"></script>	 

	 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.0/css/bulma.min.css">
	 <script src="https://kit.fontawesome.com/14e494ac10.js" crossorigin="anonymous"></script>	 
</head>
	<body>
	<header>
		<nav class="navbar is-dark" role="navigation" aria-label="main navigation">
		<div class="container">
				<div class="navbar-brand">
					<p class="navbar-item mr-5">LOGOTIPO</p>

					<a id="burgerMain" role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarMain" onclick="navBurgerMain()">
						<span aria-hidden="true"></span>
						<span aria-hidden="true"></span>
						<span aria-hidden="true"></span>
					</a>
				</div>

				<div id="navbarMain" class="navbar-menu">
					<div class="navbar-start">
						<a class="navbar-item" href="<?php echo base_url(); ?>">
							Home
						</a>
					</div>
					<div class="navbar-end">
						<div class="navbar-item">
							<div class="buttons">
								<button class="button is-info">
									<strong>Sign up</strong>
								</button>
								<button class="button is-info is-light" onclick="loginModal()">
									Log in
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</nav>
	</header>