<?php
/**
 *
 * @package       phpBB Extension - TencentCOS
 * @copyright (c) 2017 Austin Maddox
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace AustinMaddox\tencentcos\acp;

class main_info
{
	function module()
	{
		return [
			'filename' => '\AustinMaddox\tencentcos\acp\main_module',
			'title'    => 'ACP_TencentCOS_TITLE',
			'version'  => '1.0.6',
			'modes'    => [
				'settings' => [
					'title' => 'ACP_TencentCOS',
					'auth'  => 'ext_AustinMaddox/tencentcos && acl_a_board',
					'cat'   => ['ACP_TencentCOS_TITLE'],
				],
			],
		];
	}
}
