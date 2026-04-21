<div>
	{{ flashSession.output() }}

	<form action="/organization/{{ dispatcher.getParam('orgId')|e }}/members" method="POST">
		<label for="targetEmail">Invite Member:</label>
		<input type="email" id="targetEmail" name="targetEmail" placeholder="Enter email address" required>
		<button type="submit">Send Invite</button>
	</form>
</div>

<div>
	{% for member in members %}
		Organization:
		{{ member.userId|e }}
		<br/>
	{% endfor %}
</div>
