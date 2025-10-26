---
title: Running Your First Program · MagiScript
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Running Your First Program · MagiScript

In this section, we’ll guide you through the process of running your very first MagiScript program.

## Steps

- Open the MagiScript editor and connect your Atom. Follow the Editor Basics guide if you need more details.

- Once connected, you can write your first script in the editor provided.

- And let’s start with a very basic program. Copy and paste the code below into the editor. You can use the the tiny copy button appears at the top right corner of the box to copy the code. If you don’t want to copy, click on the App Store button, and select loading the “Blinky (Simple)” mini-app.

- Press the Upload button (or if you are in the editor, Ctrl-S on Windows or Cmd-S on Mac) to compile and save the program to Atom.

- This code will start blinking the LED.

- Congratulations! You have just run your first MagiScript program.

```javascript
function main() {
atom.led('rgb*');
}
```

What is this code about? We have declared a function called `main`, this function will be called once your app starts (when the upload is complete). Then there’s an `atom.led` call with the parameter of an `rgb*` pattern. It will turn on the RGB led and set it to red, green, and blue for 50-50 ms, and repeat the pattern from the beginning.

## Loading Example Code to the Editor

You can try examples by either clicking on the [App Store](https://electricks.info/docs/magiscript/app-store/) in the Editor or by checking any of the examples in the sidebar on this page.

## Persisting Mini-Apps

Once you finished developing a mini-app, you can “persist” it. It means that your mini-app will be saved to Atom’s storage , and can be launched as any other mini-apps. To do this, just upload your code, and click on the Persist button. The persisted Atom mini-app can be assigned to a button and launched like built-in mini-apps (see [Settings](https://electricks.info/docs/magiscript/editor-settings/)).

To manage (list, run, delete) persisted mini-apps , look for the “Archive” icon next to the Persist button. Click on it, and you will see the list of the available mini-apps. You can delete mini-apps you don’t need anymore.

If you’ve configured a mini-app to automatically launch when you turn on Atom, and it’s causing issues, you can prevent it from starting by holding down the bottom-right button while powering on Atom.run

## What's Next?

Now that you’ve successfully run a program, you’re ready to start exploring the capabilities of MagiScript. In the following sections, we’ll show you how to create your own mini-apps using MagiScript by examples and cover more advanced topics like variables, data types, and functions.

If you encounter any issues while running your MagiScript program, we are ready to help in the [MagiScript Facebook Group](https://www.facebook.com/groups/magiscript). Happy coding!