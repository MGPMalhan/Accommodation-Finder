<script lang="ts">
	import { onMount } from 'svelte';
	import '../app.pcss';
	import { initFlowbite } from 'flowbite';
	import { UserRole } from '@prisma/client';

	export let data;

	const footerNavs: any[] = [
		// { href: 'javascript:void()', name: 'Terms' },
		// { href: 'javascript:void()', name: 'License' },
		// { href: 'javascript:void()', name: 'Privacy' },
		// { href: 'javascript:void()', name: 'About us' }
	];

	onMount(() => {
		initFlowbite();
	});
</script>

<div class="flex min-h-screen flex-col">
	<nav class="border-gray-200 bg-white dark:bg-gray-900">
		<div class="mx-auto flex max-w-screen-xl flex-wrap items-center justify-between p-4">
			<a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
				<span class="self-center whitespace-nowrap text-2xl font-semibold dark:text-white"
					>Hostel Finder</span
				>
			</a>
			<button
				data-collapse-toggle="navbar-default"
				type="button"
				class="inline-flex h-10 w-10 items-center justify-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 md:hidden dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
				aria-controls="navbar-default"
				aria-expanded="false"
			>
				<span class="sr-only">Open main menu</span>
				<svg
					class="h-5 w-5"
					aria-hidden="true"
					xmlns="http://www.w3.org/2000/svg"
					fill="none"
					viewBox="0 0 17 14"
				>
					<path
						stroke="currentColor"
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="2"
						d="M1 1h15M1 7h15M1 13h15"
					/>
				</svg>
			</button>
			<div class="hidden w-full flex-row items-center gap-8 md:flex md:w-auto" id="navbar-default">
				<ul
					class="mt-4 flex flex-col rounded-lg border border-gray-100 bg-gray-50 p-4 font-medium md:mt-0 md:flex-row md:space-x-8 md:border-0 md:bg-white md:p-0 rtl:space-x-reverse dark:border-gray-700 dark:bg-gray-800 md:dark:bg-gray-900"
				>
					<li>
						<a
							href="/"
							class="bg-primary-700 md:text-primary-700 md:dark:text-primary-500 block rounded px-3 py-2 text-white md:bg-transparent md:p-0 dark:text-white"
							aria-current="page">Home</a
						>
					</li>
					<li>
						<a
							href="/listing"
							class="md:hover:text-primary-700 md:dark:hover:text-primary-500 block rounded px-3 py-2 text-gray-900 hover:bg-gray-100 md:border-0 md:p-0 md:hover:bg-transparent dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"
							>Listing</a
						>
					</li>
					<li>
						<a
							href="/profile"
							class="md:hover:text-primary-700 md:dark:hover:text-primary-500 block rounded px-3 py-2 text-gray-900 hover:bg-gray-100 md:border-0 md:p-0 md:hover:bg-transparent dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"
							>Profile</a
						>
					</li>
					<li>
						<a
							href="/blog"
							class="md:hover:text-primary-700 md:dark:hover:text-primary-500 block rounded px-3 py-2 text-gray-900 hover:bg-gray-100 md:border-0 md:p-0 md:hover:bg-transparent dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"
							>Blog</a
						>
					</li>

					{#if data.user?.role == 'landloard'}
						<li>
							<a
								href="/listing/landloard"
								class="md:hover:text-primary-700 md:dark:hover:text-primary-500 block rounded px-3 py-2 text-gray-900 hover:bg-gray-100 md:border-0 md:p-0 md:hover:bg-transparent dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"
								>My Listings</a
							>
						</li>
					{/if}
					<li>
						<a
							href="/contact"
							class="md:hover:text-primary-700 md:dark:hover:text-primary-500 block rounded px-3 py-2 text-gray-900 hover:bg-gray-100 md:border-0 md:p-0 md:hover:bg-transparent dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"
							>Contact</a
						>
					</li>
					{#if data.login}
						<li>
							<form action="/logout" method="POST">
								<button
									class="md:hover:text-primary-700 md:dark:hover:text-primary-500 block rounded px-3 py-2 text-gray-900 hover:bg-gray-100 md:border-0 md:p-0 md:hover:bg-transparent dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"
									>Logout</button
								>
							</form>
						</li>
					{/if}
				</ul>

				{#if data.user?.avatar}
					<img
						class="hidden h-10 w-10 rounded-full p-1 ring-2 ring-gray-300 md:block dark:ring-gray-500"
						src={`http://localhost:8080/avatars/${data.user?.avatar}`}
						alt="Bordered avatar"
					/>
				{/if}
			</div>
		</div>
	</nav>

	<slot />

	<footer class="float-end w-full pt-10">
		<div class="mx-auto max-w-screen-xl px-4 text-gray-600 md:px-8">
			<div class="mt-10 items-center justify-between border-t py-10 sm:flex">
				<p>© 2024 Hostel Management. All rights reserved.</p>
				<ul class="mt-6 flex flex-wrap items-center gap-4 sm:mt-0 sm:text-sm">
					{#each footerNavs as item (item.name)}
						<li class="text-gray-800 duration-150 hover:text-gray-500">
							<a href={item.href}>{item.name}</a>
						</li>
					{/each}
				</ul>
			</div>
		</div>
	</footer>
</div>
