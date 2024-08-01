<?php
namespace InfluencersElementorWidgets\Widgets\PodcastGridStyle2;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Widget_PodcastGridStyle2 extends Widget_Base {

	public function get_name() {
		return 'bt-podcast-grid-style-2';
	}

	public function get_title() {
		return __( 'Podcast Grid Style 2', 'influencers' );
	}

  public function get_icon() {
		return 'eicon-posts-ticker';
	}

	public function get_categories() {
		return [ 'influencers' ];
	}

	protected function get_supported_ids() {
		$supported_ids = [];

		$wp_query = new \WP_Query( array(
									'post_type' => 'podcast',
									'post_status' => 'publish'
								) );

		if ( $wp_query->have_posts() ) {
	    while ( $wp_query->have_posts() ) {
        $wp_query->the_post();
        $supported_ids[get_the_ID()] = get_the_title();
	    }
		}

		return $supported_ids;
	}

	public function get_supported_taxonomies() {
		$supported_taxonomies = [];

		$categories = get_terms( array(
			'taxonomy' => 'podcast_categories',
	    'hide_empty' => false,
		) );
		if( ! empty( $categories )  && ! is_wp_error( $categories ) ) {
			foreach ( $categories as $category ) {
			    $supported_taxonomies[$category->term_id] = $category->name;
			}
		}

		return $supported_taxonomies;
	}

	protected function register_layout_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'influencers' ),
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Posts Per Page', 'influencers' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

    $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'label' => __( 'Image Size', 'influencers' ),
				'show_label' => true,
				'default' => 'medium_large',
				'exclude' => [ 'custom' ],
			]
		);

    $this->add_control(
			'show_pagination',
			[
				'label' => __( 'Pagination', 'influencers' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'influencers' ),
				'label_off' => __( 'Hide', 'influencers' ),
				'default' => '',
			]
		);

		$this->end_controls_section();
	}

	protected function register_query_section_controls() {
		$this->start_controls_section(
			'section_query',
			[
				'label' => __( 'Query', 'influencers' ),
			]
		);

		$this->start_controls_tabs( 'tabs_query' );

		$this->start_controls_tab(
			'tab_query_include',
			[
				'label' => __( 'Include', 'influencers' ),
			]
		);

		$this->add_control(
			'ids',
			[
				'label' => __( 'Ids', 'influencers' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_supported_ids(),
				'label_block' => true,
				'multiple' => true,
			]
		);

		$this->add_control(
			'category',
			[
				'label' => __( 'Category', 'influencers' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_supported_taxonomies(),
				'label_block' => true,
				'multiple' => true,
			]
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'tab_query_exnlude',
			[
				'label' => __( 'Exclude', 'influencers' ),
			]
		);

		$this->add_control(
			'ids_exclude',
			[
				'label' => __( 'Ids', 'influencers' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_supported_ids(),
				'label_block' => true,
				'multiple' => true,
			]
		);

		$this->add_control(
			'category_exclude',
			[
				'label' => __( 'Category', 'influencers' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_supported_taxonomies(),
				'label_block' => true,
				'multiple' => true,
			]
		);

		$this->add_control(
			'offset',
			[
				'label' => __( 'Offset', 'influencers' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'description' => __( 'Use this setting to skip over posts (e.g. \'2\' to skip over 2 posts).', 'influencers' ),
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order By', 'influencers' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post_date',
				'options' => [
					'post_date' => __( 'Date', 'influencers' ),
					'post_title' => __( 'Title', 'influencers' ),
					'menu_order' => __( 'Menu Order', 'influencers' ),
					'rand' => __( 'Random', 'influencers' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'influencers' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc' => __( 'ASC', 'influencers' ),
					'desc' => __( 'DESC', 'influencers' ),
				],
			]
		);

		$this->end_controls_section();
	}


	protected function register_style_section_controls() {
		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'influencers' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'img_border_radius',
			[
				'label' => __( 'Border Radius', 'influencers' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .bt-post--thumbnail .bt-cover-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'thumbnail_effects_tabs' );

		$this->start_controls_tab( 'thumbnail_tab_normal',
			[
				'label' => __( 'Normal', 'influencers' ),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'thumbnail_filters',
				'selector' => '{{WRAPPER}} .bt-post--thumbnail img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'thumbnail_tab_hover',
			[
				'label' => __( 'Hover', 'influencers' ),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'thumbnail_hover_filters',
				'selector' => '{{WRAPPER}} .bt-post:hover .bt-post--thumbnail img',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

    $this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'influencers' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_style',
			[
				'label' => __( 'Title', 'influencers' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'influencers' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-post--title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label' => __( 'Color Hover', 'influencers' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-post--title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'influencers' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-post--title',
			]
		);

		$this->add_control(
			'category_style',
			[
				'label' => __( 'Category', 'influencers' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'category_color',
			[
				'label' => __( 'Color', 'influencers' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-post--category' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'category_color_hover',
			[
				'label' => __( 'Color Hover', 'influencers' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-post--category a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'category_typography',
				'label' => __( 'Typography', 'influencers' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-post--category',
			]
		);

		$this->add_control(
			'play_link_style',
			[
				'label' => __( 'Play Link', 'influencers' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'play_link_color',
			[
				'label' => __( 'Color', 'influencers' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-post--pod-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'play_link_color_hover',
			[
				'label' => __( 'Color Hover', 'influencers' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-post--pod-link a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'play_link_typography',
				'label' => __( 'Typography', 'influencers' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-post--pod-link',
			]
		);

		$this->end_controls_section();

    $this->start_controls_section(
			'section_style_pagination',
			[
				'label' => esc_html__( 'Pagination', 'influencers' ),
				'tab' => Controls_Manager::TAB_STYLE,
        'condition' => [
					'show_pagination!'=> '',
				],
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label' => __( 'Color', 'influencers' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-pagination .page-numbers:not(.current)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pagination_color_hover',
			[
				'label' => __( 'Color Hover', 'influencers' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-pagination .page-numbers:not(.current, .dots):hover' => 'color: {{VALUE}};',
				],
			]
		);

    $this->add_control(
			'pagination_color_current',
			[
				'label' => __( 'Color Current', 'influencers' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-pagination .page-numbers.current' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pagination_typography',
				'label' => __( 'Typography', 'influencers' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-pagination .page-numbers',
			]
		);

    $this->add_responsive_control(
			'pagination_space',
			[
				'label' => __( 'Space', 'influencers' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 60,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bt-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_controls() {

		$this->register_layout_section_controls();
		$this->register_query_section_controls();

		$this->register_style_section_controls();

	}

	public function query_posts() {
		$settings = $this->get_settings_for_display();

		$args = [
			'post_type' => 'podcast',
			'post_status' => 'publish',
			'posts_per_page' => $settings['posts_per_page'],
			'orderby' => $settings['orderby'],
			'order' => $settings['order'],
		];

		if($settings['show_pagination'] == 'yes') {
			$args['paged'] = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		}

		if( ! empty( $settings['ids'] ) ) {
			$args['post__in'] = $settings['ids'];
		}

		if( ! empty( $settings['ids_exclude'] ) ) {
			$args['post__not_in'] = $settings['ids_exclude'];
		}

		if( ! empty( $settings['category'] ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' 		=> 'podcast_categories',
					'terms' 		=> $settings['category'],
					'field' 		=> 'term_id',
					'operator' 		=> 'IN'
				)
			);
		}

		if( ! empty( $settings['category_exclude'] ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' 		=> 'podcast_categories',
					'terms' 		=> $settings['category_exclude'],
					'field' 		=> 'term_id',
					'operator' 		=> 'NOT IN'
				)
			);
		}

		if( 0 !== absint( $settings['offset'] ) ) {
			$args['offset'] = $settings['offset'];
		}

		return $query = new \WP_Query( $args );
	}

	protected function render() {
    $settings = $this->get_settings_for_display();
		$query = $this->query_posts();

    ?>
      <div class="bt-elwg-podcast-grid--style-2">
        <?php
          if( $query->have_posts() ) {
            ?>
              <div class="bt-podcast-grid">
                <?php
                  while ( $query->have_posts() ) : $query->the_post();
                    get_template_part( 'framework/templates/podcast', 'style', array('image-size' => $settings['thumbnail_size'], 'layout' => 'style-2'));
                  endwhile;
                ?>
              </div>
            <?php
            if($settings['show_pagination'] == 'yes') {
              influencers_paginate_links($query);
            }
          } else {
            get_template_part( 'framework/templates/post', 'none');
          }
        ?>
      </div>
    <?php
		wp_reset_postdata();
	}

	protected function content_template() {

	}

}
