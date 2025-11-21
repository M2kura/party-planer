# Party Planner API Documentation

API reference.

## Table of Contents

- [Base URL](#base-url)
- [Authentication](#authentication)
- [Endpoints](#endpoints)
  - [Parties](#parties)
  - [Guests](#guests)
  - [Items](#items)
  - [User](#user)
- [Data Models](#data-models)
- [Error Handling](#error-handling)
- [Examples](#examples)
- [Swagger/OpenAPI](#swaggeropenapi)
- [Postman Collection](#postman-collection)

## Base URL

```
http://localhost:8000/api
```

All endpoints are prefixed with `/api`.

## Authentication

Only `/user` endpoint requires authentication. Use Laravel Sanctum bearer token:

```
Authorization: Bearer {token}
```

All other endpoints are public.

## Endpoints

### Parties

#### List All Parties

**GET** `/parties`

Returns all parties with guests and items.

**Response:** `200 OK`
```json
[
  {
    "id": 1,
    "host_id": 1,
    "name": "New Year's Eve Party",
    "description": "Celebrating the new year",
    "party_date": "2025-12-31T20:00:00.000000Z",
    "location": "123 Main St, City",
    "created_at": "2025-11-05T12:23:31.000000Z",
    "updated_at": "2025-11-05T12:23:31.000000Z",
    "guests": [
      {
        "id": 1,
        "user_id": 2,
        "party_id": 1,
        "status": "pending",
        "created_at": "2025-11-05T12:59:23.000000Z",
        "updated_at": "2025-11-05T12:59:23.000000Z"
      }
    ],
    "items": [
      {
        "id": 1,
        "party_id": 1,
        "name": "Pizza",
        "quantity": 2,
        "guest_id": null,
        "created_at": "2025-11-05T13:00:30.000000Z",
        "updated_at": "2025-11-05T13:00:30.000000Z"
      }
    ]
  }
]
```

#### Get Party by ID

**GET** `/parties/{id}`

Returns party with guests (including user details) and items.

**Parameters:**
- `id` (path): Party ID

**Response:** `200 OK`
```json
{
  "id": 1,
  "host_id": 1,
  "name": "New Year's Eve Party",
  "description": "Celebrating the new year",
  "party_date": "2025-12-31T20:00:00.000000Z",
  "location": "123 Main St, City",
  "created_at": "2025-11-05T12:23:31.000000Z",
  "updated_at": "2025-11-05T12:23:31.000000Z",
  "guests": [
    {
      "id": 1,
      "user_id": 2,
      "party_id": 1,
      "status": "pending",
      "created_at": "2025-11-05T12:59:23.000000Z",
      "updated_at": "2025-11-05T12:59:23.000000Z",
      "user": {
        "id": 2,
        "name": "Jane Doe",
        "email": "jane@example.com"
      }
    }
  ],
  "items": [
    {
      "id": 1,
      "party_id": 1,
      "name": "Pizza",
      "quantity": 2,
      "guest_id": null,
      "created_at": "2025-11-05T13:00:30.000000Z",
      "updated_at": "2025-11-05T13:00:30.000000Z"
    }
  ]
}
```

**Error:** `404 Not Found` - Party not found

#### Create Party

**POST** `/parties`

Creates a new party.

**Request Body:**
```json
{
  "name": "Birthday Party",
  "description": "John's 30th birthday celebration",
  "party_date": "2025-12-15T18:00:00",
  "location": "456 Oak Avenue, City",
  "host_id": 1
}
```

**Required:**
- `name` (string, max 255)
- `party_date` (datetime)
- `location` (string)
- `host_id` (integer)

**Optional:**
- `description` (string)

**Response:** `201 Created`
```json
{
  "id": 2,
  "host_id": 1,
  "name": "Birthday Party",
  "description": "John's 30th birthday celebration",
  "party_date": "2025-12-15T18:00:00.000000Z",
  "location": "456 Oak Avenue, City",
  "created_at": "2025-11-05T14:00:00.000000Z",
  "updated_at": "2025-11-05T14:00:00.000000Z"
}
```

**Error:** `422` - Validation error

#### Update Party

**PUT** `/parties/{id}`

Partial update - only provided fields are updated.

**Parameters:**
- `id` (path): Party ID

**Request Body:**
```json
{
  "name": "Updated Party Name",
  "location": "New Location"
}
```

**Optional:**
- `name` (string, max 255)
- `description` (string)
- `party_date` (datetime)
- `location` (string)
- `host_id` (integer)

**Response:** `200` - Returns updated party

**Errors:**
- `404` - Not found
- `422` - Validation error

#### Delete Party

**DELETE** `/parties/{id}`

Deletes party and associated guests/items.

**Parameters:**
- `id` (path): Party ID

**Response:** `200 OK`
```json
{
  "message": "Party deleted successfully"
}
```

**Error:** `404` - Not found

---

### Guests

#### List All Guests

**GET** `/guests`

Returns all guests with user and party info.

**Response:** `200 OK`
```json
[
  {
    "id": 1,
    "user_id": 2,
    "party_id": 1,
    "status": "pending",
    "created_at": "2025-11-05T12:59:23.000000Z",
    "updated_at": "2025-11-05T12:59:23.000000Z",
    "user": {
      "id": 2,
      "name": "Jane Doe",
      "email": "jane@example.com"
    },
    "party": {
      "id": 1,
      "name": "New Year's Eve Party",
      "party_date": "2025-12-31T20:00:00.000000Z"
    }
  }
]
```

#### Get Guest by ID

**GET** `/guests/{id}`

Returns guest with user and party details.

**Parameters:**
- `id` (path): Guest ID

**Response:** `200` - Guest object

**Error:** `404` - Not found

#### Create Guest Invitation

**POST** `/guests`

Creates invitation. Returns existing record if user already invited.

**Request Body:**
```json
{
  "user_id": 2,
  "party_id": 1,
  "status": "pending"
}
```

**Required:**
- `user_id` (integer)
- `party_id` (integer)

**Optional:**
- `status` (string, defaults to "pending")

**Response:** `201 Created`
```json
{
  "id": 1,
  "user_id": 2,
  "party_id": 1,
  "status": "pending",
  "created_at": "2025-11-05T12:59:23.000000Z",
  "updated_at": "2025-11-05T12:59:23.000000Z"
}
```

**Error:** `422` - Validation error

#### Update Guest RSVP

**PUT** `/guests/{id}`

Updates guest status only.

**Parameters:**
- `id` (path): Guest ID

**Request Body:**
```json
{
  "status": "confirmed"
}
```

**Required:**
- `status` (string)

**Response:** `200` - Updated guest

**Errors:**
- `404` - Not found
- `422` - Validation error

#### Remove Guest from Party

**DELETE** `/guests/{id}`

Removes guest from party.

**Parameters:**
- `id` (path): Guest ID

**Response:** `200 OK`
```json
{
  "message": "Guest removed from party"
}
```

**Error:** `404` - Not found

---

### Items

#### List All Items

**GET** `/items`

Returns all items with guest info.

**Response:** `200 OK`
```json
[
  {
    "id": 1,
    "party_id": 1,
    "name": "Pizza",
    "quantity": 2,
    "guest_id": null,
    "created_at": "2025-11-05T13:00:30.000000Z",
    "updated_at": "2025-11-05T13:00:30.000000Z",
    "guest": null
  },
  {
    "id": 2,
    "party_id": 1,
    "name": "Cake",
    "quantity": 1,
    "guest_id": 1,
    "created_at": "2025-11-05T13:01:00.000000Z",
    "updated_at": "2025-11-05T13:01:00.000000Z",
    "guest": {
      "id": 1,
      "user_id": 2,
      "party_id": 1,
      "status": "confirmed"
    }
  }
]
```

#### Get Item by ID

**GET** `/items/{id}`

Returns item with guest details.

**Parameters:**
- `id` (path): Item ID

**Response:** `200` - Item object

**Error:** `404` - Not found

#### Create Item

**POST** `/items`

Creates item. Optionally assign to guest via guest_id.

**Request Body:**
```json
{
  "party_id": 1,
  "name": "Cake",
  "quantity": 1,
  "guest_id": null
}
```

**Required:**
- `party_id` (integer)
- `name` (string, max 255)

**Optional:**
- `quantity` (integer, min 1, default 1)
- `guest_id` (integer)

**Response:** `201 Created`
```json
{
  "id": 2,
  "party_id": 1,
  "name": "Cake",
  "quantity": 1,
  "guest_id": null,
  "created_at": "2025-11-05T13:01:00.000000Z",
  "updated_at": "2025-11-05T13:01:00.000000Z"
}
```

**Error:** `422` - Validation error

#### Update Item

**PUT** `/items/{id}`

Set guest_id to claim, null to unclaim.

**Parameters:**
- `id` (path): Item ID

**Request Body:**
```json
{
  "name": "Chocolate Cake",
  "quantity": 2,
  "guest_id": 1
}
```

**Optional:**
- `name` (string, max 255)
- `quantity` (integer, min 1)
- `guest_id` (integer) - Set to claim, null to unclaim

**Response:** `200` - Updated item

**Errors:**
- `404` - Not found
- `422` - Validation error

#### Delete Item

**DELETE** `/items/{id}`

Deletes item.

**Parameters:**
- `id` (path): Item ID

**Response:** `200 OK`
```json
{
  "message": "Item deleted"
}
```

**Error:** `404` - Not found

---

### User

#### Get Current User

**GET** `/user`

Returns current user. Requires authentication.

**Headers:**
```
Authorization: Bearer {token}
```

**Response:** `200 OK`
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "email_verified_at": "2025-11-01T10:00:00.000000Z",
  "created_at": "2025-11-01T10:00:00.000000Z",
  "updated_at": "2025-11-01T10:00:00.000000Z"
}
```

**Error:** `401` - Unauthorized

---

## Data Models

### Party

```typescript
interface Party {
  id: number;
  host_id: number;
  name: string;
  description: string | null;
  party_date: string; // ISO 8601
  location: string;
  created_at: string; // ISO 8601
  updated_at: string; // ISO 8601
  guests?: Guest[];
  items?: Item[];
}
```

### Guest

```typescript
interface Guest {
  id: number;
  user_id: number;
  party_id: number;
  status: string; // "pending", "confirmed", "declined"
  created_at: string; // ISO 8601
  updated_at: string; // ISO 8601
  user?: User;
  party?: Party;
}
```

### Item

```typescript
interface Item {
  id: number;
  party_id: number;
  name: string;
  quantity: number;
  guest_id: number | null;
  created_at: string; // ISO 8601
  updated_at: string; // ISO 8601
  guest?: Guest | null;
}
```

### User

```typescript
interface User {
  id: number;
  name: string;
  email: string;
  email_verified_at: string | null; // ISO 8601
  created_at: string; // ISO 8601
  updated_at: string; // ISO 8601
}
```

## Error Handling

### 404 Not Found
```json
{ "message": "Resource not found" }
```

### 422 Validation Error
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "name": ["The name field is required."],
    "party_date": ["The party date must be a valid date."]
  }
}
```

### 401 Unauthorized
```json
{ "message": "Unauthenticated." }
```

## Examples

### Creating a Party Flow

1. **Create party:**
```javascript
const response = await fetch('http://localhost:8000/api/parties', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({
    name: 'Birthday Party',
    description: 'John\'s 30th birthday',
    party_date: '2025-12-15T18:00:00',
    location: '456 Oak Avenue',
    host_id: 1
  })
});
const party = await response.json();
```

2. **Invite guests:**
```javascript
const inviteGuest = async (userId, partyId) => {
  const response = await fetch('http://localhost:8000/api/guests', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      user_id: userId,
      party_id: partyId,
      status: 'pending'
    })
  });
  return await response.json();
};
```

3. **Add items:**
```javascript
const addItem = async (partyId, itemName, quantity = 1) => {
  const response = await fetch('http://localhost:8000/api/items', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      party_id: partyId,
      name: itemName,
      quantity: quantity
    })
  });
  return await response.json();
};
```

4. **Guest claims item:**
```javascript
const claimItem = async (itemId, guestId) => {
  const response = await fetch(`http://localhost:8000/api/items/${itemId}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      guest_id: guestId
    })
  });
  return await response.json();
};
```

5. **Update RSVP:**
```javascript
const updateRSVP = async (guestId, status) => {
  const response = await fetch(`http://localhost:8000/api/guests/${guestId}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      status: status // 'confirmed' or 'declined'
    })
  });
  return await response.json();
};
```

## Swagger/OpenAPI

OpenAPI 3.0 spec available in `openapi.yaml`:
- View in [Swagger Editor](https://editor.swagger.io/)
- Generate client code with [OpenAPI Generator](https://openapi-generator.tech/)
- Import into Postman/Insomnia

## Postman Collection

Collection available in `postman_collection.json`:
- Import into Postman
- Set `base_url` variable (default: `http://localhost:8000/api`)
- Set `auth_token` for authenticated endpoints

## Notes

- Dates: ISO 8601 format (`2025-12-31T20:00:00.000000Z`)
- Relationships: `GET /parties/{id}` includes guest user details
- Duplicates: Inviting same user twice returns existing guest record
- Item claiming: Set `guest_id` to claim, `null` to unclaim
- Partial updates: PUT only updates provided fields
- Validation errors: Check `errors` object for field-specific messages

