<div>
	{{ flashSession.output() }}

	<form action="/organization/{{ dispatcher.getParam('orgId')|e }}/members/invite" method="POST">
		<label for="targetEmail">Invite Member:</label>
		<input type="email" id="targetEmail" name="targetEmail" placeholder="Enter email address" required>
		<button type="submit">Send Invite</button>
	</form>
</div>

<div>
	{% for member in memberships %}
		<span>{{ member.userId|e }}:
			{{ member.userFirstName|e }}
			{{ member.userLastName|e }}
			-
			{{ member.role|e }}
		</span>
	{% endfor %}
</div>
