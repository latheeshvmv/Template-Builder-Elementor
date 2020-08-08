jQuery( function( $ ) {
  'use strict';
    if ( typeof elementor != "undefined" && typeof elementor.settings.page != "undefined") {

        elementor.settings.page.addChangeCallback( 'tmpenvo_d_custom_post_selector', function( newValue ) {
            elementor.saver.saveEditor( {
                onSuccess: function() {
                    elementor.reloadPreview();
                    elementor.once( 'preview:loaded', function() {
                        elementor.getPanelView().footer.currentView.showSettingsPage("page_settings");
                        elementor.getPanelView().getCurrentPageView().activateSection("tmpenvo_custom_section");
                        elementor.getPanelView().getCurrentPageView()._renderChildren();
                    } );
                }
            } );
        } );

        elementor.settings.page.addChangeCallback( 'tmpenvo_d_custom_post_selector_id_setter', function( newValue ) {
            elementor.saver.saveEditor( {
                onSuccess: function() {
                    elementor.reloadPreview();
                    elementor.once( 'preview:loaded', function() {
                        elementor.getPanelView().footer.currentView.showSettingsPage("page_settings");
                        elementor.getPanelView().getCurrentPageView().activateSection("tmpenvo_custom_section");
                        elementor.getPanelView().getCurrentPageView()._renderChildren();
                    } );
                }
            } );
        } );
    }

} );
