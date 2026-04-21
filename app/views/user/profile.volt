{# User Basic Information #}
<h1>User Profile</h1>
<p>
	<strong>ID:</strong>
	{{ profile.userId }}</p>
<p>
	<strong>Name:</strong>
	{{ profile.firstName }}
	{{ profile.lastName }}</p>
<p>
	<strong>Email:</strong>
	{{ profile.email }}</p>

{# Handle Nullable Fields #}
{% if profile.location %}
	<p>
		<strong>Location:</strong>
		{{ profile.location }}</p>
{% endif %}

{% if profile.website %}
	<p>
		<strong>Website:</strong>
		<a href="{{ profile.website }}">{{ profile.website }}</a>
	</p>
{% endif %}

<hr>

{# Memberships Loop #}
<h2>Memberships</h2>
{% if profile.memberships|length > 0 %}
	<ul>
		{% for membership in profile.memberships %}
			<li>
				{{membership.orgId}}
				<strong>{{ membership.orgName }}</strong>
				({{ membership.role }})<br>

			</li>
		{% endfor %}
	</ul>
{% else %}
	<p>No active memberships found.</p>
{% endif %}
