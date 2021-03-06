/**
 * User: nikk
 * Date: 12/23/13
 * Time: 6:42 PM
 */

function Registration(){}

Registration.prototype =
{
    init: function() {
        $('#termsAccepted').click(function(){
            if (jQuery(this).is(":checked")) {
                $('input[type="submit"]').removeAttr('disabled');
            } else {
                $('input[type="submit"]').attr('disabled', 'disabled');
            }
        });

        var childNum = 1;
        $('.add-child').click(function(event) {
            $('.children .items').append($('#fos_user_registration_form_children').data('prototype')
                    .replace('__name__', '').replace('label__', 'Child:').replace(/__name__/g, childNum++))
                .find('.datetime').datepicker({changeYear: true});
            event.preventDefault();
        }).click();
    }
};

$(document).ready(function(){
    Registration.prototype.init();
});