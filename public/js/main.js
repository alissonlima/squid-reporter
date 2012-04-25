jQuery(function(){
	jQuery('ul.navigation').addClass('sf-menu');
	jQuery('ul.sf-menu').superfish();
	jQuery( '#tabs').tabs();
	jQuery('#description').htmlarea();
/*
	jQuery('#description').htmlarea({
		toolbar: [
                    ["bold", "italic", "underline", "|", "forecolor"],
                    ["h1", "h2", "h3", "h4", "h5", "h6"],
                    ["link", "unlink", "|", "image"],                    
                    [{
                        css: "custom_disk_button",
                        text: "Save",
                        action: function(btn) {
                            // 'this' = jHtmlArea object
                            // 'btn' = jQuery object that represents the <A> "anchor" tag for the Toolbar Button
                            alert('SAVE!\n\n' + this.toHtmlString());
                        }
                    }],
                    [{
                        css: "custom_media_gallery",
                        text: "Medias",
                        action: function(btn) {
                            // 'this' = jHtmlArea object
                            // 'btn' = jQuery object that represents the <A> "anchor" tag for the Toolbar Button
                            alert('show custom media gallery settings');
                        }
                    }]
                ],
	});
*/
});
