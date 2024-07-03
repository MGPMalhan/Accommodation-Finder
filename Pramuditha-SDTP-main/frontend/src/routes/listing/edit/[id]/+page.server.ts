import type { PageServerLoad } from '../../$types';
import { PrismaClient } from '@prisma/client';

const prisma = new PrismaClient();

export const load: PageServerLoad = async (event) => {
	const user = event.locals.user;
	const id = event.params.id;

	const property = await prisma.property.findUnique({
		where: {
			id: parseInt(id)
		}
	});

	return {
		user,
		property
	};
};
