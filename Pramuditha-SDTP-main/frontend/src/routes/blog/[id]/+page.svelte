<script lang="ts">
	import BlogArticle from '$lib/components/blogArticle.svelte';
	export let data;
</script>

<svelte:head>
	<title>Hostel Finder - {data.article?.title}</title>
</svelte:head>

<!-- Post Page -->

<div class="container mx-auto flex flex-wrap py-6">
	<!-- Post Section -->
	<section class="flex w-full flex-col items-center px-3 md:w-2/3">
		<BlogArticle
			title={data.article?.title}
			content={data.article?.content}
			image={data.article?.image}
			articleId={data.article?.id.toString()}
		/>
	</section>

	<!-- Sidebar Section -->
	<aside class="flex w-full flex-col items-center px-3 md:w-1/3">
		<div class="my-4 flex w-full flex-col bg-white p-6 shadow">
			<p class="pb-5 text-xl font-semibold">About Us</p>
			<p class="pb-2">
				Founded on the principles of trust, innovation, and excellence, we strive to deliver
				outstanding services and experiences. Our dedicated team is committed to enriching lives
				through quality offerings and unparalleled support. Join us in our journey towards creating
				lasting impacts and fostering connections that matter. Your trust is our greatest
				inspiration.
			</p>
		</div>
	</aside>
</div>
