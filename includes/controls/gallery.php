<?php
namespace Elementor;

use Elementor\TemplateLibrary\Classes\Import_Images;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Control_Gallery extends Control_Base {

	public function get_type() {
		return 'gallery';
	}

	public function on_import( $settings ) {
		foreach ( $settings as &$attachment ) {
			if ( empty( $attachment['url'] ) )
				continue;

			$attachment = Import_Images::instance()->import( $attachment );
		}

		// Filter out attachments that doesn't exist
		$settings = array_filter( $settings );

		return $settings;
	}

	public function content_template() {
		?>
		<div class="elementor-control-field">
			<div class="elementor-control-input-wrapper">
				<# if ( data.description ) { #>
				<div class="elementor-control-description">{{{ data.description }}}</div>
				<# } #>
				<div class="elementor-control-media">
					<div class="elementor-control-gallery-status">
						<span class="elementor-control-gallery-status-title">
							<# if ( data.controlValue.length ) {
								print( elementor.translate( 'gallery_images_selected', [ data.controlValue.length ] ) );
							} else { #>
								<?php _e( 'No Images Selected', 'elementor' ); ?>
							<# } #>
						</span>
						<span class="elementor-control-gallery-clear">(<?php _e( 'Clear', 'elementor' ); ?>)</span>
					</div>
					<div class="elementor-control-gallery-thumbnails">
						<# _.each( data.controlValue, function( image ) { #>
							<div class="elementor-control-gallery-thumbnail" style="background-image: url({{ image.url }})"></div>
						<# } ); #>
					</div>
					<button class="elementor-button elementor-control-gallery-add"><?php _e( '+ Add Images', 'elementor' ); ?></button>
				</div>
			</div>
		</div>
		<?php
	}

	protected function get_default_settings() {
		return [
			'label_block' => true,
			'separator' => 'none',
		];
	}

	public function get_default_value() {
		return [];
	}
}
