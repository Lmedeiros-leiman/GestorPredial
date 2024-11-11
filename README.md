# Gerenciador de condominio.
a

## Instalando 

### Configuração do Ambiente

> **Aviso Importante**: Esta aplicação foi desenvolvida e testada utilizando XAMPP v3.3.0. Outras versões podem exigir configurações adicionais.

### 1. Banco de Dados

O aplicativo utiliza MySQL como sistema de banco de dados. Para configurar:

1. Certifique-se de que o MySQL está instalado e em execução
2. Navegue até o diretório raiz do projeto
3. Execute o script de migração:

```bash
php ./Core/Basics/Database/Migration/migrate.php
```

Este comando irá automaticamente:
- Criar todas as tabelas necessárias
- Configurar os relacionamentos entre tabelas
- Adicionar as permissões padrão
- Configurar as definições iniciais

> **Importante**: Verifique se as credenciais do banco de dados estão configuradas corretamente em `config/database.php` antes de executar as migrações.

### 2. Servidor Web (XAMPP)

> Observação: Estas etapas servem para hospedar o servidor localmente ou em maquinário 100% pessoal e com total acesso.
>
> Verifique seu plano de hospedagem caso isso não seja a realidade.

#### 2.1 Instalação do XAMPP

1. Baixe o XAMPP v3.3.0:
   - Windows: https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/3.3.0/
   - Linux: https://sourceforge.net/projects/xampp/files/XAMPP%20Linux/3.3.0/

2. Instale o XAMPP:
   - Windows: Execute o instalador normalmente
   - Linux:
     ```bash
     chmod +x xampp-linux-x64-3.3.0-0-installer.run
     sudo ./xampp-linux-x64-3.3.0-0-installer.run
     ```

#### 2.2 Configuração no Windows

1. Copie o projeto para a pasta `htdocs`:
   ```bash
   C:\xampp\htdocs\GestorPredial
   ```

> Observação: As etapas a seguir apenas servem para expor o servidor na web. Podem ser ignoradas para um servidor local.

2. Configure o Virtual Host:
   1. Abra `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
   2. Adicione:
   ```apache
   <VirtualHost *:80>
       DocumentRoot "C:/xampp/htdocs/GestorPredial"
       ServerName GestorPredial.local
       <Directory "C:/xampp/htdocs/GestorPredial">
           Options Indexes FollowSymLinks
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```

3. Edite o arquivo hosts:
   1. Abra como administrador: `C:\Windows\System32\drivers\etc\hosts`
   2. Adicione:
   ```
   127.0.0.1 GestorPredial.local
   ```

#### 2.3 Configuração no Linux

1. Copie o projeto para a pasta `htdocs`:
   ```bash
   sudo cp -r seu-projeto /opt/lampp/htdocs/
   ```

2. Configure o Virtual Host:
   1. Abra `/opt/lampp/etc/extra/httpd-vhosts.conf`
   2. Adicione:
   ```apache
   <VirtualHost *:80>
       DocumentRoot "/opt/lampp/htdocs/GestorPredial"
       ServerName seu-projeto.local
       <Directory "/opt/lampp/htdocs/GestorPredial">
           Options Indexes FollowSymLinks
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```

3. Edite o arquivo hosts:
   ```bash
   sudo nano /etc/hosts
   ```
   Adicione:
   ```
   127.0.0.1 GestorPredial.local
   ```

#### 2.4 Iniciando os Serviços

Windows:
1. Abra o XAMPP Control Panel
2. Inicie Apache e MySQL

Linux:
```bash
sudo /opt/lampp/lampp start
```

#### 2.5 Acessando a Aplicação

Após a configuração, você pode acessar:
- Com Virtual Host: http://GestorPredial.local
- Sem Virtual Host: http://localhost/GestorPredial

> **Dicas**:
> - Certifique-se de que as portas 80 (Apache) e 3306 (MySQL) estão disponíveis
> - No Linux, pode ser necessário ajustar as permissões da pasta do projeto:
>   ```bash
>   sudo chmod -R 755 /opt/lampp/htdocs/GestorPredial
>   sudo chown -R daemon:daemon /opt/lampp/htdocs/GestorPredial
>   ```
> - Em caso de problemas, verifique os logs do Apache:
>   - Windows: `C:\xampp\apache\logs\error.log`
>   - Linux: `/opt/lampp/logs/error.log`


## Estrutura do projeto:


### Estrutura dos arquivos:
    - Core: possui as funcionalidades básicas da aplicação. Desde uma script para lidar com o envio de Emails, Autenticação, Resposta a pedidos... todo o básico essencial para uma aplicação.

    - Configurables: Armazena os dados configuraveis para a aplicação a nivel de **desenvolvedor**.

    - Protected: Armazena os arquivos colocados no sistema por cada usuário. eles podem compartilhar arquivos. arquivos compartilhados ficarão na pasta shared.

    - Public: Armazena os arquivos publicos do servidor, scripts javascript, arquivos de estilo css, imagens e icones... qualquer arquivo seja disponivel 

    - Modules: Representa cada módulo de alto nivel da aplicação: Gestor de pessoas, apartamentos, inventário...

