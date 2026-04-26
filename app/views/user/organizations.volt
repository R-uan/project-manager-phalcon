<div
	x-data="{
				    memberships: {{ membershipsJson }},
				    invitations: {{ invitationsJson }},
		
				    async accept(invite) {
				      const res = await fetch('/organization/invites/accept', {
				        method: 'POST',
				        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				        body: 'orgId=' + invite.orgId
				      });
				      const data = await res.json();
				      if (data.success) {
				        this.invitations = this.invitations.filter(i => i.orgId !== invite.orgId);
				        this.memberships.push(data.membership);
				      }
				    },
		
				    async decline(invite) {
				      const res = await fetch('/invitations/decline', {
				        method: 'POST',
				        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				        body: 'orgId=' + invite.orgId
				      });
				      const data = await res.json();
				      if (data.success) {
				        this.invitations = this.invitations.filter(i => i.orgId !== invite.orgId);
				      }
				    }
				  }">
	{# Memberships #}
	<template x-for="membership in memberships" :key="membership.orgId">
		<div class="flex items-center justify-between p-4 border rounded-lg mb-2">
			<div class="flex items-center gap-4">
				<div>
					<p class="font-medium" x-text="membership.orgName"></p>
					<p class="text-sm text-gray-500" x-text="membership.role"></p>
				</div>
				<template x-if="membership.role === 'OWNER'">
					<span class="bg-amber-400 text-black text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded">Owner</span>
				</template>
			</div>
		</div>
	</template>

	{# Invitations #}
	<template x-for="invite in invitations" :key="invite.orgId">
		<div class="flex items-center justify-between p-4 border border-dashed border-blue-300 bg-blue-50/50 rounded-lg mb-2">
			<div class="flex items-center gap-4">
				<div>
					<p class="font-medium text-blue-900" x-text="invite.orgName"></p>
					<p class="text-xs text-gray-500">
						Invited by:
						<span class="font-semibold" x-text="invite.inviterName"></span>
					</p>
				</div>
				<span class="bg-blue-500 text-white text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded">Pending</span>
			</div>
			<div class="flex gap-2">
				<button @click="accept(invite)" class="text-xs bg-white border border-blue-500 text-blue-600 px-3 py-1.5 rounded hover:bg-blue-50 transition-colors font-medium">Accept</button>
				<button @click="decline(invite)" class="text-xs text-gray-400 hover:text-red-500 px-2 py-1.5 transition-colors">Decline</button>
			</div>
		</div>
	</template>

	{# Empty state #}
	<template x-if="memberships.length === 0 && invitations.length === 0">
		<p class="text-center py-8 text-gray-400">No organizations or invitations found.</p>
	</template>
</div>
