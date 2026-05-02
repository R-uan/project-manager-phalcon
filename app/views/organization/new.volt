<div id="container">
	<div id="content">
		<h1>Set up your organization</h1>
		<p>Tell us about your organization</p>

		{{ flashSession.output() }}

		<form method="POST" action="/organization/new">
			<div class="field-wrapper">
				<label for="handle">Organization Handle
					<span class="required">*</span>
				</label>
				<input id="handle" type="text" name="handle" placeholder="Organization handle" value="{{ request.getPost('handle')|e }}" required>
				<span id="handle-message" class="message-wrapper"></span>
			</div>

			<div class="field-wrapper">
				<label for="name">Display Name
					<span class="required">*</span>
				</label>
				<input id="name" type="text" name="name" placeholder="Organization name" value="{{ request.getPost('name')|e }}" required>
				<span id="name-message" class="message-wrapper"></span>
			</div>

			<div class="field-wrapper">
				<label for="email">Contact Email
					<span class="required">*</span>
				</label>
				<input id="email" type="email" name="contactEmail" placeholder="Organization email" value="{{ request.getPost('contactEmail')|e }}" required>
				<span id="email-message" class="message-wrapper"></span>
			</div>

			<div class="field-wrapper checkbox-wrapper">
				<div class="checkbox-container">
					<input id="visibility" type="checkbox" name="visibility" value="1" {{ request.getPost('visibility') ? 'checked' : '' }}>
					<label for="visibility">Make organization public</label>
				</div>
				<span id="visibility-message" class="message-wrapper"></span>
			</div>

			<button id="submit-btn" class="submit-btn" disabled type="submit">
				Create Organization
			</button>
		</form>
	</div>
</div>
