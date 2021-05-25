### Запуск проекта

```bash
cp .env.test .env
docker-compose up --build -d
cd app
cp .env.test .env
```

Чтобы войти в любой из контейнеров, делаем следующее:
```bash
docker exec -it <container_name> bash
```

Посмотреть запущенные контейнеры:
```bash
docker ps
```

Логи контейнера:
```bash
docker logs <container_name>
```

Обновить базу:
```bash
php bin/console doctrine:schema:update --force
```

При ошибке:
```sql
SET GLOBAL sql_mode='';
```

Запуск фикстур:
```bash
php bin/console doctrine:fixtures:load
```