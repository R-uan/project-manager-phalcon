$(document).on('click', '.invite-btn', function () {
  const orgId = $(this).data('org-id');
  const action = $(this).data('action');

  $.ajax({
    url: '/organization/' + orgId + '/members/invite/' + action, 
    method: 'GET',
    dataType: 'json',
    success: function(response) {
      $('#flashOutputError').hide();
      console.log(response)
    },
    error: function(xhr) {
      console.log(xhr);
      $('#errorText').text(xhr.responseJSON.message || 'Something went wrong.');
      $('#flashOutputError').show();
    }
  });
});
