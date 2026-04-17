<div class="form-container">
  <h1>Login</h1>

  <?= $this->flashSession->output() ?> 

  <form method="POST" action="/session/login">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>

  <a href="/session/register">Don't have an account?</a>
</div>