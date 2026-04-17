<div class="flex min-h-screen font-sans">
  <!-- Left sidebar -->
  <div class="hidden lg:flex w-80 flex-shrink-0 bg-[#0f0f0f] flex-col justify-between p-10">
    <div class="text-white font-medium text-lg">
      <span class="inline-block w-7 h-7 bg-white rounded-md mr-2 align-middle"></span>
      Acme
    </div>
    <div>
      <p class="text-gray-400 text-sm leading-relaxed mb-4">
        "Building something great starts with the right foundation. Welcome aboard."
      </p>
      <p class="text-gray-300 text-sm font-medium">Get started in seconds — no credit card required.</p>
    </div>
    <p class="text-gray-600 text-xs">© 2026 Acme Inc. · Privacy · Terms</p>
  </div>

  <!-- Main content -->
  <div class="flex-1 bg-gray-50 dark:bg-zinc-900 flex items-center justify-center p-8">
    <div class="w-full max-w-md">

      <h1 class="text-2xl font-medium text-gray-900 dark:text-white mb-1">Login to your account</h1>
      <p class="text-sm text-gray-400 mb-7">It's nice to see you again</p>

      <?= $this->flashSession->output() ?>

      <form method="POST" action="/auth/login">
        <div class="mb-4">
          <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Email address</label>
          <input type="email" name="email" placeholder="Your email" required
            class="w-full border border-gray-200 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400 dark:focus:border-zinc-500 transition-colors">
        </div>

        <div class="mb-6">
          <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Password</label>
          <input type="password" name="password" placeholder="Your password" required
            class="w-full border border-gray-200 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400 dark:focus:border-zinc-500 transition-colors">
        </div>

        <button type="submit"
          class="w-full bg-white text-gray-900 rounded-lg py-2.5 text-sm font-medium hover:bg-gray-700 dark:hover:bg-gray-100 transition-colors">
          Log in
        </button>

      </form>

      <p class="text-center text-sm text-gray-400 mt-5">
        Don't have an account?
        <a href="/auth/register" class="text-gray-900 dark:text-white underline underline-offset-2">Sign in</a>
      </p>

    </div>
  </div>
</div>