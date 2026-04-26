<div id="new-page">
	<div class="greeting">
		<h2>
			Set up your organization
		</h2>
		<p>
			Tell us about your organization
		</p>
	</div>

	<div id="content">
		<div>{{ flashSession.output() }}</div>
		<form action="/organization/new" method="post">
			<div>
				<div class="field">
					<label required="required" for="name">Organization Name</label>
					<input required id="name" name="name" type="text" placeholder="Organization name" value="{{ request.getPost('name')|e }}">
				</div>
			</div>

			<div>
				<div class="field">
					<label required="required" for="email">Contact Email</label>
					<input required id="email" type="email" name="contactEmail" placeholder="Organization email" aria-placeholder="Organization contact email" value="{{ request.getPost('contactEmail')|e }}">
				</div>
			</div>

			<div>
				<button type="submit">
					Create Organization
				</button>
			</div>
		</form>
	</div>
</div>
