<?php
namespace InfluencersElementorWidgets\Widgets\OrbitCircle;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Widget_OrbitCircle extends Widget_Base {

	public function get_name() {
		return 'bt-orbit-circle';
	}

	public function get_title() {
		return __( 'Orbit Circle', 'influencers' );
	}

	public function get_icon() {
		return 'eicon-posts-ticker';
	}

	public function get_categories() {
		return [ 'influencers' ];
	}

	protected function register_content_section_controls() {

	}

	protected function register_style_content_section_controls() {

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'influencers' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'circle_size',
			[
				'label' => __( 'Size', 'influencers' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'size' => 56,
					'unit' => 'vw',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'body' => '--circle-diameter: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'circle_color',
			[
				'label' => __( 'Line Color', 'influencers' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-orbit-wrap' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dot_style',
			[
				'label' => __( 'Dots', 'influencers' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'red_dot_color',
			[
				'label' => __( 'Color 1', 'influencers' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-orbit.red span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'blue_dot_color',
			[
				'label' => __( 'Color 2', 'influencers' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-orbit.blue span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'yellow_dot_color',
			[
				'label' => __( 'Color 3', 'influencers' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-orbit.yellow span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'purple_dot_color',
			[
				'label' => __( 'Color 4', 'influencers' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-orbit.purple span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'green_dot_color',
			[
				'label' => __( 'Color 5', 'influencers' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-orbit.green span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function register_controls() {
		$this->register_content_section_controls();
		$this->register_style_content_section_controls();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		?>
		<div class="bt-elwg-orbit-circle">
			<div class="bt-orbit-wrap">
				<div class="bt-orbit red"><span></span></div>
				<div class="bt-orbit blue"><span></span></div>
				<div class="bt-orbit yellow"><span></span></div>
				<div class="bt-orbit purple"><span></span></div>
				<div class="bt-orbit green"><span></span></div>
			</div>
		</div>
		<?php
	}

	protected function content_template() {

	}
}
