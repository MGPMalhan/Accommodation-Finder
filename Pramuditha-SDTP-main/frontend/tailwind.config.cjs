/** @type {import('tailwindcss').Config}*/
const config = {
	content: ['./src/**/*.{html,js,svelte,ts}', './node_modules/flowbite/**/*.js'],

	theme: {
		extend: {
			colors: {
				primary: {
					50: '#f1f9fe',
					100: '#e2f2fc',
					200: '#bfe4f8',
					300: '#87d1f2',
					400: '#47b8e9',
					500: '#1fa2db',
					600: '#1180b8',
					700: '#0f6795',
					800: '#11577b',
					900: '#134967',
					950: '#0d2e44'
				}
			}
		}
	},

	plugins: [require('flowbite/plugin')]
};

module.exports = config;
