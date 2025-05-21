 (function($){
  "use strict";
    $(document).ready(function () {
        $('select').each(function(){
            var $this = $(this), numberOfOptions = $(this).children('option').length;  
            $this.addClass('select-hidden'); 
            $this.wrap('<div class="select"></div>');
            $this.after('<div class="select-styled"></div>');
            var $styledSelect = $this.next('div.select-styled');
            $styledSelect.text($this.children('option').eq(0).text());  
            var $list = $('<ul />', {
                'class': 'select-options'
            }).insertAfter($styledSelect);  
            for (var i = 0; i < numberOfOptions; i++) {
                $('<li />', {
                    text: $this.children('option').eq(i).text(),
                    rel: $this.children('option').eq(i).val()
                }).appendTo($list);
            }
            var $listItems = $list.children('li');  
            $styledSelect.on('click', function (e) {
             if($('.select-options').is(':visible')) {
                e.stopPropagation();
                $styledSelect.text($(this).text()).removeClass('active');
                $this.val($(this).attr('rel'));      
                $list.hide();
             } else {
                e.stopPropagation();
                $('div.select-styled.active').each(function(){
                    $(this).removeClass('active').next('ul.select-options').hide();
                });
                $(this).toggleClass('active').next('ul.select-options').toggle();
             }//end if
            });
          
            $listItems.on('click', function (e) {
                e.stopPropagation();
                $styledSelect.text($(this).text()).removeClass('active');
                $this.val($(this).attr('rel'));
                $list.hide();
                //console.log($this.val());
            });
            
            $(document).on('click', function (e) {
                $styledSelect.removeClass('active');
                $list.hide();
            });
        });
    });
})(jQuery);