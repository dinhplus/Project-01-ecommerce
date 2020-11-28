# Introduce

    This is my MVC model framework ver 2. In this ver, I have develops the router, so developer can route conveniently


# How it work?
    * The Server will run on only a single file has name "server.php"
    * The file "request.php" will complete duty of resolving the URL

    * the Router will process the request, call special Controller or do some action directly
    * A particular controller will work with a particular model and return data for a particular view via the render function
# Install & Run
    1. Clone or Download this project from this repo
    2. Create table template (mySQL) use "migrate.sql" at "./Config/migrate.sql"
    3. Run command line (terminal) script " php -S {host}:{port} {ROOT_directory}"
        * exam: ROOT_directory = "WEBROOT"
        * notice: 80 is default of {port}, XAMPP or skype will run on it
    4. url example: http://127.0.0.1:8080/posts
# Isue


# Document:
    Read document.md to learn how to use it.
