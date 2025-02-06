<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div>
		<!-- Header section -->
		<section id="header">
			<div class="max-container"> <!-- Header container-->

				<header>
					<nav>

						<div id="header-logo"> <!-- logo div -->
							<a href="#">Header Logo</a>
						</div> <!-- logo div end-->


						<div> <!-- Menu Links -->

							<li class="link-li"> <!-- Each van link li -->
								<a href="#">Link One</a>
							</li> <!-- Each van link li end-->

							<li class="link-li">
								<a href="#">Link Two</a>
							</li>
							<li class="link-li">
								<a href="#">Link Three</a>
							</li>

						</div><!-- Menu Links end -->

					</nav>
				</header>


				<div id="hero-sec" class="max-container"> <!-- hero section start-->

					<div id="hero-info"> <!-- Hero info-->

						<h2>This website is <br> awesome</h2>
						<p>This website has some subtext that goes under the main title. it's a smaller font and the
							colour
							is
							lower contrast.
						</p>
						<button>Sign Up</button>

					</div><!-- Hero info end-->

					<div id="hero-img"> <!-- Banner image div-->
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/box.png' ); ?>" alt="">
					</div> <!-- Banner image div-->

				</div> <!-- hero section end -->

			</div><!-- Header container end-->

		</section>
		<main>
			<!-- Main content -->
		</main>

	</div><!-- #primary -->
</body> <!-- end body -->


</html>