{% for membership in memberships %}
	<div class="flex items-center gap-4 p-4 border rounded-lg">
		<div>
			<p class="font-medium">{{ membership.organizationName|e }}</p>
			<p class="text-sm text-gray-500">{{ membership.role|e }}</p>
		</div>

		{% if membership.role == 'OWNER' %}
			<span class="bg-amber-400 text-xs px-2 py-1 rounded">Owner</span>
		{% endif %}
	</div>
{% else %}
	<p>No memberships found.</p>
{% endfor %}
