## Domínios
#### User
- Name
- DocumentId
- Email
- Password
- Type
- Wallet

#### Wallet
- Balance
- User

#### Transaction
- PayerId
- PayeeId
- Value

#### PaymentGateway


#### Notification


## Casos de uso
- Solicita a realização de uma transactionência
  - Verifica se o payerId é um usuário comum (não lojista)
    - Caso for Lojista, retorna erro
  - Verifica se o usuário tem saldo suficiente
    - Caso não tenha saldo, retorna erro
  - Verifica se serviço autorizador permite a transactionência
    - Caso não autorize, retorna erro
  - Dispara evento para efetuar transactionência
    - Cria o registro de transactionência
    - Adiciona saldo ao payee
    - Decrementa saldo do payer
  - Dispara evento para efetuar notificação de sucesso da transactionência -> o evento vai adicionar numa fila assíncrona
    - Verifica se o serviço de notificação está disponível
      - Caso não esteja disponível, mantém na fila
      - Caso esteja disponível, commita a mensagem

## Decisões de modelagem
- Armazenar as transactionências e também o saldo, mesmo que o saldo seja apenas um "extrato" das transactionências -> pensando em histórico e numa consulta mais direta
  - Melhorias: as transactionências (histórico) poderiam ser armazenadas em um banco não relacional
- Apesar de não especificado, pensando em um cenário real é possível que o usuário tenha mais de uma carteira

## Decisões de tecnologia
- Familiaridade do dev com linguagem PHP
  - HyperF
    - Economia de recursos computacionais
    - PHP Assíncrono -> maior performance
- Banco relacional (MySQL)
  - Controle de transações
  - Dados estruturados

## Decisões de design de software
- Arquitetura modular
  - Por que modular?
    - Dividir a aplicação em contextos (módulos) bem definidos -> desacoplamento
    - Próprio Hyperf utiliza um pouco de arquitetura modular para organização dos componentes
  - Por que não DDD?
    - Inexperiência em construção de aplicações PHP (HyperF/Laravel) utilizando DDD -> suscetível a overengineer
- Dependency Inversion
- Repository Pattern
  - Desafio: desacoplar o Eloquent -> solução: criar um classe Entity que não é Model do Eloquent + Mapper
- Strategy Pattern -> Notificações
  - Implica em que eu posso ter diferentes canais de notificação ao mesmo tempo
- Testes unitários -> regras de negócio
- Testes de integração -> mockery para externos
- Testes de contrato -> CI/CD
- Comunicação entre os módulos
  - Expor uma API/Contrato Interno -> Service
    - Só entrega o necessário e o Service que utiliza monta sua regra a partir disso, exemplo:
      - A regra de se o usuário está apto para uma transactionência é responsabilidade do módulo de Transaction, ele só recebe os dados (getBalance e getUserType)
  - Eventos -> Event Bus

## Decisões de arquitetura
- Async Queue
  - Retry no envio de notificações
    - Backoff exponencial
  - DLQ
    - Reprocessamento manual
  - Componente do HyperF - Escolhi não criar um client genérico pois o HyperF já me facilita trocar (Kafka, RabbitMQ, Redis)

### Proposta de melhorias
- Implementação de lock pessimista -> garantir que realmente o usuário tenha saldo, não é possível fazer duas transações simultaneamente
- Implementar um Factory para seleção dinâmica da estratégia de notificação -> para poder utilizar de acordo com o caso de uso ou prioridade por exemplo
- Não depender de reprocessamento manual das mensagens de notificação
  - Fallback para reprocessamento automatizada da DLQ -> reencaminhar para a fila principal
  - Configurar um worker para reprocessar mensagens da DLQ

## Outros
- CI/CD
  - Testes unitários
  - Testes de integração
  - Testes de contrato
  - Análise estática do código -> phpstan ou phpcs-fixer
- Observalidade
  - Logging de operações financeiras
  - Tracer de erros