<?php

class WOL {
	public function __construct($ip = '', $mac = '', $protocol = AF_INET)
	{
		$this->wake($ip, $mac, $protocol);
	}

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

	private function convertMacAddress($mac)
	{
		return implode('', array_map(function ($part) {
			return chr(hexdec($part));
		}, preg_split('/[:\-]/', $mac)));
	}

	private function generateMagicPacket()
	{
		return str_repeat(chr(255), 6);
	}
}
