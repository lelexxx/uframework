Test it

    You can test it with php server embed like with this command : php -S localhost:8080 -t /

How to use uframework ?

    UFramework is a simple framework wich work without database. In fact datas are store in a JSON file in the folder "/data".

JSON file

    In order to use uframework with JSON you have to respect this syntaxe in your JSON file :

{
    "articles": [
        {
            "id": "ID_ARTICLE", 
            "name": "NAME_ARTICLE", 
            "description": "DESCRIPTION_ARTICLE"
        }
    ]
}

Apps

	UFramework comes with a frontend application to viewing articles, and a backend application to manage content.

Tests

    The test part is not functional
