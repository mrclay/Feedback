function Feedback_init() {
    var $ = this.jQuery
       ,b = document.body
       ,c = Feedback_config
       ,formLoaded = 0
       ,formDisplayed = false
    ;

    function submitForm() {
        // validate
        if (window.Feedback_formIsValid) {
            if (! Feedback_formIsValid($)) {
                return false;
            }
        }
        // send
        $('#Feedback form')
            .addClass('submitting')
            .fadeTo(300, .5);
        $('#Feedback_submit').attr('disabled', 'disabled');
        formLoaded = 0; // after submitting this, we'll need to reload form to get new CSRF token
        $.ajax({
            type: 'POST'
            ,url: c.url + '/send'
            ,data: $(this).serialize()
            ,success: function (html) {
                if (html) {
                    $('#Feedback_inner').html(html);
                    $('#Feedback_response').click(toggle);
                }
            }
            ,dataType: 'html'
        });
        return false;
    }

    function loadForm() {
        formLoaded = 1;
        $('#Feedback_inner')
            .load(c.url + '/form', function () {
                // form loaded
                $('#Feedback').css({cursor: 'default'});
                $('#Feedback_url').val(location.href);
                $('#Feedback form').submit(submitForm);
                window.Feedback_afterFormLoad && Feedback_afterFormLoad($);
            });
    }

    function toggle() {
        if (formDisplayed) {
            $('#Feedback')
                .removeClass('visible')
                .animate({
                    left: -c.formSize[0] + 'px'
                });
            $('#Feedback_open')
                .animate({
                    right: -c.imgSize[0] + 'px'
                });
        } else {
            if (! formLoaded) {
                loadForm();
            }
            $('#Feedback_open')
                .animate({
                    right: '0px'
                });
            $('#Feedback')
                .addClass('visible')
                .animate({
                    left: '0px'
                });
        }
        formDisplayed = !formDisplayed;
    }

    function setup() {
        var d = $('<div id="Feedback"><div id="Feedback_inner"></div>'
                  + '<img id="Feedback_open" src="' + c.url + '/static/feedback.gif" /></div>')
                .css({
                    position:'fixed'
                    ,top: Math.round(($(window).height() - c.formSize[1]) / 2) + 'px'
                    ,left: -c.formSize[0] + 'px'
                    ,zIndex: '1000'
                    ,width: c.formSize[0] + 'px'
                    ,height: c.formSize[1] + 'px'
                    ,cursor: 'wait'
                })[0] // ref to the div element
            ,i = $('img', d)
                .css({
                    position: 'absolute'
                    ,top: Math.round((c.formSize[1] - c.imgSize[1]) / 2) + 'px'
                    ,right: -c.imgSize[0] + 'px'
                    ,cursor: 'pointer'
                })
                .click(function (evt) {
                    evt.stopPropagation();
                    toggle();
                })
                [0] // ref to the img element
        ;
        $('<img src="' + c.url + '/static/closebox.png" id="Feedback_close" />')
            .click(toggle)
            .attr('title', c.closeButtonTitle)
            .appendTo(d);

        // if narrow window, use padding on body to reserve space
        c.adjustWindow(d);

        i.title = c.imgTitle;
        b.appendChild(d);
        $('<link rel="stylesheet" href="' + c.url + '/static/style.css?' + c.cssTimestamp + '" />').appendTo(b);
    }

    setup();
}

// init, or if jQuery missing, load it and call init when it loads
if (this.jQuery) {
    jQuery(Feedback_init);
} else {
    // https://gist.github.com/2004404
    !function(src, callback) {
        var s = document.createElement("script"),
            onEvent = ('onreadystatechange' in s) ? 'onreadystatechange' : 'onload';
        s[onEvent] = function () {
            if (("loaded,complete").indexOf(this.readyState || "loaded") > -1) {
                s[onEvent] = null;
                if (callback) {
                    callback();
                }
                s.parentNode.removeChild(s);
            }
        };
        s.src = src;
        document.body.appendChild(s);
    }(Feedback_config.jQueryUrl, Feedback_init);
}
