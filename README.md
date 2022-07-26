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
7. If you work on linux and cannot edit some of the project files right after the first installation, you can run 
8. docker-compose run --rm php chown -R $(id -u):$(id -g) . to set yourself as owner of the project files that were 
9. created by the docker container.

## Usage
This is an API project with authentication based in JWT token.

You can first register your user and then make a login request to get the JWT token.
Then you can do the authenticated requests including this token in an Authorization header with Bearer format.

## Comments

I have started from the [symfony-ddd-cqrs-hexagonal-skeleton](https://github.com/lcavero/symfony-ddd-cqrs-hexagonal-skeleton)
 project (also implemented by myself) as a base that already provides me with some functions that I need, such as CQRS
with Symfony Messenger, exception handling, serialization, validation.... .

I use [named constructors](https://verraes.net/2014/06/named-constructors-in-php/) in some classes to prevent Symfony 
include them as services and due to semantic reasons.

I use [adr pattern](https://en.wikipedia.org/wiki/Action%E2%80%93domain%E2%80%93responder) in Controllers to preserve 
the Single Responsability principle in them.

I'm only testing Domain Entities behaviour, sorry, I'm not very experienced in testing for now.

**Why only API is implemented?**
I think web side should not be in the same project. It's better to separate backend and frontend into two different projects.
For now I'm not interested in frontend so this project is gonna be only Api.


**Why Controller is creating the identifiers?**
Follow CQRS standard implies return no result in commands, but it's necessary return domain objects id's as the response 
in POST creation requests. So, I think is acceptable create a not-domain identifier in the controller, and let the 
command turn it into an appropiate Domain Id.

**Why update methods are empty in ORM repositories?**
A repository should differentiate between creating and updating, regardless of the specific implementation 
(ORM, ODM, Api, Redis Client...). In the case of Doctrine, no action is required to update an entity, because
it is already done when the flush method is called by the DoctrineTransactionMiddleware. 
However, I want to keep the update action in the repository, so if in the future it has to be changed to 
something else that doesn't work with Doctrine (API repository, for example), update calls are already done.

**Why are you including a trailing slash in all your routes?** The standard is to remove the trailing slash of all routes 
but recently I have experimented [problems](https://stackoverflow.com/questions/71311305/how-to-prevent-safari-from-dropping-the-authorization-header-when-following-a-sa) 
in other projects with Safari and the solution was add this trailing slash in my routes to evade Symfony redirection.
This is fixed in last Safari updates but I am currently adding this slash to prevents old Safari clients can't request correctly.

**Why are you using specification pattern with plain values?**
Standard Specification pattern uses the Domain entity (DE) to validate invariants, however, this is impossible to apply to validate
DE invariants because I am following the [Always-valid domain model](https://enterprisecraftsmanship.com/posts/always-valid-vs-not-always-valid-domain-model/)
and I can't pass an invalid DE to the specification. I could simply use *if sentences* in the DE, but I need to do the same validations as
input validations in the Application Layer, so... I decided to use a little different Specifications to validate plain values. 
Also, I added a validation context (only used in Application Layer) to return valid error messages to the Presentation Layer.

