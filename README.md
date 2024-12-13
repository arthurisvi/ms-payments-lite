
# ms-payments-lite

Serviço que simula uma plataforma de pagamentos simplificada. Sua principal função é possibilitar a realização de transferência de dinheiro entre usuários.

---

## Índice
- [Tecnologias](#tecnologias)
- [Configuração Inicial](#configuração-inicial)
- [Arquitetura da Aplicação](#arquitetura-da-aplicação)
- [Estrutura do Projeto](#estrutura-do-projeto)
- [Melhorias Futuras](#melhorias-futuras)
---

## Tecnologias
 - PHP 8.3
 - Swoole 5.0
 - HyperF 
 - MySQL 8
 - Redis

## Configuração inicial

### Pré-requisitos
- Docker e docker-compose

#### Passo 1: Crie o .env

```bash
cp .env.example .env
```

#### Passo 2: Acesse o diretório .devcontainer

```bash
cd .devcontainer
```

#### Passo 3: Build dos containers com Docker Compose

```bash
docker-compose build
```

#### Passo 4: Subindo todos os serviços com Docker Compose

```bash
docker-compose up -d
```
#### Passo 5: Acesse o container e execute o comando para criação do banco de dados

```bash
docker-compose exec ms-payments-lite php bin/hyperf.php migrate
```

#### Passo 6: Verifique a aplicação rodando em ```http://localhost:9501```
---

## Arquitetura da Aplicação

### 1. Arquitetura modular

A **arquitetura modular** é um paradigma de design de software que divide um sistema complexo em componentes menores, independentes e coesos, conhecidos como módulos. Cada módulo encapsula uma funcionalidade específica e interage com outros módulos através de interfaces bem definidas.

Os principais benefícios da arquitetura modular incluem:

- **Facilidade de manutenção:** Ao isolar funcionalidades em módulos distintos, as alterações em uma parte do sistema tendem a ter um impacto menor em outras áreas, facilitando a correção de bugs e a implementação de novas funcionalidades.
- **Reusabilidade:** Módulos bem projetados podem ser reutilizados em diferentes projetos, reduzindo o tempo de desenvolvimento e aumentando a qualidade do software.
- **Escalabilidade:** A arquitetura modular permite que o sistema seja escalado de forma mais eficiente, adicionando ou removendo módulos conforme necessário.
Compreensão do sistema: Ao dividir o sistema em partes menores, a compreensão do código se torna mais fácil, facilitando a colaboração entre desenvolvedores.
- **Teste:** A modularidade facilita a criação de testes unitários, pois cada módulo pode ser testado isoladamente.

### 2. Event Bus


### 3. Design Patterns


### 4. Componentes do Software

---

## Estrutura do Projeto

### Camadas e Pastas

1. **modules/**
   Contém os diferentes domínios da aplicação, cada um com sua própria organização, podendo ou não ter subdiretórios. A ideia é que cada módulo seja um contexto independente que expõe apenas uma porta de entrada (contratos bem definidos) para o restante dos módulos:
   - **Repository/**: Contém as classes responsáveis por acessar e persistir dados em um banco de dados. Por sua vez, nesse diretório existe uma ocorrência da Interface e uma implementação concreta.
   - **Service/**: Contém as classes que tratam da lógica de negócio da aplicação, encapsulando as regras de negócio e orquestrando dados. No contexto dessa aplicação modular são as classes expostas (API) para comunicação entre módulos.
   - **Exception/**: Contém as classes de exceção personalizadas da aplicação.
   - **Event/**: Contém as classes que representam os objetos de eventos do sistema.
   - **DTOs/**: Contém as classes de Data Transfer Object (DTO), utilizadas para transferir e representar dados entre camadas da aplicação.
   - **Model/**: Contém as classes que representam um espelho da tabela do banco de dados. Este componente está fortemente acoplado ao banco relacional, através do EloquentORM.
   - **Http/**: Contém as camadas responsáveis por lidar com requisições HTTP.
     - **Controller/**: Contém as classes de controladores da API REST.
     - **Request/**: Contém as classes de validação de requisições da API REST.

2. **app/**
   Esta camada possui alguns componentes padrões que são compartilhados entre a aplicação (ex: AbstractController, Model, ExceptionHandler).

3. **config/**
   Engloba os arquivos de configurações que estão amarrados ao framework, bem como drivers de banco de dados, middlewares, container DI, loggers, etc

5. **test/**
   Contém pastas relacionadas a testes:
   - **Unit/**: Esta pasta abriga testes unitários, onde se verifica o funcionamento isolado de um método, desconsiderando comportamentos externos.
   - **Integration/**: Esta pasta abriga testes de integração, onde se verifica a interação entre diferentes componentes do sistema.
  
---

## Melhorias Futuras
