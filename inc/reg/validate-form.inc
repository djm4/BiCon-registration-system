<script language="javascript" type="text/javascript">
jQuery(document).ready(function(){//DOM not loaded, must use ready event
	jQuery(' form' ).submit(function(event){
    var isErrorFree = true;
    // iterate through required form elements and check to see if they are valid
    jQuery(' input.required, select.required, textarea.required',this).each(function(){
        if ( validateElement.isValid(this) == false ){
            isErrorFree = false;
        };
    });
    return isErrorFree;
  });
});

var validateElement = {

    isValid:function(element){

        var isValid = true;
        var $element = jQuery(element);
        var id = $element.attr('id');
        var name = $element.attr('name');
        var value = $element.val();

        // <input> uses type attribute as written in tag
        // <textarea> has intrinsic type of 'textarea'
        // <select> has intrinsic type of 'select-one' or 'select-multiple'
        var type = $element[0].type.toLowerCase();

        switch(type){
            case 'text':
            case 'textarea':
            case 'password':
                if ( value.length == 0 || value.replace(/\s/g,'').length == 0 ){ isValid = false; }
                break;
            case 'select-one':
            case 'select-multiple':
                if( !value ){ isValid = false; }
                break;
            case 'checkbox':
            case 'radio':
                if( $('input[name="' + name +'"]:checked').length == 0 ){ isValid = false; };
                break;
        } // close switch()

        // instead of $(selector).method we are going to use $(selector)[method]
        // choose the right method, but choose wisely
        var method = isValid ? 'removeClass' : 'addClass';

        // show error message [addClass]
        // hide error message [removeClass]
        jQuery('#errorMessage_' + name)[method]('showErrorMessage');
        jQuery('label[for="' + id + '"]')[method]('error');

        return isValid;

    } // close validateElement.isValid()
}; // close validateElement object

					  
</script>
