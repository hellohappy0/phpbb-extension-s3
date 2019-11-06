<?php
/**
 *
 * @package       phpBB Extension - TencentCOS
 * @copyright (c) 2017 Austin Maddox
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
        'YES'		=> 'yes',
        'NO'		=> 'no',

	'ACP_TencentCOS'               => 'Settings',
	'ACP_TencentCOS_SETTING_SAVED' => 'Settings have been saved successfully!',

	'ACP_TencentCOS_ACCESS_KEYS_EXPLAIN' => 'To successfully send requests to Tencent APIs, you need to have a valid set of security credentials called
	<strong>access keys</strong>. To learn more about Tencent access keys, visit the <a href="https://cloud.tencent.com/product/cos/document"
		   target="_blank">developer documentation</a> .',

	'ACP_TencentCOS_ACCESS_KEY_ID'         => 'Tencent Access Key Id',
	'ACP_TencentCOS_ACCESS_KEY_ID_EXPLAIN' => 'Enter your Tencent Access Key Id for TencentCOS, e.g.: <samp>AKIAIOSqdf658FOd5D3N5qN7EwdXrewAMPLE</samp>.',
	'ACP_TencentCOS_ACCESS_KEY_ID_INVALID' => '“%s” is not a valid Tencent Access Key Id. It must be a combination of letters and/or numbers and exactly 36 characters.<br>Specifically, it must match the regular expression <code>/[A-Za-z0-9]{36})/</code>',

	'ACP_TencentCOS_SECRET_ACCESS_KEY'         => 'Tencent Secret Access Key',
	'ACP_TencentCOS_SECRET_ACCESS_KEY_EXPLAIN' => 'Enter your Tencent Secret Access Key for TencentCOS, e.g.: <samp>vp88f3reGm29my0BPjyEWo5Qiv48dOSS</samp>.',
	'ACP_TencentCOS_SECRET_ACCESS_KEY_INVALID' => '“%s” is not a valid Tencent Secret Access Key. It must be a combination of letters and/or numbers, and exactly 32 characters.<br>Specifically, it must match the regular expression <code>/[A-Za-z0-9]{32}/</code>',

	'ACP_TencentCOS_REGION'         => 'TencentCOS Region',
	'ACP_TencentCOS_REGION_EXPLAIN' => 'Enter the TencentCOS region where your bucket resides, e.g.: <samp>ap-chengdu</samp>.',
	'ACP_TencentCOS_REGION_INVALID' => 'You must enter a valid TencentCOS region. To learn more about Tencent access keys, visit the <a href="https://cloud.tencent.com/product/cos/document" target="_blank">developer documentation</a> .',

	'ACP_TencentCOS_BUCKET'         => 'TencentCOS Bucket',
	'ACP_TencentCOS_BUCKET_EXPLAIN' => 'Enter the name of your TencentCOS bucket, e.g.: <samp>example-1258617708</samp>. The bucket must already be created in your Tencent account.',
	'ACP_TencentCOS_BUCKET_INVALID' => 'You must enter a valid TencentCOS bucket. To learn more about Tencent access keys, visit the <a href="https://cloud.tencent.com/product/cos/document" target="_blank">developer documentation</a> .',

        'ACP_TencentCOS_UPLOAD_FILE'         	=> 'Auto Upload File',
        'ACP_TencentCOS_UPLOAD_FILE_EXPLAIN' 	=> 'Every time you visit the website, all the attachments in your webpage (the attachments only include those in the "files" folder) will be uploaded to the bucket automatically. It is recommended to turn off this option to speed up your page access when you have made sure that all attachments have been uploaded. This option is used to help you upload your old files to the bucket.',

        'ACP_TencentCOS_UPLOAD_THUMBNAIL'            => 'Auto Upload Thumbnail',
        'ACP_TencentCOS_UPLOAD_THUMBNAIL_EXPLAIN'    => 'Every time you visit the website, all thumbnails (only those in the "files" folder) in your webpage will be uploaded to the bucket automatically. If thumbnail generation is set in your website settings, you need to turn on this option to help you upload new thumbnails to the bucket.',

	'ACP_TencentCOS_IS_ENABLED'         => 'Is the extension enabled?',
	'ACP_TencentCOS_IS_ENABLED_EXPLAIN' => 'Displays whether or not the extension is enabled and will use TencentCOS for uploading and delivering your attachments.If you did not have this extension installed when you started using phpbb, before you use this extension, you need to copy all the contents of the file folder under the root path of phpbb(That is, the path where the files you downloaded are stored) into the bucket. If you do not do this, you may be prompted for errors when accessing attachments or pictures. This error reporting is not fatal, but you will not be able to access the previous files unless you stop the extension.',
]);
