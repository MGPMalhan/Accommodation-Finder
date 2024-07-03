<script lang="ts">
	export let data;
	console.log(data.property);

	interface Property {
		id: number;
		title: string;
		description: string;
		rentalPrice: number;
		status: string;
		listedOn: string;
		image: string;
		location: string;
		longitude: number;
		latitude: number;
		image2: string;
		image3: string;
	}

	let loadedImage = data.property?.image;

	let error = '';
	let success = '';

	let handleFormSubmit = (event: SubmitEvent) => {
		event.preventDefault();
		const formData = new FormData(event.target as HTMLFormElement);

		fetch('http://localhost:8080/api/listing/property/update.php', {
			method: 'POST',
			body: formData
		})
			.then((response) => response.text())
			.then((result) => {
				if (result.includes('Error')) {
					error = result;
					success = '';
				} else {
					error = '';
					success = result;
				}
			});
	};
</script>

<svelte:head>
	<title>Hostel Finder - Edit Listing</title>
</svelte:head>

<!-- Property Images -->
<div class="my-16 flex w-full flex-col items-center justify-center gap-4 p-8 md:flex-row">
	<div class="w-full md:w-1/2">
		<!-- svelte-ignore a11y-img-redundant-alt -->
		<img
			src="http://localhost:8080/api/listing/property/images/{loadedImage}"
			alt="Property Image"
			class=" mb-8 h-96 w-full rounded-md object-cover"
			style="aspect-ratio: 16/9"
		/>
		<!-- Small image list -->
		<div class="flex items-center gap-4">
			<!-- svelte-ignore a11y-click-events-have-key-events -->
			<!-- svelte-ignore a11y-no-noninteractive-element-interactions -->
			<!-- svelte-ignore a11y-img-redundant-alt -->
			<img
				src="http://localhost:8080/api/listing/property/images/{data.property?.image}"
				alt="Property Image"
				class="h-24 w-24 rounded-md object-cover"
				on:click={() => {
					loadedImage = data.property?.image;
				}}
			/>
			<!-- svelte-ignore a11y-click-events-have-key-events -->
			<!-- svelte-ignore a11y-no-noninteractive-element-interactions -->
			<!-- svelte-ignore a11y-img-redundant-alt -->
			<img
				src="http://localhost:8080/api/listing/property/images/{data.property?.image2}"
				alt="Property Image"
				class="h-24 w-24 rounded-md object-cover"
				on:click={() => {
					loadedImage = data.property?.image2 || data.property?.image;
				}}
			/>
			<!-- svelte-ignore a11y-click-events-have-key-events -->
			<!-- svelte-ignore a11y-no-noninteractive-element-interactions -->
			<!-- svelte-ignore a11y-img-redundant-alt -->
			<img
				src="http://localhost:8080/api/listing/property/images/{data.property?.image3}"
				alt="Property Image"
				class="h-24 w-24 rounded-md object-cover"
				on:click={() => {
					loadedImage = data.property?.image3 || data.property?.image;
				}}
			/>
		</div>
	</div>

	<!-- Property Edit Page -->
	<div class="mx-auto w-full p-5">
		<h1 class="mb-8 text-4xl font-bold text-gray-800">Edit Property</h1>
		<!-- Alerts -->
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
		<form on:submit={handleFormSubmit} class="flex flex-col gap-4">
			<input type="hidden" name="listingId" value={data.property?.id} />
			<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
				<div class="w-full sm:w-1/2">
					<label for="title" class="text-gray-600">Title</label>
					<input
						type="text"
						name="title"
						id="title"
						value={data.property?.title}
						class="block w-full rounded border border-gray-300 bg-white px-4 py-3 leading-tight text-gray-700 focus:border-gray-500 focus:bg-white focus:outline-none"
					/>
				</div>
				<div class="w-full sm:w-1/2">
					<label for="rentalPrice" class="text-gray-600">Rental Price</label>
					<input
						type="number"
						name="rentalPrice"
						id="rentalPrice"
						value={data.property?.rentalPrice}
						class="block w-full rounded border border-gray-300 bg-white px-4 py-3 leading-tight text-gray-700 focus:border-gray-500 focus:bg-white focus:outline-none"
					/>
				</div>
			</div>
			<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
				<div class="w-full sm:w-1/2">
					<label for="location" class="text-gray-600">Location</label>
					<input
						type="text"
						name="location"
						id="location"
						value={data.property?.location}
						class="block w-full rounded border border-gray-300 bg-white px-4 py-3 leading-tight text-gray-700 focus:border-gray-500 focus:bg-white focus:outline-none"
					/>
				</div>
			</div>
			<div class="flex flex-col gap-4">
				<label for="description" class="text-gray-600">Description</label>
				<textarea
					name="description"
					id="description"
					class="block w-full rounded border border-gray-300 bg-white px-4 py-3 leading-tight text-gray-700 focus:border-gray-500 focus:bg-white focus:outline-none"
					>{data.property?.description}</textarea
				>
			</div>
			<button
				type="submit"
				class="bg-primary-600 hover:bg-primary-700 rounded-md px-4 py-2 text-white transition duration-500 ease-in-out"
			>
				Update
			</button>
		</form>
	</div>
</div>
