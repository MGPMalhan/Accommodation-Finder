import { authenticateUser } from '$lib/auth';
import type { PageServerLoad } from '../$types';
import { PrismaClient } from '@prisma/client';

const prisma = new PrismaClient();

export const load: PageServerLoad = async (event) => {
	const user = await authenticateUser(event);
	// get a list of properties owned by the user
	const properties = await prisma.property.findMany({
		where: {
			landlordId: parseInt(event.locals.user.id)
		}
	});
	return {
		user,
		properties
	};
};
