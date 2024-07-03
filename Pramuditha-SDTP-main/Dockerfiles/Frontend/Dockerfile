# Use the official Node.js 18 image as a parent image
FROM node:18-alpine

# Set the working directory in the container
WORKDIR /app

# Copy the rest of your app's source code from your host to your image filesystem.
COPY frontend/ .

# Install dependencies
RUN npm install

# Build the Next.js app
RUN npm run build

# Command to run when starting the container
CMD ["npm", "run", "preview"]
