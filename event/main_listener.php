<?php
/**
 *
 * @package       phpBB Extension - TencentCOS
 * @copyright (c) 2017 Austin Maddox
 * @copyright (c) 2018 ZWYang
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace AustinMaddox\tencentcos\event;

use Qcloud\Cos\Client;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class main_listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var $phpbb_root_path */
	protected $phpbb_root_path;

	/** @var TencentCOSClient */
	protected $tencentcos_client;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config     $config   Config object
	 * @param \phpbb\template\template $template Template object
	 * @param \phpbb\user              $user     User object
	 * @param                          $phpbb_root_path
	 *
	 * @access public
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\template\template $template, \phpbb\user $user, $phpbb_root_path)
	{
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;
		$this->phpbb_root_path = $phpbb_root_path;

		if ($this->config['tencentcos_is_enabled'])
		{
			// Instantiate an TencentCOS client.
			$this->tencentcos_client = new  Client([
				'credentials' => [
					'secretId'    => $this->config['tencentcos_aws_access_key_id'],
					'secretKey' => $this->config['tencentcos_aws_secret_access_key'],
				],
				'region'      => $this->config['tencentcos_region'],
			]);
		}
	}

	static public function getSubscribedEvents()
	{
		return [
			'core.user_setup'                               => 'user_setup',
			'core.modify_uploaded_file'                     => 'modify_uploaded_file',
			'core.delete_attachments_from_filesystem_after' => 'delete_attachments_from_filesystem_after',
			'core.parse_attachments_modify_template_data'   => 'parse_attachments_modify_template_data',
		];
	}

	public function user_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'AustinMaddox/tencentcos',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * Event to modify uploaded file before submit to the post
	 *
	 * @param $event
	 */
	public function modify_uploaded_file($event)
	{
		if ($this->config['tencentcos_is_enabled'])
		{
			$filedata = $event['filedata'];
                        // Fullsize
                        $key = $filedata['physical_filename'];
                        $body = file_get_contents($this->phpbb_root_path . $this->config['upload_path'] . '/' . $key);
                        $uploadFileName = utf8_basename($filedata['real_filename']);
                        $this->uploadFileToTencentCOS($key ."_". $uploadFileName, $body, $filedata['mimetype'], $uploadFileName );
		}
	}

	/**
	 * Perform additional actions after attachment(s) deletion from the filesystem
	 *
	 * @param $event
	 */
	public function delete_attachments_from_filesystem_after($event)
	{
		if ($this->config['tencentcos_is_enabled'])
		{
			 foreach ($event['physical'] as $physical_file)
                        {
                                $uploadFileName = utf8_basename($physical_file['real_filename']);
                                $this->tencentcos_client->deleteObject([
                                        'Bucket' => $this->config['tencentcos_bucket'],
                                        'Key'    => $physical_file['filename'] ."_". $uploadFileName,
                                ]);
                                //only the image have the thumbnail, but you can try to delete anyway.
                                $this->tencentcos_client->deleteObject([
                                        'Bucket' => $this->config['tencentcos_bucket'],
                                        'Key'    => 'thumb_' . $physical_file['filename'] ."_". $uploadFileName,
                                ]);
                        }
		}
	}

	/**
	 * Use this event to modify the attachment template data.
	 *
	 * This event is triggered once per attachment.
	 *
	 * @param $event
	 */
	public function parse_attachments_modify_template_data($event)
	{
		if ($this->config['tencentcos_is_enabled'])
		{
			$block_array = $event['block_array'];
                        $attachment = $event['attachment'];
			
                        $uploadFileName = utf8_basename($attachment['real_filename']);
                        $key = 'thumb_' . $attachment['physical_filename'];
                        
			$tencentcos_link_thumb = '//' . $this->config['tencentcos_bucket'] . '.cos.ap-chengdu.myqcloud.com/' . $key ."_". $uploadFileName;
                        $tencentcos_link_fullsize = '//' . $this->config['tencentcos_bucket'] . '.cos.ap-chengdu.myqcloud.com/' . $attachment['physical_filename'] ."_". $uploadFileName;
                        $local_thumbnail = $this->phpbb_root_path . $this->config['upload_path'] . '/' . $key;
                        if ($this->config['img_create_thumbnail'])
                        {
                                // Existence on local filesystem check. Just in case "Create thumbnail" was turned off at some point in the past and thumbnails weren't generated.
                                if (file_exists($local_thumbnail))
                                {
                                        // Existence on TencentCOS check. Since this method runs on every page load, we don't want to upload the thumbnail multiple times.
                                        try{
                                                $this->tencentcos_client->headObject(['Bucket' => $this->config['tencentcos_bucket'], 'Key' => $key ."_". $uploadFileName]);
                                                //File has been here, nothing to do
                                        } catch (\Exception $e) {
                                                //No such file , Upload the thumbnail to TencentCOS.
                                                $body = file_get_contents($local_thumbnail);
                                                $this->uploadFileToTencentCOS($key ."_". $uploadFileName, $body, $attachment['mimetype'], 'thumbnail_' . $uploadFileName);
                                        }
                                }
                                $block_array['THUMB_IMAGE'] = $tencentcos_link_thumb;
                                $block_array['U_DOWNLOAD_LINK'] = $tencentcos_link_fullsize;
                        }
                        $block_array['U_INLINE_LINK'] = $tencentcos_link_fullsize;
                        $event['block_array'] = $block_array;
		}
	}

	/**
	 * Upload the attachment to the TencentCOS bucket.
	 *
	 * @param $key
	 * @param $body
	 * @param $content_type
	 */
	private function uploadFileToTencentCOS($key, $body, $content_type, $uploadFile_UploadName)
	{
		$this->tencentcos_client->putObject(['Bucket' => $this->config['tencentcos_bucket'], 'Key' => $key,'Body' => $body, 'ACL' => 'public-read', 'ContentType' => $content_type, 'ContentDisposition' => $uploadFile_UploadName] );
	}
}
