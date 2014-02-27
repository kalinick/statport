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

        $('.add-child').click(function() {
            $('.children .items').append($('#fos_user_registration_form_children').data('prototype'));
        });
    }
};

$(document).ready(function(){
    Registration.prototype.init();
});