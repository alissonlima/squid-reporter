var programs = [];

function ChannelInfo() {
        this.name = 'Praça';
        this.ID = 0;
}

jQuery(document).ready(function() {


   var $calendar = $('#calendar');
   var id = 10;

   $calendar.weekCalendar({
			timeslotsPerHour: 12,
			firstDayOfWeek : 1,
			startParam: 'início',
			endParam: 'término',
			newEventText: 'Novo ítem',
			timeSeparator: ' até ',
        		allowEventDelete: false,
        		allowCalEventOverlap: false,
        		overlapEventsSeparate: false,

      displayOddEven:true,
      firstDayOfWeek : 1,
      daysToShow : 7,
      //switchDisplay: {'1 day': 1, '3 next days': 3, 'work week': 5, 'full week': 7},
      title: function(daysToShow) {
			//return daysToShow == 1 ? '%date%' : '%start% - %end%';
	return Channel.name;
      },
      height : function($calendar) {
         return $(window).height() - $("h1").outerHeight() - 1;
      },
      eventRender : function(calEvent, $event) {
         if (calEvent.end.getTime() < new Date().getTime()) {
            $event.css("backgroundColor", "#aaa");
            $event.find(".wc-time").css({
               "backgroundColor" : "#999",
               "border" : "1px solid #888"
            });
         }
      },
      draggable : function(calEvent, $event) {
         return calEvent.readOnly != true;
      },
      resizable : function(calEvent, $event) {
         return calEvent.readOnly != true;
      },
      eventNew : function(calEvent, $event) {
         var $dialogContent = $("#event_edit_container");
         resetForm($dialogContent);
         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         var bodyField = $dialogContent.find("textarea[name='body']");
         var programField = $dialogContent.find("select[name='program']").val(calEvent.program);
         var channelsField = $dialogContent.find("input[name='channels']").val(calEvent.channels);
 	 setupProgramListSelect(programField, calEvent);


         $dialogContent.dialog({
            modal: true,
            title: "Novo ítem",
	    //width: 1000,
	    width: 'auto',
	   // height: 800,
	    height: 'auto',
            close: function() {
               $dialogContent.dialog("destroy");
               $dialogContent.hide();
               $('#calendar').weekCalendar("removeUnsavedEvents");
            },
            buttons: {
               save : function() {
                  calEvent.id = id;
                  id++;
                  calEvent.start = new Date(startField.val());
                  calEvent.startGMT = startField.val();
                  calEvent.end = new Date(endField.val());
                  calEvent.endGMT = endField.val();
                  calEvent.title = programs[programField.val()];
                  calEvent.program = programField.val();
		  calEvent.body = bodyField.val();
		  calEvent.channels = channelsField.val();

			//alert('save');

		  var url = "/Schedule/Schedulejson/newevent/id_channel/" + Channel.ID;
		  jQuery.post(url,
			{
			programID: calEvent.program,
			programName: calEvent.title,
			startTime: calEvent.startGMT,
			endTime: calEvent.endGMT,
		      },function(result){
			//alert(result);
			calEvent.id = result;
		  });	
                  $calendar.weekCalendar("removeUnsavedEvents");
                  $calendar.weekCalendar("updateEvent", calEvent);
                  $dialogContent.dialog("close");
               },
               cancel : function() {
                  $dialogContent.dialog("close");
               }
            }
         }).show();

         $dialogContent.find(".date_holder").text($calendar.weekCalendar("formatDate", calEvent.start));
         setupStartAndEndTimeFields(startField, endField, calEvent, $calendar.weekCalendar("getTimeslotTimes", calEvent.start));
 	 setupProgramListSelect(programField, calEvent);
	 setupChannelListCheckboxes(calEvent);

      },
      eventDrop : function(calEvent, $event) {
      	moveEvent(calEvent)  
      },
      eventResize : function(calEvent, $event) {
	moveEvent(calEvent);
      },
      eventClick : function(calEvent, $event) {

         if (calEvent.readOnly) {
            return;
         }

         var $dialogContent = $("#event_edit_container");
         resetForm($dialogContent);
         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         var bodyField = $dialogContent.find("textarea[name='body']");
         var programField = $dialogContent.find("select[name='program']").val(calEvent.program);
         var titleField = programs[$dialogContent.find("select[name='program']").val(calEvent.program)];
         var channelsField = $dialogContent.find("input[name='channels']");

         $dialogContent.dialog({
            modal: true,
            title: "Edit - " + calEvent.title,
            close: function() {
               $dialogContent.dialog("destroy");
               $dialogContent.hide();
               $('#calendar').weekCalendar("removeUnsavedEvents");
            },
            buttons: {
               save : function() {

                  calEvent.body = bodyField.val();
                  calEvent.program = programField.val();
                  calEvent.title = programs[programField.val()];
                  calEvent.channels = channelsField.val();
                 
		  calEvent.start = new Date(startField.val());
                  calEvent.startGMT = startField.val();
                  calEvent.end = new Date(endField.val());
                  calEvent.endGMT = endField.val();

		var ch = [];
		jQuery('#channel_list :checkbox:checked').each(function() {
			var value = jQuery(this).val();
			if(value != '')
			{
				ch.push(value);
			}
		});
		
		alert('Channels:: ' + ch.join(', '));
	
		  var url = "/Schedule/Schedulejson/updateevent/id_channel/" + Channel.ID;
		  jQuery.post(url,
			{
			id: calEvent.id,
			programID: calEvent.program,
			programName: calEvent.title,
			startTime: calEvent.startGMT,
			endTime: calEvent.endGMT,
			channels: ch.join(','),
		      },function(result){
			//alert(result);
		//    $("span").html(result);
		  });	

                  $calendar.weekCalendar("updateEvent", calEvent);
                  $dialogContent.dialog("close");
               },
               "delete" : function() {
                  $calendar.weekCalendar("removeEvent", calEvent.id);
		  deleteEvent(calEvent);
                  $dialogContent.dialog("close");
               },
               cancel : function() {
                  $dialogContent.dialog("close");
               }
            }
         }).show();

         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         $dialogContent.find(".date_holder").text($calendar.weekCalendar("formatDate", calEvent.start));
         setupStartAndEndTimeFields(startField, endField, calEvent, $calendar.weekCalendar("getTimeslotTimes", calEvent.start));
 	 setupProgramListSelect(programField, calEvent);
	 setupChannelListCheckboxes(calEvent);
         $(window).resize().resize(); //fixes a bug in modal overlay size ??

      },
      eventMouseover : function(calEvent, $event) {
      },
      eventMouseout : function(calEvent, $event) {
      },
      noEvents : function() {

      },

	data: function(start, end, callback) { 
        jQuery.getJSON("/Schedule/Schedulejson/getlistings/id_channel/" + Channel.ID, { 
                start: start.getTime(), 
                end: end.getTime()  }, 
        function(result) { 
	      //alert(result);
              var calevents = result; 
              callback(calevents); 
        }); 
        } 

   });

   function resetForm($dialogContent) {
      $dialogContent.find("input").val("");
      $dialogContent.find("textarea").val("");
      $dialogContent.find("select").val("");
   }

   function getEventData() {
      var year = new Date().getFullYear();
      var month = new Date().getMonth();
      var day = new Date().getDate();

	var eves = [];

	var urlJson = "/Schedule/Schedulejson/getlistings/id_channel/" + Channel.ID;
	jQuery.ajax({ type: 'POST', url: urlJson, dataType: 'json', cache: false, success: function(result) { data = {events : result} } });


      return {
         events : [
         ]
      };
   }

   function deleteEvent(calEvent)
   {
	var urlJson = "/Schedule/Schedulejson/deleteevent/id_channel/" + Channel.ID + '/id/' + calEvent.id;
	var params = { channel: Channel.ID, id: calEvent.id, 'start': calEvent.start.toString(), 'end': calEvent.end.toString() ,'dude': 'libowsky'};

	jQuery.post(urlJson, params ,function(data) {
		//alert('deleted:: ' + calEvent.id);
	});
   }

   function moveEvent(calEvent)
   {
	var urlJson = "/Schedule/Schedulejson/moveeevent/id_channel/" + Channel.ID + '/id/' + calEvent.id;

	//alert(calEvent.start + ' :: ' + calEvent.end);

	var params = { channel: Channel.ID, id: calEvent.id, 'start': calEvent.start.toString(), 'end': calEvent.end.toString(), 'programID': calEvent.program };

	jQuery.post(urlJson, params ,function(data) {
		//alert('move');
	});
	//jQuery.ajax({ type: 'POST', url: urlJson, dataType: 'json', cache: false, success: function(result) { data = {events : result} } });
   }

   function setupProgramListSelect($programField, calEvent)
   {
        $programField.empty();

	programs = [];
	var urlJson = "/Schedule/Schedulejson/getprogramshtml";
	jQuery.ajax({ type: 'POST', url: urlJson,  cache: false, success: function(result) { $programField.append(result); $programField.val(calEvent.program); } });

	var url = '/Schedule/Schedulejson/getprograms';
        jQuery.getJSON(url, function(data) {
                jQuery.each(data, function(key, val) {
                        programs[key] = val;
                });
        });
    }

   function setupChannelListCheckboxes(calEvent)
   {
	var urlJson = "/Schedule/Schedulejson/getchannelshtml";
	jQuery.ajax({ type: 'POST', url: urlJson,  cache: false, success: function(result) { jQuery('#channel_list').html(result); populateChannelListChecboxes(calEvent);} });


    }

	function populateChannelListChecboxes(calEvent)
	{
		var channels = calEvent.channels.split(',');
		jQuery('input[type=checkbox]').each(function (value) {
			var channel =  jQuery(this).val();
			var channelObj =  jQuery(this);
			jQuery.each(channels, function(index, value) 
			{
				if(value == channel)
				{
					channelObj.attr('checked','true');
				}
			}); 
			
		}); 
	}


   /*
    * Sets up the start and end time fields in the calendar event
    * form for editing based on the calendar event being edited
    */
   /*
    * Sets up the start and end time fields in the calendar event
    * form for editing based on the calendar event being edited
    */
   function setupStartAndEndTimeFields($startTimeField, $endTimeField, calEvent, timeslotTimes) {

      $startTimeField.empty();
      $endTimeField.empty();
	

      for (var i = 0; i < timeslotTimes.length; i++) {
         var startTime = timeslotTimes[i].start;
         var endTime = timeslotTimes[i].end;
         var startSelected = "";
         if (startTime.getTime() === calEvent.start.getTime()) {
            startSelected = "selected=\"selected\"";
         }
         var endSelected = "";
         if (endTime.getTime() === calEvent.end.getTime()) {
            endSelected = "selected=\"selected\"";
         }
         $startTimeField.append("<option value=\"" + startTime + "\" " + startSelected + ">" + timeslotTimes[i].startFormatted + "</option>");
         $endTimeField.append("<option value=\"" + endTime + "\" " + endSelected + ">" + timeslotTimes[i].endFormatted + "</option>");

         $timestampsOfOptions.start[timeslotTimes[i].startFormatted] = startTime.getTime();
         $timestampsOfOptions.end[timeslotTimes[i].endFormatted] = endTime.getTime();

      }
      $endTimeOptions = $endTimeField.find("option");
      $startTimeField.trigger("change");
   }

   var $endTimeField = $("select[name='end']");
   var $endTimeOptions = $endTimeField.find("option");
   var $timestampsOfOptions = {start:[],end:[]};

   //reduces the end time options to be only after the start time options.
   $("select[name='start']").change(function() {
      var startTime = $timestampsOfOptions.start[$(this).find(":selected").text()];
      var currentEndTime = $endTimeField.find("option:selected").val();
      $endTimeField.html(
            $endTimeOptions.filter(function() {
               return startTime < $timestampsOfOptions.end[$(this).text()];
            })
            );

      var endTimeSelected = false;
      $endTimeField.find("option").each(function() {
         if ($(this).val() === currentEndTime) {
            $(this).attr("selected", "selected");
            endTimeSelected = true;
            return false;
         }
      });

      if (!endTimeSelected) {
         //automatically select an end date 2 slots away.
         $endTimeField.find("option:eq(1)").attr("selected", "selected");
      }

   });


   var $about = $("#about");

   $("#about_button").click(function() {
      $about.dialog({
         title: "About this calendar demo",
         width: 600,
         close: function() {
            $about.dialog("destroy");
            $about.hide();
         },
         buttons: {
            close : function() {
               $about.dialog("close");
            }
         }
      }).show();
   });


});
