const timerDelayMs = 700;

const formState = {
  username: false,
  email: false,
  password: false,
  firstName: false,
  lastName: false,
}

function updateSubmitButton() {
  const allValid = Object.values(formState).every(v => v === true);
  $('#submit-btn').prop('disabled', !allValid);
}

let firstNameTimer;
$('#first-name').on('input', function () {
  clearTimeout(firstNameTimer);
  formState.firstName = $(this).val().length >= 2;
  firstNameTimer = setTimeout(() => {
    if (formState.firstName === false && $(this).val().length > 0) {
      $('#first-name-message').text("Valid first name required");
    } else {
      $('#first-name-message').text('');
    }
  }, timerDelayMs);
  updateSubmitButton();
});

let lastNameTimer;
$('#last-name').on('input', function () {
  clearTimeout(lastNameTimer);
  formState.lastName = $(this).val().length >= 2;
  lastNameTimer = setTimeout(() => {
    if (formState.lastName === false && $(this).val().length > 0) {
      $('#last-name-message').text("Valid last name required");
    } else {
      $('#last-name-message').text('');
    }
  }, timerDelayMs);
  updateSubmitButton();
});

let usernameTimer;
$('#username').on('input', function () {
  clearTimeout(usernameTimer);
  const value = $(this).val();

  formState.username = false;
  updateSubmitButton();

  if (value.length < 3) {
    $('#username-message').text('Too short').css('color', 'red');
    return;
  }

  usernameTimer = setTimeout(function () {
    $.get('/auth/verify-availability', { field: 'username', value: value })
      .done((data) => {
        formState.username = data.available;
        updateSubmitButton();

        $('#username-message')
          .text(data.message)
          .css('color', data.available === true ? 'green' : 'red');
      }).fail(function () {
        formState.username = false;
        updateSubmitButton();

        $('#username-message')
          .text('Could not verify.')
          .css('color', 'red');
      });
  }, timerDelayMs);
});

let emailTimer;
$('#email').on('input', function () {
  clearTimeout(emailTimer);
  const value = $(this).val();

  emailTimer = setTimeout(() => {
    $.get('/auth/verify-availability', { field: 'email', value: value })
      .done((data) => {
        formState.email = data.available;
        updateSubmitButton();

        $('#email-message')
          .text(data.message)
          .css('color', data.available === true ? 'green' : 'red');
      }).fail(function () {
        formState.email = false;
        updateSubmitButton();

        $('#email-message')
          .text('Could not verify.')
          .css('color', 'red');
      });
  }, timerDelayMs);
});

let passwordTimer;
$('#password').on('input', function () {
  clearTimeout(passwordTimer);
  formState.password = $(this).val().length >= 8;
  passwordTimer = setTimeout(() => {
    if (formState.password === false && $(this).val().length > 0) {
      $('#password-message').text("Min 8 characters");
    } else {
      $('#password-message').text('');
    }
  }, timerDelayMs);
  updateSubmitButton();
});