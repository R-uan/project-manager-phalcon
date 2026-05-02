<div id="container">
  <div id="content">
    <h1>Create an account</h1>
    <p>Fill in your details to get started</p>

    {{ flashSession.output() }}

    <form method="POST" action="/auth/register">
      <div id="names">
        <div class="name-wrapper">
          <label>First name</label>
          <input id="first-name" type="text" name="firstName" placeholder="John" required>
          <span id="first-name-message" class="message-wrapper"></span>
        </div>
        <div class="name-wrapper">
          <label>Last name</label>
          <input id="last-name" type="text" name="lastName" placeholder="Smith" required>
          <span id="last-name-message" class="message-wrapper"></span>
        </div>
      </div>

      <div class="field-wrapper">
        <label>Username</label>
        <input id="username" type="text" name="username" placeholder="Choose a username" required>
        <span id="username-message" class="message-wrapper"></span>
      </div>

      <div class="field-wrapper">
        <label>Email address</label>
        <input id="email" type="email" name="email" placeholder="john@example.com" required>
        <span id="email-message" class="message-wrapper"></span>
      </div>

      <div class="field-wrapper">
        <label>Password</label>
        <input id="password" type="password" name="password" placeholder="Min. 8 characters" required>
        <span id="password-message" class="message-wrapper"></span>
      </div>

      <button id="submit-btn" class="submit-btn" disabled type="submit">
        Create account
      </button>

    </form>

    <p class="auth-redirect">
      Already have an account?
      <a href="/auth/login">Sign in</a>
    </p>

  </div>
</div>