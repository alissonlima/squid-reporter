var htmlarea;

jHtmlArea.defaultOptions.toolbar.push([
    {
        // This is how to add a completely custom Toolbar Button
        css: "datebutton",
        text: "Today's Date",
        action: function(btn) {
            // 'this' = jHtmlArea object
            // 'btn' = jQuery object that represents the <A> "anchor" tag for the Toolbar Button

            var m_names = new Array("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Septembro", "Outobro", "Novembro", "Dezembro");

            var d = new Date();
            var curr_date = d.getDate();
            var curr_month = d.getMonth();
            var curr_year = d.getFullYear();
            //this.pasteHTML(m_names[curr_month] + " " + curr_date + ", " + curr_year);
            this.pasteHTML( curr_date + " de " + m_names[curr_month] + " de " + curr_year);
        }
    }
]);

function select_gallery(htmlarea_obj)
{
	htmlarea = htmlarea_obj;

	var url = '/mailing/index/jsongetgalleries';

	jQuery.getJSON(url, function(data) {
		var items = [];

		jQuery.each(data, function(key, val) {
		    items.push('<option value="' + key + '">' + val + '</option>');
		});
		
		var buffer = 'Selectione uma galeria: <select id="gallery_id" name="gallery_id"><option></option>' + items.join('') + '</select><div id="image_list"></div>';
		jQuery('#stage').html(buffer);	

		jQuery('#gallery_id').change(function() {
			select_gallery_image(jQuery('#gallery_id').val());
		});

		jQuery("#stage").dialog('open');
	});
}

function select_gallery_image(gallery_id)
{
	var url = '/mailing/index/jsongetgalleryimages/id/' + gallery_id;
	jQuery.getJSON(url, function(data) {
		var items = [];

		jQuery.each(data, function(key, val) {
		    items.push('<img src="' + val + '" width="80" height="60" style="float: left;"/>');
		});
		var buffer = items.join('');
		jQuery('#image_list').html(buffer);
		jQuery('#image_list img').click(function() {
			jQuery("#stage").html('');
			jQuery("#stage").dialog('close');
			var image = '<img src="' + jQuery(this).attr('src') + '"/>';
			htmlarea.pasteHTML(image);
		});
	});
}


jHtmlArea.defaultOptions.toolbar.push([
    {
        // This is how to add a completely custom Toolbar Button
        css: "gallery",
        text: "galeria",
        action: function(btn) {
		select_gallery(this);
        }
    }
]);


jQuery(document).ready(function(){

	jQuery('#email_body').htmlarea();

 	jQuery("#stage").dialog(
            {
                autoOpen: false,
                modal: true,
		title: 'galerias',
                overlay: { opacity: 0.2, background: "cyan" },
                width: 450,
                height: 470,
                position: [520, 180],
/*

                close: function(event, ui) {
                    fnHideDatePicker();
                }
*/
            }
      );
});

