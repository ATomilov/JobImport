<h1><?php echo get_admin_page_title(); ?></h1>
<div class="card">
<?php
$post_types = get_post_types('','names');

foreach( $post_types as $post_type ) {
  echo $post_type ."\n";
}
?>
</div>	