1. index.php is our first page where we have given carousel for all our tags and it continuously slides and represents types of project that we have in our system. We have provided links for login , signup , aboutus, explore projects based on tags.

2. login.php takes username and password as input and validate with database entry and makes user logged in to the system and sets the session variable.

3. sign_up_page.php makes new user to signup . It takes all the required fields such as username, first name, last name, email, password, ccn and checks validations and makes entry in the user table.

4. aboutus.php shows information regarding creators of this website.

5. search.php gives details of projects such as project name, no of likes, owner of project with link to view detailed description of project on Projects.php.
It shows only those projects which matches the keyword that has been passed. If nothing being passed as keyword then it will show all the projects available in database.

6. explore.php allows user to search projects based on tags. This page shows all the tags present in database with no of projects present for each tag. clicking on any tag it will redirect to search.php where all projects will be retrieved matching the selected tag.

7. first_page.php is users customized personal page which displays projects based on users interests, users previous activities, projects that user has been liked or funded, and trending projects which is being fetched based on no of likes project has been received. Clicking on any project it will redirect to Projects.php page.

8. Projects.php shows entire information about particular project such as project name, description, owner, status, pledge status, no of likes received, media related to project if completed project  then it will also show average rating received . Also it allows the user to like, comment and pledge for that project. On clicking on project media of image type the image will be available in new window and for audio or video types it will redirect to Play_media.php

9. Play_media.php plays audio or video passed from Projects.php page in new window.

10. new_proj.php allows user to create new project. it takes all the necessary inputs such as project name, description, completion dates , cover pic etc. and validate for correctness and insert into projects table of database.

11. my_projects.php  allows user to view projects created by him and if the project status in pending or execution state allows user to add new media , if project is in execution state and user needs to change it to complete then it allows the user to do so.

12. manage_payment.php allows user to add or delete credit card number and makes appropriate update in credit_card table of database.

13. update_profile.php allows user to add or change address and interests of user.

14. Pledge.php accepts amount user want to pledge and checks maximum fund reached condition and based on that makes entry in Pledge table in database.

15. Users.php page shows all the details of particular user such as username, first name, last name, address, interests, followers, people that user is being following and projects created by that particular user. For followers and following links are being provided so that logged in user can view profile of them as well.

16. logout.php destroys the session making user logged out.

 