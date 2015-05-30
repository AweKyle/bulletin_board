var ArrCourseGroup = new Array();


function saveValue() {
	/*var courseGroup - многомерный массив, 0 элемент каждого подмассива - курс. остальные элементы - группы*/
	var course = jQuery(".courses:checked").val();
	var group = jQuery(".groups:checked");
	var courseGroup = [];
	var checkedGroup = [];

	console.log(group);

	courseGroup.push(course);
	for(var i = 0; i < group.length; i++){
		courseGroup.push(group[i].value);
		checkedGroup.push(group[i].value);
	}

	ArrCourseGroup.push(courseGroup);

	console.log(ArrCourseGroup);

	jQuery(".selectors").before("<div class='added'><span class='del_courseGroup'>x</span><span>Курс: "+course+"</span> <span>Группа: "+checkedGroup.join(", ")+"</div>");
}

jQuery(function() {
	var saveBlock = jQuery('.selectors').html();
	jQuery(".btn_add").on('click', function() {
		if (jQuery(".courses:checked").val() === undefined) {
    		alert('Выберите курс');
    	}
    	else {
			saveValue();
			jQuery(".selectors").empty();
    		jQuery(".selectors").append(saveBlock);
    	}
	});

	jQuery(".type_radio").on( "click", function() {
        jQuery('.select_type').val(jQuery(".type_radio:checked").val());
    });


    jQuery("#publish").click(function() {
    	if (ArrCourseGroup.length != 0 || jQuery(".courses:checked").val() != undefined) {
			if (ArrCourseGroup.length === 0 && jQuery(".courses:checked").val() != undefined) {
				saveValue();
			}
			jQuery("#CourseGroup").val(JSON.stringify(ArrCourseGroup));
			alert(jQuery("#CourseGroup").val());
		}
    });



});