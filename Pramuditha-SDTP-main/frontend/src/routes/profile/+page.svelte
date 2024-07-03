<script lang="ts">
	export let data;

	const deleteListing = (id: Number) => {
		fetch(`http://localhost:8080/api/listing/delete.php?listingId=${id}`).then((response) => {
			response.text();
			// Refresh window
			window.location.reload();
		});
	};

	let username = data.user?.username;
	let password = data.user?.password;
	let confirmPassword = data.user?.password;

	let error = '';
	let success = '';

	const updateProfile = () => {
		// Post as form data
		if (username == '' || password == '' || confirmPassword == '') {
			error = 'Please fill in all fields';
			success = '';
			return;
		}

		let formData = new FormData();
		formData.append('username', username as string);
		formData.append('password', password as string);

		fetch('http://localhost:8080/api/user/update.php', {
			method: 'POST',
			body: formData
		})
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
		fetch('http://localhost:8080/api/user/update.php', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({
				username,
				password,
				confirmPassword
			})
		})
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
	<title>Hostel Finder - Profile</title>
</svelte:head>

<!-- Profile Page -->

<div class="mx-auto w-full p-5 sm:p-10 md:p-16">
	<h1 class="mb-8 text-4xl font-bold text-gray-800">Profile</h1>
	<div class="flex flex-col gap-8 md:flex-row">
		<div class="w-full md:w-1/2">
			<div class="flex flex-col gap-4">
				<div class="flex items-center gap-4">
					<img
						src="http://localhost:8080/avatars/{data.user?.avatar}"
						alt="User Avatar"
						class="h-24 w-24 rounded-full object-cover"
					/>
					<div class="flex flex-col">
						<h2 class="text-2xl font-bold text-gray-800">{data.user?.username}</h2>
						<!-- <p class="text-gray-600">{data.user?.email}</p> -->
					</div>
				</div>
				<div class="flex flex-col gap-4">
					<h2 class="text-2xl font-bold text-gray-800">My Listings</h2>
					{#if data.properties.length == 0}
						<p class="text-gray-600">You have no listings</p>
					{:else}
						{#each data.properties as property}
							<div class="flex items-center gap-4">
								<!-- svelte-ignore a11y-img-redundant-alt -->
								<img
									src="http://localhost:8080/api/listing/property/images/{property.image}"
									alt="Property Image"
									class="h-24 w-24 rounded-md object-cover"
								/>
								<div class="flex flex-col">
									<h2 class="text-xl font-bold text-gray-800">{property.title}</h2>
									<p class="text-gray-600">{property.description}</p>
									<div class="flex items-center gap-4">
										<a
											href="/listing/{property.id}"
											class="text-primary-700 hover:text-primary-500"
										>
											View
										</a>
										<a
											href="/listing/edit/{property.id}"
											class="text-primary-700 hover:text-primary-500"
										>
											Edit
										</a>
										<button
											on:click={() => {
												deleteListing(property.id);
											}}
											class="text-primary-700 hover:text-primary-500"
										>
											Delete
										</button>
									</div>
								</div>
							</div>
						{/each}
					{/if}
				</div>
			</div>
		</div>
		<div class="w-full md:w-1/2 md:pl-8">
			<h2 class="mb-4 text-2xl font-semibold text-gray-800">Edit Profile</h2>
			<form
				on:submit|preventDefault={() => {
					updateProfile();
				}}
				class="flex flex-col gap-4"
			>
				<div class="flex flex-col gap-4">
					<label for="username" class="text-gray-600"> Username </label>
					<input
						type="text"
						id="username"
						name="username"
						class="rounded-md border-gray-300"
						bind:value={username}
						disabled
					/>
				</div>
				<div class="flex flex-col gap-4">
					<label for="password" class="text-gray-600"> Password </label>
					<input
						type="password"
						id="password"
						name="password"
						class="rounded-md border-gray-300"
						bind:value={password}
					/>
				</div>
				<div class="flex flex-col gap-4">
					<label for="confirmPassword" class="text-gray-600"> Confirm Password </label>
					<input
						type="password"
						id="confirmPassword"
						name="confirmPassword"
						class="rounded-md border-gray-300"
						bind:value={confirmPassword}
					/>
				</div>
				<button
					type="submit"
					class="bg-primary-600 hover:bg-primary-700 rounded-md px-4 py-2 text-white transition duration-500 ease-in-out"
				>
					Update Profile
				</button>
			</form>
		</div>
	</div>
</div>
