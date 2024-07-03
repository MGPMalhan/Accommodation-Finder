import { loginstat } from '$lib/stores';

export const ssr = false;
let login = 0;

loginstat.subscribe((value) => {
	login = value;
});

/** @type {import('./$types').LayoutServerLoad} */
export async function load(event) {
	return {
		login,
		user: event.locals.user
	};
}
