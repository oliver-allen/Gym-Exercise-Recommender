# Gym-Exercise-Recommender
An exercise web app that provides gym exercise recommendations using an “AI” based on previous selections.

After or during a workout, exercises can be updated to reflect which exercises were performed during the session. New exercises can also be added at any time. An exercise consists of several attributes:
- primary bodypart
- secondary bodypart
- equipment used,
- if it is bilateral,
- when it was last done.

Theses attributes are then used to add a score for each exercises based on how highly the system recommended it.

## Set-up
The easiers way to run the application is using an application such as MAMP (for Mac). MAMP creates an Apache server, MYSQL database and a phpMyAdmin account, and allows the PHP code to be run. The connection to the database should connect using the default details.

## Use
- index page provides a log-in and sign-up page.
- home page shows all of the exercises, their attributes and score, in order of recommendation levels. Add / update exercise and logout buttons are available from this page.
- add exercise page allows a new exercise to be added with the appropriate attributes.
- update exercise page shows all of the execises and allows them to be searched and ticked if they have been performed.

## Important Notes!
1. The database connection file is not totally unaccessable from the front-end. This file could be a layer above so that it is out of scope from the other code.
2. The usernames and passwords are stores in plain text. Encryption will need to be added to make it more secure.
