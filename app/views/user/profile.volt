<div id="container">
	<div id="content">
		<div
			class="profile-card">
			<!-- Profile section -->
			<div class="profile-section">
				<h2 class="profile-name">{{ profile.firstName }}
					{{ profile.lastName }}</h2>
				<div class="profile-username">@{{ profile.username }}</div>
				{% if profile.location %}
					<div class="profile-detail">{{ profile.location }}</div>
				{% endif %}
				{% if profile.website %}
					<div class="profile-detail">{{ profile.website }}</div>
				{% endif %}
			</div>

			<!-- Divider -->
			<hr
			class="divider">

			<!-- Organizations section -->
			<div class="org-section">
				<h3 class="section-title">Organizations</h3>
				{% if profile.memberships|length > 0 %}
					<ul class="org-list">
						{% for membership in profile.memberships %}
							<li class="org-item">
								<div class="org-info">
									<span class="org-name">{{ membership.orgDisplayName }}</span>
									<span class="org-handle">@{{ membership.orgHandle }}</span>
								</div>
								<span class="org-role">{{ membership.role }}</span>
							</li>
						{% endfor %}
					</ul>
				{% else %}
					<p class="empty-message">No active memberships found.</p>
				{% endif %}
			</div>
		</div>
	</div>
</div>
