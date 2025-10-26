---
title: Cosmos Printer
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Cosmos Printer

## About Cosmos Printer Support

The [Cosmos Printer](https://electricks.info/product/cosmos-physical-prediction/) support of Atom remote in MagiScript allows developers to connect your Cosmos Printer to Atom, and control the printer using commands. You can:

- print text

- print a hand-drawn clock

- feed the paper

```javascript

```

## Connecting To Your Cosmos Printer

To connect Atom to a Cosmos Printer, you need to use the `cosmos.connect` method.

If Atom is not yet connected to a Cosmos Printer device, it will start searching for it and then connect. If a Cosmos Printer device is already connected, but the specified name is different, Atom will disconnect from the Cosmos Printer device, and start searching for the specified name.

You can use the `*` character to connect to any available Cosmos Printer device.

The method is flexible regarding its parameters. Let’s review the possible options.

```javascript

```

## Connecting without a Device Name

This is the recommended way to connect, as this way you can share your code and no change will be necessary.

```javascript
cosmos.connect();
```

You can configure a default Cosmos Printer device ID in the Atom Editor Settings. By default, it is *, which means it will connect to the first Cosmos Printer device it finds.

## Connecting by Specifying a Device Name

You can pass a Cosmos Printer device ID as the first parameter, and Atom will connect to it. For example, to connect to a Cosmos Printer with the ID “Cosmos-166666”, you would use the following command:

```javascript
cosmos.connect('Cosmos-166666');
```

This is the legacy way, we recommend using it only if you have a specific use case.

## Connecting by Specifying a Device Name and a Callback

As a second parameter, you can specify a callback function. It will be called when Atom successfully connects to the Cosmos Printer device. It will be called immediately if Atom is already connected to a Cosmos Printer.

```javascript
cosmos.connect('Cosmos-166666', connected);

function connected(event) {
console.log('Cosmos connected.');
}
```

When a Cosmos Printer is connected, then an event will be triggered. Both the onEvent function, and the callback will be called with the event details.

```javascript
cosmos.connect('Cosmos-166666', connected);

function connected(event) {
console.log('Cosmos connected.');
}
```

## Using the cosmos.connect Method

```javascript

```

The best way to connect is by adding this call to the beginning of the `main` function, which runs when the code is loaded.

```javascript
function main() {
cosmos.connect();
// ...
}
```

## Disconnecting your Cosmos Printer

To disconnect your Cosmos Printer, simply call the disconnect method. It will disconnect the active Cosmos Printer device.

```javascript
cosmos.disconnect();
```

You can also specify by it’s name which device you would like to disconnect:

```javascript
cosmos.disconnect('Cosmos-036666');
```

## Querying the Connected Cosmos Printer

You can query the Bluetooth name (ID) of the Cosmos Printer device(s) Atom connected to. The id method gives you the active device’s ID, while the ids method returns an array with the Cosmos Printer devices Atom connected to.

```javascript
cosmos.id(); // the active Cosmos Printer device
cosmos.ids(); // all the Cosmos Printer devices Atom connected to
```

You can query the connected Cosmos Printer devices as a list of device objects as well using the list method.

```javascript
const devs = cosmos.list();
for (let i = 0; i
```

If more than one Cosmos Printer device is connected, you can set one of them to active with the select method. Messages will be sent to this unit.

```javascript
cosmos.select('Cosmos-036666');
```

## Setting to Print a Hand-Drawn Clock

You can use the cosmos.printClock() command to print a hand-drawn clock with the Cosmos Printer. There are many ways to use it, see below:

```javascript
cosmos.printClock(9); // prints 9:00
cosmos.printCLock(23); // prints 23:00
cosmos.printClock(42); // prints 4:02
cosmos.printClock(930); // prints 9:30
cosmos.printClock('9'); // prints 9:00
cosmos.printClock('23'); // prints 23:00
cosmos.printClock('42'); // prints 4:02
cosmos.printClock('930'); // prints 9:30
cosmos.printClock(9, 10); // prints 9:10
cosmos.printClock('7:12'); // prints 7:12
```

## Printing Text

```javascript

```

You can print text using the `cosmos.print` method. 
For example, if you want to print the text “Hello World”, you can use the following code:

```javascript
cosmos.print('Hello World');
```

## Feeding the Paper

The cosmos.feed() method advances the thermal printer’s paper by the specified number of lines. This helps ensure the paper is out of the printer.

```javascript
cosmos.feed(10); // feed the paper by 10 lines
```