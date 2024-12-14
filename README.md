
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

### (Extra) Testes automatizados

#### 1. Testes de integração
Para realizar os testes de integração é necessário que você crie uma database específica para isso. Acesse a conexão do BD e execute o seguinte comando para criar uma nova database:
```sql
CREATE DATABASE `payments-database-test` CHARACTER SET utf8 COLLATE utf8_general_ci;
```
#### 2. Testes unitários
Para os testes unitários não é necessário realizar uma ação.

#### 3. Execução dos testes:
Para executar os testes, você pode acessar o container docker diretamente e executar ```composer test```, ou fora do container o seguinte comando:
```bash
docker-compose exec ms-payments-lite composer test
```
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
É um padrão de arquitetura que permite que diferentes componentes de um sistema se comuniquem de forma desacoplada, através de eventos. Esse padrão é útil em sistemas que precisam de comunicação assíncrona entre diversos módulos ou serviços sem que os módulos precisem saber diretamente uns dos outros

### 3. Design Patterns
**3.1. Repository Pattern:**  padrão de design utilizado para abstrair o acesso a dados, fornecendo uma interface para realizar operações de leitura e gravação sem expor detalhes de implementação (como consultas SQL).

**3.2. Strategy Pattern:** padrão comportamental que permite selecionar uma ação (ou algoritmo) em tempo de execução, delegando o comportamento para diferentes classes que implementam uma interface comum.

**3.3. Factory Pattern:** padrão de criação de objetos que fornece uma interface para criar objetos, mas permite que as subclasses decidam qual classe instanciar.

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
   - **Strategy/**: Contém as classes referentes ao padrão de projeto Strategy.
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
1. [Lock pessimista](https://medium.com/@abhirup.acharya009/managing-concurrent-access-optimistic-locking-vs-pessimistic-locking-0f6a64294db7) no fluxo de transação
2. [Filas assíncronas](https://www.hyperf.wiki/3.1/#/en/async-queue?id=async-queue) para o envio de Notificações
   - [Retry Pattern com Backoff exponencial](https://docs.aws.amazon.com/prescriptive-guidance/latest/cloud-design-patterns/retry-backoff.html)
   - [DLQ](https://aws.amazon.com/pt/what-is/dead-letter-queue/)
4. [Cache](https://www.hyperf.wiki/3.1/#/en/cache?id=cache) na obtenção de dados
5. Uso de [corrotinas](https://www.hyperf.wiki/3.1/#/en/coroutine?id=coroutine)
