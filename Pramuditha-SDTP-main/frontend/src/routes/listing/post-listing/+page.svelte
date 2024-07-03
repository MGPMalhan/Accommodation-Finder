<script lang="ts">
	import { browser } from '$app/environment';
	import Map from '$lib/components/map.svelte';
	import { lon, lat } from '$lib/stores';

	export let data;

	let error = '';
	let success = '';

	let longitude = $lon;
	let latitude = $lat;

	if ('geolocation' in navigator) {
		navigator.geolocation.getCurrentPosition((position) => {
			longitude = position.coords.longitude;
			latitude = position.coords.latitude;
			lon.set(longitude);
			lat.set(latitude);
			console.log('Latitude: ', latitude, 'Longitude: ', longitude);
		});
	}

	// Submit to localhost:8080/api/listing/post.php
	async function handleSubmit(event: SubmitEvent) {
		event.preventDefault();

		const formData = new FormData(event.target as HTMLFormElement);

		if (browser) {
			const response = await fetch('http://localhost:8080/api/listing/post.php', {
				method: 'POST',
				body: formData
			});

			const result = await response.text();
			console.log(result);

			if (result.includes('Error')) {
				error = result;
				success = '';
			} else {
				// Handle successful registration, maybe redirect or clear the form
				error = ''; // Clear any previous error
				success = result;
				// Reset the form
				(event.target as HTMLFormElement).reset();
			}
		}
	}
</script>

<svelte:head>
	<title>Hostel Finder - Post Listing</title>
</svelte:head>

<!-- Hero -->
<section
	class="relative flex h-96 w-full items-center justify-center bg-cover bg-center bg-no-repeat"
	style="background-image: url('https://unsplash.com/photos/tMI2_-r5Nfo/download?ixid=M3wxMjA3fDB8MXxzZWFyY2h8OHx8Y29udGFjdCUyMHN1cHBvcnR8ZW58MHx8fHwxNzEwODI0MTAzfDA&force=true&w=1920')"
>
	<div class="gradient absolute inset-0 bg-black opacity-50"></div>
	<h1 class="z-10 text-4xl font-bold tracking-tight text-white sm:text-5xl md:text-6xl">
		Post a listing
	</h1>
</section>

<!-- Listing Post Form -->
<section class="bg-gray-50 py-10 dark:bg-gray-900">
	<div class="mx-auto grid grid-cols-1 gap-8 px-6 py-8 md:grid-cols-2 lg:py-0">
		<div class="w-full">
			<h2 class="mb-4 text-2xl font-bold text-gray-900 dark:text-white">Location</h2>
			{#if latitude && longitude}
				<Map lng={longitude.toString()} lat={latitude.toString()} />
			{:else}
				<!-- Spinner -->
				<div class="flex h-96 items-center justify-center">
					<div
						class="border-primary-500 h-32 w-32 animate-spin rounded-full border-b-2 border-t-2"
					></div>
				</div>
			{/if}
		</div>
		<div
			class="mx-auto w-full max-w-xl rounded-lg bg-white shadow md:mt-0 xl:p-0 dark:border dark:border-gray-700 dark:bg-gray-800"
		>
			<div class="space-y-4 p-6 sm:p-8 md:space-y-6">
				<div class=" rounded-t-lg p-6 pb-0">
					<h2 class="text-center text-2xl font-bold">Listing Details</h2>
				</div>
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
				<form
					class="grid w-full grid-cols-1 gap-4 space-y-4 md:grid-cols-2 md:space-y-6"
					on:submit={handleSubmit}
					enctype="multipart/form-data"
				>
					<input type="hidden" name="longitude" value={longitude} />
					<input type="hidden" name="latitude" value={latitude} />
					<input type="hidden" name="landloardId" value={data.user.id} />
					<div class="col-span-2">
						<label for="title" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
							>Title</label
						>
						<input
							type="text"
							name="title"
							id="title"
							class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							placeholder="Title"
							required
						/>
					</div>

					<div class="col-span-2">
						<label
							for="description"
							class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
							>Description</label
						>
						<textarea
							name="description"
							id="description"
							class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							placeholder="Description"
							required
						></textarea>
					</div>

					<div>
						<label for="price" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
							>Price</label
						>
						<input
							type="number"
							name="price"
							id="price"
							class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							placeholder="Price"
							required
						/>
					</div>

					<div>
						<label
							for="location"
							class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
							>Closest City</label
						>
						<input
							type="text"
							name="location"
							id="location"
							class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							placeholder="Location"
							required
						/>
					</div>

					<div>
						<label for="image" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
							>Primary Image</label
						>
						<input
							type="file"
							name="image"
							id="image"
							class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							required
						/>
					</div>

					<div>
						<label for="image2" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
							>Secondary Image 1</label
						>
						<input
							type="file"
							name="image2"
							id="image2"
							class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							required
						/>
					</div>

					<div>
						<label for="image3" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
							>Secondary Image 2</label
						>
						<input
							type="file"
							name="image3"
							id="image3"
							class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							required
						/>
					</div>

					<div class="col-span-2 grid grid-cols-2 gap-4">
						<button
							type="submit"
							class="bg-primary-400 block w-full rounded-md px-7 py-3 text-center text-white shadow-md sm:w-auto"
						>
							Post
						</button>

						<a
							href="/listing"
							class="block w-full rounded-md bg-gray-700 px-7 py-3 text-center text-gray-200 sm:w-auto"
						>
							Cancel
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
