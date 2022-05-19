/**
 * Custom Javascripts,
 * @package Academy Management
 * @author DataTrix Team
 */
;(function($, window, document){

    // Smoothly close bootstrap alerts
    $('body').on('close.bs.alert', function(e){
        e.preventDefault();
        e.stopPropagation();
        $(e.target).slideUp();
    });


    // tooltip activation
    $('[data-toggle=tooltip]').tooltip();


    //bootstrap center modal
    function setModalMaxHeight(element) {
        this.$element     = $(element);  
        this.$content     = this.$element.find('.modal-content');
        var borderWidth   = this.$content.outerHeight() - this.$content.innerHeight();
        var dialogMargin  = $(window).width() < 768 ? 20 : 60;
        var contentHeight = $(window).height() - (dialogMargin + borderWidth);
        var headerHeight  = this.$element.find('.modal-header').outerHeight() || 0;
        var footerHeight  = this.$element.find('.modal-footer').outerHeight() || 0;
        var maxHeight     = contentHeight - (headerHeight + footerHeight);
      
        this.$content.css({
            'overflow': 'hidden'
        });
        
        this.$element
          .find('.modal-body').css({
            'max-height': maxHeight,
            'overflow-y': 'auto'
        });
      }
      
      $('.modal').on('show.bs.modal', function() {
        $(this).show();
        setModalMaxHeight(this);
      });
      
      $(window).resize(function() {
        if ($('.modal.in').length != 0) {
          setModalMaxHeight($('.modal.in'));
        }
      });

      //reset modal form input when closing/cancel modal
      $('.modal').on('hidden.bs.modal', function(){
          $(this).find('form')[0].reset();
          $('.form-group').removeClass('has-error');
          $( "span.text-danger" ).html('');
      });




}(jQuery, window, document));
