## API documentation

1. /api/register  POST request

Request body
{
    "name": "Test",
    "email": "test@test.com",
    "password": "password"
}

Response

Status 422 if validation error
{
    "errors": {
        "name": [
            "The name field is required."
        ],
        "email": [
            "The email field is required."
        ],
        "password": [
            "The password field is required."
        ]
    }
}

Status 500 other error
{
    "message": "Undefined variable example",
    "success": false
}

Status 201 if all good
{
    "message": "User create successfully",
    "data": {
        "name": "test 2",
        "email": "test@test4.com",
        "updated_at": "2023-09-21T18:05:34.000000Z",
        "created_at": "2023-09-21T18:05:34.000000Z",
        "id": 2,
        "api_token": "4|3Ff1ltr4u6FGNHFhZbgdbUyIo6AseEGuvL80P4A91efb4d03"
    },
    "success": true
}
 

2. /api/login  POST request

Request body
{
    "email": "test@test.com",
    "password": "password"
}

Response

Status 422 if validation error
{
    "errors": {
        "name": [
            "The name field is required."
        ],
        "email": [
            "The email field is required."
        ],
        "password": [
            "The password field is required."
        ]
    }
}

Status 500 other error
{
    "message": "Undefined variable example",
    "success": false
}

Status 200 if all good
{
    "message": "User create successfully",
    "data": {
        "name": "test 2",
        "email": "test@test4.com",
        "updated_at": "2023-09-21T18:05:34.000000Z",
        "created_at": "2023-09-21T18:05:34.000000Z",
        "id": 2,
        "api_token": "4|3Ff1ltr4u6FGNHFhZbgdbUyIo6AseEGuvL80P4A91efb4d03"
    },
    "success": true
}

3. /api/requests  GET Request

Filter options  example  /api/requests?offset=10&limit=50&date=asc&status=Resolved
default value offset = 0
                limit = 20;
                date="desc"
                status=null
Response

Status 500 other error
{
    "message": "Undefined variable example",
    "success": false
}


Status 200 if all good
{
    "message": "Successfully",
    "data": [
        {
            "id": 4,
            "name": "Test",
            "email": "test@test.com",
            "status": "Resolved",
            "message": "test 2",
            "comment": "test 2",
            "user_id": 1,
            "responsible_id": 1,
            "created_time": "21-09-2023 17:15",
            "updated_time": "21-09-2023 17:54"
        },
        .......
    ],
    "success": true
}

4. /api/requests POST request
if user authenticated
    send with header  "Authorization": "Bearer "+api_token
Request body

if user authenticated

{
    "message": "test ticket",
    "name": "test", //no required
    "email": "test@test.com"  //no required
}
if user not authenticated

{
    "message": "test ticket",
    "name": "test",
    "email": "test@test.com"
}

Response 

Status 422 if no valid
{
    "errors": {
        "message": [
            "The message field is required."
        ]
    }
}


Status 500 other error
{
    "message": "Undefined variable example",
    "success": false
}


Status 201 if ok

{
    "message": "Ticket successfully created",
    "data": {
        "email": "test@test7.com",
        "message": "test 2",
        "name": "test",
        "user_id": 1,
        "id": 5,
        "created_time": "21-09-2023 18:18",
        "updated_time": "21-09-2023 18:18"
    },
    "success": true
}


5. /api/requests/{id}   --this id ticket id  PUT request must be authenticated
send with header  "Authorization": "Bearer "+api_token

Request body

if you want send email answer for client
{
    "status": "Active",
    "email_comment": "Ticket close"
}

if you want close ticket
{
    "status": "Resolved",
    "comment": "Ticket close"
}

Response 

Status 422 if no valid
{
    "errors": {
        "status": [
            "The status field is required."
        ]
    }
}

Status 500 other error
{
    "message": "Undefined variable example",
    "success": false
}

Status 200 i fok
{
    "message": "Ticket successfully updated",
    "data": {
        "id": 6,
        "name": "test",
        "email": "test@test7.com",
        "status": "Resolved",
        "message": "test 2",
        "comment": "test123",
        "user_id": 1,
        "responsible_id": 1,
        "created_time": "21-09-2023 18:19",
        "updated_time": "21-09-2023 18:24"
    },
    "success": true
}


5. /api/requests/{id}   --this id ticket id  Delete request must be authenticated
send with header  "Authorization": "Bearer "+api_token

Response

Status 403 if user not responsible for this ticket

{
    "message": "User not have delete permission for this ticket",
    "success": false
}

Status 500 other error
{
    "message": "Undefined variable example",
    "success": false
}

Status 200 if ok

{
    "message": "Ticket successfully deleted",
    "data": {
        "id": 4,
        "name": "Test",
        "email": "admin@test.com",
        "status": "Resolved",
        "message": "test 2",
        "comment": "test 2",
        "user_id": 1,
        "responsible_id": 1,
        "created_time": "21-09-2023 17:15",
        "updated_time": "21-09-2023 17:54"
    },
    "success": true
}