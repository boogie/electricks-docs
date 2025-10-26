---
title: Bluetooth Keyboard
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Bluetooth Keyboard

## About

MagiScript can turn a compatible device like the Atom into a Bluetooth keyboard. This enables the device to send keystrokes to a phone or computer that has been paired with it.

To use the keyboard and media support in MagiScript, you need to pair your device with the target phone or computer. Once the pairing process is complete, you can use the available functions to send keystrokes or media commands to the target device.

When Atom is paired with a phone, it automatically connects to Atom when turned on. You can still connect to Atom via Bluetooth from the same host device to develop mini-apps or use Atom. You can even pair another device, but this can start being unreliable. If you experience that you cannot connect to Atom again, or your device cannot pair with it, go to your Bluetooth settings to unpair Atom, and connect to it again.

## Keyboard Type

The `keyboard.type()` function allows you to type a string of characters on the target device. The function takes a string as its argument, and it types each character of the string sequentially. For example, if you want to type the string “Hello, world!”, you can use the following code:

```javascript
keyboard.type('Hello, world!'); // prints "Hello, world!"
```

You can use multiple values, and even numbers. Atom will add a space between them:

```javascript
keyboard.type('Hello', 'World'); // prints "Hello World"
keyboard.type('Temperature:', 42); // prints "Temperature: 42"
```

## Keyboard Tap

The `keyboard.tap()` function allows you to tap a specific key on the target device.

From firmware v2.3.1, we introduced a new, easy way to press keys or key combinations. This function takes a string or more as its arguments, representing the key or key combination you would like to press. Keys can be combined with Control, Shift, Alt, AltGr, Cmd and Win keys.

For example:

```javascript
keyboard.tap('return');
keyboard.tap('cmd-space');
keyboard.tap('Cmd+Space');
keyboard.tap('Ctrl-Alt-Del');
keyboard.tap('Ctrl-C', 'Ctrl-V');
```

You can use these modifiers, even combined:

- [kbd:ctrl] [kbd:control] [kbd:alt] [kbd:altgr] [kbd:option] [kbd:shift] [kbd:cmd] [kbd:command] [kbd:win] [kbd:windows]

And these keys:

- [kbd:enter] [kbd:return] [kbd:esc] [kbd:backspace] [kbd:bs] [kbd:tab] [kbd:space] [kbd:sp] [kbd:minus] [kbd:-] [kbd:equal] [kbd:=] [kbd:leftbrace] [kbd:(] [kbd:rightbrace] [kbd:)] [kbd:backslash] [kbd:\] [kbd:hashtilde] [kbd:tilde] [kbd:~] [kbd:semicolon] [kbd:;] [kbd:apostrophe] [kbd:'] [kbd:grave] [kbd:comma] [kbd:,] [kbd:dot] [kbd:.] [kbd:slash] [kbd:/] [kbd:capslock]

- [kbd:f1] [kbd:f2] [kbd:f3] [kbd:f4] [kbd:f5] [kbd:f6] [kbd:f7] [kbd:f8] [kbd:f9] [kbd:f10] [kbd:f11] [kbd:f12] [kbd:f13] [kbd:f14] [kbd:f15] [kbd:f16] [kbd:f17] [kbd:f18] [kbd:f19] [kbd:f20] [kbd:f21] [kbd:f22] [kbd:f23] [kbd:f24]

- [kbd:sysrq] [kbd:scrolllock] [kbd:pause] [kbd:insert] [kbd:home] [kbd:pageup] [kbd:delete] [kbd:del] [kbd:end] [kbd:pagedown] [kbd:right] [kbd:left] [kbd:down] [kbd:up] [kbd:numlock] [kbd:kpslash] [kbd:kpasterisk] [kbd:kpminus] [kbd:kpplus] [kbd:kpenter]

- [kbd:kp1] [kbd:kp2] [kbd:kp3] [kbd:kp4] [kbd:kp5] [kbd:kp6] [kbd:kp7] [kbd:kp8] [kbd:kp9] [kbd:kp0] [kbd:102nd] [kbd:compose] [kbd:power] [kbd:kpequal] [kbd:kpcomma] [kbd:kpleftparen] [kbd:kprightparen]

- [kbd:open] [kbd:help] [kbd:props] [kbd:front] [kbd:stop] [kbd:again] [kbd:undo] [kbd:cut] [kbd:copy] [kbd:paste] [kbd:find] [kbd:mute] [kbd:volumeup] [kbd:volumedown]

- [kbd:ro] [kbd:katakanahiragana] [kbd:yen] [kbd:henkan] [kbd:muhenkan] [kbd:kpjpcomma] [kbd:hangeul] [kbd:hanja] [kbd:katakana] [kbd:hiragana] [kbd:zenkakuhankaku]

- [kbd:playpause] [kbd:play] [kbd:pause] [kbd:stop] [kbd:previous] [kbd:next] [kbd:eject] [kbd:volumeup] [kbd:volumedown] [kbd:mute] [kbd:www] [kbd:back] [kbd:forward] [kbd:stop2] [kbd:find] [kbd:scrollup] [kbd:scrolldown] [kbd:edit] [kbd:sleep] [kbd:coffee] [kbd:refresh] [kbd:calc]

DEPRECATED

There’s also a deprecated way to send simple key presses, by passing a keyCode as its argument, which represents the key that you want to tap. The available keyCodes are listed below:

-

-

KBD_UP

-

KBD_DOWN

-

KBD_LEFT

-

KBD_RIGHT

-

KBD_PAGE_UP

-

KBD_PAGE_DOWN

-

KBD_HOME

-

KBD_END

-

-

KBD_BACKSPACE

-

KBD_TAB

-

KBD_RETURN

-

KBD_ESC

-

KBD_INSERT

-

KBD_PRTSC

-

KBD_DELETE

-

KBD_CAPS_LOCK

-

-

KBD_F1

-

KBD_F2

-

KBD_F3

-

KBD_F4

-

KBD_F5

-

KBD_F6

-

KBD_F7

-

KBD_F8

-

KBD_F9

-

KBD_F10

-

KBD_F11

-

KBD_F12

For example, if you want to tap the “Enter” key, you can use the following code:

```javascript
keyboard.tap(KBD_RETURN);
```

Also, multiple keys can be listed:

```javascript
keyboard.tap(KBD_UP, KBD_END);
```

## Media Key Tap

The `media.tap()` function allows you to send media commands to the target device. The function takes a mediaKeyCode as its argument, which represents the media command that you want to send. The available mediaKeyCodes are listed below:

-

-

MEDIA_PLAY_PAUSE

-

MEDIA_NEXT_TRACK

-

MEDIA_PREVIOUS_TRACK

-

MEDIA_STOP

-

-

MEDIA_VOLUME_UP

-

MEDIA_VOLUME_DOWN

-

MEDIA_MUTE

For example, if you want to play or pause media playback on the target device, you can use the following code:

```javascript
media.tap(MEDIA_PLAY_PAUSE);
```

## Keyboard Send

The `keyboard.send()` command serves as the foundation for all other keyboard-related functions. For instance, the Custom Keyboard built-in application utilizes this command to transmit key presses. This allows users to configure the function and media keys in the settings (as strings).

When you pass a simple string, it will act as `keyboard.type()`. You can use keywords, it will act as a keyboard tap or media key tap.

There are two special keywords, their behaviour can be configure in the settings:

-

-

#SEPARATOR

-

-

#SUBMIT (usually an ENTER)

And the available keywords are:

-

-

#UP

-

#DOWN

-

#LEFT

-

#RIGHT

-

#PAGE_UP

-

#PAGE_DOWN

-

#HOME

-

#END

-

#BACKSPACE /
#DEL /
#DELETE

-

#TAB

-

#ENTER /
#RETURN

-

#INS /
#INSERT

-

#PRTSC

-

#CAPS_LOCK

-

-

#F1

-

#F2

-

#F3

-

#F4

-

#F5

-

#F6

-

#F7

-

#F8

-

#F9

-

#F10

-

#F11

-

#F12

-

-

#PLAY /
#PAUSE /
#PLAY_PAUSE

-

#NEXT

-

#PREV /
#PREVIOUS

-

#STOP

-

#MUTE

-

#VOL_UP /
#VOLUME_UP

-

#VOL_DOWN /
#VOLUME_DOWN

For example:

```javascript
keyboard.send('Hello', '#SEPARATOR', 'World', '#ENTER', '#PLAY');
```

## Note

It’s important to note that not all devices support all keyCodes and mediaKeyCodes. Also, some devices may have additional keyCodes or mediaKeyCodes not listed here.

## Conclusion

MagiScript provides a simple and convenient way to turn a compatible device into a Bluetooth keyboard and send keystrokes or media commands to a target device. With the available functions, developers can create various applications that require keyboard or media input.