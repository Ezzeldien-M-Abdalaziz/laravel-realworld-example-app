## Setup & Running the Backend

### Clone & Install

- git clone <https://github.com/Ezzeldien-M-Abdalaziz/laravel-realworld-example-app.gitl>
- cd laravel-realworld-example-app
- composer install
- cp .env.example .env
- php artisan key:generate


### Database Setup

- Update .env with your DB credentials.

#### Run migrations:

- php artisan migrate
- php artisan db:seed


### Run the server

- php artisan serve

### Revision Feature Overview

The Article Revision system automatically stores previous versions of an article whenever it’s updated.

Each revision stores the old title, description, body, and user ID.

Revisions are linked to their parent article.

#### Owners of articles can:

- List revisions of an article

- View a single revision

- Revert the article to a previous revision

### Assumptions & Design Decisions

- Only the article owner can access or revert revisions (enforced by ArticleRevisionPolicy)

- Revisions are created automatically by an Eloquent Observer (ArticleObserver).

- Unauthorized users get 403 Forbidden.

- Tests cover both happy path and unauthorized access.
### Testing

- Automated tests were added to ensure correctness:

- Unit Test

- ArticleObserverTest: verifies revisions are created on update.

- Feature Tests

#### ArticleRevisionTest: 
- covers listing, showing, reverting, and unauthorized access.

#### ArticleTest:
- ensures articles can be fetched correctly.

#### Run tests with:

- php artisan test


### Postman Collection

- A Postman collection is included in the project (postman/ArticleRevisions.postman_collection.json).

- Contains requests for list revisions, view revision, revert article.

- Preconfigured with auth tokens where required.
