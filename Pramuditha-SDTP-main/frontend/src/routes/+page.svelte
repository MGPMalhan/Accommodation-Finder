<script lang="ts">
	import type { PageData } from './$types';

	export let data: PageData;

	let navigation = [
		{ title: 'Customers', path: 'javascript:void(0)' },
		{ title: 'Careers', path: 'javascript:void(0)' }
	];
</script>

<svelte:head>
	<title>Hostel Finder</title>
</svelte:head>

<div class="bg-white shadow-md">
	<section class="mx-auto max-w-screen-xl items-center px-4 pb-12 pt-24 md:px-8 lg:flex">
		<div class="flex-1 space-y-4 sm:text-center lg:text-left">
			<h1 class="text-4xl font-bold text-gray-900 xl:text-5xl">
				Find a Safe and Comfortable
				<span class="text-primary-400">Hostel</span>
			</h1>
			<p class="max-w-xl leading-relaxed text-gray-500 sm:mx-auto lg:ml-0">
				Did you knew the hostel you're in can affect your mental health?
			</p>
			<div
				class="grid grid-cols-2 items-center justify-center gap-4 space-y-3 pt-10 sm:space-x-6 sm:space-y-0 lg:justify-start"
			>
				<a
					href="/listing"
					class="block w-full rounded-md bg-white px-7 py-3 text-center text-gray-800 shadow-md sm:w-auto"
				>
					Start Searching
				</a>
				{#if data.user?.role === 'landloard'}
					<a
						href="/listing/post-listing"
						target="_blank"
						class="block w-full rounded-md bg-gray-700 px-7 py-3 text-center text-gray-200 sm:w-auto"
					>
						Post a Hostel
					</a>
				{/if}
				{#if data.user?.role === 'warden'}
					<a
						href="/listing/review"
						class="block w-full rounded-md bg-gray-700 px-7 py-3 text-center text-gray-200 sm:w-auto"
					>
						Review Listing
					</a>
				{/if}
				{#if data.user?.role === 'warden'}
					<a
						href="/register/landloard"
						class="block w-full rounded-md bg-gray-700 px-7 py-3 text-center text-gray-200 sm:w-auto"
					>
						Add Land Loards
					</a>
				{/if}
				{#if data.user?.role === 'warden'}
					<a
						href="/blog/post"
						class="block w-full rounded-md bg-gray-700 px-7 py-3 text-center text-gray-200 sm:w-auto"
					>
						Add a Blog Post
					</a>
				{/if}
			</div>
		</div>
		<div class="mt-7 flex-1 text-center lg:ml-3 lg:mt-0">
			<!-- svelte-ignore a11y-missing-attribute -->
			<img src="/hero-bg.png" class="mx-auto w-full sm:w-10/12 lg:w-full" />
		</div>
	</section>
</div>
