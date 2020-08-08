<?php
namespace Elementor;
if (!defined('ABSPATH')) {
		exit;
}
class GgowlWidget_Video extends \Elementor\Widget_Base {


	public function get_name() {
		return 'tmpenvo_acf_video';
	}


	public function get_title() {
		return esc_html__('ACF Video', 'tmpenvo' );
	}


	public function get_icon() {
		return 'fas fa-laptop-code';
	}

	public function get_keywords() {
		return ['owl', 'video', 'acf'];
	}

	public function get_categories() {
		return [ 'tmpenvo-category' ];
	}

  private function get_acf_list(){
    global $wpdb;
    $tmpenvo_qry =  "SELECT post_excerpt as 'field_name', post_title as 'field_label' FROM {$wpdb->prefix}posts where post_type = 'acf-field'";
    $tmpenvo_list_results = $wpdb->get_results( $tmpenvo_qry, ARRAY_A );
    $acf_field_array = array();
    if(!empty($tmpenvo_list_results)){
      foreach ($tmpenvo_list_results as $value) {
        $acf_field_array[$value['field_name']]= $value['field_label'];
      }
    }
    return $acf_field_array;
  }


	protected function _register_controls() {

		$this->start_controls_section(
			'tmpenvo_acf_video_control',
			[
				'label' => esc_html__( 'Customize ACF Video ', 'tmpenvo' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

    $this->add_control(
        'fieldtype_setter_video',
        [
            'label'       => esc_html__('Field Key Setter', 'tmpenvo'),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => 'manual',
            'options'     => [
                'manual'     => esc_html__('Type Field Key Manually', 'tmpenvo'),
                'list'    => esc_html__('Choose Field Key From List', 'tmpenvo'),
            ],
            'description' => esc_html__('', 'tmpenvo'),
        ]
    );


    $this->add_control(
        'tmpenvo_field_name_video',
        [
            'label'       => esc_html__('Custom Field Name (Key)', 'tmpenvo'),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'placeholder' => esc_html__('Type field name here.', 'tmpenvo'),
            'condition'       => [
                'fieldtype_setter_video' => ['manual'],
            ],
        ]
    );


    $this->add_control(
        'fieldtype_setter_list_video',
        [
            'label'       => esc_html__('Custom Field Name', 'tmpenvo'),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => 'manual',
            'options'     => $this->get_acf_list(),
            'description' => esc_html__('', 'tmpenvo'),
            'condition'       => [
                'fieldtype_setter_video' => ['list'],
            ],
        ]
    );

    $this->add_control(
			'youtube_vide_autoplay_setter',
			[
				'label' => esc_html__( 'Enable Autoplay', 'tmpenvo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'your-plugin' ),
				'label_off' => esc_html__( 'No', 'your-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->end_controls_section();
	}


	protected function render() {
		$settings = $this->get_settings_for_display();
		$tmpenvo_acf_video_instance =new \TMPENVOHELPERNS\GgowlHelper();
		global $post;
		if($post->post_type == 'tmpenvo_template'):
				$post_id = get_the_ID();
				$tmpenvo_post_type = $tmpenvo_acf_video_instance->tmpenvo_active_post_template($post_id);
				$tmpenvo_id = $tmpenvo_acf_video_instance->tmpenvo_single_post_returner($tmpenvo_post_type);
				if(is_int($tmpenvo_id)){
					if( $tmpenvo_acf_video_instance->tmpenvo_acf_video_render($settings,$tmpenvo_id) === NULL ){
						return;
					}
              $tmpenvo_acf_video_instance->tmpenvo_acf_video_render($settings,$tmpenvo_id);

				}else{
					$tmpenvo_id;
				}
		else:
      $tmpenvo_id = get_the_id();
          $tmpenvo_acf_video_instance->tmpenvo_acf_video_render($settings,$tmpenvo_id);      
		endif;

	}

}
