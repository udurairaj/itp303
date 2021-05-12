	<nav class="navbar navbar-expand-md navbar-custom navbar-dark">
		<div class="container-fluid">
			<img src="<?php if ($active_nav == "logout") { echo "../images/logo-grey.png"; } else { echo "images/logo-grey.png"; } ?>" width="45" alt="LOGO" class="d-inline-block align-middle mr-2">
			<a class="navbar-brand ps-4 fs-4" href="myrecipes.php">recipage</a>


			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent" aria-controls="navContent" aria-expanded="false">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navContent">
				<ul class="navbar-nav me-auto mb-md-0">
					<li class="nav-item">
						<a class="nav-link text-center <?php if($active_nav == "myrecipes") { echo "active "; } ?>" aria-current="page" href="myrecipes.php">my recipes</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-center <?php if($active_nav == "searching") { echo "active "; } ?>" aria-current="page" href="search-ing.php">search by ingredient</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-center <?php if($active_nav == "addcustom") { echo "active "; } ?>" aria-current="page" href="add_custom_form.php">add a recipe</a>
					</li>
				</ul>
				<ul class="navbar-nav ml-auto mb-md-0">
					<li class="nav-item text-end">
						<a class="nav-link text-center <?php if($active_nav == "logout") { echo "active "; } ?>" aria-current="page" href="login/logout.php">logout</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>