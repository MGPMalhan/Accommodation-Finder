<script>
	export let image = '';
	export let title = '';
	export let content = '';
	export let articleId = '';
</script>

<article class="my-4 flex w-full flex-col shadow">
	<!-- Article Image -->
	<a href={`/blog/${articleId}`} class="hover:opacity-75">
		<!-- svelte-ignore a11y-missing-attribute -->
		<img class="w-full" src={`http://localhost:8080/postImages/${image}`} />
	</a>
	<div class="flex flex-col justify-start bg-white p-6">
		<h1 class="pb-3 text-2xl font-bold">{title}</h1>
		<p class="pb-3">
			{content}
		</p>
	</div>
</article>
