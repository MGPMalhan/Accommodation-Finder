<script lang="ts">
	import { onMount } from 'svelte';
	//@ts-ignore
	import { Map } from '@onsvisual/svelte-maps';
	import maplibre, { Marker } from 'maplibre-gl';

	let map: any;
	let zoom: any;
	let center = {};
	let marker: any;
	const api = 'euHcvQEPWqR2gLe0f8z2';

	export let lng: string = '80.0416';
	export let lat: string = '6.8213';
	export let pins:
		| {
				latitude: number;
				longitude: number;
				title: string;
				price: number;
		  }[]
		| null = null;

	onMount(() => {
		if (pins) {
			let coordinates = pins.map((pin) => {
				return [pin.longitude, pin.latitude];
			});

			console.log(coordinates);

			let centerLng = coordinates.reduce((acc, val) => acc + val[0], 0) / coordinates.length;
			let centerLat = coordinates.reduce((acc, val) => acc + val[1], 0) / coordinates.length;

			let zoom = 11;

			map = new maplibre.Map({
				container: 'map',
				style: `https://api.maptiler.com/maps/streets/style.json?key=${api}`,
				center: [centerLng, centerLat],
				zoom: zoom
			});

			for (let pin of pins) {
				marker = new Marker({ color: 'red' })
					.setLngLat([pin.longitude, pin.latitude])
					.setPopup(new maplibre.Popup().setText(pin.title))
					.addTo(map as Map);
			}
		} else {
			map.addControl(new maplibre.NavigationControl(), 'top-left');
			marker = new Marker({ color: 'red' })
				.setLngLat([parseFloat(lng), parseFloat(lat)])
				.addTo(map as Map);
		}
	});
</script>

<main class="h-full w-full">
	<Map
		id="map"
		style={`https://api.maptiler.com/maps/streets/style.json?key=${api}`}
		location={{ lng, lat, zoom: 14 }}
		bind:map
		bind:zoom
		bind:center
	/>
</main>

<style>
	main {
		height: 400px;
		width: 100%;
	}
</style>
