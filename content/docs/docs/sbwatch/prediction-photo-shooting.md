---
title: Prediction Photo Shooting
updated: "2024-11-29"
author: Electricks
category: guides
sidebar: "945e687"
---

# Prediction Photo Shooting

## How Does It Work?

 
 
 
 
 You can use custo prediction photos on the fake blog site or on your own website. For this you will have to shoot **720 photos** (which will cover all hour/minute variations), starting **from 1:00** all the way **to 12:59**. TimeSmith has a feature which enables you to **shoot these photos automatically**. The app will set the time on your watch, take a photo, upload it to the webserver, then skip one minute and start over.

 
 
 
 
 ## Preparations

 
 
 
 
 You will need to **connect your watch** in TimeSmith, and you also have to own the **FULL version** of the app for the automatic photo shooting function to work. You also need to have a **username and PIN**. In case you haven’t done that before, go to USER SETTINGS and tap the empty field for the username (and read the instructions for registering the username and PIN). And of course you will need to have the **URL for the processing PHP code** – please see the next chapters for getting the URL.

 
 
 
 
 ## Shooting The Photos

 
 
 
 
 Go to **PREDICTION SETTINGS**, scroll down to “Shoot custom photos” and open the panel. Enter (or paste) the **URL for the processing PHP code**. Put the phone to a **camera tripod**, frame the watch in the camera preview and set the ZOOM if necessary. For shooting all 720 photos, the default values for the **starting and ending time** (“from” and “to”) will be OK. If you need to shoot photos for a custom timeframe (in case you want to re-shoot some photos), set the “from” and “to” values (hour and minutes) accordingly. When all is set, hit the **START** button. The app will set the first time on your watch (1:00 by default), take a photo, upload it to the webserver, then skip one minute and start over.

In case the next **time is NOT set** on the watch, it means that the photo shooting or uploading was not successful. Check if the URL is correct, and if you have access to the webserver, check the uploaded files. If you have a question or a problem, please **contact me** on Messenger ([Benke Smith](https://m.me/benke.smith)).

You can **STOP** the process at any time, and if you don’t change the “from” and “to” values, you can **resume shooting** with the **START** button. If your phone has an OLED or AMOLED screen, you should tap **HIDE** to make the screen go black, this will prevent the screen from “burning”. Tap the black screen to turn it on again.

When all the photos are ready and uploaded and the watch hands are staying still, the **phone will vibrate** (and if the Audio Assistant is enabled, it will say “Photo shooting ready.”) and a **pop-up message** will be displayed. If the screen is turned OFF (after pressing HIDE), you have to tap the screen to see the popup message. If you don’t need to re-shoot some of the photos, you can tap “**Close**” and the panel will be closed.

In case you need to re-shoot some of the photos, enter the new “from” and “to” values (hour and minutes), then start the shooting again.

 
 
 
 
 
 
 
 
 
 
 ## Saving The Photos to Your Webserver

 
 
 
 
 If you have access to a webserver, you can do the automatic photo shooting for **FREE**.

On the AUTOMATIC PHOTO page you’ll have to **enter the direct URL** for your processing **PHP code**. The PHP code should be like this (feel free to change it if you know how to code in PHP), save it as “**photo_upload.php**” on your server: [click here to view the PHP code](https://bsmagic.app/api/automatic_photo_process.txt)

Before you start shooting the photos, **create a folder** called “**uploads**” at the same location where your processing PHP file is located. This is the folder where your uploaded photos will be stored.

 
 
 
 
 ## Using The Custom Photos for The Prediction

 
 
 
 
 After all the 720 photos are taken and uploaded (either to your or my webserver), here is how you can use them for the prediction routine: