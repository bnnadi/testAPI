# testAPI

The live version of this is located at [here](http://165.227.214.31/)

## Route
The response object will look like this:
```
{
    success: Boolean,
    data:   Array
    messages: Array
}
```
### POST /v1/user/create
This POST is expecting ``signed_request`` to be sent over in the body.

### GET /v1/user
### GET /v1/user/:user_id
### GET /v1/user/total

### POST /v1/score/:user_id/create
This POST is expecting ``user_score``to be sent over in the body.
### GET /v1/score
### GET /v1/score/:score_id
### GET /v1/score/topPlayers
### GET /v1/score/todayScore
### GET /v1/score/topImporved