# Clube Regatto

## Visão geral

O **Clube Regatto** é uma aplicação web desenvolvida para gerenciar um programa de relacionamento e pontuação da **Regatto Ambientes Planejados**.  
A proposta do sistema é permitir que parceiros se cadastrem, sejam aprovados pela administração, acumulem pontos por movimentações registradas e realizem resgates de prêmios.

O projeto foi pensado para rodar de forma simples em hospedagem compartilhada, com foco em manutenção facilitada, fluxo administrativo claro e baixo custo operacional.

---

## Objetivo do projeto

O sistema atende principalmente aos seguintes fluxos:

- cadastro público de interessados em participar do clube;
- aprovação ou recusa de solicitações por um administrador;
- autenticação web de usuários aprovados;
- controle de pontos;
- cadastro e manutenção de prêmios;
- resgate de prêmios pelos usuários;
- histórico de movimentações;
- envio de e-mails transacionais;
- rotina anual para zerar a pontuação dos usuários.

---

## Tecnologias utilizadas

### Back-end
- **PHP**
- **Laravel**
- **Eloquent ORM**
- **Blade**

### Front-end
- **Blade**
- **Bootstrap**
- **HTML**
- **CSS**
- **JavaScript** (pontual, quando necessário para comportamento de interface)

### Banco de dados
- **MySQL**

### Infraestrutura / publicação
- **cPanel / hospedagem compartilhada**
- **Cron Jobs**
- **SMTP** para envio de e-mails

---

## Justificativa das escolhas técnicas

## 1. Laravel como framework principal

O Laravel foi escolhido porque oferece:

- estrutura pronta para rotas, controllers, models e migrations;
- sistema robusto de autenticação;
- facilidade para envio de e-mails;
- scheduler nativo para tarefas recorrentes;
- integração simples com banco MySQL;
- boa produtividade para aplicações administrativas e institucionais.

Essa escolha faz sentido para o projeto porque o sistema possui regras de negócio bem definidas, CRUD administrativo, autenticação e automações periódicas.

---

## 2. Blade em vez de SPA com React

Apesar de existir familiaridade com React, a escolha por **Laravel + Blade** foi tecnicamente mais adequada para este projeto porque:

- reduz complexidade de deploy;
- evita separar front-end e back-end em duas aplicações;
- simplifica autenticação baseada em sessão;
- funciona muito bem em hospedagem compartilhada;
- acelera o desenvolvimento de telas administrativas e formulários.

Como o sistema é majoritariamente orientado a formulários, listagens, validações e páginas administrativas, o Blade atende muito bem com menor custo de manutenção.

---

## 3. MySQL como banco de dados

O MySQL foi adotado por ser:

- amplamente suportado em hospedagens compartilhadas;
- simples de administrar pelo phpMyAdmin;
- compatível de forma nativa com o ecossistema Laravel;
- suficiente para o volume esperado do projeto.

Para este sistema, não havia necessidade de um banco com maior complexidade operacional como PostgreSQL.

---

## 4. Bootstrap no front-end

O Bootstrap foi utilizado para acelerar a construção da interface, principalmente em:

- formulários;
- accordions;
- responsividade;
- padronização visual;
- componentes administrativos.

Essa decisão reduz o tempo de implementação e facilita manutenção visual sem exigir uma stack de front-end separada.

---

## 5. Autenticação baseada em sessão

A autenticação foi pensada para ambiente web tradicional, com sessão e cookies, porque:

- o sistema é acessado via navegador;
- não há necessidade principal de API pública para app mobile;
- o fluxo com Blade combina naturalmente com autenticação por sessão;
- simplifica login, logout e proteção de rotas.

Isso torna o sistema mais simples do que uma arquitetura baseada em JWT ou SPA.

---

## 6. Controle de aprovação de usuários

Foi adotado um campo de aprovação no usuário para garantir que o acesso ao sistema só ocorra após análise administrativa.

### Motivo da decisão
Nem todo usuário que se cadastra deve acessar imediatamente a área restrita.  
Por isso, o sistema separa:

- cadastro inicial;
- análise administrativa;
- aprovação;
- acesso liberado somente após aprovação.

Essa decisão protege o fluxo de negócio e evita acessos indevidos.

---

## 7. Scheduler para zerar pontos anualmente

A regra de zerar os pontos em todo dia **1º de janeiro** foi pensada para ser executada via **Laravel Scheduler + Cron Job**.

### Por que essa abordagem?
Porque:

- centraliza a lógica no próprio Laravel;
- evita ações manuais repetitivas;
- torna o comportamento previsível;
- funciona bem em produção com cron configurado.

### Observação importante de deploy
Ao publicar o projeto, é necessário configurar o cron da hospedagem para rodar:

```bash
/usr/local/bin/php /home/SEU_USUARIO/SEU_PROJETO/artisan schedule:run >> /dev/null 2>&1
```

Sem isso, as rotinas agendadas não serão executadas.

---

## Arquitetura do projeto

A aplicação segue a arquitetura padrão MVC do Laravel:

- **Models**: representam entidades e regras de acesso ao banco;
- **Controllers**: centralizam fluxos e regras da aplicação;
- **Views (Blade)**: renderizam páginas HTML;
- **Routes**: definem entradas HTTP;
- **Migrations**: controlam a estrutura do banco;
- **Notifications / Mail**: envio de e-mails;
- **Scheduler / Commands**: tarefas automáticas.

---

## Principais entidades do sistema

## Usuários (`users`)
Armazena os participantes do clube e administradores.

Campos importantes:
- nome;
- e-mail;
- senha;
- telefone;
- role;
- pontos;
- rrt;
- aprovado;
- cpf_cnpj;
- profissao.

### Decisões relevantes
- o usuário só acessa o sistema se estiver aprovado;
- o campo `role` controla permissões administrativas;
- o campo `pontos` guarda o saldo atual;
- dados como `cpf_cnpj` e `profissao` enriquecem o cadastro do parceiro.

---

## Prêmios (`premios`)
Armazena os itens disponíveis para resgate.

Campos relevantes:
- nome;
- descrição;
- pontos necessários;
- status/ativo;
- imagem.

### Decisão técnica
Foi importante manter um indicador de ativo/inativo para permitir:
- ocultar prêmios indisponíveis;
- preservar histórico sem excluir registros;
- facilitar administração do catálogo.

---

## Resgates (`resgates`)
Registra cada resgate realizado por um usuário.

Campos importantes:
- usuário;
- prêmio;
- data/hora;
- pontos gastos;
- saldo antes;
- saldo depois.

### Justificativa
Esse histórico garante rastreabilidade do consumo de pontos e facilita auditoria.

---

## Movimentações de pontos (`movimentacoes_pontos`)
Registra alterações administrativas de pontuação.

Campos relevantes:
- usuário administrador;
- usuário do clube;
- pontos antes;
- pontos depois;
- data/hora;
- projeto;
- data da compra;
- nome do cliente.

### Justificativa
Essa tabela existe para auditoria.  
Em vez de depender apenas do saldo atual do usuário, o sistema mantém um histórico claro de quem alterou, quando alterou e por qual contexto de negócio.

---

## Regras de negócio principais

## 1. Cadastro público
O usuário pode preencher o formulário de afiliação no site.

### Comportamento esperado
- os dados são validados;
- o cadastro é criado com status pendente/não aprovado;
- o usuário aguarda análise administrativa;
- o sistema pode redirecionar para uma página pública de confirmação.

---

## 2. Aprovação administrativa
Um administrador avalia solicitações pendentes.

### Possibilidades
- aprovar como usuário comum;
- aprovar como administrador;
- recusar solicitação.

### Motivo
Esse fluxo permite controle total sobre quem entra no clube e com qual nível de acesso.

---

## 3. Login
Somente usuários aprovados conseguem entrar no sistema.

### Motivo da regra
Evita que um usuário recém-cadastrado acesse funcionalidades internas antes da validação do cadastro.

---

## 4. Gestão de prêmios
Administradores podem:
- cadastrar;
- editar;
- ativar;
- inativar prêmios.

### Vantagem da abordagem
Permite manutenção do catálogo sem apagar histórico.

---

## 5. Resgate de prêmios
Quando o usuário clica em resgatar:

- o sistema verifica se há saldo suficiente;
- registra o resgate;
- subtrai a pontuação;
- pode disparar e-mails de notificação;
- redireciona para uma confirmação de sucesso.

### Justificativa
Esse fluxo mantém integridade da pontuação e histórico confiável.

---

## 6. Histórico de movimentações
O usuário e/ou administrador podem consultar as movimentações de pontos.

### Benefício
Transparência do saldo e facilidade de conferência.

---

## 7. Reset anual dos pontos
Todo dia 1º de janeiro, os pontos devem ser zerados.

### Implementação recomendada
- criar um comando ou job no Laravel;
- agendar no `app/Console/Kernel.php` ou na abordagem de agendamento da versão usada;
- garantir cron ativo no servidor.

---

## Estrutura técnica esperada do projeto

Uma estrutura típica do projeto inclui:

```text
app/
  Http/
    Controllers/
  Models/
  Notifications/

resources/
  views/

routes/
  web.php

database/
  migrations/

public/
```

---

## Decisões importantes de manutenção

## 1. Uso de migrations
As migrations foram adotadas para:

- versionar a estrutura do banco;
- facilitar criação e alteração de tabelas;
- permitir replicação do ambiente;
- reduzir erros manuais no banco.

---

## 2. Uso de Eloquent
O Eloquent foi escolhido para:

- simplificar relacionamentos;
- deixar o código mais legível;
- facilitar manutenção de consultas comuns;
- integrar naturalmente com validações e controllers.

---

## 3. Separação entre área pública e área autenticada
Essa divisão melhora:

- segurança;
- organização das rotas;
- clareza do fluxo do usuário;
- manutenção do sistema.

---

## 4. E-mails transacionais
O sistema prevê envio de e-mails para eventos como:

- aprovação;
- recusa;
- redefinição de senha;
- notificações de resgate.

### Motivo
Melhora comunicação com o usuário e reduz necessidade de contato manual.

### Observação técnica
Em produção, é fundamental configurar corretamente:
- host SMTP;
- porta;
- criptografia;
- usuário;
- senha;
- remetente.

---

## Segurança e boas práticas aplicadas

- proteção de rotas autenticadas;
- uso de validação de campos;
- uso de hash de senha;
- separação de permissões por role;
- controle de aprovação de usuário;
- uso de `.env` para dados sensíveis;
- uso de migrations em vez de alterações manuais dispersas.

---

## Variáveis de ambiente esperadas

Exemplo simplificado do que normalmente precisa existir no `.env`:

```env
APP_NAME="Clube Regatto"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-dominio.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seu_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha

MAIL_MAILER=smtp
MAIL_HOST=seu_host_smtp
MAIL_PORT=587
MAIL_USERNAME=seu_email
MAIL_PASSWORD=sua_senha
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu_email
MAIL_FROM_NAME="${APP_NAME}"
```

---

## Estratégia de deploy

O projeto foi pensado para uma publicação simples em hospedagem compartilhada.

### Pontos importantes
- apontar o domínio/subdomínio para a pasta pública correta;
- ajustar `.env` para produção;
- rodar migrations;
- configurar permissões de escrita;
- validar SMTP;
- configurar cron do Laravel Scheduler.

---

## Vantagens da solução escolhida

- simples de publicar;
- simples de manter;
- custo baixo;
- boa produtividade no desenvolvimento;
- aderente ao tipo de sistema;
- não exige front-end desacoplado;
- boa compatibilidade com hospedagem compartilhada.

---

## Limitações assumidas pela arquitetura

- menor separação entre front-end e back-end do que em uma SPA/API;
- experiência mais tradicional de navegação;
- dependência de configuração correta do servidor para scheduler e e-mail.

Ainda assim, para o objetivo do projeto, essas limitações são aceitáveis e compensadas pela simplicidade operacional.

---

## Próximas melhorias possíveis

- dashboard administrativo com métricas;
- fila para e-mails;
- logs administrativos mais detalhados;
- exportação de relatórios;
- testes automatizados;
- política de permissões mais granular;
- API futura para integrações;
- painel mais robusto de histórico de resgates e movimentações.

---

## Conclusão

O **Clube Regatto** foi estruturado com foco em:

- praticidade;
- manutenção simples;
- aderência ao negócio;
- boa compatibilidade com hospedagem compartilhada;
- controle administrativo claro;
- rastreabilidade das operações.

As escolhas técnicas feitas privilegiam uma solução realista, escalável dentro do contexto do projeto e suficientemente robusta para o fluxo atual do clube.

---

# Como subir este projeto no GitHub

## 1. Entre na pasta do projeto
```bash
cd caminho/do/projeto
```

## 2. Inicialize o Git
```bash
git init
```

## 3. Configure seu usuário, se necessário
```bash
git config user.name "Seu Nome"
git config user.email "seuemail@exemplo.com"
```

## 4. Crie um `.gitignore`
Se ainda não existir, use um `.gitignore` adequado para Laravel.  
Itens essenciais:

```gitignore
/vendor
/node_modules
/.env
/public/storage
/storage/*.key
```

## 5. Adicione os arquivos
```bash
git add .
```

## 6. Faça o primeiro commit
```bash
git commit -m "Initial commit - projeto Clube Regatto"
```

## 7. Crie um repositório no GitHub
No GitHub:
- clique em **New repository**;
- escolha o nome do repositório;
- não marque para criar README, `.gitignore` ou licença se o projeto já estiver localmente preparado;
- crie o repositório.

## 8. Conecte o repositório local ao remoto
Substitua pela URL do seu repositório:

```bash
git remote add origin https://github.com/SEU_USUARIO/SEU_REPOSITORIO.git
```

## 9. Defina a branch principal
```bash
git branch -M main
```

## 10. Envie para o GitHub
```bash
git push -u origin main
```

---

## Fluxo de atualização depois do primeiro envio

Sempre que alterar o projeto:

```bash
git add .
git commit -m "Descreva a alteração"
git push
```

---

## Cuidados antes de publicar no GitHub

Nunca envie:
- `.env`;
- senhas;
- credenciais SMTP;
- chaves de API;
- arquivos sensíveis de produção;
- dados privados de banco.

Antes de subir, revise especialmente:
- `.gitignore`;
- arquivos de configuração;
- credenciais fixas no código;
- URLs internas;
- dumps de banco e backups.

---

## Sugestão de organização do repositório

Você pode deixar no repositório:

- código-fonte;
- migrations;
- README;
- instruções de instalação;
- prints da aplicação em uma pasta `docs/` ou `public/docs/`.

---

## Comandos úteis de conferência

Ver status:
```bash
git status
```

Ver remotos:
```bash
git remote -v
```

Ver histórico:
```bash
git log --oneline
```

---

## Observação final importante

Como este projeto usa Laravel e possui rotina agendada para zerar pontos, lembrar de documentar no GitHub e também no deploy que a configuração do **cron do scheduler** é obrigatória em produção.
