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
		$files = array('files' => array($page_url));
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