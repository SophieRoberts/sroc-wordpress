<!--
Template Name: Home Page
-->

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
                <img src="/wp-content/themes/sroc_theme/img/logo.png" alt="logo">
                <div class='title'>
                  <h1>SROC - <em>Red Rose Orienteers</em></h1>
                  <h3>South Ribble Orienteering Club, England's first, Founded 1964</h3>
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

  <!-- <div class='nav_placeholder'>
  </div> -->    
	<main role="main">
    <div class='top'>
      <div id="events">
        <?php dynamic_sidebar( 'next_events' ); ?>
      </div>
      <div id='results'>
        <div>
          <h2>Recent Results</h2>
          <div id="resultList">
            <?php
              $args = array(
                'orderby' => 'date',
                'order' => 'desc',
                'post_type' => 'post',
                'posts_per_page' => 6
              );
              $recent_posts = get_posts($args);
              foreach ( $recent_posts as $recent_post ) :
                setup_postdata($recent_post);
                $cats = get_the_category($recent_post->ID);
                if ($cats[0]->name == "Results"){
                  ?>
                  <li class="post_content">
                    <a href="<?php echo get_the_permalink($recent_post->ID) ?>" class="post">
                      <?php echo $recent_post->post_title ?>
                    </a>
                    <date>
                      <?php echo get_the_time('j F Y', $recent_post->ID); ?>
                    </date>
                  </li>              
              <?php 
                  wp_reset_postdata();
                }
                endforeach;
              ?>
          </div>
        </div>
      </div>
    </div>
    <div class='posts'>
      <div class='left'>
        <div id='twitter'>
          <a class="twitter-timeline" data-width="310" data-height="834" data-link-color="#00B433" href="https://twitter.com/SROC_1964">Tweets by SROC_1964</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
      </div>
      <div class ='blog_posts'>
        <?php if (have_posts()): while (have_posts()) : the_post(); ?>
          <?php the_content(); ?>
        <section class="page latest">
          <div class="box">
            <ul class="recently">
            <?php
              $args = array(
                'orderby' => 'date',
                'order' => 'desc',
                'post_type' => 'post',
                'posts_per_page' => 8
              );
              $recent_posts = get_posts($args);
              foreach ( $recent_posts as $recent_post ) :
                setup_postdata($recent_post);
              ?>
                <li class="post_content">
                  <ul>
                    <li>
                      <date>
                        <?php echo get_the_time('l, j F Y', $recent_post->ID); ?>
                      </date>
                    </li>
                    <li class='post_title'>
                      <a href="<?php echo get_the_permalink($recent_post->ID) ?>" class="post">
                        <?php echo $recent_post->post_title ?>
                      </a>
                    </li>
                    <li>
                      <p class="excerpt">
                        <?php echo the_excerpt() ?>
                      </p>
                    </li>
                  </ul>
                </li>
              <?php 
                  wp_reset_postdata();
                endforeach;
              ?>
            </ul>
            <a href='http://sroc.dev/all-posts/'>All Posts &rarr;</a>
          </div>
        </section>
      </div>
      <div class='right'>
        <div id="weather">
          <script type="text/javascript"> moWWidgetParams="moAllowUserLocation:true~moBackgroundColour:white~moColourScheme:white~moDays:5~moDomain:www.metoffice.gov.uk~moFSSI:320301~moListStyle:vertical~moMapDisplay:none~moShowFeelsLike:true~moShowUV:true~moShowWind:true~moSpecificHeight:380~moSpecificWidth:310~moSpeedUnits:M~moStartupLanguage:en~moTemperatureUnits:C~moTextColour:black~moGridParams:weather,temperature,pop,wind,warnings~"; </script><script type="text/javascript" src="http://www.metoffice.gov.uk/public/pws/components/yoursite/loader.js"> </script></p>
        </div>
        <div id="strava">
          <iframe height='454' width='310' frameborder='0' allowtransparency='true' scrolling='no' src='https://www.strava.com/clubs/sroc/latest-rides/261474158679483a36cda97bea22308471d52123?show_rides=true'></iframe>
        </div>
      </div>
    </div>
      
    
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php the_content(); ?>
  </article>

  <?php endwhile; ?>

  <?php else: ?>


  <?php endif; ?>

  </main>

<?php get_footer(); ?>

