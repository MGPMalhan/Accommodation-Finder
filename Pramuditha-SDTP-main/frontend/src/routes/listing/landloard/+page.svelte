<script lang="ts">
	import Map from '$lib/components/map.svelte';
	export let data;
	console.log(data.pins);
	// create card[] from data.properties
	const cards = data.properties.map((property) => {
		return {
			link: `/listing/${property.id}`,
			imageUrl: `http://localhost:8080/api/listing/property/images/${property.image}`,
			altText: property.title,
			category: property.status.toUpperCase(),
			date: new Date(property.listedOn).getDate(),
			month: new Date(property.listedOn).toLocaleString('default', { month: 'long' }),
			title: property.title,
			description: property.description,
			id: property.id,
			rental: property.rentalPrice
		};
	});

	export let currentPage = data.currentPage;
	let pages: Number[] = [];

	// Pagination ( if not 1 add 2 previous pages and next 2 pages  to a total of 5 pages )
	if (currentPage == 1) {
		pages = [1, 2, 3, 4, 5];
	} else if (currentPage == 2) {
		pages = [1, 2, 3, 4, 5];
	} else {
		pages = [currentPage - 2, currentPage - 1, currentPage, currentPage + 1, currentPage + 2];
	}

	let selectedLocation = data.filters.location;
	let selectedPricingMin = data.filters.minPrice;
	let selectedPricingMax = data.filters.maxPrice;

	const onFilter = () => {
		// encoded URL with page, selectedLocation, selectedPricingMin and selectedPricingMax
		const url = `/listing/landloard?page=${currentPage}&location=${selectedLocation}&minPrice=${selectedPricingMin}&maxPrice=${selectedPricingMax}`;
		window.location.replace(url);
	};

	const changePage = (page: Number) => {
		const url = `/listing/landloard?page=${page}`;
		window.location.replace(url);
	};

	let error = '';
	let success = '';

	const markAsRented = (id: Number) => {
		fetch(`http://localhost:8080/api/listing/rented.php?listingId=${id}`)
			.then((response) => response.text())
			.then((result) => {
				console.log(result);
				if (result.includes('Error')) {
					error = result;
					success = '';
				} else {
					error = '';
					success = result;
					// Refresh window
					window.location.reload();
				}
			});
	};

	const markAsReserved = (id: Number) => {
		fetch(`http://localhost:8080/api/listing/reserved.php?listingId=${id}`)
			.then((response) => response.text())
			.then((result) => {
				console.log(result);
				if (result.includes('Error')) {
					error = result;
					success = '';
				} else {
					error = '';
					success = result;
					// Refresh window
					window.location.reload();
				}
			});
	};

	const deleteListing = (id: Number) => {
		fetch(`http://localhost:8080/api/listing/delete.php?listingId=${id}`)
			.then((response) => response.text())
			.then((result) => {
				console.log(result);
				if (result.includes('Error')) {
					error = result;
					success = '';
				} else {
					error = '';
					success = result;
					// Refresh window
					window.location.reload();
				}
			});
	};

	const markAsAvailable = (id: Number) => {
		fetch(`http://localhost:8080/api/listing/accept.php?listingId=${id}`)
			.then((response) => response.text())
			.then((result) => {
				console.log(result);
				if (result.includes('Error')) {
					error = result;
					success = '';
				} else {
					error = '';
					success = result;
					// Refresh window
					window.location.reload();
				}
			});
	};
</script>

<svelte:head>
	<title>Hostel Finder - My Listing</title>
</svelte:head>

<div class="mx-auto flex max-w-screen-xl flex-col gap-8 p-5 sm:p-10 md:p-16">
	<h1 class="mb-8 text-4xl font-bold text-gray-800">Overview Map</h1>
	<Map pins={data.pins} />
	<h1 class="mb-8 text-4xl font-bold text-gray-800">Latest Listings</h1>
	<!-- Alert -->
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
	<!-- Filters for Pricing min, Pricing max and Location ( Dropdown ) -->
	<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
		<div class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:space-x-4 sm:space-y-0">
			<div class="relative">
				<select
					bind:value={selectedLocation}
					class="block w-full appearance-none rounded border border-gray-300 bg-white px-4 py-3 pr-8 leading-tight text-gray-700 focus:border-gray-500 focus:bg-white focus:outline-none"
				>
					<option value="All">All</option>
					{#each data.locations as location}
						<option value={location.location}>{location.location}</option>
					{/each}
				</select>
			</div>
			<div class="relative">
				<input
					bind:value={selectedPricingMin}
					type="number"
					placeholder="Pricing Min"
					class="block w-full appearance-none rounded border border-gray-300 bg-white px-4 py-3 pr-8 leading-tight text-gray-700 focus:border-gray-500 focus:bg-white focus:outline-none"
				/>
			</div>
			<div class="relative">
				<input
					bind:value={selectedPricingMax}
					type="number"
					placeholder="Pricing Max"
					class="block w-full appearance-none rounded border border-gray-300 bg-white px-4 py-3 pr-8 leading-tight text-gray-700 focus:border-gray-500 focus:bg-white focus:outline-none"
				/>
			</div>
		</div>
		<div class="flex items-center space-x-4">
			<button
				on:click={onFilter}
				class="bg-primary-400 block w-full rounded-md px-7 py-3 text-center text-white shadow-md sm:w-auto"
			>
				Filter
			</button>
		</div>
	</div>

	<div class="grid grid-cols-1 gap-10 sm:grid-cols-2 md:grid-cols-3">
		{#each cards as card}
			<div class="flex flex-col justify-between overflow-hidden rounded shadow-lg">
				<div class="relative">
					<a href={card.link}>
						<img class="w-full" src={card.imageUrl} alt={card.altText} />
						<div
							class="absolute bottom-0 left-0 right-0 top-0 bg-gray-900 opacity-25 transition duration-300 hover:bg-transparent"
						></div>
					</a>
					<a href={card.link}>
						<div
							class="bg-primary-600 hover:text-primary-600 absolute bottom-0 left-0 px-4 py-2 text-sm text-white transition duration-500 ease-in-out hover:bg-white"
						>
							{card.category}
						</div>
					</a>

					<a href={card.link}>
						<div
							class="bg-primary-600 hover:text-primary-600 absolute right-0 top-0 mr-3 mt-3 flex h-16 w-16 flex-col items-center justify-center rounded-full px-4 text-sm text-white transition duration-500 ease-in-out hover:bg-white"
						>
							<span class="font-bold">{card.date}</span>
							<small>{card.month}</small>
						</div>
					</a>
				</div>
				<div class="px-6 py-4">
					<a
						href={card.link}
						class="hover:text-primary-600 inline-block text-lg font-semibold transition duration-500 ease-in-out"
					>
						{card.title} - Rs.{card.rental}/Month
					</a>
					<p class="text-sm text-gray-500">{card.description}</p>
				</div>
				<!-- Accept and Reject Buttons -->
				<div class="grid grid-cols-2 gap-4 px-6 py-4">
					{#if card.category !== 'REJECTED' && card.category !== 'PENDING'}
						<button
							on:click={() => {
								markAsRented(card.id);
							}}
							class="bg-primary-400 block w-full rounded-md px-7 py-3 text-center text-white shadow-md sm:w-auto"
						>
							Mark as Rented
						</button>
						<button
							on:click={() => {
								markAsReserved(card.id);
							}}
							class="block w-full rounded-md bg-yellow-400 px-7 py-3 text-center text-white shadow-md sm:w-auto"
						>
							Mark as Reserved
						</button>
						<button
							on:click={() => {
								markAsAvailable(card.id);
							}}
							class="block w-full rounded-md bg-orange-400 px-7 py-3 text-center text-white shadow-md sm:w-auto"
						>
							Mark as Available
						</button>
					{/if}
					<a
						href={`/listing/edit/${card.id}`}
						class="block w-full rounded-md bg-green-400 px-7 py-3 text-center text-gray-200 sm:w-auto"
					>
						Edit Listing Details
					</a>
					<button
						on:click={() => {
							deleteListing(card.id);
						}}
						class="block w-full rounded-md bg-red-400 px-7 py-3 text-center text-white shadow-md sm:w-auto"
					>
						Delete
					</button>
				</div>
			</div>
		{/each}
	</div>

	<!-- Dynamic Pagination -->
	<div class="mt-10 flex items-center justify-center">
		{#each pages as page}
			{#if page == currentPage}
				<button
					on:click={() => changePage(page)}
					class="bg-primary-600 hover:bg-primary-700 rounded-md px-4 py-2 text-white transition duration-500 ease-in-out"
				>
					{page}
				</button>
			{:else}
				<button
					on:click={() => changePage(page)}
					class="hover:bg-primary-600 rounded-md bg-white px-4 py-2 text-gray-800 transition duration-500 ease-in-out hover:text-white"
				>
					{page}
				</button>
			{/if}
		{/each}
	</div>
</div>
