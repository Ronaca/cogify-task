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

and navigate to the project directory:

```bash
cd cogify-task
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
docker-compose up --build -d
```

Once the containers are built and running, you can access the application at `http://localhost:8000`.

### 4. Enter the PHP Container and Install Dependencies

Enter the PHP container and install the application dependencies:

```bash
 composer install
```


### 5. Set Up the Database

To set up the database, run the following commands:

```bash
php bin/console doctrine:migrations:migrate
```

### 6. Access the Application

You can access the application at `http://localhost:8000`.
From there, you can go to the `/api` endpoint to view the API documentation.

### 7. Run tests

Create the test database:

```bash
php bin/console doctrine:database:create --env=test
```

Run migrations:

```bash 
php bin/console doctrine:migrations:migrate --env=test
```

Copy the `phpunit.xml.example` file to `phpunit.xml`:

```bash
cp phpunit.xml.example phpunit.xml
```

Run tests:

```bash
php bin/phpunit --testdox
```

