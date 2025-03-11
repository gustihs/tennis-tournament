
## Tennis tournament - Geopagos

- Dockerizado con Sail (https://github.com/laravel/sail): Laravel + MongoDB (docker-compose.yml)
- Se utilizó Laravel v12 (https://laravel.com/docs/12.x/)

 ### Instrucciones
1. Instalación de dependencias
    ```
        docker compose up -d laravel.test
        docker compose exec laravel.test bash
        composer install
    ```
2. Salir del contenedor y reiniciarlo
    ```
        docker compose restart laravel.test
    ```
3. Archivo .env de configuración
    ```
        mv .env.example .env
    ```
4. Ingresar en http://localhost/docs/api y listo

### Swagger
- En http://localhost/docs/api#/operations/tournaments.index está configurado un Swagger con la documentación relacionada

![alt text](https://github.com/gustihs/tennis-tournament/blob/main/swagger1.png?raw=true)

![alt text](https://github.com/gustihs/tennis-tournament/blob/main/swagger2.png?raw=true)

### Tests
- Se incluyen tests sobre el domain core de la simulación del torneo

![alt text](https://github.com/gustihs/tennis-tournament/blob/main/tests.png?raw=true)

