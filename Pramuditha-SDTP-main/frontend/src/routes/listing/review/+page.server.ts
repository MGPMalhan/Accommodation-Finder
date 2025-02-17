// src/routes/your-route/+page.server.ts

import type { PageServerLoad } from './$types';
import { PrismaClient, PropertyStatus } from '@prisma/client';

const prisma = new PrismaClient();

export const load: PageServerLoad = async ({ url }) => {
	// Get the current offset from the query string, defaulting to 0
	const page = parseInt(url.searchParams.get('page') || '1');
	const minPrice = parseInt(url.searchParams.get('minPrice') || '0');
	const maxPrice = parseInt(url.searchParams.get('maxPrice') || '1000000');
	let location = url.searchParams.get('location') || '';

	if (location === 'All') {
		location = '';
	}

	let properties;
	if (location != '')
		properties = await prisma.property.findMany({
			skip: (page - 1) * 9, // Skip the number of properties already loaded
			take: 9, // Take the next 3 properties
			where: {
				status: PropertyStatus.pending,
				location: location,
				rentalPrice: {
					gte: minPrice,
					lte: maxPrice
				}
			}
		});
	else
		properties = await prisma.property.findMany({
			skip: (page - 1) * 9, // Skip the number of properties already loaded
			take: 9, // Take the next 3 properties
			where: {
				status: PropertyStatus.pending,
				rentalPrice: {
					gte: minPrice,
					lte: maxPrice
				}
			}
		});

	// get a list of all unique locations from properties
	const locations = await prisma.property.findMany({
		select: {
			location: true
		},
		distinct: ['location']
	});

	// compile a list of pins
	const pins = properties.map((property) => {
		return {
			latitude: property.latitude,
			longitude: property.longitude,
			title: property.title,
			price: property.rentalPrice
		};
	});

	return {
		properties,
		locations,
		currentPage: page,
		filters: {
			minPrice,
			maxPrice,
			location: location === '' ? 'All' : location
		},
		pins
	};
};
