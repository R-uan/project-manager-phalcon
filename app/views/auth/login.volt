<div id="container">
  <div id="content">

    <h1>Login to your account</h1>
    <p>It's nice to see you again</p>

    {{ flashSession.output() }}

    <form method="POST" action="/auth/login">
      <div class="field-wrapper">
        <label>Email address</label>
        <input id="email" type="email" name="email" placeholder="Your email" required>
        <span id="email-message" class="message-wrapper"></span>
      </div>

      <div class="field-wrapper">
        <label>Password</label>
        <input id="password" type="password" name="password" placeholder="Your password" required>
        <span id="password-message" class="message-wrapper"></span>
      </div>

      <button id="submit-btn" class="submit-btn" type="submit">
        Log in
      </button>
    </form>

    <p class="auth-redirect">
      Don't have an account?
      <a href="/auth/register">Sign up</a>
    </p>

  </div>
</div>