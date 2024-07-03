import type { RequestEvent } from '@sveltejs/kit';
import { PrismaClient } from '@prisma/client';
import { loginstat } from './stores';

const prisma = new PrismaClient();

export const authenticateUser = async (event: RequestEvent) => {
	// Get the cookies from the request
	const { cookies } = event;

	// Get the user token from the cookie
	const userToken = cookies.get('auth');

	if (!userToken) {
		loginstat.set(0);

		return null;
	}

	try {
		// Fetch the user from the database
		const user = await prisma.user.findUnique({
			where: {
				id: parseInt(userToken)
			}
		});

		// Check if user exists and return user data
		if (user) {
			loginstat.set(1);
			return user;
		} else {
			// No user found
			loginstat.set(0);
			return null;
		}
	} catch (error) {
		console.error('Error fetching user:', error);
		loginstat.set(0);

		return null;
	}
};
