<script lang="ts">
	import { browser } from '$app/environment';

	let error = '';
	let success = '';

	async function handleSubmit(event: SubmitEvent) {
		event.preventDefault(); // Prevent the default form submission

		const formData = new FormData(event.target as HTMLFormElement);

		if (browser) {
			const response = await fetch('http://localhost:8080/api/blog/post.php', {
				method: 'POST',
				body: formData
			});

			const result = await response.text();

			if (result.includes('Error')) {
				error = result;
				success = '';
			} else {
				// Handle successful registration, maybe redirect or clear the form
				error = ''; // Clear any previous error
				success = result;
				console.log('Registration successful');
				// Redirect or update UI accordingly
			}
		}
	}
</script>

<svelte:head>
	<title>Hostel Finder - Post Article</title>
</svelte:head>

<!-- Hero with bg image -->
<section
	class="relative flex h-96 w-full items-center justify-center bg-cover bg-center bg-no-repeat"
	style="background-image: url('https://unsplash.com/photos/tMI2_-r5Nfo/download?ixid=M3wxMjA3fDB8MXxzZWFyY2h8OHx8Y29udGFjdCUyMHN1cHBvcnR8ZW58MHx8fHwxNzEwODI0MTAzfDA&force=true&w=1920')"
>
	<div class="gradient absolute inset-0 bg-black opacity-50"></div>
	<h1 class="z-10 text-4xl font-bold tracking-tight text-white sm:text-5xl md:text-6xl">
		Post Article
	</h1>
</section>

<!-- Contact Us -->
<section class="bg-gray-50 py-10 dark:bg-gray-900">
	<div class="mx-auto flex flex-col items-center justify-center px-6 py-8 lg:py-0">
		<div
			class="w-full rounded-lg bg-white shadow sm:max-w-md md:mt-0 xl:p-0 dark:border dark:border-gray-700 dark:bg-gray-800"
		>
			<div class="space-y-4 p-6 sm:p-8 md:space-y-6">
				{#if error}
					<div
						class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-gray-800 dark:text-red-400"
						role="alert"
					>
						{error}
					</div>
				{/if}
				{#if success}
					<div
						class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-gray-800 dark:text-green-400"
						role="alert"
					>
						{success}
					</div>
				{/if}
				<form on:submit={handleSubmit}>
					<div class="space-y-2">
						<label for="title" class="text-sm font-medium text-gray-700 dark:text-gray-300">
							Title
						</label>
						<input
							type="text"
							id="title"
							name="title"
							class="focus:ring-primary-500 focus:border-primary-500 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm sm:text-sm dark:bg-gray-800 dark:text-gray-300"
							required
						/>
					</div>
					<div class="space-y-2">
						<label for="content" class="text-sm font-medium text-gray-700 dark:text-gray-300">
							Content
						</label>
						<textarea
							id="content"
							name="content"
							class="focus:ring-primary-500 focus:border-primary-500 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm sm:text-sm dark:bg-gray-800 dark:text-gray-300"
							required
						></textarea>
					</div>
					<div class="space-y-2">
						<label for="image" class="text-sm font-medium text-gray-700 dark:text-gray-300">
							Image
						</label>
						<input
							type="file"
							id="image"
							name="image"
							class="focus:ring-primary-500 focus:border-primary-500 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm sm:text-sm dark:bg-gray-800 dark:text-gray-300"
							required
						/>
					</div>
					<div class="space-y-2">
						<button
							type="submit"
							class="bg-primary-600 hover:bg-primary-700 focus:ring-primary-500 w-full rounded-md border border-transparent px-4 py-2 text-sm font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2"
						>
							Post Article
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
