<div id="organization-page">
	<div id="top-menu">
		<div>
			<span>Your Organizations</span>
		</div>
		<div>
			<a href="/organization/new">New Organization</a>
		</div>
	</div>
	<section id="org-section">
		<ul id="org-list">
			{% for org in organizations %}
				<li class="org-view">
					<div>
						<span>{{ org.orgName|e }}</span>
					</div>
				</li>
			{% endfor %}
		</ul>
	</section>
</div>
