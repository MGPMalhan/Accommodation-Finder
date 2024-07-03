<script lang="ts">
	import Map from '$lib/components/map.svelte';
	export let data;

	let lng = data.property?.longitude;
	let lat = data.property?.latitude;

	let loadedImage = data.property?.image;

	let rating = data.reviews?.map((review) => {
		return {
			username: review.username,
			rating: review.rating,
			message: review.message
		};
	});

	rating;

	let success = '';
	let error = '';

	const submitReview = async (e: any) => {
		e.preventDefault();
		const form = e.target;
		const formData = new FormData(form);

		const response = await fetch('http://localhost:8080/api/listing/review.php', {
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
			(e.target as HTMLFormElement).reset();
			window.location.reload();
		}
	};
</script>

<svelte:head>
	<title>Hostel Finder - {data.property?.title}</title>
</svelte:head>

<!-- Property Page -->

<div class="mx-auto max-w-screen-xl p-5 sm:p-10 md:p-16">
	<h1 class="mb-8 text-4xl font-bold text-gray-800">Property Details</h1>
	<div class="flex flex-col gap-8 md:flex-row">
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
		<div class="w-full md:w-1/2 md:pl-8">
			<h2 class="mb-4 text-2xl font-semibold text-gray-800">{data.property?.title}</h2>
			<p class="mb-4 text-gray-600">{data.property?.description}</p>
			<div class="mb-4 flex items-center justify-between">
				<div class="flex items-center space-x-2">
					<svg
						xmlns="http://www.w3.org/2000/svg"
						class="text-primary-400 h-6 w-6"
						fill="none"
						viewBox="0 0 24 24"
						stroke="currentColor"
					>
						<path
							stroke-linecap="round"
							stroke-linejoin="round"
							stroke-width="2"
							d="M12 6v6m0 0v6m0-6h6m-6 0H6"
						/>
					</svg>
					<p class="text-gray-600">Location: {data.property?.location}</p>
				</div>
				<div class="flex items-center space-x-2">
					<svg
						xmlns="http://www.w3.org/2000/svg"
						class="text-primary-400 h-6 w-6"
						fill="none"
						viewBox="0 0 24 24"
						stroke="currentColor"
					>
						<path
							stroke-linecap="round"
							stroke-linejoin="round"
							stroke-width="2"
							d="M12 6v6m0 0v6m0-6h6m-6 0H6"
						/>
					</svg>
					<p class="text-gray-600">Price: Rs.{data.property?.rentalPrice} / Month</p>
				</div>
			</div>
			<!-- <div class="flex items-center space-x-2">
				<svg
					xmlns="http://www.w3.org/2000/svg"
					class="text-primary-400 h-6 w-6"
					fill="none"
					viewBox="0 0 24 24"
					stroke="currentColor"
				>
					<path
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="2"
						d="M12 6v6m0 0v6m0-6h6m-6 0H6"
					/>
				</svg>
				<p class="text-gray-600">Amenities</p>
			</div> -->

			<!-- Contact Button and Open in Google Maps Button -->
			<div class="mt-8 grid grid-cols-2 items-center justify-between gap-4">
				<a
					href={`tel:${data.landloard?.contactInfo}`}
					class="bg-primary-600 hover:bg-primary-700 focus:ring-primary-300 w-full rounded-md px-6 py-2 font-semibold text-white focus:outline-none focus:ring-2"
				>
					Contact Land Loard
				</a>
				<a
					href={`https://www.google.com/maps/place/${lat},${lng}/@${lat},${lng},14z`}
					target="_blank"
					class="w-full rounded-md bg-gray-200 px-6 py-2 font-semibold text-gray-800 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300"
				>
					Open in Google Maps
				</a>
				<button
					disabled={data.user?.role == 'landloard'}
					class="bg-primary-600 hover:bg-primary-700 focus:ring-primary-300 w-full rounded-md px-6 py-2 font-semibold text-white focus:outline-none focus:ring-2"
				>
					Message Land Loard
				</button>
			</div>
		</div>
	</div>

	{#if lng != null && lat != null}
		<h2 class="mb-4 mt-8 text-2xl font-semibold text-gray-800">Location</h2>
		<Map lng={lng.toString()} lat={lat.toString()} />
	{/if}

	<!-- Reviews ( username, rating, message ) -->
	{#if rating}
		<h2 class="mb-4 mt-8 text-2xl font-semibold text-gray-800">Reviews</h2>
		<div class="flex flex-col gap-8 space-y-4">
			{#each rating as rate}
				<div class="flex flex-col gap-4">
					<div class="flex flex-col gap-4">
						<div class="flex flex-row items-center gap-4">
							<div class="h-12 w-12 rounded-full bg-gray-200"></div>
							<div class="flex flex-col gap-4">
								<div class="flex flex-row">
									<p class="font-semibold text-gray-800">{rate.username}</p>
									<div class="flex items-center">
										<svg
											class="ms-1 h-4 w-4 text-yellow-300"
											aria-hidden="true"
											xmlns="http://www.w3.org/2000/svg"
											fill="currentColor"
											viewBox="0 0 22 20"
										>
											<path
												d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"
											/>
										</svg>
										( {rate.rating} )
									</div>
								</div>
								<p class="text-gray-600">{rate.message}</p>
							</div>
						</div>
					</div>
				</div>
			{/each}
		</div>
	{/if}

	<!-- Add Reviews -->
	{#if data.user?.role == 'student'}
		<div class="mx-auto mt-8 max-w-xl p-4">
			<h2 class="mb-4 text-2xl font-semibold text-gray-800">Add Review</h2>
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
			<form on:submit={submitReview} class="flex flex-col gap-4">
				<input type="hidden" name="propertyID" value={data.property?.id} />
				<input type="hidden" name="studentID" value={data.user?.id} />
				<input type="hidden" name="landloardID" value={data.property?.landlordId} />
				<input type="hidden" name="username" value={data.user?.username} />
				<input type="hidden" name="propertyTitle" value={data.property?.title} />
				<input
					type="number"
					name="rating"
					placeholder="Rating 1-10"
					min="1"
					max="10"
					class="rounded-md border border-gray-200 p-2"
				/>
				<textarea name="message" placeholder="Message" class="rounded-md border border-gray-200 p-2"
				></textarea>
				<button
					type="submit"
					class="bg-primary-600 hover:bg-primary-700 focus:ring-primary-300 w-full rounded-md px-6 py-2 font-semibold text-white focus:outline-none focus:ring-2"
				>
					Submit Review
				</button>
			</form>
		</div>
	{/if}
</div>
