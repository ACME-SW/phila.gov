<?php
/**
 * The template for displaying the front page.
 *
 * @package phila-gov
 */

get_header(); ?>

<div id="primary" class="content-area">
  <main id="main" class="site-main home">
    <div class="hero-content">
      <div class="row">
        <section class="medium-13 small-centered columns">
          <div class="row collapse call-to-action bg-white pvs">
            <div class="small-6 phs columns">
              <a href="" class="phs">
                <div class="pam bg-ben-franklin-light">
                  <i class="fa fa-trash fa-4x"></i>
                  <p>Find <span class="break-before">trash day</span></p>
                </div>
              </a>
              </div>
              <div class="small-6 columns">
                <a href="https://secure.phila.gov/PaymentCenter/AccountLookup/" class="prs">
                  <div class="pam bg-ben-franklin-light">
                    <i class="fa fa-credit-card fa-4x"></i>
                    <p>Pay <span class="break-before">a bill</span></p>
                  </div>
                </a>
              </div>
              <div class="small-6 columns">
                <a href="http://www.phila.gov/personnel/JobOpps.html" class="prs">
                  <div class="pam bg-ben-franklin-light">
                    <i class="fa fa-briefcase fa-4x"></i>
                    <p>Explore <span class="break-before">jobs</span></p>
                  </div>
                </a>
              </div>
              <div class="small-6 columns ">
                <a href="/property" class="prs">
                  <div class="pam bg-ben-franklin-light">
                    <i class="fa fa-home fa-4x"></i>
                    <p>Search for a <span class="break-before">property</span></p>
                  </div>
                </a>
            </div>
          </div><!--#popular -->
        </section>
      </div>
    </div>

    <?php $args = array( 'post_type' => 'service_updates' ); ?>
    <?php $service_updates_loop = new WP_Query( $args ); ?>
    <?php include( locate_template( 'partials/content-service-updates.php' ) ); ?>
    <?php wp_reset_query();?>

    <div class="news-row row expanded">
      <div class="columns">
        <div class="row">
          <div class="columns">
            <h2 class="contrast"><?php printf( __( 'News' ) ) ?> </h2>
          </div>
        </div>
          <div class="row equal-height">
            <?php
              $args = array(
                'post_type' => array ('news_post'),
                'posts_per_page'    => 3,
                'meta_key'          => 'phila_show_on_home',
                //only show if "yes" is selected
                'meta_value'     => '1'
              );
              $news_query = new WP_Query( $args );
              if ( $news_query->have_posts() ) : while ( $news_query->have_posts() ) : $news_query->the_post(); ?>

              <div class="small-24 medium-8 columns">
                <?php phila_get_home_news(); ?>
              </div>
              <?php endwhile; ?>

              <?php else : ?>
                  <div class="alert">No recent news.</div>
              <?php endif; ?>

        </div><!-- .row -->
      </div><!-- .home-news -->
    </div>

   <section>
      <div class="row">
        <div class="columns">
          <h2>Neighborhood resources</h2>
        </div>
      </div>
      <div class="neighborhood-resources row expanded">

          <div class="row phl equal-height">

              <div class="small-12 medium-6 columns mvl-mu sidewalk bdr-right nbdr-right-mu  bdr-bottom-sm ">
                <a href="http://www.freelibrary.org/" class="action-panel">
                  <div class="panel equal" data-equalizer-watch="" >
                    <header class="">
                      <div class="icon">
                        <span><i class="fa fa-book fa-5x" aria-hidden="true"></i></span>
                      </div>
                      <span class="external">Free Libraries</span>
                    </header>
                  </div>
                </a>
              </div>

              <div class="small-12 medium-6 columns mvl-mu sidewalk bdr-bottom-sm">
                <a href="http://gsg.phila.gov/map#id=e7d139e404dd4fdaac4ae0bbaf637f79" class="action-panel">
                  <div class="panel equal" data-equalizer-watch="" >
                    <header class="">
                      <div class="icon">
                        <span><i class="fa fa-tree fa-5x" aria-hidden="true"></i></span>
                      </div>
                      <span class="external">Parks</span>
                    </header>
                  </div>
                </a>
              </div>

              <div class="small-12 medium-6 columns mvl-mu sidewalk bdr-right nbdr-right-mu  bdr-bottom-sm">
                <a href="http://www.phila.gov/parksandrecreation/findafacility/" class="action-panel">
                  <div class="panel equal" data-equalizer-watch="" >
                    <header class="">
                      <div class="icon">
                        <span><i class="fa fa-paint-brush fa-5x" aria-hidden="true"></i></span>
                      </div>
                      <span class="external">Recreation Centers</span>
                    </header>
                  </div>
                </a>
              </div>

              <div class="small-12 medium-6 columns mvl-mu sidewalk bdr-bottom-sm">
                <a href="https://www.phillykeyspots.org/keyspot-finder" class="action-panel">
                  <div class="panel equal" data-equalizer-watch="" >
                    <header class="">
                      <div class="icon">
                        <span><i class="fa fa-wifi fa-5x" aria-hidden="true"></i></span>
                      </div>
                      <span class="external">Free Internet Access</span>
                    </header>
                  </div>
                </a>
              </div>

              <div class="small-12 medium-6 columns mvl-mu sidewalk bdr-right nbdr-right-mu  bdr-bottom-sm">
                <a href="http://gsg.phila.gov/map#id=aa5f6f59d35c45e9bc089b400694f43a" class="action-panel">
                  <div class="panel equal" data-equalizer-watch="" >
                    <header class="">
                      <div class="icon">
                        <span><i class="fa fa-soccer-ball-o fa-5x" aria-hidden="true"></i></span>
                      </div>
                      <span class="external">Playgrounds</span>
                    </header>
                  </div>
                </a>
              </div>

              <div class="small-12 medium-6 columns mvl-mu sidewalk bdr-bottom-sm">
                <a href="/city-health-centers/" class="action-panel">
                  <div class="panel equal" data-equalizer-watch="" >
                    <header class="">
                      <div class="icon">
                        <span><i class="fa fa-heartbeat fa-5x" aria-hidden="true"></i></span>
                      </div>
                      <span class="">Health Centers</span>
                    </header>
                  </div>
                </a>
              </div>

              <div class="small-12 medium-6 columns mvl-mu sidewalk bdr-right nbdr-right-mu">
                <a href="http://www.phila.gov/fire/fac_and_equip/facil_firehouses.html" class="action-panel">
                  <div class="panel equal" data-equalizer-watch="" >
                    <header class="">
                      <div class="icon">
                        <span><i class="fa fa-fire-extinguisher fa-5x" aria-hidden="true"></i></span>
                      </div>
                      <span class="external">Fire Stations</span>
                    </header>
                  </div>
                </a>
              </div>

              <div class="small-12 medium-6 columns mvl-mu sidewalk">
                <a href="https://www.phillypolice.com/districts/" class="action-panel">
                  <div class="panel equal" data-equalizer-watch="" >
                    <header class="">
                      <div class="icon">
                        <span><i class="fa fa-shield fa-5x" aria-hidden="true"></i></span>
                      </div>
                      <span class="external">Police Stations</span>
                    </header>
                  </div>
                </a>
              </div>

          </div>
      </div>
      <div class="feedback phm phn-mu mvs mvn-mu">
        <div class="row expanded" data-toggle="feedback">
          <div class="column call-to-action pas center">
            <i class="fa fa-lightbulb-o" aria-hidden="true"></i> What should we add to this section? <span class="nowrap">Tell us</span>.
          </div>
        </div>
        <div class="row expanded feedback-form" data-type="feedback-form" style="display:none;">
          <div class="medium-18 column small-centered mvm" >
            <div class="">
              <p>There are many ways to connect with your neighbors, local organizations, and the City of Philadelphia. We’d like to help you find the neighborhood resources you need. Tell us what you find useful by answering the questions below.</p>
              <p>Please don’t provide personal information, like your name or contact details, in your answers.</p>

              <form>
                <label>What would you add to the neighborhood resources list?</label>
                <input>
                <label>What neighborhood resources would you like to know more about and why?</label>
                <input>
                <label>What’s your zip code?</label>
                <input>
              </form>
            </div>
          </div>
        </div>
        <div class="row expanded" data-type="feedback-indicator">
          <div class="column center">
            <div class="arrow"></div>
          </div>
        </div>
        <div class="row expanded" data-toggle="feedback" data-type="feedback-footer" style="display:none;">
          <div class="column call-to-action center" >
            <div class="pas"><i class="fa fa-close" aria-hidden="true"></i> <span>Close</span> </div>
          </div>
        </div>
    </section>

  </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
