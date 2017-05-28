<?php
/*
	Template for the search listing item
*/

global $db_search_listing_data;
if ( empty($db_search_listing_data) ) {
	return;
}
$main_settings = get_option( 'db_main_settings');
$listing_rating = get_post_meta( $db_search_listing_data['ID'], 'listing_ratings', true );
if ( $listing_rating == '' ) {
	$listing_rating = 0;
} else {
	$rating_count = 0;
	foreach ($listing_rating as $rating_value) {
		$rating_count += $rating_value;
	}
	$listing_rating = $rating_count/count($listing_rating);
}
?>

<div class="db-main-search-item" data-id="<?php echo $db_search_listing_data['ID']; ?>" data-name="<?php echo strtolower($db_search_listing_data['post_title']); ?>" data-date="<?php echo strtotime($db_search_listing_data['post_date_gmt']); ?>" data-rating="<?php echo $listing_rating; ?>">
	<a href="<?php echo get_permalink( $db_search_listing_data['ID'] ); ?>"><h3 class="db-search-listing-title"><?php echo $db_search_listing_data['post_title']; ?></h3></a>
	<?php if ( has_post_thumbnail( $db_search_listing_data['ID'] ) ) {
		$img = wp_get_attachment_image_src( get_post_thumbnail_id( $db_search_listing_data['ID'] ) ); ?>
		<img src="<?php echo $img['0']; ?>" alt="" class="db-search-listing-image">
	<?php } else if ( $main_settings['default_listing_image'] != '' ) { ?>
		<img src="<?php echo $main_settings['default_listing_image']; ?>" alt="" class="db-search-listing-image">
	<?php } ?>
	<div class="db-search-listing-data">
		<div class="db-search-listing-meta">
			<span class="db-field-title">Categories:</span> <?php db_get_categories( $db_search_listing_data['ID'] ); ?>
		</div>
		<div class="db-search-listing-fields">
		<?php db_get_listing_custom_field_data( $db_search_listing_data, 'db-search-listing-field-item' ); ?>
		</div>
		<?php if ( $db_search_listing_data['post_excerpt'] ) { ?>
			<p class="db-search-listing-content"><?php echo $db_search_listing_data['post_excerpt']; ?></p>
		<?php } else if ( $db_search_listing_data['post_content'] ) { ?>
			<p class="db-search-listing-content"><?php echo $db_search_listing_data['post_content']; ?></p>
		<?php } ?>
	</div>
	<div class="clearfix"></div>
</div>