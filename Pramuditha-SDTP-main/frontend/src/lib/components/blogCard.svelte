<script>
	export let image = '';
	export let title = '';
	export let content = '';
	export let articleId = '';
</script>

<article class="my-4 flex w-full flex-col shadow">
	<!-- Article Image -->
	<a href={`/blog/${articleId}`} class="hover:opacity-75">
		<!-- svelte-ignore a11y-img-redundant-alt -->
		<img class="w-full" alt="post image" src={`http://localhost:8080/postImages/${image}`} />
	</a>
	<div class="flex flex-col justify-start bg-white p-6">
		<a href={`/blog/${articleId}`} class="pb-4 text-3xl font-bold hover:text-gray-700">{title}</a>
		<a href={`/blog/${articleId}`} class="pb-6">{content.slice(0, 100)}</a>
		<a href={`/blog/${articleId}`} class="text-primary-800 hover:text-primary-400 uppercase"
			>Continue Reading <i class="fas fa-arrow-right"></i></a
		>
	</div>
</article>
