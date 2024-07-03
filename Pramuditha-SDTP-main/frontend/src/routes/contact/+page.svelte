<script lang="ts">
	import { browser } from '$app/environment';

	let error = '';
	let success = '';

	async function handleSubmit(event: SubmitEvent) {
		event.preventDefault(); // Prevent the default form submission

		const formData = new FormData(event.target as HTMLFormElement);

		if (browser) {
			const response = await fetch('http://localhost:8080/api/contact.php', {
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
	<title>Hostel Finder - Contact</title>
</svelte:head>

<!-- Hero with bg image -->
<section
	class="relative flex h-96 w-full items-center justify-center bg-cover bg-center bg-no-repeat"
	style="background-image: url('https://unsplash.com/photos/tMI2_-r5Nfo/download?ixid=M3wxMjA3fDB8MXxzZWFyY2h8OHx8Y29udGFjdCUyMHN1cHBvcnR8ZW58MHx8fHwxNzEwODI0MTAzfDA&force=true&w=1920')"
>
	<div class="gradient absolute inset-0 bg-black opacity-50"></div>
	<h1 class="z-10 text-4xl font-bold tracking-tight text-white sm:text-5xl md:text-6xl">
		Contact Us
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
				<form class="space-y-4 md:space-y-6" on:submit={handleSubmit}>
					<div>
						<label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
							>Your name</label
						>
						<input
							type="text"
							name="name"
							id="name"
							class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							placeholder="John Doe"
							required
						/>
					</div>

					<div>
						<label for="email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
							>Your email</label
						>
						<input
							type="email"
							name="email"
							id="email"
							class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							placeholder="email@company.com"
							required
						/>
					</div>

					<div>
						<label
							for="message"
							class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
							>Your message</label
						>
						<textarea
							name="message"
							id="message"
							class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							placeholder="Your message here"
							required
						></textarea>
					</div>

					<button
						type="submit"
						class="bg-primary-600 hover:bg-primary-700 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 w-full rounded-lg px-5 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4"
						>Send message</button
					>
				</form>
			</div>
		</div>
	</div>
</section>
