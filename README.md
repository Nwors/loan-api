# loan-api

Проект для выдачи продуктов пользователю, постороен с применением архитектурного стиля
DDD (Domain Driver Design) и CQRS (Command Query Responsible Segregation)
(Из осознанных нарушений стиля, используются Doctrine коллекции в Domain для удобства)

Слои:

    Core:
        Domain - слой домена (бизнес логика, сущности)
        Application - слой приложения (уровень action'ов и action handler'ов)
    Infrastructure - слой инфраструктуры, реализации интерфейсов средствами фреймворка и внешние зависимости
    Presentation - слой представления, контроллеры, и прочие входы и выходы системы.

## Сборка

```bash
docker compose up -d --build --force-recreate
```

или

```bash
make up
```

По умолчанию nginx на порту 8080, БД на порту 5433, не 5432. 

## Миграции

```bash
docker compose exec php php bin/console doctrine:migrations:migrate
```

или

```bash
make db-migrate
```

Так как создание продукта не предусмотрено реализацией, в миграции создаются два продукта с идентификаторами ('10eb998a-3631-ba57-2f22-4e029e1dda4c' и 'ba177f63-1ea6-ba38-70ef-f7f22d776c47')

### Реализация

Существующие методы API:
(Да, для этого можно было прикрутить openapi docs)

Создание пользователя:
```
POST http://localhost:8080/user
```
```JSON
{
    "firstName": "John",
    "lastName": "Doe",
    "age": 30,
    "city": "New York",
    "usState": "NY",
    "ssn": "123-45-6789",
    "fico": 720,
    "email": "john.doe@example.com",
    "phone": "555-1234"
}
```
Обновление пользователя
```
PATCH http://localhost:8080/user/{id}
```
Просмотр продукта
```
GET http://localhost:8080/product/{id}
```
Проверка возможности выдачи продукта пользователю
```
GET http://localhost:8080/product/{:productId}/eligibility?user_id={:userId}
```
Выдача продукта пользователю
```
POST http://localhost:8080/user/:id/product
```
```JSON
{
    "productId" : "10eb998a-3631-ba57-2f22-4e029e1dda4c"
}
```

### Тесты
Проект не покрыт тестами, так как они занимают длительное время на подготовку инфраструктуры
фикстуры, тестовая БД, моки стабы и т.д.

### Время
Затрачено примерно 6 - 8 часов
