<?php
/**
 * WhiteLab 1.0 Theme Customizer support
 *
 * @package WordPress
 * @subpackage WhiteLab
 * @since WhiteLab 1.0
 */

/**
 * Implement Theme Customizer additions and adjustments.
 *
 * @since WhiteLab 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function whitelab_customize_register( $wp_customize ) {
	// Add custom description to Colors and Background sections.
	$wp_customize->get_section( 'colors' )->description           = esc_html__( 'Background may only be visible on wide screens.', 'whitelab' );
	$wp_customize->get_section( 'background_image' )->description = esc_html__( 'Background may only be visible on wide screens.', 'whitelab' );

	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Rename the label to "Site Title Color" because this only affects the site title in this theme.
	$wp_customize->get_control( 'header_textcolor' )->label = esc_html__( 'Site Title Color', 'whitelab' );

	// Rename the label to "Display Site Title & Tagline" in order to make this option extra clear.
	$wp_customize->get_control( 'display_header_text' )->label = esc_html__( 'Display Site Title &amp; Tagline', 'whitelab' );

	// Add Header setting panel and configure settings inside it
	$wp_customize->add_panel( 'whitelab_header_panel', array(
		'priority'       => 250,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'Header settings' , 'whitelab'),
		'description'    => esc_html__( 'You can configure your theme header settings here.' , 'whitelab'),
	) );

	$wp_customize->add_panel( 'whitelab_header_slider_panel', array(
		'priority'       => 250,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'Header login/register settings' , 'whitelab'),
		'description'    => esc_html__( 'You can configure your theme header login settings here.' , 'whitelab'),
	) );

	$wp_customize->add_panel( 'whitelab_footer_panel', array(
		'priority'       => 250,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'Footer settings' , 'whitelab'),
		'description'    => esc_html__( 'You can configure your theme footer settings here.' , 'whitelab'),
	) );

	for ($i=1; $i < 6; $i++) { 
		// Slide section
		$wp_customize->add_section( 'whitelab_header_slide_section_'.$i, array(
			'priority'       => 10,
			'capability'     => 'edit_theme_options',
			'title'          => sprintf( __( 'Header slide Nr. %d', 'whitelab'), $i ),
			'description'    => esc_html__( 'Slide for your header!' , 'whitelab'),
			'panel'          => 'whitelab_header_slider_panel'
		) );

		// Slide title
		$wp_customize->add_setting( 'whitelab_header_slide_title_'.$i, array( 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control(
			'whitelab_header_slide_title_'.$i,
			array(
				'label'      => esc_html__( 'Slider title' , 'whitelab'),
				'section'    => 'whitelab_header_slide_section_'.$i,
				'type'       => 'text',
			)
		);

		// Slide text
		$wp_customize->add_setting( 'whitelab_header_slide_text_'.$i, array( 'sanitize_callback' => 'whitelab_wpkses' ) );
		$wp_customize->add_control(
			'whitelab_header_slide_text_'.$i,
			array(
				'label'      => esc_html__( 'Slider text' , 'whitelab'),
				'section'    => 'whitelab_header_slide_section_'.$i,
				'type'       => 'text',
			)
		);

		// Slide image
		$wp_customize->add_setting( 'whitelab_header_slide_section_'.$i, array( 'sanitize_callback' => 'esc_url' ) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'whitelab_header_slide_section_'.$i, array(
				'label'      => esc_html__( 'Header slide image', 'whitelab' ),
				'section'    => 'whitelab_header_slide_section_'.$i,
				'settings'	 => 'whitelab_header_slide_section_'.$i
				)
			)
		);
	}

	// Slider autoplay
	$wp_customize->add_section( 'whitelab_header_autoplay_section', array(
			'priority'       => 10,
			'capability'     => 'edit_theme_options',
			'title'          => esc_html__( 'Header slider autoplay', 'whitelab'),
			'description'    => esc_html__( 'Provide a delay in milliseconds, how fast to slide the slides. Entering "0" will disable the autoplay.' , 'whitelab'),
			'panel'          => 'whitelab_header_slider_panel'
		) );

	$wp_customize->add_setting( 'whitelab_header_autoplay', array( 'sanitize_callback' => 'sanitize_text_field', 'default' => '0' ) );
	$wp_customize->add_control(
		'whitelab_header_autoplay',
		array(
			'label'      => esc_html__( 'Delay' , 'whitelab'),
			'section'    => 'whitelab_header_autoplay_section',
			'type'       => 'number',
		)
	);

	// Terms and conditions
	$wp_customize->add_section( 'whitelab_header_terms_section', array(
			'priority'       => 10,
			'capability'     => 'edit_theme_options',
			'title'          => esc_html__( 'Terms and conditions', 'whitelab'),
			'description'    => esc_html__( 'Terms and conditions URL for your register dialog!' , 'whitelab'),
			'panel'          => 'whitelab_header_slider_panel'
		) );

	$wp_customize->add_setting( 'whitelab_header_terms', array( 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control(
		'whitelab_header_terms',
		array(
			'label'      => esc_html__( 'Terms and conditions URL' , 'whitelab'),
			'section'    => 'whitelab_header_terms_section',
			'type'       => 'text',
		)
	);

	// Logo
	$wp_customize->add_section( 'whitelab_header_logo_section', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'Header logo' , 'whitelab'),
		'description'    => esc_html__( 'Logo that\'s going to be shown only in the static front page header.', 'whitelab'),
		'panel'          => 'whitelab_header_panel'
	) );

	$wp_customize->add_setting( 'whitelab_header_logo', array( 'sanitize_callback' => 'esc_url' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'whitelab_header_logo', array(
			'label'      => esc_html__( 'Header logo', 'whitelab' ),
			'section'    => 'whitelab_header_logo_section',
			'settings'	 => 'whitelab_header_logo'
			)
		)
	);

	// Logo 2
	$wp_customize->add_section( 'whitelab_header_second_logo_section', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'Header secondary logo' , 'whitelab'),
		'description'    => esc_html__( 'Logo that\'s going to be shown everywhere except the static front page!.' , 'whitelab'),
		'panel'          => 'whitelab_header_panel'
	) );

	$wp_customize->add_setting( 'whitelab_header_second_logo', array( 'sanitize_callback' => 'esc_url' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'whitelab_header_second_logo', array(
			'label'      => esc_html__( 'Header secondary logo', 'whitelab' ),
			'section'    => 'whitelab_header_second_logo_section',
			'settings'	 => 'whitelab_header_second_logo'
			)
		)
	);

	// Header custom slider
	$wp_customize->add_section( 'whitelab_header_custom_slider_section', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'Homepage slider' , 'whitelab'),
		'description'    => esc_html__( 'Choose what type of slider to show at your homepage.' , 'whitelab'),
		'panel'          => 'whitelab_header_panel'
	) );

	$wp_customize->add_setting( 'whitelab_custom_slider_status', array( 'sanitize_callback' => 'sanitize_text_field', 'default' => 'revolution' ) );
	$wp_customize->add_control(
		'whitelab_custom_slider_status',
		array(
			'label'      => esc_html__( 'Slider status' , 'whitelab'),
			'section'    => 'whitelab_header_custom_slider_section',
			'type'       => 'select',
			'choices'		 => array(
					'revolution' => 'Revolution slider',
					'split' => 'Split slider',
					'none' => 'None'
				)
		)
	);

	$wp_customize->add_setting( 'whitelab_custom_slider_image', array( 'sanitize_callback' => 'esc_url' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'whitelab_custom_slider_image', array(
			'label'      => esc_html__( 'Slider image', 'whitelab' ),
			'section'    => 'whitelab_header_custom_slider_section',
			'settings'	 => 'whitelab_custom_slider_image'
			)
		)
	);

	$wp_customize->add_setting( 'whitelab_custom_slider_text', array( 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Whitelab' ) );
	$wp_customize->add_control(
		'whitelab_custom_slider_text',
		array(
			'label'      => esc_html__( 'Slider text' , 'whitelab'),
			'section'    => 'whitelab_header_custom_slider_section',
			'type'       => 'text',
		)
	);

	$wp_customize->add_setting( 'whitelab_custom_slider_color', array( 'sanitize_callback' => 'sanitize_text_field', 'default' => '#ffffff' ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'whitelab_custom_slider_color', array(
			'label'      => esc_html__( 'Slider text color', 'whitelab' ),
			'section'    => 'whitelab_header_custom_slider_section',
			'settings'   => 'whitelab_custom_slider_color',
			)
		) 
	);

	$wp_customize->add_setting( 'whitelab_custom_slider_delay', array( 'sanitize_callback' => 'sanitize_text_field', 'default' => '1500' ) );
	$wp_customize->add_control(
		'whitelab_custom_slider_delay',
		array(
			'label'      => esc_html__( 'Start slider after' , 'whitelab'),
			'description' => 'Delay in milliseconds',
			'section'    => 'whitelab_header_custom_slider_section',
			'type'       => 'number',
		)
	);

	$wp_customize->add_setting( 'whitelab_custom_slider_alias', array( 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control(
		'whitelab_custom_slider_alias',
		array(
			'label'      => esc_html__( 'Slider alias' , 'whitelab'),
			'section'    => 'whitelab_header_custom_slider_section',
			'type'       => 'text',
		)
	);

	// Footer style
	$wp_customize->add_section( 'whitelab_footer_section', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'Footer style' , 'whitelab'),
		'description'    => esc_html__( 'The style of your themes footer.' , 'whitelab'),
		'panel'          => 'whitelab_footer_panel'
	) );

	$wp_customize->add_setting( 'whitelab_footer_style', array( 'sanitize_callback' => 'sanitize_text_field', 'default' => 'default' ) );
	$wp_customize->add_control(
		'whitelab_footer_style',
		array(
			'label'      => esc_html__( 'Footer style' , 'whitelab'),
			'section'    => 'whitelab_footer_section',
			'type'       => 'select',
			'default'     => 'minimal',
			'choices'		 => array(
					'default' => 'Default',
					'minimal' => 'Minimal'
				)
		)
	);

	// Header categories
	$wp_customize->add_section( 'whitelab_header_category_section', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'Search categories' , 'whitelab'),
		'description'    => esc_html__( 'Choose which categories to show at the homepage search.' , 'whitelab'),
		'panel'          => 'whitelab_header_panel'
	) );

	$wp_customize->add_setting( 'whitelab_search_categories', array( 'sanitize_callback' => 'wl_sanitize_category', 'default' => array(), 'transport'   => 'refresh' ));
	$wp_customize->add_control( new WL_Customize_Control_Multiple_Select ( $wp_customize, 'whitelab_search_categories', array(
            'settings' => 'whitelab_search_categories',
            'label'    => esc_html__( 'Categories' , 'whitelab'),
            'section'  => 'whitelab_header_category_section',
            'type'     => 'multiple-select',
            'choices' => whitelab_get_listing_categories()
	        )
	    )
	);

	// Add Font setting panel and configure settings inside it
	$wp_customize->add_panel( 'whitelab_font_panel', array(
		'priority'       => 270,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'Font settings' , 'whitelab'),
		'description'    => esc_html__( 'You can configure your themes font settings here, if there are characters in your language that are not supported by a particular font, disable it..' , 'whitelab')
	) );

	$font_settings = whitelab_get_font_settings();

	foreach ($font_settings as $font_key => $font_value) {
		$wp_customize->add_section( 'whitelab_'.$font_key.'_fonts', array(
			'priority'       => 20,
			'capability'     => 'edit_theme_options',
			'title'          => $font_value['title'],
			'description'    => $font_value['description'],
			'panel'          => 'whitelab_font_panel'
		) );

		$wp_customize->add_setting( 'whitelab_'.$font_key.'_fontsize', array( 'default' => $font_value['size'], 'sanitize_callback' => 'absint' ) );
		$wp_customize->add_control(
			'whitelab_'.$font_key.'_fontsize',
			array(
				'label'      => 'Font size',
				'section'    => 'whitelab_'.$font_key.'_fonts',
				'type'       => 'select',
				'choices'    => whitelab_get_select( 8, 100 )
			)
		);

		$wp_customize->add_setting( 'whitelab_'.$font_key.'_lineheight', array( 'default' => $font_value['lineheight'], 'sanitize_callback' => 'absint' ) );
		$wp_customize->add_control(
			'whitelab_'.$font_key.'_lineheight',
			array(
				'label'      => 'Lineheight',
				'section'    => 'whitelab_'.$font_key.'_fonts',
				'type'       => 'select',
				'choices'    => whitelab_get_select( 8, 150 )
			)
		);

		$wp_customize->add_setting( 'whitelab_'.$font_key.'_fontfamily', array( 'default' => $font_value['fontfamily'], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control(
			'whitelab_'.$font_key.'_fontfamily',
			array(
				'label'      => 'Font family',
				'section'    => 'whitelab_'.$font_key.'_fonts',
				'type'       => 'select',
				'choices'    => whitelab_return_fonts()
			)
		);

		$wp_customize->add_setting( 'whitelab_'.$font_key.'_fontweight', array( 'default' => $font_value['fontweight'], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control(
			'whitelab_'.$font_key.'_fontweight',
			array(
				'label'      => 'Font weight',
				'section'    => 'whitelab_'.$font_key.'_fonts',
				'type'       => 'select',
				'choices'    => array(
					'100' => '100',
					'300' => '300',
					'400' => 'Normal',
					'700' => 'Bold',
					'400italic' => 'Italic',
					'700italic' => 'Bold Italic'
					)
			)
		);
	}

	// Reset
	$wp_customize->add_section( new Whitelab_Customized_Reset_Section( $wp_customize, 'whitelab_reset_fonts', array(
		'priority'       => 210,
		'capability'     => 'edit_theme_options',
		'panel'          => 'whitelab_font_panel'
		) )
	);

	$wp_customize->add_setting( 'whitelab_fake_field2', array( 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control(
		'whitelab_fake_field2',
		array(
			'label'      => '',
			'section'    => 'whitelab_reset_fonts',
			'type'       => 'text'
		)
	);

	// Social links
	$wp_customize->add_section( new Whitelab_Customized_Section( $wp_customize, 'whitelab_social_links', array(
		'priority'       => 300,
		'capability'     => 'edit_theme_options'
		) )
	);

	$wp_customize->add_setting( 'whitelab_fake_field', array( 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control(
		'whitelab_fake_field',
		array(
			'label'      => '',
			'section'    => 'whitelab_social_links',
			'type'       => 'text'
		)
	);
}
add_action( 'customize_register', 'whitelab_customize_register' );

function whitelab_wpkses( $text ) {
	return wp_kses( $text, array( 'strong' => array() ) );
}

function whitelab_get_listing_categories() {
	$listing_categories = get_terms( array(
		'taxonomy' => 'listing_category',
		'hide_empty' => false,
	));

	if ( !is_wp_error($listing_categories) && !empty($listing_categories) ) {
		$all_categories = array();

		foreach ($listing_categories as $category_data) {
			$all_categories[$category_data->term_id] = $category_data->name;
		}

		return $all_categories;
	}
}

if ( class_exists( 'WP_Customize_Section' ) && !class_exists( 'Whitelab_Customized_Section' ) ) {
	class Whitelab_Customized_Section extends WP_Customize_Section {
		public function render() {
			$classes = 'accordion-section control-section control-section-' . $this->type;
			?>
			<li id="accordion-section-<?php echo esc_attr( $this->id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
				<ul class="cohhe-social-profiles">
					<li class="documentation"><a href="http://documentation.cohhe.com/whitelab" class="button button-primary button-hero" target="_blank"><?php esc_html_e( 'Documentation', 'whitelab' ); ?></a></li>
				</ul>
			</li>
			<?php
		}
	}
}

if ( class_exists( 'WP_Customize_Section' ) && !class_exists( 'Whitelab_Customized_Reset_Section' ) ) {
	class Whitelab_Customized_Reset_Section extends WP_Customize_Section {
		public function render() {
			$classes = 'accordion-section control-section control-section-' . $this->type;
			?>
			<li id="accordion-section-<?php echo esc_attr( $this->id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
				<ul class="cohhe-reset-fonts">
					<li class="reset-fonts"><a href="javascript:void(0)" class="button button-primary" target="_blank"><?php esc_html_e( 'Reset fonts', 'whitelab' ); ?></a></li>
				</ul>
			</li>
			<?php
		}
	}
}

if ( class_exists( 'WP_Customize_Section' ) && !class_exists( 'WL_Customize_Control_Multiple_Select' ) ) {
	class WL_Customize_Control_Multiple_Select extends WP_Customize_Control {
		/**
		 * The type of customize control being rendered.
		 */
		public $type = 'multiple-select';

		/**
		 * Displays the multiple select on the customize screen.
		 */
		public function render_content() {

		if ( empty( $this->choices ) )
		    return;
		?>
		    <label>
		        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		        <select <?php $this->link(); ?> multiple="multiple" class="whitelab-custom-select">
		            <?php
		                foreach ( $this->choices as $value => $label ) {
		                    $selected = ( in_array( $value, $this->value() ) ) ? selected( 1, 1, false ) : '';
		                    echo '<option value="' . esc_attr( $value ) . '"' . $selected . '>' . $label . '</option>';
		                }
		            ?>
		        </select>
		    </label>
		<?php }
	}
}

function wl_sanitize_category( $input ) {
	if ( !empty($input) ) {
		$sanitized_array = array();
		foreach ($input as $cat_value) {
			$sanitized_array[] = intval($cat_value);
		}
		return $sanitized_array;
	} else {
		return array();
	}
	exit;
}

function whitelab_get_select( $min, $max ) {
	$select = array();
	for ($i=$min; $i <= $max; $i++) { 
		$select[$i] = $i.'px';
	}
	return $select;
}

function whitelab_return_fonts() {
	return array("Arial" => 'Arial', "Verdana" => 'Verdana', "Georgia" => 'Georgia', "Tahoma" => 'Tahoma', "Trebuchet+MS" => 'Trebuchet MS', "Calibri" => 'Calibri', "Geneva" => 'Geneva', "Abel" => 'Abel', "Abril+Fatface" => 'Abril Fatface', "Aclonica" => 'Aclonica', "Actor" => 'Actor', "Adamina" => 'Adamina', "Aguafina+Script" => 'Aguafina Script', "Aladin" => 'Aladin', "Aldrich" => 'Aldrich', "Alice" => 'Alice', "Alike+Angular" => 'Alike Angular', "Alike" => 'Alike', "Allan" => 'Allan', "Allerta+Stencil" => 'Allerta Stencil', "Allerta" => 'Allerta', "Amaranth" => 'Amaranth', "Amatic+SC" => 'Amatic SC', "Andada" => 'Andada', "Andika" => 'Andika', "Annie+Use+Your+Telescope" => 'Annie Use Your Telescope', "Anonymous+Pro" => 'Anonymous Pro', "Antic" => 'Antic', "Anton" => 'Anton', "Arapey" => 'Arapey', "Architects+Daughter" => 'Architects Daughter', "Arimo" => 'Arimo', "Artifika" => 'Artifika', "Arvo" => 'Arvo', "Asset" => 'Asset', "Astloch" => 'Astloch', "Atomic+Age" => 'Atomic Age', "Aubrey" => 'Aubrey', "Bangers" => 'Bangers', "Bentham" => 'Bentham', "Bevan" => 'Bevan', "Bigshot+One" => 'Bigshot One', "Bitter" => 'Bitter', "Black+Ops+One" => 'Black Ops One', "Bowlby+One+SC" => 'Bowlby One SC', "Bowlby+One" => 'Bowlby One', "Brawler" => 'Brawler', "Bubblegum+Sans" => 'Bubblegum Sans', "Buda" => 'Buda', "Butcherman+Caps" => 'Butcherman Caps', "Cabin+Condensed" => 'Cabin Condensed', "Cabin+Sketch" => 'Cabin Sketch', "Cabin" => 'Cabin', "Cagliostro" => 'Cagliostro', "Calligraffitti" => 'Calligraffitti', "Candal" => 'Candal', "Cantarell" => 'Cantarell', "Cardo" => 'Cardo', "Carme" => 'Carme', "Carter+One" => 'Carter One', "Caudex" => 'Caudex', "Cedarville+Cursive" => 'Cedarville Cursive', "Changa+One" => 'Changa One', "Cherry+Cream+Soda" => 'Cherry Cream Soda', "Chewy" => 'Chewy', "Chicle" => 'Chicle', "Chivo" => 'Chivo', "Coda+Caption" => 'Coda Caption', "Coda" => 'Coda', "Comfortaa" => 'Comfortaa', "Coming+Soon" => 'Coming Soon', "Contrail+One" => 'Contrail One', "Convergence" => 'Convergence', "Cookie" => 'Cookie', "Copse" => 'Copse', "Corben" => 'Corben', "Cousine" => 'Cousine', "Coustard" => 'Coustard', "Covered+By+Your+Grace" => 'Covered By Your Grace', "Crafty+Girls" => 'Crafty Girls', "Creepster+Caps" => 'Creepster Caps', "Crimson+Text" => 'Crimson Text', "Crushed" => 'Crushed', "Cuprum" => 'Cuprum', "Damion" => 'Damion', "Dancing+Script" => 'Dancing Script', "Dawning+of+a+New+Day" => 'Dawning of a New Day', "Days+One" => 'Days One', "Delius+Swash+Caps" => 'Delius Swash Caps', "Delius+Unicase" => 'Delius Unicase', "Delius" => 'Delius', "Devonshire" => 'Devonshire', "Didact+Gothic" => 'Didact Gothic', "Dorsa" => 'Dorsa', "Dr+Sugiyama" => 'Dr Sugiyama', "Droid+Sans+Mono" => 'Droid Sans Mono', "Droid+Sans" => 'Droid Sans', "Droid+Serif" => 'Droid Serif', "EB+Garamond" => 'EB Garamond', "Eater+Caps" => 'Eater Caps', "Expletus+Sans" => 'Expletus Sans', "Fanwood+Text" => 'Fanwood Text', "Federant" => 'Federant', "Federo" => 'Federo', "Fjord+One" => 'Fjord One', "Fondamento" => 'Fondamento', "Fontdiner+Swanky" => 'Fontdiner Swanky', "Forum" => 'Forum', "Francois+One" => 'Francois One', "Gentium+Basic" => 'Gentium Basic', "Gentium+Book+Basic" => 'Gentium Book Basic', "Geo" => 'Geo', "Geostar+Fill" => 'Geostar Fill', "Geostar" => 'Geostar', "Give+You+Glory" => 'Give You Glory', "Gloria+Hallelujah" => 'Gloria Hallelujah', "Goblin+One" => 'Goblin One', "Gochi+Hand" => 'Gochi Hand', "Goudy+Bookletter+1911" => 'Goudy Bookletter 1911', "Gravitas+One" => 'Gravitas One', "Gruppo" => 'Gruppo', "Hammersmith+One" => 'Hammersmith One', "Herr+Von+Muellerhoff" => 'Herr Von Muellerhoff', "Holtwood+One+SC" => 'Holtwood One SC', "Homemade+Apple" => 'Homemade Apple', "IM+Fell+DW+Pica+SC" => 'IM Fell DW Pica SC', "IM+Fell+DW+Pica" => 'IM Fell DW Pica', "IM+Fell+Double+Pica+SC" => 'IM Fell Double Pica SC', "IM+Fell+Double+Pica" => 'IM Fell Double Pica', "IM+Fell+English+SC" => 'IM Fell English SC', "IM+Fell+English" => 'IM Fell English', "IM+Fell+French+Canon+SC" => 'IM Fell French Canon SC', "IM+Fell+French+Canon" => 'IM Fell French Canon', "IM+Fell+Great+Primer+SC" => 'IM Fell Great Primer SC', "IM+Fell+Great+Primer" => 'IM Fell Great Primer', "Iceland" => 'Iceland', "Inconsolata" => 'Inconsolata', "Indie+Flower" => 'Indie Flower', "Irish+Grover" => 'Irish Grover', "Istok+Web" => 'Istok Web', "Jockey+One" => 'Jockey One', "Josefin+Sans" => 'Josefin Sans', "Josefin+Slab" => 'Josefin Slab', "Judson" => 'Judson', "Julee" => 'Julee', "Jura" => 'Jura', "Just+Another+Hand" => 'Just Another Hand', "Just+Me+Again+Down+Here" => 'Just Me Again Down Here', "Kameron" => 'Kameron', "Kelly+Slab" => 'Kelly Slab', "Kenia" => 'Kenia', "Knewave" => 'Knewave', "Kranky" => 'Kranky', "Kreon" => 'Kreon', "Kristi" => 'Kristi', "La+Belle+Aurore" => 'La Belle Aurore', "Lancelot" => 'Lancelot', "Lato" => 'Lato', "League+Script" => 'League Script', "Leckerli+One" => 'Leckerli One', "Lekton" => 'Lekton', "Lemon" => 'Lemon', "Limelight" => 'Limelight', "Linden+Hill" => 'Linden Hill', "Lobster+Two" => 'Lobster Two', "Lobster" => 'Lobster', "Lora" => 'Lora', "Love+Ya+Like+A+Sister" => 'Love Ya Like A Sister', "Loved+by+the+King" => 'Loved by the King', "Luckiest+Guy" => 'Luckiest Guy', "Maiden+Orange" => 'Maiden Orange', "Mako" => 'Mako', "Marck+Script" => 'Marck Script', "Marvel" => 'Marvel', "Mate+SC" => 'Mate SC', "Mate" => 'Mate', "Maven+Pro" => 'Maven Pro', "Meddon" => 'Meddon', "MedievalSharp" => 'MedievalSharp', "Megrim" => 'Megrim', "Merienda+One" => 'Merienda One', "Merriweather" => 'Merriweather', "Metrophobic" => 'Metrophobic', "Michroma" => 'Michroma', "Miltonian+Tattoo" => 'Miltonian Tattoo', "Miltonian" => 'Miltonian', "Miss+Fajardose" => 'Miss Fajardose', "Miss+Saint+Delafield" => 'Miss Saint Delafield', "Modern+Antiqua" => 'Modern Antiqua', "Molengo" => 'Molengo', "Monofett" => 'Monofett', "Monoton" => 'Monoton', "Monsieur+La+Doulaise" => 'Monsieur La Doulaise', "Montez" => 'Montez', "Mountains+of+Christmas" => 'Mountains of Christmas', "Mr+Bedford" => 'Mr Bedford', "Mr+Dafoe" => 'Mr Dafoe', "Mr+De+Haviland" => 'Mr De Haviland', "Mrs+Sheppards" => 'Mrs Sheppards', "Muli" => 'Muli', "Neucha" => 'Neucha', "Neuton" => 'Neuton', "News+Cycle" => 'News Cycle', "Niconne" => 'Niconne', "Nixie+One" => 'Nixie One', "Nobile" => 'Nobile', "Nosifer+Caps" => 'Nosifer Caps', "Nothing+You+Could+Do" => 'Nothing You Could Do', "Nova+Cut" => 'Nova Cut', "Nova+Flat" => 'Nova Flat', "Nova+Mono" => 'Nova Mono', "Nova+Oval" => 'Nova Oval', "Nova+Round" => 'Nova Round', "Nova+Script" => 'Nova Script', "Nova+Slim" => 'Nova Slim', "Nova+Square" => 'Nova Square', "Numans" => 'Numans', "Nunito" => 'Nunito', "Old+Standard+TT" => 'Old Standard TT', "Open+Sans+Condensed" => 'Open Sans Condensed', "Open+Sans" => 'Open Sans', "Orbitron" => 'Orbitron', "Oswald" => 'Oswald', "Over+the+Rainbow" => 'Over the Rainbow', "Ovo" => 'Ovo', "Poppins" => 'Poppins', "PT+Sans+Caption" => 'PT Sans Caption', "PT+Sans+Narrow" => 'PT Sans Narrow', "PT+Sans" => 'PT Sans', "PT+Serif+Caption" => 'PT Serif Caption', "PT+Serif" => 'PT Serif', "Pacifico" => 'Pacifico', "Passero+One" => 'Passero One', "Patrick+Hand" => 'Patrick Hand', "Paytone+One" => 'Paytone One', "Permanent+Marker" => 'Permanent Marker', "Petrona" => 'Petrona', "Philosopher" => 'Philosopher', "Piedra" => 'Piedra', "Pinyon+Script" => 'Pinyon Script', "Play" => 'Play', "Playfair+Display" => 'Playfair Display', "Podkova" => 'Podkova', "Poller+One" => 'Poller One', "Poly" => 'Poly', "Pompiere" => 'Pompiere', "Prata" => 'Prata', "Prociono" => 'Prociono', "Puritan" => 'Puritan', "Quattrocento+Sans" => 'Quattrocento Sans', "Quattrocento" => 'Quattrocento', "Questrial" => 'Questrial', "Quicksand" => 'Quicksand', "Radley" => 'Radley', "Raleway" => 'Raleway', "Rammetto+One" => 'Rammetto One', "Rancho" => 'Rancho', "Rationale" => 'Rationale', "Redressed" => 'Redressed', "Reenie+Beanie" => 'Reenie Beanie', "Ribeye+Marrow" => 'Ribeye Marrow', "Ribeye" => 'Ribeye', "Righteous" => 'Righteous', "Rochester" => 'Rochester', "Rock+Salt" => 'Rock Salt', "Rokkitt" => 'Rokkitt', "Rosario" => 'Rosario', "Ruslan+Display" => 'Ruslan Display', "Salsa" => 'Salsa', "Sancreek" => 'Sancreek', "Sansita+One" => 'Sansita One', "Satisfy" => 'Satisfy', "Schoolbell" => 'Schoolbell', "Shadows+Into+Light" => 'Shadows Into Light', "Shanti" => 'Shanti', "Short+Stack" => 'Short Stack', "Sigmar+One" => 'Sigmar One', "Signika+Negative" => 'Signika Negative', "Signika" => 'Signika', "Six+Caps" => 'Six Caps', "Slackey" => 'Slackey', "Smokum" => 'Smokum', "Smythe" => 'Smythe', "Sniglet" => 'Sniglet', "Snippet" => 'Snippet', "Sorts+Mill+Goudy" => 'Sorts Mill Goudy', "Special+Elite" => 'Special Elite', "Spinnaker" => 'Spinnaker', "Spirax" => 'Spirax', "Stardos+Stencil" => 'Stardos Stencil', "Sue+Ellen+Francisco" => 'Sue Ellen Francisco', "Sunshiney" => 'Sunshiney', "Supermercado+One" => 'Supermercado One', "Swanky+and+Moo+Moo" => 'Swanky and Moo Moo', "Syncopate" => 'Syncopate', "Tangerine" => 'Tangerine', "Tenor+Sans" => 'Tenor Sans', "Terminal+Dosis" => 'Terminal Dosis', "The+Girl+Next+Door" => 'The Girl Next Door', "Tienne" => 'Tienne', "Tinos" => 'Tinos', "Tulpen+One" => 'Tulpen One', "Ubuntu+Condensed" => 'Ubuntu Condensed', "Ubuntu+Mono" => 'Ubuntu Mono', "Ubuntu" => 'Ubuntu', "Ultra" => 'Ultra', "UnifrakturCook" => 'UnifrakturCook', "UnifrakturMaguntia" => 'UnifrakturMaguntia', "Unkempt" => 'Unkempt', "Unlock" => 'Unlock', "Unna" => 'Unna', "VT323" => 'VT323', "Varela+Round" => 'Varela Round', "Varela" => 'Varela', "Vast+Shadow" => 'Vast Shadow', "Vibur" => 'Vibur', "Vidaloka" => 'Vidaloka', "Volkhov" => 'Volkhov', "Vollkorn" => 'Vollkorn', "Voltaire" => 'Voltaire', "Waiting+for+the+Sunrise" => 'Waiting for the Sunrise', "Wallpoet" => 'Wallpoet', "Walter+Turncoat" => 'Walter Turncoat', "Wire+One" => 'Wire One', "Yanone+Kaffeesatz" => 'Yanone Kaffeesatz', "Yellowtail" => 'Yellowtail', "Yeseva+One" => 'Yeseva One', "Zeyada" => 'Zeyada', "Headland+One" => 'Headland One', "Fjalla+One" => 'Fjalla One', "Roboto" => 'Roboto', "Roboto+Condensed" => 'Roboto Condensed', "Roboto+Slab" => 'Roboto Slab');
}

/**
 * Bind JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since WhiteLab 1.0
 */
function whitelab_customize_preview_js() {
	wp_enqueue_script( 'directory_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20131205', true );
}
add_action( 'customize_preview_init', 'whitelab_customize_preview_js' );