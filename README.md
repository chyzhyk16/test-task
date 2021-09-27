# test-task
Приклади запитів для users:
- GET /users - return all users;
- GET /users/1 - return user with id 1;
- POST /users 
json_body:
```
{
	"name": "Vlad",
	"email": "vlad@gmail.com",
	"birth_date": "2021-09-12",
	"sex": 1
}
```
create a user
- PUT /users 
json_body:
```
{
  "id": 1,
	"name": "Vlad"
}
```
update user 1;
- DELETE /users/1 - delete user with id 1;
