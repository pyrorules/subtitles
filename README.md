# Subtitles

A simple app that generates word usage statistics for a given file

## Requirements

- Docker >=18.09
- docker-compose

## Running up the application

```
$ docker run -d --name docker-hostmanager --restart=always -v /var/run/docker.sock:/var/run/docker.sock -v /etc/hosts:/hosts dkarlovi/docker-hostmanager
$ docker-compose up -d
$ docker-compose exec php composer install
```

The application should now be available at http://subtitles.loc

## Launching tests

Static code analysis:
```
$ docker-compose exec php composer run psalm
$ docker-compose exec php composer run cs
```

Unit tests:
```
$ docker-compose exec php composer run phpunit
```

Everything at once:
```
$ docker-compose exec php composer run qa
```

## Some explanations

- Pragmatically speaking, subtitles files are usually very small so memory management matters are omitted when reading files in the application
- `sample` directory contains files in different formats that can be used to check the application's functionality
