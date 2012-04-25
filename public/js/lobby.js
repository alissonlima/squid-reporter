jQuery(document).ready(function(){
        var url = 'http://redecnt.apps/lobby/index/getvisitorsjson';
        jQuery.getJSON(url, function(data) {
          var items = [];
          jQuery.each(data, function(key, val) {
		var itembuff = '<div class="visitor"><b>' + val.name + '</b>';
		itembuff += '<img src="/images/lobby/image.png" height="70" width="55" class="visitor-img" style="float: left;"/>';
		itembuff += '<br/><i>S&F S.A.</i> - (41) 9906-6924</br>';
		itembuff += 'TI - Fernando Michelotti - ramal 197</br>';
		itembuff += '10:25 - </br>';
		itembuff += '<a href="" class="visitor-out">saída</a></br>';
		itembuff += '</div>';
            	//items.push('<li id="' + val.id + '">' + val.name + '</li>');
            	items.push(itembuff);
          });
          var buffer = '<ul>' + items.join('') + '</ul>';
          jQuery('#show-visitors').html(buffer);

        });
});

