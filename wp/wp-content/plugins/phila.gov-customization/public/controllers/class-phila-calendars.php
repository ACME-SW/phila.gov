<?php

class Phila_Calendars_Controller {

  // Initialize the namespace and resource name.
  public function __construct() {
    $this->namespace     = 'calendars/v1';
    $this->resource_name = 'list';

  }

  // Register our routes.
  public function register_routes() {
  // Register the endpoint for collections.
    register_rest_route( $this->namespace, '/' . $this->resource_name, array(
      array(
        'methods'   => WP_REST_Server::READABLE,
        'callback'  => array( $this, 'get_items' ),
      ),
      'schema' => array( $this, 'get_item_schema' ),
    ) );
  }

  /**
   * Return all calendars, excluding stubs
   *
   * @param WP_REST_Request $request Current request.
  */
  public function get_items( $request ) {

    $cal_a = array(
      'post_type' => 'calendar',
      'posts_per_page'  => -1,
      'post_status' => 'any',
      'tax_query' => array(
        'relation' => 'OR',
        array(
            'taxonomy' => 'calendar_category',
            'field'    => 'slug',
            'terms'    => array( 'all-events' ),
        ),
      )
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
        $categories = get_the_category( get_the_id() );
    
        if ($categories != null) {
          $i++;
          array_push($post_ids, get_the_id() );

          // $cat = phila_get_department_homepage_typography( null, $return_stripped = true, $page_title = $categories[0]->name);
          // $trimmed_name = preg_replace('/( & )/', ' and ', $cat);

          array_push($cal_cat_ids,  $categories[0]->slug);
          array_push($cal_nice_name, $categories);
    
          // $names[$i]['id'] = $categories[0]->cat_ID;
          // $names[$i]['name'] = phila_get_department_homepage_typography( null, $return_stripped = true, $page_title = $categories[0]->name );
          
        }

        endwhile;
      
        wp_reset_postdata();
      }

      $grouped_cals = array();
      foreach ($post_ids as $post_id) {
        $categories = get_the_category( $post_id );
        $category = $categories[0];

        // $cat = phila_get_department_homepage_typography( null, $return_stripped = true, $page_title = $category->name);
        // $trimmed_name = preg_replace('/( & )/', ' and ', $cat);
        // $final =  html_entity_decode(trim($trimmed_name));
        $current_cal = get_post_meta( $post_id, '_grouped_calendars_ids', true );
       // var_dump($current_cal );
        $grouped_cals[$category->slug] = get_post_meta( $post_id, '_grouped_calendars_ids', true );;

      
        //$grouped_cals[$category->slug] = get_post_meta( $post_id, '_grouped_calendars_ids', true );
        
        //array_push($grouped_cals, get_post_meta( $post_id, '_grouped_calendars_ids', true ) );
        array_push($cal_ids, base64_decode(get_post_meta( $post_id, '_google_calendar_id', true ) ) );
      }
      //remove duplicates
      $clean_grouped_cals = array_filter($grouped_cals);
      $just_ids = array();

      //var_dump($clean_grouped_cals);
    
      foreach ($clean_grouped_cals as $key => $value){
        var_dump($value);
        if ( is_array($value) ) {
          foreach ($value as $cal_id) {
            $categories = get_the_category( $cal_id );
            $category = $categories[0];

            $single_cal_id[$category->slug] = base64_decode(
              get_post_meta($cal_id, '_google_calendar_id', true)
            );
            //var_dump($single_cal_id[$category->slug]);
            //TODO: add if statement to catch the loop and stop it from duplicating 
            //if () {
              $just_ids[$key] = $single_cal_id;

            //}

          }

        }
      }    

      $i=0;
      foreach ($cal_nice_name as $nice){
        $i++;
        $links[$nice[0]->cat_ID] = phila_get_current_department_name($nice);
      }
      // this is good. 
      $final_array_single = array_combine($cal_cat_ids, $cal_ids);
      var_dump($just_ids);
     //somewhere in here is the issue.
      $final_array = array_replace($final_array_single, $just_ids);

      //var_dump($final_array);
      //remove duplicates
      $names = array_map('unserialize', array_unique(array_map('serialize', $names)));
    
      $links = array_filter($links);
    
      $calendar_ids = json_encode($final_array);

      //var_dump($calendar_ids);
    
      function sort_by_name($a, $b){
        return strcmp($a['name'], $b['name']);
      }
    
      usort($names, 'sort_by_name');
    
      $names = json_encode($names);

    $data = array();

    if ( empty( $calendar_ids ) ) {
      return rest_ensure_response( $data );
    }

    foreach ( $final_array as $key => $cal_id ) {
      $response = $this->prepare_item_for_response( $key, $cal_id, $request );

      $data[] = $this->prepare_response_for_collection( $response );
    }
    // Return all response data.
    return rest_ensure_response( $data );
  }


  /**
   * Matches the post data to the schema. Also, rename the fields to nicer names.
   *
   * @param WP_Post $post The comment object whose response is being prepared.
   */

  public function prepare_item_for_response( $key, $calendar , $request ) {
    $calendar_data = array();

    $schema = $this->get_item_schema( $request );
    // var_dump($calendar);
    // foreach( $calendar as $key => $val) {

      if (isset( $schema['properties']['department_slug'] )) {
        // convert to id of celandar
        $calendar_data['department_slug'] = (string) $key;
      }

      if (isset( $schema['properties']['calendar_id'] )) {
        // NEED TO CONVERT ARRAYS TO OBJECTS
        $calendar_data['calendar_id'] =  $calendar;
      }
    // }

    return rest_ensure_response( $calendar_data );
}

  /**
   * Prepare a response for inserting into a collection of responses.
   *
   * This is copied from WP_REST_Controller class in the WP REST API v2 plugin.
   *
   * @param WP_REST_Response $response Response object.
   * @return array Response data, ready for insertion into collection data.
   */
  public function prepare_response_for_collection( $response ) {
    if ( ! ( $response instanceof WP_REST_Response ) ) {
      return $response;
    }

    $data = (array) $response->get_data();
    $server = rest_get_server();

    if ( method_exists( $server, 'get_compact_response_links' ) ) {
      $links = call_user_func( array( $server, 'get_compact_response_links' ), $response );
    } else {
      $links = call_user_func( array( $server, 'get_response_links' ), $response );
    }

    if ( ! empty( $links ) ) {
      $data['_links'] = $links;
    }

    return $data;
  }

  /**
   * Get sample schema for a collection.
   *
   * @param WP_REST_Request $request Current request.
   */
  public function get_item_schema( $request ) {
    $schema = array(
      // This tells the spec of JSON Schema we are using which is draft 4.
      '$schema'              => 'http://json-schema.org/draft-04/schema#',
      // The title property marks the identity of the resource.
      'title'                => 'post',
      'type'                 => 'object',
      // Specify object properties in the properties attribute.
      'properties'           => array(
        'department_slug' => array(
          'description'  => esc_html__( 'Title of the object.', 'phila-gov' ),
          'type'         => 'string',
          'readonly'     => true,
        ),
        'calendar_id' => array(
          'description'  => esc_html__( 'Department short name.', 'phila-gov' ),
          'type'         => 'string',
          'readonly'     => true,
        ),
        'owner' => array(
          'description'  => esc_html__( 'Acronym of the object.', 'phila-gov' ),
          'type'         => 'string',
          'readonly'     => true,
        ),
      ),
    );

    return $schema;
  }

}

// Function to register our new routes from the controller.
function phila_register_calendar_rest_routes() {
  $controller = new Phila_Calendars_Controller();
  $controller->register_routes();
}

add_action( 'rest_api_init', 'phila_register_calendar_rest_routes' );
