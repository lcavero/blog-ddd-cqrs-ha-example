#  Symfony Blog DDD + CQRS + Hexagonal Architecture

A Symfony blog project made with CQRS, Hexagonal Architecture and DDD

## Docker integration

This project has been created using the [Symfony Docker](https://github.com/dunglas/symfony-docker) repository.

## Deploy

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/)
2. In docker-compose.override.yml choose between dev or prod environment
3. Run `docker-compose build --pull --no-cache` to build fresh images
4. Run `docker-compose up` (the logs will be displayed in the current shell)
5. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
6. Run `docker-compose down --remove-orphans` to stop the Docker containers.
7. If you work on linux and cannot edit some of the project files right after the first installation, you can run docker-compose run --rm php chown -R $(id -u):$(id -g) . to set yourself as owner of the project files that were created by the docker container.


# Comments

I have started from the [symfony-ddd-cqrs-hexagonal-skeleton](https://github.com/lcavero/symfony-ddd-cqrs-hexagonal-skeleton)
 project (also implemented by myself) as a base that already provides me with some functions that I need, such as CQRS with Symfony Messenger, exception handling, serialization, validation.... .

I use [named constructors](https://verraes.net/2014/06/named-constructors-in-php/) in some classes to prevent Symfony include them as services and due to semantic reasons.
