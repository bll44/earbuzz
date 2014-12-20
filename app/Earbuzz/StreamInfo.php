<?php

namespace Earbuzz;

class StreamInfo {

	const HOST = 'wowza.straightcash.co',
		  PORT = '8086',
		  USER = 'wowza_earbuzz',
		  PASS = '3v0lve2oo9';

	public $xml;
	public $activeStreams = [];

	public function __construct()
	{
		$this->refreshXML();
	}

	public function refreshXML()
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['ContentType: text/xml']);
		curl_setopt($ch, CURLOPT_URL, 'http://' . self::HOST . ':' . self::PORT . '/connectioncounts');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, self::USER . ':' . self::PASS);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);

		file_put_contents(storage_path() . '/streams/stream_info.xml', $output);
		$this->xml = simplexml_load_file(storage_path() . '/streams/stream_info.xml');

		// set activeStreams property
		$this->setActiveStreams();
	}

	public function applicationActive()
	{
		if(isset($this->xml->VHost->Application))
			return true;
		else
			return false;
	}

	private function setActiveStreams()
	{
		if($this->applicationActive())
		{
			foreach($this->xml->VHost->Application->ApplicationInstance->Stream as $s)
			{
				$this->activeStreams[(string)$s->Name] = $s;
			}
		}
	}

	public function getLiveStreams()
	{
		$this->refreshXML();
		$this->setActiveStreams();
		return $this->activeStreams;
	}

}