<?php

/**
 * Class for handling WOL requests
 */
class Wol
{
	/**
	 * Default constructor for Wol. If IP and MAC addresses are specified
	 * it will call the Wol::wake()
	 * @param string $ip The broadcast IP address to use
	 * @param string $mac The MAC address of the device to wake
	 * @param int $protocol The type of IP to use. Deafult AF_INET
	 */
	public function __construct($ip = '', $mac = '', $protocol = AF_INET)
	{
		if (!empty($ip) && !empty($mac)) {
			$this->wake($ip, $mac, $protocol);
		}
	}
	/**
	 * Sends a magic packet to the specified IP/MAC address using the specified
	 * address protocol.
	 * @param string $ip The broadcast IP address to use
	 * @param string $mac The MAC address of the device to wake
	 * @param int $protocol The type of IP to use. Deafult AF_INET
	 * @return int|bool The result of sending the packet
	 */
	public static function wake($ip, $mac, $protocol = AF_INET)
	{
		if (empty($ip) || empty($mac)) {
			throw new \Exception('Broadcast IP address and MAC address required.');
		}
		if (!in_array($protocol, array(
				AF_INET,
				AF_INET6,
				AF_UNIX
			))) {
			throw new \Exception('Invalid protocol.');
		}
		$socket = socket_create($protocol, SOCK_DGRAM, SOL_UDP);
		if ($socket && is_resource($socket)) {
			if (!socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array(
				'sec' => $timeout, 'usec' => 0))) {
				throw new \Exception('Unable to set options on socket: ' . 
					socket_strerror(socket_last_error()) . PHP_EOL);
			}
			$packet = SELF::generateMagicPacket();
			$result = socket_sendto($socket, $packet, strlen($packet), 0, $ip, 7);
			socket_close($socket);
			return $result;
		} else {
			throw new \Exception('Connection failed: ' . 
				socket_strerror(socket_last_error()) . PHP_EOL);
		}
	}
	/**
	 * Converts the specified MAC address into a character representation
	 * by converted each octet into decimal and appending the resulting
	 * character to the string
	 * @param string $mac The MAC address to convert
	 * @return string The converted MAC address
	 */
	private function convertMacAddress($mac)
	{
		return implode('', array_map(function ($part) {
			return chr(hexdec($part));
		}, preg_split('/[:\-]/', $mac)));
	}
	/**
	 * Generates a magic packet (6 * FF) to be used in WOL request
	 * @return string The contents of the mahic packet to send
	 */
	private function generateMagicPacket()
	{
		return str_repeat(chr(255), 6);
	}
}
