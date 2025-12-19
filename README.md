# Especificação Técnica: Sistema de Autenticação Laravel

## 📋 Informações do Projeto

| Campo | Informação |
|-------|-----------|
| **Data** | 17 de dezembro de 2025 |
| **Versão** | 1.0 |
| **Status** | Ativo |
| **Contexto** | Teste prático de desenvolvimento backend com Laravel 12 |

---

## 🎯 Visão Geral

### Objetivo

Desenvolver uma aplicação web de autenticação de usuários completa e segura, permitindo:

- ✅ Cadastro (registro) com validação robusta de dados
- ✅ Autenticação via email e senha com segurança
- ✅ Dashboard para usuários autenticados
- ✅ Edição de perfil com validações
- ✅ Logout seguro

### Escopo do Projeto

| Aspecto | Descrição |
|--------|-----------|
| **Incluído** | Sistema completo de autenticação com CRUD básico de usuários |
| **Não Incluído** | Sistema de recuperação de senha
| **Entrega** | Repositório GitHub + README.md executável |

---

## 💻 Stack Tecnológico

### Requisitos Obrigatórios

| Componente | Versão | Justificativa |
|---|---|---|
| **Linguagem** | PHP 8.2+ | Requisito obrigatório |
| **Framework** | Laravel 12 | Versão mais recente compatível com PHP 8.2 |
| **Autenticação** | Laravel Breeze | Scaffolding oficial do Laravel |
| **Frontend** | Blade Templates | Template engine nativo do Laravel |
| **Styling** | Bootstrap 5+ | Framework CSS responsivo |
| **JavaScript** | Vanilla JS | Interações frontend leves |
| **Database** | MySQL 8.0+ | Conforme ambiente disponível |
| **Validação** | Laravel Request Validation | Validações do framework |
| **Hash de Senha** | bcrypt | Padrão do Laravel |
| **Testing** | PHPUnit | Testes automatizados |
| **Ambiente** | Docker & Docker Compose | Build baseado em Serviços |
| **Pipeline** | Github Actions | BUild automático e Testes Automatizados | Pode ser acessados na aba Actions do Github

---

## 🔐 Requisitos Funcionais

### 1️⃣ Setup Inicial - Configuração do Projeto

#### Procedimento de Instalação

**É necessário ter o docker e docker-compose instalados no host** 
 
 - ✅ O projeto contém na raiz um arquivo chamdo **docker-compose.yml** que provisiona container de aplicação e de banco de dados dados Mysql. 

 - ✅ O projeto utiliza de um arquivo **app.Dockerfile** na raiz do projeto que provisiona instalação do PHP em container utilizando a imagem php:8.2-apache


```bash

#Buildar o ambiente
docker-compose up -d --build

 #Instalar Breeze
docker-compose exec app composer require laravel/breeze --dev

# Executar instalação (escolha blade, react ou vue)
docker-compose exec app php artisan breeze:install blade

# Instalar dependências NPM
docker-compose exec app npm install

# Rodar migrations
docker-compose exec app php artisan migrate

# Compilar assets
docker-compose exec app npm run dev

```

**Uma outra alternativa de instalação é a utilização de comandos dentro do container, siga as instruções:**

```bash

#Buildar o ambiente
docker-compose up -d --build

#Acesso ao container
docker exec -it app bash

 #Instalar Breeze
composer require laravel/breeze --dev

# Executar instalação (escolha blade, react ou vue)
php artisan breeze:install blade

# Instalar dependências NPM
npm install

# Rodar migrations
php artisan migrate

# Compilar assets
npm run dev

```

#### Saída Esperada

- O ambiente Deverá Rodar na URI http://localhost:8000
- Projeto estruturado com pastas: `app/`, `routes/`, `resources/`, `database/`
- Arquivo `.env.example` com configurações padrão
- Tabela `users` criada com campos: `id`, `name`, `email`, `password`, `email_verified_at`, `timestamps`

**OBS:**
```
Para configuração correta do .env é necessário verificar as credenciais de banco de dados do docker-compose.yml e configurá-las no arquivo .env
```

---

### 2️⃣ Registro de Usuário

#### Interface de Registro
- **Rota:** `GET /register` (página)

**Elementos da Tela:**

| Campo | Tipo | Validação |
|-------|------|-----------|
| name | Input text | Obrigatório, 3-255 caracteres |
| email | Input email | Obrigatório, único no banco |
| password | Input password | Obrigatório, mínimo 8 caracteres, forte, ao menos uma letra maiúscula, letra minúscula, número e caractere especial |
| password_confirmation | Input password | Deve corresponder com `password` |

**Botões:**
- ✓ "Registrar" (type submit)
- ℹ️ Link para login (se já tiver conta)

#### Validações Servidor

```php
[
    'name' => 'required|string|min:3|max:255',
    'email' => 'required|string|email|lowercase|unique:users',
    'password' => 'required|string|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)/',
]
```

#### Regras de Senha Forte

- ✅ Mínimo 8 caracteres
- ✅ Contém letra minúscula
- ✅ Contém letra maiúscula
- ✅ Contém número

#### Processamento de Registro
- **Rota:** `POST /register`
- **Controller:** `RegisteredUserController@store`

**Ações:**

1. Validar entrada (rejeitando com mensagens amigáveis se inválido)
2. Criar novo usuário com senha hasheada via bcrypt
3. Autenticar usuário automaticamente após registro
4. Redirecionar para `/dashboard`

**Tratamento de Erros:**

| Erro | Mensagem |
|------|----------|
| Email duplicado | "Este email já está cadastrado" |
| Senha fraca | "Senha deve conter maiúscula, minúscula e número" |
| Validação falha | Exibir erros específicos no formulário |

---

### 3️⃣ Login e Autenticação

#### Interface de Login
- **Rota:** `GET /login` (página)

**Elementos da Tela:**

| Campo | Tipo | Validação |
|-------|------|-----------|
| email | Input email | Obrigatório |
| password | Input password | Obrigatório |
| remember_me | Checkbox | Opcional |

**Botões:**
- ✓ "Entrar" (type submit)
- ℹ️ Link para registro (se não tiver conta)

#### Processamento de Login
- **Rota:** `POST /login`
- **Controller:** `AuthenticatedSessionController@store`

**Validações:**
```php
[
    'email' => 'required|string|email',
    'password' => 'required|string',
]
```

#### Fluxo de Autenticação

```
┌─────────────────────────────────┐
│  Validar entrada               │
└──────────────┬──────────────────┘
               │
        ┌──────▼──────┐
        │ Tentar auth │
        └──────┬───┬──┘
               │   │
         ✓Sucesso  ✗Falha
           │         │
           ├─────┬───┘
           │     │
        Regen  Retornar
        sessão  erro
           │     │
        Dash   Login
        board  page
```

**Segurança:**
- ✅ Não diferenciar entre "email não existe" ou "senha errada" (previne enumeração)
- ✅ Rate limiting: máximo 5 tentativas por minuto por IP

---

### 4️⃣ Dashboard/Home

- **Rota:** `GET /dashboard` (autenticada)
- **Middleware:** `auth`

**Elementos:**

- 👋 Saudação: "Bem-vindo, [Nome do Usuário]"
- 📋 Card com informações básicas do usuário:
  - Nome
  - Email
  - Data de cadastro
  - Avatar/Imagem de perfil (se implementado)
- 🔗 Botão "Editar Perfil" (link para `/profile`)
- 🚪 Botão "Logout"

**Layout:** Limpo com Bootstrap

**Comportamento:**
- ✓ Usuário não autenticado é redirecionado para `/login`
- ✓ Página é protegida por middleware `auth`

---

### 5️⃣ Logout

- **Rota:** `POST /logout` (POST para segurança)
- **Controller:** `AuthenticatedSessionController@destroy`

**Ações:**

1. Destruir sessão do usuário
2. Invalidar token CSRF associado
3. Redirecionar para página inicial ou `/login`
4. Exibir mensagem: "Logout realizado com sucesso"

---

### 6️⃣ Edição de Perfil

#### Interface de Edição
- **Rota:** `GET /profile` ou `GET /profile/edit` (autenticada)
- **Middleware:** `auth`

**Elementos da Tela:**

| Campo | Tipo | Validação |
|-------|------|-----------|
| name | Input text | Editável, obrigatório |
| email | Input email | Editável, obrigatório |
| password | Input password | Vazio, opcional |
| password_confirmation | Input password | Vazio, opcional |

**Indicadores Visuais:**
- ⭐ Campos obrigatórios marcados com asterisco
- 💡 Dica sob campo de senha: "Deixe em branco para manter a senha atual"
- ✨ Feedback visual de sucesso/erro após envio

**Botões:**
- ✓ "Salvar Alterações"
- ↩️ "Cancelar" (voltar ao dashboard)

#### Processamento de Edição
- **Rota:** `PUT /profile`
- **Controller:** `ProfileController@update`

**Validações:**
```php
[
    'name' => 'required|string|min:3|max:255',
    'email' => 'required|string|email|unique:users,email,' . Auth::id(),
    'password' => 'nullable|string|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)/',
]
```

**Regras Específicas:**

| Regra | Descrição |
|-------|-----------|
| **Email único** | Permitir email atual do usuário, rejeitar outros duplicados |
| **Senha opcional** | Se vazio, manter senha atual |
| **Senha forçada** | Se preenchido, deve atender critérios de força |
| **Confirmação** | Obrigatória se senha for fornecida |

**Lógica de Atualização:**

1. Validar entrada
2. Se email foi alterado:
   - Verificar se não é duplicado
   - Atualizar email
3. Se password foi fornecido:
   - Hash com bcrypt
   - Atualizar senha
4. Atualizar nome
5. Salvar no banco
6. Redirecionar com mensagem: "Perfil atualizado com sucesso"

**Tratamento de Erros:**

| Erro | Mensagem |
|------|----------|
| Email já existe | "Este email já está associado a outra conta" |
| Senha fraca | "Senha deve conter maiúscula, minúscula e número" |
| Validação falha | Exibir erros específicos no formulário |

---

## 🔒 Requisitos Não-Funcionais

### Segurança

#### Proteção CSRF
- ✅ Todos os formulários devem incluir token CSRF
- ✅ Implementar middleware CSRF do Laravel (padrão)
- ✅ Validar token em todas as requisições POST/PUT

#### Autenticação
- ✅ Usar `Auth::check()` para verificar autenticação
- ✅ Aplicar middleware `auth` em rotas protegidas
- ✅ Hash de senha: bcrypt (padrão do Laravel)
- ✅ Regenerar session ID após login

#### Autorização
- ✅ Usuários só podem editar seu próprio perfil
- ✅ Implementar verificação: `$user->id === Auth::id()`
- ✅ Retornar 403 Forbidden se usuário tentar acessar perfil de outro

#### Rate Limiting
- ✅ Limitar tentativas de login: 5 por minuto por IP
- ✅ Implementar via middleware do Laravel

#### Proteção de Dados
- ✅ Senhas nunca armazenadas em plain text
- ✅ Não exibir senhas em respostas de API
- ✅ Usar HTTPS em produção

### Performance

#### Consultas ao Banco
- ✅ Usar eager loading com `with()` quando aplicável
- ✅ Evitar N+1 queries
- ✅ Indexar campos: `email` (único), `id` (primária)

#### Cache
- ✅ Cache de configurações de autenticação (opcional)
- ✅ Session storage eficiente

### Acessibilidade

#### Labels e Formulários
- ✅ Associar `<label>` com `<input>` via atributo `for`
- ✅ Usar atributo `aria-label` para campos sem label visível

#### Contraste e Legibilidade
- ✅ Contraste de cores conforme WCAG 2.1 AA
- ✅ Fontes legíveis (tamanho mínimo 14px)

---

## ⭐ Diferenciais (Bônus)

- ✅ Containirização de Ambiente com Docker

- ✅ Pipeline de CI com Github Actions / Os Builds podem ser visualizados acessando a aba Actions no github


## ⭐ Rotas Implementadas

```php

Route::get('/', [DashboardController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('index');


Route::get('/dashboard', [DashboardController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.upload_avatar');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
```


### Upload de Imagem de Perfil (Avatar)

#### Funcionalidade Completa
- **Rota:** `POST /profile/avatar` (autenticada)

**Validações:**
```php
[
    'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:10000',
]
```

**Regras:**
- ✅ Formatos aceitos: JPEG, PNG, JPG, GIF
- ✅ Tamanho máximo: 10MB
- ✅ Armazenar em `storage/app/public/avatars/`

**Lógica:**

1. Validar arquivo de imagem
2. Deletar avatar anterior se existir
3. Armazenar novo arquivo com nome único (hash)
4. Salvar caminho no banco de dados
5. Exibir imagem no dashboard

**Segurança:**
- ✅ Validar tipo MIME (não confiar apenas na extensão)
- ✅ Gerar nome único com hash (evitar sobrescrita)
- ✅ Deletar arquivo antigo ao substituir
- ✅ Servir arquivo através de rota segura

---

## 🧪 Testes Automatizados

### Framework Recomendado: PHPUNIT

#### Teste de Registro

```bash
#Teste completo de feature
docker exec laravel_app php artisan test tests/Feature/Auth/

#Teste de Update de Password
docker exec laravel_app php artisan test tests/Feature/Auth/PasswordUpdateTest.php

#Teste de Autenticação
docker exec laravel_app php artisan test tests/Feature/Auth/AuthenticationTest.php

#Testes de Registro de Usuário
docker exec laravel_app php artisan test tests/Feature/Auth/RegistrationTest.php.php

```


## 📂 Estrutura de Diretórios

```
case-dp-test/
pp
├── Http
│   ├── Controllers
│   └── Requests
├── Models
├── Providers
├── Services
│   └── Contracts
└── View
    └── Components
bootstrap
└── cache
config
database
├── factories
├── migrations
└── seeders
    └── init.sql
public
└── build
    └── assets
resources
├── css
├── js
└── views
    ├── auth
    ├── components
    ├── layouts
    └── profile
routes
storage
├── app
│   ├── private
│   └── public
├── framework
│   ├── cache
│   ├── sessions
│   ├── testing
│   └── views
└── logs
tests
├── Feature
│   └── Auth
└── Unit

```

---

## 🛣️ Mapa de Rotas

| Método | Rota | Autenticação | Controlador | Ação |
|--------|------|--------------|-------------|------|
| GET | `/register` | Visitante | RegisteredUserController | create |
| POST | `/register` | Visitante | RegisteredUserController | store |
| GET | `/login` | Visitante | AuthenticatedSessionController | create |
| POST | `/login` | Visitante | AuthenticatedSessionController | store |
| POST | `/logout` | Autenticado | AuthenticatedSessionController | destroy |
| GET | `/dashboard` | Autenticado | DashboardController | show |
| GET | `/profile/edit` | Autenticado | ProfileController | edit |
| PUT | `/profile` | Autenticado | ProfileController | update |
| POST | `/profile/avatar` | Autenticado | ProfileController | uploadAvatar |

---


---

## 🎓 Conclusão

Este projeto é uma excelente oportunidade para praticar:

- ✨ Padrões de desenvolvimento backend moderno
- 🔒 Implementação segura de autenticação
- 🏗️ Arquitetura limpa e mantenível
- 🧪 Testes automatizados de qualidade
- 📖 Documentação técnica profissional

**Boa sorte! 🚀**

---

**Especificação Técnica Case Teste Deep**  
*Atualizado em 17 de dezembro de 2025*
