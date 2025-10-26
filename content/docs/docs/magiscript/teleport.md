---
title: Teleport
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Teleport

## About Teleport Support

The Teleport support of Atom remote in MagiScript allows developers to connect your Teleport to Atom. You can:

- reveal a poker card

- reveal time with a hand-drawn clock

- reveal time with a Pocket Watch photo

```javascript

```

## Connecting To Your Teleport

To connect Atom to a Teleport, you need to use the `teleport.connect` method.

If Atom is not yet connected to a Teleport device, it will start searching for it and then connect. If a Teleport device is already connected, but the specified name is different, Atom will disconnect from the Teleport device, and start searching for the specified name.

You can use the `*` character to connect to any available Teleport device.

The method is flexible regarding its parameters. Let’s review the possible options.

```javascript

```

## Connecting without a Device Name

This is the recommended way to connect, as this way you can share your code and no change will be necessary.

```javascript
teleport.connect();
```

You can configure a default Teleport device ID in the Atom Editor Settings. By default, it is *, which means it will connect to the first Teleport device it finds.

## Connecting by Specifying a Device Name

You can pass a Teleport device ID as the first parameter, and Atom will connect to it. For example, to connect to a Teleport with the ID “Teleport-166666”, you would use the following command:

```javascript
teleport.connect('Teleport-166666');
```

This is the legacy way, we recommend using it only if you have a specific use case.

## Connecting by Specifying a Device Name and a Callback

As a second parameter, you can specify a callback function. It will be called when Atom successfully connects to the Teleport device. It will be called immediately if Atom is already connected to a Teleport.

```javascript
teleport.connect('Teleport-166666', connected);

function connected(event) {
console.log('Teleport connected.');
}
```

When a Teleport is connected, then an event will be triggered. Both the onEvent function, and the callback will be called with the event details.

```javascript
teleport.connect('Teleport-166666', connected);

function connected(event) {
console.log('Teleport connected.');
}
```

## Using the teleport.connect Method

```javascript

```

The best way to connect is by adding this call to the beginning of the `main` function, which runs when the code is loaded.

```javascript
function main() {
teleport.connect();
// ...
}
```

## Disconnecting your Teleport

To disconnect your Teleport, simply call the disconnect method. It will disconnect the active Teleport device.

```javascript
teleport.disconnect();
```

You can also specify by it’s name which device you would like to disconnect:

```javascript
teleport.disconnect('Teleport-036666');
```

## Querying the Connected Teleport

You can query the Bluetooth name (ID) of the Teleport device(s) Atom connected to. The id method gives you the active device’s ID, while the ids method returns an array with the Teleport devices Atom connected to.

```javascript
teleport.id(); // the active Teleport device
teleport.ids(); // all the Teleport devices Atom connected to
```

You can query the connected Teleport devices as a list of device objects as well using the list method.

```javascript
const devs = teleport.list();
for (let i = 0; i
```

If more than one Teleport device is connected, you can set one of them to active with the select method. Messages will be sent to this unit.

```javascript
teleport.select('Teleport-036666');
```