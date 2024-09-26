# Beauty Sys 

Repositório destinado a documentar a evolução do sistema Beauty Sys. 
Este sistema está sendo desenvolvido como um trabalho na matéria de Laboratório de Engenharia de Software, presente na grade de graduação do curso de Análise e Desenvolvimento de Sistemas na Fatec Campinas.<br>
**Equipe responsável:** Dimas F. Silva, Gabriel P. M. de Freitas, Gabriel Odorcik, Lais M. T. Rangel, Rodrigo O. Feitosa.

## ‍ 📝 Sobre o sistema

O projeto Beauty Sys é um sistema de gerenciamento para salões de beleza, desenvolvido para otimizar a administração de agendamentos. Este sistema permitirá aos salões gerenciar eficientemente suas operações diárias, oferecendo aos clientes a capacidade de agendar serviços como cortes de cabelo, coloração, manicure, pedicure e outros tratamentos de beleza.

Além disso, pensando na evolução natural do sistema, projetamos o Beauty Sys para incluir funcionalidades de venda de produtos de beleza. Isso permitirá que os salões não apenas prestem serviços, mas também comercializem uma variedade de produtos, como xampus, condicionadores, cremes e acessórios. O objetivo é oferecer uma interface amigável que facilite e integre a experiência em salões de beleza e barbearias.

## 📒 Manual do projeto
O manual completo e atualizado do projeto está disponível no link do notion a seguir: 
https://delicate-weight-9bf.notion.site/Manual-do-projeto-Beauty-Sys-6e02a9e2732548599756547a09de520c?pvs=4

## 📅 Cronograma do projeto
O cronograma atualizado está disponível no link do Jira a seguir: 
https://dfprata.atlassian.net/jira/software/projects/SCRUM/boards/1/timeline?shared=&atlOrigin=eyJpIjoiNmQyZTkyODIxMzE3NDI2ZmI5ZjViMmI0YjljZDVmYjEiLCJwIjoiaiJ9

## Como executar o projeto na sua máquina

### Pré-Requisitos
Antes de começar, certifique-se de que você tem os seguintes softwares instalados em sua máquina:

- PHP >= 8.0
- Composer (https://getcomposer.org/)
- MySQL ou PostgreSQL (ou outro banco de dados compatível)


```bash
  git clone https://github.com/lais-telles/Beauty-Sys.git
```

Vá até o diretório do projeto

```bash
  cd beautysys
```

Instale o composer:

```bash
  composer install
```

Copie o arquivo .env.example

```bash
  cp .env.example .env
```

Gere a chave da aplicação
```bash
  php artisan key:generate
```

Configure o banco de dados (.env)
```bash
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=beauty_sys
  DB_USERNAME=usuario
  DB_PASSWORD=senha
```

Inicie o servidor de desenvolvimento
```bash
  php artisan serve
```


 





