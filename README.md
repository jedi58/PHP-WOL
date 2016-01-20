# PHP-WOL
A PHP library for sending WOL (Wake-On-LAN) notifications across a network. In order to utilise this the target system must be set-up to accept WOL requests.

> Wake-on-LAN (WoL) is an Ethernet or Token ring computer networking standard that allows a computer to be turned on or awakened by a network message.
-- Wikipedia definition of WOL

## Example usage

```PHP
WOL::wake('192.168.1.2', '6A:70:D0:F0:B0:50');
```
The result of this will return the number of bytes sent to the target if successful, otherwise it will return `FALSE`.
