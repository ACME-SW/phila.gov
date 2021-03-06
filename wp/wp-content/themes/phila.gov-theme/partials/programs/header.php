<?php
  /*
   * Programs and initiatives header
  */
  $parent = phila_util_get_furthest_ancestor($post);
  $hero = rwmb_meta( 'prog_header_img', array( 'limit' => 1 ) );

  $hero = !empty( $hero ) ? reset( $hero ) : '';

  $sub_hero = rwmb_meta( 'prog_association_img', array( 'limit' => 1 ), $post->ID);

  $sub_heading = rwmb_meta('prog_sub_head');

  if ( !empty( $sub_hero ) ):
    $sub_hero = reset( $sub_hero );
  else:
    $sub_hero = rwmb_meta( 'prog_header_img_sub', array( 'limit' => 1 ), $parent->ID);
    $sub_hero =  !empty( $sub_hero ) ? reset( $sub_hero ) : '' ;
  endif;

  $owner = rwmb_meta( 'phila_program_owner_logo', array( 'limit' => 1 ) );
  $owner = !empty($owner) ? reset($owner) : '';

  $credit = rwmb_meta( 'phila_photo_credit' );
  $description = rwmb_meta( 'phila_meta_desc' );

  $current_post_type = get_post_type($post->ID);
?>
<header>
  <?php if ( !empty( get_post_ancestors( $post->ID ) ) ) : ?>
    <div class="hero-subpage <?php echo !empty($sub_heading) ? 'associated-sub' : '' ?>" style="background-image:url(<?php echo $sub_hero['full_url']  ?>) ">
      <div class="grid-container pvxl">
        <div class="grid-x center">
          <div class="cell">
    
            <?php if(!empty($sub_heading)) : ?>
              <hr>
            <?php endif ?>
            <h1 <?php echo !empty($sub_heading) ? 'class="man"' : ''; ?>><?php echo !empty($sub_heading) ? the_title() : $parent->post_title ?></h1>
            <?php if(!empty($sub_heading)) : ?>
              <hr>
            <?php endif ?>
            <?php if(!empty($sub_heading)) : ?>
                <h3><?php echo $sub_heading ?></h3>
            <?php endif;?>
          </div>
        </div>
      </div>
    </div>
    <?php if (phila_get_selected_template() != 'prog_association') : ?>
      <?php phila_get_menu(); ?>
    <?php endif; ?>
    <?php if ($current_post_type != 'department_page' && $user_selected_template != 'stub') : ?>
      <div class="mtl mbm">
        <?php get_template_part( 'partials/breadcrumbs' ); ?>
      </div>
      <?php if ( empty( $sub_heading ) ) :?>
        <div class="grid-container">
          <div class="grid-x">
            <div class="cell">
              <h2 class="contrast"><?php echo the_title(); ?></h2>
            </div>
          </div>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <?php elseif($current_post_type !== 'department_page'): ?>
    <div class="hero-half">
      <div class="grid-x">
        <div class="cell medium-12 bg-shade bg-ben-franklin-blue white hero-half--container">
          <div class="grid-x grid-container align-right">
            <div class="hero-half--title mvl">
              <h1><?php echo the_title() ?></h1>
              <p class="description"><?php echo $description ?></p>
              <?php if ( !empty( $owner ) ) : ?>
                <div class="owner-logo">
                  <div class="sep"></div>
                  <img src="<?php echo $owner['full_url']?>" alt="<?php echo $owner['alt']?>">
                </div>
              <?php endif;?>
            </div>
          </div>
        </div>
        <div class="cell medium-12 align-self-stretch hero-image hide-for-small-only" style="background-image:url(<?php echo $hero['full_url']  ?>) ">
          <?php echo !empty($credit) ? '<div class="photo-credit"><span><i class="fas fa-camera" aria-hidden="true"></i> Photo by ' . $credit . '</div>' : '' ?>
        </div>
      </div>
    <?php phila_get_menu(); ?>
  <?php endif; ?>
</header>
