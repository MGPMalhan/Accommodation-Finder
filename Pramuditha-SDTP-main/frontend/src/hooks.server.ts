import { authenticateUser } from '$lib/auth';
import { redirect, type Handle } from '@sveltejs/kit';

export const handle: Handle = async ({ event, resolve }) => {
	// Stage 1
	// eslint-disable-next-line @typescript-eslint/ban-ts-comment
	//@ts-ignore
	event.locals.user = await authenticateUser(event);

	// console.log(event.url.pathname);

	// Redirect to login page if user is not authenticated and trying to access pages other than /, /login, /register
	if (!event.locals.user) {
		if (!event.url.pathname.startsWith('/login') && !event.url.pathname.startsWith('/register')) {
			throw redirect(303, '/login');
		}
	} else {
		// Redirect to home page if user is authenticated and trying to access /login or /register
		if (event.url.pathname.startsWith('/login') || event.url.pathname.startsWith('/register')) {
			throw redirect(303, '/');
		}

		// Restrict access to /listing/post if not type landloard
		if (event.url.pathname.startsWith('/listing/post-listing')) {
			if (event.locals.user.role !== 'landloard') {
				throw redirect(303, '/listing');
			}
		}

		// Restrict access to /listing/landloard if not type landloard
		if (event.url.pathname.startsWith('/listing/landloard')) {
			if (event.locals.user.role !== 'landloard') {
				throw redirect(303, '/listing');
			}
		}

		// Restrict access to /listing/review if not type warden
		if (event.url.pathname.startsWith('/listing/review')) {
			if (event.locals.user.role !== 'warden') {
				throw redirect(303, '/listing');
			}
		}

		// Restrict access to /register/landloard if not type warden
		if (event.url.pathname.startsWith('/register/landloard')) {
			if (event.locals.user.role !== 'warden') {
				throw redirect(303, '/');
			}
		}

		// Restrict access to /blog/post if type is not warden
		if (event.url.pathname.startsWith('/blog/post')) {
			if (event.locals.user.role !== 'warden') {
				throw redirect(303, '/blog');
			}
		}
	}

	const response = await resolve(event);

	return response;
};
