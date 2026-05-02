<div>
	<div id="flashOutputError">
		<span id="errorText"></span>
	</div>
	<section>
		<div>
			<h2>My Organizations</h2>
		</div>
		<div>
			<ul>
				{% for membership in memberships %}
					<li>
						<div>{{ membership.orgName }}</div>
						<div>{{ membership.role }}</div>
					</li>
				{% endfor %}
			</ul>
		</div>
	</section>
	<section>
		<div>
			<h2>Invitations</h2>
		</div>
		<div>
			{% if invitations|length > 0 %}
				<ul>
					{% for invitation in invitations %}
						<li>
							<div>{{ invitation.orgName }}</div>
							<div>{{ invitation.inviterName }}</div>
							<button class="invite-btn" data-org-id="{{ invitation.orgId }}" data-action="accept">Accept</button>
							<button class="invite-btn" data-org-id="{{ invitation.orgId }}" data-action="deny">Deny</button>
						</li>
					{% endfor %}
				</ul>
			{% else %}
				<span>No invitations.</span>
			{% endif %}
		</div>
	</section>
</div>
