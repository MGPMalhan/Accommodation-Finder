<script>
	export let received = false;
	export let message = '';
</script>

{#if received}
	<div class="mb-2 rounded-lg bg-gray-100 p-4 text-gray-700">
		<p>{message}</p>
	</div>
{:else}
	<div class="mb-2 rounded-lg p-4 text-right text-gray-700">
		<p>{message}</p>
	</div>
{/if}
