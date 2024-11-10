# Gerenciador de condominio.



## Estrutura do projeto:


### Estrutura dos arquivos:
    - Core: possui as funcionalidades básicas da aplicação. Desde uma script para lidar com o envio de Emails, Autenticação, Resposta a pedidos... todo o básico essencial para uma aplicação.

    - Configurables: Armazena os dados configuraveis para a aplicação a nivel de **desenvolvedor**.

    - Protected: Armazena os arquivos colocados no sistema por cada usuário. eles podem compartilhar arquivos. arquivos compartilhados ficarão na pasta shared.

    - Public: Armazena os arquivos publicos do servidor, scripts javascript, arquivos de estilo css, imagens e icones... qualquer arquivo seja disponivel 

    - Modules: Representa cada módulo de alto nivel da aplicação: Gestor de pessoas, apartamentos, inventário...

