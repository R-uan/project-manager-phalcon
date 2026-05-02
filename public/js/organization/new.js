const timerDelayMs = 700;

const formState = {
  handle: false,
}

function updateSubmitButton() {
  const allValid = Object.values(formState).every(v => v === true);
  $('#submit-btn').prop('disabled', !allValid);
}

let handleTimer;
$('#handle').on('input', function () {
  clearTimeout(handleTimer);
  const value = $(this).val();

  formState.handle = false;

  if (value.length < 3) {
    $('#handle-message').text('Too short').css('color', 'red');
    return;
  }

  handleTimer = setTimeout(function () {
    $.get('/org/verify-availability', { field: 'handle', value: value })
      .done((data) => {
        formState.handle = data.available;
        updateSubmitButton();

        $('#handle-message')
          .text(data.message)
          .css('color', data.available === true ? 'green' : 'red');
      }).fail(function () {
        formState.handle = false;
        updateSubmitButton();

        $('#handle-message')
          .text('Could not verify.')
          .css('color', 'red');
      });
  }, timerDelayMs)
});

