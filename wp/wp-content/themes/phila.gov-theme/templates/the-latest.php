<?php
/**
 * Template Name: The latest
 * Description: Custom Page template for The Latest
 * @package phila-gov
 */

  get_header();
?>

<div id="primary" class="the-latest content-area">
  <main id="main" class="site-main">
    <header>
      <div class="grid-container">
        <?php the_title( '<h1 class="contrast">', '</h1>' );  ?>
      </div>
      <div data-sticky-container class="bg-white">
        <nav class="sticky sticky--in-page center bg-white menu" data-sticky data-top-anchor="global-sticky-nav:bottom" style="width:100%" data-sticky-on="medium">
          <div class="grid-container">
            <ul class="inline-list grid-x man" data-magellan data-options="offset: 106; deepLinking: true;">
              <li class="featured cell medium-auto small-24">
                <a href="#featured">
                  <i class="fa fa-fw fa-3x fa-newspaper-o" aria-hidden="true"></i>
                  <div>Featured</div>
                </a>
              </li>
              <li class="announcement cell medium-auto small-24">
                <a href="#announcements">
                  <i class="fa fa-fw fa-3x fa-bullhorn" aria-hidden="true"></i>
                  <div>Announcements</div>
                </a>
              </li>
              <li class="post cell medium-auto small-24">
                <a href="#posts">
                  <i class="fa fa-fw fa-3x fa-pencil" aria-hidden="true"></i>
                  <div>Posts</div>
                </a>
              </li>
              <li class="event cell medium-auto small-24">
                <a href="#events">
                  <i class="fa fa-fw fa-3x fa-calendar-check-o" aria-hidden="true"></i>
                  <div>Events</div>
                </a>
              </li>
              <li class="press_release cell medium-auto small-24">
                <a href="#press-releases">
                  <i class="fa fa-fw fa-3x fa-file-text-o" aria-hidden="true"></i>
                <div>Press releases</div>
              </a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </header>
    <div id="featured" data-magellan-target="featured">
      <header class="row columns mtl">
        <h2>Featured</h2>
      </header>
      <?php get_template_part('partials/posts/featured', 'grid'); ?>
    </div>

    <div id="announcements" data-magellan-target="announcements">
      <header class="row columns mtl">
        <h2>Announcements</h2>
      </header>
      <?php get_template_part('partials/posts/announcements', 'grid'); ?>
    </div>

    <div id="posts" data-magellan-target="posts">
      <header class="row columns mtl">
        <h2>The latest from departments</h2>
      </header>
      <?php get_template_part('partials/posts/post', 'grid'); ?>
    </div>

    <div id="events" data-magellan-target="events">
      <header class="row columns mtl">
        <h2>Upcoming events</h2>
      </header>
      <div class="grid-container">
        <div class="grid-x">
          <div class="cell small-24">
            <?php echo do_shortcode('[calendar id="28661"]')?>
          </div>
        </div>
      </div>
    </div>

    <div id="press-releases" data-magellan-target="press-releases">
      <header class="row columns mtl">
        <h2>Press Releases</h2>
      </header>
      <?php get_template_part('partials/posts/press-release', 'grid'); ?>
    </div>

  </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>