---
title: Virtual Cube Predicted
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "11a9eac"
---

# Virtual Cube Predicted

## About the Routine

The spectator opens the blog page (cubing.rocks/your-username) on their phone, and you talk about some cube facts you’ve read there. Then you show a virtual cube on your phone, which can be mixed with finger swipes. You give it to the spectator, who can mix the cube on the screen. When they are ready, you ask them to scroll down the webpage on their phone to the 3rd article, and look at the photo: it shows the same pattern that they’ve just mixed on the screen!

## Method

For this routine you don’t need an actual bluetooth cube, you can perform this  anytime, anywhere ad-hoc .

Select “ Virtual cube predicted ” as the routine, and set the timer at “ Wait after mixing ” to either 3sec (when practicing) or to 10-15sec (when performing). There is no need to select a secret screen type, this routine will always use the virtual cube screen. You should also set your username/PIN beforehand under “PREDICTION SETTINGS” – see the page “ [Setting up the prediction](https://cubesmith.info/setting-up-the-prediction) “. When all set, you can start the routine.

After starting the routine, you will see a  fully solved virtual cube  on the screen. You can show the spectator how you can mix the cube using finger swipes on the screen: just  swipe the side you want to turn  in the desired direction. You can also  flip the cube up/down  by swiping one finger up/down over the blank space  under  the virtual cube.

Now tell the spectator about a blog page that has articles about the Rubik’s cube.  Open the webpage on their phone , the address is

cubing.rocks/your-username
(replacing the end with  your username  you have already set up in the app). Don’t tell them about the 3rd article yet…

Then ask the spactator to mix the onscreen virtual cube. With each turn (finger swipe) the timer resets, so you will have to  wait X seconds  after the mixing before the prediction  photo gets generated online . There will be no visual indicator of the timer nor a confirmation of the prediction successfully generated, so make sure you wait enough before you go to the blog page to check the prediction photo. You can ask the spectator to check out the  3rd article  on the fake blog page… and there will be a  photo of a cube  which has the same pattern as their shuffled cube.

## Using a Personalized Prediction Photo

I offer an option to use customized photos (where  you are holding the cube ) as blog images, but this will cost extra money. Retail price for a custom photo will be  $35 .

I’ll need a high resolution photo of you holding the cube, in a way that 3 sides are clearly visible, and the cube has no shadows and reflections on it. The default prediction photo will be then replaced by your custom photo, and  will change automatically  every time you perform the prediction routine.

Here are some  samples  for custom photos (click to open):

## Using the Photo on your Own Website

![](https://electricks.info/wp-content/uploads/2024/08/jeremypei-263x300.jpg)

You can display the prediction photo on your own website as well.

HTML code for embedding the image (format with css stlye as you like):

<img id=”prediction” src=”https://cubing.rocks/gallery/username.png” style=”max-width: 80%;” />

J avascript code for the automatic refresh:

<script> refresh_image(); setInterval(refresh_image, 5000); function refresh_image() { document.getElementById(“prediction”).src=”https://cubing.rocks/gallery/username.png?rnd=”+Math.random(); } </script>

Of course replace “username” with your own username in CubeSmith.

If you embed the image into your website, it should be automatically refreshed when the prediction gets generated… so you can open your website on the spectator’s phone even  BEFORE  they mixed the cube.