<?php
//single testimonial default template
 ?>
		<div class="<?php echo $output_theme; ?> <?php echo $attribute_classes; ?> easy_t_single_testimonial" <?php echo $width_style; ?>>
			<?php
				//output json-ld review markup, if option is set
				if($output_schema_markup){
					echo $this->output_jsonld_markup($display_testimonial);
				}
			?>
			<blockquote class="easy_testimonial" style="<?php echo $display_testimonial_body_css; ?>">
				<?php if ($show_thumbs) {
					?><div class="easy_testimonial_image_wrapper"><?php
					echo $display_testimonial['image'];
					?></div><?php
				} ?>		
				<?php if ($show_title) {
					echo '<p class="easy_testimonial_title">' . get_the_title($display_testimonial['id']) . '</p>';
				} ?>	
				<?php if($meta_data_position == "above") {
					$this->easy_testimonials_build_metadata_html($display_testimonial, $author_class, $show_date, $show_rating, $show_other);	
				} ?>
				<div class="<?php echo $body_class; ?>">
					<?php echo $display_testimonial['content']; ?>
					<?php if($show_view_more):?><a href="<?php echo $testimonials_link; ?>" class="easy_testimonials_read_more_link"><?php echo get_option('easy_t_view_more_link_text', 'Read More Testimonials'); ?></a><?php endif; ?>
				</div>	
				<?php if($meta_data_position == "below") {	
					$this->easy_testimonials_build_metadata_html($display_testimonial, $author_class, $show_date, $show_rating, $show_other);	
				} ?>
				<div class="easy_t_clear"></div>
			</blockquote>
		</div>