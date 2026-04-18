<div class="container">

	<div class="mt-[50px] sm:mx-auto sm:w-full sm:max-w-md">
		<h2 class="mt-6 text-center text-3xl font-extrabold tracking-tight text-white">
			Set up your organization
		</h2>
		<p class="mt-2 text-center text-sm text-zinc-400">
			Tell us about your organization
		</p>
	</div>

	<div class="mt-[50px] sm:mx-auto sm:w-full sm:max-w-md">
		<div class="mb-6">
			{{ flashSession.output() }}
		</div>

		<form action="/organization/create" method="post" class="space-y-6">
			<div>
				<div class="mt-1 flex gap-1 flex-col">
					<label required="required" for="name" class="block text-sm font-medium text-zinc-300">
						Organization Name
					</label>
					<input id="name" name="name" type="text" r equired value="{{ request.getPost('name')|e }}" placeholder="">
				</div>
			</div>

			<div>
				<div class="mt-1 flex gap-1 flex-col">
					<label required="required" for="email" class="block text-sm font-medium text-zinc-300">
						Contact Email
					</label>
					<input id="email" name="contactEmail" type="email" required value="{{ request.getPost('contactEmail')|e }}" placeholder="">
				</div>
			</div>

			<div class="flex items-center">
				<input id="isPublic" name="isPublic" type="checkbox" value="1" {% if request.getPost('isPublic') %} checked {% endif %} class="h-4 w-4 text-indigo-500 focus:ring-indigo-500 border-zinc-700 rounded bg-zinc-800">
				<label for="isPublic" class="ml-2 block text-sm text-zinc-300">
					Make Organization Public
				</label>
			</div>

			<div>
				<button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-zinc-900 focus:ring-indigo-500 transition-colors">
					Create Organization
				</button>
			</div>
		</form>
	</div>
</div>
