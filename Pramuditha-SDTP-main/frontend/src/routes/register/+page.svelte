<script lang="ts">
	import { browser } from '$app/environment';
	let error = '';
	let success = '';

	async function handleSubmit(event: SubmitEvent) {
		event.preventDefault(); // Prevent the default form submission

		const formData = new FormData(event.target as HTMLFormElement);

		if (browser) {
			const response = await fetch('http://localhost:8080/api/register_user.php', {
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
				// Reset the form
				(event.target as HTMLFormElement).reset();
			}
		}
	}
</script>

<svelte:head>
	<title>Hostel Finder - Register</title>
</svelte:head>

<section class="bg-gray-50 py-10 dark:bg-gray-900">
	<div class="mx-auto flex flex-col items-center justify-center px-6 py-8 md:h-screen lg:py-0">
		<div
			class="w-full rounded-lg bg-white shadow sm:max-w-md md:mt-0 xl:p-0 dark:border dark:border-gray-700 dark:bg-gray-800"
		>
			<div class="space-y-4 p-6 sm:p-8 md:space-y-6">
				<h1
					class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
				>
					Register your account
				</h1>
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
				<form class="space-y-4 md:space-y-6" on:submit={handleSubmit} enctype="multipart/form-data">
					<div>
						<label
							for="username"
							class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
							>Your username</label
						>
						<input
							type="text"
							name="username"
							id="username"
							class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							placeholder="username"
							required
						/>
					</div>

					<div>
						<label for="avatar" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
							>Your avatar</label
						>
						<input
							type="file"
							name="avatar"
							id="avatar"
							class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
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
							placeholder="name@company.com"
							required
						/>
					</div>
					<div>
						<label for="phone" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
							Your phone
						</label>
						<input
							type="text"
							name="contactInfo"
							id="phone"
							class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							placeholder="phone"
							required
						/>
					</div>
					<div>
						<label
							for="password"
							class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Password</label
						>
						<input
							type="password"
							name="password"
							id="password"
							placeholder="••••••••"
							class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							required
						/>
					</div>
					<div>
						<label
							for="password"
							class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
							>Confirm Password</label
						>
						<input
							type="password"
							name="password"
							id="password"
							placeholder="••••••••"
							class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							required
						/>
					</div>

					<button
						type="submit"
						class="bg-primary-600 hover:bg-primary-700 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 w-full rounded-lg px-5 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4"
						>Sign Up</button
					>
					<p class="text-sm font-light text-gray-500 dark:text-gray-400">
						Already have an account yet? <a
							href="/login"
							class="text-primary-600 dark:text-primary-500 font-medium hover:underline">Sign In</a
						>
					</p>
					<input type="hidden" name="incomingURL" value="/register" />
				</form>
			</div>
		</div>
	</div>
</section>
