# ToDoApp

## Execução
- composer install (Para instalar as dependências e gerar o arquivo de autoload).
- Utilizando docker:
  - docker-compose up -d
  - docker exec -it php php bin/console doctrine:migrations:migrate 
- Sem docker:
  - php -S 0.0.0.0:80 -t public/
  - php bin/console doctrine:migrations:migrate 
