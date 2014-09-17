Title: Orthorectifying ElectronMicroscope data in reference to a thin section image

index.html
	This is the main page of the application and it simply manages the various states of the application. So, throughout the application the user never really leaves index.php, the page just reloads with a different state (states are marked with the POST variable, 'state'.) Since a lot of the states share some of the same code and html, like functions and styles, this central location was an easy way to maintain this code. If for example, we want to change the title of the application from 'Georeferencing Images' to 'Relating Images Spatially', we only have to edit index.php instead of every php file that displays a title. Also, this central location makes it easy to move states around and to add or remove states. There is each state corresponding to each file so that one can be able to know in which state the user is currently working on.

getBase.php
	State #1. It explains the application to the user and asks the user to submit a base image of low resolution that the user will eventually place sub images of higher resolution on top of.

saveBase.php
	State #2. It saves the base image to disk, but also stores session data and initializes some session variables.

getSub.php
	State #3. This state follows state 2 immediately without user interaction. It simply asks the user to submit a high resolution image to place on top of the base image. The reason that this is a distinct state, and not just part of saveBase.php, is because the user may want to return here again and add more sub images.

saveSub.php
	State #4. It stores the sub image to disk and updates session variables. It then moves on immediately to state 5 without user interaction.

collectPoints.php
	State #5. This is the main state of the application. Here, the user defines control points based on the features that are provided that is zoom in and zoom out, on the sub and base images in order to relate them together spatially. This page uses mostly JavaScript and jQuery to do this. Once the user is finished defining points, the control points/values are passed on to the next page.

displayResults.php
	As the control points are collected, the scale to which the sub image is calculated. Based upon these caluclations, the subimage is placed onto the base image using OpenLayers.Layer.Image constructor. Based upon the bounds of the subimage the image is placed. And if the user is not satisfied with the result, the user can return back to the previous state which is collecting the points. There are sveral options too which the user can start from the begining. or the user can add several subimages to the existing base image. In addition to this the user can avail the option to download the current overlaid images and also the option to download all the other files of the related base image.


temp.html
	This is the file where the user has the same file as of displayResults.php page and this page can be downloaded and can display it on the users website.

dimg.html
	This is the file where the user can download the all the overliad images of a particular base image and its related sub images as a file and then display it on the users website.

archive.tar
	This is the file where the user will download files readme, temp.html and the images, and the user can display it on their website.

archiveall.tar
	This is the file where the user will download files readme, dimg.html and the images, and the user can display it on their website.
