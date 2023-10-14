# Пользователь Symfony CRUD

## Инструкция по разворачиванию проекта
1) Клонирование в терминале
```
git clone https://github.com/tlegen99/symfony-user.git
```

2) Билд и запуск контейнеров.
```
docker-compose build
```
```
docker-compose up -d
```

3) Открыть bash контейнера php.
```
docker exec -it app bash
```

4) Установите зависимости Composer
```
composer install
```

5) Запуск миграции
```
php bin/console doctrine:migrations:migrate
```

## Ссылки API
1) Post Добавление
```
http://localhost:8798/api/v1/user
```

2) Get Чтение(одного или всех)
```
http://localhost:8798/api/v1/user
```
```
http://localhost:8798/api/v1/users
```

3) Put Редактирование по id
```
http://localhost:8798/api/v1/user/{id}
```

3) Delete Удаление по id
```
http://localhost:8798/api/v1/user/{id}
```
