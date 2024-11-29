
# Gestor predial.

esse é o projeto de quinto semestre da Uniasselvi!


# Instalação

O projeto foi construido com uma linguagem interpretada, bastando apenas expor em formato de um servidor local (ou web). O aplicativo foi construido pensado para funcionar com Docker OU XAMPP para Windows. Siga os respectivos tutoriais para conseguir executar o projeto.


## Criando um servidor local:

### Docker

Docker nos permite construir toda uma complexa estrutura de aplicativos que se interligam, desde um servidor web Apache até um banco de dados MySql sem a possibilidade de erros internos ou mal versionamento.


para criar o ambiente, basta instalar o Docker no computador e pelo terminal ir até a pasta raiz do projeto e executar

```bash
docker compose up
```

para apagar os dados basta executar

```bash
docker compose down -v
```


### XAMPP
- Versão durante a escrita -> 8.2.1.2

Basta apenas pegar o projeto e copiar e colar TODOS os arquivos para a página htdocs do xampp.

porem será necessário configurar o banco de dados manualmente. basta apenas executar em algum terminal:

```bash
php ./src/Database/migrador.php
```

essa script irá construir nosso banco de dados MySql.
Caso tenha o XAMPP instalado porem não tenha o PHP instalado, basta apenas adicionar a pasta com o executavel do php para as variáveis de ambientes do computador. para ser mais exato: PATH.



