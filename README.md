# Repository

![Continuous Integration](https://github.com/pgrau/repository/workflows/Continuous%20Integration/badge.svg)

Get all dependencies and execute your pipeline

### 🖥️ Stack Technology

<p>PHP 8.1</p>

## 🚀 Environment Setup

### 🐳 Needed tools

1. [Install Docker](https://www.docker.com/get-started)
2. Clone this project: `git clone https://github.com/pgrau/repository`
3. Move to the project folder: `cd repository`

### 🔥 Application execution

1. Install and configure all the dependencies and bring up the project executing:
   `make start`

2. Execute the tests executing:
   `make test`

3. Generate the code coverage executing:
   `make coverage`

   The code coverage will be generated in the folder: `metrics/coverage`

4. Generate various metrics executing:
   `make analizer`

   The report will be generated in the folder: `metrics/analizer`

   You will see the complexity of the project in `metrics/analizer/complexity.html`

5. Check possible errors in the code executing:
   `make phpstan`

6. Check the code standard executing:
   `make phpcs`

7. Fix the code standard automatically executing:
   `make fixer`

8. Stop all dockers containers executing:
   `make down`
   