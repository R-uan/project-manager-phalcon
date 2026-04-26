$(function() {
  $("#add-org-btn").on('click', function () {
    const $btn = $(this);
    $btn.prop('disabled', true).text('Adding...');
    $('#org-list').append('<li>New item</li>');
    $btn.prop('disabled', false).text('Add Org');
  });
})