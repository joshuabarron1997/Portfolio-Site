AN ATTEMPT AT FILE CONTEXT~

images folder --- contains images uploaded via addRecipe.php (may be absent due to being empty locally)

Emailer.php --- php email class. Used in contact.php

addRecipes.php --- self-posting php form. Connected to recipes database. In the future will update aswell via GET variables.

adminPanel.php --- a landing page for when you successfully log in via login.php. Calls php pages for manipulating the recipe database

contact.php --- simple self-posting contact form

deleteRecipe.php --- deletes item from recipe database matching passed GET variable

getSession.php --- simple page that assertains a valid session for dynamic content on .html sites

imageLoader.php --- php file used to upload images to server

index.html --- landing page. Uses ajax to populate selection elements. navigation dynamic via getSession.php

login.php --- simple login form. Validates post with database users. Sends to adminPanel on success.

logoff.php --- simple php page. unsets and destroys a session.

master.js --- bulk javascript for index.html

recipe.class.php --- used for packaging recipes into objects to be encode to json and uploaded to database.

selectRecipe.php --- dumps all content of recipe table from the database. If it is passed a GET, it will select a single row.
