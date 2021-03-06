# API de sistema de avaliação de livros
> Desenvolvimento com Framework Laravel 8.0

Este é um pequeno sistema desenvolvido apenas para aprimoramento de habilidades. O propósito dele é permitir cadastro e gestão de editoras, séries, autores, gêneros, livros e avaliações de livros.

Para autenticação desta API utilizei Laravel Sanctum 2.11 com validação através de token.

## Requisitos mínimos
- PHP 7.4
- MYSQL 5.7
- Composer

## Inicialização deste projeto

#### *Instalação:*

Abra uma janela de terminal na raiz da pasta do projeto e utilize os comandos a seguir:

```shell
cp .env.example .env

composer install

php artisan key:generate
```

#### *Conexão com banco de dados:*

Este projeto requer que você já tenha criado um banco de dados vazio para ser utilizado no projeto. O nome recomendado é *livro_rating*, mas você tem liberdade para usar o nome que desejar.

É necessário ir até a raiz da pasta do projeto e editar o arquivo **.env** com as informações de acesso ao banco de dados que você criou. O trecho cuja edição é necessária segue esta estrutura:

```
DB_HOST=127.0.0.1
DB_PORT=3308
DB_DATABASE='nome do seu database'
DB_USERNAME='seu usuario'
DB_PASSWORD='sua senha'
```

Edite os dados de acordo com o seu ambiente. Preste atenção ao parâmetro DB_PORT, pois ele possui variações, podendo ser 3306 ou 3308, por exemplo.

#### *Criação de tabelas e alimentação de dados básicos:*

A criação de tabelas e a alimentação de dados básicos é feita através de comandos da própria aplicação, desde que a etapa de conexão com o banco de dados tenha sido feita de maneira correta.

Abra uma janela de terminal na raiz da pasta do projeto e utilize os comandos a seguir:

```shell
php artisan migrate
php artisan db:seed
```

A aplicação fará o resto do trabalho para você.

#### *Rodando a aplicação:*

Abra uma janela de terminal na raiz da pasta do projeto e utilize o comando a seguir:

```shell
php artisan serve --port=8000
```

Mantenha esta janela de terminal aberta para que seja possível encerrar o serviço posteriormente.

Você poderá fazer testes dos endpoints da API usando programas como *Postman* e *Insomnia REST Client*. Os endpoins estão listados no tópico **Rotas da aplicação**.

#### *Rodando cases de teste com PHPUnit:*

Caso vá executar a rotina de cases de teste, é necessário primeiro criar um novo banco de dados vazio exclusivo para os testes. O nome recomendado é *livro_rating_testing*, mas você tem liberdade para usar o nome que desejar.

É necessário ir até a raiz da pasta do projeto e editar o arquivo **phpunit.xml** com o nome do banco de dados que você criou para execução de testes. O trecho cuja edição é necessária segue esta estrutura:

```
<server name="DB_DATABASE" value="nome do seu database"/>
```

Abra uma janela de terminal na raiz da pasta do projeto e utilize o comando a seguir:

```shell
php artisan test
```

Serão executados alguns cases de testes com o PHPUnit. As respostas dos testes serão exibidas na própria janela do terminal.

#### *Encerrando execução da aplicação:*

Pressione **ctrl + c** na janela de terminal aberta no tópico **Rodando a aplicação** para encerrar a execução do serviço.

## Estrutura de pastas

* app/
    * BusinessLayer/
        * Actions/ => Onde guardamos classes que executam apenas uma tarefa. Pode possuir subpastas de acordo com as entidades que estão sendo trabalhadas.
            * Pasta1/
            * Pasta2/
        * Features/ => Onde guardamos classes que agrupam actions num determinado propósito. Pode possuir subpastas.
        * Validators/ => Onde guardamos classes que fazem validação de dados. Pode possuir subpastas.
    * DataLayer/
        * DTOs/ => Onde guardamos os data transfer objects, que são usados para organizar e passar os dados entre as camadas do sistema.
    * Http/
        * Controllers/ => Onde guardamos as classes controladoras
            * Api/
                * LivroController.php
        * Resources/ => Onde guardamos as classes que formatam os dados antes dos mesmos serem servidos.
            * LivroCollection.php
            * LivroResource.php
* config/
* stubs/ => Onde guardamos os arquivos de "esqueleto" para criação de variados tipos de classes usando o artisan.

## Rotas da aplicação

| URL | Verbo | Nome | Descrição |
| --- | --- | --- | --- |
| http://localhost:8000/api/auth/registrar | POST | auth.registro.store | Cadastra um novo usuário para a API |
| http://localhost:8000/api/auth/perfil | GET | auth.show | Visualiza dados do usuário autenticado |
| http://localhost:8000/api/auth/login | POST | auth.store | Efetua login na API |
| http://localhost:8000/api/auth/logout | POST | auth.destroy | Efetua logout na API |
| &nbsp; | &nbsp; | &nbsp; |
| http://localhost:8000/api/editoras | GET | editoras.index | Lista de todas as editoras |
| http://localhost:8000/api/editoras/{editora} | GET | editoras.show | Visualiza dados de um editora específica |
| http://localhost:8000/api/editoras | POST | editoras.store | Cadastra uma nova editora |
| http://localhost:8000/api/editoras/{editora} | PUT | editoras.update | Atualiza dados de uma editora específica |
| http://localhost:8000/api/editoras/{editora} | DELETE | editoras.destroy | Remove uma editora específica |
| &nbsp; | &nbsp; | &nbsp; |
| http://localhost:8000/api/editoras/{editora}/livros | GET | editoras.livros.index | Lista de todos os livros de uma editora específica |
| &nbsp; | &nbsp; | &nbsp; |
| http://localhost:8000/api/autores | GET | autores.index | Lista de todos os autores |
| http://localhost:8000/api/autores/{autor} | GET | autores.show | Visualiza dados de um autor específico |
| http://localhost:8000/api/autores | POST | autores.store | Cadastra um novo autor |
| http://localhost:8000/api/autores/{autor} | PUT | autores.update | Atualiza dados de um autor específico |
| http://localhost:8000/api/autores/{autor} | DELETE | autores.destroy | Remove um autor específico |
| &nbsp; | &nbsp; | &nbsp; |
| http://localhost:8000/api/autores/{autor}/livros | GET | autores.livros.index | Lista de todos os livros de um autor específico |
| &nbsp; | &nbsp; | &nbsp; |
| http://localhost:8000/api/generos | GET | generos.index | Lista de todos os gêneros |
| http://localhost:8000/api/generos/{genero} | GET | generos.show | Visualiza dados de um gênero específico |
| http://localhost:8000/api/generos | POST | generos.store | Cadastra um novo gênero |
| http://localhost:8000/api/generos/{genero} | PUT | generos.update | Atualiza dados de um gênero específico |
| http://localhost:8000/api/generos/{genero} | DELETE | generos.destroy | Remove um gênero específico |
| &nbsp; | &nbsp; | &nbsp; |
| http://localhost:8000/api/generos/{genero}/livros | GET | generos.livros.index | Lista de todos os livros de um gênero específico |
| &nbsp; | &nbsp; | &nbsp; |
| http://localhost:8000/api/series | GET | series.index | Lista de todas as séries |
| http://localhost:8000/api/series/{serie} | GET | series.show | Visualiza dados de uma série específica |
| http://localhost:8000/api/series | POST | series.store | Cadastra uma nova série |
| http://localhost:8000/api/series/{serie} | PUT | series.update | Atualiza dados de uma série específica |
| http://localhost:8000/api/series/{serie} | DELETE | series.destroy | Remove uma série específica |
| &nbsp; | &nbsp; | &nbsp; |
| http://localhost:8000/api/series/{serie}/livros | GET | series.livros.index | Lista de todos os livros de uma série específica |
| &nbsp; | &nbsp; | &nbsp; |
| http://localhost:8000/api/livros | GET | livros.index | Lista de todos os livros |
| http://localhost:8000/api/livros/pesquisar | POST | livros.pesquisa.index | Lista de livros fruto de uma pesquisa avançada |
| http://localhost:8000/api/livros/{livro} | GET | livros.show | Visualiza dados de um livro específico |
| http://localhost:8000/api/livros | POST | livros.store | Cadastra um novo livro |
| http://localhost:8000/api/livros/{livro} | PUT | livros.update | Atualiza dados de um livro específico |
| http://localhost:8000/api/livros/{livro} | DELETE | livros.destroy | Remove um livro específico |
| &nbsp; | &nbsp; | &nbsp; |
| http://localhost:8000/api/livros/{livro}/foto-capa | PUT | livros.foto-capa.update | Atualiza foto da capa de um livro específico |
| &nbsp; | &nbsp; | &nbsp; |
| http://localhost:8000/api/livros/{livro}/avaliacoes | GET | livros.avaliacoes.index | Lista de todas as avaliações de um livro específico |
| http://localhost:8000/api/livros/{livro}/avaliacoes | POST | livros.avaliacoes.store | Cadastra uma nova avaliação para um livro específico |
| &nbsp; | &nbsp; | &nbsp; |
| http://localhost:8000/api/avaliacoes/{avaliacao} | GET | avaliacoes.show | Visualiza dados de uma avaliação específica |
| http://localhost:8000/api/avaliacoes/{avaliacao} | PUT | avaliacoes.update | Atualiza dados de uma avaliação específica |
| http://localhost:8000/api/avaliacoes/{avaliacao} | DELETE | avaliacoes.destroy | Remove uma avaliação específica |

## TO DO

- [ ] Listagem de livros filtrados por editora, gênero, autor e série
- [ ] Upload de imagem para foto da capa do livro
- [ ] Testes com phpUnit

Vamos codar :+1:
