
(function ( $ ) {
 
    var tours = {};
        
    $.fn.tour = function( options ) {

        var settings = $.extend({
            target: "body",
            name: "tour",
            templatePrev: 'Prev',
            templateNext: 'Next',
            templateSkip: 'Skip tour',
            templateEnd: 'End tour',
            steps: [{"orphan": true, "title": "Welcome to the tour", "content": "" }]
        }, options );

        settings.template = '<div class="popover" role="tooltip"> <div class="arrow"></div> <h3 class="popover-title"></h3> <div class="popover-content"></div> <div class="popover-navigation"> <div class="btn-group"> <button class="btn btn-sm btn-default" data-role="prev">&laquo; '+settings.templatePrev+'</button> <button class="btn btn-sm btn-default" data-role="next">'+settings.templateNext+' &raquo;</button> <button class="btn btn-sm btn-default" data-role="pause-resume" data-pause-text="Pause" data-resume-text="Resume">Pause</button> </div> <button class="btn btn-sm btn-default" data-role="end">'+settings.templateSkip+'</button> </div> </div>';
        settings.endTemplate = '<div class="popover" role="tooltip"> <div class="arrow"></div> <h3 class="popover-title"></h3> <div class="popover-content"></div> <div class="popover-navigation"> <div class="btn-group"> <button class="btn btn-sm btn-default" data-role="prev">&laquo; '+settings.templatePrev+'</button> <button class="btn btn-sm btn-default" data-role="next">'+settings.templateNext+' &raquo;</button> <button class="btn btn-sm btn-default" data-role="pause-resume" data-pause-text="Pause" data-resume-text="Resume">Pause</button> </div> <button class="btn btn-sm btn-default" data-role="end">'+settings.templateEnd+'</button> </div> </div>';
        settings.steps[settings.steps.length-1].template = settings.endTemplate;
        $(settings.target).append('<a href="#"  id="'+settings.name+'-link" class="text-white bg-color-05 margin-top-20 margin-top-0-767 margin-bottom-15 float-right tour-link"><i class="fa fa-question"></i></a>');
        
        tours[settings.name] = new Tour({
            name: settings.name,
            backdrop: true,
            template: settings.template,
            steps: settings.steps,
            onEnd: function(tour) {
                var tourStepCount = tour._options.steps.length-1;
                if (tourStepCount === tour.getCurrentStep()) {
                    tour.setCurrentStep(0);
                }
            }
        });

        tours[settings.name].init();
        tours[settings.name].start();

        $("#"+settings.name+"-link").click(function(){
            tours[settings.name].start(true);
        });

        return this;
    };
 
}( jQuery ));

