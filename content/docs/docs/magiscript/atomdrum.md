---
title: Atom Drum
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Atom Drum

## Just for Fun

 
 
 
 
 AtomDrum is a fun project but demonstrates several features of Atom in one project, like how you can connect to PeekSmith and SB Watch, and how you can work with buttons.

After uploading this code to Atom, it will connect to your PeekSmith and SB Watch.

It will print “Atom Drum” on PeekSmith, announce that Atom Drum is ready (your browser will speak on your machine), and sets the SB Watch to 12:00.

Then, on button press events coming from PeekSmith, SB Watch (the crown button), or Atom (the top three buttons), it will play a drum sound.

 
 
 
 
 
 
 
 function main() {
 ps.connect();
 sbwatch.connect();

 voice.say("Atom drum is ready.");
 sbwatch.setTime("12:00");
}

function onButtonPress(source, buttonId) {
 console.log(source, buttonId);
 if (buttonId === 0) {
 sound.play("tom1");
 }
 if (buttonId === 1) {
 sound.play("tom2");
 }
 if (buttonId === 2) {
 sound.play("tom3");
 }
}

function onEvent(e) {
 if (e.source === "ps:ble" && e.type === "connected") {
 ps.print("Atom\nDrum");
 return;
 }
 if (e.type === "press") {
 onButtonPress(e.source, parseInt(e.value));
 }
}

 
 
 
 
 
 
 
 ## Tips and Tricks

 
 
 
 
 The main function will run when you upload the code.

You should not write code outside functions, except for the variable declaration.

Connection to PeekSmith and SB Watch will happen in the background, so it may take a few seconds while Atom connects – that said, once connected, it will ignore connection requests.

 
 
 
 
 ## Challenges

 
 
 
 
 Modify the code to print the buttonId (0-11) to PeekSmith’s screen when you press the button.

Add setting the hour on SB Watch to the button pressed. You should use the sbwatch.setTime(12, 0); call, but replace 12 with the hour you would like to set.