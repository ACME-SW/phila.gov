<?php
/**
 * Template Name: The latest - Events archive
 * Description: Custom Page template for Events archive
 * @package phila-gov
 */

get_header();
?>
<div class="row">
  <header class="columns">
    <h1 class="contrast">
        <?php echo get_the_title(); ?>
    </h1>
  </header>
</div>

<?php
$cal_a = array(
  'post_type' => 'calendar',
  'posts_per_page'  => -1,
  'post_status' => 'any'
);
$calendar_q = new WP_Query( $cal_a );

if ( $calendar_q->have_posts() ) {
  $post_ids = array();
  $cal_ids = array();
  $cal_cat_ids = array();
  $cal_nice_name = array();
  // $grouped_cals = array();
  $names = array();
  $links = array();
  $i = 0;

  while ( $calendar_q->have_posts() ) : $calendar_q->the_post();
  $ids = get_the_id();
  //var_dump( $ids);
    $categories = get_the_category( get_the_id() );
    //var_dump( get_post_meta( get_the_id() ));

    if ($categories != null) {
      $i++;
      array_push($post_ids, get_the_id() );
      array_push($cal_cat_ids, $categories[0]->cat_ID);
      array_push($cal_nice_name, $categories);

      $names[$i]['id'] = $categories[0]->cat_ID;
      $names[$i]['name'] = phila_get_department_homepage_typography( null, $return_stripped = true, $page_title = $categories[0]->name );
    }
  endwhile;

    wp_reset_postdata();
  }
  foreach ($post_ids as $post_id) {
    $categories = get_the_category( $post_id );
    $category = $categories[0];
    // var_dump($category);
    $grouped_cals[$category->term_id] = get_post_meta( $post_id, '_grouped_calendars_ids', true );
    //  $test = get_post_meta($post_id, '_grouped_calendars_ids');
    array_push($grouped_cals, get_post_meta( $post_id, '_grouped_calendars_ids', true ) );
    array_push($cal_ids, base64_decode(get_post_meta( $post_id, '_google_calendar_id', true ) ) );
  }
  //remove duplicates
  $clean_grouped_cals = array_filter($grouped_cals);
  $just_ids = array();

  foreach ($clean_grouped_cals as $key => $value){
    if ( is_array($value) ) {
      foreach ($value as $id) {
        $categories = get_the_category( $id );
        $category = $categories[0];

        //var_dump($categories);
        $single_cal_id[$category->term_id] = base64_decode(get_post_meta($id, '_google_calendar_id', true));
      }
      $just_ids[$key] = $single_cal_id;
    }
  }

  $i=0;
  foreach ($cal_nice_name as $nice){
    $i++;
    $links[$nice[0]->cat_ID] = phila_get_current_department_name($nice);
  }

  $final_array_single = array_combine($cal_cat_ids, $cal_ids);
  //var_dump($final_array_single);
  $final_array = array_replace($final_array_single, $just_ids);

  //remove duplicates
  $names = array_map("unserialize", array_unique(array_map("serialize", $names)));

  $links = array_filter($links);

  $calendar_ids = json_encode($final_array);

  function sort_by_name($a, $b){
    return strcmp($a['name'], $b['name']);
  }

  usort($names, 'sort_by_name');

  $names = json_encode($names);

  /* g_cal_data - Object: key is category ID, value is calendar ids*/
  wp_localize_script('vuejs-app',
  'g_cal_data', array(
    'json' => __($calendar_ids)
      )
    );
    /*calendar_owners - Array: key is category ID, value is department link */
    wp_localize_script('vuejs-app',
    'calendar_owners', array(
      'json' => __($links)
      )
    );
    /* calendar_nice_names - Array. key is category ID, value is department nice name */
    wp_localize_script('vuejs-app',
    'calendar_nice_names', array($names) );

?>
<section id="events-archive" class="content-area archive">

  <div class="row">
    <main id="main" class="site-main medium-20 columns medium-centered">

      <div id="all-events">
        <div class="center"><i class="fas fa-spinner fa-spin fa-3x"></i></div>
      </div>

    </main><!-- #main -->
  </div>
</section><!-- #primary -->

<?php get_footer();?>