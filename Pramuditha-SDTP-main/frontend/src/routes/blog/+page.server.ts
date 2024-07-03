import type { PageServerLoad } from './$types';
import { PrismaClient } from '@prisma/client';

const prisma = new PrismaClient();

export const load: PageServerLoad = async () => {
	const articles = await prisma.article.findMany({
		orderBy: {
			id: 'desc'
		},
		take: 20
	});

	return {
		articles
	};
};
