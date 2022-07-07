## Context

This challenge was propossed by [Alquiler Argentina](https://jobs.alquilerargentina.com) as a business case to enter the technology development team. My role was to give an inside-company test, to give feedback for future business cases, to receive feedback and continue to develop my skills as a back-end developer and to enjoy the weekend with an always welcomed interesting pokemon related programming task haha  

Please do not hesitate and check the following links to know more about this type of challenges: (link will be here when available, sorry!)   

## About This Challenge

With a given endpoint to connect to a pokemon database and a chart with the tables relationships, the main task was to build a restful api on laravel with two must have methods, three documented methods (with endpoint, params and response), and a lot (or some, or none, it's up to you) of fun, interesting, mindblowing and creative methods fully invented by you (in my case just some boring ones, pretty fun to do though!).  

#  Methods to Do

Method: GET Pokemon  
Params: name (ej: "pikachu")  
Response:  
```json
{
    "pok_id": 1,
    "name": "Pikachu",
    "height": 4,
    " weight ": 60,
    "base_experience": 112,
    "type": "elctryc"
}
```

Method: Get Pokemons By Type  
Params: type (ej: "elctryc")  
Response:   
```json
[
    {
    "id": 25,
    "name": "Pikachu",
    "height": 4,
    "weight": 60,
    "base_experience": 112,
    "type": "elctryc"
    },
    {
    "pok_id": 26,
    "name": "Raichu",
    "height": 8,
    "weight": 300,
    "base_experience": 218,
    "type": "elctryc"
    }
    . . .
]
```
# Methods to Document

Description given: add a pokemon to a particular team  
Method: POST  
Endpoint: api/teams/{idTeam}/pokemons/{idPokemon}  
Params:  
    idTeam: id of the particular team in wich the pokemon will be added  
    idPokemon: id of the pokemon that will be added to the particular team  
Optional Query Params:  
    moves: array of the moves the pokemon will have  
        each one must be in the availables moves list of that particular pokemon. If null given, moves will be automatically selected from the availables moves list.  
    abilities: array of the abilities the pokemon will have  
        each one must be in the availables abilities list of that particular pokemon. If null given, abilities will be automatically selected from the availables abilities list.  
    stats: associative array that contains the stats the pokemon will have  
        The base stats will be overwrite with the value of the key that matches that base state name (if found). New values must be greater or equal to base stats values  
    name: personalized alias of the pokemon  
        If null given, the original pokemon name will be used with a numeric index appended based on the number of pokemons with that alias on the team  
Response (status code 201):   
```json
{
    id:447
    name: riolu
    height: 7
    weight: 202
    base_experience: 5
    type: fighting
    abilities: [inner-focus, steadfast]
    moves: [low-kick, sky-uppercut, swords-dance, thunder-punch]
    stats: [
        hp: 45,
        atk: 72,
        def: 50,
        sp_atk: 35,
        sp_def: 40,
        speed: 60
    ],
    id_team: 3
}
```

Description given: Delete a pokemon from a particular team  
Method: DELETE  
Endpoint: api/teams/{idTeam}/pokemons/{aliasPokemon}  
Params:   
    aliasPokemon: the pokemon's alias previosly saved  
Response: status code 204  
 
Description given: Edit a pokemon of a particular team  
Method: PUT  
Endpoint: api/teams/{idTeam}/pokemons/{aliasPokemon}  
Params:   
    aliasPokemon: the pokemon's alias previously saved  
Optional Query Params: The query params are identical to the add method  
Response: The response is identical to the previous add method, except it has status code TODO  


# Aditional Methods

Aditional methods will not be as documented as the previous one's.   

Query params where added to the get pokemon method to retrieve pokemons by type, habitat, particular move that must be in their availables moves list and particular ability that must be in their availables abilities list.  

Methods to see the moves, abilities, evolutions, base form of a pokemon and its base stats were added  
Endpoints (all GET methods):  
api/pokemons/{id}/moves  
api/pokemons/{id}/abilities  
api/pokemons/{id}/evolutions  
api/pokemons/{id}/base  
api/pokemons/{id}/stats  
