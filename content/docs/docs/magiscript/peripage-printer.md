---
title: PeriPage Printer
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# PeriPage Printer

## About PeriPage Printer Support

The PeriPage Printer support of Atom remote in MagiScript allows developers to connect your PeriPage Printer to Atom, and control the printer using commands. You can:

- print text

- print a hand-drawn clock

- feed the paper

```javascript

```

## Connecting To Your PeriPage Printer

To connect Atom to a PeriPage Printer, you need to use the `peripage.connect` method.

If Atom is not yet connected to a PeriPage Printer device, it will start searching for it and then connect. If a PeriPage Printer device is already connected, but the specified name is different, Atom will disconnect from the PeriPage Printer device, and start searching for the specified name.

You can use the `*` character to connect to any available PeriPage Printer device.

The method is flexible regarding its parameters. Let’s review the possible options.

```javascript

```

## Connecting without a Device Name

This is the recommended way to connect, as this way you can share your code and no change will be necessary.

```javascript
peripage.connect();
```

You can configure a default PeriPage Printer device ID in the Atom Editor Settings. By default, it is *, which means it will connect to the first PeriPage Printer device it finds.

## Connecting by Specifying a Device Name

You can pass a PeriPage Printer device ID as the first parameter, and Atom will connect to it. For example, to connect to a PeriPage Printer with the ID “PeriPage-166666”, you would use the following command:

```javascript
peripage.connect('PeriPage-166666');
```

This is the legacy way, we recommend using it only if you have a specific use case.

## Connecting by Specifying a Device Name and a Callback

As a second parameter, you can specify a callback function. It will be called when Atom successfully connects to the PeriPage Printer device. It will be called immediately if Atom is already connected to a PeriPage Printer.

```javascript
peripage.connect('PeriPage-166666', connected);

function connected(event) {
console.log('PeriPage connected.');
}
```

When a PeriPage Printer is connected, then an event will be triggered. Both the onEvent function, and the callback will be called with the event details.

```javascript
peripage.connect('PeriPage-166666', connected);

function connected(event) {
console.log('PeriPage connected.');
}
```

## Using the peripage.connect Method

```javascript

```

The best way to connect is by adding this call to the beginning of the `main` function, which runs when the code is loaded.

```javascript
function main() {
peripage.connect();
// ...
}
```

## Disconnecting your PeriPage Printer

To disconnect your PeriPage Printer, simply call the disconnect method. It will disconnect the active PeriPage Printer device.

```javascript
peripage.disconnect();
```

You can also specify by it’s name which device you would like to disconnect:

```javascript
peripage.disconnect('PeriPage-036666');
```

## Querying the Connected PeriPage Printer

You can query the Bluetooth name (ID) of the PeriPage Printer device(s) Atom connected to. The id method gives you the active device’s ID, while the ids method returns an array with the SPeriPage Printer devices Atom connected to.

```javascript
peripage.id(); // the active PeriPage Printer device
peripage.ids(); // all the PeriPage Printer devices Atom connected to
```

You can query the connected PeriPage Printer devices as a list of device objects as well using the list method.

```javascript
const devs = peripage.list();
for (let i = 0; i
```

If more than one PeriPage Printer device is connected, you can set one of them to active with the select method. Messages will be sent to this unit.

```javascript
peripage.select('PeriPage-036666');
```

## Setting to Print a Hand-Drawn Clock

You can use the peripage.printClock() command to print a hand-drawn clock with the PeriPage Printer. There are many ways to use it, see below:

```javascript
peripage.printClock(9); // prints 9:00
peripage.printCLock(23); // prints 23:00
peripage.printClock(42); // prints 4:02
peripage.printClock(930); // prints 9:30
peripage.printClock('9'); // prints 9:00
peripage.printClock('23'); // prints 23:00
peripage.printClock('42'); // prints 4:02
peripage.printClock('930'); // prints 9:30
peripage.printClock(9, 10); // prints 9:10
peripage.printClock('7:12'); // prints 7:12
```

## Printing Text

```javascript

```

You can print text using the `peripage.print` method. 
For example, if you want to print the text “Hello World”, you can use the following code:

```javascript
peripage.print('Hello World');
```

## PeriPage Paper Feed

The peripage.feed() method advances the thermal printer’s paper by the specified number of lines. This helps ensure the paper is out of the printer.

```javascript
peripage.feed(10); // feed the paper by 10 lines
```