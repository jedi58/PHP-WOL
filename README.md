# PHP-WOL
A PHP library for sending WOL (Wake-On-LAN) notifications across a network. In order to utilise this the target system must be set-up to accept WOL requests.

> Wake-on-LAN (WoL) is an Ethernet or Token ring computer networking standard that allows a computer to be turned on or awakened by a network message.
-- Wikipedia definition of WOL

## Example usage

```PHP
Wol::wake('192.168.1.2', '6A:70:D0:F0:B0:50');
```
The result of this will return the number of bytes sent to the target if successful, otherwise it will return `FALSE`.


## Errors

### Broadcast IP address and MAC address required.
In order to use WOL it is necessary to provide a broadcast IP address and the MAC address of the machine to wake (or turn on).


### Invalid protocol
Only supported protocols may be used; these are:

| Protocol | Description |
| :------: | :---------- |
| AF_INET | IPv4 Internet based protocols. TCP and UDP are common protocols of this protocol family. |
| AF_INET6 | IPv6 Internet based protocols. TCP and UDP are common protocols of this protocol family. |
| AF_UNIX | Local communication protocol family. High efficiency and low overhead make it a great form of IPC (Interprocess Communication). |

 
### Connection failed
This indicates that the socket could not be created. This could be down to permissions, socket extension not being loaded, etc.


### Unable to set options on socket
Although the socket could be created, this indicates that the settings that are attempting to be applied to the socket are not supported.
