<script lang="ts">
	import BlogCard from '$lib/components/blogCard.svelte';
	export let data;
</script>

<!-- Blog Page -->

<!-- Header -->
<section
	class="relative flex h-96 w-full items-center justify-center bg-cover bg-center bg-no-repeat"
	style="background-image: url('https://unsplash.com/photos/tMI2_-r5Nfo/download?ixid=M3wxMjA3fDB8MXxzZWFyY2h8OHx8Y29udGFjdCUyMHN1cHBvcnR8ZW58MHx8fHwxNzEwODI0MTAzfDA&force=true&w=1920')"
>
	<div class="gradient absolute inset-0 bg-black opacity-50"></div>
	<h1 class="z-10 text-4xl font-bold tracking-tight text-white sm:text-5xl md:text-6xl">Blog</h1>
</section>

<!-- Blog Posts -->
<div class="container mx-auto flex flex-wrap py-6">
	<!-- Posts Section -->
	<section class="flex w-full flex-col items-center px-3 md:w-2/3">
		{#each data.articles as article}
			<BlogCard
				title={article.title}
				content={article.content}
				articleId={article.id.toString()}
				image={article.image}
			/>
		{/each}
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
