import type { PageServerLoad } from './$types';
import { PrismaClient } from '@prisma/client';

const prisma = new PrismaClient();

export const load: PageServerLoad = async ({ params }) => {
	const id = params.id;

	// Load Property by ID
	const property = await prisma.property.findUnique({
		where: {
			id: parseInt(id)
		}
	});

	let landloard;
	let reviews;

	// get landloard Information
	if (property?.landlordId) {
		landloard = await prisma.user.findUnique({
			where: {
				id: property?.landlordId
			}
		});
	}

	// get reviews
	if (property?.id) {
		reviews = await prisma.review.findMany({
			where: {
				propertyId: property?.id
			}
		});
	}

	return {
		property,
		landloard,
		reviews
	};
};
