import { redirect } from '@sveltejs/kit';
import type { Actions } from './$types';
import { PrismaClient } from '@prisma/client';

const prisma = new PrismaClient();

export const actions: Actions = {
	login: async ({ request, cookies }) => {
		const form = await request.formData();
		const username = form.get('username');
		const password = form.get('password');

		if (typeof username !== 'string' || typeof password !== 'string') {
			return { error: 'Invalid form data' };
		}

		try {
			const user = await prisma.user.findUnique({
				where: {
					username: username
				}
			});

			if (!user || !user.password) {
				// User not found or user has no password set
				return { error: 'Invalid login credentials' };
			}

			const passwordIsValid = user.password === password;

			if (!passwordIsValid) {
				return { error: 'Invalid login credentials' };
			}

			// Here, instead of 'regularusertoken', you should generate a secure token.
			// This could be a JWT or any other secure means of representing user sessions.
			// For simplicity, I'm using the user's ID.
			cookies.set('auth', user.id.toString(), {
				path: '/',
				httpOnly: true,
				sameSite: 'strict',
				secure: process.env.NODE_ENV === 'production',
				maxAge: 60 * 60 * 24 * 7 // 1 week
			});

			throw redirect(303, '/');
		} catch (error) {
			console.error('Login error:', error);
			return { error: 'Failed to process login' };
		}
	}
};
