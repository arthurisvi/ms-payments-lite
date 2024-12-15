# API Documentation

## Endpoint

**POST** `/transfer`

---

## Request

### Headers

| Key           | Value            |
|---------------|------------------|
| Content-Type  | application/json |

### Body

```json
{
  "value": 20,
  "payer": "5a93e640-5d8b-11eb-9bf2-0242ac130002",
  "payee": "9b9c43a0-5d8b-11eb-9bf2-0242ac130003"
}
```

| Field  | Type    | Description                      |
|--------|---------|----------------------------------|
| value  | Number  | Amount to be transferred.        |
| payer  | String  | UUID of the user making payment. |
| payee  | String  | UUID of the user receiving funds.|

---

## Responses

### Success

**Status Code**: `201 Created`

**Body**:

```json
{
  "data": {
    "id": "efe791b6-2e5f-4709-ba81-2327682e2181"
  }
}
```

| Field | Type   | Description                    |
|-------|--------|--------------------------------|
| id    | String | UUID of the completed transfer.|

---

### Error

**Status Code**: `40x`

**Body**:

```json
{
  "error": {
    "code": 2,
    "message": "Transação não autorizada pelo serviço autorizador."
  }
}
```

| Field   | Type   | Description                             |
|---------|--------|-----------------------------------------|
| code    | Number | Error code representing the issue.      |
| message | String | Description of the error encountered.   |

---

## Example Usage

### Request

```bash
curl -X POST \
  http://your-api-domain.com/transfer \
  -H 'Content-Type: application/json' \
  -d '{
    "value": 20,
    "payer": "5a93e640-5d8b-11eb-9bf2-0242ac130002",
    "payee": "9b9c43a0-5d8b-11eb-9bf2-0242ac130003"
  }'
```

### Successful Response

```json
{
  "data": {
    "id": "efe791b6-2e5f-4709-ba81-2327682e2181"
  }
}
```

### Error Response

```json
{
  "error": {
    "code": 2,
    "message": "Transação não autorizada pelo serviço autorizador."
  }
}
```