---
title: Spotted Dice
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Spotted Dice

## About Spotted Dice

The Spotted Dice support of Atom remote in MagiScript allows developers to connect your Spotted Dice to Atom, and control the Dice using commands.

```javascript

```

## Connecting To Your Spotted Dice

To connect Atom to a Spotted Dice, you need to use the `spotted.connect` method.

If Atom is not yet connected to a Spotted Dice device, it will start searching for it and then connect. If a Spotted Dice device is already connected, but the specified name is different, Atom will disconnect from the Spotted Dice device, and start searching for the specified name.

You can use the `*` character to connect to any available Spotted Dice device.

The method is flexible regarding its parameters. Let’s review the possible options.

```javascript

```

## Connecting without a Device Name

This is the recommended way to connect, as this way you can share your code and no change will be necessary.

```javascript
spotted.connect();
```

You can configure a default Spotted Dice device ID in the Atom Editor Settings. By default, it is *, which means it will connect to the first Spotted Dice device it finds.

## Connecting by Specifying a Device Name

You can pass a Spotted Dice device ID as the first parameter, and Atom will connect to it. For example, to connect to a Spotted Dice with the ID “Spotted-166666”, you would use the following command:

```javascript
spotted.connect('Spotted-166666');
```

This is the legacy way, we recommend using it only if you have a specific use case.

## Connecting by Specifying a Device Name and a Callback

As a second parameter, you can specify a callback function. It will be called when Atom successfully connects to the Spotted Dice device. It will be called immediately if Atom is already connected to a Spotted Dice.

```javascript
spotted.connect('Spotted-166666', connected);

function connected(event) {
console.log('Spotted Dice connected.');
}
```

When a Spotted Dice is connected, then an event will be triggered. Both the onEvent function, and the callback will be called with the event details.

```javascript
spotted.connect('Spotted-166666', connected);

function connected(event) {
console.log('Spotted Dice connected.');
}
```

## Using the spotted.connect Method

```javascript

```

The best way to connect is by adding this call to the beginning of the `main` function, which runs when the code is loaded.

```javascript
function main() {
spotted.connect();
// ...
}
```

## Disconnecting your Spotted Dice

To disconnect your Spotted Dice, simply call the disconnect method. It will disconnect the active Spotted Dice device.

```javascript
spotted.disconnect();
```

You can also specify by it’s name which device you would like to disconnect:

```javascript
spotted.disconnect('Spotted-036666');
```

## Querying the Connected Spotted Dice

You can query the Bluetooth name (ID) of the Spotted Dice device(s) Atom connected to. The id method gives you the active device’s ID, while the ids method returns an array with the Spotted Dice devices Atom connected to.

```javascript
spotted.id(); // the active Spotted Dice device
spotted.ids(); // all the Spotted Dice devices Atom connected to
```

You can query the connected Spotted Dice devices as a list of device objects as well using the list method.

```javascript
const devs = spotted.list();
for (let i = 0; i
```

If more than one Spotted Dice device is connected, you can set one of them to active with the select method. Messages will be sent to this unit.

```javascript
spotted.select('Spotted-036666');
```

## Battery Percentage

```javascript

```

###

The battery level of Spotted Dice can be queried with the battery method. It reports a number between 0 and 100. It is checked when Atom connects to the device, and is subsequently updated every other minute.

```javascript
const percentage = spotted.battery();
console.log(Spotted Dice battery level: ${percentage}%);
```

## Conclusion

```javascript

```

###

The Spotted Dice support of Atom remote in MagiScript provides a convenient way for developers to connect their Spotted Dice to Atom and control its functions. By following the steps outlined in this documentation, you can easily connect to your Spotted Dice and set its time using MagiScript.

## Die Color

```javascript
spotted.color();
```