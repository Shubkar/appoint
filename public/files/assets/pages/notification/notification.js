  'use strict';
function notify(from,align,icon,type,animIn,animOut,message){
		//var from = $(ele).attr('data-from');
        //var align = $(ele).attr('data-align');
        //var icon = $(ele).attr('data-icon');
        //var type = $(ele).attr('data-type');
        //var animIn = $(ele).attr('data-animation-in');
        //var animOut = $(ele).attr('data-animation-out');
		//var title = $(ele).attr('data-title');
		var title='';
		//var message = $(ele).attr('data-message');
        $.growl({
            icon: icon,
            title: title,
            message: message,
            url: ''
        },{
            element: 'body',
            type: type,
            allow_dismiss: true,
            placement: {
                from: from,
                align: align
            },
            offset: {
                x: 30,
                y: 30
            },
            spacing: 10,
            z_index: 999999,
            delay: 2500,
            timer: 1000,
            url_target: '_blank',
            mouse_over: false,
            animate: {
                enter: animIn,
                exit: animOut
            },
            icon_type: 'class',
            template: '<div data-growl="container" class="alert" role="alert">' +
            '<button type="button" class="close" data-growl="dismiss">' +
            '<span aria-hidden="true">&times;</span>' +
            '<span class="sr-only">Close</span>' +
            '</button>' +
            '<span data-growl="icon" style="margin-right:10px;"></span>' +
            '<span data-growl="title"></span>' +
            '<span data-growl="message"></span>' +
            '<a href="#" data-growl="url"></a>' +
            '</div>'
        });
    }