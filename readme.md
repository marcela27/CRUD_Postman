```bash
composer install
php -S localhost:8081
abrir URL no Postaman: http://localhost:8081
```

```sql
CREATE TABLE `clientes` (
  `cliente_id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cidade` varchar(255) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`cliente_id`)
); ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
```

{
    "id": "4",
    "nome": "Joana",
    "email": "joana@gmail.com",
    "cidade": "São Paulo",
    "estado": "SP"
}