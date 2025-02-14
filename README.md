# Symfony Application with Docker

This project is a Symfony application running inside Docker containers. It is easily deployable to a local environment on macOS or Linux.

## Prerequisites

Before setting up the project, ensure the following are installed on your machine:
- **Docker** (https://www.docker.com/products/docker-desktop)
- **Docker Compose** (usually bundled with Docker Desktop)

**Note**: Ensure that Docker and Docker Compose are up-to-date.

## Getting Started

### 1. Clone the Repository

Clone the repository to your local machine:

```bash
git clone https://github.com/Ronaca/cogify-task.git
```

### 2. Set Up Environment Variables

Before building the application, you need to set up your environment variables. 
Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

### 3. Build and Run the Containers

To start the application using Docker Compose, use the following command:

```bash
docker-compose up --build
```

Once the containers are built and running, you can access the application at `http://localhost:8000`.

