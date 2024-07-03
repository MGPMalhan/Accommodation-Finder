import type { PageServerLoad } from './$types';

export const load: PageServerLoad = async (events) => {
	return {
		user: events.locals.user
	};
};
