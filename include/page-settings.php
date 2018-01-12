<h1><?php echo get_admin_page_title(); ?></h1>
<div class="card">
  <h2>Where Meta Box should show</h2>
  <form action="options.php" method="post" class="ji-form">
  <?php
  settings_fields( 'selectedPostTypes_group' );
  $options = get_option( 'selectedPostTypes' );
  $post_types = get_post_types( array( 'public' => true ),'names' ); ?>
    <?php if( $post_types ) : ?>
      <ul class="post-types-list">
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
  <h2>API Credentials</h2>
  <form action="options.php" method="post" class="ji-form api-credentials-fields">
    <?php
    settings_fields( 'apiCredentials_group' );
    $options_api = get_option( 'apiCredentials' );
    ?>
    <div class="single-field">
      <label for="api-username" class="username">Username
        <input type="text" name="apiCredentials[username]" id="api-username" value="<?php echo esc_attr( $options_api['username'] ); ?>" required>
      </label>
    </div>
    <div class="single-field">
      <label for="api-password" class="password">Password
        <input type="password" name="apiCredentials[password]" id="api-password" value="<?php echo esc_attr( $options_api['password'] ); ?>" required>
      </label>
    </div>
    <div class="single-field">
      <label for="api-key-field" class="api-key">API Key
        <input type="text" name="apiCredentials[api_key]" id="api-key-field" value="<?php echo esc_attr( $options_api['api_key'] ); ?>" required>
      </label>
    </div>
    <div class="single-field">
      <label for="url-web" class="api-key">The URL to the web service
        <input type="text" name="apiCredentials[url_web_service]" id="url-web" value="<?php echo esc_attr( $options_api['url_web_service'] ); ?>" required>
      </label>
    </div>
    <p class="submit">
    	<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
    </p>
  </form>
<?php
if ( !empty( $options_api ) ) : 
  $options_api = array_values( $options_api );
print_r( $options_api );
endif;
?>
</div>	