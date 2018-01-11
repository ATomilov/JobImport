<h1><?php echo get_admin_page_title(); ?></h1>
<div class="card">
<form action="options.php" method="POST" class="ji-form">
<?php
settings_fields( 'selectedPostTypes_group' );
$options = get_option( 'selectedPostTypes' );
$post_types = get_post_types( array( 'public' => true ),'names' ); ?>
  <?php if( $post_types ) : ?>
    <ul>
      <?php foreach( $post_types as $post_type ) : ?>
        <li>
          <label for="<?php echo $post_type;?>">
            <input type="checkbox" name="selectedPostTypes[]" id="<?php echo $post_type;?>" value="<?php echo $post_type;?>" 
            <?php
            if ( !empty( $options ) ) : 
              foreach( $options as $key => $value ) : 
                if ($value == $post_type)
                  echo ' checked="checked"';
              endforeach;
            endif;?>>
            <?php echo $post_type;?>
          </label>
        </li>
      <?php
      endforeach;
      ?>
    </ul>
  <?php endif;?>
  <p class="submit">
  	<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
  </p>
</form>
<?php
if ( !empty( $options ) ) : 
  foreach( $options as $key => $value ) : 
    echo $key . ' ' . $value . '<br>';
  endforeach;
endif;
?>
</div>	