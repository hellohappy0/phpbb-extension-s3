<?php
/**
 *
 * @package       phpBB Extension - TencentCOS
 * @copyright (c) 2018 ZWYang
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
        'YES'           => '是',
        'NO'            => '否',

	'ACP_TencentCOS'               => '设置',
	'ACP_TencentCOS_SETTING_SAVED' => '设置已保存！',

	'ACP_TencentCOS_ACCESS_KEYS_EXPLAIN' => '为了能使用腾讯的php CDK，你需要输入有效的
	<strong>secretId</strong>。想要知道更多请访问 <a href="https://cloud.tencent.com/product/cos/document"
		   target="_blank">腾讯的帮助文档</a> 。',

	'ACP_TencentCOS_ACCESS_KEY_ID'         => '腾讯COS的secretId',
	'ACP_TencentCOS_ACCESS_KEY_ID_EXPLAIN' => '举例: <samp>AKIAIOSqdf658FOd5D3N5qN7EwdXrewAMPLE</samp>.',
	'ACP_TencentCOS_ACCESS_KEY_ID_INVALID' => '“%s” 是非有效secretId。它必须是大小写字母加数字，刚好36位<br>也就是它满足正则表达式： <code>/[A-Za-z0-9]{36})/</code>',

	'ACP_TencentCOS_SECRET_ACCESS_KEY'         => '腾讯COS的secretKey',
	'ACP_TencentCOS_SECRET_ACCESS_KEY_EXPLAIN' => '举例: <samp>vp88f3reGm29my0BPjyEWo5Qiv48dOSS</samp>.',
	'ACP_TencentCOS_SECRET_ACCESS_KEY_INVALID' => '“%s” 是非有效secretKey。它必须是大小写字母加数字，刚好32位。<br>也就是它满足正则表达式：<code>/[A-Za-z0-9]{32}/</code>',

	'ACP_TencentCOS_REGION'         => '腾讯COS存储桶所在地区',
	'ACP_TencentCOS_REGION_EXPLAIN' => '举例: <samp>ap-chengdu</samp>',
	'ACP_TencentCOS_REGION_INVALID' => '存储桶的地区是创建存储桶时候确定的，想知道更多请访问 <a href="https://cloud.tencent.com/product/cos/document"
                   target="_blank">腾讯的帮助文档</a> 。',

	'ACP_TencentCOS_BUCKET'         => '腾讯COS的 Bucket',
	'ACP_TencentCOS_BUCKET_EXPLAIN' => '举例: <samp>example-1266014408</samp>.请填写已经存在的存储桶',
	'ACP_TencentCOS_BUCKET_INVALID' => '想知道更多请访问 <a href="https://cloud.tencent.com/product/cos/document"
                   target="_blank">腾讯的帮助文档</a> 。',

        'ACP_TencentCOS_UPLOAD_FILE'            => '自动上传附件',
        'ACP_TencentCOS_UPLOAD_FILE_EXPLAIN'    => '每当你访问到网站的时候，将会自动上传你这个网页中所有的附件（附件只包括files文件夹里面的）到存储桶。建议当你保证所有附件都上传了以后，关掉这个选项以加快你网页的访问速度。这个选项为了帮助你上传你的旧文件到存储桶。',

        'ACP_TencentCOS_UPLOAD_THUMBNAIL'            => '自动上传缩略图',
        'ACP_TencentCOS_UPLOAD_THUMBNAIL_EXPLAIN'    => '每当你访问到网站的时候，将会自动上传你这个网页中所有的缩略图（只包括files文件夹里面的）到存储桶。如果你的网站设置中设置了生成缩略图，你需要开启这个选项，以帮助你把新的缩略图上传到存储桶。',

	'ACP_TencentCOS_IS_ENABLED'         => '插件是否启动',
	'ACP_TencentCOS_IS_ENABLED_EXPLAIN' => '插件启动以后，文件会在原来的服务器上面保存一份（也就是原来的工作方式不变），同时，所有上传的文件上传到腾讯COS，并将帖子内的链接改为存储桶的链接。倘若你不是一开建站时候就开启这个插件，你需要将你根目录下的file文件夹（也就是你的文件存储位置）下面的文件全部拷贝到腾讯的对应存储桶里面。否则，你在访问文件或者图片时候可能会报错（不是致命错误，但是你以前的文件都访问不了，除非你停掉扩展，才能访问以前的文件。）',
]);
