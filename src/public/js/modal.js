$('.detail-view').click(function() {
    var contact_id = $(this).attr('id');
    var fullname = $('.name_get' + contact_id).text();
    var gender = $('.gender_get' + contact_id).text();
    var email = $('.email_get' + contact_id).text();
    var tel = $('.tel_get' + contact_id).text();
    var address = $('.address_get' + contact_id).text();
    var building = $('.building_get' + contact_id).text();
    var category = $('.category_get' + contact_id).text();
    var detail = $('.detail_get' + contact_id).text();

    $('.full-name-modal').text(fullname);
    $('.gender-modal').text(gender);
    $('.email-modal').text(email);
    $('.tel-modal').text(tel);
    $('.address-modal').text(address);
    $('.building-modal').text(building);
    $('.category-modal').text(category);
    $('.detail-text-modal').val(detail);
    $('.delete-id').val(contact_id);
    $('.modal').css({ 'display': 'block' });
});

$('.close-button').click(function() {
    $('.modal').css({ 'display': 'none' });
});
