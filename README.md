# Configuration Instructions and Build Details

1.Setup Configuration

Ensure that your .env file contains necessary configurations, such as:

```
    APP_NAME=json-api

    REDIS_CLIENT=phpredis
    REDIS_HOST=redis
    REDIS_PASSWORD=null
    REDIS_PORT=6379
    
```

2.Dependencies

Make sure you have all necessary PHP packages installed:
```
    composer install
    
```

3.Build and Run

Ensure Docker containers are running, including Redis:

```
    docker-compose build
    docker-compose up -d
    
```

## How to use

    Base URL: /api/

the 'q' parameter is used to specify the search query

    /api/?q=girls

# Future Evolution of the API

In the future, the API capabilities for this service could be expanded by adding support for additional endpoints and integrations with other APIs. Moreover, a more structured caching strategy could be considered to optimize query performance and reduce response times.

Additionally, it would be beneficial to implement versioning for the API to ensure backward compatibility as new features are added. Implementing detailed logging and monitoring could also help in maintaining and debugging the service more effectively.
