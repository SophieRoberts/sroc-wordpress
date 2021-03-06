
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">

		<?php wp_head(); ?>


	</head>
	<body <?php body_class(); ?>>

		<!-- wrapper -->
		<div class="wrapper">

			<!-- header -->
			<header class="header clear" role="banner">
        <div id='container'>
        	<?php if (has_post_thumbnail()) : ?>
            <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );?>
              <div class='background' style="background-image: url('<?php echo $thumb['0'];?>')"></div>
              <div class="header_title">
                <div class='title'>
                  <h1><?php the_title()?></h1>
                </div>
              </div>
          <?php else : ?>
            <div class='background'></div>
              <div class="header_title">
                <div class='title'>
                  <h1><?php the_title()?></h1>
                </div>
              </div>
        		<?php endif; ?>


					<!-- nav -->
					<nav class="nav" role="navigation">
            <?php sroc_nav(); ?>
					</nav>
					<!-- /nav -->

			</header>
			<!-- /header -->
