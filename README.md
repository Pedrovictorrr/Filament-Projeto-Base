# Projeto Base em Laravel com Filament

Este é um projeto base em Laravel integrado com Filament, uma biblioteca para administração de painéis de controle elegantes e personalizáveis. Este projeto foi desenvolvido para facilitar o início de novos sistemas em Laravel, fornecendo uma estrutura sólida e recursos essenciais, incluindo:

- Log de Atividade
- Log de Exceções ( [Laravel Exception Spatie](https://spatie.be/docs/laravel-permission/v6/advanced-usage/exceptions) )
- Funções e Permissões ( [Laravel Permission Spatie](https://spatie.be/index.php/docs/laravel-permission/v6/introduction) )
- CRUD de Usuários 
- Área para Cadastrar Releases

## Configuração

### Pré-requisitos

Antes de começar, certifique-se de ter os seguintes requisitos instalados em sua máquina:

- PHP >= 8.1
- Composer
- Um servidor de banco de dados (MySQL, PostgreSQL, SQLite, etc.)

### Instalação

1. Clone este repositório para o seu ambiente de desenvolvimento:

   ```bash
   git clone https://github.com/Pedrovictorrr/Filament-Projeto-Base.git
   ```

2. Navegue até o diretório do projeto:

   ```bash
   cd Filament-Projeto-Base
   ```

3. Instale as dependências do PHP com o Composer:

   ```bash
   composer install
   ```

4. Copie o arquivo de configuração `.env.example` e renomeie para `.env`:

   ```bash
   cp .env.example .env
   ```

5. Gere uma nova chave de aplicativo:

   ```bash
   php artisan key:generate
   ```

6. Configure as informações do banco de dados no arquivo `.env`:

   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nome_do_banco_de_dados
   DB_USERNAME=seu_usuario
   DB_PASSWORD=sua_senha
   ```

7. Execute as migrações do banco de dados para criar as tabelas necessárias:

   ```bash
   php artisan migrate
   ```

8. Inicie o servidor de desenvolvimento:

    ```bash
    php artisan serve
    ```

    O projeto estará disponível em `http://localhost:8000`.

   
## Funcionalidades

### Log de Atividade

O log de atividade registra todas as ações realizadas no sistema, permitindo que os administradores monitorem as atividades dos usuários. Isso proporciona uma visão detalhada das interações dos usuários com o sistema, incluindo login, logout, criação, atualização e exclusão de recursos, entre outras ações. Essa funcionalidade é essencial para o monitoramento e auditoria do sistema, ajudando a identificar e investigar atividades suspeitas ou não autorizadas.

### Log de Exceções

O log de exceções registra todos os erros e exceções que ocorrem no sistema. Isso é crucial para identificar e corrigir problemas rapidamente, pois fornece informações detalhadas sobre as circunstâncias em que ocorreram as falhas. Com esses registros, os desenvolvedores podem rastrear a origem dos erros, entender melhor os problemas e implementar soluções eficazes. Além disso, o log de exceções ajuda a manter a estabilidade e confiabilidade do sistema, garantindo uma experiência consistente para os usuários.

### Funções e Permissões

O sistema inclui um sistema de roles e permissões para controlar o acesso dos usuários a determinadas partes do sistema. Isso permite definir diferentes níveis de acesso com base nas responsabilidades e privilégios de cada usuário. As roles definem conjuntos predefinidos de permissões, enquanto as permissões determinam quais ações específicas um usuário pode realizar em determinados recursos. Com esse sistema, os administradores podem garantir que apenas usuários autorizados tenham acesso a funcionalidades específicas, protegendo assim a integridade e segurança do sistema.

### CRUD de Usuários

O CRUD de usuários permite a gestão completa dos usuários do sistema, incluindo a criação, leitura, atualização e exclusão de usuários. Isso proporciona aos administradores uma interface intuitiva para gerenciar a base de usuários do sistema, adicionando novos usuários, atualizando suas informações e desativando contas conforme necessário. Além disso, o CRUD de usuários simplifica a administração do sistema, permitindo que os administradores respondam rapidamente a mudanças na equipe e mantenham os perfis de usuário atualizados e precisos.

### Área para Cadastrar Releases

A área de cadastro de releases permite que os administradores do sistema gerenciem as versões do sistema e registrem as novidades de cada versão. Isso facilita a comunicação das atualizações e melhorias do sistema para os usuários, mantendo-os informados sobre as últimas mudanças. Os administradores podem registrar detalhes sobre cada release, como notas de lançamento, correções de bugs, melhorias de desempenho e novas funcionalidades, garantindo uma transição suave para os usuários e uma experiência aprimorada com o sistema.


## Contribuição

Se deseja contribuir com este projeto, por favor siga estas etapas:

1. Faça um fork do repositório
2. Crie uma nova branch (`git checkout -b feature/nova-feature`)
3. Faça o commit das suas mudanças (`git commit -am 'Adiciona nova feature'`)
4. Faça o push para a branch (`git push origin feature/nova-feature`)
5. Abra um pull request

## Licença

Este projeto é licenciado sob a [Licença MIT](LICENSE).

## Contato

Se tiver alguma dúvida ou sugestão, entre em contato através do email: pedro.fabreu97@gmail.com

---



| ![image](https://github.com/Pedrovictorrr/Filament-Projeto-Base/assets/82172897/a0db7e15-00e1-40f3-8a22-e0542e48a96d) | ![image](https://github.com/Pedrovictorrr/Filament-Projeto-Base/assets/82172897/f652ed2c-a9cc-477a-ad79-76ba7816c377) | ![image](https://github.com/Pedrovictorrr/Filament-Projeto-Base/assets/82172897/3510557e-404c-4d65-84f8-0ecea1e50497) |
| --- | --- | --- |
| ![image](https://github.com/Pedrovictorrr/Filament-Projeto-Base/assets/82172897/000d1ac1-9505-4242-9d10-16ecb97f1bdd) | ![image](https://github.com/Pedrovictorrr/Filament-Projeto-Base/assets/82172897/8ae5a942-4804-4c63-a184-aa7b4c4d6c2c) | ![image](https://github.com/Pedrovictorrr/Filament-Projeto-Base/assets/82172897/a32ecb00-c36a-42f2-a28d-ba516cd36c7c) |
| ![image](https://github.com/Pedrovictorrr/Filament-Projeto-Base/assets/82172897/5d09c8a6-99f7-43a2-93ab-c4d6b5dd7859) | ![image](https://github.com/Pedrovictorrr/Filament-Projeto-Base/assets/82172897/5294de53-875e-47fa-9e30-31a94d1a7181) | ![image](https://github.com/Pedrovictorrr/Filament-Projeto-Base/assets/82172897/12513f53-2aa8-4fa8-9558-d0372c95fece) |
