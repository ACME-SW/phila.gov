<?php 
/* 
  * Template for navigation card, with icon. 
  * @vars - $link - Required
          - $background - Required
          - $icon - Required
          - $h3 - Required
          - $description - Required
  *
*/
?>
<?php if ( !empty( $icon ) ): ?>
  <a class="card card--navigation guide-card" href="<?php echo !empty($link) ? $link : ''?>">
    <div class="icon-box" style="background-color: <?php echo $background ?>">
      <div class="icon-content">
        <i class="<?php echo !empty($icon) ? $icon : ''?> fa-fw"></i>
      </div>
    </div>
    <div class="card-text guide-card-text">
      <h3><?php echo !empty($h3) ? $h3 : ''?></h3>
      <p class="hide-for-small-only"><?php echo !empty($description) ? $description : ''?></p>
    </div>
  </a>
<?php endif ?>