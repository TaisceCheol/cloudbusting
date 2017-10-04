<?php

namespace Craft;

class CloudbustingService extends BaseApplicationComponent
{
	protected $apiKey;
	protected $zone;
	protected $email;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$settings = craft()->plugins->getPlugin('Cloudbusting')->getSettings();

		$this->apiKey = $settings->apiKey;
		$this->zone = $settings->zone;
		$this->email = $settings->email;
	}


	public function purgeCache($page_url)
	{
		$files = $this->_formatFilesBlob($page_url);
		$cloudflare_url = "https://api.cloudflare.com/client/v4/zones/".$this->zone."/purge_cache";
		$headers = $this->_getHeaders();

		try {
			$client = new \Guzzle\Http\Client();
        	$request = $client->delete($cloudflare_url,$headers,$files);  
            CloudbustingPlugin::log("Request sent\n".$request,LogLevel::Warning);

        	$response = $request->send();

            CloudbustingPlugin::log("Entry purged\n".$response,LogLevel::Warning);

			return $response;
		} catch(\Exception $e) {
            CloudbustingPlugin::log("Entry purge failed with Status Code:".$e->getResponse()->getStatusCode()."\n\n".$e->getResponse(),LogLevel::Error);
			return;
		}
	}

	private function _formatFilesBlob($page_url)
	{
		$parsed_url = parse_url($page_url);
		if (array_key_exists('path',$parsed_url) == 1) {
			$split_path = explode('/',trim($parsed_url['path'],'/'));
			$host = $parsed['scheme'].'://'.$parsed['host'];
			$bubbled_url = array(count($split_path));
			for ($i = 0; $i < count($path); $i++) {
				array_push($bubbled_url,$host.'/'.join('/',array_slice($split_path,0,$i+1)));
			}
			$files = array('files' => $bubbled_url);
		} else {
			$files = array('files' => array($page_url));			
		}
		return json_encode($files);
	}

	private function _getHeaders()
	{
        $headers = array(
            'Content-Type' => 'application/json',
            'X-Auth-Email' => $this->email,
            'X-Auth-Key' => $this->apiKey
        );
		return $headers;
	}	
}